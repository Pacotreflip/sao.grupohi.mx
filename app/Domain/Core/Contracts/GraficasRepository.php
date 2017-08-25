<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 27/07/2017
 * Time: 02:09 PM
 */

namespace Ghi\Domain\Core\Contracts;


interface GraficasRepository
{
    /**
     * recupera un array con los últimos 7 diasa partir de la fecha
     * actual
     * @return mixed
     *
     */
    public function getDates();

    /**
     * Obtiene los datos para las estadisticas iniciales
     * @return mixed
     *
     */
    public function getChartInfo();

    /**
     * Retorna el conteo de cada tipo de poliza por fecha ingresada
     * @return mixed
     */
    public function getCountDate($date, $tipo);

    /**
     * Retorna el acumilado de Polizas Tipo de acuerdo al total por estatus
     * @return mixed
     */
    public function getChartAcumuladoInfo();

    /**
     * Regresa los datos para el Chart informativo de Cuentas Contables
     * @return mixed
     */
    public function getChartCuentaContableInfo();
    /**
     * Retorna el acumilado de Polizas Tipo de acuerdo al total por estatus
     * @return mixed
     */
    public function getChartAcumuladoModal();


}