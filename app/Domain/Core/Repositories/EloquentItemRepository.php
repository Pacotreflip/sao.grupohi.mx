<?php

namespace Ghi\Domain\Core\Repositories;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Contracts\Compras\Identificador;

use Ghi\Domain\Core\Contracts\ItemRepository;
use Ghi\Domain\Core\Contracts\Para;
use Ghi\Domain\Core\Models\Compras\Requisiciones\ItemExt;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Transacciones\Item;
use Ghi\Domain\Core\Models\Transacciones\Subcontrato;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
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
    public function __construct(Item $model, ItemExt $ext)
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
    /*public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $item = $this->model->create($data);

            if (isset($data['observaciones'])) {
                $this->ext->create([
                    'id_item' => $item->id_item,
                    'observaciones' => $data['observaciones']
                ]);
            }

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $this->model->with(['itemExt', 'material'])->find($item->id_item);
    }*/

    public function create(Request $request) {
        $rules = [
            'id_transaccion' => ['required', 'exists:cadeco.transacciones,id_transaccion'],
            'id_antedecente' => ['exists:cadeco.transacciones,id_transaccion'],
            'cantidad' => ['numeric'],
            'precio_unitario' => ['numeric']
        ];

        $validator = app('validator')->make($request->all(), $rules);

        $transaccion = Transaccion::find($request->id_transaccion);

        // Valida que el campo id_antecedente sea requerido dependieno del tipo de transacción a la que pertenece,
        // pudiendose agregar mas tipos de transacción como sea necesario.
        $validator->sometimes('id_antecedente', 'required', function ($input) use ($transaccion) {
            if($transaccion) {
                // Se pueden agregar mas tipos de transacción como se requieran
                return in_array($transaccion->tipo_transaccion, [Tipo::SUBCONTRATO, Tipo::ESTIMACION]);
            }
        });

        // Valida que el campo id_concepto sea requerido y exista en la tabla conceptos siempre y cuando el tipo de
        // Transacción así lo requiera
        $validator->sometimes('id_concepto', ['required', 'exists:cadeco.contratos,id_concepto'], function ($input) use ($transaccion) {
            if($transaccion) {
                // Se pueden agregar mas tipos de transacción como se requieran
                return in_array($transaccion->tipo_transaccion, [Tipo::SUBCONTRATO]);
            }
        });

        $validator->sometimes('cantidad', 'required', function($input) use ($transaccion) {
            if($transaccion) {
                return in_array($transaccion->tipo_transaccion, [Tipo::SUBCONTRATO]);
            }
        });

        $validator->sometimes('precio_unitario', 'required', function($input) use ($transaccion) {
            if($transaccion) {
                return in_array($transaccion->tipo_transaccion, [Tipo::SUBCONTRATO]);
            }
        });

        try {
            DB::connection('cadeco')->beginTransaction();

            if (count($validator->errors()->all())) {
                throw new StoreResourceFailedException('No se pudo crear el Item', $validator->errors());
            } else {
                $item = $this->model->create($request->all());

                switch ($transaccion->tipo_transaccion) {
                    // Registro de un Item para un Subcontrato
                    case Tipo::SUBCONTRATO :
                        $item->cantidad_original1 = $item->cantidad;
                        $item->precio_original1 = $item->precio_unitario;
                        $item->save();

                        $contrato = Contrato::findOrFail($item->id_concepto);
                        $proyectado = $contrato->cantidad_presupuestada;
                        $contratado = $contrato->items()->sum('cantidad');
                        $por_contratar = $proyectado - $contratado;

                        if($item->cantidad > $por_contratar) {
                            $contrato->cantidad_presupuestada += $item->cantidad - $por_contratar;
                            $contrato->save();
                        }
                        break;
                }
                DB::connection('cadeco')->commit();

                return $item;
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
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

            if (!$item = $this->model->find($id)) {
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
        return $this->model->with(['itemExt', 'material'])->find($item->id_item);
    }


    /**
     * Elimina un Item
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        if (!$item = $this->model->find($id)) {
            throw new HttpResponseException(new Response('No se encontró el Item', 404));
        }

        $item->delete();
        // $this->ext->destroy($id);
    }

    /**
     * Obtiene un Item
     * @param $attribute
     * @param $operator
     * @param $value
     * @return mixed
     */
    public function getBy($attribute, $operator, $value)
    {
        return $this->model->where($attribute, $operator, $value)->get();
    }

    /**
     * @param $scope Para consulta mixta de Item con Transacción
     * @return mixed
     */
    public function scope($scope)
    {
        $this->model = $this->model->$scope();
        return $this;
    }
}