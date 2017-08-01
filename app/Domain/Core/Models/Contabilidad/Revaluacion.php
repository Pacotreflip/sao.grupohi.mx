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
use Illuminate\Database\Eloquent\Model;

class Revaluacion extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.revaluaciones';

    protected $fillable=[
        'fecha'
        ,'tipo_cambio'
        ,'id_moneda'
        ,'id_obra'
    ];
    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Factura
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->fecha = Carbon::now();
            $model->id_obra = Context::getId();
            $model->id_moneda=Moneda::DOLARES;
        });
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Factura
     */
    public function facturas() {
        return $this->belongsToMany(Factura::class, 'Contabilidad.revaluacion_transaccion', 'id_revaluacion', 'id_transaccion');
    }
}