-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: localhost    Database: team_web
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `itemname` varchar(64) COLLATE utf8_bin NOT NULL,
  `userid` varchar(64) COLLATE utf8_bin NOT NULL,
  `bizrule` text COLLATE utf8_bin,
  `data` text COLLATE utf8_bin,
  PRIMARY KEY (`itemname`,`userid`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_bin,
  `bizrule` text COLLATE utf8_bin,
  `data` text COLLATE utf8_bin,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_bin NOT NULL,
  `child` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_award`
--

DROP TABLE IF EXISTS `tbl_award`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `award_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `award_date` date DEFAULT NULL,
  `org_from` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_intl` tinyint(1) DEFAULT NULL,
  `is_national` tinyint(1) DEFAULT NULL,
  `is_provincial` tinyint(1) DEFAULT NULL,
  `is_city` tinyint(1) DEFAULT NULL,
  `is_school` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_award_people`
--

DROP TABLE IF EXISTS `tbl_award_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_award_people` (
  `award_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`award_id`,`people_id`),
  KEY `tbl_award_people_ibfk` (`people_id`),
  CONSTRAINT `tbl_award_people_ibfk_1` FOREIGN KEY (`award_id`) REFERENCES `tbl_award` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_award_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_award_teaching`
--

DROP TABLE IF EXISTS `tbl_award_teaching`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_award_teaching` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `award_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `award_date` date DEFAULT NULL,
  `org_from` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_intl` tinyint(1) DEFAULT NULL,
  `is_national` tinyint(1) DEFAULT NULL,
  `is_provincial` tinyint(1) DEFAULT NULL,
  `is_city` tinyint(1) DEFAULT NULL,
  `is_school` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_award_teaching_people`
--

DROP TABLE IF EXISTS `tbl_award_teaching_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_award_teaching_people` (
  `award_teaching_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`award_teaching_id`,`people_id`),
  KEY `tbl_award_teaching_people_ibfk` (`people_id`),
  CONSTRAINT `tbl_award_teaching_people_ibfk_1` FOREIGN KEY (`award_teaching_id`) REFERENCES `tbl_award_teaching` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_award_teaching_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_course`
--

DROP TABLE IF EXISTS `tbl_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '课程名称',
  `description` text COLLATE utf8_bin COMMENT '课程简介',
  `semester` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '开课学期',
  `duration` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '学时',
  `textbook` text COLLATE utf8_bin COMMENT '教材及参考资料',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_course_people`
--

DROP TABLE IF EXISTS `tbl_course_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_course_people` (
  `course_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`course_id`,`people_id`),
  KEY `tbl_course_people_ibfk_2` (`people_id`),
  CONSTRAINT `tbl_course_people_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `tbl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_course_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_migration`
--

DROP TABLE IF EXISTS `tbl_migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_migration` (
  `version` varchar(180) COLLATE utf8_bin NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_paper`
--

DROP TABLE IF EXISTS `tbl_paper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_paper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info` text COLLATE utf8_bin NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `index_number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `pass_date` date DEFAULT NULL,
  `pub_date` date DEFAULT NULL,
  `index_date` date DEFAULT NULL,
  `latest_date` date DEFAULT NULL,
  `sci_number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `ei_number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `istp_number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `file_type` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_content` mediumblob,
  `is_high_level` tinyint(1) NOT NULL DEFAULT '0',
  `maintainer_id` int(11) DEFAULT NULL,
  `last_update_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_paper_ibfk_1` (`maintainer_id`),
  CONSTRAINT `tbl_paper_ibfk_1` FOREIGN KEY (`maintainer_id`) REFERENCES `tbl_people` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=945 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_paper_people`
--

DROP TABLE IF EXISTS `tbl_paper_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_paper_people` (
  `paper_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`paper_id`,`people_id`),
  KEY `tbl_paper_people_ibfk_2` (`people_id`),
  CONSTRAINT `tbl_paper_people_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `tbl_paper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_paper_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_paper_project_achievement`
--

DROP TABLE IF EXISTS `tbl_paper_project_achievement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_paper_project_achievement` (
  `paper_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`paper_id`,`project_id`),
  KEY `tbl_paper_project_ibfk_2` (`project_id`),
  CONSTRAINT `tbl_project_people_achievement_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_project_people_achievement_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `tbl_paper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_paper_project_fund`
--

DROP TABLE IF EXISTS `tbl_paper_project_fund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_paper_project_fund` (
  `paper_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`paper_id`,`project_id`),
  KEY `tbl_paper_project_ibfk_2` (`project_id`),
  CONSTRAINT `tbl_paper_project_fund_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_paper_project_fund_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `tbl_paper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_paper_project_reim`
--

DROP TABLE IF EXISTS `tbl_paper_project_reim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_paper_project_reim` (
  `paper_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`paper_id`,`project_id`),
  KEY `tbl_paper_project_ibfk_2` (`project_id`),
  CONSTRAINT `tbl_paper_project_reim_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_paper_project_reim_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `tbl_paper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_paper_teaching`
--

DROP TABLE IF EXISTS `tbl_paper_teaching`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_paper_teaching` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `pass_date` date DEFAULT NULL,
  `pub_date` date DEFAULT NULL,
  `index_date` date DEFAULT NULL,
  `sci_number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `ei_number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `istp_number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_first_grade` tinyint(1) DEFAULT NULL,
  `is_core` tinyint(1) DEFAULT NULL,
  `other_pub` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_journal` tinyint(1) DEFAULT NULL,
  `is_conference` tinyint(1) DEFAULT NULL,
  `is_intl` tinyint(1) DEFAULT NULL,
  `is_domestic` tinyint(1) DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_high_level` tinyint(1) DEFAULT NULL,
  `maintainer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_paper_teaching_ibfk_1` (`maintainer_id`),
  CONSTRAINT `tbl_paper_teaching_ibfk_1` FOREIGN KEY (`maintainer_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_paper_teaching_people`
--

DROP TABLE IF EXISTS `tbl_paper_teaching_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_paper_teaching_people` (
  `paper_teaching_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`paper_teaching_id`,`people_id`),
  KEY `tbl_paper_teaching_people_ibfk_2` (`people_id`),
  CONSTRAINT `tbl_paper_teaching_people_ibfk_1` FOREIGN KEY (`paper_teaching_id`) REFERENCES `tbl_paper_teaching` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_paper_teaching_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_paper_teaching_project_achievement`
--

DROP TABLE IF EXISTS `tbl_paper_teaching_project_achievement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_paper_teaching_project_achievement` (
  `paper_teaching_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`paper_teaching_id`,`project_id`),
  KEY `tbl_paper_teaching_project_achievement_ibfk_2` (`project_id`),
  CONSTRAINT `tbl_paper_teaching_project_achievement_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_paper_teaching_project_achievement_ibfk_2` FOREIGN KEY (`paper_teaching_id`) REFERENCES `tbl_paper_teaching` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_paper_teaching_project_fund`
--

DROP TABLE IF EXISTS `tbl_paper_teaching_project_fund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_paper_teaching_project_fund` (
  `paper_teaching_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`paper_teaching_id`,`project_id`),
  KEY `tbl_paper_teaching_project_fund_ibfk` (`project_id`),
  CONSTRAINT `tbl_project_project_fund_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_project_project_fund_ibfk_2` FOREIGN KEY (`paper_teaching_id`) REFERENCES `tbl_paper_teaching` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_paper_teaching_project_reim`
--

DROP TABLE IF EXISTS `tbl_paper_teaching_project_reim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_paper_teaching_project_reim` (
  `paper_teaching_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`paper_teaching_id`,`project_id`),
  KEY `tbl_paper_teaching_project_reim_ibfk_2` (`project_id`),
  CONSTRAINT `tbl_project_project_reim_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_project_project_reim_ibfk_2` FOREIGN KEY (`paper_teaching_id`) REFERENCES `tbl_paper_teaching` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_patent`
--

DROP TABLE IF EXISTS `tbl_patent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_patent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin NOT NULL,
  `number` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `app_date` date DEFAULT NULL,
  `auth_date` date DEFAULT NULL,
  `latest_date` date DEFAULT NULL,
  `level` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `file_type` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_content` mediumblob,
  `abstract` text COLLATE utf8_bin,
  `maintainer_id` int(11) DEFAULT NULL,
  `last_update_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maintainer_id` (`maintainer_id`),
  CONSTRAINT `tbl_patent_ibfk_1` FOREIGN KEY (`maintainer_id`) REFERENCES `tbl_people` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=361 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_patent_people`
--

DROP TABLE IF EXISTS `tbl_patent_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_patent_people` (
  `patent_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  PRIMARY KEY (`patent_id`,`people_id`),
  KEY `tbl_patent_people_ibfk_2` (`people_id`),
  CONSTRAINT `tbl_patent_people_ibfk_1` FOREIGN KEY (`patent_id`) REFERENCES `tbl_patent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_patent_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_patent_project_achievement`
--

DROP TABLE IF EXISTS `tbl_patent_project_achievement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_patent_project_achievement` (
  `patent_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`patent_id`,`project_id`),
  KEY `tbl_patent_project_ibfk_2` (`project_id`),
  CONSTRAINT `tbl_patent_project_achievement_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_patent_project_achievement_ibfk_2` FOREIGN KEY (`patent_id`) REFERENCES `tbl_patent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_patent_project_reim`
--

DROP TABLE IF EXISTS `tbl_patent_project_reim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_patent_project_reim` (
  `patent_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`patent_id`,`project_id`),
  KEY `tbl_patent_project_reim_ibfk_2` (`project_id`),
  CONSTRAINT `tbl_patent_project_reim_ibfk_1` FOREIGN KEY (`patent_id`) REFERENCES `tbl_patent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_patent_project_reim_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_people`
--

DROP TABLE IF EXISTS `tbl_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `name_en` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `position` tinyint(4) NOT NULL DEFAULT '0',
  `last_update_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3695 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_project`
--

DROP TABLE IF EXISTS `tbl_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin,
  `number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `fund_number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `deadline_date` date DEFAULT NULL,
  `conclude_date` date DEFAULT NULL,
  `latest_date` date DEFAULT NULL,
  `fund` decimal(11,3) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `level` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `maintainer_id` int(11) DEFAULT NULL,
  `last_update_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maintainer_id` (`maintainer_id`),
  CONSTRAINT `tbl_project_ibfk_1` FOREIGN KEY (`maintainer_id`) REFERENCES `tbl_people` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2129 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_project_people_execute`
--

DROP TABLE IF EXISTS `tbl_project_people_execute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_people_execute` (
  `project_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  PRIMARY KEY (`project_id`,`people_id`),
  KEY `tbl_paper_people_execute_ibfk_2` (`people_id`),
  CONSTRAINT `tbl_project_people_execute_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_project_people_execute_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_project_people_liability`
--

DROP TABLE IF EXISTS `tbl_project_people_liability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_people_liability` (
  `project_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  PRIMARY KEY (`project_id`,`people_id`),
  KEY `tbl_paper_people_liability_ibfk_2` (`people_id`),
  CONSTRAINT `tbl_project_people_liability_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_project_people_liability_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_project_teaching`
--

DROP TABLE IF EXISTS `tbl_project_teaching`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_teaching` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '项目名称',
  `number` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '项目编号',
  `is_intl` tinyint(1) DEFAULT NULL COMMENT '国际',
  `is_provincial` tinyint(1) DEFAULT NULL COMMENT '省部级',
  `is_city` tinyint(1) DEFAULT NULL COMMENT '市级',
  `is_school` tinyint(1) DEFAULT NULL COMMENT '校级',
  `is_quality` tinyint(1) DEFAULT NULL COMMENT '质量工程',
  `is_reform` tinyint(1) DEFAULT NULL COMMENT '教学改革',
  `is_lab` tinyint(1) DEFAULT NULL COMMENT '实验室建设',
  `is_new_lab` tinyint(1) DEFAULT NULL COMMENT '新实验建设',
  `start_date` date DEFAULT NULL COMMENT '开始时间',
  `deadline_date` date DEFAULT NULL COMMENT '截至时间',
  `conclude_date` date DEFAULT NULL COMMENT '结题时间',
  `fund` decimal(15,2) DEFAULT NULL COMMENT '经费',
  `should_display` tinyint(1) DEFAULT NULL COMMENT '对外显示',
  `maintainer_id` int(11) DEFAULT NULL COMMENT '维护人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_project_teaching_people`
--

DROP TABLE IF EXISTS `tbl_project_teaching_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_teaching_people` (
  `project_teaching_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`project_teaching_id`,`people_id`),
  KEY `tbl_project_teaching_people_ibfk` (`people_id`),
  CONSTRAINT `tbl_project_teaching_people_ibfk_1` FOREIGN KEY (`project_teaching_id`) REFERENCES `tbl_project_teaching` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_project_teaching_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_publication`
--

DROP TABLE IF EXISTS `tbl_publication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_publication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info` text COLLATE utf8_bin,
  `press` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `isbn_number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `pub_date` date DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `last_update_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_publication_people`
--

DROP TABLE IF EXISTS `tbl_publication_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_publication_people` (
  `publication_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  PRIMARY KEY (`publication_id`,`people_id`),
  KEY `tbl_publication_people_ibfk` (`people_id`),
  CONSTRAINT `tbl_publication_people_ibfk_1` FOREIGN KEY (`publication_id`) REFERENCES `tbl_publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_publication_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_publication_project_achievement`
--

DROP TABLE IF EXISTS `tbl_publication_project_achievement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_publication_project_achievement` (
  `publication_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`publication_id`,`project_id`),
  KEY `tbl_publication_project_achievement_ibfk_2` (`project_id`),
  CONSTRAINT `tbl_publication_project_achievement_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_publication_project_achievement_ibfk_2` FOREIGN KEY (`publication_id`) REFERENCES `tbl_publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_publication_project_fund`
--

DROP TABLE IF EXISTS `tbl_publication_project_fund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_publication_project_fund` (
  `publication_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`publication_id`,`project_id`),
  KEY `tbl_publication_project_fund_ibfk` (`project_id`),
  CONSTRAINT `tbl_publication_project_fund_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_publication_project_fund_ibfk_2` FOREIGN KEY (`publication_id`) REFERENCES `tbl_publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_publication_project_reim`
--

DROP TABLE IF EXISTS `tbl_publication_project_reim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_publication_project_reim` (
  `publication_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`publication_id`,`project_id`),
  KEY `tbl_publication_project_reim_ibfk_2` (`project_id`),
  CONSTRAINT `tbl_publication_project_reim_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_publication_project_reim_ibfk_2` FOREIGN KEY (`publication_id`) REFERENCES `tbl_publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_software`
--

DROP TABLE IF EXISTS `tbl_software`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_software` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `reg_number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `file_type` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_content` mediumblob,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `maintainer_id` int(11) DEFAULT NULL,
  `last_update_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maintainer_id` (`maintainer_id`),
  CONSTRAINT `tbl_software_ibfk_1` FOREIGN KEY (`maintainer_id`) REFERENCES `tbl_people` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_software_people`
--

DROP TABLE IF EXISTS `tbl_software_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_software_people` (
  `software_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`software_id`,`people_id`),
  KEY `tbl_software_people_ibfk` (`people_id`),
  CONSTRAINT `tbl_software_people_ibfk_1` FOREIGN KEY (`software_id`) REFERENCES `tbl_software` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_software_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_software_project_achievement`
--

DROP TABLE IF EXISTS `tbl_software_project_achievement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_software_project_achievement` (
  `software_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`software_id`,`project_id`),
  KEY `tbl_software_project_ibfk_2` (`project_id`),
  CONSTRAINT `tbl_software_project_achievement_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_software_project_achievement_ibfk_2` FOREIGN KEY (`software_id`) REFERENCES `tbl_software` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_software_project_fund`
--

DROP TABLE IF EXISTS `tbl_software_project_fund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_software_project_fund` (
  `software_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`software_id`,`project_id`),
  KEY `tbl_software_project_ibfk` (`project_id`),
  CONSTRAINT `tbl_software_project_fund_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_software_project_fund_ibfk_2` FOREIGN KEY (`software_id`) REFERENCES `tbl_software` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_software_project_reim`
--

DROP TABLE IF EXISTS `tbl_software_project_reim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_software_project_reim` (
  `software_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`software_id`,`project_id`),
  KEY `tbl_software_project_ibfk` (`project_id`),
  CONSTRAINT `tbl_software_project_reim_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_software_project_reim_ibfk_2` FOREIGN KEY (`software_id`) REFERENCES `tbl_software` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `is_manager` tinyint(1) DEFAULT NULL,
  `is_user` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-28 23:14:38
