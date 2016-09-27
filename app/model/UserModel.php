<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\model;

class UserModel extends \core\BaseModel
{
    public static $table = 'user';

    // 返回所有的用户
    public function getUsers()
    {
        return $this->selectAll('user');
    }

    // 返回所有的产品
    public function getProducts()
    {
        return $this->selectAll('product');
    }

    //查询出所有用户信息详情
    public function selectAllUser($where, $limit)
    {
        $sql = "SELECT * FROM `user` WHERE $where $limit";
        return $this->db->getAll($sql);
    }

    // 添加用户
    public function addUser($username, $nickname, $email)
    {
        $sql = "INSERT INTO `user` VALUES (null, '$username', '$email', '', '$nickname', 0, '')";
        return $this->db->exec($sql);
    }

    // 查询一个用户的详情
    public function getUser($id)
    {
        $sql = "SELECT * FROM `user` WHERE id=$id";
        return $this->db->getOne($sql);
    }

    // 修改一个用户的信息
    public function updateUser($id, $username, $nickname, $password, $email)
    {
        $sql = "UPDATE `user` SET username='{$username}',nickname='{$nickname}', password='{$password}',email='{$email}' WHERE id=$id";
        return $this->db->exec($sql);
    }

    //更新用户登录时修改用户的上次登录时间跟登录ip
    public function updateLoginTimeIp($id,$lastlogintime,$lastloginip)
    {
        $sql = "UPDATE `user` SET last_login_time={$lastlogintime}, last_login_ip='{$lastloginip}' WHERE id=$id";
        return $this->db->exec($sql);
    }
}











