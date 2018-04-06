<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 03/04/2018
 * Time: 02:50 PM
 */

namespace Ghi\Api\Controllers\v1;


use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Contracts\ContratoProyectadoRepository;
use Ghi\Domain\Core\Formatos\Compras\ComparativaCotizacionesCompra;
use Ghi\Domain\Core\Formatos\Contratos\ComparativaCotizacionesContrato;
use Ghi\Http\Controllers\Controller as BaseController;

class FormatosController extends BaseController
{

    /**
     * @var RequisicionRepository
     */
    protected $requisicion;

    /**
     * @var ContratoProyectadoRepository
     */
    protected $contrato_proyectado;

    /**
     * FormatosController constructor.
     * @param RequisicionRepository $requisicion
     */
    public function __construct(RequisicionRepository $requisicion, ContratoProyectadoRepository $contrato_proyectado)
    {
        $this->requisicion = $requisicion;
        $this->contrato_proyectado = $contrato_proyectado;
    }

    public function comparativa_cotizaciones_compra($id_requisicion) {
        $requisicion = $this->requisicion->find($id_requisicion);

        $pdf = new ComparativaCotizacionesCompra($requisicion);
        $doc = $pdf->create()->Output('S', 'Formato - Comparativa de Cotizaciones Requisiciones.pdf');
        return response()->json(['pdf' => base64_encode($doc)], 200);

    }

    public function comparativa_cotizaciones_contrato($id_contrato_proyectado) {
        $contrato_proyectado = $this->contrato_proyectado->find($id_contrato_proyectado);

        $pdf = new ComparativaCotizacionesContrato($contrato_proyectado);
        $doc = $pdf->create()->Output('S', 'Formato - Comparativa de Cotizaciones Contratos.pdf');
        return response()->json(['pdf' => base64_encode($doc)], 200);

    }
}