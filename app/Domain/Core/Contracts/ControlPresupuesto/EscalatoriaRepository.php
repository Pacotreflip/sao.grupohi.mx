<?php

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;

use \Ghi\Domain\Core\Models\ControlPresupuesto\Escalatoria;

interface EscalatoriaRepository
{
    /**
     * Obtiene todos los registros de Escalatoria
     * @return Escalatoria
     */
    public function all();

    /**
     * Regresa las Variaciones de Volúmen Paginadas
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $data);

    /**
     * Guarda un registro de Escalatoria
     * @param array $data
     * @throws \Exception
     * @return Escalatoria
     */
    public function create(array $data);

    /**
     * Regresa un registro específico de Escalatoria
     * @param $id
     * @return Escalatoria
     */
    public function find($id);

    public function with($relations);

    /**
     * Autoriza una Escalatoria
     * @param $id
     * @param array $data
     * @return Escalatoria
     * @throws \Exception
     */
    public function  autorizar($id, array $data);

    /**
     * Rechaza una Escalatoria
     * @param array $data
     * @throws \Exception
     * @return Escalatoria
     */
    public function  rechazar(array $data);

    /**
     * Aplica una Escalatoria a un Presupuesto
     * @param Escalatoria $escalatoria
     * @param $id_base_presupuesto
     * @return bool
     * @internal param Escalatoria $Escalatoria
     */
    public function aplicar(Escalatoria $escalatoria, $id_base_presupuesto);
}