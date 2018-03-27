<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Seguridad\Proyecto;
use Ghi\Domain\Core\Models\Contabilidad\DatosContables;
use Ghi\Domain\ModulosSAO\Models\Logotipo;
use Ghi\Domain\Core\Models\Seguridad\ConfiguracionObra;

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

    /**
     * @return mixed
     */
    public function configuracionObra(){
        return $this->hasOne(ConfiguracionObra::class, 'id_obra')->where('id_proyecto','=',Proyecto::where('base_datos', '=',Context::getDatabaseName())->first()->id);
    }

    /**
     * @return mixed
     */
    public function getLogotipoAttribute() {
        return $this->configuracionObra->logotipo_original;
    }
}
