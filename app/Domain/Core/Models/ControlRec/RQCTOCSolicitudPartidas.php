<?php

namespace Ghi\Domain\Core\Models\ControlRec;

use Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion;
use Illuminate\Database\Eloquent\Model;
use Ghi\Core\Models\Material;
use Ghi\Domain\Core\Models\Transacciones;
use Illuminate\Support\Facades\DB;
use Ghi\Core\Facades\Context;


/**
 * Class RQCTOCSolicitudPartidas
 * @package Ghi\Domain\Core\Models\ControlRec
 */
class RQCTOCSolicitudPartidas extends Model
{
    /**
     * @var string
     */
    protected $connection = 'controlrec';

    /**
     * @var string
     */
    protected $table = 'rqctoc_solicitudes_partidas';
    /**
     * @var string
     */
    protected $primaryKey = 'idrqctoc_solicitudes_partidas';

    /**
     * @return mixed
     */
    public function getCantidadPendienteAttribute() {
        $res = $this->cantidad_solicitada;
        foreach ($this->partidasAgrupadas as $partida) {

            $res -= $partida->rqctocTablaComparativaPartidas()->sum('cantidad_asignada');
        }
        return $res;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rqctocTablaComparativaPartidas() {
        return $this->hasMany(RQCTOCTablaComparativaPartida::class, 'idrqctoc_solicitudes_partidas', 'idrqctoc_solicitudes_partidas');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rqctocCotizacionPartida() {
        return $this->hasOne(RQCTOCCotizacionesPartidas::class, 'idrqctoc_solicitudes_partidas', 'idrqctoc_solicitudes_partidas');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rqctocCotizacionPartidas() {
        return $this->hasMany(RQCTOCCotizacionesPartidas::class, 'idrqctoc_solicitudes_partidas');
    }

    /**
     * @return mixed
     */
    public function getRequisicionEstatusAttribute() {
        return Requisicion::find($this->rqctocSolicitud->idtransaccion_sao)->estado;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rqctocSolicitud() {
        return $this->belongsTo(RQCTOCSolicitud::class, 'idrqctoc_solicitudes', 'idrqctoc_solicitudes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function item()
    {
        return $this->hasOne(Transacciones\Item::class, 'id_item', 'iditem_sao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function material()
    {
        return $this->hasOne(Material::class, 'id_material', 'idmaterial_sao');
    }

    /**
     * @return int|mixed
     */
    public function getCantidadAutorizadaAttribute() {
        if($this->requisicion_estatus == 1){
            return $this->cantidad;
        } else {
            return 0;
        }
    }

    /**
     * @return mixed
     */
    public function getCantidadSolicitadaAttribute() {
        if($this->requisicion_estatus == 1){
            if($this->cantidad_original != 0) {
                return $this->cantidad_original;
            }
        }
        return $this->partidasAgrupadas()->sum('cantidad');
    }

    public function getFincadaAttribute() {
        $fincada = DB::connection('cadeco')->select(DB::raw("
            select
            case when
            (ISNULL((select cantidad from cotizaciones
            where id_transaccion  in (select top 1 id_transaccion from transacciones where id_antecedente = ". $this->rqctocSolicitud->idtransaccion_sao ." and tipo_transaccion = ". Transacciones\Tipo::COTIZACION_COMPRA.") and id_material = ". $this->idmaterial_sao ."), 0)) -
            (ISNULL((select sum(cantidad) from items where id_antecedente = ". $this->rqctocSolicitud->idtransaccion_sao ." and id_material = ". $this->idmaterial_sao ."),0))
            < 0.01 then 1 else 0 end as fincada
        "))[0];
        return $fincada->fincada == '1';
    }

    public function partidasAgrupadas() {
        return $this->hasMany(self::class, 'idrqctoc_solicitudes', 'idrqctoc_solicitudes')->where('idmaterial_sao', '=', $this->idmaterial_sao);
    }

    public function getCantidadAttribute() {
        return DB::connection($this->connection)
            ->table($this->table)
            ->where($this->primaryKey, '=', $this->idrqctoc_solicitudes_partidas)
            ->value(DB::raw('CONCAT(cantidad, "")'));
    }
}