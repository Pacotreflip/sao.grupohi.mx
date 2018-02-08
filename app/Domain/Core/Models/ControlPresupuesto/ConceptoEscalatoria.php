<?php
/**
 * Created by PhpStorm.
 * User: JFESQUIVEL
 * Date: 01/02/2018
 * Time: 04:47 PM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;


use Illuminate\Database\Eloquent\Model;

class ConceptoEscalatoria extends Model
{
    protected $table = 'ControlPresupuesto.concepto_escalatoria';
    protected $connection = 'cadeco';
    //protected $primaryKey = false;
    protected  $fillable = ['id_concepto', 'registro'];

    protected static function boot()
    {
        static::creating(function($model) {
            $model->registro = auth()->id();
        });
    }
}