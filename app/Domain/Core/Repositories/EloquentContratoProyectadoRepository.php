<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 06/11/2017
 * Time: 0:10
 */

namespace Ghi\Domain\Core\Repositories;


use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Contracts\ContratoProyectadoRepository;
use Ghi\Domain\Core\Models\Acarreos\MaterialAcarreo;
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
     * @param Request $request
     * @return ContratoProyectado
     * @throws \Exception
     * @internal param array $data
     */
    public function create(Request $request)
    {
        //Reglas de validación para crear un contrato proyectado
        $rules = [
            //Validaciones de Transaccion
            'fecha' => ['required', 'date'],
            'referencia' => ['required', 'string', 'max:64'],
            'cumplimiento' => ['required', 'date'],
            'vencimiento' => ['required', 'date', 'after:cumplimiento'],
            'contratos' => ['required', 'array'],
            'contratos.*.nivel' => ['required', 'string', 'max:255', 'regex:"^(\d{3}\.)+$"', 'distinct'],
            'contratos.*.descripcion' => ['required', 'string', 'max:255', 'distinct'],
            'contratos.*.unidad' => ['string', 'max:16', 'exists:cadeco.unidades,unidad'],
            'contratos.*.cantidad_presupuestada' => ['numeric'],
            'contratos.*.clave' => ['string', 'max:140', 'distinct'],
            'contratos.*.id_marca' => ['integer'],
            'contratos.*.id_modelo' => ['integer'],
            'contratos.*.destinos.*.id_concepto' => ['required_with:contratos.*.destinos', 'integer', 'exists:cadeco.conceptos,id_concepto']
        ];

        //Validar los datos recibidos con las reglas de validación
        $validator = app('validator')->make($request->all(), $rules);

        foreach ($request->get('contratos', []) as $key => $contrato) {
            if(array_key_exists('nivel', $contrato)) {
                if ($this->validarNivel($request->get('contratos', []), $contrato['nivel'])) {
                    foreach (array_only($contrato, ['unidad', 'cantidad_presupuestada', 'destinos']) as $key_campo => $campo) {
                        $validator->errors()->add('contratos.' . $key . '.' . $key_campo, 'El contrato no debe incluir ' . $key_campo . ' ya que tiene niveles subsecuentes');
                    }
                } else {
                    $validator->sometimes(['contratos.' . $key . '.unidad', 'contratos.' . $key . '.cantidad_presupuestada', 'contratos.' . $key . '.destinos'], 'required', function () {
                        return true;
                    });
                }
            }
        }

        try {
            if (count($validator->errors()->all())) {
                throw new StoreResourceFailedException('Error al crear el Contrato Proyectado', $validator->errors());
            } else {
                DB::connection('cadeco')->beginTransaction();
                $contrato_proyectado = $this->model->create($request->all());

                foreach ($request->get('contratos') as $key => $contrato) {
                    $contrato['id_transaccion'] = $contrato_proyectado->id_transaccion;

                    $contrato['cantidad_original'] = array_key_exists('cantidad_presupuestada', $contrato) ? $contrato['cantidad_presupuestada'] : 0;
                    $new_contrato = Contrato::create($contrato);

                    if (array_key_exists('destinos', $contrato)) {
                        foreach ($contrato['destinos'] as $destino) {
                            $new_contrato->destinos()->attach($destino['id_concepto'], ['id_transaccion' => $contrato_proyectado->id_transaccion]);

                            $newMaterial = MaterialAcarreo::create([
                                'id_material_acarreo' => $contrato['id_material']
                                ,'id_concepto' => $destino['id_concepto']
                                ,'id_concepto_contrato' => $new_contrato['id_concepto']
                                ,'id_transaccion' => $contrato_proyectado->id_transaccion
                                ,'tarifa' => $contrato['tarifa']
                                ,'id_item' => $contrato['tiro']
                            ]);
                        }
                    }
                }

                DB::connection('cadeco')->commit();
                return $contrato_proyectado;

            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Actualiza un Contrato Proyectado
     * @param array $data
     * @param $id
     * @return ContratoProyectado
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        DB::connection('cadeco')->beginTransaction();
        try {


            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Agrega nuevos Contratos al Contrato Proyectado
     * @param array $data
     * @param $id
     * @return Collection|Contrato
     * @throws \Exception
     */
    public function addContratos(Request $request, $id)
    {

        $rules = [
            //Validaciones de Transaccion
            'contratos' => ['required', 'array'],
            'contratos.*.nivel' => ['regex:"^(\d{3}\.)+$"', 'required', 'distinct', 'string', 'max:255', 'unique:cadeco.contratos,nivel,NULL,id_concepto,id_transaccion,' . $id],
            'contratos.*.descripcion' => ['required', 'string', 'max:255'],
            'contratos.*.unidad' => ['string', 'max:16', 'exists:cadeco.unidades,unidad'],
            'contratos.*.cantidad_presupuestada' => ['numeric'],
            'contratos.*.clave' => ['string', 'max:140', 'distinct'],
            'contratos.*.id_marca' => ['integer'],
            'contratos.*.id_modelo' => ['integer'],
            'contratos.*.destinos.*.id_concepto' => ['required_with:contratos.*.destinos', 'integer', 'exists:cadeco.conceptos,id_concepto']
        ];

        //Validar los datos recibidos con las reglas de validación
        $validator = app('validator')->make($request->all(), $rules);

        $contratos_existentes = Contrato::where('id_transaccion', '=', $id)->get(['nivel'])->toArray();
        foreach ($request->get('contratos', []) as $c) {

            if(array_key_exists('nivel', $c)) {
                $contratos_existentes [] = ['nivel' => $c['nivel']];
            }
        }

        foreach ($request->get('contratos', []) as $key => $contrato) {
            if(array_key_exists('nivel', $contrato)) {
                if (EloquentContratoProyectadoRepository::validarNivel($contratos_existentes, $contrato['nivel'])) {
                    foreach (array_only($contrato, ['unidad', 'cantidad_presupuestada', 'destinos']) as $key_campo => $campo) {
                        $validator->errors()->add('contratos.' . $key . '.' . $key_campo, 'El contrato no debe incluir ' . $key_campo . ' ya que tiene niveles subsecuentes');
                    }
                } else {
                    $validator->sometimes(['contratos.' . $key . '.unidad', 'contratos.' . $key . '.cantidad_presupuestada', 'contratos.' . $key . '.destinos'], 'required', function () {
                        return true;
                    });
                }
            }
        }

        try {
            if (count($validator->errors()->all())) {
                //Caer en excepción si alguna regla de validación falla
                throw new StoreResourceFailedException('Error al agregar los Contratos '. $validator->errors());
            } else {
                DB::connection('cadeco')->beginTransaction();
                $data = $request->all();
                $contratos = [];
                foreach ($data['contratos'] as $contrato) {
                    !array_key_exists('cantidad_presupuestada', $contrato) ? : $contrato['cantidad_original'] = $contrato['cantidad_presupuestada'];

                    $contrato['id_transaccion'] = $id;
                    $new_contrato = Contrato::create($contrato);
                    array_push($contratos, $new_contrato);
                    if (array_key_exists('destinos', $contrato)) {
                        foreach ($contrato['destinos'] as $destino) {
                            $new_contrato->destinos()->attach($destino['id_concepto'], ['id_transaccion' => $new_contrato->id_transaccion]);
                            $newMaterial = MaterialAcarreo::firstOrCreate([
                                'id_material_acarreo' => $contrato['id_material']
                                ,'id_concepto' => $destino['id_concepto']
                                ,'id_concepto_contrato' => $new_contrato['id_concepto']
                                ,'id_transaccion' => $id
                                ,'tarifa' => $contrato['tarifa']
                                ,'id_item' => $contrato['tiro']
                            ]);
                        }
                    }
                }

                DB::connection('cadeco')->commit();
                return collect($contratos);
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }

    /**
     * Valida que un nivel no tenga hijos en un array de contratos
     * @param array $contratos
     * @param string $nivel
     * @return bool
     */
    public function validarNivel(array $contratos, $nivel)
    {
        foreach ($contratos as $contrato) {
            if (starts_with($contrato['nivel'], $nivel) && (strlen($nivel) < strlen($contrato['nivel']))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Devuelve un contrato proyectado por su ID
     * @param $id
     * @return ContratoProyectado
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Devuelve todos los contratos proyectados
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param array $cols
     * @param string $q
     * @return mixed
     */
    public function like(array $cols, $q)
    {
        return $this->model->where(function ($query) use ($cols, $q) {
            foreach ($cols as $col) {
                $query->orWhere($col, 'like', "%$q%");
            }
        })->limit(10)->get();
    }
}