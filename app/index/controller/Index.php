<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/11/14
 * Time: 23:23
 */

namespace app\index\controller;

use core\xw\validate\ValidateRule as Rule;
use core\Controller;

class Index extends Controller
{
    public function index()
    {
        $mysqlPool = \core\xw\Pool\MysqlPool::getInstance();

        $mysql = $mysqlPool->get();
        $mysqlPre = $mysql->prepare("select * from user where id = ?");
        $res = $mysqlPre->execute(array(200));
//        var_dump($res);
        $validate = new \core\xw\Validate();
        $validate->rule('age', Rule::isNumber()->between([1,120]))
            ->rule([
                'name'  => Rule::isRequire()->max(25),
                'email' => Rule::isEmail(),
            ]);
        $data = [
            'name'  => 'thinkphpthinkphpthinkphpthinkphpthinkphp',
            'email' => 'thinkphp@qq.com'
        ];

        if (!$validate->check($data)) {
            var_dump($validate->getError());
        }

        $this->response->end('Hello World!');
    }
}

