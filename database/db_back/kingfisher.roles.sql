-- MySQL dump 10.13  Distrib 5.7.9, for Linux (x86_64)
--
-- Host: localhost    Database: kingfisher
-- ------------------------------------------------------
-- Server version	5.7.9

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','管理员','管理员角色，负责进行系统管理及安装配置等','2016-11-08 11:36:55','2016-11-08 11:36:55'),(2,'director','运营总监','运营角色，进行商品、订单、发货、物流等操作','2016-11-08 11:36:55','2016-11-08 11:36:55'),(3,'shopkeeper','运营店长','店长角色，进行商品、订单等运营操作','2016-11-08 11:36:55','2016-11-08 11:36:55'),(4,'servicer','客服专员','客服角色，进行订单、发货、物流等操作','2016-11-08 11:36:55','2016-11-08 11:36:55'),(5,'buyer','采购专员','采购角色，进行商品、采购、物流等操作','2016-11-08 11:36:55','2016-11-08 11:36:55'),(6,'storekeeper','库管员','库管角色，进行仓库管理、收货、入库、盘点等操作','2016-11-08 11:36:55','2016-11-08 11:36:55'),(7,'financer','财务专员','财务角色，进行收款、付款、对账、结算、报表等操作','2016-11-08 11:36:55','2016-11-08 11:36:55'),(8,'supplier','供应商','供应商角色，进行选品、下单、物流查看等操作','2016-11-08 11:36:55','2016-11-08 11:36:55'),(9,'distributor','分发商','分发商角色，产品库，站点，分发用户，分发商品等操作','2017-07-25 11:21:37','2017-07-25 11:21:37'),(10,'operation','运维','数据爬取，分析','2017-07-27 06:44:10','2017-07-27 06:44:10');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-17 18:56:59
