<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Domain\Core\Models\BaseModel;

class TraspasoCuentas extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.traspaso_cuentas';
    protected $primaryKey = 'id_traspaso';
    protected $fillable = [];

    protected static function boot()
    {
        parent::boot();
    }
}
