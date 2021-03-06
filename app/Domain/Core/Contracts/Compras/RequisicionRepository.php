<?php
namespace Ghi\Domain\Core\Contracts\Compras;


interface RequisicionRepository
{
    /**
     * Obtiene todos los registros de Requisicion
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Transacciones\Transaccion
     */
    public function all();

    /**
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Transacciones\Transaccion
     */
    public function find($id);
    /**
     * Guarda un registro de Transaccion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Transacciones\Transaccion
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations);

    /**
     * Actualiza un registro de Transaccion
     * @param array $data
     * @param integer $id
     * @return \Ghi\Domain\Core\Models\Transacciones\Transaccion
     * @throws \Exception
     */
    public function update(array $data, $id);

    /**
     * Elimina una Requisicion
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param array $cols
     * @param string $q
     * @return mixed
     */
    public function like(array $cols,$q);

    /**
     * @param int $id_requisicion
     * @return mixed
     */
    public function getPartidasCotizacion($id_requisicion, $id_transaccion_sao, $solo_pendientes);

    public function getPartidasCotizacionAgrupadas($id_requisicion, $id_transaccion_sao, $solo_pendientes);

    public function getRequisicion($id_requisicion);
}