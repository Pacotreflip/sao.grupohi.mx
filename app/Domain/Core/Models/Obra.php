<?php

namespace Ghi\Domain\Core\Models;

class Obra extends \Ghi\Core\Models\Obra
{
    protected $fillable = [
        'nombre',
        'tipo_obra',
        'constructora',
        'cliente',
        'facturar',
        'descripcion',
        'direccion',
        'ciudad',
        'estado',
        'codigo_postal',
        'fecha_inicial',
        'fecha_final',
        'iva',
        'id_moneda',
        'responsable',
        'rfc',
        'rowguid',
        'nombre_publico',
        'BDContPaq',
        'NumobraContPaq',
        'FormatoCuenta',
        'FormatoCuentaRegExp'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|CuentaContable
     */
    public function cuentasContables(){
        return $this->hasMany(CuentaContable::class, "id_obra");
    }
}
