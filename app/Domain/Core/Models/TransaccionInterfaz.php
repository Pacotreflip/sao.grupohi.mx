<?php

namespace Ghi\Domain\Core\Models;


class TransaccionInterfaz extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.int_transacciones_interfaz';
    protected $primaryKey = 'id_transaccion_interfaz';
    protected $fillable = [
        'descripcion'
    ];
    public function polizasTipo(){
        return $this->hasMany(PolizaTipo::class, "id_transaccion_interfaz");
    }

    public function __toString()
    {
        return $this->descripcion;
    }

    public function scopeDisponibles($query)
    {
        return $query->has('polizasTipo', '=', 0);
    }
}
