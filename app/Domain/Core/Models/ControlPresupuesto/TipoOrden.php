<?php

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Illuminate\Database\Eloquent\Model;

class TipoOrden extends Model
{
    const ESCALATORIA = 1;
    const RECLAMOS_INDIRECTO = 2;
    const CONCEPTOS_EXTRAORDINARIOS = 3;
    const VARIACION_VOLUMEN = 4;
    const ORDEN_DE_CAMBIO_NO_COBRABLE = 5;
    const ORDEN_DE_CAMBIO_DE_INSUMOS = 6;
    const ORDEN_DE_CAMBIO_DE_CANTIDAD_INSUMOS = 8;

    protected $table = 'ControlPresupuesto.tipos_ordenes';
    protected $connection = 'cadeco';
    public $incrementing = false;
    protected $fillable = [
        'descripcion',
        'id_tipo_cobrabilidad',
        'estatus',
        'name',
    ];

    public function cobrabilidad()
    {
        return $this->belongsTo(TipoCobrabilidad::class, 'id_tipo_cobrabilidad', 'id');
    }

    public function basesPresupuesto() {
        return $this->belongsToMany(BasePresupuesto::class, 'ControlPresupuesto.afectacion_ordenes_presupuesto', 'id_tipo_orden', 'id_base_presupuesto');
    }

    public function partidas() {
        return $this->hasManyThrough(SolicitudCambioPartida::class, SolicitudCambio::class, 'id_tipo_orden', 'id_solicitud_cambio', 'id', 'id');
    }

    public function getMontoAutorizadoAttribute() {
        $res = 0;
        foreach ($this->partidas()->has('historico')->get() as $partida) {
            $res += ($partida->historico->monto_presupuestado_actualizado - $partida->historico->monto_presupuestado_original);
        }
        return $res;
    }
}
