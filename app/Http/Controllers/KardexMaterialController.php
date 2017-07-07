<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\ItemsRepository;
use Ghi\Domain\Core\Contracts\MaterialRepository;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

use Ghi\Http\Requests;

class KardexMaterialController extends Controller
{
    use Helpers;

    /**
     * @var MaterialRepository
     */
    private $material;
    private $item;

    public function __construct(
        MaterialRepository $material,
        ItemsRepository $item)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->material = $material;
        $this->item = $item;
    }

    /**
     * Muestra la vista del listado del Material para visualizar en el Kardex
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $materiales = $this->material->scope('ConTransaccionES')->all();
        return view('sistema_contable.kardex_material.index')
            ->with('materiales', $materiales);
        //
    }

    public function getBy($id)
    {
       // return $this->item->with(['transaccion', 'material'])->getBy('materiales.id_material', '=', $id);
        return $this->item->scope('conTransaccionES')->with('transaccion')->getBy('id_material', '=', $id);
    }
}
