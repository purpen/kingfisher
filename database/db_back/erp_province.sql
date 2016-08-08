# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.12-log)
# Database: kingfisher
# Generation Time: 2016-08-08 08:49:09 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table erp_province
# ------------------------------------------------------------

DROP TABLE IF EXISTS `erp_province`;

CREATE TABLE `erp_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '1 - 直辖市\r\n2 - 行政省\r\n3 - 自治区\r\n4 - 特别行政区\r\n5 - 其他国家\r\n见全局数据字典[省份类型] \r\n',
  `status` tinyint(1) DEFAULT '1' COMMENT '0 - 禁用\r\n1 - 启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `erp_province` WRITE;
/*!40000 ALTER TABLE `erp_province` DISABLE KEYS */;

INSERT INTO `erp_province` (`id`, `number`, `name`, `type`, `status`)
VALUES
	(1,1,'国外',5,1),
	(2,10,'北京',1,1),
	(3,11,'上海',1,1),
	(4,12,'天津',1,1),
	(5,13,'重庆',1,1),
	(6,14,'河北',2,1),
	(7,15,'山西',2,1),
	(8,16,'内蒙古 ',3,1),
	(9,17,'辽宁',2,1),
	(10,18,'吉林',2,1),
	(11,19,'黑龙江',2,1),
	(12,20,'江苏',2,1),
	(13,21,'浙江',2,1),
	(14,22,'安徽',2,1),
	(15,23,'福建',2,1),
	(16,24,'江西',2,1),
	(17,25,'山东',2,1),
	(18,26,'河南',2,1),
	(19,27,'湖北',2,1),
	(20,28,'湖南',2,1),
	(21,29,'广东',2,1),
	(22,30,'广西',3,1),
	(23,31,'海南',2,1),
	(24,32,'四川',2,1),
	(25,33,'贵州',2,1),
	(26,34,'云南',2,1),
	(27,35,'西藏',3,1),
	(28,36,'陕西',2,1),
	(29,37,'甘肃',2,1),
	(30,38,'青海',2,1),
	(31,39,'宁夏',3,1),
	(32,40,'新疆',3,1),
	(33,41,'香港',4,1),
	(34,42,'澳门',4,1),
	(35,43,'台湾',2,1);

/*!40000 ALTER TABLE `erp_province` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
