<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 03/11/2017
 * Time: 5:13 AM
 */

namespace Ghi\Api\Controllers;

use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\ContratoRepository;
use Ghi\Domain\Core\Transformers\ContratoTransformer;
use Ghi\Http\Controllers\Controller;

class ContratoController extends Controller
{
    use Helpers;

    private $contrato;

    public function __construct(ContratoRepository $contrato)
    {
        $this->contrato = $contrato;
    }

    public function update(Request $request, $id)
    {
        $contrato = $this->contrato->update($request->all(), $id);
        return $this->response->item($contrato, new ContratoTransformer());
    }

    public function store(Request $request){
        $contrato = $this->contrato->create($request->all());
        return $this->response->item($contrato, new ContratoTransformer());
    }
}