<?php

namespace Ghi\Domain\Core\Models\Acarreos;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ConciliacionEstimacion extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Acarreos.conciliacion_estimacion';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_conciliacion',
        'id_estimacion',
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $model->registro = auth()->user()->usuario;
            $model->FechaHoraRegistro = Carbon::now()->toDateTimeString();
        });
    }
}
