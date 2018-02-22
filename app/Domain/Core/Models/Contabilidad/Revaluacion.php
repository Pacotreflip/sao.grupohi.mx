<?php
/**
 * Created by PhpStorm.
 * User: JFEsquivel
 * Date: 28/07/2017
 * Time: 07:44 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;


use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Moneda;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\Model;

class Revaluacion extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.revaluaciones';

    protected $fillable=[
        'fecha',
        'tipo_cambio',
        'id_moneda',
        'id_obra',
        'user_registro'
    ];

    protected $dates=['fecha'];

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Factura
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_obra = Context::getId();
            $model->user_registro = auth()->id();
        });
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Factura
     */
    public function facturas() {
        return $this->belongsToMany(Factura::class, 'Contabilidad.revaluacion_transaccion', 'id_revaluacion', 'id_transaccion');
    }

    public function moneda() {
        return $this->belongsTo(Moneda::class, 'id_moneda', 'id_moneda');
    }

    public function usuario_registro() {
        return $this->belongsTo(User::class, 'user_registro', 'idusuario');
    }
}