<?php

namespace Ghi\Domain\Core\Repositories\ControlCostos;

use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionRepository;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Models\ControlCostos\SolicitudReclasificacion;

class EloquentSolicitudReclasificacionRepository implements SolicitudReclasificacionRepository
{
    /**
     * @var SolicitudReclasificacion $model
     */
    private $model;

    /**
     * EloquentSolicitudReclasificacionRepository constructor.
     * @param SolicitudReclasificacion $model
     */
    public function __construct(SolicitudReclasificacion $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Tesoreria\SolicitarReclasificaciones
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $record = SolicitudReclasificacion::create($data);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return SolicitudReclasificacion::where('id', '=', $record->id)->first();
    }

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations) {
        $this->model = $this->model->with($relations);
        return $this;
    }

    public function paginate(array $data)
    {
        $query = $this->model->with(['autorizadas.usuario', 'rechazadas.usuario', 'usuario', 'estatus', 'partidas.item.material', 'partidas.item.transaccion.tipoTransaccion', 'partidas.conceptoNuevo', 'partidas.conceptoOriginal'])->select('ControlCostos.solicitud_reclasificacion.*')->orderBy('ControlCostos.solicitud_reclasificacion.created_at', 'DESC');
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    public function reporte($id)
    {
        return $this->model->with([
            'autorizadas.usuario',
            'rechazadas.usuario',
            'usuario',
            'estatus',
            'partidas.item.material',
            'partidas.item.transaccion.tipoTransaccion',
            'partidas.conceptoNuevo', 'partidas.conceptoOriginal'
        ])
            ->where('id', '=', $id)
            ->select('ControlCostos.solicitud_reclasificacion.*')
            ->orderBy('ControlCostos.solicitud_reclasificacion.created_at', 'DESC')->first();

    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function update($data, $id)
    {
        // TODO: Implement update() method.
    }
}
