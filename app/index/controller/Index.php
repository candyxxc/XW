<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/11/14
 * Time: 23:23
 */

namespace app\index\controller;

use core\Controller;
use core\Validate;

class Index extends Controller
{
    public function index()
    {
        $data = [
            'name' => ''
        ];
        $res = (new Validate())->goCheck('index',$data);
        var_dump($res);

        $this->response->end('Hello World!');
    }
}

