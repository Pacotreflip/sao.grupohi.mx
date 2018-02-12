<?php
/**
 * Created by PhpStorm.
 * User: JFEsquivel
 * Date: 07/02/2018
 * Time: 12:40 PM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;
use Illuminate\Database\Eloquent\Model;

class SolicitudCambioPartidaHistorico extends Model
{
    protected $table = 'ControlPresupuesto.solicitud_cambio_partidas_historico';
    protected $connection = 'cadeco';
    protected $fillable = [
        'id_solicitud_cambio_partida',
        'id_base_presupuesto',
        'nivel',
        'cantidad_presupuestada_original',
        'cantidad_presupuestada_actualizada',
        'monto_presupuestado_original',
        'monto_presupuestado_actualizado'
    ];
}