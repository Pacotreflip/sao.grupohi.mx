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
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\BasePresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
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
        parent::__construct('P', 'cm', 'A4');

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

    function cabecera() {

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
        $this->SetRounds(array('1234'));
        $this->SetRadius(array(0.2));
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
        $this->Ln(0.5);


    }

    function titulos (){

        // Título
        $this->SetFont('Arial', 'B', $this->txtTitleTam - 3);
        $this->CellFitScale(0.6 * $this->WidthTotal, 1.5, utf8_decode('Título'), 0, 1, 'L', 0);

        $this->SetFont('Arial', '', $this->txtSubtitleTam -1);
        $this->CellFitScale(0.6 * $this->WidthTotal, 0.35, utf8_decode('Folio - #'. $this->solicitud->id), 0, 1, 'L', 0);
        $this->Line(1, $this->GetY() + 0.2, $this->WidthTotal + 1, $this->GetY() + 0.2);
        $this->Ln(0.5);

        //Detalles de la Asignación (Titulo)
        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->Cell(0.5 * $this->WidthTotal, 0.7, utf8_decode('Detalles de la Solicitud'), 0, 0, 'L');

        $this->Cell(0.5);
        $this->Cell(0.5 * $this->WidthTotal, .7, '', 0, 1, 'L');

    }

    function detallesAsignacion(){

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->Cell(0.15 * $this->WidthTotal, 0.5, utf8_decode('Fecha Asignación:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.4 * $this->WidthTotal, 0.5, utf8_decode(Carbon::parse($this->solicitud->fecha_solicitud)->format('Y-m-d h:m A')), '', 1, 'L');
        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->Cell(0.15 * $this->WidthTotal, 0.5, utf8_decode('Elaborado por: '), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.4 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->userRegistro), '', 1, 'L');
        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->Cell(0.15 * $this->WidthTotal, 0.5, utf8_decode(''), '', 0, 'LB');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.4 * $this->WidthTotal, 0.5, '', '', 1, 'L');
    }

    function referencias($x_inicial){

        $this->setX($x_inicial + 0.55 * $this->WidthTotal + 0.5);
        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->Cell(0.12 * $this->WidthTotal, 0.5, utf8_decode('No. de Recepción:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.225 * $this->WidthTotal, 0.5, utf8_decode('# ' . $this->asignacion->recepcion->numero_folio), '', 1, 'L');
    }

    function items(){

        $this->SetWidths(array(0));
        $this->SetFills(array('255,255,255'));
        $this->SetTextColors(array('1,1,1'));
        $this->SetRounds(array('0'));
        $this->SetRadius(array(0));
        $this->SetHeights(array(0));
        $this->Row(Array(''));
        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->SetTextColors(array('255,255,255'));
        $this->CellFitScale($this->WidthTotal, 1, utf8_decode('PARTIDAS'), 0, 1, 'L');

        $this->SetWidths(array(0.04 * $this->WidthTotal, 0.08 * $this->WidthTotal, 0.56 * $this->WidthTotal, 0.16 * $this->WidthTotal, 0.16 * $this->WidthTotal));
        $this->SetFont('Arial', '', 6);
        $this->SetStyles(array('DF', 'DF', 'DF', 'FD', 'DF'));
        $this->SetWidths(array(0.04 * $this->WidthTotal, 0.08 * $this->WidthTotal, 0.56 * $this->WidthTotal, 0.16 * $this->WidthTotal, 0.16 * $this->WidthTotal));
        $this->SetRounds(array('1', '', '', '', '2'));
        $this->SetRadius(array(0.2, 0, 0, 0, 0.2));
        $this->SetFills(array('180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180'));
        $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
        $this->SetHeights(array(0.3));
        $this->SetAligns(array('C', 'C', 'C', 'C', 'C'));
        $this->Row(array('#', 'No. Parte', utf8_decode("Descripción"), "Unidad", "Cantidad Asignada"));

        // hardcode
        $this->SetFont('Arial', '', 6);
        $this->SetWidths(array(0.04 * $this->WidthTotal, 0.08 * $this->WidthTotal, 0.56 * $this->WidthTotal, 0.16 * $this->WidthTotal, 0.16 * $this->WidthTotal));
        $this->SetRounds(array('', '', '', '', ''));
        $this->SetRadius(array(0, 0, 0, 0, 0));
        $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
        $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
        $this->SetHeights(array(0.35));
        $this->SetAligns(array('L', 'L', 'L', 'L', 'L'));

        $this->SetWidths(array(0.04 * $this->WidthTotal, 0.08 * $this->WidthTotal, 0.56 * $this->WidthTotal, 0.16 * $this->WidthTotal, 0.16 * $this->WidthTotal));

        $this->Row(array(1, utf8_decode('numero_parte'), utf8_decode('descripcion'), utf8_decode('unidad'), 666));


    }


    function motivo(){

        $this->encola = "";

        // hardcode
        if(true){
            if($this->GetY() > $this->GetPageHeight() - 5){
                $this->AddPage();
            }
            $this->SetWidths(array($this->WidthTotal));
            $this->SetRounds(array('12'));
            $this->SetRadius(array(0.2));
            $this->SetFills(array('180,180,180'));
            $this->SetTextColors(array('0,0,0'));
            $this->SetHeights(array(0.3));
            $this->SetFont('Arial', '', 6);
            $this->SetAligns(array('C'));
            $this->Row(array("Motivo"));
            $this->SetRounds(array('34'));
            $this->SetRadius(array(0.2));
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

    function logo(){
        $this->image(public_path('img/logo_hc.png'), $this->WidthTotal - 1.3, 0.5, 2.33, 1.5);
    }

    function firma(){
        $this->SetY(-4);
        $this->SetFont('Arial', '', 6);
        $this->SetFillColor(180, 180, 180);

        $this->SetX(-1-0.25 * $this->GetPageWidth());
        $this->Cell(0.25 * $this->GetPageWidth(), 0.4, utf8_decode('ASIGNA'), 'TRLB', 1, 'C', 1);
        $this->SetX(-1-0.25 * $this->GetPageWidth());
        $this->Cell(0.25 * $this->GetPageWidth(), 1.5, '', 'RLB', 1, 'C');
        $this->SetX(-1-0.25 * $this->GetPageWidth());
        $this->CellFitScale(0.25 * $this->GetPageWidth(), 0.4, utf8_decode('nombreCompleto'), 'TRLB', 1, 'C', 1);
    }

    function Footer() {
        $this->firma();
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->SetY($this->GetPageHeight() - 1);
        $this->SetFont('Arial', '', $this->txtFooterTam);
        $this->Cell(6.5, .4, utf8_decode('Fecha de Consulta: ' . date('Y-m-d g:i a')), 0, 0, 'L');
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->Cell(6.5, .4, '', 0, 0, 'C');
        $this->Cell(6.5, .4, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
        $this->SetY($this->GetPageHeight() - 1.3);
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->Cell(6.5, .4, utf8_decode('Formato generado desde el módulo de Control de Equipamiento.'), 0, 0, 'L');
    }

    function create() {
        $this->SetMargins(1, 0.5, 1);
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetAutoPageBreak(true,3.75);
        $this->cabecera();
        $this->items();
        $this->Ln();
        $this->motivo();
        try {
            $this->Output('I', 'pdf.pdf', 1);
        } catch (\Exception $ex) {
            dd($ex);
        }
        exit;
    }
}