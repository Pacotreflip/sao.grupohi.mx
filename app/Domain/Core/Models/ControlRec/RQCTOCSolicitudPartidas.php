<?php

namespace Ghi\Domain\Core\Models\ControlRec;

use Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion;
use Illuminate\Database\Eloquent\Model;
use Ghi\Core\Models\Material;
use Ghi\Domain\Core\Models\Transacciones;
use Illuminate\Support\Facades\DB;

class RQCTOCSolicitudPartidas extends Model
{
    protected $connection = 'controlrec';

    protected $table = 'rqctoc_solicitudes_partidas';
    protected $primaryKey = 'idrqctoc_solicitudes_partidas';

    public function getCantidadPendienteAttribute() {
        return $this->cantidad - $this->rqctocTablaComparativaPartidas()->sum('cantidad_asignada');
    }

    public function rqctocTablaComparativaPartidas() {
        return $this->hasMany(RQCTOCTablaComparativaPartida::class, 'idrqctoc_solicitudes_partidas', 'idrqctoc_solicitudes_partidas');
    }

    public function getRequisicionEstatusAttribute() {
        return Requisicion::find($this->rqctocSolicitud->idtransaccion_sao)->estado;
    }

    public function rqctocSolicitud() {
        return $this->belongsTo(RQCTOCSolicitud::class, 'idrqctoc_solicitudes', 'idrqctoc_solicitudes');
    }

    public function item()
    {
        return $this->hasOne(Transacciones\Item::class, 'id_item', 'iditem_sao');
    }

    public function material()
    {
        return $this->hasOne(Material::class, 'id_material', 'idmaterial_sao');
    }

    public function getCantidadAutorizadaAttribute() {
        if($this->requisicion_estatus == 1){
            return $this->cantidad;
        } else {
           return 0;
        }
    }

    public function getCantidadSolicitadaAttribute() {
        if($this->requisicion_estatus == 1){
            if($this->cantidad_original != 0) {
                return $this->cantidad_original;
            }
        }
        return $this->cantidad;
    }
}
