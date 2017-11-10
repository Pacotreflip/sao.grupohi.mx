<?php

namespace Ghi\Domain\Core\Models\Tesoreria;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Cuenta;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class TraspasoCuentas extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'Tesoreria.traspaso_cuentas';
    protected $primaryKey = 'id_traspaso';
    protected $fillable = [
        'estatus',
        'id_cuenta_origen',
        'id_cuenta_destino',
        'importe',
        'observaciones',
        'id_obra',
        'folio',
        'fecha',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {

            $mov = MovimientosBancarios::orderBy('numero_folio', 'DESC')->first();
            $folio = $mov ? $mov->numero_folio + 1 : 1;

            $model->estatus = 1;
            $model->id_obra = Context::getId();
            $model->numero_folio = $folio;
        });
    }

    public function cuenta_destino() {
        return $this->belongsTo(Cuenta::class, 'id_cuenta_destino', 'id_cuenta');
    }

    public function cuenta_origen() {
        return $this->belongsTo(Cuenta::class, 'id_cuenta_origen', 'id_cuenta');
    }

    public function traspaso_transaccion()
    {
        return $this->belongsTo(TraspasoTransaccion::class, 'id_traspaso', 'id_traspaso');
    }
}
