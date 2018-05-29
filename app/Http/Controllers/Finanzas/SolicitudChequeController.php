<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 28/05/2018
 * Time: 08:39 PM
 */

namespace Ghi\Http\Controllers\Finanzas;

use Ghi\Http\Controllers\Controller;

class SolicitudChequeController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('context');
        $this->middleware('permission:registrar_solicitud_cheque', ['only' => ['create']]);
    }

    public function create() {
        return view('finanzas.solicitud_cheque.create');
    }
}