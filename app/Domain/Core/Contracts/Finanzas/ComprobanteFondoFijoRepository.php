<?php

namespace Ghi\Domain\Core\Contracts\Finanzas;

interface ComprobanteFondoFijoRepository
{
    /**
     * Obtiene todos los registros de Comprobantes de Fondo Fijo
     * @return mixed
     */
    public function all();

    /**
     * @param $id
     * @return Ghi\Domain\Core\Models\Finanzas\ComprobanteFondoFijo
     */
    public function find($id);

    /**
     * @param $data
     * @return Ghi\Domain\Core\Models\Finanzas\ComprobanteFondoFijo
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

}