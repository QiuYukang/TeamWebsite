-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-02-18 07:07:32
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `team_web`
--

-- --------------------------------------------------------

--
-- 表的结构 `tbl_paper`
--

CREATE TABLE `tbl_paper` (
  `id` int(11) NOT NULL,
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
  `last_update_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_paper_people`
--

CREATE TABLE `tbl_paper_people` (
  `paper_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_paper_project_achievement`
--

CREATE TABLE `tbl_paper_project_achievement` (
  `paper_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_paper_project_fund`
--

CREATE TABLE `tbl_paper_project_fund` (
  `paper_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_paper_project_reim`
--

CREATE TABLE `tbl_paper_project_reim` (
  `paper_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_patent`
--

CREATE TABLE `tbl_patent` (
  `id` int(11) NOT NULL,
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
  `last_update_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_patent_people`
--

CREATE TABLE `tbl_patent_people` (
  `patent_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_patent_project_achievement`
--

CREATE TABLE `tbl_patent_project_achievement` (
  `patent_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_patent_project_reim`
--

CREATE TABLE `tbl_patent_project_reim` (
  `patent_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_people`
--

CREATE TABLE `tbl_people` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `name_en` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `position` tinyint(4) NOT NULL DEFAULT '0',
  `last_update_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_project`
--

CREATE TABLE `tbl_project` (
  `id` int(11) NOT NULL,
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
  `last_update_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_project_people_execute`
--

CREATE TABLE `tbl_project_people_execute` (
  `project_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_project_people_liability`
--

CREATE TABLE `tbl_project_people_liability` (
  `project_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_publication`
--

CREATE TABLE `tbl_publication` (
  `id` int(11) NOT NULL,
  `info` text COLLATE utf8_bin,
  `press` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `isbn_number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `pub_date` date DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `last_update_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_publication_people`
--

CREATE TABLE `tbl_publication_people` (
  `publication_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_publication_project_achievement`
--

CREATE TABLE `tbl_publication_project_achievement` (
  `publication_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_publication_project_fund`
--

CREATE TABLE `tbl_publication_project_fund` (
  `publication_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_publication_project_reim`
--

CREATE TABLE `tbl_publication_project_reim` (
  `publication_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_software`
--

CREATE TABLE `tbl_software` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `reg_number` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `file_type` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_content` mediumblob,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `maintainer_id` int(11) DEFAULT NULL,
  `last_update_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_software_people`
--

CREATE TABLE `tbl_software_people` (
  `software_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_software_project_achievement`
--

CREATE TABLE `tbl_software_project_achievement` (
  `software_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_software_project_fund`
--

CREATE TABLE `tbl_software_project_fund` (
  `software_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_software_project_reim`
--

CREATE TABLE `tbl_software_project_reim` (
  `software_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `is_manager` tinyint(1) DEFAULT NULL,
  `is_user` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_paper`
--
ALTER TABLE `tbl_paper`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_paper_ibfk_1` (`maintainer_id`);

--
-- Indexes for table `tbl_paper_people`
--
ALTER TABLE `tbl_paper_people`
  ADD PRIMARY KEY (`paper_id`,`people_id`),
  ADD KEY `tbl_paper_people_ibfk_2` (`people_id`);

--
-- Indexes for table `tbl_paper_project_achievement`
--
ALTER TABLE `tbl_paper_project_achievement`
  ADD PRIMARY KEY (`paper_id`,`project_id`),
  ADD KEY `tbl_paper_project_ibfk_2` (`project_id`);

--
-- Indexes for table `tbl_paper_project_fund`
--
ALTER TABLE `tbl_paper_project_fund`
  ADD PRIMARY KEY (`paper_id`,`project_id`),
  ADD KEY `tbl_paper_project_ibfk_2` (`project_id`);

--
-- Indexes for table `tbl_paper_project_reim`
--
ALTER TABLE `tbl_paper_project_reim`
  ADD PRIMARY KEY (`paper_id`,`project_id`),
  ADD KEY `tbl_paper_project_ibfk_2` (`project_id`);

--
-- Indexes for table `tbl_patent`
--
ALTER TABLE `tbl_patent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintainer_id` (`maintainer_id`);

--
-- Indexes for table `tbl_patent_people`
--
ALTER TABLE `tbl_patent_people`
  ADD PRIMARY KEY (`patent_id`,`people_id`),
  ADD KEY `tbl_patent_people_ibfk_2` (`people_id`);

--
-- Indexes for table `tbl_patent_project_achievement`
--
ALTER TABLE `tbl_patent_project_achievement`
  ADD PRIMARY KEY (`patent_id`,`project_id`),
  ADD KEY `tbl_patent_project_ibfk_2` (`project_id`);

--
-- Indexes for table `tbl_patent_project_reim`
--
ALTER TABLE `tbl_patent_project_reim`
  ADD PRIMARY KEY (`patent_id`,`project_id`),
  ADD KEY `tbl_patent_project_reim_ibfk_2` (`project_id`);

--
-- Indexes for table `tbl_people`
--
ALTER TABLE `tbl_people`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_project`
--
ALTER TABLE `tbl_project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintainer_id` (`maintainer_id`);

--
-- Indexes for table `tbl_project_people_execute`
--
ALTER TABLE `tbl_project_people_execute`
  ADD PRIMARY KEY (`project_id`,`people_id`),
  ADD KEY `tbl_paper_people_execute_ibfk_2` (`people_id`);

--
-- Indexes for table `tbl_project_people_liability`
--
ALTER TABLE `tbl_project_people_liability`
  ADD PRIMARY KEY (`project_id`,`people_id`),
  ADD KEY `tbl_paper_people_liability_ibfk_2` (`people_id`);

--
-- Indexes for table `tbl_publication`
--
ALTER TABLE `tbl_publication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_publication_people`
--
ALTER TABLE `tbl_publication_people`
  ADD PRIMARY KEY (`publication_id`,`people_id`),
  ADD KEY `tbl_publication_people_ibfk` (`people_id`);

--
-- Indexes for table `tbl_publication_project_achievement`
--
ALTER TABLE `tbl_publication_project_achievement`
  ADD PRIMARY KEY (`publication_id`,`project_id`),
  ADD KEY `tbl_publication_project_achievement_ibfk_2` (`project_id`);

--
-- Indexes for table `tbl_publication_project_fund`
--
ALTER TABLE `tbl_publication_project_fund`
  ADD PRIMARY KEY (`publication_id`,`project_id`),
  ADD KEY `tbl_publication_project_fund_ibfk` (`project_id`);

--
-- Indexes for table `tbl_publication_project_reim`
--
ALTER TABLE `tbl_publication_project_reim`
  ADD PRIMARY KEY (`publication_id`,`project_id`),
  ADD KEY `tbl_publication_project_reim_ibfk_2` (`project_id`);

--
-- Indexes for table `tbl_software`
--
ALTER TABLE `tbl_software`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintainer_id` (`maintainer_id`);

--
-- Indexes for table `tbl_software_people`
--
ALTER TABLE `tbl_software_people`
  ADD PRIMARY KEY (`software_id`,`people_id`),
  ADD KEY `tbl_software_people_ibfk` (`people_id`);

--
-- Indexes for table `tbl_software_project_achievement`
--
ALTER TABLE `tbl_software_project_achievement`
  ADD PRIMARY KEY (`software_id`,`project_id`),
  ADD KEY `tbl_software_project_ibfk_2` (`project_id`);

--
-- Indexes for table `tbl_software_project_fund`
--
ALTER TABLE `tbl_software_project_fund`
  ADD PRIMARY KEY (`software_id`,`project_id`),
  ADD KEY `tbl_software_project_ibfk` (`project_id`);

--
-- Indexes for table `tbl_software_project_reim`
--
ALTER TABLE `tbl_software_project_reim`
  ADD PRIMARY KEY (`software_id`,`project_id`),
  ADD KEY `tbl_software_project_ibfk` (`project_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tbl_paper`
--
ALTER TABLE `tbl_paper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=945;
--
-- 使用表AUTO_INCREMENT `tbl_patent`
--
ALTER TABLE `tbl_patent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;
--
-- 使用表AUTO_INCREMENT `tbl_people`
--
ALTER TABLE `tbl_people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3695;
--
-- 使用表AUTO_INCREMENT `tbl_project`
--
ALTER TABLE `tbl_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2129;
--
-- 使用表AUTO_INCREMENT `tbl_publication`
--
ALTER TABLE `tbl_publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- 使用表AUTO_INCREMENT `tbl_software`
--
ALTER TABLE `tbl_software`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- 使用表AUTO_INCREMENT `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- 限制导出的表
--

--
-- 限制表 `tbl_paper`
--
ALTER TABLE `tbl_paper`
  ADD CONSTRAINT `tbl_paper_ibfk_1` FOREIGN KEY (`maintainer_id`) REFERENCES `tbl_people` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `tbl_paper_people`
--
ALTER TABLE `tbl_paper_people`
  ADD CONSTRAINT `tbl_paper_people_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `tbl_paper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_paper_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_paper_project_achievement`
--
ALTER TABLE `tbl_paper_project_achievement`
  ADD CONSTRAINT `tbl_project_people_achievement_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_project_people_achievement_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `tbl_paper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_paper_project_fund`
--
ALTER TABLE `tbl_paper_project_fund`
  ADD CONSTRAINT `tbl_paper_project_fund_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_paper_project_fund_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `tbl_paper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_paper_project_reim`
--
ALTER TABLE `tbl_paper_project_reim`
  ADD CONSTRAINT `tbl_paper_project_reim_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_paper_project_reim_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `tbl_paper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_patent`
--
ALTER TABLE `tbl_patent`
  ADD CONSTRAINT `tbl_patent_ibfk_1` FOREIGN KEY (`maintainer_id`) REFERENCES `tbl_people` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `tbl_patent_people`
--
ALTER TABLE `tbl_patent_people`
  ADD CONSTRAINT `tbl_patent_people_ibfk_1` FOREIGN KEY (`patent_id`) REFERENCES `tbl_patent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_patent_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_patent_project_achievement`
--
ALTER TABLE `tbl_patent_project_achievement`
  ADD CONSTRAINT `tbl_patent_project_achievement_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_patent_project_achievement_ibfk_2` FOREIGN KEY (`patent_id`) REFERENCES `tbl_patent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_patent_project_reim`
--
ALTER TABLE `tbl_patent_project_reim`
  ADD CONSTRAINT `tbl_patent_project_reim_ibfk_1` FOREIGN KEY (`patent_id`) REFERENCES `tbl_patent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_patent_project_reim_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_project`
--
ALTER TABLE `tbl_project`
  ADD CONSTRAINT `tbl_project_ibfk_1` FOREIGN KEY (`maintainer_id`) REFERENCES `tbl_people` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `tbl_project_people_execute`
--
ALTER TABLE `tbl_project_people_execute`
  ADD CONSTRAINT `tbl_project_people_execute_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_project_people_execute_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_project_people_liability`
--
ALTER TABLE `tbl_project_people_liability`
  ADD CONSTRAINT `tbl_project_people_liability_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_project_people_liability_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_publication_people`
--
ALTER TABLE `tbl_publication_people`
  ADD CONSTRAINT `tbl_publication_people_ibfk_1` FOREIGN KEY (`publication_id`) REFERENCES `tbl_publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_publication_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_publication_project_achievement`
--
ALTER TABLE `tbl_publication_project_achievement`
  ADD CONSTRAINT `tbl_publication_project_achievement_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_publication_project_achievement_ibfk_2` FOREIGN KEY (`publication_id`) REFERENCES `tbl_publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_publication_project_fund`
--
ALTER TABLE `tbl_publication_project_fund`
  ADD CONSTRAINT `tbl_publication_project_fund_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_publication_project_fund_ibfk_2` FOREIGN KEY (`publication_id`) REFERENCES `tbl_publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_publication_project_reim`
--
ALTER TABLE `tbl_publication_project_reim`
  ADD CONSTRAINT `tbl_publication_project_reim_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_publication_project_reim_ibfk_2` FOREIGN KEY (`publication_id`) REFERENCES `tbl_publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_software`
--
ALTER TABLE `tbl_software`
  ADD CONSTRAINT `tbl_software_ibfk_1` FOREIGN KEY (`maintainer_id`) REFERENCES `tbl_people` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `tbl_software_people`
--
ALTER TABLE `tbl_software_people`
  ADD CONSTRAINT `tbl_software_people_ibfk_1` FOREIGN KEY (`software_id`) REFERENCES `tbl_software` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_software_people_ibfk_2` FOREIGN KEY (`people_id`) REFERENCES `tbl_people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_software_project_achievement`
--
ALTER TABLE `tbl_software_project_achievement`
  ADD CONSTRAINT `tbl_software_project_achievement_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_software_project_achievement_ibfk_2` FOREIGN KEY (`software_id`) REFERENCES `tbl_software` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_software_project_fund`
--
ALTER TABLE `tbl_software_project_fund`
  ADD CONSTRAINT `tbl_software_project_fund_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_software_project_fund_ibfk_2` FOREIGN KEY (`software_id`) REFERENCES `tbl_software` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `tbl_software_project_reim`
--
ALTER TABLE `tbl_software_project_reim`
  ADD CONSTRAINT `tbl_software_project_reim_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_software_project_reim_ibfk_2` FOREIGN KEY (`software_id`) REFERENCES `tbl_software` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
