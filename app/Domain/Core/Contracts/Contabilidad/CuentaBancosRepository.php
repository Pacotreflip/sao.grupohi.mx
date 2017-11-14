<?php


namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface CuentaBancosRepository
{
    /**
     * Obtiene todas las Cuentas de la Empresa
     *
     * @return \Illuminate\Database\Eloquent\Collection|CuentaBancos
     */
    public function all();

    /**
     *  Obtiene Cuenta contable bancaria por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaBancos
     */
    public function find($id);

    /**
     * Guarda un nuevo registro de Cuenta CuentaBancos
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\CuentaBancos
     * @throws \Exception
     */
    public function create($data);

    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|CuentaBancos
     * @throws \Exception
     */
    public function delete(array $data, $id);

    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|CuentaBancos
     * @throws \Exception
     */
    public function update(array $data, $id);

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations);

    /**
     *  Contiene los parametros de búsqueda
     * @param array $where
     * @return mixed
     */
    public function where(array $where);

}