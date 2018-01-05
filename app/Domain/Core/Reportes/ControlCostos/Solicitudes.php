<?php
/**
 * Created by PhpStorm.
 * User: mirah
 * Date: 04/01/2018
 * Time: 12:40 PM
 */

namespace Ghi\Domain\Core\Reportes\ControlCostos;

use Ghi\Core\Facades\Context;
use Ghidev\Fpdf\Rotation;
use Ghi\Domain\Core\Models\Obra;

class Solicitudes extends Rotation {

    var $encola = '';

    const DPI = 96;
    const MM_IN_INCH = 25.4;
    const A4_HEIGHT = 297;
    const A4_WIDTH = 210;

    const MAX_WIDTH = 225;
    const MAX_HEIGHT = 180;
    /**
     * @var SolicitudReclasificacionRepository
     */
    private $solicitud;
    protected $obra;


    /**
     * Solicitudes constructor.
     * @param SolicitudReclasificacionRepository $solicitud
     */
    public function __construct($solicitud)
    {
        parent::__construct('P', 'cm', 'A4');

        $this->solicitud = $solicitud;
        $this->obra = Obra::find(Context::getId());
    }

    function Header() {
        $this->SetY(1);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(($this->w - 2) / 2, 0.4, '', 0, 0, 'C');
        $this->CellFitScale(($this->w - 2) / 2, 0.4, utf8_decode('SOLICITUD DE RECLASIFICACIÓN'), 0, 1, 'C');

        $this->logo();
        $this->info();
        $this->Ln(1);

        if($this->encola == 'partidas') {
            $this->SetFont('Arial', '', 7);
            $this->SetStyles(['DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF']);
            $this->SetWidths([
                ($this->w - 2) * 0.15, // Tipo
                ($this->w - 2) * 0.05, // Folio
                ($this->w - 2) * 0.30, // Item
                ($this->w - 2) * 0.10, //Cantidad
                ($this->w - 2) * 0.10, // Importe
                ($this->w - 2) * 0.15, // Costo Origen
                ($this->w - 2) * 0.15, // Costo Destino
            ]);

            $this->SetFills(['180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180']);
            $this->SetTextColors(['0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0']);
            $this->SetHeights([0.5]);
            $this->SetAligns(['C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C']);
            $this->Row([
                utf8_decode('Tipo Transacción'),
                'Folio',
                'Item',
                'Cantidad',
                'Importe',
                'Costo Origen',
                'Costo Destino',
            ]);

            $this->SetFont('Arial', '', 7);
            $this->SetWidths([
                ($this->w - 2) * 0.15, // Tipo
                ($this->w - 2) * 0.05, // Folio
                ($this->w - 2) * 0.30, // Item
                ($this->w - 2) * 0.10, //Cantidad
                ($this->w - 2) * 0.10, // Importe
                ($this->w - 2) * 0.15, // Costo Origen
                ($this->w - 2) * 0.15, // Costo Destino
            ]);

            $this->SetFills(['255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255']);
            $this->SetTextColors(['0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0']);
            $this->SetHeights([0.35]);
            $this->SetAligns(['L', 'L', 'R', 'L', 'L', 'L', 'L']);
        }
    }

    function info()
    {
        $this->SetXY($this->w / 2, 2);
        $this->SetTextColor('0,0,0');
        $this->SetFont('Arial', 'B', 14);

        $this->Cell(($this->w - 2) / 4,.7, utf8_decode('FOLIO'),'LT',0,'L');
        $this->Cell(($this->w - 2) / 4,.7, '# '. $this->solicitud['id'],'RT',0,'L');
        $this->Ln(.7);
        $y_f = $this->GetY();

        $this->SetXY($this->w / 2, $y_f);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(($this->w - 2) / 4,.7, 'FECHA ','LB',0,'L');
        $this->Cell(($this->w - 2) / 4,.7, $this->solicitud->created_at->format('Y-m-d h:i:s a'),'RB',0,'L');
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
            $this->Image($file, ($this->w / 4) - ($width / 2), 1.5, $width, $height);
            unlink($file);
        }
    }

    function detalles() {
        $fecha = new \DateTime($this->solicitud['created_at']);


        $this->SetX(8);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(4, 0.4, '', 0, 0);
        $this->CellFitScale(10, 0.4, $fecha->format('Y-m-d'), 0, 1, 'L');
        $this->Ln(0.25);

        $this->SetX(8);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(4, 0.4, '', 0, 0);
        $this->CellFitScale(10, 0.4, 'Elaborado por: '. $this->solicitud['usuario']['nombre'] .' '. $this->solicitud['usuario']['apaterno'], 0, 1, 'L');
        $this->Ln(0.25);
    }

    function partidas()
    {
        $this->Ln(1.25);
        $this->SetFont('Arial', '', 7);
        $this->SetStyles(['DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF']);
        $this->SetWidths([
            ($this->w - 2) * 0.15, // Tipo
            ($this->w - 2) * 0.05, // Folio
            ($this->w - 2) * 0.30, // Item
            ($this->w - 2) * 0.10, //Cantidad
            ($this->w - 2) * 0.10, // Importe
            ($this->w - 2) * 0.15, // Costo Origen
            ($this->w - 2) * 0.15, // Costo Destino
        ]);

        $this->SetFills(['180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180']);
        $this->SetTextColors(['0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0']);
        $this->SetHeights([0.5]);
        $this->SetAligns(['C', 'C', 'C', 'C', 'C', 'C', 'C']);
        $this->Row([
            utf8_decode('Tipo Transacción'),
            'Folio',
            'Item',
            'Cantidad',
            'Importe',
            'Costo Origen',
            'Costo Destino',
        ]);
        foreach ($this->solicitud['partidas'] as $item) {
            $this->SetFont('Arial', '', 7);
            $this->SetWidths([
                ($this->w - 2) * 0.15, // Tipo
                ($this->w - 2) * 0.05, // Folio
                ($this->w - 2) * 0.30, // Item
                ($this->w - 2) * 0.10, //Cantidad
                ($this->w - 2) * 0.10, // Importe
                ($this->w - 2) * 0.15, // Costo Origen
                ($this->w - 2) * 0.15, // Costo Destino

            ]);

            $this->SetFills(['255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255']);
            $this->SetTextColors(['0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0']);
            $this->SetHeights([0.35]);
            $this->SetAligns(['L', 'R', 'L', 'R', 'L', 'L', 'L']);
            $this->encola = 'partidas';

            $this->Row([
                (!empty($item['item']['transaccion']['tipoTransaccion']) ? $item['item']['transaccion']['tipoTransaccion'] : '-' ),
                '#'. $item['item']['transaccion']['numero_folio'],
                $item['item']['material']['descripcion'],
                $item['item']['cantidad'],
                '$' . number_format($item['item']['importe'], 2, '.', ','),
                $item['concepto_original']['clave'],
                $item['concepto_nuevo']['clave'],
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

        $this->encola = '';
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

        $this->Cell(($this->GetPageWidth() - 4) / 2, 0.4, utf8_decode('Solicitó'), 'TRLB', 0, 'C', 1);
        $this->Cell(2);
        $this->Cell(($this->GetPageWidth() - 4) / 2, 0.4, utf8_decode('Autorizó'), 'TRLB', 1, 'C', 1);

        $this->Cell(($this->GetPageWidth() - 4) / 2, 1.2, '', 'TRLB', 0, 'C');
        $this->Cell(2);
        $this->Cell(($this->GetPageWidth() - 4) / 2, 1.2, '', 'TRLB', 1, 'C');

        $this->Cell(($this->GetPageWidth() - 4) / 2, 0.4, utf8_decode($this->solicitud->usuario), 'TRLB', 0, 'C', 1);
        $this->Cell(2);
        $this->Cell(($this->GetPageWidth() - 4) / 2, 0.4, utf8_decode($this->solicitud->autorizacion ? $this->solicitud->autorizacion->usuario : ''), 'TRLB', 0, 'C', 1);


    }

    function create() {
        $this->SetMargins(1, 0.5, 1);
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetAutoPageBreak(true,3.75);
        $this->partidas();
        $this->Ln();

        if($this->y > 17.05)
            $this->AddPage();
        $this->Ln(1);

        try {
            $this->Output('I', 'Formato - Solicitud de Reclasificación.pdf', 1);
        } catch (\Exception $ex) {
            dd($ex);
        }
        exit;
    }
}