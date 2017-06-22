<?php namespace Ghi\Domain\Core\Contracts;


interface PolizasRepository
{

    /**
     * Obtiene todas las polizas
     *
     * @return \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function all($with = null);
}