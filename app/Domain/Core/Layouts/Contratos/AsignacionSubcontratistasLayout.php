<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/04/2018
 * Time: 01:07 PM
 */

namespace Ghi\Domain\Core\Layouts\Contratos;

use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Layouts\ValidacionLayout;
use Ghi\Domain\Core\Models\Subcontratos\Asignaciones;
use Ghi\Domain\Core\Models\Subcontratos\PartidaAsignacion;
use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;
use Ghi\Domain\Core\Repositories\Subcontratos\EloquentAsignacionesRepository;
use Ghi\Domain\Core\Repositories\Subcontratos\EloquentPartidaAsignacionRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;

class AsignacionSubcontratistasLayout extends ValidacionLayout
{

    /**
     * @var ContratoProyectado
     */
    protected $contrato_proyectado;
    /**
     * @var array
     */
    protected $resultData = [];

    protected $headerFijos = [
        '' => "#",
        'id_partida' => "ID Partida",
        'descripcion' => "Descripción",
        'destino' => "Destino",
        'unidad' => "Unidad",
        'cantidad_solicitada' => "Cantidad Solicitada",
        'cantidad_autorizada' => "Cantidad Autorizada",
        'cantidad_pendiente_de_asignar' => "Cantidad Pendiente de Asignar",
    ];

    protected $headerDinamicos = [
        'id_presupuesto' => "ID Presupuesto",
        'fecha_de_presupuesto' => "Fecha de Presupuesto",
        'nombre_del_proveedor' => "Nombre del Proveedor",
        'precio_unitario_antes_descto.' => "Precio Unitario Antes Descto.",
        'precio_total_antes_descto.' => "Precio Total Antes Descto.",
        'descuento' => "% Descuento",
        'precio_unitario' => "Precio Unitario",
        'precio_total' => "Precio Total",
        'moneda' => "Moneda",
        'observaciones' => "Observaciones",
        'cantidad_asignada' => "Cantidad Asignada",
    ];

    /**
     * @var EloquentAsignacionesRepository
     */
    protected $asignacion;
    /**
     * @var EloquentPartidaAsignacionRepository
     */
    protected $partidaAsignacion;

    /**
     * AsignacionSubcontratistasLayout constructor.
     * @param ContratoProyectado $contrato_proyectado
     */
    public function __construct(ContratoProyectado $contrato_proyectado)
    {
        $this->lengthHeaderFijos = count($this->headerFijos);
        $this->lengthHeaderDinamicos = count($this->headerDinamicos);
        $this->contrato_proyectado = $contrato_proyectado;
        $this->asignacion = new EloquentAsignacionesRepository(new Asignaciones());
        $this->partidaAsignacion = new EloquentPartidaAsignacionRepository(new PartidaAsignacion());
    }

    public function setData(ContratoProyectado $contrato_proyectado)
    {
        $row = 0;
        $maxRow = 0;
        $arrayResult['totales'] = $contrato_proyectado->cotizacionesContrato->count();
        if ($arrayResult['totales'] > 0) {
            foreach ($contrato_proyectado->cotizacionesContrato as $key => $cotizacion) {
                foreach ($cotizacion->presupuestos->filter(function ($value) use ($contrato_proyectado) {
                    return $contrato_proyectado->contratos()->find($value->id_concepto)->cantidad_pendiente > 0;
                }) as $index => $presupuesto) {
                    $contrato = $contrato_proyectado->contratos()->find($presupuesto->id_concepto);
                    if (!isset($arrayResult['valores'][$contrato->id_concepto])) {
                        $arrayResult['valores'][$contrato->id_concepto] = [];
                        $arrayResult['valores'][$contrato->id_concepto]['contrato'] = $contrato;
                        $row++;
                        $maxRow = ($maxRow < $row) ? $row : $maxRow;
                    }
                    if ($presupuesto->no_cotizado == 0) {
                        $arrayResult['valores'][$contrato->id_concepto]['presupuesto'][$key] = $presupuesto;
                        $arrayResult['valores'][$contrato->id_concepto]['cotizacion'][$key] = $cotizacion;
                    } else {
                        $arrayResult['valores'][$contrato->id_concepto]['presupuesto'][$key] = [];
                        $arrayResult['valores'][$contrato->id_concepto]['cotizacion'][$key] = [];
                    }
                }
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
        return Excel::create('Asignación subcontratistas', function ($excel) use ($contrato_proyectado) {
            $excel->sheet('# ' . str_pad($contrato_proyectado->numero_folio, 5, '0', STR_PAD_LEFT), function (LaravelExcelWorksheet $sheet) use ($contrato_proyectado) {
                $arrayContratoProyectado = $this->setData($contrato_proyectado);
                $sheet->getProtection()->setSheet(true);
                $sheet->loadView('excel_layouts.asignacion_subcontratistas',
                    [
                        'contratoProyectados' => $arrayContratoProyectado,
                        'headerCotizaciones' => $this->headerFijos,
                        'headerPresupuestos' => $this->headerDinamicos,
                    ]);
                $sheet->setAutoSize(false);
                if ($arrayContratoProyectado['totales'] > 0) {
                    //$sheet->setAutoFilter('A1:S1');
                    $maxCol = ($arrayContratoProyectado['totales'] * $this->lengthHeaderDinamicos) + $this->lengthHeaderFijos;
                    $j = $this->lengthHeaderFijos + ($this->lengthHeaderDinamicos - 1);
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
                        $j += $this->lengthHeaderDinamicos;
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
     * @param array $asignaciones
     * @return bool
     * @throws \Exception
     */
    public function procesarDatos(array $asignaciones)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $error = 0;
            $sumatorias = [];
            if (count($asignaciones)) {
                foreach ($asignaciones as $id_transaccion => $rows) {
                    if (!empty(trim($id_transaccion))) {
                        //->Que las cotizaciones presentadas en el layout correspondan a los que están registrados en la base de datos  al momento de cargarlo	Listo
                        $cotizacion = $this->contrato_proyectado->cotizacionesContrato->find($id_transaccion);
                        if ($cotizacion) {
                            $dataAsignaciones['id_transaccion'] = $cotizacion->id_transaccion;
                            $asignacion = $this->asignacion->create($dataAsignaciones);
                            foreach ($rows as $row) {
                                $contrato = $this->contrato_proyectado->contratos()->find($row['id_concepto']);
                                if ($contrato->cantidad_pendiente > 0) {
                                    //->Que la cantidad pendiente de cada partida del layout sea igual a la cantidad pendiente que se calcule con información de la base de datos, para asi evitar duplicidad de información
                                    if(!isset($sumatorias[$row['id_concepto']]['pendiente'])){
                                        $sumatorias[$row['id_concepto']]['pendiente'] = $contrato->cantidad_pendiente;
                                    }
                                    if ($sumatorias[$row['id_concepto']]['pendiente'] == $row['cantidad_archivo']) {
                                        //->Que la cantidad a asignar sea menor o igual a la cantidad pendiente de cada partida
                                        if (
                                            $contrato->cantidad_pendiente >= $row['cantidad_asignada']
                                            && is_numeric($row['cantidad_asignada'])
                                            && $row['cantidad_asignada'] > 0
                                        ) {
                                            //save
                                            $data['id_concepto'] = $contrato->id_concepto;
                                            $data['id_transaccion'] = $contrato->id_transaccion;
                                            $data['id_asignacion'] = $asignacion->id_asignacion;
                                            $data['cantidad_asignada'] = $row['cantidad_asignada'];
                                            $data['cantidad_autorizada'] = $row['cantidad_asignada'];
                                            $newPartidaAsignacion = $this->partidaAsignacion->create($data);
                                            if (!$newPartidaAsignacion) {
                                                $row['error'] = "No se puede guardar el registro";
                                                $row['cantidad_pendiente'] = $contrato->cantidad_pendiente;
                                                $error++;
                                            } else {
                                                $row['error'] = "";
                                            }
                                        } else {
                                            $row['error'] = "Supera el número máximo asignado";
                                            $row['cantidad_pendiente'] = $contrato->cantidad_pendiente;
                                            $error++;
                                        }
                                    } else {
                                        $row['error'] = "La cantidad del archivo es diferente a la cantidad pendiente";
                                        $row['cantidad_pendiente'] = $contrato->cantidad_pendiente;
                                        $error++;
                                    }
                                } else {
                                    $row['error'] = "No se permite asignar valores a una cotización que no tiene cantidades pendeientes";
                                    $row['cantidad_pendiente'] = $contrato->cantidad_pendiente;
                                    $error++;
                                }
                                $this->resultData[$id_transaccion][] = $row;
                            } 
                        } else {
                            $this->resultData = $asignaciones;
                            throw new \Exception('No se puede guardar la cotizacion');
                        }
                    }
                }
                Log::error($error);
                if ($error > 0) {
                    throw new \Exception("hubo $error errores en el documento");
                }
                Log::debug($this->resultData);
                DB::connection('cadeco')->commit();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::connection('cadeco')->rollback();
            throw new \Exception($e->getMessage());
        }
        return true;
    }

    /**
     * @param Request $request
     */
    public function qetDataFile(Request $request)
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);
        Excel::load($request->file('file')->getRealPath(), function ($reader) {
            try {

                $results = $reader->all();
                $sheet = $reader->sheet($results->getTitle(), function (LaravelExcelWorksheet $sheet) {
                    $sheet->getProtection()->setSheet(false);
                });
                $folio = explode(' ',$results->getTitle());
                //->Validar que el Layout corresponda a la transacción
                if('# ' . str_pad($this->contrato_proyectado->numero_folio, 5, '0', STR_PAD_LEFT)!=$results->getTitle()){
                    throw new \Exception("No corresponde el layout al Contrato");
                }
                $headers = $results->getHeading();
                $layout = $this->setData($this->contrato_proyectado);
                //->Número y descripción de columnas
                if($this->validarHeader($headers,$layout)) {
                    $col = $sheet->toArray();
                    //->Que las partidas presentadas en el Layout sean las mismas que se encuentran en la base de datos al momento de cargarlo
                    if (count($col)!=($layout['maxRow']+$this->cabecerasLength))
                    {
                        throw new \Exception("No corresponde el numero de filas con las que contiene el layout");
                    }
                    $asignaciones = [];
                    for ($i = $this->cabecerasLength; $i < count($col); $i++) {
                        $row = $col[$i];
                        $maxCol = count($row);
                        $j = $this->lengthHeaderFijos + ($this->lengthHeaderDinamicos - 1);
                        $k = $this->lengthHeaderFijos;
                        while ($j <= $maxCol) {
                            if (is_numeric($row[$k]) and !empty($row[$k])) {
                                if ($row[$k + ($this->lengthHeaderDinamicos - 1)] > 0) {
                                    $asignaciones[$row[$k]][] = [
                                        'id_concepto' => $row[1],
                                        'id_transaccion' => $row[$k],
                                        'cantidad_archivo' => $row[($this->lengthHeaderFijos-1)],//->Que la cantidad pendiente de cada partida del layout sea igual a la cantidad pendiente que se calcule con información de la base de datos, para asi evitar duplicidad de información
                                        'cantidad_asignada' => $row[$k + ($this->lengthHeaderDinamicos - 1)],
                                    ];
                                }
                            }
                            $k += $this->lengthHeaderDinamicos;
                            $j += $this->lengthHeaderDinamicos;
                        }
                    }
                    if (count($asignaciones) > 0) {
                        $this->procesarDatos($asignaciones);
                    } else {
                        throw new \Exception("no hay elementos asignados");
                    }
                }
            } catch (\Exception $e) {
                Log::debug($e->getMessage());
                Log::debug($this->resultData);
                dd($e->getMessage());
            }
        });
    }


}