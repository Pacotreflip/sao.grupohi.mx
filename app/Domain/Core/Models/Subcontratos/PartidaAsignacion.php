<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 02/05/2018
 * Time: 05:54 PM
 */

namespace Ghi\Domain\Core\Models\Subcontratos;


use Illuminate\Database\Eloquent\Model;

class PartidaAsignacion extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Subcontratos.partidas_asignacion';
    protected $primaryKey = 'id_partida_asignacion';
    public $timestamps = false;

}