<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoXiaoChun
 * Date: 2018/12/19
 * Time: 23:37
 */

namespace core\xw\Coroutine;


class Coroutine
{
    public static $IdMaps = [];

    public static function getId()
    {
        //获取进程ID
        $id = \Swoole\Coroutine::getuid();
        return $id;
    }

    public static function setBaseId()
    {
        $id = self::getId();
        echo 'setBaseId'.$id.PHP_EOL;
        self::$IdMaps[$id] = $id;
        return $id;
    }

    public static function clear($id=null)
    {
        unset(self::$IdMaps[$id ?? self::getId()]);
    }
}