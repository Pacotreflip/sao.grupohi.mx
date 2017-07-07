<?php
namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\Compras\Identificador;

use Ghi\Domain\Core\Contracts\ItemRepository;
use Ghi\Domain\Core\Models\Compras\Requisiciones\ItemExt;
use Ghi\Domain\Core\Models\Transacciones\Item;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EloquentItemRepository implements ItemRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Transacciones\Item
     */
    protected $model;
    /**
     * @var \Ghi\Domain\Core\Models\Compras\Requisiciones\ItemExt
     */
    protected $ext;

    /**
     * EloquentItemRepository constructor.
     * @param \Ghi\Domain\Core\Models\Transacciones\Item $model
     */
    public function __construct(Item $model,ItemExt $ext)
    {
        $this->model = $model;
        $this->ext = $ext;
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

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Guarda un registro de Item
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Transacciones\Item
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

             $item = $this->model->create($data);
             $this->ext->create([
                 'id_item' => $item->id_item,
                 'observaciones' => $data['observaciones']
             ]);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $this->model->with(['itemExt', 'material'])->find($item->id_item);
    }


    /**
     * Actualiza la información de las partidas de una requisición
     * @param array $data
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            if (! $item = $this->model->find($id)) {
                throw new HttpResponseException(new Response('No se encontró el Item', 404));
            }

            $item->update($data);
            $item_ext = $this->ext->find($id);
            $item_ext->update($data);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }
        return $this->model->with('itemExt')->find($item->id_item);
    }


    /**
     * Elimina un Item
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        if (! $item = $this->model->find($id)) {
            throw new HttpResponseException(new Response('No se encontró el Item', 404));
        }

        $item->delete();
       // $this->ext->destroy($id);
    }
}