<?php

namespace Ghi\Domain\Core\Repositories\Finanzas;

use Dingo\Api\Exception\StoreResourceFailedException;
use Ghi\Domain\Core\Contracts\Finanzas\PagoCuentaRepository;
use Ghi\Domain\Core\Models\Finanzas\PagoCuenta;
use Ghi\Domain\Core\Models\TipoTransaccion;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Illuminate\Database\Eloquent\Collection;
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
            $transaccion = Transaccion::find($data['id_antecedente']);
            if(!$transaccion->costo && isset($data['id_costo'])) {
                $transaccion->id_costo = $data['id_costo'];
                $transaccion->save();
            }
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

    /**
     * Devuelve lis tipos de transacción que se utilizan en las solicitudes de pago de pago a cuenta
     * @return Collection | TipoTransaccion
     */
    public function getTiposTran()
    {
        return TipoTransaccion::where(function ($q) {
            foreach ($this->model->tipos_transaccion as $item) {
                $q->orWhere($item);
            }
        })->get();
    }
}