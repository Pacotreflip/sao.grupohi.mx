<?php

namespace Ghi\Domain\Core\Models\SubcontratosEstimaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 26/09/2017
 * Time: 04:41 PM
 */

class Retencion extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'SubcontratosEstimaciones.retencion';
    protected $primaryKey = 'id_retencion';
}