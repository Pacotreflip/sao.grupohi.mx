<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/04/2018
 * Time: 01:07 PM
 */

namespace Ghi\Domain\Core\Layouts\Contratos;

use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;

class AsignacionSubcontratistasLayout
{

    /**
     * @var ContratoProyectado
     */
    protected $contrato_proyectado;

    /**
     * AsignacionSubcontratistasLayout constructor.
     * @param ContratoProyectado $contrato_proyectado
     */
    public function __construct(ContratoProyectado $contrato_proyectado)
    {
        $this->contrato_proyectado = $contrato_proyectado;
    }

    public function getFile()
    {
        $contrato_proyectado = $this->contrato_proyectado;

        return Excel::create('Asignación Proveedores', function ($excel) use ($contrato_proyectado) {
            $excel->sheet('# ' . str_pad($contrato_proyectado->numero_folio, 5,'0', STR_PAD_LEFT), function (LaravelExcelWorksheet $sheet) use ($contrato_proyectado) {
                $sheet->loadView('excel_layouts.asignacion_subcontratistas', ['contrato_proyectado' => $contrato_proyectado]);
                $sheet->setAutoSize(false);
                $sheet->setAutoFilter('A1:S1');
            });
        });
    }
}