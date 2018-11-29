<?php
/**
 * Created by PhpStorm.
 * User: Tango萧小春
 * Date: 2018/11/24
 * Time: 14:22
 */

namespace app\index\controller;


use core\Controller;
use core\RedisPool;

class User extends Controller
{
    public function regiSter()
    {
        \Swoole\Runtime::enableCoroutine();
        go(function () {
            $pool = new RedisPool();
            // max concurrency num is more than max connections
            // but it's no problem, channel will help you with scheduling
            $redis = $pool->get();
            $redis->get('awesome');
            $pool->put($redis);
        });
        $this->response->end();

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