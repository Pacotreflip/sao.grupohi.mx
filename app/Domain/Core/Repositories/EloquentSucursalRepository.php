<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 03/11/2017
 * Time: 3:39 AM
 */

namespace Ghi\Domain\Core\Repositories;


use Ghi\Domain\Core\Contracts\SucursalRepository;
use Ghi\Domain\Core\Models\Sucursal;

class EloquentSucursalRepository implements SucursalRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Sucursal
     */
    private $model;

    /**
     * EloquentSucursalRepository constructor.
     * @param Sucursal $model
     */
    public function __construct(Sucursal $model)
    {
        $this->model = $model;
    }

    /**
     * Crea un nuevo registro de Sucursal
     * @param array $data
     * @return Sucursal
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }
}