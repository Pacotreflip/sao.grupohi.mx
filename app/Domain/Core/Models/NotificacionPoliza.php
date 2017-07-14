<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\Poliza;
use Illuminate\Database\Eloquent\Model;

class NotificacionPoliza extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.notificaciones_polizas';
    protected $fillable =
        [
            'id_notificacion',
            'id_int_poliza',
            'tipo_poliza',
            'concepto',
            'cuadre',
            'fecha_solicitud',
            'usuario_solicita',
            'estatus',
            'poliza_contpaq'
        ];

    public function poliza()
    {
        return $this->belongsTo(Poliza::class, 'id_tipo_poliza_contpaq');

    }

    public function notificacion()
    {
        return $this->belongsTo(Notificacion::class, 'id_notificacion');
    }
}