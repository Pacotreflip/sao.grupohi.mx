<?php
/**
 * Created by PhpStorm.
 * User: JFEsquivel
 * Date: 28/07/2017
 * Time: 07:44 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;


use Illuminate\Database\Eloquent\Model;

class Revaluacion extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.revaluaciones';

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Factura
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tipo_transaccion = Tipo::FACTURA;
            $model->opciones = 0;
            $model->fecha = Carbon::now();
            $model->id_obra = Context::getId();
        });
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Factura
     */
    public function facturas() {
        return $this->belongsToMany(Factura::class, 'Contabilidad.revaluacion_transaccion', 'id_revaluacion', 'id_transaccion');
    }
}