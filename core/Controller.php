<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/11/18
 * Time: 0:22
 */
namespace core;
use core\xw\Pool\Context;

class Controller
{
    protected $request = NULL;
    protected $response = NULL;
    public function __construct()
    {
        $this->request = Context::getContext()->request();
        $this->response = Context::getContext()->response();
    }
    public function responseJson($status,$message)
    {
        $this->response->header("Content-Type", "application/json");
        $this->response->status($status);
        $this->response->write(json_encode($message,JSON_UNESCAPED_UNICODE));
        $this->response->end();
    }
    private static function returnError($response, $message = 'Request url error')
    {
        $arr = [
            'message' => $message,
            'errorCode' => 99999,
            'request_url' => self::$request_url
        ];
        $response->header("Content-Type", "application/json");
        $response->end(json_encode($arr, true));
    }
}