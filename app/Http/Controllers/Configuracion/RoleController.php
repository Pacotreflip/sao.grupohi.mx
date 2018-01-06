<?php

namespace Ghi\Http\Controllers\Configuracion;

use Illuminate\Http\Request;

use Ghi\Http\Requests;
use Ghi\Http\Controllers\Controller;

class RoleController extends Controller
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
