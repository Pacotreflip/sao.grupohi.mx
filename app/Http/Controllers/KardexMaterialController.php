<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\MaterialRepository;
use Dingo\Api\Routing\Helpers;

class KardexMaterialController extends Controller
{
    use Helpers;

    /**
     * @var MaterialRepository
     */
    private $material;

    public function __construct(MaterialRepository $material)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->middleware('permission:consultar_kardex_material', ['only' => ['index']]);

        $this->material = $material;
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
    }
}
