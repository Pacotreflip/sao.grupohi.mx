<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 25/06/2018
 * Time: 12:22 PM
 */

namespace Ghi\Http\Controllers\Finanzas;

use Ghi\Domain\Core\Models\Finanzas\SolicitudRecursos;
use Ghi\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SolicitudRecursosController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('context');
    }

    public function index() {
        return view('finanzas.solicitud_recursos.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id) {
        $solicitud = SolicitudRecursos::abiertas()->findOrFail($id);
        return view('finanzas.solicitud_recursos.edit')->withSolicitud($solicitud);
    }

    public function show(Request $request, $id) {
        $solicitud = SolicitudRecursos::find($id);
        return view('finanzas.solicitud_recursos.show')->withSolicitud($solicitud);
    }
}