<?php

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;

interface PresupuestoRepository
{
    /**
     * @return mixed
     */
    public function getMaxNiveles();

    /**
     * @return mixed
     */
    public function getOperadores();
}