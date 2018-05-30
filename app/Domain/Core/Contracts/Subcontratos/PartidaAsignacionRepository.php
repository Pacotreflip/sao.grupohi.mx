<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 28/06/2017
 * Time: 05:53 PM
 */

namespace Ghi\Domain\Core\Contracts\Subcontratos;

use Ghi\Domain\Core\Models\Subcontratos\PartidaAsignacion;

/**
 * Interface PartidaAsignacionRepository
 * @package Ghi\Domain\Core\Contracts\Subcontratos
 */
interface PartidaAsignacionRepository
{
    /**
     * Guardar un nuevo registro
     * @param array $data
     * @return PartidaAsignacion
     * @throws \Exception
     */
    public function create($data);

    /**
     * @param $id Identificador
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Subcontratos\PartidaAsignacionRepository
     */
    public function find($id);

}