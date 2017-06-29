<?php
namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface CuentaConceptoRepository
{
    /**
     * Guarda un registro de cuenta concepto
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Actualiza un registro de cuenta concepto
     * @param array $data
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaConcepto
     * @throws \Exception
     */
    public function update(array $data,$id);
}