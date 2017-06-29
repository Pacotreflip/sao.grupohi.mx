<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\AlmacenRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaAlmacenRepository;
use Dingo\Api\Routing\Helpers;

class CuentaAlmacenController extends Controller
{
    use Helpers;

    /**
     * @var CuentaAlmacenRepository
     */
    private $cuenta_almacen;
    private $almacen;

    public function __construct(
        CuentaAlmacenRepository $cuenta_almacen,
        AlmacenRepository $almacen)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->cuenta_almacen = $cuenta_almacen;
        $this->almacen = $almacen;
    }

    public function index() {
        $almacenes = $this->almacen->all('cuentaAlmacen');

        return view('sistema_contable.cuenta_almacen.index')
            ->with('almacenes', $almacenes);
    }

    /**
     * Guarda un registro de una Asignacion de Cuenta a una Cuenta de Alamcen
     */
    public function store(Request $request)
    {

        $item = $this->cuenta_almacen->create($request->all());

        return $this->response->created(route('sistema_contable.cuenta_almacen.show', $item));
    }


}
