<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 26/06/2017
 * Time: 11:05 AM
 */

namespace Ghi\Domain\Core\Contracts;


interface CuentaMaterialRepository
{
    /**
     * Obtiene todas las Cuentas de Materiales
     *
     * @return \Illuminate\Database\Eloquent\Collection|CuentaMaterial
     */
    public function all();

    /**
     * Obtiene todas las Cuentas de Materiales padre
     *
     * @return \Illuminate\Database\Eloquent\Collection|CuentaMaterial
     */
    public function getBy($attribute, $operador, $value, $tipo);

    /**
     *  Obtiene Cuenta de Material por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaMaterial
     */
    public function find($id);

    /**
     * Guarda un nuevo registro de Cuenta Material
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\CuentaMaterial
     * @throws \Exception
     */
    public function create($data);

    /**
     * Aplica un SoftDelete a la Cuenta de Material seleccionado
     * @param $data Motivo por el cual se elimina el registro
     * @param $id Identificador del registro de al Cuenta de Material que se va a eliminar
     * @return mixed
     * @throws \Exception
     */
    public function delete($data, $id);
}