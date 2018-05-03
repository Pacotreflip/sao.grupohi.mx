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
    protected $resultData = [];
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
        $this->resultData = [];
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        $requisicion = $this->requisicion;

        return Excel::create('Asignación Proveedores', function ($excel) use ($requisicion) {
            $excel->sheet('# ' . str_pad($requisicion->numero_folio, 5, '0', STR_PAD_LEFT), function (LaravelExcelWorksheet $sheet) use ($requisicion) {
                $sheet->loadView('excel_layouts.asignacion_proveedores', ['requisicion' => $requisicion]);
                $sheet->setAutoSize(false);
                $sheet->setAutoFilter('A1:R1');
            });
        });
    }

    public function validateHeaders($headers)
    {
        $resultado = array_diff($this->header, $headers);
        if (count($resultado) > 0) {
            throw new \Exception('Las cabeceras no coinciden');
        }
        return true;
    }

    /**
     * @param $folio_sao
     * @param array $data
     * @return bool
     * @throws \Exception
     *
     */
    public function procesarDatos($folio_sao, array $data)
    {
        try {
            if (empty($folio_sao)) {
                $this->resultData = $data;
                throw new \Exception('No se puede guardar la comparación');
            }
            DB::connection('controlrec')->beginTransaction();
            $RQCTOCSolicitud = $this->requisicion->rqctocSolicitud()->where('folio_sao', $folio_sao)->first();
            $data['idrqctoc_solicitudes'] = $RQCTOCSolicitud->idrqctoc_solicitudes;
            $data['idserie'] = $RQCTOCSolicitud->id_serie;
            $tablaComparativa = $this->RQCTOCTablaComparativa->create($data);
            if (!$tablaComparativa) {
                $this->resultData = $data;
                throw new \Exception('No se puede guardar la comparación');
            }
            $error = 0;
            if (count($data)) {
                $sumatorias = [];
                foreach ($data as $index => $row) {
                    if (!empty(trim($row['id_partida']))) {
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
                        $this->resultData[] = $row;
                    }
                }
                if ($error > 0) {
                    throw new \Exception("hubo $error errores en el documento");
                }
                DB::connection('controlrec')->commit();
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            DB::connection('controlrec')->rollback();
        }
        return true;
    }

    public function qetDataFile(Request $request)
    {
        Excel::load($request->file('file')->getRealPath(), function ($reader) {

        });
    }
}