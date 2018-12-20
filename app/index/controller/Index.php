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

class Index extends Controller
{
    public function index()
    {
        $this->response->end('Hello World!');
//        $mysqlPool = MysqlPool::getInstance(Config::getInstance()->getCon('MYSQL'));
//        $mysql = $mysqlPool->get();
//        $data = $mysql->query('select * from user');
//        $mysqlPool->put($mysql);
//        $this->responseJson(200,123456);
    }
}

