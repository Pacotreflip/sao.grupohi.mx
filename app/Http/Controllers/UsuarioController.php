<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\UserRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class UsuarioController extends Controller
{

    use Helpers;

    protected $usuario;

    /**
     * UsuarioController constructor.
     * @param UserRepository $usuario
     */
    public function __construct(UserRepository $usuario)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->usuario = $usuario;
    }

    public function paginate(Request $request) {
        $usuarios = $this->usuario->paginate($request->all());

        return response()->json([
            'recordsTotal' => $usuarios->total(),
            'recordsFiltered' => $usuarios->total(),
            'data' => $usuarios->items()
        ], 200);
    }
}
