<?php

namespace Ghi\Http\Controllers;

use Illuminate\Http\Request;

use Ghi\Http\Requests;

class MailController extends Controller
{
    public function index(){
        return view('sistema_contable.emails.notificaciones.poliza');
    }
}
