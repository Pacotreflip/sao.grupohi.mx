<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Scopes\FacturaScope;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Illuminate\Support\Facades\DB;

class Factura extends Transaccion
{

    public $fecha_revaluacion;

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Factura
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new FacturaScope());
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {
            $model->tipo_transaccion = Tipo::FACTURA;
            $model->opciones = 0;
            $model->fecha = Carbon::now();
            $model->id_obra = Context::getId();
        });
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne | OrdenPago
     */
    public function ordenPago()
    {
        return $this->hasOne(OrdenPago::class, 'id_referente', 'id_transaccion');
    }

    public function revaluaciones()
    {
        return $this->belongsToMany(Revaluacion::class, 'Contabilidad.revaluacion_transaccion', 'id_transaccion', 'id_revaluacion');
    }

    public function revaluacionesActuales()
    {
        return $this->belongsToMany(Revaluacion::class, 'Contabilidad.revaluacion_transaccion', 'id_transaccion', 'id_revaluacion')
            ->where(DB::raw("MONTH(Contabilidad.revaluaciones.fecha)"), '=', $this->fecha_revaluacion->month)
            ->where(DB::raw("YEAR(Contabilidad.revaluaciones.fecha)"), '=', $this->fecha_revaluacion->year);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}