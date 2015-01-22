-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:7777
-- Generation Time: Jan 22, 2015 at 02:23 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `coursentnu`
--

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
`id` int(20) NOT NULL,
  `report` text CHARACTER SET latin1 NOT NULL,
  `fbID` bigint(30) NOT NULL,
  `fbMail` varchar(20) CHARACTER SET latin1 NOT NULL,
  `fbName` varchar(10) CHARACTER SET latin1 NOT NULL,
  `fbGender` varchar(10) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `report`
--
ALTER TABLE `report`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;