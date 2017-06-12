<?php namespace Ghi\Domain\Core\Contracts;

interface MovimientoRepository
{
    /**
     * Crea un nuevo registro de Movimiento
     * @param $data
     * @return \Ghi\Domain\Core\Models\MovimientoPoliza
     */
    public function create($data);

    /**
     * @param $id
     * @return \Ghi\Domain\Core\Models\MovimientoPoliza
     */
    public function getByPolizaTipoId($id);
}