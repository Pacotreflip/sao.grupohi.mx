<?php

namespace Ghi\Domain\Core\Models;

use Ghi\Domain\Core\Models\Contabilidad\CuentaAlmacen;

class Almacen extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.almacenes';
    protected $primaryKey = 'id_almacen';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|CuentaAlmacen
     */
    public function cuentaAlmacen(){
        return $this->hasOne(CuentaAlmacen::class, "id_almacen");
    }
}
