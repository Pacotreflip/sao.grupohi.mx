<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 03/01/2018
 * Time: 12:59 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;


use Carbon\Carbon;
use Ghi\Domain\Core\Models\BaseModel;

class Apertura extends BaseModel
{
    protected $table = 'Contabilidad.cierres_aperturas';
    protected $connection = 'cadeco';
    public $timestamps = false;
    protected $fillable = [
        'motivo',
        'registro',
        'inicio_apertura',
        'fin_apertura',
        'estatus'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $model->estatus = true;
            $model->registro = auth()->id();
            $model->inicio_apertura = Carbon::now()->toDateTimeString();
        });
    }

    public function cierre() {
        return $this->belongsTo(Cierre::class, 'id_cierre');
    }

    public function scopeAbiertas($query) {
        return $query->where('estatus', '=', true);
    }

    public function scopeCerradas($query) {
        return $query->where('estatus', '=', false);
    }
}