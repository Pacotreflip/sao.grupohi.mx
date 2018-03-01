<?php

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\AfectacionOrdenPresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CambioInsumosRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PartidasInsumosAgrupadosRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\ConceptoPath;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoTarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\PartidasInsumosAgrupados;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartidaHistorico;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioRechazada;
use Ghi\Domain\Core\Models\ControlPresupuesto\Tarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Ghi\Domain\Core\Models\ControlPresupuesto\CambioInsumos;
use Ghi\Domain\Core\Models\Material;
use Ghi\Domain\Core\Models\Seguridad\Proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Config\Repository;
use Ghi\Domain\Core\Models\Obra;
use Ghi\Domain\Core\Models\User;
use Ghi\Domain\Core\Models\UsuarioCadeco;
use Illuminate\Support\Facades\View;

class EloquentCambioInsumosRepository implements CambioInsumosRepository
{
    /**
     * @var CambioInsumos
     */
    private $model;
    /**
     * @var Repository
     */
    private $config;
    private $partidas;
    private $afectacion;
    private $agrupacion;

    /**
     * EloquentSolicitudCambioRepository constructor.
     * @param CambioInsumos $model
     */
    public function __construct(CambioInsumos $model, Repository $config, SolicitudCambioPartidaRepository $partidas, AfectacionOrdenPresupuestoRepository $afectacion, PartidasInsumosAgrupadosRepository $agrupacion)
    {
        $this->model = $model;
        $this->config = $config;
        $this->partidas = $partidas;
        $this->afectacion = $afectacion;
        $this->agrupacion = $agrupacion;
    }

    /**
     * Obtiene todos los registros de CambioInsumos
     * @return CambioInsumos
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Regresa las Variaciones de Volúmen Paginadas
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $data)
    {
        $query = $this->model->with(['tipoOrden', 'userRegistro', 'estatus']);
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * Guarda un registro de CambioInsumos
     * @param array $data
     * @throws \Exception
     * @return CambioInsumos
     */
    public function create(array $data)
    {
        try {

            // dd($data);
            DB::connection('cadeco')->beginTransaction();
            if(!array_key_exists('insumos_eliminados',$data)){
                $data['insumos_eliminados']=array();
            }

            $solicitud = $this->model->create($data);

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
                            if (in_array($material['id_concepto'], $data['insumos_eliminados'])) {
                                $material['rendimiento_nuevo'] = 0;
                            }

                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $material['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $material['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }
                        $material['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $material['tipo_agrupador'] = 1;
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
                            if (in_array($mano['id_concepto'], $data['insumos_eliminados'])) {
                                $mano['rendimiento_nuevo'] = 0;
                            }
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
                        $mano['tipo_agrupador'] = 2;
                        if (array_key_exists('precio_unitario_nuevo', $mano) || array_key_exists('rendimiento_nuevo', $mano)) {
                            SolicitudCambioPartida::create($mano);
                        }
                    }
                }
                ////////impacto Herramienta y equipo
                if (array_key_exists('insumos', $partida['conceptos']['HERRAMIENTAYEQUIPO'])) {
                    foreach ($partida['conceptos']['HERRAMIENTAYEQUIPO']['insumos'] as $herramienta) {
                        if (isset($herramienta['id_concepto'])) {
                            if (in_array($herramienta['id_concepto'], $data['insumos_eliminados'])) {
                                $herramienta['rendimiento_nuevo'] = 0;
                            }
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
                        $herramienta['tipo_agrupador'] = 4;
                        if (array_key_exists('precio_unitario_nuevo', $herramienta) || array_key_exists('rendimiento_nuevo', $herramienta)) {
                            SolicitudCambioPartida::create($herramienta);
                        }
                    }
                }

                ////////impacto Maquinaria

                if (array_key_exists('insumos', $partida['conceptos']['MAQUINARIA'])) {
                    foreach ($partida['conceptos']['MAQUINARIA']['insumos'] as $maquinaria) {
                        if (isset($maquinaria['id_concepto'])) {
                            if (in_array($maquinaria['id_concepto'], $data['insumos_eliminados'])) {
                                $maquinaria['rendimiento_nuevo'] = 0;
                            }
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
                        $maquinaria['tipo_agrupador'] = 8;
                        if (array_key_exists('precio_unitario_nuevo', $maquinaria) || array_key_exists('rendimiento_nuevo', $maquinaria)) {
                            SolicitudCambioPartida::create($maquinaria);
                        }


                    }
                }

                ////////impacto Subcontratos

                if (array_key_exists('insumos', $partida['conceptos']['SUBCONTRATOS'])) {


                    foreach ($partida['conceptos']['SUBCONTRATOS']['insumos'] as $subcontrato) {
                        //    dd("subcontratos",$subcontrato);
                        if (isset($subcontrato['id_concepto'])) {
                            if (in_array($subcontrato['id_concepto'], $data['insumos_eliminados'])) {
                                $subcontrato['rendimiento_nuevo'] = 0;
                            }
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $subcontrato['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $subcontrato['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }


                        $subcontrato['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $subcontrato['id_solicitud_cambio'] = $solicitud->id;
                        $subcontrato['precio_unitario_original'] = $subcontrato['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $subcontrato) ? $subcontrato['precio_unitario_nuevo'] = $subcontrato['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $subcontrato) ? $subcontrato['rendimiento_nuevo'] = $subcontrato['rendimiento_nuevo'] : '';
                        $subcontrato['rendimiento_original'] = $subcontrato['rendimiento_actual'];
                        $subcontrato['tipo_agrupador'] = 5;
                        if (array_key_exists('precio_unitario_nuevo', $subcontrato) || array_key_exists('rendimiento_nuevo', $subcontrato)) {
                            SolicitudCambioPartida::create($subcontrato);
                        }


                    }
                }

                ////////impacto Subcontratos

                if (array_key_exists('insumos', $partida['conceptos']['GASTOS'])) {
                    foreach ($partida['conceptos']['GASTOS']['insumos'] as $gasto) {
                        if (isset($gasto['id_concepto'])) {
                            if (in_array($gasto['id_concepto'], $data['insumos_eliminados'])) {
                                $gasto['rendimiento_nuevo'] = 0;
                            }
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $gasto['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $gasto['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }
                        $gasto['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $gasto['id_solicitud_cambio'] = $solicitud->id;
                        $gasto['precio_unitario_original'] = $gasto['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $gasto) ? $gasto['precio_unitario_nuevo'] = $gasto['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $gasto) ? $gasto['rendimiento_nuevo'] = $gasto['rendimiento_nuevo'] : '';
                        $gasto['rendimiento_original'] = $gasto['rendimiento_actual'];
                        $gasto['tipo_agrupador'] = 6;
                        if (array_key_exists('precio_unitario_nuevo', $gasto) || array_key_exists('rendimiento_nuevo', $gasto)) {
                            SolicitudCambioPartida::create($gasto);
                        }


                    }
                }
            }
            $solicitud = $this->with('partidas')->find($solicitud->id);
            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch
        (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }


    }

    /**
     * Guarda un registro de CambioInsumos
     * @param array $data
     * @throws \Exception
     * @return CambioInsumos
     */
    public function createIndirecto(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
           if(!array_key_exists('insumos_eliminados',$data)){
               $data['insumos_eliminados']=array();
           }

            $solicitud = $this->model->create($data);

            $partidaInsumo['id_solicitud_cambio'] = $solicitud->id;
            $partidaInsumo['concepto_seleccionado'] = $data['concepto_seleccionado']['id'];
            $partidaInsumo['id_concepto'] = $data['concepto_seleccionado']['id_concepto'];

            PartidasInsumosAgrupados::create($partidaInsumo);

            $cantidad_presupuestada_concepto = $data['concepto_seleccionado']['cantidad_presupuestada'];

            foreach ($data['partidas'] as $gasto) {


                if (isset($gasto['id_concepto'])) {
                    if (in_array($gasto['id_concepto'], $data['insumos_eliminados'])) {
                        $gasto['rendimiento_nuevo'] = 0;
                    }

                    $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $gasto['id_concepto'])->first();
                    if ($conceptoTarjeta) {
                        $gasto['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                    }
                }
                $gasto['monto_presupuestado'] = $cantidad_presupuestada_concepto;
                $gasto['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                $gasto['id_solicitud_cambio'] = $solicitud->id;
                $gasto['precio_unitario_original'] = $gasto['precio_unitario'];

                //  dd(strlen($gasto['precio_unitario_nuevo']));
                strlen($gasto['precio_unitario_nuevo']) > 0 ? $gasto['precio_unitario_nuevo'] = $gasto['precio_unitario_nuevo'] : $gasto['precio_unitario_nuevo'] = NULL;
                strlen($gasto['rendimiento_nuevo']) > 0 ? $gasto['rendimiento_nuevo'] = $gasto['rendimiento_nuevo'] : $gasto['rendimiento_nuevo'] = NULL;
                $gasto['rendimiento_original'] = $gasto['rendimiento_actual'];
                $gasto['tipo_agrupador'] = 6;
                if (strlen($gasto['precio_unitario_nuevo']) > 0 || strlen($gasto['rendimiento_nuevo']) > 0) {
                    SolicitudCambioPartida::create($gasto);
                }


            }
            $solicitud = $this->with('partidas')->find($solicitud->id);
            DB::connection('cadeco')->commit();
            //  dd($solicitud);

            return $solicitud;
        } catch
        (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }


    }

    /**
     * Regresa un registro específico de CambioInsumos
     * @param $id
     * @return CambioInsumos
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
     * Autoriza una CambioInsumos
     * @param $id
     * @param array $data
     * @return CambioInsumos
     * @throws \Exception
     */
    public function autorizar($id, array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $sumas_insumos = 0;

            $insumosAgrupados = PartidasInsumosAgrupados::where('id_solicitud_cambio', '=', $id)->get();
            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $insumosAgrupados[0]->id_concepto)->first();

            if ($conceptoTarjeta != null) {
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
            }

            foreach ($insumosAgrupados as $insumo) {

                $partidas = SolicitudCambioPartida::with('material')->where('id_solicitud_cambio', '=', $id)->get();
                $concepto = Concepto::find($insumo['id_concepto']);

                $materiales = [];
                $mano_obra = [];
                $herramienta = [];
                $maquinaria = [];
                $subcontratos = [];
                $gastos = [];

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


                    $conceptoReset = Concepto::where('nivel', 'like', $concepto->nivel . '%')->where('id_obra', '=', Context::getId())->where('id_material', '=', $partida->id_material)->first();
                    if ($conceptoReset) {
                        $partida->id_concepto = $conceptoReset->id_concepto;
                    }
                    switch ($partida->tipo_agrupador) {
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
                        case 5:/// Maquinaria
                            array_push($subcontratos, $partida);
                            break;
                        case 6:/// Maquinaria
                            array_push($gastos, $partida);
                            break;
                    }


                }


                foreach ($materiales as $material) ////integracion materiales tarjeta nueva
                {

                    if ($material->id_concepto) { ////actualizacion de concepto
                        $dataHist = [];
                        $conceptoUpdate = Concepto::find($material->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $material['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($material['precio_unitario_nuevo'] > 0) {
                            $dataHist['precio_unitario_original'] = $conceptoUpdate->precio_unitario;
                            $conceptoUpdate->precio_unitario = $material['precio_unitario_nuevo'];
                            $dataHist['precio_unitario_actualizado'] = $conceptoUpdate->precio_unitario;
                        }

                        $dataHist['monto_presupuestado_original'] = $conceptoUpdate->monto_presupuestado;
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();
                        $dataHist['monto_presupuestado_actualizado'] = $conceptoUpdate->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $material->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $conceptoUpdate->nivel;
                        $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);


                    } else { ////nuevo concepto generar nuevo nivel
                        $dataHist = [];
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
                        $this->insertarPath($nuevoInsumo->id_concepto);
                        $dataHist['precio_unitario_original'] = 0;
                        $dataHist['precio_unitario_actualizado'] = $nuevoInsumo->precio_unitario;
                        $dataHist['monto_presupuestado_original'] = 0;
                        $dataHist['monto_presupuestado_actualizado'] = $nuevoInsumo->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $material->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $nuevoInsumo->nivel;
                        $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);


                        //  dd($nuevoInsumo);

                    }
                }

                foreach ($mano_obra as $manoObra) ////integracion materiales tarjeta nueva
                {
                    if ($manoObra->id_concepto) { ////actualizacion de concepto
                        $dataHist = [];
                        $conceptoUpdate = Concepto::find($manoObra->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $manoObra['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($manoObra['precio_unitario_nuevo'] > 0) {
                            $dataHist['precio_unitario_original'] = $conceptoUpdate->precio_unitario;
                            $conceptoUpdate->precio_unitario = $manoObra['precio_unitario_nuevo'];
                            $dataHist['precio_unitario_actualizado'] = $conceptoUpdate->precio_unitario;
                        }

                        $dataHist['monto_presupuestado_original'] = $conceptoUpdate->monto_presupuestado;
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();

                        $dataHist['monto_presupuestado_actualizado'] = $conceptoUpdate->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $manoObra->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $conceptoUpdate->nivel;
                        $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);

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
                        $this->insertarPath($nuevoInsumo->id_concepto);
                        $dataHist = [];
                        $dataHist['precio_unitario_original'] = 0;
                        $dataHist['precio_unitario_actualizado'] = $nuevoInsumo->precio_unitario;
                        $dataHist['monto_presupuestado_original'] = 0;
                        $dataHist['monto_presupuestado_actualizado'] = $nuevoInsumo->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $manoObra->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $nuevoInsumo->nivel;
                        $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);

                    }
                }
                ///cambio nueva tarjeta

                foreach ($herramienta as $herram) ////integracion materiales tarjeta nueva
                {
                    if ($herram->id_concepto) { ////actualizacion de concepto
                        $dataHist = [];
                        $conceptoUpdate = Concepto::find($herram->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $herram['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($herram['precio_unitario_nuevo'] > 0) {
                            $dataHist['precio_unitario_original'] = $conceptoUpdate->precio_unitario;
                            $conceptoUpdate->precio_unitario = $herram['precio_unitario_nuevo'];
                            $dataHist['precio_unitario_actualizado'] = $conceptoUpdate->precio_unitario;
                        }

                        $dataHist['monto_presupuestado_original'] = $conceptoUpdate->monto_presupuestado;
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();

                        $dataHist['monto_presupuestado_actualizado'] = $conceptoUpdate->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $herram->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $conceptoUpdate->nivel;
                        $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);

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
                        $this->insertarPath($nuevoInsumo->id_concepto);
                        $dataHist = [];
                        $dataHist['precio_unitario_original'] = 0;
                        $dataHist['precio_unitario_actualizado'] = $nuevoInsumo->precio_unitario;
                        $dataHist['monto_presupuestado_original'] = 0;
                        $dataHist['monto_presupuestado_actualizado'] = $nuevoInsumo->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $herram->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $nuevoInsumo->nivel;
                        $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);

                    }
                }

                foreach ($maquinaria as $maquina) ////integracion materiales tarjeta nueva
                {
                    if ($maquina->id_concepto) { ////actualizacion de concepto
                        $dataHist = [];
                        $conceptoUpdate = Concepto::find($maquina->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $maquina['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($maquina['precio_unitario_nuevo'] > 0) {
                            $dataHist['precio_unitario_original'] = $conceptoUpdate->precio_unitario;
                            $conceptoUpdate->precio_unitario = $maquina['precio_unitario_nuevo'];
                            $dataHist['precio_unitario_actualizado'] = $conceptoUpdate->precio_unitario;
                        }

                        $dataHist['monto_presupuestado_original'] = $conceptoUpdate->monto_presupuestado;
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();
                        $dataHist['monto_presupuestado_actualizado'] = $conceptoUpdate->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $maquina->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $conceptoUpdate->nivel;
                        $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);

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
                        $this->insertarPath($nuevoInsumo->id_concepto);
                        $dataHist = [];
                        $dataHist['precio_unitario_original'] = 0;
                        $dataHist['precio_unitario_actualizado'] = $nuevoInsumo->precio_unitario;
                        $dataHist['monto_presupuestado_original'] = 0;
                        $dataHist['monto_presupuestado_actualizado'] = $nuevoInsumo->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $maquina->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $nuevoInsumo->nivel;
                        $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);
                    }
                }

////////////subcontratos
///

                foreach ($subcontratos as $subcontrato) ////integracion materiales tarjeta nueva
                {
                    if ($subcontrato->id_concepto) { ////actualizacion de concepto
                        $dataHist = [];
                        $conceptoUpdate = Concepto::find($subcontrato->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $subcontrato['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($subcontrato['precio_unitario_nuevo'] > 0) {
                            $dataHist['precio_unitario_original'] = $conceptoUpdate->precio_unitario;
                            $conceptoUpdate->precio_unitario = $subcontrato['precio_unitario_nuevo'];
                            $dataHist['precio_unitario_actualizado'] = $conceptoUpdate->precio_unitario;
                        }

                        $dataHist['monto_presupuestado_original'] = $conceptoUpdate->monto_presupuestado;
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();
                        $dataHist['monto_presupuestado_actualizado'] = $conceptoUpdate->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $subcontrato->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $conceptoUpdate->nivel;
                        $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);

                    } else { ////nuevo concepto generar nuevo nivel

                        $conceptoMaterial = Concepto::where('descripcion', '=', 'SUBCONTRATOS')->where('nivel', 'like', $concepto->nivel . '%')->first();
                        $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '%')->get();

                        $total = count($totalInsumos);
                        $ceros = 3 - strlen($total);
                        $nuevo_nivel = $conceptoMaterial->nivel . str_repeat("0", $ceros) . $total . '.';
                        $unidadMaterial = Material::select('unidad')->where('id_material', '=', $subcontrato->id_material)->first();
                        $dataNuevoInsumo = [
                            "id_material" => $subcontrato->id_material,
                            "id_obra" => Context::getId(),
                            "nivel" => $nuevo_nivel,
                            "descripcion" => $subcontrato->descripcion,
                            "unidad" => $unidadMaterial->unidad,
                            "cantidad_presupuestada" => $subcontrato->rendimiento_nuevo * $concepto->cantidad_presupuestada,
                            "monto_presupuestado" => ($subcontrato->rendimiento_nuevo * $concepto->cantidad_presupuestada) * $subcontrato->precio_unitario_nuevo,
                            "precio_unitario" => $subcontrato->precio_unitario_nuevo,

                        ];

                        $nuevoInsumo = \Ghi\Domain\Core\Models\Concepto::create($dataNuevoInsumo);

                        $this->insertarPath($nuevoInsumo->id_concepto);
                        $dataHist = [];
                        $dataHist['precio_unitario_original'] = 0;
                        $dataHist['precio_unitario_actualizado'] = $nuevoInsumo->precio_unitario;
                        $dataHist['monto_presupuestado_original'] = 0;
                        $dataHist['monto_presupuestado_actualizado'] = $nuevoInsumo->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $subcontrato->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $nuevoInsumo->nivel;
                        $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);
                    }
                }

                ////////////gastos
                foreach ($gastos as $gasto) ////integracion materiales tarjeta nueva
                {
                    if ($gasto->id_concepto) { ////actualizacion de concepto
                        $dataHist = [];
                        $conceptoUpdate = Concepto::find($gasto->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $gasto['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($gasto['precio_unitario_nuevo'] > 0) {
                            $dataHist['precio_unitario_original'] = $conceptoUpdate->precio_unitario;
                            $conceptoUpdate->precio_unitario = $gasto['precio_unitario_nuevo'];
                            $dataHist['precio_unitario_actualizado'] = $conceptoUpdate->precio_unitario;
                        }

                        $dataHist['monto_presupuestado_original'] = $conceptoUpdate->monto_presupuestado;
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();
                        $dataHist['monto_presupuestado_actualizado'] = $conceptoUpdate->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $gasto->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $conceptoUpdate->nivel;
                        $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);

                    } else { ////nuevo concepto generar nuevo nivel

                        $conceptoMaterial = Concepto::where('descripcion', '=', 'GASTOS')->where('nivel', 'like', $concepto->nivel . '%')->first();
                        $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '%')->get();

                        $total = count($totalInsumos);
                        $ceros = 3 - strlen($total);
                        $nuevo_nivel = $conceptoMaterial->nivel . str_repeat("0", $ceros) . $total . '.';
                        $unidadMaterial = Material::select('unidad')->where('id_material', '=', $gasto->id_material)->first();
                        $dataNuevoInsumo = [
                            "id_material" => $gasto->id_material,
                            "id_obra" => Context::getId(),
                            "nivel" => $nuevo_nivel,
                            "descripcion" => $gasto->descripcion,
                            "unidad" => $unidadMaterial->unidad,
                            "cantidad_presupuestada" => $gasto->rendimiento_nuevo * $concepto->cantidad_presupuestada,
                            "monto_presupuestado" => ($gasto->rendimiento_nuevo * $concepto->cantidad_presupuestada) * $gasto->precio_unitario_nuevo,
                            "precio_unitario" => $gasto->precio_unitario_nuevo,

                        ];

                        $nuevoInsumo = \Ghi\Domain\Core\Models\Concepto::create($dataNuevoInsumo);
                        $this->insertarPath($nuevoInsumo->id_concepto);
                        $dataHist = [];
                        $dataHist['precio_unitario_original'] = 0;
                        $dataHist['precio_unitario_actualizado'] = $nuevoInsumo->precio_unitario;
                        $dataHist['monto_presupuestado_original'] = 0;
                        $dataHist['monto_presupuestado_actualizado'] = $nuevoInsumo->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $gasto->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $nuevoInsumo->nivel;
                        $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);
                    }
                }


                if ($conceptoTarjeta != null) {
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
                }

                ///////////Suma de montos a propagar
                ///
                $dataHist = [];
                $afectacion_mmonto_propagacion = 0;
                $conceptoMaterial = Concepto::where('descripcion', '=', 'MATERIALES')->where('nivel', 'like', $concepto->nivel . '%')->first();

                $dataHist['precio_unitario_original'] = $conceptoMaterial->precio_unitario;
                $dataHist['monto_presupuestado_original'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['precio_unitario_actualizado'] = $conceptoMaterial->precio_unitario;
                $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;

                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado = $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();

                $dataHist['monto_presupuestado_actualizado'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['id_base_presupuesto'] = 2;
                $dataHist['nivel'] = $conceptoMaterial->nivel;
                SolicitudCambioPartidaHistorico::create($dataHist);


                $dataHist = [];
                $conceptoMaterial = Concepto::where('descripcion', '=', 'MANO OBRA')->where('nivel', 'like', $concepto->nivel . '%')->first();
                $dataHist['precio_unitario_original'] = $conceptoMaterial->precio_unitario;
                $dataHist['monto_presupuestado_original'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['precio_unitario_actualizado'] = $conceptoMaterial->precio_unitario;
                $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado = $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();
                $dataHist['monto_presupuestado_actualizado'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['id_base_presupuesto'] = 2;
                $dataHist['nivel'] = $conceptoMaterial->nivel;
                SolicitudCambioPartidaHistorico::create($dataHist);


                $dataHist = [];
                $conceptoMaterial = Concepto::where('descripcion', '=', 'HERRAMIENTA Y EQUIPO')->where('nivel', 'like', $concepto->nivel . '%')->first();
                $dataHist['precio_unitario_original'] = $conceptoMaterial->precio_unitario;
                $dataHist['monto_presupuestado_original'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['precio_unitario_actualizado'] = $conceptoMaterial->precio_unitario;
                $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado = $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();
                $dataHist['monto_presupuestado_actualizado'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['id_base_presupuesto'] = 2;
                $dataHist['nivel'] = $conceptoMaterial->nivel;
                SolicitudCambioPartidaHistorico::create($dataHist);

                $dataHist = [];
                $conceptoMaterial = Concepto::where('descripcion', '=', 'MAQUINARIA')->where('nivel', 'like', $concepto->nivel . '%')->first();
                $dataHist['precio_unitario_original'] = $conceptoMaterial->precio_unitario;
                $dataHist['monto_presupuestado_original'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['precio_unitario_actualizado'] = $conceptoMaterial->precio_unitario;
                $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado = $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();
                $dataHist['monto_presupuestado_actualizado'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['id_base_presupuesto'] = 2;
                $dataHist['nivel'] = $conceptoMaterial->nivel;
                SolicitudCambioPartidaHistorico::create($dataHist);


                $dataHist = [];
                $conceptoMaterial = Concepto::where('descripcion', '=', 'SUBCONTRATOS')->where('nivel', 'like', $concepto->nivel . '%')->first();
                $dataHist['precio_unitario_original'] = $conceptoMaterial->precio_unitario;
                $dataHist['monto_presupuestado_original'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['precio_unitario_actualizado'] = $conceptoMaterial->precio_unitario;
                $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado = $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();
                $dataHist['monto_presupuestado_actualizado'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['id_base_presupuesto'] = 2;
                $dataHist['nivel'] = $conceptoMaterial->nivel;
                SolicitudCambioPartidaHistorico::create($dataHist);

                $dataHist = [];
                $conceptoMaterial = Concepto::where('descripcion', '=', 'GASTOS')->where('nivel', 'like', $concepto->nivel . '%')->first();
                $dataHist['precio_unitario_original'] = $conceptoMaterial->precio_unitario;
                $dataHist['monto_presupuestado_original'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['precio_unitario_actualizado'] = $conceptoMaterial->precio_unitario;
                $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;
                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado = $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();
                $dataHist['monto_presupuestado_actualizado'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['id_base_presupuesto'] = 2;
                $dataHist['nivel'] = $conceptoMaterial->nivel;
                SolicitudCambioPartidaHistorico::create($dataHist);

                //propagacion hacia arriba monto_presupuestado

                $tamanioFaltante = strlen($concepto->nivel);

                $monto_anterior = $concepto->monto_presupuestado;
                while ($tamanioFaltante > 0) { ///////////////recorrido todos los niveles hacia arriba

                    $dataHist = [];
                    $afectaConcepto = Concepto::where('nivel', '=', substr($concepto->nivel, 0, $tamanioFaltante))->where('id_obra', '=', Context::getId())->first();
                    $dataHist['precio_unitario_original'] = $afectaConcepto->precio_unitario;
                    $dataHist['monto_presupuestado_original'] = $afectaConcepto->monto_presupuestado;
                    $dataHist['precio_unitario_actualizado'] = $afectaConcepto->precio_unitario;
                    $dataHist['id_partidas_insumos_agrupados'] = $insumo->id;

                    $afectaConcepto->monto_presupuestado = ($afectaConcepto->monto_presupuestado - $monto_anterior) + $afectacion_mmonto_propagacion;
                    $afectaConcepto->save();

                    $dataHist['monto_presupuestado_actualizado'] = $afectaConcepto->monto_presupuestado;
                    $dataHist['id_base_presupuesto'] = 2;
                    $dataHist['nivel'] = $afectaConcepto->nivel;
                    SolicitudCambioPartidaHistorico::create($dataHist);
                    $tamanioFaltante -= 4;
                }

            }

            $solicitud = SolicitudCambio::find($id);
            $solicitud->id_estatus = Estatus::AUTORIZADA;
            $solicitud->save();

            $data = ["id_solicitud_cambio" => $id];
            $solicitudCambio = SolicitudCambioAutorizada::create($data);
            $solicitud = $this->model->find($id);
            $this->enviarNotificacionRevasePresupuesto($id);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
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
            $solicitud = $this->model->with('partidas')->find($data['id_solicitud_cambio']);

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

    /**
     * Aplica una CambioInsumos a un Presupuesto
     * @param CambioInsumos $CambioInsumos
     * @param $id_base_presupuesto
     * @return void
     */
    public function aplicar(CambioInsumos $CambioInsumos, $id_base_presupuesto)
    {

    }

    public function enviarNotificacionRevasePresupuesto($id)
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

                        $mail = new \PHPMailer();
                        $body = $html;
                        $mail->IsSMTP(); // telling the class to use SMTP
                        $mail->Host = "mail.hermesconstruccion.com.mx"; // SMTP server
                        $mail->SMTPDebug = 2;                     // enables SMTP debug information (for testing)
                        $mail->SMTPAuth = true;                  // enable SMTP authentication
                        $mail->Port = 25;                   // set the SMTP port for the GMAIL server
                        $mail->Username = "seguimiento@hermesconstruccion.com.mx";  // GMAIL username
                        $mail->Password = "qhermu";            // GMAIL password
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
}