<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 06:39 PM
 */

namespace Ghi\Domain\Core\Contracts;


interface EmpresaRepository
{
    /**
     * @param $with
     * @return \Ghi\Domain\Core\Models\Contabilidad\collection|CuentaEmpresa
     */
    public function all();

    /**
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaEmpresa
     */
    public function find($id);

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations);

    /**
     * Aplica un scope a la consulta de Empresas
     */
    public function scope($scope);

    /**
     * Crea una nueva Empreas
     */
    public function create(array $data);
}