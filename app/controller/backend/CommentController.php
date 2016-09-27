<?php
namespace app\controller\backend;

use app\model\CommentModel;
use core\BaseController;

class CommentController extends BaseController
{
	//评论的列表功能
	public function index()
	{
		$this->loginRequired();
		//1) 获取评论列表的动态数据
        $comments = CommentModel::build()->selectAllWithJoin();
        //2) 调用index.php显示评论列表的动态数据,将动态数据传递到index.php
        $this->loadView('backend/comment/index',array(
             'comments' => $comments,
        ));
	}
}