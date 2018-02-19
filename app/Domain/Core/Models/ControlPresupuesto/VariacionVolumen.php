<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 16/02/2018
 * Time: 12:36 PM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Scopes\VariacionVolumenScope;

class VariacionVolumen extends SolicitudCambio
{

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());
        static::addGlobalScope(new VariacionVolumenScope());
        static::creating(function ($model) {
            $model->id_tipo_orden = TipoOrden::VARIACION_VOLUMEN;
            $model->id_solicita = auth()->id();
            $model->fecha_solicitud = Carbon::now()->toDateTimeString();
            $model->id_estatus = Estatus::GENERADA;
            $model->id_obra = Context::getId();
            $model->asignaFolio();
        });
    }

    protected $casts = [
        'aplicada' => 'boolean'
    ];

    protected $appends = [
        'aplicada'
    ];

    public function aplicaciones() {
        return $this->belongsToMany(BasePresupuesto::class, 'ControlPresupuesto.solicitud_cambio_aplicacion', 'id_solicitud_cambio', 'id_base_presupuesto')->withPivot(['aplicada', 'created_at', 'updated_at']);
    }

    public function aplicacionesPendientes() {
        return $this->belongsToMany(BasePresupuesto::class, 'ControlPresupuesto.solicitud_cambio_aplicacion', 'id_solicitud_cambio', 'id_base_presupuesto')->withPivot(['aplicada', 'created_at', 'updated_at'])->wherePivot('aplicada', '=', false);
    }

    public function getAplicadaAttribute() {
        return  $this->aplicaciones()->where('aplicada', '=', true)->count() == BasePresupuesto::all()->count();
    }
}