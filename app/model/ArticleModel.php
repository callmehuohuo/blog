<?php 
namespace app\model;

use core\BaseModel;

class ArticleModel extends BaseModel
{
     public static $table = 'article';

     //返回所有文章,同时查处文章的作者的名字和文章的分类的分类的名字
     public function selectAllWithUsernameAndCategoryName($where, $limit = '')
     {
       	$sql = "SELECT article.*, category.name AS category_name, user.username AS user_name, count(comment.id) AS comment_count FROM article
                    LEFT JOIN category ON article.category_id = category.id
                    LEFT JOIN user ON article.user_id=user.id
                    LEFT JOIN comment ON comment.article_id=article.id
                    WHERE $where
                    GROUP BY article.id
                    $limit";
       	return $this->db->getAll($sql);
     }

     //返回查询的文章数量
     public function selectArticleCount($where, $limit = '')
     {
        $sql = "SELECT article.*, count(article.id) AS article_count, category.name AS category_name, user.username AS user_name, count(comment.id) AS comment_count FROM article
                    LEFT JOIN category ON article.category_id = category.id
                    LEFT JOIN user ON article.user_id=user.id
                    LEFT JOIN comment ON comment.article_id=article.id
                    WHERE $where $limit";
        return $this->db->getOne($sql);
     }

     //返回查出详细的文章,并同时返回这个文章的作者名和分类名
     public function selectOneWithUsernameAndCategoryName($id)
     {
        $sql = "SELECT `article`.*, `user`.`username` AS user_name, `category`.`name` AS category_name, count(`comment`.`id`) AS comment_count FROM `article`
                   LEFT JOIN `user` ON `article`.`user_id` = `user`.`id`
                   LEFT JOIN `category` ON `category`.`id` = `article`.`category_id`
                   LEFT JOIN `comment` ON `comment`.`article_id` = `article`.`id`
                   WHERE `article`.`id` = $id";
        return $this->db->getOne($sql);
     }

     //为文章的点赞数+1, 返回点赞了0或1的数量
     public function updatePointOfPraise($id)
     {
        $sql = "UPDATE `article` SET `point_of_praise`= `point_of_praise` + 1 WHERE `id`={$id}";
        return $this->db->exec($sql);
     }

     // 为文章的阅读书+1,
     public function updateReadCount($id)
     {
        $sql = "UPDATE `article` SET `read_count`=`read_count` + 1 WHERE `id` = {$id}";
        return $this->db->exec($sql);
     }
}














?>