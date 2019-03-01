<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoXiaoChun
 * Date: 2019/3/1
 * Time: 10:52
 */

namespace core;

//验证器,规则请查看thinkphp5.1手册
use core\xw\Exception\Ehandler;

class Validate extends \core\xw\Validate
{
    /**
     * @param null $scene 验证场景
     * @param null $data  验证数据
     */
    public function goCheck($scene = NULL,$data = NULL)
    {
        $res = $this->scene($scene)->batch()->check($data);
        if (!$res){
            throw new Ehandler($this->getError(),41000);
        }
        return $data;
    }

    //规则
    protected $rule = [
        'name' => 'require|max:5',
    ];

    //错误提示消息
    protected $message = [
        'name.require' =>  '名字不能为空'
    ];

    //验证场景
    protected $scene = [
      'edit' => ['name']
    ];
}