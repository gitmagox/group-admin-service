<?php
/*
 * 服务基础
 */
namespace App\Services\Common;

use App\Exceptions\BizException;
use App\Exceptions\SystemError;

class BasicService
{
    public  $masterModel;

    /**
     * 是否存在ID
     * @param $id
     */
    public function isOurs( $id )
    {

    }

    /**
     * 抛系统异常
     * @param $message
     */
    public function sysError( $message )
    {
        throw new SystemError( $message );
    }

    /**
     * 抛普能异常
     * @param $message
     */
    public function bizError( $message )
    {
        throw new BizException( $message );
    }




}