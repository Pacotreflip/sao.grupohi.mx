<?php
namespace Ghi\Domain\Core\Reportes\Subcontratos;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Obra;
use Ghi\Domain\Core\Models\Transacciones\Subcontrato;
use Ghidev\Fpdf\Rotation;

class Estimacion extends Rotation {

    protected $obra;
    protected $estimacion;

    var $encola = '';

    const DPI = 96;
    const MM_IN_INCH = 25.4;
    const A4_HEIGHT = 297;
    const A4_WIDTH = 210;

    const MAX_WIDTH = 225;
    const MAX_HEIGHT = 180;


    public function __construct(\Ghi\Domain\Core\Models\Transacciones\Estimacion $estimacion)
    {
        parent::__construct('P', 'cm', 'A4');

        $this->obra = Obra::find(Context::getId());
        $this->estimacion = $estimacion;
    }

    function Header() {
        $this->logo();
        $this->detalles();
        $this->Ln(1);

        if($this->encola == 'partidas') {
            $this->SetFont('Arial', '', 7);
            $this->SetStyles(['DF', 'DF', 'DF', 'DF', 'DF', 'DF']);
            $this->SetWidths([
                ($this->w - 2) * 0.07,
                ($this->w - 2) * 0.30,
                ($this->w - 2) * 0.15,
                ($this->w - 2) * 0.28,
                ($this->w - 2) * 0.05,
                ($this->w - 2) * 0.15,
            ]);

            $this->SetFills(['180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180']);
            $this->SetTextColors(['0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0']);
            $this->SetHeights([0.5]);
            $this->SetAligns(['C', 'C', 'C', 'C', 'C', 'C']);
            $this->Row([
                'Partida',
                utf8_decode('Descripción'),
                'Importe',
                utf8_decode('Aplicación de Costo'),
                '%',
                'Cuenta'
            ]);

            $this->SetFont('Arial', '', 7);
            $this->SetWidths([
                ($this->w - 2) * 0.07,
                ($this->w - 2) * 0.30,
                ($this->w - 2) * 0.15,
                ($this->w - 2) * 0.28,
                ($this->w - 2) * 0.05,
                ($this->w - 2) * 0.15,
            ]);

            $this->SetFills(['255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255']);
            $this->SetTextColors(['0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0']);
            $this->SetHeights([0.35]);
            $this->SetAligns(['L', 'L', 'R', 'L', 'L', 'L']);
        }
    }

    function Footer() {
        $this->firmas();
    }

    function logo() {
        $data = $this->obra->logotipo;
        $data = pack('H*', $data);
        $file = public_path('img/logo_temp.png');
        if (file_put_contents($file, $data) !== false) {
            list($width, $height) = $this->resizeToFit($file);
            $this->Image($file, 1, 2, $width, $height);
            unlink($file);
        }
    }

    function detalles() {
        $this->SetXY(6, 1.5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(4, 0.4, '', 0, 0);
        $this->CellFitScale(10, 0.4, $this->obra->nombre, 0, 1, 'C');
        $this->ln(0.25);

        $this->SetX(6);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(4, 0.4, '', 0, 0);
        $this->CellFitScale(10, 0.4, 'ORDEN DE PAGO No.', 0, 1, 'L');
        $this->Ln(0.25);

        $this->SetX(6);
        $this->SetFont('Arial', '', 10);
        $this->Cell(4, 0.4, 'Subcontrato No. :', 0, 0, 'R');
        $this->CellFitScale(10, 0.4, $this->estimacion->subcontrato, 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(6);
        $this->SetFont('Arial', '', 8);
        $this->Cell(4, 1, 'Objeto del Contrato :', 0, 0, 'R');
        $this->CellFitScale(10, 1, '', 1, 1, 'C');
        $this->Ln(0.1);

        $this->SetX(6);
        $this->SetFont('Arial', '', 8);
        $this->Cell(4, 0.4, 'Fecha :', 0, 0, 'R');
        $this->CellFitScale(10, 0.4, $this->estimacion->fecha->format('d/m/Y'), 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(6);
        $this->SetFont('Arial', '', 8);
        $this->Cell(4, 0.4, 'Monto del Contrato :', 0, 0, 'R');
        $this->CellFitScale(10, 0.4,'$' . number_format($this->estimacion->subcontrato->monto_subcontrato, 2, '.', ','), 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(6);
        $this->SetFont('Arial', '', 8);
        $this->Cell(4, 0.35, 'Contratista :', 0, 0, 'R');
        $this->CellFitScale(10, 0.35, $this->estimacion->subcontrato->empresa, 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(6);
        $this->SetFont('Arial', '', 8);
        $this->Cell(4, 0.35, utf8_decode('Estimación :'), 0, 0, 'R');
        $this->CellFitScale(10, 0.35, '', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(6   );
        $this->SetFont('Arial', '', 8);
        $this->Cell(4, 0.35, 'Periodo :', 0, 0, 'R');
        $this->CellFitScale(5, 0.35, 'Del : ' . $this->estimacion->cumplimiento->format('d/m/Y'), 'B', 0, 'C');
        $this->CellFitScale(5, 0.35, 'Al : ' . $this->estimacion->vencimiento->format('d/m/Y'), 'B', 1, 'C');

        $this->Ln();
    }

    function partidas()
    {
        $this->SetFont('Arial', '', 7);
        $this->SetStyles(['DF', 'DF', 'DF', 'DF', 'DF', 'DF']);
        $this->SetWidths([
            ($this->w - 2) * 0.07,
            ($this->w - 2) * 0.30,
            ($this->w - 2) * 0.15,
            ($this->w - 2) * 0.28,
            ($this->w - 2) * 0.05,
            ($this->w - 2) * 0.15,
        ]);

        $this->SetFills(['180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180']);
        $this->SetTextColors(['0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0']);
        $this->SetHeights([0.5]);
        $this->SetAligns(['C', 'C', 'C', 'C', 'C', 'C']);
        $this->Row([
            'Partida',
            utf8_decode('Descripción'),
            'Importe',
            utf8_decode('Aplicación de Costo'),
            '%',
            'Cuenta'
        ]);
        for ($i = 0; $i < 69; $i++) {
            $this->SetFont('Arial', '', 7);
            $this->SetWidths([
                ($this->w - 2) * 0.07,
                ($this->w - 2) * 0.30,
                ($this->w - 2) * 0.15,
                ($this->w - 2) * 0.28,
                ($this->w - 2) * 0.05,
                ($this->w - 2) * 0.15,
            ]);

            $this->SetFills(['255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255']);
            $this->SetTextColors(['0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0']);
            $this->SetHeights([0.35]);
            $this->SetAligns(['L', 'L', 'R', 'L', 'L', 'L']);

            $this->encola = 'partidas';
            $this->Row([
                '',
                '[descripcion]',
                '[importe]',
                '[ConceptoPadre]',
                '',
                ''
            ]);
        }

        $this->SetFont('Arial', '', 7);
        $this->SetWidths([
            ($this->w - 2) * 0.37,
            ($this->w - 2) * 0.15,
            ($this->w - 2) * 0.48
        ]);

        $this->SetFills(['255,255,255', '255,255,255', '255,255,255']);
        $this->SetTextColors(['0,0,0', '0,0,0', '0,0,0']);
        $this->SetHeights([0.35]);
        $this->SetAligns(['R', 'R', 'R']);

        $this->encola = 'total_partidas';

        $this->Row([
            'Importe Total :',
            '[Sum(importe)]',
            ''
        ]);

        $this->encola = '';
    }

    function seguimiento()
    {
        $this->encola = 'seguimiento_header';

        $this->SetFont('Arial', '', 7);
        $this->SetStyles(['DF']);
        $this->SetWidths([$this->w - 2]);
        $this->SetFills(['180,180,180']);
        $this->SetTextColors(['0,0,0']);
        $this->SetHeights([0.5]);
        $this->SetAligns(['C']);
        $this->Row(['Seguimiento del Anticipo']);

        $this->SetWidths([
            ($this->w - 2) * 0.25,
            ($this->w - 2) * 0.25,
            ($this->w - 2) * 0.25,
            ($this->w - 2) * 0.25
        ]);
        $this->SetFills(['255,255,255', '255,255,255', '255,255,255', '255,255,255']);
        $this->SetTextColors(['0,0,0', '0,0,0', '0,0,0', '0,0,0']);
        $this->SetAligns(['C']);
        $this->SetHeights([0.35]);
        $this->Row(['Monto Anticipo', 'Saldo Anterior', utf8_decode('Amortización de esta Estimación'), 'Saldo Actual']);
        $this->SetAligns(['R', 'R', 'R', 'R']);
        $this->Row([
            '[anticipo_subcontrato]',
            '[saldo_anterior]',
            '[monto_anticipo_aplicado]',
            '[saldo_actual]'
        ]);
    }

    function totales() {
        $y_inicial = $this->GetY();

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, utf8_decode('Importes Estimación :'), 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Amortizacion de Anticipo :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Subtotal :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'I.V.A :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, '', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Total :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, utf8_decode('Retención de Fondo de Garantia Estimación :'), 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, '', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Total Deductivas :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Total Retenciones :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, utf8_decode('Retención de IVA :'), 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Total Retenciones Liberadas :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Total Anticipo a Liberar :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Total de la Orden de Pago :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '[]', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Importe con letra :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 1, '[]', 1, 1, 'C');

        $y_final = $this->GetY();

        $this->SetY($y_inicial + (($y_final - $y_inicial) / 2) - 1);

        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.125, 0.4, 'Retenido Anterior :', 0, 0, 'L');
        $this->CellFitScale(($this->w - 2) * 0.125, 0.4, '[]', 'B', 1, 'R');

        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.125, 0.4, 'Retenido Origen :', 0, 0, 'L');
        $this->CellFitScale(($this->w - 2) * 0.125, 0.4, '[]', 'B', 1, 'R');

        $this->SetY($y_final);

        $this->Ln(0.1);
    }

    function pixelsToCM($val) {
        return ($val * self::MM_IN_INCH / self::DPI) / 10;
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
        $this->partidas();
        $this->Ln();
        $this->seguimiento();
        if($this->y > 17.05)
            $this->AddPage();
        $this->Ln(1);
        $this->totales();
        try {
            $this->Output('I', 'Formato - Orden de Pago Estimación.pdf', 1);
        } catch (\Exception $ex) {
            dd($ex);
        }
        exit;
    }
}