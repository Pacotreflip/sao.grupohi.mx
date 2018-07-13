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
        return $this->model->get();
    }

    /**
     * Regresa registros de Solicitud de Pago paginados
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data)
    {
        $query = $this->model;


        $query->where(function ($q) use ($data){
            $q
                ->where('numero_folio', 'LIKE', '%' . $data['search']['value'] . '%')
                ->orWhere('observaciones', 'LIKE', '%' . $data['search']['value'] . '%')
                ->orWhere('referencia', 'LIKE', '%' . $data['search']['value'] . '%')
                ->orWhere('destino', 'LIKE', '%' . $data['search']['value'] . '%')
                ->orWhere('monto', 'LIKE', '%' . $data['search']['value'] . '%');
        });

        foreach ($data['order'] as $order) {
            $query->orderBy($data['columns'][$order['column']]['data'], $order['dir']);
        }

        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * Devuelve modelo relacionado con otros modelos
     * @param $with
     * @return EloquentSolicitudPagoRepository
     */
    public function with($with) {
        $this->model = $this->model->with($with);
        return $this;
    }

    /**
     * @param $conditions
     * @return EloquentSolicitudPagoRepository
     */
    public function where($conditions)
    {
        if($conditions) {
            $this->model = $this->model->where($conditions);
        }
        return $this;
    }

    /**
     * @param $column
     * @param $values
     * @return EloquentSolicitudPagoRepository
     */
    public function whereBetween($column, $values) {
        if($column && $values) {
            $this->model = $this->model->whereBetween($column, $values);
        }
        return $this;
    }
}