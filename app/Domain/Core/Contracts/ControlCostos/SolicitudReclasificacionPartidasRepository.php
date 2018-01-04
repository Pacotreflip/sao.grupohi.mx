<?php

namespace Ghi\Domain\Core\Contracts\ControlCostos;


interface SolicitudReclasificacionPartidasRepository
{

    public function create($data);

    public function all();

    public function with($relations);

    public function delete($id);

    public function update($data, $id);
}