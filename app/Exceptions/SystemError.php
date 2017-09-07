<?php
/**
 * 系统错误类
 * @author 吴辉 3001378341@qq.com
 * @@date 2017-03-29 16:47:52
 */
namespace App\Exceptions;

class SystemError extends \Exception{
    protected $code = 500;
    protected $message = "系统出错啦^_^，请稍后再试";

    /**
     * @param string $message
     */
    public function setMessage($message){
        $this->message = $message;
    }


}
