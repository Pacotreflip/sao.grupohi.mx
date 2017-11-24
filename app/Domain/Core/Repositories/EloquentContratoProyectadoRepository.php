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
     * @return ContratoProyectado
     * @throws \Exception
     */
    public function create(array $data)
    {
        $contrato_proyectado = $this->model->create($data);

        foreach ($data['contratos'] as $key => $contrato) {
            $contrato['id_transaccion'] = $contrato_proyectado->id_transaccion;

            $contrato['cantidad_original'] = array_key_exists('cantidad_presupuestada', $contrato) ? $contrato['cantidad_presupuestada'] : 0;
            $new_contrato = Contrato::create($contrato);

            if (array_key_exists('destinos', $contrato)) {
                foreach ($contrato['destinos'] as $destino) {
                    $new_contrato->destinos()->attach($destino['id_concepto'], ['id_transaccion' => $contrato_proyectado->id_transaccion]);
                }
            }
        }

        return $contrato_proyectado;
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
    public function addContratos(array $data, $id)
    {

        $contratos = [];
        foreach ($data['contratos'] as $contrato) {
            !array_key_exists('cantidad_presupuestada', $contrato) ? : $contrato['cantidad_original'] = $contrato['cantidad_presupuestada'];

            $contrato['id_transaccion'] = $id;
            $new_contrato = Contrato::create($contrato);
            array_push($contratos, $new_contrato);
            if (array_key_exists('destinos', $contrato)) {
                foreach ($contrato['destinos'] as $destino) {
                    $new_contrato->destinos()->attach($destino['id_concepto'], ['id_transaccion' => $new_contrato->id_transaccion]);
                }
            }
        }
        return collect($contratos);
    }

    /**
     * Valida que un nivel no tenga hijos en un array de contratos
     * @param array $contratos
     * @param string $nivel
     * @return bool
     */
    public static function validarNivel(array $contratos, $nivel)
    {
        foreach ($contratos as $contrato) {
            if (starts_with($contrato['nivel'], $nivel) && (strlen($nivel) < strlen($contrato['nivel']))) {
                return true;
            }
        }
        return false;
    }
}