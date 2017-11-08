<?php

namespace Ghi\Domain\Core\Contracts\Tesoreria;

interface TiposMovimientosRepository
{
     /**
     * Guardar un nuevo registro
     * @param array $data
     * @return TiposMovimientos
     * @throws \Exception
     */
    public function create($data);

    public function all();

    /**
     * Aplica un SoftDelete al Tipo de TiposMovimientos seleccionado
     * @param $id Identificador del registro de Tipo de TiposMovimientos que se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($id);
}
