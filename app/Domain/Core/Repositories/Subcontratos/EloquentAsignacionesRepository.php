<?php

namespace Ghi\Domain\Core\Repositories\Subcontratos;


use Ghi\Domain\Core\Contracts\Subcontratos\AsignacionesRepository;
use Ghi\Domain\Core\Models\Subcontratos\Asignaciones;

/**
 * Class EloquentAsignacionesRepository
 * @package Ghi\Domain\Core\Repositories\Subcontratos
 */
class EloquentAsignacionesRepository implements AsignacionesRepository
{
    /**
     * @var Asignaciones
     */
    protected $model;


    /**
     * EloquentAlmacenRepository constructor.
     * @param Asignaciones $model
     */
    public function __construct(Asignaciones $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id Identificador de Asignaciones
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Subcontratos\AsignacionesRepository
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Guartdar un nuevo registro
     * @param array $data
     * @return AsignacionesRepository
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
}