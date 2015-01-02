-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 27, 2014 at 12:16 PM
-- Server version: 5.5.32-MariaDB
-- PHP Version: 5.5.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `coursentnu`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `abbr` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `abbr` (`abbr`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `abbr`, `code`, `name`) VALUES
(1, '01U', 'AAAA', '藝術與美感'),
(2, '02U', 'BBBB', '哲學思維與道德推理'),
(3, '03U', 'CCCC', '公民素養與社會探究'),
(4, '04U', 'DDDD', '歷史與文化'),
(5, '05U', 'EEEE', '數學與科學思維'),
(6, '06U', 'FFFF', '科學與生命'),
(7, '0AU', 'GGGG', '一般通識'),
(8, '0HU', 'HHHH', '一般通識'),
(9, '0NU', 'IIII', '一般通識'),
(10, '0SU', 'JJJJ', '一般通識'),
(11, 'AEU', 'HU75', '電機工程學系'),
(12, 'ATU', 'TU60', '美術學系'),
(13, 'BAU', 'OU57', '企業管理學士學位學程'),
(14, 'BIU', 'SU43', '生命科學系'),
(15, 'CEU', 'EU07', '公民教育與活動領導學系'),
(16, 'CHU', 'LU20', '國文學系'),
(17, 'CLU', 'IU84', '華語文教學系'),
(18, 'CMC', 'SU42', '化學系'),
(19, 'CSU', 'SU47', '資訊工程學系'),
(20, 'EAU', 'IU83', '東亞學系'),
(21, 'EDU', 'EU00', '教育學系'),
(22, 'ENU', 'LU21', '英語學系'),
(23, 'ESU', 'SU44', '地球科學系'),
(24, 'FPU', 'AU32', '運動競技學系'),
(25, 'GCU', 'HU72', '圖文傳播學系'),
(26, 'GEU', 'LU23', '地理學系'),
(27, 'HEU', 'EU05', '健康促進與衛生教育學系'),
(28, 'HGU', 'EU06', '人類發展與家庭學系'),
(29, 'HIU', 'LU22', '歷史學系'),
(30, 'IEU', 'HU70', '工業教育學系'),
(31, 'ITU', 'HU71', '科技應用與人力資源發展學系'),
(32, 'MAU', 'SU40', '數學系'),
(33, 'MTU', 'HU73', '機電科技學系'),
(34, 'MUU', 'MU90', '音樂學系'),
(35, 'PCU', 'EU01', '教育心理與輔導學系'),
(36, 'PEU', 'AU30', '體育學系'),
(37, 'PHU', 'SU41', '物理系'),
(38, 'SOU', 'EU02', '社會教育學系'),
(39, 'SPU', 'EU09', '特殊教育學系'),
(40, 'TCU', 'LU26', '臺灣語文學系'),
(41, 'TSU', 'IU85', '應用華語文學系'),
(42, 'VDU', 'TU68', '設計學系');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
