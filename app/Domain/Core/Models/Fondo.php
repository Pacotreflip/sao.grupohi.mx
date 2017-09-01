<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 01/09/2017
 * Time: 04:36 PM
 */

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\CuentaFondo;
use Ghi\Domain\Core\Models\Scopes\ObraScope;

class Fondo extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.fondos';
    protected $primaryKey = 'id_fondo';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cuentaFondo() {
        return $this->hasOne(CuentaFondo::class, 'id_fondo', 'id_fondo')->where('Contabilidad.cuentas_fondos.estatus', '=', 1);
    }
}