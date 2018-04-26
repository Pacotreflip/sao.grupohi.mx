<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 18/04/18
 * Time: 17:35
 */

namespace Ghi\Domain\Core\Repositories\Programacion;

use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Contracts\Procuracion\AsignacionesRepository;
use Ghi\Domain\Core\Models\Procuracion\Asignaciones;

class EloquentAsignacionesRepository implements AsignacionesRepository
{
    /**
     * @var Asignaciones
     */
    private $model;

    /**
     * EloquentAsignacionesRepository constructor.
     * @param Asignaciones $model
     */
    public function __construct(Asignaciones $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Procuracion\Asignaciones
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Guartdar un nuevo registro
     * @param array $data
     * @return TraspasoCuentas
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $record = $this->model->create($data);
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $record->id;
    }

    /**
     * @param array $relations
     * @return $this|mixed
     */
    public function with(array $relations) {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param array $where
     * @return $this|mixed
     */
    public function where(array $where) {
        $this->model = $this->model->where($where);
        return $this;
    }
    /**
     * Aplica un SoftDelete a la asignacion seleccionada
     * @param $id Identificador del registro de asinacion se va a eliminar
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $item = $this->model->where('id', '=', $id);

            if (!$item) {
                throw new \Exception('no se esta el registro');
            }

            $item->delete($id);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $id;
    }

    /**
     * Regresa las Asignaciones Paginados de acuerdo a los parametros
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data)
    {
        $query = $this->model;

        foreach ($data['order'] as $order) {
            $query->orderBy($data['columns'][$order['column']]['data'], $order['dir']);
        }

        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * @param array $data
     * @return array|mixed
     */
    public function exists(array $data)
    {
        $where = [
            ['id_transaccion', '=', $data['id_transaccion']],
            ['id_usuario_asignado', '=', $data['id_usuario_asignado']]
        ];
        $whereAsignacion = $this->with(['usuario_asigna','usuario_asignado','transaccion.tipotran','transaccion'])
            ->where($where)->all()->toArray();

        return $whereAsignacion;
    }

    public function refresh()
    {
        self::__construct(new Asignaciones);
        return $this;
    }
}