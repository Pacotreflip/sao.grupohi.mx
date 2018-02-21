<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

class Escalatoria extends SolicitudCambio
{
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
