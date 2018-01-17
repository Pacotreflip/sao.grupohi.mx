<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 27/12/2017
 * Time: 07:53 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cierre extends Model
{
    use SoftDeletes;

    protected $table = 'Contabilidad.cierres';
    protected $connection = 'cadeco';
    protected $fillable = [
        'anio',
        'mes'
    ];

    protected $appends = [
        'abierto'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {
            $model->id_obra = Context::getId();
            $model->registro = auth()->id();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRegistro() {
        return $this->belongsTo(User::class, 'registro');
    }

    public function aperturas() {
        return $this->hasMany(Apertura::class, 'id_cierre');
    }

    public function getAbiertoAttribute() {
        return (boolean) $this->aperturas()->abiertas()->count();
    }
}