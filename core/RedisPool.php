<?php
/**
 * Created by PhpStorm.
 * User: Tango萧小春
 * Date: 2018/11/24
 * Time: 19:11
 */
namespace core;
class RedisPool
{
    public function __construct(int $size=10)
    {
        $this->pool = new \Swoole\Coroutine\Channel($size);
        for ($i = 0; $i < $size; $i++) {
            $redis = new \Swoole\Coroutine\Redis();
            $res = $redis->connect('127.0.0.1', 6379);
            if ($res == false) {
                throw new \RuntimeException("failed to connect redis server.");
            } else {
                $this->put($redis);
            }
        }
    }

    public function get(): \Swoole\Coroutine\Redis
    {
        return $this->pool->pop();
    }

    public function put(\Swoole\Coroutine\Redis $redis)
    {
        $this->pool->push($redis);
    }

    public function close(): void
    {
        $this->pool->close();
        $this->pool = null;
    }
}