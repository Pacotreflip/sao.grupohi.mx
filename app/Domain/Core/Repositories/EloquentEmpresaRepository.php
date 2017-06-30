<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 06:39 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Ghi\Domain\Core\Contracts\EmpresaRepository;
use Ghi\Domain\Core\Contracts\Ghi;
use Ghi\Domain\Core\Models\Empresa;


class EloquentEmpresaRepository implements EmpresaRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Empresa
     */
    private $model;

    /**
     * EloquentObraRepository constructor.
     * @param \Ghi\Domain\Core\Models\Empresa $model
     */
    public function __construct(Empresa $model)
    {
        $this->model = $model;
    }
    /**
     * @param $with
     * @return  Illuminate\Support\Collection\Empresa
     */
    public function all($with=null)
    {
        if ($with != null) {
            return $this->model->with($with)->get();
        }
        return $this->model->all();
    }

    /**
     * @param $id
     * @return Ghi\Domain\Core\Models\Contabilidad\CuentaEmpresa
     */
    public function find($id, $with = null)
    {

        if ($with != null) {
            return $this->model->with($with)->find($id);
        }
        return $this->model->find($id);
    }
}