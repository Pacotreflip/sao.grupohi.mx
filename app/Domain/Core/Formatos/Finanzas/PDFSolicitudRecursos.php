<?php
/**
 * Created by PhpStorm.
 * User: mirah
 * Date: 24/01/2018
 * Time: 12:40 PM
 */

namespace Ghi\Domain\Core\Formatos\Finanzas;


use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Finanzas\SolicitudRecursos;
use Ghi\Domain\Core\Models\Obra;
use Ghidev\Fpdf\Rotation;

class PDFSolicitudRecursos extends Rotation
{

    var $encola = '';

    const DPI = 96;
    const MM_IN_INCH = 25.4;
    const A4_HEIGHT = 297;
    const A4_WIDTH = 210;

    const MAX_WIDTH = 225;
    const MAX_HEIGHT = 100;

    const TAMANO_CONTENIDO = 6;
    const TAMANO_TITULO = 12;
    const TAMANO_SUBTITULO = 9;

    /**
     * @var SolicitudRecursos
     */
    private $solicitud;
    private $obra;

    private $WidthTotal;

    /**
     * @var array
     */
    private $grupos;

    public function __construct(SolicitudRecursos $solicitud)
    {
        parent::__construct('L', 'cm', 'A4');

        $this->SetAutoPageBreak(true, 5);
        $this->WidthTotal = $this->GetPageWidth() - 2;
        $this->txtTitleTam = 18;
        $this->txtSubtitleTam = 13;
        $this->txtSeccionTam = 9;
        $this->txtContenidoTam = 7;
        $this->txtFooterTam = 6;
        $this->solicitud = $solicitud;

        $this->obra = Obra::find(Context::getId());
        $this->grupos = $solicitud->partidas->groupBy('transaccion.id_rubro');
     }

    function Header()
    {

        $this->encabezados();
        if ($this->encola == 'partidas') {
            $this->SetFont('Arial', '', 6);
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'R', 'L', 'R', 'R'));
            $this->SetWidths(array(0.078 * $this->WidthTotal, 0.125 * $this->WidthTotal, 0.203 * $this->WidthTotal, 0.104 * $this->WidthTotal, 0.063 * $this->WidthTotal, 0.078 * $this->WidthTotal, 0.086 * $this->WidthTotal, 0.07 * $this->WidthTotal, 0.062 * $this->WidthTotal, 0.048 * $this->WidthTotal, 0.083 * $this->WidthTotal));
        }
    }

    protected function encabezados() {
        $this->logo();
        $this->SetXY($this->w * 0.25, 1);
        $this->SetFont('Arial', 'B', self::TAMANO_TITULO + 4);
        $this->Cell(($this->w * 0.75),1.05,utf8_decode('Solicitud de Recursos'),'',1,'L');
        $this->SetLineWidth(0.075);
        $this->Line($this->w * 0.25, $this->y, $this->w - 1, $this->y);
        $this->SetLineWidth(0.02);


        $this->SetXY($this->w * 0.25, $this->y);
        $this->SetFont('Arial', '', self::TAMANO_CONTENIDO + 2);
        $this->Cell(($this->w * 0.75) * 0.25,0.50,utf8_decode('Proyecto:'),'',0,'L');
        $this->Cell(($this->w * 0.75) * 0.75,0.50,utf8_decode($this->obra->nombre),'',1,'L');
        $this->SetXY($this->w * 0.25, $this->y);
        $this->Cell(($this->w * 0.75) * 0.25,0.50,utf8_decode('Periodo:'),'',0,'L');
        $this->Cell(($this->w * 0.75) * 0.75,0.50, utf8_decode($this->solicitud->anio . ' - Semana ' . $this->solicitud->semana . ' - ' . 'Solicitud ' . ($this->solicitud->tipo->descripcion) . ($this->solicitud->consecutivo ? ' [' . $this->solicitud->consecutivo .']' : '')),'',1,'L');
        $this->Ln(1);

        $this->SetX(1);

        $this->SetFillColor('180','180','180');
        $this->Cell($this->WidthTotal / 3, 1, 'ESTATUS', 'T', 0, 'C',1);
        $this->Cell($this->WidthTotal / 3, 1, 'ESTATUS', 'T', 0, 'C',1);
    }

    function setPartidasEstilos()
    {
        $this->SetFont('Arial', '', 6);
        $this->SetStyles(array('DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF'));
        $this->SetFills(array('180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180'));
        $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
        $this->SetHeights(array(0.35));
        $this->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
        $this->SetWidths(array(0.078 * $this->WidthTotal, 0.125 * $this->WidthTotal, 0.203 * $this->WidthTotal, 0.104 * $this->WidthTotal, 0.063 * $this->WidthTotal, 0.078 * $this->WidthTotal, 0.086 * $this->WidthTotal, 0.07 * $this->WidthTotal, 0.062 * $this->WidthTotal, 0.048 * $this->WidthTotal, 0.083 * $this->WidthTotal));
        $this->Row(array(utf8_decode('Folio (SAO)'), utf8_decode('Tipo de Movimiento'), utf8_decode('Tipo de Transacción'), utf8_decode('Folio de Factura'), utf8_decode('Folio CR'), utf8_decode('Fecha'), utf8_decode('Vencimiento'), utf8_decode('Monto'), utf8_decode('Moneda'), utf8_decode('T.C.'), utf8_decode('Monto M.N.')));

        $this->SetFont('Arial', '', 6);
        $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
        $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
        $this->SetHeights(array(0.35));
        $this->SetAligns(array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'R', 'L', 'R', 'R'));
        $this->SetWidths(array(0.078 * $this->WidthTotal, 0.125 * $this->WidthTotal, 0.203 * $this->WidthTotal, 0.104 * $this->WidthTotal, 0.063 * $this->WidthTotal, 0.078 * $this->WidthTotal, 0.086 * $this->WidthTotal, 0.07 * $this->WidthTotal, 0.062 * $this->WidthTotal, 0.048 * $this->WidthTotal, 0.083 * $this->WidthTotal));

    }

    function titulos()
    {

        $this->SetFont('Arial', '', $this->txtSubtitleTam - 1);

        //Detalles de la Asignación (Titulo)
        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->SetXY($this->GetPageWidth() / 2, 1);
        $this->Cell(0.5 * $this->WidthTotal, 0.7, utf8_decode('SOLICITUD DE RECURSOS'), 'TRL', 0, 'C');

        $this->Cell(0.5);
        $this->Cell(0.5 * $this->WidthTotal, .7, '', 0, 1, 'L');

    }

    function detallesRecurso($x)
    {

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Obra:'), '', 0, 'LB');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.360 * $this->WidthTotal, 0.5, utf8_decode($this->obra->nombre), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Tipo de Solicitud:'), '', 0, 'LB');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->tipoOrden->descripcion), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Tipo de Cobrabilidad:'), '', 0, 'LB');
        $this->SetFont('Arial', '', '#' . $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->tipoOrden->cobrabilidad), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Número de Folio:'), '', 0, 'LB');
        $this->SetFont('Arial', '', '#' . $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.5, '#' . utf8_decode($this->solicitud->numero_folio), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Estatus:'), '', 0, 'LB');
        $this->SetFont('Arial', '', '#' . $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->estatus), '', 1, 'L');

        $this->SetFont('Arial', 'B', '#' . $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Fecha Solicitud:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.5, utf8_decode(Carbon::parse($this->solicitud->fecha_solicitud)->format('d-m-Y')), '', 1, 'L');


        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Persona que Solicita:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->userRegistro), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Área Solicitante:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->area_solicitante), '', 1, 'L');
    }

    function items()
    {



        foreach ($this->grupos as $grupo) {
            $this->setPartidasEstilos();
            foreach ($grupo as $partida) {
                $this->encola = 'partidas';
                $this->Row(array(
                    '#'. $partida->transaccion->numero_folio,
                    isset($partida->transaccion->rubros[0]) ? utf8_decode($partida->transaccion->rubros[0]->descripcion) : 'N/A',
                    utf8_decode($partida->transaccion->tipoTran->Descripcion),
                    $partida->transaccion->referencia ? utf8_decode($partida->transaccion->referencia) : 'N/A',
                    $partida->transaccion->contrarecibo ? ('#'. utf8_decode($partida->transaccion->contrarecibo->numero_folio)) : 'N/A',
                    $partida->transaccion->fecha->format('Y-m-d'),
                    $partida->transaccion->vencimiento->format('Y-m-d'),
                    '$ '. number_format($partida->transaccion->monto, 2, '.', ','),
                    utf8_decode($partida->transaccion->moneda->nombre),
                    '$ '. number_format($partida->transaccion->tipo_cambio, 2, '.', ','),
                    '$ '. number_format($partida->transaccion->monto * $partida->transaccion->tipo_cambio, 2, '.', ',')
                ));
            }
            $this->Ln(0.75);
        }
        $this->encola = 'total';

    }

    function motivo()
    {

        $this->encola = "motivo";
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

    function resumen()
    {


        if ($this->getY() > 13) {
            $this->addPage();
        }
        $this->SetX(17.52);
        $this->SetFont('Arial', '', 6);
        $this->SetStyles(array('DF', 'DF'));
        $this->SetFills(array('180,180,180', '180,180,180'));
        $this->SetTextColors(array('0,0,0', '0,0,0'));
        $this->SetHeights(array(0.38));
        $this->SetAligns(array('C', 'C'));
        $this->SetWidths(array(0.2 * $this->WidthTotal, 0.2 * $this->WidthTotal));
        $this->Row(array('Detalle', 'Cantidad'));

//his->resumen);



        $this->SetFills(array('255,255,255', '255,255,255'));
        $this->SetTextColors(array('0,0,0', '0,0,0'));
        $this->SetHeights(array(0.38));
        $this->SetAligns(array('L', 'R'));
        $this->SetWidths(array(0.2 * $this->WidthTotal, 0.2 * $this->WidthTotal));
        $this->SetX(17.52);
        $this->Row(['Conceptos Modificados', $this->data['detalle_afectacion']['conceptos_modificados']]);
        $this->SetX(17.52);
        $this->Row(['Importe Conceptos Modificados', '$ ' . number_format( $this->data['detalle_afectacion']['imp_conceptos_modif'], 2, '.', ',')]);
        $this->SetX(17.52);
        $this->Row([utf8_decode('Importe Variación'), '$ ' . number_format( $this->data['detalle_afectacion']['imp_variacion'], 2, '.', ',')]);
        $this->SetX(17.52);
        $this->Row(['Importe Conceptos Actualizados', '$ ' . number_format( $this->data['detalle_afectacion']['imp_conceptos_actualizados'], 2, '.', ',')]);
        $this->SetX(17.52);
        $this->Row(['Importe Presupuesto Actual', '$ ' . number_format( $this->data['detalle_afectacion']['imp_pres_original'], 2, '.', ',')]);
        $this->SetX(17.52);
        $this->Row(['Importe Presupuesto Nuevo', '$ ' . number_format(( $this->data['detalle_afectacion']['imp_pres_actualizado']), 2, '.', ',')]);
        $this->Ln(1);


        //  dd($this->resumen);
    }

    function logo()
    {
        $data = $this->obra->logotipo;
        $data = pack('H*', hex2bin($data));
        $file = public_path('img/logo_temp.png');
        if (file_put_contents($file, $data) !== false) {
            list($width, $height) = $this->resizeToFit($file);
            $this->image($file, 1, 1, $width, $height);
            unlink($file);;
        }
    }

    function pixelsToCM($val)
    {
        return ($val * self::MM_IN_INCH / self::DPI) / 10;
    }

    function resizeToFit($imgFilename)
    {
        list($width, $height) = getimagesize($imgFilename);
        $widthScale = self::MAX_WIDTH / $width;
        $heightScale = self::MAX_HEIGHT / $height;
        $scale = min($widthScale, $heightScale);

        return [
            round($this->pixelsToCM($scale * $width)),
            round($this->pixelsToCM($scale * $height))
        ];
    }

    function firmas()
    {
        $this->SetY(- 3.5);
        $this->SetTextColor('0', '0', '0');
        $this->SetFont('Arial', '', 6);
        $this->SetFillColor(180, 180, 180);

        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, utf8_decode('Solicita'), 'TRLB', 0, 'C', 1);
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, utf8_decode('Autoriza'), 'TRLB', 0, 'C', 1);
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, utf8_decode('Autoriza'), 'TRLB', 0, 'C', 1);
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, utf8_decode('Autoriza'), 'TRLB', 0, 'C', 1);
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, utf8_decode('Autoriza'), 'TRLB', 0, 'C', 1);
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, utf8_decode('Autoriza'), 'TRLB', 0, 'C', 1)
        ;$this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, utf8_decode('Autoriza'), 'TRLB', 1, 'C', 1);

        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, '', 'RL', 0, 'C');
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, '', 'RL', 0, 'C');
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, '', 'RL', 0, 'C');
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, '', 'RL', 0, 'C');
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, '', 'RL', 0, 'C');
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, '', 'RL', 0, 'C');
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, '', 'RL', 1,'C');

        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, ucfirst(strtolower(utf8_decode($this->solicitud->usuario))), 'RL', 0, 'C');
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, '', 'RL', 0, 'C');
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, '', 'RL', 0, 'C');
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, ucfirst(strtolower(utf8_decode('Miguel Ángel Álvarez García'))), 'RL', 0, 'C');
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, ucfirst(strtolower(utf8_decode('Sandra Mosqueda'))), 'RL', 0, 'C');
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.6, ucfirst(strtolower(utf8_decode('Benjamín Mondragón'))), 'RL', 0, 'C');
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, ucfirst(strtolower(utf8_decode('Gabriel Ramírez'))), 'RL', 1, 'C');



        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, ucfirst(strtolower(utf8_decode('Solicitante'))), 'TRLB', 0, 'C', 1);
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, ucfirst(strtolower(utf8_decode('Tesorería'))), 'TRLB', 0, 'C', 1);
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, ucfirst(strtolower(utf8_decode('Gerencia de Finanzas'))), 'TRLB', 0, 'C', 1);
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, ucfirst(strtolower(utf8_decode('Gerencia de Administración'))), 'TRLB', 0, 'C', 1);
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, ucfirst(strtolower(utf8_decode('Gerencia de Control de Riesgos'))), 'TRLB', 0, 'C', 1);
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, ucfirst(strtolower(utf8_decode('Dirección de Administración y Finanzas'))), 'TRLB', 0, 'C', 1);
        $this->cell(0.33);
        $this->Cell(($this->GetPageWidth() - 4) / 7, 0.4, ucfirst(strtolower(utf8_decode('Dirección General'))), 'TRLB', 0, 'C', 1);

    }

    function Footer()
    {
        $this->firmas();
       /*
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->SetY($this->GetPageHeight() - 1);
        $this->SetFont('Arial', '', $this->txtFooterTam);
        $this->Cell(6.5, .4, utf8_decode('Fecha de Consulta: ' . date('Y-m-d g:i a')), 0, 0, 'L');
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->Cell(6.5, .4, '', 0, 0, 'C');
        $this->Cell(15, .4, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
        $this->SetY($this->GetPageHeight() - 1.3);
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->Cell(6.5, .4, utf8_decode('Formato generado desde SAO.'), 0, 0, 'L');*/

        //if ($this->solicitud->id_estatus == 1) {
        //    $this->SetFont('Arial', '', 80);
        //    $this->SetTextColor(204, 204, 204);
        //    $this->RotatedText(7, 17, utf8_decode("PENDIENTE DE"), 45);
        //    $this->RotatedText(9.5, 18, utf8_decode("AUTORIZACIÓN"), 45);
        //    $this->SetTextColor('0,0,0');
        //}
    }

    function RotatedText($x, $y, $txt, $angle)
    {
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function create()
    {
        $this->SetMargins(1, 0.5, 1);
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetAutoPageBreak(true, 5.1);

        $this->items();

        try {
            $this->Output('I', 'Solicitud de recursos #' . $this->solicitud->folio . '.pdf', 1);
        } catch (\Exception $ex) {
            dd($ex);
        }
        exit;
    }
}