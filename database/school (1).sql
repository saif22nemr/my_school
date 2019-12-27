-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2019 at 12:08 AM
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
(17, 5, 56),
(18, 5, 64),
(19, 5, 66),
(20, 5, 68);

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
(1, '2019-05-10', 22),
(4, '2019-05-14', 22),
(3, '2019-05-15', 22),
(5, '2019-05-23', 24);

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
(22, 'ربيع 2019\\2018', '2019-05-09', 1, 0),
(23, 'خريف 2018/2019', '2019-05-22', 2, 0),
(24, 'ربيع 2019/2020', '2019-05-22', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adid` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adid`, `teacherId`) VALUES
(1, 58);

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
(19, 3, 56, 6),
(20, 3, 64, 9),
(21, 4, 56, 6),
(22, 4, 64, 9),
(23, 5, 56, 9),
(24, 5, 64, 10);

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
(2, 'العملي 2', 19, 10, '2019-05-22', 22),
(3, 'العملي', 19, 10, '2019-02-22', 24),
(4, 'العملي', 20, 10, '2019-02-22', 24),
(5, 'العملي 2', 8, 10, '2008-02-22', 24);

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
(2, 'الاول', 'هنا الفعلية الاولة', '2019-05-11', 0, 22),
(3, 'الفاعيلة الثانية', 'هذه هي التفاصيل', '2019-05-13', 1, 22),
(4, 'العنوان الاول', 'كل التفصيل هنا\r\n\r\n', '2019-05-22', 0, 24);

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
(4, 56, 57),
(7, 64, 65),
(8, 66, 67),
(9, 68, 57);

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
(46, 56, 8, 24),
(47, 64, 8, 24),
(48, 56, 19, 24),
(49, 64, 19, 24),
(50, 56, 20, 24),
(51, 64, 20, 24),
(52, 56, 27, 24),
(53, 64, 27, 24),
(54, 66, 10, 24),
(55, 68, 10, 24),
(56, 66, 22, 24),
(57, 68, 22, 24),
(58, 66, 24, 24),
(59, 68, 24, 24),
(60, 66, 26, 24),
(61, 68, 26, 24),
(62, 66, 35, 24),
(63, 68, 35, 24);

-- --------------------------------------------------------

--
-- Table structure for table `reg_event`
--

CREATE TABLE `reg_event` (
  `reid` int(11) NOT NULL,
  `reevent` int(11) NOT NULL,
  `reuser` int(11) NOT NULL,
  `redate` date NOT NULL
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
(17, 71, 8, 24),
(18, 58, 19, 24),
(19, 69, 20, 24),
(20, 58, 27, 24),
(21, 71, 10, 24),
(22, 69, 22, 24),
(23, 58, 24, 24),
(24, 58, 26, 24),
(25, 58, 35, 24),
(26, 69, 23, 24),
(27, 58, 29, 24),
(28, 58, 30, 24),
(29, 71, 4, 24),
(30, 58, 32, 24),
(31, 58, 34, 24),
(32, 58, 25, 24);

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

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`sid`, `ssnid`, `scourseId`, `sdate`, `sday`, `stime`) VALUES
(1, 1, 8, NULL, 1, '12:59:00'),
(2, 1, 19, NULL, 3, '01:59:00'),
(3, 1, 19, NULL, 4, '12:01:00'),
(4, 1, 20, NULL, 3, '00:59:00'),
(5, 1, 27, NULL, 4, '23:41:00');

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

--
-- Dumping data for table `schedule_name`
--

INSERT INTO `schedule_name` (`snid`, `snname`, `snacademicYear`, `sntype`, `sndate`) VALUES
(1, 'الجدول', 24, 'دراسي', '2019-05-23');

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

--
-- Dumping data for table `upload`
--

INSERT INTO `upload` (`id`, `title`, `name`, `path`, `extension`, `type`, `ucourseId`, `uacademicYear`, `date`) VALUES
(1, 'الملف الاول ', '91159827512185790991322895855.pdf', 'upload/lectrue/', 'pdf', 3, 8, 24, '2019-05-23'),
(2, 'الملف الثاني', '10187225491897617754968401295.pdf', 'upload/exam/', 'pdf', 2, 10, 24, '2019-05-23'),
(3, 'ملف', '11760495911270246434594780886.pdf', 'upload/lectrue/', 'pdf', 3, 8, 24, '2019-05-23'),
(4, 'f', '171116263310823931391347748533.pdf', 'upload/exam/', 'pdf', 2, 24, 24, '2019-05-23'),
(5, 'f', '205680761117232158051607386388.pdf', 'upload/homework/', 'pdf', 1, 10, 24, '2019-05-23');

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
(55, 'سيد ابراهيم احمد', 'سيد55', 's3aif33333@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 3, '0000-00-00', NULL, '2019-05-22', 1919191919, 'الشرقية', NULL, 10101010010, 1, NULL),
(56, 'ابراهيم سيد محمد احمد', 'ابراهيم56', 'saif2nemr@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2000-02-22', NULL, '2019-05-22', 0, 'القاهرة', 2019, 0, 1, NULL),
(57, 'سيد ابراهيم احمد', 'سيد57', 's3aif3333@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 3, '0000-00-00', NULL, '2019-05-22', 0, 'الشرقية', NULL, 1, 1, NULL),
(58, 'ابراهيم سيد محمد ابراهيم', 'ابراهيم سيد', 'dfjaskld@gmial.com', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 2, '1980-02-22', NULL, '2019-05-22', 100110010101010, 'الشرقية', NULL, 1010010100101010, 1, 'الغة العربية'),
(64, 'محمد سيد احمد', 'محمد64', 'mohmmed@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2010-02-22', NULL, '2019-05-23', 101010101010, 'القاهرة', 2019, 101010101001, 1, NULL),
(65, 'سيد احمد', 'سيد65', 'sayed@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 3, '0000-00-00', NULL, '2019-05-23', 1010100101010, 'الشرقية', NULL, 9223372036854775807, 1, NULL),
(66, 'محمد سيد محمد احمد', 'محمد66', 'sayed22@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2010-02-22', NULL, '2019-05-23', 10194929329, 'العريش', 2018, 1010100101010, 1, NULL),
(67, 'سيد محمد احمد', 'سيد67', 's3f33333@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 3, '0000-00-00', NULL, '2019-05-23', 1094269634, 'الشرقية', NULL, 3039473637283838, 1, NULL),
(68, 'محمد عادل رمضان سيد', 'محمد68', 'ramadan@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, '2010-02-22', NULL, '2019-05-23', 101942923, 'القاهرة', 2018, 1010001010, 1, NULL),
(69, 'محمد فؤاد محمد ابراهيم', 'محمد فؤاد', 'djaskld@gmial.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 2, '2010-02-22', NULL, '2019-05-23', 1010010101, 'الشرقية', NULL, 2837237287387238, 0, 'العلوم'),
(71, 'احمد ابراهيم سيد عطي لله', 'احمد71', 'ibrahem22@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 2, '2007-02-22', NULL, '2019-05-23', 101942923, 'القاهرة', NULL, 3827827387287, 1, 'الرياضيات');

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
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adid`),
  ADD KEY `teacher` (`teacherId`);

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
  MODIFY `abid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `absence_day`
--
ALTER TABLE `absence_day`
  MODIFY `adid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `degreetype`
--
ALTER TABLE `degreetype`
  MODIFY `dtid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reg_course`
--
ALTER TABLE `reg_course`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `reg_event`
--
ALTER TABLE `reg_event`
  MODIFY `reid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reg_teacher`
--
ALTER TABLE `reg_teacher`
  MODIFY `rtid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedule_name`
--
ALTER TABLE `schedule_name`
  MODIFY `snid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `upload`
--
ALTER TABLE `upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

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
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `teacher` FOREIGN KEY (`teacherId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
