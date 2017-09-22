<?php

namespace Ghi\Domain\Core\Models\Transacciones;

use Ghi\Domain\Core\Models\Almacen;
use Ghi\Domain\Core\Models\Compras\Requisiciones\ItemExt;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Material;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cadeco';

    /**
     * @var string
     */
    protected $table = 'dbo.items';

    /**
     * @var string
     */
    protected $primaryKey = 'id_item';

    /**
     * @var array
     */
    protected $casts = [
        'cantidad' => 'float',
        'precio_unitario' => 'float'
    ];

    protected $fillable = [
        'id_transaccion',
        'id_material',
        'unidad',
        'cantidad',
        'id_concepto',
        'id_almacen',
        'precio_unitario',
        'importe',
        'referencia',
        'estado'
    ];

    public $timestamps = false;

    /**
     * Material relacionado con este item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Material
     */
    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material', 'id_material');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|ItemExt
     */
    public function itemExt()
    {
        return $this->hasOne(ItemExt::class, 'id_item', 'id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne | Transaccion
     */
    public function transaccion()
    {
        return $this->hasOne(Transaccion::class, 'id_transaccion', 'id_transaccion');
    }

    /**
     * @param $query Consulta para obtener transacciones por cada Item
     * @return mixed Item con Transacción
     */
    public function scopeConTransaccionES($query)
    {
        return $query->whereHas('transaccion', function ($q) {
            $q->whereIn('transacciones.tipo_transaccion', Tipo::TIPO_TRANSACCION);
        })->orderBy('id_item');
    }


    /**
     * Concepto relacionado con este item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Concepto
     */
    public function concepto()
    {
        return $this->belongsTo(Concepto::class, 'id_concepto', 'id_concepto');
    }

    /**
     * Concepto relacionado con este item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Concepto
     */
    public function destino()
    {

        if($this->id_almacen) {
            return $this->belongsTo(Almacen::class, 'id_almacen', 'id_almacen');
        }
        if($this->id_concepto) {
            return $this->belongsTo(Concepto::class, 'id_concepto', 'id_concepto');

        }
    }


    public function getMontoAttribute()
    {
        return $this->importe;
    }
}
