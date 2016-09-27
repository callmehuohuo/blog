<?php 
namespace app\controller\backend;

use app\model\ArticleModel;
use app\model\CategoryModel;
use core\BaseController;
use vendor\Pager;

class ArticleController extends BaseController
{   
    public function __construct()
    {
        $this->loginRequired();
    }
	//文章列表
	public function index()
	{
		$where = '2 > 1';
		if (isset($_POST['submit'])) {
			$categoryId = $_POST['category'];
			if ($categoryId > 0) {
				$where .= " AND article . category_id = $categoryId";
			}
			$status = $_POST['status'];
			if ($status) {
				//选择了按状态搜索
				$where .= " AND article . status = $status"; 
			}
			$top = isset($_POST['istop']) ? 1 : 2;
			if ($top == 1) {
				$where .= " AND article . top = 1";
			}
            $title = $_POST['search'];
            if ($title) {
            	$where .= " AND article . title LIKE '%$title%'";
            }		
		}
		//生成分页按钮
		$pageSize = 2; //每页显示条数(字数)
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $pager = new Pager(ArticleModel::build()->count($where), $pageSize, $currentPage, 'index.php', array(
        	    'p' => 'backend',
        	    'c' => 'Article',
        	    'a' => 'index',
        	));
        $buttons = $pager->showPage();

        $limit = " limit " . (($currentPage - 1) * $pageSize) . ",{$pageSize}";
        
		$articles = ArticleModel::build()->selectAllWithUsernameAndCategoryName($where,$limit);
        $categories = CategoryModel::build()->selectAll();
		$categories = CategoryModel::build()->level($categories);
		$this->loadView('backend/article/index',array(
            'categories' => $categories,
            'articles'  => $articles,
            'buttons' => $buttons,
		));
	}
	//添加一个文章
	public function add()
	{
		$this->loginRequired();
        if (isset($_POST['submit'])) {
        	//提交了表单
        	$article = array(
                   'title' => $_POST['Title'],
                   'content' => $_POST['Content'],
                   'category_id' => $_POST['CateID'],
                   'status' => $_POST['Status'],
                   'post_date' => strtotime($_POST['PostTime']),
                   'user_id' => $_SESSION['user']['id'],
                   'top' => isset($_POST['idTop']) ? 1 : 2,
            );
            if (ArticleModel::build()->addOne($article)) {
            	//添加成功
                $this->loadView('backend/article/success');
                $this->redirect(3,'?a=index&c=Article&p=backend','');
            } else {
            	//添加失败
                $this->loadView('backend/article/fail');
            	$this->redirect(3,'?a=add&p=backend&c=Article','');
            }     	
        } else {
        	// 没有提交表单，显示表单
            $categories = CategoryModel::build()->selectAll();
            // 对分类进行分级：level
            $categories = CategoryModel::build()->level($categories);
            $this->loadView('backend/article/add', array(
                'categories' => $categories,
            ));
        }
	}
}






















?>