<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 07/03/2018
 * Time: 10:47 AM
 */

namespace Ghi\Domain\Core\Formatos\Compras;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\Moneda;
use Ghi\Domain\Core\Models\Obra;
use Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion;
use Ghidev\Fpdf\Rotation;

class ComparativaCotizacionesCompra extends Rotation
{

    //Constantes utilizadas para la calcular las dimensiones del logotipo
    const DPI = 96;
    const MM_IN_INCH = 25.4;
    const MAX_HEIGHT = 45;

    //Constante utilizada para determinar el número de cotizaciones que se mostrarán a lo ancho de cada página
    const MAX_COTIZACIONES_PP = 5;

    const TAMANO_CONTENIDO = 6;
    const TAMANO_TITULO = 12;
    const TAMANO_SUBTITULO = 9;

    /**
     * @var Requisicion
     */
    protected $requisicion;

    /**
     * @var array
     */
    var $items, $cotizaciones, $subtotales;

    /**
     * @var int
     */
    var $num_cotizaciones, $restantes, $acumuladas, $x_i, $y_i;

    /**
     * @var Obra
     */
    var $obra;

    /**
     * ComparativaCotizacionesContrato constructor.
     * @param Requisicion $requisicion
     */
    public function __construct(Requisicion $requisicion) {

        parent::__construct('L', 'cm', 'A3');

        $this->obra = Obra::find(Context::getId());

        $this->requisicion = $requisicion;
        $this->items = $requisicion->items()->with('material')->get()->toArray();
        $this->cotizaciones = $requisicion->cotizacionesCompra()->with('cotizaciones.moneda')->orderBy('monto')->get()->toArray();
        $this->num_cotizaciones = count($this->cotizaciones);
        $this->restantes = $this->num_cotizaciones;

        /*Se inicializa la variable $subtotales como arreglo vacío lista para recibir datos por cada una de las monedas,
         * Dicha variable servida para almacenar los subtotales para cada cotización y tipo de moneda registrado en el sistema
         */

        foreach ($this->cotizaciones as $index => $cotizacion) {
            $this->subtotales[$index] = [];
        }
    }

    function Header()
    {
        $this->encabezados();

        $this->SetFillColor(220);
        $this->SetFont('Arial', '', self::TAMANO_CONTENIDO);
        $this->y_i = $this->y;
        $this->Cell(($this->w - 2) * 0.200, 3, utf8_decode('PARTIDA / CONCEPTO / ACTIVIDAD'), 'TLBR', 0, 'C');
        $this->Cell(($this->w - 2) * 0.050, 3, utf8_decode('CANTIDAD'), 'TBR', 0, 'C');
        $this->Cell(($this->w - 2) * 0.050, 3, utf8_decode('UNIDAD'), 'TBR', 0, 'C');
        $this->x_i = $this->x;

        for ($i = 0; $i < self::MAX_COTIZACIONES_PP && $i < ($this->num_cotizaciones - $this->acumuladas); $i++) {

            foreach (Moneda::all() as $moneda) {
                isset($this->subtotales[$i + $this->acumuladas][$moneda->id_moneda]) ? : $this->subtotales[$i + $this->acumuladas][$moneda->id_moneda] = 0;
            }

            $cotizacion = $this->requisicion->cotizacionesCompra()->orderBy('monto')->get()[$i + $this->acumuladas];

            $this->y = $this->y_i;
            $this->x = $this->x_i;

            $this->Cell(($this->w - 2) * (0.7 / self::MAX_COTIZACIONES_PP), 0.45, utf8_decode('EMPRESA # ' . ($this->acumuladas + 1 + $i)), 'TR', 2, 'C');
            $this->CellFitScale(($this->w - 2) * (0.7 / self::MAX_COTIZACIONES_PP), 0.45, utf8_decode($cotizacion->empresa), 'LR', 2, 'C', '1');
            $this->Cell(($this->w - 2) * (0.7 / self::MAX_COTIZACIONES_PP), 0.45, utf8_decode($cotizacion->sucursal ? $cotizacion->sucursal->contacto : '---'), 'LR', 2, 'C');
            $this->Cell(($this->w - 2) * (0.7 / self::MAX_COTIZACIONES_PP), 0.45, utf8_decode('Tel: ' . ($cotizacion->sucursal ? $cotizacion->sucursal->telefono : '--')), 'LR', 2, 'C', 1);
            $this->Cell(($this->w - 2) * (0.7 / self::MAX_COTIZACIONES_PP), 0.45, utf8_decode($cotizacion->sucursal ? $cotizacion->sucursal->email : ''), 'R', 2, 'C');
            $this->Cell(($this->w - 2) * (0.7 / self::MAX_COTIZACIONES_PP), 0.45, utf8_decode('Validez de Oferta:'), 'RLB', 2, 'C', 1);
            $this->Cell(($this->w - 2) * (0.7 / ((10/3) * self::MAX_COTIZACIONES_PP)), 0.3, utf8_decode('MONEDA'), 'BR', 0, 'C');
            $this->Cell(($this->w - 2) * (0.7 / ((10/3) * self::MAX_COTIZACIONES_PP)), 0.3, utf8_decode('P.U.'), 'BR', 0, 'C');
            $this->Cell(($this->w - 2) * (0.7 / (2.5 * self::MAX_COTIZACIONES_PP)), 0.3, utf8_decode('IMPORTE'), 'BR', 0, 'C');

            $this->x_i = $this->x;

        }
        $this->Ln(0.75);

    }

    protected function encabezados() {
        $this->logo();
        $this->SetXY(1, 1);
        $this->SetFont('Arial', 'UB', self::TAMANO_SUBTITULO);
        $this->Cell(($this->w - 2) * 0.40,1.05,utf8_decode($this->obra->constructora),'BR',0,'R');
        $this->y = 1;
        $this->SetFont('Arial', '', self::TAMANO_TITULO);
        $this->Cell(($this->w - 2) * 0.6,1.05,'TABLA COMPARATIVA DE COTIZACIONES','BR',2,'C');
        $this->Ln(0.15);

        $this->SetFont('Arial', 'B', self::TAMANO_CONTENIDO);

        $this->y_i = $this->y;
        $this->Cell(($this->w - 2) * 0.200, 0.35, utf8_decode('Proyecto:'), '', 2, 'R');
        $this->Cell(($this->w - 2) * 0.200, 0.35, utf8_decode('Número de concurso:'), '', 2, 'R');
        $this->Cell(($this->w - 2) * 0.200, 0.35, utf8_decode('Descripción de la compra:'), '', 0, 'R');

        $this->y = $this->y_i;

        $this->SetFont('Arial', '', self::TAMANO_CONTENIDO);
        $this->SetFillColor(220);
        $this->Cell(($this->w - 2) * 0.8, 0.35, utf8_decode($this->obra->nombre), '', 2, 'L');
        $this->Cell(($this->w - 2) * 0.8, 0.35, '#' . $this->requisicion['numero_folio'], 'TB', 2, 'L');
        $this->MultiCell(($this->w - 2) * 0.8, 0.35, utf8_decode($this->requisicion['observaciones']), 'TB', 'L', 1);

        $this->Ln(0.15);


    }

    function logo() {
        $data = $this->obra->logotipo;
        $data = pack('H*', hex2bin($data));
        $file = public_path('img/logo_temp.png');
        if (file_put_contents($file, $data) !== false) {
            list($width, $height) = $this->resizeToFit($file);
            $this->Image($file, 1, 1, $width, $height);
            unlink($file);
        }
    }

    function pixelsToCM($val) {
        return ($val * self::MM_IN_INCH / self::DPI) / 10;
    }

    function resizeToFit($imgFilename) {
        list($width, $height) = getimagesize($imgFilename);
        $scale = self::MAX_HEIGHT / $height;
        return [
            round($this->pixelsToCM($scale * $width)),
            round($this->pixelsToCM($scale * $height))
        ];
    }

    protected function items() {
        foreach ($this->items as $index => $item_requisicion) {

            $widths = [($this->w - 2) * 0.020, ($this->w - 2) * 0.180, ($this->w - 2) * 0.050, ($this->w - 2) * 0.050];
            $fills = ['255,255,255', '255,255,255', '255,255,255', '255,255,255'];
            $aligns = ['L', 'L', 'R', 'L'];
            $row = [
                $index + 1,
                utf8_decode($item_requisicion['material']['descripcion']),
                $item_requisicion['unidad'] ? number_format($item_requisicion['cantidad'], 2, '.', ',') : '',
                $item_requisicion['unidad']
            ];

            for($i = 0; $i < self::MAX_COTIZACIONES_PP && $i < ($this->num_cotizaciones - $this->acumuladas); $i++) {

                $item_cotizacion = head(array_where($this->cotizaciones[$i + $this->acumuladas]['cotizaciones'], function ($key, $value) use ($item_requisicion) {
                    return $value['id_material'] == $item_requisicion['id_material'];
                }));

                if(! is_null($item_cotizacion['id_moneda']))
                    $this->subtotales[$i + $this->acumuladas][$item_cotizacion['id_moneda']] += ($item_cotizacion['precio_unitario'] * $item_requisicion['cantidad']);

                array_push($widths, ($this->w - 2) * (0.7 / ((10/3) * self::MAX_COTIZACIONES_PP)));
                array_push($widths, ($this->w - 2) * (0.7 / ((10/3) * self::MAX_COTIZACIONES_PP)));
                array_push($widths, ($this->w - 2) * (0.7 / (2.5 * self::MAX_COTIZACIONES_PP)));
                array_push($fills, '255,255,255');
                array_push($fills, '255,255,255');
                array_push($fills, '255,255,255');
                array_push($aligns, 'L');
                array_push($aligns, 'R');
                array_push($aligns, 'R');

                array_push($row, isset($item_cotizacion['moneda']['abreviatura']) ? trim($item_cotizacion['moneda']['abreviatura']) : '');
                array_push($row, isset($item_cotizacion['precio_unitario']) ? '$ ' . number_format($item_cotizacion['precio_unitario'], 2, '.', ',') : '');
                array_push($row, isset($item_cotizacion['precio_unitario']) ? '$ ' . number_format($item_cotizacion['precio_unitario'] * $item_requisicion['cantidad'], 2, '.', ',') : '');
            }

            $this->SetWidths($widths);
            $this->SetHeights([0.3]);
            $this->SetAligns($aligns);
            $this->SetFills($fills);
            $this->SetFont('Arial', '', self::TAMANO_CONTENIDO);

            $this->Row($row);
        }
        $this->Ln(0.25);
        //Subtotales
        if($this->h - $this->y <= 5.7) {
            $this->AddPage();
        }
        $this->subtotales();
    }

    private function subtotales() {
        $this->y_i = $this->y;

        $this->Cell(($this->w - 2) * 0.300, 0.3, '', 'TL', '1', 'R');

        $total_txt = '';
        foreach (Moneda::all() as $index => $moneda) {
            $this->Cell(($this->w - 2) * 0.300, 0.3, 'SUB ' . trim($moneda->abreviatura), 'TL', '1', 'R');
            if($index != 0)
                $total_txt .= ' + ';
            if ($moneda->tipo != 1) {
                $this->Cell(($this->w - 2) * 0.300, 0.3, 'TIPO DE CAMBIO ' . trim($moneda->abreviatura), 'TL', '1', 'R');
                $total_txt .= '(SUB ' . trim($moneda->abreviatura) . ' * TIPO DE CAMBIO ' . trim($moneda->abreviatura) . ')';
            } else{
                $total_txt .= 'SUB ' . trim($moneda->abreviatura);
            }
        }


        $this->Cell(($this->w - 2) * 0.300, 0.3, utf8_decode($total_txt), 'TL', '1', 'R');
        $this->Cell(($this->w - 2) * 0.300, 0.3, 'I.V.A. 16%', 'TL', '1', 'R');
        $this->Cell(($this->w - 2) * 0.300, 0.3, 'TOTAL', 'LB', '0', 'R');

        $this->x_i = $this->x;

        for ($i = 0; $i < self::MAX_COTIZACIONES_PP && $i < ($this->num_cotizaciones - $this->acumuladas); $i++) {

            $cotizacion = $this->cotizaciones[$i + $this->acumuladas];

            //Determinar el color de acuerdo a la posición de cada cotización considerando que están ordenadas por monto
            switch ($i + $this->acumuladas) {
                case 0 :
                    $this->SetFillColor(255, 0, 0);
                    break;
                case 1:
                    $this->SetFillColor(255, 128, 0);
                    break;
                case 2:
                    $this->SetFillColor(255, 255, 0);
                    break;
                default:
                    $this->SetFillColor(200, 200, 200);
                    break;
            }

            $this->SetFont('Arial', 'B', self::TAMANO_CONTENIDO);

            $this->y = $this->y_i;

            $nf = new \NumberFormatter(\Locale::ACTUAL_LOCALE, \NumberFormatter::ORDINAL);
            $this->Cell(($this->w - 2) * (1.4 / (2 * self::MAX_COTIZACIONES_PP)), 0.3, utf8_decode($nf->format(($i + 1 + $this->acumuladas)) . ' lugar'), 'TLR', 2, 'C', 1);
            $this->SetFont('Arial', '', self::TAMANO_CONTENIDO);


            $subtotal = 0;
            foreach (Moneda::all() as $moneda) {
                $this->Cell(($this->w - 2) * (1.4 / (2 * self::MAX_COTIZACIONES_PP)), 0.3, '$ ' . number_format($this->subtotales[$i + $this->acumuladas][$moneda->id_moneda], 2, '.', ','), 'TLR', 2, 'R');
                if($moneda->tipo != 1) {
                    if(trim($moneda->abreviatura) == 'USD') {
                        $subtotal += $this->subtotales[$i + $this->acumuladas][$moneda->id_moneda] * $cotizacion['TcUSD'];
                        $this->Cell(($this->w - 2) * (1.4 / (2 * self::MAX_COTIZACIONES_PP)), 0.3, '$ ' . number_format($cotizacion['TcUSD'], 2, '.', ','), 'LR', 2, 'R');
                    } else if(trim($moneda->abreviatura) == 'EUROS') {
                        $subtotal += $this->subtotales[$i + $this->acumuladas][$moneda->id_moneda] * $cotizacion['TcEuro'];
                        $this->Cell(($this->w - 2) * (1.4 / (2 * self::MAX_COTIZACIONES_PP)), 0.3, '$ ' . number_format($cotizacion['TcEuro'], 2, '.', ','), 'LR', 2, 'R');
                    }
                } else {
                    $subtotal += $this->subtotales[$i + $this->acumuladas][$moneda->id_moneda];
                }
            }

            $this->Cell(($this->w - 2) * (1.4 / (2 * self::MAX_COTIZACIONES_PP)), 0.3, '$ ' . number_format($subtotal, 2, '.', ','), 'LRBT', 2, 'R');
            $this->Cell(($this->w - 2) * (1.4 / (2 * self::MAX_COTIZACIONES_PP)), 0.3, '$ ' . number_format($subtotal * 0.16, 2, '.', ','), 'TLR', 2, 'R');
            $this->Cell(($this->w - 2) * (1.4 / (2 * self::MAX_COTIZACIONES_PP)), 0.3, '$ ' . number_format($subtotal * 1.16, 2, '.', ','), 'BLR', 0, 'R');

        }
        $this->Ln(0.75);
        $this->acumuladas += $i;
    }

    function Footer() {
        $this->firmas();
        $this->SetY($this->h - 0.5);
        $this->SetFont('Arial', '', 6);
        $this->Cell(($this->w - 2) /3, .4, utf8_decode('Formato generado desde SAO.'), '', 0, 'L');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(($this->w - 2) /3, .4, '', '', 0, 'C');
        $this->Cell(($this->w - 2) /3, .4, utf8_decode('Página ') . $this->PageNo() . '/{nb}', '', 0, 'R');
    }

    function firmas() {
        $this->SetY(-2.65);
        $this->SetTextColor('0', '0', '0');
        $this->SetFont('Arial', '', self::TAMANO_CONTENIDO);
        $this->SetFillColor(200, 200, 200);

        $this->y_i = $this->y;

        $this->Cell(($this->w - 8) / 7 , 0.4, utf8_decode('Elaboró'), '', 2, 'C');
        $this->Cell(($this->w - 8) / 7, 1, '', '', 2, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(($this->w - 8) / 7, 0.3, utf8_decode('Carlos Job Rojas Ochoa'), 'T', 2, 'C');
        $this->SetFont('Arial', '', 6);
        $this->Cell(($this->w - 8) / 7, 0.2, utf8_decode('Coordinador de Procuración'), '', 0, 'C');

        $this->Cell(1);
        $this->y = $this->y_i;

        $this->Cell(($this->w - 8) / 7 , 0.4, utf8_decode('Revisó'), '', 2, 'C');
        $this->Cell(($this->w - 8) / 7, 1, '', 'B', 2, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(($this->w - 8) / 7, 0.3, utf8_decode('Miguel Ángel Lara Hernández'), '', 2, 'C');
        $this->SetFont('Arial', '', 6);
        $this->Cell(($this->w - 8) / 7, 0.2, utf8_decode('Gerente de Construcción'), '', 0, 'C');

        $this->Cell(1);
        $this->y = $this->y_i;

        $this->Cell(($this->w - 8) / 7 , 0.4, utf8_decode('Revisó'), '', 2, 'C');
        $this->Cell(($this->w - 8) / 7, 1, '', '', 2, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(($this->w - 8) / 7, 0.3, utf8_decode('Efraín Susano Rivera'), 'T', 2, 'C');
        $this->SetFont('Arial', '', 6);
        $this->Cell(($this->w - 8) / 7, 0.2, utf8_decode('Especialista en Arquitectura'), '', 0, 'C');

        $this->Cell(1);
        $this->y = $this->y_i;

        $this->Cell(($this->w - 8) / 7 , 0.4, utf8_decode('Revisó'), '', 2, 'C');
        $this->Cell(($this->w - 8) / 7, 1, '', '', 2, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(($this->w - 8) / 7, 0.3, utf8_decode('Alejandro Chong de la Rosa'), 'T', 2, 'C');
        $this->SetFont('Arial', '', 6);
        $this->Cell(($this->w - 8) / 7, 0.2, utf8_decode('Gerente de Procuración'), '', 0, 'C');

        $this->Cell(1);
        $this->y = $this->y_i;

        $this->Cell(($this->w - 8) / 7 , 0.4, utf8_decode('Vo.Bo.'), '', 2, 'C');
        $this->Cell(($this->w - 8) / 7, 1, '', '', 2, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(($this->w - 8) / 7, 0.3, utf8_decode('Juan Antonio Hernández Carrillo'), 'T', 2, 'C');
        $this->SetFont('Arial', '', 6);
        $this->Cell(($this->w - 8) / 7, 0.2, utf8_decode('Director de Construcción'), '', 0, 'C');

        $this->Cell(1);
        $this->y = $this->y_i;

        $this->Cell(($this->w - 8) / 7 , 0.4, utf8_decode('Vo.Bo.'), '', 2, 'C');
        $this->Cell(($this->w - 8) / 7, 1, '', '', 2, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(($this->w - 8) / 7, 0.3, utf8_decode('Enrique Martín Medina Muguiro'), 'T', 2, 'C');
        $this->SetFont('Arial', '', 6);
        $this->Cell(($this->w - 8) / 7, 0.2, utf8_decode('Director de Procuración'), '', 0, 'C');

        $this->Cell(1);
        $this->y = $this->y_i;

        $this->Cell(($this->w - 8) / 7 , 0.4, utf8_decode('Autorizó'), '', 2, 'C');
        $this->Cell(($this->w - 8) / 7, 1, '', '', 2, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(($this->w - 8) / 7, 0.3, utf8_decode('Francisco Gabriel Ramírez Ordaz'), 'T', 2, 'C');
        $this->SetFont('Arial', '', 6);
        $this->Cell(($this->w - 8) / 7, 0.2, utf8_decode('Director de Proyecto'), '', 0, 'C');
    }

    public function create() {
        $this->SetMargins(1, 0.5, 1);
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetAutoPageBreak(true,3);

        for($i = 0; $i < (ceil($this->num_cotizaciones / self::MAX_COTIZACIONES_PP)); $i++) {
            $this->items();
            if($this->acumuladas < $this->num_cotizaciones) {
                $this->AddPage();
            }
        }
        try {
            return $this;
        } catch (\Exception $ex) {
            dd($ex);
        }
        exit;
    }
}