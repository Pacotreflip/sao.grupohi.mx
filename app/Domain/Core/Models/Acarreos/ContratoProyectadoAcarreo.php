<?php

/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 06/12/2017
 * Time: 01:11 PM
 */
namespace Ghi\Domain\Core\Models\Acarreos;
use Carbon\Carbon;
use Ghi\Domain\Core\Models\BaseModel;

class ContratoProyectadoAcarreo extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'Acarreos.contrato_proyectado';
    protected $primaryKey = 'id_contrato';

    protected $fillable = [
        'id_transaccion',
        'descripcion',
        'registro',
        'estatus'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $model->registro = auth()->user()->usuario;
            $model->estatus = 1;
            $model->FechaHoraRegistro = Carbon::now()->toDateTimeString();
        });
    }
}