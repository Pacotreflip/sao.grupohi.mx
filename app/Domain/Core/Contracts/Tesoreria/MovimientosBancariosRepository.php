<?php

namespace Ghi\Domain\Core\Contracts\Tesoreria;

use Ghi\Domain\Core\Models\Tesoreria\MovimientosBancarios;

interface MovimientosBancariosRepository
{
     /**
     * Guardar un nuevo registro
     * @param array $data
     * @return MovimientosBancarios
     * @throws \Exception
     */
    public function create($data);

    public function all();

    /**
     * Aplica un SoftDelete al Tipo de MovimientosBancarios seleccionado
     * @param $id Identificador del registro de Tipo de MovimientosBancarios que se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($id);
}
