<?php
namespace Ghi\Domain\Core\Contracts\Compras;

interface MaterialRepository
{
    /**
     * Obtiene todos los registros de Materiales
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Material
     */
    public function all();

    /**
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Material
     */
    public function find($id);
    /**
     * Guarda un registro de Materiales
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Material
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */

    public function update($id);

    /**
     * Elimina un Material
     * @param $id
     * @return mixed
     */
    public function delete($id);
}