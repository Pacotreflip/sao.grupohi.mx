<?php

namespace Ghi\Domain\Core\Models\ControlRec;

use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Sucursal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RQCTOCCotizaciones extends Model
{
    protected $connection = 'controlrec';

    protected $table = 'rqctoc_cotizaciones';
    protected $primaryKey = 'idrqctoc_cotizaciones';

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idproveedor_sao', 'id_empresa');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idsucursal_sao', 'id_sucursal');
    }

    public function rqctocCotizacionPartidas()
    {
        return $this->hasMany(RQCTOCCotizacionesPartidas::class, 'idrqctoc_cotizaciones', 'idrqctoc_cotizaciones');
    }

    public function getCandidataAttribute()
    {
        $res = false;
        foreach ($this->rqctocCotizacionPartidas as $rqctocCotizacionPartida) {
            if($rqctocCotizacionPartida->precio_unitario != 0) {
                if($rqctocCotizacionPartida->rqctocSolicitudPartida->cantidad_pendiente > 0) {
                    $res = true;
                }
            }
        }

        return $res;
    }
}