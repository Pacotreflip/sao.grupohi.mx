<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Cuenta;
use Ghi\Domain\Core\Models\Empresa;
use Illuminate\Database\Eloquent\SoftDeletes;


class CuentaBancos extends BaseModel
{
    use SoftDeletes;
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.cuentas_contables_bancarias';
    protected $fillable = [
        'id_cuenta',
        'id_tipo_cuenta_contable',
        'numero',
        'estatus',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->estatus = 1;
            $model->registro = auth()->user()->idusuario;
        });
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function cuentas() {
        return $this->belongsTo(Cuenta::class, 'id_cuenta');
    }

    public function tipoCuentaContable() {
        return $this->belongsTo(TipoCuentaContable::class, 'id_tipo_cuenta_contable');
    }

    public function tipos()
    {
        return TipoCuentaContable::with('cuentaContable')->get();
    }
}