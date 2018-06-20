<?php

namespace Ghi\Domain\Core\Models\Finanzas;

use Carbon\Carbon;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Fondo;
use Ghi\Domain\Core\Models\Scopes\ComprobanteFondoFijoScope;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Transacciones\Item;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Core\Facades\Context;

class ComprobanteFondoFijo extends Transaccion
{

    protected $fillable = [
        "id_referente",
        "referencia",
        "cumplimiento",
        "fecha",
        "id_concepto",
        "impuesto",
        "monto",
        "id_moneda",
        "opciones",
        "observaciones"

    ];


    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Comprobante de Fondo Fijo
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ComprobanteFondoFijoScope());
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {
            $model->tipo_transaccion = Tipo::COMPROBANTE_FONDO_FIJO;
            $model->opciones = 1;
            $model->id_obra = Context::getId();
        });
    }

    public function items()
    {
        return $this->hasMany(Item::class, "id_transaccion", "id_transaccion");
    }

    public function fondoFijo()
    {
        return $this->belongsTo(Fondo::class, "id_referente", "id_fondo");
    }

    /**
     * Concepto relacionado con este item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Concepto
     */
    public function concepto()
    {
        return $this->belongsTo(Concepto::class, 'id_concepto', 'id_concepto');
    }

    public function getSubtotalAttribute()
    {
        $suma = 0;
        foreach ($this->items as $item) {
            $suma += $item->importe;
        }

        return $suma;
    }

    public function getNaturalezaAttribute()
    {
        $naturaleza = 0;
        foreach ($this->items as $item) {
            $naturaleza = $item->id_material ? 1 : 0;
            if ($item->id_material != null) {
                $naturaleza = 1;
            }
        }
        return $naturaleza;
    }

    public function getDescripcionNaturalezaAttribute()
    {
       return  $this->Naturaleza==1?'Materiales / Servicios':'Gastos Varios';
    }

    /*public function getCumplimientoAttribute($cumplimiento)
    {
        return Carbon::parse($cumplimiento)->format('Y-m-d');
    }*/

    /*public function getFechaAttribute($fecha) {
        return $fecha?Carbon::parse($fecha)->format('Y-m-d'):'';
    }*/
}