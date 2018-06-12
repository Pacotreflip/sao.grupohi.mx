<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 06/06/2018
 * Time: 11:43 AM
 */

namespace Ghi\Utils;


use Ghi\Domain\Core\Models\Cambio;
use Illuminate\Support\Facades\Log;

/**
 * Class TipoCambio
 * @package Ghi\Utils
 */
class TipoCambio
{

    /**
     *
     */
    const TCEURO = 3;

    /**
     * @param $importe
     * @param $idmoneda
     *
     * @return float|int
     */
    public static function cambio($importe, $idmoneda)
    {
        $tipo_cambio = Cambio::where('fecha', '=', date('Y-m-d'))->get()->toArray();

        foreach ($tipo_cambio as $k => $v) {
            $tipoCambio[$v['id_moneda']] = $v['cambio'];
        }
        $importeCambio = ($importe * $tipoCambio[$idmoneda]) / $tipoCambio[self::TCEURO];
        return $importeCambio;
    }
}