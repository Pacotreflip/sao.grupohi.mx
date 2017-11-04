<?php

namespace Ghi\Domain\Core\Models\Tesoreria;

use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Cuenta;
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

        // Crear el nuevo folio de acuerdo con el id de la obra
        $id_obra = session()->get('id');
        $folio = TraspasoCuentas::where('id_obra', $id_obra)->max('numero_folio');
        $folio = (int) $folio + 1;

        static::creating(function ($model) use($folio) {
            $model->estatus = 1;
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
