<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/06/2018
 * Time: 01:48 PM
 */

namespace Ghi\Domain\Core\Repositories\Finanzas;


use Ghi\Domain\Core\Contracts\Finanzas\SolicitudRecursosRepository;
use Ghi\Domain\Core\Models\Finanzas\SolicitudRecursos;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentSolicitudRecursosRepository
 * @package Ghi\Domain\Core\Repositories\Finanzas
 */
class EloquentSolicitudRecursosRepository implements SolicitudRecursosRepository
{

    /**
     * @var SolicitudRecursos
     */
    protected $model;

    /**
     * EloquentSolicitudRecursosRepository constructor.
     * @param SolicitudRecursos $solicitudRecursos
     */
    public function __construct(SolicitudRecursos $solicitudRecursos)
    {
        $this->model = $solicitudRecursos;
    }

    /**
     * Crea un registro de Solicitud de Recursos con sus Partidas
     *
     * @return SolicitudRecursos|mixed
     * @throws \Exception
     */
    public function create()
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $record = $this->model->create();

            DB::connection('cadeco')->commit();
            return $record;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    public function paginate(array $data)
    {
        $query = $this->model->with(['usuario', 'partidas']);


        $query->where(function ($q) use ($data) {
            $q
                ->where('folio', 'LIKE', '%' . $data['search']['value'] . '%');
        });

        foreach ($data['order'] as $order) {
            $query->orderBy($data['columns'][$order['column']]['data'], $order['dir']);
        }

        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * Devuelve modelo relacionado con otros modelos
     * @param $with
     * @return EloquentSolicitudRecursosRepository
     */
    public function with($with)
    {
        $this->model = $this->model->with($with);
        return $this;
    }

    /**
     * @param $id
     * @return SolicitudRecursos|mixed
     */
    public function finalizar($id)
    {
        $solicitud = $this->model->findOrFail($id);

        $solicitud->estado = 2;
        $solicitud->save();
    }
}