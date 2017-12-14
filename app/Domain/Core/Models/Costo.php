<?php

namespace Ghi\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Costo extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.costos';
    protected $primaryKey = 'id_costo';
}
