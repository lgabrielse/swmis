-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 05, 2014 at 03:27 PM
-- Server version: 5.6.12
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bethany`
--
CREATE DATABASE IF NOT EXISTS `bethany` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `bethany`;

-- --------------------------------------------------------

--
-- Table structure for table `aaa`
--

CREATE TABLE IF NOT EXISTS `aaa` (
  `id` int(11) NOT NULL,
  `tstnum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `city_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `development`
--

CREATE TABLE IF NOT EXISTS `development` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `MenuMain` int(10) NOT NULL,
  `MenuSub1` int(10) NOT NULL,
  `MenuiSub2` int(10) NOT NULL,
  `Priority` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Status` text COLLATE utf8_unicode_ci NOT NULL,
  `AssignedTo` text COLLATE utf8_unicode_ci NOT NULL,
  `Summary` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci NOT NULL,
  `EntryBy` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `EntryDt` date NOT NULL,
  `Comments` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `developmenthistory`
--

CREATE TABLE IF NOT EXISTS `developmenthistory` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `DevDocId` int(11) NOT NULL,
  `MenuMain` int(10) NOT NULL,
  `MenuSub1` int(10) NOT NULL,
  `MenuiSub2` int(10) NOT NULL,
  `Priority` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Status` text COLLATE utf8_unicode_ci NOT NULL,
  `AssignedTo` text COLLATE utf8_unicode_ci NOT NULL,
  `Summary` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci NOT NULL,
  `EntryBy` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `EntryDt` date NOT NULL,
  `Comments` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dropdownlist`
--

CREATE TABLE IF NOT EXISTS `dropdownlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list` text COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `seq` int(11) DEFAULT NULL,
  `entrydt` datetime NOT NULL,
  `entryby` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=102 ;

--
-- Dumping data for table `dropdownlist`
--

INSERT INTO `dropdownlist` (`id`, `list`, `name`, `seq`, `entrydt`, `entryby`) VALUES
(1, 'list', 'dept', 5, '2013-12-02 12:12:00', 'leng'),
(6, 'dept', 'Pharm', 4, '2013-12-02 12:12:00', 'leng'),
(8, 'dept', 'Surgery', 8, '2013-12-02 12:12:00', 'leng'),
(9, 'labsection', 'hematology', 3, '2013-12-02 12:12:00', 'leng'),
(10, 'list', 'labsection', 11, '2013-12-02 12:12:00', 'leng'),
(12, 'labsection', 'chemistry', 2, '2013-12-02 12:12:00', 'leng'),
(16, 'dept', 'Laboratory', 3, '2013-12-02 12:12:00', 'leng'),
(17, 'dept', 'Physiotherapy', 7, '2013-12-02 12:12:00', 'leng'),
(18, 'dept', 'Records', 1, '2013-12-02 12:12:00', 'leng'),
(19, 'dept', 'OutPatient', 2, '2013-12-02 12:12:00', 'leng'),
(20, 'labsection', 'microbiology', 5, '2013-12-02 12:12:00', 'leng'),
(21, 'labsection', 'urinalysis', 4, '0000-00-00 00:00:00', ''),
(22, 'labsection', 'bloodbank', 6, '0000-00-00 00:00:00', ''),
(23, 'labsection', 'otherlab', 8, '0000-00-00 00:00:00', ''),
(24, 'list', 'opdsection', 8, '0000-00-00 00:00:00', ''),
(25, 'opdsection', 'Records', 1, '0000-00-00 00:00:00', ''),
(26, 'list', 'Urine Color', 55, '0000-00-00 00:00:00', ''),
(27, 'Urine Color', 'Pale Yellow', 1, '0000-00-00 00:00:00', ''),
(28, 'Urine Color', 'Pale Yellow', 2, '0000-00-00 00:00:00', ''),
(29, 'Urine Color', 'Dark Yellow', 3, '0000-00-00 00:00:00', ''),
(30, 'Urine Color', 'Orange', 4, '0000-00-00 00:00:00', ''),
(31, 'Urine Color', 'Brown', 5, '0000-00-00 00:00:00', ''),
(32, 'Urine Color', 'Green', 6, '0000-00-00 00:00:00', ''),
(33, 'Urine Color', 'See Comments', 7, '0000-00-00 00:00:00', ''),
(34, 'list', 'Urine Clarity', 56, '0000-00-00 00:00:00', ''),
(35, 'Urine Clarity', 'Clear', 1, '0000-00-00 00:00:00', ''),
(36, 'Urine Clarity', 'Turbid', 4, '0000-00-00 00:00:00', ''),
(37, 'Urine Clarity', 'Milky', 3, '0000-00-00 00:00:00', ''),
(38, 'Urine Clarity', 'Cloudy', 2, '0000-00-00 00:00:00', ''),
(39, 'list', 'Urine Glucose', 57, '0000-00-00 00:00:00', ''),
(40, 'Urine Glucose', 'Negative', 1, '0000-00-00 00:00:00', ''),
(41, 'Urine Glucose', '+', 2, '0000-00-00 00:00:00', ''),
(42, 'Urine Glucose', '++', 3, '0000-00-00 00:00:00', ''),
(43, 'Urine Glucose', '+++', 4, '0000-00-00 00:00:00', ''),
(44, 'Urine Glucose', '++++', 5, '0000-00-00 00:00:00', ''),
(45, 'list', 'Urine Protein', 58, '0000-00-00 00:00:00', ''),
(46, 'Urine Protein', 'Negative', 1, '0000-00-00 00:00:00', ''),
(47, 'Urine Protein', '+', 2, '0000-00-00 00:00:00', ''),
(48, 'Urine Protein', '++', 3, '0000-00-00 00:00:00', ''),
(49, 'Urine Protein', '+++', 4, '0000-00-00 00:00:00', ''),
(50, 'Urine Protein', '++++', 5, '0000-00-00 00:00:00', ''),
(51, 'list', 'Blood Group', 30, '0000-00-00 00:00:00', ''),
(52, 'Blood Group', 'O POS', 1, '0000-00-00 00:00:00', ''),
(53, 'Blood Group', 'A POS', 2, '0000-00-00 00:00:00', ''),
(54, 'Blood Group', 'B POS', 3, '0000-00-00 00:00:00', ''),
(55, 'Blood Group', 'AB POS', 4, '0000-00-00 00:00:00', ''),
(56, 'Blood Group', 'O NEG', 5, '0000-00-00 00:00:00', ''),
(57, 'Blood Group', 'A NEG', 6, '0000-00-00 00:00:00', ''),
(58, 'Blood Group', 'B NEG', 7, '0000-00-00 00:00:00', ''),
(59, 'Blood Group', 'AB NEG', 8, '0000-00-00 00:00:00', ''),
(60, 'list', 'Stool Micro', 20, '0000-00-00 00:00:00', ''),
(61, 'Stool Micro', 'See Order Comments', 3, '0000-00-00 00:00:00', ''),
(62, 'list', 'Urine WBCs', 61, '0000-00-00 00:00:00', ''),
(63, 'list', 'Urine RBCs', 63, '0000-00-00 00:00:00', ''),
(64, 'list', 'Urine Casts', 64, '0000-00-00 00:00:00', ''),
(65, 'list', 'Urine Parasites', 66, '0000-00-00 00:00:00', ''),
(66, 'Urine WBCs', '0 - 5', 2, '0000-00-00 00:00:00', ''),
(67, 'Urine WBCs', 'None', 1, '0000-00-00 00:00:00', ''),
(68, 'Urine WBCs', '5 - 20', 3, '0000-00-00 00:00:00', ''),
(69, 'Urine WBCs', '20 - 100', 4, '0000-00-00 00:00:00', ''),
(70, 'Urine WBCs', '>100', 5, '0000-00-00 00:00:00', ''),
(71, 'Urine RBCs', 'None', 1, '0000-00-00 00:00:00', ''),
(72, 'Urine RBCs', '0 - 5', 2, '0000-00-00 00:00:00', ''),
(73, 'Urine RBCs', '5 - 20', 2, '0000-00-00 00:00:00', ''),
(74, 'Urine RBCs', '20-100', 3, '0000-00-00 00:00:00', ''),
(75, 'Urine RBCs', '>100', 5, '0000-00-00 00:00:00', ''),
(76, 'Urine Parasites', 'None', 1, '0000-00-00 00:00:00', ''),
(77, 'Urine Parasites', 'See Order Comments', 2, '0000-00-00 00:00:00', ''),
(78, 'Urine Casts', 'None', 1, '0000-00-00 00:00:00', ''),
(79, 'Urine Casts', 'See Order Comments', 2, '0000-00-00 00:00:00', ''),
(80, 'Urine Casts', '0 - 5 Hyaline', 6, '0000-00-00 00:00:00', ''),
(81, 'Urine Casts', '5 - 20 Hyaline', 7, '0000-00-00 00:00:00', ''),
(82, 'Urine Casts', '20 - 100 Hyaline', 8, '0000-00-00 00:00:00', ''),
(83, 'Urine Casts', '>100 Hyaline', 9, '0000-00-00 00:00:00', ''),
(84, 'Urine Casts', '0 - 5 WBC', 11, '0000-00-00 00:00:00', ''),
(85, 'Urine Casts', '5 - 20 WBC', 12, '0000-00-00 00:00:00', ''),
(86, 'Urine Casts', '20 - 100 WBC', 13, '0000-00-00 00:00:00', ''),
(87, 'Urine Casts', '>100 WBC', 14, '0000-00-00 00:00:00', ''),
(88, 'list', 'RBC Morphology', 40, '0000-00-00 00:00:00', ''),
(89, 'RBC Morphology', 'Normal', 1, '0000-00-00 00:00:00', ''),
(90, 'RBC Morphology', 'See Order Comments', 2, '0000-00-00 00:00:00', ''),
(91, 'list', 'Ethnic Group', 2, '0000-00-00 00:00:00', ''),
(92, 'Ethnic Group', 'Tiv', 1, '0000-00-00 00:00:00', ''),
(93, 'Ethnic Group', 'Yoroba', 2, '0000-00-00 00:00:00', ''),
(94, 'Ethnic Group', 'Idoma', 4, '0000-00-00 00:00:00', ''),
(95, 'Ethnic Group', 'Hausa', 6, '0000-00-00 00:00:00', ''),
(96, 'Ethnic Group', 'Ibo', 8, '0000-00-00 00:00:00', ''),
(97, 'Ethnic Group', 'European', 21, '0000-00-00 00:00:00', ''),
(98, 'Ethnic Group', 'American', 23, '0000-00-00 00:00:00', ''),
(99, 'Ethnic Group', 'Asian', 25, '0000-00-00 00:00:00', ''),
(100, 'list', 'Rate', 3, '0000-00-00 00:00:00', ''),
(101, 'Stool Micro', 'Normal', 1, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `fee`
--

CREATE TABLE IF NOT EXISTS `fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dept` text COLLATE utf8_unicode_ci NOT NULL,
  `section` text COLLATE utf8_unicode_ci,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `unit` text COLLATE utf8_unicode_ci,
  `descr` text COLLATE utf8_unicode_ci,
  `specid` int(11) NOT NULL,
  `fee` int(11) NOT NULL,
  `entryby` text COLLATE utf8_unicode_ci NOT NULL,
  `entrydt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `fee`
--

INSERT INTO `fee` (`id`, `dept`, `section`, `name`, `unit`, `descr`, `specid`, `fee`, `entryby`, `entrydt`) VALUES
(1, 'Laboratory', 'hematology', 'CBC', 'each', 'Complete Blood Count', 1, 400, 'leng', '2013-12-19 13:35:51'),
(2, 'Laboratory', 'hematology', 'WBC', 'each', 'White Blood Cell Count', 7, 200, 'leng', '2013-12-17 18:08:56'),
(3, 'Laboratory', 'hematology', 'Platelet Count', 'each', 'Platelet Count', 7, 300, 'leng', '2013-12-17 18:09:04'),
(4, 'Laboratory', 'chemistry', 'Glucose', 'each', 'Blood Sugar', 7, 200, 'leng', '2013-12-17 18:09:17'),
(5, 'Laboratory', 'chemistry', 'Sodium', 'each', 'Sodium', 5, 400, 'leng', '2013-12-17 18:09:26'),
(6, 'Laboratory', 'chemistry', 'Potassium', 'each', 'Potassium', 5, 400, 'leng', '2013-12-17 18:09:37'),
(7, 'Laboratory', 'chemistry', 'Chloride', 'each', 'Chloride', 5, 400, 'leng', '2013-12-17 18:09:45'),
(8, 'Laboratory', 'chemistry', 'CO2', 'each', 'Carbon Dioxide', 5, 400, 'leng', '2013-12-17 18:09:56'),
(9, 'Laboratory', 'chemistry', 'Electrolytes', 'panel', ' Electrolytes', 5, 1000, 'leng', '2013-12-17 18:10:04'),
(10, 'Laboratory', 'urinalysis', 'Urinalysis', 'panel', 'Urinalysis', 3, 800, 'leng', '2013-12-17 18:10:12'),
(11, 'Laboratory', 'urinalysis', 'Urine Chem', 'panel', 'Urine Chemistry:  Gluc, pH, Ketone, Hgb, WBCs', 3, 400, 'leng', '2013-12-17 18:10:20'),
(12, 'Laboratory', 'urinalysis', 'Urine Micro', 'Panel', 'Urine micro: RBC, WBC, casts, crystals, parasites', 3, 400, 'leng', '2014-01-06 10:23:22'),
(13, 'Laboratory', 'microbiology', 'Urine Culture', 'each', 'Urine Culture and Organism ID', 10, 1200, 'leng', '2014-01-06 11:40:55'),
(14, 'Laboratory', 'microbiology', 'Blood Culture', 'each', 'Blood Culture', 5, 2000, 'leng', '2014-01-02 16:46:27'),
(15, 'Laboratory', 'bloodbank', 'Blood Grouping', 'each', 'Blood Grouping: ABO & Rh', 5, 800, 'L.GABRIELSE', '2014-02-20 20:22:25'),
(16, 'Laboratory', 'bloodbank', 'Crossmatch', 'each', 'Crossmatch with one unit of blood', 5, 800, 'leng', '2013-12-17 18:49:29'),
(17, 'Laboratory', 'bloodbank', 'Unit of Blood', 'each', 'Unit of BLood', 8, 1600, 'leng', '2013-12-17 18:52:00'),
(18, 'Laboratory', 'otherlab', 'Stool Micro', 'each', 'Stool Microscopic exam', 4, 400, 'leng', '2013-12-17 18:50:00'),
(19, 'OutPatient', 'Records', 'Initial Registration', 'each', 'Initial Registration', 8, 200, 'leng', '2013-12-17 18:52:10'),
(20, 'OutPatient', 'Records', 'Visit', 'each', 'Visit', 8, 600, 'leng', '2013-12-17 18:52:29'),
(22, 'Laboratory', 'chemistry', 'SGOT', 'each', 'SGOT', 5, 500, 'leng', '2013-12-19 13:32:55'),
(24, 'Laboratory', 'hematology', 'Hematocrit', 'each', 'Blood Hematocrit', 7, 160, 'leng', '2014-01-02 16:30:12'),
(25, 'Laboratory', 'hematology', 'Differential WBC', 'each', 'White Blood Cell Differential Count', 1, 1000, 'leng', '2014-01-03 10:11:34'),
(26, 'Laboratory', 'otherlab', 'normvalues', 'each', 'test normalvalues', 8, 0, 'leng', '2014-01-08 12:59:06'),
(27, 'Laboratory', 'microbiology', 'Urine Sensitivity', 'each', 'Urine Organism Sensitivity', 11, 1600, 'leng', '2014-01-06 11:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `menu_main`
--

CREATE TABLE IF NOT EXISTS `menu_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `m_seq` int(11) NOT NULL,
  `m_permit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `m_link` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `menu_main`
--

INSERT INTO `menu_main` (`id`, `m_name`, `m_seq`, `m_permit`, `m_link`) VALUES
(1, 'Home', 1, 'A', '../Home/index.php'),
(2, 'Patient', 2, 'B', ''),
(3, 'Cashier', 3, 'C', ''),
(4, 'Laboratory', 4, 'D', ''),
(5, 'Admin', 7, 'G', ''),
(6, 'Other', 9, 'I', '../BethanyProject/bpusers.php'),
(7, 'Pharmacy', 5, 'E', ''),
(8, 'Reports', 6, 'H', '');

-- --------------------------------------------------------

--
-- Table structure for table `menu_sub1`
--

CREATE TABLE IF NOT EXISTS `menu_sub1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_id` int(11) NOT NULL,
  `s1_name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `s1_seq` int(11) NOT NULL,
  `s1_permit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `s1_link` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `menu_sub1`
--

INSERT INTO `menu_sub1` (`id`, `m_id`, `s1_name`, `s1_seq`, `s1_permit`, `s1_link`) VALUES
(1, 2, 'Patient Search', 1, 'B1', '../Patient/PatSearch.php'),
(2, 2, 'Add New Patient', 2, 'B2', '../Patient/PatPermAdd.php'),
(3, 2, 'Medical History', 3, 'B3', ''),
(4, 2, 'Add Document', 4, 'B4', ''),
(5, 3, 'Recieve Payment', 1, 'C1', '../patient/cashsearch.php'),
(6, 3, 'Receipts Report', 2, 'C2', '../patient/cashreceipts.php'),
(7, 4, 'Collection', 1, 'D1', '../Lab/LabSearchPat.php'),
(8, 4, 'Result Entry', 2, 'D2', '../Lab/LabREOrders.php'),
(9, 4, 'Lab Report', 3, 'D3', '../Lab/LabViewResults.php'),
(10, 5, 'Security', 1, 'G1', '../Security/SecurityMenu.php'),
(11, 6, 'System Reports', 1, 'I1', '../Security/Selector.php'),
(12, 5, 'Setup', 2, 'G2', '../Setup/SetupMenu.php'),
(13, 8, 'Patient List', 1, 'H1', '../Reports/PatientList.php');

-- --------------------------------------------------------

--
-- Table structure for table `menu_sub2`
--

CREATE TABLE IF NOT EXISTS `menu_sub2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s1_id` int(11) NOT NULL,
  `s2_name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `s2_seq` int(11) NOT NULL,
  `s2_permit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `s2_link` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu_sub3`
--

CREATE TABLE IF NOT EXISTS `menu_sub3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s2_id` int(11) NOT NULL,
  `s3_name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `s3_seq` int(11) NOT NULL,
  `s3_permit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `s3_link` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medrecnum` int(11) NOT NULL,
  `visitid` int(11) NOT NULL,
  `feeid` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `ratereason` int(11) NOT NULL,
  `status` text COLLATE utf8_unicode_ci NOT NULL,
  `urgency` text COLLATE utf8_unicode_ci NOT NULL,
  `doctor` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` text COLLATE utf8_unicode_ci,
  `entryby` text COLLATE utf8_unicode_ci NOT NULL,
  `entrydt` datetime NOT NULL,
  `amtpaid` int(11) DEFAULT NULL,
  `receiptnum` int(11) DEFAULT NULL,
  `revby` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `revdt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patinfo`
--

CREATE TABLE IF NOT EXISTS `patinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medrecnum` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `occup` text COLLATE utf8_unicode_ci NOT NULL,
  `married` text COLLATE utf8_unicode_ci NOT NULL,
  `street` text COLLATE utf8_unicode_ci NOT NULL,
  `city` text COLLATE utf8_unicode_ci NOT NULL,
  `locgovt` text COLLATE utf8_unicode_ci NOT NULL,
  `state` text COLLATE utf8_unicode_ci NOT NULL,
  `country` text COLLATE utf8_unicode_ci NOT NULL,
  `phone1` text COLLATE utf8_unicode_ci,
  `phone2` text COLLATE utf8_unicode_ci,
  `phone3` text COLLATE utf8_unicode_ci,
  `em_rel` text COLLATE utf8_unicode_ci,
  `em_fname` text COLLATE utf8_unicode_ci,
  `em_lname` text COLLATE utf8_unicode_ci,
  `em_phone1` text COLLATE utf8_unicode_ci,
  `em_phone2` text COLLATE utf8_unicode_ci,
  `entrydt` date NOT NULL,
  `entryby` text COLLATE utf8_unicode_ci NOT NULL,
  `comments` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patnotes`
--

CREATE TABLE IF NOT EXISTS `patnotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medrecnum` int(11) NOT NULL,
  `visitid` int(11) NOT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `temp` text COLLATE utf8_unicode_ci,
  `pulse` text COLLATE utf8_unicode_ci,
  `bp_sys` text COLLATE utf8_unicode_ci,
  `bp_dia` text COLLATE utf8_unicode_ci,
  `entryby` text COLLATE utf8_unicode_ci NOT NULL,
  `entrydt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patperm`
--

CREATE TABLE IF NOT EXISTS `patperm` (
  `medrecnum` int(11) NOT NULL AUTO_INCREMENT,
  `hospital` text COLLATE utf8_unicode_ci NOT NULL,
  `active` text COLLATE utf8_unicode_ci NOT NULL,
  `ddate` date DEFAULT NULL,
  `entrydt` date NOT NULL,
  `entryby` text COLLATE utf8_unicode_ci NOT NULL,
  `lastname` text COLLATE utf8_unicode_ci NOT NULL,
  `firstname` text COLLATE utf8_unicode_ci NOT NULL,
  `othername` text COLLATE utf8_unicode_ci,
  `gender` text COLLATE utf8_unicode_ci NOT NULL,
  `ethnicgroup` text COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `est` text COLLATE utf8_unicode_ci NOT NULL,
  `photofile` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`medrecnum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `patperm`
--

INSERT INTO `patperm` (`medrecnum`, `hospital`, `active`, `ddate`, `entrydt`, `entryby`, `lastname`, `firstname`, `othername`, `gender`, `ethnicgroup`, `dob`, `est`, `photofile`) VALUES
(1, 'Bethany', 'Y', NULL, '2014-05-05', 'administrator', 'Test', 'Test', 'Test', 'F', 'Tiv', '1974-05-03', 'N', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patvisit`
--

CREATE TABLE IF NOT EXISTS `patvisit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medrecnum` int(11) NOT NULL,
  `visitdate` date NOT NULL,
  `pat_type` text COLLATE utf8_unicode_ci NOT NULL,
  `location` text COLLATE utf8_unicode_ci NOT NULL,
  `urgency` text COLLATE utf8_unicode_ci NOT NULL,
  `discharge` date DEFAULT NULL,
  `height` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `weight` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `visitreason` text COLLATE utf8_unicode_ci NOT NULL,
  `diagnosis` text COLLATE utf8_unicode_ci,
  `entryby` text COLLATE utf8_unicode_ci NOT NULL,
  `entrydt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permits`
--

CREATE TABLE IF NOT EXISTS `permits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permit` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `main` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sub1` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub2` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub3` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y',
  `descr` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `permits`
--

INSERT INTO `permits` (`id`, `permit`, `main`, `sub1`, `sub2`, `sub3`, `active`, `descr`) VALUES
(2, 'Role', 'G', '1', NULL, NULL, 'Y', NULL),
(3, 'User', 'G', '1', NULL, NULL, 'Y', NULL),
(6, 'Permit', 'G', '1', NULL, NULL, 'Y', NULL),
(7, 'User Role', 'G', '1', NULL, NULL, 'Y', NULL),
(8, 'Role Permit', 'G', '1', NULL, NULL, 'Y', NULL),
(9, 'Patient', 'B', '1', NULL, NULL, 'Y', 'Allows Menu: PATIENT and ''Patient Permanent''  R,E actions'),
(10, 'Recieve Payments', 'C', '1', NULL, NULL, 'Y', NULL),
(12, 'Pharmacy', 'E', NULL, NULL, NULL, 'Y', NULL),
(13, 'Inventory', 'F', '1', NULL, NULL, 'Y', NULL),
(14, 'Reports', 'H', '1', NULL, NULL, 'Y', NULL),
(15, 'Home', 'A', NULL, NULL, NULL, 'Y', 'Allows Menu:HOME'),
(16, 'Laboratory', 'D', NULL, NULL, NULL, 'Y', NULL),
(18, 'New Patient', 'B', '2', NULL, NULL, 'Y', 'Allows Menu: PATIENT:New Patient\r\nAllows Add New Patient'),
(19, 'User Details', 'G', '2', NULL, NULL, 'Y', NULL),
(20, 'Patient Visit', 'B', '1', NULL, NULL, 'Y', 'Allows Menu Patient Patient Search\r\nAllows Patient Visit R,E,A,D'),
(21, 'Patient Info', 'B', '1', NULL, NULL, 'Y', 'Allows Menu Patient:Patient Search\r\nAllows R,E,A Patient Info\r\n'),
(22, 'Patient List', 'H', '1', NULL, NULL, 'Y', NULL),
(23, 'ReceiptsReport', 'C', '2', NULL, NULL, 'Y', NULL),
(24, 'LabCollection', 'D', '1', NULL, NULL, 'Y', NULL),
(25, 'LabResultEntry', 'D', '2', NULL, NULL, 'Y', NULL),
(26, 'LabViewResults', 'D', '3', NULL, NULL, 'Y', NULL),
(27, 'PatientNotes', 'B', '1', NULL, NULL, 'Y', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ratereason`
--

CREATE TABLE IF NOT EXISTS `ratereason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `seq` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ratereason`
--

INSERT INTO `ratereason` (`id`, `reason`, `seq`) VALUES
(0, 'None', 0),
(1, 'Destitute', 1),
(2, 'Emergency', 2),
(3, 'will pay later', 3),
(4, 'employee', 5),
(5, 'volunteer', 6),
(6, 'courtesy', 4);

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE IF NOT EXISTS `receipts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medrecnum` int(11) NOT NULL,
  `ordlist` text COLLATE utf8_unicode_ci,
  `amt` int(11) NOT NULL,
  `entrydt` datetime DEFAULT NULL,
  `entryby` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `testid` int(11) NOT NULL,
  `feeid` int(11) NOT NULL,
  `ordid` int(11) NOT NULL,
  `result` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `normflag` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entryby` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entrydt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` text COLLATE utf8_unicode_ci NOT NULL,
  `descr` text COLLATE utf8_unicode_ci NOT NULL,
  `active` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `descr`, `active`) VALUES
(1, 'sysadmin', 'System Administrator', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `role_permit`
--

CREATE TABLE IF NOT EXISTS `role_permit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleid` int(11) NOT NULL,
  `permitid` int(11) NOT NULL,
  `level` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `role_permit`
--

INSERT INTO `role_permit` (`id`, `roleid`, `permitid`, `level`) VALUES
(1, 1, 3, '4'),
(2, 1, 2, '4'),
(3, 1, 7, '4'),
(4, 1, 6, '4'),
(5, 1, 8, '4'),
(6, 1, 15, '4'),
(7, 1, 24, '4'),
(8, 1, 16, '4'),
(9, 1, 25, '4'),
(10, 1, 26, '4'),
(11, 1, 18, '4'),
(12, 1, 9, '4'),
(13, 1, 21, '4'),
(14, 1, 22, '4'),
(15, 1, 20, '4'),
(16, 1, 27, '4'),
(17, 1, 23, '4'),
(18, 1, 10, '4'),
(19, 1, 14, '4'),
(20, 1, 19, '4');

-- --------------------------------------------------------

--
-- Table structure for table `speccollected`
--

CREATE TABLE IF NOT EXISTS `speccollected` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordnum` int(11) NOT NULL,
  `specid` int(11) NOT NULL,
  `collby` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `colldt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `specimens`
--

CREATE TABLE IF NOT EXISTS `specimens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `method` text COLLATE utf8_unicode_ci,
  `container` text COLLATE utf8_unicode_ci NOT NULL,
  `minvolume` text COLLATE utf8_unicode_ci,
  `preservative` text COLLATE utf8_unicode_ci,
  `viablelimit` text COLLATE utf8_unicode_ci,
  `storage` text COLLATE utf8_unicode_ci,
  `instructions` text COLLATE utf8_unicode_ci,
  `entryby` text COLLATE utf8_unicode_ci NOT NULL,
  `entrydt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `specimens`
--

INSERT INTO `specimens` (`id`, `name`, `method`, `container`, `minvolume`, `preservative`, `viablelimit`, `storage`, `instructions`, `entryby`, `entrydt`) VALUES
(1, 'PurpleTop', 'Phlebotomy', '12x75 tube', '1cc', 'EDTA', '6 hrs', 'Refrigerator', 'Mix immediagtely by tilting tube for >20 seconds', 'leng', '2013-12-19 13:38:38'),
(3, 'Urine', 'Patient void', 'clean cup/jar', '50cc', 'None', '2hrs', 'Refrigerator', 'Use covered containers', 'leng', '2014-01-06 11:39:48'),
(4, 'Stool', 'Patient void', 'non absorbant cup or  wrapper', '1 teaspoon', 'None', '2 hours', 'Refrigerator', 'Be sure specimen is sealed.', 'leng', '2013-12-17 16:04:08'),
(5, 'RedTop', 'Phlebotomy', '12x75 (or100mm) tube', '2 cc', 'None', '4 hours', 'Refrigerator', 'If separator, mix well', 'leng', '2013-12-17 16:06:46'),
(6, 'Swab', 'Professional Collection', 'Swab holder', 'N/A', 'None', 'varies', 'Refrigerator', 'Process ASAP', 'leng', '2013-12-17 16:09:05'),
(7, 'blood - micro', 'finger/feel stick', 'micro tube', '5 ul', 'none', 'na', 'Refrigerator', 'Be sure blood flows freely for collection', 'leng', '2013-12-17 16:10:46'),
(8, 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'leng', '2013-12-17 18:50:46'),
(9, 'EDTA-VPorFS', 'EDTA Venipuncture or Fingerstick', 'EDTA 12x75 or capillary', '20ul', 'EDTA', '4 hours', 'Refrigerator', 'Mix immediately with EDTA', 'leng', '2014-01-03 10:48:32'),
(10, 'Sterile Cup Urine', 'Patient void', 'Sterile Cup/Jar', '25 ml', 'none', '2 hrs', 'Refrigerator', 'Sterile Procedure', 'leng', '2014-01-06 11:36:26'),
(11, 'Culture Colony', 'Sterile loop', 'Culture Medium', 'colony', 'none', '2 hrs', 'Culture', NULL, 'leng', '2014-01-06 11:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `testnormalvalues`
--

CREATE TABLE IF NOT EXISTS `testnormalvalues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `testid` int(11) NOT NULL,
  `begindate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  `agemin` int(11) NOT NULL,
  `agemax` int(11) NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `paniclow` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `normlow` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `normhigh` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `panichigh` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interpretation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entrydt` datetime NOT NULL,
  `entryby` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `testnormalvalues`
--

INSERT INTO `testnormalvalues` (`id`, `testid`, `begindate`, `enddate`, `agemin`, `agemax`, `gender`, `paniclow`, `normlow`, `normhigh`, `panichigh`, `interpretation`, `entrydt`, `entryby`) VALUES
(2, 4, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', '60', '80', '150', '300', 'Blood Glucose Interpretation', '2014-01-01 23:13:56', 'leng'),
(5, 8, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', NULL, 'Clear', NULL, NULL, NULL, '2014-01-01 23:25:30', 'leng'),
(6, 7, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', NULL, 'Yellow', NULL, NULL, NULL, '2014-01-01 23:28:50', 'leng'),
(7, 9, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', NULL, 'Negative', NULL, NULL, NULL, '2014-01-01 23:30:38', 'leng'),
(8, 10, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', NULL, 'Negative', NULL, NULL, NULL, '2014-01-01 23:31:32', 'leng'),
(9, 11, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', NULL, 'No Growth', NULL, NULL, NULL, '2014-01-01 23:32:41', 'leng'),
(10, 12, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', NULL, 'NA', NULL, NULL, NULL, '2014-01-01 23:33:48', 'leng'),
(11, 2, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'F', '1.4', '4.4', '9.4', '24', NULL, '2014-01-03 09:13:45', 'leng'),
(12, 2, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'M', '1.5', '4.5', '10.5', '15', NULL, '2014-01-03 09:12:14', 'leng'),
(13, 5, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', '2.0', '4.2', '5.4', '7.5', NULL, '2014-01-03 15:01:12', 'leng'),
(14, 6, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', '75', '130', '400', '650', NULL, '2014-01-03 15:02:31', 'leng'),
(15, 20, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', '20', '40', '74', '90', NULL, '2014-01-03 15:05:11', 'leng'),
(16, 21, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', '5', '19', '48', '70', NULL, '2014-01-03 15:08:06', 'leng'),
(17, 22, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', NULL, '0', '9', NULL, NULL, '2014-01-03 15:10:14', 'leng'),
(18, 23, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', NULL, '0', '7', NULL, NULL, '2014-01-03 15:11:19', 'leng'),
(19, 24, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', NULL, '0', '4', NULL, NULL, '2014-01-03 15:12:21', 'leng'),
(20, 18, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'F', '30', '37', '47', '65', NULL, '2014-01-03 15:15:02', 'leng'),
(21, 18, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'M', '35', '42', '52', '65', NULL, '2014-01-03 15:28:55', 'leng'),
(22, 27, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 8, 'F', '40', '50', '59', '69', 'child female 50-59\r\nPL < 40  PH > 69', '2014-01-03 16:47:10', 'leng'),
(23, 27, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 8, 'M', '50', '60', '69', '79', 'child male 60-69\r\nPL < 50 PH > 79', '2014-01-03 16:37:11', 'leng'),
(24, 27, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 9, 99, 'F', '20', '30', '39', '49', 'adult female 30-39 \r\nPL < 20 PH > 49', '2014-01-03 16:44:53', 'leng'),
(25, 27, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 9, 99, 'M', '30', '40', '49', '59', 'adult male 40-49 \r\nPL < 30 PH > 59', '2014-01-03 16:48:36', 'leng'),
(26, 14, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', '100', '135', '148', '180', NULL, '2014-01-06 12:13:16', 'leng'),
(27, 13, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', '2.5', '3.5', '5.3', '6.5', NULL, '2014-01-06 12:14:34', 'leng'),
(28, 15, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', '85', '100', '112', '130', NULL, '2014-01-06 12:19:56', 'leng'),
(29, 16, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', '15', '23', '28', '35', NULL, '2014-01-06 12:20:46', 'leng'),
(30, 17, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', NULL, '0', '31', NULL, NULL, '2014-01-06 12:27:31', 'leng'),
(31, 32, '2014-01-01 00:00:00', '2019-01-01 00:00:00', 0, 99, 'MF', '50', '130', '400', '600', NULL, '2014-01-06 17:20:12', 'leng');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feeid1` int(11) NOT NULL,
  `feeid2` int(11) DEFAULT NULL,
  `feeid3` int(11) DEFAULT NULL,
  `test` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `formtype` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `units` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reportseq` int(11) NOT NULL,
  `active` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `entryby` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entrydt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `feeid1`, `feeid2`, `feeid3`, `test`, `description`, `formtype`, `units`, `reportseq`, `active`, `entryby`, `entrydt`) VALUES
(2, 1, 2, NULL, 'WBC', 'White Blood Cell Count', 'TextField', 'thou/mm3', 1, 'Y', 'leng', '2014-01-03 13:05:51'),
(4, 4, NULL, NULL, 'Blood Glucose', 'Blood Sugar', 'TextField', 'mg/dl', 1, 'Y', 'leng', '2014-01-06 12:33:43'),
(5, 1, NULL, NULL, 'RBC', 'Red Blood Cell Count', 'TextField', 'mil/cmm', 2, 'Y', 'leng', '2014-01-03 11:43:20'),
(6, 1, NULL, NULL, 'Platelets', 'Platelet Count', 'TextField', 'thou/mm3', 6, 'Y', 'leng', '2014-01-03 13:08:39'),
(7, 10, NULL, NULL, 'Urine Color', 'Urine Color', 'DropDown', 'quali', 1, 'Y', 'leng', '2014-01-03 12:49:14'),
(8, 10, NULL, NULL, 'Urine Clarity', 'Urine Clarity', 'DropDown', 'qual', 2, 'Y', 'leng', '2014-01-03 12:49:27'),
(9, 10, NULL, NULL, 'Urine Glucose', 'Urine Glucose - DipStick', 'DropDown', 'qual', 3, 'Y', 'leng', '2013-12-30 16:11:51'),
(10, 10, NULL, NULL, 'Urine Protein', 'Urine Protein - dipstick', 'DropDown', 'qual', 4, 'Y', 'leng', '2013-12-30 16:13:38'),
(11, 13, NULL, NULL, 'Urine Culture', 'Urine Culture', 'TextField', 'NA', 1, 'Y', 'leng', '2014-01-03 12:49:47'),
(12, 27, NULL, NULL, 'Urine Sensitivity', 'Urine Sensitivity', 'TextField', 'NA', 2, 'Y', 'leng', '2013-12-30 22:13:21'),
(13, 9, 6, NULL, 'Potassium', 'Blood Potassium', 'TextField', 'mEq/L', 3, 'Y', 'leng', '2014-01-03 13:07:00'),
(14, 9, 5, NULL, 'Sodium', 'Blood Sodium', 'TextField', 'mEq/L', 2, 'Y', 'leng', '2014-01-03 13:07:19'),
(15, 9, 7, NULL, 'Chloride', 'Blood Chloride', 'TextField', 'mEq/L', 4, 'Y', 'leng', '2014-01-03 13:06:38'),
(16, 8, 9, NULL, 'CO2', 'Blood CO2', 'TextField', 'mEq/L', 5, 'Y', 'leng', '2014-01-03 12:45:08'),
(17, 22, NULL, NULL, 'SGOT', 'Blood SGOT', 'TextField', 'U/L', 1, 'Y', 'leng', '2014-01-03 12:47:12'),
(18, 1, 24, NULL, 'Hematocrit', 'Blood Hematocrit', 'TextField', '%', 4, 'Y', 'leng', '2014-01-03 13:08:13'),
(19, 15, NULL, NULL, 'Blood Group', 'Blood Group', 'DropDown', 'Group', 1, 'Y', 'leng', '2014-01-02 17:30:19'),
(20, 25, NULL, NULL, 'SEGS', 'segs', 'TextField', '%', 2, 'Y', 'leng', '2014-01-03 12:55:40'),
(21, 25, NULL, NULL, 'Lymphocytes', 'Lymphocyte WBC', 'TextField', '%', 4, 'Y', 'leng', '2014-01-03 13:10:34'),
(22, 25, NULL, NULL, 'Monocytes', 'Monocytes WBC', 'TextField', '%', 6, 'Y', 'leng', '2014-01-03 13:10:44'),
(23, 25, NULL, NULL, 'Eosinophils', 'Eosinophil WBS', 'TextField', '%', 8, 'Y', 'leng', '2014-01-03 13:11:28'),
(24, 25, NULL, NULL, 'Basophils', 'Basophilic WBC', 'TextField', '%', 10, 'Y', 'leng', '2014-01-03 13:13:09'),
(25, 25, NULL, NULL, 'RBC Morphology', 'RBC Morphology', 'DropDown', 'NA', 12, 'Y', 'leng', '2014-01-06 17:39:35'),
(26, 18, NULL, NULL, 'Stool Micro', 'Stool Microscopic Exam', 'DropDown', NULL, 1, 'Y', 'leng', '2014-01-03 13:16:14'),
(27, 26, NULL, NULL, 'normvalues', 'test normal ranges', 'TextField', 'units', 1, 'Y', 'leng', '2014-01-04 08:51:15'),
(28, 12, NULL, NULL, 'Urine WBCs', 'Urine WBC', 'DropDown', 'cells/lpf', 1, 'Y', 'leng', '2014-01-06 14:13:11'),
(29, 12, NULL, NULL, 'Urine RBCs', 'Urine RBCs', 'DropDown', 'cells/lpf', 2, 'Y', 'leng', '2014-01-06 14:13:36'),
(30, 12, NULL, NULL, 'Urine Casts', 'Urine Casts', 'DropDown', 'casts/lpf', 4, 'Y', 'leng', '2014-01-06 14:13:47'),
(31, 12, NULL, NULL, 'Urine Parasites', 'Urine Parasites', 'DropDown', NULL, 8, 'Y', 'leng', '2014-01-06 13:21:28'),
(32, 3, NULL, NULL, 'Platelet Count', 'Platelet Count', 'TextField', 'thou/cmm', 1, 'Y', 'leng', '2014-01-06 17:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `docflag` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `active` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userid`, `login`, `lastname`, `firstname`, `password`, `docflag`, `active`) VALUES
(1, 'Len Gabrielse', 'leng', 'Gabrielse', 'Leonard', 'len', 'N', 'Y'),
(2, 'administrator', 'admin', 'admin', 'admin', '123', 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `roleid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `userid`, `roleid`) VALUES
(1, 1, 1),
(2, 2, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
