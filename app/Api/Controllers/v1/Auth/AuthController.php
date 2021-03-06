<?php

namespace Ghi\Api\Controllers\v1\Auth;

use Ghi\Domain\Core\Models\User;
use Ghi\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends BaseController {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogin(Request $request)
    {
        $credenciales = [
            'usuario' => $request->header('usuario'),
            'clave' => $request->header('clave'),
        ];
        $token = '';
        try
        {
            $token = JWTAuth::attempt($credenciales);

            if (!$token)
                return response()->json(['message' => 'credenciales inválidas'], 401);

        }
        catch (JWTException $e)
        {
            return response()->json(['error' => 'no se pudo generar el token'], 500);
        }

        //$token = JWTAuth::fromUser(User::find(3180));
        return compact('token');
    }

    public function testing2() {
        return response()->json(['hola' => 'v2']);
    }

    public function testing() {
        return response()->json(['hola' => 'v1']);
    }
}

