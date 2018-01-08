<?php
/**
 * Created by PhpStorm.
 * User: mirah
 * Date: 02/01/2018
 * Time: 04:31 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlCostos;


interface SolicitudReclasificacionRechazadaRepository
{

    public function create($data);

    public function all();

    public function with($relations);

    public function delete($id);

    public function update($data, $id);
}