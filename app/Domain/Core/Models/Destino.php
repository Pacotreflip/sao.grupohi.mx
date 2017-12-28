<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 06/11/2017
 * Time: 07:06 PM
 */

namespace Ghi\Domain\Core\Models;


use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.destinos';
    protected $primaryKey = 'id';
}