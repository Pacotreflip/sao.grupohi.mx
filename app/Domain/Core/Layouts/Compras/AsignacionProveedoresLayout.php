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
use Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCSolicitud;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCTablaComparativa;
use Ghi\Domain\Core\Models\ControlRec\RQCTOCTablaComparativaPartida;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;

class AsignacionProveedoresLayout
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
    /**
     * @var int
     */
    protected $partidasLength = 8;
    /**
     * @var int
     */
    protected $cotizacionesLength = 7;
    /**
     * @var int
     */
    protected $cabecerasLength = 2;

    /**
     * AsignacionProveedoresLayout constructor.
     * @param Requisicion $requisicion
     */
    public function __construct(Requisicion $requisicion)
    {
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
        if($arrayResult['totales']>0) {
            foreach ($requisicion->rqctocSolicitud->rqctocCotizaciones->filter(function ($value) {
                return $value->candidata;
            }) as $key => $cotizacion) {
                foreach ($cotizacion->rqctocCotizacionPartidas->filter() as $index => $cotizacionPartida) {
                    $partida = $requisicion->rqctocSolicitud->rqctocSolicitudPartidas()->find($cotizacionPartida->idrqctoc_solicitudes_partidas);
                    if (!isset($arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas])) {
                        $arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas] = [];
                        $arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas]['partida'] = $partida;
                    }
                    if ($cotizacionPartida->precio_unitario > 0) {
                        $arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas]['cotizacionPartida'][$key] = $cotizacionPartida;
                        $arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas]['cotizacion'][$key] = $cotizacion;
                    } else {
                        $arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas]['cotizacionPartida'][$key] = [];
                        $arrayResult['valores'][$partida->idrqctoc_solicitudes_partidas]['cotizacion'][$key] = [];
                    }
                    $row++;
                    $maxRow = ($maxRow < $row) ? $row : $maxRow;
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
                $sheet->loadView('excel_layouts.asignacion_proveedores', ['requisiciones' => $arrayRequisicion]);
                if($arrayRequisicion['totales']>0) {
                    $sheet->setAutoSize(false);
                    //$sheet->setAutoFilter('A1:R1');
                    $maxCol = ($arrayRequisicion['totales'] * $this->cotizacionesLength) + $this->partidasLength;
                    $j = $this->partidasLength + ($this->cotizacionesLength - 1);
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
                        $j += $this->cotizacionesLength;
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
        });
        //->store('xlsx', storage_path());
    }


    /**
     * @param Request $request
     */
    public function qetDataFile(Request $request)
    {
        Excel::load($request->file('file')->getRealPath(), function ($reader) {
            $results = $reader->all();
            $folio_sao = explode(" ", $results->getTitle());
            $sheet = $reader->sheet($results->getTitle(), function (LaravelExcelWorksheet $sheet) {
                $sheet->getProtection()->setSheet(false);
            });
            $col = $sheet->toArray();
            for ($i = ($this->cabecerasLength + 1); $i < count($col); $i++) {
                $row = $col[$i];
                $maxCol = count($row);
                $j = $this->partidasLength + ($this->cotizacionesLength - 1);
                $k = $this->partidasLength;
                while ($j <= $maxCol) {
                    if (is_numeric($row[$k]) and !empty($row[$k])) {
                        $partidas[] = [
                            'id_partida' => $row[1],
                            'id_cotizacion' => $row[$k],
                            'cantidad_asignada' => $row[$k + ($this->cotizacionesLength - 1)],
                        ];
                    }
                    $k += $this->cotizacionesLength;
                    $j += $this->cotizacionesLength;
                }
            }
            try {
                $this->procesarDatos($folio_sao[1], $partidas);
            } catch (\Exception $e) {
                Log::debug($this->resultData);
                dd($e->getMessage());
            }
        });
    }
}