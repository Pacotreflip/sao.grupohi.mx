<?php

namespace Ghi\Domain\Core\Contracts\Tesoreria;

use Ghi\Domain\Core\Models\Tesoreria\TraspasoTransaccion;

interface TraspasoTransaccionRepository
{
     /**
     * Guartdar un nuevo registro
     * @param array $data
     * @return TraspasoTransaccion
     * @throws \Exception
     */
    public function create($data);

    public function all();

    /**
     * Aplica un SoftDelete al Tipo de TraspasoTransaccion seleccionado
     * @param $id Identificador del registro de Tipo de TraspasoTransaccion que se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($id);
}
