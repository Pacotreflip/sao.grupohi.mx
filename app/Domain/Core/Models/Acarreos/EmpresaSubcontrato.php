<?php

namespace Ghi\Domain\Core\Models\Acarreos;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmpresaSubcontrato extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Acarreos.empresa_subcontratos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_empresa_sao'
        ,'id_empresa_acarreo'
        ,'id_sindicato_acarreo'
        ,'id_tipo_tarifa'
        ,'id_subcontrato'
        ,'registro'
        ,'fechaHoraRegistro'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $model->registro = auth()->user()->usuario;
            $model->fechaHoraRegistro = Carbon::now()->toDateTimeString();
        });
    }
}
