<?php

namespace Ghi\Http\Controllers;

use Illuminate\Http\Request;

use Ghi\Http\Requests;

class ConceptoCuentaController extends Controller
{
    public function index() {
        return view('sistema_contable.concepto_cuenta.index');
    }
}
