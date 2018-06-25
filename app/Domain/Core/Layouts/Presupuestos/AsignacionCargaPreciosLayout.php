<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 16/05/2018
 * Time: 09:42 AM
 */

namespace Ghi\Domain\Core\Layouts\Presupuestos;

use Carbon\Carbon;
use Ghi\Domain\Core\Layouts\ValidacionLayout;
use Ghi\Domain\Core\Models\Subcontratos\PartidaAsignacion;
use Ghi\Domain\Core\Repositories\Subcontratos\EloquentPartidaAsignacionRepository;
use Ghi\Utils\TipoCambio;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use MCrypt\MCrypt;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;
use Ghi\Domain\Core\Repositories\EloquentContratoProyectadoRepository;
use Ghi\Domain\Core\Models\Cambio;

/**
 * Class AsignacionCargaPreciosLayout
 * @package Ghi\Domain\Core\Layouts\Presupuestos
 */
class AsignacionCargaPreciosLayout extends ValidacionLayout
{
    /**
     * @var ContratoProyectado
     */
    protected $contrato_proyectado;
    /**
     * @var int
     */
    protected $id_contrato_proyectado;
    /**
     * @var ContratoProyectado
     */
    protected $contrato;
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
        "hijos" => "hijos",
        "clave" => "clave",
        "descripcion_span" => "descripcion_span",
        "unidad" => "unidad",
        "cantidad_autorizada" => "cantidad_autorizada",
        "cantidad_solicitada" => "cantidad_solicitada",
    ];
    /**
     * @var array
     */
    protected $headerDinamicos = [
        "Precio Unitario Antes Descto" => "Precio Unitario Antes Descto",
        "Precio Total Antes Descto" => "Precio Total Antes Descto",
        "% Descuento" => "% Descuento",
        "Precio Unitario" => "Precio Unitario",
        "Precio Total" => "Precio Total",
        "Moneda" => "Moneda",
        "Precio Unitario Moneda Conversión" => "Precio Unitario Moneda Conversión",
        "Precio Total Moneda Conversión" => "Precio Total Moneda Conversión",
        "Observaciones" => "Observaciones",
        "cotizado_img" => "cotizado_img",
        "id_moneda" => "id_moneda",
        "precio_total_mxp" => "precio_total_mxp",
        "separador" => "separador",
    ];
    /**
     * @var array
     */
    protected $rowOperacionesExtra = [
        "PorcentajeDescuento" => "% Descuento",
        "subtotal_precio_pesos" => "Subtotal Precios Peso (MXP)",
        "subtotal_precio_dolar" => "Subtotal Precios Dolar (USD)",
        "subtotal_precio_euro" => "Subtotal Precios EURO",
        "TcUSD" => "TC USD",
        "TcEuro" => "TC EURO",
        "moneda_de_conv" => "Moneda de Conv.",
        "subtotal_moneda_conv" => "Subtotal Moneda Conv.",
        "iva" => "IVA",
        "total" => "Total",
        "fecha" => "Fecha de Presupuesto",
        "anticipio" => "% Anticipo",
        "DiasCredito" => "Crédito dias",
        "DiasVigencia" => "Vigencia dias",
        "observaciones" => "Observaciones Generales",
    ];
    /**
     * @var
     */
    private $tipo_cambio;

    /**
     * AsignacionSubcontratistasLayout constructor.
     *
     * @param ContratoProyectado $contrato_proyectado
     */
    public function __construct(EloquentContratoProyectadoRepository $contrato_proyectado, $info)
    {
        $this->mCrypt = new MCrypt();
        $this->mCrypt->setKey($this->Key);
        $this->mCrypt->setIv($this->Iv);
        $this->lengthHeaderFijos = count($this->headerFijos);
        $this->lengthHeaderDinamicos = count($this->headerDinamicos);
        $this->contrato_proyectado = $contrato_proyectado;
        $this->info = $info;
        $this->cabecerasLength = 2;
        $this->partidaAsignacion = new EloquentPartidaAsignacionRepository(new PartidaAsignacion());

        // Tipo cambio hoy
        $tipo_cambio = Cambio::where('fecha', '=', date('Y-m-d'))->get()->toArray();

        foreach ($tipo_cambio as $k => $v) {
            $this->tipo_cambio[$v['id_moneda']] = $v;
        }
    }

    /**
     * @return mixed
     */
    public function setData()
    {
        $contrato = $this->contrato_proyectado->find($this->info['id_contrato_proyectado']);
        $row = 0;
        $maxRow = 0;
        $presupuestos = $contrato->cotizacionesContrato()->with(['empresa', 'sucursal'])->whereIn('id_transaccion',
            $this->info['presupuesto_ids'])->get();

        // Agrupados/No agrupados
        $partidas = is_array($this->info['agrupadores']) ? $this->contrato_proyectado->getPartidasContratoAgrupadas($this->info['id_contrato_proyectado'],
            $this->info['solo_pendientes']) : $this->contrato_proyectado->getPartidasContratos($this->info['id_contrato_proyectado'],
            $this->info['solo_pendientes']);

        $arrayResult['totales'] = $presupuestos->count();
        $arrayResult['valores'] = [];
        if ($arrayResult['totales'] > 0) {
            $index = 0;
            $maxRow = count($partidas);
            foreach ($partidas as $key => $cotizacion) {

                $totalesPartidas = $presupuestos->count();
                if ($totalesPartidas > 0) {
                    if ($totalesPartidas == 0) {
                        $arrayResult['totales'] = $arrayResult['totales'] - 1;
                    } else {
                        foreach ($presupuestos as $_index => $presupuesto) {

                            if (!isset($arrayResult['valores'][$cotizacion->id_concepto])) {
                                $arrayResult['valores'][$cotizacion->id_concepto] = [];
                                $arrayResult['valores'][$cotizacion->id_concepto]['partida'] = $cotizacion;
                                $row++;
                            }
                            $arrayResult['valores'][$cotizacion->id_concepto]['presupuesto'][$_index] = $presupuesto;
                            $arrayResult['valores'][$cotizacion->id_concepto]['cotizacion'][$_index] = $cotizacion;
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
        $contrato = $this->contrato_proyectado->find([$this->info['id_contrato_proyectado']])->first();

        Config::set(['excel.export.calculate' => true]);
        return Excel::create('Asignación Carga Precios Layout', function ($excel) use ($contrato) {
            $excel->sheet('# ' . str_pad($contrato->numero_folio, 5, '0', STR_PAD_LEFT),
                function (LaravelExcelWorksheet $sheet) use ($contrato) {
                    $arrayContratoProyectado = $this->setData($contrato);

                    $sheet->getProtection()->setSheet(true);

                    $sheet->loadView('excel_layouts.asignacion_presupuestos',
                        [
                            'contratoProyectados' => $arrayContratoProyectado,
                            'headerCotizaciones' => $this->headerFijos,
                            'headerPresupuestos' => $this->headerDinamicos,
                            'mcrypt' => $this->mCrypt,
                            'info' => $this->info,
                        ]);
                    $sheet->setAutoSize(false);

                    $index = 1;
                    $haciaAbajo = 3;
                    $contratoProyectadoRef = [];
                    foreach ($arrayContratoProyectado['valores'] as $key => $contratoProyectado) {
                        $contratoProyectadoRef = $contratoProyectado['presupuesto'];
                        foreach ($contratoProyectado['presupuesto'] as $key => $presupuesto) {
                            $desde = (count($this->headerDinamicos) * $key) + (count($this->headerFijos));

                            // Precio Unitario Antes Descuento
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

                            // % Descuento
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 2) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                            $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 2) . $haciaAbajo, 0);

                            //Moneda
                            if ($contratoProyectado['cotizacion'][0]->hijos == 0) {
                                $objValidation = $sheet->getCell(\PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo)->getDataValidation();
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

                                $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                            } else {
                                $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo,
                                    '');
                            }

                            // Precio Unitario Moneda Conversión
                            $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 6) . $haciaAbajo,
                                '=IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo . '="EURO",' . \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo . '*' . $this->tipo_cambio[3]['cambio'] . '/1, IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo . '="DOLAR USD",' . \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo . '*' . $this->tipo_cambio[2]['cambio'] . '/1, IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo . '="PESO MXP",' . \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo . '/1, IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo . '="",0))))');
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 6) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);

                            // Precio Total Moneda Conversión
                            $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 7) . $haciaAbajo,
                                '=IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo . '="EURO",H' . $haciaAbajo . '*' . \PHPExcel_Cell::stringFromColumnIndex($desde + 6) . $haciaAbajo . '/1, IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo . '="DOLAR USD",H' . $haciaAbajo . '*' . \PHPExcel_Cell::stringFromColumnIndex($desde + 6) . $haciaAbajo . '/1, IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo . '="PESO MXP",' . \PHPExcel_Cell::stringFromColumnIndex($desde + 4) . $haciaAbajo . '/1,IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo . '="",0))))');
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 7) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);

                            // Observaciones
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 8) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

                            // cotizado_img
                            $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 9) . $haciaAbajo,
                                $contratoProyectado['partida']->en_asig);
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 9) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);

                            //id_moneda
                            $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 10) . $haciaAbajo,
                                '=IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo . '="EURO",3, IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo . '="DOLAR USD",2, IF(' . \PHPExcel_Cell::stringFromColumnIndex($desde + 5) . $haciaAbajo . '="PESO MXP",1,0)))');
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 10) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);

                            //precio_total_mxp
                            $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 11) . $haciaAbajo,
                                '=(G' . $haciaAbajo . '* ' . \PHPExcel_Cell::stringFromColumnIndex($desde + 6) . $haciaAbajo . '*100)/(100-' . \PHPExcel_Cell::stringFromColumnIndex($desde + 2) . $haciaAbajo . ')');
                            $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 11) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);

                        }
                        $index++;
                        $haciaAbajo++;
                    }

                    // Referencia última fila
                    $haciaAbajo = $haciaAbajo - 1;
                    $ultimaFila = $haciaAbajo;

                    // % Descuento
                    $pos = ++$haciaAbajo;
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
                        $desde = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos))) - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, '% Descuento');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos, '0');
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    }

                    // Subtotal Precios PESO MXP
                    $pos = ++$haciaAbajo;
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;

                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Subtotal Precios PESO MXP');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            '=SUMIF(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 5) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 5) . $ultimaFila . ',"PESO MXP",' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . $ultimaFila . ')-(SUMIF(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 5) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 5) . $ultimaFila . ',"PESO MXP",' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . $ultimaFila . ')*' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot) . ($ultimaFila + 1) . '/100)');
                    }

                    // Subtotal Precios DOLAR USD
                    $pos = ++$haciaAbajo;
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;

                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Subtotal Precios DOLAR USD');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            '=SUMIF(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 5) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 5) . $ultimaFila . ',"DOLAR USD",' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . $ultimaFila . ')-(SUMIF(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 5) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 5) . $ultimaFila . ',"DOLAR USD",' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . $ultimaFila . ')*' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot) . ($ultimaFila + 1) . '/100)');
                    }

                    // Subtotal Precios EURO
                    $pos = ++$haciaAbajo;
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;

                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Subtotal Precios EURO');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            '=SUMIF(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 5) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 5) . $ultimaFila . ',"EURO",' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . $ultimaFila . ')-(SUMIF(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 5) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 5) . $ultimaFila . ',"EURO",' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . $ultimaFila . ')*' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot) . ($ultimaFila + 1) . '/100)');
                    }

                    // TC USD
                    $pos = ++$haciaAbajo;
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
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
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
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
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
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
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Subtotal Moneda Conv');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            '=SUM(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 7) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 7) . $ultimaFila . ')-(SUM(' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 7) . '3:' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 7) . $ultimaFila . ')*' . \PHPExcel_Cell::stringFromColumnIndex($desdeCot) . ($ultimaFila + 1) . '/100)');
                    }

                    // IVA
                    $pos = ++$haciaAbajo;
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
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
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;

                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Total');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos,
                            '=' . \PHPExcel_Cell::stringFromColumnIndex($desde + 1) . ($pos - 2) . '+' . \PHPExcel_Cell::stringFromColumnIndex($desde + 1) . ($pos - 1));
                    }

                    // Fecha de Presupuesto
                    $pos = ++$haciaAbajo;
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos,
                            'Fecha de Presupuesto');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos, date("d-m-Y"));
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);
                    }

                    // % Anticipo
                    $pos = ++$haciaAbajo;
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, '% Anticipo');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos, '0');
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    }

                    // Crédito dias
                    $pos = ++$haciaAbajo;
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Crédito dias');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos, '');
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    }

                    // Vigencia dias
                    $pos = ++$haciaAbajo;
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
                        // Referencia de posición para la cotización
                        $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                        // Referencia de posición para los totales/subtotales
                        $desde = $desdeCot - 1;
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Vigencia dias');
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos, '');
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    }

                    // Observaciones Generales
                    $pos = ++$haciaAbajo;
                    foreach ($contratoProyectadoRef as $key => $presupuesto) {
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

        $contrato_proyectado = $this->contrato_proyectado->find($this->id_contrato_proyectado);
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $results = false;
        Excel::load($request->file('file')->getRealPath(), function ($reader) use (&$results, $contrato_proyectado) {
            try {
                $results = $reader->all();
                $sheet = $reader->sheet($results->getTitle(), function (LaravelExcelWorksheet $sheet) {
                    $sheet->getProtection()->setSheet(false);
                });
                $folio = explode(' ', $results->getTitle());
                //->Validar que el Layout corresponda a la transacción
                if ('# ' . str_pad($contrato_proyectado->numero_folio, 5, '0', STR_PAD_LEFT) != $results->getTitle()) {
                    throw new \Exception("No corresponde el layout al Contrato");
                }
                $col = $sheet->toArray();
                $_headers = $results->getHeading();
                $identificadores = !empty($_headers[0]) ? $this->mCrypt->decrypt($_headers[0]) : [];
                $idTransaciones = explode($this->delimiter, $identificadores);
                $idTransacion = explode(',', current($idTransaciones));
                $headers = $col[($this->cabecerasLength - 1)];
                $agrupadores = $idTransaciones[2];
                $solo_pendientes = $idTransaciones[3];
                $this->info = [
                    'id_contrato_proyectado' => $this->id_contrato_proyectado,
                    'presupuesto_ids' => $idTransacion,
                    'agrupadores' => $agrupadores,
                    'solo_pendientes' => $solo_pendientes,
                ];

                $layout = $this->setData();
                $this->setMessage("No es posible procesar el Layout debido a que presenta diferencias con la estructura original descargada");
                if ($this->validarHeader($headers, $layout)) {
                    if (count($col) != ($layout['maxRow'] + $this->cabecerasLength + $this->operaciones)) {
                        throw new \Exception("No es posible procesar el Layout debido a que presenta diferencias con la estructura original descargada");
                    }
                    $arrayContratos = [];
                    for ($i = $this->cabecerasLength; $i < count($col); $i++) {
                        $row = $col[$i];
                        $maxCol = count($row);
                        $j = $this->lengthHeaderFijos + ($this->lengthHeaderDinamicos - 1);
                        $k = $this->lengthHeaderFijos;
                        $l = 0;
                        while ($j <= $maxCol) {
                            $concepto = !empty($row[1]) ? $this->mCrypt->decrypt($row[1]) : '';
                            //$concepto = $row[1];
                            $id_concepto = explode($this->delimiter, $concepto);
                            $id_transaccion = !empty($idTransacion[$l]) ? $idTransacion[$l] : '';
                            if ($i < ($layout['maxRow'] + $this->cabecerasLength)) {
                                if (is_numeric($id_transaccion) and !empty($id_transaccion) && is_array($id_concepto) and count($id_concepto)) {
                                    if ($row[2] == "0") {
                                        //if ($row[$k + ($this->lengthHeaderDinamicos - 1)] > 0) {
                                        $arrayContratos[$id_transaccion]['presupuestos'][] = [
                                            'linea' => $i,
                                            'unidad' => $row[4],//de contratos
                                            'cantidad_autorizada' => $row[6],//de contratos
                                            'cantidad_solicitada' => $row[7],//de contratos
                                            'id_transaccion' => $id_transaccion,//transaccion de presupuesto
                                            'id_concepto' => $id_concepto,//de contratos
                                            'precio_unitario' => str_replace(",", "",
                                                $row[$k + ($this->lengthHeaderDinamicos - 13)]),
                                            "no_cotizado" => '',
                                            "PorcentajeDescuento" => str_replace(",", "",
                                                $row[$k + ($this->lengthHeaderDinamicos - 11)]),
                                            "IdMoneda" => $row[$k + ($this->lengthHeaderDinamicos - 3)],
                                            "Observaciones" => $row[$k + ($this->lengthHeaderDinamicos - 5)],
                                            "clave" => '',
                                            "descripcion" => '',
                                            'precio_unitario_antes_descuento' => str_replace(",", "",
                                                $row[$k + ($this->lengthHeaderDinamicos - 10)]),
                                            'precio_tototal_antes_descuento' => str_replace(",", "",
                                                $row[$k + ($this->lengthHeaderDinamicos - 12)]),
                                            'precio_total' => str_replace(",", "",
                                                $row[$k + ($this->lengthHeaderDinamicos - 7)]),
                                            'moneda' => $row[$k + ($this->lengthHeaderDinamicos - 3)],
                                            'precio_unitario_moneda_convertido' => str_replace(",", "",
                                                $row[$k + ($this->lengthHeaderDinamicos - 7)]),
                                            'precio_total_moneda_convertido' => str_replace(",", "",
                                                $row[$k + ($this->lengthHeaderDinamicos - 6)]),
                                            'cotizado_img' => $row[$k + ($this->lengthHeaderDinamicos - 4)],
                                            'precio_total_mxp' => $row[$k + ($this->lengthHeaderDinamicos - 2)],
                                        ];
                                        //}
                                    }
                                }

                            } else {
                                $aux = $col[$this->cabecerasLength + 1];
                                $detalle = !empty($row[$this->lengthHeaderFijos - 1]) ? $row[$this->lengthHeaderFijos - 1] : '';
                                $valorDetalle = !empty($row[$k]) ? $row[$k] : '';
                                $keyDetalle = array_search($detalle, $this->rowOperacionesExtra);
                                $arrayContratos[$id_transaccion]['cotizacion'][$keyDetalle] = $valorDetalle;
                            }
                            $k += $this->lengthHeaderDinamicos;
                            $j += $this->lengthHeaderDinamicos;
                            $l++;
                        }
                    }
                    if (count($arrayContratos) > 0) {
                        $results = $this->procesarDatos($arrayContratos);
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
     * @param array $contratos
     *
     * @return array
     * @throws \Exception
     */
    public function procesarDatos(array $contratos)
    {
        $contrato_proyectado = $this->contrato_proyectado->find($this->id_contrato_proyectado);
        Log::debug($contratos);
        try {
            DB::connection('cadeco')->beginTransaction();
            $error = 0;
            $success = 0;
            $sumatorias = [];
            $mensajeError = '';
            foreach ($contratos as $key => $contrato) {
                if ($contrato['cotizacion']['PorcentajeDescuento'] > 100 || $contrato['cotizacion']['PorcentajeDescuento'] < 0) {
                    $contratos[$key]['error'][] = "El valor del descuento debe estar entre 0% y 100%";
                    $error++;
                }
                if ($contrato['cotizacion']['TcUSD'] > 25 || $contrato['cotizacion']['TcUSD'] < 10) {
                    $error++;
                    $contratos[$key]['error'][] = "Ingrese un valor válido para el Tipo de Cambio del dólar";
                }

                if ($contrato['cotizacion']['TcEuro'] > 25 || $contrato['cotizacion']['TcEuro'] < 10) {
                    $contratos[$key]['error'][] = "Ingrese un valor válido para el Tipo de Cambio del Euro";
                    $error++;
                }
                empty($contrato['cotizacion']['iva'])? $contrato['cotizacion']['iva'] = 0:'';
                if (!is_numeric($contrato['cotizacion']['iva'])/*is_nan($contrato['cotizacion']['iva'])*/) {
                    $contratos[$key]['error'][] = "Ingrese un valor válido para el IVA";
                    $error++;
                }
                if ($contrato['cotizacion']['anticipio'] > 100 || $contrato['cotizacion']['anticipio'] < 0) {
                    $contratos[$key]['error'][] = "Ingrese un valor válido para el IVA";
                    $error++;
                }
                empty($contrato['cotizacion']['DiasCredito'])? $contrato['cotizacion']['DiasCredito'] = 0:'';
                if (!is_numeric($contrato['cotizacion']['DiasCredito'])) {
                    $contratos[$key]['error'][] = "Ingrese un valor válido para los días de crédito.";
                    $error++;
                }
                 empty($contrato['cotizacion']['DiasVigencia'])? $contrato['cotizacion']['DiasVigencia'] = 0:'';
                if (!is_numeric($contrato['cotizacion']['DiasVigencia'])) {
                    $contratos[$key]['error'][] = "Ingrese un valor válido para los días de vigencia del presupuesto.";
                    $error++;
                }
                $fecha_ex = explode("-", $contrato['cotizacion']['fecha']);
                if (!checkdate($fecha_ex[1], $fecha_ex[0], $fecha_ex[2])) {
                    $contratos[$key]['error'][] = "Ingrese un valor válido para la fecha del presupuesto.";
                    $error++;
                }
                $contrato['cotizacion']['fecha'] =  $fecha_ex[2]."-". $fecha_ex[1]."-".$fecha_ex[0];
                if ($error == 0) {
                    $cotizacionContrato = $contrato_proyectado->cotizacionesContrato()->find($key);
                    $presupuestos = $cotizacionContrato->presupuestos->filter(function ($value) use ($key) {
                        $asinado = $this->partidaAsignacion->where([
                            'id_concepto' => $value->id_concepto,
                            'id_transaccion' => $key,
                        ])->get();
                        return (count($asinado) > 0);
                    });
                    if ($presupuestos->count() > 0) {
                        $contratos[$key]['error'][] = "Al menos una partida del presupuesto esta incluida en una asignación de proveedores 
                        y no pudo ser modificada, los datos del presupuesto y de las partidas que no estan relacionadas con una asignación fueron actualizadas correctamente.";
                        $error++;
                    } else {
                        foreach ($contrato['presupuestos'] as $arrayPresupuesto) {
                            if (is_array($arrayPresupuesto['id_concepto'])) {
                                if(is_numeric($arrayPresupuesto['precio_unitario_antes_descuento'])) {
                                    foreach ($arrayPresupuesto['id_concepto'] as $id_concepto) {
                                        $presupuesto = $cotizacionContrato->presupuestos()
                                            ->where('id_concepto', $id_concepto)
                                            ->where('id_transaccion', $key);
                                        /**
                                         * insert presupuesto precio unitario
                                         */
                                        $dataUpdatePresupuesto = [
                                            "precio_unitario" => TipoCambio::cambio($arrayPresupuesto['precio_unitario_antes_descuento'],
                                                $arrayPresupuesto['IdMoneda']),
                                            "no_cotizado" => $arrayPresupuesto['no_cotizado'],
                                            "PorcentajeDescuento" => $arrayPresupuesto['PorcentajeDescuento'],
                                            "IdMoneda" => $arrayPresupuesto['IdMoneda'],
                                            "Observaciones" => $arrayPresupuesto['Observaciones'],
                                            //"clave" =>  $arrayPresupuesto['clave'],
                                            //"descripcion" => $arrayPresupuesto['descripcion'],
                                        ];
                                        Log::error($dataUpdatePresupuesto);
                                        $updatePartidas = $presupuesto->update($dataUpdatePresupuesto);
                                        if (!$updatePartidas) {
                                            $contratos[$key]['error'][] = "No se puede guardar el registro";
                                            $error++;
                                        } else {
                                            $arrayPresupuesto['success'] = true;
                                            $success++;
                                        }
                                        if (!$arrayPresupuesto['success']) {
                                            $this->resultData[$arrayPresupuesto['linea']][] = $arrayPresupuesto;
                                        }
                                    }
                                }else{
                                    $contratos[$key]['error'][] = "No se puede guardar el registro, por que el Precio Unitario Antes Descto no es numérico";
                                    $error++;
                                }
                            } else {
                                $contratos[$key]['error'][] = "No se puede guardar el registro";
                                $error++;
                            }
                        }

                        if ($error == 0) {
                            if ($cotizacionContrato->update($contrato['cotizacion'])) {
                                $totalesContratos = $cotizacionContrato->getTotalesPresupiestos();
                                $cotizacionContrato->monto = $totalesContratos[0]->monto;
                                $cotizacionContrato->impuesto = $totalesContratos[0]->impuesto;
                                $cotizacionContrato->save();
                                $arrayPresupuesto['success'] = true;
                                $success++;
                            } else {
                                $contratos[$key]['error'][] = 'No es posible procesar el Layout debido a que presenta diferencias con la información actual del Contrato Proyectado ';
                            }
                        }
                    }
                }
            }
            if ($error > 0) {
                $this->resultData = $contratos;
                throw new \Exception('No es posible procesar el Layout debido a que presenta diferencias con la información actual del Contrato Proyectado ');
            }
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw new \Exception($e->getMessage());
        }

        return ["message" => "se guardaron correctamente $success registros"];
    }

    /**
     * @param $id_contrato_proyectado
     *
     * @return $this
     */
    public function setIdContratoProyectado($id_contrato_proyectado)
    {
        $this->id_contrato_proyectado = $id_contrato_proyectado;
        return $this;
    }

}