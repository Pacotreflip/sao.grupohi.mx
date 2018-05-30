<?php

namespace Ghi\Domain\Core\Contracts\Finanzas;

use Ghi\Domain\Core\Models\Finanzas\ComprobanteFondoFijo;
use Illuminate\Support\Collection;

interface ComprobanteFondoFijoRepository
{
    /**
     * Obtiene todos los registros de Comprobantes de Fondo Fijo
     * @return mixed
     */
    public function all();

    /**
     * @param $id
     * @return ComprobanteFondoFijo
     */
    public function find($id);

    /**
     * @param $data
     * @return ComprobanteFondoFijo
     */
    public function columns($data);

    /**
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function create(array $data);

    /**
     * Actualiza un nuevo registro de Comprobante de Fondo Fijo
     * @param array $data
     * @param  $id
     * @return mixed
     * @throws Exception
     */
    public function update(array $data, $id);

    /**
     * Elimina el Comprobante de Fondo Fijo
     * @param $id
     * @return mixed
     *
     */

    public function delete($id);

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations);

    /**
     * Regresa los Cierres Paginados de acuerdo a los parametros
     * @param array $data
     * @return Collection | ComprobanteFondoFijo
     */
    public function paginate(array $data);


    /**
     * Buscar conceptos
     * @param $attribute
     * @param $operator
     * @param $value
     * @return \Illuminate\Database\Eloquent\Collection|Concepto
     */
    public function getBy($attribute, $operator, $value, $with = null);

    /**
     * @param array $orWhere
     *
     * @return mixed
     */
    public function like(array $orWhere);

    /**
     * @param $limit
     *
     * @return mixed
     */
    public function limit($limit);
}