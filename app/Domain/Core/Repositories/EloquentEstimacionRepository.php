<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 22/09/2017
 * Time: 01:40 PM
 */

namespace Ghi\Domain\Core\Repositories;

use Dingo\Api\Exception\StoreResourceFailedException;
use Ghi\Domain\Core\Contracts\EstimacionRepository;
use Ghi\Domain\Core\Models\Transacciones\Estimacion;
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
     * @param array $data
     * @return Estimacion
     * @throws \Exception
     */
    public function create(array $data)
    {
        DB::connection('cadeco')->beginTransaction();
        try {

            $rules = [
                'id_antecedente' => ['required', 'exists:cadeco.transacciones,id_transaccion,tipo_transaccion,' . Tipo::SUBCONTRATO],
                'fecha' => ['required', 'date'],
                'id_empresa' => ['required', 'exists:cadeco.empresas,id_empresa'],
                'id_moneda' => ['required', 'exists:cadeco.monedas,id_moneda'],
                'vencimiento' => ['required', 'date', 'after:cumplimiento'],
                'cumplimiento' => ['required', 'date'],
                'referencia' => ['string', 'max:64'],
                'observaciones' => ['string', 'max:4096']
            ];

            $validator = app('validator')->make($data, $rules);

            if (count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al crear la Estimación', $validator->errors());
            } else {
                dd('panda');
            }

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}