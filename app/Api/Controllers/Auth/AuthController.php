<?php

namespace Ghi\Api\Controllers\Auth;

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

        return compact('token');
    }
}

