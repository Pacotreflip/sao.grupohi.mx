<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 20/04/2018
 * Time: 12:24 PM
 */

namespace Ghi\Api\Controllers\v1;

use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\TipoTranRepository;
use Ghi\Http\Controllers\Controller;

class TipoTranController extends Controller
{
    private $solicitud = array('Tipo_Transaccion' =>17,'Opciones'=>1);
    private $contratoProyectado = array('Tipo_Transaccion' =>49,'Opciones'=>1026);


    /**
     * Dingo\Api\Routing\Helpers
     */
    use Helpers;
    /**
     * @var TipoTranRepository
     */
    private $tipoTranRepository;

    /**
     * TipoTransaccion constructor.
     * @param TipoTranRepository $tipoTranRepository
     */
    public function __construct(TipoTranRepository $tipoTranRepository)
    {
        $this->tipoTranRepository = $tipoTranRepository;
    }

    /**
     * @return \Dingo\Api\Http\Response
     * @throws \ErrorException
     */
    public function show(Request $request)
    {
        if($request->has('paramters')) {
            $tipoTran = $this->tipoTranRepository->orWhere($request->get('paramters'));
            return $this->response()->array($tipoTran, function ($item) {
                return $item;
            });
        }
    }
}