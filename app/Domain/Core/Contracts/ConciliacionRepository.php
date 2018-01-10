<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 01/12/2017
 * Time: 01:54 PM
 */

namespace Ghi\Domain\Core\Contracts;

use Dingo\Api\Http\Request;

interface ConciliacionRepository
{
    /**
     * Almacena los datos de conciliaciones del Módulo de Acarreos
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request);

    /**
     * Recupera los Costos de la pista en caso de que no exista un Costo
     * asociado a la empresa en el subcontrato.
     * @param Request $request
     * @return mixed
     */
    public function getCostos(Request $request);

}