<?php

namespace Ghi\Domain\Core\Models\Compras\Requisiciones;

use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Compras\CotizacionCompra;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Scopes\RequisicionScope;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Domain\Core\Models\Transacciones\TransaccionTrait;
use Ghi\Domain\Core\Models\Procuracion\Asignacion;

class Requisicion extends Transaccion
{

    protected $fillable = [
        'tipo_transaccion',
        'fecha',
        'opciones',
        'observaciones'
    ];

    protected $dates = ['fecha'];

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Requisición
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RequisicionScope());
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {
            $model->tipo_transaccion = Tipo::REQUISICION;
            $model->opciones = 1;
            $model->fecha = Carbon::now();
            $model->id_obra = Context::getId();
        });

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaccionExt() {
        return $this->hasOne(TransaccionExt::class, 'id_transaccion', 'id_transaccion');
    }

    /**
     * @return string
     */
    public function getFolioAttribute() {
        return $this->transaccionExt->folio_adicional;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|DepartamentoResponsable
     */
    public function departamentoResponsable() {
        return $this->transaccionExt->departamentoResponsable();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|TipoRequisicion
     */
    public function tipoRequisicion() {
        return $this->transaccionExt->tipoRequisicion();
    }

    public function cotizacionesCompra() {
        return $this->hasMany(CotizacionCompra::class, 'id_antecedente', 'id_transaccion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignaciones(){
        return $this->hasMany(Asignacion::class, 'id_transaccion', 'id_transaccion');
    }
}