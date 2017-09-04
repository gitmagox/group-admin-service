<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2017/8/31
 * Time: 21:12
 */

namespace App\Http\Controllers\Api\V1;

use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Dingo\Api\Routing\Helpers;

class UserController extends Controller
{
    use Helpers;
    public function index(){

    }
    //登陆
    public function login( LoginRequest $request, JWTAuth $JWTAuth )
    {
        $credentials = $request->only(['email', 'password']);
        try {
            $token = $JWTAuth->attempt($credentials);
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

}