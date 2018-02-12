<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 26/09/2017
 * Time: 12:09 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\CostosDolaresRepository;
use Illuminate\Support\Facades\DB;


class EloquentCostosDolaresRepository implements CostosDolaresRepository
{

    /**
     * Obtiene el reporte de Costos en Dolares
     * @return mixed
     */
    public function getBy($fechas)
    {
        $reporte = DB::connection('cadeco')->select(" SELECT int_polizas.fecha AS fecha_poliza,
int_polizas.id_int_poliza AS id_poliza,
transacciones.tipo_cambio,
int_polizas.poliza_contpaq as folio_contpaq,
int_polizas_movimientos.cuenta_contable,
conceptos.descripcion AS descripcion_concepto,
int_polizas_movimientos.importe,
CAST(
CASE 
WHEN transacciones.tipo_cambio = 0
THEN 0
ELSE int_polizas_movimientos.importe / transacciones.tipo_cambio

END as float) AS costo_dolares,
CAST(
CASE
WHEN transacciones.tipo_cambio = 0
THEN 0
ELSE 
int_polizas_movimientos.importe
- (int_polizas_movimientos.importe / transacciones.tipo_cambio)
END as float) AS costo_dolares_complementaria,
int_tipos_polizas_contpaq.descripcion AS tipo_poliza_contpaq,
int_transacciones_interfaz.descripcion AS tipo_poliza_sao

  FROM (((((( Contabilidad.int_polizas_movimientos int_polizas_movimientos
        INNER JOIN (SELECT cuentas_conceptos.cuenta FROM  Contabilidad.cuentas_conceptos cuentas_conceptos
              GROUP BY cuentas_conceptos.cuenta) Subquery ON (int_polizas_movimientos.cuenta_contable = Subquery.cuenta))
            INNER JOIN  dbo.transacciones transacciones 
              ON (int_polizas_movimientos.id_transaccion_sao = transacciones.id_transaccion))
            INNER JOIN  Contabilidad.int_polizas int_polizas
              ON (int_polizas_movimientos.id_int_poliza = int_polizas.id_int_poliza)
                 AND (int_polizas.id_transaccion_sao = transacciones.id_transaccion))
            INNER JOIN  Contabilidad.int_tipos_polizas_contpaq int_tipos_polizas_contpaq
              ON (int_polizas.id_tipo_poliza_contpaq = int_tipos_polizas_contpaq.id_int_tipo_poliza_contpaq))
            INNER JOIN  Contabilidad.int_transacciones_interfaz int_transacciones_interfaz
              ON (int_polizas.id_tipo_poliza_interfaz = int_transacciones_interfaz.id_transaccion_interfaz))
            INNER JOIN  Contabilidad.cuentas_conceptos cuentas_conceptos
              ON (cuentas_conceptos.cuenta = Subquery.cuenta))
            INNER JOIN  dbo.conceptos conceptos
              ON (cuentas_conceptos.id_concepto = conceptos.id_concepto)
 
            WHERE (int_polizas.estatus IN (2, 3))
              AND ((transacciones.id_moneda <> 1 AND abs (cuadre) <= 0.99)
                AND int_polizas_movimientos.id_tipo_cuenta_contable = 1) 
              AND int_polizas.fecha BETWEEN ".$fechas." ORDER BY folio_contpaq asc");

        return $reporte;
    }
}