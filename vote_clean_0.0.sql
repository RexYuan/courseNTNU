-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:7777
-- Generation Time: Jan 22, 2015 at 02:24 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `coursentnu`
--

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
`id` int(30) NOT NULL,
  `fbid` bigint(30) unsigned NOT NULL,
  `code` varchar(10) CHARACTER SET latin1 NOT NULL,
  `vote` tinyint(1) NOT NULL COMMENT '1 for yay 0 for nay',
  `fbName` varchar(10) CHARACTER SET latin1 NOT NULL,
  `fbGender` varchar(10) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
 ADD PRIMARY KEY (`id`), ADD KEY `fbid` (`fbid`,`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
MODIFY `id` int(30) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;