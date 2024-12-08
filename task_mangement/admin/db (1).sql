-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Dec 08, 2024 at 04:25 PM
-- Server version: 10.11.8-MariaDB-ubu2204-log
-- PHP Version: 8.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign_task_junc`
--

CREATE TABLE `assign_task_junc` (
  `ass_task_id` int(100) NOT NULL,
  `uid` int(100) NOT NULL,
  `task_id` int(100) NOT NULL,
  `proj_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assign_task_junc`
--

INSERT INTO `assign_task_junc` (`ass_task_id`, `uid`, `task_id`, `proj_id`) VALUES
(3, 2, 3, 1),
(4, 2, 4, 2),
(6, 3, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `com_id` int(11) NOT NULL,
  `com_desc` varchar(110) NOT NULL,
  `task_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `time` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`com_id`, `com_desc`, `task_id`, `uid`, `time`) VALUES
(1, 'hay\r\n', 4, 2, '2024-09-18 07:24:40.000000');

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE `company_profile` (
  `com_id` int(100) NOT NULL,
  `com_name` varchar(100) NOT NULL,
  `com_email` varchar(100) NOT NULL,
  `comp_desc` text NOT NULL,
  `contact` bigint(100) NOT NULL,
  `comp_address` varchar(250) NOT NULL,
  `created_on` bigint(250) NOT NULL,
  `uid` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`com_id`, `com_name`, `com_email`, `comp_desc`, `contact`, `comp_address`, `created_on`, `uid`) VALUES
(1, 'Drupak', 'drupak@gmail.com', 'Drupak is an agency that specializes in Drupal Training and Development. We have the necessary expertise to create web applications, web portals, and mobile apps for clients of all sizes. Our team uses the powerful Drupal framework to deliver exceptional digital experiences. In addition to our Drupal development services, Drupak provides a range of Drupal training courses designed for individuals at all skill levels, ensuring success in navigating the world of Drupal.', 3090903628, 'Wah canntt', 1723556802, 1),
(2, 'Funary Tech Limited', 'funary@gmail.com', '\r\nDrupal website development by Top-notch Drupal Developers\r\n\r\nWhen it comes to building websites, having top-notch Drupal developers at the helm makes all the difference. These experts bring a wealth of experience to the table, creating Drupal websites that go above and beyond.\r\n\r\nFrom a strong foundation to a user-friendly design, their work stands out. By staying up-to-date with the latest trends, these developers ensure that the websites they build are not only secure and scalable but also visually impressive.\r\n\r\nIt\'s not just about creating a website; it\'s about combining the latest technology with expert skills to make a Drupal website that shines in the online world.\r\n', 3139504221, 'Islamabad Main Blue Area', 1723556947, 1);

-- --------------------------------------------------------

--
-- Table structure for table `create_task`
--

CREATE TABLE `create_task` (
  `cat_task_id` int(100) NOT NULL,
  `task_name` varchar(100) NOT NULL,
  `task_desc` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `task_status` varchar(100) NOT NULL,
  `proj_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `create_task`
--

INSERT INTO `create_task` (`cat_task_id`, `task_name`, `task_desc`, `start_date`, `end_date`, `task_status`, `proj_id`) VALUES
(3, 'Fix The Header Issue urgent', 'Fix The Header Issue urgent', '2024-08-21', '2024-08-22', 'Pending', 1),
(4, 'create a header and footer section', 'create a header and footer sectioncreate a header and footer sectioncreate a header and footer secti', '2024-08-16', '2024-08-23', 'Completed', 2),
(6, 'footer', 'footerfooterfooterfooterfooterfooterfooterfooterfooterfooterfooterfooterfooter', '2024-08-15', '2024-08-20', 'Not Started', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `pro_id` int(100) NOT NULL,
  `pro_name` varchar(100) NOT NULL,
  `pro_desc` text NOT NULL,
  `start_date` date NOT NULL,
  `deadLine` date NOT NULL,
  `com_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`pro_id`, `pro_name`, `pro_desc`, `start_date`, `deadLine`, `com_id`) VALUES
(1, 'Task mangement System', 'It involves managing all aspects of a task, from its status and priority to the time spent, people involved, and finally, financial resources needed. Task management methods, tools, and techniques give you and your team a detailed and real-time view of all the moving parts of a project.', '2024-08-15', '2024-08-23', 1),
(2, 'Fintech For Riyadh', 'Fintech For RiyadhFintech For RiyadhFintech For RiyadhFintech For RiyadhFintech For RiyadhFintech For Riyadh\r\n', '2024-08-16', '2024-08-23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `replytable`
--

CREATE TABLE `replytable` (
  `rep_id` int(100) NOT NULL,
  `rep_desc` varchar(100) NOT NULL,
  `com_id` int(100) NOT NULL,
  `uid` int(100) NOT NULL,
  `time` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replytable`
--

INSERT INTO `replytable` (`rep_id`, `rep_desc`, `com_id`, `uid`, `time`) VALUES
(1, 'what problem do you have in this task\r\n', 1, 2, '2024-12-07 18:15:19.000000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(100) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created` bigint(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `uname`, `username`, `user_email`, `password`, `status`, `created`) VALUES
(1, 'Muhammad Afaq', 'afaq1122', 'afaq@gmail.com', '$2y$10$y2hCJWz41sQSbl.HfCHaF.2wV87A7lYJYTn.bfYlaADD0QAIIUq1e', 'admin', 1723556802),
(2, 'umer', 'umer1122', 'umer@gmail.com', '$2y$10$vER4FQed9oF2fpNfLZfWmuDJSYkaQajFwEQIv7jn6l0s4Yr5oU7C6', 'member', 1723556802),
(3, 'Kaleem', 'kalem1122', 'kalem@gmail.com', '$2y$10$6Zhsj1AKhY7Qziqg2uQ9c.DN1vJrRPIVctmYyNbzneKC2d6UmeZ52', 'member', 1723642697),
(4, 'Shahab', 'shahab1122', 'shahab@gmail.com', '$2y$10$pWnO8L7Rdvum2Gf9JQwAzOHf8YuXIQ42UpX5y6HzWD/fEOfzUsS6y', 'member', 1723643208),
(5, 'Bilal', 'bilal11', 'bilal@gmail.com', '$2y$10$A6x7x4vZdVEfLeniVX6e/uPd31Myac9BZuiNNI9zdhdjs1hBIHlL2', 'member', 1723643344),
(6, 'Uzair', 'Uzair1122', 'uze@gamil.com', '$2y$10$5xqQ7rR9Rq1lCUeGbKB5xeIf1vBU3sSqmjWdtPe7w6d5fFnNtMaWu', 'member', 1723643497);

-- --------------------------------------------------------

--
-- Table structure for table `user_com_junc`
--

CREATE TABLE `user_com_junc` (
  `user_com_id` int(100) NOT NULL,
  `uid` int(100) NOT NULL,
  `com_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_com_junc`
--

INSERT INTO `user_com_junc` (`user_com_id`, `uid`, `com_id`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 4, 1),
(4, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `u_id` int(100) NOT NULL,
  `user_Fullname` varchar(100) NOT NULL,
  `user_phone` bigint(100) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_role` varchar(100) NOT NULL,
  `user_expertises` varchar(100) NOT NULL,
  `uid` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`u_id`, `user_Fullname`, `user_phone`, `user_address`, `user_role`, `user_expertises`, `uid`) VALUES
(1, 'Muhammad Umer Khan', 3139500232, 'Wah cannt texilla near GT Road', 'Drupal Developer', 'professional web developer', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign_task_junc`
--
ALTER TABLE `assign_task_junc`
  ADD PRIMARY KEY (`ass_task_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `create_task`
--
ALTER TABLE `create_task`
  ADD PRIMARY KEY (`cat_task_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `replytable`
--
ALTER TABLE `replytable`
  ADD PRIMARY KEY (`rep_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `user_com_junc`
--
ALTER TABLE `user_com_junc`
  ADD PRIMARY KEY (`user_com_id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign_task_junc`
--
ALTER TABLE `assign_task_junc`
  MODIFY `ass_task_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `com_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `create_task`
--
ALTER TABLE `create_task`
  MODIFY `cat_task_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `pro_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `replytable`
--
ALTER TABLE `replytable`
  MODIFY `rep_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_com_junc`
--
ALTER TABLE `user_com_junc`
  MODIFY `user_com_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `u_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
