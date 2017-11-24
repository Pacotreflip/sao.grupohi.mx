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
     * @param  array $data
     * @return Subcontrato
     */
    public function create(array $data)
    {
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

        $subcontrato->monto = $subcontrato->saldo = $subcontrato->items()->sum(DB::raw('cantidad * precio_unitario'));
        $subcontrato->impuesto = (0.16 * $subcontrato->monto) / 1.16;
        $subcontrato->anticipo_monto = $subcontrato->anticipo_saldo = ($subcontrato->monto - $subcontrato->impuesto) * ($subcontrato->anticipo / 100);

        $subcontrato->save();

        return $subcontrato;
    }
}