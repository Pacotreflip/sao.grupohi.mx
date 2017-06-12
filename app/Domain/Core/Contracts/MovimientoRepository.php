<?php namespace Ghi\Domain\Core\Contracts;

interface MovimientoRepository
{
 public function create(array $data);
 public function getByPolizaTipoId($id);
}