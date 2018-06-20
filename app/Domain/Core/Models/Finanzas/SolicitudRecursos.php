<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/06/2018
 * Time: 01:13 PM
 */

namespace Ghi\Domain\Core\Models\Finanzas;


use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SolicitudRecursos
 * @package Ghi\Domain\Core\Models\Finanzas
 */
class SolicitudRecursos extends Model
{

    use SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'cadeco';
    /**
     * @var string
     */
    protected $table = 'Finanzas.solicitud_recursos';

    /**
     * @var array
     */
    protected $fillable = [
        'id_tipo',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'partidas',
        'tipo',
        'usuario',
    ];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            /*
            TODO:
            $model->consecutivo =
            $model->folio =
            $model->registro =
            $model->semama =
            $model->anio =
            */
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo() {
        return $this->belongsTo(CTGTipoSolicitud::class, 'id_tipo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partidas() {
        return $this->hasMany(SolicitudRecursosPartida::class, 'id_solicitud_recursos');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario() {
        return $this->belongsTo(User::class, 'registro');
    }
}
