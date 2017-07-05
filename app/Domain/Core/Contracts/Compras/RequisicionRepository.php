<?php
namespace Ghi\Domain\Core\Contracts\Compras;


interface RequisicionRepository
{
    /**
     * Obtiene todos los registros de Requisicion
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Transacciones\Transaccion
     */
    public function all();

    /**
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Transacciones\Transaccion
     */
    public function find($id);
    /**
     * Guarda un registro de Transaccion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Transacciones\Transaccion
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations);
}