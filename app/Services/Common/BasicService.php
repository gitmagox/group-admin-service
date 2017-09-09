<?php
/*
 * 服务基础
 */
namespace App\Services\Common;

use App\Exceptions\BizException;
use App\Exceptions\SystemError;
use App\Traits\ExceptionHelps;

class BasicService
{
    use ExceptionHelps;
    static  $masterModel;


    /**
     * 是否存在ID
     * @param $id
     */
    public function isOurs( $id )
    {
        $check = self::$masterModel->where( self::$masterModel->getKeyname(), $id )->exists();
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
        $check = self::$masterModel->whereIn( self::$masterModel->getKeyname(), $ids )->exists();
        if( $check ){
            return $check;
        }
    }
}