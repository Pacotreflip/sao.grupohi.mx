<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/04/2018
 * Time: 01:07 PM
 */

namespace Ghi\Domain\Core\Layouts\Contratos;

use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;

class AsignacionSubcontratistasLayout
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
    protected $cotizacionesLength = 8;
    /**
     * @var int
     */
    protected $presupuestosLength = 11;
    /**
     * @var int
     */
    protected $cabecerasLength = 2;

    /**
     * AsignacionSubcontratistasLayout constructor.
     * @param ContratoProyectado $contrato_proyectado
     */
    public function __construct(ContratoProyectado $contrato_proyectado)
    {
        $this->contrato_proyectado = $contrato_proyectado;
    }

    public function setData(ContratoProyectado $contrato_proyectado)
    {
        $row = 0;
        $maxRow = 0;
        $arrayResult['totales'] = $contrato_proyectado->cotizacionesContrato->filter()->count();
        foreach ($contrato_proyectado->cotizacionesContrato->filter() as $key => $cotizacion) {
            foreach ($cotizacion->presupuestos->filter(function ($value) use ($contrato_proyectado) {
                return $contrato_proyectado->contratos()->find($value->id_concepto)->cantidad_pendiente > 0;
            }) as $index => $presupuesto) {
                $contrato = $contrato_proyectado->contratos()->find($presupuesto->id_concepto);
                if (!isset($arrayResult['valores'][$contrato->id_concepto])) {
                    $arrayResult['valores'][$contrato->id_concepto] = [];
                    $arrayResult['valores'][$contrato->id_concepto]['contrato'] = $contrato;
                }
                if ($presupuesto->no_cotizado == 0) {
                    $arrayResult['valores'][$contrato->id_concepto]['presupuesto'][$key] = $presupuesto;
                    $arrayResult['valores'][$contrato->id_concepto]['cotizacion'][$key] = $cotizacion;
                } else {
                    $arrayResult['valores'][$contrato->id_concepto]['presupuesto'][$key] = [];
                    $arrayResult['valores'][$contrato->id_concepto]['cotizacion'][$key] = [];
                }
                $row++;
                $maxRow = ($maxRow < $row) ? $row : $maxRow;
            }
        }
        $arrayResult['maxRow'] = $maxRow;
        return $arrayResult;
    }

    public function getFile()
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $contrato_proyectado = $this->contrato_proyectado;
        Config::set(['excel.export.calculate' => true]);
        return Excel::create('Asignación Proveedores', function ($excel) use ($contrato_proyectado) {
            $excel->sheet('# ' . str_pad($contrato_proyectado->numero_folio, 5, '0', STR_PAD_LEFT), function (LaravelExcelWorksheet $sheet) use ($contrato_proyectado) {
                $arrayContratoProyectado = $this->setData($contrato_proyectado);
                $sheet->getProtection()->setSheet(true);
                $sheet->loadView('excel_layouts.asignacion_subcontratistas', ['contratoProyectados' => $arrayContratoProyectado]);
                $sheet->setAutoSize(false);
                if ($arrayContratoProyectado['totales'] > 0) {
                    //$sheet->setAutoFilter('A1:S1');
                    $maxCol = ($arrayContratoProyectado['totales'] * $this->presupuestosLength) + $this->cotizacionesLength;
                    $j = $this->cotizacionesLength + ($this->presupuestosLength - 1);
                    $arrayTotales = [];
                    while ($j <= $maxCol) {
                        $index = \PHPExcel_Cell::stringFromColumnIndex($j);
                        Log::debug($index . '' . ($this->cabecerasLength + 1) . ':' . $index . ($arrayContratoProyectado['maxRow'] + $this->cabecerasLength));
                        $sheet->getStyle($index . '' . ($this->cabecerasLength + 1) . ':' . $index . ($arrayContratoProyectado['maxRow'] + $this->cabecerasLength))
                            ->getProtection()
                            ->setLocked(
                                \PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
                            )->getActiveSheet();
                        $sheet->getStyle($index . '' . ($this->cabecerasLength + 1) . ':' . $index . ($arrayContratoProyectado['maxRow'] + $this->cabecerasLength))->getNumberFormat();
                        $sheet
                            ->setColumnFormat(array(
                                $index . '' . ($this->cabecerasLength + 1) . ':' . $index . ($arrayContratoProyectado['maxRow'] + $this->cabecerasLength) => \PHPExcel_Style_NumberFormat::FORMAT_NUMBER
                            ));
                        $arrayTotales[$index] = $index;
                        $j += $this->presupuestosLength;
                    }
                    $index = \PHPExcel_Cell::stringFromColumnIndex($maxCol);
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
                        $sheet->setCellValue($index . "$i", "=(H" . $i . "-SUM($col))");
                    }
                }
            })->getActiveSheetIndex(0);
        })->store('xlsx', storage_path() . '/logs/');
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
            /*if (empty($folio_sao)) {
                $this->resultData = $partidas;
                throw new \Exception('No se puede guardar la comparación');
            }

            $RQCTOCSolicitud = $this->requisicion->rqctocSolicitud()->where('folio_sao', $folio_sao)->first();
            $data['idrqctoc_solicitudes'] = $RQCTOCSolicitud->idrqctoc_solicitudes;
            $data['idserie'] = $RQCTOCSolicitud->id_serie;
            $tablaComparativa = $this->RQCTOCTablaComparativa->create($data);
            if (!$tablaComparativa) {
                $this->resultData = $partidas;
                throw new \Exception('No se puede guardar la comparación');
            }
            $error = 0;
            if (count($partidas)) {
                foreach ($partidas as $index => $row) {
                    if (!empty(trim($row['id_partida']))) {
                        $cotizacion = $this->requisicion->rqctocSolicitud->rqctocCotizaciones()->find($row['id_cotizacion'])->rqctocCotizacionPartidas->filter(function ($value) use ($row) {
                            return $value->idrqctoc_solicitudes_partidas == $row['id_partida'];
                        });
                        $arrayCotizacion = $cotizacion->toArray();
                        $validarCotizacion = current($arrayCotizacion);
                        if ($validarCotizacion['precio_unitario'] > 0) {
                            $partida = $this->requisicion->rqctocSolicitud->rqctocSolicitudPartidas()->find((int)$row['id_partida']);
                            $sumatorias[$row['id_partida']]['total'] = $partida->cantidad_pendiente;
                            if (
                                $sumatorias[$row['id_partida']]['total'] >= $row['cantidad_asignada']
                                && is_numeric($row['cantidad_asignada'])
                                && $row['cantidad_asignada'] > 0
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
                                $error++;
                            }
                        } else {
                            $row['error'] = "No se permite asignar valores a una cotización que no existe";
                            $error++;
                        }
                        $this->resultData[] = $row;
                    }
                }
                if ($error > 0) {
                    throw new \Exception("hubo $error errores en el documento");
                }
                DB::connection('controlrec')->commit();
            }*/
        } catch (\Exception $e) {
            DB::connection('controlrec')->rollback();
            throw new \Exception($e->getMessage());
        }
        return true;
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
                $j = $this->cotizacionesLength + ($this->presupuestosLength - 1);
                $k = $this->cotizacionesLength;
                while ($j <= $maxCol) {
                    if (is_numeric($row[$k]) and !empty($row[$k])) {
                        $partidas[] = [
                            'id_partida' => $row[1],
                            'id_cotizacion' => $row[$k],
                            'cantidad_asignada' => $row[$k + ($this->presupuestosLength - 1)],
                        ];
                    }
                    $k += $this->presupuestosLength;
                    $j += $this->presupuestosLength;
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