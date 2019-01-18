<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 19-1-18
 * Time: 下午4:45
 */

namespace core\xw\Db;


use core\xw\Exception\Ehandler;
use mysql_xdevapi\Exception;
use Swoole\Coroutine\Mysql;

class Db
{
    private $mysql;
    private $config;


    public function connect($config)
    {

        $mysql = new Mysql();
        $res = $mysql->connect($config);
        if ($res) {
            $this->mysql = $mysql;
            $this->config = $config;
        } else {
            throw new \Exception($mysql->connect_error, $mysql->connect_errno);
        }

    }

    public function prepare($sql)
    {
        $stmt = $this->mysql->prepare($sql);
        if ($stmt !== false) {
            return $stmt;
        }
        if ($this->mysql->errno === 2006) {
            $this->resConnect = true;
            $mysqlPool = MysqlPool::getInstance();
            $mysqlPool->reconnect();
            $mysqlCli = $mysqlPool->get();
            $mysqlPool->put($mysqlCli);
            return $mysqlCli->prepare($sql);
        } else {
            $error = $this->mysql->error;
            $errno = $this->mysql->errno;
            throw new Ehandler($error, $errno);
        }
    }
}