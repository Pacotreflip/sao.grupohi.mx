<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 20/04/2018
 * Time: 09:57 AM
 */

namespace Ghi\Api\Controllers\v1;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Seguridad\RoleRepository;
use Ghi\Domain\Core\Models\User;
use Ghi\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Contracts\UserRepository;
use Ghi\Domain\Core\Transformers\UsuarioTransformer;
use Illuminate\Support\Facades\Log;

/**
 * Class UsuarioController
 * @package Ghi\Api\Controllers\v1
 */
class UsuarioController extends Controller
{
    /**
     * Dingo\Api\Routing\Helpers
     */
    use Helpers;
    /**
     * @var UserRepository
     */
    private $usuarioRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * UsuarioController constructor.
     * @param UserRepository $usuarioRepository
     */
    public function __construct(UserRepository $usuarioRepository, RoleRepository $roleRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->has('roles')) {
            $roles = $request->get('roles');
            $usuarios = $this->usuarioRepository->rolesForUser();
            $usuariosArray = array();
            $usuariosUnique= array();
            foreach ($usuarios as $usuario) {
                if (isset($usuario->user->roles)) {
                    foreach ($usuario->user->roles as $rolesUsuario) {
                        if (count($rolesUsuario)) {
                            if (in_array($rolesUsuario->name, $roles)) {
                                if(!in_array($usuario->user->usuario,$usuariosArray)) {
                                    $usuariosArray[] = array(
                                        'idusuarios' => $usuario->user->idusuario,
                                        'name' => $usuario->user->nombre . "  " . $usuario->user->apaterno . " " . $usuario->user->amaterno);
                                }
                            }
                        }
                    }
                }
            }

            if(count($usuariosArray)){
                $collection = collect($usuariosArray);
                $usuariosUnique = $collection->unique('idusuarios');
            }
            return $this->response()->array($usuariosUnique->values()->all(), function ($item) {
                return $item;
            });
        }
    }
}