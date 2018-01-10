<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 27/12/2017
 * Time: 07:53 PM
 */

namespace Ghi\Domain\Core\Models\Seguridad;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Scopes\ProyectoScope;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Cierre extends Model
{
    use SoftDeletes;

    protected $table = 'Configuracion.cierres';
    protected $connection = 'seguridad';
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
        static::addGlobalScope(new ProyectoScope());

        static::creating(function ($model) {
            $proyecto = Proyecto::where('base_datos', '=', Context::getDatabaseName())->first();
            $model->id_proyecto = $proyecto->id;
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