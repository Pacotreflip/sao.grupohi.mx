<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 11/04/2018
 * Time: 09:06 AM
 */

namespace Ghi\Api\Controllers\v1\Tesoreria;

use Ghi\Domain\Core\Contracts\Tesoreria\TraspasoCuentasRepository;
use Ghi\Http\Controllers\Controller as BaseController;
use Dingo\Api\Http\Request;


class TraspasoCuentasController extends BaseController
{
    /**
     * @var TraspasoCuentasRepository
     */
    protected $traspasoCuentas;

    /**
     * TraspasoCuentasController constructor.
     * @param TraspasoCuentasRepository $traspasoCuentas
     */
    public function __construct(TraspasoCuentasRepository $traspasoCuentas)
    {
        $this->traspasoCuentas = $traspasoCuentas;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request){
        $resp = $this->traspasoCuentas->paginate($request->all());
        return response()->json([
            'recordsTotal' => $resp->total(),
            'recordsFiltered' => $resp->total(),
            'data' => $resp->items()], 200);
    }
}