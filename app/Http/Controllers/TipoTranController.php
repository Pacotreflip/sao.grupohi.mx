<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\TipoTranRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class TipoTranController extends Controller
{
    use Helpers;

    /**
     * @var TipoTranRepository
     */
    private $tipo_tran;

    /**
     * TipoTranController constructor.
     * @param TipoTranRepository $tipo_tran
     */
    public function __construct(TipoTranRepository $tipo_tran)
    {
        $this->middleware(['auth', 'context']);
        $this->tipo_tran = $tipo_tran;
    }

    public function lists() {
        $tipos_tran = $this->tipo_tran->lists();

        return $this->response->array($tipos_tran);
    }
}
