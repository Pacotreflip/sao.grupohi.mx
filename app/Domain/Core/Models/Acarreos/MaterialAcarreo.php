<?php

namespace Ghi\Domain\Core\Models\Acarreos;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MaterialAcarreo extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Acarreos.material';
    protected $primaryKey = 'id';

    protected $fillable = [
         'id_material_acarreo'
        ,'id_concepto'
        ,'id_concepto_contrato'
        ,'id_transaccion'
        ,'id_item'
        ,'tarifa'
        ,'registro'
        ,'fechaHoraRegistro'
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
