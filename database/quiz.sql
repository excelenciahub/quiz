-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.33-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5278
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for quiz
CREATE DATABASE IF NOT EXISTS `quiz` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `quiz`;

-- Dumping structure for table quiz.admin_master
CREATE TABLE IF NOT EXISTS `admin_master` (
  `admin_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(20) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>admin, 2=>teacher',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_ip` varchar(20) NOT NULL,
  `created_by` int(10) NOT NULL,
  `modified_time` datetime NOT NULL,
  `modified_ip` varchar(20) NOT NULL,
  `modified_by` int(10) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table quiz.admin_master: ~3 rows (approximately)
/*!40000 ALTER TABLE `admin_master` DISABLE KEYS */;
INSERT INTO `admin_master` (`admin_id`, `name`, `password`, `email`, `mobile`, `image`, `type`, `status`, `is_delete`, `created_time`, `created_ip`, `created_by`, `modified_time`, `modified_ip`, `modified_by`) VALUES
	(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin@quiz.com', '1234567890', NULL, 1, 1, 0, '2019-03-08 06:18:23', '192.168.30.8', 0, '2019-03-08 06:18:23', '192.168.30.8', 1),
	(2, 'Teacher', 'e10adc3949ba59abbe56e057f20f883e', 'teacher@quiz.com', '1234567890', NULL, 2, 1, 0, '2019-03-08 09:27:07', '192.168.30.8', 1, '2019-03-08 09:27:07', '192.168.30.8', 2);
/*!40000 ALTER TABLE `admin_master` ENABLE KEYS */;

-- Dumping structure for table quiz.options_master
CREATE TABLE IF NOT EXISTS `options_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `option` varchar(250) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT '0' COMMENT '0=> No, 1=>Yes',
  `que_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table quiz.options_master: ~0 rows (approximately)
/*!40000 ALTER TABLE `options_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `options_master` ENABLE KEYS */;

-- Dumping structure for table quiz.questions_master
CREATE TABLE IF NOT EXISTS `questions_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `question` varchar(250) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `admin_id` int(10) DEFAULT NULL,
  `test_id` int(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_ip` varchar(20) NOT NULL,
  `created_by` int(10) NOT NULL,
  `modified_time` datetime NOT NULL,
  `modified_ip` varchar(20) NOT NULL,
  `modified_by` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table quiz.questions_master: ~0 rows (approximately)
/*!40000 ALTER TABLE `questions_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `questions_master` ENABLE KEYS */;

-- Dumping structure for table quiz.tests_master
CREATE TABLE IF NOT EXISTS `tests_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `test_name` varchar(250) DEFAULT NULL,
  `admin_id` int(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_ip` varchar(20) NOT NULL,
  `created_by` int(10) NOT NULL,
  `modified_time` datetime NOT NULL,
  `modified_ip` varchar(20) NOT NULL,
  `modified_by` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table quiz.tests_master: ~0 rows (approximately)
/*!40000 ALTER TABLE `tests_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `tests_master` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
