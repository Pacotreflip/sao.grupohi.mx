<?php
namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface CuentaCostoRepository
{
    /**
     * Guarda un registro de cuenta concepto
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaCosto
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Actualiza un registro de cuenta concepto
     * @param array $data
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaCosto
     * @throws \Exception
     */
    public function update(array $data,$id);
}