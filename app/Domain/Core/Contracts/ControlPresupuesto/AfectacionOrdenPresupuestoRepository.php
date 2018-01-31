<?php
namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;


interface AfectacionOrdenPresupuestoRepository
{
    /**
     * Obtiene todos los registros del estatus
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\ControlPresupuesto\AfectacionOrdenesPresupuesto
     */
    public function all();

    /**
     * Obtiene un estatus que coincida con la búsqueda
     * @param $attribute
     * @param $value
     * @return \Ghi\Domain\Core\Models\ControlPresupuesto\AfectacionOrdenesPresupuesto
     */
    public function getBy($attribute,$operator, $value);

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations);
}