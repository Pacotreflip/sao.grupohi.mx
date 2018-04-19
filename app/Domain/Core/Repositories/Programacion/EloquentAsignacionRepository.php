<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 18/04/18
 * Time: 17:35
 */

namespace Ghi\Domain\Core\Repositories\Programacion;


use Ghi\Domain\Core\Contracts\Procuracion\AsignacionRepository;
use Ghi\Domain\Core\Models\Procuracion\Asingacion;

class EloquentAsignacionRepository implements AsignacionRepository
{
    /**
     * @var Asingacion
     */
    private $model;

    /**
     * EloquentAsignacionRepository constructor.
     * @param Asingacion $model
     */
    public function __construct(Asingacion $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Procuracion\Asingacion
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

    public function with($relations) {
        $this->model = $this->model->with($relations);
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

            $item = $this->model->where('id_traspaso_transaccion', '=', $id);

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
}