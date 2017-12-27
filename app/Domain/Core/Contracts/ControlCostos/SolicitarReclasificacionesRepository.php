<?php

namespace Ghi\Domain\Core\Contracts\ControlCostos;


interface SolicitarReclasificacionesRepository
{

    public function create($data);

    public function all();

    public function delete($id);
}