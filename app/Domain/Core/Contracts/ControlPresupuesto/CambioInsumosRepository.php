<?php

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;

use \Ghi\Domain\Core\Models\ControlPresupuesto\CambioInsumos;

interface CambioInsumosRepository
{
    /**
     * Obtiene todos los registros de CambioInsumos
     * @return CambioInsumos
     */
    public function all();

    /**
     * Regresa las Variaciones de Volúmen Paginadas
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $data);

    /**
     * Guarda un registro de CambioInsumos
     * @param array $data
     * @throws \Exception
     * @return CambioInsumos
     */
    public function create(array $data);

    /**
     * Regresa un registro específico de CambioInsumos
     * @param $id
     * @return CambioInsumos
     */
    public function find($id);

    public function with($relations);

    /**
     * Autoriza una CambioInsumos
     * @param $id
     * @param array $data
     * @return CambioInsumos
     * @throws \Exception
     */
    public function  autorizar($id, array $data);

    /**
     * Rechaza una CambioInsumos
     * @param array $data
     * @throws \Exception
     * @return CambioInsumos
     */
    public function  rechazar(array $data);

    /**
     * Aplica una CambioInsumos a un Presupuesto
     * @param CambioInsumos $CambioInsumos
     * @param $id_base_presupuesto
     * @return bool
     * @internal param CambioInsumos $CambioInsumos
     */
    public function aplicar(CambioInsumos $cambio_insumos, $id_base_presupuesto);
}