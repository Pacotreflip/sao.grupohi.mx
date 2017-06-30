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

    public function getTipoAlmacenAttribute($tipo_almacen) {
        switch ($tipo_almacen) {
            case 0:
                return 'Almacén Materiales';
                break;
            case 1:
                return 'Almacén Maquina';
                break;
            case 2:
                return 'Almacén Maquina Controladora de Insumos';
                break;
            case 3:
                return 'Almacén Mano de Obra';
                break;
            case 4:
                return 'Almacén Servicios';
                break;
            case 5:
                return 'Almacén Herramientas';
                break;
        }
    }
}
