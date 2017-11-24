/*创建数据库*/
CREATE DATABASE IF NOT EXISTS `test`;

/*选择数据库*/
USE `test`;

/*创建表*/
CREATE TABLE IF NOT EXISTS `user` (
    id INT(20) NOT NULL AUTO_INCREMENT,
    name VARCHAR(50),
    age INT(11),
    PRIMARY KEY(id)
);

/*插入测试数据*/
INSERT INTO `user` (name, age) VALUES('harry', 20), ('tony', 23), ('tom', 24);