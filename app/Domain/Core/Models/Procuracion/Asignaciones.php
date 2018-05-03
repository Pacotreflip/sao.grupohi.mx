<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 18/04/18
 * Time: 17:07
 */

namespace Ghi\Domain\Core\Models\Procuracion;

use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Domain\Core\Models\TipoTransaccion;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Asignacion
 * @package Ghi\Domain\Core\Models\Procuracion
 */
class Asignaciones  extends BaseModel
{
    /**
     *  SoftDeletes
     * eliminacion logica
     */
    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * @var string
     */
    protected $connection = 'cadeco';
    /**
     * @var string
     */
    protected $table = 'Procuracion.asignaciones';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $fillable = [
        'id_transaccion',
        'id_usuario_asigna',
        'id_usuario_asignado',
        'numero_folio',
        'id_usuario_deleted',
    ];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        /**
         * numero de folio progresivo
         */
        static::creating(function ($model) {
            $asignacion = Asignaciones::orderBy('numero_folio', 'DESC')->first();
            $folio = $asignacion ? $asignacion->numero_folio + 1 : 1;
            $model->numero_folio = $folio;
            $model->id_usuario_asigna = auth()->id();
        },10);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario_asigna() {
        return $this->belongsTo(User::class, 'id_usuario_asigna', 'idusuario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario_asignado() {
        return $this->belongsTo(User::class, 'id_usuario_asignado', 'idusuario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaccion() {
        return $this->belongsTo(Transaccion::class, 'id_transaccion', 'id_transaccion');
    }

    public static function getFolio()
    {
        $asignacion = self::orderBy('numero_folio', 'DESC')->first();
        $folio = $asignacion ? $asignacion->numero_folio + 1 : 1;
        return $folio;
    }
}