<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */

namespace core;

// 项目启动类
class Application
{
    // 最原始的用户输入的$_GET
    public static $originGet;
    // 最原始的用户输入的$_POST
    public static $originPost;

    // 对框架的流程按顺序调用
    public static function run()
    {
        self::defineConst();
        self::defineAutoload();
        self::setCharset();
        self::openSession();
        self::addSlashesUserInput();
        self::routeDispatch();
    }

    // 定义常用常量
    private static function defineConst() {
        $type = isset($_GET['a']) ? $_GET['a'] : 'index';
        $c = isset($_GET['c']) ? $_GET['c'] : 'Article';
        // 接收平台的参数, frontend表示前台 backend表示后台
        $p = isset($_GET['p']) ? $_GET['p'] : 'frontend';
        // 重要的参数
        define('PLATFORM', $p);
        define('CONTROLLER', $c);
        define('ACTION', $type);
        define('DS', '/');
        // 重复的路径
        define('ROOT', './');// 项目根目录
        define('CORE', ROOT . 'core/');// 核心文件目录
        define('APP', ROOT . 'app/');// ./app
        define('VIEW', APP . 'view/');// 视图目录
    }

    // 定义自动加载
    private static function defineAutoload()
    {
        spl_autoload_register('self::autoload');
    }

    private static function autoload($className)
    {
        // echo $className . '还没有加载，正在加载中，请稍等....<br />';
        $fireName =  "./" . str_replace('\\', '/', $className) . ".php";
        if (is_file($fireName)) {
            //文件存在
            require $fireName;
        }
    }

    // 设置字符集
    private static function setCharset()
    {
        header('Content-Type:text/html;charset=utf-8');
    }

    // 开启session
    private static function openSession()
    {
        session_start();
    }

    // 转义用户的所有输入
    private static function addSlashesUserInput()
    {
        // 转义用户输入
        function addslashesArray($arr)
        {
            foreach ($arr as $key => $value) {
                if (is_string($value)) {
                    $arr[$key] = addslashes($value);// 防止sql注入攻击
                } else if (is_array($value)) {
                    $arr[$key] = addslashesArray($value);
                }
            }
            return $arr;
        }
        // 转义前，复制一份$_GET和$_POST
        self::$originGet = $_GET;
        self::$originPost = $_POST;
        $_GET = addslashesArray($_GET);
        $_POST = addslashesArray($_POST);// 对$_POST所有的数据转义
    }

    // 路由分发
    private static function routeDispatch()
    {
        $c= CONTROLLER;
        $type = ACTION;
        $p = PLATFORM;
        $c .= 'Controller';
        $c = "\\app\\controller\\{$p}\\" . $c;
        $controller = new $c();// new \app\controller\backend\UserController, new ProductController, new ...
        $controller->$type();
    }
}










