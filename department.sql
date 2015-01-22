-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:7777
-- Generation Time: Jan 21, 2015 at 11:28 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `coursentnu`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
`id` int(2) NOT NULL,
  `abbr` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(18, 'CMU', 'SU42', '化學系'),
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `abbr` (`abbr`), ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
MODIFY `id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;