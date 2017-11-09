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
use Illuminate\Support\Facades\DB;

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

    /**
     * Crea un nuevo Contrato adjunto a un Contrato Proyectado
     * @param array $data
     * @return contrato
     * @throws \Exception
     */
    public function create(array $data)
    {
        DB::connection('cadeco')->beginTransaction();
        try{
            //Reglas de validación para crear un contrato
            $rules = [
                //Validaciones de Transaccion
                'id_transaccion' => ['required', 'integer'],
                'nivel' => ['required', 'string', 'max:255'],
                'descripcion' => ['required', 'string', 'max:255'],
                'unidad' => ['string', 'max:16', 'exists:cadeco.unidades,unidad'],
                'cantidad_original' => ['numeric', 'required_with:unidad'],
                'clave' => ['string', 'max:140'],
                'id_marca' => ['integer'],
                'id_modelo' => ['integer'],
                'destinos' => ['required_with:unidad,cantidad_original'],
                'destinos.*.id_concepto' => ['required_with:destinos', 'integer', 'distinct', 'exists:cadeco.conceptos,id_concepto']
            ];

            //Validar los datos recibidos con las reglas de validación
            $validator = app('validator')->make($data, $rules);
            if(count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al crear el Contrato', $validator->errors());
            }else{
                ! array_key_exists('cantidad_original', $data) ? : $data['cantidad_presupuestada'] = $data['cantidad_original'] ;

                $contrato = Contrato::create($data);

                if(array_key_exists('destinos', $data)) {
                    foreach ($data['destinos'] as $destino) {
                        $contrato->conceptos()->attach($destino['id_concepto'], ['id_transaccion' => $contrato->id_transaccion]);
                    }
                }
            }
            DB::connection('cadeco')->commit();
            return $contrato;
        }catch (\Exception $e){
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}