<?php
/**
 * Created by PhpStorm.
 * User: Tang萧小春
 * Date: 2018/11/14
 * Time: 23:23
 */

namespace app\index\controller;

use core\Controller;

class Index extends Controller
{
    public function index()
    {
        $this->respons->end("Swoole Server!!!!!");
    }

    public function test()
    {
        $config = include_once '/usr/share/nginx/html/xxc/config/databases.php';
        $this->response->end(var_dump($config));
    }
}

