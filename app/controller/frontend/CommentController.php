<?php 
namespace app\controller\frontend;

use app\model\CommentModel;
use core\BaseController;

class CommentController extends BaseController
{
     //文章添加评论的方法
    public function add()
    {
        //权限控制器,要求用户必须登录
        //1. 接收用户的提交的评论
        //2. 调用CommentModel用户提交的评论输入到comment表
        //3. 评论成功,提示用户评论成功,并且跳转到文章详情页面,评论失败,提示用户评论失败,并且跳转到文章详情页面       
        $this->loginRequired();                
        //1. 接收用户提交的评论
        $articleId = $_POST['a_id'];
        $content   = $_POST['txaArticle'] = str_replace('<script>','&lt;script&gt;',$_POST['txaArticle']);
        $parentId  = $_POST['inpRevID'];
        $userId    = $_SESSION['user']['id'];
        $postDate  = time();
        //2. 调用CommentModel将用户提交的评论输入到comment表
        //3. 评论成功,提示用户评论成功,并且跳转到文章详情页面,评论失败,提示用户评论失败,并且跳转大炮文章详情页面
        if (CommentModel::build()->addOne(array(
            'article_id' => $articleId,
            'content' => $content,
            'parent_id' => $parentId,
            'user_id' => $userId,
            'post_date' => $postDate,
          ))) {
            //添加成功
            $this->loadView('backend/login/success');
            $this->redirect(2,"?p=frontend&c=Article&a=show&id={$articleId}","");
        } else {
            //添加失败
            $this->loadView('backend/login/fail');
            $this->redirect(2,"?p=frontend&c=Article&a=show&id={$articleId}","");
        }
    }

}