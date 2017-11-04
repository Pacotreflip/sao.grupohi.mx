<?php

namespace Ghi\Domain\Core\Models\Tesoreria;

use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Illuminate\Database\Eloquent\SoftDeletes;

class TraspasoTransaccion extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'Tesoreria.traspaso_transacciones';
    protected $primaryKey = 'id_traspaso_transaccion';
    protected $fillable = [
        'id_traspaso',
        'id_transaccion',
        'tipo_transaccion',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function transaccion_debito() {
        return $this->belongsTo(Transaccion::class, 'id_transaccion', 'id_transaccion');
    }

    public function transaccion_credito() {
        return $this->belongsTo(Transaccion::class, 'id_transaccion', 'id_transaccion');
    }
}
