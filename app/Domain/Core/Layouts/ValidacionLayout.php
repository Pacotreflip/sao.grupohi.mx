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
     * @var string
     */
    protected $Key = 'BY8eK8H3XKmb4LXt';
    /**
     * @var string
     */
    protected $Iv = 'Y1MVtMxZQaPpfg8y';
    /**
     * @var object
     */
    protected $mCrypt;
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
     * @var int
     */
    protected $columnsExt = 2;
    /**
     * @var string
     */
    protected $message = 'No es posible procesar el Layout debido a que presenta diferencias con la información actual';
    /**
     * @param $headers
     * @param $layout
     * @return bool
     * @throws \Exception
     */
    public function validarHeader($headers, $layout)
    {
        $maxCol = (($layout['totales'] * $this->lengthHeaderDinamicos) + $this->lengthHeaderFijos);
        $headers = array_slice($headers, 0, count($headers) - $this->columnsExt);
        if ($maxCol != count($headers)) {
            throw new \Exception($this->message);
        }
        $headersCotizaciones = array_slice($headers, 0, $this->lengthHeaderFijos);
        $diffCotizaciones = array_diff(array_keys($this->headerFijos), $headersCotizaciones);
        if (count($diffCotizaciones) != 0) {
            throw new \Exception($this->message);
        }
        $j = $this->lengthHeaderFijos;

        while ($j < ($maxCol - 1)) {
            $headersCotizaciones = array_slice($headers, $j, $this->lengthHeaderDinamicos);
            $diffCotizaciones = array_diff(array_keys($this->headerDinamicos), $headersCotizaciones);
            if (count($diffCotizaciones) > 0) {
                throw new \Exception($this->message);
            }
            $j += $this->lengthHeaderDinamicos;
        }
        return true;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}