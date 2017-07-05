<?php

namespace Ghi\Domain\Core\Models\Compras\Requisiciones;

use Ghi\Domain\Core\Models\Transacciones\Item;
use Illuminate\Database\Eloquent\Model;

class ItemExt extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cadeco';

    /**
     * @var string
     */
    protected $table = 'Compras.items_ext';

    /**
     * @var string
     */
    protected $primaryKey = 'id_item';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Item
     */
    public function item() {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
}