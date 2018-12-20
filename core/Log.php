<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 18-12-20
 * Time: 上午10:07
 */

namespace core;

use SeasLog;
class Log
{
    private static $seaslog = false;

    public static function inti()
    {
        if (class_exists('SeasLog')) {
            self::$seaslog = true;
            $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'log';
            SeasLog::setBasePath($path);
        }
    }

    public static function exception(\Throwable $e)
    {
        $errorMessage = [
            '{file}' => $e->getFile(),
            '{line}' => $e->getLine(),
            '{code}' => $e->getCode(),
            '{message}' => $e->getMessage(),
            '{trace}' => $e->getTraceAsString(),
        ];
        SeasLog::emergency($errorMessage,$errorMessage,'http');
    }
}