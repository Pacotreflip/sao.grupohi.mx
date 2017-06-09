<?php namespace Ghi\Domain\Core\Contracts;

interface MovimientoRepository
{
 function create($id_transaccion_interfaz,array $movimientos);
}