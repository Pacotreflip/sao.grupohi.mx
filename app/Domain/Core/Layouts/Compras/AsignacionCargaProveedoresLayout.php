<?php

namespace Ghi\Domain\Core\Layouts\Compras;

use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Layouts\ValidacionLayout;
use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCCotizacionesPartidas;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCSolicitudPartidas;
use Ghi\Utils\TipoCambio;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use MCrypt\MCrypt;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Models\Cambio;

/**
 * Class AsignacionCargaProveedoresLayout
 * @package Ghi\Domain\Core\Layouts\Compras
 */
class AsignacionCargaProveedoresLayout extends ValidacionLayout
{
    /**
     * @var ContratoProyectado
     */
    protected $info;
    /**
     * @var array
     */
    protected $resultData = [];

    /**
     * @var int
     */
    protected $columnsExt = 0;

    /**
     * @var int
     */
    protected $partidaAsignacion = 0;
    /**
     * @var int
     */
    protected $operaciones = 15;
    /**
     * @var string
     */
    protected $delimiter = '|';
    /**
     * @var array
     */
    protected $headerFijos = [
        "#" => "#",
        "Id" => "Id",
        "descripcion_span" => "descripcion_span",
        "unidad" => "unidad",
        "cantidad solicitada" => "cantidad solicitada",
        "cantidad_aprobada" => "cantidad_aprobada",
    ];

    /**
     * @var array
     */
    protected $headerDinamicos = [
        "Precio Unitario" => "Precio Unitario",
        "% Descuento" => "% Descuento",
        "Precio Total" => "Precio Total",
        "Moneda" => "Moneda",
        "Precio Total Moneda Conversión" => "Precio Total Moneda Conversión",
        "Observaciones" => "Observaciones",
        "material_sao" => "material_sao",
        "idrqctoc_solicitudes_partidas" => "idrqctoc_solicitudes_partidas",
        "idrqctoc_solicitudes" => "idrqctoc_solicitudes",
        "idmoneda" => "idmoneda",
        "separador" => "",
    ];
    /**
     * @var array
     */
    protected $rowOperacionesExtra = [
        "descuento" => "% Descuento",
        "subtotal_precio_pesos" => "Subtotal Precios PESO MXP",
        "subtotal_precio_dolar" => "Subtotal Precios DOLAR USD",
        "subtotal_precio_euro" => "Subtotal Precios EURO",
        "tc_usd" => "TC USD",
        "tc_euro" => "TC EURO",
        "moneda_de_conv" => "Moneda de Conv",
        "subtotal_moneda_conv" => "Subtotal Moneda Conv",
        "iva" => "IVA",
        "total" => "Total",
        "fecha_de_presupuesto" => "Fecha de Presupuesto",
        "pago_en_parcialidades" => "Pago en Parcialdades (%)",
        "anticipio" => "% Anticipo",
        "credito_dias" => "Crédito días",
        "tiempo_de_entrega" => "Tiempo de Entrega (días)",
        "vigencia_dias" => "Vigencia días",
        "observaciones" => "Observaciones Generales",
    ];
    /**
     * @var
     */
    private $tipo_cambio;
    /**
     * @var RequisicionRepository
     */
    private $requisicion;
    /**
     * @var int
     */
    protected $id_requisicion;

    /**
     * AsignacionSubcontratistasLayout constructor.
     *
     * @param RequisicionRepository $requisicionRepository
     * @param $info
     *
     * @internal param ContratoProyectado $contrato_proyectado
     */
    public function __construct(RequisicionRepository $requisicionRepository, $info)
    {
        $this->mCrypt = new MCrypt();
        $this->mCrypt->setKey($this->Key);
        $this->mCrypt->setIv($this->Iv);
        $this->lengthHeaderFijos = count($this->headerFijos);
        $this->lengthHeaderDinamicos = count($this->headerDinamicos);
        $this->operaciones = count($this->rowOperacionesExtra);
        $this->requisicion = $requisicionRepository;
        $this->info = $info;
        $this->cabecerasLength = 2;

        // Tipo cambio hoy
        $tipo_cambio = Cambio::where('fecha', '=', date('Y-m-d'))->get()->toArray();

        foreach ($tipo_cambio as $k => $v) {
            $this->tipo_cambio[$v['id_moneda']] = $v;
        }
        $this->requisicion = $requisicionRepository;
    }

    /**
     * @return mixed
     */
    public function setData()
    {
        $row = 0;
        $maxRow = 0;
        $presupuestos = $this->requisicion->getCotizaciones($this->info['id_requisicion'], $this->info['cot_ids']);

        // Agrupados/No agrupados
        $partidas = !empty($this->info['agrupadores']) ? $this->requisicion->getPartidasCotizacionAgrupadas($this->info['id_requisicion']) : $this->requisicion->getPartidasCotizacion($this->info['id_requisicion']);

        $arrayResult['totales'] = $presupuestos->count();
        $arrayResult['valores'] = [];
        if ($arrayResult['totales'] > 0) {
            $index = 0;
            foreach ($partidas as $key => $solicitud_partida) {

                if (!isset($arrayResult['valores'][$solicitud_partida->iditem_sao])) {
                    $arrayResult['valores'][$solicitud_partida->iditem_sao] = [];
                    $arrayResult['valores'][$solicitud_partida->iditem_sao]['partida'] = $solicitud_partida;
                    $row++;
                    $maxRow = ($maxRow < $row) ? $row : $maxRow;
                }

                $totalesPartidas = $presupuestos->count();
                if ($totalesPartidas > 0) {
                    if ($totalesPartidas == 0) {
                        $arrayResult['totales'] = $arrayResult['totales'] - 1;
                    } else {
                        foreach ($presupuestos as $_index => $presupuesto) {

                            //if ($presupuesto->no_cotizado == 0) {
                            $arrayResult['valores'][$solicitud_partida->iditem_sao]['presupuesto'][$_index] = $presupuesto;
                            /*} else {
                                $arrayResult['valores'][$partida->id_concepto]['presupuesto'][$index] = [];
                                $arrayResult['valores'][$partida->id_concepto]['partida'][$index] = [];
                                $totalesPartidas--;
                            }*/

                            $maxRow = ($maxRow < $totalesPartidas) ? $totalesPartidas : $maxRow;

                        }
                    }
                } else {
                    $arrayResult['totales'] = $arrayResult['totales'] - 1;
                }
            }
        }
        $arrayResult['maxRow'] = $maxRow;

        return $arrayResult;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $req = $this->requisicion->getRequisicion($this->info['id_transaccion_sao']);

        Config::set(['excel.export.calculate' => true]);
        return Excel::create('Asignación Carga Proveedores Layout', function ($excel) use ($req) {
            $excel->sheet('# ' . str_pad($req->folio_sao, 5, '0', STR_PAD_LEFT),
                function (LaravelExcelWorksheet $sheet) use ($req) {
                    $arrayRequisicion = $this->setData();

                    $sheet->getProtection()->setSheet(true);
                    $sheet->loadView('excel_layouts.asignacion_proveedores',
                        [
                            'requisicion' => $arrayRequisicion,
                            'headerRequisiciones' => $this->headerFijos,
                            'headerCotizaciones' => $this->headerDinamicos,
                            'mcrypt' => $this->mCrypt,
                            'info' => $this->info,
                        ]);
                    $sheet->setAutoSize(false);

                    $index = 1;
                    $haciaAbajo = 3;
                    $reqPresupuestos = [];
                    foreach ($arrayRequisicion['valores'] as $key => $requisicion) {
                        $reqPresupuestos = $requisicion['presupuesto'];

                        foreach ($requisicion['presupuesto'] as $key => $cotizacion) {
                            $desde = (count($this->headerDinamicos) * $key) + (count($this->headerFijos));

                            // Precio Unitario
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

                            // % Descuento
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

                            // Precio Total
                            $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 2) . $haciaAbajo,
                                '=' . \PHPExcel_Cell::stringFromColumnIndex($desde) . $haciaAbajo . '*' . 'E' . $haciaAbajo . '-((' . \PHPExcel_Cell::stringFromColumnIndex($desde) . $haciaAbajo . '*E' . $haciaAbajo . '*' . \PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $haciaAbajo . ')/100)');

                            // Moneda
                            $objValidation = $sheet->getCell(\PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo)->getDataValidation();
                            $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                            $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                            $objValidation->setAllowBlank(false);
                            $objValidation->setShowInputMessage(true);
                            $objValidation->setShowErrorMessage(true);
                            $objValidation->setShowDropDown(true);
                            $objValidation->setErrorTitle('error');
                            $objValidation->setError('Valor no está en la lista');
                            $objValidation->setPromptTitle('Tipo de Moneda');
                            $objValidation->setPrompt('Selecciona un valor de la lista');
                            $objValidation->setFormula1('"EURO, DOLAR USD, PESO MXP"');

                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);


                            // Precio Total Moneda Conversión
                            $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 4) . $haciaAbajo,
                                '=IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo . '="EURO",' . \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo . '*' . $this->tipo_cambio[3]['cambio'] . '/1, IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo . '="DOLAR USD",' . \PHPExcel_Cell::stringFromColumnIndex($desde + 2) . $haciaAbajo . '*' . $this->tipo_cambio[2]['cambio'] . '/1, IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo . '="PESO MXP",' . \PHPExcel_Cell::stringFromColumnIndex($desde + 2) . $haciaAbajo . '/1, IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo . '="",0))))');
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 4) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);

                            // Observaciones
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

                            // idrqctoc_solicitudes_partidas
                            $solicitudPartidas = [];
                            foreach ($cotizacion->rqctocSolicitud->rqctocSolicitudPartidas as $sp) {
                                $solicitudPartidas[] = $sp->idrqctoc_solicitudes_partidas;
                            }

                            $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 7) . $haciaAbajo,
                                $this->mCrypt->encrypt(implode(',', array_unique($solicitudPartidas))));
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 7) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);

                            // id moneda
                            $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 9) . $haciaAbajo,
                                '=IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo . '="EURO",2, IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo . '="DOLAR (USD)",1, IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo . '="PESO (MXP)",3,0)))');
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 9) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);

                        }
                        $index++;
                        $haciaAbajo++;
                    }

                    // Referencia última fila
                    $haciaAbajo = $haciaAbajo - 1;
                    $ultimaFila = $haciaAbajo;

                    // % Descuento
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        $desde = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos))) - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, '% Descuento');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos, '0');
                    }

                    // Subtotal Precios PESO MXP
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;

                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Subtotal Precios PESO MXP');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            '=SUMIF(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . $ultimaFila . ',"PESO MXP",' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . $ultimaFila . ')-(SUMIF(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . $ultimaFila . ',"PESO MXP",' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . $ultimaFila . ')*' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot) . ($ultimaFila) . '/100)');
                    }

                    // Subtotal Precios DOLAR USD
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;

                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Subtotal Precios DOLAR USD');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            '=SUMIF(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . $pos . ',"DOLAR USD",' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . $pos . ')-(SUMIF(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . $pos . ',"DOLAR USD",' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . $pos . ')*' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot) . ($haciaAbajo + 1) . '/100)');
                    }

                    // Subtotal Precios EURO
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;

                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Subtotal Precios EURO');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            '=SUMIF(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . $ultimaFila . ',"EURO",' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . $ultimaFila . ')-(SUMIF(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . $ultimaFila . ',"EURO",' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . $ultimaFila . ')*' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot) . ($ultimaFila + 1) . '/100)');
                    }

                    // TC USD
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'TC USD');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            $this->tipo_cambio[2]['cambio']);
                    }

                    // TC EURO
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'TC EURO');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            $this->tipo_cambio[3]['cambio']);
                    }

                    // Moneda de Conv.
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;

                        $objValidation = $sheet->getCell(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getDataValidation();
                        $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                        $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                        $objValidation->setAllowBlank(false);
                        $objValidation->setShowInputMessage(true);
                        $objValidation->setShowErrorMessage(true);
                        $objValidation->setShowDropDown(true);
                        $objValidation->setFormula1('"PESO MX"');
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Moneda de Conv');
                    }

                    // Subtotal Moneda Conv.
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Subtotal Moneda Conv');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            '=SUM(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . $ultimaFila . ')-(SUM(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . $ultimaFila . ')*' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot) . ($ultimaFila + 1) . '/100)');
                    }

                    // IVA
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;

                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'IVA');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            '=' . \PHPExcel_Cell::stringFromColumnIndex($desde + 1) . ($pos - 1) . '*' . '.16');
                    }

                    // Total
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;

                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Total');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            '=' . \PHPExcel_Cell::stringFromColumnIndex($desde + 1) . ($pos - 2) . '+' . \PHPExcel_Cell::stringFromColumnIndex($desde + 1) . ($pos - 1));
                    }

                    // Fecha de Cotización
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Fecha de Presupuesto');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos, date("d-m-Y"));
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);
                    }

                    // Pago en Parcialdades (%)
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Pago en Parcialdades (%)');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            $cotizacion->anticipo_pactado);
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    }

                    // % Anticipo
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, '% Anticipo');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            $cotizacion->anticipo);
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    }

                    // Crédito días
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Crédito días');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            $cotizacion->días_credito);
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    }

                    // Plazo entrega
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Tiempo de Entrega (días)');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            $cotizacion->plazo_entrega);
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    }

                    // Vigencia días
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Vigencia días');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            $cotizacion->vigencia);
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    }

                    // Observaciones Generales
                    $pos = ++$haciaAbajo;
                    foreach ($reqPresupuestos as $key => $cotizacion) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Observaciones Generales');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos, '');
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    }


                })->getActiveSheetIndex(0);
        })
            ->store('xlsx', storage_path() . '/logs/');
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function qetDataFile(Request $request)
    {
        $requisicion = $this->requisicion->find($this->id_requisicion);
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $results = false;
        Excel::load($request->file('file')->getRealPath(), function ($reader) use (&$results, $requisicion) {
            try {
                $results = $reader->all();
                $sheet = $reader->sheet($results->getTitle(), function (LaravelExcelWorksheet $sheet) {
                    $sheet->getProtection()->setSheet(false);
                });
                //->Validar que el Layout corresponda a la transacción
                if ('# ' . str_pad($requisicion->numero_folio, 5, '0', STR_PAD_LEFT) != $results->getTitle()) {
                    throw new \Exception("No corresponde el layout al Contrato con el folio [" . $results->getTitle() . "]");
                }
                $col = $sheet->toArray();
                $_headers = $results->getHeading();
                $identificadores = !empty($_headers[0]) ? $this->mCrypt->decrypt($_headers[0]) : [];
                $idTransaciones = explode($this->delimiter, $identificadores);
                $idTransacion = explode(',', current($idTransaciones));
                $headers = $col[($this->cabecerasLength - 1)];
                $cot_ids = $idTransaciones[1];
                $agrupadores = $idTransaciones[2];
                $solo_pendientes = $idTransaciones[3];
                $req = $this->requisicion->getRequisicion($this->id_requisicion);
                $this->info = [
                    'id_requisicion' => $req->idrqctoc_solicitudes,
                    'id_transaccion_sao' => $this->id_requisicion,
                    'cot_ids' => $idTransacion,
                    'agrupadores' => !empty($agrupadores) ? explode(',', $agrupadores) : [],
                    'solo_pendientes' => $solo_pendientes,
                ];
                $layout = $this->setData();
                if ($this->validarHeader($headers, $layout)) {
                    if (count($col) != ($layout['maxRow'] + $this->cabecerasLength + $this->operaciones)) {
                        throw new \Exception("No es posible procesar el Layout debido a que presenta diferencias con la información actual");
                    }
                    $arrayCotiazaciones = [];
                    for ($i = $this->cabecerasLength; $i < count($col); $i++) {
                        $row = $col[$i];
                        $maxCol = count($row);
                        $j = $this->lengthHeaderFijos + ($this->lengthHeaderDinamicos - 1);
                        $k = $this->lengthHeaderFijos;
                        $l = 0;
                        while ($j <= $maxCol) {
                            $cotizaciones = !empty($row[1]) ? $this->mCrypt->decrypt($row[1]) : '';
                            $id_cotizacion = explode($this->delimiter, $cotizaciones);
                            $id_transaccion = !empty($idTransacion[$l]) ? $idTransacion[$l] : '';

                            if ($i < ($layout['maxRow'] + $this->cabecerasLength)) {
                                if (is_numeric($id_transaccion) and !empty($id_transaccion) && is_array($id_cotizacion) and count($id_cotizacion)) {
                                    if(is_numeric($row[$k + ($this->lengthHeaderDinamicos - 11)])) {
                                        $arrayCotiazaciones[$id_transaccion]['partidas'][] = [
                                            'linea' => $i,
                                            'unidad' => $row[3],//de contratos
                                            'cantidad solicitada' => $row[4],//de contratos
                                            'cantidad_aprobada' => $row[5],//de contratos
                                            'id_cotizacion' => $id_cotizacion,//de contratos
                                            'precio_unitario' => str_replace(",", "",
                                                $row[$k + ($this->lengthHeaderDinamicos - 11)]),
                                            "PorcentajeDescuento" => $row[$k + ($this->lengthHeaderDinamicos - 10)],
                                            'precio_total' => str_replace(",", "",
                                                $row[$k + ($this->lengthHeaderDinamicos - 9)]),
                                            "Observaciones" => $row[$k + ($this->lengthHeaderDinamicos - 7)],
                                            "precio_total_moneda_convertido" => $row[$k + ($this->lengthHeaderDinamicos - 6)],
                                            'material_sao' => str_replace(",", "",
                                                $row[$k + ($this->lengthHeaderDinamicos - 5)]),
                                            'idrqctoc_solicitudes_partidas' => $this->mCrypt->decrypt($row[$k + ($this->lengthHeaderDinamicos - 4)]),
                                            'idrqctoc_solicitudes' => $row[$k + ($this->lengthHeaderDinamicos - 3)],
                                            "IdMoneda" => $row[$k + ($this->lengthHeaderDinamicos - 2)],
                                            "estado" => 1,
                                        ];
                                    }
                                }
                            } else {
                                $aux = $col[$this->cabecerasLength + 1];
                                $detalle = !empty($row[$this->lengthHeaderFijos - 1]) ? $row[$this->lengthHeaderFijos - 1] : '';
                                $valorDetalle = !empty($row[$k]) ? $row[$k] : '';
                                $keyDetalle = array_search($detalle, $this->rowOperacionesExtra);
                                $arrayCotiazaciones[$id_transaccion]['cotizacion'][$keyDetalle] = $valorDetalle;
                            }
                            $k += $this->lengthHeaderDinamicos;
                            $j += $this->lengthHeaderDinamicos;
                            $l++;
                        }
                    }
                    if (count($arrayCotiazaciones) > 0) {
                        $results = $this->procesarDatos($arrayCotiazaciones);
                    } else {
                        throw new \Exception("Ingrese por lo menos una cantidad asignada");
                    }
                }
            } catch (\Exception $e) {
                if (count($this->resultData) > 0) {
                    throw new StoreResourceFailedException($e->getMessage(), $this->resultData);
                } else {
                    throw new StoreResourceFailedException($e->getMessage());
                }
            }
        });
        return $results;
    }

    /**
     * @param array $cotizaciones
     *
     * @return array
     * @throws \Exception
     */
    public function procesarDatos(array $cotizaciones)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            DB::connection('controlrec')->beginTransaction();
            $error = 0;
            $success = 0;
            $sumatorias = [];
            $mensajeError = '';
            $requisicion = $this->requisicion->find($this->id_requisicion);
            foreach ($cotizaciones as $key => $gralCotizacion) {
                $cotizacionCompra = $requisicion->cotizacionesCompra()->find($key);
                if (count($cotizacionCompra)) {
                    $anticipo = $gralCotizacion["cotizacion"]["anticipio"];
                    $idmoneda = ($gralCotizacion["cotizacion"]["moneda_de_conv"] == 'PESO MX') ? 3 : 3;
                    $vigencia = $gralCotizacion["cotizacion"]["vigencia_dias"];
                    $ex = explode("-", $gralCotizacion["cotizacion"]["fecha_de_presupuesto"]);
                    $fecha_cotizacion = $ex[2] . "-" . $ex[1] . "-" . $ex[0];
                    if ($anticipo > 100) {
                        $mensajeError = "El porcentaje de anticipo no puede ser mayor a 100";
                        $error++;
                    }
                    $rqctocCotizacion = $cotizacionCompra->rqctocCotizacion()->get();
                    $idrqctocCotizaciones=$rqctocCotizacion[0]->idrqctoc_cotizaciones;
                    $con_asignacion = $this->requisicion->getNumAsignaciones($idrqctocCotizaciones);
                    if ($con_asignacion) {
                        $mensajeError = "La cotización no puede ser modificada debido a que se encuentra relacionada en al menos una asignación de compra";
                        $error++;
                    }
                    if ($error > 0) {
                        $this->resultData = $cotizaciones;
                        throw new \Exception($mensajeError);
                    }
                    $anticipo_pactado = $gralCotizacion["cotizacion"]["pago_en_parcialidades"];
                    $subtotal = str_replace(",", "", $gralCotizacion["cotizacion"]["subtotal_moneda_conv"]);
                    $impuesto = str_replace(",", "", $gralCotizacion["cotizacion"]["iva"]);
                    $monto = str_replace(",", "", $gralCotizacion["cotizacion"]["total"]);
                    $dias_credito = $gralCotizacion["cotizacion"]["credito_dias"];
                    $plazo_entrega = $gralCotizacion["cotizacion"]["tiempo_de_entrega"];
                    $segundos_sumar = $vigencia * 86400;
                    $month = $ex[1];
                    $day = $ex[2];
                    $year = $ex[0];
                    $segundos_iniciales = mktime(0, 0, 0, $month, $day, $year);
                    $segundos_totales = $segundos_sumar + $segundos_iniciales;
                    $cumplimiento = $fecha_cotizacion;
                    $vencimiento = date("Y-m-d", $segundos_totales);

                    if ($idmoneda == 1) {
                        $id_moneda = 2;
                    } elseif ($idmoneda == 2) {
                        $id_moneda = 3;
                    } elseif ($idmoneda == 3) {
                        $id_moneda = 1;
                    }
                    $datos_transaccion = [
                        "cumplimiento" => $cumplimiento,
                        "vencimiento" => $vencimiento,
                        "monto" => $monto,
                        "impuesto" => $impuesto,
                        "observaciones" => $gralCotizacion["cotizacion"]["observaciones"],
                        "id_moneda" => $id_moneda,
                        "porcentaje_anticipo_pactado" => ($anticipo_pactado == "") ? 0 : $anticipo_pactado,
                        "estado" => 1,
                    ];
                    if (!$cotizacionCompra->update($datos_transaccion)) {
                        $mensajeError = "No se puede procesar la cotización";
                        $this->resultData = $cotizaciones;
                        throw new \Exception($mensajeError);
                    }
                    $descuento = $gralCotizacion["cotizacion"]["descuento"];
                    $datos_cotizacion = [];
                    $datos_cotizacion["idmoneda"] = $idmoneda;
                    $datos_cotizacion["fecha_cotizacion"] = $fecha_cotizacion;
                    $datos_cotizacion["anticipo"] = ($anticipo == "") ? 0 : $anticipo;
                    $datos_cotizacion["anticipo_pactado"] = ($anticipo_pactado == "") ? 0 : $anticipo_pactado;
                    $datos_cotizacion["dias_credito"] = ($dias_credito == "") ? 0 : $dias_credito;
                    $datos_cotizacion["plazo_entrega"] = ($plazo_entrega == "") ? 0 : $plazo_entrega;
                    $datos_cotizacion["observaciones"] = $gralCotizacion["cotizacion"]["observaciones"];
                    $datos_cotizacion["vigencia"] = ($vigencia == "") ? 0 : $vigencia;
                    $datos_cotizacion["tc_usd"] = $gralCotizacion["cotizacion"]["tc_usd"];
                    $datos_cotizacion["tc_eur"] = $gralCotizacion["cotizacion"]["tc_euro"];
                    $datos_cotizacion["importe"] = $subtotal;
                    $datos_cotizacion["iva"] = $impuesto;
                    $datos_cotizacion["total"] = $monto;
                    $datos_cotizacion["descuento"] = ($descuento == "") ? 0 : $descuento;

                    if (!$cotizacionCompra->rqctocCotizacion->update($datos_cotizacion)) {
                        $mensajeError = "No se puede procesar la cotización";
                        $this->resultData = $cotizaciones;
                        throw new \Exception($mensajeError);
                    }

                    foreach ($gralCotizacion["partidas"] as $partidas) {
                        $idMaterial = $partidas['material_sao'];
                        $idrqctocSolicitudesPartidas = $partidas['idrqctoc_solicitudes_partidas'];
                        $descuento_partida = $partidas['PorcentajeDescuento'];
                        $descuento_compuesto = $descuento_partida + $descuento - ($descuento_partida * $descuento / 100);
                        if ($partidas['IdMoneda'] == 1) {
                            $id_moneda_partida = 2;
                        } elseif ($partidas['IdMoneda'] == 2) {
                            $id_moneda_partida = 3;
                        } elseif ($partidas['IdMoneda'] == 3) {
                            $id_moneda_partida = 1;
                        }
                        foreach ($partidas["id_cotizacion"] as $idCotizacion) {
                            $rqctocSolicitudPartida = $cotizacionCompra->rqctocCotizacion->rqctocSolicitudesPartidas()
                                ->where(['idrqctoc_solicitudes_partidas'=>$idCotizacion,'idmaterial_sao'=>$idMaterial])->first();
                            $rqctocCotizacionPartidas = false;
                            if($rqctocSolicitudPartida) {
                                if(isset($rqctocSolicitudPartida->rqctocCotizacionPartida)) {
                                    $rqctocCotizacionPartidas = $rqctocSolicitudPartida->rqctocCotizacionPartida;
                                }
                            }
                            $cotizacion = $cotizacionCompra->cotizaciones()->where(['id_transaccion'=>$key,'id_material'=>$idMaterial])->first();
                            if ($cotizacion) {
                                $datos_sao = [
                                    "disponibles" => 1,
                                    "precio_unitario" => str_replace(",", "",
                                        $partidas["precio_unitario"]),
                                    /*"precio_unitario_mxp" => TipoCambio::cambio(str_replace(",", "",
                                        $partidas["precio_unitario"]), $partidas['IdMoneda']),*/
                                    "descuento" => ($descuento_compuesto == "") ? 0 : $descuento_compuesto,
                                    "anticipo" => ($anticipo == "") ? 0 : $anticipo,
                                    "dias_entrega" => ($plazo_entrega == "") ? 0 : $plazo_entrega,
                                    "id_moneda" => $id_moneda_partida,
                                    "dias_credito" => ($dias_credito == "") ? 0 : $dias_credito,
                                    "no_cotizado" => 0,
                                ];

                                $datos_partida_edicion = [
                                    "idmoneda" => $id_moneda_partida,
                                    "precio_unitario" => str_replace(",", "",
                                        $partidas["precio_unitario"]),
                                    "precio_unitario_mxp" => TipoCambio::cambio(str_replace(",", "",
                                        $partidas["precio_unitario"]), $partidas['IdMoneda']),
                                    "descuento" => ($descuento_compuesto == "") ? 0 : $descuento_compuesto,
                                    "observaciones" => $partidas['Observaciones'],
                                ];
                                if ($rqctocCotizacionPartidas) {
                                    $rqctocCotizacionPartidas->update($datos_partida_edicion);
                                } else {
                                    $datos_partida_edicion["idrqctoc_cotizaciones"] = $cotizacionCompra->rqctocCotizacion->idrqctoc_cotizaciones;
                                    $datos_partida_edicion["idrqctoc_solicitudes_partidas"] = $rqctocSolicitudPartida->idrqctoc_solicitudes_partidas;
                                    RQCTOCCotizacionesPartidas::create($datos_partida_edicion);
                                }
                                $cotizacionCompra->cotizaciones()->where(['id_transaccion'=>$key,'id_material'=>$idMaterial])->update($datos_sao);
                                $success++;
                            } else {
                                $cotizaciones[$key]['error'][] = "No se puede procesar la cotización";
                                $error++;
                            }
                        }
                    }
                } else {
                    $cotizaciones[$key]['error'][] = "La cotización no exite";
                    $error++;
                }
            }
            if ($error > 0) {
                $this->resultData = $cotizaciones;
                throw new \Exception('No es posible procesar el Layout debido a que presenta diferencias con la información actual del Contrato Proyectado 1');
            }
            DB::connection('cadeco')->commit();
            DB::connection('controlrec')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            DB::connection('controlrec')->rollback();
            throw $e;
        }
        return ["message" => "se guardaron correctamente $success registros"];
    }

    /**
     * @return int
     */
    public function getIdRequisicion()
    {
        return $this->id_requisicion;
    }

    /**
     * @param $id_requisicion
     *
     * @return $this
     */
    public function setIdRequisicion($id_requisicion)
    {
        $this->id_requisicion = $id_requisicion;

        return $this;
    }

}