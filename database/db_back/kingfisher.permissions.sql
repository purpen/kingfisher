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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (3,'admin.user.viewlist','用户管理：查看、列表、搜索权限','','2016-10-23 16:39:49','2016-10-23 16:41:19'),(4,'admin.user.store','用户管理：新增、编辑、更新等权限','','2016-10-23 16:40:26','2016-10-23 16:41:12'),(5,'admin.user.destroy','用户管理：删除、禁用用户等权限','','2016-10-23 16:41:02','2016-10-23 16:41:02'),(6,'admin.role.viewlist','角色管理：查看、列表、搜索等权限','','2016-10-23 16:41:58','2016-10-23 16:41:58'),(7,'admin.role.store','角色管理：新增、编辑、更新等权限','','2016-10-23 16:42:31','2016-10-23 16:42:31'),(8,'admin.role.destroy','角色管理：删除、禁用用户等权限','','2016-10-23 16:43:01','2016-10-23 16:43:01'),(9,'admin.storage.viewlist','仓库管理：列表、查看、搜索等权限','','2016-10-23 16:44:02','2016-10-23 16:44:02'),(10,'admin.storage.store','仓库管理：新增、编辑、更新等权限','','2016-10-23 16:44:33','2016-10-23 16:44:33'),(11,'admin.storage.destroy','仓库管理：开放、关闭等权限','','2016-10-23 16:45:03','2016-10-23 16:45:03'),(12,'admin.supplier.viewlist','供应商管理：查看、列表、搜索等权限','','2016-10-23 16:45:57','2016-10-23 16:45:57'),(13,'admin.supplier.store','供应商管理：新增、编辑、更新等权限','','2016-10-23 16:46:26','2016-10-23 16:46:26'),(14,'admin.supplier.destroy','供应商管理：删除等权限','','2016-10-23 16:47:07','2016-10-23 16:47:07'),(15,'admin.logistics.viewlist','物流管理：物流与发货列表、查看、搜索等权限','','2016-10-23 16:48:09','2016-10-23 16:48:09'),(16,'admin.logistics.store','物流管理：物流与发货新增、编辑、更新等权限','','2016-10-23 16:48:36','2016-10-23 16:48:36'),(17,'admin.logistics.destroy','物流管理：物流与发货删除、禁用等权限','','2016-10-23 16:49:14','2016-10-23 16:49:14'),(18,'admin.setting.viewlist','基本设置：列表、查看、搜索等权限','','2016-10-23 16:49:59','2016-10-23 16:49:59'),(19,'admin.setting.store','基本设置：新增、编辑、更新等权限','','2016-10-23 16:50:41','2016-10-23 16:50:41'),(20,'admin.setting.destroy','基本设置：删除、禁用等权限','','2016-10-23 16:51:11','2016-10-23 16:51:11'),(21,'admin.product.viewlist','商品管理：列表、查看、搜索等权限','','2016-10-23 16:51:45','2016-10-23 16:51:45'),(22,'admin.product.store','商品管理：新增、编辑、更新等权限','','2016-10-23 16:52:10','2016-10-23 16:52:10'),(23,'admin.product.destroy','商品管理：删除、隐藏等权限','','2016-10-23 16:52:39','2016-10-23 16:52:39'),(24,'admin.purchase.viewlist','采购管理：列表、查看、搜索等权限','','2016-10-23 16:53:16','2016-10-23 16:53:16'),(25,'admin.purchase.store','采购管理：新增、编辑、更新等权限','','2016-10-23 16:53:42','2016-10-23 16:53:42'),(26,'admin.purchase.destroy','采购管理：删除等权限','','2016-10-23 16:54:07','2016-10-23 16:54:07'),(27,'admin.purchase.verified','采购管理：审核等权限','','2016-10-23 16:54:38','2016-10-23 16:54:38'),(28,'admin.warehouse.viewlist','入库管理：查看、列表、搜索等权限','','2016-10-23 16:55:15','2016-10-23 16:55:15'),(29,'admin.warehouse.change','入库管理：库存变更等权限','','2016-10-23 16:59:36','2016-10-23 16:59:36'),(30,'admin.warehouse.verify','入库管理：调拨单审核等权限','','2016-10-23 17:00:06','2016-10-23 17:00:06'),(31,'admin.warehouse.store','入库管理：新增、编辑、更新等权限','','2016-10-23 17:00:39','2016-10-23 17:00:39'),(32,'admin.order.viewlist','订单管理：查看、列表、搜索等权限','','2016-10-23 17:01:13','2016-10-23 17:01:13'),(33,'admin.order.store','订单管理：新增、编辑、更新等权限','','2016-10-23 17:01:43','2016-10-23 17:01:43'),(34,'admin.order.verify','订单管理：审核等权限','','2016-10-23 17:02:10','2016-10-23 17:02:10'),(35,'admin.order.send','订单管理：发货等权限','','2016-10-23 17:02:58','2016-10-23 17:02:58'),(36,'admin.order.destroy','订单管理：删除、撤销等权限','','2016-10-23 17:03:26','2016-10-23 17:03:26'),(37,'admin.payment.viewlist','财务管理：列表、查看、搜索等权限','','2016-10-23 17:04:29','2016-10-23 17:04:29'),(38,'admin.payment.store','财务管理：新增、编辑、更新等权限','','2016-10-23 17:09:57','2016-10-23 17:09:57'),(39,'admin.payment.confrim','财务管理：审核等权限','','2016-10-23 17:10:42','2016-12-04 14:48:32'),(40,'admin.payment.charge','财务管理：charge等权限','','2016-10-23 17:11:22','2016-10-23 17:11:22'),(41,'admin.payment.reject','订单管理：驳回等权限','','2016-10-23 17:12:14','2016-10-23 17:12:14'),(42,'admin.supplier.verified','供应商管理：审核，关闭权限','','2016-11-08 12:25:52','2016-11-08 12:25:52'),(43,'admin.product.verified','商品设置：审核/下架','','2016-11-09 02:32:27','2016-11-09 02:32:27'),(44,'admin.synchronousStock.store','同步库存：同步操作，同步记录','','2016-11-09 06:30:03','2016-11-09 06:30:03'),(45,'admin.positiveEnergy.viewlist','短语设置：短语列表','','2016-11-10 02:40:41','2016-11-10 02:40:41'),(46,'admin.positiveEnergy.store','短语设置： 新增/修改','','2016-11-10 02:41:02','2016-11-10 02:41:02'),(47,'admin.positiveEnergy.destroy','短语管理： 删除','','2016-11-10 02:41:18','2016-11-10 02:41:18'),(48,'admin.warehouse.verified','出库管理：出库审核','','2016-11-28 11:50:39','2016-11-28 11:50:39'),(49,'admin.index.store','异常信息确认','','2016-11-28 11:50:57','2016-11-28 11:50:57'),(50,'admin.orderUser.viewlist','会员管理：列表/搜索','','2016-11-28 11:51:16','2016-11-28 11:51:16'),(51,'admin.orderUser.store','会员管理：创建/修改','','2016-11-28 11:51:31','2016-11-28 11:51:31'),(52,'admin.orderUser.destroy','会员管理：删除','','2016-11-28 11:52:03','2016-11-28 11:52:03'),(60,'admin.salesStatistics.viewList','销售统计：列表','','2016-12-06 06:47:13','2016-12-06 06:47:13'),(61,'admin.userSaleStatistics.viewList','人员销售统计：列表','','2016-12-23 08:05:45','2016-12-23 08:05:45'),(62,'admin.statistics.viewList','销售统计：sku销售 统计	','','2016-12-27 03:30:02','2016-12-27 03:30:02'),(63,'admin.payment.confirm','财务收款','','2016-12-30 07:46:24','2016-12-30 07:46:24'),(64,'admin.refund.viewlist','退款管理：列表','','2017-01-13 06:41:20','2017-09-25 06:21:42'),(65,'admin.user.stats','销售统计','','2017-01-13 06:53:58','2017-01-13 06:53:58'),(66,'admin.chinaCity.viewlist','城市列表','','2017-01-13 07:01:26','2017-01-13 07:01:26'),(67,'admin.saasProduct.viewList','分发SAAS：列表/详情 查看','','2017-06-21 07:03:37','2017-06-30 02:51:02'),(68,'admin.saasProduct.store','分发SAAS： 商品 编辑/删除','','2017-06-30 02:50:40','2017-06-30 02:50:40'),(69,'admin.site.operate','网站操作','','2017-07-27 06:40:55','2017-07-27 06:40:55'),(70,'admin.site.view','网站查看','','2017-07-27 06:41:13','2017-07-27 06:41:13'),(71,'admin.refund.store','退款管理：同意、拒绝','','2017-09-25 06:11:52','2017-09-25 06:11:52'),(72,'admin.takeStock.viewlist','仓库盘点相关操作','','2017-10-13 09:25:32','2017-10-13 09:25:32');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-17 18:57:07
