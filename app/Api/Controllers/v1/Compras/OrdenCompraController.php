<?php
/**
 * Created by PhpStorm.
 * User: JFEsquivel
 * Date: 07/06/2018
 * Time: 04:49 PM
 */

namespace Ghi\Api\Controllers\v1\Compras;

use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Compras\OrdenCompraRepository;
use Ghi\Http\Controllers\Controller;

/**
 * Class OrdenCompraController
 * @package Ghi\Api\Controllers\v1\Compras
 */
class OrdenCompraController extends Controller
{
    use Helpers;

    /**
     * @var OrdenCompraRepository
     */
    private $ordenCompraRepository;

    /**
     * OrdenCompraController constructor.
     * @param OrdenCompraRepository $ordenCompraRepository
     */
    public function __construct(OrdenCompraRepository $ordenCompraRepository)
    {
        $this->ordenCompraRepository = $ordenCompraRepository;
    }

    public function find($id) {
        $oc = $this->ordenCompraRepository->find($id);
        return $this->response->item($oc, function ($item) { return $item; });
    }

    public function search(Request $request)
    {
        $oc = $this->ordenCompraRepository
            ->limit($request->limit)
            ->with($request->with)
            ->search($request->q, $request->cols);

        return response()->json($oc, 200);
    }
}