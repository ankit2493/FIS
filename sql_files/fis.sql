-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Dec 20, 2015 at 01:30 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `FIS`
--

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `designation` varchar(20) DEFAULT NULL,
  `availability_status` varchar(20) DEFAULT NULL,
  `qualification` varchar(20) DEFAULT NULL,
  `timing` varchar(20) DEFAULT NULL,
  `cabin` varchar(20) DEFAULT NULL,
  `subjects` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `school_id`, `name`, `designation`, `availability_status`, `qualification`, `timing`, `cabin`, `subjects`) VALUES
(1, 1, 'Ajay Kumar', 'Asst. Professor', 'available', 'BTECH IT', '10am-3pm', 'SJT101', 'C, Java Programming'),
(2, 1, 'Swarna Priya', 'Senior Professor', 'unavailable', 'MSC', '5pm-7pm', 'KJU12', 'Computer Networks'),
(3, 2, 'Abhishek Gupta', 'Researcher', 'available', 'BBA', '10am-11am, 2pm-4pm', 'SJT212', 'Economics'),
(4, 1, 'Ajay Singh', 'Asst. Professor', 'available', 'MTECH MECH', '2pm-4pm', 'TT12', 'Thermodynamics'),
(5, 3, 'Will Smith', 'Senior Professor', 'unavailable', 'BTECH CSE', '10am-7pm', 'MB212', 'Algorithms');

-- --------------------------------------------------------

--
-- Table structure for table `facultyProject`
--

CREATE TABLE `facultyProject` (
  `project_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facultyProject`
--

INSERT INTO `facultyProject` (`project_id`, `faculty_id`) VALUES
(1, 2),
(2, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `details` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `name`, `details`) VALUES
(1, 'AI', 'Artificial Intelligence'),
(2, 'DB', 'Database Management'),
(3, 'JAVA', 'Java Framework');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `school_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `desc` varchar(400) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`school_id`, `name`, `desc`) VALUES
(1, 'SITE', 'The School of Information Technology & Engineering (SITE) emphasizes the fields of Information Technology, Software Engineering and Domain Specific Applications so as to facilitate the evolution of skills in students to help them attain a higher degree of knowledge, global competency and excellence, for the betterment of the society.'),
(2, 'SELECT', ' School of Electrical Engineering (SELECT) has 79 faculty members who have done their UG and PG degrees from the top-notch universities. The faculty members of this school are consistently doing well in teaching and research. Faculty members and students of SELECT frequently get awards, prizes for outstanding research contributions in their respective fields. '),
(3, 'SMBS', 'The School of Mechanical and Building Sciences comprises of the Mechanical Engineering, Civil Engineering and chemical Engineering disciplines. The School has more than 160 faculty members trained in reputed institutes such as the IITs and the Indian Institute of Science. '),
(4, 'SBST', 'The School of Bio Sciences and Technology offers undergraduate, post graduate and doctoral courses in the fields of Biotechnology, Biomedical Engineering, Biomedical Genetics and Applied Microbiology. ');

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE `userdetails` (
  `username` varchar(20) NOT NULL DEFAULT '',
  `passwd` varchar(10) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`username`, `passwd`) VALUES
('ankit123', 'pass234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `facultyProject`
--
ALTER TABLE `facultyProject`
  ADD KEY `project_id` (`project_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `userdetails`
--
ALTER TABLE `userdetails`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `fk_sf` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`) ON UPDATE CASCADE;

--
-- Constraints for table `facultyProject`
--
ALTER TABLE `facultyProject`
  ADD CONSTRAINT `fk_faculty` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE NO ACTION ON UPDATE CASCADE;
