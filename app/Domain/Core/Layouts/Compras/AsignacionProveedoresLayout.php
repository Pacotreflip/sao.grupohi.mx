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
    protected $header = [0 => 0,
        1 => "id_partida",
        2 => "descripcion",
        3 => "unidad",
        4 => "cantidad_solicitada",
        5 => "cantidad_autorizada",
        6 => "cantidad_asignada_previamente",
        7 => "cantidad_pendiente_de_asignar",
        8 => "id_cotizacion",
        9 => "fecha_de_cotizacion",
        10 => "nombre_del_proveedor",
        11 => "sucursal",
        12 => "direccion",
        13 => "precio_unitario",
        14 => "descuento",
        15 => "precio_total",
        16 => "moneda",
        17 => "observaciones",
        18 => "cantidad_asignada"
    ];


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
    }

    public function getFile()
    {
        $requisicion = $this->requisicion;

        return Excel::create('Asignación Proveedores', function ($excel) use ($requisicion) {
            $excel->sheet('# ' . str_pad($requisicion->numero_folio, 5,'0', STR_PAD_LEFT), function (LaravelExcelWorksheet $sheet) use ($requisicion) {
                $sheet->loadView('excel_layouts.asignacion_proveedores', ['requisicion' => $requisicion]);
                $sheet->setAutoSize(false);
                $sheet->setAutoFilter('A1:R1');
            });
        });
    }

    public function setData(Request $request)
    {
        $arrayErros['errors'] = [];
        Excel::load($request->file('file')->getRealPath(), function ($reader) use (&$arrayErros) {
            $headerRow = $reader->first()->keys()->toArray();

            $resultado = array_diff($this->header, $headerRow);
            if (count($resultado) > 0) {
                throw new StoreResourceFailedException('Error al procesar el archivo', $resultado);
            }
            $results = $reader->all();
            $folio_sao = explode(" ",$results->getTitle());
            $RQCTOCSolicitud = $this->requisicion->rqctocSolicitud()->where('folio_sao',$folio_sao[1])->first();
            $data['idrqctoc_solicitudes'] = $RQCTOCSolicitud->idrqctoc_solicitudes;
            $data['idserie'] = $RQCTOCSolicitud->id_serie;
            $tablaComparativa = $this->RQCTOCTablaComparativa->create($data);
            if(!$tablaComparativa){
                throw new StoreResourceFailedException('No se puede guardar la comparación', $tablaComparativa);
            }
            $results = $reader->all();
            if (count($results)) {
                $sumatorias = [];
                foreach ($reader->get() as $row) {
                    //dd($row);
                    Log::debug($row->id_partida);
                    if(!empty(trim($row->id_partida)))
                    {
                        $partida = $this->requisicion->rqctocSolicitud->rqctocSolicitudPartidas()->find($row->id_partida)->first();
                        Log::error($partida->cantidad_pendiente);
                        if (!isset($sumatorias[$row->id_partida])) {
                            if (empty($sumatorias[$row->id_partida]['total'])) {
                                $sumatorias[$row->id_partida]['total'] = $partida->cantidad_pendiente;
                            }
                        }
                        Log::debug($sumatorias[$row->id_partida]['total'] . ">=" . $row->cantidad_asignada);
                        Log::debug($sumatorias[$row->id_partida]['total'] >= $row->cantidad_asignada);
                        if ($sumatorias[$row->id_partida]['total'] >= $row->cantidad_asignada && is_numeric($row->cantidad_asignada)) {
                            //save
                            try {
                                DB::connection('controlrec')->beginTransaction();
                                //print $row->cantidad_pendiente_de_asignar."\n";
                                $dataRQCTOCTablaComparativaPartida['idrqctoc_tabla_comparativa'] = $tablaComparativa->idrqctoc_tabla_comparativa;
                                $dataRQCTOCTablaComparativaPartida['idrqctoc_solicitudes_partidas'] = $row->id_partida;
                                $dataRQCTOCTablaComparativaPartida['idrqctoc_cotizaciones_partidas'] = $row->id_cotizacion;
                                $dataRQCTOCTablaComparativaPartida['cantidad_asignada'] = $row->cantidad_asignada;
                                /*$dataRQCTOCTablaComparativaPartida['cantidad_autorizada'] = $row->cantidad_asignada;
                                $dataRQCTOCTablaComparativaPartida['autorizo'] = auth()->user()->id;*/
                                $newRQCTOCTablaComparativaPartida = $this->RQCTOCTablaComparativaPartida->create($dataRQCTOCTablaComparativaPartida);
                                Log::debug($newRQCTOCTablaComparativaPartida);
                                if (!$newRQCTOCTablaComparativaPartida) {
                                    DB::connection('controlrec')->rollback();
                                    $arrayErros['errors'][$row->id_partida] = (array)$row->toArray();
                                } else {
                                    DB::connection('controlrec')->commit();
                                    $sumatorias[$row->id_partida]['total'] += $row->cantidad_asignada;
                                }
                            } catch (\ErrorException $e) {
                                DB::connection('controlrec')->rollback();
                                $arrayErros['errors'][$row->id_partida] = (array)$row->toArray();
                            }
                        } else {
                            $arrayErros['errors'][$row->id_partida] = (array)$row->toArray();
                        }
                    }
                }
            }
        });
        Log::error($arrayErros);
        return $arrayErros;
    }
}