<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 05/01/2018
 * Time: 06:41 PM
 */

namespace Ghi\Domain\Core\Contracts\Seguridad;

use Ghi\Domain\Core\Models\Seguridad\AccesosApi;
use Illuminate\Support\Collection;

/**
 * Interface AccesosApiRepository
 * @package Ghi\Domain\Core\Contracts\Seguridad
 */
interface AccesosApiRepository
{
    /**
     * Obtiene todos los registros de config niveles presupuesto
     * @return Collection | AccesosApi
     */
    public function all();

    /**
     * Crea un nuevo registro de config niveles presupuesto
     * @param array $data
     * @return AccesosApi
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Actualiza un Registro de config niveles presupuesto
     * @param array $data
     * @param $id
     * @return AccesosApi
     * @throws \Exception
     */
    public function update(array $data, $id);

    /**
     * Elimina un Registro de config niveles presupuesto
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function delete($id);

    /**
     * Regresa registros de config niveles presupuesto Paginados
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data);

    /**
     * Regresa el Registro de config niveles presupuesto Buscado
     * @param $id
     * @return AccesosApi
     */
    public function find($id);
}