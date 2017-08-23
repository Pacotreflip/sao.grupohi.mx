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
            case 'No Lanzable' :
                return 'gray';
            case 'No Lanzada' :
                return 'red';
                break;
            case 'Con Errores':
                return 'red';
                break;
            case 'Por Validar':
                return 'yellow';
                break;
            case 'Validada':
                return 'blue';
                break;
            case 'Lanzada':
                return 'green';
                break;
            case 'Omitida':
                return 'gray';
                break;
            case 'Registro Manual':
                return 'green';
                break;
        }
    }

    public function getRgbAttribute () {
        switch ($this->descripcion) {
            case 'No Lanzada' :
                return 'rgb(255, 159, 64)';
                break;
            case 'Con Errores':
                return 'rgb(255, 99, 132)';
                break;
            case 'Por Validar':
                return 'rgb(255, 205, 86)';
                break;
            case 'Validada':
                return 'rgb(54, 162, 235)';
                break;
            case 'Lanzada':
                return 'rgb(75, 192, 192)';
                break;
            case 'Omitida':
                return 'rgb(201, 203, 207)';
                break;
            case 'Registro Manual':
                return 'rgb(75, 192, 192)';
                break;
        }
    }
}