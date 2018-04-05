<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 23/02/2018
 * Time: 04:55 PM
 */

namespace Ghi\Domain\Core\Models\Seguridad;


use Illuminate\Database\Eloquent\Model;

class AccesosApi extends Model
{
    protected $table = 'dbo.accesos_api';
    protected $connection = 'seguridad';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'description',
        'tipo',
        'app_key',
    ];
}