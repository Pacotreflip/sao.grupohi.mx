<?php
/**
 * Created by PhpStorm.
 * User: mirah
 * Date: 24/01/2018
 * Time: 12:40 PM
 */

namespace Ghi\Domain\Core\Formatos\ControlPresupuesto;

use Carbon\Carbon;
use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\ControlPresupuesto\AfectacionOrdenesPresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghidev\Fpdf\Rotation;
use Ghi\Domain\Core\Models\Obra;
use Illuminate\Support\Facades\DB;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;

class PDFSolicitudCambioEscalatoria extends Rotation {

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
     * @var SolicitudCambioPartidaRepository
     */
    private $partidas;

    /**
     * Solicitudes constructor.
     * @param SolicitudCambio|SolicitudCambioRepository $solicitud
     * @param SolicitudCambioPartidaRepository $partidas
     */
    public function __construct(SolicitudCambio $solicitud, SolicitudCambioPartidaRepository $partidas)
    {
        parent::__construct('P', 'cm', 'A4');

        $this->SetAutoPageBreak(true,5);
        $this->WidthTotal = $this->GetPageWidth() - 2;
        $this->txtTitleTam = 18;
        $this->txtSubtitleTam = 13;
        $this->txtSeccionTam = 9;
        $this->txtContenidoTam = 7;
        $this->txtFooterTam = 6;
        $this->solicitud = $solicitud;

        $this->obra = Obra::find(Context::getId());
        $this->partidas = $partidas;
    }

    function Header() {
        $this->titulos();

        //Obtener Posiciones despues de los títulos
        $y_inicial = $this->getY();
        $x_inicial = $this->GetPageWidth() / 2;
        $this->setY($y_inicial);
        $this->setX($x_inicial);
        $this->logo();

        //Tabla Detalles de la Asignación
        $this->detallesAsignacion($x_inicial);

        //Posiciones despues de la primera tabla
        $y_final = $this->getY();

        $this->setXY($x_inicial, $y_inicial);

        $alto = abs($y_final - $y_inicial);

        //Redondear Bordes Detalles Asignacion
        $this->SetWidths(array(0.5 * $this->WidthTotal));

        $this->SetFills(array('255,255,255'));
        $this->SetTextColors(array('0,0,0'));
        $this->SetHeights(array($alto));
        $this->SetStyles(array('DF'));
        $this->SetAligns("L");
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->setXY($x_inicial, $y_inicial);
        $this->Row(array(""));

        $this->setXY($x_inicial, $y_inicial);


        //Tabla Detalles de la Asignacion
        $this->setY($y_inicial);
        $this->setX($x_inicial);
        $this->detallesAsignacion($x_inicial);

        //Obtener Y después de la tabla
        $this->setY($y_final);
        $this->Ln(1.5);

        if($this->encola == 'partidas') {

            $this->SetFont('Arial', '', 6);
            $this->SetStyles(array('DF', 'DF', 'DF'));
            $this->SetFills(array('180,180,180', '180,180,180', '180,180,180'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.3));
            $this->SetAligns(array('C', 'C', 'C'));
            $this->Row(array('#', utf8_decode("Descripción"), utf8_decode("Importe")));

            $this->SetFont('Arial', '', 6);
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('L', 'L', 'R'));
            $this->SetWidths(array(0.05 * $this->WidthTotal, 0.85 * $this->WidthTotal, 0.1 * $this->WidthTotal));
        }

        else if($this->encola == 'motivo')
        {
            $this->SetWidths(array($this->WidthTotal));
            $this->SetFills(array('180,180,180'));
            $this->SetTextColors(array('0,0,0'));
            $this->SetHeights(array(0.3));
            $this->SetFont('Arial', '', 6);
            $this->SetAligns(array('C'));

        }
    }

    function titulos(){

        $this->SetFont('Arial', '', $this->txtSubtitleTam -1);

        //Detalles de la Asignación (Titulo)
        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->SetXY($this->GetPageWidth() /2, 1);
        $this->Cell(0.5 * $this->WidthTotal, 0.7, utf8_decode('SOLICITUD DE CAMBIO AL PRESUPUESTO'), 'TRL', 0, 'C');

        $this->Cell(0.5);
        $this->Cell(0.5 * $this->WidthTotal, .7, '', 0, 1, 'L');

    }

    function detallesAsignacion($x){

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.140 * $this->WidthTotal, 0.5, utf8_decode('Obra:'), '', 0, 'LB');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.360 * $this->WidthTotal, 0.5, utf8_decode($this->obra->nombre), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.140 * $this->WidthTotal, 0.5, utf8_decode('Tipo de solicitud:'), '', 0, 'LB');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.360 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->tipoOrden->descripcion), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.140 * $this->WidthTotal, 0.5, utf8_decode('Tipo de Cobrabilidad:'), '', 0, 'LB');
        $this->SetFont('Arial', '', '#'.$this->txtContenidoTam);
        $this->CellFitScale(0.360 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->tipoOrden->cobrabilidad), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.140 * $this->WidthTotal, 0.5, utf8_decode('Número de Folio:'), '', 0, 'LB');
        $this->SetFont('Arial', '', '#'.$this->txtContenidoTam);
        $this->CellFitScale(0.360 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->numero_folio), '', 1, 'L');

        $this->SetFont('Arial', 'B', '#'.$this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.140 * $this->WidthTotal, 0.5, utf8_decode('Fecha Solicitud:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.360 * $this->WidthTotal, 0.5, utf8_decode(Carbon::parse($this->solicitud->fecha_solicitud)->format('d-m-Y')), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.140 * $this->WidthTotal, 0.5, utf8_decode('Persona que Solicita:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.360 * $this->WidthTotal, 0.5, utf8_decode($this->solicitud->userRegistro), '', 1, 'L');

    }

    function items(){

        $tipo_orden = 0;
        foreach ($this->solicitud->partidas as $index => $p)
            $tipo_orden = $p['id_tipo_orden'];

        $baseDatos = AfectacionOrdenesPresupuesto::where('id_tipo_orden', '=', $tipo_orden)->with('baseDatos')->get();

        foreach ($baseDatos as $bi => $base)
        {
            $this->SetFont('Arial', 'B', $this->txtSeccionTam);
            $this->Cell($this->WidthTotal, 0.7, utf8_decode('PRESUPUESTO DE '. $base->baseDatos->descripcion), 'TRLB', 0, 'C');
            $this->SetXY($this->GetX(), $this->GetY() + 0.2);
            $this->SetWidths(array(0));
            $this->SetFills(array('255,255,255'));
            $this->SetTextColors(array('1,1,1'));
            $this->SetHeights(array(0));
            $this->SetFont('Arial', 'B', $this->txtSeccionTam);
            $this->SetTextColors(array('255,255,255'));
            $this->MultiCell($this->WidthTotal, .35, utf8_decode($this->solicitud->concepto), 0, 'L');

            $this->SetWidths(array(0.05 * $this->WidthTotal, 0.85 * $this->WidthTotal, 0.1 * $this->WidthTotal));
            $this->SetFont('Arial', '', 6);
            $this->SetStyles(array('DF', 'DF', 'DF'));
            $this->SetFills(array('180,180,180', '180,180,180', '180,180,180'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.3));
            $this->SetAligns(array('C', 'C', 'R'));
            $this->Row(array('#', utf8_decode("Descripción"), utf8_decode("Importe")));

            $contador = 1;
            foreach ($this->solicitud->partidas as $i => $p)
            {
                $partida = $p->find($p->id);

                $this->SetWidths(array(0.05 * $this->WidthTotal, 0.85 * $this->WidthTotal, 0.1 * $this->WidthTotal));
                $this->SetFont('Arial', '', 6);
                $this->SetStyles(array('DF', 'DF', 'DF'));
                $this->SetFills(array('255,255,255', '255,255,255', '255,255,255'));
                $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0'));
                $this->SetHeights(array(0.3));
                $this->SetAligns(array('L', 'L', 'R'));

                $this->encola = 'partidas';

                $this->Row([
                    $contador++,
                    utf8_decode($partida->descripcion),
                    '$'. number_format($partida->monto_presupuestado, 2, '.', ','),
                ]);

            }

            $this->Ln(1);
        }

        $this->encola = '';
    }
    function motivo(){

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


    function logo() {

        $data = $this->obra->logotipo;
        $data = pack('H*', $data);
        $file = public_path('img/logo_temp.png');
        if (file_put_contents($file, $data) !== false) {
            list($width, $height) = $this->resizeToFit($file);
            $this->image($file, ($this->GetPageWidth() / 4) - ($width/2), 1, $width, $height);
            unlink($file);;
        }
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

    function firmas(){

        $this->SetFont('Arial', '', 6);
        $this->SetFillColor(180, 180, 180);

        $qr_name = 'qrcode_'. mt_rand() .'.png';
        $renderer = new Png();
        $renderer->setHeight(132);
        $renderer->setWidth(132);
        $renderer->setMargin(0);
        $writer = new Writer($renderer);
        $writer->writeFile(route('control_presupuesto.cambio_presupuesto.show',[
            'id' => $this->solicitud->id,
            'DATABASE_NAME' => base64_encode(Context::getDatabaseName()),
            'ID_OBRA' => base64_encode(Context::getId())]), $qr_name);

        $this->SetY($this->GetPageHeight() - 5);

        $qrX = $this->GetPageWidth() + 4;

        $this->Image($qr_name, 1);
        unlink($qr_name);

        $this->SetY($this->GetPageHeight() - 4);
        $firmasWidth = 6.5;
        $firmaX1 = ($qrX / 3) - ($firmasWidth / 2);
        $firmaX2 = ($qrX / 1.50) - ($firmasWidth / 2);

        $this->SetX($firmaX1);
        $this->Cell($firmasWidth, 0.4, utf8_decode('COORDINADOR DE CONTROL DE PROYECTOS'), 'TRLB', 0, 'C', 1);

        $this->SetX($firmaX2);
        $this->Cell($firmasWidth, 0.4, utf8_decode('PERSONA QUE SOLICITA'), 'TRLB', 1, 'C', 1);


        $this->SetX($firmaX1);
        $this->Cell($firmasWidth, 1.2, '', 'TRLB', 0, 'C');

        $this->SetX($firmaX2);
        $this->Cell($firmasWidth, 1.2, '', 'TRLB', 1, 'C');

        $this->SetX($firmaX1);
        $this->Cell($firmasWidth, 0.4, utf8_decode(''), 'TRLB', 0, 'C', 1);

        $this->SetX($firmaX2);
        $this->Cell($firmasWidth, 0.4, utf8_decode($this->solicitud->userRegistro), 'TRLB', 0, 'C', 1);
    }

    function Footer() {
        $this->firmas();
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->SetY($this->GetPageHeight() - 1);
        $this->SetFont('Arial', '', $this->txtFooterTam);
        $this->Cell(6.5, .4, utf8_decode('Fecha de Consulta: ' . date('Y-m-d g:i a')), 0, 0, 'L');
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->Cell(6.5, .4, '', 0, 0, 'C');
        $this->Cell(5, .4, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
        $this->SetY($this->GetPageHeight() - 1.3);
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->Cell(6.5, .4, utf8_decode('Formato generado desde SAO.'), 0, 0, 'L');

    }

    function RotatedText($x,$y,$txt,$angle)
    {
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }

    function create() {
        $this->SetMargins(1, 0.5, 1);
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetAutoPageBreak(true,4);

        $this->items();
        $this->Ln();
        $this->motivo();
        try {
            $this->Output('I', 'Solicitud de cambio ('. $this->solicitud->tipoOrden->descripcion .') #'.
                $this->solicitud->numero_folio .'.pdf', 1);
        } catch (\Exception $ex) {
            dd($ex);
        }
        exit;
    }
}