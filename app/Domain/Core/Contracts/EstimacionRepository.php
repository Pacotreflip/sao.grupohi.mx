<?php
/**
 * Created by PhpStorm.
 * User: JFESQUIVEL
 * Date: 22/09/2017
 * Time: 01:38 PM
 */

namespace Ghi\Domain\Core\Contracts;

use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Models\Transacciones\Estimacion;
use Illuminate\Database\Eloquent\Collection;

interface EstimacionRepository
{
    /**
     * Obtiene todos los registros de Estimaciones
     * @return Collection|Estimacion
     */
    public function all();

    /**
     * @param int $id
     * @return Estimacion
     */
    public function find($id);

    /**
     * Crea relaciones con otros modelos
     * @param array $relations
     * @return mixed
     */
    public function with($relations);

    /**
     * Obtiene las estimaciones que coincidan con los campos de búsqueda
     * @param $attribute
     * @param $operator
     * @param $value
     * @return Collection
     */
    public function getBy($attribute, $operator, $value);

    /**
     * Registra una nueva Estimación
     * @param Request $request
     * @return Estimacion
     * @throws \Exception
     */
    public function create(Request $request);
}