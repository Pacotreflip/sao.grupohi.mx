<?php

namespace Ghi\Api\Controllers\v2\Auth;

use Ghi\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use JWTAuth;

class AuthController extends BaseController {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogin(Request $request)
    {
        // TODO : Lógica para login y regreso del Token
    }
}

