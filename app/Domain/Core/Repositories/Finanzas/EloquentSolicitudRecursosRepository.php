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
     * @throws \Exception
     */
    public function finalizar($id)
    {
        try {
            $solicitud = $this->model->findOrFail($id);
            if($solicitud->partidas()->count() == 0) {
                throw new \Exception('Seleccione por lo menos uns Transacción para esta Solicitud para poder finalizar');
            }

            $solicitud->estado = 2;
            $solicitud->save();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $id
     * @param $id_transaccion
     * @throws \Exception
     */
    public function addPartida($id, $id_transaccion)
    {
        try {
            $solicitud = $this->model->findOrFail($id);

            if($solicitud->partidas()->where('id_transaccion', '=', $id_transaccion)->first()) {
                throw new \Exception('La Transacción que desea agregar ya esta contenida en esta Solicitud');
            }
            $solicitud->partidas()->create([
                'id_transaccion' => $id_transaccion
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $id
     * @param $id_transaccion
     * @throws \Exception
     */
    public function removePartida($id, $id_transaccion)
    {
        try {
            $solicitud = $this->model->findOrFail($id);
            if(! $solicitud->partidas()->where('id_transaccion', '=', $id_transaccion)->first()) {
                throw new \Exception('La Transacción que desea quitar no esta contenida en esta Solicitud');
            }
            $solicitud->partidas()->where('id_transaccion', '=', $id_transaccion)->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        try {
            $solicitud = $this->model->find($id);
            if(! $solicitud) {
                throw new \Exception('No se pudo encontrar la solicitud');
            }
            return $solicitud;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}