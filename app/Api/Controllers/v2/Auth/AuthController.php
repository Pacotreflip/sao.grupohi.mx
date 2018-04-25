<?php

namespace Ghi\Api\Controllers\v2\Auth;

use Ghi\Domain\Core\Models\User;
use Ghi\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use JWTAuth;
use Ghi\Domain\Core\Models\Seguridad\AccesosApi;
use Illuminate\Support\Facades\DB;

class AuthController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogin(Request $request)
    {
        $rules = [
            'usuario' => ['max:140', 'string', 'filled','required'],
            'app_key' => ['max:140', 'string', 'filled','required'],
            'id_obra' => ['numeric', 'min:0', 'filled','required'],
            'database_name' => ['string', 'max:255', 'filled','required'],
        ];

        $validator = app('validator')->make($request->all(), $rules);

        if (count($validator->errors()->all())) {
            //Caer en excepción si alguna regla de validación falla
            return response()->json(['error' => 'Lo parametros son invalidos', $validator->errors()], 500);
        }

        $proyecto = [
            'id_obra' => $request->id_obra,
            'database_name' => $request->database_name,
        ];

        $token = '';
        try {
            $acceso = AccesosApi::where('app_key', '=',  md5($request->app_key))->get();
            if (count($acceso)==0) {
                return response()->json(['error' => 'Clave de api erronea'], 500);
            }
            $user = User::where('usuario', '=', $request->usuario)->first();
            if(!$user){
                return response()->json(['error' => 'Error, el usuario no existe'], 500);
            }
            $token = JWTAuth::fromUser($user,$proyecto);
            if (!$token)
                return response()->json(['message' => 'credenciales inválidas'], 401);

        } catch (JWTException $e) {
            return response()->json(['error' => 'no se pudo generar el token'], 500);
        }

        //$token = JWTAuth::fromUser(User::find(3180));
        return compact('token');
    }
}