<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 12:20 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioRechazadaRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioRechazada;

class EloquentSolicitudCambioRechazadaRepository implements SolicitudCambioRechazadaRepository
{
    /**
     * @var SolicitudCambioRechazada
     */
    protected $model;

    public function __construct(SolicitudCambioRechazada $model)
    {
        $this->model = $model;
    }


    /**
     * Obtiene todos los registros de SolicitudCambioRechazada
     *
     * @return SolicitudCambioRechazada
     */
    public function all()
    {
        return $this->model->get();
    }


    /**
     * Guarda un registro de SolicitudCambioRechazada
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambioRechazada
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $solicitudCambioRechazada= $this->model->create($data);
            DB::connection('cadeco')->commit();
            return $solicitudCambioRechazada;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Regresa un registro específico de SolicitudCambioRechazada
     * @param $id
     * @return SolicitudCambioRechazada
     */
    public function find($id)
    {
        $solicitudCambio = $this->model->find($id);
        return $solicitudCambio;
    }
}