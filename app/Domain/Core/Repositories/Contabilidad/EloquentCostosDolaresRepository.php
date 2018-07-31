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
    public function getBy($fechas, $provision = false)
    {
        $prov = $provision?' AND int_transacciones_interfaz.id_transaccion_interfaz != 19 ':'';
        $reporte = DB::connection('cadeco')->select("SELECT  distinct
conceptos.id_concepto
, int_polizas.fecha AS fecha_poliza
, int_polizas.id_int_poliza AS id_poliza
, transacciones.tipo_cambio
, monedas.nombre as moneda
, cambios_autorizados.cambio
, int_polizas.poliza_contpaq as folio_contpaq
, int_polizas_movimientos.cuenta_contable
, [SubcontratosEstimaciones].[udfRutaDestinoConcepto] (conceptos.id_concepto) AS descripcion_concepto
, int_polizas_movimientos.importe as importe
, (CAST(
  CASE 
      WHEN transacciones.tipo_cambio = 0
      THEN 0
      ELSE int_polizas_movimientos.importe / transacciones.tipo_cambio
  END as float) * cambios_autorizados.cambio) - ( int_polizas_movimientos.importe) 
  AS efecto_cambiario
, CAST(
CASE 
    WHEN transacciones.tipo_cambio = 0
    THEN 0
    ELSE int_polizas_movimientos.importe / transacciones.tipo_cambio
END as float) AS costo_me
, CAST(
CASE
    WHEN transacciones.tipo_cambio = 0
    THEN 0
    ELSE int_polizas_movimientos.importe - (int_polizas_movimientos.importe / transacciones.tipo_cambio)
END as float) AS costo_me_complementaria
, int_tipos_polizas_contpaq.descripcion AS tipo_poliza_contpaq
, int_transacciones_interfaz.descripcion AS tipo_poliza_sao

  FROM 
  (
    (
      (
        (
          ( 
            Contabilidad.int_polizas int_polizas
              INNER JOIN  dbo.transacciones transacciones 
              ON (int_polizas.id_transaccion_sao = transacciones.id_transaccion)
          )
            INNER JOIN  Contabilidad.int_polizas_movimientos int_polizas_movimientos
              ON (int_polizas_movimientos.id_int_poliza = int_polizas.id_int_poliza)
                 AND (int_polizas.id_transaccion_sao = transacciones.id_transaccion)
        )
            INNER JOIN  Contabilidad.int_tipos_polizas_contpaq int_tipos_polizas_contpaq
              ON (int_polizas.id_tipo_poliza_contpaq = int_tipos_polizas_contpaq.id_int_tipo_poliza_contpaq)
      )
            INNER JOIN  Contabilidad.int_transacciones_interfaz int_transacciones_interfaz
              ON (int_polizas.id_tipo_poliza_interfaz = int_transacciones_interfaz.id_transaccion_interfaz)
    )
  )
              -------------
              LEFT JOIN (
                SELECT conceptos.id_concepto, cuentas.cuenta, conceptos.descripcion, Contabilidad.int_polizas.id_int_poliza as id_int_poliza 
                from conceptos as conceptos join items on(items.id_concepto= conceptos.id_concepto)
                inner join transacciones as t on(t.id_transaccion = items.id_transaccion)
                inner join Contabilidad.int_polizas ON Contabilidad.int_polizas.id_transaccion_sao = t.id_transaccion
                inner join (
                    select cuenta, cuentas_conceptos.id_concepto 
                    from Contabilidad.cuentas_conceptos
                ) as cuentas on(cuentas.id_concepto = conceptos.id_concepto)
                
                group by conceptos.id_concepto,Contabilidad.int_polizas.id_int_poliza,conceptos.descripcion, cuentas.cuenta
              ) as conceptos
              on(conceptos.id_int_poliza = int_polizas.id_int_poliza and conceptos.cuenta = int_polizas_movimientos.cuenta_contable )
              
            
              INNER JOIN  Contabilidad.cuentas_conceptos cuentas_conceptos
              ON (cuentas_conceptos.id_concepto = conceptos.id_concepto)
             
              
              INNER JOIN dbo.monedas ON transacciones.id_moneda = monedas.id_moneda

			  INNER JOIN  ControlPresupuesto.cambios_autorizados on monedas.id_moneda = cambios_autorizados.id_moneda
     
 
            WHERE (int_polizas.estatus IN (2, 3))
              AND ((transacciones.id_moneda <> 1 )
                AND int_polizas_movimientos.id_tipo_cuenta_contable = 1
					AND int_polizas_movimientos.cuenta_contable like '5%'
                AND int_polizas_movimientos.deleted_at is null
                ".$prov."
                ) 
          
          union
          SELECT  distinct
conceptos.id_concepto
, int_polizas.fecha AS fecha_poliza
, int_polizas.id_int_poliza AS id_poliza
, transacciones.tipo_cambio
, monedas.nombre as moneda
, cambios_autorizados.cambio
, int_polizas.poliza_contpaq as folio_contpaq
, int_polizas_movimientos.cuenta_contable
, [SubcontratosEstimaciones].[udfRutaDestinoConcepto] (conceptos.id_concepto) AS descripcion_concepto
, int_polizas_movimientos.importe as importe_movimiento_poliza
, (CAST(
  CASE 
      WHEN transacciones.tipo_cambio = 0
      THEN 0
      ELSE int_polizas_movimientos.importe / transacciones.tipo_cambio
  END as float) * cambios_autorizados.cambio) - ( int_polizas_movimientos.importe) 
  AS efecto_cambiario

, CAST(
CASE 
    WHEN transacciones.tipo_cambio = 0
    THEN 0
    ELSE int_polizas_movimientos.importe / transacciones.tipo_cambio
END as float) AS costo_me
, CAST(
CASE
    WHEN transacciones.tipo_cambio = 0
    THEN 0
    ELSE int_polizas_movimientos.importe - (int_polizas_movimientos.importe / transacciones.tipo_cambio)
END as float) AS costo_me_complementaria
, int_tipos_polizas_contpaq.descripcion AS tipo_poliza_contpaq
, int_transacciones_interfaz.descripcion AS tipo_poliza_sao

  FROM 
  (
    (
      (
        (
          ( 
            Contabilidad.int_polizas int_polizas
              INNER JOIN  dbo.transacciones transacciones 
              ON (int_polizas.id_transaccion_sao = transacciones.id_transaccion)
              INNER JOIN  dbo.items AS items_factura
              ON (items_factura.id_transaccion = transacciones.id_transaccion)
          )
            INNER JOIN  Contabilidad.int_polizas_movimientos int_polizas_movimientos
              ON (int_polizas_movimientos.id_int_poliza = int_polizas.id_int_poliza)
                 AND (int_polizas.id_transaccion_sao = transacciones.id_transaccion)
        )
            INNER JOIN  Contabilidad.int_tipos_polizas_contpaq int_tipos_polizas_contpaq
              ON (int_polizas.id_tipo_poliza_contpaq = int_tipos_polizas_contpaq.id_int_tipo_poliza_contpaq)
      )
            INNER JOIN  Contabilidad.int_transacciones_interfaz int_transacciones_interfaz
              ON (int_polizas.id_tipo_poliza_interfaz = int_transacciones_interfaz.id_transaccion_interfaz)
    )
  )
              LEFT JOIN (
                  SELECT conceptos.id_concepto, cuentas.cuenta, conceptos.descripcion, Contabilidad.int_polizas.id_int_poliza as id_int_poliza 
                  from  transacciones as t  join items  on(t.id_transaccion = items.id_transaccion)
                  inner join Contabilidad.int_polizas ON Contabilidad.int_polizas.id_transaccion_sao = t.id_transaccion
                 inner join transacciones as ta on(ta.id_transaccion = items.id_antecedente)
                 inner join items as ia on(ia.id_transaccion = ta.id_transaccion)
                 inner join conceptos as conceptos on(conceptos.id_concepto = ia.id_concepto)
                  left join (
                      select cuenta, cuentas_conceptos.id_concepto 
                      from Contabilidad.cuentas_conceptos
                  ) as cuentas on(cuentas.id_concepto = conceptos.id_concepto)
                  WHERE t.tipo_transaccion = 65
                  and ta.id_moneda !=1
                  
                  group by conceptos.id_concepto,Contabilidad.int_polizas.id_int_poliza
                  ,conceptos.descripcion, cuentas.cuenta
              ) as conceptos
              on(conceptos.id_int_poliza = int_polizas.id_int_poliza and conceptos.cuenta = int_polizas_movimientos.cuenta_contable )
              
            
              INNER JOIN  Contabilidad.cuentas_conceptos cuentas_conceptos
              ON (cuentas_conceptos.id_concepto = conceptos.id_concepto)
             
              
              INNER JOIN dbo.monedas ON transacciones.id_moneda = monedas.id_moneda

			  INNER JOIN  ControlPresupuesto.cambios_autorizados on monedas.id_moneda = cambios_autorizados.id_moneda
     
 
            WHERE (int_polizas.estatus IN (2, 3))
              AND ((transacciones.id_moneda <> 1 
              AND transacciones.tipo_transaccion = 65)
                AND int_polizas_movimientos.id_tipo_cuenta_contable = 1
				AND int_polizas_movimientos.cuenta_contable like '5%'
                AND int_polizas_movimientos.deleted_at is null
                ".$prov."
                )
             AND int_polizas.fecha BETWEEN ".$fechas." ORDER BY folio_contpaq asc");

        return $reporte;
    }
}