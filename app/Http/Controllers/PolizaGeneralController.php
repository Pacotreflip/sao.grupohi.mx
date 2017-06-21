<?php

namespace Ghi\Http\Controllers;

use Illuminate\Http\Request;

use Ghi\Http\Requests;

class PolizaGeneralController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');
    }

    public function index()
    {
        return view('modulo_contable.poliza_general.index');
    }
}
