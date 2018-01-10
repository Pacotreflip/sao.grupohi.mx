<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 14/07/2017
 * Time: 12:05 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;


use Illuminate\Database\Eloquent\Model;

class NaturalezaPoliza  extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.naturaleza_poliza';
    protected $primaryKey = 'id_naturaleza_poliza';
    public $timestamps = false;

    public function __toString()
    {
      return $this->descripcion;
    }
}