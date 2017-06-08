<?php namespace Ghi\Domain\Core\Contracts;

interface PolizaTipoRepository
{
    /**
     * Obtiene todas las polizas tipo
     *
     * @return Collection|PolizaTipo
     */
    public function getAll();
}