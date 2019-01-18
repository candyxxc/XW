<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 19-1-15
 * Time: 下午5:08
 */

namespace core\xw\Pool;


use core\xw\Db\Db;
use core\xw\Exception\Ehandler;
use Swoole\Coroutine\Channel;
use Swoole\Coroutine\Mysql;

class MysqlPool implements PoolInterface
{
    private static $instanc = NULL;
    protected $pool = NULL;

    public static function getInstance($config = NULL)
    {
        if (self::$instanc == NULL){
            if (empty($config)){
                throw new Ehandler('mysql config not be empty');
            }
            $obj = new self();
            $obj->connect($config);
            self::$instanc = $obj;
        }
        return self::$instanc;
    }

    public function connect($config)
    {
        $this->pool = new Channel($config['pool_size']);
        for ($i = 0;$i < $config['pool_size'];$i++) {
            $obj = $this->createObject($config);
            $this->pool->push($obj);
        }
    }

    public function createObject($config)
    {
        $mysql = new Db();
        $mysql->connect($config);
        return $mysql;
    }


    public function reconnect()
    {
        while (!($this->pool->isEmpty()))
            $this->get();
        for ($i = 0; $i < $this->config['pool_size']; $i++) {
            $mysql = new Db();
            $mysql->connect($this->config);
            $this->put($mysql);
        }
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