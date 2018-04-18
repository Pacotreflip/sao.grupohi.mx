<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 17/04/2018
 * Time: 11:37 PM
 */

namespace Ghi\Api\Controllers\v1\Tesoreria;

use Ghi\Domain\Core\Contracts\Tesoreria\MovimientosBancariosRepository;
use Ghi\Http\Controllers\Controller as BaseController;
use Dingo\Api\Http\Request;
use JWTAuth;

class MovimientosBancariosController  extends BaseController
{
    /**
     * @var MovimientosBancariosRepository
     */
    private $movimientosBancarios;

    /**
     * @param MovimientosBancariosRepository $movimientos
     */
    public function __construct(MovimientosBancariosRepository $movimientosBancarios)
    {
        $this->movimientosBancarios = $movimientosBancarios;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request){
        $resp = $this->movimientosBancarios->paginate($request->all());
        return response()->json([
            'recordsTotal' => $resp->total(),
            'recordsFiltered' => $resp->total(),
            'data' => $resp->items()], 200);
    }
}