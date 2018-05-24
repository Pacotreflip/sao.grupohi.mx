<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 16/05/2018
 * Time: 09:42 AM
 */

namespace Ghi\Domain\Core\Layouts\Presupuestos;


use Ghi\Domain\Core\Layouts\ValidacionLayout;
use Ghi\Domain\Core\Models\Subcontratos\PartidaAsignacion;
use Ghi\Domain\Core\Repositories\Subcontratos\EloquentPartidaAsignacionRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use MCrypt\MCrypt;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;

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
        "" => "#",
        "identificador" => "identificador",
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
        "precio_unitario_antes_descto" => "Precio Unitario Antes Descto",
        "precio_total_antes_descto" => "Precio Total Antes Descto",
        "descuento" => "% Descuento",
        "precio_unitario" => "Precio Unitario",
        "precio_total" => "Precio Total",
        "moneda" => "Moneda",
        "precio_unitario_moneda_conversion" => "Precio Unitario Moneda Conversión",
        "precio_total_moneda_conversion" => "Precio Total Moneda Conversión",
        "observaciones" => "Observaciones",
        "cotizado_img" => "cotizado_img",
        "id_moneda" => "id_moneda",
        "precio_total_mxp" => "precio_total_mxp",
        "" => "",
    ];

    /**
     * @var array
     */
    protected $rowOperacionesExtra = [
        "descuento" => "% Descuento",
        "subtotal_precio_pesos" => "Subtotal Precios Peso (MXP)",
        "subtotal_precio_dolar" => "Subtotal Precios Dolar (USD)",
        "subtotal_precio_euro" => "Subtotal Precios EURO",
        "tc_usd" => "TC USD",
        "tc_euro" => "TC EURO",
        "moneda_de_conv" => "Moneda de Conv.",
        "subtotal_moneda_conv" => "Subtotal Moneda Conv.",
        "iva" => "IVA",
        "total" => "Total",
        "fecha_de_presupuesto" => "Fecha de Presupuesto",
        "anticipio" => "% Anticipo",
        "credito_dias" => "Credito dias",
        "vigencia_dias" => "Vigencia dias",
        "observaciones" => "Observaciones Generales",
    ];

    /**
     * AsignacionSubcontratistasLayout constructor.
     * @param ContratoProyectado $contrato_proyectado
     */
    public function __construct(ContratoProyectado $contrato_proyectado)
    {
        $this->mCrypt = new MCrypt();
        $this->mCrypt->setKey($this->Key);
        $this->mCrypt->setIv($this->Iv);
        $this->lengthHeaderFijos = count($this->headerFijos);
        $this->lengthHeaderDinamicos = count($this->headerDinamicos);
        $this->contrato_proyectado = $contrato_proyectado;
        $this->cabecerasLength = 2;
        $this->partidaAsignacion = new EloquentPartidaAsignacionRepository(new PartidaAsignacion());
    }

    /**
     * @return mixed
     */
    public function setData()
    {
        $contrato_proyectado = $this->contrato_proyectado;
        $row = 0;
        $maxRow = 0;
        $presupuestos = $contrato_proyectado->cotizacionesContrato;
        $arrayResult['totales'] = $presupuestos->count();
        $arrayResult['valores'] = [];
        if ($arrayResult['totales'] > 0) {
            $index = 0;
            foreach ($contrato_proyectado->cotizacionesContrato as $key => $cotizacion) {
                $presupuestos = $cotizacion->presupuestos->filter(function ($value) use ($cotizacion) {
                    $asinado = $this->partidaAsignacion->where(['id_concepto' => $value->id_concepto, 'id_transaccion' => $cotizacion->id_transaccion])->get();
                    return (count($asinado) == 0);
                });
                $totalesPartidas = $presupuestos->count();
                if ($totalesPartidas > 0) {
                    if ($totalesPartidas == 0) {
                        $arrayResult['totales'] = $arrayResult['totales'] - 1;
                    } else {
                        foreach ($presupuestos as $_index => $presupuesto) {
                            $partida = $contrato_proyectado->contratos()->find($presupuesto->id_concepto);
                            if (!isset($arrayResult['valores'][$partida->id_concepto])) {
                                $arrayResult['valores'][$presupuesto->id_concepto] = [];
                                $arrayResult['valores'][$presupuesto->id_concepto]['partida'] = $partida;
                                $row++;
                                $maxRow = ($maxRow < $row) ? $row : $maxRow;
                            }
                            //if ($presupuesto->no_cotizado == 0) {
                            $arrayResult['valores'][$presupuesto->id_concepto]['presupuesto'][$index] = $presupuesto;
                            $arrayResult['valores'][$presupuesto->id_concepto]['cotizacion'][$index] = $cotizacion;
                            /*} else {
                                $arrayResult['valores'][$partida->id_concepto]['presupuesto'][$index] = [];
                                $arrayResult['valores'][$partida->id_concepto]['partida'][$index] = [];
                                $totalesPartidas--;
                            }*/

                            $maxRow = ($maxRow < $totalesPartidas) ? $totalesPartidas : $maxRow;

                        }
                        $index++;
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
        $contrato_proyectado = $this->contrato_proyectado;
        Config::set(['excel.export.calculate' => true]);
        return Excel::create('Asignación presupuestos', function ($excel) use ($contrato_proyectado) {
            $excel->sheet('# ' . str_pad($contrato_proyectado->numero_folio, 5, '0', STR_PAD_LEFT), function (LaravelExcelWorksheet $sheet) use ($contrato_proyectado) {
                $arrayContratoProyectado = $this->setData($contrato_proyectado);
                $sheet->getProtection()->setSheet(true);
                $sheet->loadView('excel_layouts.asignacion_presupuestos',
                    [
                        'contratoProyectados' => $arrayContratoProyectado,
                        'headerCotizaciones' => $this->headerFijos,
                        'headerPresupuestos' => $this->headerDinamicos,
                        'mcrypt' => $this->mCrypt,
                    ]);
                $sheet->setAutoSize(false);
                /*if ($arrayContratoProyectado['totales'] > 0) {
                    //$sheet->setAutoFilter('A1:S1');
                    $maxCol = ($arrayContratoProyectado['totales'] * $this->lengthHeaderDinamicos) + $this->lengthHeaderFijos;
                    $j = $this->lengthHeaderFijos + ($this->lengthHeaderDinamicos - 1);
                    $arrayTotales = [];

                    $start = \PHPExcel_Cell::stringFromColumnIndex($this->lengthHeaderFijos);
                    $sheet->getStyle($start . ($this->cabecerasLength + 1) . ':' . $start . ($arrayContratoProyectado['maxRow'] + ($this->cabecerasLength)))
                        ->applyFromArray(array(
                            'borders' => array(
                                'left' => array('style' => \PHPExcel_Style_Border::BORDER_THICK),
                            )
                        ));

                    while ($j <= $maxCol) {
                        $index = \PHPExcel_Cell::stringFromColumnIndex($j);
                        $sheet->getStyle($index . '' . ($this->cabecerasLength + 1) . ':' . $index . ($arrayContratoProyectado['maxRow'] + $this->cabecerasLength))
                            ->getProtection()
                            ->setLocked(
                                \PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
                            )->getActiveSheet();
                        $sheet->getStyle($index . '' . ($this->cabecerasLength + 1) . ':' . $index . ($arrayContratoProyectado['maxRow'] + $this->cabecerasLength))
                            ->applyFromArray(array(
                                'borders' => array(
                                    'right' => array('style' => \PHPExcel_Style_Border::BORDER_THICK),
                                )
                            ))
                            ->getNumberFormat()
                        ;
                        $sheet
                            ->setColumnFormat(array(
                                $index . '' . ($this->cabecerasLength + 1) . ':' . $index . ($arrayContratoProyectado['maxRow'] + $this->cabecerasLength) => \PHPExcel_Style_NumberFormat::FORMAT_NUMBER
                            ));
                        $arrayTotales[$index] = $index;
                        $j += $this->lengthHeaderDinamicos;
                    }
                    $index = \PHPExcel_Cell::stringFromColumnIndex($maxCol+1);
                    $sheet->getStyle($index . '' . ($this->cabecerasLength) . ':' . $index . ($arrayContratoProyectado['maxRow'] + $this->cabecerasLength))
                        ->getProtection()
                        ->setLocked(
                            \PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
                        )->getActiveSheet();
                    for ($i = ($this->cabecerasLength + 1); $i < ($arrayContratoProyectado['maxRow'] + ($this->cabecerasLength + 1)); $i++) {
                        $col = '';
                        foreach ($arrayTotales as $totales) {
                            $col .= $totales . "$i,";
                        }
                        $col = substr($col, 0, -1);
                        $indexSumatoria = \PHPExcel_Cell::stringFromColumnIndex($this->lengthHeaderFijos - 1);
                        $sheet->setCellValue($index . "$i", "=($indexSumatoria" . $i . "-SUM($col))");
                    }
                    $index = \PHPExcel_Cell::stringFromColumnIndex($maxCol-1);
                    $sheet->getStyle( 'A' . ($arrayContratoProyectado['maxRow'] + $this->cabecerasLength) . ':' . $index . ($arrayContratoProyectado['maxRow'] + $this->cabecerasLength))
                        ->applyFromArray(array(
                            'borders' => array(
                                'bottom' => array('style' => \PHPExcel_Style_Border::BORDER_THICK),
                            )
                        ))
                    ;
                }*/
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
                if ('# ' . str_pad($this->contrato_proyectado->numero_folio, 5, '0', STR_PAD_LEFT) != $results->getTitle()) {
                    throw new \Exception("No corresponde el layout al Contrato");
                }
                $col = $sheet->toArray();
                $headers = $col[($this->cabecerasLength - 1)];
                //$headers = $results->getHeading();
                $layout = $this->setData();
                if ($this->validarHeader($headers, $layout)) {
                    if (count($col) != ($layout['maxRow'] + $this->cabecerasLength + $this->operaciones)) {
                        throw new \Exception("No es posible procesar el Layout debido a que presenta diferencias con la información actual del Contrato Proyectado ");
                    }
                    $arrayContratos = [];
                    for ($i = $this->cabecerasLength; $i < count($col); $i++) {
                        $row = $col[$i];
                        $maxCol = count($row);
                        $j = $this->lengthHeaderFijos + ($this->lengthHeaderDinamicos - 1);
                        $k = $this->lengthHeaderFijos;
                        while ($j <= $maxCol) {
                            $id_concepto = !empty($row[1]) ? $this->mCrypt->decrypt($row[1]) : '';
                            $id_transaccion = '';
                            if ($i <= ($layout['maxRow'] + $this->cabecerasLength) - 1) {
                                //$id_transaccion = !empty($row[$k]) ? $this->mCrypt->decrypt($row[$k]) : '';
                                if (is_numeric($id_transaccion) and !empty($id_transaccion) && is_numeric($id_concepto) and !empty($id_concepto)) {
                                    //if ($row[$k + ($this->lengthHeaderDinamicos - 1)] > 0) {
                                    $arrayContratos[$id_transaccion]['presupuestos'][] = [
                                        'linea' => $i,
                                        'unidad' => $row[4],//de contratos
                                        'cantidad_autorizada' => $row[5],//de contratos
                                        'cantidad_solicitada' => $row[6],//de contratos
                                        'id_transaccion' => $id_transaccion,//transaccion de presupuesto
                                        'id_concepto' => $id_concepto,//de contratos
                                        'precio_unitario' => str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 8)]),
                                        "no_cotizado" => '',
                                        "PorcentajeDescuento" => str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 9)]),
                                        "IdMoneda" => $row[$k + ($this->lengthHeaderDinamicos - 2)],
                                        "Observaciones" => $row[$k + ($this->lengthHeaderDinamicos - 4)],
                                        "clave" => '',
                                        "descripcion" => '',
                                        'precio_unitario_antes_descuento' => str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 11)]),
                                        'precio_tototal_antes_descuento' => str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 10)]),
                                        'precio_total' => str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 7)]),
                                        'moneda' => $row[$k + ($this->lengthHeaderDinamicos - 3)],
                                        'precio_unitario_moneda_convertido' => str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 6)]),
                                        'precio_total_moneda_convertido' => str_replace(",", "", $row[$k + ($this->lengthHeaderDinamicos - 5)]),
                                        'cotizado_img' => $row[$k + ($this->lengthHeaderDinamicos - 3)],
                                        'precio_total_mxp' => $row[$k + ($this->lengthHeaderDinamicos - 1)],
                                    ];
                                    //}
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
     * @return array
     * @throws \Exception
     */
    public function procesarDatos(array $contratos)
    {
        $contrato_proyectado = $this->contrato_proyectado;
        try {
            DB::connection('cadeco')->beginTransaction();
            $error = 0;
            $success = 0;
            $sumatorias = [];
            $mensajeError = '';
            foreach ($contratos as $key => $contrato) {
                if ($contrato['cotizacion']['descuento'] > 100 || $contrato['cotizacion']['descuento'] < 0) {
                    $mensajeError = "El valor del descuento debe estar entre 0% y 100%";
                    $error++;
                }
                if ($contrato['cotizacion']['tc_usd'] > 25 || $contrato['cotizacion']['tc_usd'] < 10) {
                    $error++;
                    $mensajeError = "Ingrese un valor válido para el Tipo de Cambio del dólar";
                }

                if ($contrato['cotizacion']['tc_euro'] > 25 || $contrato['cotizacion']['tc_euro'] < 10) {
                    $mensajeError = "Ingrese un valor válido para el Tipo de Cambio del Euro";
                    $error++;
                }
                if (!is_numeric($contrato['cotizacion']['iva'])/*is_nan($contrato['cotizacion']['iva'])*/) {
                    $mensajeError = "Ingrese un valor válido para el IVA";
                    $error++;
                }
                if ($contrato['cotizacion']['anticipio'] > 100 || $contrato['cotizacion']['anticipio'] < 0) {
                    $mensajeError = "Ingrese un valor válido para el IVA";
                    $error++;
                }
                if (!is_numeric($contrato['cotizacion']['credito_dias'])) {
                    $mensajeError = "Ingrese un valor válido para los dáas de crédito.";
                    $error++;
                }
                if (!is_numeric($contrato['cotizacion']['vigencia_dias'])) {
                    $mensajeError = "Ingrese un valor válido para los días de vigencia del presupuesto.";
                    $error++;
                }
                $fecha_ex = explode("-", $contrato['cotizacion']['fecha_de_presupuesto']);
                if (!checkdate($fecha_ex[1], $fecha_ex[0], $fecha_ex[2])) {
                    $mensajeError = "Ingrese un valor válido para la fecha del presupuesto.";
                    $error++;
                }

                if ($error > 0) {
                    $this->resultData = $contratos;
                    throw new \Exception($mensajeError);
                }

                $cotizacionContrato = $contrato_proyectado->cotizacionesContrato()->find($key);
                $presupuestos = $cotizacionContrato->presupuestos->filter(function ($value) use ($key) {
                    $asinado = $this->partidaAsignacion->where(['id_concepto' => $value->id_concepto, 'id_transaccion' => $key])->get();
                    return (count($asinado) > 0);
                });
                if ($presupuestos->count() > 0) {
                    throw new \Exception("Al menos una partida del presupuesto esta incluida en una asignación de proveedores y no pudo ser modificada, los datos del presupuesto y de las partidas que no estan relacionadas con una asignación fueron actualizadas correctamente.");
                } else {
                    foreach ($contrato['presupuestos'] as &$arrayPresupuesto) {
                        /*if(is_array($arrayPresupuesto['id_transaccion_contrato'])) {
                            foreach($arrayPresupuesto['id_transaccion_contrato'] as $id_presupuesto) {*/
                                $presupuesto = $cotizacionContrato->presupuestos()->where('id_concepto', $arrayPresupuesto['id_concepto'])->where('id_transaccion', $key);
                                $dataUpdatePresupuesto = [
                                    "precio_unitario" => $arrayPresupuesto['precio_unitario'],
                                    "no_cotizado" => $arrayPresupuesto['no_cotizado'],
                                    "PorcentajeDescuento" => $arrayPresupuesto['PorcentajeDescuento'],
                                    "IdMoneda" => $arrayPresupuesto['IdMoneda'],
                                    "Observaciones" => $arrayPresupuesto['Observaciones'],
                                    //"clave" =>  $arrayPresupuesto['clave'],
                                    //"descripcion" => $arrayPresupuesto['descripcion'],
                                ];
                                $updatePartidas = $presupuesto->update($dataUpdatePresupuesto);
                                if (!$updatePartidas) {
                                    $arrayPresupuesto['error'] = "No se puede guardar el registro";
                                    $error++;
                                } else {
                                    $arrayPresupuesto['success'] = true;
                                    $success++;
                                }
                                if (!$arrayPresupuesto['success']) {
                                    $this->resultData[$arrayPresupuesto['linea']][] = $arrayPresupuesto;
                                }
                            /*}
                        }else{
                            $arrayPresupuesto['error'] = "No se puede guardar el registro";
                            $error++;
                        }*/
                    }

                    if ($error == 0) {
                        $totalesContratos = $cotizacionContrato->getTotalesPresupiestos();
                        $contrato['cotizacion']['monto'] = $totalesContratos[0]->monto;
                        $contrato['cotizacion']['impuesto'] = $totalesContratos[0]->impuesto;
                        if ($cotizacionContrato->update($contrato['cotizacion'])) {
                            $arrayPresupuesto['success'] = true;
                            $success++;
                        } else {
                            throw new \Exception('No es posible procesar el Layout debido a que presenta diferencias con la información actual del Contrato Proyectado ');
                        }
                    }
                }
                if ($error > 0) {
                    $this->resultData = $contratos;
                    throw new \Exception('No es posible procesar el Layout debido a que presenta diferencias con la información actual del Contrato Proyectado ');
                }
                DB::connection('cadeco')->commit();
            }
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw new \Exception($e->getMessage());
        }

        return ["message" => "se guardaron correctamente $success registros"];
    }

}