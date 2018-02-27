<?php

namespace Ghi\Http\Controllers\Configuracion;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Seguridad\PermissionRepository;
use Illuminate\Http\Request;

use Ghi\Http\Controllers\Controller;

class PermissionController extends Controller
{

    use Helpers;
    /**
     * @var PermissionRepository
     */
    protected $permission;


    public function __construct(PermissionRepository $permission)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');
        $this->middleware('permission:administrar_roles_permisos', ['only' => ['store']]);

        $this->permission = $permission;
    }

    public function index() {
        $permissions = $this->permission->all();
        return $this->response()->collection($permissions, function ($items) { return $items; });
    }

    public function store(Request $request) {
        $permission = $this->permission->create($request->all());
        return $this->response()->item($permission, function ($item) { return $item; });
    }
}
