<?php

namespace Ghi\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.materiales';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|CuentaMaterial
     */
    public function cuentaMaterial(){
        return $this->hasMany(CuentaMaterial::class, "id_material");
    }
}
