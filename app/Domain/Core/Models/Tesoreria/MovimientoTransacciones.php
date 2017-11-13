<?php

namespace Ghi\Domain\Core\Models\Tesoreria;

use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimientoTransacciones extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'Tesoreria.movimiento_transacciones';
    protected $primaryKey = 'id_movimiento_transaccion';
    protected $fillable = [
        'id_movimiento_bancario',
        'id_transaccion',
        'tipo_transaccion',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function transaccion() {
        return $this->belongsTo(Transaccion::class, 'id_transaccion', 'id_transaccion');
    }

}
