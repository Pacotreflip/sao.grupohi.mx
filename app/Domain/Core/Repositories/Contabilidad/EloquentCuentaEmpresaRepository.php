<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 02:40 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;


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
    public function all($with = null)
    {
        if ($with != null) {
            return $this->model->all()->with($with);
        }
        return $this->model->all();

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
        // TODO: Implement create() method.
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
            $cuenta->cuenta=$data['data']['cuenta'];
            $cuenta->save();
        } catch (\Exception $e) {
            throw $e;
        }


    }
}