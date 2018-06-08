<?php
namespace Ghi\Domain\Core\Contracts\Compras;


interface OrdenCompraRepository
{
    /**
     * @param integer $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Compras\OrdenCompra
     */
    public function find($id);

    public function search($value, array $columns);

    public function limit($limit);

    public function with($relations);
}