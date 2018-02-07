<?php
namespace Ghi\Domain\Core\Models\ControlPresupuesto;
use Illuminate\Database\Eloquent\Model;


class PartidasInsumosAgrupados extends Model
{
    protected $table = 'ControlPresupuesto.partidas_insumos_agrupados';
    protected $connection = 'cadeco';
    protected $fillable = [
        'id_solicitud_cambio',
        'id_concepto'
    ];

}