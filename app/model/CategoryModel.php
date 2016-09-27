<?php

namespace app\model;

use core\BaseModel;

class CategoryModel extends BaseModel
{
    public static $table = 'category';

    /**
     * @param $categories 是CategoryModel::build()->selectAll()的结果
     * @param int $level 是级别，默认是第0个级别
     * @param int $parentId 是父分类id，默认是顶级分类的父分类0
     * @return array 含有level元素的分类
     */
    public function level($categories, $level = 0, $parentId = 0) {
        static $levelCategories = array();

        foreach ($categories as $key => $category) {
            if ($category['parent_id'] == $parentId) {// 只有顶级分类
                $category['level'] = $level;
                $levelCategories[] = $category;// 将顶级分类存放到$levelCategories
                // 计算顶级分类下分类的level
                $this->level($categories, $level + 1, $category['id']);
            }
        }
        return $levelCategories;
    }

    // 返回$id的下级分类的数量
    public function countSub($id)
    {
        $category = static::$table;
        $sql = "SELECT count(*) AS c FROM `$category` WHERE parent_id=$id";
        $row = $this->db->getOne($sql);
        return $row['c'];
    }
}













