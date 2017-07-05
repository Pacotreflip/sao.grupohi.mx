<?php

namespace Ghi\Domain\Core\Models\Compras\Requisiciones;
use Illuminate\Database\Eloquent\Model;

class DepartamentoResponsable extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cadeco';

    /**
     * @var string
     */
    protected $table = 'Compras.departamentos_responsables';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|TransaccionExt
     */
    public function transaccionExt() {
        return $this->hasMany(TransaccionExt::class, 'id_departamento', 'id');
    }
}