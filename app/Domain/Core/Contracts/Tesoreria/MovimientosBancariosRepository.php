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

    /**
     * @return mixed
     */
    public function all();

    /**
     * Aplica un SoftDelete al Tipo de MovimientosBancarios seleccionado
     * @param $id Identificador del registro de Tipo de MovimientosBancarios que se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($id);

    /**
     * Regresa registros de movimientos bancarios entre cuentas seleccionado
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data);

    /**
     * Regresa el Registro de un movimiento bancario buscado
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
