<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 03/11/2017
 * Time: 09:54 PM
 */

namespace Ghi\Domain\Core\Models;


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
}