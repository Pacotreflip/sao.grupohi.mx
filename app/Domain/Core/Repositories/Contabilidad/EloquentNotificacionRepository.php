<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 10/07/2017
 * Time: 07:00 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;


use Carbon\Carbon;
use Ghi\Core\Models\BaseDatosCadeco;
use Ghi\Domain\Core\Contracts\Contabilidad\NotificacionRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\CuentaEmpresa;

use Ghi\Domain\Core\Models\Contabilidad\Notificacion;
use Ghi\Domain\Core\Models\Contabilidad\NotificacionPoliza;
use Ghi\Domain\Core\Models\Contabilidad\Poliza;
use Ghi\Domain\Core\Models\Obra;
use Ghi\Domain\Core\Models\User;
use Ghi\Domain\Core\Models\UsuarioCadeco;
use Ghi\Events\NewEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            $basesDatos = BaseDatosCadeco::where('activa', true)->orderBy('nombre')->get();
            foreach ($basesDatos as $bd) {
                $this->config->set('database.connections.cadeco.database', $bd->nombre);
                $obras = Obra::all();


                foreach ($obras as $obra) {

                    $contadores = collect(DB::connection('seguridad')
                        ->table('role_user')
                        ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
                        ->select('role_user.user_id')
                        ->where('role_user.id_obra', '=', $obra->id_obra)
                        ->where('role_user.proyecto', '=', $bd->nombre)
                        ->where('roles.name', '=', 'contador')
                        ->get());
                    foreach ($contadores as $contador) {
                        $polizasErrores = array();
                        $polizasNoValidadas = array();
                        $polizasSinLanzar = array();

                        $polizas_errores = collect(DB::Connection('cadeco')->table('Contabilidad.int_polizas')->where('estatus', '=', Poliza::CON_ERRORES)->get());
                        $polizas_validar = collect(DB::Connection('cadeco')->table('Contabilidad.int_polizas')->where('estatus', '=', Poliza::NO_VALIDADA)->get());
                        $polizas_no_lanzadas = collect(DB::Connection('cadeco')->table('Contabilidad.int_polizas')->where('estatus', '=', Poliza::NO_LANZADA)->get());

                        if(count($polizas_errores) > 0||count($polizas_validar) > 0||count($polizas_no_lanzadas) > 0)
                        $item = $this->model->create([
                            'titulo' => 'Resumen de Errores',
                            'id_usuario' => $contador->user_id,
                            'id_obra' => $obra->id_obra,
                            'remitente'=>Notificacion::REMITENTE_COMPRAS
                        ]);

                        if (count($polizas_errores) > 0) {

                            foreach ($polizas_errores as $poliza) {
                                $this->usuario = User::find($contador->user_id);
                                $polizasError = collect(DB::Connection('cadeco')
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
                                    $notificacion = NotificacionPoliza::create([
                                        'id_notificacion' => $item->id,
                                        'id_int_poliza' => $poliza->id_int_poliza,
                                        'tipo_poliza' => $polizaError->poliza_sao,
                                        'concepto' => $polizaError->concepto,
                                        'cuadre' => number_format($polizaError->cuadre,2),
                                        'fecha_solicitud' => $polizaError->created_at,
                                        'usuario_solicita' => $polizaError->registro,
                                        'estatus' => $polizaError->estatus,
                                        'total' => number_format($poliza->total, 2),
                                        'poliza_contpaq' => $polizaError->poliza_contpaq
                                    ]);
                                    array_push($polizasErrores, $notificacion);
                                }
                            }

                        } else {
                            Log::info('Notificaciones : NO EXISTEN POLIZAS CON ERRORES @ ' . Carbon::now());
                        }

                        if (count($polizas_validar) > 0) {

                            foreach ($polizas_validar as $poliza) {

                                $this->usuario = User::find($contador->user_id);
                                $polizasValida = collect(DB::Connection('cadeco')
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
                                    $notificacion = NotificacionPoliza::create([
                                        'id_notificacion' => $item->id,
                                        'id_int_poliza' => $poliza->id_int_poliza,
                                        'tipo_poliza' => $polizaValidar->poliza_sao,
                                        'concepto' => $polizaValidar->concepto,
                                        'cuadre' => number_format($polizaValidar->cuadre,2),
                                        'fecha_solicitud' => $polizaValidar->created_at,
                                        'usuario_solicita' => $polizaValidar->registro,
                                        'estatus' => $polizaValidar->estatus,
                                        'total' => number_format($poliza->total, 2),
                                        'poliza_contpaq' => $polizaValidar->poliza_contpaq
                                    ]);
                                    array_push($polizasNoValidadas, $notificacion);
                                }
                            }

                        } else {
                            Log::info('Notificaciones : NO EXISTEN POLIZAS POR VALIDAR @ ' . Carbon::now());
                        }

                        if (count($polizas_no_lanzadas) > 0) {


                            foreach ($polizas_no_lanzadas as $poliza) {

                                $this->usuario = User::find($contador->user_id);
                                $polizasNoLanzadas = collect(DB::Connection('cadeco')
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
                                    $notificacion = NotificacionPoliza::create([
                                        'id_notificacion' => $item->id,
                                        'id_int_poliza' => $poliza->id_int_poliza,
                                        'tipo_poliza' => $polizaNoLanzada->poliza_sao,
                                        'concepto' => $polizaNoLanzada->concepto,
                                        'cuadre' => number_format($polizaNoLanzada->cuadre,2),
                                        'fecha_solicitud' => $polizaNoLanzada->created_at,
                                        'usuario_solicita' => $polizaNoLanzada->registro,
                                        'estatus' => $polizaNoLanzada->estatus,
                                        'total' => number_format($poliza->total, 2),
                                        'poliza_contpaq' => $polizaNoLanzada->poliza_contpaq
                                    ]);
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
                        $data['obra']=$obra;

                          Mail::send(['sistema_contable.emails.notificaciones.poliza_html', 'sistema_contable.emails.notificaciones.poliza'], $data, function ($message) {
                               $message->from('saoweb@grupohi.mx', 'SAO WEB');
                               $message->to($this->usuario->correo, $this->usuario)->subject('Pólizas con errores');
                           });
                           event(new NewEmail($item, $this->usuario->idusuario));


                    }
                }
                DB::disconnect('cadeco');
            }
        } catch (\Exception $e) {
            Log::info($e->getFile().'  0'. $e->getLine());
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