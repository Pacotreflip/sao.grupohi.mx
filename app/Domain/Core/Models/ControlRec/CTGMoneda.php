<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 25/04/2018
 * Time: 04:27 PM
 */

namespace Ghi\Domain\Core\Models\ControlRec;


use Illuminate\Database\Eloquent\Model;

class CTGMoneda extends Model {

    protected $connection = 'controlrec';
    protected $table = 'ctg_monedas';
    protected $primaryKey = 'id';
}