<?php
/**
 * Created by PhpStorm.
 * User: JFESQUIVEL
 * Date: 16/02/2018
 * Time: 12:39 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;

use Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto;
use \Ghi\Domain\Core\Models\ControlPresupuesto\VariacionVolumen;
use Illuminate\Database\Eloquent\Collection;

interface VariacionVolumenRepository
{
    /**
     * Obtiene todos los registros de Variación de Volúmen
     * @return VariacionVolumen
     */
    public function all();

    /**
     * Regresa las Variaciones de Volúmen Paginadas
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $data);

    /**
     * Guarda un registro de Variación de Volúmen
     * @param array $data
     * @throws \Exception
     * @return VariacionVolumen
     */
    public function create(array $data);

    /**
     * Regresa un registro específico de Variación de Volúmen
     * @param $id
     * @return VariacionVolumen
     */
    public function find($id);

    public function with($relations);

    /**
     * Autoriza una Variación de Volúmen
     * @param $id
     * @param array $data
     * @return VariacionVolumen
     * @throws \Exception
     */
    public function  autorizar($id, array $data);

    /**
     * Rechaza una Variación de Volúmen
     * @param $id
     * @param array $data
     * @throws \Exception
     * @return VariacionVolumen
     */
    public function  rechazar($id, array $data);

    /**
     * Aplica una Variación de Volúmen a un Presupuesto
     * @param VariacionVolumen $variacionVolumen
     * @param $id_base_presupuesto
     * @throws \Exception
     * @return boolean
     */
    public function aplicar(VariacionVolumen $variacionVolumen, $id_base_presupuesto);

    /**
     * Obtiene las bases de datos que afecta el tipo de solicitud Variación de Volumen
     * @return Collection | BasePresupuesto
     */
    public function getBasesAfectadas();
}