<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 12:04 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;

use Ghi\Core\Facades\Context;
use Ghi\Core\Models\Concepto;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\AfectacionOrdenesPresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoEscalatoria;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoTarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\PartidasInsumosAgrupados;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioRechazada;
use Ghi\Domain\Core\Models\ControlPresupuesto\Tarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Ghi\Domain\Core\Models\Material;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class EloquentSolicitudCambioRepository implements SolicitudCambioRepository
{
    /**
     * @var SolicitudCambio
     */
    protected $model;

    public function __construct(SolicitudCambio $model)
    {
        $this->model = $model;
    }


    /**
     * Obtiene todos los registros de la SolicitudCambioPartida
     *
     * @return SolicitudCambio
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Regresa todas las solicitudes de cambio
     * @return Collection | SolicitudCambio
     */

    public function paginate(array $data)
    {
        $query = $this->model->with(['tipoOrden', 'userRegistro', 'estatus']);
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * Guarda un registro de SolicitudCambio
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambio
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $solicitudCambio = $this->model->create($data);
            DB::connection('cadeco')->commit();
            return $solicitudCambio;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Regresa un registro específico de SolicitudCambio
     * @param $id
     * @return SolicitudCambio
     */
    public function find($id)
    {
        $solicitudCambio = $this->model->find($id);
        return $solicitudCambio;
    }

    public function saveVariacionVolumen(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $solicitud = $this->create($data);
            foreach ($data['partidas'] as $partida) {
                $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $partida['id_concepto'])->first();
                if ($conceptoTarjeta) {
                    $partida['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                }
                $partida['cantidad_presupuestada_nueva'] = ($partida['cantidad_presupuestada_original'] + $partida['variacion_volumen']);
                $partida['id_solicitud_cambio'] = $solicitud->id;
                $partida['id_tipo_orden'] = TipoOrden::VARIACION_VOLUMEN;
                $partida = SolicitudCambioPartida::create($partida);
            }

            $solicitud = $this->with('partidas')->find($solicitud->id);
            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    public function saveEscalatoria(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $solicitud = $this->create($data);
            foreach ($data['partidas'] as $partida) {
                $partida['id_solicitud_cambio'] = $solicitud->id;
                $partida['id_tipo_orden'] = TipoOrden::ESCALATORIA;
                SolicitudCambioPartida::create($partida);
            }
            $solicitud = $this->with('partidas')->find($solicitud->id);
            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Autoriza una solicitud de cambio
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambio
     */
    public function autorizarVariacionVolumen($id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();


            $solicitud = $this->model->with('partidas')->find($id);
            $basesAfectadas = AfectacionOrdenesPresupuesto::with('baseDatos')->where('id_tipo_orden', '=', $solicitud->id_tipo_orden)->get();


            foreach ($solicitud->partidas as $partida) {

                $conceptoSolicitud = Concepto::find($partida->id_concepto); ///concepto raiz para obtener la clave
                //  echo "A-".$concepto->clave_concepto;
                if ($conceptoSolicitud->clave_concepto == null) {
                    throw new HttpResponseException(new Response('El concepto ' . $conceptoSolicitud->descripcion . ' no cuenta con clave de concepto registrada', 404));
                    //////////////////////////////////// sin clave de concepto
                }
                foreach ($basesAfectadas as $basePresupuesto) { /////////seleccionamos el tipo de presupuesto a afectar
                    $concepto = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->select('*')->where('clave_concepto', '=', $conceptoSolicitud->clave_concepto)->first();
                    if (!$concepto) {
                        throw new HttpResponseException(new Response('El concepto ' . $conceptoSolicitud->descripcion . ' no cuenta con clave de concepto registrada en ' . $basePresupuesto->baseDatos->base_datos, 404));

                    }
                    $montoAnterior = $concepto->monto_presupuestado;

                    $factor = ($partida->cantidad_presupuestada_nueva / $concepto->cantidad_presupuestada);
                    $concepto->cantidad_presupuestada = $partida->cantidad_presupuestada_nueva;
                    $concepto->monto_presupuestado = $concepto->monto_presupuestado * $factor;

                    //propagacion hacia abajo
                    $conceptosPropagacion = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->where('nivel', 'like', $concepto->nivel . '%')->where('id_obra', '=', Context::getId())->get();
                    $afectacion = 0;
                    foreach ($conceptosPropagacion as $conceptoPropagacion) {

                        $conceptoPropagacion->cantidad_presupuestada = $conceptoPropagacion->cantidad_presupuestada * $factor;
                        $conceptoPropagacion->monto_presupuestado = $conceptoPropagacion->monto_presupuestado * $factor;
                        if ($afectacion > 0) {
                            DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")
                                ->where('id_concepto', $conceptoPropagacion->id_concepto)
                                ->update(['cantidad_presupuestada' => $conceptoPropagacion->cantidad_presupuestada, 'monto_presupuestado' => $conceptoPropagacion->monto_presupuestado]);
                            // $conc = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->where('id_concepto', '=', $conceptoPropagacion->id_concepto)->first();
                        }
                        $afectacion++;

                        //echo "cp->" . $conceptoPropagacion->id_concepto;
                    }

                    DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")
                        ->where('id_concepto', $concepto->id_concepto)
                        ->update(['cantidad_presupuestada' => $concepto->cantidad_presupuestada, 'monto_presupuestado' => $concepto->monto_presupuestado]);
                    $conc = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->where('id_concepto', '=', $concepto->id_concepto)->where('id_obra', '=', Context::getId())->first();

                    //propagacion hacia arriba monto

                    $tamanioFaltante = strlen($conc->nivel);
                    $afectacionConcepto = 0;

                    while ($tamanioFaltante > 0) { ///////////////recorrido todos los niveles hacia arriba
                        $afectaConcepto = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->where('id_obra', '=', Context::getId())->where('nivel', '=', substr($conc->nivel, 0, $tamanioFaltante))->first();
                        if ($afectacionConcepto > 0) {///afectamos el concepto de la solicitud
                            $cantidadMonto = ($afectaConcepto->monto_presupuestado - $montoAnterior) + $conc->monto_presupuestado;
                            DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")
                                ->where('id_concepto', $conc->id_concepto)
                                ->update(['monto_presupuestado' => $cantidadMonto]);
                        }
                        $afectacionConcepto++;
                        $tamanioFaltante -= 4;
                    }
                }

            }

            $solicitud->id_estatus = Estatus::AUTORIZADA;
            $solicitud->save();
            $data = ["id_solicitud_cambio" => $id];
            $solicitudCambio = SolicitudCambioAutorizada::create($data);
            $solicitud = $this->model->with(['tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto', 'partidas.numeroTarjeta'])->find($id);
            $solicitud['cobrabilidad'] = $solicitud->tipoOrden->cobrabilidad;


            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch
        (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }


    /**
     * Rechaza una solicitud de cambio
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambio
     */
    public function rechazarVariacionVolumen(array $data)
    {
        try {

            DB::connection('cadeco')->beginTransaction();
            $solicitud = $this->model->with('partidas')->find($data['id_solicitud_cambio']);
            $solicitud->id_estatus = Estatus::RECHAZADA;
            // $data = ["id_solicitud_cambio" => $data['id'],"motivo"=>$data['motivo']];
            $solicitudCambio = SolicitudCambioRechazada::create($data);
            $solicitud->save();
            $solicitud = $this->model->with(['tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto', 'partidas.numeroTarjeta'])->find($data['id_solicitud_cambio']);
            $solicitud['cobrabilidad'] = $solicitud->tipoOrden->cobrabilidad;

            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }

    public function saveCambioInsumos(array $data)
    {

        try {
            DB::connection('cadeco')->beginTransaction();

            $solicitud = $this->create($data);

            foreach ($data['agrupadas'] as $conceptoAgrupado) { /////////partidas agrupadas
                $partidaInsumo['id_solicitud_cambio'] = $solicitud->id;
                $partidaInsumo['id_concepto'] = $conceptoAgrupado;
                PartidasInsumosAgrupados::create($partidaInsumo);
            }

            foreach ($data['partidas'] as $partida) {

                $cantidad_presupuestada_concepto = $partida['cobrable']['cantidad_presupuestada'];

                ////////impacto materiales
                if (array_key_exists('insumos', $partida['conceptos']['MATERIALES'])) {
                    foreach ($partida['conceptos']['MATERIALES']['insumos'] as $material) {

                        if (isset($material['id_concepto'])) {
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $material['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $material['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }
                        $material['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $material['id_solicitud_cambio'] = $solicitud->id;
                        $material['precio_unitario_original'] = $material['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $material) ? $material['precio_unitario_nuevo'] = $material['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $material) ? $material['rendimiento_nuevo'] = $material['rendimiento_nuevo'] : '';
                        $material['rendimiento_original'] = $material['rendimiento_actual'];

                        //  dd($material['rendimiento_nuevo']);
                        if (array_key_exists('precio_unitario_nuevo', $material) || array_key_exists('rendimiento_nuevo', $material)) {
                            SolicitudCambioPartida::create($material);
                        }
                    }
                }
                ////////impacto Mano obra
                if (array_key_exists('insumos', $partida['conceptos']['MANOOBRA'])) {
                    foreach ($partida['conceptos']['MANOOBRA']['insumos'] as $mano) {
                        if (isset($mano['id_concepto'])) {
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $mano['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $mano['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }

                        $mano['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $mano['id_solicitud_cambio'] = $solicitud->id;
                        $mano['precio_unitario_original'] = $mano['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $mano) ? $mano['precio_unitario_nuevo'] = $mano['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $mano) ? $mano['rendimiento_nuevo'] = $mano['rendimiento_nuevo'] : '';
                        $mano['rendimiento_original'] = $mano['rendimiento_actual'];

                        if (array_key_exists('precio_unitario_nuevo', $mano) || array_key_exists('rendimiento_nuevo', $mano)) {
                            SolicitudCambioPartida::create($mano);
                        }
                    }
                }
                ////////impacto Herramienta y equipo
                if (array_key_exists('insumos', $partida['conceptos']['HERRAMIENTAYEQUIPO'])) {
                    foreach ($partida['conceptos']['HERRAMIENTAYEQUIPO']['insumos'] as $herramienta) {
                        if (isset($herramienta['id_concepto'])) {
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $herramienta['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $herramienta['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }
                        $herramienta['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $herramienta['id_solicitud_cambio'] = $solicitud->id;
                        $herramienta['precio_unitario_original'] = $herramienta['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $herramienta) ? $herramienta['precio_unitario_nuevo'] = $herramienta['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $herramienta) ? $herramienta['rendimiento_nuevo'] = $herramienta['rendimiento_nuevo'] : '';
                        $herramienta['rendimiento_original'] = $herramienta['rendimiento_actual'];

                        if (array_key_exists('precio_unitario_nuevo', $herramienta) || array_key_exists('rendimiento_nuevo', $herramienta)) {
                            SolicitudCambioPartida::create($herramienta);
                        }
                    }
                }

                ////////impacto Maquinaria

                if (array_key_exists('insumos', $partida['conceptos']['MAQUINARIA'])) {
                    foreach ($partida['conceptos']['MAQUINARIA']['insumos'] as $maquinaria) {
                        if (isset($maquinaria['id_concepto'])) {
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $maquinaria['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $maquinaria['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }
                        $maquinaria['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $maquinaria['id_solicitud_cambio'] = $solicitud->id;
                        $maquinaria['precio_unitario_original'] = $maquinaria['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $maquinaria) ? $maquinaria['precio_unitario_nuevo'] = $maquinaria['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $maquinaria) ? $maquinaria['rendimiento_nuevo'] = $maquinaria['rendimiento_nuevo'] : '';
                        $maquinaria['rendimiento_original'] = $maquinaria['rendimiento_actual'];

                        if (array_key_exists('precio_unitario_nuevo', $maquinaria) || array_key_exists('rendimiento_nuevo', $maquinaria)) {
                            SolicitudCambioPartida::create($maquinaria);
                        }


                    }
                }
            }

            //   dd($solicitud);
            $solicitud = $this->with('partidas')->find($solicitud->id);
            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch
        (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    public function autorizarCambioInsumos($id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $sumas_insumos = 0;

            $insumosAgrupados = PartidasInsumosAgrupados::where('id_solicitud_cambio', '=', $id)->get();
            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $insumosAgrupados[0]->id_concepto)->first();
            //////////////generamos nueva tarjeta
            $tarjeta = Tarjeta::find($conceptoTarjeta->id_tarjeta);
            $numAux = 0;
            for ($num = 1; ; $num++) {
                $tarjetaNueva = Tarjeta::where('descripcion', '=', $tarjeta->descripcion . '-' . $num)->get();
                $numAux = $num;
                if (count($tarjetaNueva) == 0) {
                    break;
                }
            }
            $tarjetaNueva = $tarjeta->descripcion . '-' . ($numAux);
            $nuevaTarjeta = Tarjeta::create(['descripcion' => $tarjetaNueva]);


            foreach ($insumosAgrupados as $insumo) {

                $partidas = SolicitudCambioPartida::with('material')->where('id_solicitud_cambio', '=', $id)->get();
                $concepto = Concepto::find($insumo['id_concepto']);

                $materiales = [];
                $mano_obra = [];
                $herramienta = [];
                $maquinaria = [];
                $data = [];
                $tarjeta_id = 0;
                foreach ($partidas as $partida) {
                    $tarjeta_id = $partida->id_tarjeta;
                    if ($partida['rendimiento_nuevo'] != null) {
                        $partida['cantidad_presupuestada'] = $partida['rendimiento_nuevo'] * $concepto->cantidad_presupuestada;
                    } else {
                        $item = Concepto::where('nivel', 'like', $concepto->nivel . '%')->where('id_material', '=', $partida['id_material'])->first();
                        $partida['cantidad_presupuestada'] = $item->cantidad_presupuestada;
                    }
                    if ($partida['precio_unitario_nuevo'] != null) {
                        $partida['precio_unitario_original'] = $partida['precio_unitario_original'];
                        $partida['precio_unitario_nuevo'] = $partida['precio_unitario_nuevo'];
                        $partida['monto_presupuestado'] = $partida['cantidad_presupuestada'] * $partida['precio_unitario_nuevo'];
                    } else {
                        $partida['precio_unitario_nuevo'] = 0;
                        $partida['monto_presupuestado'] = $partida['cantidad_presupuestada'] * $partida['precio_unitario_original'];
                    }


                    $conceptoReset=Concepto::where('nivel','like',$concepto->nivel.'%')->where('id_material','=',$partida->id_material)->first();
                    if($conceptoReset) {
                        $partida->id_concepto = $conceptoReset->id_concepto;
                    }
                    switch ($partida->material->tipo_material) {
                        case 1:///materiales
                            array_push($materiales, $partida);
                            break;
                        case 2:///Mano obra
                            array_push($mano_obra, $partida);
                            break;
                        case 4:///Herramienta y equipo
                            array_push($herramienta, $partida);
                            break;
                        case 8:/// Maquinaria
                            array_push($maquinaria, $partida);
                            break;
                    }


                }


                foreach ($materiales as $material) ////integracion materiales tarjeta nueva
                {
                    if ($material->id_concepto) { ////actualizacion de concepto
                        $conceptoUpdate = Concepto::find($material->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $material['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($material['precio_unitario_nuevo'] > 0) {
                            $conceptoUpdate->precio_unitario = $material['precio_unitario_nuevo'];
                        }
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();

                    } else { ////nuevo concepto generar nuevo nivel

                        $conceptoMaterial = Concepto::where('descripcion', '=', 'MATERIALES')->where('nivel', 'like', $concepto->nivel . '%')->first();
                        $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '%')->get();

                        $total = count($totalInsumos);
                        $ceros = 3 - strlen($total);
                        $nuevo_nivel = $conceptoMaterial->nivel . str_repeat("0", $ceros) . $total . '.';
                        $unidadMaterial = Material::select('unidad')->where('id_material', '=', $material->id_material)->first();
                        $dataNuevoInsumo = [
                            "id_material" => $material->id_material,
                            "id_obra" => Context::getId(),
                            "nivel" => $nuevo_nivel,
                            "descripcion" => $material->descripcion,
                            "unidad" => $unidadMaterial->unidad,
                            "cantidad_presupuestada" => $material->rendimiento_nuevo * $concepto->cantidad_presupuestada,
                            "monto_presupuestado" => ($material->rendimiento_nuevo * $concepto->cantidad_presupuestada) * $material->precio_unitario_nuevo,
                            "precio_unitario" => $material->precio_unitario_nuevo,

                        ];

                        $nuevoInsumo = \Ghi\Domain\Core\Models\Concepto::create($dataNuevoInsumo);
                        //  dd($nuevoInsumo);

                    }
                }

                foreach ($mano_obra as $manoObra) ////integracion materiales tarjeta nueva
                {
                    if ($manoObra->id_concepto) { ////actualizacion de concepto
                        $conceptoUpdate = Concepto::find($manoObra->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $manoObra['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($manoObra['precio_unitario_nuevo'] > 0) {
                            $conceptoUpdate->precio_unitario = $manoObra['precio_unitario_nuevo'];
                        }
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();

                    } else { ////nuevo concepto generar nuevo nivel

                        $conceptoMaterial = Concepto::where('descripcion', '=', 'MANO OBRA')->where('nivel', 'like', $concepto->nivel . '%')->first();
                        $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '%')->get();

                        $total = count($totalInsumos);
                        $ceros = 3 - strlen($total);
                        $nuevo_nivel = $conceptoMaterial->nivel . str_repeat("0", $ceros) . $total . '.';
                        $unidadMaterial = Material::select('unidad')->where('id_material', '=', $manoObra->id_material)->first();
                        $dataNuevoInsumo = [
                            "id_material" => $manoObra->id_material,
                            "id_obra" => Context::getId(),
                            "nivel" => $nuevo_nivel,
                            "descripcion" => $manoObra->descripcion,
                            "unidad" => $unidadMaterial->unidad,
                            "cantidad_presupuestada" => $manoObra->rendimiento_nuevo * $concepto->cantidad_presupuestada,
                            "monto_presupuestado" => ($manoObra->rendimiento_nuevo * $concepto->cantidad_presupuestada) * $manoObra->precio_unitario_nuevo,
                            "precio_unitario" => $manoObra->precio_unitario_nuevo,

                        ];

                        $nuevoInsumo = \Ghi\Domain\Core\Models\Concepto::create($dataNuevoInsumo);
                        //  dd($nuevoInsumo);

                    }
                }
                ///cambio nueva tarjeta

                foreach ($herramienta as $herram) ////integracion materiales tarjeta nueva
                {
                    if ($herram->id_concepto) { ////actualizacion de concepto
                        $conceptoUpdate = Concepto::find($herram->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $herram['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($herram['precio_unitario_nuevo'] > 0) {
                            $conceptoUpdate->precio_unitario = $herram['precio_unitario_nuevo'];
                        }
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();

                    } else { ////nuevo concepto generar nuevo nivel

                        $conceptoMaterial = Concepto::where('descripcion', '=', 'HERRAMIENTA Y EQUIPO')->where('nivel', 'like', $concepto->nivel . '%')->first();
                        $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '%')->get();

                        $total = count($totalInsumos);
                        $ceros = 3 - strlen($total);
                        $nuevo_nivel = $conceptoMaterial->nivel . str_repeat("0", $ceros) . $total . '.';
                        $unidadMaterial = Material::select('unidad')->where('id_material', '=', $herram->id_material)->first();
                        $dataNuevoInsumo = [
                            "id_material" => $herram->id_material,
                            "id_obra" => Context::getId(),
                            "nivel" => $nuevo_nivel,
                            "descripcion" => $herram->descripcion,
                            "unidad" => $unidadMaterial->unidad,
                            "cantidad_presupuestada" => $herram->rendimiento_nuevo * $concepto->cantidad_presupuestada,
                            "monto_presupuestado" => ($herram->rendimiento_nuevo * $concepto->cantidad_presupuestada) * $herram->precio_unitario_nuevo,
                            "precio_unitario" => $herram->precio_unitario_nuevo,

                        ];

                        $nuevoInsumo = \Ghi\Domain\Core\Models\Concepto::create($dataNuevoInsumo);
                        //  dd($nuevoInsumo);

                    }
                }

                foreach ($maquinaria as $maquina) ////integracion materiales tarjeta nueva
                {
                    if ($maquina->id_concepto) { ////actualizacion de concepto
                        $conceptoUpdate = Concepto::find($maquina->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $maquina['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($maquina['precio_unitario_nuevo'] > 0) {
                            $conceptoUpdate->precio_unitario = $maquina['precio_unitario_nuevo'];
                        }
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();

                    } else { ////nuevo concepto generar nuevo nivel

                        $conceptoMaterial = Concepto::where('descripcion', '=', 'MAQUINARIA')->where('nivel', 'like', $concepto->nivel . '%')->first();
                        $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '%')->get();

                        $total = count($totalInsumos);
                        $ceros = 3 - strlen($total);
                        $nuevo_nivel = $conceptoMaterial->nivel . str_repeat("0", $ceros) . $total . '.';
                        $unidadMaterial = Material::select('unidad')->where('id_material', '=', $maquina->id_material)->first();
                        $dataNuevoInsumo = [
                            "id_material" => $maquina->id_material,
                            "id_obra" => Context::getId(),
                            "nivel" => $nuevo_nivel,
                            "descripcion" => $maquina->descripcion,
                            "unidad" => $unidadMaterial->unidad,
                            "cantidad_presupuestada" => $maquina->rendimiento_nuevo * $concepto->cantidad_presupuestada,
                            "monto_presupuestado" => ($maquina->rendimiento_nuevo * $concepto->cantidad_presupuestada) * $maquina->precio_unitario_nuevo,
                            "precio_unitario" => $maquina->precio_unitario_nuevo,

                        ];

                        $nuevoInsumo = \Ghi\Domain\Core\Models\Concepto::create($dataNuevoInsumo);
                        //  dd($nuevoInsumo);

                    }
                }

                $conceptosNuevaTarjeta = Concepto::where('nivel', 'like', $concepto->nivel . '%')->get();
                foreach ($conceptosNuevaTarjeta as $conceptoNuevaTarjeta) {
                    //  $conceptoNuevaTarjeta->id_concepto;
                    $conceptoTarjetaUpdate = ConceptoTarjeta::where('id_concepto', '=', $conceptoNuevaTarjeta->id_concepto)->first();
                    if ($conceptoTarjetaUpdate) { //caso anteriores update
                        $conceptoTarjetaUpdate->id_tarjeta = $nuevaTarjeta->id;
                        $conceptoTarjetaUpdate->save();
                    } else { ///caso nuevos insert
                        ConceptoTarjeta::create(['id_concepto' => $conceptoNuevaTarjeta->id_concepto, 'id_tarjeta' => $nuevaTarjeta->id]);
                    }
                }

                ///////////Suma de montos a propagar
                $afectacion_mmonto_propagacion = 0;
                $conceptoMaterial = Concepto::where('descripcion', '=', 'MATERIALES')->where('nivel', 'like', $concepto->nivel . '%')->first();
                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado=$totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();


                $conceptoMaterial = Concepto::where('descripcion', '=', 'MANO OBRA')->where('nivel', 'like', $concepto->nivel . '%')->first();
                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado=$totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();

                $conceptoMaterial = Concepto::where('descripcion', '=', 'HERRAMIENTA Y EQUIPO')->where('nivel', 'like', $concepto->nivel . '%')->first();
                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado=$totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();

                $conceptoMaterial = Concepto::where('descripcion', '=', 'MAQUINARIA')->where('nivel', 'like', $concepto->nivel . '%')->first();
                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado=$totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();
                //dd($afectacion_mmonto_propagacion);

                //propagacion hacia arriba monto_presupuestado

                $tamanioFaltante = strlen($concepto->nivel);

                $monto_anterior= $concepto->monto_presupuestado;
                while ($tamanioFaltante > 0) { ///////////////recorrido todos los niveles hacia arriba
                    $afectaConcepto =Concepto::where('nivel', '=', substr($concepto->nivel, 0, $tamanioFaltante))->where('id_obra','=',Context::getId())->first();
                    $afectaConcepto->monto_presupuestado=($afectaConcepto->monto_presupuestado-$monto_anterior)+$afectacion_mmonto_propagacion ;
                    $afectaConcepto->save();
                    $tamanioFaltante -= 4;
                }

            }

            $solicitud = SolicitudCambio::find($id);
            $solicitud->id_estatus = Estatus::AUTORIZADA;
            $solicitud->save();
            $data = ["id_solicitud_cambio" => $id];
            $solicitudCambio = SolicitudCambioAutorizada::create($data);
            $solicitud = $this->model->find($id);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }


}







