<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 25/06/2018
 * Time: 12:22 PM
 */

namespace Ghi\Http\Controllers\Finanzas;

use Ghi\Http\Controllers\Controller;
use Ghi\Http\Requests\Request;

class SolicitudRecursosController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('context');
    }

    public function index() {
        return view('finanzas.solicitud_recursos.index');
    }

    public function create() {

        $solicitud = SolicitudRecursos::where('semana', '=', $hoy->weekOfYear)->where('anio', '=', $hoy->year)->get();

        return view('finanzas.solicitud_recursos.create', '');
    }
}