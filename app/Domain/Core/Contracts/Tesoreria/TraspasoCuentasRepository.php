<?php

namespace Ghi\Domain\Core\Contracts\Tesoreria;

use Ghi\Domain\Core\Models\Tesoreria\TraspasoCuentas;

interface TraspasoCuentasRepository
{
    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Tesoreria\TraspasoCuentasRepository
     */

    /**
     * Guartdar un nuevo registro
     * @param array $data
     * @return TraspasoCuentas
     * @throws \Exception
     */
    public function create($data);

    /**
     * @return mixed
     */
    public function all();

    /**
     * Aplica un SoftDelete al Tipo de Traspaso entre cuentas seleccionado
     * @param $id Identificador del registro de Tipo de Traspaso entre cuentas que se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($id);

    /**
     *  Edita el tipo de traspaso entre cuentas seleccionado
     * @param $data
     * @param $id
     * @return int $id
     * @throws \Exception
     */
    public function update($data, $id);

    /**
     * Regresa registros de traspaso entre cuentas seleccionado
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data);

    /**
     * Regresa el Registro de traspaso cuenta buscado
     * @param $id
     * @return TraspasoCuentasRepository
     */
    public function find($id);

    /**
     * @param $relations
     * @return TraspasoCuentasRepository
     */
    public function with($relations);

}
