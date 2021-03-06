<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 06:39 PM
 */

namespace Ghi\Domain\Core\Contracts;


use Ghi\Domain\Core\Models\Empresa;

interface EmpresaRepository
{
    /**
     * @param $with
     *
     * @return \Ghi\Domain\Core\Models\Contabilidad\collection|CuentaEmpresa
     */
    public function all();

    /**
     * @param $id
     *
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaEmpresa
     */
    public function find($id);

    /**Crea relaciones con otros modelos
     *
     * @param array $array
     *
     * @return mixed
     */
    public function with($relations);

    /**
     * Aplica un scope a la consulta de Empresas
     */
    public function scope($scope);

    /**
     * Crea un registro de Empresa
     *
     * @param array $data
     *
     * @return Empresa
     */
    public function create(array $data);

    /**
     * Devuelve una lista de empresas para listas
     * @return array
     */
    public function lists();
}