<?php
/**
 * Created by PhpStorm.
 * User: JFEsquivel
 * Date: 19/07/2017
 * Time: 12:58 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;


use Illuminate\Database\Eloquent\Model;

class EstatusPrePoliza extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.estatus_prepolizas';
    public $timestamps = false;

    public function __toString()
    {
        return $this->descripcion;
    }
}