<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 10/07/2017
 * Time: 07:00 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;


use Carbon\Carbon;
use Ghi\Core\Models\Material;
use Ghi\Domain\Core\Contracts\Contabilidad\NotificacionRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\CuentaEmpresa;

use Ghi\Domain\Core\Models\Contabilidad\Notificacion;
use Ghi\Domain\Core\Models\Contabilidad\NotificacionPoliza;
use Ghi\Domain\Core\Models\Contabilidad\Poliza;
use Ghi\Domain\Core\Models\Obra;
use Ghi\Domain\Core\Models\Seguridad\Proyecto;
use Ghi\Domain\Core\Models\User;
use Ghi\Domain\Core\Models\UsuarioCadeco;
use Ghi\Events\NewEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class EloquentNotificacionRepository implements NotificacionRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\Notificacion
     */
    private $model;

    /**
     * @var Repository
     */
    private $config;

    /**
     * @var PolizaRepository
     */
    private $poliza;


    private $usuario;

    /**
     * EloquentNotificacionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Notificacion $model
     */
    public function __construct(Notificacion $model, Repository $config, PolizaRepository $poliza)
    {
        $this->model = $model;
        $this->config = $config;
        $this->poliza = $poliza;
    }

    /**
     * Obtiene todas las Notificaciones
     *
     * @return \Illuminate\Database\Eloquent\Collection|CuentaEmpresa
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $id
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Guarda una notificacion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Notificacion
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $item = $this->model->create($data);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $item;
    }

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }


    /**
     * Actualiza una notificacion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Notificacion
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            $notificacion = $this->model->find($id);
            $notificacion->update($data);
        } catch (\Exception $e) {
            throw $e;
        }
        return $notificacion;
    }

    /**
     * Obtiene un scope sobre el modelo
     * @param string $scope
     * @return mixed
     */

    public function scope($scope)
    {
        $this->model = $this->model->$scope();
        return $this;
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    public function send()
    {
        try {
            $basesDatos = Proyecto::get();

            foreach ($basesDatos as $bd) {
                $this->config->set('database.connections.cadeco.database', $bd->base_datos);
                $obras = Obra::all();


                foreach ($obras as $obra) {

                    $contadores = collect(DB::connection('seguridad')
                        ->table('role_user')
                        ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
                        ->leftJoin('proyectos', 'role_user.id_proyecto', '=', 'proyectos.id')
                        ->select('role_user.user_id')
                        ->where('role_user.id_obra', '=', $obra->id_obra)
                        ->where('proyectos.base_datos', '=', $bd->base_datos)
                        ->where('roles.name', '=', 'contador')
                        ->get());

                    foreach ($contadores as $contador) {

                        $polizasErrores = array();
                        $polizasNoValidadas = array();
                        $polizasSinLanzar = array();


                        $polizas_errores = collect(DB::connection('cadeco')->table('Contabilidad.int_polizas')->where('estatus', '=', Poliza::CON_ERRORES)->get());
                        $polizas_validar = collect(DB::connection('cadeco')->table('Contabilidad.int_polizas')->where('estatus', '=', Poliza::NO_VALIDADA)->get());
                        $polizas_no_lanzadas = collect(DB::connection('cadeco')->table('Contabilidad.int_polizas')->where('estatus', '=', Poliza::NO_LANZADA)->get());
                        $this->usuario = User::find($contador->user_id);


                        /*
                         * Notifcacion polizas con detalles
                         */

                        if (count($polizas_errores) > 0 || count($polizas_validar) > 0 || count($polizas_no_lanzadas) > 0) {

                            if (count($polizas_errores) > 0) {

                                foreach ($polizas_errores as $poliza) {

                                    $polizasError = collect(DB::connection('cadeco')
                                        ->table('Contabilidad.int_polizas')
                                        ->leftJoin('Contabilidad.int_transacciones_interfaz', 'Contabilidad.int_transacciones_interfaz.id_transaccion_interfaz', '=', 'Contabilidad.int_polizas.id_tipo_poliza_interfaz')
                                        ->leftJoin('Contabilidad.int_tipos_polizas_contpaq', 'Contabilidad.int_tipos_polizas_contpaq.id_int_tipo_poliza_contpaq', '=', 'Contabilidad.int_polizas.id_tipo_poliza_contpaq')
                                        ->select(
                                            'id_int_poliza',
                                            'Contabilidad.int_transacciones_interfaz.descripcion as poliza_sao',
                                            'concepto',
                                            'cuadre',
                                            'estatus',
                                            'Contabilidad.int_polizas.created_at',
                                            'Contabilidad.int_polizas.registro',
                                            'Contabilidad.int_polizas.poliza_contpaq'
                                        )
                                        ->where('id_int_poliza', '=', $poliza->id_int_poliza)
                                        ->get());

                                    foreach ($polizasError as $polizaError) {

                                        $notificacion = [
                                            'id_int_poliza' => $poliza->id_int_poliza,
                                            'tipo_poliza' => $polizaError->poliza_sao,
                                            'concepto' => $polizaError->concepto,
                                            'cuadre' => number_format($polizaError->cuadre, 2),
                                            'fecha_solicitud' => $polizaError->created_at,
                                            'usuario_solicita' => $polizaError->registro,
                                            'estatus' => $polizaError->estatus,
                                            'total' => number_format($poliza->total, 2),
                                            'poliza_contpaq' => $polizaError->poliza_contpaq
                                        ];
                                        array_push($polizasErrores, $notificacion);
                                    }
                                }

                            } else {
                                Log::info('Notificaciones : NO EXISTEN POLIZAS CON ERRORES @ ' . Carbon::now());
                            }

                            if (count($polizas_validar) > 0) {
                                foreach ($polizas_validar as $poliza) {
                                    $polizasValida = collect(DB::connection('cadeco')
                                        ->table('Contabilidad.int_polizas')
                                        ->leftJoin('Contabilidad.int_transacciones_interfaz', 'Contabilidad.int_transacciones_interfaz.id_transaccion_interfaz', '=', 'Contabilidad.int_polizas.id_tipo_poliza_interfaz')
                                        ->leftJoin('Contabilidad.int_tipos_polizas_contpaq', 'Contabilidad.int_tipos_polizas_contpaq.id_int_tipo_poliza_contpaq', '=', 'Contabilidad.int_polizas.id_tipo_poliza_contpaq')
                                        ->select(
                                            'id_int_poliza',
                                            'Contabilidad.int_transacciones_interfaz.descripcion as poliza_sao',
                                            'concepto',
                                            'cuadre',
                                            'estatus',
                                            'Contabilidad.int_polizas.created_at',
                                            'Contabilidad.int_polizas.registro',
                                            'Contabilidad.int_polizas.poliza_contpaq'
                                        )
                                        ->where('id_int_poliza', '=', $poliza->id_int_poliza)
                                        ->get());

                                    foreach ($polizasValida as $polizaValidar) {
                                        $notificacion = [
                                            'id_int_poliza' => $poliza->id_int_poliza,
                                            'tipo_poliza' => $polizaValidar->poliza_sao,
                                            'concepto' => $polizaValidar->concepto,
                                            'cuadre' => number_format($polizaValidar->cuadre, 2),
                                            'fecha_solicitud' => $polizaValidar->created_at,
                                            'usuario_solicita' => $polizaValidar->registro,
                                            'estatus' => $polizaValidar->estatus,
                                            'total' => number_format($poliza->total, 2),
                                            'poliza_contpaq' => $polizaValidar->poliza_contpaq
                                        ];
                                        array_push($polizasNoValidadas, $notificacion);
                                    }
                                }

                            } else {
                                Log::info('Notificaciones : NO EXISTEN POLIZAS POR VALIDAR @ ' . Carbon::now());
                            }

                            if (count($polizas_no_lanzadas) > 0) {
                                foreach ($polizas_no_lanzadas as $poliza) {
                                    $polizasNoLanzadas = collect(DB::connection('cadeco')
                                        ->table('Contabilidad.int_polizas')
                                        ->leftJoin('Contabilidad.int_transacciones_interfaz', 'Contabilidad.int_transacciones_interfaz.id_transaccion_interfaz', '=', 'Contabilidad.int_polizas.id_tipo_poliza_interfaz')
                                        ->leftJoin('Contabilidad.int_tipos_polizas_contpaq', 'Contabilidad.int_tipos_polizas_contpaq.id_int_tipo_poliza_contpaq', '=', 'Contabilidad.int_polizas.id_tipo_poliza_contpaq')
                                        ->select(
                                            'id_int_poliza',
                                            'Contabilidad.int_transacciones_interfaz.descripcion as poliza_sao',
                                            'concepto',
                                            'cuadre',
                                            'estatus',
                                            'Contabilidad.int_polizas.created_at',
                                            'Contabilidad.int_polizas.registro',
                                            'Contabilidad.int_polizas.poliza_contpaq'
                                        )
                                        ->where('id_int_poliza', '=', $poliza->id_int_poliza)
                                        ->get());

                                    foreach ($polizasNoLanzadas as $polizaNoLanzada) {
                                        $notificacion = [

                                            'id_int_poliza' => $poliza->id_int_poliza,
                                            'tipo_poliza' => $polizaNoLanzada->poliza_sao,
                                            'concepto' => $polizaNoLanzada->concepto,
                                            'cuadre' => number_format($polizaNoLanzada->cuadre, 2),
                                            'fecha_solicitud' => $polizaNoLanzada->created_at,
                                            'usuario_solicita' => $polizaNoLanzada->registro,
                                            'estatus' => $polizaNoLanzada->estatus,
                                            'total' => number_format($poliza->total, 2),
                                            'poliza_contpaq' => $polizaNoLanzada->poliza_contpaq
                                        ];
                                        array_push($polizasSinLanzar, $notificacion);
                                    }
                                }

                            } else {
                                Log::info('Notificaciones : NO EXISTEN POLIZAS NO LANZADAS @ ' . Carbon::now());
                            }
                            $data['polizas_errores'] = $polizasErrores;
                            $data['polizas_no_validadas'] = $polizasNoValidadas;
                            $data['polizas_no_lanzadas'] = $polizasSinLanzar;
                            $data['usuario'] = $this->usuario;
                            $data['obra'] = $obra;
                            $html = View::make('sistema_contable.emails.notificaciones_body.poliza', $data)->render();
                            $item = $this->model->create([
                                        'titulo' => 'Polizas con errores',
                                        'id_usuario' => $contador->user_id,
                                        'id_obra' => $obra->id_obra,
                                        'remitente' => Notificacion::REMITENTE_COMPRAS,
                                        'body'=>$html
                                    ]);


                             Mail::send(['sistema_contable.emails.notificaciones_html.poliza_html', 'sistema_contable.emails.notificaciones_text.poliza'], $data, function ($message) {
                                    $message->from('saoweb@grupohi.mx', 'SAO WEB');
                                    $message->to($this->usuario->correo, $this->usuario)->subject('Pólizas con errores');
                                });
                              event(new NewEmail($item,$bd->base_datos));


                        }
                        $cuentas_materiales = array();
                        $cuentas_empresa = collect(DB::Connection('cadeco')
                            ->table('Contabilidad.cuentas_empresas')
                            ->rightJoin('dbo.empresas', 'Contabilidad.cuentas_empresas.id_empresa', '=', 'dbo.empresas.id_empresa')
                            ->select(
                                'dbo.empresas.id_empresa',
                                'dbo.empresas.razon_social'
                            )
                            ->whereNull('Contabilidad.cuentas_empresas.cuenta')
                            ->get());

                        if(count($cuentas_empresa)>0){

                            $data['cuentas_empresa'] = $cuentas_empresa;
                            $data['usuario'] = $this->usuario;
                            $data['obra'] = $obra;
                            $html = View::make('sistema_contable.emails.notificaciones_body.cuenta_empresa', $data)->render();
                            $item = $this->model->create([
                                'titulo' => 'Cuentas de Empresa',
                                'id_usuario' => $contador->user_id,
                                'id_obra' => $obra->id_obra,
                                'remitente' => Notificacion::REMITENTE_COMPRAS,
                                'body'=>$html
                            ]);
                                Mail::send(['sistema_contable.emails.notificaciones_html.cuenta_empresa','sistema_contable.emails.notificaciones_text.cuenta_empresa'], $data, function ($message) {
                                   $message->from('saoweb@grupohi.mx', 'SAO WEB');
                                   $message->to($this->usuario->correo, $this->usuario)->subject('Cuentas de Empresa');
                               });
                               event(new NewEmail($item,$bd->base_datos));
                        }
                        //////Material configurado
                        $material_configurado = collect(DB::Connection('cadeco')
                            ->table('Contabilidad.cuentas_materiales')->rightJoin('dbo.materiales', 'Contabilidad.cuentas_materiales.id_material', '=', 'dbo.materiales.id_material')
                            ->select(DB::raw('count(*) as total'))
                            ->where('dbo.materiales.tipo_material', '=', Material::TIPO_MATERIALES)
                            ->whereNotNull('Contabilidad.cuentas_materiales.cuenta')->get());

                        $material_faltante = collect(DB::Connection('cadeco')->table('Contabilidad.cuentas_materiales')
                            ->rightJoin('dbo.materiales', 'Contabilidad.cuentas_materiales.id_material', '=', 'dbo.materiales.id_material')
                            ->select(DB::raw('count(*) as total'))
                            ->where('dbo.materiales.tipo_material', '=', Material::TIPO_MATERIALES)
                            ->whereNull('Contabilidad.cuentas_materiales.cuenta')->get());

                        //////Mano de obra y Servicios
                        $mano_obra_configurado = collect(DB::Connection('cadeco')->table('Contabilidad.cuentas_materiales')
                            ->rightJoin('dbo.materiales', 'Contabilidad.cuentas_materiales.id_material', '=', 'dbo.materiales.id_material')
                            ->select(DB::raw('count(*) as total'))
                            ->where('dbo.materiales.tipo_material', '=', Material::TIPO_MANO_OBRA_Y_SERVICIOS)
                            ->whereNotNull('Contabilidad.cuentas_materiales.cuenta')->get());

                        $mano_obra_faltante = collect(DB::Connection('cadeco')->table('Contabilidad.cuentas_materiales')
                            ->rightJoin('dbo.materiales', 'Contabilidad.cuentas_materiales.id_material', '=', 'dbo.materiales.id_material')
                            ->select(DB::raw('count(*) as total'))
                            ->where('dbo.materiales.tipo_material', '=', Material::TIPO_MANO_OBRA_Y_SERVICIOS)
                            ->whereNull('Contabilidad.cuentas_materiales.cuenta')->get());

                        //////Herramienta y equipo
                        $herr_equipo_configurado = collect(DB::Connection('cadeco')->table('Contabilidad.cuentas_materiales')
                            ->rightJoin('dbo.materiales', 'Contabilidad.cuentas_materiales.id_material', '=', 'dbo.materiales.id_material')
                            ->select(DB::raw('count(*) as total'))
                            ->where('dbo.materiales.tipo_material', '=', Material::TIPO_HERRAMIENTA_Y_EQUIPO)
                            ->whereNotNull('Contabilidad.cuentas_materiales.cuenta')->get());

                        $herr_equipo_faltante = collect(DB::Connection('cadeco')->table('Contabilidad.cuentas_materiales')
                            ->rightJoin('dbo.materiales', 'Contabilidad.cuentas_materiales.id_material', '=', 'dbo.materiales.id_material')
                            ->select(DB::raw('count(*) as total'))
                            ->where('dbo.materiales.tipo_material', '=', Material::TIPO_HERRAMIENTA_Y_EQUIPO)
                            ->whereNull('Contabilidad.cuentas_materiales.cuenta')->get());

                        //////Herramienta y equipo
                        $maquinaria_configurado = collect(DB::Connection('cadeco')->table('Contabilidad.cuentas_materiales')
                            ->rightJoin('dbo.materiales', 'Contabilidad.cuentas_materiales.id_material', '=', 'dbo.materiales.id_material')
                            ->select(DB::raw('count(*) as total'))
                            ->where('dbo.materiales.tipo_material', '=', Material::TIPO_MAQUINARIA)
                            ->whereNotNull('Contabilidad.cuentas_materiales.cuenta')->get());

                        $maquinaria_faltante = collect(DB::Connection('cadeco')->table('Contabilidad.cuentas_materiales')
                            ->rightJoin('dbo.materiales', 'Contabilidad.cuentas_materiales.id_material', '=', 'dbo.materiales.id_material')
                            ->select(DB::raw('count(*) as total'))
                            ->where('dbo.materiales.tipo_material', '=', Material::TIPO_MAQUINARIA)
                            ->whereNull('Contabilidad.cuentas_materiales.cuenta')->get());

                        $data = [];
                        $data['material_actual'] = $material_configurado[0]->total;
                        $data['material_restante'] = $material_faltante[0]->total;
                        $data['mano_actual'] = $mano_obra_configurado[0]->total;
                        $data['mano_restante'] = $mano_obra_faltante[0]->total;
                        $data['herramienta_actual'] = $herr_equipo_configurado[0]->total;
                        $data['herramienta_restante'] = $herr_equipo_faltante[0]->total;
                        $data['maquinaria_actual'] = $maquinaria_configurado[0]->total;
                        $data['maquinaria_restante'] = $maquinaria_faltante[0]->total;
                        $data['usuario'] = $this->usuario;
                        $data['obra'] = $obra;
                          if($data['material_restante']>0||$data['mano_restante']>0||$data['herramienta_restante']>0||$data['maquinaria_restante']>0){
                              $html = View::make('sistema_contable.emails.notificaciones_body.cuenta_material', $data)->render();
                              $item = $this->model->create([
                                  'titulo' => 'Cuentas de Materiales',
                                  'id_usuario' => $contador->user_id,
                                  'id_obra' => $obra->id_obra,
                                  'remitente' => Notificacion::REMITENTE_COMPRAS,
                                  'body'=>$html
                              ]);
                              Mail::send(['sistema_contable.emails.notificaciones_html.cuenta_material','sistema_contable.emails.notificaciones_text.cuenta_material'], $data, function ($message) {
                                  $message->from('saoweb@grupohi.mx', 'SAO WEB');
                                  $message->to($this->usuario->correo, $this->usuario)->subject('Cuentas de Materiales');
                              });
                              event(new NewEmail($item,$bd->base_datos));
                          }
                    }
                }
                DB::disconnect('cadeco');
            }
        } catch (\Exception $e) {
            Log::info($e->getFile() . '  0' . $e->getLine());
            throw $e;
        }


    }

    /**
     * Obtiene el usuario cadeco asociado al usuario de intranet
     *
     * @param $id_usuario
     * @return UsuarioCadeco
     * @internal param $idUsuario
     */
    public function getUsuarioCadeco($usuario)
    {
        return UsuarioCadeco::where('usuario', $usuario->usuario)->first();
    }

    /**
     * Obtiene las obras de un usuario cadeco
     *
     * @param UsuarioCadeco $usuarioCadeco
     * @return \Illuminate\Database\Eloquent\Collection|Obra
     */
    private function getObrasUsuario($usuarioCadeco)
    {
        if (!$usuarioCadeco) {
            return [];
        }

        if ($usuarioCadeco->tieneAccesoATodasLasObras()) {
            return Obra::orderBy('nombre')->get();
        }

        return $usuarioCadeco->obras()->orderBy('nombre')->get();
    }

    /**
     * Las notificaciones que coincidan con la busqueda
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->orderBy('created_at', 'DESC')->get($columns);
    }
}