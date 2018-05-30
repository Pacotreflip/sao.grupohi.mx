<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 28/06/2017
 * Time: 05:53 PM
 */

namespace Ghi\Domain\Core\Contracts\Subcontratos;

use Ghi\Domain\Core\Models\Subcontratos\Asignaciones;

/**
 * Interface AsignacionesRepository
 * @package Ghi\Domain\Core\Contracts\Subcontratos
 */
interface AsignacionesRepository
{
    /**
     * Guardar un nuevo registro
     * @param array $data
     * @return Asignaciones
     * @throws \Exception
     */
    public function create($data);

    /**
     * @param $id Identificador
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Subcontratos\AsignacionesRepository
     */
    public function find($id);

}