<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/12/8
 * Time: 17:09
 */

namespace core;


use Swoole\Coroutine\Channel;
use Swoole\Coroutine\Mysql;

class MysqlPool
{
    private static $instance;
    private $pool;//连接池容器
    private $config;

    public static function getInstance($config = null)
    {
        if (empty(self::$instance)) {
            if (empty($config)) {
                throw new \RuntimeException("mysql config null");
            }
            self::$instance = new static($config);
        }
        return self::$instance;
    }

    public function __construct($config)
    {
        if (empty($this->pool)) {
            $this->config = $config;
            $this->pool = new Channel($config['pool_size']);
            for ($i = 0; $i < $config['pool_size']; $i++) {
                $mysql = new Mysql();
                $res = $mysql->connect($config);
                if ($res == false) {
                    throw new \RuntimeException('failed to connect mysql');
                } else {
                    $this->put($mysql);
                }
            }
        }
    }

    //向管道写入一个MySQL连接对象
    public function put($mysql)
    {
        $this->pool->push($mysql);
    }

    //从管道获取一个MySQL连接对象
    public function get()
    {
        return $this->pool->pop();
    }
}