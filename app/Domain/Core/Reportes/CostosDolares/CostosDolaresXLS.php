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
                //$tipos[] = '';
                $tipos[] = 'Reporte de Costo en Moneda Extranjera y Efecto Cambiario';
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
                /*array_push($data);  //*/
                $sheet->setBorder($this->letters[$num + 1].'2:'. $this->letters[$num + 2].'2', 'thin');
                $sheet->cells($this->letters[$num + 1].'2:'. $this->letters[$num + 2].'2', function ($cells){
                    $cells->setBackground('#F5F5F5');

                });
                array_push($data, $cambio);  //
                $sheet->setBorder('A3:'. $this->letters[$num].'3', 'thin');
                $sheet->cells('A3:'. $this->letters[$num].'3', function ($cells){
                    $cells->setBackground('#F5F5F5');

                });

                // Recuadro de transacciones de Moneda Extranjera
                array_push($data, array('Fecha de Póliza','Tipo de Cambio','Tipo de Moneda' ,'Cuenta Contable'  ,'Descripción','Importe Moneda Nacional Tipo Cambio Real','Costo Moneda Extranjera','Costo Moneda Extranjera Complementaria','Importe Moneda Nacional Tipo Cambio Autorizado','Efecto Cambiario'  ,'Póliza ContPaq','Póliza SAO'));  //
                $sheet->setBorder('A4:L4', 'thin');
                $sheet->cells('A4:L4', function ($cells){
                    $cells->setBackground('#A5A5A5');

                });

                $linea = 5;
                $total_mn_real = 0;
                $total_mn_aut = 0;
                $total_costo_me = 0;
                $total_costo_me_comp = 0;
                $total_efecto_camb = 0;
                foreach ($this->costos as $item){
                    $total_mn_real += $item->importe;
                    $total_mn_aut += $item->costo_me * $item->cambio;
                    $total_costo_me += $item->costo_me;
                    $total_costo_me_comp += $item->costo_me_complementaria;
                    $total_efecto_camb += $item->efecto_cambiario;
                    array_push($data, array( $item->fecha_poliza, $item->tipo_cambio,$item->moneda, $item->cuenta_contable, $item->descripcion_concepto, number_format($item->importe,'2','.',','), number_format($item->costo_me,'2','.',','),number_format($item->costo_me_complementaria,'2','.',','), number_format($item->costo_me * $item->cambio,'2','.',',') , number_format($item->efecto_cambiario,'2','.',','), $item->tipo_poliza_contpaq.' No. '.$item->folio_contpaq, $item->tipo_poliza_sao.' No. '.$item->id_poliza ));
                    $sheet->setBorder('A'.$linea.':L'.$linea.'', 'thin');
                    $sheet->cells('A'.$linea.':L'.$linea.'', function ($cells){
                        $cells->setBackground('#F5F5F5');
                    });
                    $linea+=1;
                }
                // Agrega linea final con los totales
                array_push($data, array('','','','','Totales: ',number_format($total_mn_real,'2','.',','),number_format($total_costo_me,'2','.',','),number_format($total_costo_me_comp,'2','.',','),number_format($total_mn_aut,'2','.',','),number_format($total_efecto_camb,'2','.',',') ,'',''));  //
                $sheet->setBorder('A'.$linea.':L'.$linea.'', 'thin');
                $sheet->cells('A'.$linea.':L'.$linea.'', function ($cells){
                    $cells->setBackground('#A5A5A5');

                });
                $sheet->mergeCells('A1:B1');
                $sheet->mergeCells($this->letters[$num + 1].'2:'. $this->letters[$num + 3].'2');
                $sheet->fromArray($data, null, 'A1', false, false );
            });
        })->download('xlsx');
    }
}