<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 03/04/2018
 * Time: 02:50 PM
 */

namespace Ghi\Api\Controllers\v1;


use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Formatos\Compras\ComparativaCotizacionesCompra;
use Ghi\Http\Controllers\Controller as BaseController;

class FormatosController extends BaseController
{

    /**
     * @var RequisicionRepository
     */
    protected $requisicion;

    /**
     * FormatosController constructor.
     * @param RequisicionRepository $requisicion
     */
    public function __construct(RequisicionRepository $requisicion)
    {
        $this->requisicion = $requisicion;
    }

    public function comparativa_cotizaciones_compra($id_requisicion) {
        $requisicion = $this->requisicion->find($id_requisicion);

        $pdf = new ComparativaCotizacionesCompra($requisicion);
        $doc = $pdf->create();
        return response()->json(['pdf' => base64_encode($doc)], 200);

    }
}