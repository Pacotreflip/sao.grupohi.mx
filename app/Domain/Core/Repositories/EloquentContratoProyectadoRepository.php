<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 06/11/2017
 * Time: 0:10
 */

namespace Ghi\Domain\Core\Repositories;


use Dingo\Api\Exception\StoreResourceFailedException;
use Ghi\Domain\Core\Contracts\ContratoProyectadoRepository;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;
use Illuminate\Support\Facades\DB;

class EloquentContratoProyectadoRepository implements ContratoProyectadoRepository
{

    /**
     * @var ContratoProyectado
     */
    private $model;

    /**
     * EloquentContratoProyectadoRepository constructor.
     * @param ContratoProyectado $model
     */
    public function __construct(ContratoProyectado $model)
    {
        $this->model = $model;
    }

    /**
     * Crea un nuevo registro de Contrato Proyectado
     * @param array $data
     * @return Sucursal
     * @throws \Exception
     */
    public function create(array $data)
    {
        DB::connection('cadeco')->beginTransaction();
        try {
            //Reglas de validación para crear un contrato proyectado
            $rules = [
                //Validaciones de Transaccion
                'fecha' => ['required', 'date'],
                'referencia' => ['required', 'string', 'max:64'],
                'cumplimiento' => ['required', 'date'],
                'vencimiento' => ['required', 'date', 'after:cumplimiento'],
                'contratos' => ['required', 'array'],
                'contratos.*.nivel' => ['required', 'string', 'max:255'],
                'contratos.*.descripcion' => ['required', 'string', 'max:255'],
                'contratos.*.unidad' => ['string', 'max:16', 'exists:cadeco.unidades,unidad'],
                'contratos.*.cantidad_original' => ['numeric', 'required_with:contratos.*.unidad'],
                'contratos.*.clave' => ['string', 'max:140'],
                'contratos.*.id_marca' => ['integer'],
                'contratos.*.id_modelo' => ['integer'],
                'contratos.*.destinos' => ['required_with:contratos.*.unidad,contratos.*.cantidad_original'],
                'contratos.*.destinos.*.id_concepto' => ['required_with:contratos.*.destinos', 'integer', 'exists:cadeco.conceptos,id_concepto']
            ];

            //Validar los datos recibidos con las reglas de validación
            $validator = app('validator')->make($data, $rules);

            if(count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al crear el Contrato Proyectado', $validator->errors());
            } else {
                //Crear empresa nueva si la validación no arroja ningún error
                $contrato_proyectado = $this->model->create($data);

                foreach ($data['contratos'] as $key => $contrato) {
                    $contrato['id_transaccion'] = $contrato_proyectado->id_transaccion;

                    $contrato['cantidad_presupuestada'] = array_key_exists('cantidad_original', $contrato) ? $contrato['cantidad_original'] : 0;
                    $new_contrato = Contrato::create($contrato);

                    if(array_key_exists('destinos', $contrato)) {
                        foreach ($contrato['destinos'] as $destino) {
                            $new_contrato->conceptos()->attach($destino['id_concepto'], ['id_transaccion' => $contrato_proyectado->id_transaccion]);
                        }
                    }
                }

                DB::connection('cadeco')->commit();
                return $contrato_proyectado;
            }
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}