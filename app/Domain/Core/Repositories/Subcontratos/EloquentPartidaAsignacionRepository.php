<?php

namespace Ghi\Domain\Core\Repositories\Subcontratos;


use Ghi\Domain\Core\Contracts\Subcontratos\PartidaAsignacionRepository;
use Ghi\Domain\Core\Models\Subcontratos\PartidaAsignacion;

/**
 * Class EloquentPartidaAsignacionRepository
 * @package Ghi\Domain\Core\Repositories\Subcontratos
 */
class EloquentPartidaAsignacionRepository implements PartidaAsignacionRepository
{
    /**
     * @var PartidaAsignacion
     */
    protected $model;


    /**
     * EloquentAlmacenRepository constructor.
     * @param PartidaAsignacion $model
     */
    public function __construct(PartidaAsignacion $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos las partidas asignadas
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Subcontratos\PartidaAsignacionRepository
     */
    public function get()
    {
        return $this->model->get();
    }

    /**
     * @param $id Identificador de la Cuenta de Almacen que se va a mostrar
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Subcontratos\PartidaAsignacionRepository
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Guartdar un nuevo registro
     * @param array $data
     * @return PartidaAsignacionRepository
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            $record = $this->model->create($data);
        } catch (\Exception $e) {
            throw $e;
        }

        return $record;
    }

    /**
     * @param array $where
     * @return $this|mixed
     */
    public function where(array $where)
    {
        $this->model = $this->model->where($where);
        return $this;
    }
}