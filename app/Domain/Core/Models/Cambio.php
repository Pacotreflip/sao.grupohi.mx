<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 31/07/2017
 * Time: 06:39 PM
 */

namespace Ghi\Domain\Core\Models;


use Illuminate\Database\Eloquent\Model;

class Cambio extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.cambios';

}