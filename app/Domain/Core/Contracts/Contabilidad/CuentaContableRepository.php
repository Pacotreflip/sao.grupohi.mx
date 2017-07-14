<?php
namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface CuentaContableRepository
{
    /**
     * Obtiene todas las cuentas contables
     * @return \Illuminate\Database\Eloquent\Collection|CuentaContable
     */
    public function all();

    /**
     * Obtiene una cuenta contable por su Id
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaContable
     */
    public function find($id);

    /**
     * Obtiene una Cuenta Contable que coincida con la búsqueda
     * @param $attribute
     * @param $value
     * @return \Ghi\Domain\Core\Models\CuentaContable
     */
    public function findBy($attribute, $value);

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
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaContable
     * @throws \Exception
     */
    public function update(array $data,$id);

    /**Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     * @internal param array $array
     */
    public function with($relations);
}