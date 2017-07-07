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
    protected $fillable = [
        'nivel'
        ,'tipo_material'
        ,'descripcion'
        ,'id_material'
    ];


    protected $appends = ['nivel_hijos', 'd_padre'];

    public function getNivelHijosAttribute() {
        return $this->nivel . '___.';
    }

    public function scopeMateriales($query){
        return $query->where('tipo_material','=',$this::TIPO_MATERIALES);
    }
    public function getDPadreAttribute(){
        $nv = substr($this->nivel, 0,4);
        return $this->select('descripcion')->where('nivel', '=', $nv)->where('tipo_material', '=', 1)->get();
    }

    public function items() {
        return $this->hasMany(Items::class, 'id_material');
    }

    public function scopeConTransaccionES($query) {
        return $query->whereHas('items.transaccion', function ($q){
            $q->whereIn('transacciones.tipo_transaccion', [33, 34]);
        });
    }
}
