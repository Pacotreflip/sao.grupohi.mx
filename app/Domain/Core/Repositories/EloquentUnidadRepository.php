<?php

namespace Ghi\Domain\Core\Repositories;

use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Ghi\Core\Models\Unidad;
use Ghi\Domain\Core\Contracts\Compras\Identificador;

use Ghi\Domain\Core\Contracts\ItemRepository;
use Ghi\Domain\Core\Contracts\Para;
use Ghi\Domain\Core\Contracts\UnidadRepository;
use Ghi\Domain\Core\Models\Compras\Requisiciones\ItemExt;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Transacciones\Item;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EloquentUnidadRepository implements UnidadRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Unidad
     */
    protected $model;

    /**
     * EloquentItemRepository constructor.
     * @param \Ghi\Domain\Core\Models\Unidad $model
     */
    public function __construct(Unidad $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Item
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Unidad
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $id Identificador del Item
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Unidad
     */
    public function find($id)
    {
        return $this->model->find($id);
    }


    public function getUnidadesByDescripcion($descripcion)
    {
        return $this->model->where('descripcion', 'like', '%' . $descripcion . '%')->get();


    }
}