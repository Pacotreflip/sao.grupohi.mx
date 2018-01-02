<?php

namespace Ghi\Domain\Core\Models\ControlCostos;

use Ghi\Domain\Core\Models\BaseModel;

class Estatus extends BaseModel
{
    protected $table = 'ControlCostos.estatus';
    protected $connection = 'cadeco';
    protected $primaryKey = 'id';
}
