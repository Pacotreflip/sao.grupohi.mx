<?php
namespace Ghi\Domain\Core\Reportes\CostosDolares;

use Ghidev\Fpdf\Rotation;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Obra;

class CostosDolaresPDF extends Rotation
{
    protected $obra;
    protected $costos;
    protected  $inicio;
    protected  $final;

    var $encola = '';

    const DPI = 96;
    const MM_IN_INCH = 25.4;
    const A4_HEIGHT = 297;
    const A4_WIDTH = 210;

    const MAX_WIDTH = 225;
    const MAX_HEIGHT = 180;


    public function __construct($costos)
    {
        parent::__construct('L', 'cm', 'LETTER');

        $this->obra = Obra::find(Context::getId());
        $this->costos = $costos;
    }

    function Header()
    {
        $this->logo();
        $this->detalles();
        $this->Ln(1);
    }
    function Footer() {
        $this->firmas();
    }

    function logo() {
        $data = $this->obra->logotipo;
        $data = pack('H*', hex2bin($data));
        $file = public_path('img/logo_temp.png');
        if (file_put_contents($file, $data) !== false) {
            list($width, $height) = $this->resizeToFit($file);
            $this->Image($file, 1, 2, $width, $height);
            unlink($file);
        }
    }
    function pixelsToCM($val) {
        return ($val * self::MM_IN_INCH / self::DPI) / 10;
    }

    function fechas(){
        $this->costos->count();
    }
    function resizeToFit($imgFilename) {
        list($width, $height) = getimagesize($imgFilename);
        $widthScale = self::MAX_WIDTH / $width;
        $heightScale = self::MAX_HEIGHT / $height;
        $scale = min($widthScale, $heightScale);
        return [
            round($this->pixelsToCM($scale * $width)),
            round($this->pixelsToCM($scale * $height))
        ];
    }
    function detalles()
    {
        $this->SetXY(11, 1.5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(4, 0.4, '', 0, 0);
        $this->CellFitScale(10, 0.4, $this->obra->nombre, 0, 1, 'C');
        $this->ln(0.25);

        $this->SetX(11);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(4, 0.4, '', 0, 0);
        $this->CellFitScale(10, 0.4, utf8_decode('REPORTE DE COSTOS EN MONEDA EXTRANJERA'), 0, 1, 'C');
        $this->Ln(0.25);
        $this->Ln();
        $this->SetX(11 );
        $this->SetFont('Arial', '', 8);
        $this->Cell(4, 0.35, 'Periodo :', 0, 0, 'R');
        $this->CellFitScale(5, 0.35, 'Del : '. \Carbon\Carbon::parse($this->costos[0]->fecha_poliza)->format('d/m/Y') , 'B', 0, 'C');
        $this->CellFitScale(5, 0.35, 'Al : '. \Carbon\Carbon::parse($this->costos[sizeof($this->costos )-1]->fecha_poliza)->format('d/m/Y'), 'B', 1, 'C');

        $this->Ln();

    }

    function costos(){
        $this->setFont('Arial', '', 7);
        $this->setStyles(['DF','DF','DF','DF','DF','DF','DF','DF','DF','DF','DF']);
        $this->setWidths([
            ($this->w -2) * 0.05,
            ($this->w -2) * 0.05,
            ($this->w -2) * 0.07,
            ($this->w -2) * 0.05,
            ($this->w -2) * .15,
            ($this->w -2) * .25,
            ($this->w -2) * 0.08,
            ($this->w -2) * 0.08,
            ($this->w -2) * 0.1,
            ($this->w -2) * 0.06,
            ($this->w -2) * 0.06,
        ]);
        $this->setFills(['180,180,180','180,180,180','180,180,180','180,180,180','180,180,180','180,180,180','180,180,180','180,180,180','180,180,180','180,180,180','180,180,180',]);
        $this->setTextColors(['0,0,0','0,0,0','0,0,0','0,0,0','0,0,0','0,0,0','0,0,0','0,0,0','0,0,0','0,0,0','0,0,0',]);
        $this->setHeights([0.5]);
        $this->setAligns(['C','C','C','C','C','C','C','C','C','C','C',]);
        $this->row([
            utf8_decode('Id PrePóliza'),
            'Folio ContPaq',
            utf8_decode('Fecha de Póliza'),
            'Tipo de Cambio',
            'Cuenta Contable',
            utf8_decode('Descripción'),
            'Importe Moneda Nacional',
            utf8_decode('Costo Moneda Extranjera'),
            utf8_decode('Costo Moneda Extranjera Complementaria'),
            utf8_decode('Póliza ContPaq'),
            utf8_decode('Póliza SAO')
        ]);

        $total_importe = 0;
        $total_costo_dolares = 0;
        $total_costo_dolares_complementaria = 0;
        foreach ($this->costos as $item) {
            $this->setFont('Arial', '', 7);
            $this->setWidths([
                ($this->w -2) * 0.05,
                ($this->w -2) * 0.05,
                ($this->w -2) * 0.07,
                ($this->w -2) * 0.05,
                ($this->w -2) * .15,
                ($this->w -2) * .25,
                ($this->w -2) * 0.08,
                ($this->w -2) * 0.08,
                ($this->w -2) * 0.1,
                ($this->w -2) * 0.06,
                ($this->w -2) * 0.06,
            ]);
            $this->setFills(['255,255,255','255,255,255','255,255,255','255,255,255','255,255,255','255,255,255','255,255,255','255,255,255','255,255,255','255,255,255','255,255,255',]);
            $this->setTextColors(['0,0,0','0,0,0','0,0,0','0,0,0','0,0,0','0,0,0','0,0,0','0,0,0','0,0,0','0,0,0','0,0,0',]);
            $this->setHeights([0.35]);
            $this->setAligns(['C','C','C','C','C','L','R','R','R','C','C',]);
            $this->row([
                $item->id_poliza,
                $item->folio_contpaq,
                \Carbon\Carbon::parse($item->fecha_poliza)->format('d/m/Y'),
                '$'.number_format($item->tipo_cambio,'2','.',','),
                $item->cuenta_contable,
                utf8_decode($item->descripcion_concepto),
                '$'.number_format($item->importe,'2','.',','),
                '$'.number_format($item->costo_dolares,'2','.',','),
                '$'.number_format($item->costo_dolares_complementaria,'2','.',','),
                utf8_decode($item->tipo_poliza_contpaq).' No. '.$item->folio_contpaq,
                utf8_decode($item->tipo_poliza_sao).' No. '.$item->id_poliza
            ]);
            $total_importe += $item->importe;
            $total_costo_dolares += $item->costo_dolares;
            $total_costo_dolares_complementaria += $item->costo_dolares_complementaria;

        }
        $this->SetFont('Arial', 'B', 7);
        $this->SetWidths([
            ($this->w - 2) * 0.62,
            ($this->w - 2) * 0.08,
            ($this->w - 2) * 0.08,
            ($this->w - 2) * 0.1,
            ($this->w - 2) * 0.12
        ]);

        $this->SetFills(['255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255']);
        $this->SetTextColors(['0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0']);
        $this->SetHeights([0.5]);
        $this->SetAligns(['R', 'R', 'R', 'R', 'R']);

        $this->encola = 'total_partidas';

        $this->Row([
            'Totales  :',
            '$ ' . number_format($total_importe, 2, '.', ','),
            '$ ' . number_format($total_costo_dolares, 2, '.', ','),
            '$ ' . number_format($total_costo_dolares_complementaria, 2, '.', ','),
            ''
        ]);

        $this->encola = '';

    }

    function firmas() {
        $this->SetY(- 2.5);
        $this->SetTextColor('0', '0', '0');
        $this->SetFont('Arial', '', 6);
        $this->SetFillColor(180, 180, 180);

        $this->Cell(($this->GetPageWidth() - 4) / 5, 0.4, utf8_decode('Realizó'), 'TRLB', 0, 'C', 1);
        $this->Cell(0.5);
        $this->Cell(($this->GetPageWidth() - 4) / 5, 0.4, utf8_decode('Avaló'), 'TRLB', 0, 'C', 1);
        $this->Cell(0.5);
        $this->Cell(($this->GetPageWidth() - 4) / 5, 0.4, utf8_decode('Autorizó'), 'TRLB', 0, 'C', 1);
        $this->Cell(0.5);
        $this->Cell(($this->GetPageWidth() - 4) / 5, 0.4, utf8_decode('Autorizó'), 'TRLB', 0, 'C', 1);
        $this->Cell(0.5);
        $this->Cell(($this->GetPageWidth() - 4) / 5, 0.4, utf8_decode('Recibió'), 'TRLB', 1, 'C', 1);

        $this->Cell(($this->GetPageWidth() - 4) / 5, 1.2, '', 'TRLB', 0, 'C');
        $this->Cell(0.5);
        $this->Cell(($this->GetPageWidth() - 4) / 5, 1.2, '', 'TRLB', 0, 'C');
        $this->Cell(0.5);
        $this->Cell(($this->GetPageWidth() - 4) / 5, 1.2, '', 'TRLB', 0, 'C');
        $this->Cell(0.5);
        $this->Cell(($this->GetPageWidth() - 4) / 5, 1.2, '', 'TRLB', 0, 'C');
        $this->Cell(0.5);
        $this->Cell(($this->GetPageWidth() - 4) / 5, 1.2, '', 'TRLB', 1, 'C');

        $this->Cell(($this->GetPageWidth() - 4) / 5, 0.4, 'SUBCONTRATOS', 'TRLB', 0, 'C', 1);
        $this->Cell(0.5);
        $this->Cell(($this->GetPageWidth() - 4) / 5, 0.4, 'SUPERINTENDENTE DE OBRA', 'TRLB', 0, 'C', 1);
        $this->Cell(0.5);
        $this->Cell(($this->GetPageWidth() - 4) / 5, 0.4, 'GERENTE DE OBRA', 'TRLB', 0, 'C', 1);
        $this->Cell(0.5);
        $this->Cell(($this->GetPageWidth() - 4) / 5, 0.4, 'CONTROL DE OBRA', 'TRLB', 0, 'C', 1);
        $this->Cell(0.5);
        $this->Cell(($this->GetPageWidth() - 4) / 5, 0.4, 'ADMINISTRADOR', 'TRLB', 0, 'C', 1);
    }

    function create() {
        $this->SetMargins(1, 0.5, 1);
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetAutoPageBreak(true,3.5);
        $this->costos();
        //$this->partidas();
        $this->Ln();
        //$this->seguimiento();
        if($this->y > 17.05)
            $this->AddPage();
        $this->Ln(1);
        //$this->totales();
        try {
            $this->Output('I', 'Formato - Reporte Costos en Dolares.pdf', 1);
        } catch (\Exception $ex) {
            dd($ex);
        }
        exit;
    }
}