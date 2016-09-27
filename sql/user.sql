use php49;

-- id 数字 int 主键 自增
-- 用户名 username 字符串 varchar(18) 不能为空 没有默认值
-- 邮箱 email 字符串 varchar(20) 不能为空 没有默认值
-- 密码 password 字符串 varchar(64) 不能为空 没有默认值
-- 年龄 age 数字 int 不能为空 默认值为0
-- 注册时间 register_time INT 不能为空 默认值为0

CREATE TABLE `user` (
  `id` INT PRIMARY KEY auto_increment,
  `username` varchar(18) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `age` INT NOT NULL DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET utf8;


ALTER TABLE `user` ADD `register_time` INT NOT NULL DEFAULT 0;

INSERT INTO `user` VALUES
(null, 'papi酱', 'papi@vip.qq.com', '111111', 28, 0),
(null, '周杰伦', 'zjl@vip.qq.com', '222222', 30, 0);

-- 昵称 nickname VARCHAR(20) 不能为空 默认值是''
ALTER TABLE `user` ADD `nickname` VARCHAR(20) NOT NULL DEFAULT '';
-- 上次登录时间 last_login_time INT 不能为空 默认值是0
ALTER TABLE `user` ADD `last_login_time` INT NOT NULL DEFAULT 0;
-- 最短ip: 1.1.1.1 最长的ip: 255.255.255.255
-- 上次登录ip last_login_ip VARCHAR(15) 不能为空 默认值是''
ALTER TABLE `user` ADD `last_login_ip` VARCHAR(15) NOT NULL DEFAULT '';
-- 删除注册时间的字段
ALTER TABLE `user` DROP `register_time`;
-- 删除年龄字段
ALTER TABLE `user` DROP `age`;




