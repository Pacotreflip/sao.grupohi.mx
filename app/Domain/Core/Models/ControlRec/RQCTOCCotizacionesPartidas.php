<?php

namespace Ghi\Domain\Core\Models\ControlRec;

use Illuminate\Database\Eloquent\Model;

class RQCTOCCotizacionesPartidas extends Model
{
    protected $connection = 'controlrec';

    protected $table = 'rqctoc_cotizaciones_partidas';
    protected $primaryKey = 'idrqctoc_cotizaciones_partidas';


    public function rqctocSolicitudPartida() {
        return $this->belongsTo(RQCTOCSolicitudPartidas::class, 'idrqctoc_solicitudes_partidas', 'idrqctoc_solicitudes_partidas');
    }
    public function getPrecioTotalAttribute() {
        return $this->rqctocSolicitudPartida->cantidad * ($this->precio_unitario - ($this->precio_unitario * $this->descuento / 100));
    }

    public function ctgMoneda() {
        return $this->belongsTo(CTGMoneda::class, 'idmoneda');
    }
}
