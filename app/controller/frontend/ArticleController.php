<?php

namespace app\controller\frontend;

use app\model\ArticleModel;
use app\model\CategoryModel;
use app\model\CommentModel;
use core\BaseController;
use vendor\Pager;

// 前台的文章模块
class ArticleController extends BaseController
{
    // 文章列表功能
    public function index()
    {
        $where = '2 > 1';
        if (isset($_POST['submit'])) {
            $search = $_POST['q'];
            $where .= " AND article.title LIKE '%$search%'";
        }

        //生成分页按钮
        $pageSize = 2;
        //每页显示条数(数字)
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $pager = new Pager(ArticleModel::build()->count($where), $pageSize, $currentPage, 'index.php', array(
              'p' => 'frontend',
              'c' => 'Article',
              'a' => 'index',
            ));
        $buttons = $pager->showPage();
        $limit = " limit " . (($currentPage - 1) * $pageSize) . ",{$pageSize}";


        // 1.查询出文章列表，同时查询出文章的作者的作者的名字，文章的分类的分类的名字，文章的评论的评论的数量
        $articles = ArticleModel::build()->selectAllWithUsernameAndCategoryName($where, $limit);
        // 2.查询出分类列表
        $categories = CategoryModel::build()->selectAll();
        // 3.使用Category::level()对分类列表分级
        $categories = CategoryModel::build()->level($categories);
        //按条件查出的文章数
        $articleCount = ArticleModel::build()->selectArticleCount($where);

        
        // 加载index.html，并且将$articles和$categories传递到index.html
        $this->loadViewBySmarty('frontend/article/index', array(
            'articles' => $articles,
            'categories' => $categories,
            'articleCount' => $articleCount,
            'buttons' => $buttons,
        ));
    }

    //显示文章详情功能
    public function show()
    {
        $id = $_GET['id'];
        //$id文章的阅读书 +1 
        ArticleModel::build()->updateReadCount($id);
        //查出$id文章的详细信息
        $article = ArticleModel::build()->selectOneWithUserNameAndCategoryName($id); 

        //查出文章评论列表,并进行分级操作
        $comments = CommentModel::build()->selectAllWithJoinLevel($where = "`comment`.`article_id` = {$id}");
        
        //将$id文章的详细信息写入视图     
        $this->loadViewBySmarty('frontend/article/show',array(
            'article' => $article,
            'comments' => $comments,
        ));

    }

    //为文章点一个赞
    public function point()
    {
        $id = $_GET['id'];
        if (isset($_SESSION["zan_{$id}"])) {
            //用户已经赞过
            $this->loadView('backend/login/fail');
            $this->redirect(3,"?p=frontend&c=Article&a=show&id={$id}",'已经赞过,不能重复点赞');
        } else {
            //用户没有点赞
            if (ArticleModel::build()->updatePointOfPraise($id)) {
                //点赞成功
                $_SESSION["zan_{$id}"] = "已赞";
                $this->loadView('backend/login/success');
                $this->redirect(1,"?p=frontend&c=Article&a=show&id={$id}",'');
            } else {
                //点赞失败
                $this->loadView('backend/login/fail');
                $this->redirect(1,"?p=frontend&c=Article&a=show&id={$id}",'');
            }

        }
    }

    



}
