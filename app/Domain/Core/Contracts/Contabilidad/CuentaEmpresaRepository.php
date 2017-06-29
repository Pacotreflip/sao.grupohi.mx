<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 02:39 PM
 */

namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface CuentaEmpresaRepository
{
    /**
     * Obtiene todas las Cuentas de la Empresa
     *
     * @return \Illuminate\Database\Eloquent\Collection|CuentaEmpresa
     */
    public function all($with);

    /**
     *  Obtiene Cuenta de Empresa por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaEmpresa
     */
    public function find($id);

    /**
     * Guarda un nuevo registro de Cuenta CuentaEmpresa
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\CuentaEmpresa
     * @throws \Exception
     */
    public function create($data);

    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|CuentaEmpresa
     * @throws \Exception
     */
    public function delete(array $data, $id);

    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|CuentaEmpresa
     * @throws \Exception
     */
    public function update(array $data, $id);

}