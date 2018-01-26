<?php
/**
 * Created by PhpStorm.
 * User: mirah
 * Date: 24/01/2018
 * Time: 12:40 PM
 */

namespace Ghi\Domain\Core\Reportes\ControlPresupuesto;

use Carbon\Carbon;
use Ghi\Core\Facades\Context;

use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghidev\Fpdf\Rotation;
use Ghi\Domain\Core\Models\Obra;

class PDFSolicitudCambio extends Rotation {

    var $encola = '';

    const DPI = 96;
    const MM_IN_INCH = 25.4;
    const A4_HEIGHT = 297;
    const A4_WIDTH = 210;

    const MAX_WIDTH = 225;
    const MAX_HEIGHT = 100;
    /**
     * @var SolicitudReclasificacion
     */
    private $solicitud;
    protected $obra;

    /**
     * Solicitudes constructor.
     * @param SolicitudCambioRepository $solicitud
     */
    public function __construct(SolicitudCambio $solicitud)
    {
        parent::__construct('L', 'cm', 'A4');

        $this->SetAutoPageBreak(true,4.5);
        $this->WidthTotal = $this->GetPageWidth() - 2;
        $this->txtTitleTam = 18;
        $this->txtSubtitleTam = 13;
        $this->txtSeccionTam = 9;
        $this->txtContenidoTam = 7;
        $this->txtFooterTam = 6;
        $this->solicitud = $solicitud;

        $this->obra = Obra::find(Context::getId());
    }

    function Header() {

        $this->titulos();
        $this->logo();

        //Obtener Posiciones despues de los títulos
        $y_inicial = $this->getY();
        $x_inicial = $this->getX();
        $this->setY($y_inicial);
        $this->setX($x_inicial);

        //Tabla Detalles de la Asignación
        $this->detallesAsignacion();

        //Posiciones despues de la primera tabla
        $y_final = $this->getY();
        $this->setY($y_inicial);

        $alto = abs($y_final - $y_inicial);

        //Redondear Bordes Detalles Asignacion
        $this->SetWidths(array(0.5 * $this->WidthTotal));

        $this->SetFills(array('255,255,255'));
        $this->SetTextColors(array('0,0,0'));
        $this->SetHeights(array($alto));
        $this->SetStyles(array('DF'));
        $this->SetAligns("L");
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->setY($y_inicial);
        $this->Row(array(""));



        $this->setY($y_inicial);
        $this->setX(0.35 * $this->WidthTotal + 0.5);

        //Tabla Detalles de la Asignacion
        $this->setY($y_inicial);
        $this->setX($x_inicial);
        $this->detallesAsignacion();

        //Obtener Y despues de la tabla
        $this->setY($y_final);
        $this->Ln(1.5);

        if($this->encola == 'partidas') {

            $this->SetWidths(array(0.025 * $this->WidthTotal, 0.065 * $this->WidthTotal, 0.475 * $this->WidthTotal, 0.035 * $this->WidthTotal, 0.1 * $this->WidthTotal, 0.1 * $this->WidthTotal, 0.1 * $this->WidthTotal, 0.1 * $this->WidthTotal));
            $this->SetFont('Arial', '', 6);
            $this->SetStyles(array('DF', 'DF', 'DF', 'FD', 'DF', 'DF', 'DF', 'DF'));
//            $this->SetWidths(array(0.04 * $this->WidthTotal, 0.07 * $this->WidthTotal, 0.56 * $this->WidthTotal, 0.12 * $this->WidthTotal, 0.12 * $this->WidthTotal, 0.09 * $this->WidthTotal));
            $this->SetFills(array('180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.3));
            $this->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
            $this->Row(array('#', 'No.Tarjeta', utf8_decode("Descripción"), "Unidad", "Cantidad Original", "Cantidad Nueva", "Monto Original", "Monto Nuevo" ));

            $this->SetFont('Arial', '', 6);
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('R', 'R', 'L', 'L', 'R', 'R', 'L', 'L'));
            $this->SetWidths(array(0.025 * $this->WidthTotal, 0.065 * $this->WidthTotal, 0.475 * $this->WidthTotal, 0.035 * $this->WidthTotal, 0.1 * $this->WidthTotal, 0.1 * $this->WidthTotal, 0.1 * $this->WidthTotal, 0.1 * $this->WidthTotal));
        }
    }

    function titulos (){

        // Título
        $this->SetFont('Arial', 'B', $this->txtTitleTam - 3);
        $this->CellFitScale(0.6 * $this->WidthTotal, 1.5, utf8_decode('SOLICITUD DE CAMBIO'), 0, 1, 'L', 0);

        $this->SetFont('Arial', '', $this->txtSubtitleTam -1);
//        $this->CellFitScale(0.6 * $this->WidthTotal, 0.35, utf8_decode(''), 0, 1, 'L', 0);
        $this->Line(1, $this->GetY() + 0.2, $this->WidthTotal + 1, $this->GetY() + 0.2);
        $this->Ln(0.5);

        //Detalles de la Asignación (Titulo)
        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->Cell(0.5 * $this->WidthTotal, 0.7, utf8_decode('Detalles de la Solicitud'), 0, 0, 'L');

        $this->Cell(0.5);
        $this->Cell(0.5 * $this->WidthTotal, .7, '', 0, 1, 'L');

    }

    function detallesAsignacion(){
// #	número de tarjeta	Descripción	unidad	cantidad cantidad 2  monto | monto 2

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Número de Folio'), '', 0, 'LB');
        $this->SetFont('Arial', '', '#'.$this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->numero_folio), '', 1, 'L');
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Fecha Solicitud:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.5, utf8_decode(Carbon::parse($this->solicitud->fecha_solicitud)->format('Y-m-d h:m A')), '', 1, 'L');
        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Solicita: '), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->userRegistro), '', 1, 'L');
        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Tipo de solicitud'), '', 0, 'LB');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->tipoOrden->descripcion), '', 1, 'L');
    }

    function items($items, $partida){
        $this->SetWidths(array(0));
        $this->SetFills(array('255,255,255'));
        $this->SetTextColors(array('1,1,1'));
        $this->SetHeights(array(0));
        $this->Row(Array(''));
        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->SetTextColors(array('255,255,255'));
        $this->MultiCell($this->WidthTotal, .35, utf8_decode($partida->concepto), 0, 'L');

        $this->SetFont('Arial', '', 6);
        $this->SetStyles(array('DF', 'DF', 'DF', 'FD', 'DF', 'DF', 'DF', 'DF'));
        $this->SetFills(array('180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180'));
        $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
        $this->SetHeights(array(0.3));
        $this->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
        $this->SetWidths(array(0.025 * $this->WidthTotal, 0.065 * $this->WidthTotal, 0.475 * $this->WidthTotal, 0.035 * $this->WidthTotal, 0.1 * $this->WidthTotal, 0.1 * $this->WidthTotal, 0.1 * $this->WidthTotal, 0.1 * $this->WidthTotal));
        $this->Row(array('#', 'No.Tarjeta', utf8_decode("Descripción"), "Unidad", "Cantidad Original", "Cantidad Nueva", "Monto Original", "Monto Nuevo" ));

        foreach ($items as $index => $item) {
            $this->SetFont('Arial', '', 6);
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('R', 'R', 'L', 'L', 'R', 'R', 'L', 'L'));
            $this->SetWidths(array(0.025 * $this->WidthTotal, 0.065 * $this->WidthTotal, 0.475 * $this->WidthTotal, 0.035 * $this->WidthTotal, 0.1 * $this->WidthTotal, 0.1 * $this->WidthTotal, 0.1 * $this->WidthTotal, 0.1 * $this->WidthTotal));

            $nivel_padre = $partida->concepto->nivel;
            $nivel_hijo = $item->nivel;
            $profundidad =( strlen($nivel_hijo) - strlen($nivel_padre) )/ 4;
            $factor = $partida->cantidad_presupuestada_nueva / $partida->concepto->cantidad_presupuestada;
            $cantidad_nueva = $item->cantidad_presupuestada * $factor;
            $monto_nuevo = $item->monto_presupuestado * $factor;

            $this->encola = 'partidas';

            $this->Row([
                $index + 1, // #
                $item->numero_tarjeta,
                str_repeat("--", $profundidad).' '.utf8_decode($item->descripcion), // Descripción concepto
                utf8_decode($item->unidad),
                number_format($item->cantidad_presupuestada, 2, '.', ','), // Cantidad original
                number_format($cantidad_nueva, 2, '.', ','), // Cantidad original
                '$'.number_format($item->monto_presupuestado, 2, '.', ','),
                '$'.number_format($monto_nuevo, 2, '.', ','),
            ]);
        }
        $this->encola = '';
    }
    function motivo(){

        $this->encola = "";

        // hardcode
        if(true){
            if($this->GetY() > $this->GetPageHeight() - 5){
                $this->AddPage();
            }
            $this->SetWidths(array($this->WidthTotal));
            $this->SetFills(array('180,180,180'));
            $this->SetTextColors(array('0,0,0'));
            $this->SetHeights(array(0.3));
            $this->SetFont('Arial', '', 6);
            $this->SetAligns(array('C'));
            $this->Row(array("Motivo"));
            $this->SetAligns(array('J'));
            $this->SetStyles(array('DF'));
            $this->SetFills(array('255,255,255'));
            $this->SetTextColors(array('0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetFont('Arial', '', 6);
            $this->SetWidths(array($this->WidthTotal));
            $this->Row(array(utf8_decode($this->solicitud->motivo)));
        }
    }


    function logo() {
        $data = $this->obra->logotipo;
        $data = pack('H*', $data);
        $file = public_path('img/logo_temp.png');
        if (file_put_contents($file, $data) !== false) {
            $this->image(public_path('img/logo_hc.png'), $this->WidthTotal - 1.3, 0.5, 2.33, 1.5);
            unlink($file);
        }
    }

    function firmas(){
        $this->SetY(-4);
        $this->SetFont('Arial', '', 6);
        $this->SetFillColor(180, 180, 180);

        $this->Cell(($this->GetPageWidth() - 4) / 2, 0.4, utf8_decode('firma 1'), 'TRLB', 0, 'C', 1);
        $this->Cell(2);
        $this->Cell(($this->GetPageWidth() - 4) / 2, 0.4, utf8_decode('firma 2'), 'TRLB', 1, 'C', 1);

        $this->Cell(($this->GetPageWidth() - 4) / 2, 1.2, '', 'TRLB', 0, 'C');
        $this->Cell(2);
        $this->Cell(($this->GetPageWidth() - 4) / 2, 1.2, '', 'TRLB', 1, 'C');

        $this->Cell(($this->GetPageWidth() - 4) / 2, 0.4, utf8_decode('nombre 1'), 'TRLB', 0, 'C', 1);
        $this->Cell(2);
        $this->Cell(($this->GetPageWidth() - 4) / 2, 0.4, utf8_decode('nombre 2'), 'TRLB', 0, 'C', 1);
    }

    function Footer() {
        $this->firmas();
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->SetY($this->GetPageHeight() - 1);
        $this->SetFont('Arial', '', $this->txtFooterTam);
        $this->Cell(6.5, .4, utf8_decode('Fecha de Consulta: ' . date('Y-m-d g:i a')), 0, 0, 'L');
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->Cell(6.5, .4, '', 0, 0, 'C');
        $this->Cell(6.5, .4, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
        $this->SetY($this->GetPageHeight() - 1.3);
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->Cell(6.5, .4, utf8_decode('Formato generado desde '), 0, 0, 'L');
    }

    function create() {
        $this->SetMargins(1, 0.5, 1);
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetAutoPageBreak(true,4);
        foreach ($this->solicitud->partidas as $partida) {
            if($this->y > 13.5) {
                $this->AddPage();

            }
            $this->items(Concepto::orderBy('nivel', 'ASC')->where('nivel', 'like', $partida->concepto->nivel.'%')->get(), $partida);
            $this->Ln(1);
        }
        $this->Ln();
        $this->motivo();
        try {
            $this->Output('I', 'Solicitud de cambio #'. $this->solicitud->numero_folio .'.pdf', 1);
        } catch (\Exception $ex) {
            dd($ex);
        }
        exit;
    }
}