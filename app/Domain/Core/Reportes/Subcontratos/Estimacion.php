<?php
namespace Ghi\Domain\Core\Reportes\Subcontratos;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Obra;
use Ghi\Domain\Core\Models\Transacciones\Subcontrato;
use Ghi\Utils\NumberToLetterConverter;
use Ghidev\Fpdf\Rotation;
use Illuminate\Support\Facades\DB;

class Estimacion extends Rotation {

    protected $obra;
    protected $estimacion;
    protected $objeto_contrato;

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
        $this->objeto_contrato = DB::connection('cadeco')->table('Subcontratos.subcontrato')->select('observacion')->where('id_transaccion', '=', $this->estimacion->id_antecedente)->first();
        $this->objeto_contrato = $this->objeto_contrato->observacion;
    }

    function Header() {
        //$this->logo();
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
        $this->SetY($this->GetPageHeight() - 1);
        $this->SetFont('Arial', '', 6);
        $this->Cell(6.5, .4, utf8_decode('Formato generado desde SAO.'), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(6.5, .4, '', 0, 0, 'C');
        $this->Cell(6.5, .4, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');

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
        $this->MultiCell(10, 0.5, $this->objeto_contrato, 1, 'C');
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
        $this->CellFitScale(10, 0.35, utf8_decode("#".$this->estimacion->numero_folio . " - " . $this->estimacion->observaciones), 'B', 1, 'C');
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
        foreach ($this->estimacion->items as $item) {
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
                utf8_decode($item->contrato),
                '$ ' . number_format($item->importe, 2, '.', ','),
                utf8_decode($item->concepto->padre() ? $item->concepto->padre() : ''),
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
            '$ ' . number_format($this->estimacion->suma_importes, 2, '.', ','),
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
        $this->SetAligns(['C', 'C', 'C', 'C']);
        $this->SetHeights([0.35]);
        $this->Row([
            'Monto Anticipo',
            utf8_decode('Amortización Pendiente Anterior'),
            utf8_decode('Amortización de esta Estimación'),
            utf8_decode('Amortización Pendiente')
        ]);
        $this->SetAligns(['R', 'R', 'R', 'R']);
        $this->Row([
            '$ ' . number_format($this->estimacion->subcontrato->anticipo_monto, 2, '.', ','),
            '$ ' . number_format($this->estimacion->amortizacion_pendiente_anterior, 2, '.', ','),
            '$ ' . number_format($this->estimacion->monto_anticipo_aplicado, 2, '.', ','),
            '$ ' . number_format($this->estimacion->amortizacion_pendiente, 2, '.', ',')
        ]);
    }

    function totales() {
        $y_inicial = $this->GetY();

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, utf8_decode('Importes Estimación :'), 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, number_format($this->estimacion->suma_importes, 2, '.', ','), 'B', 1, 'R');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Amortizacion de Anticipo :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.10, 0.4, round($this->estimacion->anticipo, 2) . ' %', 'B', 0, 'L');
        $this->CellFitScale(($this->w - 2) * 0.15, 0.4, number_format($this->estimacion->monto_anticipo_aplicado, 2 ,'.', ','), 'B', 1, 'R');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Subtotal :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, number_format($this->estimacion->suma_importes - $this->estimacion->monto_anticipo_aplicado, 2, '.', ','), 'B', 1, 'R');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'I.V.A :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, number_format($this->estimacion->impuesto, 2, '.', ','), 'B', 1, 'R');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, '', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Total :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, number_format($this->estimacion->monto, 2, '.', ','), 'B', 1, 'R');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, utf8_decode('Retención de Fondo de Garantia Estimación :'), 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.10, 0.4, round($this->estimacion->retencion, 2) . ' %', 'B', 0, 'L');
        $this->CellFitScale(($this->w - 2) * 0.15, 0.4, number_format($this->estimacion->subcontratoEstimacion ? $this->estimacion->subcontratoEstimacion->ImporteFondoGarantia : 0, 2, '.', ','), 'B', 1, 'R');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, '', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, '', 'B', 1, 'C');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Total Deductivas :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, number_format($this->estimacion->descuentos->sum('importe'), 2, '.', ','), 'B', 1, 'R');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Total Retenciones :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, number_format($this->estimacion->retenciones->sum('importe'), 2, '.', ','), 'B', 1, 'R');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, utf8_decode('Retención de IVA :'), 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, number_format($this->estimacion->iva_retenido, 2, '.', ','), 'B', 1, 'R');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Total Retenciones Liberadas :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, number_format($this->estimacion->liberaciones->sum('importe'), 2, '.', ','), 'B', 1, 'R');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Total Anticipo a Liberar :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, number_format($this->estimacion->subcontratoEstimacion ?$this->estimacion->subcontratoEstimacion->ImporteAnticipoLiberar : 0, 2, '.', ','), 'B', 1, 'R');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Total de la Orden de Pago :', 0, 0, 'R');
        $this->CellFitScale(($this->w - 2) * 0.25, 0.4, number_format($this->estimacion->monto_a_pagar, 2, '.', ','), 'B', 1, 'R');
        $this->Ln(0.1);

        $this->SetX(($this->w) * 0.45);
        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.30, 0.4, 'Importe con letra :', 0, 0, 'R');
        $this->MultiCell(($this->w - 2) * 0.25, 0.35, utf8_decode(strtoupper((new NumberToLetterConverter())->num2letras(round($this->estimacion->monto_a_pagar, 2)))), 1, 1, 'L');

        $y_final = $this->GetY();

        $this->SetY($y_inicial + (($y_final - $y_inicial) / 2) - 1);

        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.21, 0.4, 'Acumulado Retenido Anterior :', 0, 0, 'L');
        $this->CellFitScale(($this->w - 2) * 0.125, 0.4, '$ ' .  number_format($this->estimacion->retenido_anterior, 2, '.', ','), 'B', 1, 'R');

        $this->SetFont('Arial', '', 8);
        $this->Cell(($this->w - 2) * 0.21, 0.4, 'Retenido Origen :', 0, 0, 'L');
        $this->CellFitScale(($this->w - 2) * 0.125, 0.4, '$ ' .  number_format($this->estimacion->retenido_origen, 2, '.', ','), 'B', 1, 'R');

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
        $this->SetY(- 3.5);
        $this->SetTextColor('0', '0', '0');
        $this->SetFont('Arial', '', 6);
        $this->SetFillColor(180, 180, 180);

        $this->Cell(($this->GetPageWidth() - 4) / 4, 0.4, utf8_decode('Realizó'), 'TRLB', 0, 'C', 1);
        $this->Cell(0.73);
        $this->Cell(($this->GetPageWidth() - 4) / 4, 0.4, utf8_decode('Autorizó'), 'TRLB', 0, 'C', 1);
        $this->Cell(0.73);
        $this->Cell(($this->GetPageWidth() - 4) / 4, 0.4, utf8_decode('Autorizó'), 'TRLB', 0, 'C', 1);
        $this->Cell(0.73);
        $this->Cell(($this->GetPageWidth() - 4) / 4, 0.4, utf8_decode('Recibió'), 'TRLB', 1, 'C', 1);

        $this->Cell(($this->GetPageWidth() - 4) / 4, 1.2, '', 'TRLB', 0, 'C');
        $this->Cell(0.73);
        $this->Cell(($this->GetPageWidth() - 4) / 4, 1.2, '', 'TRLB', 0, 'C');
        $this->Cell(0.73);
        $this->Cell(($this->GetPageWidth() - 4) / 4, 1.2, '', 'TRLB', 0, 'C');
        $this->Cell(0.73);
        $this->Cell(($this->GetPageWidth() - 4) / 4, 1.2, '', 'TRLB', 1, 'C');

        $this->Cell(($this->GetPageWidth() - 4) / 4, 0.4, 'RESPONSABLE DE AREA', 'TRLB', 0, 'C', 1);
        $this->Cell(0.73);
        $this->Cell(($this->GetPageWidth() - 4) / 4, 0.4, 'GERENCIA DE AREA', 'TRLB', 0, 'C', 1);
        $this->Cell(0.73);
        $this->Cell(($this->GetPageWidth() - 4) / 4, 0.4, 'DIRECCION DE AREA', 'TRLB', 0, 'C', 1);
        $this->Cell(0.73);
        $this->Cell(($this->GetPageWidth() - 4) / 4, 0.4, 'ADMINISTRACION', 'TRLB', 0, 'C', 1);

    }

    function create() {
        $this->SetMargins(1, 0.5, 1);
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetAutoPageBreak(true,3.75);
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