<?php

namespace Ghi\Domain\Core\Models\Transacciones;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cadeco';

    /**
     * @var string
     */
    protected $table = 'dbo.transacciones';

    /**
     * @var string
     */
    protected $primaryKey = 'id_transaccion';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Items relacionados con esta transaccion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Item
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'id_transaccion', 'id_transaccion');
    }
}
