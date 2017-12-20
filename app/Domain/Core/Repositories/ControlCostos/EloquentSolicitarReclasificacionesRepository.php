<?php

namespace Ghi\Domain\Core\Repositories\ControlCostos;

use Ghi\Domain\Core\Contracts\ControlCostos\SolicitarReclasificacionesRepository;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Models\ControlCostos\SolicitarReclasificaciones;

class EloquentSolicitarReclasificacionesRepository implements SolicitarReclasificacionesRepository
{
    /**
     * @var SolicitarReclasificaciones $model
     */
    private $model;

    /**
     * EloquentSolicitarReclasificacionesRepository constructor.
     * @param SolicitarReclasificaciones $model
     */
    public function __construct(SolicitarReclasificaciones $model)
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

            $record = SolicitarReclasificaciones::create($data);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return SolicitarReclasificaciones::where('id_solicitar_reclasificacion', '=', $record->id_solicitar_reclasificacion)->first();
    }

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations) {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        // Define el error a mostrar
        $error = 'No se encontró la solicitud de reclasificación que se desea eliminar';

        try {
            $item = $this->model->where('id_solicitar_reclasificacion', '=', $id);

            if (!$item) {
                throw new HttpResponseException(new Response($error, 404));
                return;
            }

            DB::connection('cadeco')->beginTransaction();
            $item->delete($id);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $id;
    }

    public function update($data, $id)
    {
        // Define el error a mostrar
        $error = 'No se encontró la solicitud de reclasificación que se desea editar';

        try {
            $item = $this->model->find($id);

            if (!$item) {
                throw new HttpResponseException(new Response($error, 404));
                return;
            }

            DB::connection('cadeco')->beginTransaction();
            $item->update($data);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $this->model->with(['tipo', 'cuenta.empresa', 'movimiento_transaccion.transaccion'])->find($item->id_movimiento_bancario);
    }

    public function obras()
    {
        return Obra::all();
    }
}
