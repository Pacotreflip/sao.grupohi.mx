<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 02/05/2018
 * Time: 05:54 PM
 */

namespace Ghi\Domain\Core\Models\Subcontratos;


use Illuminate\Database\Eloquent\Model;

/**
 * Class PartidaAsignacion
 * @package Ghi\Domain\Core\Models\Subcontratos
 */
class PartidaAsignacion extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cadeco';
    /**
     * @var string
     */
    protected $table = 'Subcontratos.partidas_asignacion';
    /**
     * @var string
     */
    protected $primaryKey = 'id_partida_asignacion';
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'id_asignacion',
        'id_concepto',
        'id_transaccion',
        'cantidad_asignada',
        'cantidad_autorizada',
    ];
}