-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2017 at 04:10 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ptcladmin_progranz_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_answer_comment_master`
--

CREATE TABLE `blog_answer_comment_master` (
  `id` int(11) NOT NULL,
  `blog_asnwer_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_by` int(11) NOT NULL,
  `comment_time` datetime NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_answer_master`
--

CREATE TABLE `blog_answer_master` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `accepted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_answer_rating`
--

CREATE TABLE `blog_answer_rating` (
  `id` int(11) NOT NULL,
  `blog_answer_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `rated_by` int(11) NOT NULL,
  `rated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_master`
--

CREATE TABLE `blog_master` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_tag_master`
--

CREATE TABLE `blog_tag_master` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category1_master`
--

CREATE TABLE `category1_master` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `category1_master`
--

INSERT INTO `category1_master` (`id`, `name`, `active`) VALUES
(1, 'text', 1),
(2, 'video', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_master`
--

CREATE TABLE `category_master` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `sequence` int(11) NOT NULL DEFAULT '1',
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `category_master`
--

INSERT INTO `category_master` (`id`, `name`, `sequence`, `active`) VALUES
(1, 'active', 1, 1),
(2, 'total', 2, 1),
(3, 'deactive', 3, 1),
(4, 'deleted', 4, 1),
(5, 'destroyed', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_permission_master`
--

CREATE TABLE `category_permission_master` (
  `id` int(11) NOT NULL,
  `usertype_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `category_permission_master`
--

INSERT INTO `category_permission_master` (`id`, `usertype_id`, `module_id`, `category_id`, `active`, `created_by`, `updated_by`, `created_date`, `updated_date`) VALUES
(1, 2, 9, 1, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(2, 2, 9, 2, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(3, 2, 9, 3, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(4, 2, 9, 4, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(5, 2, 9, 5, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(6, 2, 5, 1, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(7, 2, 5, 2, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(8, 2, 5, 3, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(9, 2, 5, 4, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(10, 2, 5, 5, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(11, 2, 4, 1, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(12, 2, 4, 2, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(13, 2, 4, 3, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(14, 2, 4, 4, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(15, 2, 4, 5, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(16, 2, 1, 1, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(17, 2, 1, 2, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(18, 2, 1, 3, 1, 3, NULL, '2017-04-05 16:37:08', NULL),
(19, 2, 1, 4, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(20, 2, 1, 5, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(21, 2, 11, 1, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(22, 2, 11, 2, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(23, 2, 11, 3, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(24, 2, 11, 4, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(25, 2, 11, 5, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(26, 2, 8, 1, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(27, 2, 8, 2, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(28, 2, 8, 3, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(29, 2, 8, 4, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(30, 2, 8, 5, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(31, 2, 10, 1, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(32, 2, 10, 2, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(33, 2, 10, 3, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(34, 2, 10, 4, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(35, 2, 10, 5, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(36, 2, 7, 1, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(37, 2, 7, 2, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(38, 2, 7, 3, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(39, 2, 7, 4, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(40, 2, 7, 5, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(41, 2, 12, 1, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(42, 2, 12, 2, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(43, 2, 12, 3, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(44, 2, 12, 4, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(45, 2, 12, 5, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(46, 2, 6, 1, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(47, 2, 6, 2, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(48, 2, 6, 3, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(49, 2, 6, 4, 1, 3, NULL, '2017-04-05 16:37:09', NULL),
(50, 2, 6, 5, 1, 3, NULL, '2017-04-05 16:37:10', NULL),
(51, 2, 3, 1, 1, 3, NULL, '2017-04-05 16:37:10', NULL),
(52, 2, 3, 2, 1, 3, NULL, '2017-04-05 16:37:10', NULL),
(53, 2, 3, 3, 1, 3, NULL, '2017-04-05 16:37:10', NULL),
(54, 2, 3, 4, 1, 3, NULL, '2017-04-05 16:37:10', NULL),
(55, 2, 3, 5, 1, 3, NULL, '2017-04-05 16:37:10', NULL),
(56, 2, 2, 1, 1, 3, NULL, '2017-04-05 16:37:10', NULL),
(57, 2, 2, 2, 1, 3, NULL, '2017-04-05 16:37:10', NULL),
(58, 2, 2, 3, 1, 3, NULL, '2017-04-05 16:37:10', NULL),
(59, 2, 2, 4, 1, 3, NULL, '2017-04-05 16:37:10', NULL),
(60, 2, 2, 5, 1, 3, NULL, '2017-04-05 16:37:10', NULL),
(61, 61, 9, 1, 1, 3, NULL, '2017-04-08 06:18:41', NULL),
(62, 61, 9, 2, 1, 3, NULL, '2017-04-08 06:18:41', NULL),
(63, 61, 9, 3, 1, 3, NULL, '2017-04-08 06:18:41', NULL),
(64, 61, 9, 4, 1, 3, NULL, '2017-04-08 06:18:41', NULL),
(65, 61, 9, 5, 1, 3, NULL, '2017-04-08 06:18:41', NULL),
(66, 2, 13, 1, 1, 3, NULL, '2017-04-08 07:08:13', NULL),
(67, 2, 13, 2, 1, 3, NULL, '2017-04-08 07:08:13', NULL),
(68, 2, 13, 3, 1, 3, NULL, '2017-04-08 07:08:13', NULL),
(69, 2, 13, 4, 1, 3, NULL, '2017-04-08 07:08:13', NULL),
(70, 2, 13, 5, 1, 3, NULL, '2017-04-08 07:08:13', NULL),
(71, 2, 14, 1, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(72, 2, 14, 2, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(73, 2, 14, 3, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(74, 2, 14, 4, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(75, 2, 14, 5, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(76, 61, 4, 1, 1, 3, NULL, '2017-05-11 06:24:45', NULL),
(77, 61, 4, 2, 1, 3, NULL, '2017-05-11 06:24:45', NULL),
(78, 61, 4, 3, 1, 3, NULL, '2017-05-11 06:24:45', NULL),
(79, 61, 4, 4, 1, 3, NULL, '2017-05-11 06:24:45', NULL),
(80, 61, 4, 5, 1, 3, NULL, '2017-05-11 06:24:45', NULL),
(81, 61, 1, 1, 1, 3, NULL, '2017-05-11 06:24:45', NULL),
(82, 61, 1, 2, 1, 3, NULL, '2017-05-11 06:24:45', NULL),
(83, 61, 1, 3, 1, 3, NULL, '2017-05-11 06:24:45', NULL),
(84, 61, 1, 4, 1, 3, NULL, '2017-05-11 06:24:46', NULL),
(85, 61, 1, 5, 1, 3, NULL, '2017-05-11 06:24:46', NULL),
(86, 61, 13, 1, 1, 3, NULL, '2017-05-11 06:24:46', NULL),
(87, 61, 13, 2, 1, 3, NULL, '2017-05-11 06:24:46', NULL),
(88, 61, 13, 3, 1, 3, NULL, '2017-05-11 06:24:46', NULL),
(89, 61, 13, 4, 1, 3, NULL, '2017-05-11 06:24:46', NULL),
(90, 61, 13, 5, 1, 3, NULL, '2017-05-11 06:24:46', NULL),
(91, 2, 15, 1, 1, 3, NULL, '2017-05-12 07:14:47', NULL),
(92, 2, 15, 2, 1, 3, NULL, '2017-05-12 07:14:47', NULL),
(93, 2, 15, 3, 1, 3, NULL, '2017-05-12 07:14:47', NULL),
(94, 2, 15, 4, 1, 3, NULL, '2017-05-12 07:14:47', NULL),
(95, 2, 15, 5, 1, 3, NULL, '2017-05-12 07:14:47', NULL),
(96, 2, 16, 1, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(97, 2, 16, 2, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(98, 2, 16, 3, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(99, 2, 16, 4, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(100, 2, 16, 5, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(101, 2, 17, 1, 1, 3, NULL, '2017-05-12 07:35:09', NULL),
(102, 2, 17, 2, 1, 3, NULL, '2017-05-12 07:35:09', NULL),
(103, 2, 17, 3, 1, 3, NULL, '2017-05-12 07:35:09', NULL),
(104, 2, 17, 4, 1, 3, NULL, '2017-05-12 07:35:09', NULL),
(105, 2, 17, 5, 1, 3, NULL, '2017-05-12 07:35:09', NULL),
(106, 2, 18, 1, 1, 3, NULL, '2017-05-13 05:42:10', NULL),
(107, 2, 18, 2, 1, 3, NULL, '2017-05-13 05:42:10', NULL),
(108, 2, 18, 3, 1, 3, NULL, '2017-05-13 05:42:10', NULL),
(109, 2, 18, 4, 1, 3, NULL, '2017-05-13 05:42:10', NULL),
(110, 2, 18, 5, 1, 3, NULL, '2017-05-13 05:42:10', NULL),
(111, 2, 19, 1, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(112, 2, 19, 2, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(113, 2, 19, 3, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(114, 2, 19, 4, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(115, 2, 19, 5, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(116, 61, 15, 1, 1, 30, NULL, '2017-05-16 06:16:40', NULL),
(117, 63, 4, 1, 1, 3, NULL, '2017-05-16 15:54:42', NULL),
(122, 63, 1, 1, 1, 3, NULL, '2017-05-16 15:54:48', NULL),
(123, 63, 1, 2, 1, 3, NULL, '2017-05-16 15:54:48', NULL),
(124, 63, 1, 3, 1, 3, NULL, '2017-05-16 15:54:48', NULL),
(125, 63, 1, 4, 1, 3, NULL, '2017-05-16 15:54:48', NULL),
(126, 63, 1, 5, 1, 3, NULL, '2017-05-16 15:54:48', NULL),
(128, 63, 19, 1, 1, 3, NULL, '2017-05-16 15:55:23', NULL),
(129, 63, 13, 1, 1, 3, NULL, '2017-05-16 15:55:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_master`
--

CREATE TABLE `course_master` (
  `id` int(11) NOT NULL,
  `view` int(11) NOT NULL DEFAULT '0',
  `folder` varchar(20) NOT NULL DEFAULT '',
  `image` text NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `category_id` int(11) NOT NULL COMMENT 'text, video'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_master`
--

INSERT INTO `course_master` (`id`, `view`, `folder`, `image`, `name`, `description`, `created_date`, `created_by`, `updated_date`, `active`, `category_id`) VALUES
(22, 107, 'html', 'HTML1494824204.jpg', 'HTML', 'HTML is the standard markup language for creating Web pages.', '2017-03-18 06:47:36', 3, '2017-05-15 06:59:06', 1, 1),
(27, 30, 'css', 'css1494824588.png', 'css', 'CSS is a language that describes the style of an HTML document.', '2017-03-25 05:22:18', 3, '2017-05-15 07:03:45', 1, 1),
(32, 59, 'video', 'html video1494824274.png', 'HTML Video', 'Html Is The Standard Markup Language For Creating Web Pages.', '2017-04-08 07:40:06', 3, '2017-05-15 07:05:19', 1, 2),
(33, 4, 'jquery', 'jquery-logo1494866786.png', 'jquery', 'jQuery is a fast, small, and feature-rich JavaScript library.', '2017-05-15 16:26:15', 3, '2017-05-15 18:59:13', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_tag_master`
--

CREATE TABLE `course_tag_master` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_tag_master`
--

INSERT INTO `course_tag_master` (`id`, `course_id`, `tag_id`) VALUES
(1, 22, 1),
(2, 22, 1),
(3, 27, 1),
(4, 32, 2),
(5, 33, 3);

-- --------------------------------------------------------

--
-- Table structure for table `course_topic_master`
--

CREATE TABLE `course_topic_master` (
  `id` int(11) NOT NULL,
  `sequence` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `filename` varchar(20) NOT NULL,
  `active` tinyint(4) DEFAULT '1',
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_topic_master`
--

INSERT INTO `course_topic_master` (`id`, `sequence`, `name`, `filename`, `active`, `course_id`) VALUES
(2, 3, 'heading', 'heading.php', 1, 22),
(3, 3, 'paragraph', 'paragraph.php', 1, 22),
(4, 3, 'forms', 'forms.php', 1, 22),
(6, 0, 'Introduction to html', 'introduction.php', 1, 22),
(7, 0, 'introduction', 'css_Intro.php', 1, 27),
(8, 1, 'topic1', 'topic1.php', 1, 32),
(9, 1, 'Basic HTML', 'Basic.php', 1, 22),
(10, 2, 'HTML Elements', 'Elements.php', 1, 22),
(11, 1, 'howto', 'css_howto.php', 1, 27),
(12, 2, 'syntax', 'css_syntax.php', 1, 27),
(13, 3, 'color', 'css_color.php', 1, 27),
(14, 1, 'jquery introduction', 'intro.php', 1, 33),
(15, 0, 'jquery home', 'home.php', 1, 33),
(16, 2, 'jquery syntax', 'syntax.php', 1, 33),
(17, 3, 'jquery selector', 'selector.php', 1, 33),
(18, 4, 'jquery event', 'event.php', 1, 33);

-- --------------------------------------------------------

--
-- Table structure for table `material_master`
--

CREATE TABLE `material_master` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `path` varchar(100) NOT NULL,
  `descrption` text,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `module_master`
--

CREATE TABLE `module_master` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `display_name` varchar(25) NOT NULL DEFAULT '',
  `dev_only` tinyint(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module_master`
--

INSERT INTO `module_master` (`id`, `name`, `display_name`, `dev_only`, `active`) VALUES
(1, 'index', 'home', 0, 1),
(2, 'usertype', 'usertype', 0, 1),
(3, 'user', 'user', 0, 1),
(4, 'courses', 'courses', 0, 1),
(5, 'category1', 'category', 0, 1),
(6, 'tag', 'tag', 0, 1),
(7, 'perpage', 'per page', 1, 1),
(8, 'module', 'modules', 0, 1),
(9, 'category', 'categories', 0, 1),
(10, 'operation', 'operations', 0, 1),
(11, 'module_operation', 'module operations', 1, 1),
(12, 'permission', 'permission', 0, 1),
(13, 'video', 'video', 0, 1),
(14, 'course_topic', 'course topic', 1, 1),
(15, 'quiz', 'quiz', 0, 1),
(16, 'quiz_question', 'quiz questions', 0, 1),
(17, 'quiz_answer', 'quiz answer', 0, 1),
(18, 'quiz_list', 'quiz list', 0, 1),
(19, 'start_quiz', 'start quiz', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_operation_master`
--

CREATE TABLE `module_operation_master` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module_operation_master`
--

INSERT INTO `module_operation_master` (`id`, `module_id`, `operation_id`, `active`, `created_by`, `updated_by`, `created_date`, `updated_date`) VALUES
(1, 1, 1, 1, 3, NULL, '2017-04-05 16:32:11', NULL),
(2, 1, 2, 1, 3, NULL, '2017-04-05 16:32:11', NULL),
(3, 1, 3, 1, 3, NULL, '2017-04-05 16:32:11', NULL),
(4, 1, 4, 1, 3, NULL, '2017-04-05 16:32:11', NULL),
(5, 1, 5, 1, 3, NULL, '2017-04-05 16:32:11', NULL),
(6, 1, 6, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(7, 1, 7, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(8, 1, 8, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(9, 1, 9, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(10, 1, 11, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(11, 1, 12, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(12, 1, 13, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(13, 2, 1, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(14, 2, 2, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(15, 2, 3, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(16, 2, 4, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(17, 2, 5, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(18, 2, 6, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(19, 2, 7, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(20, 2, 8, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(21, 2, 9, 1, 3, NULL, '2017-04-05 16:32:12', NULL),
(22, 2, 11, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(23, 2, 12, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(24, 2, 13, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(25, 3, 1, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(26, 3, 2, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(27, 3, 3, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(28, 3, 4, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(29, 3, 5, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(30, 3, 6, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(31, 3, 7, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(32, 3, 8, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(33, 3, 9, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(34, 3, 11, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(35, 3, 12, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(36, 3, 13, 1, 3, NULL, '2017-04-05 16:32:13', NULL),
(37, 4, 1, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(38, 4, 2, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(39, 4, 3, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(40, 4, 4, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(41, 4, 5, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(42, 4, 6, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(43, 4, 7, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(44, 4, 8, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(45, 4, 9, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(46, 4, 11, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(47, 4, 12, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(48, 4, 13, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(49, 5, 1, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(50, 5, 2, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(51, 5, 3, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(52, 5, 4, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(53, 5, 5, 1, 3, NULL, '2017-04-05 16:32:14', NULL),
(54, 5, 6, 1, 3, NULL, '2017-04-05 16:32:15', NULL),
(55, 5, 7, 1, 3, NULL, '2017-04-05 16:32:15', NULL),
(56, 5, 8, 1, 3, NULL, '2017-04-05 16:32:15', NULL),
(57, 5, 9, 1, 3, NULL, '2017-04-05 16:32:15', NULL),
(58, 5, 11, 1, 3, NULL, '2017-04-05 16:32:15', NULL),
(59, 5, 12, 1, 3, NULL, '2017-04-05 16:32:15', NULL),
(60, 5, 13, 1, 3, NULL, '2017-04-05 16:32:15', NULL),
(61, 6, 1, 1, 3, NULL, '2017-04-05 16:32:15', NULL),
(62, 6, 2, 1, 3, NULL, '2017-04-05 16:32:15', NULL),
(63, 6, 3, 1, 3, NULL, '2017-04-05 16:32:15', NULL),
(64, 6, 4, 1, 3, NULL, '2017-04-05 16:32:15', NULL),
(65, 6, 5, 1, 3, NULL, '2017-04-05 16:32:15', NULL),
(66, 6, 6, 1, 3, NULL, '2017-04-05 16:32:16', NULL),
(67, 6, 7, 1, 3, NULL, '2017-04-05 16:32:16', NULL),
(68, 6, 8, 1, 3, NULL, '2017-04-05 16:32:16', NULL),
(69, 6, 9, 1, 3, NULL, '2017-04-05 16:32:16', NULL),
(70, 6, 11, 1, 3, NULL, '2017-04-05 16:32:16', NULL),
(71, 6, 12, 1, 3, NULL, '2017-04-05 16:32:16', NULL),
(72, 6, 13, 1, 3, NULL, '2017-04-05 16:32:16', NULL),
(73, 7, 1, 1, 3, NULL, '2017-04-05 16:32:16', NULL),
(74, 7, 2, 1, 3, NULL, '2017-04-05 16:32:16', NULL),
(75, 7, 3, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(76, 7, 4, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(77, 7, 5, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(78, 7, 6, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(79, 7, 7, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(80, 7, 8, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(81, 7, 9, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(82, 7, 11, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(83, 7, 12, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(84, 7, 13, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(85, 8, 1, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(86, 8, 2, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(87, 8, 3, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(88, 8, 4, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(89, 8, 5, 1, 3, NULL, '2017-04-05 16:32:17', NULL),
(90, 8, 6, 1, 3, NULL, '2017-04-05 16:32:18', NULL),
(91, 8, 7, 1, 3, NULL, '2017-04-05 16:32:18', NULL),
(92, 8, 8, 1, 3, NULL, '2017-04-05 16:32:18', NULL),
(93, 8, 9, 1, 3, NULL, '2017-04-05 16:32:18', NULL),
(94, 8, 11, 1, 3, NULL, '2017-04-05 16:32:18', NULL),
(95, 8, 12, 1, 3, NULL, '2017-04-05 16:32:18', NULL),
(96, 8, 13, 1, 3, NULL, '2017-04-05 16:32:18', NULL),
(97, 9, 1, 1, 3, NULL, '2017-04-05 16:32:18', NULL),
(98, 9, 2, 1, 3, NULL, '2017-04-05 16:32:18', NULL),
(99, 9, 3, 1, 3, NULL, '2017-04-05 16:32:19', NULL),
(100, 9, 4, 1, 3, NULL, '2017-04-05 16:32:19', NULL),
(101, 9, 5, 1, 3, NULL, '2017-04-05 16:32:19', NULL),
(102, 9, 6, 1, 3, NULL, '2017-04-05 16:32:19', NULL),
(103, 9, 7, 1, 3, NULL, '2017-04-05 16:32:19', NULL),
(104, 9, 8, 1, 3, NULL, '2017-04-05 16:32:19', NULL),
(105, 9, 9, 1, 3, NULL, '2017-04-05 16:32:19', NULL),
(106, 9, 11, 1, 3, NULL, '2017-04-05 16:32:19', NULL),
(107, 9, 12, 1, 3, NULL, '2017-04-05 16:32:19', NULL),
(108, 9, 13, 1, 3, NULL, '2017-04-05 16:32:19', NULL),
(109, 10, 1, 1, 3, NULL, '2017-04-05 16:32:19', NULL),
(110, 10, 2, 1, 3, NULL, '2017-04-05 16:32:19', NULL),
(111, 10, 3, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(112, 10, 4, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(113, 10, 5, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(114, 10, 6, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(115, 10, 7, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(116, 10, 8, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(117, 10, 9, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(118, 10, 11, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(119, 10, 12, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(120, 10, 13, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(121, 11, 1, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(122, 11, 2, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(123, 11, 3, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(124, 11, 4, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(125, 11, 5, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(126, 11, 6, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(127, 11, 7, 1, 3, NULL, '2017-04-05 16:32:20', NULL),
(128, 11, 8, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(129, 11, 9, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(130, 11, 11, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(131, 11, 12, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(132, 11, 13, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(133, 12, 1, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(134, 12, 2, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(135, 12, 3, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(136, 12, 4, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(137, 12, 5, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(138, 12, 6, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(139, 12, 7, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(140, 12, 8, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(141, 12, 9, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(142, 12, 11, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(143, 12, 12, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(144, 12, 13, 1, 3, NULL, '2017-04-05 16:32:21', NULL),
(145, 3, 10, 1, 3, NULL, '2017-04-05 16:53:07', NULL),
(434, 13, 1, 1, 3, NULL, '2017-04-08 07:07:39', NULL),
(435, 13, 2, 1, 3, NULL, '2017-04-08 07:07:39', NULL),
(436, 13, 3, 1, 3, NULL, '2017-04-08 07:07:39', NULL),
(437, 13, 4, 1, 3, NULL, '2017-04-08 07:07:39', NULL),
(438, 13, 5, 1, 3, NULL, '2017-04-08 07:07:39', NULL),
(439, 13, 6, 1, 3, NULL, '2017-04-08 07:07:39', NULL),
(440, 13, 7, 1, 3, NULL, '2017-04-08 07:07:39', NULL),
(441, 13, 8, 1, 3, NULL, '2017-04-08 07:07:39', NULL),
(442, 13, 9, 1, 3, NULL, '2017-04-08 07:07:39', NULL),
(443, 13, 11, 1, 3, NULL, '2017-04-08 07:07:39', NULL),
(444, 13, 12, 1, 3, NULL, '2017-04-08 07:07:39', NULL),
(445, 13, 13, 1, 3, NULL, '2017-04-08 07:07:39', NULL),
(602, 14, 1, 1, 3, NULL, '2017-04-16 06:30:55', NULL),
(603, 14, 2, 1, 3, NULL, '2017-04-16 06:30:55', NULL),
(604, 14, 3, 1, 3, NULL, '2017-04-16 06:30:55', NULL),
(605, 14, 4, 1, 3, NULL, '2017-04-16 06:30:55', NULL),
(606, 14, 5, 1, 3, NULL, '2017-04-16 06:30:55', NULL),
(607, 14, 6, 1, 3, NULL, '2017-04-16 06:30:55', NULL),
(608, 14, 7, 1, 3, NULL, '2017-04-16 06:30:55', NULL),
(609, 14, 8, 1, 3, NULL, '2017-04-16 06:30:55', NULL),
(610, 14, 9, 1, 3, NULL, '2017-04-16 06:30:55', NULL),
(611, 14, 11, 1, 3, NULL, '2017-04-16 06:30:55', NULL),
(612, 14, 12, 1, 3, NULL, '2017-04-16 06:30:55', NULL),
(613, 14, 13, 1, 3, NULL, '2017-04-16 06:30:55', NULL),
(782, 15, 1, 1, 3, NULL, '2017-05-12 07:14:28', NULL),
(783, 15, 2, 1, 3, NULL, '2017-05-12 07:14:28', NULL),
(784, 15, 3, 1, 3, NULL, '2017-05-12 07:14:29', NULL),
(785, 15, 4, 1, 3, NULL, '2017-05-12 07:14:29', NULL),
(786, 15, 5, 1, 3, NULL, '2017-05-12 07:14:29', NULL),
(787, 15, 6, 1, 3, NULL, '2017-05-12 07:14:29', NULL),
(788, 15, 7, 1, 3, NULL, '2017-05-12 07:14:29', NULL),
(789, 15, 8, 1, 3, NULL, '2017-05-12 07:14:29', NULL),
(790, 15, 9, 1, 3, NULL, '2017-05-12 07:14:29', NULL),
(791, 15, 11, 1, 3, NULL, '2017-05-12 07:14:29', NULL),
(792, 15, 12, 1, 3, NULL, '2017-05-12 07:14:29', NULL),
(793, 15, 13, 1, 3, NULL, '2017-05-12 07:14:29', NULL),
(974, 16, 1, 1, 3, NULL, '2017-05-12 07:21:57', NULL),
(975, 16, 2, 1, 3, NULL, '2017-05-12 07:21:57', NULL),
(976, 16, 3, 1, 3, NULL, '2017-05-12 07:21:57', NULL),
(977, 16, 4, 1, 3, NULL, '2017-05-12 07:21:57', NULL),
(978, 16, 5, 1, 3, NULL, '2017-05-12 07:21:57', NULL),
(979, 16, 6, 1, 3, NULL, '2017-05-12 07:21:57', NULL),
(980, 16, 7, 1, 3, NULL, '2017-05-12 07:21:57', NULL),
(981, 16, 8, 1, 3, NULL, '2017-05-12 07:21:58', NULL),
(982, 16, 9, 1, 3, NULL, '2017-05-12 07:21:58', NULL),
(983, 16, 11, 1, 3, NULL, '2017-05-12 07:21:58', NULL),
(984, 16, 12, 1, 3, NULL, '2017-05-12 07:21:58', NULL),
(985, 16, 13, 1, 3, NULL, '2017-05-12 07:21:58', NULL),
(1178, 17, 1, 1, 3, NULL, '2017-05-12 07:34:50', NULL),
(1179, 17, 2, 1, 3, NULL, '2017-05-12 07:34:50', NULL),
(1180, 17, 3, 1, 3, NULL, '2017-05-12 07:34:50', NULL),
(1181, 17, 4, 1, 3, NULL, '2017-05-12 07:34:51', NULL),
(1182, 17, 5, 1, 3, NULL, '2017-05-12 07:34:51', NULL),
(1183, 17, 6, 1, 3, NULL, '2017-05-12 07:34:51', NULL),
(1184, 17, 7, 1, 3, NULL, '2017-05-12 07:34:51', NULL),
(1185, 17, 8, 1, 3, NULL, '2017-05-12 07:34:51', NULL),
(1186, 17, 9, 1, 3, NULL, '2017-05-12 07:34:51', NULL),
(1187, 17, 11, 1, 3, NULL, '2017-05-12 07:34:51', NULL),
(1188, 17, 12, 1, 3, NULL, '2017-05-12 07:34:51', NULL),
(1189, 17, 13, 1, 3, NULL, '2017-05-12 07:34:52', NULL),
(1394, 18, 1, 1, 3, NULL, '2017-05-13 05:41:53', NULL),
(1395, 18, 2, 1, 3, NULL, '2017-05-13 05:41:53', NULL),
(1396, 18, 3, 1, 3, NULL, '2017-05-13 05:41:53', NULL),
(1397, 18, 4, 1, 3, NULL, '2017-05-13 05:41:53', NULL),
(1398, 18, 5, 1, 3, NULL, '2017-05-13 05:41:53', NULL),
(1399, 18, 6, 1, 3, NULL, '2017-05-13 05:41:54', NULL),
(1400, 18, 7, 1, 3, NULL, '2017-05-13 05:41:54', NULL),
(1401, 18, 8, 1, 3, NULL, '2017-05-13 05:41:54', NULL),
(1402, 18, 9, 1, 3, NULL, '2017-05-13 05:41:54', NULL),
(1403, 18, 11, 1, 3, NULL, '2017-05-13 05:41:54', NULL),
(1404, 18, 12, 1, 3, NULL, '2017-05-13 05:41:54', NULL),
(1405, 18, 13, 1, 3, NULL, '2017-05-13 05:41:54', NULL),
(1406, 4, 14, 1, 3, NULL, '2017-05-13 06:14:52', NULL),
(1407, 15, 14, 1, 3, NULL, '2017-05-13 06:37:40', NULL),
(1624, 19, 1, 1, 3, NULL, '2017-05-13 06:58:30', NULL),
(1625, 19, 2, 1, 3, NULL, '2017-05-13 06:58:30', NULL),
(1626, 19, 3, 1, 3, NULL, '2017-05-13 06:58:30', NULL),
(1627, 19, 4, 1, 3, NULL, '2017-05-13 06:58:30', NULL),
(1628, 19, 5, 1, 3, NULL, '2017-05-13 06:58:30', NULL),
(1629, 19, 6, 1, 3, NULL, '2017-05-13 06:58:30', NULL),
(1630, 19, 7, 1, 3, NULL, '2017-05-13 06:58:30', NULL),
(1631, 19, 8, 1, 3, NULL, '2017-05-13 06:58:30', NULL),
(1632, 19, 9, 1, 3, NULL, '2017-05-13 06:58:30', NULL),
(1633, 19, 11, 1, 3, NULL, '2017-05-13 06:58:30', NULL),
(1634, 19, 12, 1, 3, NULL, '2017-05-13 06:58:30', NULL),
(1635, 19, 13, 1, 3, NULL, '2017-05-13 06:58:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `operation_master`
--

CREATE TABLE `operation_master` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `common` varchar(10) NOT NULL DEFAULT 'common',
  `sequence` int(11) NOT NULL DEFAULT '1',
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `operation_master`
--

INSERT INTO `operation_master` (`id`, `name`, `common`, `sequence`, `active`) VALUES
(1, 'view', 'common', 1, 1),
(2, 'add', 'common', 2, 1),
(3, 'edit', 'common', 3, 1),
(4, 'delete', 'common', 4, 1),
(5, 'activate', 'common', 5, 1),
(6, 'deactivate', 'common', 6, 1),
(7, 'restore', 'common', 7, 1),
(8, 'destroy', 'common', 8, 1),
(9, 'harddelete', 'common', 9, 1),
(10, 'password', 'specific', 10, 1),
(11, 'print', 'common', 11, 1),
(12, 'pdf', 'common', 12, 1),
(13, 'excel', 'common', 13, 1),
(14, 'grid', 'specific', 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `operation_permission_master`
--

CREATE TABLE `operation_permission_master` (
  `id` int(11) NOT NULL,
  `usertype_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `operation_permission_master`
--

INSERT INTO `operation_permission_master` (`id`, `usertype_id`, `module_id`, `operation_id`, `active`, `created_by`, `updated_by`, `created_date`, `updated_date`) VALUES
(1, 2, 9, 1, 1, 3, NULL, '2017-04-05 16:37:10', NULL),
(2, 2, 9, 2, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(3, 2, 9, 3, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(4, 2, 9, 4, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(5, 2, 9, 5, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(6, 2, 9, 6, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(7, 2, 9, 7, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(8, 2, 9, 8, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(9, 2, 9, 9, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(10, 2, 9, 11, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(11, 2, 9, 12, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(12, 2, 9, 13, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(13, 2, 5, 1, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(14, 2, 5, 2, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(15, 2, 5, 3, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(16, 2, 5, 4, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(17, 2, 5, 5, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(18, 2, 5, 6, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(19, 2, 5, 7, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(20, 2, 5, 8, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(21, 2, 5, 9, 1, 3, NULL, '2017-04-05 16:37:11', NULL),
(22, 2, 5, 11, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(23, 2, 5, 12, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(24, 2, 5, 13, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(25, 2, 4, 1, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(26, 2, 4, 2, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(27, 2, 4, 3, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(34, 2, 4, 11, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(35, 2, 4, 12, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(36, 2, 4, 13, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(37, 2, 1, 1, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(38, 2, 1, 2, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(39, 2, 1, 3, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(40, 2, 1, 4, 1, 3, NULL, '2017-04-05 16:37:12', NULL),
(41, 2, 1, 5, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(42, 2, 1, 6, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(43, 2, 1, 7, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(44, 2, 1, 8, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(45, 2, 1, 9, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(46, 2, 1, 11, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(47, 2, 1, 12, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(48, 2, 1, 13, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(49, 2, 11, 1, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(50, 2, 11, 2, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(51, 2, 11, 3, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(52, 2, 11, 4, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(53, 2, 11, 5, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(54, 2, 11, 6, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(55, 2, 11, 7, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(56, 2, 11, 8, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(57, 2, 11, 9, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(58, 2, 11, 11, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(59, 2, 11, 12, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(60, 2, 11, 13, 1, 3, NULL, '2017-04-05 16:37:13', NULL),
(61, 2, 8, 1, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(62, 2, 8, 2, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(63, 2, 8, 3, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(64, 2, 8, 4, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(65, 2, 8, 5, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(66, 2, 8, 6, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(67, 2, 8, 7, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(68, 2, 8, 8, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(69, 2, 8, 9, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(70, 2, 8, 11, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(71, 2, 8, 12, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(72, 2, 8, 13, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(73, 2, 10, 1, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(74, 2, 10, 2, 1, 3, NULL, '2017-04-05 16:37:14', NULL),
(75, 2, 10, 3, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(76, 2, 10, 4, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(77, 2, 10, 5, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(78, 2, 10, 6, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(79, 2, 10, 7, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(80, 2, 10, 8, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(81, 2, 10, 9, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(82, 2, 10, 11, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(83, 2, 10, 12, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(84, 2, 10, 13, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(85, 2, 7, 1, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(86, 2, 7, 2, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(87, 2, 7, 3, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(88, 2, 7, 4, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(89, 2, 7, 5, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(90, 2, 7, 6, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(91, 2, 7, 7, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(92, 2, 7, 8, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(93, 2, 7, 9, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(94, 2, 7, 11, 1, 3, NULL, '2017-04-05 16:37:15', NULL),
(95, 2, 7, 12, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(96, 2, 7, 13, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(97, 2, 12, 1, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(98, 2, 12, 2, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(99, 2, 12, 3, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(100, 2, 12, 4, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(101, 2, 12, 5, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(102, 2, 12, 6, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(103, 2, 12, 7, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(104, 2, 12, 8, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(105, 2, 12, 9, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(106, 2, 12, 11, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(107, 2, 12, 12, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(108, 2, 12, 13, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(109, 2, 6, 1, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(110, 2, 6, 2, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(111, 2, 6, 3, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(112, 2, 6, 4, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(113, 2, 6, 5, 1, 3, NULL, '2017-04-05 16:37:16', NULL),
(114, 2, 6, 6, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(115, 2, 6, 7, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(116, 2, 6, 8, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(117, 2, 6, 9, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(118, 2, 6, 11, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(119, 2, 6, 12, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(120, 2, 6, 13, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(121, 2, 3, 1, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(122, 2, 3, 2, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(123, 2, 3, 3, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(124, 2, 3, 4, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(125, 2, 3, 5, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(126, 2, 3, 6, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(127, 2, 3, 7, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(128, 2, 3, 8, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(129, 2, 3, 9, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(130, 2, 3, 11, 1, 3, NULL, '2017-04-05 16:37:17', NULL),
(131, 2, 3, 12, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(132, 2, 3, 13, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(133, 2, 2, 1, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(134, 2, 2, 2, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(135, 2, 2, 3, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(136, 2, 2, 4, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(137, 2, 2, 5, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(138, 2, 2, 6, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(139, 2, 2, 7, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(140, 2, 2, 8, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(141, 2, 2, 9, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(142, 2, 2, 11, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(143, 2, 2, 12, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(144, 2, 2, 13, 1, 3, NULL, '2017-04-05 16:37:18', NULL),
(145, 2, 3, 10, 1, 3, NULL, '2017-04-05 16:53:17', NULL),
(146, 61, 9, 1, 1, 3, NULL, '2017-04-08 06:18:41', NULL),
(147, 61, 9, 2, 1, 3, NULL, '2017-04-08 06:18:41', NULL),
(148, 61, 9, 3, 1, 3, NULL, '2017-04-08 06:18:41', NULL),
(149, 61, 9, 4, 1, 3, NULL, '2017-04-08 06:18:42', NULL),
(150, 61, 9, 5, 1, 3, NULL, '2017-04-08 06:18:42', NULL),
(151, 61, 9, 6, 1, 3, NULL, '2017-04-08 06:18:42', NULL),
(152, 61, 9, 7, 1, 3, NULL, '2017-04-08 06:18:42', NULL),
(153, 61, 9, 8, 1, 3, NULL, '2017-04-08 06:18:42', NULL),
(154, 61, 9, 9, 1, 3, NULL, '2017-04-08 06:18:42', NULL),
(155, 61, 9, 11, 1, 3, NULL, '2017-04-08 06:18:42', NULL),
(156, 61, 9, 12, 1, 3, NULL, '2017-04-08 06:18:42', NULL),
(157, 61, 9, 13, 1, 3, NULL, '2017-04-08 06:18:42', NULL),
(158, 62, 4, 1, 1, 3, NULL, '2017-04-08 06:32:46', NULL),
(159, 62, 1, 1, 1, 3, NULL, '2017-04-08 06:32:46', NULL),
(160, 2, 13, 1, 1, 3, NULL, '2017-04-08 07:08:13', NULL),
(161, 2, 13, 2, 1, 3, NULL, '2017-04-08 07:08:13', NULL),
(162, 2, 13, 3, 1, 3, NULL, '2017-04-08 07:08:13', NULL),
(163, 2, 13, 4, 1, 3, NULL, '2017-04-08 07:08:13', NULL),
(164, 2, 13, 5, 1, 3, NULL, '2017-04-08 07:08:13', NULL),
(165, 2, 13, 6, 1, 3, NULL, '2017-04-08 07:08:14', NULL),
(166, 2, 13, 7, 1, 3, NULL, '2017-04-08 07:08:14', NULL),
(167, 2, 13, 8, 1, 3, NULL, '2017-04-08 07:08:14', NULL),
(168, 2, 13, 9, 1, 3, NULL, '2017-04-08 07:08:14', NULL),
(169, 2, 13, 11, 1, 3, NULL, '2017-04-08 07:08:14', NULL),
(170, 2, 13, 12, 1, 3, NULL, '2017-04-08 07:08:14', NULL),
(171, 2, 13, 13, 1, 3, NULL, '2017-04-08 07:08:14', NULL),
(172, 2, 14, 1, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(173, 2, 14, 2, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(174, 2, 14, 3, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(175, 2, 14, 4, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(176, 2, 14, 5, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(177, 2, 14, 6, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(178, 2, 14, 7, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(179, 2, 14, 8, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(180, 2, 14, 9, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(181, 2, 14, 11, 1, 3, NULL, '2017-04-16 06:31:16', NULL),
(182, 2, 14, 12, 1, 3, NULL, '2017-04-16 06:31:17', NULL),
(183, 2, 14, 13, 1, 3, NULL, '2017-04-16 06:31:17', NULL),
(184, 61, 4, 1, 1, 3, NULL, '2017-05-11 06:24:46', NULL),
(185, 61, 4, 11, 1, 3, NULL, '2017-05-11 06:24:46', NULL),
(186, 61, 4, 12, 1, 3, NULL, '2017-05-11 06:24:46', NULL),
(187, 61, 4, 13, 1, 3, NULL, '2017-05-11 06:24:46', NULL),
(188, 61, 1, 1, 1, 3, NULL, '2017-05-11 06:24:46', NULL),
(189, 61, 1, 11, 1, 3, NULL, '2017-05-11 06:24:47', NULL),
(190, 61, 1, 12, 1, 3, NULL, '2017-05-11 06:24:47', NULL),
(191, 61, 1, 13, 1, 3, NULL, '2017-05-11 06:24:47', NULL),
(192, 61, 13, 1, 1, 3, NULL, '2017-05-11 06:24:47', NULL),
(193, 61, 13, 11, 1, 3, NULL, '2017-05-11 06:24:47', NULL),
(194, 61, 13, 12, 1, 3, NULL, '2017-05-11 06:24:47', NULL),
(195, 61, 13, 13, 1, 3, NULL, '2017-05-11 06:24:47', NULL),
(196, 2, 15, 1, 1, 3, NULL, '2017-05-12 07:14:47', NULL),
(197, 2, 15, 2, 1, 3, NULL, '2017-05-12 07:14:47', NULL),
(198, 2, 15, 3, 1, 3, NULL, '2017-05-12 07:14:47', NULL),
(199, 2, 15, 4, 1, 3, NULL, '2017-05-12 07:14:47', NULL),
(200, 2, 15, 5, 1, 3, NULL, '2017-05-12 07:14:47', NULL),
(201, 2, 15, 6, 1, 3, NULL, '2017-05-12 07:14:47', NULL),
(202, 2, 15, 7, 1, 3, NULL, '2017-05-12 07:14:47', NULL),
(203, 2, 15, 8, 1, 3, NULL, '2017-05-12 07:14:48', NULL),
(204, 2, 15, 9, 1, 3, NULL, '2017-05-12 07:14:48', NULL),
(205, 2, 15, 11, 1, 3, NULL, '2017-05-12 07:14:48', NULL),
(206, 2, 15, 12, 1, 3, NULL, '2017-05-12 07:14:48', NULL),
(207, 2, 15, 13, 1, 3, NULL, '2017-05-12 07:14:48', NULL),
(208, 2, 16, 1, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(209, 2, 16, 2, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(210, 2, 16, 3, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(211, 2, 16, 4, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(212, 2, 16, 5, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(213, 2, 16, 6, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(214, 2, 16, 7, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(215, 2, 16, 8, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(216, 2, 16, 9, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(217, 2, 16, 11, 1, 3, NULL, '2017-05-12 07:22:12', NULL),
(218, 2, 16, 12, 1, 3, NULL, '2017-05-12 07:22:13', NULL),
(219, 2, 16, 13, 1, 3, NULL, '2017-05-12 07:22:13', NULL),
(220, 2, 17, 1, 1, 3, NULL, '2017-05-12 07:35:09', NULL),
(221, 2, 17, 2, 1, 3, NULL, '2017-05-12 07:35:10', NULL),
(222, 2, 17, 3, 1, 3, NULL, '2017-05-12 07:35:10', NULL),
(223, 2, 17, 4, 1, 3, NULL, '2017-05-12 07:35:10', NULL),
(224, 2, 17, 5, 1, 3, NULL, '2017-05-12 07:35:10', NULL),
(225, 2, 17, 6, 1, 3, NULL, '2017-05-12 07:35:10', NULL),
(226, 2, 17, 7, 1, 3, NULL, '2017-05-12 07:35:10', NULL),
(227, 2, 17, 8, 1, 3, NULL, '2017-05-12 07:35:10', NULL),
(228, 2, 17, 9, 1, 3, NULL, '2017-05-12 07:35:10', NULL),
(229, 2, 17, 11, 1, 3, NULL, '2017-05-12 07:35:10', NULL),
(230, 2, 17, 12, 1, 3, NULL, '2017-05-12 07:35:10', NULL),
(231, 2, 17, 13, 1, 3, NULL, '2017-05-12 07:35:10', NULL),
(232, 2, 18, 1, 1, 3, NULL, '2017-05-13 05:42:10', NULL),
(233, 2, 18, 2, 1, 3, NULL, '2017-05-13 05:42:11', NULL),
(234, 2, 18, 3, 1, 3, NULL, '2017-05-13 05:42:11', NULL),
(235, 2, 18, 4, 1, 3, NULL, '2017-05-13 05:42:11', NULL),
(236, 2, 18, 5, 1, 3, NULL, '2017-05-13 05:42:11', NULL),
(237, 2, 18, 6, 1, 3, NULL, '2017-05-13 05:42:11', NULL),
(238, 2, 18, 7, 1, 3, NULL, '2017-05-13 05:42:11', NULL),
(239, 2, 18, 8, 1, 3, NULL, '2017-05-13 05:42:11', NULL),
(240, 2, 18, 9, 1, 3, NULL, '2017-05-13 05:42:11', NULL),
(241, 2, 18, 11, 1, 3, NULL, '2017-05-13 05:42:11', NULL),
(242, 2, 18, 12, 1, 3, NULL, '2017-05-13 05:42:11', NULL),
(243, 2, 18, 13, 1, 3, NULL, '2017-05-13 05:42:11', NULL),
(244, 2, 4, 14, 1, 3, NULL, '2017-05-13 06:15:06', NULL),
(245, 2, 4, 4, 1, 3, NULL, '2017-05-13 06:17:50', NULL),
(246, 2, 4, 5, 1, 3, NULL, '2017-05-13 06:17:50', NULL),
(247, 2, 4, 6, 1, 3, NULL, '2017-05-13 06:17:50', NULL),
(248, 2, 4, 7, 1, 3, NULL, '2017-05-13 06:17:50', NULL),
(249, 2, 4, 8, 1, 3, NULL, '2017-05-13 06:17:50', NULL),
(250, 2, 4, 9, 1, 3, NULL, '2017-05-13 06:17:50', NULL),
(251, 2, 15, 14, 1, 3, NULL, '2017-05-13 06:38:45', NULL),
(252, 2, 19, 1, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(253, 2, 19, 2, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(254, 2, 19, 3, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(255, 2, 19, 4, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(256, 2, 19, 5, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(257, 2, 19, 6, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(258, 2, 19, 7, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(259, 2, 19, 8, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(260, 2, 19, 9, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(261, 2, 19, 11, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(262, 2, 19, 12, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(263, 2, 19, 13, 1, 3, NULL, '2017-05-13 06:58:51', NULL),
(264, 61, 15, 1, 1, 30, NULL, '2017-05-16 06:16:40', NULL),
(265, 61, 15, 11, 1, 30, NULL, '2017-05-16 06:16:40', NULL),
(266, 61, 15, 12, 1, 30, NULL, '2017-05-16 06:16:40', NULL),
(267, 61, 15, 13, 1, 30, NULL, '2017-05-16 06:16:40', NULL),
(268, 63, 4, 1, 1, 3, NULL, '2017-05-16 15:54:42', NULL),
(269, 63, 1, 1, 1, 3, NULL, '2017-05-16 15:54:48', NULL),
(271, 63, 19, 1, 1, 3, NULL, '2017-05-16 15:55:23', NULL),
(272, 63, 13, 1, 1, 3, NULL, '2017-05-16 15:55:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `per_page_master`
--

CREATE TABLE `per_page_master` (
  `id` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `per_page_master`
--

INSERT INTO `per_page_master` (`id`, `page`, `active`) VALUES
(4, 50, 1),
(5, 6, -2),
(6, 100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_answer_master`
--

CREATE TABLE `quiz_answer_master` (
  `id` int(11) NOT NULL,
  `quiz_question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `is_answer` varchar(3) NOT NULL DEFAULT 'no' COMMENT '1=Answer',
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `quiz_answer_master`
--

INSERT INTO `quiz_answer_master` (`id`, `quiz_question_id`, `answer`, `is_answer`, `active`) VALUES
(8, 1, 'Hyper Text Markup Language', 'yes', 1),
(9, 1, 'Home Tool Markup Language', '', 1),
(10, 1, 'Hyperlinks and Text Markup Language', '', 1),
(11, 1, 'Hyperlinks and Hypertext and Text Markup Language', '', 1),
(13, 2, 'Mozilla', '', 1),
(14, 2, 'The World Wide Web Consortium', 'yes', 1),
(16, 2, 'Google', '', 1),
(17, 5, '<h1>', 'yes', 1),
(18, 5, '<h2>', '', 1),
(19, 5, '<h3>', '', 1),
(20, 5, '<h6>', '', 1),
(21, 6, '<br>', '', 1),
(22, 6, '<break>', '', 1),
(23, 6, '<br/>', '', 1),
(24, 6, 'both <br> and <br/> used', 'yes', 1),
(25, 7, '<body style=\"background-color:yellow;\">', 'yes', 1),
(26, 7, '<body style=\"backgroundcolor:yellow;\">', '', 1),
(27, 7, '<background>yellow</background>', '', 1),
(28, 7, '<body bg=\"yellow\">', '', 1),
(29, 8, '<strong>', 'yes', 1),
(30, 8, '<b>', '', 1),
(32, 2, 'microsoft', '', 1),
(33, 8, '<important>', 'no', 1),
(34, 8, '<i>', '', 1),
(35, 9, '<italic>', '', 1),
(36, 9, '<em>', 'yes', 1),
(37, 9, '<i>', '', 1),
(38, 9, '<strong>', '', 1),
(39, 10, '<a name=\"http://www.w3schools.com\">W3Schools.com</a>', '', 1),
(40, 10, '<a>http://www.w3schools.com</a>', '', 1),
(41, 10, '<a url=\"http://www.w3schools.com\">W3Schools.com</a>', '', 1),
(42, 10, '<a href=\"http://www.w3schools.com\">W3Schools</a>', 'yes', 1),
(43, 11, '*', '', 1),
(44, 11, '<', '', 1),
(45, 11, '>', '', 1),
(46, 11, '/', 'yes', 1),
(47, 12, '<a href=\"url\" target=\"_blank\">', 'yes', 1),
(48, 12, '<a href=\"url\" new>', '', 1),
(49, 12, '<a href=\"url\" target=\"new\">', '', 1),
(50, 12, '<a href=\"url\" target=\"_new\">', '', 1),
(51, 14, '<link rel=\"stylesheet\" type=\"text/css\" href=\"mystyle.css\">', 'yes', 1),
(52, 13, 'Computer Style Sheets', '', 1),
(53, 13, 'Cascading Style Sheets', 'yes', 1),
(54, 13, 'Colorful Style Sheets', 'no', 1),
(55, 13, 'Creative Style Sheets', '', 1),
(56, 14, '<stylesheet>mystyle.css</stylesheet>', 'no', 1),
(57, 14, '<style src=\"mystyle.css\">', '', 1),
(58, 14, '<style rel=\"mystyle.css\">', '', 1),
(59, 15, 'In the <head> section', 'yes', 1),
(60, 15, 'At the end of the document', 'no', 1),
(61, 15, 'In the <body> section', '', 1),
(62, 15, 'In the <style> section', '', 1),
(63, 16, '<script>', '', 1),
(64, 16, '<css>', '', 1),
(65, 16, '<style>', 'yes', 1),
(66, 16, '<body>', 'no', 1),
(67, 17, 'class', '', 1),
(68, 17, 'styles', '', 1),
(69, 17, 'font', '', 1),
(70, 17, 'style', 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_master`
--

CREATE TABLE `quiz_master` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_master`
--

INSERT INTO `quiz_master` (`id`, `name`, `time`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`, `description`) VALUES
(1, 'HTML Quiz 1', 5, 0, '0000-00-00 00:00:00', NULL, NULL, 1, NULL),
(2, 'css quiz', 5, 0, '0000-00-00 00:00:00', NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question_master`
--

CREATE TABLE `quiz_question_master` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `mark` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_question_master`
--

INSERT INTO `quiz_question_master` (`id`, `quiz_id`, `name`, `mark`, `active`) VALUES
(1, 1, 'What does HTML stand for?', 1, 1),
(2, 1, 'Who is making the Web standards?', 1, 1),
(5, 1, 'Choose the correct HTML element for the largest heading:', 1, 1),
(6, 1, 'What is the correct HTML element for inserting a line break?', 1, 1),
(7, 1, 'What is the correct HTML for adding a background color?', 1, 1),
(8, 1, 'Choose the correct HTML element to define important text', 1, 1),
(9, 1, 'Choose the correct HTML element to define emphasized text', 1, 1),
(10, 1, 'What is the correct HTML for creating a hyperlink?', 1, 1),
(11, 1, 'Which character is used to indicate an end tag?', 1, 1),
(12, 1, 'How can you open a link in a new tab/browser window?', 1, 1),
(13, 2, 'What does CSS stand for?', 1, 1),
(14, 2, 'What is the correct HTML for referring to an external style sheet?', 1, 1),
(15, 2, 'Where in an HTML document is the correct place to refer to an external style sheet?', 1, 1),
(16, 2, 'Which HTML tag is used to define an internal style sheet?', 1, 1),
(17, 2, 'Which HTML attribute is used to define inline styles?', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_tag_master`
--

CREATE TABLE `quiz_tag_master` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review_master`
--

CREATE TABLE `review_master` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review_by` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `message` text,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review_master`
--

INSERT INTO `review_master` (`id`, `course_id`, `rating`, `review_by`, `title`, `message`, `date`) VALUES
(2, 27, 3, 3, '', '', '2017-05-15 18:48:06'),
(4, 27, 2, 30, 'fhfg', 'ghjkghkjh', '2017-05-11 06:32:57'),
(5, 22, 5, 3, 'ddddddd', 'aaaaaaaaaaaaa', '2017-05-11 07:18:28'),
(6, 32, 3, 3, 'sdfa', 'v asdfasdfasdf', '2017-05-11 07:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `tag_master`
--

CREATE TABLE `tag_master` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag_master`
--

INSERT INTO `tag_master` (`id`, `name`, `active`) VALUES
(1, 'programming', 1),
(2, 'database', 1),
(3, 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usertype_master`
--

CREATE TABLE `usertype_master` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertype_master`
--

INSERT INTO `usertype_master` (`id`, `name`, `active`, `created_by`, `updated_by`, `created_date`, `updated_date`) VALUES
(2, 'developer', 1, NULL, 3, '2017-01-12 00:00:00', '2017-04-05 16:36:22'),
(59, 'tutor', 1, 3, NULL, '2017-02-09 07:32:10', NULL),
(60, 'moderator', 1, 3, 3, '2017-02-09 07:32:14', NULL),
(61, 'student', 1, 3, NULL, '2017-02-09 07:32:45', NULL),
(62, 'non-registered', 1, 3, NULL, '2017-04-08 06:31:58', NULL),
(63, 'guest', 1, 3, NULL, '2017-05-13 05:45:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `id` int(11) NOT NULL,
  `usertype_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified` tinyint(4) NOT NULL DEFAULT '0',
  `password` varchar(256) DEFAULT NULL,
  `activation_key` varchar(256) DEFAULT NULL,
  `recovery_key` varchar(256) DEFAULT NULL,
  `recovery_key_time` datetime DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text,
  `mobile` decimal(15,0) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`id`, `usertype_id`, `name`, `email`, `email_verified`, `password`, `activation_key`, `recovery_key`, `recovery_key_time`, `dob`, `address`, `mobile`, `gender`, `module_id`, `active`, `created_date`, `created_by`, `updated_by`, `updated_date`) VALUES
(3, 2, 'Krunal Patel', 'krunal273@gmail.com', 1, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', NULL, NULL, NULL, '2017-01-12', NULL, NULL, 'male', 4, 1, '2017-01-12 00:00:00', NULL, 3, '2017-05-14 07:33:39'),
(22, 61, 'hitesh', 'hbvaghela83@gmail.com', 0, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00 00:00:00', NULL, 3, '2017-05-14 07:29:59'),
(24, 61, 'asdfds', 'hbvaghela83@hotmail.com', 0, '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0000-00-00 00:00:00', NULL, NULL, NULL),
(25, 61, 'yash patel', 'pyash1091@gmail.com', 0, '7c222fb2927d828af22f592134e8932480637c0d', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0000-00-00 00:00:00', NULL, NULL, NULL),
(30, 61, 'sugnesh patel', 'patelsugnesh2552@gmail.com', 1, '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 'buVjmljfYwFQZKKEsmSksKv8ERvQ1vrGfagQL9V5LhSavNdenu', NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, '0000-00-00 00:00:00', NULL, 3, '2017-05-16 06:12:17'),
(31, 63, 'guest', 'guest@gmail.com', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, '2017-05-13 05:46:23', 3, 3, '2017-05-14 07:33:17');

-- --------------------------------------------------------

--
-- Table structure for table `video_master`
--

CREATE TABLE `video_master` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `video` text NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_master`
--

INSERT INTO `video_master` (`id`, `course_id`, `video`, `title`, `description`, `created_date`, `created_by`, `updated_date`, `active`) VALUES
(1, 27, 'movie - Copy1491630063.mp4', 'safsdf', 'asdfsdfasdf', '2017-04-08 07:15:00', 3, '2017-04-08 07:41:03', 1),
(2, 27, 'mov_bbb1492230114.mp4', 'sadfasdf', 'asdasdasd', '2017-04-15 06:21:54', 3, NULL, 1),
(3, 32, 'asd1494938337.mp4', '234', 'werewr', '2017-04-16 07:30:24', 3, '2017-05-16 14:38:57', 1),
(4, 32, 'small1493958721.mp4', 'a sample video', 'asfsd\r\nsdfg\r\nsdfgsdf', '2017-05-05 06:32:01', 3, NULL, 1),
(6, 32, 'Stripe Series - Episode 2.mp4', '234asd', 'werewr', '2017-04-16 07:30:24', 3, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_answer_comment_master`
--
ALTER TABLE `blog_answer_comment_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_by` (`comment_by`),
  ADD KEY `blog_asnwer_id` (`blog_asnwer_id`);

--
-- Indexes for table `blog_answer_master`
--
ALTER TABLE `blog_answer_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `blog_answer_rating`
--
ALTER TABLE `blog_answer_rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rated_by` (`rated_by`),
  ADD KEY `blog_answer_id` (`blog_answer_id`);

--
-- Indexes for table `blog_master`
--
ALTER TABLE `blog_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `blog_tag_master`
--
ALTER TABLE `blog_tag_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`blog_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `category1_master`
--
ALTER TABLE `category1_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_master`
--
ALTER TABLE `category_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `category_permission_master`
--
ALTER TABLE `category_permission_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usertype_id_2` (`usertype_id`,`module_id`,`category_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `usertype_id` (`usertype_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `course_master`
--
ALTER TABLE `course_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `course_tag_master`
--
ALTER TABLE `course_tag_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `course_topic_master`
--
ALTER TABLE `course_topic_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `category_id` (`course_id`);

--
-- Indexes for table `material_master`
--
ALTER TABLE `material_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `module_master`
--
ALTER TABLE `module_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `module_operation_master`
--
ALTER TABLE `module_operation_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `module_id_2` (`module_id`,`operation_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `usertype_id` (`module_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `operation_id` (`operation_id`);

--
-- Indexes for table `operation_master`
--
ALTER TABLE `operation_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `operation_permission_master`
--
ALTER TABLE `operation_permission_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usertype_id_2` (`usertype_id`,`module_id`,`operation_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `usertype_id` (`usertype_id`),
  ADD KEY `operation_id` (`operation_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `per_page_master`
--
ALTER TABLE `per_page_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`page`);

--
-- Indexes for table `quiz_answer_master`
--
ALTER TABLE `quiz_answer_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_question_id`);

--
-- Indexes for table `quiz_master`
--
ALTER TABLE `quiz_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `quiz_question_master`
--
ALTER TABLE `quiz_question_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_tag_master`
--
ALTER TABLE `quiz_tag_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`quiz_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `review_master`
--
ALTER TABLE `review_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rated_by` (`review_by`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `tag_master`
--
ALTER TABLE `tag_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usertype_master`
--
ALTER TABLE `usertype_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `usertype_id` (`usertype_id`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `video_master`
--
ALTER TABLE `video_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`title`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_answer_comment_master`
--
ALTER TABLE `blog_answer_comment_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blog_answer_master`
--
ALTER TABLE `blog_answer_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blog_answer_rating`
--
ALTER TABLE `blog_answer_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blog_master`
--
ALTER TABLE `blog_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blog_tag_master`
--
ALTER TABLE `blog_tag_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category1_master`
--
ALTER TABLE `category1_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `category_master`
--
ALTER TABLE `category_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `category_permission_master`
--
ALTER TABLE `category_permission_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;
--
-- AUTO_INCREMENT for table `course_master`
--
ALTER TABLE `course_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `course_tag_master`
--
ALTER TABLE `course_tag_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `course_topic_master`
--
ALTER TABLE `course_topic_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `material_master`
--
ALTER TABLE `material_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `module_master`
--
ALTER TABLE `module_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `module_operation_master`
--
ALTER TABLE `module_operation_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1636;
--
-- AUTO_INCREMENT for table `operation_master`
--
ALTER TABLE `operation_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `operation_permission_master`
--
ALTER TABLE `operation_permission_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;
--
-- AUTO_INCREMENT for table `per_page_master`
--
ALTER TABLE `per_page_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `quiz_answer_master`
--
ALTER TABLE `quiz_answer_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `quiz_master`
--
ALTER TABLE `quiz_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `quiz_question_master`
--
ALTER TABLE `quiz_question_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `quiz_tag_master`
--
ALTER TABLE `quiz_tag_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `review_master`
--
ALTER TABLE `review_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tag_master`
--
ALTER TABLE `tag_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `usertype_master`
--
ALTER TABLE `usertype_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `video_master`
--
ALTER TABLE `video_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_answer_comment_master`
--
ALTER TABLE `blog_answer_comment_master`
  ADD CONSTRAINT `blog_answer_comment_master_ibfk_1` FOREIGN KEY (`blog_asnwer_id`) REFERENCES `blog_answer_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_answer_comment_master_ibfk_2` FOREIGN KEY (`comment_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_answer_master`
--
ALTER TABLE `blog_answer_master`
  ADD CONSTRAINT `blog_answer_master_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_answer_master_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_answer_rating`
--
ALTER TABLE `blog_answer_rating`
  ADD CONSTRAINT `blog_answer_rating_ibfk_1` FOREIGN KEY (`blog_answer_id`) REFERENCES `blog_answer_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_answer_rating_ibfk_2` FOREIGN KEY (`rated_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_master`
--
ALTER TABLE `blog_master`
  ADD CONSTRAINT `blog_master_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_tag_master`
--
ALTER TABLE `blog_tag_master`
  ADD CONSTRAINT `blog_tag_master_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_tag_master_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `category_permission_master`
--
ALTER TABLE `category_permission_master`
  ADD CONSTRAINT `category_permission_master_ibfk_1` FOREIGN KEY (`usertype_id`) REFERENCES `usertype_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_permission_master_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `module_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_permission_master_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_permission_master_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_permission_master_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_master`
--
ALTER TABLE `course_master`
  ADD CONSTRAINT `course_master_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_master_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category1_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_tag_master`
--
ALTER TABLE `course_tag_master`
  ADD CONSTRAINT `course_tag_master_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_tag_master_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `material_master`
--
ALTER TABLE `material_master`
  ADD CONSTRAINT `material_master_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module_operation_master`
--
ALTER TABLE `module_operation_master`
  ADD CONSTRAINT `module_operation_master_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `module_operation_master_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `module_operation_master_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `module_operation_master_ibfk_5` FOREIGN KEY (`operation_id`) REFERENCES `operation_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `operation_permission_master`
--
ALTER TABLE `operation_permission_master`
  ADD CONSTRAINT `operation_permission_master_ibfk_1` FOREIGN KEY (`usertype_id`) REFERENCES `usertype_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `operation_permission_master_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `module_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `operation_permission_master_ibfk_3` FOREIGN KEY (`operation_id`) REFERENCES `operation_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `operation_permission_master_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `operation_permission_master_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_answer_master`
--
ALTER TABLE `quiz_answer_master`
  ADD CONSTRAINT `quiz_answer_master_ibfk_1` FOREIGN KEY (`quiz_question_id`) REFERENCES `quiz_question_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_question_master`
--
ALTER TABLE `quiz_question_master`
  ADD CONSTRAINT `quiz_question_master_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_tag_master`
--
ALTER TABLE `quiz_tag_master`
  ADD CONSTRAINT `quiz_tag_master_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_tag_master_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review_master`
--
ALTER TABLE `review_master`
  ADD CONSTRAINT `review_master_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_master_ibfk_2` FOREIGN KEY (`review_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usertype_master`
--
ALTER TABLE `usertype_master`
  ADD CONSTRAINT `usertype_master_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usertype_master_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_master`
--
ALTER TABLE `user_master`
  ADD CONSTRAINT `user_master_ibfk_1` FOREIGN KEY (`usertype_id`) REFERENCES `usertype_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_master_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_master_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_master_ibfk_4` FOREIGN KEY (`module_id`) REFERENCES `module_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video_master`
--
ALTER TABLE `video_master`
  ADD CONSTRAINT `video_master_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video_master_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
