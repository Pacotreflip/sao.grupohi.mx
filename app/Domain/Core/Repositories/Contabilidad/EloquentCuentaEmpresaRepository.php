<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 02:40 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;


use Dingo\Api\Auth\Auth;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaEmpresaRepository;
use Ghi\Domain\Core\Models\Contabilidad\CuentaContable;
use Ghi\Domain\Core\Models\Contabilidad\CuentaEmpresa;
use Illuminate\Support\Facades\DB;


class EloquentCuentaEmpresaRepository implements CuentaEmpresaRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\CuentaContable
     */
    protected $model;

    /**
     * EloquentCuentaContableRepository constructor.
     * @param \Ghi\Domain\Core\Models\CuentaContable $model
     */
    public function __construct(CuentaEmpresa $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las Cuentas de la Empresa
     *
     * @return \Illuminate\Database\Eloquent\Collection|CuentaEmpresa
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     *  Obtiene Cuenta de Empresa por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\CuentaEmpresa
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * Guarda un nuevo registro de Cuenta CuentaEmpresa
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\CuentaEmpresa
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $modelo = $this->model;
            $modelo->registro = auth()->user()->idusuario;
            $modelo->id_empresa = $data['id_empresa'];
            $modelo->cuenta = $data['cuenta'];
            $modelo->id_tipo_cuenta_empresa = $data['id_tipo_cuenta_empresa'];

            $item = $modelo->save();

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $item;

    }

    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|CuentaEmpresa
     * @throws \Exception
     */
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
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            $cuenta = $this->model->find($id);
            $cuenta->cuenta = $data['data']['cuenta'];
            $cuenta->save();
        } catch (\Exception $e) {
            throw $e;
        }


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