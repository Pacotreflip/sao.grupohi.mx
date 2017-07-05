<?php

namespace Ghi\Domain\Core\Models\Compras\Requisiciones;

use Ghi\Domain\Core\Models\Scopes\RequisicionScope;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Domain\Core\Models\Transacciones\TransaccionTrait;

class Requisicion extends Transaccion
{
    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Requisición
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RequisicionScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaccionExt() {
        return $this->hasOne(TransaccionExt::class, 'id_transaccion', 'id_transaccion');
    }

    /**
     * @return string
     */
    public function getFolioAttribute() {
        return $this->departamentoResponsable->descripcion_corta . '-' . $this->tipoRequisicion->descripcion_corta . '-' . $this->numero_folio;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|DepartamentoResponsable
     */
    public function departamentoResponsable() {
        return $this->transaccionExt->departamentoResponsable();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|TipoRequisicion
     */
    public function tipoRequisicion() {
        return $this->transaccionExt->tipoRequisicion();
    }
}