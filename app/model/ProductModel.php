<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\model;

class ProductModel extends BaseModel
{
    // 获取到产品列表
    public function getProducts()
    {
        $sql = "SELECT * FROM `product` WHERE 2 > 1";
        return $this->db->GetRows($sql);
    }

    // 获取到产品的数量
    public function getCount()
    {
        $sql = "SELECT count(*) FROM `product` WHERE 2 > 1";
        return $this->db->GetOneData($sql);
    }

    // 删除一个产品
    public function deleteProduct($id)
    {
        $sql = "DELETE FROM `product` WHERE `pro_id`=$id";
        $this->db->exec($sql);
        return mysql_affected_rows();
    }
}














