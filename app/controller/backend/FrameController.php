<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\controller\backend;

use core\BaseController;

class FrameController extends BaseController
{
    // 骨架页
    public function index()
    {
//        if (用户没有登录) {
//            跳到登录页;
//        }

        /**
         * 1. $_SESSION数组里不存在loginSuccess下标
         * 2. $_SESSION数组里的loginSuccess下标的值是false
         * 我们没有登录/登录失败了
         */
        if ((!isset($_SESSION['loginSuccess'])) || ($_SESSION['loginSuccess'] === false)) {
            $this->redirect(3, '?p=backend&c=Login&a=login', '请登录。');
            exit(0);
        }
        $this->loadView('backend/frame/index');
    }

    // 左侧菜单
    public function left()
    {
        $this->loadView('backend/frame/left');
    }

    // 内容页
    public function content()
    {
        $this->loadView('backend/frame/content');
    }

    // 顶部导航
    public function top()
    {
        $this->loadView('backend/frame/top');
    }
}