<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 26/09/2017
 * Time: 12:14 PM
 */

namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface CostosDolaresRepository
{
    /**
     * Obtiene el reporte de Costos en Dolares
     * @return mixed
     */
    public function getBy($fechas);
}