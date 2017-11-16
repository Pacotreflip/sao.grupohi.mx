<?php

namespace Ghi\Domain\Core\Models;

class Cuenta extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'cuentas';
    protected $primaryKey = 'id_cuenta';
    public $timestamps = false;

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function scopeParaTraspaso($query) {
        return $query->whereHas('empresa', function ($q) {
            $q->where('tipo_empresa', '=', 8);
        })
            // ->where('cuenta_contable', 'like', '%[0-9\-]%')
            ->whereRaw('ISNUMERIC(numero) = 1');
    }
}


