<?php

namespace Ghi\Domain\Core\Models\Finanzas;


use Ghi\Domain\Core\Models\Scopes\SolicitudPagoScope;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;

class TransaccionRubro extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'Finanzas.transacciones_rubros';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_transaccion',
        'id_rubro',
    ];

    protected static function boot()
    {
    }
}