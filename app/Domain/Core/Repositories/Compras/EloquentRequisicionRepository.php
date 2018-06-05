<?php

namespace Ghi\Domain\Core\Repositories\Compras;

use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Models\Compras\Requisiciones\DepartamentoResponsable;
use Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion;
use Ghi\Domain\Core\Models\Compras\Requisiciones\TipoRequisicion;
use Ghi\Domain\Core\Models\Compras\Requisiciones\TransaccionExt;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCCotizaciones;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCCotizacionesPartidas;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCSolicitudPartidas;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCSolicitud;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class EloquentRequisicionRepository
 * @package Ghi\Domain\Core\Repositories\Compras
 */
class EloquentRequisicionRepository implements RequisicionRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion
     */
    protected $model;

    /**
     * @var \Ghi\Domain\Core\Models\Compras\Requisiciones\TransaccionExt
     */
    protected $ext;

    /**
     * EloquentRequisicionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion $model
     */
    public function __construct(Requisicion $model, TransaccionExt $ext)
    {
        $this->model = $model;
        $this->ext = $ext;
    }

    /**
     * Obtiene todos los registros de Requisicion
     *
     * @return \Illuminate\Database\Eloquent\Collection|Requisicion
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model|Requisicion
     */
    public function find($id)
    {
        return $this->model->find($id);
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
     * Guarda un registro de Transaccion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $item = $this->model->create($data);

            $this->ext->create([
                'id_transaccion' => $item->id_transaccion,
                'id_departamento' => $data['id_departamento'],
                'id_tipo_requisicion' => $data['id_tipo_requisicion']
            ]);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $this->model->with('transaccionExt')->find($item->id_transaccion);
    }

    /**
     * Actualiza un registro de Transaccion
     * @param array $data
     * @param integer $id
     * @return \Ghi\Domain\Core\Models\Transacciones\Transaccion
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {

            DB::connection('cadeco')->beginTransaction();
            if (!$requisicion = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la requisición', 404));
            }

            $requisicion_ext = $this->ext->find($id);
            $requisicion->update($data);
            $requisicion_ext->update($data);

            $requisicion_ext->folio_adicional =
                DepartamentoResponsable::find($requisicion_ext->id_departamento)->descripcion_corta
                . '-'
                . TipoRequisicion::find($requisicion_ext->id_tipo_requisicion)->descripcion_corta
                . '-'
                . Requisicion::find($requisicion_ext->id_transaccion)->numero_folio;
            $requisicion_ext->save();

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $this->model->with('transaccionExt')->find($requisicion->id_transaccion);
    }

    /**
     * Elimina una Requisicion
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        if (!$requisicion = $this->model->find($id)) {
            throw new HttpResponseException(new Response('No se encontró la requisición', 404));
        }
        $requisicion->delete();
    }

    /**
     * @param array $cols
     * @param string $q
     * @return mixed
     */
    public function like(array $cols, $q)
    {
        return $this->model->where(function ($query) use ($cols, $q) {
            foreach ($cols as $col) {
                $query->orWhere($col, 'like', "%$q%");
            }
        })->limit(10)->get();
    }

    public  function getCotizaciones($id_requisicion, $ids_cot = [])
    {
        return RQCTOCCotizaciones::whereIn('idrqctoc_cotizaciones', $ids_cot)
            ->where('idrqctoc_solicitudes', $id_requisicion)
            ->with(['rqctocSolicitud.rqctocSolicitudPartidas.item.transaccion', 'rqctocSolicitud.rqctocSolicitudPartidas.material', 'empresa', 'sucursal'])
            ->get();
    }

    /**
     * @param $id_requisicion
     * @return mixed
     */
    public function getPartidasCotizacion($id_requisicion)
    {
        return RQCTOCSolicitudPartidas::where('idrqctoc_solicitudes', $id_requisicion)
            ->with(['item.transaccion', 'material'])
            ->groupBy('idmaterial_sao')->get();
    }

    /**
     * @param int $id_requisicion
     * @param array $ids_cot
     */
    public function   getPartidasCotizacionAgrupadas($id_requisicion)
    {
        return RQCTOCCotizacionesPartidas::select( DB::raw("
            rqctoc_cotizaciones_partidas.idrqctoc_cotizaciones_partidas,
            rqctoc_cotizaciones_partidas.idrqctoc_cotizaciones,
            rqctoc_cotizaciones_partidas.idrqctoc_solicitudes_partidas,
            rqctoc_cotizaciones_partidas.precio_unitario,
            format(rqctoc_cotizaciones_partidas.precio_unitario,3) as precio_unitario_f,
            rqctoc_cotizaciones_partidas.descuento,
            rqctoc_cotizaciones_partidas.idmoneda,
            rqctoc_cotizaciones_partidas.observaciones,
            rqctoc_cotizaciones_partidas.cantidad_asignada,
            rqctoc_cotizaciones.tc_usd,
            rqctoc_cotizaciones.vigencia,
            rqctoc_cotizaciones.tc_eur,
            rqctoc_cotizaciones.idmoneda as idmoneda_cot,
            sum(rqctoc_solicitudes_partidas.cantidad) as cantidad,
            ctg_monedas.moneda as moneda,
            ctg_monedas.corto as  moneda_corto,
            (precio_unitario-(precio_unitario*rqctoc_cotizaciones_partidas.descuento/100)) as precio_unitario,
            sum(rqctoc_solicitudes_partidas.cantidad)*(precio_unitario-(precio_unitario*rqctoc_cotizaciones_partidas.descuento/100)) as precio_total,
            cantidad_asignada*(precio_unitario-(precio_unitario*rqctoc_cotizaciones_partidas.descuento/100)) as precio_total_asignado,
            format(sum(rqctoc_solicitudes_partidas.cantidad)*(precio_unitario-(precio_unitario*rqctoc_cotizaciones_partidas.descuento/100)),2) as precio_total_f") )
            ->from('rqctoc_cotizaciones_partidas as rqctoc_cotizaciones_partidas')
            ->join('rqctoc_cotizaciones', 'rqctoc_cotizaciones_partidas.idrqctoc_cotizaciones', '=', 'rqctoc_cotizaciones.idrqctoc_cotizaciones')
            ->join('rqctoc_solicitudes_partidas', 'rqctoc_solicitudes_partidas.idrqctoc_solicitudes_partidas', '=', 'rqctoc_cotizaciones_partidas.idrqctoc_solicitudes_partidas')
            ->join('ctg_monedas', 'ctg_monedas.id', '=', 'rqctoc_cotizaciones_partidas.idmoneda')
            ->where('rqctoc_cotizaciones.idrqctoc_solicitudes', $id_requisicion)
            ->groupBy('rqctoc_solicitudes_partidas.idmaterial_sao', 'rqctoc_cotizaciones.idrqctoc_cotizaciones')
            ->get();
    }

    public function getRequisicion($id_transaccion_sao)
    {
        return RQCTOCSolicitud::where('idtransaccion_sao', $id_transaccion_sao)->first();
    }

    /**
     * @param $id_cotizacion
     *
     * @return bool
     */
    public function getNumAsignaciones($id_cotizacion)
    {
        $query = DB::connection('controlrec')
            ->select(DB::raw("
          SELECT count(*) as cantidad FROM rqctoc_cotizaciones as c join
            rqctoc_cotizaciones_partidas as cp on(c.idrqctoc_cotizaciones = cp.idrqctoc_cotizaciones) join
            rqctoc_tabla_comparativa_partidas as tcp on(tcp.idrqctoc_cotizaciones_partidas = cp.idrqctoc_cotizaciones_partidas)
            where c.idrqctoc_cotizaciones = $id_cotizacion group by tcp.idrqctoc_tabla_comparativa;
          "));
        if(isset($query[0])) {
            if ($query[0]->cantidad > 0) {
                return true;
            }
        }
        return false;
    }
}