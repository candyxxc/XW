<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 19-1-15
 * Time: 下午5:12
 */

namespace core\xw\Pool;

interface PoolInterface
{
    public function connect($config);
    public function createObject($config);
    public function put($obj);
    public function get();
    public function length();
}