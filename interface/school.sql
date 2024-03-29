-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2019 at 08:41 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `absence`
--

CREATE TABLE `absence` (
  `abid` int(11) NOT NULL,
  `aadid` int(11) NOT NULL,
  `abstudentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `absence`
--

INSERT INTO `absence` (`abid`, `aadid`, `abstudentId`) VALUES
(6, 1, 8),
(4, 1, 18),
(5, 1, 32),
(2, 1, 34),
(3, 1, 35),
(1, 1, 39),
(8, 2, 7),
(9, 2, 18),
(7, 2, 22),
(10, 2, 32),
(11, 2, 41);

-- --------------------------------------------------------

--
-- Table structure for table `absence_day`
--

CREATE TABLE `absence_day` (
  `adid` int(11) NOT NULL,
  `day` date NOT NULL,
  `adacademicYear` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `absence_day`
--

INSERT INTO `absence_day` (`adid`, `day`, `adacademicYear`) VALUES
(2, '2019-05-07', 22),
(1, '2019-05-10', 22);

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `aid` int(11) NOT NULL,
  `yearId` varchar(50) NOT NULL,
  `year` date NOT NULL,
  `semester` tinyint(4) NOT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`aid`, `yearId`, `year`, `semester`, `checked`) VALUES
(22, 'ربيع 2019\\2018', '2019-05-09', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `coid` int(11) NOT NULL,
  `coname` varchar(100) NOT NULL,
  `cocity` varchar(100) NOT NULL,
  `cocountry` varchar(100) NOT NULL,
  `cophone` varchar(20) NOT NULL,
  `comessage` text NOT NULL,
  `codate` date NOT NULL,
  `coacademicYear` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `cid` int(11) NOT NULL,
  `cname` varchar(255) NOT NULL,
  `clevel` int(11) NOT NULL,
  `csemester` tinyint(1) NOT NULL,
  `ccode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`cid`, `cname`, `clevel`, `csemester`, `ccode`) VALUES
(4, 'الرياضيات', 4, 1, 'Cal43'),
(5, 'العلوم', 3, 2, 'Sic11'),
(6, 'الغة العربية', 3, 2, ''),
(8, 'الرياضيات', 1, 1, 'EXA'),
(10, 'الرياضيات', 2, 1, 'Cal432'),
(19, 'دين', 1, 1, 'reg423'),
(20, 'العلوم', 1, 1, 'sin32'),
(22, 'العلوم', 2, 1, 'sinc22'),
(23, 'العلوم', 3, 1, 'sin412'),
(24, 'دين', 2, 1, 'reg331'),
(25, 'دين', 6, 1, 'reg4238'),
(26, 'الغة العربية', 2, 1, 'ara1010'),
(27, 'الغة العربية', 1, 1, 'ara11'),
(28, 'الغة العربية', 1, 2, 'ara423'),
(29, 'دين', 3, 1, 'reg4'),
(30, 'الغة العربية', 3, 1, 'ara121'),
(31, 'دين', 3, 2, 'reg22'),
(32, 'الغة العربية', 4, 1, 'ara2222'),
(33, 'الغة العربية', 4, 2, 'ara11232'),
(34, 'الغة العربية', 5, 1, 'ara10'),
(35, 'الغة الانجليزية', 2, 1, 'eng22'),
(36, 'دين', 1, 2, 'reg101'),
(37, 'الرياضات', 1, 2, 'stort3332');

-- --------------------------------------------------------

--
-- Table structure for table `degree`
--

CREATE TABLE `degree` (
  `did` int(11) NOT NULL,
  `dtype` int(11) NOT NULL,
  `dstudentId` int(11) NOT NULL,
  `degree` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `degree`
--

INSERT INTO `degree` (`did`, `dtype`, `dstudentId`, `degree`) VALUES
(1, 1, 39, 9),
(2, 1, 34, 9),
(3, 1, 20, 7),
(4, 1, 35, 6),
(5, 1, 22, 17),
(6, 1, 7, 12),
(7, 1, 18, 2),
(8, 1, 32, 2),
(9, 1, 41, 5),
(10, 2, 39, 3),
(11, 2, 34, 9),
(12, 2, 20, 9),
(13, 2, 35, 9),
(14, 2, 22, 9),
(15, 2, 7, 9),
(16, 2, 18, 9),
(17, 2, 32, 9),
(18, 2, 41, 9);

-- --------------------------------------------------------

--
-- Table structure for table `degreetype`
--

CREATE TABLE `degreetype` (
  `dtid` int(11) NOT NULL,
  `dtname` varchar(50) NOT NULL,
  `dtcourseId` int(11) NOT NULL,
  `dtmaxDegree` int(4) NOT NULL,
  `dtexamDate` date NOT NULL,
  `dtacademicYear` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `degreetype`
--

INSERT INTO `degreetype` (`dtid`, `dtname`, `dtcourseId`, `dtmaxDegree`, `dtexamDate`, `dtacademicYear`) VALUES
(1, 'العملي', 19, 20, '2019-05-01', 22),
(2, 'العملي 2', 19, 10, '2019-05-22', 22);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `eid` int(11) NOT NULL,
  `title` text NOT NULL,
  `details` text NOT NULL,
  `edate` date NOT NULL,
  `register` tinyint(1) NOT NULL DEFAULT '0',
  `eacademicYear` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eid`, `title`, `details`, `edate`, `register`, `eacademicYear`) VALUES
(2, 'الاول', 'هنا الفعلية الاولة', '2019-05-11', 0, 22);

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `pid` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `parentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`pid`, `studentId`, `parentId`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `reg_course`
--

CREATE TABLE `reg_course` (
  `rid` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `academicYear` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reg_course`
--

INSERT INTO `reg_course` (`rid`, `studentId`, `courseId`, `academicYear`) VALUES
(1, 7, 8, 22),
(2, 18, 8, 22),
(3, 20, 8, 22),
(4, 22, 8, 22),
(5, 32, 8, 22),
(6, 7, 19, 22),
(7, 18, 19, 22),
(8, 20, 19, 22),
(9, 22, 19, 22),
(10, 32, 19, 22),
(11, 7, 20, 22),
(12, 18, 20, 22),
(13, 20, 20, 22),
(14, 22, 20, 22),
(15, 32, 20, 22),
(16, 8, 10, 22),
(17, 7, 27, 22),
(18, 18, 27, 22),
(19, 20, 27, 22),
(20, 22, 27, 22),
(21, 32, 27, 22),
(22, 34, 27, 22),
(23, 35, 27, 22),
(24, 39, 27, 22),
(25, 41, 27, 22),
(26, 8, 22, 22),
(27, 8, 24, 22),
(28, 8, 26, 22),
(29, 8, 35, 22),
(30, 1, 23, 22),
(31, 1, 29, 22),
(32, 1, 30, 22),
(33, 19, 34, 22),
(34, 34, 8, 22),
(35, 35, 8, 22),
(36, 39, 8, 22),
(37, 41, 8, 22),
(38, 34, 19, 22),
(39, 35, 19, 22),
(40, 39, 19, 22),
(41, 41, 19, 22),
(42, 34, 20, 22),
(43, 35, 20, 22),
(44, 39, 20, 22),
(45, 41, 20, 22);

-- --------------------------------------------------------

--
-- Table structure for table `reg_event`
--

CREATE TABLE `reg_event` (
  `reid` int(11) NOT NULL,
  `reevent` int(11) NOT NULL,
  `reuser` int(11) NOT NULL,
  `redate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reg_teacher`
--

CREATE TABLE `reg_teacher` (
  `rtid` int(11) NOT NULL,
  `rtteacherId` int(11) NOT NULL,
  `rtcourseId` int(11) NOT NULL,
  `rtacademicYear` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reg_teacher`
--

INSERT INTO `reg_teacher` (`rtid`, `rtteacherId`, `rtcourseId`, `rtacademicYear`) VALUES
(1, 30, 8, 22),
(2, 3, 19, 22),
(3, 27, 20, 22),
(4, 28, 10, 22),
(5, 29, 27, 22),
(6, 27, 22, 22),
(7, 3, 24, 22),
(8, 29, 26, 22),
(9, 3, 35, 22),
(10, 27, 23, 22),
(11, 3, 29, 22),
(12, 29, 30, 22),
(13, 28, 4, 22),
(14, 3, 32, 22),
(15, 29, 34, 22),
(16, 3, 25, 22);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `sid` int(11) NOT NULL,
  `ssnid` int(11) NOT NULL,
  `scourseId` int(11) NOT NULL,
  `sdate` date DEFAULT NULL,
  `sday` tinyint(4) DEFAULT NULL,
  `stime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_name`
--

CREATE TABLE `schedule_name` (
  `snid` int(11) NOT NULL,
  `snname` varchar(200) NOT NULL,
  `snacademicYear` int(11) NOT NULL,
  `sntype` varchar(20) NOT NULL,
  `sndate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `upload`
--

CREATE TABLE `upload` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(200) NOT NULL,
  `path` text NOT NULL,
  `extension` varchar(20) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `ucourseId` int(11) NOT NULL,
  `uacademicYear` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `groupid` smallint(6) NOT NULL,
  `birthday` date NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `startdate` date NOT NULL,
  `phone` bigint(11) NOT NULL,
  `address` text NOT NULL,
  `regdate` year(4) DEFAULT NULL,
  `ssn` bigint(14) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `email`, `password`, `groupid`, `birthday`, `picture`, `startdate`, `phone`, `address`, `regdate`, `ssn`, `active`, `description`) VALUES
(1, 'احمد محمد شاكر', 'احمد شاكر', 'ahmed22shaker@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '1998-01-01', '', '2015-01-01', 1094269634, 'الفيوم', 2017, 0, 1, NULL),
(2, 'محمد شاكر', 'شاكر', 'shaker@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 3, '1955-01-01', '', '2019-03-01', 1094269634, 'الفيوم', 2019, 0, 0, NULL),
(3, 'ابراهيم محمد احمد', 'ابراهيم', 'ibrahem@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 2, '1956-02-02', '', '2019-03-01', 1094269634, 'الشرقية', 2019, 0, 1, 'الغة العربية'),
(7, 'سيف هشام بدران ', 'سيف هشام', 'saif2nemr@gail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2019-03-15', NULL, '2019-03-06', 3837373, 'الشرقية', 2019, 383737, 1, NULL),
(8, 'احمد ابراهيم سيد عطي لله', 'احمدابراهيم', 'ahmed33@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2019-03-26', NULL, '2019-03-08', 1010938377, 'المنوفية', 2018, 3273892789379, 1, NULL),
(18, 'شادي محمد ابراهيم فؤاد', 'شادي محمد', 'shady@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2003-02-02', NULL, '2019-03-17', 1094269634, 'القاهرة', 2019, 10827226262537, 1, NULL),
(19, 'محمد ابراهيم سيد', 'محمد ابراهيم', 'sayd@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2001-02-02', NULL, '2019-03-18', 1094269634, 'القاهرة', 2015, 39393939393939, 1, NULL),
(20, 'احمد عاطف محمد احمد', 'احمد عاطف', 'atef@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2006-12-03', NULL, '2019-03-18', 1094269634, 'القاهرة', 2019, 4444444444444444, 1, NULL),
(22, 'احمد محمد احمد', 'احمد محمد', 'attef@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2006-02-03', NULL, '2019-03-18', 1094269634, 'القاهرة', 2019, 4444444444444444, 1, NULL),
(27, 'ابراهيم سيد محمد احمد', 'ابراهيم سيد', 'dfjaskld@gmial.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 2, '2008-03-31', NULL, '2019-03-20', 101001010, 'القاهرة', NULL, 1010101010, 1, 'العلوم'),
(28, 'محمد فؤاد محمد ابراهيم', 'محمد فؤاد', 'foaud@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 2, '2005-03-22', NULL, '2019-03-20', 484848484848, 'القاهرة', NULL, 48484848, 1, 'الرياضيات'),
(29, 'السيد محمد ابراهيم', 'السيد محمد', 'sayed@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 2, '2014-02-22', NULL, '2019-03-20', 101001010, 'القاهرة', NULL, 10101010, 0, 'الغة العربية'),
(30, 'ابراهيم عزمي محمد', 'ابراهيم عزمي', 'ssas@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 2, '1985-02-22', NULL, '2019-04-26', 1093929393, 'القاهرة', NULL, 9393938483, 1, 'الغة الانجليزية'),
(32, 'محمد ابراهيم احمد اسيد', 'محمد32ابراهيم', 'saif2nemr@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2019-05-09', NULL, '2019-05-09', 101942923, 'القاهرة', 2019, 181818181818, 1, NULL),
(34, 'ابرهيم محمد سيد احمد', 'ابرهيم34محمد', 'saif2nemr1@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2019-02-22', NULL, '2019-05-09', 293892384923, 'القاهرة', 2019, 203902390293, 1, NULL),
(35, 'احمد محمد ابراهيم', 'احمد35محمد', 's333aif2nemr@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2019-02-22', NULL, '2019-05-09', 10101010, 'القاهرة', 2019, 101010101010, 1, NULL),
(39, 'ابراهيم سيد محمد احمد', 'ابراهيم39سيد', 'saif22322nemr@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2019-05-14', NULL, '2019-05-09', 101942923, 'الشرقية', 2019, 222222222, 1, NULL),
(41, 'محمد سيد محمد احمد', 'محمد41سيد', 'saif22333222nemr@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2019-05-14', NULL, '2019-05-09', 101942923, 'الشرقية', 2019, 222222222, 1, NULL),
(42, 'سيد ابراهيم احمد', 'سيد123', 'saif331333@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 3, '0000-00-00', NULL, '2019-05-09', 10942932939, 'الشرقية', NULL, 101010101010, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absence`
--
ALTER TABLE `absence`
  ADD PRIMARY KEY (`abid`),
  ADD UNIQUE KEY `aadid` (`aadid`,`abstudentId`),
  ADD KEY `absenceToStudent` (`abstudentId`);

--
-- Indexes for table `absence_day`
--
ALTER TABLE `absence_day`
  ADD PRIMARY KEY (`adid`),
  ADD UNIQUE KEY `day` (`day`,`adacademicYear`),
  ADD KEY `absenceToAcademicYear` (`adacademicYear`);

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`aid`),
  ADD UNIQUE KEY `yearId` (`yearId`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`coid`),
  ADD KEY `contactToAcademicYear` (`coacademicYear`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`cid`),
  ADD UNIQUE KEY `c-code` (`ccode`);

--
-- Indexes for table `degree`
--
ALTER TABLE `degree`
  ADD PRIMARY KEY (`did`),
  ADD KEY `degreeToStudent` (`dstudentId`),
  ADD KEY `degreeToDegreeType` (`dtype`);

--
-- Indexes for table `degreetype`
--
ALTER TABLE `degreetype`
  ADD PRIMARY KEY (`dtid`),
  ADD KEY `degreeTypeToAcademicYear` (`dtacademicYear`),
  ADD KEY `degreeTypeToCourse` (`dtcourseId`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eid`),
  ADD KEY `eventToAcademicYear` (`eacademicYear`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `parentStudent` (`studentId`),
  ADD KEY `parentParent` (`parentId`);

--
-- Indexes for table `reg_course`
--
ALTER TABLE `reg_course`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `regsAcademicYear` (`academicYear`),
  ADD KEY `regCourse` (`courseId`),
  ADD KEY `regStudent` (`studentId`);

--
-- Indexes for table `reg_event`
--
ALTER TABLE `reg_event`
  ADD PRIMARY KEY (`reid`),
  ADD KEY `regEventToEvent` (`reevent`),
  ADD KEY `regEventToUser` (`reuser`);

--
-- Indexes for table `reg_teacher`
--
ALTER TABLE `reg_teacher`
  ADD PRIMARY KEY (`rtid`),
  ADD KEY `rtteacherId` (`rtteacherId`),
  ADD KEY `rtcourseId` (`rtcourseId`),
  ADD KEY `rtacademicYear` (`rtacademicYear`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `scourseId` (`scourseId`,`sday`,`ssnid`) USING BTREE,
  ADD KEY `scheduleToScheduleName` (`ssnid`);

--
-- Indexes for table `schedule_name`
--
ALTER TABLE `schedule_name`
  ADD PRIMARY KEY (`snid`),
  ADD UNIQUE KEY `snname` (`snname`,`snacademicYear`),
  ADD KEY `scheduleNameToAcademicYear` (`snacademicYear`);

--
-- Indexes for table `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `uploadToCourse` (`ucourseId`),
  ADD KEY `uploadToAcademicYear` (`uacademicYear`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u-username` (`username`),
  ADD UNIQUE KEY `u-email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absence`
--
ALTER TABLE `absence`
  MODIFY `abid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `absence_day`
--
ALTER TABLE `absence_day`
  MODIFY `adid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `coid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `degree`
--
ALTER TABLE `degree`
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `degreetype`
--
ALTER TABLE `degreetype`
  MODIFY `dtid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reg_course`
--
ALTER TABLE `reg_course`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `reg_event`
--
ALTER TABLE `reg_event`
  MODIFY `reid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reg_teacher`
--
ALTER TABLE `reg_teacher`
  MODIFY `rtid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule_name`
--
ALTER TABLE `schedule_name`
  MODIFY `snid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upload`
--
ALTER TABLE `upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absence`
--
ALTER TABLE `absence`
  ADD CONSTRAINT `absenceToAbsenceDay` FOREIGN KEY (`aadid`) REFERENCES `absence_day` (`adid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absenceToStudent` FOREIGN KEY (`abstudentId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `absence_day`
--
ALTER TABLE `absence_day`
  ADD CONSTRAINT `absenceToAcademicYear` FOREIGN KEY (`adacademicYear`) REFERENCES `academic_year` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contactToAcademicYear` FOREIGN KEY (`coacademicYear`) REFERENCES `academic_year` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `degree`
--
ALTER TABLE `degree`
  ADD CONSTRAINT `degreeToDegreeType` FOREIGN KEY (`dtype`) REFERENCES `degreetype` (`dtid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `degreeToStudent` FOREIGN KEY (`dstudentId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `degreetype`
--
ALTER TABLE `degreetype`
  ADD CONSTRAINT `degreeTypeToAcademicYear` FOREIGN KEY (`dtacademicYear`) REFERENCES `academic_year` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `degreeTypeToCourse` FOREIGN KEY (`dtcourseId`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `eventToAcademicYear` FOREIGN KEY (`eacademicYear`) REFERENCES `academic_year` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parent`
--
ALTER TABLE `parent`
  ADD CONSTRAINT `parentParent` FOREIGN KEY (`parentId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `parentStudent` FOREIGN KEY (`studentId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reg_course`
--
ALTER TABLE `reg_course`
  ADD CONSTRAINT `regCourse` FOREIGN KEY (`courseId`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `regStudent` FOREIGN KEY (`studentId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `regsAcademicYear` FOREIGN KEY (`academicYear`) REFERENCES `academic_year` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reg_event`
--
ALTER TABLE `reg_event`
  ADD CONSTRAINT `regEventToEvent` FOREIGN KEY (`reevent`) REFERENCES `event` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `regEventToUser` FOREIGN KEY (`reuser`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reg_teacher`
--
ALTER TABLE `reg_teacher`
  ADD CONSTRAINT `rtacademicYear` FOREIGN KEY (`rtacademicYear`) REFERENCES `academic_year` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rtcourseId` FOREIGN KEY (`rtcourseId`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rtteacherId` FOREIGN KEY (`rtteacherId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `scheduleToCourse` FOREIGN KEY (`scourseId`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `scheduleToScheduleName` FOREIGN KEY (`ssnid`) REFERENCES `schedule_name` (`snid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule_name`
--
ALTER TABLE `schedule_name`
  ADD CONSTRAINT `scheduleNameToAcademicYear` FOREIGN KEY (`snacademicYear`) REFERENCES `academic_year` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `upload`
--
ALTER TABLE `upload`
  ADD CONSTRAINT `uploadToAcademicYear` FOREIGN KEY (`uacademicYear`) REFERENCES `academic_year` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uploadToCourse` FOREIGN KEY (`ucourseId`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
