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
use Ghi\Domain\Core\Models\ControlPresupuesto\AfectacionOrdenesPresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartidaHistorico;
use Ghi\Domain\Core\Models\ControlPresupuesto\VariacionVolumen;
use Ghidev\Fpdf\Rotation;
use Ghi\Domain\Core\Models\Obra;
use Illuminate\Support\Facades\DB;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;

class PDFVariacionVolumen extends Rotation {

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
     * @param VariacionVolumen $solicitud
     * @param SolicitudCambioPartidaRepository $partidas
     */
    public function __construct(VariacionVolumen $solicitud, SolicitudCambioPartidaRepository $partidas)
    {
        parent::__construct('L', 'cm', 'A4');

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
        $this->Ln(1);

        if($this->encola == 'partidas') {
            $this->SetWidths(array(0.03 * $this->WidthTotal, 0.05 * $this->WidthTotal, 0.42 * $this->WidthTotal, 0.07
                * $this->WidthTotal, 0.07 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal));
            $this->SetStyles(array('DF', 'DF', 'DF', 'FD', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF'));
            $this->SetFills(array('180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.3));
            $this->SetAligns(array('R', 'R', 'R', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
            $this->Row(array('#', 'No. Tarjeta', utf8_decode("Descripción"), utf8_decode("Unidad"), utf8_decode("Precio Unitario"), utf8_decode("Volúmen Original"), utf8_decode("Volúmen del Cambio"), utf8_decode("Volúmen Actualizado"), utf8_decode("Importe Original"), utf8_decode("Importe del Cambio"), utf8_decode("Importe Actualizado") ));

            $this->SetFont('Arial', '', 6);
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('L', 'L', 'L', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R'));
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
        else if ($this->encola == 'resumen_h') {
            $this->SetX(($this->WidthTotal * .6) + 1);
            $this->SetFont('Arial', '', 6);
            $this->SetStyles(array('DF', 'DF'));
            $this->SetFills(array('180,180,180', '180,180,180'));
            $this->SetTextColors(array('0,0,0', '0,0,0'));
            $this->SetHeights(array(0.38));
            $this->SetAligns(array('C', 'C'));
            $this->SetWidths(array(0.2 * $this->WidthTotal, 0.2 * $this->WidthTotal));
        } else if($this->encola == 'resumen') {
            $this->SetFills(array('255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0'));
            $this->SetHeights(array(0.38));
            $this->SetAligns(array('L', 'R'));
            $this->SetWidths(array(0.2* $this->WidthTotal, 0.2* $this->WidthTotal));
            $this->SetX(($this->WidthTotal * .6) + 1);
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

        $aplicadaTitulo =' ('. (!$this->solicitud->aplicada ? 'no ' : '') .'Aplicada)';

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.35, utf8_decode('Obra:'), '', 0, 'LB');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.35, utf8_decode($this->obra->nombre), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.35, utf8_decode('Tipo de solicitud:'), '', 0, 'LB');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.35, utf8_decode($this->solicitud->tipoOrden->descripcion), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.35, utf8_decode('Tipo de Cobrabilidad:'), '', 0, 'LB');
        $this->SetFont('Arial', '', '#'.$this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.35, utf8_decode($this->solicitud->tipoOrden->cobrabilidad), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.35, utf8_decode('Número de Folio:'), '', 0, 'LB');
        $this->SetFont('Arial', '', '#'.$this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.35, utf8_decode('#' . $this->solicitud->numero_folio), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.35, utf8_decode('Area Solicitante:'), '', 0, 'LB');
        $this->SetFont('Arial', '', '#'.$this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.35, utf8_decode($this->solicitud->area_solicitante), '', 1, 'L');


        $this->SetFont('Arial', 'B', '#'.$this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.35, utf8_decode('Fecha Solicitud:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.35, utf8_decode(Carbon::parse($this->solicitud->fecha_solicitud)->format('d-m-Y')), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.35, utf8_decode('Persona que Solicita:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.35, utf8_decode($this->solicitud->userRegistro), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.35, utf8_decode('Estatus:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.35, utf8_decode(strtoupper($this->solicitud->estatus . $aplicadaTitulo)), '', 1, 'L');
    }

    function items(){
        $tipo_orden = 0;
        foreach ($this->solicitud->partidas as $index => $p)
            $tipo_orden = $p['id_tipo_orden'];

        $baseDatos = AfectacionOrdenesPresupuesto::where('id_tipo_orden', '=', $tipo_orden)->with('baseDatos')->get();

        foreach ($baseDatos as $bi => $base)
        {
            $siAplicada = false;

            if ($aplicacion = $this->solicitud->aplicaciones()->wherePivot('aplicada', '=', true)->where('id', '=', $base->id_base_presupuesto)->first()) {
                $siAplicada  = true;
            }

            $aplicadaTitulo =' ('. (empty($siAplicada) ? 'NO ' : '') .'APLICADA)';
            $tituloBase = 'PRESUPUESTO DE '. $base->baseDatos->descripcion . $aplicadaTitulo;
            $this->SetFont('Arial', 'B', $this->txtSeccionTam);
            $this->Cell($this->WidthTotal, 0.5, utf8_decode($tituloBase),
                'TRLB', 0, 'C');
            $this->Ln();

            $estaSolicitudSuma = 0;
            $contador = 1;
            $partidasRow = [];
            foreach ($this->solicitud->partidas as $i => $p)
            {
                $partida = $p->find($p->id);
                $conceptoBase = DB::connection('cadeco')->table($base->baseDatos->base_datos . ".dbo.conceptos")->where('clave_concepto', '=', $partida->concepto->clave_concepto)->first();

                $items = DB::connection('cadeco')->table($base->baseDatos->base_datos . ".dbo.conceptos")->orderBy('nivel', 'ASC')->where('id_obra', '=', Context::getId())->where('nivel', 'like', $conceptoBase->nivel . '%')->get();

                $this->encola = 'partidas';

                $historico = SolicitudCambioPartidaHistorico::where('id_solicitud_cambio_partida', '=', $partida->id)
                    ->where('id_base_presupuesto', '=', $base->id_base_presupuesto)
                    ->where('nivel', '=', $conceptoBase->nivel)
                    ->first();

                $factor = $partida->cantidad_presupuestada_nueva / $partida->cantidad_presupuestada_original;

                // Si ya existe el histórico, muestra esa info
                if($historico) {
                    $cantidadPresupuestada =  $historico->cantidad_presupuestada_original;
                    $cantidadNueva =  $historico->cantidad_presupuestada_actualizada;
                    $monto_presupuestado = $historico->monto_presupuestado_original;
                    $monto_nuevo = $historico->monto_presupuestado_actualizado;
                    $variacion_volumen =  $historico->cantidad_presupuestada_actualizada - $historico->cantidad_presupuestada_original;
                    $variacion_importe =  ($historico->monto_presupuestado_actualizado - $historico->monto_presupuestado_original);
                } else {
                    $cantidadPresupuestada = $conceptoBase->cantidad_presupuestada;
                    $cantidadNueva = ($conceptoBase->cantidad_presupuestada * $factor);
                    $monto_presupuestado = $conceptoBase->monto_presupuestado;
                    $monto_nuevo = ($conceptoBase->monto_presupuestado * $factor);
                    $variacion_volumen = ($conceptoBase->cantidad_presupuestada * $factor) - $conceptoBase->cantidad_presupuestada;
                    $variacion_importe = ($conceptoBase->monto_presupuestado * $factor) - $conceptoBase->monto_presupuestado;
                }

                //Calcula total de esta solicitud
                $estaSolicitudSuma = $estaSolicitudSuma + ($variacion_importe);

                $partidasRow[$i] = [
                    $contador++,
                    utf8_decode($partida->numeroTarjeta->descripcion), // Número de tarjeta
                    utf8_decode($conceptoBase->descripcion),  // Descripción
                    utf8_decode($conceptoBase->unidad), // Unidad
                    '$ ' . number_format($conceptoBase->precio_unitario, 2, '.', ','), // Precio unitario
                    number_format($cantidadPresupuestada, 2, '.', ','), // Vólumen Original
                    number_format($variacion_volumen, 2, '.', ','), // Vólumen del cambio
                    number_format($cantidadNueva, 2, '.', ','),  // Vólumen actualizado
                    '$ '. number_format($monto_presupuestado, 2, '.', ','), // Importe original
                    '$ '. number_format($variacion_importe, 2, '.', ','), // Importe del cambio
                    '$ '. number_format($monto_nuevo, 2, '.', ','), // Importe actualizado
                ];
            }

            $conceptoCD = DB::connection('cadeco')->table($base->baseDatos->base_datos . ".dbo.conceptos")
                ->select('monto_presupuestado')->where('descripcion', 'like', '%costo directo%')->first();


            //Tabla
            $this->SetWidths(array(0));
            $this->SetFills(array('255,255,255'));
            $this->SetTextColors(array('1,1,1'));
            $this->SetHeights(array(0));
            $this->SetFont('Arial', 'B', $this->txtSeccionTam);
            $this->SetTextColors(array('255,255,255'));

            $this->SetFont('Arial', '', 6);
            $this->SetStyles(array('DF', 'DF', 'DF', 'FD', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF'));
            $this->SetFills(array('180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.28));
            $this->SetAligns(array('L', 'L', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
            $this->SetWidths(array(0.03 * $this->WidthTotal, 0.05 * $this->WidthTotal, 0.42 * $this->WidthTotal, 0.07
                * $this->WidthTotal, 0.07 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal));
            $this->Row(array('#', 'No. Tarjeta', utf8_decode("Descripción"), utf8_decode("Unidad"), utf8_decode("Precio Unitario"), utf8_decode("Volúmen Original"), utf8_decode("Volúmen del Cambio"), utf8_decode("Volúmen Actualizado"), utf8_decode("Importe Original"), utf8_decode("Importe del Cambio"), utf8_decode("Importe Actualizado") ));

            $this->SetFont('Arial', '', 6);
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('L', 'L', 'L', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R'));
            $this->SetWidths(array(0.03 * $this->WidthTotal, 0.05 * $this->WidthTotal, 0.42 * $this->WidthTotal, 0.07
                * $this->WidthTotal, 0.07 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal));

            $this->encola = 'partidas';

            foreach ($partidasRow as $i => $p){
                $this->Row($p);

            }
            $this->encola = '';

            $this->resumen([
                'PRESUPUESTO '. $base->baseDatos->descripcion .' C. D.' => '$'. number_format
                    ($conceptoCD->monto_presupuestado, 2, '.', ','),
                'ESTA SOLICITUD' => '$'. number_format($estaSolicitudSuma, 2, '.', ','),
                'COSTO DIRECTO ACTUALIZADO' => '$'.number_format($conceptoCD->monto_presupuestado +
                    ($estaSolicitudSuma), 2, '.', ',')
            ]);
            if($bi != count($baseDatos) - 1) {
                $this->AddPage();
            } else {
                $this->Ln();
            }
        }
    }

    function resumen($data = array())
    {
        $this->Ln();
        $this->SetX(($this->WidthTotal * .6) + 1);
        $this->SetFont('Arial', '', 6);
        $this->SetStyles(array('DF', 'DF'));
        $this->SetFills(array('180,180,180', '180,180,180'));
        $this->SetTextColors(array('0,0,0', '0,0,0'));
        $this->SetHeights(array(0.38));
        $this->SetAligns(array('C', 'C'));
        $this->SetWidths(array(0.2 * $this->WidthTotal, 0.2 * $this->WidthTotal));
        $this->encola = 'resumen_h';
        $this->Row(array('Detalle', 'Cantidad'));
        $this->encola = 'resumen';
        $this->SetFills(array('255,255,255', '255,255,255'));
        $this->SetTextColors(array('0,0,0', '0,0,0'));
        $this->SetHeights(array(0.38));
        $this->SetAligns(array('L', 'R'));
        $this->SetWidths(array(0.2 * $this->WidthTotal, 0.2 * $this->WidthTotal));

        foreach ($data as $nombre => $valor)
        {
            $this->SetX(($this->WidthTotal * .6) + 1);
            $this->Row([$nombre, $valor]);
        }

        $this->encola = '';

        $this->Ln(1);

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
        $writer->writeFile(route('control_presupuesto.variacion_volumen.show',[
            'variacion_volumen' => $this->solicitud->id,
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
        $this->Cell(15, .4, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
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
        $this->SetAutoPageBreak(true,5);

        $this->items();
        $this->Ln(-0.75);
        $this->motivo();
        try {
            $this->Output('I', 'Solicitud de cambio ('. $this->solicitud->tipoOrden->descripcion .')#'. $this->solicitud->numero_folio .'.pdf', 1);
        } catch (\Exception $ex) {
            throw $ex;
        }
        exit;
    }
}