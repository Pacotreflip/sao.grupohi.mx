<?php

namespace Ghi\Domain\Core\Repositories\Finanzas;

use Ghi\Domain\Core\Contracts\Finanzas\PagoCuentaRepository;
use Ghi\Domain\Core\Models\Finanzas\PagoCuenta;
use Illuminate\Support\Facades\DB;

class EloquentPagoCuentaRepository implements PagoCuentaRepository
{
    /**
     * @var PagoCuenta
     */
    protected $model;

    /**
     * EloquentPagoCuentaRepository constructor.
     * @param PagoCuenta $model
     */
    public function __construct(PagoCuenta $model)
    {
        $this->model = $model;
    }

    /**
     * Guarda un nuevo registro de Pago a Cuenta
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $item = $this->model->create($data);
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $item;
    }

    /**
     * @param array $where
     * @return $this
     */
    public function where(array $where)
    {
        return  $this->model->where($where);
    }


    /**
     * @return mixed
     */
    public function get()
    {
        return $this->model->get();
    }
}