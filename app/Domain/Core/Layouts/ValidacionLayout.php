<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 08/05/2018
 * Time: 04:33 PM
 */

namespace Ghi\Domain\Core\Layouts;

use Illuminate\Support\Facades\Log;

/**
 * Class ValidacionLayout
 * @package Ghi\Domain\Core\Layouts
 */
class ValidacionLayout
{
    /**
     * @var int
     */
    protected $cabecerasLength = 1;
    /**
     * @var int
     */
    protected $lengthHeaderFijos = 0;
    /**
     * @var int 
     */
    protected $lengthHeaderDinamicos = 0;
    
    /**
     * @param $headers
     * @param $layout
     * @return bool
     * @throws \Exception
     */
    public function validarHeader($headers, $layout)
    {
        $maxCol = (($layout['totales'] * $this->lengthHeaderDinamicos) + $this->lengthHeaderFijos + 1);

        if ($maxCol != count($headers)) {
            throw new \Exception("Las columnas no son iguales a las que descargo en el archivo 1");
        }
        $headersCotizaciones = array_slice($headers, 0, $this->lengthHeaderFijos);
        $diffCotizaciones = array_diff(array_keys($this->headerFijos), $headersCotizaciones);
        if (count($diffCotizaciones) != 0) {
            throw new \Exception("Las columnas no son iguales a las que descargo en el archivo 2");
        }
        $j = $this->lengthHeaderFijos;

        while ($j < ($maxCol-1)) {
            $headersCotizaciones = array_slice($headers, $j, $this->lengthHeaderDinamicos);
            $diffCotizaciones = array_diff(array_keys($this->headerDinamicos), $headersCotizaciones);
            if (count($diffCotizaciones) > 0) {
                throw new \Exception("Las columnas no son iguales a las que descargo en el archivo 3");
            }
            $j += $this->lengthHeaderDinamicos;
        }
        return true;
    }
}