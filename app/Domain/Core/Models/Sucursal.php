<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 03/11/2017
 * Time: 09:54 PM
 */

namespace Ghi\Domain\Core\Models;


use Carbon\Carbon;

class Sucursal extends BaseModel
{

    protected $connection = 'cadeco';
    protected $table = 'dbo.sucursales';
    protected $primaryKey = 'id_sucursal';
    protected $fillable = [
        'id_empresa',
        'descripcion',
        'direccion',
        'ciudad',
        'estado',
        'codigo_postal',
        'telefono',
        'fax',
        'contacto',
        'casa_central',
        'email',
        'cargo',
        'telefono_movil',
        'observaciones',
        'FechaHoraRegistro',
        'UsuarioRegistro',
        'UsuarioValido'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->UsuarioRegistro = auth()->id();
            $model->FechaHoraRegistro = Carbon::now()->toDateTimeString();
        });
    }
}