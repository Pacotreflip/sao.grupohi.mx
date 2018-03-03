<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\CuentaMaterial;
use Ghi\Domain\Core\MOdels\Transacciones\Item;
use Ghi\Domain\Core\Models\Transacciones\Tipo;


class Entrega extends BaseModel
{

    protected $connection = 'cadeco';
    protected $table = 'dbo.entregas';
    protected $primaryKey = 'id_item';

    public $timestamps = false;

}
