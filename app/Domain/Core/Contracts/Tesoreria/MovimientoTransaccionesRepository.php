<?php

namespace Ghi\Domain\Core\Contracts\Tesoreria;

use Ghi\Domain\Core\Models\Tesoreria\TraspasoTransaccion;

interface MovimientoTransaccionesRepository
{
     /**
     * Guartdar un nuevo registro
     * @param array $data
     * @return MovimientoTransacciones
     * @throws \Exception
     */
    public function create($data);

    public function all();

    /**
     * Aplica un SoftDelete al Tipo de MovimientoTransacciones seleccionado
     * @param $id Identificador del registro de Tipo de MovimientoTransacciones que se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($id);
}
