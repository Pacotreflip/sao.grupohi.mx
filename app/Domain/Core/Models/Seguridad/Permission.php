<?php

namespace Ghi\Domain\Core\Models\Seguridad;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $connection = "seguridad";

    /**
     * Un permisos puede ser requerido en Varios Sistemas
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sistemas() {
        return $this->belongsToMany(Sistema::class, 'dbo.sistemas_permisos', 'permission_id', 'sistema_id');
    }
}