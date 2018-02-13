<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 11:37 AM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Material;
use Illuminate\Database\Eloquent\Model;

class SolicitudCambioPartida extends Model
{
    protected $table = 'ControlPresupuesto.solicitud_cambio_partidas';
    protected $connection = 'cadeco';
    protected $fillable = [
        'id_solicitud_cambio',
        'id_tipo_orden',
        'id_tarjeta',
        'id_concepto',
        'cantidad_presupuestada_original',
        'cantidad_presupuestada_nueva',
        'variacion_volumen',
        'monto_presupuestado',
        'descripcion',
        'id_material',
        'nivel',
        'precio_unitario_original',
        'precio_unitario_nuevo',
        'rendimiento_original',
        'rendimiento_nuevo'
    ];

    public function concepto() {
        return $this->belongsTo(Concepto::class, 'id_concepto');
    }
    public function numeroTarjeta()
    {
        return $this->hasOne(Tarjeta::class, 'id', 'id_tarjeta');
    }

    public function solicitud()
    {
        return $this->belongsTo(SolicitudCambio::class, 'id_solicitud_cambio', 'id');
    }

    public function getClaveConceptoAttribute() {
        return $this->concepto->clave_concepto;
    }
    public function material()
    {
        return $this->hasOne(Material::class, 'id_material', 'id_material');
    }

}