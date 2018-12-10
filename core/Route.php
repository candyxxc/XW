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
    private static $request_url = NULL;

    public function __construct($request, $response)
    {
        self::$request_url = $request->server['request_uri'];//获取请求url
        \core\xw\XwRouter::analysis(self::$request_url,$request,$response);//解析
    }

    public static function load($className, $response)
    {
        $className = str_replace('\\', '/', $className);
        $className = '../' . $className . '.php';
        if (is_file($className)) {
            require_once $className;
        } else {
            \core\ExceptionHandler::handle($className . ' class not found', $response);
        }

    }
}
