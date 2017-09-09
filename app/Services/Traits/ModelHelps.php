<?php
/**
 * model help functions
 * Author:magox
 */
namespace App\Services\Traits;


trait ModelHelps
{
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

    /**
     * select
     * @param array $where
     * @return mixed
     */
    public function select( array $colums = ['*'], array $where = [])
    {
        return self::$masterModel->where( $where )
            ->orderBy('id','asc')
            ->select($colums)
            ->get();
    }

    /**
     * 取值
     * @param $name
     * @param $id
     * @return mixed
     */
    public function pluck( $name, $id, array $where=[] )
    {
        return $this->select([$name,$id],$where)->pluck($name, $id);
    }
}
