<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/11/14
 * Time: 23:23
 */

namespace app\index\controller;

use core\Config;
use core\Controller;
use core\MysqlPool;
use core\xw\Db\Db;
use core\xw\Pool\Context;

class Index extends Controller
{
    public function index()
    {
        $mysqlPool = \core\xw\Pool\MysqlPool::getInstance();

        $mysql = $mysqlPool->get();
        $mysqlPre = $mysql->prepare("select * from user where id = ?");
        $res = $mysqlPre->execute(array(200));
        var_dump($res);
        $this->response->end('Hello World!');
    }
}

