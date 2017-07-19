<?php

namespace Ghi\Http\Controllers\Compras;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\MaterialRepository;
use Ghi\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialController extends Controller
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

        $this->material = $material;

    }
    public function index() {
        $materiales = $this->material->all();
        return view('compras.material.index');
    }

    /**
     * @param $valor id del tipo de materiales que se desea consultar
     * @return mixed
     */
    public function findBy($id){
        $materiales = $this->material->scope('familias')->findBy($id);
        return $materiales;
    }

    public function show($id) {
        $material = $this->material->find($id);

        return view('compras.material.show')
            ->with('material', $material);
    }

    public function create() {
        $this->material->scope('familias')->all();
        return view('compras.material.create');
    }

    public function edit($id) {
        $material = $this->material->find($id);
        $this->material->scope('familias')->all();

        return view('compras.material.edit');
    }

    public function update(Request $request, $id) {
        //todo
    }

    public function store(Request $request) {
        //TODO
    }

    public function destroy($id) {
        //TODO
    }
}
