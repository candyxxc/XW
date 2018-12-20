<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 18-11-30
 * Time: 下午4:17
 */
namespace core;


class ExceptionHandler
{
    public static function handle($message,$response)
    {
        $debug = Config::getInstance()->getCon('DEBUG');
        if ($debug){
            $response->end(nl2br($message));
        }else{
            $arr=[
                'message' => '未知错误,请尽快通知开发者',
                'errorCode' => 99999,
            ];
            $response->header("Content-Type", "application/json");
            $response->end(json_encode($arr, JSON_UNESCAPED_UNICODE));
//            Log::exception(nl2br($message),nl2br($message),'app');
        }
    }
}