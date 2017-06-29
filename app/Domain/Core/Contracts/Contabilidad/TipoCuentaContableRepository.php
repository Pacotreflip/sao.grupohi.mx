<?php namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface TipoCuentaContableRepository
{
    /**
     * Obtiene todas los Tipos de Cuentas Contables
     *
     * @return \Illuminate\Database\Eloquent\Collection|TipoCuentaContable
     */
    public function all();

    /**
     *  Obtiene Tipo de Cuenta Contable por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\TipoCuentaContable
     */
    public function find($id);

    /**
     * Guarda un nuevo registro de Tipo de Cuenta Contable
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\TipoCuentaContable
     * @throws \Exception
     */
    public function create($data);

    /**
     * Aplica un SoftDelete al Tipo de Cuenta Contable seleccionado
     * @param $data Motivo por el cual se elimina el registro
     * @param $id Identificador del registro de Tipo de Cuenta Contable que se va a eliminar
     * @return mixed
     * @throws \Exception
     */
    public function delete($data, $id);

    /**
     * Obtienes los tipos de cuentas contables en lista para combo
     * @return array
     */
    public function lists();

}