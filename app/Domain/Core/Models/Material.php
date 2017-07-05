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
}
