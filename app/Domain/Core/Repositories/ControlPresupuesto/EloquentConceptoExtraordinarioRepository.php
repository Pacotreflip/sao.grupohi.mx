<?php
/**
 * Created by PhpStorm.
 * User: 25852
 * Date: 18/05/2018
 * Time: 04:53 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;

use Ghi\Core\Facades\Context;
use Ghi\Core\Models\User;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\ConceptoExtraordinarioRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\ConceptoPath;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoTarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartidaHistorico;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioRechazada;
use Ghi\Domain\Core\Models\ControlPresupuesto\Tarjeta;
use Ghi\Domain\Core\Models\Seguridad\Proyecto;
use Illuminate\Support\Facades\DB;

class EloquentConceptoExtraordinarioRepository implements ConceptoExtraordinarioRepository
{
    protected $solicitud;
    protected $solicitud_partidas;

    public function __construct(SolicitudCambio $solicitud, SolicitudCambioPartida $solicitud_partidas)
    {
        $this->solicitud = $solicitud;
        $this->solicitud_partidas = $solicitud_partidas;
    }


    public function store(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $agrupador_conceptos = ['MATERIALES', 'MANOOBRA', 'HERRAMIENTAYEQUIPO', 'MAQUINARIA', 'SUBCONTRATOS', 'GASTOS'];

            /// Se guarda el registro en la tabla Solicitud Cambio
            $solicitud = $this->solicitud->create($data);
            /// se inicia con guardado de las partidas en la tabla Solicitud Cambio Partidas
            $data['extraordinario']['id_solicitud_cambio'] = $solicitud->id;
            $data['id_origen_extraordinario'] == 1? $data['extraordinario']['id_tarjeta'] = $data['id_opcion']:  $data['extraordinario']['id_tarjeta'] = null;
            $data['extraordinario']['nivel'] = $data['nivel_base']. str_pad($data['tiene_hijos_base'] + 1,3,"0", STR_PAD_LEFT) . '.';
            $data['extraordinario']['id_tipo_orden'] = $data['id_tipo_orden'];
            $data['extraordinario']['id_material'] = null;
            $data['extraordinario']['cantidad_presupuestada_nueva'] = $data['extraordinario']['cantidad_presupuestada'];
            $data['extraordinario']['precio_unitario_nuevo'] = $data['extraordinario']['precio_unitario'];
            $data['extraordinario']['monto_presupuestado'] = $data['extraordinario']['cantidad_presupuestada'] * $data['extraordinario']['precio_unitario'];
            $concepto_ext = $this->solicitud_partidas->create($data['extraordinario']);

            foreach ($agrupador_conceptos as $key_a =>  $agrupador_insumos){
                $agrupador = $data['extraordinario'][$agrupador_insumos];
                $nivel_agrupador = explode('.', $agrupador['nivel']);
                $agrupador['tipo_agrupador'] = (int)$nivel_agrupador[sizeof($nivel_agrupador)-2];
                $agrupador['id_solicitud_cambio'] = $solicitud->id;
                $agrupador['id_tipo_orden'] = $data['id_tipo_orden'];
                $agrupador['id_tarjeta'] = $data['extraordinario']['id_tarjeta'];
                $agrupador['id_material'] = null;
                $agrupador['nivel'] =  $data['extraordinario']['nivel']. str_pad($key_a + 1,3,"0", STR_PAD_LEFT) . '.';
                $agrupador['descripcion'] == 'MANOOBRA'? $agrupador['descripcion'] = 'MANO OBRA':'';
                $agrupador['descripcion'] == 'HERRAMIENTAYEQUIPO'? $agrupador['descripcion'] = 'HERRAMIENTA Y EQUIPO':'';
                $monto_presupuestado_agrupador = 0;
                $agrupado = $this->solicitud_partidas->create($agrupador);
                /// Inicia ciclo para guardar insumos del agrupador
                if(array_key_exists('insumos', $agrupador)) {
                    foreach ($agrupador['insumos'] as $key => $insumo) {
                        $insumo['id_solicitud_cambio'] = $solicitud->id;
                        $insumo['id_tipo_orden'] = $data['id_tipo_orden'];
                        $insumo['tipo_agrupador'] = $agrupador['tipo_agrupador'];
                        $insumo['id_tarjeta'] = $agrupador['id_tarjeta'];
                        $insumo['nivel'] = $agrupador['nivel'] . str_pad($key + 1,3,"0", STR_PAD_LEFT) . '.';
                        $insumo['cantidad_presupuestada_nueva'] = $agrupador['descripcion'] == 'GASTOS'?$insumo['cantidad_presupuestada']:$insumo['cantidad_presupuestada'] * $concepto_ext->cantidad_presupuestada_nueva;
                        $insumo['precio_unitario_nuevo'] = $insumo['precio_unitario'];
                        $insumo['monto_presupuestado'] = $agrupador['descripcion'] == 'GASTOS'?$insumo['monto_presupuestado']:$insumo['cantidad_presupuestada_nueva'] * $insumo['precio_unitario'];
                        $monto_presupuestado_agrupador += $insumo['monto_presupuestado'];

                        $this->solicitud_partidas->create($insumo);
                    }
                    if($agrupador['descripcion'] == 'GASTOS'){
                        $concepto_update = SolicitudCambioPartida::find($concepto_ext->id);
                        $concepto_update->cantidad_presupuestada_nueva = $monto_presupuestado_agrupador;
                        $concepto_update->precio_unitario_nuevo = 1;
                        $concepto_update->monto_presupuestado = $monto_presupuestado_agrupador;
                        $concepto_update->save();
                    }
                };

                /// por último se guarda el agrupador con sus datos
                $agrupado_update = SolicitudCambioPartida::find($agrupado->id);
                $agrupado_update->monto_presupuestado = $monto_presupuestado_agrupador;
                $agrupado_update->save();
                //$this->solicitud_partidas->update($agrupado);
            }
            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch
        (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    public function autorizar($id){

        try{
            DB::connection('cadeco')->beginTransaction();
            ////  buscar los insumos autorizados
            $partida_base = $this->solicitud_partidas->where('id_solicitud_cambio', '=', $id)->orderBY('nivel')->first();
            $partidas = $this->solicitud_partidas->where('id_solicitud_cambio', '=', $id)->orderBY('nivel')->get();

            /// buscar y/o crear una nueva tarjeta
            $tarjeta = Tarjeta::where('id', '=', $partida_base->id_tarjeta)->first();
            if($tarjeta){
                $tarjeta_nueva = Tarjeta::create(['descripcion' => $tarjeta->descripcion.'-'.$tarjeta->cantidad_descripcion]);
            }else{
                $tarjeta_ext = Tarjeta::where('descripcion', 'like', 'EXT-%')->count();
                if($tarjeta_ext > 0){
                    $tarjeta_nueva = Tarjeta::create(['descripcion' => 'EXT-'.$tarjeta_ext ]);
                }else{
                    $tarjeta_nueva = Tarjeta::create(['descripcion' => 'EXT-0']);
                }
            }

            ///     comenzar a iterar los conceptos

            foreach ($partidas as $key => $partida){
                ///     guardar en conceptos
                $dataNuevoInsumo = [
                    "id_material" => $partida->id_material,
                    "id_obra" => Context::getId(),
                    "nivel" => $partida->nivel,
                    "descripcion" => $partida->descripcion,
                    "unidad" =>  isset($partida->concepto)?$partida->concepto->unidad:$partida->unidad,
                    "cantidad_presupuestada" => $partida->cantidad_presupuestada_nueva,
                    "monto_presupuestado" => $partida->monto_presupuestado,
                    "precio_unitario" => $partida->precio_unitario_nuevo,

                ];

                $nuevoInsumo = \Ghi\Domain\Core\Models\Concepto::create($dataNuevoInsumo);

                ///     guardar en conceptos path(id_concepto y nivel)
                $this->insertarPath($nuevoInsumo->id_concepto);

                ///     guardar en historico
                $dataHist = [];
                $dataHist['precio_unitario_original'] = 0;
                $dataHist['precio_unitario_actualizado'] = $nuevoInsumo->precio_unitario;
                $dataHist['monto_presupuestado_original'] = 0;
                $dataHist['monto_presupuestado_actualizado'] = $nuevoInsumo->monto_presupuestado;
                $dataHist['cantidad_presupuestada_original'] = 0;
                $dataHist['cantidad_presupuestada_actualizada'] = $nuevoInsumo->cantidad_presupuestada;
                $dataHist['id_solicitud_cambio_partida'] = $partida_base->id;
                $dataHist['id_base_presupuesto'] = 2;
                $dataHist['nivel'] = $nuevoInsumo->nivel;
                //$dataHist['id_partidas_insumos_agrupados'] = $id;
                SolicitudCambioPartidaHistorico::create($dataHist);

                ///     guardar en concepto tarjeta
                ConceptoTarjeta::create(['id_concepto' => $nuevoInsumo->id_concepto, 'id_tarjeta' => $tarjeta_nueva->id]);

            }

            /// Propagacion de monto presupuestado del extraordinario
            $tamanioFaltante = strlen($partida_base->nivel)-4;
            $nivel = $partida_base->nivel;
            $afectacion_mmonto_propagacion = $partida_base->monto_presupuestado;

            while ($tamanioFaltante > 0) { ///////////////recorrido todos los niveles hacia arriba

                $dataHist = [];
                $afectaConcepto = Concepto::where('nivel', '=', substr($nivel, 0, $tamanioFaltante))->where('id_obra', '=', Context::getId())->first();
                $dataHist['precio_unitario_original'] = $afectaConcepto->precio_unitario;
                $dataHist['monto_presupuestado_original'] = $afectaConcepto->monto_presupuestado;
                $dataHist['precio_unitario_actualizado'] = $afectaConcepto->precio_unitario;
                //$dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                $dataHist['id_solicitud_cambio_partida'] = $partida_base->id;

                $afectaConcepto->monto_presupuestado = $afectaConcepto->monto_presupuestado + $afectacion_mmonto_propagacion;
                $afectaConcepto->save();

                $dataHist['monto_presupuestado_actualizado'] = $afectaConcepto->monto_presupuestado;
                $dataHist['id_base_presupuesto'] = 2;
                $dataHist['nivel'] = $afectaConcepto->nivel;
                SolicitudCambioPartidaHistorico::create($dataHist);
                $tamanioFaltante -= 4;
            }

            ///  autorizar solicitud

            $solicitud = SolicitudCambio::find($id);
            $solicitud->id_estatus = Estatus::AUTORIZADA;
            $solicitud->save();

            SolicitudCambioAutorizada::create(["id_solicitud_cambio" => $id]);
            //$this->enviarNotificacionRevasePresupuesto($id);


            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }

    public function rechazar(array $data)
    {
        try {

            DB::connection('cadeco')->beginTransaction();
            $solicitud = $this->solicitud->with('partidas')->find($data['id_solicitud_cambio']);

            if (is_null($solicitud))
                throw new HttpResponseException(new Response('No existe la solicitud a rechazar', 404));

            // La solicitud ya está rechazada
            if ($solicitud->id_estatus == Estatus::RECHAZADA)
                throw new HttpResponseException(new Response('La solicitud ya está rechazada', 404));

            $solicitud->id_estatus = Estatus::RECHAZADA;
            $solicitudCambio = SolicitudCambioRechazada::create($data);
            $solicitud->save();
            $solicitud = $this->solicitud->with(['tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto', 'partidas.numeroTarjeta'])->find($data['id_solicitud_cambio']);
            $solicitud['cobrabilidad'] = $solicitud->tipoOrden->cobrabilidad;

            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }

    public function getSolicitudCambioPartidas($id)
    {
        $extraordinario = [];
        $agrupadores_insumos = [];
        $partida = $this->solicitud_partidas->where('id_solicitud_cambio', '=', $id)->orderBy('nivel', 'asc')->first();
        $extraordinario += [
            'nivel'=>$partida->nivel,
            'descripcion'=>$partida->descripcion,
            'unidad'=>$partida->unidad,
            'id_material'=>$partida->id_material,
            'cantidad_presupuestada'=>$partida->cantidad_presupuestada_nueva,
            'precio_unitario'=>$partida->precio_unitario_nuevo,
            'monto_presupuestado'=>$partida->monto_presupuestado
        ];

        $agrupadores = $this->solicitud_partidas->where('nivel', 'like', $partida->nivel.'___.')->where('id_solicitud_cambio', '=', $id)->get();
        foreach ($agrupadores as $key =>$agrupador){
            $insumos = SolicitudCambioPartida::where('nivel', 'like', $agrupador->nivel.'___.')->where('id_solicitud_cambio', '=', $id)->get()->toArray();
            $agrupadores_insumos += [
                $key => [
                    'nivel' => $agrupador->nivel,
                    'descripcion' => $agrupador->descripcion,
                    'monto_presupuestado' => $agrupador->monto_presupuestado,
                    'insumos' => $insumos
                ]
            ];
        }
        $extraordinario += ['agrupadores' => $agrupadores_insumos];

        return $extraordinario;
    }

    public function insertarPath($idConcepto){
        $concepto=Concepto::find($idConcepto);
        $concepto->nivel;
        $nivelPadre=substr($concepto->nivel, 0, strlen($concepto->nivel)-4);

        $conceptoPadre=Concepto::where('nivel','=',$nivelPadre)->first();
        $conceptoPathPadre=ConceptoPath::where('id_concepto','=',$conceptoPadre->id_concepto)->first();

        $conceptoPathHijo=$conceptoPathPadre;
        $conceptoPathHijo->id_concepto=$concepto->id_concepto;
        $conceptoPathHijo->nivel=$concepto->nivel;
        $conceptoPathHijo->id_obra=Context::getId();

        switch (strlen($concepto->nivel)){
            case 4:
                $conceptoPathHijo->filtro1=$concepto->descripcion;
                break;
            case 8:
                $conceptoPathHijo->filtro2=$concepto->descripcion;
                break;
            case 12:
                $conceptoPathHijo->filtro3=$concepto->descripcion;
                break;
            case 16:
                $conceptoPathHijo->filtro4=$concepto->descripcion;
                break;
            case 20:
                $conceptoPathHijo->filtro5=$concepto->descripcion;
                break;
            case 24:
                $conceptoPathHijo->filtro6=$concepto->descripcion;
                break;
            case 28:
                $conceptoPathHijo->filtro7=$concepto->descripcion;
                break;
            case 32:
                $conceptoPathHijo->filtro8=$concepto->descripcion;
                break;
            case 36:
                $conceptoPathHijo->filtro9=$concepto->descripcion;
                break;
            case 40:
                $conceptoPathHijo->filtro10=$concepto->descripcion;
                break;
            case 44:
                $conceptoPathHijo->filtro11=$concepto->descripcion;
                break;

        }

        $conceptoPathNuevo= ConceptoPath::create($conceptoPathHijo->toArray());
    }

    /*public function enviarNotificacionRevasePresupuesto($id)
    {
        try {

            $solicitud = SolicitudCambio::with(['tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto',
                'partidas.numeroTarjeta', 'aplicaciones'])->find($id);
            $presupuestos = $this->afectacion->with('baseDatos')->getBy('id_tipo_orden', '=', $solicitud->id_tipo_orden);
            $conceptos_agrupados = $this->agrupacion->with('concepto')->where([['id_solicitud_cambio', '=', $solicitud->id]])->all();
            $conceptos_agrupados = $this->partidas->getTotalesClasificacionInsumos($conceptos_agrupados->toArray());
            $solicitud = SolicitudCambio::with(['tipoOrden', 'userRegistro', 'estatus'])->find($id);


            $data = [];
            $data['solicitud'] = $solicitud;
            $data['cobrabilidad'] = $solicitud->tipoOrden->cobrabilidad;
            $data['presupuestos'] = $presupuestos;
            $data['conceptos_agrupados'] = $conceptos_agrupados;
            $data['folio_solicitud'] = $solicitud->numero_folio;
            $data['usuario_autorizo'] = SolicitudCambioAutorizada::where("id_solicitud_cambio", "=", $id)->first()->userAutorizo;
            $data['dif_proforma'] = $conceptos_agrupados['maximo_proforma']['diferencia'];
            $basesDatos = Proyecto::get();

            foreach ($basesDatos as $bd) {
                $this->config->set('database.connections.cadeco.database', $bd->base_datos);
                $obras = Obra::all();


                foreach ($obras as $obra) {
                    if ($obra->id_obra == $solicitud->id_obra) {
                        $coordinadores_control_proyectos = collect(DB::connection('seguridad')
                            ->table('role_user')
                            ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
                            ->leftJoin('proyectos', 'role_user.id_proyecto', '=', 'proyectos.id')
                            ->select('role_user.user_id')
                            ->where('role_user.id_obra', '=', $obra->id_obra)
                            ->where('proyectos.base_datos', '=', $bd->base_datos)
                            ->where('roles.name', '=', 'coordinador_control_proyectos')
                            ->get());

                        $data['obra'] = $obra->nombre;
                        $html = View::make('control_presupuesto.emails.notificaciones_html.cambio_insumos', $data)->render();

                        $mail = new Mail();
                        $body = $html;

                        $mail->SetFrom('seguimiento@hermesconstruccion.com.mx', 'sao.grupohi.mx');
                        $mail->MsgHTML($body);
                        $mail->Subject = utf8_decode("Autorización de cambio de insumos");

                        foreach ($coordinadores_control_proyectos as $coordinador_control_proyectos) {
                            $usuario = User::find($coordinador_control_proyectos->user_id);
                            $address = $usuario->correo;
                            $mail->AddAddress($address, $usuario);
                            $mail->Send();
//dd("enviado --->". $usuario->correo);

                        }
                    }


                }
            }
        } catch (\Exception $e) {
            //Log::info($e->getFile() . '  0' . $e->getLine());
            throw $e;
        }

    }*/

    public function getPdfData($id)
    {
        $resumen = $this->getResumenExtraordinario($id);
        $solicitud = $this->solicitud->with(['aplicaciones', 'tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto',
            'partidas.numeroTarjeta', 'partidas.historico'])->find($id);
        $solicitud_partidas = $this->getSolicitudCambioPartidas($id);
        return ['resumen' => $resumen,
                'solicitud' => $solicitud,
                'solicitud_partidas' => $solicitud_partidas];
    }

    public function getResumenExtraordinario($id)
    {
        $sol_cambio = $this->solicitud->find($id);
        if($sol_cambio->id_estatus == 1 || $sol_cambio->id_estatus == 3){
             return Concepto::where('nivel', 'like', '___.')->first();
        }else{
            $partida_base = $this->solicitud_partidas->where('id_solicitud_cambio', '=', $id)->orderBY('nivel')->first();
            return SolicitudCambioPartidaHistorico::where('id_solicitud_cambio_partida', '=', $partida_base->id)->where('nivel', 'like', '___.')->first();
        }
    }

}