<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 25/06/2018
 * Time: 12:22 PM
 */

namespace Ghi\Http\Controllers\Finanzas;

use Carbon\Carbon;
use Ghi\Domain\Core\Models\Finanzas\SolicitudRecursos;
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id) {

        $solicitud = SolicitudRecursos::find($id);

        return view('finanzas.solicitud_recursos.create');
    }

    public function update(Request $request, $id) {

        $hoy = Carbon::now();
        $solicitud = SolicitudRecursos::where('semana', '=', $hoy->weekOfYear)->where('anio', '=', $hoy->year)->get();

        return view('finanzas.solicitud_recursos.create');
    }
}