<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\CuentaContableRepository;
use Ghi\Domain\Core\Models\Contabilidad\CuentaContable;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

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
        if ($with != null) {
            return $this->model->with($with)->get();
        }
        return $this->model->all();
    }

    /**
     *  Obtiene Poliza Tipo por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\PolizaTipo
     */
    public function find($id, $with = null)
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
                'prefijo' => $data['con_prefijo'] == "true" ? $data['prefijo'] : null,
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
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaContable
     * @throws \Exception
     */
    public function update(array $data,$id)
    {

        try {
            DB::connection('cadeco')->beginTransaction();
            if (!$item = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la poliza', 404));
            }

            $item->update([
                'prefijo' => $data['data']['con_prefijo'] == "true" ? $data['data']['prefijo'] : null,
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

    /**
     * Obtiene una Cuenta Contable que coincida con la búsqueda
     * @param $attribute
     * @param $value
     * @return \Ghi\Domain\Core\Models\CuentaContable
     */
    public function findBy($attribute, $value, $with = null)
    {
        if ($with != null) {
            return $this->model->orderBy('id_int_cuenta_contable', 'DESC')->with($with)->where($attribute, '=', $value)->first();
        }
        return $this->model->orderBy('id', 'DESC')->where($attribute, '=', $value)->first();
    }
}