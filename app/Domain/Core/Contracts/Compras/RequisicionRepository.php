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
     * @param $id Identificador de la Transaccion
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Transacciones\Transaccion
     */
    public function find($id);

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations);

}