<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 27/07/2017
 * Time: 02:09 PM
 */

namespace Ghi\Domain\Core\Repositories;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Contracts\SubcontratoRepository;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Transacciones\Item;
use Ghi\Domain\Core\Models\Transacciones\Subcontrato;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EloquentSubcontratoRepository implements SubcontratoRepository
{
    /**
     * @var Subcontrato
     */
    protected $model;

    /**
     * EloquentSubcontratoRepository constructor.
     * @param Subcontrato $model
     */
    public function __construct(Subcontrato $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene los Subcontratos que coincidan con los campos de búsqueda
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
     * Almacena un nuevo SubContrato
     * @param Request $request
     * @return Subcontrato
     * @throws \Exception
     * @internal param array $data
     */
    public function create(Request $request)
    {

        try {
            //Reglas de validación para crear un subcontrat
            $rules = [
                //Validaciones de Subcontrato
                'id_antecedente' => ['required', 'integer', 'exists:cadeco.transacciones,id_transaccion,tipo_transaccion,' . Tipo::CONTRATO_PROYECTADO],
                'fecha' => ['required', 'date'],
                'id_costo' => ['required', 'integer', 'exists:cadeco.costos,id_costo'],
                'id_empresa' => ['required', 'integer', 'exists:cadeco.empresas,id_empresa'],
                'id_moneda' => ['required', 'integer', 'exists:cadeco.monedas,id_moneda'],
                'anticipo' => ['numeric'],
                'retencion' => ['numeric'],
                'referencia' => ['string', 'required', 'max:64', 'unique:cadeco.transacciones,referencia,NULL,id_transaccion,tipo_transaccion,' . Tipo::SUBCONTRATO],
                'observaciones' => ['string', 'max:4096'],
                'items' => ['required', 'array'],
                'items.*.id_concepto' => ['distinct', 'required', 'exists:cadeco.contratos,id_concepto,id_transaccion,' . $request->id_antecedente . ',unidad,NOT_NULL'],
                'items.*.cantidad' => ['required', 'numeric'],
                'items.*.precio_unitario' => ['required', 'numeric']
            ];

            //Validar los datos recibidos con las reglas de validación
            $validator = app('validator')->make($request->all(), $rules);

            if (count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al crear el Subcontrato', $validator->errors());
            } else {
                DB::connection('cadeco')->beginTransaction();
                $data = $request->all();
                $subcontrato = $this->model->create($data);

                foreach ($data['items'] as $item) {
                    $contrato = Contrato::findOrFail($item['id_concepto']);
                    $proyectado = $contrato->cantidad_presupuestada;
                    $contratado = $contrato->items()->sum('cantidad');
                    $por_contratar = $proyectado - $contratado;

                    if($item['cantidad'] > $por_contratar) {
                        $contrato->cantidad_presupuestada += $item['cantidad'] - $por_contratar;
                        $contrato->save();
                    }

                    $item['cantidad_original1'] = $item['cantidad'];
                    $item['precio_original1'] = $item['precio_unitario'];
                    $item['id_transaccion'] = $subcontrato->id_transaccion;
                    $item['id_antecedente'] = $subcontrato->id_antecedente;

                    Item::create($item);
                }

                $suma_importes = $subcontrato->items()->sum(DB::raw('cantidad * precio_unitario'));
                $impuesto = 0.16 * $suma_importes;
                $subcontrato->monto = $subcontrato->saldo = $suma_importes + $impuesto;
                $subcontrato->impuesto = $impuesto;
                $subcontrato->anticipo_monto = $subcontrato->anticipo_saldo = ($subcontrato->monto - $subcontrato->impuesto) * ($subcontrato->anticipo / 100);

                $subcontrato->save();


                DB::connection('cadeco')->commit();

                return $subcontrato;
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }
}