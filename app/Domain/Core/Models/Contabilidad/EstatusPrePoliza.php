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

    public function getLabelAttribute() {
        switch ($this->descripcion) {
            case 'No Lanzada' :
                return 'red';
                break;
            case 'Con Errores':
                return 'red';
                break;
            case 'No Validada':
                return 'yellow';
                break;
            case 'Validada':
                return 'blue';
                break;
            case 'Lanzada':
                return 'green';
                break;
            case 'Omitir':
                return 'gray';
                break;
        }
    }
}