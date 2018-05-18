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

    protected $operaciones = 15;

    /**
     * @var array
     */
    protected $headerFijos = [
        "#" => "#",
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
        "id" => "Id",
        "Precio Unitario Antes Descto" => "Precio Unitario Antes Descto",
        "Precio Total Antes Descto" => "Precio Total Antes Descto",
        "% Descuento" => "% Descuento",
        "Precio Unitario" => "Precio Unitario",
        "Precio Total" => "Precio Total",
        "Moneda" => "Moneda",
        "Precio Unitario Moneda Conversión" => "Precio Unitario Moneda Conversión",
        "Precio Total Moneda Conversión" => "Precio Total Moneda Conversión",
        "Observaciones" => "Observaciones"
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
        $this->cabecerasLength = 1;
        $this->partidaAsignacion = new EloquentPartidaAsignacionRepository(new PartidaAsignacion());
    }

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
            ->store('xlsx', storage_path() . '/logs/')
            ;
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
                /*if ('# ' . str_pad($this->contrato_proyectado->numero_folio, 5, '0', STR_PAD_LEFT) != $results->getTitle()) {
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