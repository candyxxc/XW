<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/11/14
 * Time: 23:04
 */

error_reporting(0);

class Route
{
    private $request_url = NULL;

    public function __construct()
    {
        $request = \core\xw\Pool\Context::getContext()->request();
        $response = \core\xw\Pool\Context::getContext()->response();
        $this->request_url = $request->server['request_uri'];//获取请求url
        if ($this->request_url == '/favicon.ico') {
            $response->end();
            return;
        } else {
            \core\xw\XwRouter::analysis($this->request_url, $request, $response);//解析
        }
    }

    public static function load($className)
    {
        $className = str_replace('\\', '/', $className);
        $className = '../' . $className . '.php';
        if (is_file($className)) {
            require_once $className;
        } else {
            \core\ExceptionHandler::handle($className . ' class not found', \core\xw\Pool\Context::getContext()->response());
        }

    }
}
