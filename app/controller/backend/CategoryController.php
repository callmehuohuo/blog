<?php

namespace app\controller\backend;

use app\model\CategoryModel;
use core\BaseController;

// 分类管理功能
class CategoryController extends BaseController
{
    public function __construct()
    {
        $this->loginRequired();
    }
    // 分类列表功能
    public function index()
    {
        // CategoryController使用CategoryModel从category取数据出来，CategoryController使用index.html显示数据
        $categories = CategoryModel::build()->selectAll();
        // 计算分类所在的级别
        $categories = CategoryModel::build()->level($categories);// 分类新加一个level表示分类的级别
        $this->loadView('backend/category/index', array(
            'categories' => $categories,// $categories传递到模版
        ));
    }

    // 删除一个分类
    public function delete()
    {
        $id = $_GET['id'];

        // 下级的数量大于0，提示不允许删除
        if (CategoryModel::build()->countSub($id) > 0) {
            $this->loadView('backend/category/fail');
            $this->redirect(3, '?p=backend&c=Category&a=index', '');
            exit();
        }

        if (CategoryModel::build()->deleteOne($id) === true) {
            // 删除成功
            $this->loadView('backend/category/success');
            $this->redirect(3, '?p=backend&c=Category&a=index', '删除成功。');
        } else {
            // 删除失败
            $this->loadView('backend/category/fail');
            $this->redirect(3, '?p=backend&c=Category&a=index', '删除失败。');
        }
    }

    // 添加一个分类
    public function add()
    {
        if (isset($_POST['submit'])) {
            // 提交了表单
            $name = $_POST['Name'];
            $nickname = $_POST['Alias'];
            $sort = $_POST['Order'];
            $parentId = $_POST['ParentID'];

            if (CategoryModel::build()->addOne(array(
                'name' => $name,
                'nickname' => $nickname,
                'sort' => $sort,
                'parent_id' => $parentId,
            ))) {
                // 添加成功
                $this->loadView('backend/category/success');
                $this->redirect(3, '?p=backend&c=Category&a=index', '添加成功。');
            } else {
                // 添加失败
                $this->loadView('backend/category/fail');
                $this->redirect(3, '?p=backend&c=Category&a=add', '添加失败。');
            }
        } else {
            // 没有提交表单，显示表单
            $categories = CategoryModel::build()->selectAll();
            // 对分类进行分级：level，又称为无限极分类, 无限极分类算法
            $categories = CategoryModel::build()->level($categories);
            $this->loadView('backend/category/add', array(
                'categories' => $categories,
            ));
        }
    }

    // 修改一个分类
    public function update()
    {
        if (isset($_POST['submit'])) {
            // 提交了表单
            $id = $_GET['id'];
            $category = array(// 修改后的分类
                'name' => $_POST['Name'],
                'nickname' => $_POST['Alias'],
                'sort' => $_POST['Order'],
                'parent_id' => $_POST['ParentID'],
            );
            if (CategoryModel::build()->updateOne($id, $category)) {
                // 修改成功
                $this->loadView('backend/category/success');
                $this->redirect(3, '?p=backend&c=Category&a=index', '');
            } else {
                // 修改失败
                $this->loadView('backend/category/fail');
                $this->redirect(3, "?p=backend&c=Category&a=update&id={$id}", '');
            }
        } else {
            // 显示表单
            $id = $_GET['id'];
            // 查询修改前的一个分类
            $category = CategoryModel::build()->selectOne($id);
            // 查询所有分类，并进行分级
            $categories = CategoryModel::build()->selectAll();
            $categories = CategoryModel::build()->level($categories);
            $this->loadView('backend/category/update', array(
                'category' => $category,
                'categories' => $categories,
            ));
        }
    }
}















