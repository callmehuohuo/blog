<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace core;

class BaseController
{
    protected function redirect($w, $u, $m)
    {
        header("Refresh:{$w};url={$u}");
        echo $m;
    }

    // 加载视图
    public function loadView($view, $arr = array())
    {
        foreach($arr as $key => $value) {
            // $key => $users
            $$key = $value;
        }
        require VIEW . "{$view}.html";
    }

    // 通过smarty加载视图
    public function loadViewBySmarty($view, $arr = array())
    {
        // $view的路径是相对于app/view目录
        require ROOT . 'vendor/libs/Smarty.class.php';
        $smarty = new \Smarty();
        // 修改smarty的左定界符为 <{, 右定界符为 }>
        $smarty->left_delimiter = '<{';
        $smarty->right_delimiter = '}>';
        // smarty默认使用模版目录templates，我们项目里的目录是view
        $smarty->setTemplateDir(VIEW);
        // smarty默认使用编译目录是templates_c，我们项目里使用 C:/Windows/Temp/templates_c | /tmp/templates_c
        $smarty->setCompileDir(sys_get_temp_dir() . '/templates_c');
        // smarty默认使用的配置文件目录是configs，我们项目里使用 app/config
        $smarty->setConfigDir(APP . 'config');

        // 调用smarty的assign将$arr传递到html里
        $smarty->assign($arr);

        // 调用smarty的display关联html文件
        $view = $view . '.html';
        $smarty->display($view);
    }
    
    //用户未登录,跳转到登录页面
    //        if (用户没有登录) {
    //            跳到登陆页面;
    //        }
    /*
       1. $_SESSION数组里不存在loginSuccess下标
       2. $_SESSION数组里的loginSuccess下标的值是false,我们没有登录/登录失败了
     */
    public function loginRequired()
    {
        if ((!isset($_SESSION['loginSuccess'])) || ($_SESSION['loginSuccess']) === false)  {
              $this->redirect(3,'?p=backend&c=Login&a=login','请登录');
              exit();
        }
    }
} 






