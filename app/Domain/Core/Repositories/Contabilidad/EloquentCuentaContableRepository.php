<?php namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaContableRepository;
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
     *Obtiene todas las cuentas contables
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->get();
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
                'id_int_tipo_cuenta_contable' => $data['id_int_tipo_cuenta_contable'],
                'estatus' => 1
            ]);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $this->model->with('tipoCuentaContable')->find($item->id_int_cuenta_contable);
    }

    /**
     * Actualiza un registro de cuenta contable
     * @param array $data
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaContable
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
   try {
            DB::connection('cadeco')->beginTransaction();
            if (!$item = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró la cuenta contable que se desea actualizar', 404));
            }

            $item->estatus = 0;
            $item->update();

            $data['prefijo'] = $data['data']['con_prefijo'] == "true" ? $data['data']['prefijo'] : null;
            $data['cuenta_contable'] = $data['data']['con_prefijo'] == "true" ? null : $data['data']['cuenta_contable'];
            $data['id_int_tipo_cuenta_contable'] = $item->id_int_tipo_cuenta_contable;
            $data['estatus'] = 1;
            $item = CuentaContable::create($data);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            $item->estatus = 1;
            $item->update();
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
    public function findBy($attribute, $value)
    {
        return $this->model->orderBy('id_int_cuenta_contable', 'DESC')->where($attribute, '=', $value)->first();
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
}