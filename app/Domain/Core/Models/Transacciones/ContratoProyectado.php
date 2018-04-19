<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 05/11/2017
 * Time: 23:59
 */

namespace Ghi\Domain\Core\Models\Transacciones;


use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Contrato;
use Ghi\Domain\Core\Models\Procuracion\Asingacion;
use Ghi\Domain\Core\Models\Scopes\ContratoProyectadoScope;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Sucursal;

class ContratoProyectado extends Transaccion
{

    protected $fillable = [
        'referencia',
        'tipo_transaccion',
        'numero_folio',
        'fecha',
        'estado',
        'impreso',
        'id_obra',
        'opciones',
        'comentario',
        'observaciones',
        'FechaHoraRegistro',
        'cumplimiento',
        'vencimiento'
    ];

    protected $dates = [
        'fecha',
        'cumplimiento',
        'vencimiento'
    ];

    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Contrato Proyectado
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ContratoProyectadoScope());
        static::addGlobalScope(new ObraScope());

        static::creating(function($model) {
            $model->id_obra = Context::getId();
            $model->FechaHoraRegistro = Carbon::now()->toDateTimeString();
            $model->tipo_transaccion = Tipo::CONTRATO_PROYECTADO;
            $model->opciones = 1026;
            $model->comentario = "I;" . date('d/m/Y') . " " . date('h:m:s') . ";SAO|" . auth()->user()->usuario . "|";
        });
    }

    public function cotizacionesContrato() {
        return $this->hasMany(CotizacionContrato::class, 'id_antecedente', 'id_transaccion');
    }

    public function contratos() {
        return $this->hasMany(Contrato::class, 'id_transaccion', 'id_transaccion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignaciones()
    {
        return $this->hasMany(Asingacion::class, 'id_transaccion', 'id_transaccion');

    }
}