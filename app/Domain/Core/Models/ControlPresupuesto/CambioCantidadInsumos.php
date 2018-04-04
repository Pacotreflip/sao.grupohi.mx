<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

class CambioCantidadInsumos extends SolicitudCambio
{

    public function filtroCambioCantidad() {
         return $this->hasOne(FiltroCambioCantidadInsumo::class, "id_solicitud_cambio", "id");
    }
    public function partidas() {
        return $this->hasMany(SolicitudCambioPartida::class, "id_solicitud_cambio", "id");
    }
}
