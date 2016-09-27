<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */

namespace app\controller\backend;

use vendor\pager;
use app\model\UserModel;

class UserController extends \core\BaseController
{
    public function __construct()
    {
        $this->loginRequired();
    }
    
    public function index()
    {
        // new UserModel()
        $userModel = UserModel::build();
        $where = '2 > 1';
        $limit = '';
        //生成分页按钮
        $pageSize = 5; //每页显示条数
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        

        $pager = new Pager(UserModel::build()->count($where), $pageSize, $currentPage, 'index.php', array(
                  'p' => 'backend',
                  'c' => 'User',
                  'a' => 'index',
            ));
        $buttons = $pager->showPage();
        $limit = " limit " . (($currentPage - 1) * $pageSize) . ",{$pageSize}";
        var_dump($limit);

        // 显示用户列表
        // 1. 调用模型
        $users = $userModel->selectAllUser($where, $limit);
        $arr = array(
            'users' => $users,
            'buttons' => $buttons,
        );
        // 2. 调用视图
        $this->loadView('backend/UserIndex', $arr);
    }

    public function delete()
    {
        $id = $_GET['id'];

        if (UserModel::build()->deleteOne($id) > 0) {
            $this->loadView('backend/login/success');
            $this->redirect(3, 'index.php?p=backend&c=User&a=index', '');
        } else {
            $this->loadView('backend/login/fail');
            $this->redirect(3, 'index.php?p=backend&c=User&a=index', '');
        }
    }


    public function add()
    {
        if (isset($_POST['submit'])) {
            $username = $_POST['Username'];
            $nickname = $_POST['Nickname'];
            $email = $_POST['Email'];

            if (UserModel::build()->addUser($username, $nickname, $email) == 1) {
                // 添加成功
                $this->loadView('backend/login/success');
                $this->redirect(3, '?p=backend&c=User&a=index', '添加成功');
            } else {
                // 添加失败
                $this->loadView('backend/login/fail');
                $this->redirect(3, '?p=backend&c=User&a=add', '');
            }
        } else {
            $this->loadView('backend/UserAdd');
        }
    }

    // 修改用户
    public function update()
    {
        $id = $_GET['id'];
        if (isset($_POST['submit'])) {
            // 接收修改后的用户的信息
            $username = $_POST['Username'];
            $nickname = $_POST['Nickname'];
            $password = $_POST['passWord'];
            $email = $_POST['Email'];

            // 修改后的值输入数据库
            if (UserModel::build()->updateUser($id, $username, $nickname,$password, $email) == 1) {
                // 修改成功
                $this->loadView('backend/login/success');
                $this->redirect(3, '?p=backend&c=User&a=index', '');
            } else {
                // 修改失败
                $this->loadView('backend/login/fail');
                $this->redirect(3, "?p=backend&c=User&a=update&id=$id", '');
            }
        } else {
            // 获取一个用户的信息
            $user = UserModel::build()->getUser($id);
            $arr = array(
                'user' => $user,
            );
            $this->loadView('backend/update', $arr);
        }
    }
}














