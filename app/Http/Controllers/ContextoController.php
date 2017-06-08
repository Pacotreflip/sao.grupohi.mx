<?php

namespace Ghi\Http\Controllers;

use Ghi\Core\Contracts\Context;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class ContextoController extends Controller
{

    /**
     * @var Context
     */
    private $context;

    /**
     * ContextoController constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->middleware('auth');
        $this->context = $context;
    }

    /**
     * Establecer Base de Datos y Obra en el contexto
     * @param $database
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function  set($database, $id){
        $this->context->setId($id);
        $this->context->setDatabaseName($database);
        return redirect()->to('index');
    }
}