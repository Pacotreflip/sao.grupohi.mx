<?php

namespace Ghi\Domain\Core\Models\Tesoreria;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Cuenta;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
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
        'fecha',
        'id_obra',
        'numero_folio',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {

            $mov = MovimientosBancarios::orderBy('numero_folio', 'DESC')->first();
            $folio = $mov ? $mov->numero_folio + 1 : 1;

            $model->estatus = 1;
            $model->registro = auth()->id();
            $model->id_obra = Context::getId();
            $model->numero_folio = $folio;
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
        return $this->belongsTo(TipoMovimiento::class, 'id_tipo_movimiento', 'id_tipo_movimiento');
    }
}
