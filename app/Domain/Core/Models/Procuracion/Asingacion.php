<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 18/04/18
 * Time: 17:07
 */

namespace Ghi\Domain\Core\Models\Procuracion;

use Ghi\Core\Models\Transaccion;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion;
use Ghi\Domain\Core\Models\TipoTransaccion;
use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;
use Ghi\Domain\Core\Models\User as UsuarioAsignado;
use Ghi\Domain\Core\Models\User as UsuarioAsigna;

/**
 * Class Asingacion
 * @package Ghi\Domain\Core\Models\Procuracion
 */
class Asingacion  extends BaseModel
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
    protected $table = 'Prcuracion.asignacion';
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
        'tipo_transaccion',
        'numero_folio',
    ];

    protected $appends = array('usuarioAsignado','usuariosAsigna');
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
            $asignacion = Asingacion::orderBy('numero_folio', 'DESC')->first();
            $folio = $asignacion ? $asignacion->numero_folio + 1 : 1;
            $model->numero_folio = $folio;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioAsignado() {
        return $this->belongsTo(UsuarioAsignado::class, 'id_usuario_asigna', 'idusuario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuariosAsigna() {
        return $this->belongsTo(UsuarioAsigna::class, 'id_usuario_asignado', 'idusuario');
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
    public function tipoTransaccion() {
        return $this->belongsTo(TipoTransaccion::class, 'tipo_transaccion', 'Tipo_Transaccion');
    }
}