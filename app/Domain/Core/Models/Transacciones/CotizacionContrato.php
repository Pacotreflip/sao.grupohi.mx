<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 07/03/2018
 * Time: 12:40 PM
 */

namespace Ghi\Domain\Core\Models\Transacciones;


use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Presupuesto;
use Ghi\Domain\Core\Models\Scopes\CotizacionContratoScope;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Sucursal;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Core\Facades\Context;
use Illuminate\Support\Facades\Log;

class CotizacionContrato extends Transaccion
{
    /**
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'tipo_transaccion',
        'fecha',
        'estado',
        'id_obra',
        'id_cuenta',
        'id_moneda',
        'cumplimiento',
        'vencimiento',
        'opciones',
        'monto',
        'impuesto',
        'referencia',
        'comentario',
        'observaciones',
        'FechaHoraRegistro',
        'numero_folio',
        'PorcentajeDescuento',
        'TcUSD',
        'TcEuro',
        'DiasCredito',
        'DiasVigencia',
    ];
    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Cotización de Contrato
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CotizacionContratoScope());
        static::addGlobalScope(new ObraScope());
    }

    public function presupuestos() {
        return $this->hasMany(Presupuesto::class, 'id_transaccion', 'id_transaccion');
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function sucursal() {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    public function getCandidataAttribute()
    {
        $res = false;
        foreach ($this->presupuestos as $presupuesto) {
            if($presupuesto->no_cotizado == 0) {
                if($presupuesto->contrato->cantidad_pendiente > 0) {
                    $res = true;
                }
            }
        }

        return $res;
    }

    /**
     * @return mixed
     */
    public function getTotalesPresupiestos()
    {
        return DB::connection('cadeco')
            ->table('dbo.transacciones')
            ->select(
                DB::raw("sum(cast(( contratos.cantidad_original * presupuestos.precio_unitario ) * ((100-case when presupuestos.PorcentajeDescuento is null then 0 else presupuestos.PorcentajeDescuento end)/100)*((100- case when transacciones.PorcentajeDescuento is null then 0 else transacciones.PorcentajeDescuento end)/100) as float(2))) as monto"),
                DB::raw("sum(cast(( contratos.cantidad_original * presupuestos.precio_unitario ) * ((100-case when presupuestos.PorcentajeDescuento is null then 0 else presupuestos.PorcentajeDescuento end)/100)*((100- case when transacciones.PorcentajeDescuento is null then 0 else transacciones.PorcentajeDescuento end)/100) as float(2)))*.16 as impuesto")
            )
            ->join('presupuestos', 'transacciones.id_transaccion', '=', 'presupuestos.id_transaccion')
            ->join('contratos', 'contratos.id_concepto', '=', 'presupuestos.id_concepto')
            ->where('presupuestos.id_transaccion',$this->id_transaccion)
            ->where('tipo_transaccion', Tipo::COTIZACION_CONTRATO)
            ->where('opciones ',0)
            ->where('dbo.transacciones.id_obra',Context::getId())->get();
    }
}