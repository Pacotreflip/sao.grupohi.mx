<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 07/06/2018
 * Time: 04:55 PM
 */

namespace Ghi\Domain\Core\Models\Compras;


use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Costo;
use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Scopes\OrdenCompraScope;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;

class OrdenCompra extends Transaccion
{
    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Estimación
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrdenCompraScope());
        static::addGlobalScope(new ObraScope());

        static::creating(function($model) {
            $model->opciones = 1;
            $model->id_obra = Context::getId();
            $model->FechaHoraRegistro = Carbon::now()->toDateTimeString();
            $model->tipo_transaccion = Tipo::ORDEN_COMPRA;
            $model->comentario = "I;" . date('d/m/Y') . " " . date('h:m:s') . ";SAO|" . auth()->user()->usuario . "|";
        });
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function costo() {
        return $this->belongsTo(Costo::class, 'id_costo');
    }

}