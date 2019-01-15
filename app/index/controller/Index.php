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
use core\xw\Pool\Context;

class Index extends Controller
{
    public function index()
    {
        $this->response->end('Hello World!');
    }
}

