
-- 设计分类表：
-- 1.序号 id INT 主键 自增
-- 2.排序 sort INT 不能为空 默认值是0
-- 3.名称 name VARCHAR(20) 不能为空 没有默认值
-- 4.别名 nickname VARCHAR(20) 不能为空 默认值''
-- 5.父分类 parent_id INT 不能为空 默认值是0

use php49;

CREATE TABLE `category` (
  `id` INT PRIMARY KEY auto_increment,
  `sort` INT NOT NULL DEFAULT 0,
  `name` VARCHAR(20) NOT NULL,
  `nickname` VARCHAR(20) NOT NULL DEFAULT '',
  `parent_id` INT NOT NULL DEFAULT 0
)ENGINE=INNODB DEFAULT CHARSET utf8;

-- 测试数据
insert into category (id, name, nickname, parent_id, sort) values
(null,'科技','',0,50), -- 1
(null,'武侠','',0,50), -- 2
(null,'旅游','',0,50), -- 3
(null,'美食','',0, 50), -- 4
(null,'IT','',1,50),   -- 5
(null,'生物','',1,50), -- 6
(null,'鸟类','',6,50), -- 7
(null,'湘菜','',4,50), -- 8
(null,'粤菜','',4,50), -- 9
(null,'川菜','',4,50), -- 10
(null,'跳跳蛙','',8,50), -- 11
(null,'口味虾','',8,50), -- 12
(null,'臭豆腐','',8,50), -- 13
(null,'白切鸡','',9,50), -- 14
(null,'隆江猪脚','',9,50); -- 15