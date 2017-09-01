<?php

namespace Ghi\Domain\Core\Contracts\Contabilidad;

use Ghi\Domain\Core\Models\Contabilidad\CuentaFondo;

interface CuentaFondoRepository
{
    /**
     * Guarda un registro de cuenta de fondo
     * @param array $data
     * @return CuentaFondo
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Actualiza un registro de cuenta de fondo
     * @param array $data
     * @param $id
     * @return CuentaFondo
     * @throws \Exception
     */
    public function update(array $data,$id);
}