-- MySQL dump 10.13  Distrib 5.6.22, for osx10.10 (x86_64)
--
-- Host: localhost    Database: poll
-- ------------------------------------------------------
-- Server version	5.6.22

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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `cmt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `t_id` int(10) unsigned DEFAULT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`cmt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coursename` varchar(20) DEFAULT NULL,
  `t_id` int(10) unsigned DEFAULT NULL,
  `getflowers` int(10) DEFAULT '0',
  `geteggs` int(10) DEFAULT '0',
  `grade_1` int(2) DEFAULT '0',
  `grade_2` int(2) DEFAULT '0',
  `grade_3` int(2) DEFAULT '0',
  `grade_4` int(2) DEFAULT '0',
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `deadline`
--

DROP TABLE IF EXISTS `deadline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deadline` (
  `dl_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vote_dl` datetime DEFAULT CURRENT_TIMESTAMP,
  `iscurrent` int(2) DEFAULT '0',
  `istohistory` int(2) DEFAULT '0',
  `starttime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `historyCourse`
--

DROP TABLE IF EXISTS `historyCourse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historyCourse` (
  `hc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_id` int(10) unsigned DEFAULT NULL,
  `cs_flower` int(10) unsigned DEFAULT '0',
  `cs_egg` int(10) unsigned DEFAULT '0',
  `vote_dl` datetime DEFAULT CURRENT_TIMESTAMP,
  `t_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`hc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `historyTch`
--

DROP TABLE IF EXISTS `historyTch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historyTch` (
  `ht_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `t_id` int(10) unsigned DEFAULT NULL,
  `tch_flower` int(10) unsigned DEFAULT '0',
  `tch_egg` int(10) unsigned DEFAULT '0',
  `vote_dl` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ht_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `historycomments`
--

DROP TABLE IF EXISTS `historycomments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historycomments` (
  `hcmt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `t_id` int(10) unsigned DEFAULT NULL,
  `comment` text,
  `vote_dl` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hcmt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pollers`
--

DROP TABLE IF EXISTS `pollers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pollers` (
  `u_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `pwd` varchar(50) DEFAULT NULL,
  `flowernum` int(10) DEFAULT '10',
  `eggnum` int(10) DEFAULT '5',
  `voted` int(2) DEFAULT '0',
  PRIMARY KEY (`u_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stucourses`
--

DROP TABLE IF EXISTS `stucourses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stucourses` (
  `sc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `u_id` int(10) unsigned DEFAULT NULL,
  `c_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`sc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers` (
  `t_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `teachername` varchar(255) DEFAULT NULL,
  `imgurl` varchar(255) DEFAULT NULL,
  `getflowers` int(10) DEFAULT '0',
  `geteggs` int(10) DEFAULT '0',
  `aboutVoter` text NOT NULL,
  PRIMARY KEY (`t_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-31 21:00:21
