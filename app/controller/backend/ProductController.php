<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\controller\backend;

use app\model\ProductModel;

class ProductController extends \core\BaseController
{
    public function index()
    {
        // 获取到产品列表
        $products = ProductModel::build()->getProducts();
        // 获取到产品的数量
        $productCount = ProductModel::build()->getCount();

        $this->loadView('backend/index');
    }

    // 删除一个产品
    public function delete()
    {
        $id = $_GET['id'];
        if (ProductModel::build()->deleteProduct($id) == 1) {
            // 删除成功
            $this->loadView('backend/login/success');
            $this->redirect(3, '?p=backend&c=Product&a=index', '');
        } else {
            // 删除失败
            $this->loadView('backend/login/fail');
            $this->redirect(3, '?p=backend&c=Product&a=index', '');
        }
    }
}









