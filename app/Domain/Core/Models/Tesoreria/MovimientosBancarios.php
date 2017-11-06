<?php

namespace Ghi\Domain\Core\Models\Tesoreria;

use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Cuenta;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimientosBancarios extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'Tesoreria.movimientos_bancarios';
    protected $primaryKey = 'id_movimiento_bancario';
    protected $fillable = [
        'id_tipo_movimiento',
        'estatus',
        'id_cuenta',
        'impuesto',
        'importe',
        'observaciones',
        'registro',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->estatus = 1;
            $model->registro = auth()->user()->idusuario;
        });
    }

    public function cuenta() {
        return $this->belongsTo(Cuenta::class, 'id_cuenta', 'id_cuenta');
    }


    public function movimiento_transaccion()
    {
        return $this->belongsTo(MovimientoTransacciones::class, 'id_movimiento_bancario', 'id_movimiento_bancario');
    }

    public function tipo() {
        return $this->belongsTo(TiposMovimientos::class, 'id_tipo_movimiento', 'id_tipo_movimiento');
    }
}
