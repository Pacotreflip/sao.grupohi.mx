<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 06:52 PM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;


use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Concepto;
use Illuminate\Database\Eloquent\Model;

class ConceptoTarjeta extends Model
{
    protected $table = 'ControlPresupuesto.concepto_tarjeta';
    protected $connection = 'cadeco';
    public function concepto()
    {
        return $this->hasOne(Concepto::class, 'id_concepto', 'id_concepto');
    }
    protected $fillable = [
        'id_concepto',
        'id_tarjeta',
        'estatus',
        'id_obra'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->estatus =1;
            $model->id_obra = Context::getId();
        });
    }

}