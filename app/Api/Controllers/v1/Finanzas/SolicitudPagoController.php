<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 15/06/2018
 * Time: 03:06 PM
 */

namespace Ghi\Api\Controllers\v1\Finanzas;


use Ghi\Domain\Core\Contracts\Finanzas\SolicitudPagoRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SolicitudPagoController extends Controller
{
    /**
     * @var SolicitudPagoRepository
     */
    protected $solicitudPagoRepository;

    /**
     * SolicitudPagoController constructor.
     * @param SolicitudPagoRepository $solicitudPagoRepository
     */
    public function __construct(SolicitudPagoRepository $solicitudPagoRepository)
    {
        $this->solicitudPagoRepository = $solicitudPagoRepository;
    }

    public function index() {
        return response()->json($this->solicitudPagoRepository->all());
    }

    public function paginate(Request $request){
        $resp = $this->solicitudPagoRepository->paginate($request->all());
        return response()->json([
            'recordsTotal' => $resp->total(),
            'recordsFiltered' => $resp->total(),
            'data' => $resp->items()], 200);
    }
}