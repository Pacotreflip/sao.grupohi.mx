<?php

namespace Ghi\Domain\Core\Models;



class Items extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.items';
    protected $primaryKey = 'id_item';

    protected $fillable = [
        'id_material',
        'id_transaccion'
    ];

    public function transaccion(){
        return $this->hasOne(Transaccion::class, 'id_transaccion','id_transaccion');
    }

    public function material() {
        return $this->belongsTo(Material::class, 'id_material', 'id_material');
    }

    public function scopeConTransaccionES($query) {
        return $query->whereHas('transaccion', function($q) {
            $q->whereIn('transacciones.tipo_transaccion', [33, 34]);
        });
    }
}