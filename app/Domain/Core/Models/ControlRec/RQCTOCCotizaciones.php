<?php

namespace Ghi\Domain\Core\Models\ControlRec;

use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Scopes\DatabaseScope;
use Ghi\Domain\Core\Models\Sucursal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class RQCTOCCotizaciones
 * @package Ghi\Domain\Core\Models\ControlRec
 */
class RQCTOCCotizaciones extends Model
{
    /**
     * @var string
     */
    protected $connection = 'controlrec';

    /**
     * @var string
     */
    protected $table = 'rqctoc_cotizaciones';
    /**
     * @var string
     */
    protected $primaryKey = 'idrqctoc_cotizaciones';

    /**
     * @var array
     */
    protected $fillable = [
        'idmoneda',
        'fecha_cotizacion',
        'anticipo',
        'anticipo_pactado',
        'dias_credito',
        'plazo_entrega',
        'observaciones',
        'vigencia',
        'tc_usd',
        'tc_eur',
        'importe',
        'iva',
        'total',
        'descuento',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DatabaseScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idproveedor_sao', 'id_empresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idsucursal_sao', 'id_sucursal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rqctocCotizacionPartidas()
    {
        return $this->hasMany(RQCTOCCotizacionesPartidas::class, 'idrqctoc_cotizaciones', 'idrqctoc_cotizaciones');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rqctocSolicitud() {
        return $this->belongsTo(RQCTOCSolicitud::class, 'idrqctoc_solicitudes', 'idrqctoc_solicitudes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rqctocSolicitudesPartidas() {
        return $this->hasMany(RQCTOCSolicitudPartidas::class, 'idrqctoc_solicitudes', 'idrqctoc_solicitudes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedores()
    {
        return $this->belongsTo(Proveedores::class, 'idproveedor', 'IdProveedor');
    }

    /**
     * @return bool
     */
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