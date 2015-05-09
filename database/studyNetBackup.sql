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
INSERT INTO `ClassEnroll` VALUES (1,'ACCT',1004),(1,'ACCT',1234),(1,'ACCT',1334),(1,'ARHS',1003),(1,'BIOL',1301),(1,'BIOL',3524),(1,'CELL',2143),(1,'CHEM',3452),(3,'EDU',2315),(4,'ADPR',2345);
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
INSERT INTO `Classes` VALUES ('ACCT',1234,'05:00 PM','Now ','Working'),('ACCT',1234,'09:00 AM','Who','CARES'),('ACCT',1234,'09:10 AM','Whooo','Cares'),('ACCT',1234,'09:30 AM','Test','Prof'),('ADPR',2345,'10:00 AM','Again','Not'),('BLI',3324,'09:10 AM','Trying','Profs'),('BLI',3324,'11:00 AM','Nice','Try'),('EDU',2315,'09:20 AM','Mac','What');
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
INSERT INTO `GroupEnroll` VALUES (3,0,'admin',0),(3,1,'member',0),(3,3,'admin',1),(4,0,'member',0),(4,1,'admin',1),(4,2,'admin',1),(5,0,'member',0),(5,4,'admin',1),(6,0,'member',0),(6,3,'member',1);
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
INSERT INTO `OrgEnroll` VALUES (1,0,0),(1,1,1),(1,2,0),(1,3,1),(1,4,0),(1,5,0),(1,6,1),(1,7,1),(3,8,1),(4,9,1),(5,10,1),(6,11,1);
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
INSERT INTO `Organizations` VALUES (0,'Merp'),(1,'Band'),(2,'Error'),(3,'This'),(4,'Trying'),(5,'Hello'),(6,'Alpha'),(7,'Eric'),(8,'Wizardry'),(9,'Football'),(10,'Alpha Chi Omega'),(11,'Avenging');
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
INSERT INTO `StudyGroups` VALUES (0,'EDU',2315,3,'Let\'s Learn','09:10 PM','A Place',0,0),(1,'ACCT',1234,4,'This','08:30 PM','Whatever',-1,1),(2,'BLI',3324,4,'What','10:00 PM','Now',1,1),(3,'BIOL',3234,3,'That','08:00 AM','Test',2,1),(4,'CHEM',2344,5,'Than','10:00 PM','Trying',1,1);
/*!40000 ALTER TABLE `StudyGroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `f_name` varchar(30) NOT NULL DEFAULT '',
  `l_name` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `passwd` varchar(64) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`f_name`,`l_name`,`email`,`passwd`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
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

-- Dump completed on 2015-05-09  3:39:05
