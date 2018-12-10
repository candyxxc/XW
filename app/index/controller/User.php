<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/11/24
 * Time: 14:22
 */

namespace app\index\controller;


use core\Controller;
use core\ExceptionHandler;
use core\RedisPool;

class User extends Controller
{
    public function test()
    {
        $pool = new RedisPool();
        $redis = $pool->get();
        $data = $redis->get('wesome');
        $pool->put($redis);
        $this->response->end($data);
    }
    public function regiSter()
    {
        \Swoole\Runtime::enableCoroutine();
        go(function () {
            try{
                $this->test();
            }catch (\Throwable $throwable){
                ExceptionHandler::handle($throwable,$this->response);
            }
        });

//            go(function () {
//                ($redis = new \Redis)->connect('127.0.0.1', 6379);
//                $redis->get('awesome');
//            });
//            $this->response->end();
//        \Swoole\Event::wait();
//        echo 'use ' . (microtime(true) - $s) . ' s';
//        $this->response->end();
//        go(function (){
//            $swoole_mysql = new \Swoole\Coroutine\MySQL();
//            $swoole_mysql->connect([
//                'host' => '127.0.0.1',
//                'port' => 3306,
//                'user' => 'root',
//                'password' => 'WOaini990117++',
//                'database' => 'blog',
//            ]);
//            $res = $swoole_mysql->query('select * from user');
//            $this->response->end(json_encode($res,true));
//        });
    }
}