<?php
/*
 * 服务基础
 */
namespace App\Services\Common;

use App\Exceptions\BizException;
use App\Exceptions\SystemError;

class BasicService
{
    static  $masterModel;


    /**
     * 是否存在ID
     * @param $id
     */
    public function isOurs( $id )
    {
        $check = self::$masterModel->where( self::$masterModel->getKeyname, $id )->exists();
        if( $check ){
            return $check;
        }
    }
    /**
     * id 数组是否都存在
     * @param $id
     */
    public function inOurs( $ids )
    {
        $check = self::$masterModel->whereIn( self::$masterModel->getKeyname, $ids )->exists();
        if( $check ){
            return $check;
        }
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