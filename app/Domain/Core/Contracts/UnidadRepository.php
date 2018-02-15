<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 27/07/2017
 * Time: 02:09 PM
 */

namespace Ghi\Domain\Core\Contracts;


interface UnidadRepository
{

    /**
     * Obtiene todos los registros de Item
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Unidad
     */
    public function all();

    /**
     * @param $id Identificador del Item
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Unidad
     */
    public function find($id);

    public function getUnidadesByDescripcion($descripcion);


}