<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 07/11/2017
 * Time: 10:56
 */

namespace Ghi\Domain\Core\Repositories;

use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Ghi\Domain\Core\Contracts\ContratoRepository;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class EloquentContratoRepository implements ContratoRepository
{

    /**
     * @var Contrato
     */
    private $model;

    /**
     * EloquentContratoRepository constructor.
     * @param Contrato $model
     */
    public function __construct(Contrato $model)
    {
        $this->model = $model;
    }

    /**
     * Actualiza un registro de Contrato
     * @return Contrato
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        DB::connection('cadeco')->beginTransaction();
        try {
            if(! $contrato = $this->model->find($id)) {
                throw new ResourceException('No se encontró el Contrato que se desea actualizar');
            }

            $rules = [
                'descripcion' => ['max:255', 'filled'],
                'unidad' => ['max:16', 'exists:cadeco.unidades,unidad'],
                'cantidad_original' => ['numeric'],
                'clave' => ['max:140', 'string', 'filled'],
                'id_marca' => ['integer'],
                'id_modelo' => ['integer']
            ];

            $validator = app('validator')->make($data, $rules);

            if (count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al actualizar el Contrato', $validator->errors());
            }

            ! array_key_exists('cantidad_original', $data) ? : $data['cantidad_presupuestada'] = $data['cantidad_original'] ;

            $contrato->update($data);

            DB::connection('cadeco')->commit();

            return $contrato;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Busca un Contrato por su ID
     * @param $id
     * @return Contrato
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
}