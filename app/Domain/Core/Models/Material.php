<?php

namespace Ghi\Domain\Core\Models;


class Material extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.materiales';
    protected $primaryKey = 'id_material';


    protected $appends = ['nivel_hijos'];

    public function getNivelHijosAttribute() {
        return $this->nivel . '___.';
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|CuentaMaterial
     */
    public function cuentaMaterial(){
        return $this->hasMany(CuentaMaterial::class, "id_material");
    }
}
