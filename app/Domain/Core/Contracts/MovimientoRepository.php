<?php namespace Ghi\Domain\Core\Contracts;

interface MovimientoRepository
{
 public function create($id_transaccion_interfaz,array $movimientos);
 public function getByPolizaTipoId($poliza_tipo_id);
}