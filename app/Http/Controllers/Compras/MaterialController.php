<?php

namespace Ghi\Http\Controllers\Compras;

use Dingo\Api\Routing\Helpers;
use Ghi\Http\Controllers\Controller;

class MaterialController extends Controller
{
    use Helpers;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

    }
    public function index() {
        return view('compras.material.index');
    }

    public function show($id) {
        return view('compras.material.show');
    }

    public function create() {
        return view('compras.material.create');
    }

    public function edit($id) {
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
