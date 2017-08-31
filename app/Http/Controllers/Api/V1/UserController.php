<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2017/8/31
 * Time: 21:12
 */

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

class UserController extends Controller
{
    use Helpers;
    public function index(){

        return $this->response->error('This is an error.', 403);
        return ['dddddd'];
    }

}