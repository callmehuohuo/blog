<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */

namespace core;

class BaseModel
{
    protected $db;

    public function __construct()
    {
        require APP . 'config/db.php';
        $this->db = new PDOWrapper($arr);
    }

    private static $instances = array();
    public static function build()
    {
        $className = get_called_class();

        if (isset(self::$instances[$className]) == false) {
            self::$instances[$className] = new $className;
        }

        return self::$instances[$className];
    }

    // 查出所有的记录
    public function selectAll()
    {
        $table = static::$table;
        $sql = "SELECT * FROM `{$table}` WHERE 2 > 1 ";
        return $this->db->getAll($sql);
    }

    // 查出一行记录
    public function selectOne($id)
    {
        $table = static::$table;
        $sql = "SELECT * FROM `{$table}` WHERE id='{$id}'";
        return $this->db->getOne($sql);
    }

    // 通过条件查询一行数据
    public function selectOneBy($where = '2 > 1')
    {
        $table = static::$table;
        $sql = "SELECT * FROM `{$table}` WHERE $where LIMIT 1";
        return $this->db->getOne($sql);
    }
    

    // 添加一个
    /**
     * @param Array $data 新纪录的值
     */
    public function addOne($data)
    {
        $table = static::$table;
        /**
         * $data变量的数据格式
         * array(
                '字段的名字' => '字段的值',
                '字段的名字' => '字段的值',
                '字段的名字' => '字段的值',
                '字段的名字' => '字段的值',
                '字段的名字' => '字段的值',
         * )
         */
        $zd = implode(',', array_keys($data));// array('字段的名字', '字段的名字', '字段的名字', '字段的名字')
        $z = "'" . implode("','", array_values($data)) . "'";// array('字段的值', '字段的值', '字段的值')
        $sql = "INSERT INTO `{$table}` ($zd) VALUES ($z)";
        return $this->db->exec($sql);
    }

    // 修改一个
    /**
     * @param $id Integer id
     * @param $data Array 修改后的记录
     * @param $table String 表名
     */
    public function updateOne($id, $data, $primaryName = 'id')
    {
        $table = static::$table;
        /**
         * $data变量的数据格式
         * array(
        '字段的名字' => '字段的值',
        '字段的名字' => '字段的值',
        '字段的名字' => '字段的值',
        '字段的名字' => '字段的值',
        '字段的名字' => '字段的值',
         * )
         */
        $s = '';
        foreach ($data as $zd => $z) {
            $s .= "{$zd}='{$z}',";
        }
        $s = substr($s, 0, strlen($s) - 1);
        $sql = "UPDATE `{$table}` SET $s WHERE {$primaryName}='{$id}'";
        return $this->db->exec($sql);
    }

    // 删除一个数据
    public function deleteOne($id, $primaryName = 'id')
    {
        $table = static::$table;
        $sql = "DELETE FROM `{$table}` WHERE {$primaryName}='{$id}'";
        return (bool) $this->db->exec($sql);// 1 => true, 0 => false
    }

    //返回总记录数
    public function count($where = '2 > 1')
    {
        $table = static::$table;
        $sql = "SELECT count(*) AS c FROM $table WHERE $where";
        $row = $this->db->getOne($sql);
        return $row['c'];
    }
}
















