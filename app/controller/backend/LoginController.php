<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */



namespace app\controller\backend;

use app\model\UserModel;
use core\BaseController;
use vendor\Captcha;

class LoginController extends BaseController
{
    public function login()
    {
        if (isset($_POST['btnPost'])) {
            // 提交表单
            $username = $_POST['username'];
            $password = $_POST['password'];
            $captcha = $_POST['edtCaptcha'];
            if ($captcha === $_SESSION['captchaCode']) {
                // 一样
            } else {
                // 不一样
                $this->loadView('backend/login/fail');
                $this->redirect(3, '?p=backend&c=Login&a=login', '');
            }
            // var_dump($username, $password);
            $user = UserModel::build()->selectOneBy("MD5(password)='$password' AND username='$username' ");// $user可能找不到，用户名/密码错误了
            // var_dump($user);
            if ($user === false) {
                $_SESSION['loginSuccess'] = false;
                // 登录失败 调用跳转视图
                $this->loadView('backend/login/fail');               
                $this->redirect(3, '?p=backend&c=Login&a=login', '');
            } else {
                // 登录成功
                $_SESSION['loginSuccess'] = true;
                $_SESSION['user'] = $user;
                //当前用户id
                $id = $user['id'];
                //当前时间
                $_SESSION['current_time'] = time();
                //当前IP
                $_SESSION['current_ip'] = $_SERVER['REMOTE_ADDR'];

                UserModel::build()->updateLoginTimeIp($id, $_SESSION['current_time'], $_SESSION['current_ip']);
                //登录成功 调用跳转视图
                $this->loadView('backend/login/success');
                $this->redirect(3, '?p=backend&c=Frame&a=index', '');
            }
        } else {
            // 显示登陆页面
            $this->loadView('backend/login/login');
        }
    }

    public function logout()
    {
        // 修改/删除 $_SESSION 里的loginSuccess下标
        // $_SESSION['loginSuccess'] = false;
        // unset($_SESSION['loginSuccess']);
        $_SESSION = array();// 清空session，防止其它逻辑代码使用$_SESSION时的逻辑错误
        session_destroy();// 下一次请求时影响$_SESSION,不影响本次请求
        // 退出成功后跳转到登录页面
        $this->loadView('backend/login/success');
        $this->redirect(3, '?p=backend&c=Login&a=login', '');
    }

    // 输出验证码图片
    public function captcha()
    {
        $captcha = new Captcha();
        $captcha->generateCode();// 输出验证码图片
        $_SESSION['captchaCode'] = $captcha->getCode();
    }
}































