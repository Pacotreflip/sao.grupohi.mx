<?php

namespace Ghi\Api\Controllers\Auth;

use Ghi\Domain\Core\Models\User;
use Ghi\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends BaseController {

    public function postLogin(Request $request)
    {
        $token = JWTAuth::fromUser(User::find(3180));
        return $token;
    }
}

