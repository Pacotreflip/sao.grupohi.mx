<?php

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 03/11/2017
 * Time: 01:13 AM
 */

namespace Ghi\Api\Controllers;

use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Repositories\EloquentSucursalRepository;
use Ghi\Domain\Core\Transformers\SucursalTransformer;
use Ghi\Http\Controllers\Controller;

class SucursalController extends Controller
{
    use Helpers;

    private $sucursal;

    /**
     * SucursalController constructor.
     * @param EloquentSucursalRepository $sucursal
     */
    public function __construct(EloquentSucursalRepository $sucursal)
    {
        $this->sucursal = $sucursal;
    }

    public function store(Request $request)
    {
        $sucursal = $this->sucursal->create($request->all());
        return $this->response->item($sucursal, new SucursalTransformer());
    }

    public function show($id) {
        $sucursal = $this->sucursal->find($id);
        return $this->response->item($sucursal, new SucursalTransformer());
    }
}