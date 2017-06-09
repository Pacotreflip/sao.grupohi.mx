<?php

namespace Ghi\Api\Controllers;

use Ghi\Domain\Core\Contracts\CuentaContableRepository;
use Illuminate\Routing\Controller;

class CuentaContableController extends Controller
{
    protected $cuenta_contable;

    public function __construct(CuentaContableRepository $cuenta_contable)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('api.context');

        $this->cuenta_contable = $cuenta_contable;
    }

    /**
     * Regresa una cuenta contable por Id
     * @param $id
     * @return mixed
     */
    public function getById($id) {
        return response()->json($this->cuenta_contable->getById($id));
    }
}
