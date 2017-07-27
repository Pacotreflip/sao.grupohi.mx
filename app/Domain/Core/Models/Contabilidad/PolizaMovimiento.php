<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Domain\Core\Models\Empresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolizaMovimiento extends Model
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.int_polizas_movimientos';
    protected $primaryKey = 'id_int_poliza_movimiento';
    protected $fillable = [
        'id_int_poliza',
        'id_tipo_cuenta_contable',
        'id_cuenta_contable',
        'cuenta_contable',
        'importe',
        'id_tipo_movimiento_poliza',
        'referencia',
        'concepto',
        'id_empresa_cadeco',
        'razon_social',
        'rfc',
        'estatus',
        'timestamp',
        'registro'
    ];

    protected $appends = ['descripcion_cuenta_contable'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function polizaMovimiento()
    {
        return $this->belongsTo(Poliza::class, 'id_int_poliza');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class, 'id_cuenta_contable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoMovimientos()
    {
        return $this->belongsTo(TipoMovimiento::class, 'id_tipo_movimiento_poliza');
    }

    public function getDescripcionCuentaContableAttribute()
    {
        if ($cuenta_contable = CuentaContable::where('cuenta_contable', '=', $this->cuenta_contable)->first()) {
            return (String)$cuenta_contable->tipoCuentaContable;
        } else {
            return "No Registrada";
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoCuentaContable()
    {
        return $this->belongsTo(TipoCuentaContable::class, 'id_tipo_cuenta_contable');
    }

    /**
     * @param Importe
     * @return Importe con 2 decimales
     */
    public function getImporteAttribute($value)
    {
        return $this->attributes['importe'] = number_format((float)$value, 2, '.', '');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresaCadeco()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa_cadeco');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('id_empresa_cadeco', 'asc');
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotNull($query)
    {
        return $query->WhereNull('Contabilidad.int_polizas_movimientos.cuenta_contable');
    }
}
