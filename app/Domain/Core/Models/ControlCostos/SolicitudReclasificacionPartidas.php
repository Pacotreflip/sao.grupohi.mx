<?php

namespace Ghi\Domain\Core\Models\ControlCostos;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
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
}
