<?php

namespace Ghi\Domain\Core\Models;


class Material extends BaseModel
{

    const TIPO_MATERIALES            = 1;
    const TIPO_MANO_OBRA_Y_SERVICIOS = 2;
    const TIPO_HERRAMIENTA_Y_EQUIPO  = 4;
    const TIPO_MAQUINARIA            = 8;

    protected $connection = 'cadeco';
    protected $table = 'dbo.materiales';
    protected $primaryKey = 'id_material';

    protected $appends = ['nivel_hijos'];

    public function getNivelHijosAttribute() {
        return $this->nivel . '___.';
    }

    public function scopeMateriales($query){
        return $query->where('tipo_material','=',$this::TIPO_MATERIALES);
    }
}
