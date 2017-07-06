<?php
namespace Ghi\Domain\Core\Contracts\Compras;


interface DepartamentoResponsableRepository
{
    /**
     * Obtiene todos los registros de Departamento Responsable
     *
     * @return \Illuminate\Database\Eloquent\Collection|DepartamentoResponsable
     */
    public function all();
}