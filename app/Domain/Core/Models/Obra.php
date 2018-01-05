<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\DatosContables;
use Ghi\Domain\ModulosSAO\Models\Logotipo;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|DatosContables
     */
    public function datosContables() {
        return $this->hasOne(DatosContables::class, 'id_obra');
    }

    public function getLogotipoAttribute() {

        if ($this->nombre == 'PISTA 3 NAICM') {
            return Logotipo::where('Descripcion', '=', 'Logotipo NAICM')->first()->LogotipoReportes;
        } else if (in_array($this->nombre, ['TERMINAL NAICM', 'TERMINAL DEV'])) {
            return Logotipo::where('Descripcion', '=', 'Logotipo Terminal Naicm')->first()->LogotipoReportes;
        } else {
            return Logotipo::where('EsDelGrupo', '=', 1)->where('EstaVigente', '=', 1)->first()->LogotipoReportes;
        }
    }
}
