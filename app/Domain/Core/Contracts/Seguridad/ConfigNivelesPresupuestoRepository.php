<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 05/01/2018
 * Time: 06:41 PM
 */

namespace Ghi\Domain\Core\Contracts\Seguridad;

use Ghi\Domain\Core\Models\Seguridad\ConfigNivelesPresupuesto;
use Illuminate\Support\Collection;

/**
 * Interface ConfigNivelesPresupuestoRepository
 * @package Ghi\Domain\Core\Contracts\Seguridad
 */
interface ConfigNivelesPresupuestoRepository
{
    /**
     * Obtiene todos los registros de config niveles presupuesto
     * @return Collection | ConfigNivelesPresupuesto
     */
    public function all();

    /**
     * Crea un nuevo registro de config niveles presupuesto
     * @param array $data
     * @return ConfigNivelesPresupuesto
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Actualiza un Registro de config niveles presupuesto
     * @param array $data
     * @param $id
     * @return ConfigNivelesPresupuesto
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
     * @return ConfigNivelesPresupuesto
     */
    public function find($id);
}