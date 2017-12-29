<?php

namespace Ghi\Domain\Core\Models\ControlCostos;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Transacciones\Item;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudReclasificacionPartidas extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'ControlCostos.solicitud_reclasificacion_partidas';
    protected $primaryKey = 'id_partida';
    protected $fillable = [
        'id_solicitud_reclasificacion',
        'id_item',
        'id_concepto_original',
        'id_concepto_nuevo',
    ];

    public function solicitud()
    {
        return $this->belongsTo(SolicitudReclasificacion::class, 'id_solicitud_reclasificacion', 'id_solicitud_reclasificacion');
    }

    public function item() {
        return $this->belongsTo(Item::class, 'id_item');
    }

    public function conceptoOriginal() {
        return $this->belongsTo(Concepto::class, 'id_concepto_original', 'id_concepto');
    }

    public function conceptoNuevo() {
        return $this->belongsTo(Concepto::class, 'id_concepto_nuevo', 'id_concepto');
    }
}
