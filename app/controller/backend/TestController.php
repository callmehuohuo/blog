<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */

namespace app\controller\backend;

use app\model\UserModel;
use core\Application;
use core\BaseController;

class TestController extends BaseController
{
    public function testmodel()
    {
        // 增
//        $number = UserModel::build()->addOne(array(
//            'username' => '千颂伊',
//            'email' => '2@korea.com',
//            'password' => '111111',
//        ));
//        echo $number;

        // 删
//        $number = UserModel::build()->deleteOne(12);
//        var_dump($number);

        // 改
//        $number = UserModel::build()->updateOne(13, array(
//            'nickname' => '颂伊姐',
//        ));
//        echo $number;

        // 查全部
//        $users = UserModel::build()->selectAll();
//        echo '<pre>';
//        print_r($users);

        // 查一个
//        $user = UserModel::build()->selectOne(13);
//        echo '<pre>';
//        print_r($user);
    }

    public function zy()
    {
        echo "<pre>";
        print_r($_GET);
        print_r(Application::$originGet);
    }

    public function phpinfo()
    {
        \phpinfo();
    }
}