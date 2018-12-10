<?php
/**
 * Created by PhpStorm.
 * User: XiaoXiaoChun
 * Date: 2018/12/1
 * Time: 11:21
 */
namespace core;
class Config
{
    protected static $instance = null;
    private function __construct(){}

    public static function getInstance()
    {
        if (empty(self::$instance)){
            self::$instance=new Config();
        }
        return self::$instance;
    }
    public function getCon($configName=null)
    {
        $config= include '../config/config.php';
        if ($configName==null){
            return $config;
        }
        return $config[$configName];
    }
}