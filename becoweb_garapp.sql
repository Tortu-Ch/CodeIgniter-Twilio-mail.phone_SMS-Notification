-- MySQL dump 10.13  Distrib 5.7.24, for Win64 (x86_64)
--
-- Host: garmysqlserver.mysql.database.azure.com    Database: becoweb_garapp
-- ------------------------------------------------------
-- Server version	5.6.39.0

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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `action` enum('created','updated','deleted') COLLATE utf8_unicode_ci NOT NULL,
  `log_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `log_type_title` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `log_type_id` int(11) NOT NULL DEFAULT '0',
  `changes` mediumtext COLLATE utf8_unicode_ci,
  `log_for` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `log_for_id` int(11) NOT NULL DEFAULT '0',
  `log_for2` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `log_for_id2` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,'2018-12-13 05:03:55',1,'created','task','Turnover Painting',1,NULL,'project',1,'',0,0),(2,'2018-12-13 05:08:15',4,'updated','task','Turnover Painting',1,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"2\";}}','project',1,'',0,0),(3,'2018-12-13 05:09:02',4,'updated','task','Turnover Painting',1,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"2\";s:2:\"to\";s:1:\"3\";}}','project',1,'',0,0),(4,'2018-12-13 05:10:18',4,'created','task_comment','agreamos un bano',1,NULL,'project',1,'task',1,0),(5,'2018-12-26 14:30:36',3,'created','task','Painting',2,NULL,'project',2,'',0,1),(6,'2018-12-26 14:55:36',4,'created','task_comment','Check please ',2,NULL,'project',2,'task',2,1),(7,'2018-12-26 15:01:19',3,'updated','task','Painting',2,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"2\";}}','project',2,'',0,1),(8,'2018-12-26 15:01:38',4,'updated','task','Painting',2,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"2\";s:2:\"to\";s:1:\"3\";}}','project',2,'',0,1),(9,'2019-01-03 16:11:54',1,'created','task','Painting',3,NULL,'project',3,'',0,0),(10,'2019-01-03 16:12:29',4,'created','task_comment','Gracias',4,NULL,'project',3,'task',3,0),(11,'2019-01-03 16:14:10',4,'updated','task','Painting',3,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"2\";}}','project',3,'',0,0),(12,'2019-01-03 16:31:14',1,'updated','task','Painting',3,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"2\";s:2:\"to\";s:1:\"3\";}}','project',3,'',0,0),(13,'2019-01-03 18:17:49',4,'created','task_comment','test\n',5,NULL,'project',3,'task',3,0),(14,'2019-01-03 19:57:41',4,'created','task_comment','DFDGG',6,NULL,'project',3,'task',3,0),(15,'2019-01-04 00:14:08',4,'created','task_comment','demo',7,NULL,'project',3,'task',3,0),(16,'2019-01-04 14:30:41',4,'created','task_comment','done that?',8,NULL,'project',3,'task',3,0),(17,'2019-01-04 14:47:52',4,'created','task_comment','Check again',9,NULL,'project',3,'task',3,0),(18,'2019-01-04 15:54:52',4,'created','task_comment','I ready sms?',10,NULL,'project',3,'task',3,0),(19,'2019-01-04 17:18:11',4,'created','task_comment','Otra vez test',11,NULL,'project',3,'task',3,0),(20,'2019-01-04 17:21:46',4,'created','task_comment','veamos',12,NULL,'project',3,'task',3,0),(21,'2019-01-05 07:07:35',1,'created','task','Demos',4,NULL,'project',4,'',0,1),(22,'2019-01-05 07:08:36',1,'updated','task','Demos',4,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"2\";}}','project',4,'',0,1),(23,'2019-01-05 07:09:09',1,'updated','task','Demos',4,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"2\";s:2:\"to\";s:1:\"3\";}}','project',4,'',0,1),(24,'2019-01-05 19:34:05',1,'created','task','Cambiar bano',5,NULL,'project',5,'',0,1),(25,'2019-01-05 19:34:23',1,'updated','task','Cambiar bano',5,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"3\";}}','project',5,'',0,1),(26,'2019-01-18 16:40:28',9,'created','task','Unit 413',6,NULL,'project',6,'',0,0),(27,'2019-04-08 14:10:28',1,'created','task','Paint',7,NULL,'project',10,'',0,0),(28,'2019-04-08 14:55:30',1,'updated','task','Paint',7,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"3\";}}','project',10,'',0,0),(29,'2019-04-10 14:50:19',9,'created','task','Fer',8,NULL,'project',11,'',0,0),(30,'2019-04-19 15:50:36',21,'created','task_comment','prueba',13,NULL,'project',6,'task',6,0),(31,'2019-04-19 15:52:41',9,'created','task_comment','Prueba',14,NULL,'project',6,'task',6,0),(32,'2019-04-19 15:55:05',21,'created','task_comment','prueba',15,NULL,'project',6,'task',6,0),(33,'2019-04-19 15:59:45',21,'created','task','vacant - carpet clenaing',9,NULL,'project',6,'',0,0),(34,'2019-04-19 16:13:30',21,'created','task','vacant - carpet cleaning',10,NULL,'project',6,'',0,0),(35,'2019-04-19 16:13:44',74,'updated','task','vacant - carpet clenaing',9,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"3\";}}','project',6,'',0,0),(36,'2019-04-19 16:13:52',74,'updated','task','vacant - carpet clenaing',9,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"3\";s:2:\"to\";s:1:\"1\";}}','project',6,'',0,0),(37,'2019-04-19 16:14:39',74,'updated','task','vacant - carpet clenaing',9,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"3\";}}','project',6,'',0,0),(38,'2019-04-19 16:14:48',74,'updated','task','Unit 413',6,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"3\";}}','project',6,'',0,0),(39,'2019-04-19 16:17:55',74,'updated','task','vacant - carpet cleaning',10,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"3\";}}','project',6,'',0,0),(40,'2019-05-15 18:44:20',1,'created','task','task1',11,NULL,'project',12,'',0,0),(41,'2019-05-16 15:07:36',1,'created','task','Camisas',12,NULL,'project',13,'',0,0),(42,'2019-05-16 15:07:56',1,'updated','task','Camisas',12,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"3\";}}','project',13,'',0,0),(43,'2019-05-16 21:19:53',9,'created','task','test task',13,NULL,'project',12,'',0,0),(44,'2019-05-16 21:21:28',9,'created','task','task',14,NULL,'project',12,'',0,0),(45,'2019-05-17 02:28:58',1,'created','task','Demo',15,NULL,'project',16,'',0,0),(46,'2019-05-17 02:29:10',1,'updated','task','Demo',15,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"3\";}}','project',16,'',0,0),(47,'2019-05-17 13:17:47',1,'created','task','Pintar',16,NULL,'project',18,'',0,0),(48,'2019-05-17 13:20:17',1,'updated','task','Pintar',16,'a:1:{s:8:\"deadline\";a:2:{s:4:\"from\";N;s:2:\"to\";s:10:\"2019-05-22\";}}','project',18,'',0,0),(49,'2019-05-17 13:54:16',1,'created','task','Cambiar Wather heater',17,NULL,'project',18,'',0,0),(50,'2019-05-17 13:55:18',1,'created','task_comment','DSAdsadasdsadsadsdsasa',18,NULL,'project',18,'task',17,0),(51,'2019-05-17 13:56:22',1,'updated','task','Pintar',16,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"3\";}}','project',18,'',0,0),(52,'2019-05-17 13:58:11',1,'updated','task','Cambiar Wather heater',17,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"3\";}}','project',18,'',0,0),(53,'2019-05-28 13:39:22',114,'created','task','Test Task',18,NULL,'project',18,'',0,0),(54,'2019-05-28 13:40:54',114,'created','task_comment','Test',19,NULL,'project',18,'task',18,0),(55,'2019-05-28 13:41:07',114,'updated','task','Test Task',18,'a:2:{s:4:\"sort\";a:2:{s:4:\"from\";s:1:\"0\";s:2:\"to\";s:8:\"10000000\";}s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"1\";s:2:\"to\";s:1:\"2\";}}','project',18,'',0,0),(56,'2019-05-30 21:03:25',31,'updated','task','Test Task',18,'a:1:{s:9:\"status_id\";a:2:{s:4:\"from\";s:1:\"2\";s:2:\"to\";s:1:\"3\";}}','project',18,'',0,0),(57,'2019-06-05 18:24:04',9,'created','task','prueba',19,NULL,'project',17,'',0,0),(58,'2019-06-05 18:24:57',9,'created','task_comment','comentario de prueba',20,NULL,'project',17,'task',19,0),(59,'2019-06-18 18:16:25',9,'created','task','task for test',20,NULL,'project',17,'',0,0),(60,'2019-06-18 18:18:46',9,'updated','task','task for test',20,'a:1:{s:6:\"labels\";a:2:{s:4:\"from\";s:0:\"\";s:2:\"to\";s:5:\"paint\";}}','project',17,'',0,0),(61,'2019-06-18 18:27:57',9,'created','task','test task',21,NULL,'project',22,'',0,0),(62,'2019-07-22 13:34:08',1,'created','task','Demo Final',22,NULL,'project',25,'',0,0);
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `share_with` mediumtext COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `files` text COLLATE utf8_unicode_ci NOT NULL,
  `read_by` mediumtext COLLATE utf8_unicode_ci,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,'Demo','<p style=\"text-align: center; \"><img src=\"https://catholic-link.com/wp-content/uploads/2016/08/tumblr_ocsl91wYmy1uggvueo1_1280.png\" style=\"width: 600px;\"><br></p>','0000-00-00','0000-00-00',1,'all_members','2018-12-18 06:39:58','a:0:{}','0,7',0);
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('incomplete','pending','approved','rejected','deleted') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'incomplete',
  `user_id` int(11) NOT NULL,
  `in_time` datetime NOT NULL,
  `out_time` datetime DEFAULT NULL,
  `checked_by` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `checked_at` datetime DEFAULT NULL,
  `reject_reason` text COLLATE utf8_unicode_ci,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `checked_by` (`checked_by`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (1,'pending',1,'2018-12-11 23:29:36','2018-12-11 23:29:41',NULL,'',NULL,NULL,0);
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checklist_items`
--

DROP TABLE IF EXISTS `checklist_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checklist_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `is_checked` int(11) NOT NULL DEFAULT '0',
  `task_id` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checklist_items`
--

LOCK TABLES `checklist_items` WRITE;
/*!40000 ALTER TABLE `checklist_items` DISABLE KEYS */;
INSERT INTO `checklist_items` VALUES (1,'Pintar Bano',1,1,0,0),(2,'Pintar Cuarto',1,1,0,0),(3,'Recibir Material',1,17,0,0);
/*!40000 ALTER TABLE `checklist_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_groups`
--

DROP TABLE IF EXISTS `client_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_groups`
--

LOCK TABLES `client_groups` WRITE;
/*!40000 ALTER TABLE `client_groups` DISABLE KEYS */;
INSERT INTO `client_groups` VALUES (1,'PANCO',0),(2,'ALEXANDER CO. ',0),(3,'ALLEN ROCKS',0);
/*!40000 ALTER TABLE `client_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_address` text COLLATE utf8_unicode_ci,
  `created_date` date NOT NULL,
  `website` text COLLATE utf8_unicode_ci,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `starred_by` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `group_ids` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `vat_number` text COLLATE utf8_unicode_ci,
  `currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disable_online_payment` tinyint(1) NOT NULL DEFAULT '0',
  `bill_address_selected` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'Beco ','Demo','12','22','123456','Cliente',NULL,NULL,'0000-00-00','','12027664200','','','',1,'','',0,NULL),(2,'Panco Managment','Demo Address','','','','',NULL,NULL,'2018-12-13','','12027664200','','','1',1,'','',0,NULL),(3,'Seminary Hill Apartments ','4820 Kenmore ave','Alexandria','Virginia','223046','United State',NULL,NULL,'2018-12-18','','12027664200',NULL,',:7:','',1,'',NULL,0,NULL),(4,'Ballston Square Apartments','850 N Randolph St','Arlington','VA','22203','','Demo','123456','2019-01-18','','','','','',0,'','',0,0),(5,'Liberty Crest Apartments','9380 Quadrangle Street','Lorton','VA','22079','',NULL,NULL,'2019-01-18','','',NULL,'','',0,'',NULL,0,NULL),(6,'National Park Seminary','9615 Dewitt Dr','Silver Spring','VA','20910','',NULL,NULL,'2019-01-18','','',NULL,'','',0,'',NULL,0,NULL),(7,'The Apollo','600 H St NE','Washington','DC','20002','',NULL,NULL,'2019-01-18','','',NULL,'','',1,'',NULL,0,1),(8,'AK','Ytr','palanpur','Demo','293993','Usa','','','2019-02-06','','Jugg','$','','2',1,'','USD',0,0),(9,'The Point at Dulles','13690 Legacy Circle','Herndon','VA','20171','','Same','Same','2019-02-18','','',NULL,'','1',0,'',NULL,0,0),(10,'The Point at McNair Farms','2511 Farmcrest Dr','Herndon','VA','20171','','Same','Same','2019-02-19','','',NULL,'','1',0,'',NULL,0,NULL),(11,'Misty Ridge Apartments','1989 Delaware Dr.','Woodbridge','VA','22191','','','','2019-04-01','','',NULL,'','',0,'',NULL,0,NULL),(12,'Ovation at Park Crest','8231 Crestwood Heights Dr.','McLean','VA','22102','','','','2019-04-01','','',NULL,'','',0,'',NULL,0,NULL),(13,'Aperture','11410 Reston Station Blvd.','Reston','VA','20190','','','','2019-04-01','','',NULL,'','',0,'',NULL,0,NULL),(14,'The Wellington','1850 Columbia Pike','Arlington','VA','22204','','','','2019-04-01','','',NULL,'','',0,'',NULL,0,NULL),(15,'Reston Glade','12265 Laurel Glade Ct.','Reston','VA','20191','','','','2019-04-01','','',NULL,'','',0,'',NULL,0,NULL),(16,'The Millenium at Metropolitan Park','1330 S. Fair St.','Arlington','VA','22202','','','','2019-04-01','','',NULL,'','',0,'',NULL,0,NULL),(17,'The Acadia at Metropolitan Park','575 12th Rd S','Arlington','VA','22202','','','','2019-04-01','','',NULL,'','',0,'',NULL,0,NULL),(18,'Loudoun Heights','20300 River Ridge Ter.','Ashburn','VA','20147','','','','2019-04-01','','',NULL,'','',0,'',NULL,0,NULL),(19,'Seminary Hill','4820 Kenmore Ave.','Alexandria','VA','20147','','','','2019-04-01','','',NULL,'','',0,'',NULL,0,NULL),(20,'Ridgeleigh at Van Dorn','5901 Cloverdale Way','Alexandria','VA','22310','','','','2019-04-01','','',NULL,'','',0,'',NULL,0,NULL),(21,'Hermitage Hill','2246 N Beauregard St.','Alexandria','VA','22311','','','','2019-04-01','','',NULL,'','',0,'',NULL,0,NULL),(22,'Whitestone at Landmark','250 S Whiting St','Alexandria','VA','22304','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(23,'Abbotts Run','5711 Woodlawn Gable Dr','Alexandria','VA','22309','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(24,'The Reserve at Town Center','20723 Reserve Falls Terrace','Sterling','VA','20165','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(25,'Westfield Village','5115 Woodmere Dr','Centreville','VA','20120','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(26,'Amberton','11989 Coverstone Hill Cir','Manassas','VA','20109','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(27,'The Reserve at Regency Park','14411 Newton Patent Ct','Centreville','VA','20120','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(28,'Ashford Meadows','2551 Cornelia Rd','Herndon','VA','20171','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(29,'Saddle Ridge','20070 Coltsfoot Terrace','Ashburn','VA','20147','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(30,'Lincoln at Fair Oaks','12167 Lincoln Lake Way','Fairfax','VA','22030','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(31,'The Point at Alexandria','205 Century Pl','Alexandria','VA','22304','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(32,'The Point at Pentagon City','1201 S Eads St','Arlington','VA','22202','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(33,'The Point at Bull Run','10519 Lariat Ln','Manassas','VA','20109','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(34,'The Point at Park Station','9430 Russia Branch View Dr','Manassas Park','VA','20111','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(35,'The Point at Herndon','13161 Fox Hunt Ln','Herndon','VA','20171','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(36,'The Point at Ashburn','22555 Leanne Terrace','Ashburn','VA','20148','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(37,'The Point at Leesburg','86 Heritage Way NE','Leesburg','VA','20176','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(38,'The Point at Loudoun','703 Clark Ct NE','Leesburg','VA','20176','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(39,'The Point at Manassas','11212 Chatterly Loop','Manassas','VA','20109','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(40,'Chase Heritage','1212 Chase Heritage Cir','Sterling','VA','20164','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(41,'Trevors Run at Dulles Center','2411 Little Current Dr # 1111','Herndon','VA','20171','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(42,'Rancho El Renacer','11252 Elk Run Rd','Catlett','VA','20119','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(43,'909 Capitol Yards','909 New Jersey Ave SE','Washington','DC','20003','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(44,'Allegro','3460 14th St NW','Washington','DC','20010','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(45,'Elevation at Washington Gateway','100 Florida Ave NE','Washington','DC','20002','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(46,'Insignia on M','1111 New Jersey Ave SE','Washington','DC','20003','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(47,'The Apollo','600 H St NE','Washington','DC','20002','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(48,'District','1401 S St NW','Washington','DC','20009','','','','2019-04-03','','',NULL,'','',0,'',NULL,0,NULL),(49,'Rhode Island Row','2300 Washington Pl NE','Washington','DC','20018','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(50,'Senate Square','201 I St NE','Washington','DC','20002','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(51,'The Channel','950 Maine Ave SW','Washington','DC','20024','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(52,'The Kenmore','5415 Connecticut Ave NW','Washington','DC','20008','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(53,'Yale West','443 New York Ave NW','Washington','DC','20001','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(54,'70 Capitol Yards','70 I St SE','Washington','DC','20003','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(55,'100 Capitol Yards','100 I St SE','Washington','DC','20003','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(56,'First Residences','1263 First St SE','Washington','DC','20003','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(57,'Onyx on First','1100 First St SE','Washington','DC','20003','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(58,'Capitol Park Tower','301 G St SW','Washington','DC','20024','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(59,'Canterbury','20019 Sweetgum Cir','Germantown','MD','20874','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(60,'Flats 8300','8300 Wisconsin Ave','Bethesda','MD','20814','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(61,'The Esplanade','250 American Way','National Harbor','MD','20745','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(62,'Huntington Square','9705 Clocktower Ln # 104','Columbia','MD','21046','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(63,'The Ashberry','8017 Ashberry Ln,','Pasadena','MD','21122','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(64,'The Rothbury Apartments','Rothbury Dr','Montgomery Village','MD','20886','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(65,'Emerson at Cherry Lane','14720 4th St','Laurel','MD','20707','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(66,'C Street Flats','24 C St #102','Laurel','MD','20707','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(67,'Ashton Green','5320 Cedar Ln','Columbia','MD','21044','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(68,'The Townes at Holly Station','3001 Hollins Ln','Waldorf','MD','20601','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(69,'Foxfire','8737 Contee Rd','Laurel','MD','20708','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(70,'The Point at Crofton','1623 Parkridge Cir','Crofton','MD','21114','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(71,'The Point at Germantown Station','19228 Circle Gate Dr','Germantown','MD','20874','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(72,'The Point at Germantown','2 Observation Ct','Germantown','MD','20876','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(73,'The Point at Watkins Mill','180 Watkins Station Cir','Gaithersburg','MD','20879','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(74,'Homestead at Laurel','9523 Muirkirk Rd','Laurel','MD','20708','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(75,'The Point at Elkridge','7100 Ducketts Ln','Elkrdige','MD','21075','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(76,'The Point at Silver Spring','8750 Georgia Ave','Silver Spring','MD','20910','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(77,'The Monterey','5901 Montrose Rd','North Bethesda','MD','20852','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(78,'The Point at Hampton Hollow','3408 Hampton Hollow Dr','Silver Spring','MD','20904','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(79,'The Point at Seven Oaks','300 Gatehouse Ln','Odenton','MD','21113','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(80,'The Point at Winterset','4700 Winterset Way','Owings Mills','MD','21117','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(81,'The Point at Owings Mills','9204 Appleford Cir','Owings Mills','MD','21117','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(82,'The Point at Odenton','322 Baldwin Rd','Odenton','MD','21113','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(83,'The Point at Laurel Lakes','8220 Marymont Dr','Laurel','MD','20707','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(84,'Walker House','18700 Walkers Choice Rd','Montgomery Village','MD','20886','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(85,'The Park at Kingsview Village','13414 Daventry Way','Germantown','MD','20874','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(86,'Windsor Crossing','3000 Victory Ln','Suitland','MD','20746','','','','2019-04-04','','',NULL,'','',0,'',NULL,0,NULL),(87,'sam','2nd street','surat','gujrat','395001','india','sam ','2nd street','2019-05-22','','7043096067','','','',1,'','',0,NULL),(88,'test','test','testtest','test','stst','stset','test','tets','2019-05-23','sdfgdf','4564132132','teeeere','','1',1,'sdfg','AFN',0,NULL),(89,'test','test','test','test','789456132','test','test','test','2019-05-23','test','798465132','tes','','1',1,'test','AFN',0,NULL),(90,'atesa','adsf','asdf','zvc','czxv','zxcv','zcvz','zbzvc','2019-05-23','zxv','zxcv','zcxzxvc','','1',1,'zvcx','AED',0,NULL),(91,'safsadf','dsfdsa','zxvzc','zxv','zxvc','zcxv','zxcvx','zxcv','2019-05-23','zxvc','zxcv','zcxvzxcv','','1',1,'zxvc','AED',0,NULL),(92,'zcxv','zxcv','zxcv','zxc','zcx','zcxv','zxc','zcxv','2019-05-23','zxcv','zcx','zcxv','','1',1,'zxvc','AFN',0,NULL),(93,'My new','2nd floor','surat','guj','395001','india','test','test','2019-05-23','test,.com','+917043096067','$','','1',0,'123456','INR',0,NULL),(94,'test','test','test','test','395001','india','test','test','2019-07-01','www.test.com','+917043096067','','','',0,'123456789','',0,NULL);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_field_values`
--

DROP TABLE IF EXISTS `custom_field_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_field_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_to_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `related_to_id` int(11) NOT NULL,
  `custom_field_id` int(11) NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_field_values`
--

LOCK TABLES `custom_field_values` WRITE;
/*!40000 ALTER TABLE `custom_field_values` DISABLE KEYS */;
INSERT INTO `custom_field_values` VALUES (1,'estimate_request',1,2,'General Contractors',0),(2,'estimate_request',2,2,'Painting',0),(3,'estimate_request',3,3,'Pintura',0),(4,'estimate_request',3,4,'Unitb32',0);
/*!40000 ALTER TABLE `custom_field_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_fields`
--

DROP TABLE IF EXISTS `custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `placeholder` text COLLATE utf8_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `field_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `related_to` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `show_in_table` tinyint(1) NOT NULL DEFAULT '0',
  `show_in_invoice` tinyint(1) NOT NULL DEFAULT '0',
  `show_in_estimate` tinyint(1) NOT NULL DEFAULT '0',
  `visible_to_admins_only` tinyint(1) NOT NULL DEFAULT '0',
  `hide_from_clients` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields`
--

LOCK TABLES `custom_fields` WRITE;
/*!40000 ALTER TABLE `custom_fields` DISABLE KEYS */;
INSERT INTO `custom_fields` VALUES (1,'Demo','Coreas','','textarea','estimate_form-1',1,1,0,0,0,0,0,1),(2,'Seleccion de Serbivcios','Select Services','General Contractors,Painting,Food,EWtr','multi_select','estimate_form-1',1,1,0,0,0,0,0,1),(3,'Title','','','textarea','estimate_form-1',1,0,0,0,0,0,0,0),(4,'Location','','','textarea','estimate_form-1',2,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `custom_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_widgets`
--

DROP TABLE IF EXISTS `custom_widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `show_title` tinyint(1) NOT NULL DEFAULT '0',
  `show_border` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_widgets`
--

LOCK TABLES `custom_widgets` WRITE;
/*!40000 ALTER TABLE `custom_widgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_widgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dashboards`
--

DROP TABLE IF EXISTS `dashboards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dashboards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `data` text COLLATE utf8_unicode_ci,
  `color` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dashboards`
--

LOCK TABLES `dashboards` WRITE;
/*!40000 ALTER TABLE `dashboards` DISABLE KEYS */;
INSERT INTO `dashboards` VALUES (1,3,'Demos','a:1:{i:0;O:8:\"stdClass\":2:{s:7:\"columns\";a:1:{i:0;a:2:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:13:\"open_projects\";s:5:\"title\";s:13:\"Open Projects\";}i:1;O:8:\"stdClass\":2:{s:6:\"widget\";s:18:\"completed_projects\";s:5:\"title\";s:18:\"Completed Projects\";}}}s:5:\"ratio\";s:2:\"12\";}}','#2d9cdb',0,1),(2,1,'fer','a:1:{i:0;O:8:\"stdClass\":2:{s:7:\"columns\";a:4:{i:0;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:16:\"starred_projects\";s:5:\"title\";s:16:\"Starred Projects\";}}i:1;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:13:\"my_tasks_list\";s:5:\"title\";s:13:\"My tasks list\";}}i:2;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:13:\"my_open_tasks\";s:5:\"title\";s:13:\"My open tasks\";}}i:3;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:18:\"completed_projects\";s:5:\"title\";s:18:\"Completed Projects\";}}}s:5:\"ratio\";s:7:\"3-3-3-3\";}}','#2d9cdb',0,1),(3,7,'Payment','a:1:{i:0;O:8:\"stdClass\":2:{s:7:\"columns\";a:1:{i:0;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:18:\"invoice_statistics\";s:5:\"title\";s:18:\"Invoice Statistics\";}}}s:5:\"ratio\";s:3:\"6-6\";}}','#83c340',0,1),(4,7,'Ejemplo','a:1:{i:0;O:8:\"stdClass\":2:{s:7:\"columns\";a:3:{i:0;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:13:\"my_open_tasks\";s:5:\"title\";s:13:\"My open tasks\";}}i:1;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:11:\"task_status\";s:5:\"title\";s:11:\"Task Status\";}}i:2;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:14:\"total_invoices\";s:5:\"title\";s:14:\"Total invoices\";}}}s:5:\"ratio\";s:5:\"3-6-3\";}}','#83c340',0,1),(5,1,'App Show ','a:1:{i:0;O:8:\"stdClass\":2:{s:7:\"columns\";a:4:{i:0;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:11:\"task_status\";s:5:\"title\";s:11:\"Task Status\";}}i:1;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:13:\"my_open_tasks\";s:5:\"title\";s:13:\"My open tasks\";}}i:2;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:13:\"open_projects\";s:5:\"title\";s:13:\"Open Projects\";}}i:3;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:9:\"todo_list\";s:5:\"title\";s:9:\"Todo list\";}}}s:5:\"ratio\";s:7:\"3-3-3-3\";}}','#2d9cdb',0,1),(6,1,'Dashboard App','a:1:{i:0;O:8:\"stdClass\":2:{s:7:\"columns\";a:4:{i:0;a:2:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:13:\"open_projects\";s:5:\"title\";s:13:\"Open Projects\";}i:1;O:8:\"stdClass\":2:{s:6:\"widget\";s:18:\"completed_projects\";s:5:\"title\";s:18:\"Completed Projects\";}}i:1;a:2:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:13:\"my_open_tasks\";s:5:\"title\";s:13:\"My open tasks\";}i:1;O:8:\"stdClass\":2:{s:6:\"widget\";s:9:\"total_due\";s:5:\"title\";s:9:\"Total due\";}}i:2;a:2:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:11:\"task_status\";s:5:\"title\";s:11:\"Task Status\";}i:1;O:8:\"stdClass\":2:{s:6:\"widget\";s:9:\"todo_list\";s:5:\"title\";s:9:\"Todo list\";}}i:3;a:1:{i:0;O:8:\"stdClass\":2:{s:6:\"widget\";s:13:\"my_tasks_list\";s:5:\"title\";s:13:\"My tasks list\";}}}s:5:\"ratio\";s:7:\"3-3-3-3\";}}','#2d9cdb',0,0);
/*!40000 ALTER TABLE `dashboards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `division_type`
--

DROP TABLE IF EXISTS `division_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `division_type` (
  `division_id` int(11) NOT NULL AUTO_INCREMENT,
  `sequence` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`division_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `division_type`
--

LOCK TABLES `division_type` WRITE;
/*!40000 ALTER TABLE `division_type` DISABLE KEYS */;
INSERT INTO `division_type` VALUES (1,1,'General Requirements',NULL,1),(2,2,'Site Work',NULL,1),(3,3,'Pending',NULL,1),(4,4,'Finishes',NULL,1),(5,5,'Flooring',NULL,1),(6,6,'Pending',NULL,1),(7,7,'Electrical',NULL,1);
/*!40000 ALTER TABLE `division_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email_subject` text COLLATE utf8_unicode_ci NOT NULL,
  `default_message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `custom_message` mediumtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_templates`
--

LOCK TABLES `email_templates` WRITE;
/*!40000 ALTER TABLE `email_templates` DISABLE KEYS */;
INSERT INTO `email_templates` VALUES (1,'login_info','Login details','<div style=\"background-color: #eeeeef; padding: 50px 0; \"><div style=\"max-width:640px; margin:0 auto; \"> <div style=\"color: #fff; text-align: center; background-color:#33333e; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\">  <h1>Login Details</h1></div><div style=\"padding: 20px; background-color: rgb(255, 255, 255);\">            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\"> Hello {USER_FIRST_NAME}, &nbsp;{USER_LAST_NAME},<br><br>An account has been created for you.</p>            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\"> Please use the following info to login your dashboard:</p>            <hr>            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\">Dashboard URL:&nbsp;<a href=\"{DASHBOARD_URL}\" target=\"_blank\">{DASHBOARD_URL}</a></p>            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\"></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">Email: {USER_LOGIN_EMAIL}</span><br></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">Password:&nbsp;{USER_LOGIN_PASSWORD}</span></p>            <p style=\"color: rgb(85, 85, 85);\"><br></p>            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\">{SIGNATURE}</p>        </div>    </div></div>','<div style=\"background-color: #eeeeef; padding: 50px 0;\">\n<div style=\"max-width: 640px; margin: 0 auto;\">\n<div style=\"color: #fff; text-align: center; background-color: #00b8ff; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\">\n<h1></h1>\n<h1>{LOGO_URL}<br><span style=\"color: #ffffff;\">Login Details</span></h1>\n</div>\n\n<div style=\"padding: 20px; background-color: rgb(255, 255, 255);\">            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\"> Hi {USER_FIRST_NAME}, &nbsp;{USER_LAST_NAME},<br>\n				<br>\n\n				You are receiving this message because you are now enrolled in our new system. \n				<br>\n				<br>\n				You will start getting different notifications from the GAR Contractors APP.<br>\n				<br>Remember that we are here to help, so if you have any questions, please send us an email to <a href=\"mailto:app_support@garcontractors.com\" target=\"_blank\">app_support@garcontractors.com</a><wbr>.\n				<br><br>\n				</p>            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\"> Please use the following info to login your dashboard:</p>            <hr>            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\">Dashboard URL:&nbsp;<a href=\"{DASHBOARD_URL}\" target=\"_blank\">{DASHBOARD_URL}</a></p>            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\"></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">Email: {USER_LOGIN_EMAIL}</span><br></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">Password:&nbsp;{USER_LOGIN_PASSWORD}</span></p>            <p style=\"color: rgb(85, 85, 85);\"><br>Kind Regards,\n				<br><br></p>            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\">{SIGNATURE}</p>        </div>    </div></div>',0),(2,'reset_password','Reset password','<div style=\"background-color: #eeeeef; padding: 50px 0; \"><div style=\"max-width:640px; margin:0 auto; \"><div style=\"color: #fff; text-align: center; background-color:#33333e; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\"><h1>Reset Password</h1>\n </div>\n <div style=\"padding: 20px; background-color: rgb(255, 255, 255); color:#555;\">                    <p style=\"font-size: 14px;\"> Hello {ACCOUNT_HOLDER_NAME},<br><br>A password reset request has been created for your account.&nbsp;</p>\n                    <p style=\"font-size: 14px;\"> To initiate the password reset process, please click on the following link:</p>\n                    <p style=\"font-size: 14px;\"><a href=\"{RESET_PASSWORD_URL}\" target=\"_blank\">Reset Password</a></p>\n                    <p style=\"font-size: 14px;\"></p>\n                    <p style=\"\"><span style=\"font-size: 14px; line-height: 20px;\"><br></span></p>\n<p style=\"\"><span style=\"font-size: 14px; line-height: 20px;\">If you\'ve received this mail in error, it\'s likely that another user entered your email address by mistake while trying to reset a password.</span><br></p>\n<p style=\"\"><span style=\"font-size: 14px; line-height: 20px;\">If you didn\'t initiate the request, you don\'t need to take any further action and can safely disregard this email.</span><br></p>\n<p style=\"font-size: 14px;\"><br></p>\n<p style=\"font-size: 14px;\">{SIGNATURE}</p>\n                </div>\n            </div>\n        </div>','<div style=\"background-color: #eeeeef; padding: 50px 0;\">\n<div style=\"max-width: 640px; margin: 0 auto;\">\n<div style=\"color: #fff; text-align: center; background-color: #00b8ff; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\">\n<h1><img src=\"http://becodemo.website/logotipo-gar.png\" alt=\"\" width=\"320\" height=\"86\"></h1>\n<h1><br><span style=\"color: #ffffff;\">Reset Password<br></span></h1>\n</div>                  \n\n<p style=\"font-size: 14px;\"> </p><p style=\"font-size: 14px;\">Hello {ACCOUNT_HOLDER_NAME},<br><br>A password reset request has been created for your account.&nbsp;</p>\n                    <p style=\"font-size: 14px;\"> To initiate the password reset process, please click on the following link:</p>\n                    <p style=\"font-size: 14px;\"><a href=\"{RESET_PASSWORD_URL}\" target=\"_blank\">Reset Password</a></p>\n                    <p style=\"font-size: 14px;\"></p>\n                    <p style=\"\"><span style=\"font-size: 14px; line-height: 20px;\"><br></span></p>\n<p style=\"\"><span style=\"font-size: 14px; line-height: 20px;\">If you\'ve received this mail in error, it\'s likely that another user entered your email address by mistake while trying to reset a password.</span><br></p>\n<p style=\"\"><span style=\"font-size: 14px; line-height: 20px;\">If you didn\'t initiate the request, you don\'t need to take any further action and can safely disregard this email.</span><br></p>\n<p style=\"font-size: 14px;\"><br></p>\n<p style=\"font-size: 14px;\">{SIGNATURE}</p>\n                </div>\n            </div>\n        ',0),(3,'team_member_invitation','You are invited','<div style=\"background-color: #eeeeef; padding: 50px 0; \"><div style=\"max-width:640px; margin:0 auto; \"> <div style=\"color: #fff; text-align: center; background-color:#33333e; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\"><h1>Account Invitation</h1>   </div>  <div style=\"padding: 20px; background-color: rgb(255, 255, 255);\">            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">Hello,</span><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><span style=\"font-weight: bold;\"><br></span></span></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><span style=\"font-weight: bold;\">{INVITATION_SENT_BY}</span> has sent you an invitation to join with a team.</span></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><br></span></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><a style=\"background-color: #00b393; padding: 10px 15px; color: #ffffff;\" href=\"{INVITATION_URL}\" target=\"_blank\">Accept this Invitation</a></span></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><br></span></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">If you don\'t want to accept this invitation, simply ignore this email.</span><br><br></p>            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\">{SIGNATURE}</p>        </div>    </div></div>','<div style=\"background-color: #eeeeef; padding: 50px 0;\">\n<div style=\"max-width: 640px; margin: 0 auto;\">\n<div style=\"color: #fff; text-align: center; background-color: #00b8ff; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\">\n<h1></h1>\n<h1>{LOGO_URL}<br><span style=\"color: #ffffff;\">Invitation</span></h1>\n</div>\n\n\n<div style=\"padding: 20px; background-color: rgb(255, 255, 255);\">            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">Hello,</span><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><span style=\"font-weight: bold;\"><br></span></span></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><span style=\"font-weight: bold;\">{INVITATION_SENT_BY}</span> has sent you an invitation to join with a team.</span></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><br></span></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><a style=\"background-color: #00b393; padding: 10px 15px; color: #ffffff;\" href=\"{INVITATION_URL}\" target=\"_blank\">Accept this Invitation</a></span></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><br></span></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">If you don\'t want to accept this invitation, simply ignore this email.</span><br><br></p>            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\">{SIGNATURE}</p>        </div>    </div></div>',0),(4,'send_invoice','New invoice','<div style=\"background-color: #eeeeef; padding: 50px 0; \"> <div style=\"max-width:640px; margin:0 auto; \"> <div style=\"color: #fff; text-align: center; background-color:#33333e; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\"><h1>INVOICE #{INVOICE_ID}</h1></div> <div style=\"padding: 20px; background-color: rgb(255, 255, 255);\">  <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">Hello {CONTACT_FIRST_NAME},</span><br></p><p style=\"\"><span style=\"font-size: 14px; line-height: 20px;\">Thank you for your business cooperation.</span><br></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">Your invoice for the project {PROJECT_TITLE} has been generated and is attached here.</span></p><p style=\"\"><br></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><a style=\"background-color: #00b393; padding: 10px 15px; color: #ffffff;\" href=\"{INVOICE_URL}\" target=\"_blank\">Show Invoice</a></span></p><p style=\"\"><span style=\"font-size: 14px; line-height: 20px;\"><br></span></p><p style=\"\"><span style=\"font-size: 14px; line-height: 20px;\">Invoice balance due is {BALANCE_DUE}</span><br></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">Please pay this invoice within {DUE_DATE}.&nbsp;</span></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><br></span></p><p style=\"color: rgb(85, 85, 85); font-size: 14px;\">{SIGNATURE}</p>  </div> </div></div>','<div style=\"background-color: #eeeeef; padding: 50px 0;\">\n<div style=\"max-width: 640px; margin: 0 auto;\">\n<div style=\"color: #fff; text-align: center; background-color: #00b8ff; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\">\n<h1>{LOGO_URL}<img src=\"http://becodemo.website/logotipo-gar.png\" alt=\"\" width=\"320\" height=\"86\"></h1>\n<h1><br><span style=\"color: #ffffff;\">Invoice&nbsp;</span>{INVOICE_ID}</h1>\n</div>\n\n\n<div style=\"padding: 20px; background-color: rgb(255, 255, 255);\">  <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">Hello {CONTACT_FIRST_NAME},</span><br></p><p style=\"\"><span style=\"font-size: 14px; line-height: 20px;\">Thank you for your business please find attached the invoice&nbsp;</span><span style=\"color: rgb(78, 94, 106);\">{INVOICE_ID} for work completed at your propert</span><span style=\"font-size: 14px;\">&nbsp;.</span></p><p style=\"\"><br></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><a style=\"background-color: #00b393; padding: 10px 15px; color: #ffffff;\" href=\"{INVOICE_URL}\" target=\"_blank\">Show Invoice</a></span></p><p style=\"\"><br></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><br></span></p><p style=\"color: rgb(85, 85, 85); font-size: 14px;\">{SIGNATURE}</p>  </div> </div></div>',0),(5,'signature','Signature','Powered By: <a href=\"http://fairsketch.com/\" target=\"_blank\">fairsketch </a>','Chaly Romero<br>CEO Founder<br><b>G.A.R. Contractors, Inc.</b><br>',0),(6,'client_contact_invitation','You are invited','<div style=\"background-color: #eeeeef; padding: 50px 0; \">    <div style=\"max-width:640px; margin:0 auto; \">  <div style=\"color: #fff; text-align: center; background-color:#33333e; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\"><h1>Account Invitation</h1> </div> <div style=\"padding: 20px; background-color: rgb(255, 255, 255);\">            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">Hello,</span><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><span style=\"font-weight: bold;\"><br></span></span></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><span style=\"font-weight: bold;\">{INVITATION_SENT_BY}</span> has sent you an invitation to a client portal.</span></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><br></span></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><a style=\"background-color: #00b393; padding: 10px 15px; color: #ffffff;\" href=\"{INVITATION_URL}\" target=\"_blank\">Accept this Invitation</a></span></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><br></span></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">If you don\'t want to accept this invitation, simply ignore this email.</span><br><br></p>            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\">{SIGNATURE}</p>        </div>    </div></div>','<div style=\"background-color: #eeeeef; padding: 50px 0;\">\n<div style=\"max-width: 640px; margin: 0 auto;\">\n<div style=\"color: #fff; text-align: center; background-color: #00b8ff; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\">\n<h1><img src=\"http://becodemo.website/logotipo-gar.png\" alt=\"\" width=\"320\" height=\"86\"></h1>\n<h1><br><span style=\"color: #ffffff;\">Account Invitation</span></h1>\n</div>\n\n<div style=\"padding: 20px; background-color: rgb(255, 255, 255);\">            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">Hello,</span><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><span style=\"font-weight: bold;\"><br></span></span></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><span style=\"font-weight: bold;\">{INVITATION_SENT_BY}</span> has sent you an invitation to a client portal.</span></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><br></span></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><a style=\"background-color: #00b393; padding: 10px 15px; color: #ffffff;\" href=\"{INVITATION_URL}\" target=\"_blank\">Accept this Invitation</a></span></p>            <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><br></span></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\">If you don\'t want to accept this invitation, simply ignore this email.</span><br><br></p>            <p style=\"color: rgb(85, 85, 85); font-size: 14px;\">{SIGNATURE}</p>        </div>    </div></div>',0),(7,'ticket_created','Ticket  #{TICKET_ID} - {TICKET_TITLE}','<div style=\"background-color: #eeeeef; padding: 50px 0; \"> <div style=\"max-width:640px; margin:0 auto; \"> <div style=\"color: #fff; text-align: center; background-color:#33333e; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\"><h1>Ticket #{TICKET_ID} Opened</h1></div><div style=\"padding: 20px; background-color: rgb(255, 255, 255);\"><p style=\"\"><span style=\"line-height: 18.5714px; font-weight: bold;\">Title: {TICKET_TITLE}</span><span style=\"line-height: 18.5714px;\"><br></span></p><p style=\"\"><span style=\"line-height: 18.5714px;\">{TICKET_CONTENT}</span><br></p> <p style=\"\"><br></p> <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><a style=\"background-color: #00b393; padding: 10px 15px; color: #ffffff;\" href=\"{TICKET_URL}\" target=\"_blank\">Show Ticket</a></span></p> <p style=\"\"><br></p><p style=\"\">Regards,</p><p style=\"\"><span style=\"line-height: 18.5714px;\">{USER_NAME}</span><br></p>   </div>  </div> </div>','',0),(8,'ticket_commented','Ticket  #{TICKET_ID} - {TICKET_TITLE}','<div style=\"background-color: #eeeeef; padding: 50px 0; \"> <div style=\"max-width:640px; margin:0 auto; \"> <div style=\"color: #fff; text-align: center; background-color:#33333e; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\"><h1>Ticket #{TICKET_ID} Replies</h1></div><div style=\"padding: 20px; background-color: rgb(255, 255, 255);\"><p style=\"\"><span style=\"line-height: 18.5714px; font-weight: bold;\">Title: {TICKET_TITLE}</span><span style=\"line-height: 18.5714px;\"><br></span></p><p style=\"\"><span style=\"line-height: 18.5714px;\">{TICKET_CONTENT}</span></p><p style=\"\"><span style=\"line-height: 18.5714px;\"><br></span></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><a style=\"background-color: #00b393; padding: 10px 15px; color: #ffffff;\" href=\"{TICKET_URL}\" target=\"_blank\">Show Ticket</a></span></p></div></div></div>','',0),(9,'ticket_closed','Ticket  #{TICKET_ID} - {TICKET_TITLE}','<div style=\"background-color: #eeeeef; padding: 50px 0; \"> <div style=\"max-width:640px; margin:0 auto; \"> <div style=\"color: #fff; text-align: center; background-color:#33333e; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\"><h1>Ticket #{TICKET_ID}</h1></div><div style=\"padding: 20px; background-color: rgb(255, 255, 255);\"><p style=\"\"><span style=\"line-height: 18.5714px;\">The Ticket #{TICKET_ID} has been closed by&nbsp;</span><span style=\"line-height: 18.5714px;\">{USER_NAME}</span></p> <p style=\"\"><br></p> <p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><a style=\"background-color: #00b393; padding: 10px 15px; color: #ffffff;\" href=\"{TICKET_URL}\" target=\"_blank\">Show Ticket</a></span></p>   </div>  </div> </div>','',0),(10,'ticket_reopened','Ticket  #{TICKET_ID} - {TICKET_TITLE}','<div style=\"background-color: #eeeeef; padding: 50px 0; \"> <div style=\"max-width:640px; margin:0 auto; \"> <div style=\"color: #fff; text-align: center; background-color:#33333e; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\"><h1>Ticket #{TICKET_ID}</h1></div><div style=\"padding: 20px; background-color: rgb(255, 255, 255);\"><p style=\"\"><span style=\"line-height: 18.5714px;\">The Ticket #{TICKET_ID} has been reopened by&nbsp;</span><span style=\"line-height: 18.5714px;\">{USER_NAME}</span></p><p style=\"\"><br></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><a style=\"background-color: #00b393; padding: 10px 15px; color: #ffffff;\" href=\"{TICKET_URL}\" target=\"_blank\">Show Ticket</a></span></p>  </div> </div></div>','',0),(11,'general_notification','{EVENT_TITLE}','<div style=\"background-color: #eeeeef; padding: 50px 0; \"> <div style=\"max-width:640px; margin:0 auto; \"> <div style=\"color: #fff; text-align: center; background-color:#33333e; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;\"><h1>{APP_TITLE}</h1></div><div style=\"padding: 20px; background-color: rgb(255, 255, 255);\"><p style=\"\"><span style=\"line-height: 18.5714px;\">{EVENT_TITLE}</span></p><p style=\"\"><span style=\"line-height: 18.5714px;\">{EVENT_DETAILS}</span></p><p style=\"\"><span style=\"line-height: 18.5714px;\"><br></span></p><p style=\"\"><span style=\"line-height: 18.5714px;\"></span></p><p style=\"\"><span style=\"color: rgb(85, 85, 85); font-size: 14px; line-height: 20px;\"><a style=\"background-color: #00b393; padding: 10px 15px; color: #ffffff;\" href=\"{NOTIFICATION_URL}\" target=\"_blank\">View Details</a></span></p>  </div> </div></div>','',0),(12,'invoice_payment_confirmation','Payment received','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #EEEEEE;border-top: 0;border-bottom: 0;\">\r\n <tbody><tr>\r\n <td align=\"center\" valign=\"top\" style=\"padding-top: 30px;padding-right: 10px;padding-bottom: 30px;padding-left: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">\r\n <tbody><tr>\r\n <td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;\">\r\n                                        <tbody><tr>\r\n                                                <td valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">\r\n                                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">\r\n                                                        <tbody>\r\n                                                            <tr>\r\n                                                                <td valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">\r\n                                                                    <table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background-color: #33333e; max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" width=\"100%\">\r\n                                                                        <tbody><tr>\r\n                                                                                <td valign=\"top\" style=\"padding-top: 40px;padding-right: 18px;padding-bottom: 40px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\">\r\n                                                                                    <h2 style=\"display: block;margin: 0;padding: 0;font-family: Arial;font-size: 30px;font-style: normal;font-weight: bold;line-height: 100%;letter-spacing: -1px;text-align: center;color: #ffffff !important;\">Payment Confirmation</h2>\r\n                                                                                </td>\r\n                                                                            </tr>\r\n                                                                        </tbody>\r\n                                                                    </table>\r\n                                                                </td>\r\n                                                            </tr>\r\n                                                        </tbody>\r\n                                                    </table>\r\n                                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">\r\n                                                        <tbody>\r\n                                                            <tr>\r\n                                                                <td valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">\r\n\r\n                                                                    <table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" width=\"100%\">\r\n                                                                        <tbody><tr>\r\n                                                                                <td valign=\"top\" style=\"padding-top: 20px;padding-right: 18px;padding-bottom: 0;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\">\r\n                                                                                    Hello,<br>\r\n                                                                                    We have received your payment of {PAYMENT_AMOUNT} for {INVOICE_ID} <br>\r\n                                                                                    Thank you for your business cooperation.\r\n                                                                                </td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td valign=\"top\" style=\"padding-top: 10px;padding-right: 18px;padding-bottom: 10px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\">\r\n                                                                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">\r\n                                                                                        <tbody>\r\n                                                                                            <tr>\r\n                                                                                                <td style=\"padding-top: 15px;padding-right: 0x;padding-bottom: 15px;padding-left: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">\r\n                                                                                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate !important;border-radius: 2px;background-color: #00b393;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">\r\n                                                                                                        <tbody>\r\n                                                                                                            <tr>\r\n                                                                                                                <td align=\"center\" valign=\"middle\" style=\"font-family: Arial;font-size: 16px;padding: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">\r\n                                                                                                                    <a href=\"{INVOICE_URL}\" target=\"_blank\" style=\"font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;display: block;\">View Invoice</a>\r\n                                                                                                                </td>\r\n                                                                                                            </tr>\r\n                                                                                                        </tbody>\r\n                                                                                                    </table>\r\n                                                                                                </td>\r\n                                                                                            </tr>\r\n                                                                                        </tbody>\r\n                                                                                    </table>\r\n                                                                                </td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td valign=\"top\" style=\"padding-top: 0px;padding-right: 18px;padding-bottom: 10px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"> \r\n                                                                                    \r\n                                                                                </td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td valign=\"top\" style=\"padding-top: 0px;padding-right: 18px;padding-bottom: 20px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"> \r\n  {SIGNATURE}\r\n  </td>\r\n </tr>\r\n </tbody>\r\n  </table>\r\n  </td>\r\n  </tr>\r\n  </tbody>\r\n </table>\r\n  </td>\r\n </tr>\r\n  </tbody>\r\n  </table>\r\n  </td>\r\n </tr>\r\n </tbody>\r\n </table>\r\n </td>\r\n </tr>\r\n </tbody>\r\n  </table>',NULL,0),(13,'message_received','{SUBJECT}','<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\"> <meta content=\"width=device-width, initial-scale=1.0\" name=\"viewport\"> <style type=\"text/css\"> #message-container p {margin: 10px 0;} #message-container h1, #message-container h2, #message-container h3, #message-container h4, #message-container h5, #message-container h6 { padding:10px; margin:0; } #message-container table td {border-collapse: collapse;} #message-container table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; } #message-container a span{padding:10px 15px !important;} </style> <table id=\"message-container\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#eee; margin:0; padding:0; width:100% !important; line-height: 100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; font-family:Helvetica,Arial,sans-serif; color: #555;\"> <tbody> <tr> <td valign=\"top\"> <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> <tbody> <tr> <td height=\"50\" width=\"600\">&nbsp;</td> </tr> <tr> <td style=\"background-color:#33333e; padding:25px 15px 30px 15px; font-weight:bold; \" width=\"600\"><h2 style=\"color:#fff; text-align:center;\">{USER_NAME} sent you a message</h2></td> </tr> <tr> <td bgcolor=\"whitesmoke\" style=\"background:#fff; font-family:Helvetica,Arial,sans-serif\" valign=\"top\" width=\"600\"> <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> <tbody> <tr> <td height=\"10\" width=\"560\">&nbsp;</td> </tr> <tr> <td width=\"560\"><p><span style=\"background-color: transparent;\">{MESSAGE_CONTENT}</span></p> <p style=\"display:inline-block; padding: 10px 15px; background-color: #00b393;\"><a href=\"{MESSAGE_URL}\" style=\"text-decoration: none; color:#fff;\" target=\"_blank\">Reply Message</a></p> </td> </tr> <tr> <td height=\"10\" width=\"560\">&nbsp;</td> </tr> </tbody> </table> </td> </tr> <tr> <td height=\"60\" width=\"600\">&nbsp;</td> </tr> </tbody> </table> </td> </tr> </tbody> </table>','<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\"> <meta content=\"width=device-width, initial-scale=1.0\" name=\"viewport\"> <style type=\"text/css\"> #message-container p {margin: 10px 0;} #message-container h1, #message-container h2, #message-container h3, #message-container h4, #message-container h5, #message-container h6 { padding:10px; margin:0; } #message-container table td {border-collapse: collapse;} #message-container table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; } #message-container a span{padding:10px 15px !important;} </style> <table id=\"message-container\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#eee; margin:0; padding:0; width:100% !important; line-height: 100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; font-family:Helvetica,Arial,sans-serif; color: #555;\"> <tbody> <tr> <td valign=\"top\"> <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> <tbody> <tr> <td height=\"50\" width=\"600\">&nbsp;</td> </tr> <tr> <td style=\"background-color:#33333e; padding:25px 15px 30px 15px; font-weight:bold; \" width=\"600\"><h2 style=\"color:#fff; text-align:center;\">{USER_NAME} sent you a message</h2></td> </tr> <tr> <td bgcolor=\"whitesmoke\" style=\"background:#fff; font-family:Helvetica,Arial,sans-serif\" valign=\"top\" width=\"600\"> <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> <tbody> <tr> <td height=\"10\" width=\"560\">&nbsp;</td> </tr> <tr> <td width=\"560\"><p><span style=\"background-color: transparent;\">{MESSAGE_CONTENT}</span></p> <p style=\"display:inline-block; padding: 10px 15px; background-color: #00b393;\"><a href=\"{MESSAGE_URL}\" style=\"text-decoration: none; color:#fff;\" target=\"_blank\">Reply Message</a></p> </td> </tr> <tr> <td height=\"10\" width=\"560\">&nbsp;</td> </tr> </tbody> </table> </td> </tr> <tr> <td height=\"60\" width=\"600\">&nbsp;</td> </tr> </tbody> </table> </td> </tr> </tbody> </table>',0),(14,'invoice_due_reminder_before_due_date','Invoice due reminder','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #EEEEEE;border-top: 0;border-bottom: 0;\"> <tbody><tr> <td align=\"center\" valign=\"top\" style=\"padding-top: 30px;padding-right: 10px;padding-bottom: 30px;padding-left: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <tbody><tr> <td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;\"> <tbody><tr> <td valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <tbody> <tr> <td valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background-color: #33333e; max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" width=\"100%\"> <tbody><tr> <td valign=\"top\" style=\"padding-top: 40px;padding-right: 18px;padding-bottom: 40px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"> <h2 style=\"display: block;margin: 0;padding: 0;font-family: Arial;font-size: 30px;font-style: normal;font-weight: bold;line-height: 100%;letter-spacing: -1px;text-align: center;color: #ffffff !important;\">Invoice Due Reminder</h2></td></tr></tbody></table></td></tr></tbody></table> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <tbody> <tr> <td valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" width=\"100%\"> <tbody><tr> <td valign=\"top\" style=\"padding-top: 20px;padding-right: 18px;padding-bottom: 0;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"><p> Hello,<br>We would like to remind you that invoice {INVOICE_ID} is due on {DUE_DATE}. Please pay the invoice within due date.&nbsp;</p><p></p></td></tr><tr><td valign=\"top\" style=\"padding-top: 10px;padding-right: 18px;padding-bottom: 10px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"><p>If you have already submitted the payment, please ignore this email.</p><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"><tbody><tr><td style=\"padding-top: 15px;padding-right: 0x;padding-bottom: 15px;padding-left: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate !important;border-radius: 2px;background-color: #00b393;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"><tbody><tr><td align=\"center\" valign=\"middle\" style=\"font-family: Arial;font-size: 16px;padding: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"><a href=\"{INVOICE_URL}\" target=\"_blank\" style=\"font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;display: block;\">View Invoice</a> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <p></p></td> </tr> <tr> <td valign=\"top\" style=\"padding-top: 0px;padding-right: 18px;padding-bottom: 20px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"> {SIGNATURE} </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table>','',0),(15,'invoice_overdue_reminder','Invoice overdue reminder','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #EEEEEE;border-top: 0;border-bottom: 0;\"> <tbody><tr> <td align=\"center\" valign=\"top\" style=\"padding-top: 30px;padding-right: 10px;padding-bottom: 30px;padding-left: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <tbody><tr> <td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;\"> <tbody><tr> <td valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <tbody> <tr> <td valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background-color: #33333e; max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" width=\"100%\"> <tbody><tr> <td valign=\"top\" style=\"padding-top: 40px;padding-right: 18px;padding-bottom: 40px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"> <h2 style=\"display: block;margin: 0;padding: 0;font-family: Arial;font-size: 30px;font-style: normal;font-weight: bold;line-height: 100%;letter-spacing: -1px;text-align: center;color: #ffffff !important;\">Invoice Overdue Reminder</h2></td></tr></tbody></table></td></tr></tbody></table> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <tbody> <tr> <td valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" width=\"100%\"> <tbody><tr> <td valign=\"top\" style=\"padding-top: 20px;padding-right: 18px;padding-bottom: 0;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"><p> Hello,<br>We would like to remind you that you have an unpaid invoice {INVOICE_ID}. We kindly request you to pay the invoice as soon as possible.&nbsp;</p><p></p></td></tr><tr><td valign=\"top\" style=\"padding-top: 10px;padding-right: 18px;padding-bottom: 10px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"><p>If you have already submitted the payment, please ignore this email.</p><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"><tbody><tr><td style=\"padding-top: 15px;padding-right: 0x;padding-bottom: 15px;padding-left: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate !important;border-radius: 2px;background-color: #00b393;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"><tbody><tr><td align=\"center\" valign=\"middle\" style=\"font-family: Arial;font-size: 16px;padding: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"><a href=\"{INVOICE_URL}\" target=\"_blank\" style=\"font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;display: block;\">View Invoice</a> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <p></p></td> </tr> <tr> <td valign=\"top\" style=\"padding-top: 0px;padding-right: 18px;padding-bottom: 20px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"> {SIGNATURE} </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table>','',0),(16,'recurring_invoice_creation_reminder','Recurring invoice creation reminder','<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #EEEEEE;border-top: 0;border-bottom: 0;\"> <tbody><tr> <td align=\"center\" valign=\"top\" style=\"padding-top: 30px;padding-right: 10px;padding-bottom: 30px;padding-left: 10px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <tbody><tr> <td align=\"center\" valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;\"> <tbody><tr> <td valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <tbody> <tr> <td valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background-color: #33333e; max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" width=\"100%\"> <tbody><tr> <td valign=\"top\" style=\"padding-top: 40px;padding-right: 18px;padding-bottom: 40px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"> <h2 style=\"display: block;margin: 0;padding: 0;font-family: Arial;font-size: 30px;font-style: normal;font-weight: bold;line-height: 100%;letter-spacing: -1px;text-align: center;color: #ffffff !important;\">Invoice Cration Reminder</h2></td></tr></tbody></table></td></tr></tbody></table> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <tbody> <tr> <td valign=\"top\" style=\"mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"> <table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" width=\"100%\"> <tbody><tr> <td valign=\"top\" style=\"padding-top: 20px;padding-right: 18px;padding-bottom: 0;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"><p> Hello,<br>We would like to remind you that a recurring invoice will be created on {NEXT_RECURRING_DATE}.</p><p></p></td></tr><tr><td valign=\"top\" style=\"padding-top: 10px;padding-right: 18px;padding-bottom: 10px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"min-width: 100%; text-size-adjust: 100%;\"><tbody><tr><td style=\"padding-top: 15px; padding-bottom: 15px; text-size-adjust: 100%;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate !important;border-radius: 2px;background-color: #00b393;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\"><tbody><tr><td align=\"center\" valign=\"middle\" style=\"font-size: 16px; padding: 10px; text-size-adjust: 100%;\"><a href=\"{INVOICE_URL}\" target=\"_blank\" style=\"font-weight: bold; line-height: 100%; color: rgb(255, 255, 255); text-size-adjust: 100%; display: block;\">View Invoice</a></td></tr></tbody></table></td></tr></tbody></table> <p></p></td> </tr> <tr> <td valign=\"top\" style=\"padding-top: 0px;padding-right: 18px;padding-bottom: 20px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #606060;font-family: Arial;font-size: 15px;line-height: 150%;text-align: left;\"> {SIGNATURE} </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table>','',0);
/*!40000 ALTER TABLE `email_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estimate_division`
--

DROP TABLE IF EXISTS `estimate_division`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estimate_division` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `division_id` int(11) NOT NULL,
  `project_name` varchar(100) DEFAULT NULL,
  `unit` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `labour` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `estimate_id` int(11) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_estimate_division` (`division_id`),
  KEY `FK_estimate_divtype` (`estimate_id`),
  CONSTRAINT `FK_estimate_division` FOREIGN KEY (`division_id`) REFERENCES `division_type` (`division_id`),
  CONSTRAINT `FK_estimate_divtype` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estimate_division`
--

LOCK TABLES `estimate_division` WRITE;
/*!40000 ALTER TABLE `estimate_division` DISABLE KEYS */;
INSERT INTO `estimate_division` VALUES (1,1,'Proyecto Prueba 1-1',10,10,'Prima',10,5000,14,1),(2,2,'Proyecto Prueba 2-1',20,10,'Prima',220,5000,14,1),(3,2,'Proyecto Prueba 2-2',30,50,'Otrta',110,10000,14,2),(4,1,'Proyecto Prueba 1-2',50,10,'Esto',10,2500,14,1),(5,1,'Proyecto 1 Prueba 1',10,5,'Acero',10,1000,15,1),(6,1,'Proyecto 1 Prueba 2',20,6,'Metal',20,500,15,2),(7,3,'Proyecto 3 Prueba 1',20,10,'Algodon',10,20,15,1);
/*!40000 ALTER TABLE `estimate_division` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estimate_forms`
--

DROP TABLE IF EXISTS `estimate_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estimate_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `enable_attachment` tinyint(4) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estimate_forms`
--

LOCK TABLES `estimate_forms` WRITE;
/*!40000 ALTER TABLE `estimate_forms` DISABLE KEYS */;
INSERT INTO `estimate_forms` VALUES (1,'Demo Formulario','Demo','active',1,0,0);
/*!40000 ALTER TABLE `estimate_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estimate_items`
--

DROP TABLE IF EXISTS `estimate_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estimate_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `quantity` double NOT NULL,
  `unit_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rate` double NOT NULL,
  `total` double NOT NULL,
  `estimate_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estimate_items`
--

LOCK TABLES `estimate_items` WRITE;
/*!40000 ALTER TABLE `estimate_items` DISABLE KEYS */;
INSERT INTO `estimate_items` VALUES (1,'General Contractors','DEMO',2,'aqwqaw',125,250,1,0),(2,'General Contractors','DEMO',1,'aqwqaw',1345,1345,2,0),(3,'Carpet Clean','Unit 651-A Occupied Carpet Clean',1,'',1,1,4,0),(4,'Carpet Clean','Unit 651-A Occupied Carpet Clean',1,'',125,125,5,0),(5,'Concrete Floor Prep','Scrape existing coating from concrete floor in trash room and apply primer.',425,'sf',2.85,1211.25,6,0),(6,'Concrete Coating','Apply new floor coating using Sherwin Williams Loxon concrete coating, color to match close to existing color as close as possible.',425,'sf',4.5,1912.5,6,0),(7,'Retaining Wall Construction','Supply and install pressure treated 8x8 retaining wall',120,'SF',65,7800,8,0),(8,'Carpet Clean','Esto es un item nuevo',10,'pc',2,20,15,0),(9,'Tile Installation','Esto es utro elemento',10,'SF',7,70,15,0);
/*!40000 ALTER TABLE `estimate_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estimate_requests`
--

DROP TABLE IF EXISTS `estimate_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estimate_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estimate_form_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `client_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `status` enum('new','processing','hold','canceled','estimated') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new',
  `files` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estimate_requests`
--

LOCK TABLES `estimate_requests` WRITE;
/*!40000 ALTER TABLE `estimate_requests` DISABLE KEYS */;
INSERT INTO `estimate_requests` VALUES (1,1,8,'2019-01-05 06:33:17',3,0,1,'estimated','a:0:{}',0),(2,1,85,'2019-05-17 13:24:32',4,0,0,'new','a:0:{}',0),(3,1,91,'2019-05-17 13:39:58',5,0,90,'new','a:0:{}',0);
/*!40000 ALTER TABLE `estimate_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estimates`
--

DROP TABLE IF EXISTS `estimates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estimates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `estimate_request_id` int(11) NOT NULL DEFAULT '0',
  `estimate_date` date NOT NULL,
  `valid_until` date NOT NULL,
  `note` mediumtext COLLATE utf8_unicode_ci,
  `last_email_sent_date` date DEFAULT NULL,
  `status` enum('draft','sent','accepted','declined') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'draft',
  `tax_id` int(11) NOT NULL DEFAULT '0',
  `tax_id2` int(11) NOT NULL DEFAULT '0',
  `project_id` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estimates`
--

LOCK TABLES `estimates` WRITE;
/*!40000 ALTER TABLE `estimates` DISABLE KEYS */;
INSERT INTO `estimates` VALUES (1,1,0,'2018-12-13','2018-12-15','juio',NULL,'accepted',1,1,0,0),(2,3,0,'2019-01-05','2019-01-07','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. ',NULL,'accepted',0,0,0,0),(3,1,0,'2019-01-07','2019-01-07','',NULL,'draft',0,0,0,0),(4,9,0,'2019-04-01','2019-05-01','',NULL,'draft',0,0,0,0),(5,9,0,'2019-04-02','2019-05-02','',NULL,'draft',0,0,0,0),(6,47,0,'2019-05-24','2019-06-24','Trash Room Floor Painting',NULL,'draft',0,0,0,0),(7,93,0,'2019-05-28','2019-05-28','Demos',NULL,'draft',0,0,0,0),(8,59,0,'2019-05-30','2019-06-30','',NULL,'draft',0,0,0,0),(9,53,0,'2019-06-13','2019-06-14','Demo',NULL,'draft',0,0,0,0),(10,55,0,'2019-06-25','2019-06-25','swnia',NULL,'draft',0,0,0,0),(11,44,0,'2019-07-09','2019-07-09','Swmoa',NULL,'draft',0,0,0,0),(12,94,0,'2019-07-14','2019-07-14','Demo Test',NULL,'sent',0,0,0,0),(13,54,0,'2019-07-17','2019-07-18','Prueba',NULL,'draft',0,0,0,0),(14,43,0,'2019-07-23','2019-07-24','Esto es una rpeuab',NULL,'draft',0,0,0,0),(15,94,0,'2019-07-23','2019-07-24','deomos',NULL,'draft',0,0,0,0),(16,43,0,'2019-08-01','2019-08-05','Esto es una rpeuba nueva',NULL,'draft',0,0,0,0);
/*!40000 ALTER TABLE `estimates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `location` mediumtext COLLATE utf8_unicode_ci,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `labels` text COLLATE utf8_unicode_ci NOT NULL,
  `share_with` mediumtext COLLATE utf8_unicode_ci,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `color` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `recurring` int(1) NOT NULL DEFAULT '0',
  `repeat_every` int(11) NOT NULL DEFAULT '0',
  `repeat_type` enum('days','weeks','months','years') COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_of_cycles` int(11) NOT NULL DEFAULT '0',
  `last_start_date` date DEFAULT NULL,
  `recurring_dates` longtext COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_by` text COLLATE utf8_unicode_ci NOT NULL,
  `rejected_by` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'test','This is testing app.','2019-05-23','2019-05-23','01:00:00','02:00:00',89,'surat',0,'test','',0,'#83c340',0,1,'months',0,'0000-00-00','','0','0'),(2,'tes','tesa','2019-05-22','2019-05-22','16:10:00','17:00:00',89,'tast',0,'test','member:89',0,'#83c340',0,1,'months',0,'0000-00-00','','0','0'),(3,'test','test','2019-05-22','2019-05-22','16:20:00','04:30:00',1,'test',87,'test','member:89',0,'#83c340',0,1,'months',0,'0000-00-00','','0,89','0'),(4,'Acadia','To Measure Garage for Cleaning, meet with Heather and Jorge','2019-05-31','2019-05-31','11:00:00','00:00:00',31,'',0,'','',0,'#83c340',0,1,'months',0,'0000-00-00','','0','0');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense_categories`
--

DROP TABLE IF EXISTS `expense_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expense_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense_categories`
--

LOCK TABLES `expense_categories` WRITE;
/*!40000 ALTER TABLE `expense_categories` DISABLE KEYS */;
INSERT INTO `expense_categories` VALUES (1,'Miscellaneous expense',0);
/*!40000 ALTER TABLE `expense_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_date` date NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `amount` double NOT NULL,
  `files` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `tax_id` int(11) NOT NULL DEFAULT '0',
  `tax_id2` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_files`
--

DROP TABLE IF EXISTS `general_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` text COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `file_size` double NOT NULL,
  `created_at` datetime NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `uploaded_by` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_files`
--

LOCK TABLES `general_files` WRITE;
/*!40000 ALTER TABLE `general_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `help_articles`
--

DROP TABLE IF EXISTS `help_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `help_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `files` text COLLATE utf8_unicode_ci NOT NULL,
  `total_views` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `help_articles`
--

LOCK TABLES `help_articles` WRITE;
/*!40000 ALTER TABLE `help_articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `help_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `help_categories`
--

DROP TABLE IF EXISTS `help_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `help_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('help','knowledge_base') COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `help_categories`
--

LOCK TABLES `help_categories` WRITE;
/*!40000 ALTER TABLE `help_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `help_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `quantity` double NOT NULL,
  `unit_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rate` double NOT NULL,
  `total` double NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `invoice_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_items`
--

LOCK TABLES `invoice_items` WRITE;
/*!40000 ALTER TABLE `invoice_items` DISABLE KEYS */;
INSERT INTO `invoice_items` VALUES (1,'General Contractors','DEMO',1,'aqwqaw',125,125,0,1,0),(2,'General Contractors','Repararon el Balcon y mejoraron esos datos.',1,'',125,125,0,4,0),(3,'General Contractors','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',1,'aqwqaw',125,125,0,3,0),(4,'Turnover Paint - 1 BR','The Apollo',1,'',270,270,0,7,0),(5,'Turnover Paint - 1 BR','The Apollo',1,'',270,270,0,14,0),(6,'Turnover Paint - 1 BR','The Apollo',1,'',270,270,0,12,0),(7,'Carpet Clean','Unit 651-A Occupied Carpet Clean',1,'',25,25,0,15,0),(8,'Turnover Paint - 1 BR','The Apollo',45,'hours',270,12150,0,20,1),(9,'Name of Project','Description of project',1,'',125,125,0,23,0),(10,'Name of the Task','Description of the Task',1,'',0,0,0,23,0),(11,'Turnover Paint - 1 BR','The Apollo',1,'',270,270,0,24,1),(12,'PINTURA','DEMOS',1,'',1250,1250,0,28,0),(13,'Fer','FEr',1,'',0,0,0,28,0);
/*!40000 ALTER TABLE `invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_payments`
--

DROP TABLE IF EXISTS `invoice_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` double NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `invoice_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `transaction_id` tinytext COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_payments`
--

LOCK TABLES `invoice_payments` WRITE;
/*!40000 ALTER TABLE `invoice_payments` DISABLE KEYS */;
INSERT INTO `invoice_payments` VALUES (1,125,'2018-12-13',1,'',1,0,NULL,3,'2018-12-13 05:34:11');
/*!40000 ALTER TABLE `invoice_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `bill_date` date NOT NULL,
  `due_date` date NOT NULL,
  `note` mediumtext COLLATE utf8_unicode_ci,
  `last_email_sent_date` date DEFAULT NULL,
  `status` enum('draft','not_paid') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'draft',
  `tax_id` int(11) NOT NULL DEFAULT '0',
  `tax_id2` int(11) NOT NULL DEFAULT '0',
  `recurring` tinyint(4) NOT NULL DEFAULT '0',
  `recurring_invoice_id` int(11) NOT NULL DEFAULT '0',
  `repeat_every` int(11) NOT NULL DEFAULT '0',
  `repeat_type` enum('days','weeks','months','years') COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_of_cycles` int(11) NOT NULL DEFAULT '0',
  `next_recurring_date` date DEFAULT NULL,
  `no_of_cycles_completed` int(11) NOT NULL DEFAULT '0',
  `due_reminder_date` date DEFAULT NULL,
  `recurring_reminder_date` date DEFAULT NULL,
  `discount_amount` double NOT NULL,
  `discount_amount_type` enum('percentage','fixed_amount') COLLATE utf8_unicode_ci NOT NULL,
  `discount_type` enum('before_tax','after_tax') COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,1,1,'2018-12-13','2018-12-13','Gracias por Preferinos',NULL,'not_paid',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(2,1,2,'2018-12-26','2018-12-27','UI',NULL,'draft',1,1,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(3,3,4,'2019-01-05','2019-01-06','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',1),(4,3,4,'2019-01-05','2019-01-06','demos','2019-01-05','not_paid',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',1),(5,1,5,'2019-01-05','2019-01-05','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',1),(6,1,5,'2019-01-05','2019-01-05','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',1),(7,7,6,'2019-01-18','2019-01-18','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(8,7,6,'2019-01-28','2019-01-29','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(9,7,6,'2019-02-01','2019-03-01','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(10,4,0,'2019-02-07','2019-02-08','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(11,4,0,'2019-02-08','2019-02-15','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(12,5,0,'2019-02-06','2019-02-21','',NULL,'draft',1,1,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(13,8,0,'2019-02-07','2019-02-22','',NULL,'draft',1,1,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(14,7,7,'2019-02-11','2019-03-11','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(15,9,8,'2019-04-02','2019-04-02','','2019-04-02','not_paid',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(16,9,9,'2019-04-04','2019-04-04','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(17,4,13,'2019-05-16','2019-05-16','DEDEDEDEDEDEDe',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(18,4,11,'2019-05-17','2019-05-17','',NULL,'draft',0,0,1,0,1,'days',1,'2019-05-19',1,NULL,NULL,0,'percentage','before_tax',0),(19,4,10,'2019-05-17','2019-05-18','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(20,4,16,'2019-05-16','2019-05-24','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(21,4,11,'2019-05-17','2019-05-23','jlkjkljkl',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(22,9,17,'2019-05-17','2019-05-19','',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(23,55,12,'2019-05-16','2019-05-23','Demo',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(24,4,18,'2019-05-17','2019-06-17','Alguna',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(25,4,18,'2019-05-17','2019-05-17','Demos tester','2019-05-23','not_paid',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(26,89,0,'2019-05-23','2019-05-23','test','2019-05-23','not_paid',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',1),(27,93,21,'2019-05-24','2019-05-24','This is test',NULL,'draft',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(28,4,11,'2019-05-18','2019-05-18','','2019-07-12','not_paid',0,0,0,18,0,NULL,0,NULL,0,NULL,NULL,0,'percentage','before_tax',0),(29,5,25,'2019-07-23','2019-07-23','','2019-07-22','not_paid',0,0,0,0,1,'months',0,NULL,0,NULL,NULL,0,'percentage','before_tax',0);
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `unit_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rate` double NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'General Contractors','DEMO','aqwqaw',125,0),(2,'Turnover Paint - 1 BR','The Apollo','',270,0),(3,'Carpet Clean','Unit 651-A Occupied Carpet Clean','',1,0),(4,'Trash Room Floor Painting','Scrape existing coating from concrete floor in trash room.','SF',1.85,0),(5,'Concrete Coating','Apply new floor coating using Sherwin Williams Loxon concrete coating, color to match close to existing color as close as possible.','SF',4.5,0),(6,'Dryer Vent Cleaning','Access units from the outside of the buildings, 244 Units.\nRemove dryer vent cover from exterior.\nHook up vacuum to exterior duct work and clean duct system using suction and rotary brush.\nReinstall existing dryer vent cover. \n','Apts.',65,0),(7,'Gutter Cleaning','•	Clean gutters at 10 apartment buildings on the property, 284 units.\n•	Blow out all leaves and debris in gutters to prevent clogging.\n•	Verify downspout opening is clear and remove any blocking.\n','Apts.',15,0),(8,'Retaining Wall Construction','Supply and install pressure treated 8x8 retaining wall','SF',65,0),(9,'Tile Installation','Labor to install ceramic tile','SF',7,0),(10,'Demo','Demo','SF',2.85,0);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` date NOT NULL,
  `website` text COLLATE utf8_unicode_ci,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leads`
--

LOCK TABLES `leads` WRITE;
/*!40000 ALTER TABLE `leads` DISABLE KEYS */;
/*!40000 ALTER TABLE `leads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_applications`
--

DROP TABLE IF EXISTS `leave_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_type_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_hours` decimal(7,2) NOT NULL,
  `total_days` decimal(5,2) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `reason` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected','canceled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `checked_at` datetime DEFAULT NULL,
  `checked_by` int(11) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `leave_type_id` (`leave_type_id`),
  KEY `user_id` (`applicant_id`),
  KEY `checked_by` (`checked_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_applications`
--

LOCK TABLES `leave_applications` WRITE;
/*!40000 ALTER TABLE `leave_applications` DISABLE KEYS */;
/*!40000 ALTER TABLE `leave_applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_types`
--

DROP TABLE IF EXISTS `leave_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_types`
--

LOCK TABLES `leave_types` WRITE;
/*!40000 ALTER TABLE `leave_types` DISABLE KEYS */;
INSERT INTO `leave_types` VALUES (1,'Casual Leave','active','#83c340','',0);
/*!40000 ALTER TABLE `leave_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Untitled',
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `status` enum('unread','read') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unread',
  `message_id` int(11) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `files` longtext COLLATE utf8_unicode_ci NOT NULL,
  `deleted_by_users` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_from` (`from_user_id`),
  KEY `message_to` (`to_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'Reparar','Ejemplo','2018-12-12 00:26:53',3,1,'read',0,0,'a:0:{}',''),(2,'Hola','Hello','2018-12-18 15:47:01',7,1,'read',0,0,'a:0:{}',''),(3,'hhyhj','fderjkl','2018-12-21 16:08:11',7,1,'read',0,0,'a:0:{}',''),(4,'','Test','2018-12-26 14:27:55',3,1,'read',1,0,'a:0:{}',''),(5,'','ok','2018-12-26 14:28:11',1,3,'read',1,0,'a:0:{}',''),(6,'','hey','2018-12-26 14:28:16',3,1,'read',1,0,'a:0:{}',''),(7,'Test','Hola','2019-01-03 16:32:43',4,1,'read',0,0,'a:0:{}',''),(8,'','hey]','2019-01-03 18:16:40',4,1,'read',7,0,'a:0:{}',''),(9,'Testing','Hello','2019-02-07 17:46:40',1,7,'unread',0,0,'a:0:{}',''),(10,'','Test','2019-04-04 01:45:40',1,7,'unread',9,0,'a:0:{}',''),(11,'','Test','2019-04-04 01:45:46',1,7,'unread',9,0,'a:0:{}',''),(12,'','hi','2019-05-17 01:14:59',1,7,'unread',9,0,'a:0:{}',''),(13,'','hi','2019-05-17 01:15:03',1,7,'unread',9,0,'a:0:{}',''),(14,'','there?','2019-05-17 01:15:12',1,7,'unread',9,0,'a:0:{}',''),(15,'test','This is test mail','2019-05-22 10:04:25',1,89,'read',0,0,'a:0:{}',''),(16,'test','tests','2019-05-22 10:14:10',1,89,'read',0,0,'a:0:{}',''),(17,'','test','2019-05-22 10:15:31',1,89,'read',16,0,'a:0:{}',''),(18,'I am developer','This is test','2019-05-22 10:17:48',1,89,'read',0,0,'a:0:{}',''),(19,'','ok','2019-05-22 10:25:45',89,1,'read',18,0,'a:0:{}',''),(20,'','ok\n','2019-05-22 10:26:12',89,1,'read',18,0,'a:0:{}',''),(21,'sdf','sdaffds','2019-05-22 11:45:49',1,89,'read',0,0,'a:0:{}',''),(22,'test','stsafd','2019-05-22 11:48:01',1,89,'read',0,0,'a:0:{}',''),(23,'zxvzxcvzxvzxcvzxcvzv','zxvzxcvzxvzxcvzxcvzv','2019-05-22 11:53:21',1,89,'read',0,0,'a:0:{}',''),(24,'sadfas','asdfsadf','2019-05-22 12:16:04',1,89,'read',0,0,'a:0:{}',''),(25,'','zvzxc','2019-05-22 12:18:07',89,1,'read',21,0,'a:0:{}',''),(26,'','hello\n','2019-06-27 16:34:58',1,4,'unread',7,0,'a:0:{}',''),(27,'','hello\n','2019-06-27 16:35:20',1,4,'unread',7,0,'a:0:{}',''),(28,'Test Demo ','This mail for testing purpose.','2019-06-27 16:44:40',1,114,'read',0,0,'a:0:{}',''),(29,'','Test ','2019-06-27 16:57:10',114,1,'read',28,0,'a:0:{}','');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `milestones`
--

DROP TABLE IF EXISTS `milestones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `milestones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `milestones`
--

LOCK TABLES `milestones` WRITE;
/*!40000 ALTER TABLE `milestones` DISABLE KEYS */;
/*!40000 ALTER TABLE `milestones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `client_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `labels` text COLLATE utf8_unicode_ci,
  `files` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` VALUES (1,89,'2019-05-22 09:43:18','test','test',0,0,0,'Important','a:0:{}',0);
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_settings`
--

DROP TABLE IF EXISTS `notification_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(250) NOT NULL,
  `category` varchar(50) NOT NULL,
  `enable_email` int(1) NOT NULL DEFAULT '0',
  `enable_web` int(1) NOT NULL DEFAULT '0',
  `notify_to_team` text NOT NULL,
  `notify_to_team_members` text NOT NULL,
  `notify_to_terms` text NOT NULL,
  `sort` int(11) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `event` (`event`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_settings`
--

LOCK TABLES `notification_settings` WRITE;
/*!40000 ALTER TABLE `notification_settings` DISABLE KEYS */;
INSERT INTO `notification_settings` VALUES (1,'project_created','project',1,1,'','3,7','client_primary_contact,client_all_contacts',1,0),(2,'project_deleted','project',1,1,'','7,9','',2,0),(3,'project_task_created','project',1,1,'','','project_members,client_primary_contact,task_assignee,task_collaborators',3,0),(4,'project_task_updated','project',1,1,'','3,7','project_members,client_all_contacts,task_assignee,task_collaborators',4,0),(5,'project_task_assigned','project',1,1,'','','project_members,task_assignee,task_collaborators',5,0),(7,'project_task_started','project',1,1,'','3,7','project_members,client_primary_contact,client_all_contacts',7,0),(8,'project_task_finished','project',1,1,'','3,7','project_members,client_primary_contact,client_all_contacts',8,0),(9,'project_task_reopened','project',1,1,'','','',9,0),(10,'project_task_deleted','project',0,1,'','','task_assignee',10,0),(11,'project_task_commented','project',1,1,'','','project_members,client_primary_contact,task_assignee,task_collaborators,mentioned_members',11,0),(12,'project_member_added','project',1,1,'','','project_members',12,0),(13,'project_member_deleted','project',0,1,'','','project_members',13,0),(14,'project_file_added','project',1,1,'','3,7','project_members,client_primary_contact',14,0),(15,'project_file_deleted','project',0,1,'','','project_members',15,0),(16,'project_file_commented','project',1,1,'','3,7','project_members,client_primary_contact,mentioned_members',16,0),(17,'project_comment_added','project',1,1,'','3,7','project_members,mentioned_members',17,0),(18,'project_comment_replied','project',1,1,'','7,3','project_members,comment_creator,mentioned_members',18,0),(19,'project_customer_feedback_added','project',0,1,'','','project_members',19,0),(20,'project_customer_feedback_replied','project',0,1,'','','project_members,comment_creator',20,0),(21,'client_signup','client',1,1,'','','',21,0),(22,'invoice_online_payment_received','invoice',1,1,'','','',22,0),(23,'leave_application_submitted','leave',0,0,'','','',23,0),(24,'leave_approved','leave',0,1,'','','leave_applicant',24,0),(25,'leave_assigned','leave',0,1,'','','leave_applicant',25,0),(26,'leave_rejected','leave',0,1,'','','leave_applicant',26,0),(27,'leave_canceled','leave',0,0,'','','',27,0),(28,'ticket_created','ticket',1,1,'','','ticket_assignee',28,0),(29,'ticket_commented','ticket',0,1,'','','client_primary_contact,ticket_creator',29,0),(30,'ticket_closed','ticket',0,1,'','','client_primary_contact,ticket_creator',30,0),(31,'ticket_reopened','ticket',0,1,'','','client_primary_contact,ticket_creator',31,0),(32,'estimate_request_received','estimate',1,1,'','3,7','',32,0),(33,'estimate_sent','estimate',1,1,'','7','client_primary_contact,client_all_contacts',33,0),(34,'estimate_accepted','estimate',1,1,'','3,7','',34,0),(35,'estimate_rejected','estimate',1,1,'','3,7','',35,0),(36,'new_message_sent','message',1,1,'','','recipient',36,0),(37,'message_reply_sent','message',1,1,'','','recipient',37,0),(38,'invoice_payment_confirmation','invoice',1,1,'','','client_primary_contact',22,0),(39,'new_event_added_in_calendar','event',0,0,'','','',39,0),(40,'recurring_invoice_created_vai_cron_job','invoice',1,1,'','','client_primary_contact',22,0),(41,'new_announcement_created','announcement',1,1,'','','recipient',41,0),(42,'invoice_due_reminder_before_due_date','invoice',0,0,'','','',22,0),(43,'invoice_overdue_reminder','invoice',1,1,'','3,7','',22,0),(44,'recurring_invoice_creation_reminder','invoice',0,0,'','','',22,0);
/*!40000 ALTER TABLE `notification_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `notify_to` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `read_by` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `event` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `project_comment_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `ticket_comment_id` int(11) NOT NULL,
  `project_file_id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `activity_log_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_payment_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `estimate_id` int(11) NOT NULL,
  `estimate_request_id` int(11) NOT NULL,
  `actual_message_id` int(11) NOT NULL,
  `parent_message_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `sms` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,3,'','2018-12-13 05:01:11','','','project_member_deleted',1,0,0,0,0,0,0,0,3,0,0,0,0,0,0,0,0,0,0,0,1),(2,3,'','2018-12-13 05:01:30','4','','project_member_added',1,0,0,0,0,0,0,0,4,0,0,0,0,0,0,0,0,0,0,0,1),(3,1,'','2018-12-13 05:03:55','4',',4','project_task_created',1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1),(4,4,'','2018-12-13 05:08:15','','','project_task_updated',1,1,0,0,0,0,0,0,0,2,0,0,0,0,0,0,0,0,0,0,0),(5,4,'','2018-12-13 05:09:02','','','project_task_updated',1,1,0,0,0,0,0,0,0,3,0,0,0,0,0,0,0,0,0,0,0),(6,4,'','2018-12-13 05:10:19','','','project_task_commented',1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(7,7,'','2018-12-18 15:57:05','3','','project_member_added',2,0,0,0,0,0,0,0,3,0,0,0,0,0,0,0,0,0,0,1,0),(8,3,'','2018-12-26 14:29:59','7,4','','project_member_added',2,0,0,0,0,0,0,0,4,0,0,0,0,0,0,0,0,0,0,1,1),(9,3,'','2018-12-26 14:30:36','7,4',',4','project_task_created',2,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1),(10,4,'','2018-12-26 14:55:36','3',',3','project_task_commented',2,2,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0),(11,3,'','2018-12-26 15:01:20','','','project_task_updated',2,2,0,0,0,0,0,0,0,7,0,0,0,0,0,0,0,0,0,1,1),(12,4,'','2018-12-26 15:01:38','3',',3','project_task_updated',2,2,0,0,0,0,0,0,0,8,0,0,0,0,0,0,0,0,0,1,0),(13,1,'','2019-01-03 12:36:53','2','','project_created',3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(14,1,'','2019-01-03 12:37:47','4',',4','project_member_added',3,0,0,0,0,0,0,0,4,0,0,0,0,0,0,0,0,0,0,0,0),(15,1,'','2019-01-03 16:11:54','4',',4','project_task_created',3,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(16,4,'','2019-01-03 16:12:30','1',',1','project_task_commented',3,3,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(17,4,'','2019-01-03 16:14:11','1','','project_task_updated',3,3,0,0,0,0,0,0,0,11,0,0,0,0,0,0,0,0,0,0,0),(18,1,'','2019-01-03 16:18:56','8','','project_created',4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0),(19,1,'','2019-01-03 16:31:14','','','project_task_updated',3,3,0,0,0,0,0,0,0,12,0,0,0,0,0,0,0,0,0,0,0),(20,1,'','2019-01-03 16:31:50','4','','project_member_added',4,0,0,0,0,0,0,0,4,0,0,0,0,0,0,0,0,0,0,1,0),(21,4,'','2019-01-03 18:17:50','1','','project_task_commented',3,3,5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(22,4,'','2019-01-03 19:57:41','1','','project_task_commented',3,3,6,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(23,4,'','2019-01-04 00:14:09','1',',1','project_task_commented',3,3,7,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(24,4,'','2019-01-04 14:30:41','1','','project_task_commented',3,3,8,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(25,4,'','2019-01-04 14:47:53','1','','project_task_commented',3,3,9,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(26,4,'','2019-01-04 15:54:53','1','','project_task_commented',3,3,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(27,4,'','2019-01-04 17:18:11','1','','project_task_commented',3,3,11,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(28,4,'','2019-01-04 17:21:46','1',',1','project_task_commented',3,3,12,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(29,8,'','2019-01-05 06:33:18','7,3','','estimate_request_received',0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0),(30,1,'','2019-01-05 07:07:35','4,8','','project_task_created',4,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0),(31,1,'','2019-01-05 07:08:37','4','','project_task_updated',4,4,0,0,0,0,0,0,0,22,0,0,0,0,0,0,0,0,0,1,0),(32,1,'','2019-01-05 07:09:09','4','','project_task_updated',4,4,0,0,0,0,0,0,0,23,0,0,0,0,0,0,0,0,0,1,0),(33,1,'','2019-01-05 19:28:48','2','','project_created',5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0),(34,1,'','2019-01-05 19:34:06','2','','project_task_created',5,5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0),(35,1,'','2019-01-05 19:34:23','','','project_task_updated',5,5,0,0,0,0,0,0,0,25,0,0,0,0,0,0,0,0,0,1,0),(36,1,'','2019-01-06 00:39:29','7,8','','estimate_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,2,0,0,0,0,0,0,0),(37,1,'','2019-01-18 00:50:01','7','','project_deleted',5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(38,1,'','2019-01-18 03:18:02','7','','project_deleted',4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(39,1,'','2019-01-18 03:18:07','7','','project_deleted',2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0),(40,1,'','2019-01-18 03:18:11','7','','project_deleted',2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0),(41,1,'','2019-01-18 03:18:13','7','','project_deleted',2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0),(42,1,'','2019-01-18 03:18:19','7','','project_deleted',2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(43,9,'','2019-01-18 16:37:41','7','','project_created',6,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(44,9,'','2019-01-18 16:40:31','','','project_task_created',6,6,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(45,1,'','2019-02-07 17:46:43','7','','new_message_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,9,0,0,0,0,0),(46,9,'','2019-02-11 22:28:26','','','project_created',7,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(47,9,'','2019-02-11 22:29:04','15','','project_member_added',7,0,0,0,0,0,0,0,15,0,0,0,0,0,0,0,0,0,0,0,0),(48,9,'','2019-04-01 16:48:31','18,19','','project_created',8,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(49,9,'','2019-04-01 16:50:00','21','','project_member_added',8,0,0,0,0,0,0,0,21,0,0,0,0,0,0,0,0,0,0,0,0),(50,9,'','2019-04-02 16:35:29','18,19','','project_created',9,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(51,1,'','2019-04-04 01:45:42','','','message_reply_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,9,0,0,0,0),(52,1,'','2019-04-04 01:45:48','','','message_reply_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,11,9,0,0,0,0),(53,1,'','2019-04-08 14:08:38','','','project_created',10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(54,1,'','2019-04-08 14:09:26','9,20','','project_member_added',10,0,0,0,0,0,0,0,20,0,0,0,0,0,0,0,0,0,0,0,0),(55,1,'','2019-04-08 14:09:27','9,20','','project_member_added',10,0,0,0,0,0,0,0,9,0,0,0,0,0,0,0,0,0,0,0,0),(56,1,'','2019-04-08 14:10:30','9,20','','project_task_created',10,7,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(57,1,'','2019-04-08 14:55:33','9,20','','project_task_updated',10,7,0,0,0,0,0,0,0,28,0,0,0,0,0,0,0,0,0,0,0),(58,9,'','2019-04-10 14:48:14','','','project_created',11,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(59,9,'','2019-04-10 14:49:09','84,1','','project_member_added',11,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0),(60,9,'','2019-04-10 14:49:10','84,1',',1','project_member_added',11,0,0,0,0,0,0,0,84,0,0,0,0,0,0,0,0,0,0,0,0),(61,9,'','2019-04-10 14:50:22','84,1',',1','project_task_created',11,8,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(62,21,'','2019-04-15 19:04:05','','','project_created',12,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(63,21,'','2019-04-15 19:12:57','74','','project_member_added',12,0,0,0,0,0,0,0,74,0,0,0,0,0,0,0,0,0,0,0,0),(64,21,'','2019-04-15 19:14:26','9,74','','project_member_added',12,0,0,0,0,0,0,0,9,0,0,0,0,0,0,0,0,0,0,0,0),(65,21,'','2019-04-19 15:50:39','9',',9,21','project_task_commented',6,6,13,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(66,9,'','2019-04-19 15:52:43','',',21','project_task_commented',6,6,14,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(67,21,'','2019-04-19 15:55:08','9',',21','project_task_commented',6,6,15,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(68,21,'','2019-04-19 15:59:48','9','','project_task_created',6,9,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(69,21,'','2019-04-19 16:05:16','9,74','','project_member_added',6,0,0,0,0,0,0,0,74,0,0,0,0,0,0,0,0,0,0,0,0),(70,21,'','2019-04-19 16:13:32','9,74','','project_task_created',6,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(71,74,'','2019-04-19 16:13:47','9','','project_task_updated',6,9,0,0,0,0,0,0,0,35,0,0,0,0,0,0,0,0,0,0,0),(72,74,'','2019-04-19 16:13:54','9','','project_task_updated',6,9,0,0,0,0,0,0,0,36,0,0,0,0,0,0,0,0,0,0,0),(73,74,'','2019-04-19 16:14:41','9','','project_task_updated',6,9,0,0,0,0,0,0,0,37,0,0,0,0,0,0,0,0,0,0,0),(74,74,'','2019-04-19 16:14:50','9','','project_task_updated',6,6,0,0,0,0,0,0,0,38,0,0,0,0,0,0,0,0,0,0,0),(75,74,'','2019-04-19 16:17:57','9','','project_task_updated',6,10,0,0,0,0,0,0,0,39,0,0,0,0,0,0,0,0,0,0,0),(76,1,'','2019-05-15 18:43:19','9,21,74,90','','project_member_added',12,0,0,0,0,0,0,0,90,0,0,0,0,0,0,0,0,0,0,0,0),(77,1,'','2019-05-15 18:44:22','9,21,74,90','','project_task_created',12,11,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(78,1,'','2019-05-16 15:03:30','85','','project_created',13,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(79,1,'','2019-05-16 15:07:39','85','','project_task_created',13,12,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(80,1,'','2019-05-16 15:07:58','85','','project_task_updated',13,12,0,0,0,0,0,0,0,42,0,0,0,0,0,0,0,0,0,0,0),(81,1,'','2019-05-16 15:57:41','','','project_created',14,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0),(82,1,'','2019-05-16 16:31:02','85','','project_created',15,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0),(83,1,'','2019-05-16 16:33:52','85','','project_created',16,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(84,9,'','2019-05-16 21:19:55','21,74,90','','project_task_created',12,13,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(85,9,'','2019-05-16 21:21:30','21,74,90','','project_task_created',12,14,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(86,1,'','2019-05-17 01:15:02','','','message_reply_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,12,9,0,0,0,0),(87,1,'','2019-05-17 01:15:05','','','message_reply_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,13,9,0,0,0,0),(88,1,'','2019-05-17 01:15:14','','','message_reply_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,14,9,0,0,0,0),(89,1,'','2019-05-17 02:03:14','','','project_deleted',15,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(90,1,'','2019-05-17 02:03:21','','','project_deleted',14,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(91,1,'','2019-05-17 02:21:43','18,19','','project_created',17,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(92,1,'','2019-05-17 02:29:01','85','','project_task_created',16,15,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(93,1,'','2019-05-17 02:29:13','85','','project_task_updated',16,15,0,0,0,0,0,0,0,46,0,0,0,0,0,0,0,0,0,0,0),(94,1,'','2019-05-17 13:14:11','85','','project_created',18,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(95,1,'','2019-05-17 13:16:12','31,74','','project_member_added',18,0,0,0,0,0,0,0,74,0,0,0,0,0,0,0,0,0,0,0,0),(96,1,'','2019-05-17 13:16:13','31,74,80','','project_member_added',18,0,0,0,0,0,0,0,31,0,0,0,0,0,0,0,0,0,0,0,0),(97,1,'','2019-05-17 13:16:15','31,72,74,80','','project_member_added',18,0,0,0,0,0,0,0,80,0,0,0,0,0,0,0,0,0,0,0,0),(98,1,'','2019-05-17 13:16:15','31,72,74,80','','project_member_added',18,0,0,0,0,0,0,0,72,0,0,0,0,0,0,0,0,0,0,0,0),(99,1,'','2019-05-17 13:17:49','31,72,74,80,85','','project_task_created',18,16,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(100,1,'','2019-05-17 13:20:19','31,72,74,80,85','','project_task_updated',18,16,0,0,0,0,0,0,0,48,0,0,0,0,0,0,0,0,0,0,0),(101,85,'','2019-05-17 13:24:35','','','estimate_request_received',0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,0,0,0,0,0,0),(102,91,'','2019-05-17 13:40:01','','','estimate_request_received',0,0,0,0,0,0,0,0,0,0,0,0,0,0,3,0,0,0,0,0,0),(103,1,'','2019-05-17 13:54:18','31,72,74,80,85','','project_task_created',18,17,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(104,1,'','2019-05-17 13:55:21','','','project_task_commented',18,17,18,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(105,1,'','2019-05-17 13:56:25','31,72,74,80,85','','project_task_updated',18,16,0,0,0,0,0,0,0,51,0,0,0,0,0,0,0,0,0,0,0),(106,1,'','2019-05-17 13:58:14','31,72,74,80,85','','project_task_updated',18,17,0,0,0,0,0,0,0,52,0,0,0,0,0,0,0,0,0,0,0),(107,1,'','2019-05-22 10:04:27','89','','new_message_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,15,0,0,0,0,0),(108,1,'','2019-05-22 10:14:13','89','','new_message_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,16,0,0,0,0,0),(109,1,'','2019-05-22 10:17:51','89','','new_message_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,18,0,0,0,0,0),(110,89,'','2019-05-22 10:25:47','1','','message_reply_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,19,18,0,0,0,0),(111,89,'','2019-05-22 10:26:15','1',',1','message_reply_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,20,18,0,0,0,0),(112,1,'','2019-05-22 10:54:46','','','project_created',19,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(113,1,'','2019-05-22 11:48:04','89','','new_message_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,22,0,0,0,0,0),(114,1,'','2019-05-22 11:53:23','89','','new_message_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,23,0,0,0,0,0),(115,1,'','2019-05-23 06:34:15','99','','project_created',20,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(116,1,'','2019-05-23 09:06:58','','','project_created',21,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(117,114,'','2019-05-28 13:39:24','72,31,1,74,80,85','','project_task_created',18,18,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(118,114,'','2019-05-28 13:40:56','31',',31,1','project_task_commented',18,18,19,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(119,114,'','2019-05-28 13:41:09','72,31,1,74,80,85',',1','project_task_updated',18,18,0,0,0,0,0,0,0,55,0,0,0,0,0,0,0,0,0,0,0),(120,31,'','2019-05-30 21:03:27','72,1,74,80,85','','project_task_updated',18,18,0,0,0,0,0,0,0,56,0,0,0,0,0,0,0,0,0,0,0),(121,9,'','2019-06-05 18:23:25','1','','project_member_added',17,0,0,0,0,0,0,0,9,0,0,0,0,0,0,0,0,0,0,0,0),(122,9,'','2019-06-05 18:24:06','1,18','','project_task_created',17,19,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(123,9,'','2019-06-05 18:24:59','','','project_task_commented',17,19,20,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(124,9,'','2019-06-18 18:16:27','1,18',',1','project_task_created',17,20,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(125,9,'','2019-06-18 18:18:49','1,18,19','','project_task_updated',17,20,0,0,0,0,0,0,0,60,0,0,0,0,0,0,0,0,0,0,0),(126,9,'','2019-06-18 18:23:49','','','project_created',22,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(127,9,'','2019-06-18 18:27:59','','','project_task_created',22,21,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(128,1,'','2019-06-27 16:35:00','','','message_reply_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,26,7,0,0,0,0),(129,1,'','2019-06-27 16:35:22','','','message_reply_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,27,7,0,0,0,0),(130,1,'','2019-06-27 16:44:42','114','','new_message_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,28,0,0,0,0,0),(131,114,'','2019-06-27 16:57:12','1',',1','message_reply_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,29,28,0,0,0,0),(132,1,'','2019-07-01 09:19:55','','','project_created',23,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(133,1,'','2019-07-12 12:00:47','','','project_created',24,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(134,0,'','2019-07-12 19:14:45','85','','recurring_invoice_created_vai_cron_job',0,0,0,0,0,0,0,0,0,0,0,0,28,0,0,0,0,0,0,0,0),(135,1,'','2019-07-14 22:33:58','','','estimate_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,12,0,0,0,0,0,0,0),(136,1,'','2019-07-14 22:34:03','','','estimate_sent',0,0,0,0,0,0,0,0,0,0,0,0,0,12,0,0,0,0,0,0,0),(137,1,'','2019-07-22 13:26:27','91','','project_created',25,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(138,1,'','2019-07-22 13:27:15','115','','project_member_added',25,0,0,0,0,0,0,0,115,0,0,0,0,0,0,0,0,0,0,0,0),(139,1,'','2019-07-22 13:34:10','115,91','','project_task_created',25,22,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'custom',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `online_payable` tinyint(1) NOT NULL DEFAULT '0',
  `available_on_invoice` tinyint(1) NOT NULL DEFAULT '0',
  `minimum_payment_amount` double NOT NULL DEFAULT '0',
  `settings` longtext COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES (1,'Check','custom','Check payments',0,0,0,'a:0:{}',0),(2,'Stripe','stripe','Stripe online payments',1,0,0,'a:3:{s:15:\"pay_button_text\";s:6:\"Stripe\";s:10:\"secret_key\";s:6:\"\";s:15:\"publishable_key\";s:6:\"\";}',0),(3,'PayPal Payments Standard','paypal_payments_standard','PayPal Payments Standard Online Payments',1,0,0,'a:4:{s:15:\"pay_button_text\";s:6:\"PayPal\";s:5:\"email\";s:4:\"\";s:11:\"paypal_live\";s:1:\"0\";s:5:\"debug\";s:1:\"0\";}',0);
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paypal_ipn`
--

DROP TABLE IF EXISTS `paypal_ipn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paypal_ipn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` tinytext COLLATE utf8_unicode_ci,
  `ipn_hash` longtext COLLATE utf8_unicode_ci NOT NULL,
  `ipn_data` longtext COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paypal_ipn`
--

LOCK TABLES `paypal_ipn` WRITE;
/*!40000 ALTER TABLE `paypal_ipn` DISABLE KEYS */;
/*!40000 ALTER TABLE `paypal_ipn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `share_with` text COLLATE utf8_unicode_ci,
  `files` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_comments`
--

DROP TABLE IF EXISTS `project_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0',
  `task_id` int(11) NOT NULL DEFAULT '0',
  `file_id` int(11) NOT NULL DEFAULT '0',
  `customer_feedback_id` int(11) NOT NULL DEFAULT '0',
  `files` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `sms` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_comments`
--

LOCK TABLES `project_comments` WRITE;
/*!40000 ALTER TABLE `project_comments` DISABLE KEYS */;
INSERT INTO `project_comments` VALUES (1,4,'2018-12-13 05:10:18','agreamos un bano',1,0,1,0,0,'a:0:{}',0,1),(2,4,'2018-12-26 14:55:36','Check please ',2,0,2,0,0,'a:1:{i:0;a:2:{s:9:\"file_name\";s:43:\"project_comment_file5c239668333a9-image.jpg\";s:9:\"file_size\";s:7:\"2151354\";}}',1,1),(3,1,'2019-01-03 16:11:55','',3,0,3,0,0,'a:1:{i:0;a:2:{s:9:\"file_name\";s:95:\"project_comment_file5c2e344b4072b-contact-us-icon-set-red-colored-icons-reflection-61564650.jpg\";s:9:\"file_size\";s:5:\"11767\";}}',0,1),(4,4,'2019-01-03 16:12:29','Gracias',3,0,3,0,0,'a:0:{}',0,1),(5,4,'2019-01-03 18:17:49','test\n',3,0,3,0,0,'a:0:{}',0,1),(6,4,'2019-01-03 19:57:41','DFDGG',3,0,3,0,0,'a:0:{}',0,1),(7,4,'2019-01-04 00:14:08','demo',3,0,3,0,0,'a:0:{}',0,1),(8,4,'2019-01-04 14:30:41','done that?',3,0,3,0,0,'a:0:{}',0,1),(9,4,'2019-01-04 14:47:52','Check again',3,0,3,0,0,'a:0:{}',0,1),(10,4,'2019-01-04 15:54:52','I ready sms?',3,0,3,0,0,'a:0:{}',0,1),(11,4,'2019-01-04 17:18:11','Otra vez test',3,0,3,0,0,'a:0:{}',0,1),(12,4,'2019-01-04 17:21:46','veamos',3,0,3,0,0,'a:0:{}',0,1),(13,21,'2019-04-19 15:50:35','prueba',6,0,6,0,0,'a:0:{}',0,0),(14,9,'2019-04-19 15:52:41','Prueba',6,0,6,0,0,'a:1:{i:0;a:2:{s:9:\"file_name\";s:75:\"project_comment_file5cb9eec839116-12E92FE6-78A6-466F-BDE4-FD8CD599E4DF.jpeg\";s:9:\"file_size\";s:7:\"2433846\";}}',0,0),(15,21,'2019-04-19 15:55:05','prueba',6,0,6,0,0,'a:1:{i:0;a:2:{s:9:\"file_name\";s:52:\"project_comment_file5cb9ef5976d61-Building-22-1.jpeg\";s:9:\"file_size\";s:6:\"195796\";}}',0,0),(16,21,'2019-04-19 15:59:47','',6,0,9,0,0,'a:1:{i:0;a:2:{s:9:\"file_name\";s:56:\"project_comment_file5cb9f0730ff3f-626j-roof-repair-1.jpg\";s:9:\"file_size\";s:6:\"606420\";}}',0,0),(17,21,'2019-04-19 16:13:31','',6,0,10,0,0,'a:1:{i:0;a:2:{s:9:\"file_name\";s:56:\"project_comment_file5cb9f3ab242e9-626j-roof-repair-2.jpg\";s:9:\"file_size\";s:6:\"428326\";}}',0,0),(18,1,'2019-05-17 13:55:18','DSAdsadasdsadsadsdsasa',18,0,17,0,0,'a:0:{}',0,0),(19,114,'2019-05-28 13:40:53','Test',18,0,18,0,0,'a:0:{}',0,0),(20,9,'2019-06-05 18:24:57','comentario de prueba',17,0,19,0,0,'a:0:{}',0,0);
/*!40000 ALTER TABLE `project_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_files`
--

DROP TABLE IF EXISTS `project_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` text COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `file_size` double NOT NULL,
  `created_at` datetime NOT NULL,
  `project_id` int(11) NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_files`
--

LOCK TABLES `project_files` WRITE;
/*!40000 ALTER TABLE `project_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_members`
--

DROP TABLE IF EXISTS `project_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `is_leader` tinyint(1) DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_members`
--

LOCK TABLES `project_members` WRITE;
/*!40000 ALTER TABLE `project_members` DISABLE KEYS */;
INSERT INTO `project_members` VALUES (1,3,1,1,1),(2,4,1,0,0),(3,7,2,1,0),(4,3,2,0,0),(5,4,2,0,0),(6,1,3,1,0),(7,4,3,0,0),(8,1,4,1,0),(9,4,4,0,0),(10,1,5,1,0),(11,9,6,1,0),(12,9,7,1,0),(13,15,7,0,0),(14,9,8,1,0),(15,21,8,0,0),(16,9,9,1,0),(17,1,10,1,0),(18,20,10,0,0),(19,9,10,0,0),(20,9,11,1,0),(21,1,11,0,0),(22,84,11,0,0),(23,21,12,1,0),(24,74,12,0,0),(25,9,12,0,0),(26,74,6,0,0),(27,90,12,0,0),(28,1,13,1,0),(29,1,14,1,0),(30,1,15,1,0),(31,1,16,1,0),(32,1,17,1,0),(33,1,18,1,0),(34,74,18,0,0),(35,31,18,0,0),(36,80,18,0,0),(37,72,18,0,0),(38,1,19,1,0),(39,1,20,1,0),(40,1,21,1,0),(41,9,17,0,0),(42,9,22,1,0),(43,1,23,1,0),(44,1,24,1,0),(45,1,25,1,0),(46,115,25,0,0);
/*!40000 ALTER TABLE `project_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_settings`
--

DROP TABLE IF EXISTS `project_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_settings` (
  `project_id` int(11) NOT NULL,
  `setting_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `unique_index` (`project_id`,`setting_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_settings`
--

LOCK TABLES `project_settings` WRITE;
/*!40000 ALTER TABLE `project_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_time`
--

DROP TABLE IF EXISTS `project_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` enum('open','logged','approved') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'logged',
  `note` text COLLATE utf8_unicode_ci,
  `task_id` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_time`
--

LOCK TABLES `project_time` WRITE;
/*!40000 ALTER TABLE `project_time` DISABLE KEYS */;
INSERT INTO `project_time` VALUES (1,1,3,'2018-12-13 04:57:57','2018-12-13 04:58:25','logged','ki',0,1),(2,11,1,'2019-05-22 10:32:22','2019-05-28 12:00:35','logged','',8,0);
/*!40000 ALTER TABLE `project_time` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `start_date` date DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `status` enum('open','completed','hold','canceled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `labels` text COLLATE utf8_unicode_ci,
  `price` double NOT NULL DEFAULT '0',
  `starred_by` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `estimate_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `sms` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Proyecto Dmo','demoas','2018-12-12','2018-12-15',1,'2018-12-13',3,'completed','',1250,'',0,0,1),(2,'Trabajo Prueba','Trabajo de prueba #1','2018-12-24','2018-12-28',1,'2018-12-17',7,'completed','',300,'',0,1,1),(3,'Test','Tester Demo','2019-01-04',NULL,1,'2019-01-03',1,'completed','',0,'',0,0,1),(4,'Painting','Descripticon','2019-01-03','2019-01-03',3,'2019-01-03',1,'completed','',1500,'',0,1,1),(5,'Construction','Demo Test  Construction ','2019-01-05','2019-01-12',1,'2019-01-05',1,'open','',1000,'',0,1,0),(6,'Turnover Paint','','2019-01-01',NULL,7,'2019-01-18',9,'open','',0,'',0,0,0),(7,'Test Project','Test Project','2019-02-11','2019-02-18',7,'2019-02-11',9,'completed','',125,'',0,0,0),(8,'Occupied Carpet Clean','Occupied Carpet Clean - Unit 651-A','2019-04-04','2019-04-04',9,'2019-04-01',9,'completed','',0,'',0,0,0),(9,'Turnover Paint - 1 BR','Unit 1234-A','2019-04-03','2019-04-03',9,'2019-04-02',9,'completed','',1250,'',0,0,0),(10,'Demo','DEMOSTRACION PRyecto','2019-04-08','2019-04-11',4,'2019-04-08',1,'completed','',1250,'',0,0,0),(11,'PINTURA','DEMOS','2019-04-10','2019-04-10',4,'2019-04-10',9,'completed','',1250,'',0,0,0),(12,'Unit 1111 Vacant cleaning','Por favor limpiar en la tarde, el pintor va estar en la mañana.','2019-04-17','2019-04-17',55,'2019-04-15',21,'open','',0,'',0,0,0),(13,'Demo Tester','Demo Tester Demo Demo','2019-05-16','2019-05-30',4,'2019-05-16',1,'completed','',4500,'',0,0,0),(14,'Indian national removed from US, wanted in home country for attempted murder and extortion','tryrtyrt','2019-05-16','2019-05-17',55,'2019-05-16',1,'open','',123,'',0,1,0),(15,'Indian national removed from US, wanted in home country for attempted murder and extortion','3w5rwer','2019-05-14','2019-05-13',4,'2019-05-16',1,'open','',123,'',0,1,0),(16,'jftj','hjgyujgl','2019-05-17','2019-05-20',4,'2019-05-16',1,'completed','',125,'',0,0,0),(17,'test','test','2019-05-17','2019-05-19',9,'2019-05-17',1,'open','',125,'',0,0,0),(18,'Proyecto 1','Description','2019-05-17','2019-05-21',4,'2019-05-17',1,'open','paint',1200,'',0,0,0),(19,'testing','testing','2019-05-22','2019-05-22',87,'2019-05-22',1,'open','paint',4500,'',0,0,0),(20,'test','test','2019-05-23','2019-05-23',89,'2019-05-23',1,'open','paint',150,'',0,0,0),(21,'test','stst','2019-05-23','2019-05-24',93,'2019-05-23',1,'open','paint',1200,'',0,0,0),(22,'test project 0618','test project','2019-06-18','2019-06-19',55,'2019-06-18',9,'open','paint',0,'',0,0,0),(23,'test_task','test','2019-07-17','2019-07-18',94,'2019-07-01',1,'open','test',120,'',0,0,0),(24,'test john','jkhjkhjkhjh','2019-07-15','2019-07-26',55,'2019-07-12',1,'open','paint',1000,'',0,0,0),(25,'Final Demo','Demos final demos dinal','2019-07-22','2019-07-24',5,'2019-07-22',1,'open','',1250,'',0,0,0);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` mediumtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin','a:34:{s:5:\"leave\";s:3:\"all\";s:14:\"leave_specific\";s:0:\"\";s:10:\"attendance\";s:8:\"specific\";s:19:\"attendance_specific\";s:8:\"member:3\";s:7:\"invoice\";s:3:\"all\";s:8:\"estimate\";s:3:\"all\";s:7:\"expense\";s:3:\"all\";s:6:\"client\";s:3:\"all\";s:6:\"ticket\";s:3:\"all\";s:15:\"ticket_specific\";s:0:\"\";s:12:\"announcement\";s:3:\"all\";s:23:\"help_and_knowledge_base\";s:0:\"\";s:23:\"can_manage_all_projects\";s:1:\"1\";s:19:\"can_create_projects\";s:1:\"1\";s:17:\"can_edit_projects\";s:1:\"1\";s:19:\"can_delete_projects\";s:1:\"1\";s:30:\"can_add_remove_project_members\";s:1:\"1\";s:16:\"can_create_tasks\";s:1:\"1\";s:14:\"can_edit_tasks\";s:1:\"1\";s:16:\"can_delete_tasks\";s:1:\"1\";s:20:\"can_comment_on_tasks\";s:1:\"1\";s:21:\"can_create_milestones\";s:1:\"1\";s:19:\"can_edit_milestones\";s:1:\"1\";s:21:\"can_delete_milestones\";s:1:\"1\";s:16:\"can_delete_files\";s:1:\"1\";s:34:\"can_view_team_members_contact_info\";s:1:\"1\";s:34:\"can_view_team_members_social_links\";s:1:\"1\";s:29:\"team_member_update_permission\";s:3:\"all\";s:38:\"team_member_update_permission_specific\";s:0:\"\";s:27:\"timesheet_manage_permission\";s:3:\"all\";s:36:\"timesheet_manage_permission_specific\";s:0:\"\";s:21:\"disable_event_sharing\";N;s:22:\"hide_team_members_list\";N;s:28:\"can_delete_leave_application\";N;}',0),(2,'wdsa',NULL,1),(3,'Employee','a:34:{s:5:\"leave\";s:0:\"\";s:14:\"leave_specific\";s:0:\"\";s:10:\"attendance\";s:0:\"\";s:19:\"attendance_specific\";s:0:\"\";s:7:\"invoice\";s:0:\"\";s:8:\"estimate\";s:0:\"\";s:7:\"expense\";s:0:\"\";s:6:\"client\";s:3:\"all\";s:6:\"ticket\";s:0:\"\";s:15:\"ticket_specific\";s:0:\"\";s:12:\"announcement\";s:0:\"\";s:23:\"help_and_knowledge_base\";s:0:\"\";s:23:\"can_manage_all_projects\";N;s:19:\"can_create_projects\";N;s:17:\"can_edit_projects\";N;s:19:\"can_delete_projects\";N;s:30:\"can_add_remove_project_members\";N;s:16:\"can_create_tasks\";N;s:14:\"can_edit_tasks\";N;s:16:\"can_delete_tasks\";N;s:20:\"can_comment_on_tasks\";s:1:\"1\";s:21:\"can_create_milestones\";N;s:19:\"can_edit_milestones\";N;s:21:\"can_delete_milestones\";N;s:16:\"can_delete_files\";N;s:34:\"can_view_team_members_contact_info\";N;s:34:\"can_view_team_members_social_links\";N;s:29:\"team_member_update_permission\";s:0:\"\";s:38:\"team_member_update_permission_specific\";s:0:\"\";s:27:\"timesheet_manage_permission\";s:0:\"\";s:36:\"timesheet_manage_permission_specific\";s:0:\"\";s:21:\"disable_event_sharing\";s:1:\"1\";s:22:\"hide_team_members_list\";s:1:\"1\";s:28:\"can_delete_leave_application\";N;}',0),(4,'Manager','a:34:{s:5:\"leave\";s:0:\"\";s:14:\"leave_specific\";s:0:\"\";s:10:\"attendance\";s:0:\"\";s:19:\"attendance_specific\";s:0:\"\";s:7:\"invoice\";s:3:\"all\";s:8:\"estimate\";s:3:\"all\";s:7:\"expense\";s:3:\"all\";s:6:\"client\";s:3:\"all\";s:6:\"ticket\";s:3:\"all\";s:15:\"ticket_specific\";s:0:\"\";s:12:\"announcement\";s:3:\"all\";s:23:\"help_and_knowledge_base\";s:0:\"\";s:23:\"can_manage_all_projects\";s:1:\"1\";s:19:\"can_create_projects\";s:1:\"1\";s:17:\"can_edit_projects\";s:1:\"1\";s:19:\"can_delete_projects\";s:1:\"1\";s:30:\"can_add_remove_project_members\";s:1:\"1\";s:16:\"can_create_tasks\";s:1:\"1\";s:14:\"can_edit_tasks\";s:1:\"1\";s:16:\"can_delete_tasks\";s:1:\"1\";s:20:\"can_comment_on_tasks\";s:1:\"1\";s:21:\"can_create_milestones\";N;s:19:\"can_edit_milestones\";N;s:21:\"can_delete_milestones\";N;s:16:\"can_delete_files\";s:1:\"1\";s:34:\"can_view_team_members_contact_info\";s:1:\"1\";s:34:\"can_view_team_members_social_links\";N;s:29:\"team_member_update_permission\";N;s:38:\"team_member_update_permission_specific\";s:0:\"\";s:27:\"timesheet_manage_permission\";s:3:\"all\";s:36:\"timesheet_manage_permission_specific\";s:0:\"\";s:21:\"disable_event_sharing\";s:1:\"1\";s:22:\"hide_team_members_list\";N;s:28:\"can_delete_leave_application\";N;}',0),(5,'Estimator','a:34:{s:5:\"leave\";s:0:\"\";s:14:\"leave_specific\";s:0:\"\";s:10:\"attendance\";s:0:\"\";s:19:\"attendance_specific\";s:0:\"\";s:7:\"invoice\";s:3:\"all\";s:8:\"estimate\";s:3:\"all\";s:7:\"expense\";s:3:\"all\";s:6:\"client\";s:3:\"all\";s:6:\"ticket\";s:3:\"all\";s:15:\"ticket_specific\";s:0:\"\";s:12:\"announcement\";s:3:\"all\";s:23:\"help_and_knowledge_base\";s:0:\"\";s:23:\"can_manage_all_projects\";s:1:\"1\";s:19:\"can_create_projects\";s:1:\"1\";s:17:\"can_edit_projects\";s:1:\"1\";s:19:\"can_delete_projects\";s:1:\"1\";s:30:\"can_add_remove_project_members\";s:1:\"1\";s:16:\"can_create_tasks\";s:1:\"1\";s:14:\"can_edit_tasks\";s:1:\"1\";s:16:\"can_delete_tasks\";s:1:\"1\";s:20:\"can_comment_on_tasks\";s:1:\"1\";s:21:\"can_create_milestones\";N;s:19:\"can_edit_milestones\";N;s:21:\"can_delete_milestones\";N;s:16:\"can_delete_files\";s:1:\"1\";s:34:\"can_view_team_members_contact_info\";s:1:\"1\";s:34:\"can_view_team_members_social_links\";N;s:29:\"team_member_update_permission\";N;s:38:\"team_member_update_permission_specific\";s:0:\"\";s:27:\"timesheet_manage_permission\";s:3:\"all\";s:36:\"timesheet_manage_permission_specific\";s:0:\"\";s:21:\"disable_event_sharing\";s:1:\"1\";s:22:\"hide_team_members_list\";N;s:28:\"can_delete_leave_application\";N;}',0);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `setting_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'app',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `setting_name` (`setting_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES ('accepted_file_formats','jpg,jpeg,doc,xls','app',0),('allow_partial_invoice_payment_from_clients','0','app',0),('allowed_ip_addresses','','app',0),('app_title','G.A.R. Managment Building Services','app',0),('client_can_add_project_files','1','app',0),('client_can_comment_on_files','1','app',0),('client_can_comment_on_tasks','1','app',0),('client_can_create_projects','1','app',0),('client_can_create_tasks','1','app',0),('client_can_edit_tasks','','app',0),('client_can_view_gantt','','app',0),('client_can_view_milestones','','app',0),('client_can_view_overview','','app',0),('client_can_view_project_files','1','app',0),('client_can_view_tasks','1','app',0),('client_message_users','3,7','app',0),('company_address','9401 Manassas DR.\nSuite Q\nManassas Park, VA 20111','app',0),('company_email','info@garcontractors.com','app',0),('company_name','G.A.R Contractors, Inc.','app',0),('company_phone','(866) GAR-5504','app',0),('company_vat_number','','app',0),('company_website','www.garcontractors.com','app',0),('currency_position','left','app',0),('currency_symbol','$','app',0),('date_format','m/d/Y','app',0),('decimal_separator','.','app',0),('default_currency','USD','app',0),('disable_client_login','','app',0),('disable_client_signup','1','app',0),('email_protocol','smtp','app',0),('email_sent_from_address','info@garcontractors.com','app',0),('email_sent_from_name','G.A.R Contractors, Inc.','app',0),('email_smtp_host','smtp.gmail.com','app',0),('email_smtp_pass','Caca2015','app',0),('email_smtp_port','587','app',0),('email_smtp_security_type','tls','app',0),('email_smtp_user','Garnotificaciones@gmail.com','app',0),('first_day_of_week','0','app',0),('hidden_client_menus','events,knowledge_base','app',0),('invoice_color','#467cb3','app',0),('invoice_footer','<p><strong>Chaly Romero</strong></p>\n<p><em>CEO FOUNDER</em></p>\n<p><a href=\"mailto:chaly@garcontractors.com\">chaly@garcontractors.com</a></p>\n<p>&nbsp;</p>\n<p>TERMS: 30 DAYS.</p>\n<p>PLEASE SEND PAYMENTS TO:</p>\n<p><strong>GAR CONRACTORS, INC</strong></p>\n<p><em>PO BOX 538</em></p>\n<p><em>BRISTOW, VA 20136</em></p>\n<p>&nbsp;</p>\n<p>THANK YOU FOR YOUR BUSINESS</p>\n<p>&nbsp;</p>','app',0),('invoice_logo','_file5c49228a4c58b-invoice-logo.png','app',0),('invoice_prefix','INV00','app',0),('invoice_style','style_1','app',0),('item_purchase_code','d81ea366-9976-4726-9b23-173cdb81e640','app',0),('language','english','app',0),('last_cron_job_time','1562984083','app',0),('module_announcement','1','app',0),('module_attendance','','app',0),('module_chat','1','app',0),('module_estimate','1','app',0),('module_estimate_request','1','app',0),('module_event','1','app',0),('module_expense','1','app',0),('module_help','','app',0),('module_invoice','1','app',0),('module_knowledge_base','','app',0),('module_leave','','app',0),('module_message','1','app',0),('module_note','1','app',0),('module_project_timesheet','1','app',0),('module_ticket','1','app',0),('module_timeline','','app',0),('module_todo','1','app',0),('no_of_decimals','2','app',0),('rows_per_page','10','app',0),('scrollbar','native','app',0),('send_bcc_to','chaly@garcontractors.com','app',0),('send_invoice_due_after_reminder','1','app',0),('send_invoice_due_pre_reminder','1','app',0),('send_recurring_invoice_reminder_before_creation','1','app',0),('show_background_image_in_signin_page','no','app',0),('show_logo_in_signin_page','yes','app',0),('site_logo','_file5c3bb12ca2612-site-logo.png','app',0),('time_format','small','app',0),('timezone','America/New_York','app',0),('user_1_dashboard','','user',0),('user_1_personal_language','english','user',0),('user_10_dashboard','','user',0),('user_11_dashboard','','user',0),('user_113_dashboard','','user',0),('user_114_dashboard','','user',0),('user_115_dashboard','','user',0),('user_15_dashboard','','user',0),('user_2_dashboard','','user',0),('user_20_dashboard','','user',0),('user_21_dashboard','','user',0),('user_3_dashboard','','user',0),('user_3_notification_sound_volume','0','user',0),('user_3_personal_language','english','user',0),('user_30_dashboard','','user',0),('user_31_dashboard','','user',0),('user_31_notification_sound_volume','3','user',0),('user_31_personal_language','english','user',0),('user_4_dashboard','','user',0),('user_7_dashboard','','user',0),('user_7_personal_language','english','user',0),('user_74_dashboard','','user',0),('user_8_dashboard','','user',0),('user_84_dashboard','','user',0),('user_85_dashboard','','user',0),('user_86_dashboard','','user',0),('user_87_dashboard','','user',0),('user_89_dashboard','','user',0),('user_9_dashboard','','user',0),('user_90_dashboard','','user',0),('user_91_dashboard','','user',0);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_links`
--

DROP TABLE IF EXISTS `social_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `facebook` text COLLATE utf8_unicode_ci,
  `twitter` text COLLATE utf8_unicode_ci,
  `linkedin` text COLLATE utf8_unicode_ci,
  `googleplus` text COLLATE utf8_unicode_ci,
  `digg` text COLLATE utf8_unicode_ci,
  `youtube` text COLLATE utf8_unicode_ci,
  `pinterest` text COLLATE utf8_unicode_ci,
  `instagram` text COLLATE utf8_unicode_ci,
  `github` text COLLATE utf8_unicode_ci,
  `tumblr` text COLLATE utf8_unicode_ci,
  `vine` text COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_links`
--

LOCK TABLES `social_links` WRITE;
/*!40000 ALTER TABLE `social_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_status`
--

DROP TABLE IF EXISTS `task_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `key_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_status`
--

LOCK TABLES `task_status` WRITE;
/*!40000 ALTER TABLE `task_status` DISABLE KEYS */;
INSERT INTO `task_status` VALUES (1,'To Do','to_do','#F9A52D',0,0),(2,'In progress','in_progress','#1672B9',1,0),(3,'Done','done','#00B393',2,0);
/*!40000 ALTER TABLE `task_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `project_id` int(11) NOT NULL,
  `milestone_id` int(11) NOT NULL DEFAULT '0',
  `assigned_to` int(11) NOT NULL,
  `deadline` date DEFAULT NULL,
  `labels` text COLLATE utf8_unicode_ci,
  `points` tinyint(4) NOT NULL DEFAULT '1',
  `status` enum('to_do','in_progress','done') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'to_do',
  `status_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `collaborators` text COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(11) NOT NULL DEFAULT '0',
  `sms` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,'Turnover Painting','Pintar',1,0,4,'2018-12-20','',1,'to_do',3,'2018-12-13','',0,0,1),(2,'Painting','Deo9s',2,0,3,'2018-12-29','',1,'to_do',3,'2018-12-27','4',0,1,1),(3,'Painting','Demos Painting',3,0,1,'2019-01-07','',1,'to_do',3,'2019-01-04','4',0,0,1),(4,'Demos','',4,0,4,'2019-01-10','',1,'to_do',3,'2019-01-07','4',0,1,0),(5,'Cambiar bano','',5,0,1,'2019-01-05','',1,'to_do',3,'2019-01-05','',0,1,0),(6,'Unit 413','Turnover Paint',6,0,9,'2019-01-21','',1,'to_do',3,'2019-01-21','',0,0,0),(7,'Paint','Paint',10,0,1,'2019-04-09','',1,'to_do',3,'2019-04-09','20',0,0,0),(8,'Fer','FEr',11,0,1,'2019-04-11','',1,'to_do',1,'2019-04-10','84',0,0,0),(9,'vacant - carpet clenaing','ir en la tarde',6,0,9,'2019-04-22','rehab',1,'to_do',3,'2019-04-22','',0,0,0),(10,'vacant - carpet cleaning','debe ir en la mañana',6,0,74,'2019-04-23','capex',1,'to_do',3,'2019-04-23','',0,0,0),(11,'task1','',12,0,90,NULL,'',1,'to_do',1,NULL,'',0,0,0),(12,'Camisas','Demostracion',13,0,1,'2019-05-23','',1,'to_do',3,'2019-05-16','1',0,0,0),(13,'test task','notification test task',12,0,9,'2019-05-20','',1,'to_do',1,'2019-05-17','',0,0,0),(14,'task','test notification',12,0,9,'2019-05-20','',1,'to_do',1,'2019-05-17','',0,0,0),(15,'Demo','Demo',16,0,1,NULL,'',1,'to_do',3,NULL,'',0,0,0),(16,'Pintar','descrpicon',18,0,31,'2019-05-22','',1,'to_do',3,'2019-05-17','80',0,0,0),(17,'Cambiar Wather heater','DEmo',18,0,1,'2019-05-17','',1,'to_do',3,'2019-05-17','72',0,0,0),(18,'Test Task','Test Task',18,0,31,'2019-05-31','',3,'to_do',3,'2019-05-28','74,80',10000000,0,0),(19,'prueba','tarea de prueba',17,0,9,'2019-06-06','',1,'to_do',1,'2019-06-06','',0,0,0),(20,'task for test','test',17,0,9,'2019-06-19','paint',1,'to_do',1,'2019-06-19','',0,0,0),(21,'test task','description test',22,0,9,'2019-06-18','paint',1,'to_do',1,'2019-06-18','',0,0,0),(22,'Demo Final','Demos Tratas',25,0,1,'2019-07-23','',1,'to_do',1,'2019-07-22','115',0,0,0);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxes`
--

DROP TABLE IF EXISTS `taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `percentage` double NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxes`
--

LOCK TABLES `taxes` WRITE;
/*!40000 ALTER TABLE `taxes` DISABLE KEYS */;
INSERT INTO `taxes` VALUES (1,'Tax (10%)',10,1);
/*!40000 ALTER TABLE `taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `members` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` VALUES (1,'Equpio Uno','3',1);
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_member_job_info`
--

DROP TABLE IF EXISTS `team_member_job_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_member_job_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_of_hire` date DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `salary` double NOT NULL DEFAULT '0',
  `salary_term` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_member_job_info`
--

LOCK TABLES `team_member_job_info` WRITE;
/*!40000 ALTER TABLE `team_member_job_info` DISABLE KEYS */;
INSERT INTO `team_member_job_info` VALUES (1,3,'0000-00-00',0,0,''),(2,1,'0000-00-00',0,0,''),(3,4,'0000-00-00',0,0,''),(4,7,'0000-00-00',0,0,''),(5,9,'0000-00-00',0,0,''),(6,10,'0000-00-00',0,0,''),(7,11,'0000-00-00',0,0,''),(8,14,'0000-00-00',0,0,''),(9,15,'0000-00-00',0,0,''),(10,20,'0000-00-00',0,0,''),(11,21,'0000-00-00',0,0,''),(12,30,'0000-00-00',0,0,''),(13,31,'0000-00-00',0,0,''),(14,50,'0000-00-00',0,0,''),(15,72,'2019-01-01',0,0,''),(16,73,'0000-00-00',0,0,''),(17,74,'0000-00-00',0,0,''),(18,75,'0000-00-00',0,0,''),(19,76,'0000-00-00',0,0,''),(20,77,'0000-00-00',0,0,''),(21,78,'0000-00-00',0,0,''),(22,79,'0000-00-00',0,0,''),(23,80,'0000-00-00',0,0,''),(24,81,'0000-00-00',0,0,''),(25,82,'0000-00-00',0,0,''),(26,83,'0000-00-00',0,0,''),(27,84,'0000-00-00',0,0,''),(28,86,'2019-05-15',0,12000,'test'),(29,87,'2019-05-15',0,0,'test'),(30,88,'2019-05-21',0,100000,'part'),(31,89,'2019-05-15',0,0,'sam@sam.com'),(32,90,'2019-05-15',0,100000,'part'),(33,92,'2019-04-30',0,0,'test'),(34,100,'2019-05-23',0,12000,'part'),(35,101,'2019-05-23',0,12000,'part'),(36,102,'2019-05-23',0,1200,'part'),(37,103,'2019-05-23',0,13200,'part'),(38,104,'2019-05-23',0,0,'zcxv'),(39,105,'2019-05-24',0,0,'stes'),(40,106,'2019-05-23',0,0,'test'),(41,107,'2019-05-23',0,12000,'test'),(42,108,'2019-05-24',0,0,'tst'),(43,109,'2019-05-23',0,12300,'test'),(44,110,'2019-05-23',0,0,'dfasd'),(45,111,'2019-05-23',0,20000,'Part'),(46,112,'2019-05-23',0,12200,'part'),(47,113,'2019-05-23',0,12000,'part'),(48,114,'0000-00-00',0,0,''),(49,115,'0000-00-00',0,0,'');
/*!40000 ALTER TABLE `team_member_job_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_comments`
--

DROP TABLE IF EXISTS `ticket_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `files` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_comments`
--

LOCK TABLES `ticket_comments` WRITE;
/*!40000 ALTER TABLE `ticket_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_types`
--

DROP TABLE IF EXISTS `ticket_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_types`
--

LOCK TABLES `ticket_types` WRITE;
/*!40000 ALTER TABLE `ticket_types` DISABLE KEYS */;
INSERT INTO `ticket_types` VALUES (1,'General Support',0);
/*!40000 ALTER TABLE `ticket_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `ticket_type_id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` enum('new','client_replied','open','closed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new',
  `last_activity_at` datetime DEFAULT NULL,
  `assigned_to` int(11) NOT NULL DEFAULT '0',
  `labels` text COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `to_do`
--

DROP TABLE IF EXISTS `to_do`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `to_do` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `labels` text COLLATE utf8_unicode_ci,
  `status` enum('to_do','done') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'to_do',
  `start_date` date DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `to_do`
--

LOCK TABLES `to_do` WRITE;
/*!40000 ALTER TABLE `to_do` DISABLE KEYS */;
/*!40000 ALTER TABLE `to_do` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` enum('staff','client') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'client',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `message_checked_at` datetime DEFAULT NULL,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `notification_checked_at` datetime DEFAULT NULL,
  `is_primary_contact` tinyint(1) NOT NULL DEFAULT '0',
  `job_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Untitled',
  `disable_login` tinyint(1) NOT NULL DEFAULT '0',
  `note` mediumtext COLLATE utf8_unicode_ci,
  `address` text COLLATE utf8_unicode_ci,
  `alternative_address` text COLLATE utf8_unicode_ci,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alternative_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `ssn` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'male',
  `sticky_note` mediumtext COLLATE utf8_unicode_ci,
  `skype` text COLLATE utf8_unicode_ci,
  `enable_web_notification` tinyint(1) NOT NULL DEFAULT '1',
  `enable_email_notification` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `last_online` datetime DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `phone_varifiction` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `phone_varifiction_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_type` (`user_type`),
  KEY `email` (`email`),
  KEY `client_id` (`client_id`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Carlos','Coreas','staff',1,0,'Info@becowebllc.com','2fd30c2b947bd2def43b3567e61a8db2','_file5c3cbe18ecf6e-avatar.png','active','2019-07-23 06:25:35',0,'2019-07-23 15:17:34',0,'Support',0,NULL,'Washington DC','','+12027664200','','1986-01-15','','male',NULL,'',1,1,'0000-00-00 00:00:00','2019-07-24 02:08:16',0,'1','563669'),(3,'Manuel ','Martinez','staff',0,4,'cacoreasa@gmail.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active','2018-12-26 15:01:23',0,'2018-12-26 15:01:50',0,'Manager',0,NULL,'1711 West Virginia Ave NE','','2027664200','','0000-00-00','','male','','',1,1,'2018-12-11 23:45:18','2018-12-26 16:01:47',1,'0',''),(4,'Demo','Trabajador','staff',0,3,'testbecoweb@gmail.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active','2019-01-03 16:15:58',0,'2019-01-03 17:00:09',0,'Painting',0,NULL,'Maryland',NULL,'20276545678',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2018-12-13 04:30:52','2019-01-04 18:45:01',1,'0',''),(5,'Manager','Contacto','client',0,0,'contacto@pancodemo.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,2,NULL,1,'Manager',0,'',NULL,NULL,'1111111111',NULL,NULL,NULL,'male',NULL,'',1,1,'2018-12-13 04:54:50',NULL,1,'0',''),(6,'President','Demo','client',0,0,'presidente@pancodemo.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,2,NULL,0,'PResidente',0,'',NULL,NULL,'111122222',NULL,NULL,NULL,'male',NULL,'',1,1,'2018-12-13 04:55:40',NULL,1,'0',''),(7,'Chaly','Romero','staff',0,1,'chaly@garcontractors.com','7067c3560fc57a4df14e8cbdf100e040',NULL,'active','2018-12-21 16:34:15',0,'2019-01-14 16:58:00',0,'CEO Founder',0,NULL,'9104 Manassas Drive, Manassas Park, Virginia 20111','','7039292698','','0000-00-00','','male',NULL,'',1,1,'2018-12-17 00:30:02','2019-01-16 18:30:20',1,'0',''),(8,'Demo ','Test','client',0,0,'almydecoreas@gmail.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active','2019-01-05 06:57:09',3,'2019-01-05 07:08:20',1,'Manager',0,'',NULL,NULL,'2027664195',NULL,NULL,NULL,'male',NULL,'222222222',1,1,'2018-12-18 15:32:36','2019-01-06 02:48:40',1,'0',''),(9,'Manuel','Martinez','staff',1,4,'manuel@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Manager',0,NULL,'','','5715777722','','0000-00-00','','male',NULL,'',1,1,'2019-01-18 00:26:43','2019-07-02 17:46:55',0,'1','779541'),(10,'Rosario','Justiniano','staff',0,4,'rosario@garcontractors.com','3ee7e45cdefea55889d85843978e2e4f',NULL,'active',NULL,0,NULL,0,'Assistant.',0,NULL,'','','','','0000-00-00','','male',NULL,'',1,1,'2019-01-18 13:18:50','2019-04-03 21:03:28',0,'0',''),(11,'Heather','Andrade','staff',0,4,'heather@garcontractors.com','386f70c9e5547cfec6978755a9ddf711',NULL,'active',NULL,0,NULL,0,'Property Assistant',0,NULL,'','','571-550-0078','','0000-00-00','','female',NULL,'',1,1,'2019-01-18 13:20:45','2019-01-18 20:49:40',0,'0',''),(12,'AKbar','Husen','client',0,0,'akbarmaknojiya@gmail.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,4,NULL,1,'',0,'',NULL,NULL,'8530706924',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-02-07 06:13:34',NULL,1,'0',''),(13,'TEST','Buyer','client',0,0,'akbarmaknojiya@gmail.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,4,NULL,1,'',0,'',NULL,NULL,'12323232132',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-02-07 07:23:49',NULL,1,'0',''),(14,'Chaly','Romero','staff',0,1,'chaly@garcontractors.com','1aca22245447b97976803066390db38f',NULL,'active',NULL,0,NULL,0,'CEO Founder',0,NULL,'',NULL,'7039292698',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-02-09 20:02:23',NULL,1,'0',''),(15,'Chaly','Romero','staff',0,1,'chaly@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'CEO Founder',0,NULL,'',NULL,'7039292698',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-02-10 15:13:40','2019-02-19 12:45:57',1,'0',''),(16,'Bruno','Bianchi','client',0,0,'bbianchi@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,10,NULL,1,'Service Manager',0,'',NULL,NULL,'571-422-7803',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-02-19 16:55:32',NULL,0,'0',''),(17,'Katara','Mahdi','client',0,0,'KMahdi@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,10,NULL,0,'Property Manager',0,'',NULL,NULL,'703-713-0910',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-02-19 17:01:24',NULL,0,'0',''),(18,'Kevin','Ingersoll','client',0,0,'kingersoll@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,9,NULL,1,'Senior Property Manager',0,'',NULL,NULL,'703-561-0300',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-02-19 17:06:35',NULL,0,'0',''),(19,'Francisco','Urrutia','client',0,0,'jurrutia@pancomgt.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,9,NULL,0,'Service Manager',0,'',NULL,NULL,'571-329-1986',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-02-19 17:08:55',NULL,0,'0',''),(20,'Demo','Demo','staff',0,0,'cacoreasa@gmail.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active','2019-04-25 22:46:30',0,NULL,0,'DEmo',0,NULL,'',NULL,'207664200',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-03-15 13:42:28','2019-04-25 22:46:46',1,'0',''),(21,'Suilen','Campos','staff',0,4,'suilen@garcontractors.com','cf4433f2a1f37766b8cab5503398e10e',NULL,'active',NULL,0,NULL,0,'Scheduling',0,NULL,'',NULL,'',NULL,NULL,NULL,'female',NULL,NULL,1,1,'2019-04-01 14:24:32','2019-04-19 17:08:50',0,'0',''),(22,'Steve','Terapane','client',0,0,'sterapane@bainbridgere.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,11,NULL,1,'Property Manager',0,'',NULL,NULL,'703-680-0668',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-01 14:34:18',NULL,0,'0',''),(23,'Daniel','Sebbat','client',0,0,'dsebbat@bozzuto.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,12,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-01 14:41:21',NULL,0,'0',''),(24,'Christina','Guilarte','client',0,0,'cguilarte@bozzuto.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,13,NULL,1,'Property Manager',0,'',NULL,NULL,'703-348-5541',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-01 15:13:10',NULL,0,'0',''),(25,'Henry','Ramos','client',0,0,'hramos@bozzuto.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,14,NULL,1,'Property Manager',0,'',NULL,NULL,'703-920-3111',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-01 15:16:02',NULL,0,'0',''),(26,'Amen','Musingarimi','client',0,0,'manager@restonglade.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,15,NULL,1,'Property Manager',0,'',NULL,NULL,'703-620-9031',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-01 15:18:50',NULL,0,'0',''),(27,'Stephanie','Artico','client',0,0,'millennium.pm@kettler.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,16,NULL,1,'',0,'',NULL,NULL,'571-409-4938',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-01 15:31:39',NULL,0,'0',''),(28,'John','Sancho','client',0,0,'metacadia.pm@kettler.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,17,NULL,1,'Property Manager',0,'',NULL,NULL,'703-995-2505',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-01 15:38:21',NULL,0,'0',''),(29,'Michael','Wheet','client',0,0,'mwheet@kcmapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,18,NULL,1,'Property Manager',0,'',NULL,NULL,'703-478-8388',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-01 15:50:32',NULL,0,'0',''),(30,'Chaly','Romero','staff',0,1,'chaly@garcontractors.com','f05be0e4c9ed1816631847db5b9ee024',NULL,'active','2019-04-27 16:32:45',0,'2019-04-27 16:32:41',0,'CEO',0,NULL,'',NULL,'7039292698',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-02 22:53:00','2019-04-27 16:33:18',1,'0',''),(31,'Dan','Whorten','staff',0,5,'dan@garcontractors.com','aedc687563b8c3cd625ea0be170dcf58',NULL,'active','2019-05-24 15:43:35',0,NULL,0,'Senior Estimator',0,NULL,'','','703-927-1343','','1975-11-12','','male',NULL,'',1,1,'2019-04-03 13:31:50','2019-05-30 21:03:48',0,'1','265196'),(32,'Ana','Mazariego','client',0,0,'amazariego@kcmapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,21,NULL,1,'',0,'',NULL,NULL,'703-379-9094',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 17:21:31',NULL,0,'0',''),(33,'Nicole','Vaka','client',0,0,'reserveattowncentermgr@lincolnapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,24,NULL,1,'Property Manager',0,'',NULL,NULL,'571-230-0897',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 17:23:08',NULL,0,'0',''),(34,'Sarah','Bostic','client',0,0,'westfieldmgr@licolnapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,25,NULL,1,'Property Manager',0,'',NULL,NULL,'703-901-9954',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 17:24:32',NULL,0,'0',''),(35,'Shelley','Hilton','client',0,0,'ambertonmgr@lincolnapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,26,NULL,1,'Property Manager',0,'',NULL,NULL,'334-714-8114',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 17:26:24',NULL,0,'0',''),(36,'Nicole','Weathers','client',0,0,'reserveatregencymgr@lincolnapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,27,NULL,1,'Property Manager',0,'',NULL,NULL,'703-815-1000',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 17:39:19',NULL,0,'0',''),(37,'Curtis','Schaeffer','client',0,0,'mgashfordmeadows@lincolnapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,28,NULL,1,'Property manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-03 17:40:33',NULL,0,'0',''),(38,'Becky','Woods','client',0,0,'saddleridgemgr@lincolnapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,29,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 17:43:47',NULL,0,'0',''),(39,'Yvette','Walker','client',0,0,'mgrlincolnatfairoaks@lincolnapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,30,NULL,1,'Property Manager',0,'',NULL,NULL,'703-449-8900',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 17:49:56',NULL,0,'0',''),(40,'Shante','Maness','client',0,0,'smaness@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,31,NULL,1,'Property Manager',0,'',NULL,NULL,'240.350.2955',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 19:11:56',NULL,0,'0',''),(41,'Glenda','Garcia','client',0,0,'ggarcia@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,32,NULL,1,'Property Manager',0,'',NULL,NULL,'703-920-2166',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 19:15:40',NULL,0,'0',''),(42,'Kim','Shelton','client',0,0,'kshelton@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,33,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 19:20:45',NULL,0,'0',''),(43,'Miguel','Espinoza','client',0,0,'MEspinoza@chanres.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,40,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-03 19:51:50',NULL,0,'0',''),(44,'Alicia','Wiggins','client',0,0,'awiggins@rocksco.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,41,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 19:54:32',NULL,0,'0',''),(45,'Francois','Forbes','client',0,0,'fforbes@bozzuto.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,43,NULL,1,'Service Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-03 20:01:57',NULL,0,'0',''),(46,'Jonathan','Egerton','client',0,0,'jegerton@bozzuto.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,44,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-03 20:26:30',NULL,0,'0',''),(47,'Jacqueline','Blandon','client',0,0,'Jacqueline.Blandon@bozzuto.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,45,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 20:29:38',NULL,0,'0',''),(48,'Devon','McNally','client',0,0,'dmcnally@bozzuto.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,46,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-03 20:32:21',NULL,0,'0',''),(49,'Julie','Ruppert','client',0,0,'jruppert@bozzuto.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,47,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-03 20:34:40',NULL,0,'0',''),(50,'jose','arreyan','staff',0,1,'josea@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'construction manager',0,NULL,'josea@garcontractors.com',NULL,'5712896614',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-04 01:41:33',NULL,0,'0',''),(51,'Crawford','Weathers','client',0,0,'cweathers@mccafferyinterest.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,56,NULL,1,'Service Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-04 14:48:04',NULL,0,'0',''),(52,'Arlene','Brown','client',0,0,'abrown@uippm.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,57,NULL,1,'Sr. Community Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 14:51:09',NULL,0,'0',''),(53,'Verna','Hinton','client',0,0,'vhinton@uippm.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,58,NULL,1,'Assistant Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 14:54:04',NULL,0,'0',''),(54,'Nishea','Hightower','client',0,0,'nhightower@bainbridgere.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,59,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 14:58:56',NULL,0,'0',''),(55,'Shahab','Hassanpour','client',0,0,'shassanpour@bozzuto.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,60,NULL,1,'Service Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-04 15:01:49',NULL,0,'0',''),(56,'Michal','Dunseith','client',0,0,'mdunseith@kcmapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,62,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-04 15:06:45',NULL,0,'0',''),(57,'Corrie','Dinolfo','client',0,0,'cdinolfo@kcmapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,63,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 15:16:01',NULL,0,'0',''),(58,'Kim','Sisco','client',0,0,'ksisco@kcmapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,64,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 15:24:13',NULL,0,'0',''),(59,'Danielle','Akintunde','client',0,0,'dakintunde@kcmapts.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,65,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 15:27:25',NULL,0,'0',''),(60,'Nicole','Smith','client',0,0,'nsmith@murnproperties.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,68,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 15:32:32',NULL,0,'0',''),(61,'Maureen','Rohm','client',0,0,'mrohm@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,69,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-04 15:34:41',NULL,0,'0',''),(62,'Janice','Parrack','client',0,0,'jparrack@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,70,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 15:37:03',NULL,0,'0',''),(63,'Tiffany','Hall','client',0,0,'thall@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,71,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 15:40:30',NULL,0,'0',''),(64,'Fredys','Molina','client',0,0,'fmolina@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,72,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-04 15:45:38',NULL,0,'0',''),(65,'Francisca','Martinez','client',0,0,'fmartinez@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,74,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 15:50:05',NULL,0,'0',''),(66,'Tracy','Steele','client',0,0,'tsteele@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,75,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 15:53:22',NULL,0,'0',''),(67,'Van','Cooper','client',0,0,'vcooper@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,78,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-04 15:59:34',NULL,0,'0',''),(68,'Heather','Ronsini','client',0,0,'hronsini@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,79,NULL,1,'Property Manager',0,'',NULL,NULL,'301-318-2777',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 16:01:34',NULL,0,'0',''),(69,'Cara','Neetles','client',0,0,'cnettles@pancomgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,81,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 16:07:05',NULL,0,'0',''),(70,'Emmanuel','Rendon','client',0,0,'erendon@uippm.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,84,NULL,1,'Property Manager',0,'',NULL,NULL,'',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-04 16:17:46',NULL,0,'0',''),(71,'Candice','Robinson','client',0,0,'acctpay@pvmgt.com','d41d8cd98f00b204e9800998ecf8427e',NULL,'active',NULL,86,NULL,1,'',0,'',NULL,NULL,'',NULL,NULL,NULL,'female',NULL,'',1,1,'2019-04-04 16:33:00',NULL,0,'0',''),(72,'Jorge','Martinez','staff',0,4,'jorge@garcontractors.com','3a646e76cf9269a757f87129666d0947',NULL,'active',NULL,0,NULL,0,'Supervisor',0,NULL,'9104 Manassas Dr,\nSuite Q.\nManassas Park, VA 20111',NULL,'240-338-4516',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-05 15:55:20',NULL,0,'0',''),(73,'Humberto','Muñoz','staff',0,3,'humbertomunoz@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Driver',0,NULL,'9104 Manassas Dr,\nSuite Q\nManassas Park, VA 20111',NULL,'(202) 848-8152‬',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-05 19:13:15',NULL,0,'0',''),(74,'David','Chavez','staff',0,0,'davidchavez@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Sr. Carpet Technician',0,NULL,'9104 Manassas Dr\nSuite Q\nManassas Park, VA 20111',NULL,'(703) 371-4611',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-05 19:19:36','2019-04-22 20:18:25',0,'0','871306'),(75,'Edwin','Ruiz','staff',0,0,'edwinruiz@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Lead Technician',0,NULL,'9104 Manassas Dr\nSuite Q\nManassas Park, VA 20111',NULL,'(571) 359-8996‬',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-05 19:20:51',NULL,0,'0',''),(76,'Gustavo','Garay','staff',0,0,'gustavogaray@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Technician',0,NULL,'9104 Manassas Dr\nSuite Q\nManassas Park, VA 20111',NULL,'(571) 762-9758',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-05 19:22:40',NULL,0,'0',''),(77,'Marco','Victorio','staff',0,0,'marcovictorio@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Technician',0,NULL,'9104 Manassas Dr\nSuite Q\nManassas Park, VA 20111',NULL,'',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-05 19:25:26',NULL,0,'0',''),(78,'Jeovanny','Saldivar','staff',0,0,'jeovannysaldivar@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Technician',0,NULL,'9104 Manassas Dr\nSuite Q\nManassas Park, VA 20111',NULL,'(571) 575-1948‬',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-05 19:41:06',NULL,0,'0',''),(79,'Braulio','Garcia','staff',0,0,'brauliogarcia@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Lead Technician',0,NULL,'9104 Manassas Dr\nSuite Q\nManassas Park, VA 20111',NULL,'',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-05 19:43:03',NULL,0,'0',''),(80,'Elmer','Garcia','staff',0,0,'elmergarcia@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Technician',0,NULL,'9104 Manassas Dr\nSuite Q\nManassas Park, VA 20111',NULL,'',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-05 19:44:30',NULL,0,'0',''),(81,'Jose','Diaz','staff',0,0,'josediaz@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Lead Technician',0,NULL,'9104 Manassas Dr\nSuite Q\nManassas Park, VA 20111',NULL,'(571) 762-9930‬',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-05 19:47:21',NULL,0,'0',''),(82,'Wilfredo','Rodriguez','staff',0,0,'wilfredorodriguez@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Technician',0,NULL,'9104 Manassas Dr\nSuite Q\nManassas Park, VA 20111',NULL,'',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-05 19:50:02',NULL,0,'0',''),(83,'Fernando','Guzman','staff',0,0,'fernandoguzman@garcontractors.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Lead Technician',0,NULL,'9104 Manassas Dr\nSuite Q\nManassas Park, VA 20111',NULL,'',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-05 19:51:13',NULL,0,'0',''),(84,'Demo Manager','Manager','staff',0,1,'demo@demo.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,NULL,0,'Managerss',0,NULL,'',NULL,'',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-04-09 04:43:17','2019-04-11 20:18:05',1,'0',''),(85,'Client','Demo','client',0,0,'uricoreas@icloud.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,4,NULL,1,'Project',0,'',NULL,NULL,'2027664200',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-04-25 22:45:05','2019-07-02 14:42:15',0,'1','271069'),(90,'aj','test','staff',0,0,'aj@test.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,0,'2019-05-15 18:45:58',0,'test',0,NULL,'aj@test.com','','+12027664200','','0000-00-00','','male',NULL,'',1,1,'2019-05-15 12:11:45','2019-05-15 18:45:25',0,'1','786757'),(91,'Demo','Chaly','client',0,0,'carpenterchaly@gmail.com','e10adc3949ba59abbe56e057f20f883e',NULL,'active',NULL,5,NULL,1,'',0,'',NULL,NULL,'2027664200',NULL,NULL,NULL,'male',NULL,'',1,1,'2019-05-17 13:28:18','2019-05-17 13:39:40',0,'1','384303'),(113,'sams','test','staff',0,0,'salmandds7@gmail.com','98334dbe7aeef40c8e068efb7943bf92',NULL,'active',NULL,0,NULL,0,'developer',0,NULL,'salmandds7@gmail.com','','+917043096067','','0000-00-00','','male',NULL,'',1,1,'2019-05-23 09:46:37','2019-07-01 09:58:14',0,'1','755697'),(114,'Chaly','Romero','staff',0,1,'chaly@garcontractors.com','20a13d12e2b3224fde1dd94bdc86ba42',NULL,'active',NULL,0,'2019-05-28 12:30:10',0,'Owner CEO',0,NULL,'',NULL,'7039292698',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-05-28 12:03:40','2019-06-27 17:26:55',0,'1','998885'),(115,'Demo','Demos','staff',0,1,'cacoreasa@gmail.com','7798c12b7e35e2d27ac55d3b5a63fff3',NULL,'active',NULL,0,NULL,0,'Demo',0,NULL,'',NULL,'2027664200',NULL,NULL,NULL,'male',NULL,NULL,1,1,'2019-05-28 12:04:44',NULL,0,'0','748813');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-23 19:12:44
