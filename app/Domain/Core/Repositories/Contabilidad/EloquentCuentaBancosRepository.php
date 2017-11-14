<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaBancosRepository;

use Ghi\Domain\Core\Models\Contabilidad\CuentaBancos;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EloquentCuentaBancosRepository implements CuentaBancosRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\CuentaBancos
     */
    protected $model;

    public function __construct(CuentaBancos $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->get();
    }

    public function create($data)
    {

    }

    public function delete(array $data, $id)
    {
        try {
            $cuenta = $this->model->find($id);
            $cuenta->estatus = 0;
            $cuenta->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param array $data
     * @param $id
     */
    public function update(array $data, $id)
    {

    }

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * @param array $where
     * @return $this
     */
    public function where(array $where)
    {
        $this->model = $this->model->where($where);

        return $this;
    }

    /**
     *  Obtiene Cuenta contable bancaria por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaBancos
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function getCount($id_cuenta){
        return $this->model->where('id_cuenta', '=', $id_cuenta)->count();
    }
}