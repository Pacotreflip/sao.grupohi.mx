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

use Ghi\Domain\Core\Contracts\ControlPresupuesto\PartidasInsumosAgrupadosRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\ControlPresupuesto\AfectacionOrdenesPresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\PartidasInsumosAgrupados;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartidaHistorico;
use Ghidev\Fpdf\Rotation;
use Ghi\Domain\Core\Models\Obra;
use Illuminate\Support\Facades\DB;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;

class PDFSolicitudCambioInsumos extends Rotation
{

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
    private $agrupacion;
    private $resumen;
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
    public function __construct(SolicitudCambio $solicitud, SolicitudCambioPartidaRepository $partidas, PartidasInsumosAgrupadosRepository $agrupacion)
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
        $this->partidas = $partidas;
        $this->agrupacion = $agrupacion;
    }

    function Header()
    {
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

        if ($this->encola == 'partidas') {
            $this->SetWidths(array(0.02 * $this->WidthTotal, 0.04 * $this->WidthTotal, 0.34 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal));
            $this->SetFont('Arial', '', 6);
            $this->SetStyles(array('DF', 'DF', 'DF', 'FD', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF'));
            $this->SetFills(array('180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.3));
            $this->SetAligns(array('R', 'R', 'R', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
            $this->Row(array('#', 'No. Tarjeta', utf8_decode("Descripción"), utf8_decode("Unidad"), utf8_decode("Costo"), utf8_decode("Variación Costo"), "Costo Actualizado", utf8_decode("Cantidad Original"), utf8_decode("Variacion de Cantidad"), utf8_decode("Cantidad Actualizada"), utf8_decode("Importe Original"), utf8_decode("Variación de Importe"), utf8_decode("Importe Actualizado")));

            $this->SetFont('Arial', '', 6);
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('L', 'L', 'L', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R'));
            $this->SetWidths(array(0.02 * $this->WidthTotal, 0.04 * $this->WidthTotal, 0.34 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal));
        } else if ($this->encola == 'motivo') {

            $this->SetWidths(array($this->WidthTotal));
            $this->SetFills(array('180,180,180'));
            $this->SetTextColors(array('0,0,0'));
            $this->SetHeights(array(0.3));
            $this->SetFont('Arial', '', 6);
            $this->SetAligns(array('C'));


        }
    }

    function titulos()
    {

        $this->SetFont('Arial', '', $this->txtSubtitleTam - 1);

        //Detalles de la Asignación (Titulo)
        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->SetXY($this->GetPageWidth() / 2, 1);
        $this->Cell(0.5 * $this->WidthTotal, 0.7, utf8_decode('SOLICITUD DE CAMBIO AL PRESUPUESTO'), 'TRL', 0, 'C');

        $this->Cell(0.5);
        $this->Cell(0.5 * $this->WidthTotal, .7, '', 0, 1, 'L');

    }

    function detallesAsignacion($x)
    {

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Obra:'), '', 0, 'LB');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.360 * $this->WidthTotal, 0.5, utf8_decode($this->obra->nombre), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->SetX($x);
        $this->Cell(0.125 * $this->WidthTotal, 0.5, utf8_decode('Tipo de solicitud:'), '', 0, 'LB');
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
        $this->CellFitScale(0.375 * $this->WidthTotal, 0.5,'#'.utf8_decode($this->solicitud->numero_folio), '', 1, 'L');

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


        $conceptos_agrupados = $this->agrupacion->with('concepto')->where([['id_solicitud_cambio', '=', $this->solicitud->id]])->all();
        $conceptos_agrupados = $this->partidas->getTotalesClasificacionInsumos($conceptos_agrupados->toArray());

        $tipo_orden = 0;

        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->SetXY($this->GetX(), $this->GetY());
        $this->Cell($this->WidthTotal, 0.7, utf8_decode('CAMBIO DE INSUMOS'), 'TRLB', 0, 'C');
        $this->SetXY($this->GetX(), $this->GetY() + 0.3);
        $this->SetWidths(array(0));
        $this->SetFills(array('255,255,255'));
        $this->SetTextColors(array('1,1,1'));
        $this->SetHeights(array(0));
        $this->Row(Array(''));
        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->SetTextColors(array('255,255,255'));
        $this->MultiCell($this->WidthTotal, .35, utf8_decode($this->solicitud->concepto), 0, 'L');
        $numero_tarjeta = '';

        foreach ($conceptos_agrupados['conceptos'] as $conceptos) {

            $numero_tarjeta = $conceptos['concepto']['numero_tarjeta'];
            $array_data = [];

            $pu = $conceptos['concepto']['importe_anterior'] / $conceptos['concepto']['cantidad_presupuestada'];
            $pa = $conceptos['concepto']['importe_nuevo'] / $conceptos['concepto']['cantidad_presupuestada'];
            $data_info = [
                'num_tarjeta' => $numero_tarjeta,
                'descripcion' => utf8_decode($conceptos['concepto']['descripcion']),
                'unidad' => $conceptos['concepto']['unidad'],
                'pu' => $pu,
                'pu_actualizado' => $pa,
                'variacion_pu' => $pa - $pu,
                'cantidad_original' => $conceptos['concepto']['cantidad_presupuestada'],
                'variacion_cantidad' => '--',
                'cantidad_nueva' => '--',
                'importe_original' => $conceptos['concepto']['importe_anterior'],
                'variacion_importe' => $conceptos['concepto']['variacion'],
                'importe_actualizado' => $conceptos['concepto']['importe_nuevo']

            ];
            array_push($array_data, $data_info);
            //  dd($conceptos['concepto']['descripcion']);

            $this->SetFont('Arial', '', 6);
            $this->SetStyles(array('DF', 'DF', 'DF', 'FD', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF'));
            $this->SetFills(array('180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.28));
            $this->SetAligns(array('L', 'L', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
            $this->SetWidths(array(0.02 * $this->WidthTotal, 0.04 * $this->WidthTotal, 0.34 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal));
            $this->Row(array('#', 'No. Tarjeta', utf8_decode("Descripción"), utf8_decode("Unidad"), utf8_decode("Costo"), utf8_decode("Variación de Costo"), "Costo Actualizado", utf8_decode("Cantidad Original"), utf8_decode("Variacion de Cantidad"), utf8_decode("Cantidad Actualizada"), utf8_decode("Importe Original"), utf8_decode("Variación de Importe"), utf8_decode("Importe Actualizado")));

            $contador = 1;
            $conceptos_agrupados = $this->agrupacion->with('concepto')->where([['id_solicitud_cambio', '=', $this->solicitud->id]])->all();
            $conceptos_agrupados = $this->partidas->getTotalesClasificacionInsumos($conceptos_agrupados->toArray());

            $this->resumen = $conceptos_agrupados;
            $partidas = $this->partidas->getClasificacionInsumos(['id_solicitud_cambio' => $this->solicitud->id, 'id_concepto' => $conceptos['id_concepto']]);


            if ($this->solicitud->id_estatus == 2) { //historico

                //  $clasificacion = $this->partidas->getClasificacionInsumos($solicitud->id);


                foreach ($partidas as $partida) {
                    foreach ($partida['items'] as $item) {
                        $data_info = [
                            'num_tarjeta' => $numero_tarjeta,
                            'descripcion' => utf8_decode($item->material->descripcion),
                            'unidad' => $item->material->unidad,
                            'pu' => $item->precio_unitario_original,
                            'variacion_pu' => ($item->precio_unitario_nuevo == null ? 0 : $item->precio_unitario_nuevo - $item->precio_unitario_original),
                            'pu_actualizado' => $item->precio_unitario_nuevo == null ? 0 : $item->precio_unitario_nuevo,
                            'cantidad_original' => $item->cantidad_presupuestada,
                            'variacion_cantidad' => $item->cantidad_presupuestada_nueva == null ? 0 : $item->cantidad_presupuestada_nueva - $item->cantidad_presupuestada,
                            'cantidad_nueva' => $item->cantidad_presupuestada_nueva == null ? 0 : $item->cantidad_presupuestada_nueva,
                            'importe_original' => $item->cantidad_presupuestada * $item->precio_unitario_original,
                            'variacion_importe' => $item->monto_presupuestado - ($item->cantidad_presupuestada * $item->precio_unitario_original),
                            'importe_actualizado' => $item->monto_presupuestado

                        ];
                        array_push($array_data, $data_info);

                    }

                }
            } else {

                $partidas = $this->partidas->getClasificacionInsumos(['id_solicitud_cambio' => $this->solicitud->id, 'id_concepto' => $conceptos['id_concepto']]);
                foreach ($partidas as $partida) {
                    foreach ($partida['items'] as $item) {

                       // dd($item);
                        $data_info = [
                            'num_tarjeta' => $numero_tarjeta,
                            'descripcion' => $item->material->descripcion,
                            'unidad' => $item->material->unidad,
                            'pu' => $item->precio_unitario_original,
                            'variacion_pu' => ($item->precio_unitario_nuevo == null ? 0 : $item->precio_unitario_nuevo - $item->precio_unitario_original),
                            'pu_actualizado' => $item->precio_unitario_nuevo == null ? 0 : $item->precio_unitario_nuevo,
                            'cantidad_original' => $item->cantidad_presupuestada,
                            'variacion_cantidad' => $item->cantidad_presupuestada_nueva == null ? 0 : $item->cantidad_presupuestada_nueva - $item->cantidad_presupuestada,
                            'cantidad_nueva' => $item->cantidad_presupuestada_nueva == null ? 0 : $item->cantidad_presupuestada_nueva,
                            'importe_original' => $item->cantidad_presupuestada*$item->precio_unitario_original,
                            'variacion_importe' => $item->monto_presupuestado-($item->cantidad_presupuestada*$item->precio_unitario_original),
                            'importe_actualizado' => $item->monto_presupuestado


                        ];
                        array_push($array_data, $data_info);

                    }

                }
            }

            $this->SetFont('Arial', '', 6);
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('L', 'L', 'L', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R'));
            $this->SetWidths(array(0.02 * $this->WidthTotal, 0.04 * $this->WidthTotal, 0.34 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal, 0.06 * $this->WidthTotal));
            $this->encola = 'partidas';
            //dd($array_data);
            foreach ($array_data as $contador => $row) {


                $this->Row([
                    ($contador + 1),
                    $numero_tarjeta,
                    $row['descripcion'],
                    utf8_decode($row['unidad']),
                    '$ ' . number_format($row['pu'], 2, '.', ','),
                    '$ ' . number_format($row['variacion_pu'], 2, '.', ','),
                    '$ ' . number_format($row['pu_actualizado'], 2, '.', ','),
                    number_format($row['cantidad_original'], 2, '.', ','),

                    $row['variacion_cantidad'] != '--' ? number_format($row['variacion_cantidad'], 2, '.', ',') : $row['variacion_cantidad'],
                    $row['cantidad_nueva'] != '--' ? number_format($row['cantidad_nueva'], 2, '.', ',') : $row['cantidad_nueva'],
                    '$ ' . number_format($row['importe_original'], 2, '.', ','),
                    '$ ' . number_format($row['variacion_importe'], 2, '.', ','),
                    '$ ' . number_format($row['importe_actualizado'], 2, '.', ',')
                ]);


            }
        }



        $this->Ln(1);
        $this->encola = '';
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


        if($this->getY()>13){
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
        $this->Row(['Conceptos Modificados', count($this->resumen['conceptos'])]);
        $this->SetX(17.52);
        $this->Row(['Importe Conceptos Modificados', '$ ' . number_format($this->resumen['imp_nuevo_gen'] - $this->resumen['total_variaciones'], 2, '.', ',')]);
        $this->SetX(17.52);
        $this->Row([utf8_decode('Importe Variación'), '$ ' . number_format($this->resumen['total_variaciones'], 2, '.', ',')]);
        $this->SetX(17.52);
        $this->Row(['Importe Conceptos Actualizados', '$ ' . number_format($this->resumen['imp_nuevo_gen'], 2, '.', ',')]);
        $this->SetX(17.52);
        $this->Row(['Importe Presupuesto Actual', '$ ' . number_format($this->resumen['total_presupuesto'], 2, '.', ',')]);
        $this->SetX(17.52);
        $this->Row(['Importe Presupuesto Nuevo', '$ ' . number_format(($this->resumen['total_presupuesto'] + $this->resumen['total_variaciones']), 2, '.', ',')]);
        $this->Ln(1);


        //  dd($this->resumen);
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

        $this->resumen();
        $this->motivo();
        try {
            $this->Output('I', 'Solicitud de cambio (' . $this->solicitud->tipoOrden->descripcion . ')#' . $this->solicitud->numero_folio . '.pdf', 1);
        } catch (\Exception $ex) {
            dd($ex);
        }
        exit;
    }
}