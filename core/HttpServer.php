<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/11/24
 * Time: 17:52
 */

namespace core;

use core\xw\Coroutine\Context;
use core\xw\Coroutine\Coroutine;
use core\xw\Exception\ExceptionHandler;
use core\xw\Pool\Context as PoolContext;
use Swoole\Coroutine\Mysql;

include_once 'Route.php';

class HttpServer
{
    public $pool;

    public function __construct()
    {
        $http = new \Swoole\Http\Server("0.0.0.0", 9501);

        $http->set([
            'http_compression' => false
        ]);

        $http->on('workerStart', [$this, 'OnWorkerStart']);
        $http->on('request', [$this, 'OnRequest']);
        $http->on('start', [$this, 'OnStart']);
        $http->start();
    }

    public function OnWorkerStart()
    {
        Log::inti();
        $obj = new \core\xw\Pool\MysqlPool();
        $obj->connect(Config::getInstance()->getCon('MYSQL'));
        echo $obj->length();
    }

    public function OnRequest($request, $response)
    {
        try {
            Coroutine::setBaseId();
            $context = new Context($request, $response);
            PoolContext::set($context);

            defer(function (){
                PoolContext::clear();
            });

            new Route($request,$response);
        } catch (\Exception $exception) {
            Log::exception($exception);
        } catch (\Error $exception) {
            Log::exception($exception);

        } catch (\Throwable $throwable) {
            Log::exception($throwable);
        }

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
            \nAuthor:\e[31m XiaoXiaoChun\e[0m\nVersion:\e[34m 1.0.3\e[0m\n
welcome;

    }

    public static function load($className)
    {
        $ds = DIRECTORY_SEPARATOR;
        $path = dirname(__DIR__).$ds.str_replace('\\', $ds, $className).'.php';

        if (is_file($path)) {
            require_once $path;
        } else {
            ExceptionHandler::handle($className . '.php class not found', PoolContext::getContext()->response());
        }
    }
}

spl_autoload_register(function ($className) {
    HttpServer::load($className);
});
new HttpServer();