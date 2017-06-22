<?php

namespace Ghi;

use Illuminate\Database\Eloquent\Model;

class Transacciones extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'transacciones';
    protected $primaryKey = 'id_transaccion';
    protected $fillable = [
        'id_antecedente',
        'id_referente',
        'tipo_transaccion',
        'numero_folio',
        'fecha',
        'estado',
        'impreso',
        'id_obra',
        'id_concepto',
        'id_costo',
        'id_almacen',
        'id_fondo',
        'id_cuenta',
        'id_empresa',
        'id_sucursal',
        'id_moneda',
        'cumplimiento',
        'vencimiento',
        'opciones',
        'monto',
        'saldo',
        'autorizado',
        'impuesto',
        'impuesto_retenido',
        'diferencia',
        'anticipo_monto',
        'anticipo_saldo',
        'anticipo',
        'anticipo_material',
        'anticipo_mano_obra',
        'retencion',
        'tipo_cambio',
        'referencia',
        'destino',
        'comentario',
        'observaciones',
        'TipoLiberacion',
        'FechaHoraLiberacion',
        'FechaHoraRegistro',
        'IVARetenido',
        'ISRRetenido',
        'OtrosImpuestos',
        'FondoGarantia',
        'IVAReal',
        'NumeroFolioAlt',
        'PorcentajeDescuento',
        'TcUSD',
        'TcEuro',
        'DiasCredito',
        'DiasVigencia',
        'descuento',
        'porcentaje_anticipo_pactado',
        'fecha_ejecucion',
        'fecha_contable',
        'anticipo_pactado_monto'
        ];
}
