<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 07/05/2018
 * Time: 04:41 PM
 */

namespace Ghi\Domain\Core\Models\Subcontratos;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Asignaciones
 * @package Ghi\Domain\Core\Models\Subcontratos
 */
class Asignaciones extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cadeco';
    /**
     * @var string
     */
    protected $table = 'Subcontratos.asignaciones';
    /**
     * @var string
     */
    protected $primaryKey = 'id_asignacion';
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'id_transaccion',
        'registro',
        'estado',
        'fecha_hora_registro',
        'autorizo',
        'fecha_hora_autorizacion',
    ];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->registro =  auth()->id();
            $model->estado = 1;//que estado va
            $model->fecha_hora_registro = date('Y-m-d H:i:s');
            $model->autorizo = auth()->id();
            $model->fecha_hora_autorizacion = date('Y-m-d H:i:s');
        });
    }
}