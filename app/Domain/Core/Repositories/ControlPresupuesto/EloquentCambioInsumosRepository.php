<?php

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CambioInsumosRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\AfectacionOrdenesPresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioRechazada;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Ghi\Domain\Core\Models\ControlPresupuesto\CambioInsumos;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class EloquentCambioInsumosRepository implements CambioInsumosRepository
{
    /**
     * @var CambioInsumos
     */
    private $model;

    /**
     * EloquentSolicitudCambioRepository constructor.
     * @param CambioInsumos $model
     */
    public function __construct(CambioInsumos $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de CambioInsumos
     * @return CambioInsumos
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Regresa las Variaciones de Volúmen Paginadas
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $data)
    {
        $query = $this->model->with(['tipoOrden', 'userRegistro', 'estatus']);
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * Guarda un registro de CambioInsumos
     * @param array $data
     * @throws \Exception
     * @return CambioInsumos
     */
    public function create(array $data)
    {

    }

    /**
     * Regresa un registro específico de CambioInsumos
     * @param $id
     * @return CambioInsumos
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    public function with($relations)
    {
        $this->model->with($relations);
        return $this;
    }

    /**
     * Autoriza una CambioInsumos
     * @param $id
     * @param array $data
     * @return CambioInsumos
     * @throws \Exception
     */
    public function autorizar($id, array $data)
    {

    }

    /**
     * Rechaza una CambioInsumos
     * @param array $data
     * @throws \Exception
     * @return CambioInsumos
     */
    public function rechazar(array $data)
    {

    }

    /**
     * Aplica una CambioInsumos a un Presupuesto
     * @param CambioInsumos $CambioInsumos
     * @param $id_base_presupuesto
     * @return void
     */
    public function aplicar(CambioInsumos $CambioInsumos, $id_base_presupuesto)
    {
 
    }
}
