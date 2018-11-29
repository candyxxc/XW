<?php
/**
 * Created by PhpStorm.
 * User: Tango萧小春
 * Date: 2018/11/14
 * Time: 23:04
 */

use core\Controller;

class Route
{
    private static $request_url = NULL;

    public function __construct($request, $response)
    {
        self::$request_url = $request->server['request_uri'];
        $path = explode('/', trim(self::$request_url, '/'));

        $path[0] = $path[0] == "" ? 'index' : $path[0];
        $path[1] = $path[1] ?? 'index';
        $path[2] = $path[2] ?? 'index';
        [$controller, $ctrl, $method] = $path;

        $classFileName = '../app/' . $controller . '/' . 'controller/';
        $userNamespace = 'app\\' . $controller . '\\controller\\' . ucfirst($ctrl);

        if (is_dir($classFileName)) {
            $obj = new $userNamespace($request, $response);
            if (method_exists($obj, $method)) {
                $obj->$method();
            } else {
                self::returnError($response, $method . ' method not found');
            }
        } else {
            self::returnError($response, $controller . ' module not found');
        }
    }


    public static function load($className, $response)
    {
//        set_exception_handler();
        $className = str_replace('\\', '/', $className);
        $className = '../' . $className . '.php';
        try {
            if (is_file($className)) {
//                register_shutdown_function(function () use ($response){
//                    $error=error_get_last();
//                    $response->end($error['message']);
//                });
                    include_once $className;
            } else {
                throw new Exception('class not found');
            }
        } catch (Exception $e) {
            self::returnError($response, $e->getMessage());
        }
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
