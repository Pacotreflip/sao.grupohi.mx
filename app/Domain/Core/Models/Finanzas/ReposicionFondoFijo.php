<?php

namespace Ghi\Domain\Core\Models\Finanzas;

use Carbon\Carbon;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Fondo;
use Ghi\Domain\Core\Models\Scopes\ReposicionFondoFijoScope;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Transacciones\Item;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Core\Facades\Context;

/**
 * Class ReposicionFondoFijo
 * @package Ghi\Domain\Core\Models\Finanzas
 */
class ReposicionFondoFijo extends Transaccion
{

    /**
     * @var array
     */
    protected $fillable = [
        "id_referente",
        "referencia",
        "cumplimiento",
        "fecha",
        'cumplimiento',
        "vencimiento",
        "id_concepto",
        "impuesto",
        "monto",
        "saldo",
        "id_moneda",
        "opciones",
        "destino",
        "observaciones",

    ];


    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Comprobante de Fondo Fijo
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ReposicionFondoFijoScope());
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {
            $model->tipo_transaccion = Tipo::REPOSICION_FONDO_FIJO;
            $model->opciones = 1;
            $model->id_moneda = 1;
            $model->FechaHoraRegistro = Carbon::now()->toDateTimeString();
            $model->id_obra = Context::getId();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fondoFijo()
    {
        return $this->belongsTo(Fondo::class, "id_referente", "id_fondo");
    }
}