<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 03/11/2017
 * Time: 04:39 AM
 */

namespace Ghi\Domain\Core\Contracts;



use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;
use Illuminate\Database\Eloquent\Collection;

interface ContratoProyectadoRepository
{

    /**
     * Devuelve un contrato proyectado por su ID
     * @param $id
     * @return ContratoProyectado
     */
    public function find($id);

    /**
     * Crea un nuevo registro de Contrato Proyectado
     * @param array $data
     * @return ContratoProyectado
     * @throws \Exception
     */
    public function create(Request $request);

    /**
     * Actualiza un Contrato Proyectado
     * @param array $data
     * @param $id
     * @return ContratoProyectado
     * @throws \Exception
     */
    public function update(array $data, $id);

    /**
     * Agrega nuevos Contratos al Contrato Proyectado
     * @param array $data
     * @param $id
     * @return Collection|Contrato
     * @throws \Exception
     */
    public function addContratos(Request $request, $id);

    /**
     * consultar todos los contratos proyectados
     * @param $where
     * @return mixed
     */
    public function all();
}