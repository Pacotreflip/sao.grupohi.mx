<?php
namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;


interface EstatusRepository
{
    /**
     * Obtiene todos los registros del estatus
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\ControlPresupuesto\Estatus
     */
    public function all();

    /**
     * Obtiene un estatus que coincida con la búsqueda
     * @param $attribute
     * @param $value
     * @return \Ghi\Domain\Core\Models\ControlPresupuesto\Estatus
     */
    public function findBy($attribute, $value);
}