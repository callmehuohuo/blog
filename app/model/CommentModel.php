<?php 
namespace app\model;

use core\BaseModel;

class CommentModel extends BaseModel
{
	public static $table = 'comment';
	public function selectAllWithJoin($where = '2 > 1')
	{
		$sql = "SELECT `comment`.*, `user`.`username` AS user_name, `article`.`title` AS article_title, parent_comment.`content` AS parent_content FROM `comment` 
		              LEFT JOIN `user` ON `comment`.`user_id`=`user`.`id` 
		              LEFT JOIN `article` ON `comment`.`article_id`=`article`.`id` 
		              LEFT JOIN `comment` AS parent_comment ON `comment`.`parent_id`=parent_comment.id
		              WHERE $where";
		return $this->db->getAll($sql);
	}

	//返回查询评论列表,同时返回评论列表的作者和作者的名字,评论文章的文章的名字,父评论的评论内容
	public function selectAllWithJoinLevel($where)
	{
       $comments = $this->selectAllWithJoin($where);

       //对评论进行分类操作
       $comments = $this->level($comments);

       return $comments;
	}

	private function level($comments, $parentId = 0)
	{
       //存放分级后评论
       $levelComments = array();
       foreach ($comments as $comment) {
       	  if ($comment['parent_id'] == $parentId) {
       	  	//找出$comment评论的所有子评论的
       	  	$comment['children'] = $this->level($comments,$comment['id']);
       	  	
       	  	$levelComments[] = $comment; 
       	  }
       }
       return $levelComments;
	}
}