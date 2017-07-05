<?php

namespace Ghi\Domain\Core\Models\Compras\Requisiciones;

use Illuminate\Database\Eloquent\Model;

class TipoRequisicion extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cadeco';

    /**
     * @var string
     */
    protected $table = 'Compras.tipos_requisicion';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|TransaccionExt
     */
    public function transaccionExt() {
        return $this->hasMany(TransaccionExt::class, 'id_tipo_requisicion', 'id');
    }
}