<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 18/10/2017
 * Time: 06:23 PM
 */

namespace Ghi\Domain\Core\Reportes\CostosDolares;

use Excel;
use Ghi\Domain\Core\Models\Moneda;

class CostosDolaresXLS
{
    protected $costos;
    protected $monedas;
    protected $letters;

    public function __construct($costos)
    {
        $this->costos = $costos;
        $this->monedas = Moneda::cambio()->get();
        $this->letters = array_combine(range(1,26), range('A', 'Z'));
    }
    function create() {
        Excel::create('Formato - Reporte Costos en Dolares', function($excell){

            $excell->sheet('Costos Dolares', function($sheet){

                // recupera los tipos de moneda autorizadas y genera los array()
                $num = $this->monedas->count();
                $tipos=array();
                $cambio=array();
                foreach ($this->monedas as $llave => $moneda){
                    $tipos[] = $moneda->nombre;
                    $cambio[] = $moneda->cambio;
                }

                // recuadro de Tipos Monedas Autorizadas
                $data = [];
                array_push($data, array('Tipos de Cambio Autorizados'));  //
                $sheet->setBorder('A1:B1', 'thin');
                $sheet->cells('A1:B1', function ($cells){
                    $cells->setBackground('#F5F5F5');

                });
                array_push($data, $tipos);  //
                $sheet->setBorder('A2:'. $this->letters[$num].'2', 'thin');
                $sheet->cells('A2:'. $this->letters[$num].'2', function ($cells){
                    $cells->setBackground('#A5A5A5');

                });
                array_push($data, $cambio);  //
                $sheet->setBorder('A3:'. $this->letters[$num].'3', 'thin');
                $sheet->cells('A3:'. $this->letters[$num].'3', function ($cells){
                    $cells->setBackground('#F5F5F5');

                });

                // Recuadro de transacciones de Moneda Extranjera
                array_push($data, array('Fecha de Póliza','Tipo de Cambio','Tipo de Moneda' ,'Cuenta Contable'  ,'Descripción','Importe Moneda Nacional','Costo Moneda Extranjera','Costo Moneda Extranjera Complementaria','Efecto Cambiario'  ,'Póliza ContPaq','Póliza SAO'));  //
                $sheet->setBorder('A4:K4', 'thin');
                $sheet->cells('A4:K4', function ($cells){
                    $cells->setBackground('#A5A5A5');

                });

                $linea = 5;
                foreach ($this->costos as $item){
                    array_push($data, array( $item->fecha_poliza, $item->tipo_cambio,$item->moneda, $item->cuenta_contable, $item->descripcion_concepto, number_format($item->importe,'2','.',','), number_format($item->costo_me,'2','.',','),number_format($item->costo_me_complementaria,'2','.',','),number_format($item->efecto_cambiario,'2','.',','), $item->tipo_poliza_contpaq.' No. '.$item->folio_contpaq, $item->tipo_poliza_sao.' No. '.$item->id_poliza ));
                    $sheet->setBorder('A'.$linea.':K'.$linea.'', 'thin');
                    $sheet->cells('A'.$linea.':K'.$linea.'', function ($cells){
                        $cells->setBackground('#F5F5F5');
                    });
                    $linea+=1;
                }
                $sheet->mergeCells('A1:B1');
                $sheet->fromArray($data, null, 'A1', false, false );
            });
        })->download('xlsx');
    }
}