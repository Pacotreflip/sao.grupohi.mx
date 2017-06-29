<?php

namespace Ghi\Http\Controllers;
use Ghi\Domain\Core\Contracts\AlmacenRepository;
use Dingo\Api\Routing\Helpers;

class AlmacenController extends Controller
{
    use Helpers;

    /**
     * @var AlmacenRepository
     */
    private $almacen;

    public function __construct(
        AlmacenRepository $almacen)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->almacen = $almacen;
    }


    /**
     * Muestra la vista del listado de los datos de Almacenes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $almacenes = $this->almacen->all();
        //dd($almacenes[0]->cuentasAlmacen);
        return view('sistema_contable.cuenta_almacen.index')
                ->with('almacenes', $almacenes);
        //
    }

    /**
     * Devuelve la vista del detalle de una Cuenta de Almacen
     */
    public function show($id)
    {
        $almacen = $this->almacen->find($id);
        return view('sistema_contable.cuenta_almacen.show')
            ->with('almacen', $almacen);
    }
}
