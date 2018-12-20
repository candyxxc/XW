<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoXiaoChun
 * Date: 2018/12/19
 * Time: 23:34
 */

namespace core\xw\Coroutine;
Class Context
{
    private $request;
    private $response;

    private $map = [];

    public function __construct(\swoole_http_request $request, \swoole_http_response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    public function request()
    {
        return $this->request;
    }
    public function response()
    {
        return $this->response;
    }
}