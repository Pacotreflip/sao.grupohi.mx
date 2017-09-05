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
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function create(array $data);

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