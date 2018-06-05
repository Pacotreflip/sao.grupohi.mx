<?php
/**
 * Created by PhpStorm.
 * User: 25852
 * Date: 18/05/2018
 * Time: 04:53 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;

use Ghi\Domain\Core\Contracts\ControlPresupuesto\ConceptoExtraordinarioRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;

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

            foreach ($agrupador_conceptos as  $agrupador_insumos){
                $agrupador = $data['extraordinario'][$agrupador_insumos];
                $nivel_agrupador = explode('.', $agrupador['nivel']);
                $agrupador['tipo_agrupador'] = (int)$nivel_agrupador[sizeof($nivel_agrupador)-2];
                $agrupador['id_solicitud_cambio'] = $solicitud->id;
                $agrupador['id_tipo_orden'] = $data['id_tipo_orden'];
                $agrupador['id_tarjeta'] = $data['extraordinario']['id_tarjeta'];
                $agrupador['id_material'] = null;
                $agrupador['nivel'] =  $data['extraordinario']['nivel'].$nivel_agrupador[sizeof($nivel_agrupador)-2]. '.';
                $agrupador['descripcion'] == 'MANOOBRA'? $agrupador['descripcion'] = 'MANO OBRA':'';
                $agrupador['descripcion'] == 'HERRAMIENTAYEQUIPO'? $agrupador['descripcion'] = 'HERRAMIENTA Y EQUIPO':'';
                $monto_presupuestado_agrupador = 0;
                $agrupado = $this->solicitud_partidas->create($agrupador);
                /// Inicia ciclo para guardar insumos del agrupador
                if(array_key_exists('insumos', $agrupador)) {
                    foreach ($agrupador['insumos'] as $insumo) {
                        $nivel_insumo = explode('.', $insumo['nivel']);
                        $insumo['id_solicitud_cambio'] = $solicitud->id;
                        $insumo['id_tipo_orden'] = $data['id_tipo_orden'];
                        $insumo['tipo_agrupador'] = $agrupador['tipo_agrupador'];
                        $insumo['id_tarjeta'] = $agrupador['id_tarjeta'];
                        $insumo['nivel'] = $agrupador['nivel'] . $nivel_insumo[sizeof($nivel_insumo) - 2];
                        $insumo['cantidad_presupuestada_nueva'] = $insumo['cantidad_presupuestada'] * $concepto_ext->cantidad_presupuestada_nueva;
                        $insumo['precio_unitario_nuevo'] = $insumo['precio_unitario'];
                        $insumo['monto_presupuestado'] = $insumo['cantidad_presupuestada_nueva'] * $insumo['precio_unitario'];
                        $monto_presupuestado_agrupador += $insumo['monto_presupuestado'];

                        $this->solicitud_partidas->create($insumo);
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
        ////  buscar los insumos autorizados
        $partidas = $this->solicitud_partidas->where('id_solicitud_cambio', '=', $id)->orderBY('nivel')->get();

        ///    crear la tarjeta



        ///     comenzar a iterar los conceptos
        ///     guardar en conceptos
        ///     guardar en conceptos path(id_concepto y nivel)
        ///     guardar en historico
        ///     guardar en concepto tarjeta
        ///

        /// ///

        ///  autorizar solicitud
    }

}