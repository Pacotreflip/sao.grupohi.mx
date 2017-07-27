<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 25/07/2017
 * Time: 06:32 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;


use Ghi\Domain\Core\Contracts\Contabilidad\PolizaMovimientoRepository;
use Ghi\Domain\Core\Models\Contabilidad\PolizaMovimiento;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class EloquentPolizaMovimientoRepository implements PolizaMovimientoRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\Contabilidad\PolizaMovimiento
     */
    private $model;

    /**
     * EloquentPolizaMovimientoRepository constructor.
     * @param \Ghi\Domain\Core\Models\Contabilidad\PolizaMovimiento
     */
    public function __construct(PolizaMovimiento $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Contabilidad\PolizaMovimiento
     */
    public function find($id)
    {
        return $this->model->find($id);
    }


    public function where(array $where)
    {
        $this->model = $this->model->where($where);
        return $this;
    }

    /**
     * Obtiene todos los movimientos
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Contabilidad\PolizaMovimiento
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {

            DB::connection('cadeco')->beginTransaction();
            $this->model->find($id);
            $item=$this->model->update($data);
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
        return $item;
    }

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    public function scope($scope)
    {
        $this->model = $this->model->$scope();
        return $this;
    }
}