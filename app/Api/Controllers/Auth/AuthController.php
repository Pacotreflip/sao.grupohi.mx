<?php

namespace Ghi\Api\Controllers\Auth;

use Ghi\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;


class AuthController extends Controller {

    public function postLogin(Request $request)
    {

        //if($app = $app->where('domain' , '=', $request->app_domain)) {
        if($request->app_domain == 'control-acarreos.grupohi.mx')   {
            //if($app->secret_key == $request->secret_key) {
            if($request->secret_key == '1234567890') {
                $payload = JWTFactory::make();
                return $payload;
                $token = JWTAuth::encode($payload);
                //dd(auth()->user());
                return $token;
            }
            return "clave incorrecta";
        }
        return "no existe app";
    }
}

