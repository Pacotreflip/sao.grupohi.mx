<?php

namespace Ghi\Domain\Core\Layouts\Compras;

use Carbon\Carbon;
use Ghi\Domain\Core\Layouts\ValidacionLayout;
use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use MCrypt\MCrypt;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Models\Cambio;

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

    protected $operaciones = 15;

    /**
     * @var array
     */
    protected $headerFijos = [
        "#" => "#",
        "id" => "Id",
        "descripcion_span" => "descripcion_span",
        "unidad" => "unidad",
        "cantidad_solicitada" => "cantidad solicitada",
        "cantidad_autorizada" => "cantidad_aprobada",
    ];

    /**
     * @var array
     */
    protected $headerDinamicos = [

        "precio_unitario" => "Precio Unitario",
        "descuento" => "% Descuento",
        "precio_total" => "Precio Total",
        "moneda" => "Moneda",
        "precio_total_moneda_conversion" => "Precio Total Moneda Conversión",
        "observaciones" => "Observaciones",
        "material_sao" => "material_sao",
        "idrqctoc_solicitudes_partidas" => "idrqctoc_solicitudes_partidas",
        "idrqctoc_solicitudes" => "idrqctoc_solicitudes",
        "idmoneda" => "idmoneda",
        "separador" => "",
    ];
    private $tipo_cambio;
    /**
     * @var RequisicionRepository
     */
    private $requisicion;

    /**
     * AsignacionSubcontratistasLayout constructor.
     * @param RequisicionRepository $requisicionRepository
     * @param $info
     * @internal param ContratoProyectado $contrato_proyectado
     */
    public function __construct(RequisicionRepository $requisicionRepository, $info)
    {
        $this->mCrypt = new MCrypt();
        $this->mCrypt->setKey($this->Key);
        $this->mCrypt->setIv($this->Iv);
        $this->lengthHeaderFijos = count($this->headerFijos);
        $this->lengthHeaderDinamicos = count($this->headerDinamicos);
        $this->requisicion = $requisicionRepository;
        $this->info = $info;
        $this->cabecerasLength = 1;

        // Tipo cambio hoy
        $tipo_cambio = Cambio::where('fecha', '=', date('Y-m-d'))->get()->toArray();

        foreach ($tipo_cambio as $k => $v)
            $this->tipo_cambio[$v['id_moneda']] = $v;
        $this->requisicion = $requisicionRepository;
    }

    public function setData()
    {
        $row = 0;
        $maxRow = 0;
        $presupuestos = $this->requisicion->getCotizaciones($this->info['id_requisicion'], $this->info['cot_ids']);

        // Agrupados/No agrupados
        $partidas = is_array($this->info['agrupadores']) ? $this->requisicion->getPartidasCotizacionAgrupadas($this->info['id_requisicion']) : $this->requisicion->getPartidasCotizacion($this->info['id_requisicion']);

        $arrayResult['totales'] = $presupuestos->count();
        $arrayResult['valores'] = [];
        if ($arrayResult['totales'] > 0) {
            $index = 0;
            foreach ($partidas as $key => $cotizacion) {

                $totalesPartidas = $presupuestos->count();
                if ($totalesPartidas > 0)
                {
                    if ($totalesPartidas == 0)
                        $arrayResult['totales'] = $arrayResult['totales'] - 1;

                    else
                    {
                        foreach ($presupuestos as $_index => $presupuesto)
                        {

                            if (!isset($arrayResult['valores'][$cotizacion->id_concepto])) {
                                $arrayResult['valores'][$cotizacion->id_concepto] = [];
                                $arrayResult['valores'][$cotizacion->id_concepto]['partida'] = $cotizacion;
                                $row++;
                                $maxRow = ($maxRow < $row) ? $row : $maxRow;
                            }
                            //if ($presupuesto->no_cotizado == 0) {
                                $arrayResult['valores'][$cotizacion->id_concepto]['presupuesto'][$_index] = $presupuesto;
                                $arrayResult['valores'][$cotizacion->id_concepto]['cotizacion'][$_index] = $cotizacion;
                            /*} else {
                                $arrayResult['valores'][$partida->id_concepto]['presupuesto'][$index] = [];
                                $arrayResult['valores'][$partida->id_concepto]['partida'][$index] = [];
                                $totalesPartidas--;
                            }*/

                            $maxRow = ($maxRow < $totalesPartidas) ? $totalesPartidas : $maxRow;

                        }
                    }
                }
                else
                    $arrayResult['totales'] = $arrayResult['totales'] - 1;
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
        $req = $this->requisicion->getRequisicion($this->info['id_requisicion']);

        Config::set(['excel.export.calculate' => true]);
        return Excel::create('Asignación presupuestos', function ($excel) use ($req) {
            $excel->sheet('# ' . str_pad($req->folio_sao, 5, '0', STR_PAD_LEFT), function (LaravelExcelWorksheet $sheet) use ($req) {
                $arrayRequisicion = $this->setData();

                $sheet->getProtection()->setSheet(true);
                $sheet->loadView('excel_layouts.asignacion_proveedores',
                    [
                        'requisicion' => $arrayRequisicion,
                        'headerRequisiciones' => $this->headerFijos,
                        'headerCotizaciones' => $this->headerDinamicos,
                        'mcrypt' => $this->mCrypt,
                        'info' => $this->info
                    ]);
                $sheet->setAutoSize(false);

                $index = 1;
                $haciaAbajo = 3;
                foreach($arrayRequisicion['valores'] as $key => $requisicion)
                {
                    foreach($requisicion['presupuesto'] as $key => $cotizacion)
                    {
                        $desde = (count($this->headerDinamicos) * $key) + (count($this->headerFijos));

                        // Precio Unitario
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

                        // % Descuento
                        $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde + 1) . $haciaAbajo)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

                        // Precio Total
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 2) . $haciaAbajo, '='. \PHPExcel_Cell::stringFromColumnIndex($desde) . $haciaAbajo .'*'. 'E'. $haciaAbajo .'-(('. \PHPExcel_Cell::stringFromColumnIndex($desde) . $haciaAbajo .'*E'. $haciaAbajo .'*H'. $haciaAbajo .')/100)');

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
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 4) . $haciaAbajo, '=IF('. \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo .'="EURO",'. \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo .'*'. $this->tipo_cambio[3]['cambio'] .'/1, IF('. \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo .'="DOLAR USD",'. \PHPExcel_Cell::stringFromColumnIndex($desde + 2) . $haciaAbajo .'*'. $this->tipo_cambio[2]['cambio'] .'/1, IF('. \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo .'="PESO MXP",'. \PHPExcel_Cell::stringFromColumnIndex($desde + 2) . $haciaAbajo .'/1, IF('. \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo .'="",0))))');


                        // id moneda
                        $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde + 9) . $haciaAbajo,'=IF('. \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo .'="EURO",2, IF('. \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo .'="DOLAR (USD)",1, IF('. \PHPExcel_Cell::stringFromColumnIndex($desde + 3) . $haciaAbajo .'="PESO (MXP)",3,0)))');

                    }
                    $index++; $haciaAbajo++;
                }

                // Referencia última fila
                $haciaAbajo = $haciaAbajo -1;
                $ultimaFila = $haciaAbajo;

                // % Descuento
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    $desde = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos))) - 1;
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, '% Descuento');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, '0');
                }

                // Subtotal Precios PESO MXP
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;

                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Subtotal Precios PESO MXP');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, '=SUMIF('. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . $ultimaFila .',"PESO MXP",'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . $ultimaFila .')-(SUMIF('. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . $ultimaFila .',"PESO MXP",'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . $ultimaFila .')*'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot) .($ultimaFila).'/100)');
                }

                // Subtotal Precios DOLAR USD
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;

                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Subtotal Precios DOLAR USD');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, '=SUMIF('. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . $pos .',"DOLAR USD",'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . $pos .')-(SUMIF('. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . $pos .',"DOLAR USD",'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . $pos .')*'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot) .($haciaAbajo + 1) . '/100)');
                }

                // Subtotal Precios EURO
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;

                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Subtotal Precios EURO');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, '=SUMIF('. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . $ultimaFila .',"EURO",'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . $ultimaFila .')-(SUMIF('. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 3) . $ultimaFila .',"EURO",'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 2) . $ultimaFila .')*'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot) .($ultimaFila + 1) . '/100)');
                }

                // TC USD
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'TC USD');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, $this->tipo_cambio[2]['cambio']);
                }

                // TC EURO
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'TC EURO');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, $this->tipo_cambio[3]['cambio']);
                }

                // Moneda de Conv.
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;

                    $objValidation = $sheet->getCell(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos)->getDataValidation();
                    $objValidation->setType( \PHPExcel_Cell_DataValidation::TYPE_LIST );
                    $objValidation->setErrorStyle( \PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
                    $objValidation->setAllowBlank(false);
                    $objValidation->setShowInputMessage(true);
                    $objValidation->setShowErrorMessage(true);
                    $objValidation->setShowDropDown(true);
                    $objValidation->setFormula1('"PESO MX"');
                    $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Moneda de Conv');
                }

                // Subtotal Moneda Conv.
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Subtotal Moneda Conv');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, '=SUM('. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . $ultimaFila .')-(SUM('. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) .'3:'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot + 4) . $ultimaFila .')*'. \PHPExcel_Cell::stringFromColumnIndex($desdeCot) . ($ultimaFila + 1) .'/100)');
                }

                // IVA
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;

                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'IVA');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, '='. \PHPExcel_Cell::stringFromColumnIndex($desde + 1) . ($pos - 1) .'*'.'.16');
                }

                // Total
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;

                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Total');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, '='. \PHPExcel_Cell::stringFromColumnIndex($desde +1) . ($pos - 2) .'+'. \PHPExcel_Cell::stringFromColumnIndex($desde + 1) . ($pos - 1));
                }

                // Fecha de Presupuesto
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Fecha de Presupuesto');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, date("d-m-Y"));
                    $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_PROTECTED);
                }

                // % Anticipo
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, '% Anticipo');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, '0');
                    $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                }

                // Crédito dias
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Crédito dias');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, '');
                    $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                }

                // Vigencia dias
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Vigencia dias');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, '');
                    $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                }

                // Observaciones Generales
                $pos = ++$haciaAbajo;
                foreach($requisicion['presupuesto'] as $key => $cotizacion)
                {
                    // Referencia de posición para la cotización
                    $desdeCot = ((count($this->headerDinamicos) * $key) + (count($this->headerFijos)));

                    // Referencia de posición para los totales/subtotales
                    $desde = $desdeCot - 1;
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde) . $pos, 'Observaciones Generales');
                    $sheet->setCellValue(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos, '');
                    $sheet->getStyle(\PHPExcel_Cell::stringFromColumnIndex($desde +1) . $pos)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                }


            })->getActiveSheetIndex(0);
        })
            ->store('xlsx', storage_path() . '/logs/');
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function qetDataFile(Request $request)
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $results = false;
        Excel::load($request->file('file')->getRealPath(), function ($reader) use (&$results) {
            try {
                $results = $reader->all();
                $sheet = $reader->sheet($results->getTitle(), function (LaravelExcelWorksheet $sheet) {
                    $sheet->getProtection()->setSheet(false);
                });
                $folio = explode(' ', $results->getTitle());
                //->Validar que el Layout corresponda a la transacción
                /*if ('# ' . str_pad($this->requisicion->numero_folio, 5, '0', STR_PAD_LEFT) != $results->getTitle()) {
                    throw new \Exception("No corresponde el layout al Contrato");
                }*/
                //$headers = $results->getHeading();
                $col = $sheet->toArray();
                $headers = $col[$this->cabecerasLength];
                $layout = $this->setData();
                if ($this->validarHeader($headers, $layout)) {
                    if (count($col) != ($layout['maxRow'] + $this->cabecerasLength + $this->operaciones)) {
                        throw new \Exception("No es posible procesar el Layout debido a que presenta diferencias con la información actual del Contrato Proyectado ");
                    }
                    $asignaciones = [];
                    for ($i = $this->cabecerasLength; $i < count($col); $i++) {
                        $row = $col[$i];
                        $maxCol = count($row);
                        $j = $this->lengthHeaderFijos + ($this->lengthHeaderDinamicos - 1);
                        $k = $this->lengthHeaderFijos;
                        while ($j <= $maxCol) {
                            $id_concepto = $row[1];
                            $id_transaccion = !empty($row[$k]) ? $this->mCrypt->decrypt($row[$k]) : '';
                            if (is_numeric($id_transaccion) and !empty($id_transaccion)) {
                                if ($row[$k + ($this->lengthHeaderDinamicos - 1)] > 0) {
                                    $asignaciones[$id_transaccion]['partidas'][] = [
                                        'linea' => $i,
                                        'id_concepto' => $id_concepto,//de contratos
                                        'id_transaccion'=> $id_transaccion,//transaccion de presupuesto
                                        'precio_unitario_antes_descuento' => str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 1)]),
                                        'precio_tototal_antes_descuento' => str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 1)]),
                                        'porcentaje_descuento' => "",
                                        'precio_unitario' => str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 1)]),
                                        'precio_total' => str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 1)]),
                                        'moneda' => $row[$k + ($this->lengthHeaderDinamicos - 1)],
                                        'precio_unitario_moneda_convertido' =>  str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 1)]),
                                        'precio_total_moneda_convertido' => str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 1)]),
                                        'observaciones' =>  $row[$k + ($this->lengthHeaderDinamicos - 1)],
                                    ];
                                }
                            }
                            $k += $this->lengthHeaderDinamicos;
                            $j += $this->lengthHeaderDinamicos;
                        }
                    }
                    dd($asignaciones);
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

    public function procesarDatos(array $asignaciones)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $error = 0;
            $success = 0;
            $sumatorias = [];

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw new \Exception($e->getMessage());
        }
        return ["message" => "se guardaron correctamente $success registros"];
    }

}