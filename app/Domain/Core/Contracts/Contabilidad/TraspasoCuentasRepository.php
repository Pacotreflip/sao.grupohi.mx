<?php

namespace Ghi\Domain\Core\Contracts\Contabilidad;

use Ghi\Domain\Core\Models\Contabilidad\TraspasoCuentas;

interface TraspasoCuentasRepository
{
    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Contabilidad\TraspasoCuentasRepository
     */

    /**
     * Guartdar un nuevo registro
     * @param array $data
     * @return TraspasoCuentas
     * @throws \Exception
     */
    public function create($data);

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
}
