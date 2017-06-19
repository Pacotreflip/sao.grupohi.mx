<?php namespace Ghi\Domain\Core\Contracts;

interface TipoCuentaContableRepository
{
    /**
     * Obtiene todas los Tipos de Cuentas Contables
     *
     * @return \Illuminate\Database\Eloquent\Collection|TipoCuentaContable
     */
    public function all();
}