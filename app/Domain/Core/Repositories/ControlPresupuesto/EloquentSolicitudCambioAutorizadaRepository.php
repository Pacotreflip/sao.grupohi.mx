<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 12:20 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioAutorizadaRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;

class EloquentSolicitudCambioAutorizadaRepository implements SolicitudCambioAutorizadaRepository
{
    /**
     * @var SolicitudCambioAutorizada
     */
    protected $model;

    public function __construct(SolicitudCambioAutorizada $model)
    {
        $this->model = $model;
    }


    /**
     * Obtiene todos los registros de SolicitudCambioAutorizada
     *
     * @return SolicitudCambioAutorizada
     */
    public function all()
    {
        return $this->model->get();
    }


    /**
     * Guarda un registro de SolicitudCambioAutorizada
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambioAutorizada
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $solicitudCambioAutorizada = $this->model->create($data);
            DB::connection('cadeco')->commit();
            return $solicitudCambioAutorizada;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Regresa un registro específico de SolicitudCambioAutorizada
     * @param $id
     * @return SolicitudCambioAutorizada
     */
    public function find($id)
    {
        $solicitudCambio = $this->model->find($id);
        return $solicitudCambio;
    }
}