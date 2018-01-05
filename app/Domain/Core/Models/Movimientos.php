<?php

namespace Ghi\Domain\Core\Models;


class Movimientos extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.movimientos';
    protected $primaryKey = 'id_movimiento';
    public $timestamps = false;

}
