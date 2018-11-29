<?php

/**
 * Created by PhpStorm.
 * User: First
 * Date: 2018/11/10
 * Time: 14:28
 */
class redis_curd
{
    private $redisdbSource = NULL;
    private static $instance = NULL;
    public static $data;

    public function __construct()
    {
        $this->redisdbSource=new Swoole\Coroutine\Redis();
        $this->redisdbSource->connect('127.0.0.1',6379);
    }

    public static function getSource()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new redis_curd();
        }
        return self::$instance;
    }

    public function sAdd($key, $fd)
    {
        $redis = new Swoole\Coroutine\Redis();
        $redis->connect('127.0.0.1',6379);
        $redis->sadd($key, $fd);
    }

    public function sRem($key, $fd)
    {
        $this->redisdbSource->srem($key, $fd);
    }

    public function sCard($key)
    {
        $count=$this->redisdbSource->sCard($key);
        return $count;
    }
    public function sMembers($key)
    {
        $data=$this->redisdbSource->sMembers($key);
        return $data;
    }
}

