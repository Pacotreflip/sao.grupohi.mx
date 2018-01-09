<?php

namespace Ghi\Http\Controllers\Configuracion;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Seguridad\RoleRepository;
use Illuminate\Http\Request;

use Ghi\Http\Controllers\Controller;

class RoleController extends Controller
{

    use Helpers;
    /**
     * @var RoleRepository
     */
    protected $role;


    public function __construct(RoleRepository $role)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');

        $this->role = $role;
    }

    public function index() {
        $roles = $this->role->all();

        return $this->response()->collection($roles, function ($items) { return $items; });
    }

    public function store(Request $request) {
        $role = $this->role->create($request->all());

        return $this->response()->item($role, function ($item) { return $item; });
    }

    public function paginate(Request $request) {
        $roles = $this->role->paginate($request->all());

        return response()->json([
            'recordsTotal' => $roles->total(),
            'recordsFiltered' => $roles->total(),
            'data' => $roles->items()
        ], 200);
    }
}
