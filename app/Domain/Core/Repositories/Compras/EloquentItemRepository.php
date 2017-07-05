<?php
namespace Ghi\Domain\Core\Repositories\Compras;

use Ghi\Domain\Core\Contracts\Compras\Identificador;
use Ghi\Domain\Core\Contracts\Compras\ItemRepository;
use Ghi\Domain\Core\Models\Transacciones\Item;

class EloquentItemRepository implements ItemRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Transacciones\Item
     */
    protected $model;

    /**
     * EloquentItemRepository constructor.
     * @param \Ghi\Domain\Core\Models\Transacciones\Item $model
     */
    public function __construct(Item $model)
    {
        $this->model = $model;
    }
    /**
     * Obtiene todos los registros de Item
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Transacciones\Item
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $id Identificador del Item
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Transacciones\Item
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
}