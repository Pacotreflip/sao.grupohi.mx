<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\MaterialRepository;
use Illuminate\Http\Request;

class CuentaMaterialController extends Controller
{
    use Helpers;

    /**
     * @var MaterialRepository
     */
    private $material;

    public function __construct(MaterialRepository $material
       )
    {
        parent::__construct();

        //$this->middleware('auth');
        //$this->middleware('context');

        $this->material = $material;
    }


    /**
     * Muestra la vista del listado del Material para visualizar en el Kardex
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('sistema_contable.cuenta_material.index');
    }

    /**
     * @param $valor id del tipo de materiales que se desea consultar
     * @return mixed
     */
    public function findBy($valor){
        $materiales = $this->material->findBy($valor);
        return $materiales;
    }

    public function show($item){
        $familia = $this->material->find($item);

        return $familia;
    }
}
