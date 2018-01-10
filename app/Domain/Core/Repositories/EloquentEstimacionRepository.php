<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 22/09/2017
 * Time: 01:40 PM
 */

namespace Ghi\Domain\Core\Repositories;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Contracts\EstimacionRepository;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Transacciones\Estimacion;
use Ghi\Domain\Core\Models\Transacciones\Item;
use Ghi\Domain\Core\Models\Transacciones\Subcontrato;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EloquentEstimacionRepository implements EstimacionRepository
{
    /**
     * @var Estimacion
     */
    protected $model;

    /**
     * EloquentEstimacionRepository constructor.
     * @param Estimacion $model
     */
    public function __construct(Estimacion $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Estimaciones
     * @return Collection|Estimacion
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param int $id
     * @return Estimacion
     */
    public function find($id)
    {
       return $this->model->findOrFail($id);
    }

    /**
     * Crea relaciones con otros modelos
     * @param array $relations
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Obtiene las estimaciones que coincidan con los campos de búsqueda
     * @param $attribute
     * @param $operator
     * @param $value
     * @return Collection
     */
    public function getBy($attribute, $operator, $value)
    {
        return $this->model->where($attribute, $operator, $value)->get();
    }

    /**
     * Registra una nueva Estimación
     * @param Request $request
     * @return Estimacion
     * @throws \Exception
     */
    public function create(Request $request)
    {
        DB::connection('cadeco')->beginTransaction();
        try {

            $rules = [
                'id_antecedente' => ['required', 'exists:cadeco.transacciones,id_transaccion,tipo_transaccion,' . Tipo::SUBCONTRATO],
                'fecha' => ['required', 'date'],
                'id_empresa' => ['required', 'exists:cadeco.empresas,id_empresa'],
                'id_moneda' => ['required', 'exists:cadeco.monedas,id_moneda'],
                'vencimiento' => ['required', 'date'],
                'cumplimiento' => ['required', 'date'],
                'observaciones' => ['string', 'max:4096'],
                'referencia' => ['string', 'max:64', 'unique:cadeco.transacciones,referencia,NULL,id_transaccion,tipo_transaccion,' . Tipo::ESTIMACION . ',id_antecedente,' . $request->id_antecedente],
                'items' => ['required', 'array'],
                'items.*.item_antecedente' => ['required', 'exists:cadeco.items,id_concepto,id_transaccion,' . $request->id_antecedente, 'distinct'],
                'items.*.cantidad' => ['required', 'numeric', '']
            ];

            $validator = app('validator')->make($request->all(), $rules);

            foreach ($request->get('items', []) as $key => $item) {
                $subcontrato = Subcontrato::find($request->id_antecedente);
                if($subcontrato && array_key_exists('item_antecedente', $item)) {
                    $item_subcontrato = $subcontrato->items()->where('id_concepto', '=', $item['item_antecedente'])->first();
                    $total = $item_subcontrato ? $item_subcontrato->cantidad : 0;
                    $estimado = Item::where('id_antecedente', '=', $subcontrato->id_transaccion)->where('item_antecedente', '=', $item['item_antecedente'])->sum('cantidad');
                    $saldo = $total - $estimado;
                    if(array_key_exists('cantidad', $item)) {
                        if($saldo == 0)
                        {
                            $validator->errors()->add('items.' . $key . '.cantidad', 'No se puede registrar la partida ya que la cantidad pendiente por estimar es 0');
                        } else if($item['cantidad'] > $saldo) {
                            $validator->errors()->add('items.' . $key . '.cantidad', 'La cantidad debe ser menor o igual a lo pendiente por estimar: ' . $saldo);
                        }
                    }
                }
            }

            if (count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al crear la Estimación', $validator->errors());
            } else {

                $estimacion = $this->model->create($request->all());


                foreach ($request->items as $item) {
                    $item_subcontrato = Item::where('id_concepto', '=', $item['item_antecedente'])->where('id_transaccion', '=', $request->id_antecedente)->first();
                    $contrato = Contrato::find($item['item_antecedente']);
                    $destino = $contrato->destinos()->first();

                    $item['id_transaccion'] = $estimacion->id_transaccion;
                    $item['id_antecedente'] = $request->id_antecedente;
                    $item['id_concepto'] = $destino->id_concepto;
                    $item['precio_unitario'] = $item_subcontrato->precio_unitario;
                    $item['importe'] = $item['cantidad'] * $item['precio_unitario'];

                    Item::create($item);
                }

                $suma_importes = $estimacion->items()->sum('importe');

                $estimacion->anticipo = $estimacion->subcontrato->anticipo;
                $estimacion->retencion = $estimacion->subcontrato->retencion;

                $impuesto = ($suma_importes - ($suma_importes * ($estimacion->anticipo / 100))) * 0.16;

                $estimacion->monto = $estimacion->saldo = $suma_importes - ($suma_importes * ($estimacion->anticipo / 100)) + $impuesto;
                $estimacion->impuesto = $impuesto;
                $estimacion->save();
            }

            DB::connection('cadeco')->commit();
            return $estimacion;
        } catch(\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}