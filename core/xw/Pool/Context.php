<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoXiaoChun
 * Date: 2018/12/19
 * Time: 23:33
 */

namespace core\xw\Pool;

use core\xw\Coroutine\Coroutine;

class Context
{
    public static $pool = [];

    public static function getContext()
    {
        $id = Coroutine::getId();
        return self::$pool[$id];
    }

    public static function set($context)
    {
        $id = Coroutine::getId();
        self::$pool[$id] = $context;
    }

    public static function clear()
    {
        $id = Coroutine::getId();
        if (isset(self::$pool[$id])) {
            unset(self::$pool[$id]);
        }
    }
}