<?php

namespace Ghi\Domain\Core\Repositories\Finanzas;

use Ghi\Domain\Core\Contracts\Finanzas\SolicitudPagoRepository;
use Ghi\Domain\Core\Models\Finanzas\SolicitudPago;

class EloquentSolicitudPagoRepository implements SolicitudPagoRepository
{
    /**
     * @var SolicitudPago
     */
    protected $model;

    /**
     * EloquentSolicitudPagoRepository constructor.
     * @param SolicitudPago $model
     */
    public function __construct(SolicitudPago $model)
    {
        $this->model = $model;
    }


    /**
     * Devuelve todos los registros de solicitudes de pago
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Regresa registros de Solicitud de Pago paginados
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data)
    {
        $query = $this->model->with(['TipoTran']);

        foreach ($data['order'] as $order) {
            $query->orderBy($data['columns'][$order['column']]['data'], $order['dir']);
        }

        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }
}