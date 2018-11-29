<?php
/**
 * Created by PhpStorm.
 * User: Tango萧小春
 * Date: 2018/11/24
 * Time: 17:52
 */
include_once 'Route.php';
class HttpServer
{
    public function __construct()
    {
        $http = new Swoole\Http\Server("0.0.0.0", 9501);

        $http->set([
            'http_compression' => false
        ]);

        $http->on('request',[$this,'OnRequest']);
        $http->start();
    }
    public function onRequest($request, $response)
    {

        spl_autoload_register(function ($className) use ($response){
                Route::load($className,$response);
        });
        new Route($request, $response);
    }

}
new HttpServer();