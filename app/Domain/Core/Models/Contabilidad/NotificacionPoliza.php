<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Domain\Core\Models\Contabilidad\Poliza;
use Illuminate\Database\Eloquent\Model;

class NotificacionPoliza extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.notificaciones_polizas';
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
            'poliza_contpaq',
            'total'
        ];
    public $timestamps = false;



    public function notificacion()
    {
        return $this->belongsTo(Notificacion::class, 'id_notificacion');
    }

    public function poliza()
    {
        return $this->hasOne(Poliza::class, 'id_int_poliza', 'id_int_poliza');
    }
}