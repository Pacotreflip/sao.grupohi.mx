<?php

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CambioCantidadInsumosRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TarjetaRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\ConceptoPath;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\CambioCantidadInsumos;
use Ghi\Domain\Core\Models\ControlPresupuesto\CambioInsumos;
use Ghi\Domain\Core\Models\ControlPresupuesto\FiltroCambioCantidadInsumo;
use Ghi\Domain\Core\Models\ControlPresupuesto\PartidasInsumosAgrupados;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartidaHistorico;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioRechazada;
use Ghi\Domain\Core\Models\ControlPresupuesto\Tarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoFiltro;
use Ghi\Domain\Core\Models\Material;
use Illuminate\Config\Repository;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;

class EloquentCambioCantidadInsumosRepository implements CambioCantidadInsumosRepository
{
    /**
     * @var CambioInsumos
     */
    private $model;
    /**
     * @var Repository
     */
    private $tarjeta;

    public function __construct(CambioCantidadInsumos $model, TarjetaRepository $tarjeta)
    {
        $this->model = $model;
        $this->tarjeta = $tarjeta;
    }

    /**
     * Obtiene todos los registros de CambioCantidadInsumos
     * @return CambioInsumos
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Regresa un registro específico de CambioCantidadInsumos
     * @param $id
     * @return CambioCantidadInsumos
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    public function with($relations)
    {
        $this->model->with($relations);
        return $this;
    }

    /**
     * Guarda un registro de CambioCantidadInsumos
     * @param array $data
     * @throws \Exception
     * @return CambioCantidadInsumos
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            if (!array_key_exists('insumos_eliminados', $data)) {
                $data['insumos_eliminados'] = array();
            }

            $solicitud = $this->model->create($data);
            $material = Material::find($data['filtro_agrupador']['id_material']);
            FiltroCambioCantidadInsumo::create(['id_solicitud_cambio' => $solicitud->id, 'id_tipo_filtro' => $data['filtro_agrupador']['id_tipo_filtro']]);

            foreach ($data['agrupacion'] as $index => $agrupado) {


                if ($agrupado['aplicar_todos'] || array_key_exists('items', $agrupado)) {

                    $cantidad_todos = $agrupado['cantidad_todos'];

                    if (array_key_exists('items', $agrupado)) { //puede ser que modifico precios a los items

                        foreach ($agrupado['items'] as $item) {
                            if ($item['agregado']=='true') {
                                $dataPartida = [];
                                $dataPartida['id_solicitud_cambio'] = $solicitud->id;
                                $dataPartida['id_tipo_orden'] = $data['id_tipo_orden'];
                                $dataPartida['id_concepto'] = $item['id_concepto'];
                                $dataPartida['descripcion'] = $material->descripcion . " m1";
                                $dataPartida['id_material'] = $material->id_material;
                                $dataPartida['nivel'] = $item['nivel'];
                                $dataPartida['precio_unitario_original'] = $item['precio_unitario'];
                                $dataPartida['precio_unitario_nuevo'] = $item['cantidad_nueva'];
                                $dataPartida['cantidad_presupuestada_original'] = $item['cantidad_presupuestada'];

                                SolicitudCambioPartida::create($dataPartida);

                            }
                        }
                    } else {
                        if ($agrupado['aplicar_todos'] == 'true') {
                            $dataConsulta = [];
                            $dataConsulta['precio'] = $agrupado['precio_unitario'];
                            $dataConsulta['id_material'] = $material->id_material;

                            switch ($data['filtro_agrupador']['id_tipo_filtro']) {
                                case TipoFiltro::SECTOR:
                                    $dataConsulta['columnaFiltro'] = ConceptoPath::COLUMN_SECTOR;
                                    break;
                                case TipoFiltro::CUADRANTE:
                                    $dataConsulta['columnaFiltro'] = ConceptoPath::COLUMN_CUADRANTE;
                                    break;
                                case TipoFiltro::TARJETA:
                                    $dataConsulta['columnaFiltro'] = "ControlPresupuesto.tarjeta.descripcion";
                                    break;
                                default:
                                    break;
                            }
                            $dataConsulta['descripcion'] = $agrupado['agrupador'];
                            $result = $this->getExplosionAgrupados($dataConsulta);
                            foreach ($result as $item) {
                                $dataPartida = [];
                                $dataPartida['id_solicitud_cambio'] = $solicitud->id;
                                $dataPartida['id_tipo_orden'] = $data['id_tipo_orden'];
                                $dataPartida['id_concepto'] = $item->id_concepto;
                                $dataPartida['descripcion'] = $material->descripcion . ' m2';
                                $dataPartida['id_material'] = $material->id_material;
                                $dataPartida['nivel'] = $item->nivel;
                                $dataPartida['precio_unitario_original'] = $item->precio_unitario;
                                $dataPartida['precio_unitario_nuevo'] = $agrupado['cantidad_todos'];
                                $dataPartida['cantidad_presupuestada_original'] = $item->cantidad_presupuestada;


                                SolicitudCambioPartida::create($dataPartida);

                            }
                        }
                    }

                }
            }
            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch
        (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }


    }

    public function getAgrupacionFiltroPartidas(array $data)
    {

        $agrupacion = Tarjeta::select(
            DB::raw($data['columnaFiltro'] . ' as agrupador, c.precio_unitario_original, COUNT(1) as cantidad,c.id_material')
        )
            ->join('ControlPresupuesto.concepto_tarjeta as ct', 'ControlPresupuesto.tarjeta.id', '=', 'ct.id_tarjeta')
            ->join('ControlPresupuesto.solicitud_cambio_partidas as c', 'c.id_concepto ', '=', 'ct.id_concepto')
            ->join('PresupuestoObra.conceptosPath as cp', 'cp.id_concepto', '=', 'c.id_concepto')
            ->where('c.id_solicitud_cambio', '=', $data['id_solicitud'])
            ->groupBy($data['columnaFiltro'], 'c.precio_unitario_original', 'c.id_material')
            ->get();
        $solicitud = SolicitudCambio::find($data['id_solicitud']);

        foreach ($agrupacion as $agrupado) {


            $agrupado['aplicar_todos'] = false;
            $agrupado['cantidad_todos'] = 0;
            $agrupado['items'] = [];
            $agrupado['mostrar_detalle'] = true;


            $dataExplocion['id_material'] = $agrupado['id_material'];
            $dataExplocion['precio'] = $agrupado['precio_unitario_original'];
            $dataExplocion['descripcion'] = $agrupado['agrupador'];
            $dataExplocion['columnaFiltro'] = $data['columnaFiltro'];
            $dataExplocion['id_solicitud'] = $data['id_solicitud'];
            $agrupadosPartidas = $this->getExplosionAgrupadosPartidas($dataExplocion);
            $imp_original = 0;
            $imo_actualizado = 0;
            foreach ($agrupadosPartidas as $partAgrupada) {

                if ($solicitud->id_estatus == Estatus::AUTORIZADA) {//datos de historico
                    $cant_pres_hist=(SolicitudCambioPartidaHistorico::where('id_solicitud_cambio_partida','=',$partAgrupada->id_solicitud_cambio_partida)->first()->cantidad_presupuestada_original);
                    $imp_original += ($cant_pres_hist) * $partAgrupada->precio_unitario_original;
                    $imo_actualizado += ($cant_pres_hist) * $partAgrupada->precio_unitario_nuevo;


                } else {
                    $cant_pres_sol=(Concepto::find($partAgrupada->id_concepto)->cantidad_presupuestada);
                    $imp_original =$imp_original+(($cant_pres_sol) * $partAgrupada->precio_unitario_original);
                    $imo_actualizado =$imo_actualizado+(($cant_pres_sol) * $partAgrupada->precio_unitario_nuevo);
                }
            }
            $agrupado['importe_original'] = $imp_original;
            $agrupado['importe_actualizado'] = $imo_actualizado;

        }

        return $agrupacion;

    }

    public function getAgrupacionFiltro(array $data)
    {

        $agrupacion = Tarjeta::select(
            DB::raw($data['columnaFiltro'] . ' as agrupador, c.precio_unitario, COUNT(1) as cantidad')
        )
            ->join('ControlPresupuesto.concepto_tarjeta as ct', 'ControlPresupuesto.tarjeta.id', '=', 'ct.id_tarjeta')
            ->join('dbo.conceptos as c', 'c.id_concepto ', '=', 'ct.id_concepto')
            ->join('PresupuestoObra.conceptosPath as cp', 'cp.id_concepto', '=', 'c.id_concepto')
            ->where('c.id_material', '=', $data['id_material'])
            ->whereIn('c.precio_unitario', $data['precios'])
            ->groupBy($data['columnaFiltro'], 'c.precio_unitario')
            ->get();
        foreach ($agrupacion as $agrupado) {
            $agrupado['aplicar_todos'] = false;
            $agrupado['cantidad_todos'] = 0;
            $agrupado['items'] = [];
            $agrupado['mostrar_detalle'] = true;
        }

        return $agrupacion;

    }

    public function getExplosionAgrupados(array $data)
    {

        $agrupacion = Tarjeta::select(
            DB::raw('cp.*,c.id_concepto,c.precio_unitario,c.cantidad_presupuestada')
        )
            ->join('ControlPresupuesto.concepto_tarjeta as ct', 'ControlPresupuesto.tarjeta.id', '=', 'ct.id_tarjeta')
            ->join('dbo.conceptos as c', 'c.id_concepto ', '=', 'ct.id_concepto')
            ->join('PresupuestoObra.conceptosPath as cp', 'cp.id_concepto', '=', 'c.id_concepto')
            ->where('c.id_material', '=', $data['id_material'])
            ->where('c.precio_unitario', '=', $data['precio'])
            ->where($data['columnaFiltro'], '=', $data['descripcion'])
            ->get();

        foreach ($agrupacion as $agrupado) {
            $agrupado['cantidad_nueva'] = 0;
            $agrupado['agregado'] = false;
        }


        return $agrupacion;

    }

    public function getExplosionAgrupadosPartidas(array $data)
    {

        $agrupacion = Tarjeta::select(
            DB::raw('cp.*,c.id_concepto,c.precio_unitario_original,c.precio_unitario_nuevo,c.id as id_solicitud_cambio_partida,t.descripcion as tarjeta')
        )
            ->join('ControlPresupuesto.concepto_tarjeta as ct', 'ControlPresupuesto.tarjeta.id', '=', 'ct.id_tarjeta')
            ->join('ControlPresupuesto.solicitud_cambio_partidas as c', 'c.id_concepto ', '=', 'ct.id_concepto')
            ->join('PresupuestoObra.conceptosPath as cp', 'cp.id_concepto', '=', 'c.id_concepto')
            ->join('ControlPresupuesto.Tarjeta as t', 'ControlPresupuesto.tarjeta.id', '=', 't.id')

            ->where('c.id_material', '=', $data['id_material'])
            ->where('c.precio_unitario_original', '=', $data['precio'])
            ->where($data['columnaFiltro'], '=', $data['descripcion'])
            ->where('c.id_solicitud_cambio', '=', $data['id_solicitud'])
            ->get();
        foreach ($agrupacion as $agrupado) {
            $agrupado['cantidad_nueva'] = 0;
            $agrupado['agregado'] = false;
        }


        return $agrupacion;

    }

    /**
     * Rechaza una CambioInsumos
     * @param array $data
     * @throws \Exception
     * @return CambioInsumos
     */
    public function rechazar(array $data)
    {
        try {

            DB::connection('cadeco')->beginTransaction();
            $solicitud = $this->model->find($data['id_solicitud_cambio']);

            if (is_null($solicitud))
                throw new HttpResponseException(new Response('No existe la solicitud a rechazar', 404));

            // La solicitud ya está rechazada
            if ($solicitud->id_estatus == Estatus::RECHAZADA)
                throw new HttpResponseException(new Response('La solicitud ya está rechazada', 404));

            $solicitud->id_estatus = Estatus::RECHAZADA;
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

    public function getAfectacionesSolicitud($id)
    {
        $solicitud = $this->find($id);
        $cantidad_anterior = 0;
        $cantidad_nueva = 0;
        $conceptos = 0;
        $presupuesto = Concepto::where('nivel', '=', '000.001.')->where('id_obra', '=', Context::getId())->first();
        $data = [];
        foreach ($solicitud->partidas as $partida) {
            $concepto = Concepto::find($partida->id_concepto);

            if ($solicitud->id_estatus == Estatus::AUTORIZADA) {

                $cantidad_anterior += $partida->cantidad_presupuestada_original * $partida->precio_unitario_original;
                $cantidad_nueva += $partida->cantidad_presupuestada_original * $partida->precio_unitario_nuevo;

            } else {
                $cantidad_anterior += $concepto->monto_presupuestado;
                $cantidad_nueva += ($concepto->cantidad_presupuestada * $partida->precio_unitario_nuevo);

            }
            $conceptos++;
        }

        $data['conceptos_modificados'] = $conceptos;
        $data['imp_conceptos_modif'] = $cantidad_anterior;
        $data['imp_variacion'] = $cantidad_nueva - $cantidad_anterior;
        $data['imp_conceptos_actualizados'] = $cantidad_nueva;
        $data['imp_pres_original'] = $presupuesto->monto_presupuestado;
        $data['imp_pres_actualizado'] = ($presupuesto->monto_presupuestado) + ($data['imp_variacion']);

        if ($solicitud->id_estatus == Estatus::AUTORIZADA) {
            $historico_original = SolicitudCambioPartidaHistorico::select(
                DB::raw('min(ControlPresupuesto.solicitud_cambio_partidas_historico.id) as id_maximo')
            )
                ->join('ControlPresupuesto.solicitud_cambio_partidas as cp', 'cp.id', '=', 'ControlPresupuesto.solicitud_cambio_partidas_historico.id_solicitud_cambio_partida')
                ->where('cp.id_solicitud_cambio', '=', $id)
                ->where('ControlPresupuesto.solicitud_cambio_partidas_historico.nivel', '=', $presupuesto->nivel)
                ->first();

            $historico_nueva = SolicitudCambioPartidaHistorico::select(
                DB::raw('max(ControlPresupuesto.solicitud_cambio_partidas_historico.id) as id_maximo')
            )
                ->join('ControlPresupuesto.solicitud_cambio_partidas as cp', 'cp.id', '=', 'ControlPresupuesto.solicitud_cambio_partidas_historico.id_solicitud_cambio_partida')
                ->where('cp.id_solicitud_cambio', '=', $id)
                ->where('ControlPresupuesto.solicitud_cambio_partidas_historico.nivel', '=', $presupuesto->nivel)
                ->first();

            $solHist =

                // dd($solHist);
                //  $data['imp_variacion'] = $historico->monto_actualizado - $historico->monto_original;
            $data['imp_pres_original'] = SolicitudCambioPartidaHistorico::find($historico_original->id_maximo)->monto_presupuestado_original;
            $data['imp_pres_actualizado'] = SolicitudCambioPartidaHistorico::find($historico_nueva->id_maximo)->monto_presupuestado_actualizado;
        }

        return $data;

    }

    public function autorizar($id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $solicitud = SolicitudCambio::find($id);
            if (is_null($solicitud))
                throw new HttpResponseException(new Response('No existe la solicitud a autorizar', 404));

            $partidas = SolicitudCambioPartida::where('id_solicitud_cambio', '=', $id)->get();
            foreach ($partidas as $partida) {
                $concepto_original = Concepto::find($partida->id_concepto);
                $concepto_actualizado = $this->cambioPresioConcepto($partida->id_concepto, $partida->precio_unitario_nuevo);
                SolicitudCambioPartidaHistorico::create([
                    'id_solicitud_cambio_partida' => $partida->id,
                    'id_base_presupuesto' => 1,
                    'nivel' => $partida->nivel,
                    'cantidad_presupuestada_original' => $concepto_original->cantidad_presupuestada,
                    'monto_presupuestado_original' => $concepto_original->monto_presupuestado,
                    'monto_presupuestado_actualizado' => $concepto_actualizado->monto_presupuestado
                ]);
                if (!$this->propagarMontosHaciaArriba($partida->nivel, $partida->id, $concepto_original->monto_presupuestado, $concepto_actualizado->monto_presupuestado)) {
                    throw new HttpResponseException(new Response('No se pudo completar la propagacion de los montos', 404));
                }

            }
            $solicitud->id_estatus = \Ghi\Domain\Core\Models\ControlPresupuesto\Estatus::AUTORIZADA;
            $solicitud->save();
            $data['id_solicitud_cambio'] = $id;
            $solicitudCambio = SolicitudCambioAutorizada::create($data);
            $solicitud = $this->model->find($id);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    public function cambioPresioConcepto($id_concepto, $precio_unitario)
    {
        $concepto = Concepto::find($id_concepto);
        $concepto->precio_unitario = $precio_unitario;
        $concepto->monto_presupuestado = ($precio_unitario) * $concepto->cantidad_presupuestada;
        $concepto->update();
        return $concepto;
    }

    public function propagarMontosHaciaArriba($nivel_inicial, $id_partida, $monto_anterior, $monto_nuevo)
    {
        $tamanioFaltante = strlen($nivel_inicial);
        $afectacionConcepto = 0;
        while ($tamanioFaltante > 0) { ///////////////recorrido todos los niveles hacia arriba
            $conceptoAfectado = Concepto::where('id_obra', '=', Context::getId())->where('nivel', '=', substr($nivel_inicial, 0, $tamanioFaltante))->first();
            $monto_presupuestado_original = 0;
            if ($afectacionConcepto > 0) {///afectamos el concepto de la solicitud
                $monto_presupuestado_original = $conceptoAfectado->monto_presupuestado;
                $conceptoAfectado->monto_presupuestado = ($conceptoAfectado->monto_presupuestado - $monto_anterior) + $monto_nuevo;
                SolicitudCambioPartidaHistorico::create([
                    'id_solicitud_cambio_partida' => $id_partida,
                    'id_base_presupuesto' => 2,
                    'nivel' => $conceptoAfectado->nivel,
                    'monto_presupuestado_original' => $monto_presupuestado_original,
                    'monto_presupuestado_actualizado' => $conceptoAfectado->monto_presupuestado
                ]);

                $conceptoAfectado->update();
            }
            $afectacionConcepto++;
            $tamanioFaltante -= 4;
        }
        return true;
    }


}