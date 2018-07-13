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

    /**
     * @var array
     */
    private $grupos;
    private $WidthTotal;
    private $txtTitleTam;
    private $txtSubtitleTam;
    private $txtSeccionTam;
    private $txtContenidoTam;
    private $txtFooterTam;
    private $partidas;

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
        $this->partidas = $solicitud->partidas;

        $this->obra = Obra::find(Context::getId());

        $this->grupos = $this->solicitud->partidas->groupBy('transaccion.id_rubro');
    }

    function Header()
    {
        $this->encabezados();
        if ($this->encola == 'partidas') {
            $this->SetFont('Arial', '', 6);
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('L', 'L', 'L', 'L', 'L', 'L', 'R', 'L', 'R', 'R'));
            $this->SetWidths(array(0.078 * $this->WidthTotal, 0.303 * $this->WidthTotal, 0.103 * $this->WidthTotal, 0.104 * $this->WidthTotal, 0.063 * $this->WidthTotal, 0.086 * $this->WidthTotal, 0.07 * $this->WidthTotal, 0.062 * $this->WidthTotal, 0.048 * $this->WidthTotal, 0.083 * $this->WidthTotal));
        } else if ($this->encola == 'total' || $this->encola == 'gran_total') {
            $this->SetFont('Arial', 'B', self::TAMANO_CONTENIDO);
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
        $this->Cell(($this->w * 0.75) * 0.75,0.50,
            utf8_decode($this->solicitud->anio . ' - Semana ' .
                $this->solicitud->semana . ' - ' . 'Solicitud ' .
                ($this->solicitud->tipo->descripcion) . ($this->solicitud->consecutivo ? ' [' . $this->solicitud->consecutivo .']' : '')
            )
            ,'',1,'L');
        $this->Ln(1);

        $this->SetFillColor(225,225,225);
        $this->Cell($this->WidthTotal / 3, 0.5, 'ESTATUS', 'LTR', 0, 'C','1');
        $this->Cell($this->WidthTotal / 3 * 2, 0.5, $this->solicitud->estatus, 'LTR', 1, 'L','0');

        $this->Cell($this->WidthTotal / 3, 0.5, 'EMPRESA', 'LR', 0, 'C','1');
        $this->Cell($this->WidthTotal / 3, 0.5, $this->obra->constructora, 'LTR', 0, 'L','0');
        $this->Cell($this->WidthTotal / 6, 0.5, 'FECHA', 'LRT', 0, 'C','1');
        $this->Cell($this->WidthTotal / 6, 0.5, $this->solicitud->created_at->format('d/m/Y'), 'LTR', 1, 'C','0');

        $this->Cell($this->WidthTotal / 3, 0.5, 'PROYECTO', 'LR', 0, 'C','1');
        $this->Cell($this->WidthTotal / 3, 0.5, $this->obra->nombre, 'LTR', 0, 'L','0');
        $this->Cell($this->WidthTotal / 6, 0.5, 'FECHA', 'LRT', 0, 'C','1');
        $this->Cell($this->WidthTotal / 6, 0.5, $this->solicitud->semana, 'LTR', 1, 'C','0');
    }

    function setPartidasEstilos()
    {
        $this->SetFont('Arial', '', 6);
        $this->SetStyles(array('DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF'));
        $this->SetFills(array('180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180'));
        $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
        $this->SetHeights(array(0.35));
        $this->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
        $this->SetWidths(array(0.078 * $this->WidthTotal, 0.303 * $this->WidthTotal, 0.103 * $this->WidthTotal, 0.104 * $this->WidthTotal, 0.063 * $this->WidthTotal, 0.086 * $this->WidthTotal, 0.07 * $this->WidthTotal, 0.062 * $this->WidthTotal, 0.048 * $this->WidthTotal, 0.083 * $this->WidthTotal));
        $this->Row(array(utf8_decode('Folio (SAO)'), utf8_decode('Proveedor'), utf8_decode('Tipo de Transacción'), utf8_decode('Folio de Factura'), utf8_decode('Folio CR'), utf8_decode('Vencimiento'), utf8_decode('Monto'), utf8_decode('Moneda'), utf8_decode('T.C.'), utf8_decode('Monto M.N.')));

        $this->SetFont('Arial', '', 6);
        $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
        $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
        $this->SetHeights(array(0.35));
        $this->SetAligns(array('L', 'L', 'L', 'L', 'L', 'L', 'R', 'L', 'R', 'R'));
        $this->SetWidths(array(0.078 * $this->WidthTotal, 0.303 * $this->WidthTotal, 0.103 * $this->WidthTotal, 0.104 * $this->WidthTotal, 0.063 * $this->WidthTotal, 0.086 * $this->WidthTotal, 0.07 * $this->WidthTotal, 0.062 * $this->WidthTotal, 0.048 * $this->WidthTotal, 0.083 * $this->WidthTotal));
    }

    function items()
    {
        foreach ($this->grupos as $grupo) {
            $this->setPartidasEstilos();
            $this->SetFont('Arial', 'B', self::TAMANO_CONTENIDO);
            $this->Cell($this->WidthTotal, 0.5, isset($grupo[0]->transaccion->rubros[0]) ? $grupo[0]->transaccion->rubros[0]->descripcion : 'SIN AGRUPAR', 'TLRB', 1, 'L', 0);
            $this->SetFont('Arial', '', self::TAMANO_CONTENIDO);

            $this->encola = 'partidas';

            foreach ($grupo as $partida) {
                $this->Row(array(
                    '#'. $partida->transaccion->numero_folio,
                    isset($partida->transaccion->empresa) ? utf8_decode($partida->transaccion->empresa->razon_social) : 'N/A',
                    utf8_decode(trim($partida->transaccion->tipoTran->Descripcion)),
                    $partida->transaccion->referencia ? utf8_decode($partida->transaccion->referencia) : 'N/A',
                    $partida->transaccion->contrarecibo ? ('#'. utf8_decode($partida->transaccion->contrarecibo->numero_folio)) : 'N/A',
                    $partida->transaccion->vencimiento->format('Y-m-d'),
                    '$ '. number_format($partida->transaccion->monto, 2, '.', ','),
                    utf8_decode($partida->transaccion->moneda->nombre),
                    '$ '. number_format($partida->transaccion->tipo_cambio, 2, '.', ','),
                    '$ '. number_format($partida->transaccion->monto * $partida->transaccion->tipo_cambio, 2, '.', ',')
                ));
            }

            $this->encola = 'total';
            $this->SetFont('Arial', 'B', self::TAMANO_CONTENIDO);
            $this->Cell($this->WidthTotal * 0.917, 0.5, 'TOTAL DE ' . (isset($grupo[0]->transaccion->rubros[0]) ? $grupo[0]->transaccion->rubros[0]->descripcion : 'SIN AGRUPAR')       , 'TLRB', 0, 'L', 0);
            $this->Cell($this->WidthTotal * 0.083, 0.5, '$ '. number_format($grupo->sum(function ($item) { return $item->transaccion->monto * $item->transaccion->tipo_cambio;}), 2, '.', ','), 'TLRB', 1, 'R', 0);
            $this->SetFont('Arial', '', self::TAMANO_CONTENIDO);

            $this->Ln(0.5);
        }

        $this->encola = 'gran_total';

        $this->SetFont('Arial', 'B', self::TAMANO_CONTENIDO);
        $this->Cell($this->WidthTotal * 0.917, 0.5, 'GRAN TOTAL', 'TLRB', 0, 'L', 0);
        $this->Cell($this->WidthTotal * 0.083, 0.5, '$ '. number_format($this->partidas->sum(function ($item) { return $item->transaccion->monto * $item->transaccion->tipo_cambio;}), 2, '.', ','), 'TLRB', 1, 'R', 0);
        $this->SetFont('Arial', '', self::TAMANO_CONTENIDO);

        $this->encola = '';
    }

    function logo()
    {
        $data = $this->obra->logotipo;
        $data = pack('H*', hex2bin($data));
        $file = public_path('img/logo_temp.png');
        if (file_put_contents($file, $data) !== false) {
            list($width, $height) = $this->resizeToFit($file);
            $this->image($file, 1, 1, $width, $height);
            unlink($file);
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

         $this->SetFont('Arial', 'B', $this->txtFooterTam);
         $this->SetY($this->GetPageHeight() - 1);
         $this->SetFont('Arial', '', $this->txtFooterTam);
         $this->Cell(6.5, .4, utf8_decode('Fecha de Consulta: ' . date('Y-m-d g:i a')), 0, 0, 'L');
         $this->SetFont('Arial', 'B', $this->txtFooterTam);
         $this->Cell(6.5, .4, '', 0, 0, 'C');
         $this->Cell(15, .4, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
         $this->SetY($this->GetPageHeight() - 1.3);
         $this->SetFont('Arial', 'B', $this->txtFooterTam);
         $this->Cell(6.5, .4, utf8_decode('Formato generado desde SAO.'), 0, 0, 'L');
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