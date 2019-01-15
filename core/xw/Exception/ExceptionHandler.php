<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 19-1-15
 * Time: 下午5:49
 */

namespace core\xw\Exception;

use core\Config;

class ExceptionHandler
{

    public static function handle($exception, $response)
    {
        $debug = Config::getInstance()->getCon('DEBUG');
        if ($exception instanceof Ehandler) {
            self::returnError($exception->msg,$exception->errorCode,$response);
        } else {
            if (!$debug) {
                self::returnError("未知错误,请尽快通知开发者",99999,$response);
                Log::exception($exception);
            } else {
                echo $exception;
                $response->end(nl2br($exception));
            }
        }
    }
    private static function returnError($message,$errorCode,$response)
    {
        $arr = [
            'message' => $message,
            'errorCode' => $errorCode
        ];
        $response->header("Content-Type", "application/json");
        $response->end(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

}