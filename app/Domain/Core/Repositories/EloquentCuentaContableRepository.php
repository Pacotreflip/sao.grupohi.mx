<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\CuentaContableRepository;
use Ghi\Domain\Core\Models\CuentaContable;
use Illuminate\Support\Facades\DB;

class EloquentCuentaContableRepository implements CuentaContableRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\CuentaContable
     */
    protected $model;

    /**
     * EloquentCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\CuentaContable $model
     */
    public function __construct(CuentaContable $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las cuentas contables
     * @param null|array|string $with
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\CuentaContable
     */
    public function all($with = null)
    {
        if($with != null) {
            return $this->model->with($with)->get();
        }
        return $this->model->all();
    }

    /**
     *  Obtiene Poliza Tipo por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\PolizaTipo
     */
    public function find($id , $with = null)
    {
        if ($with != null) {
            return $this->model->with($with)->find($id);
        }
        return $this->model->find($id);
    }

    /**
     * Guarda un registro de cuenta contable
     * @param array $data
     * @return \Ghi\Domain\Core\Models\CuentaContable
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $item = $this->model->create([
                'prefijo' => $data['con_prefijo'] == "true" ?  $data['prefijo'] : null,
                'cuenta_contable' => $data['con_prefijo'] == "true" ? null : $data['cuenta_contable'],
                'id_int_tipo_cuenta_contable' => $data['id_int_tipo_cuenta_contable']
            ]);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $item->where('id_int_cuenta_contable', '=', $item->id_int_cuenta_contable)->with('tipoCuentaContable')->first();
    }

    /**
     * Actualiza un registro de cuenta contable
     * @param array $data
     * @return \Ghi\Domain\Core\Models\CuentaContable
     * @throws \Exception
     */
    public function update(array $data)
    {

        try {
            DB::connection('cadeco')->beginTransaction();
            $item = $this->model->findOrFail($data['data']['id_int_cuenta_contable']);

            $item->update([
                'prefijo' => $data['data']['con_prefijo'] == "true" ?  $data['data']['prefijo'] : null,
                'cuenta_contable' => $data['data']['con_prefijo'] == "true" ? null : $data['data']['cuenta_contable'],
                'id_int_tipo_cuenta_contable' => $data['data']['id_int_tipo_cuenta_contable']
            ]);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $item->where('id_int_cuenta_contable', '=', $item->id_int_cuenta_contable)->with('tipoCuentaContable')->first();
    }
}