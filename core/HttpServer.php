<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/11/24
 * Time: 17:52
 */
include_once 'Route.php';
include_once 'MysqlPool.php';
include_once 'Config.php';

class HttpServer
{
    public $pool;

    public function __construct()
    {
        $http = new Swoole\Http\Server("0.0.0.0", 9501);

        $http->set([
            'http_compression' => false
        ]);
        $http->on('request', [$this, 'OnRequest']);
        $http->on('start', [$this, 'OnStart']);
        $http->start();
    }

    public function OnRequest($request, $response)
    {

        $coId = \core\xw\Coroutine\Coroutine::setBaseId();
        $context = new \core\xw\Coroutine\Context($request,$response);
        \core\xw\Pool\Context::set($context);
        defer(function () use ($coId) {
            \core\xw\Pool\Context::clear($coId);
        });
        new Route();
    }

    public function OnStart()
    {
        echo <<<LOGO
             __      __         __           __
             \  \  /  /         \  \       /  /
              \  \/  /           \  \ / \ /  / 
               \    /             \  /   \  /  
              /  /\  \             \   _   / 
             /_ /  \__\             \_/ \_/
LOGO;
        echo <<<welcome
            \nAuthor:\e[31m XiaoXiaoChun\e[0m\nVersion:\e[34m 1.0.0\e[0m\n
welcome;

    }
}
spl_autoload_register(function ($className)  {
    Route::load($className);
});
new HttpServer();