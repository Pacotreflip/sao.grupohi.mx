<?php

namespace Ghi\Http\Controllers\Administracion;

use Illuminate\Http\Request;

use Ghi\Http\Requests;
use Ghi\Http\Controllers\Controller;

class RolesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');
    }

    public function index() {
        return view('administracion.role.index');
    }
}
