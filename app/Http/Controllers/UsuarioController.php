<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Seguridad\RoleRepository;
use Ghi\Domain\Core\Contracts\UserRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class UsuarioController extends Controller
{

    use Helpers;

    protected $usuario;
    protected $role;

    /**
     * UsuarioController constructor.
     * @param UserRepository $usuario
     */
    public function __construct(UserRepository $usuario, RoleRepository $role)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');
        $this->middleware('permission:administrar_roles_permisos', ['only' => ['saveRoles']]);

        $this->usuario = $usuario;
        $this->role = $role;
    }

    public function paginate(Request $request)
    {

        $usuarios = $this->usuario->paginate($request->all());

        return response()->json([
            'recordsTotal' => $usuarios->total(),
            'recordsFiltered' => $usuarios->total(),
            'data' => $usuarios->items()
        ], 200);
    }

    public function find($usuario)
    {
        $usuarioCadeco = $this->usuario->usuarioRoles($usuario);
        return response()->json([
            'usuario' => $usuarioCadeco,
            'roles' => $this->role->all()
        ], 200);
    }


    public function saveRoles(Request $request)
    {
        $usuario = $this->usuario->saveRoles($request->all());
        return response()->json([
            'usuario' => $usuario,
        ], 200);
    }
}
