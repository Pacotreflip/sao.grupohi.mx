<?php

namespace Ghi\Domain\Core\Models\ControlRec;

use Ghi\Core\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Ghi\Domain\Core\Models\Transacciones;

/**
 * Class RQCTOCCotizacionesPartidas
 * @package Ghi\Domain\Core\Models\ControlRec
 */
class RQCTOCCotizacionesPartidas extends Model
{
    /**
     * @var string
     */
    protected $connection = 'controlrec';

    /**
     * @var string
     */
    protected $table = 'rqctoc_cotizaciones_partidas';
    /**
     * @var string
     */
    protected $primaryKey = 'idrqctoc_cotizaciones_partidas';

    /**
     * @var array
     */
    protected $fillable = [
        'idmoneda',
        'precio_unitario',
        'precio_unitario_mxp',
        'descuento',
        'observaciones',
        'idrqctoc_cotizaciones',
        'idrqctoc_solicitudes_partidas',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rqctocSolicitudPartida() {
        return $this->belongsTo(RQCTOCSolicitudPartidas::class, 'idrqctoc_solicitudes_partidas', 'idrqctoc_solicitudes_partidas');
    }

    /**
     * @return float|int
     */
    public function getPrecioTotalAttribute() {
        return $this->rqctocSolicitudPartida->cantidad * ($this->precio_unitario - ($this->precio_unitario * $this->descuento / 100));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ctgMoneda() {
        return $this->belongsTo(CTGMoneda::class, 'idmoneda');
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

}
