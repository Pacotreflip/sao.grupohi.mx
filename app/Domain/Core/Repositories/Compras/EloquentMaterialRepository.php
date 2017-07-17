<?php
namespace Ghi\Domain\Core\Repositories\Compras;

use Ghi\Domain\Core\Contracts\Compras\MaterialRepository;
use Ghi\Domain\Core\Models\Material;

class EloquentMaterialRepository implements MaterialRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion
     */
    protected $model;

    /**
     * EloquentRequisicionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion $model
     */
    public function __construct(Material $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Materiales
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Material
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Material
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * Guarda un registro de Materiales
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Material
     * @throws \Exception
     */
    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    /**
     * Elimina un Material
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}