<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 01/11/2017
 * Time: 01:13 PM
 */

namespace Ghi\Api\Controllers;

use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Repositories\EloquentEmpresaRepository;
use Ghi\Domain\Core\Transformers\EmpresaTransformer;
use Ghi\Http\Controllers\Controller;

class EmpresaController extends Controller
{
    use Helpers;

    private $empresa;

    public function __construct(EloquentEmpresaRepository $empresa)
    {
        $this->middleware('api.context');
        $this->empresa = $empresa;
    }

    public function store(Request $request)
    {
        $empresa = $this->empresa->create($request->all());
        return $this->response->item($empresa, new EmpresaTransformer());
    }

    public function show($id) {
        $empresa = $this->empresa->find($id);
        return $this->response->item($empresa, new EmpresaTransformer());
    }
}