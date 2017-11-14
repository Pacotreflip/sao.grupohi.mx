<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 27/07/2017
 * Time: 02:09 PM
 */

namespace Ghi\Domain\Core\Repositories;

use Dingo\Api\Exception\StoreResourceFailedException;
use Ghi\Domain\Core\Contracts\SubcontratoRepository;
use Ghi\Domain\Core\Models\Transacciones\Subcontrato;
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
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function create(array $data)
    {
        DB::connection('cadeco')->beginTransaction();
        try {
            //Reglas de validación para crear un subcontrat
            $rules = [
                //Validaciones de Subcontrato
                'id_antecedente' => ['required', 'Integer', 'exists:cadeco.transacciones,id_transaccion'],
                'fecha' => ['required', 'date'],
                'id_costo' => ['Integer', 'exists:cadeco.costos,id_costo'],
                'id_empresa' => ['Integer', 'exists:cadeco.empresas,id_empresa'],
                'id_moneda' => ['Integer', 'exists:cadeco.monedas,id_moneda'],
                'monto' => ['Numeric'],
                'saldo' => ['Numeric'],
                'impuesto' => ['Numeric'],
                'referencia' => ['String'],
                'observaciones' => ['String']
            ];
            //Validar los datos recibidos con las reglas de validación
            $validator = app('validator')->make($data, $rules);

            if (count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al crear el Subcontrato', $validator->errors());
            } else {
                dd('pandita');
                $subcontrato = $this->model->create($data);
                DB::connection('cadeco')->commit();
                return $subcontrato;
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}