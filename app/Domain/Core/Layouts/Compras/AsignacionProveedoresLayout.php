<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/04/2018
 * Time: 01:07 PM
 */

namespace Ghi\Domain\Core\Layouts\Compras;

use Dingo\Api\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;
use Ghi\Domain\Core\Layouts\ValidacionLayout;
use Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCSolicitud;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCTablaComparativa;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCTablaComparativaPartida;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class AsignacionProveedoresLayout extends ValidacionLayout
{

    /**
     * @var Requisicion
     */
    protected $requisicion;
    /**
     * @var RQCTOCSolicitud
     */
    protected $RQCTOCSolicitud;
    /**
     * @var RQCTOCTablaComparativa
     */
    protected $RQCTOCTablaComparativa;
    /**
     * @var RQCTOCTablaComparativaPartida
     */
    protected $RQCTOCTablaComparativaPartida;
    /**
     * @var array
     */
    protected $resultData = [];

    protected $headerFijos = [
        '' => "#",
        'id_partida' => "ID Partida",
        'descripcion' => "Descripción",
        'unidad' => "Unidad",
        'cantidad_solicitada' => "Cantidad Solicitada",
        'cantidad_autorizada' => "Cantidad Autorizada",
        'cantidad_asignada_previamente' => "Cantidad Asignada Previamente",
        'cantidad_pendiente_de_asignar' => "Cantidad Pendiente de Asignar",
    ];

    protected $headerDinamicos = [
        'id_cotizacion' => "ID Cotización",
        'precio_unitario' => "Precio Unitario",
        'descuento' => "% Descuento",
        'precio_total' => "Precio Total",
        'moneda' => "Moneda",
        'observaciones' => "Observaciones",
        'cantidad_asignada' => "Cantidad Asignada",
    ];

    /**
     * AsignacionProveedoresLayout constructor.
     * @param Requisicion $requisicion
     */
    public function __construct(Requisicion $requisicion)
    {
        $this->lengthHeaderFijos = count($this->headerFijos);
        $this->lengthHeaderDinamicos = count($this->headerDinamicos);
        $this->requisicion = $requisicion;
        $this->RQCTOCSolicitud = new RQCTOCSolicitud();
        $this->RQCTOCTablaComparativa = new RQCTOCTablaComparativa();
        $this->RQCTOCTablaComparativaPartida = new RQCTOCTablaComparativaPartida();
        $this->resultData = [];
    }

    /**
     * @return array
     */
    public function setData(Requisicion $requisicion)
    {
        $maxRow = 0;
        $row = 0;
        $arrayResult['totales'] = $requisicion->rqctocSolicitud->rqctocCotizaciones->filter(function ($value) {
            return $value->candidata;
        })->count();
        $arrayResult['valores'] = [];
        if ($arrayResult['totales'] > 0) {
            foreach ($requisicion->rqctocSolicitud->rqctocCotizaciones->filter(function ($value) {
                return $value->candidata;
            }) as $key => $cotizacion) {
                foreach ($cotizacion->rqctocCotizacionPartidas->filter() as $index => $cotizacionPartida) {
                    $partida = $requisicion->rqctocSolicitud->rqctocSolicitudPartidas()->find($cotizacionPartida->idrqctoc_solicitudes_partidas);
                    if ($partida->cantidad_pendiente > 0) {
                        if (!isset($arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas])) {
                            $arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas] = [];
                            $arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas]['partida'] = $partida;
                            $row++;
                            $maxRow = ($maxRow < $row) ? $row : $maxRow;
                        }
                        if ($cotizacionPartida->precio_unitario > 0) {
                            $arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas]['cotizacionPartida'][$key] = $cotizacionPartida;
                            $arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas]['cotizacion'][$key] = $cotizacion;
                        } else {
                            $arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas]['cotizacionPartida'][$key] = [];
                            $arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas]['cotizacion'][$key] = [];
                        }
                    }
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
        $requisicion = $this->requisicion;
        Config::set(['excel.export.calculate' => true]);
        return Excel::create('Asignación Proveedores', function ($excel) use ($requisicion) {
            $excel->sheet('# ' . str_pad($requisicion->numero_folio, 5, '0', STR_PAD_LEFT), function (LaravelExcelWorksheet $sheet) use ($requisicion) {
                $arrayRequisicion = $this->setData($requisicion);
                $sheet->getProtection()->setSheet(true);
                $sheet->loadView('excel_layouts.asignacion_proveedores',
                    ['requisiciones' => $arrayRequisicion,
                        'headerPartidas'=>$this->headerFijos,
                        'headerCotizacion'=>$this->headerDinamicos,
                    ]
                );
                if ($arrayRequisicion['totales'] > 0) {
                    $sheet->setAutoSize(false);
                    //$sheet->setAutoFilter('A1:R1');
                    $maxCol = ($arrayRequisicion['totales'] * $this->lengthHeaderDinamicos) + $this->lengthHeaderFijos;
                    $j = $this->lengthHeaderFijos + ($this->lengthHeaderDinamicos - 1);
                    $arrayTotales = [];
                    while ($j <= $maxCol) {
                        $index = \PHPExcel_Cell::stringFromColumnIndex($j);
                        $sheet->getStyle($index . '' . ($this->cabecerasLength + 1) . ':' . $index . ($arrayRequisicion['maxRow'] + $this->cabecerasLength))
                            ->getProtection()
                            ->setLocked(
                                \PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
                            )->getActiveSheet();
                        $sheet->getStyle($index . '' . ($this->cabecerasLength + 1) . ':' . $index . ($arrayRequisicion['maxRow'] + $this->cabecerasLength))->getNumberFormat();
                        $sheet
                            ->setColumnFormat(array(
                                $index . '' . ($this->cabecerasLength + 1) . ':' . $index . ($arrayRequisicion['maxRow'] + $this->cabecerasLength) => \PHPExcel_Style_NumberFormat::FORMAT_NUMBER
                            ));
                        $arrayTotales[$index] = $index;
                        $j += $this->lengthHeaderDinamicos;
                    }
                    $index = \PHPExcel_Cell::stringFromColumnIndex($maxCol);
                    $sheet->getStyle($index . '' . ($this->cabecerasLength) . ':' . $index . ($arrayRequisicion['maxRow'] + $this->cabecerasLength))
                        ->getProtection()
                        ->setLocked(
                            \PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
                        )->getActiveSheet();
                    for ($i = ($this->cabecerasLength + 1); $i < ($arrayRequisicion['maxRow'] + ($this->cabecerasLength + 1)); $i++) {
                        $col = '';
                        foreach ($arrayTotales as $totales) {
                            $col .= $totales . "$i,";
                        }
                        $col = substr($col, 0, -1);
                        $sheet->setCellValue($index . "$i", "=(H" . $i . "-SUM($col))");
                    }
                }
            })->getActiveSheetIndex(0);
        })
            ->store('xlsx', storage_path() . '/logs/')
            ;
    }


    /**
     * @param $folio_sao
     * @param array $partidas
     * @return bool
     * @throws \Exception
     */
    public function procesarDatos($folio_sao, array $partidas)
    {
        try {
            DB::connection('controlrec')->beginTransaction();
            if (empty($folio_sao)) {
                //$this->resultData = $partidas;
                throw new \Exception('No se puede guardar la comparación');
            }
            //->Validar que el Layout corresponda a la transacción
            $RQCTOCSolicitud = $this->requisicion->rqctocSolicitud()->where('folio_sao', $folio_sao)->first();
            if (count($RQCTOCSolicitud)) {
                $data['idrqctoc_solicitudes'] = $RQCTOCSolicitud->idrqctoc_solicitudes;
                $data['idserie'] = $RQCTOCSolicitud->id_serie;
                $tablaComparativa = $this->RQCTOCTablaComparativa->create($data);
                if (!$tablaComparativa) {
                    //$this->resultData = $partidas;
                    throw new \Exception('No se puede guardar la comparación');
                }
                $error = 0;
                $sumatorias = [];
                if (count($partidas)) {
                    foreach ($partidas as $index => $row) {
                        if (!empty(trim($row['id_partida']))) {
                            //->Que las cotizaciones presentadas en el layout correspondan a los que están registrados en la base de datos  al momento de cargarlo	Listo
                            $cotizacion = $this->requisicion->rqctocSolicitud->rqctocCotizaciones()->find($row['id_cotizacion'])->rqctocCotizacionPartidas->filter(function ($value) use ($row) {
                                return $value->idrqctoc_solicitudes_partidas == $row['id_partida'];
                            });
                            $arrayCotizacion = $cotizacion->toArray();
                            $validarCotizacion = current($arrayCotizacion);
                            if ($validarCotizacion['precio_unitario'] > 0) {
                                $partida = $this->requisicion->rqctocSolicitud->rqctocSolicitudPartidas()->find((int)$row['id_partida']);
                                //->Que la cantidad pendiente de cada partida del layout sea igual a la cantidad pendiente que se calcule con información de la base de datos, para asi evitar duplicidad de información
                                if(!isset($sumatorias[$row['id_partida']]['pendiente'])){
                                    $sumatorias[$row['id_partida']]['pendiente'] = $partida->cantidad_pendiente;
                                }
                                if ($sumatorias[$row['id_partida']]['pendiente'] == $row['cantidad_archivo']) {
                                    //->Que la cantidad a asignar sea menor o igual a la cantidad pendiente de cada partida
                                    if(!empty(trim($row['cantidad_asignada']))) {
                                        if($row['cantidad_asignada'] > 0) {
                                            if (
                                                $partida->cantidad_pendiente >= $row['cantidad_asignada']
                                                && is_numeric($row['cantidad_asignada'])
                                            ) {
                                                //save
                                                $dataRQCTOCTablaComparativaPartida['idrqctoc_tabla_comparativa'] = $tablaComparativa->idrqctoc_tabla_comparativa;
                                                $dataRQCTOCTablaComparativaPartida['idrqctoc_solicitudes_partidas'] = $row['id_partida'];
                                                $dataRQCTOCTablaComparativaPartida['idrqctoc_cotizaciones_partidas'] = $row['id_cotizacion'];
                                                $dataRQCTOCTablaComparativaPartida['cantidad_asignada'] = $row['cantidad_asignada'];
                                                $newRQCTOCTablaComparativaPartida = $this->RQCTOCTablaComparativaPartida->create($dataRQCTOCTablaComparativaPartida);
                                                if (!$newRQCTOCTablaComparativaPartida) {
                                                    $row['error'] = "No se puede guardar el registro";
                                                    $error++;
                                                } else {
                                                    $row['error'] = "";
                                                }
                                            } else {
                                                $row['error'] = "Supera el número máximo asignado";
                                                $row['cantidad_pendiente'] = $partida->cantidad_pendiente;
                                                $error++;
                                            }
                                        }else{
                                            $row['error'] = "El número asignado no puede ser negativo";
                                            $row['cantidad_pendiente'] = $partida->cantidad_pendiente;
                                            $error++;
                                        }
                                    }
                                } else {
                                    $row['error'] = "No se permite asignar valores a una cotización que no existe";
                                    $error++;
                                }
                            } else {
                                $row['error'] = "No se permite asignar valores a una cotización que no existe";
                                $error++;
                            }
                            $this->resultData[$row['linea']][] = $row;
                        }
                    }
                    if ($error > 0) {
                        throw new \Exception("hubo $error errores en el documento");
                    }
                    DB::connection('controlrec')->commit();
                }
            } else {
                $row['error'] = "No se permite asignar valores a una cotización que no existe";
            }
        } catch (\Exception $e) {
            DB::connection('controlrec')->rollback();
            throw new \Exception($e->getMessage());
        }
        return true;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function qetDataFile(Request $request)
    {
        Excel::load($request->file('file')->getRealPath(), function ($reader) {
            $results = $reader->all();
            $folio_sao = explode(" ", $results->getTitle());
            $sheet = $reader->sheet($results->getTitle(), function (LaravelExcelWorksheet $sheet) {
                $sheet->getProtection()->setSheet(false);
            });
            try {
                $headers = $results->getHeading();
                $layout = $this->setData($this->requisicion);
                //->Número y descripción de columnas
                if ($this->validarHeader($headers, $layout)) {
                    $col = $sheet->toArray();
                    //->Que las partidas presentadas en el Layout sean las mismas que se encuentran en la base de datos al momento de cargarlo
                    if (count($col)!=($layout['maxRow']+$this->cabecerasLength))
                    {
                        throw new \Exception("El layout que desea utilizar ya no es válido porque se han hecho asignaciones posteriores a la descarga del mismo. Por favor descargue el layout nuevamente.");
                    }
                    $partidas = array();
                    for ($i = ($this->cabecerasLength); $i < count($col); $i++) {
                        $row = $col[$i];
                        $maxCol = count($row);
                        $j = $this->lengthHeaderFijos + ($this->lengthHeaderDinamicos - 1);
                        $k = $this->lengthHeaderFijos;
                        while ($j <= $maxCol) {
                            if (is_numeric($row[$k]) and !empty($row[$k])) {
                                $partidas[] = [
                                    'id_partida' => $row[1],
                                    'linea' => $i,
                                    'id_cotizacion' => $row[$k],
                                    'cantidad_archivo' => str_replace(",","",$row[($this->lengthHeaderFijos-1)]),//->Que la cantidad pendiente de cada partida del layout sea igual a la cantidad pendiente que se calcule con información de la base de datos, para asi evitar duplicidad de información
                                    'cantidad_asignada' => str_replace(",","",$row[$k + ($this->lengthHeaderDinamicos - 1)]),
                                ];
                            }
                            $k += $this->lengthHeaderDinamicos;
                            $j += $this->lengthHeaderDinamicos;
                        }
                    }
                }
                if(count($partidas)) {
                    $this->procesarDatos($folio_sao[1], $partidas);
                }else{
                    throw new \Exception("no hay elementos asignados");
                }
            } catch (\Exception $e) {
                throw new StoreResourceFailedException($e->getMessage(),$this->resultData);
            }
        });
        return true;
    }
}