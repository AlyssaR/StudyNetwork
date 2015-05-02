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
  `dept` varchar(6) NOT NULL DEFAULT '',
  `class_num` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`dept`,`class_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ClassEnroll`
--

LOCK TABLES `ClassEnroll` WRITE;
/*!40000 ALTER TABLE `ClassEnroll` DISABLE KEYS */;
INSERT INTO `ClassEnroll` VALUES (1,'ACCT',1004),(1,'ACCT',1234),(1,'ACCT',1334),(1,'ARHS',1003),(1,'BIOL',1301),(1,'BIOL',3524),(1,'CELL',2143),(1,'CHEM',3452);
/*!40000 ALTER TABLE `ClassEnroll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Classes`
--

DROP TABLE IF EXISTS `Classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Classes` (
  `dept` varchar(6) NOT NULL DEFAULT '',
  `class_num` int(11) NOT NULL DEFAULT '0',
  `time2` varchar(10) NOT NULL DEFAULT '',
  `profFirst` varchar(30) NOT NULL DEFAULT '',
  `profLast` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`dept`,`class_num`,`time2`,`profFirst`,`profLast`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Classes`
--

LOCK TABLES `Classes` WRITE;
/*!40000 ALTER TABLE `Classes` DISABLE KEYS */;
INSERT INTO `Classes` VALUES ('ACCT',1234,'09:30 AM','Test','Prof');
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
INSERT INTO `GroupEnroll` VALUES (1,0,'admin',0),(1,1,'admin',0),(1,2,'admin',0),(1,3,'admin',0),(1,4,'admin',0),(1,5,'admin',1),(1,6,'admin',0),(1,7,'admin',0),(1,8,'admin',0),(1,9,'admin',0),(1,10,'admin',0),(1,11,'admin',1),(1,12,'admin',1);
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
  `orgid` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`uid`,`orgid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OrgEnroll`
--

LOCK TABLES `OrgEnroll` WRITE;
/*!40000 ALTER TABLE `OrgEnroll` DISABLE KEYS */;
INSERT INTO `OrgEnroll` VALUES (1,0,0),(1,1,1),(1,2,0),(1,3,1),(1,4,0),(1,5,0),(1,6,1),(1,7,1);
/*!40000 ALTER TABLE `OrgEnroll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Organizations`
--

DROP TABLE IF EXISTS `Organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Organizations` (
  `orgid` int(11) NOT NULL,
  `org_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`orgid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Organizations`
--

LOCK TABLES `Organizations` WRITE;
/*!40000 ALTER TABLE `Organizations` DISABLE KEYS */;
INSERT INTO `Organizations` VALUES (0,'Merp'),(1,'Band'),(2,'Error'),(3,'This'),(4,'Trying'),(5,'Hello'),(6,'Alpha'),(7,'Eric');
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
  `dept` varchar(6) DEFAULT NULL,
  `class_num` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `gname` varchar(40) DEFAULT NULL,
  `time1` varchar(10) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'Tom','Brady','tbrady@smu.edu','patriots',NULL),(2,'Quincy','Schurr','qschurr@smu.edu','qrstuvwx',NULL),(3,'Harry','Potter','hpotter@smu.edu','hogwarts',1);
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

-- Dump completed on 2015-05-02  5:13:11
