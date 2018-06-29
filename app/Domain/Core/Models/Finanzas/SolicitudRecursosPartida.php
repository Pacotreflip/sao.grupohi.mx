<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/06/2018
 * Time: 01:21 PM
 */

namespace Ghi\Domain\Core\Models\Finanzas;


use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SolicitudRecursosPartida
 * @package Ghi\Domain\Core\Models\Finanzas
 */
class SolicitudRecursosPartida extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'cadeco';
    /**
     * @var string
     */
    protected $table = 'Finanzas.solicitudes_recursos_partidas';

    /**
     * @var array
     */
    protected $fillable = [
        'id_solicitud_pago',
        'id_transaccion',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'transaccion',
        'usuario'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
           // TODO:  registro
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitud() {
        return $this->belongsTo(SolicitudRecursos::class, 'id_solicitud_recursos');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaccion() {
        return $this->belongsTo(Transaccion::class, 'id_transaccion', 'id_transaccion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario() {
        return $this->belongsTo(User::class, 'registro');
    }
}