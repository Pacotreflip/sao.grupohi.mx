<?php
namespace Ghi\Domain\Core\Contracts\Compras;

interface TipoRequisicionRepository
{
    /**
     * Obtiene todos los registros de Tipo de Requisición
     *
     * @return \Illuminate\Database\Eloquent\Collection|TipoRequisicion
     */
    public function all();
}