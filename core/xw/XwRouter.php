<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/12/9
 * Time: 17:19
 */

namespace core\xw;

use core\xw\Exception\Ehandler;
use core\xw\Exception\ExceptionHandler;

class XwRouter
{
    public static function analysis($url, $response)
    {
        $path = explode('/', trim($url, '/'));
        $path[0] = $path[0] == "" ? 'index' : $path[0];
        $path[1] = $path[1] ?? 'index';
        $path[2] = $path[2] ?? 'index';
        [$controller, $ctrl, $method] = $path;

        $classFileName = '../app/' . $controller . '/' . 'controller/';
        $userNamespace = 'app\\' . $controller . '\\controller\\' . ucfirst($ctrl);


        if (is_dir($classFileName)) {
            try {
                $obj = new $userNamespace();
                if (method_exists($obj, $method)) {
                    $obj->$method();
                } else {
                    ExceptionHandler::handle($method.' method not found',$response);
                }
            } catch (\Throwable $throwable) {
                ExceptionHandler::handle($throwable,$response);
            }
        } else {
            ExceptionHandler::handle($path[0].' module not found',$response);
        }
    }
}
