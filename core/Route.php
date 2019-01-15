<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/11/14
 * Time: 23:04
 */

namespace core;

use core\xw\XwRouter;

class Route
{
    private $request_url = NULL;

    public function __construct($request,$response)
    {

        $this->request_url = $request->server['request_uri'];//获取请求url
        if ($this->request_url == '/favicon.ico') {
            $response->end();
            return;
        } else {
            XwRouter::analysis($this->request_url, $response);//解析
        }
    }

}
