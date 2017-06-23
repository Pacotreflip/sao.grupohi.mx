<?php namespace Ghi\Domain\Core\Contracts;

interface CuentaContableRepository
{
    /**
     * Obtiene todas las cuentas contables
     * @param null|array|string $with
     * @return \Illuminate\Database\Eloquent\Collection|CuentaContable
     */
    public function all($with = null);

    /**
     * Obtiene una cuenta contable por su Id
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaContable
     */
    public function find($id);

    /**
     * Guarda un registro de cuenta contable
     * @param array $data
     * @return \Ghi\Domain\Core\Models\CuentaContable
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Actualiza un registro de cuenta contable
     * @param array $data
     * @return \Ghi\Domain\Core\Models\CuentaContable
     * @throws \Exception
     */
    public function update(array $data);
}