<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 27/12/2017
 * Time: 07:53 PM
 */

namespace Ghi\Domain\Core\Models\Seguridad;


use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Scopes\ProyectoScope;
use Ghi\Domain\Core\Models\User;

class Cierre extends BaseModel
{
    protected $table = 'Configuracion.cierres';
    protected $connection = 'seguridad';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());
        static::addGlobalScope(new ProyectoScope());

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRegistro() {
        return $this->belongsTo(User::class, 'registro');
    }
}