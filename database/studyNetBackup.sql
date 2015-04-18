-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: StudyNetwork
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.12.04.1

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
-- Table structure for table `ClassEnroll`
--

DROP TABLE IF EXISTS `ClassEnroll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ClassEnroll` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `cid` varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`,`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ClassEnroll`
--

LOCK TABLES `ClassEnroll` WRITE;
/*!40000 ALTER TABLE `ClassEnroll` DISABLE KEYS */;
/*!40000 ALTER TABLE `ClassEnroll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Classes`
--

DROP TABLE IF EXISTS `Classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Classes` (
  `dept` varchar(6) DEFAULT NULL,
  `class_num` int(11) DEFAULT NULL,
  `cid` varchar(12) DEFAULT NULL,
  `time2` time DEFAULT NULL,
  `professor` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Classes`
--

LOCK TABLES `Classes` WRITE;
/*!40000 ALTER TABLE `Classes` DISABLE KEYS */;
/*!40000 ALTER TABLE `Classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GroupEnroll`
--

DROP TABLE IF EXISTS `GroupEnroll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GroupEnroll` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `gid` int(11) NOT NULL DEFAULT '0',
  `role` varchar(30) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`uid`,`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GroupEnroll`
--

LOCK TABLES `GroupEnroll` WRITE;
/*!40000 ALTER TABLE `GroupEnroll` DISABLE KEYS */;
INSERT INTO `GroupEnroll` VALUES (1,1,'admin',0),(1,2,'admin',0),(1,3,'admin',1),(1,4,'admin',1),(1,5,'admin',1),(1,6,'admin',1),(1,7,'admin',0),(1,8,'admin',1),(1,9,'admin',1),(1,10,'admin',0),(1,11,'admin',1);
/*!40000 ALTER TABLE `GroupEnroll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OrgEnroll`
--

DROP TABLE IF EXISTS `OrgEnroll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OrgEnroll` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `oid` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`uid`,`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OrgEnroll`
--

LOCK TABLES `OrgEnroll` WRITE;
/*!40000 ALTER TABLE `OrgEnroll` DISABLE KEYS */;
/*!40000 ALTER TABLE `OrgEnroll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Organizations`
--

DROP TABLE IF EXISTS `Organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Organizations` (
  `oid` int(11) NOT NULL,
  `org_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Organizations`
--

LOCK TABLES `Organizations` WRITE;
/*!40000 ALTER TABLE `Organizations` DISABLE KEYS */;
/*!40000 ALTER TABLE `Organizations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StudyGroups`
--

DROP TABLE IF EXISTS `StudyGroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StudyGroups` (
  `gid` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `gname` varchar(40) DEFAULT NULL,
  `time1` time DEFAULT NULL,
  `loc` varchar(40) DEFAULT NULL,
  `num_members` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StudyGroups`
--

LOCK TABLES `StudyGroups` WRITE;
/*!40000 ALTER TABLE `StudyGroups` DISABLE KEYS */;
INSERT INTO `StudyGroups` VALUES (0,NULL,1,'no','18:00:00','lower',1,NULL),(1,NULL,1,'Testing','08:20:00','Somewhere',1,1),(2,NULL,1,'My Group','08:45:00',' Someplace',1,1),(3,NULL,1,'TestTime','22:00:00','Brew',1,1),(4,NULL,1,'TryAgain','09:00:00','Again!',23,1),(5,NULL,1,'Keep Deleting','09:30:00','Who that',1,1),(6,NULL,1,'Try Some','10:45:00','Thing Else',1,1),(7,NULL,1,'','00:00:00','',1,1),(8,NULL,1,'','00:00:00','',1,1),(9,NULL,1,'My Test','00:00:00','Cool',1,1),(10,NULL,1,'','00:00:00','',1,1),(11,NULL,1,'Yeah','20:00:00','Testing Testing 123',1,1);
/*!40000 ALTER TABLE `StudyGroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(30) DEFAULT NULL,
  `l_name` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `passwd` varchar(64) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'Tom','Brady','tbrady@smu.edu','patriots',NULL),(2,'Quincy','Schurr','qschurr@smu.edu','qrstuvwx',NULL);
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-18 18:07:09
