<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaBancosRepository;
use Ghi\Domain\Core\Models\Cuenta;
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
    const CUENTA_DE_BANCO = 15;

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
        $item = [];

        try {
            DB::connection('cadeco')->beginTransaction();

            $record = CuentaBancos::create($data);

            $item = CuentaBancos::with('tipoCuentaContable')->where('id_cuenta_contable_bancaria', $record->id_cuenta_contable_bancaria)->first();

            // Si es una cuenta de banco, actualiza la cuenta principal.
            if ($data['id_tipo_cuenta_contable'] == static::CUENTA_DE_BANCO)
            {
                Cuenta::where('id_cuenta', $data['id_cuenta'])
                    ->update(['cuenta_contable' => $data['cuenta']]);
            }

            DB::connection('cadeco')->commit();

         } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $item;
    }

    public function delete(array $data, $id)
    {
        $error = 'No se encontró la cuenta que se desea editar';

        try {
            $item = $this->model->find($id);

            if (!$item) {
                throw new HttpResponseException(new Response($error, 404));

                return $error;
            }

            $item->estatus = 0;
            $item->save();

            // Si es una cuenta de banco, actualiza la cuenta principal.
            if ($data['data']['id_tipo_cuenta_contable'] == static::CUENTA_DE_BANCO)
            {
                Cuenta::where('id_cuenta', $item->id_cuenta)
                    ->update(['cuenta_contable' => null]);
            }

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
        $error = 'No se encontró la cuenta que se desea editar';

        try {
            $item = $this->model->find($id);

            if (!$item) {
                throw new HttpResponseException(new Response($error, 404));

                return $error;
            }

            DB::connection('cadeco')->beginTransaction();

            // Cambia el estado de la actual cuenta.
            $item->estatus = 0;
            $item->save();

            // Crea una nueva cuenta con la misma información
            $nuevo_item = $this->create($data['data']);

            // Si es una cuenta de banco, actualiza la cuenta principal.
            if ($data['data']['id_tipo_cuenta_contable'] == static::CUENTA_DE_BANCO)
            {
                Cuenta::where('id_cuenta', $data['data']['id_cuenta'])
                    ->update(['cuenta_contable' => $data['data']['cuenta']]);
            }

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

        return $nuevo_item;
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
        return $this->model->where(['id_cuenta' => $id_cuenta, 'estatus' => 1])->count();
    }

    /**
     * @return \Ghi\Domain\Core\Models\CuentaBancos
     */
    public function tipos()
    {
        return $this->model->tipos();
    }
}