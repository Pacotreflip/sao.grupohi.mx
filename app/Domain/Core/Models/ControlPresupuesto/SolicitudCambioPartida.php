<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 11:37 AM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;
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
        'cantidad_presupuestada_nueva'
    ];
}