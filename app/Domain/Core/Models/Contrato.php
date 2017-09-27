<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 26/09/2017
 * Time: 11:38 AM
 */

namespace Ghi\Domain\Core\Models;


use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.contratos';
    protected $primaryKey = 'id_concepto';

    public function __toString()
    {
        return $this->descripcion;
    }
}