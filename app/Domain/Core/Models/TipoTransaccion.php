<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 14/07/2017
 * Time: 02:18 PM
 */

namespace Ghi\Domain\Core\Models;


use Illuminate\Database\Eloquent\Model;

class TipoTransaccion extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.TipoTran';

    public function __toString()
    {
       return $this->Descripcion;
    }
}