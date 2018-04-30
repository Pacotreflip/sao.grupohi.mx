<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 20/04/2018
 * Time: 01:07 PM
 */

namespace Ghi\Domain\Core\Layouts\Compras;


use Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;

class AsignacionProveedoresLayout
{

    /**
     * @var Requisicion
     */
    protected $requisicion;


    /**
     * AsignacionProveedoresLayout constructor.
     * @param Requisicion $requisicion
     */
    public function __construct(Requisicion $requisicion)
    {
        $this->requisicion = $requisicion;
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
}