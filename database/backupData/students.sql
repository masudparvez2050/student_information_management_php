-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2025 at 02:09 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nub_student_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `department` varchar(50) NOT NULL,
  `enrollment_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `name`, `email`, `phone`, `department`, `enrollment_date`, `created_at`, `updated_at`) VALUES
(12, '42220300255', 'MD. Suruj Ali', 'md.surujali@gmail.com', '01700000055', 'Computer Science', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(13, '42220300260', 'Saidur Rahman', 'saidur.rahman@gmail.com', '01700000060', 'Computer Science', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(14, '42220300254', 'Afifa Ayat Falguni', 'afifa.ayat@gmail.com', '01700000054', 'Computer Science', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(15, '42220300258', 'Lamia Akter', 'lamia.akter@gmail.com', '01700000058', 'Computer Science', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(16, '42220300253', 'MD. Abdul Aoual', 'md.abdulaoual@gmail.com', '01700000053', 'Computer Science', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(17, '42220300264', 'Md Helal Khan', 'md.helalkhan@gmail.com', '01700000064', 'Computer Science', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(18, '42220300262', 'Jannatun Naim', 'jannatun.naim@gmail.com', '01700000062', 'Computer Science', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(19, '42220300257', 'Md. Samiul Hosen', 'md.samiulhosen@gmail.com', '01700000057', 'Computer Science', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(20, '42220300226', 'Md. Taslim Uddin', 'md.taslim@gmail.com', '01700000026', 'Computer Science', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(21, '42220300227', 'Md. Asif', 'md.asif@gmail.com', '01700000027', 'Computer Science', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(22, '42220300291', 'Md. Mashiur Rahman', 'md.mashiur@gmail.com', '01700000091', 'Business Administration', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(23, '42220300273', 'MD.Abu Salman', 'md.abusalman@gmail.com', '01700000073', 'Business Administration', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(24, '42220300244', 'Toukir Ahammed', 'toukir.ahammed@gmail.com', '01700000044', 'Business Administration', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(25, '42220300292', 'Md Mahmudul Hossain', 'md.mahmudul@gmail.com', '01700000092', 'Business Administration', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(26, '42220300282', 'Hasanuzzaman Akash', 'hasanuzzaman.akash@gmail.com', '01700000082', 'Business Administration', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(27, '42220300272', 'Gias Uddin', 'gias.uddin@gmail.com', '01700000072', 'Business Administration', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(28, '42220300287', 'Shakil khan', 'shakil.khan@gmail.com', '01700000087', 'Business Administration', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(29, '42220300344', 'Tayeba Shikder', 'tayeba.shikder@gmail.com', '01700000344', 'Business Administration', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(30, '42220300278', 'Nazmin Akhter', 'nazmin.akhter@gmail.com', '01700000078', 'Business Administration', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(31, '42220300208', 'Bristi Halder', 'bristi.halder@gmail.com', '01700000008', 'Business Administration', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(32, '42220300245', 'Md. Jannati Nayem', 'md.jannati@gmail.com', '01700000045', 'Electrical Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(33, '42220300246', 'Md. Tofajjal Hossen', 'md.tofajjal@gmail.com', '01700000046', 'Electrical Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(34, '42220300247', 'Md. Al-Amin', 'md.alamin@gmail.com', '01700000047', 'Electrical Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(35, '42220200171', 'Shahadat Hossain Shadheen', 'shahadat.shadheen@gmail.com', '01700000171', 'Electrical Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(36, '42220300241', 'Shopon Mia', 'shopon.mia@gmail.com', '01700000041', 'Electrical Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(37, '42220300261', 'Tahomin Rahoman', 'tahomin.rahoman@gmail.com', '01700000061', 'Electrical Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(38, '42220300263', 'Siam Munshei', 'siam.munshei@gmail.com', '01700000063', 'Electrical Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(39, '42220300250', 'Subrato Shil', 'subrato.shil@gmail.com', '01700000050', 'Electrical Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(40, '42220300242', 'Md. Jahid', 'md.jahid@gmail.com', '01700000042', 'Electrical Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(41, '42220300271', 'Israil Hossen', 'israil.hossen@gmail.com', '01700000071', 'Electrical Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(42, '42220300238', 'Pavel Mia', 'pavel.mia@gmail.com', '01700000038', 'Civil Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(43, '42220300234', 'Nazmul Islam', 'nazmul.islam@gmail.com', '01700000034', 'Civil Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(44, '42220300231', 'Shanto', 'shanto@gmail.com', '01700000031', 'Civil Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(45, '42220200235', 'Al-amin Islam', 'alamin.islam@gmail.com', '01700000235', 'Civil Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(46, '42220300236', 'Arup Das', 'arup.das@gmail.com', '01700000036', 'Civil Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(47, '42220300225', 'Md. Mirazul Alam', 'md.mirazul@gmail.com', '01700000025', 'Civil Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(48, '42220300298', 'Ar Rafi', 'ar.rafi@gmail.com', '01700000098', 'Civil Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(49, '42220300301', 'Md Abdullah Buhayia', 'md.abdullahbuhayia@gmail.com', '01700000301', 'Civil Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(50, '42220300297', 'Md. Abdullah', 'md.abdullah@gmail.com', '01700000097', 'Civil Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(51, '42220300323', 'Md. Kamrul Hasan', 'md.kamrulhasan@gmail.com', '01700000323', 'Civil Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(52, '42220300270', 'Md.Mehedi Hasan', 'md.mehedihasan@gmail.com', '01700000070', 'Civil Engineering', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(53, '42220300281', 'Imaz Anik', 'imaz.anik@gmail.com', '01700000081', 'Law', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(54, '42220300240', 'Pibir Chakma', 'pibir.chakma@gmail.com', '01700000040', 'Law', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(55, '42220300252', 'Md.Shofiuzzaman', 'md.shofiuzzaman@gmail.com', '01700000052', 'Law', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(56, '42220300230', 'Md. Sayedur Rahman', 'md.sayedur@gmail.com', '01700000030', 'Law', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(57, '42220300299', 'Monirul Islam', 'monirul.islam@gmail.com', '01700000299', 'Law', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19'),
(58, '42220300239', 'Md. Sajjad Hosasain', 'md.sajjadhosasain@gmail.com', '01700000039', 'Law', '2025-01-15', '2025-03-03 01:08:19', '2025-03-03 01:08:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
