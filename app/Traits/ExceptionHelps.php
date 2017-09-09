<?php
/**
 * ExceptionHelps
 * Author:Magox
 */
namespace App\Traits;

use App\Exceptions\BizException;
use App\Exceptions\SystemError;

trait ExceptionHelps
{
    /**
     * 抛系统异常
     * @param $message
     */
    public function sysError( $message )
    {
        throw new SystemError( $message );
    }

    /**
     * 抛普通异常
     * @param $message
     */
    public function bizError( $message )
    {
        throw new BizException( $message );
    }

}
