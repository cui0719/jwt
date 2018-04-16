<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['未找到此用户'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token已过期'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['请重写登录'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['非法请求'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }
}
