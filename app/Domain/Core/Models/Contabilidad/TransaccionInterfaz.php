<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Domain\Core\Models\BaseModel;

class TransaccionInterfaz extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.int_transacciones_interfaz';
    protected $primaryKey = 'id_transaccion_interfaz';
    protected $fillable = [
        'descripcion'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|PolizaTipo
     */
    public function polizasTipo()
    {
        return $this->hasMany(PolizaTipo::class, "id_transaccion_interfaz");
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->descripcion;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDisponibles($query)
    {
        return $query->has('polizasTipo', '=', 0);
    }
}
