<?php namespace Ghi\Domain\Core\Contracts;

interface CuentaContableRepository
{
    /**
     * Obtiene una cuenta contable por su Id
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaContable
     */
    public function getById($id);

    /**
     * Obtiene las cuentas contables en forma de lista para combos
     * @return \Illuminate\Database\Eloquent\Collection|CuentaContable
     */
    public function lists();
}