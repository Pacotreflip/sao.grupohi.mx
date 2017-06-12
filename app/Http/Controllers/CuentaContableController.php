<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\CuentaContableRepository;

class CuentaContableController extends Controller
{
    protected $cuenta_contable;

    public function __construct(CuentaContableRepository $cuenta_contable)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->cuenta_contable = $cuenta_contable;
    }

    public function getById($id) {
        return $this->cuenta_contable->getById($id);
    }
}