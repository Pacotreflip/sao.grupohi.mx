<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 28/12/2017
 * Time: 06:53 PM
 */

namespace Ghi\Domain\Core\Contracts;


interface TipoTranRepository
{

    /**
     * Obtienes los tipos de transacción en lista para combo
     * @return array
     */
    public function lists();

    /**
     * Contiene los parametros de búsqueda
     * @param array $orWhere
     * @return mixed
     */
    public function orWhere(array $orWhere);
}