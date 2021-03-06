<?php

namespace Ghi\Domain\Core\Models\Transacciones;

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 22/09/2017
 * Time: 01:25 PM
 */

use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Scopes\SubcontratoScope;

class Subcontrato extends Transaccion
{

    protected $fillable = [
        'id_antecedente',
        'fecha',
        'id_costo',
        'id_empresa',
        'id_moneda',
        'anticipo',
        'retencion',
        'referencia',
        'observaciones'
    ];

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Subcontrato
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SubcontratoScope());
        static::addGlobalScope(new ObraScope());

        static::creating(function($model) {
            $model->opciones = 2;
            $model->id_obra = Context::getId();
            $model->FechaHoraRegistro = Carbon::now()->toDateTimeString();
            $model->tipo_transaccion = Tipo::SUBCONTRATO;
            $model->comentario = "I;" . date('d/m/Y') . " " . date('h:m:s') . ";SAO|" . auth()->user()->usuario . "|";
        });
    }

    public function __toString()
    {
        return $this->referencia;
    }

    public function empresa() {
        return $this->hasOne(Empresa::class, 'id_empresa', 'id_empresa');
    }

    public function getMontoSubcontratoAttribute() {
        return $this->monto - $this->impuesto;
    }

    public function estimaciones() {
        return $this->hasMany(Estimacion::class, 'id_antecedente', 'id_transaccion');
    }
    public function items(){
        return $this->hasMany(Item::class, 'id_transaccion', 'id_transaccion');
    }
}