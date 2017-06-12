<?php namespace Ghi\Domain\Core\Contracts;


interface TipoMovimientoRepository
{
    /**
     * Obtiene los tipos de Movimiento en forma de lista para combos
     * @return  \Illuminate\Database\Eloquent\Collection|TipoMovimiento
     */
    public function lists();
}