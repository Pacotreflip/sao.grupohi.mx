<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 11:37 AM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;
use Illuminate\Database\Eloquent\Model;

class Estatus extends Model
{
    protected $table = 'ControlPresupuesto.estatus';
    protected $connection = 'cadeco';
    protected $fillable = [
        'clave_estado',
        'descripcion'
    ];
}