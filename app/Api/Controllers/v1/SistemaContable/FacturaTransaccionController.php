<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 25/06/2018
 * Time: 04:45 PM
 */

namespace Ghi\Api\Controllers\v1\SistemaContable;


use Ghi\Domain\Core\Contracts\Contabilidad\FacturaTransaccionRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FacturaTransaccionController extends Controller
{
    /**
     * @var FacturaTransaccionRepository
     */
    protected $facturaTransaccionRepository;

    /**
     * FacturaTransaccionController constructor.
     * @param FacturaTransaccionRepository $facturaTransaccionRepository
     */
    public function __construct(FacturaTransaccionRepository $facturaTransaccionRepository)
    {
        $this->facturaTransaccionRepository = $facturaTransaccionRepository;
    }

    public function index(Request $request) {
        return response()->json($this->facturaTransaccionRepository
            ->with($request->with)
            ->whereBetween($request->betweenColumn, $request->betweenValues)
            ->where($request->where)
            ->all()
        );
    }
}