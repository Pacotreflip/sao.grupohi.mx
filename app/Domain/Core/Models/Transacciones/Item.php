<?php

namespace Ghi\Domain\Core\Models\Transacciones;

use Ghi\Domain\Core\Models\Compras\Requisiciones\ItemExt;
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
        'cantidad'
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
}
