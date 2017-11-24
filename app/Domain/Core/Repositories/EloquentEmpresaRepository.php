<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 28/06/2017
 * Time: 06:39 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Couchbase\Exception;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Response;
use Ghi\Domain\Core\Contracts\EmpresaRepository;
use Ghi\Domain\Core\Contracts\Ghi;
use Ghi\Domain\Core\Models\Contabilidad\CuentaEmpresa;
use Ghi\Domain\Core\Models\Empresa;
use Illuminate\Support\Facades\DB;


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
     * @return Empresa
     * @internal param $with
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $id
     * @return CuentaEmpresa
     */
    public function find($id)
    {
        return $this->model->find($id);
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

    /**
     * Aplica un scope a la consulta de Empresas
     */
    public function scope($scope)
    {
        $this->model = $this->model->$scope();
        return $this;
    }

    /**
     * Crea un registro de Empresa
     * @param array $data
     * @return Empresa
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }
}