-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2020 at 04:17 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agile support tool`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(8) NOT NULL,
  `forename` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `account_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `forename`, `surname`, `email_address`, `user_type`, `account_password`) VALUES
(1, 'James', 'Taylor', 'JamesTaylor@gmail.com', 'Student', '2ac9cb7dc02b3c0083eb70898e549b63'),
(2, 'Maria', 'Garcia', 'MariaGarcia@gmail.com', 'Student', '6f9dff5af05096ea9f23cc7bedd65683'),
(3, 'Mary', 'Hernandez', 'MaryHernandez@gmail.com', 'Student', '874fcc6e14275dde5a23319c9ce5f8e4'),
(4, 'Jack', 'Johnson', 'JackJohnson@gmail.com', 'Student', 'b025a0d0ec287ba8ad0d90f4ff69158f'),
(5, 'Mark', 'Taylor', 'MarkTaylor@gmail.com', 'Student', '7df5222fb59b99c7c598bee2ef00b85e'),
(6, 'Gavyn', 'Anderson', 'GavynAnderson@gmail.com', 'Staff', '1a9ce1cc5e07b14baebc7daeec2032d0'),
(7, 'Tony', 'Cook', 'TonyCook@gmail.com', 'Staff', 'a88e25cd2e2932b3e915df4d18c0a73d'),
(8, 'Jade', 'Montoya', 'JadeMontoya@gmail.com', 'Staff', '0b90508c31852a6c905583ca73304040'),
(9, 'Leo', 'Reed', 'LeoReed@gmail.com', 'Staff', 'd0ad396a483a7570f63d7995ca9c9c34'),
(10, 'Lina', 'Gomez', 'LinaGomez@gmail.com', 'Staff', '67e71c856f22ab232184d469f3c4a401'),
(11, 'Alfred', 'Snow', 'AlfredSnow@gmail.com', 'Student', 'fabb2e3f5cee3fa92c8a872832d21fec'),
(12, 'Arturo', 'Barton', 'ArturoBarton@gmail.com', 'Staff', 'f55d8dc651c70f4593188abb84e5c921'),
(13, 'Crystal', 'Mccarthy', 'CrystalMccarthy@gmail.com', 'Student', '55354afecb098a4371f8cfa95f469868'),
(14, 'Myles', 'King', 'MylesKing@gmail.com', 'Staff', '55354afecb098a4371f8cfa95f469868'),
(15, 'Danny', 'Wheeler', 'DannyWheeler@gmail.com', 'Student', '6b208366be3649e11606feb20008924f'),
(16, 'Will', 'Blackburn', 'WillBlackburn@gmail.com', 'Staff', '6b208366be3649e11606feb20008924f'),
(17, 'Nick', 'Walters', 'NickWalters@gmail.com', 'Student', '55656034eb43d2f48de7f517c2880feb'),
(18, 'Rylee', 'Smith', 'RyleeSmith@gmail.com', 'Staff', '55656034eb43d2f48de7f517c2880feb'),
(19, 'Lillian', 'Green', 'LillianGreen@gmail.com', 'Student', '26a27c4eda5615486b20fb3103f1d2a6'),
(20, 'Hannah', 'Romero', 'HannahRomero@gmail.com', 'Staff', '26a27c4eda5615486b20fb3103f1d2a6'),
(21, 'Rebecca', 'Osborn', 'RebeccaOsborn@gmail.com', 'Student', '6a86232350b1c5c5aa2ae7bdc70d838c'),
(22, 'Stacy', 'Wilson', 'StacyWilson@gmail.com', 'Student', '6a86232350b1c5c5aa2ae7bdc70d838c'),
(23, 'Leah', 'Foster', 'LeahFoster@gmail.com', 'Student', 'a47d3224806bfff7bcafb0a73cff34b3'),
(24, 'Oliver', 'Bikar', 'oliverbikar@yahoo.co.uk', 'Student', '8e1cbbffec52c13b35cbf3c2ec1004a3'),
(25, 'Miranda', 'Lee', 'MirandaLee@gmail.com', 'Staff', '6a86232350b1c5c5aa2ae7bdc70d838c');

-- --------------------------------------------------------

--
-- Table structure for table `invite_member`
--

CREATE TABLE `invite_member` (
  `id` int(8) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(8) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(8) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_description` text NOT NULL,
  `project_start_date` date NOT NULL,
  `project_deadline` date NOT NULL,
  `project_owner` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_description`, `project_start_date`, `project_deadline`, `project_owner`) VALUES
(1, 'Classroom Booking System', 'Produce a web-based tool that helps manage reservations for all room types and resources', '2019-11-13', '2020-03-02', 1),
(2, 'Social Media Tool', 'Develop a Social Media tool that enables users to communicate information with each other', '2019-09-07', '2020-01-26', 3),
(3, 'Project Three', 'Project Three', '2020-01-26', '2020-02-26', 5),
(4, 'Project Four', 'Project Four', '2020-02-27', '2020-03-27', 11);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(8) NOT NULL,
  `task_description` varchar(100) NOT NULL,
  `id` int(8) NOT NULL,
  `task_start_date` date NOT NULL,
  `task_deadline` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `user_st_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_description`, `id`, `task_start_date`, `task_deadline`, `status`, `user_st_id`) VALUES
(1, 'Task 1', 1, '2020-02-01', '2020-03-01', 'To be Completed', 1);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `team_id` int(8) NOT NULL,
  `team_name` varchar(25) NOT NULL,
  `project_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_id`, `team_name`, `project_id`) VALUES
(1, 'Set 1', 1),
(2, 'Set 2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `team_id` int(8) NOT NULL,
  `id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`team_id`, `id`) VALUES
(1, 1),
(2, 3),
(2, 4),
(3, 25),
(3, 5),
(1, 2),
(2, 24),
(1, 24);

-- --------------------------------------------------------

--
-- Table structure for table `user_story`
--

CREATE TABLE `user_story` (
  `user_st_id` int(8) NOT NULL,
  `user` varchar(100) NOT NULL,
  `goal` varchar(100) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `project_id` int(8) NOT NULL,
  `sprint_id` int(8) NOT NULL,
  `priority` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_story`
--

INSERT INTO `user_story` (`user_st_id`, `user`, `goal`, `reason`, `project_id`, `sprint_id`, `priority`) VALUES
(1, 'Manager', 'be able to understand my colleagues progress', 'I can better report our success and failures', 1, 1, 'Medium');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `user_story`
--
ALTER TABLE `user_story`
  ADD PRIMARY KEY (`user_st_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `team_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_story`
--
ALTER TABLE `user_story`
  MODIFY `user_st_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
