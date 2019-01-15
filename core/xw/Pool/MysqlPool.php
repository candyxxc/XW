<?php
/**
 * Created by PhpStorm.
 * User: xxc
 * Date: 19-1-15
 * Time: 下午5:08
 */

namespace core\xw\Pool;


use core\xw\Exception\Ehandler;
use Swoole\Coroutine\Channel;
use Swoole\Coroutine\Mysql;

class MysqlPool implements PoolInterface
{
    protected $pool = NULL;

    public function connect($config)
    {
        if (empty($config)){
            throw new Ehandler('mysql config not be empty');
        }
        $this->pool = new Channel($config['pool_size']);
        for ($i = 0;$i < $config['pool_size'];$i++) {
            $this->pool->push($this->createObject($config));
        }
    }

    public function createObject($config)
    {
        $mysql = new Mysql();
        $mysql->connect($config);
        return $mysql;
    }

    public function put($obj)
    {
        $this->pool->push($obj);
        // TODO: Implement put() method.
    }

    public function get()
    {
        return $this->pool->pop();
        // TODO: Implement get() method.
    }

    public function length()
    {
        return $this->pool->length();
        // TODO: Implement length() method.
    }
}