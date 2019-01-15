<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 19-1-15
 * Time: 下午5:52
 */

namespace core\xw\Exception;


class Ehandler extends \Exception
{

    public $msg;
    public $errorCode;

    public function __construct($msg = "发现错误",$errorCode = 99999)
    {
        $this->msg = $msg;
        $this->errorCode = $errorCode;

    }
}