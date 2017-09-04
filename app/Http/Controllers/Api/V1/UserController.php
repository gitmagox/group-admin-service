<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2017/8/31
 * Time: 21:12
 */

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Dingo\Api\Routing\Helpers;

class UserController extends Controller
{
    use Helpers;

    //登录
    public function login( LoginRequest $request, JWTAuth $JWTAuth )
    {
        $credentials = $request->only(['email', 'password']);
        try {
            $token = Auth::guard('api')->attempt();
            if(!$token) {
                throw new AccessDeniedHttpException();
            }
        } catch (JWTException $e) {
            throw new HttpException(500);
        }
        return response()
                ->json([
                    'status' => 'ok',
                    'token' => $token
                ]);

    }
    //退出登陆
    public function logout()
    {
        return Auth::guard('api')->logout();
    }
}