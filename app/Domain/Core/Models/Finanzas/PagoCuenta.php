<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 01/06/2018
 * Time: 04:21 PM
 */

namespace Ghi\Domain\Core\Models\Finanzas;


use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Empresa;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\Scopes\PagoCuentaScope;
use Ghi\Domain\Core\Models\Transacciones\Tipo;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;

class PagoCuenta extends Transaccion
{
    protected $fillable = [
        "id_antecedente",
        "referencia",
        "cumplimiento",
        "fecha",
        "vencimiento",
        "id_concepto",
        "monto",
        "saldo",
        "id_moneda",
        "opciones",
        "destino",
        "observaciones",
        "id_empresa",
        "id_costo"
    ];

    //Tipos de transaccions que sirven como antedecende en una solicitud de pago
    public $tipos_transaccion = [
        ['Tipo_Transaccion' => 19, 'Opciones' => 1],
        ['Tipo_Transaccion' => 51, 'Opciones' => 2]
    ];


    /**
     * Aplicar Scope Global para recuperar solo las transacciones de tipo Pago a Cuenta
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PagoCuentaScope());
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {
            $model->tipo_transaccion = Tipo::PAGO_A_CUENTA;
            $model->opciones = 327681;
            $model->id_moneda = 1;
            $model->FechaHoraRegistro = Carbon::now()->toDateTimeString();
            $model->id_obra = Context::getId();
            $model->comentario = "I;" . date('d/m/Y') . " " . date('h:m:s') . ";SAO|" . auth()->user()->usuario . "|";
            $model->saldo = $model->monto;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, "id_empresa", "id_empresa");
    }
}