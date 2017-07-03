<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 28/06/2017
 * Time: 05:53 PM
 */

namespace Ghi\Domain\Core\Contracts;


interface AlmacenRepository
{
    /**
     * Obtiene todos los registros de Almacenes
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\AlmacenRepository
     */
    public function all();

    /**
     * @param $id Identificador de la Cuenta de Almacen que se va a mostrar
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\AlmacenRepository
     */
    public function find($id);

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations);
}