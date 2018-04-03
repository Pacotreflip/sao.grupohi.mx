<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 18/10/2017
 * Time: 06:23 PM
 */

namespace Ghi\Domain\Core\Reportes\CostosDolares;

use Excel;

class CostosDolaresXLS
{
    protected $costos;

    public function __construct($costos)
    {
        $this->costos = $costos;
    }
    function create() {
        Excel::create('Formato - Reporte Costos en Dolares', function($excell){
            $excell->sheet('Costos Dolares', function($sheet){
                $data = [];
                array_push($data, array('Id PrePóliza','Folio Contpaq','Fecha de Póliza','Tipo de Cambio','Cuenta Contable'  ,'Descripción','Importe Moneda Nacional','Costo Moneda Extranjera','Costo Moneda Extranjera Complementaria','Póliza ContPaq','Póliza SAO'));  //
                $sheet->setBorder('A1:K1', 'thin');
                $sheet->cells('A1:K1', function ($cells){
                    $cells->setBackground('#A5A5A5');
                });
                $linea = 2;
                foreach ($this->costos as $item){
                    array_push($data, array($item->id_poliza, $item->folio_contpaq, $item->fecha_poliza, $item->tipo_cambio, $item->cuenta_contable, $item->descripcion_concepto, number_format($item->importe,'2','.',','), number_format($item->costo_me,'2','.',','),number_format($item->costo_me_complementaria,'2','.',','), $item->tipo_poliza_contpaq.' No. '.$item->folio_contpaq, $item->tipo_poliza_sao.' No. '.$item->id_poliza ));
                    $sheet->setBorder('A'.$linea.':K'.$linea.'', 'thin');
                    $sheet->cells('A'.$linea.':K'.$linea.'', function ($cells){
                        $cells->setBackground('#F5F5F5');
                    });
                    $linea+=1;
                }

                $sheet->fromArray($data, null, 'A1', false, false );
            });
        })->download('xlsx');
    }
}