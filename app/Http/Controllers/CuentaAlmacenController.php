<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\CuentaAlmacenRepository;
use Dingo\Api\Routing\Helpers;

class CuentaAlmacenController extends Controller
{
    use Helpers;

    /**
     * @var CuentaAlmacenRepository
     */
    private $cuenta_almacen;

    public function __construct(
        CuentaAlmacenRepository $cuenta_almacen)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->cuenta_almacen = $cuenta_almacen;
    }


}
