<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 05/01/2018
 * Time: 06:41 PM
 */

namespace Ghi\Domain\Core\Contracts\Seguridad;

use Ghi\Domain\Core\Models\Seguridad\ConfiguracionObra;
use Illuminate\Support\Collection;

/**
 * Interface ConfiguracionObraRepository
 * @package Ghi\Domain\Core\Contracts\Seguridad
 */
interface ConfiguracionObraRepository
{
    /**
     * Obtiene todos los registros de config niveles presupuesto
     * @return Collection | ConfiguracionObra
     */
    public  function all();

    /**
     * Crea un nuevo registro de config obra
     * @param array $data
     * @return ConfiguracionObra
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Actualiza un Registro de config obra
     * @param array $data
     * @param $id
     * @return ConfiguracionObra
     * @throws \Exception
     */
    public function update(array $data, $id);

    /**
     * Elimina un Registro de config obra
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function delete($id);

    /**
     * Regresa registros de config obra Paginados
     * @param array $data
     * @return mixed
     */
    public function paginate(array $data);

    /**
     * Regresa el Registro de config obra Buscado
     * @param $id
     * @return ConfiguracionObra
     */
    public function find($id);
}