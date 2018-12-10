<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/12/9
 * Time: 17:19
 */

namespace core\xw;
class XwRouter
{
    public static function analysis($url, $request, $response)
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
                $obj = new $userNamespace($request, $response);
                if (method_exists($obj, $method)) {
                    self::requestMethod($controller . '/' . $ctrl . '/' . $method, $request->server['request_method'], $response);
                    $obj->$method();
                } else {
                    \core\ExceptionHandler::handle($method . ' method not found', $response);
                }
            } catch (\Throwable $throwable) {
                $e = error_get_last();
                if ($e) {
                    \core\ExceptionHandler::handle($e['message'] . '<br>' . $throwable, $response);
                } else {
                    \core\ExceptionHandler::handle($throwable, $response);
                }
            }
        } else {
            \core\ExceptionHandler::handle($method . ' module not found', $response);
        }
    }

    private function requestMethod($url, $method, $response)
    {
        $routeConfig = include './../config/route.php';
        if (!(isset($routeConfig[$url]))){
            return true;
        }
        if (!($routeConfig[$url] == $method)) {
            \core\ExceptionHandler::handle($method . ' module not found', $response);
        }
    }
}