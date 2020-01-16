-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2018 at 02:17 PM
-- Server version: 5.6.41-84.1-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digimonk_work`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `ADMINID` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_role` int(11) NOT NULL DEFAULT '2',
  `profile_picture` varchar(500) NOT NULL,
  `profile_thumb` varchar(500) NOT NULL,
  `email` varchar(80) NOT NULL DEFAULT '',
  `username` varchar(80) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`ADMINID`, `name`, `user_role`, `profile_picture`, `profile_thumb`, `email`, `username`, `password`) VALUES
(1, '', 1, '', '', 'sandeep.sikarwar@digimonk.in', 'digimonk', '7a8522303c1f6c5890e574b5171a288f');

-- --------------------------------------------------------

--
-- Table structure for table `bank_account`
--

CREATE TABLE `bank_account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `acc_no` varchar(50) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_addr` varchar(500) DEFAULT NULL,
  `ifsc_code` varchar(25) DEFAULT NULL,
  `pancard_no` varchar(20) DEFAULT NULL,
  `paypal_account` varchar(50) DEFAULT NULL,
  `paypal_email_id` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_account`
--

INSERT INTO `bank_account` (`id`, `user_id`, `user_name`, `acc_no`, `bank_name`, `bank_addr`, `ifsc_code`, `pancard_no`, `paypal_account`, `paypal_email_id`, `status`) VALUES
(1, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'paypal@digimonk.in', 0),
(2, 65, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'paypal@digimonk.in', 0),
(3, 140, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'info@digimonk.in', 0),
(7, 138, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'deepakpatel@digimonk.in', 0),
(8, 143, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'byerdeepak@digimonk.in', 0),
(9, 134, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rohit.smrl1@gmail.com', 0),
(10, 158, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'asjkldfskl', 0),
(11, 164, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aklsdgjilawejg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `category_image` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `status`, `category_image`) VALUES
(5, 'Package', '0', 'picture-frame-with-mountain-image_318-4029310.jpg'),
(2, 'Influencer', '0', 'picture-frame-with-mountain-image_318-402937.jpg'),
(3, 'busines', '0', 'picture-frame-with-mountain-image_318-402938.jpg'),
(4, 'Help center', '0', 'picture-frame-with-mountain-image_318-402939.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comment`
--

CREATE TABLE `blog_comment` (
  `id` int(11) NOT NULL,
  `user_id` varchar(500) NOT NULL,
  `blog_id` varchar(500) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `reating` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL DEFAULT '0',
  `time_zone` varchar(500) NOT NULL,
  `country_name` varchar(500) NOT NULL,
  `sent_recieved` varchar(500) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `notification_status` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_comment`
--

INSERT INTO `blog_comment` (`id`, `user_id`, `blog_id`, `comment`, `reating`, `status`, `time_zone`, `country_name`, `sent_recieved`, `created_date`, `notification_status`) VALUES
(0, '142', '10', 'Good Blog  tis very help for me thank you!!!', '5', '0', 'Asia/Kolkata', '3', '', '2018-11-28 19:35:15', '1');

-- --------------------------------------------------------

--
-- Table structure for table `buyer_rejected_list`
--

CREATE TABLE `buyer_rejected_list` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0.pending,1.accept,2.cancel',
  `rejected_request` int(11) NOT NULL DEFAULT '0' COMMENT '0.send,1.complete',
  `notification_seen` int(11) NOT NULL DEFAULT '0' COMMENT '0.not seen,1.seen',
  `created_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buyer_rejected_list`
--

INSERT INTO `buyer_rejected_list` (`id`, `seller_id`, `buyer_id`, `gig_id`, `message`, `order_id`, `status`, `rejected_request`, `notification_seen`, `created_time`) VALUES
(1, 138, 143, 72, 'My work is not perfectely', 21, 1, 1, 1, '2018-11-09 11:24:24'),
(2, 138, 143, 72, 'Deepak singh patel', 22, 1, 1, 1, '2018-11-09 11:49:13'),
(3, 138, 143, 72, 'dfhdsvb vhbsdfv bfvfb vfgbgbg', 24, 1, 1, 1, '2018-11-09 12:11:19'),
(4, 138, 143, 72, 'This is not good', 24, 1, 1, 1, '2018-11-09 12:17:57'),
(5, 134, 135, 64, 'product is not up to mark', 25, 1, 1, 1, '2018-11-09 12:49:49'),
(6, 138, 143, 72, 'dfvdfhjd vbhdgvbhd vdfhv fhv fgbvgfvbgfb', 26, 0, 0, 1, '2018-11-09 12:55:32'),
(7, 138, 143, 72, 'jklgvf sfdvb sdfhvbfdhvb dfuhv gfvjhxcb vh vcbv ', 27, 0, 0, 1, '2018-11-09 13:11:58'),
(8, 138, 143, 72, 'jdghvhdfvbdfhv dfvbdfj vsdfvbdhf vdfh vfdhv sfdh vbsudhfvbsfdhv rfbhvdfvbsdfhv sfdhv fdv f', 28, 1, 1, 1, '2018-11-09 14:17:39');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CATID` bigint(20) NOT NULL,
  `name` varchar(120) NOT NULL DEFAULT '',
  `seo` varchar(200) NOT NULL,
  `parent` bigint(20) NOT NULL DEFAULT '0',
  `details` text NOT NULL,
  `mtitle` text NOT NULL,
  `mdesc` text NOT NULL,
  `mtags` text NOT NULL,
  `category_image` varchar(500) NOT NULL,
  `category_thumb_image` varchar(500) NOT NULL,
  `category_medium_image` varchar(500) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL COMMENT '( 0 - Active , 1 - Inactive)',
  `delete_sts` int(11) NOT NULL DEFAULT '0' COMMENT '0-active,1 -inactive'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CATID`, `name`, `seo`, `parent`, `details`, `mtitle`, `mdesc`, `mtags`, `category_image`, `category_thumb_image`, `category_medium_image`, `created_date`, `status`, `delete_sts`) VALUES
(5, 'Logo Design', '', 0, '', '', '', '', 'graphic1.png', '', '', '2018-09-29 04:19:33', 0, 0),
(2, 'Graphics Design', '', 0, '', '', '', '', 'graphic.png', '', '', '2018-09-28 14:10:15', 0, 0),
(8, 'Digital Marketing', '', 0, '', '', '', '', 'digital_marketing.png', '', '', '2018-09-29 04:27:41', 0, 0),
(9, 'Social Media Marketing', '', 8, '', '', '', '', 'social-media.png', '', '', '2018-09-29 04:29:01', 0, 0),
(10, 'Writing and Translation', '', 0, '', '', '', '', 'translate.png', '', '', '2018-09-29 04:29:34', 0, 0),
(11, 'Video & Animation', '', 0, '', '', '', '', 'video-camera.png', '', '', '2018-09-29 04:30:42', 0, 0),
(12, 'Music Audio', '', 0, '', '', '', '', 'musical-note.png', '', '', '2018-09-29 04:31:24', 0, 0),
(13, 'Programming & Tech', '', 0, '', '', '', '', 'programming.png', '', '', '2018-09-29 04:31:59', 0, 0),
(14, 'Business', '', 0, '', '', '', '', 'business.png', '', '', '2018-09-29 04:32:15', 0, 0),
(15, 'Fun and Lifestyle', '', 0, '', '', '', '', 'life.png', '', '', '2018-09-29 04:32:40', 0, 0),
(16, 'Banner Ads', '', 2, '', '', '', '', 'banner.png', '', '', '2018-09-29 04:33:26', 0, 0),
(17, 'Photoshop Editing', '', 2, '', '', '', '', 'editing.png', '', '', '2018-09-29 04:33:54', 0, 0),
(18, 'Business Cards & Stationery', '', 2, '', '', '', '', 'STATANARY.png', '', '', '2018-09-29 04:34:16', 0, 0),
(19, 'Illustration', '', 2, '', '', '', '', 'illlustration.png', '', '', '2018-09-29 04:35:50', 0, 0),
(20, 'SEO', '', 8, '', '', '', '', 'seo.png', '', '', '2018-09-29 04:36:07', 0, 0),
(21, 'Content Marketing', '', 8, '', '', '', '', 'content.png', '', '', '2018-09-29 04:36:52', 0, 0),
(22, 'Video Marketing', '', 8, '', '', '', '', 'video_marketing.png', '', '', '2018-09-29 04:37:33', 0, 0),
(23, 'Email Marketing', '', 8, '', '', '', '', 'EMAILMARKETING.png', '', '', '2018-09-29 05:02:24', 0, 0),
(24, 'Resumes & Cover Letters', '', 10, '', '', '', '', 'resume.png', '', '', '2018-09-29 05:03:25', 0, 0),
(25, 'Articles & Blog Posts', '', 10, '', '', '', '', 'blogging_(1).png', '', '', '2018-09-29 05:04:20', 0, 0),
(26, 'Website Content', '', 10, '', '', '', '', 'website_content.png', '', '', '2018-09-29 05:05:01', 0, 0),
(27, 'Technical Writing ', '', 10, '', '', '', '', 'tech_wri.png', '', '', '2018-09-29 05:05:57', 0, 0),
(28, 'Product Descriptions', '', 10, '', '', '', '', 'product_description.png', '', '', '2018-09-29 05:07:06', 0, 0),
(29, 'Animated Explainers', '', 11, '', '', '', '', 'white.png', '', '', '2018-09-29 05:07:54', 0, 0),
(30, 'Intros & Outros', '', 11, '', '', '', '', 'intros.png', '', '', '2018-09-29 05:08:39', 0, 0),
(31, ' Logo Animation', '', 11, '', '', '', '', 'ANIMATION.png', '', '', '2018-09-29 05:09:37', 0, 0),
(32, ' Slideshows & Promo Videos', '', 11, '', '', '', '', 'slideshow.png', '', '', '2018-09-29 05:10:13', 0, 0),
(33, 'Editing & Post Production', '', 11, '', '', '', '', 'production.png', '', '', '2018-09-29 05:10:43', 0, 0),
(34, 'Voice Over', '', 12, '', '', '', '', 'voice-recognition.png', '', '', '2018-09-29 05:11:52', 0, 0),
(35, 'Mixing & Mastering', '', 12, '', '', '', '', 'mix.png', '', '', '2018-09-29 05:12:16', 0, 0),
(36, 'Producers & Composers', '', 12, '', '', '', '', 'producer.png', '', '', '2018-09-29 05:13:00', 0, 0),
(37, 'Singer-Songwriters', '', 12, '', '', '', '', 'singer.png', '', '', '2018-09-29 05:13:22', 0, 0),
(38, 'Session Musicians & Singers', '', 12, '', '', '', '', 'musician.png', '', '', '2018-09-29 05:13:49', 0, 0),
(39, 'WordPress', '', 0, '', '', '', '', 'wordpress-logo.png', '', '', '2018-09-29 05:14:28', 0, 0),
(40, 'Website Builders & CMS', '', 0, '', '', '', '', 'cms.png', '', '', '2018-09-29 05:14:55', 0, 0),
(41, 'Web Programming', '', 0, '', '', '', '', 'web_prog.png', '', '', '2018-09-29 05:15:13', 0, 0),
(43, 'Ecommerce', '', 0, '', '', '', '', 'ECOMMERCE.png', '', '', '2018-09-29 05:16:43', 0, 0),
(44, 'Mobile Apps & Web', '', 0, '', '', '', '', 'app.png', '', '', '2018-09-29 05:34:20', 0, 0),
(45, 'Virtual Assistant', '', 14, '', '', '', '', 'virtual.png', '', '', '2018-09-29 05:34:53', 0, 0),
(46, 'Data Entry', '', 14, '', '', '', '', 'data.png', '', '', '2018-09-29 05:35:09', 0, 0),
(47, 'Market Research', '', 14, '', '', '', '', 'research.png', '', '', '2018-09-29 05:35:30', 0, 0),
(48, 'Business Plans', '', 14, '', '', '', '', 'planning.png', '', '', '2018-09-29 05:35:45', 0, 0),
(49, 'Branding Services', '', 14, '', '', '', '', 'branding.png', '', '', '2018-09-29 05:36:38', 0, 0),
(50, 'Online Lessons', '', 15, '', '', '', '', 'lessons.png', '', '', '2018-09-29 05:37:23', 0, 0),
(51, 'Arts & Crafts', '', 15, '', '', '', '', 'art.png', '', '', '2018-09-29 05:37:45', 0, 0),
(52, 'Relationship Advice', '', 15, '', '', '', '', 'relation.png', '', '', '2018-09-29 05:38:01', 0, 0),
(53, 'Health, Nutrition & Fitness', '', 15, '', '', '', '', 'health.png', '', '', '2018-09-29 05:38:15', 0, 0),
(54, 'Astrology & Readings', '', 15, '', '', '', '', 'telescope.png', '', '', '2018-09-29 05:38:41', 0, 0),
(55, 'Logo Degine', '', 2, '', '', '', '', 'paint-palette.png', '', '', '2018-11-12 14:26:32', 0, 0),
(57, 'Blogger', '', 10, '', '', '', '', 'blog.png', '', '', '2018-11-23 12:10:43', 0, 0),
(58, 'entrepreneur', '', 14, '', '', '', '', 'manager-clipart-entrepreneur-10.png', '', '', '2018-11-23 12:11:50', 0, 0),
(59, 'Photography', '', 14, '', '', '', '', 'photographer-with-cap-and-glasses.png', '', '', '2018-11-23 12:12:20', 0, 0),
(60, 'Musician', '', 12, '', '', '', '', 'musician1.png', '', '', '2018-11-23 12:12:56', 0, 0),
(61, 'Models', '', 0, '', '', '', '', 'flamenco-male-model-standing-frontal-symbol.png', '', '', '2018-11-23 12:13:36', 0, 0),
(62, 'Politician', '', 15, '', '', '', '', 'politician.png', '', '', '2018-11-23 12:14:32', 0, 0),
(63, 'Editor & Author', '', 0, '', '', '', '', 'autho.png', '', '', '2018-11-23 12:15:19', 0, 0),
(64, 'Sport Star', '', 15, '', '', '', '', 'basketball-player.png', '', '', '2018-11-23 12:16:17', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(10) UNSIGNED NOT NULL,
  `chat_from` int(11) NOT NULL,
  `chat_to` int(11) NOT NULL,
  `content` mediumtext CHARACTER SET utf8 NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `chat_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1- user to user',
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `chat_from_time` datetime NOT NULL,
  `chat_to_time` datetime NOT NULL,
  `chat_utc_time` datetime NOT NULL,
  `timezone` varchar(20) NOT NULL,
  `from_delete_sts` tinyint(4) NOT NULL DEFAULT '0',
  `to_delete_sts` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL COMMENT '0-Unread,1-Read'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `chat_from`, `chat_to`, `content`, `file_path`, `chat_type`, `date_time`, `chat_from_time`, `chat_to_time`, `chat_utc_time`, `timezone`, `from_delete_sts`, `to_delete_sts`, `status`) VALUES
(1, 2, 1, 'Hello, Sandeep I want to buy your services.', '', 1, '2018-09-29 16:57:52', '2018-09-29 16:57:52', '2018-09-30 04:27:52', '2018-09-29 11:27:52', 'Asia/Kolkata', 0, 0, 1),
(2, 1, 2, 'Hello, Deepak I want to buy your Services. ', '', 1, '2018-09-29 17:06:45', '2018-09-30 04:36:45', '2018-09-29 17:06:45', '2018-09-29 11:36:45', 'Asia/Kolkata', 0, 0, 1),
(3, 1, 2, 'Yes Sure.', '', 1, '2018-09-29 17:16:06', '2018-09-30 04:46:06', '2018-09-29 17:16:06', '2018-09-29 11:46:06', 'Asia/Kolkata', 0, 0, 1),
(4, 2, 1, 'hello', '', 1, '2018-10-01 01:17:11', '2018-10-01 01:17:11', '2018-10-01 12:47:11', '2018-09-30 19:47:11', 'Asia/Kolkata', 0, 0, 1),
(5, 2, 1, 'Hi Sandeep how are you ?', '', 1, '2018-10-02 00:45:37', '2018-10-02 00:45:37', '2018-10-02 12:15:37', '2018-10-01 19:15:37', 'Asia/Kolkata', 0, 0, 1),
(6, 1, 2, 'i am good ', '', 1, '2018-10-02 00:46:13', '2018-10-02 12:16:13', '2018-10-02 00:46:13', '2018-10-01 19:16:13', 'Asia/Kolkata', 0, 0, 1),
(7, 1, 2, 'thanks for asking', '', 1, '2018-10-02 00:46:17', '2018-10-02 12:16:17', '2018-10-02 00:46:17', '2018-10-01 19:16:17', 'Asia/Kolkata', 0, 0, 1),
(8, 1, 2, 'hello', '', 1, '2018-10-05 11:44:40', '2018-10-05 11:44:40', '2018-10-05 11:44:40', '2018-10-05 06:14:40', 'Asia/Kolkata', 0, 0, 1),
(9, 39, 38, 'Hi jain .. How are you ... ', '', 1, '2018-10-28 21:19:24', '2018-10-28 21:19:24', '2018-10-28 21:19:24', '2018-10-28 15:49:24', 'Asia/Kolkata', 0, 0, 1),
(10, 39, 38, 'Hi there ', '', 1, '2018-10-28 21:19:49', '2018-10-28 21:19:49', '2018-10-28 21:19:49', '2018-10-28 15:49:49', 'Asia/Kolkata', 0, 0, 1),
(11, 39, 38, 'hello', '', 1, '2018-10-28 21:21:19', '2018-10-28 21:21:19', '2018-10-28 21:21:19', '2018-10-28 15:51:19', 'Asia/Kolkata', 0, 0, 1),
(12, 39, 38, 'hello', '', 1, '2018-10-28 21:27:22', '2018-10-28 21:27:22', '2018-10-28 21:27:22', '2018-10-28 15:57:22', 'Asia/Kolkata', 0, 0, 1),
(13, 39, 38, 'hello', '', 1, '2018-10-28 21:27:54', '2018-10-28 21:27:54', '2018-10-28 21:27:54', '2018-10-28 15:57:54', 'Asia/Kolkata', 0, 0, 1),
(14, 39, 38, '1 more time', '', 1, '2018-10-28 21:27:57', '2018-10-28 21:27:57', '2018-10-28 21:27:57', '2018-10-28 15:57:57', 'Asia/Kolkata', 0, 0, 1),
(15, 57, 55, 'Deepak Patel', '', 1, '2018-10-29 17:38:56', '2018-10-29 17:38:56', '2018-10-29 17:38:56', '2018-10-29 12:08:56', 'Asia/Kolkata', 0, 0, 1),
(16, 57, 55, 'ffgsbgfbgfbsgf', '', 1, '2018-10-29 17:41:04', '2018-10-29 17:41:04', '2018-10-29 17:41:04', '2018-10-29 12:11:04', 'Asia/Kolkata', 0, 0, 1),
(17, 57, 55, 'ffgsbgfbgfbsgf', '', 1, '2018-10-29 17:41:04', '2018-10-29 17:41:04', '2018-10-29 17:41:04', '2018-10-29 12:11:04', 'Asia/Kolkata', 0, 0, 1),
(18, 57, 55, 'ffgsbgfbgfbsgf', '', 1, '2018-10-29 17:41:06', '2018-10-29 17:41:06', '2018-10-29 17:41:06', '2018-10-29 12:11:06', 'Asia/Kolkata', 0, 0, 1),
(19, 57, 55, 'gffgbbgbgf', '', 1, '2018-10-29 17:41:44', '2018-10-29 17:41:44', '2018-10-29 17:41:44', '2018-10-29 12:11:44', 'Asia/Kolkata', 0, 0, 1),
(20, 57, 55, 'sdveg rgrt trhtrd hdf hyttyyy jjt jry', '', 1, '2018-10-29 18:13:48', '2018-10-29 18:13:48', '2018-10-29 18:13:48', '2018-10-29 12:43:48', 'Asia/Kolkata', 0, 0, 1),
(21, 57, 55, 'dfvsg trsg g', '', 1, '2018-10-29 18:34:55', '2018-10-29 18:34:55', '2018-10-29 18:34:55', '2018-10-29 13:04:55', 'Asia/Kolkata', 0, 0, 1),
(22, 57, 55, 'fgbdtnbhnythngfgnhhy', '', 1, '2018-10-29 18:36:57', '2018-10-29 18:36:57', '2018-10-29 18:36:57', '2018-10-29 13:06:57', 'Asia/Kolkata', 0, 0, 1),
(23, 57, 55, 'vdbgfgbdgbgbgt', '', 1, '2018-10-29 18:37:05', '2018-10-29 18:37:05', '2018-10-29 18:37:05', '2018-10-29 13:07:05', 'Asia/Kolkata', 0, 0, 1),
(24, 57, 55, 'fvfsvsfvsfdvfvf', '', 1, '2018-10-29 18:37:43', '2018-10-29 18:37:43', '2018-10-29 18:37:43', '2018-10-29 13:07:43', 'Asia/Kolkata', 0, 0, 1),
(25, 57, 55, 'fbdgbgtfbg', '', 1, '2018-10-29 18:38:13', '2018-10-29 18:38:13', '2018-10-29 18:38:13', '2018-10-29 13:08:13', 'Asia/Kolkata', 0, 0, 1),
(26, 57, 55, 'ffbvsrfbgsfb', '', 1, '2018-10-29 18:42:31', '2018-10-29 18:42:31', '2018-10-29 18:42:31', '2018-10-29 13:12:31', 'Asia/Kolkata', 0, 0, 1),
(27, 57, 55, 'fbtdhbt', '', 1, '2018-10-29 18:43:13', '2018-10-29 18:43:13', '2018-10-29 18:43:13', '2018-10-29 13:13:13', 'Asia/Kolkata', 0, 0, 1),
(28, 57, 55, 'dzgsfgrg tr', '', 1, '2018-10-29 18:48:05', '2018-10-29 18:48:05', '2018-10-29 18:48:05', '2018-10-29 13:18:05', 'Asia/Kolkata', 0, 0, 1),
(29, 57, 55, 'dsfgththhythrhyte hyg nh', '', 1, '2018-10-29 18:52:15', '2018-10-29 18:52:15', '2018-10-29 18:52:15', '2018-10-29 13:22:15', 'Asia/Kolkata', 0, 0, 1),
(30, 57, 55, 'fdvfsdbgsf gbdgfbgb dbdgnbgdfbdgndb g', '', 1, '2018-10-29 18:58:18', '2018-10-29 18:58:18', '2018-10-29 18:58:18', '2018-10-29 13:28:18', 'Asia/Kolkata', 0, 0, 1),
(31, 57, 55, ',nbnvhgcgv hg vj gh', '', 1, '2018-10-29 18:59:39', '2018-10-29 18:59:39', '2018-10-29 18:59:39', '2018-10-29 13:29:39', 'Asia/Kolkata', 0, 0, 1),
(32, 57, 56, 'sddfsdf', '', 1, '2018-10-29 19:18:24', '2018-10-29 19:18:24', '2018-10-29 19:18:24', '2018-10-29 13:48:24', 'Asia/Kolkata', 0, 0, 1),
(33, 57, 56, 'asdasdfadsf', '', 1, '2018-10-29 19:18:43', '2018-10-29 19:18:43', '2018-10-29 19:18:43', '2018-10-29 13:48:43', 'Asia/Kolkata', 0, 0, 1),
(34, 57, 56, 'asdfadf', '', 1, '2018-10-29 19:31:02', '2018-10-29 19:31:02', '2018-10-29 19:31:02', '2018-10-29 14:01:02', 'Asia/Kolkata', 0, 0, 1),
(35, 141, 140, 'HEY gaurav how are you ?', '', 1, '2018-11-05 00:58:16', '2018-11-05 00:58:16', '2018-11-05 00:58:16', '2018-11-04 19:28:16', 'Asia/Kolkata', 0, 0, 1),
(36, 141, 140, 'pls text me back when you are online', '', 1, '2018-11-05 00:58:32', '2018-11-05 00:58:32', '2018-11-05 00:58:32', '2018-11-04 19:28:32', 'Asia/Kolkata', 0, 0, 1),
(37, 140, 141, 'hello i am online pls send a message ', '', 1, '2018-11-05 01:06:01', '2018-11-05 01:06:01', '2018-11-05 01:06:01', '2018-11-04 19:36:01', 'Asia/Kolkata', 0, 0, 1),
(38, 140, 141, 'thanks', '', 1, '2018-11-05 01:06:23', '2018-11-05 01:06:23', '2018-11-05 01:06:23', '2018-11-04 19:36:23', 'Asia/Kolkata', 0, 0, 1),
(39, 140, 141, 'hi, i am sending this message to check the message box alingment a the top, how it will behave, thanks a lot..', '', 1, '2018-11-05 01:07:08', '2018-11-05 01:07:08', '2018-11-05 01:07:08', '2018-11-04 19:37:08', 'Asia/Kolkata', 0, 0, 1),
(40, 140, 141, 'hi, i am sending this message to check the message box alingment a the top, how it will behave, thanks a lot..', '', 1, '2018-11-05 01:07:39', '2018-11-05 01:07:39', '2018-11-05 01:07:39', '2018-11-04 19:37:39', 'Asia/Kolkata', 0, 0, 1),
(41, 135, 134, 'aisd\r\n', '', 1, '2018-11-05 15:54:36', '2018-11-05 15:54:36', '2018-11-05 15:54:36', '2018-11-05 10:24:36', 'Asia/Kolkata', 0, 0, 1),
(42, 134, 135, 'hi how are you', '', 1, '2018-11-05 15:54:56', '2018-11-05 15:54:56', '2018-11-05 15:54:56', '2018-11-05 10:24:56', 'Asia/Kolkata', 0, 0, 1),
(43, 135, 134, 'i am fine thankyou', '', 1, '2018-11-05 15:55:13', '2018-11-05 15:55:13', '2018-11-05 15:55:13', '2018-11-05 10:25:13', 'Asia/Kolkata', 0, 0, 1),
(44, 137, 142, 'heya i want to buy ur package', '', 1, '2018-11-10 11:08:39', '2018-11-10 11:08:39', '2018-11-10 11:08:39', '2018-11-10 05:38:39', 'Asia/Kolkata', 0, 0, 1),
(45, 137, 142, 'heya i want to buy ur package', '', 1, '2018-11-10 11:08:46', '2018-11-10 11:08:46', '2018-11-10 11:08:46', '2018-11-10 05:38:46', 'Asia/Kolkata', 0, 0, 1),
(46, 137, 142, 'heya i want to buy ur package', '', 1, '2018-11-10 11:08:50', '2018-11-10 11:08:50', '2018-11-10 11:08:50', '2018-11-10 05:38:50', 'Asia/Kolkata', 0, 0, 1),
(47, 143, 138, 'kldfjvsdkfvnsdf vjslfdv sdflvbsdfv hv dbv fd vfdv f', '', 1, '2018-11-10 11:14:19', '2018-11-10 11:14:19', '2018-11-10 11:14:19', '2018-11-10 05:44:19', 'Asia/Kolkata', 0, 0, 1),
(48, 143, 138, 'kldfjvsdkfvnsdf vjslfdv sdflvbsdfv hv dbv fd vfdv f', '', 1, '2018-11-10 11:14:24', '2018-11-10 11:14:24', '2018-11-10 11:14:24', '2018-11-10 05:44:24', 'Asia/Kolkata', 0, 0, 1),
(49, 140, 141, 'hey', '', 1, '2018-11-11 23:25:57', '2018-11-11 23:25:57', '2018-11-11 23:25:57', '2018-11-11 17:55:57', 'Asia/Kolkata', 0, 0, 1),
(50, 140, 141, 'gv me this and that ', '', 1, '2018-11-11 23:26:02', '2018-11-11 23:26:02', '2018-11-11 23:26:02', '2018-11-11 17:56:02', 'Asia/Kolkata', 0, 0, 1),
(51, 140, 141, 'hi its in process', '', 1, '2018-11-11 23:26:24', '2018-11-11 23:26:24', '2018-11-11 23:26:24', '2018-11-11 17:56:24', 'Asia/Kolkata', 0, 0, 1),
(52, 141, 140, 'Ok i gave you the feedback, great JOB', '', 1, '2018-11-11 23:29:13', '2018-11-11 23:29:13', '2018-11-11 23:29:13', '2018-11-11 17:59:13', 'Asia/Kolkata', 0, 0, 1),
(53, 144, 0, 'dfbsgbgb', '', 1, '2018-11-19 16:43:24', '2018-11-19 16:43:24', '2018-11-19 11:13:24', '2018-11-19 11:13:24', 'Asia/Kolkata', 0, 0, 0),
(54, 165, 164, 'adsfkljasdfjkl', '', 1, '2018-11-23 19:41:59', '2018-11-23 19:41:59', '2018-11-23 19:41:59', '2018-11-23 14:11:59', 'Asia/Kolkata', 0, 0, 1),
(55, 165, 164, 'adsfkljasdfjkl', '', 1, '2018-11-23 19:42:04', '2018-11-23 19:42:04', '2018-11-23 19:42:04', '2018-11-23 14:12:04', 'Asia/Kolkata', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `client_raw_image` varchar(500) NOT NULL,
  `client_cropped_image` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `setting` varchar(60) NOT NULL DEFAULT '',
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `sortname` varchar(3) NOT NULL,
  `country` varchar(150) NOT NULL,
  `country_status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `sortname`, `country`, `country_status`) VALUES
(1, 'AF', 'Afghanistan', 1),
(2, 'AL', 'Albania', 1),
(3, 'DZ', 'Algeria', 1),
(4, 'AS', 'American Samoa', 1),
(5, 'AD', 'Andorra', 1),
(6, 'AO', 'Angola', 1),
(7, 'AI', 'Anguilla', 1),
(8, 'AQ', 'Antarctica', 1),
(9, 'AG', 'Antigua And Barbuda', 1),
(10, 'AR', 'Argentina', 1),
(11, 'AM', 'Armenia', 1),
(12, 'AW', 'Aruba', 1),
(13, 'AU', 'Australia', 1),
(14, 'AT', 'Austria', 1),
(15, 'AZ', 'Azerbaijan', 1),
(16, 'BS', 'Bahamas The', 1),
(17, 'BH', 'Bahrain', 1),
(18, 'BD', 'Bangladesh', 1),
(19, 'BB', 'Barbados', 1),
(20, 'BY', 'Belarus', 1),
(21, 'BE', 'Belgium', 1),
(22, 'BZ', 'Belize', 1),
(23, 'BJ', 'Benin', 1),
(24, 'BM', 'Bermuda', 1),
(25, 'BT', 'Bhutan', 1),
(26, 'BO', 'Bolivia', 1),
(27, 'BA', 'Bosnia and Herzegovina', 1),
(28, 'BW', 'Botswana', 1),
(29, 'BV', 'Bouvet Island', 1),
(30, 'BR', 'Brazil', 1),
(31, 'IO', 'British Indian Ocean Territory', 1),
(32, 'BN', 'Brunei', 1),
(33, 'BG', 'Bulgaria', 1),
(34, 'BF', 'Burkina Faso', 1),
(35, 'BI', 'Burundi', 1),
(36, 'KH', 'Cambodia', 1),
(37, 'CM', 'Cameroon', 1),
(38, 'CA', 'Canada', 1),
(39, 'CV', 'Cape Verde', 1),
(40, 'KY', 'Cayman Islands', 1),
(41, 'CF', 'Central African Republic', 1),
(42, 'TD', 'Chad', 1),
(43, 'CL', 'Chile', 1),
(44, 'CN', 'China', 1),
(45, 'CX', 'Christmas Island', 1),
(46, 'CC', 'Cocos (Keeling) Islands', 1),
(47, 'CO', 'Colombia', 1),
(48, 'KM', 'Comoros', 1),
(49, 'CG', 'Congo', 1),
(50, 'CD', 'Congo The Democratic Republic Of The', 1),
(51, 'CK', 'Cook Islands', 1),
(52, 'CR', 'Costa Rica', 1),
(53, 'CI', 'Cote D\'Ivoire (Ivory Coast)', 1),
(54, 'HR', 'Croatia (Hrvatska)', 1),
(55, 'CU', 'Cuba', 1),
(56, 'CY', 'Cyprus', 1),
(57, 'CZ', 'Czech Republic', 1),
(58, 'DK', 'Denmark', 1),
(59, 'DJ', 'Djibouti', 1),
(60, 'DM', 'Dominica', 1),
(61, 'DO', 'Dominican Republic', 1),
(62, 'TP', 'East Timor', 1),
(63, 'EC', 'Ecuador', 1),
(64, 'EG', 'Egypt', 1),
(65, 'SV', 'El Salvador', 1),
(66, 'GQ', 'Equatorial Guinea', 1),
(67, 'ER', 'Eritrea', 1),
(68, 'EE', 'Estonia', 1),
(69, 'ET', 'Ethiopia', 1),
(70, 'XA', 'External Territories of Australia', 1),
(71, 'FK', 'Falkland Islands', 1),
(72, 'FO', 'Faroe Islands', 1),
(73, 'FJ', 'Fiji Islands', 1),
(74, 'FI', 'Finland', 1),
(75, 'FR', 'France', 1),
(76, 'GF', 'French Guiana', 1),
(77, 'PF', 'French Polynesia', 1),
(78, 'TF', 'French Southern Territories', 1),
(79, 'GA', 'Gabon', 1),
(80, 'GM', 'Gambia The', 1),
(81, 'GE', 'Georgia', 1),
(82, 'DE', 'Germany', 1),
(83, 'GH', 'Ghana', 1),
(84, 'GI', 'Gibraltar', 1),
(85, 'GR', 'Greece', 1),
(86, 'GL', 'Greenland', 1),
(87, 'GD', 'Grenada', 1),
(88, 'GP', 'Guadeloupe', 1),
(89, 'GU', 'Guam', 1),
(90, 'GT', 'Guatemala', 1),
(91, 'XU', 'Guernsey and Alderney', 1),
(92, 'GN', 'Guinea', 1),
(93, 'GW', 'Guinea-Bissau', 1),
(94, 'GY', 'Guyana', 1),
(95, 'HT', 'Haiti', 1),
(96, 'HM', 'Heard and McDonald Islands', 1),
(97, 'HN', 'Honduras', 1),
(98, 'HK', 'Hong Kong S.A.R.', 1),
(99, 'HU', 'Hungary', 1),
(100, 'IS', 'Iceland', 1),
(101, 'IN', 'India', 1),
(102, 'ID', 'Indonesia', 1),
(103, 'IR', 'Iran', 1),
(104, 'IQ', 'Iraq', 1),
(105, 'IE', 'Ireland', 1),
(106, 'IL', 'Israel', 1),
(107, 'IT', 'Italy', 1),
(108, 'JM', 'Jamaica', 1),
(109, 'JP', 'Japan', 1),
(110, 'XJ', 'Jersey', 1),
(111, 'JO', 'Jordan', 1),
(112, 'KZ', 'Kazakhstan', 1),
(113, 'KE', 'Kenya', 1),
(114, 'KI', 'Kiribati', 1),
(115, 'KP', 'Korea North', 1),
(116, 'KR', 'Korea South', 1),
(117, 'KW', 'Kuwait', 1),
(118, 'KG', 'Kyrgyzstan', 1),
(119, 'LA', 'Laos', 1),
(120, 'LV', 'Latvia', 1),
(121, 'LB', 'Lebanon', 1),
(122, 'LS', 'Lesotho', 1),
(123, 'LR', 'Liberia', 1),
(124, 'LY', 'Libya', 1),
(125, 'LI', 'Liechtenstein', 1),
(126, 'LT', 'Lithuania', 1),
(127, 'LU', 'Luxembourg', 1),
(128, 'MO', 'Macau S.A.R.', 1),
(129, 'MK', 'Macedonia', 1),
(130, 'MG', 'Madagascar', 1),
(131, 'MW', 'Malawi', 1),
(132, 'MY', 'Malaysia', 1),
(133, 'MV', 'Maldives', 1),
(134, 'ML', 'Mali', 1),
(135, 'MT', 'Malta', 1),
(136, 'XM', 'Man (Isle of)', 1),
(137, 'MH', 'Marshall Islands', 1),
(138, 'MQ', 'Martinique', 1),
(139, 'MR', 'Mauritania', 1),
(140, 'MU', 'Mauritius', 1),
(141, 'YT', 'Mayotte', 1),
(142, 'MX', 'Mexico', 1),
(143, 'FM', 'Micronesia', 1),
(144, 'MD', 'Moldova', 1),
(145, 'MC', 'Monaco', 1),
(146, 'MN', 'Mongolia', 1),
(147, 'MS', 'Montserrat', 1),
(148, 'MA', 'Morocco', 1),
(149, 'MZ', 'Mozambique', 1),
(150, 'MM', 'Myanmar', 1),
(151, 'NA', 'Namibia', 1),
(152, 'NR', 'Nauru', 1),
(153, 'NP', 'Nepal', 1),
(154, 'AN', 'Netherlands Antilles', 1),
(155, 'NL', 'Netherlands The', 1),
(156, 'NC', 'New Caledonia', 1),
(157, 'NZ', 'New Zealand', 1),
(158, 'NI', 'Nicaragua', 1),
(159, 'NE', 'Niger', 1),
(160, 'NG', 'Nigeria', 1),
(161, 'NU', 'Niue', 1),
(162, 'NF', 'Norfolk Island', 1),
(163, 'MP', 'Northern Mariana Islands', 1),
(164, 'NO', 'Norway', 1),
(165, 'OM', 'Oman', 1),
(166, 'PK', 'Pakistan', 1),
(167, 'PW', 'Palau', 1),
(168, 'PS', 'Palestinian Territory Occupied', 1),
(169, 'PA', 'Panama', 1),
(170, 'PG', 'Papua new Guinea', 1),
(171, 'PY', 'Paraguay', 1),
(172, 'PE', 'Peru', 1),
(173, 'PH', 'Philippines', 1),
(174, 'PN', 'Pitcairn Island', 1),
(175, 'PL', 'Poland', 1),
(176, 'PT', 'Portugal', 1),
(177, 'PR', 'Puerto Rico', 1),
(178, 'QA', 'Qatar', 1),
(179, 'RE', 'Reunion', 1),
(180, 'RO', 'Romania', 1),
(181, 'RU', 'Russia', 1),
(182, 'RW', 'Rwanda', 1),
(183, 'SH', 'Saint Helena', 1),
(184, 'KN', 'Saint Kitts And Nevis', 1),
(185, 'LC', 'Saint Lucia', 1),
(186, 'PM', 'Saint Pierre and Miquelon', 1),
(187, 'VC', 'Saint Vincent And The Grenadines', 1),
(188, 'WS', 'Samoa', 1),
(189, 'SM', 'San Marino', 1),
(190, 'ST', 'Sao Tome and Principe', 1),
(191, 'SA', 'Saudi Arabia', 1),
(192, 'SN', 'Senegal', 1),
(193, 'RS', 'Serbia', 1),
(194, 'SC', 'Seychelles', 1),
(195, 'SL', 'Sierra Leone', 1),
(196, 'SG', 'Singapore', 1),
(197, 'SK', 'Slovakia', 1),
(198, 'SI', 'Slovenia', 1),
(199, 'XG', 'Smaller Territories of the UK', 1),
(200, 'SB', 'Solomon Islands', 1),
(201, 'SO', 'Somalia', 1),
(202, 'ZA', 'South Africa', 1),
(203, 'GS', 'South Georgia', 1),
(204, 'SS', 'South Sudan', 1),
(205, 'ES', 'Spain', 1),
(206, 'LK', 'Sri Lanka', 1),
(207, 'SD', 'Sudan', 1),
(208, 'SR', 'Suriname', 1),
(209, 'SJ', 'Svalbard And Jan Mayen Islands', 1),
(210, 'SZ', 'Swaziland', 1),
(211, 'SE', 'Sweden', 1),
(212, 'CH', 'Switzerland', 1),
(213, 'SY', 'Syria', 1),
(214, 'TW', 'Taiwan', 1),
(215, 'TJ', 'Tajikistan', 1),
(216, 'TZ', 'Tanzania', 1),
(217, 'TH', 'Thailand', 1),
(218, 'TG', 'Togo', 1),
(219, 'TK', 'Tokelau', 1),
(220, 'TO', 'Tonga', 1),
(221, 'TT', 'Trinidad And Tobago', 1),
(222, 'TN', 'Tunisia', 1),
(223, 'TR', 'Turkey', 1),
(224, 'TM', 'Turkmenistan', 1),
(225, 'TC', 'Turks And Caicos Islands', 1),
(226, 'TV', 'Tuvalu', 1),
(227, 'UG', 'Uganda', 1),
(228, 'UA', 'Ukraine', 1),
(229, 'AE', 'United Arab Emirates', 1),
(230, 'GB', 'United Kingdom', 1),
(231, 'US', 'United States', 1),
(232, 'UM', 'United States Minor Outlying Islands', 1),
(233, 'UY', 'Uruguay', 1),
(234, 'UZ', 'Uzbekistan', 1),
(235, 'VU', 'Vanuatu', 1),
(236, 'VA', 'Vatican City State (Holy See)', 1),
(237, 'VE', 'Venezuela', 1),
(238, 'VN', 'Vietnam', 1),
(239, 'VG', 'Virgin Islands (British)', 1),
(240, 'VI', 'Virgin Islands (US)', 1),
(241, 'WF', 'Wallis And Futuna Islands', 1),
(242, 'EH', 'Western Sahara', 1),
(243, 'YE', 'Yemen', 1),
(244, 'YU', 'Yugoslavia', 1),
(245, 'ZM', 'Zambia', 1),
(246, 'ZW', 'Zimbabwe', 1);

-- --------------------------------------------------------

--
-- Table structure for table `crasol`
--

CREATE TABLE `crasol` (
  `id` bigint(20) NOT NULL,
  `item_name` varchar(500) NOT NULL,
  `type` varchar(500) NOT NULL,
  `date` varchar(500) NOT NULL,
  `item_id` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crasol`
--

INSERT INTO `crasol` (`id`, `item_name`, `type`, `date`, `item_id`, `status`) VALUES
(1, 'pawan sharma', 'user', '14-11-2018', '142', '0'),
(2, 'Gaurav Jain', 'user', '14-11-2018', '140', '0'),
(3, 'ADITYA JAIN', 'user', '14-11-2018', '141', '0'),
(91, 'logo design', 'package', '17-11-2018', '77', '0'),
(92, 'jdhvfdbvf', 'package', '17-11-2018', '78', '0'),
(8, 'user_1541394806', 'user', '14-11-2018', '142', '0'),
(9, 'user_1541356566', 'user', '14-11-2018', '140', '0'),
(10, 'user_1541358975', 'user', '14-11-2018', '141', '0'),
(11, 'user_1541168858', 'user', '14-11-2018', '134', '0'),
(12, 'user_1541169574', 'user', '14-11-2018', '135', '0'),
(13, 'user_1541223460', 'user', '14-11-2018', '138', '0'),
(14, 'user_1542004699', 'user', '14-11-2018', '144', '0'),
(15, 'ljkhdfkjblbgfkh', 'package', '14-11-2018', '63', '0'),
(16, 'my package', 'package', '14-11-2018', '64', '0'),
(17, 'facebook', 'package', '14-11-2018', '68', '0'),
(18, 'twitter marketing', 'package', '14-11-2018', '69', '0'),
(19, 'instagram marketing', 'package', '14-11-2018', '70', '0'),
(20, 'facebook', 'package', '14-11-2018', '71', '0'),
(21, '	\r\njbhgbg fhgbetb gfhbdyt dgfbyt gfbhg bggd', 'user', '14-11-2018', '72', '0'),
(22, 'facebook package', 'package', '14-11-2018', '73', '0'),
(23, 'logo design', 'package', '14-11-2018', '74', '0'),
(24, 'twitter marketing', 'package', '14-11-2018', '69', '0'),
(25, 'instagram marketing', 'package', '14-11-2018', '70', '0'),
(26, 'facebook', 'package', '14-11-2018', '71', '0'),
(39, 'Writing and Translation', 'categories', '14-11-2018', '10', '0'),
(38, 'Social Media Marketing', 'categories', '14-11-2018', '9', '0'),
(37, 'Digital Marketing', 'categories', '14-11-2018', '8', '0'),
(36, 'Graphics Design', 'categories', '14-11-2018', '2', '0'),
(35, 'Logo Design', 'categories', '14-11-2018', '5', '0'),
(40, 'Video & Animation', 'categories', '14-11-2018', '11', '0'),
(41, 'Music Audio', 'categories', '14-11-2018', '12', '0'),
(42, 'Programming & Tech', 'categories', '14-11-2018', '13', '0'),
(43, 'Business', 'categories', '14-11-2018', '14', '0'),
(44, 'Fun and Lifestyle', 'categories', '14-11-2018', '15', '0'),
(45, 'Banner Ads', 'categories', '14-11-2018', '16', '0'),
(46, 'Photoshop Editing', 'categories', '14-11-2018', '17', '0'),
(47, 'Business Cards & Stationery', 'categories', '14-11-2018', '18', '0'),
(48, 'Illustration', 'categories', '14-11-2018', '19', '0'),
(49, 'SEO', 'categories', '14-11-2018', '20', '0'),
(50, 'Content Marketing', 'categories', '14-11-2018', '21', '0'),
(51, 'Video Marketing', 'categories', '14-11-2018', '22', '0'),
(52, 'Email Marketing', 'categories', '14-11-2018', '23', '0'),
(53, 'Resumes & Cover Letters', 'categories', '14-11-2018', '24', '0'),
(54, 'Articles & Blog Posts', 'categories', '14-11-2018', '25', '0'),
(55, 'Website Content', 'categories', '14-11-2018', '26', '0'),
(56, 'Technical Writing ', 'categories', '14-11-2018', '27', '0'),
(57, 'Product Descriptions', 'categories', '14-11-2018', '28', '0'),
(58, 'Whiteboard & Animated Explainers', 'categories', '14-11-2018', '29', '0'),
(59, 'Intros & Outros', 'categories', '14-11-2018', '30', '0'),
(60, ' Logo Animation', 'categories', '14-11-2018', '31', '0'),
(61, ' Slideshows & Promo Videos', 'categories', '14-11-2018', '32', '0'),
(62, 'Editing & Post Production', 'categories', '14-11-2018', '33', '0'),
(63, 'Voice Over', 'categories', '14-11-2018', '34', '0'),
(64, 'Mixing & Mastering', 'categories', '14-11-2018', '35', '0'),
(65, 'Producers & Composers', 'categories', '14-11-2018', '36', '0'),
(66, 'Singer-Songwriters', 'categories', '14-11-2018', '37', '0'),
(67, 'Session Musicians & Singers', 'categories', '14-11-2018', '38', '0'),
(68, 'WordPress', 'categories', '14-11-2018', '39', '0'),
(69, 'Website Builders & CMS', 'categories', '14-11-2018', '40', '0'),
(70, 'Web Programming', 'categories', '14-11-2018', '41', '0'),
(71, 'Ecommerce', 'categories', '14-11-2018', '43', '0'),
(72, 'Mobile Apps & Web', 'categories', '14-11-2018', '44', '0'),
(73, 'Virtual Assistant', 'categories', '14-11-2018', '45', '0'),
(74, 'Data Entry', 'categories', '14-11-2018', '46', '0'),
(75, 'Market Research', 'categories', '14-11-2018', '47', '0'),
(76, 'Business Plans', 'categories', '14-11-2018', '48', '0'),
(77, 'Branding Services', 'categories', '14-11-2018', '49', '0'),
(78, 'Online Lessons', 'categories', '14-11-2018', '50', '0'),
(79, 'Arts & Crafts', 'categories', '14-11-2018', '51', '0'),
(80, 'Relationship Advice', 'categories', '14-11-2018', '52', '0'),
(81, 'Health, Nutrition & Fitness', 'categories', '14-11-2018', '53', '0'),
(82, 'Astrology & Readings', 'categories', '14-11-2018', '54', '0'),
(86, 'user_1542434213', 'user', '17-11-2018', '146', '0'),
(93, 'user_1542721221', 'user', '20-11-2018', '148', '0'),
(95, 'user_1542721221', 'user', '20-11-2018', '148', '0'),
(97, 'logo editing', 'package', '20-11-2018', '80', '0'),
(98, 'user_1542721221', 'user', '20-11-2018', '148', '0'),
(100, 'user_1542723892', 'user', '20-11-2018', '151', '0'),
(102, 'user_1542723892', 'user', '20-11-2018', '151', '0'),
(104, 'user_1542724919', 'user', '20-11-2018', '153', '0'),
(106, 'user_1542724919', 'user', '20-11-2018', '153', '0'),
(158, 'deepak patel', 'user', '27-11-2018', '167', '0'),
(108, 'user_1542780860', 'user', '21-11-2018', '154', '0'),
(110, 'user_1542780860', 'user', '21-11-2018', '154', '0'),
(112, 'user_1542784415', 'user', '21-11-2018', '156', '0'),
(114, 'user_1542790178', 'user', '21-11-2018', '158', '0'),
(155, 'user_1543298710', 'user', '27-11-2018', '166', '0'),
(116, 'user_1542790178', 'user', '21-11-2018', '158', '0'),
(157, 'user_1543299115', 'user', '27-11-2018', '167', '0'),
(118, 'my package', 'package', '21-11-2018', '81', '0'),
(143, 'user_1542976083', 'user', '23-11-2018', '162', '0'),
(142, 'Sport Star', 'categories', '23-11-2018', '64', '0'),
(141, 'Editor & Author', 'categories', '23-11-2018', '63', '0'),
(140, 'Politician', 'categories', '23-11-2018', '62', '0'),
(139, 'Models', 'categories', '23-11-2018', '61', '0'),
(138, 'Musician', 'categories', '23-11-2018', '60', '0'),
(137, 'Photography', 'categories', '23-11-2018', '59', '0'),
(136, 'entrepreneur', 'categories', '23-11-2018', '58', '0'),
(135, 'Blogger', 'categories', '23-11-2018', '57', '0'),
(134, 'freelancer', 'package', '23-11-2018', '82', '0'),
(130, 'user_1542966690', 'user', '23-11-2018', '161', '0'),
(131, 'ajay Sharma', 'user', '23-11-2018', '161', '0'),
(132, 'user_1542966690', 'user', '23-11-2018', '161', '0'),
(133, 'ajay Sharma', 'user', '23-11-2018', '161', '0'),
(145, 'user_1542976083', 'user', '23-11-2018', '162', '0'),
(147, 'user_1542979530', 'user', '23-11-2018', '163', '0'),
(153, 'user_1543298710', 'user', '27-11-2018', '166', '0'),
(149, 'user_1542980296', 'user', '23-11-2018', '164', '0'),
(152, 'Rohit Arora', 'user', '14-11-2018', '165', '0'),
(151, 'rohit package', 'package', '23-11-2018', '84', '0');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `currency` char(5) NOT NULL,
  `currency_sign` char(5) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `currency`, `currency_sign`, `status`) VALUES
(1, 'USD', '$', 1),
(2, 'GBP', 'Â£', 1),
(3, 'EUR', 'â‚¬', 1);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `dollar_rate` float NOT NULL,
  `indian_rate` float NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `db_backup_details`
--

CREATE TABLE `db_backup_details` (
  `backup_id` int(11) NOT NULL,
  `backup_file_name` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Database Backup Details';

--
-- Dumping data for table `db_backup_details`
--

INSERT INTO `db_backup_details` (`backup_id`, `backup_file_name`, `date_created`, `last_updated`, `status`) VALUES
(1, 'full_backup_1956474300_2018-09-30.zip', '0000-00-00 00:00:00', '2018-09-30 15:21:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `default_extra_gigs`
--

CREATE TABLE `default_extra_gigs` (
  `default_gig_id` int(11) NOT NULL,
  `gig_description` text NOT NULL,
  `category_belongs` varchar(500) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 - Active , 1 - Inactive',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `digital_download`
--

CREATE TABLE `digital_download` (
  `id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `filename` varchar(256) NOT NULL,
  `buyer_show` tinyint(4) NOT NULL COMMENT '0-show,-hide',
  `seller_show` tinyint(4) NOT NULL COMMENT '0-show,1-hide',
  `upload_user_id` int(11) NOT NULL,
  `file_size` varchar(50) NOT NULL,
  `added_on` datetime NOT NULL,
  `time_zone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `digital_download`
--

INSERT INTO `digital_download` (`id`, `gig_id`, `order_id`, `seller_id`, `buyer_id`, `filename`, `buyer_show`, `seller_show`, `upload_user_id`, `file_size`, `added_on`, `time_zone`) VALUES
(1, 72, 32, 138, 143, '404.zip', 0, 0, 138, '228.46', '2018-11-10 11:31:38', 'Asia/Kolkata'),
(2, 73, 35, 134, 135, 'youtube_video_downloader_16.zip', 0, 0, 134, '753.56', '2018-11-10 13:40:38', 'Asia/Kolkata'),
(3, 72, 46, 138, 143, 'blog.zip', 0, 0, 138, '928.32', '2018-11-10 14:49:16', 'Asia/Kolkata'),
(4, 72, 52, 138, 144, 'google-maps-services-js-master.zip', 0, 0, 138, '66.11', '2018-11-12 12:27:37', 'Asia/Kolkata');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `template_id` int(10) UNSIGNED NOT NULL,
  `template_title` tinytext NOT NULL,
  `template_content` longblob NOT NULL,
  `template_type` tinyint(3) NOT NULL,
  `template_created` datetime NOT NULL,
  `template_status` tinyint(3) NOT NULL COMMENT '0 - Inactive ,1 - Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`template_id`, `template_title`, `template_content`, `template_type`, `template_created`, `template_status`) VALUES
(8, 'E-Mail Purchase Completed', 0x3c68323e4869207b73656c6c5f6e616d657d2c3c2f68323e0d0a0d0a3c703e596f75722050757263686173652066726f6d207b6769675f6f776e65727d203c7374726f6e673e207b7469746c657d203c2f7374726f6e673e686173206265656e20636f6d706c65746564266e6273703b3c2f703e0d0a0d0a3c703e436c69636b2074686520627574746f6e2062656c6f7720746f20746f2076696577204769673a3c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20233461633130323b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e4769672056696577206c696e6b3c2f613e3c2f703e0d0a0d0a3c703e436c69636b2074686520627574746f6e2062656c6f7720746f20746f207669657720557365722050726f66696c653a3c2f703e0d0a0d0a3c703e3c6120687265663d227b757365725f70726f66696c655f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20236262616466633b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e566965772055736572732050726f66696c65206c696e6b3c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e4368656572732c3c2f703e0d0a0d0a3c703e7b736974657469746c657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 8, '2016-09-24 18:03:51', 1),
(9, 'Email user purchase seller gig', 0x3c68323e4869207b62757965725f6e616d657d2c3c2f68323e0d0a0d0a3c703e266e6273703b3c7374726f6e673e7b62757965725f6e616d657d203c2f7374726f6e673e6861732070757263686173656420796f757220676967203c7374726f6e673e7b7469746c657d3c2f7374726f6e673e2e3c2f703e0d0a0d0a3c703e436c69636b2074686520627574746f6e2062656c6f7720746f20746f2076696577204769673a3c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20233461633130323b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e436c69636b2048657265203c2f613e3c2f703e0d0a0d0a3c703e436c69636b2074686520627574746f6e2062656c6f7720746f20746f207669657720557365722050726f66696c653a3c2f703e0d0a0d0a3c703e3c6120687265663d227b757365725f70726f66696c655f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20236262616466633b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e566965772055736572732050726f66696c65206c696e6b3c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e4368656572732c3c2f703e0d0a0d0a3c703e7b736974657469746c657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 9, '2016-09-26 09:44:14', 1),
(10, 'Email User Buying', 0x3c68323e4869207b62757965725f6e616d657d2c3c2f68323e0d0a0d0a3c703e596f752068617665206d6164652070757263686173652066726f6d207b73656c6c65725f6e616d657d203c7374726f6e673e7b7469746c657d3c2f7374726f6e673e2e3c2f703e0d0a0d0a3c703e436c69636b2074686520627574746f6e2062656c6f7720746f20746f2076696577204769673a3c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20236262616466633b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e4769672056696577206c696e6b3c2f613e3c2f703e0d0a0d0a3c703e436c69636b2074686520627574746f6e2062656c6f7720746f20746f207669657720557365722050726f66696c653a3c2f703e0d0a0d0a3c703e3c6120687265663d227b757365725f70726f66696c655f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20236262616466633b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e566965772055736572732050726f66696c65206c696e6b3c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e4368656572732c3c2f703e0d0a3c703e7b736974657469746c657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 10, '2016-09-26 11:11:05', 1),
(13, 'Email Registration success', 0x3c68323e4869207b555345525f4e414d457d2c3c2f68323e0d0a0d0a3c703e5468616e6b20796f7520666f72206a6f696e696e67207b736974657469746c657d2e20546f2066696e697368207369676e696e672075702c20796f75206a757374206e65656420746f20636f6e6669726d207468617420776520676f7420796f757220656d61696c2072696768742e3c2f703e0d0a0d0a3c703e436c69636b2074686520627574746f6e2062656c6f7720746f20636f6e6669726d20796f757220656d61696c20616464726573732e3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e3c6120687265663d227b5355424d49545f4c494e4b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20233461633130323b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e436f6e6669726d20656d61696c20616464726573733c2f613e3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e4f6e636520796f75206861766520766973697465642074686520766572696669636174696f6e2055524c2c20796f7572206163636f756e742077696c6c206265206163746976617465642e3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e5468616e6b732c3c6272202f3e0d0a7b736974657469746c657d205465616d3c2f703e0d0a, 13, '2016-10-04 12:38:25', 1),
(14, 'Email Forgot Password', 0x3c68323e4869207b555345525f4e414d457d202c3c2f68323e0d0a0d0a3c703e5765262333393b76652072656365697665642061207265717565737420746f207265736574207468652070617373776f726420666f72207468697320656d61696c20616464726573732e3c2f703e0d0a0d0a3c703e436c69636b2074686520627574746f6e2062656c6f7720746f2072657365742069742e3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e3c6120687265663d227b5355424d49545f4c494e4b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20233461633130323b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e5265736574204d792050617373776f72643c2f613e3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e496620796f75206469646e262333393b74207265717565737420746869732c20796f752063616e2069676e6f7265207468697320656d61696c2e20596f75722070617373776f726420776f6e262333393b74206368616e676520756e74696c20796f75206372656174652061206e65772070617373776f72642e3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e5468616e6b732c3c6272202f3e0d0a7b736974657469746c657d205465616d3c2f703e0d0a, 14, '2016-10-04 12:55:37', 1),
(16, 'Email Feedback Received', 0x3c68323e4869207b73656c6c65725f6e616d657d202c3c2f68323e0d0a0d0a3c703e3c7374726f6e673e596f7520686176652072656365697665642074686520666565646261636b2066726f6d3c2f7374726f6e673e203c6120687265663d227b757365725f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b62757965725f6e616d657d3c2f613e20666f722062656c6f7720746869732070726f647563743c2f703e0d0a0d0a3c703e3c6120687265663d227b757365725f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b7469746c657d3c2f613e3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e496620796f752077616e7420746f207265706c7920666f72207468697320666565646261636b2c2063616e20796f7520676f20746f20796f75722073616c65732070616765206f7220636c69636b2074686520627574746f6e20746f207265706c7920666565646261636b3c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20236666663b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20233461633130323b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e5265706c7920746f207b62757965725f6e616d657d3c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e5468616e6b732c3c2f703e0d0a0d0a3c703e7b736974655f6e616d657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 16, '2016-10-13 09:40:22', 1),
(17, 'Email Feedback Reply', 0x3c68323e4869207b62757965725f6e616d657d2c3c2f68323e0d0a0d0a3c703e3c7374726f6e673e596f75206861766520726563656976656420746865207265706c7920666565646261636b2066726f6d3c2f7374726f6e673e203c6120687265663d227b757365725f70726f66696c655f6c696e6b7d22207461726765743d225f626c616e6b22207374796c653d22636f6c6f723a20236262616466633b223e7b73656c6c65725f6e616d657d203c2f613e20666f722062656c6f7720746869732070726f647563743c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22636f6c6f723a20236262616466633b22207461726765743d225f626c616e6b223e7b7469746c657d3c2f613e3c2f703e0d0a0d0a3c703e5468616e6b20796f7520666f7220796f75722074696d6520616e6420636f6e73696465726174696f6e2e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e5468616e6b732c3c2f703e0d0a0d0a3c703e7b736974655f6e616d657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 17, '2016-10-13 09:51:09', 1),
(18, 'Email Order Complete', 0x3c68323e4869207b62757965725f6e616d657d202c3c2f68323e0d0a0d0a3c703e596f7572206f7264657220697320636f6d706c65746564206279203c6120687265663d227b757365725f70726f66696c655f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b6769675f6f776e65727d3c2f613e20666f72207468652062656c6f772070726f647563743c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b7469746c657d3c2f613e3c2f703e0d0a0d0a3c703e506c6561736520636865636b20746865206f726465722e20496620796f7572206f7264657220697320636f6d706c657465642c20796f752063616e206769766520666565646261636b20666f7220746869732070726f647563742e3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e436c69636b2074686520627574746f6e2062656c6f7720746f206769766520666565646261636b2e3c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f70757263686173657d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20233461633130323b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e4769766520466565646261636b3c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e5468616e6b732c3c2f703e0d0a0d0a3c703e7b736974655f6e616d657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 18, '2016-10-13 09:56:34', 1),
(19, 'Email Purchase Completed for admin', 0x3c7461626c652063656c6c70616464696e673d2230222063656c6c73706163696e673d223022207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a303b2077696474683a31303025223e0d0a093c74626f64793e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c6832207374796c653d226d617267696e2d6c6566743a313570783b206d617267696e2d72696768743a313570783b20746578742d616c69676e3a63656e746572223e437265617465204e6577204f726465723c2f68323e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c6834207374796c653d226d617267696e2d6c6566743a3570783b206d617267696e2d72696768743a3570783b20746578742d616c69676e3a63656e746572223e7765262333393b6c6c206c657420796f75206b6e6f77207768656e20796f7572206974656d732061726520636f6d706c6574653c2f68343e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e0d0a0909093c7461626c65207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a32307078206175746f20303b20746578742d616c69676e3a6c6566743b2077696474683a31303025223e0d0a090909093c74626f64793e0d0a09090909093c74723e0d0a0909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e7b50415950414c5f49447d3c6272202f3e0d0a0909090909097b435245415445445f4f4e7d3c6272202f3e0d0a09090909090953656c6c65723a203c6120687265663d226a6176617363726970743a3b22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b73656c6c65725f6e616d657d3c2f613e3c6272202f3e0d0a09090909090942757965723a203c6120687265663d226a6176617363726970743a3b22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b62757965725f6e616d657d3c2f613e3c2f74643e0d0a09090909093c2f74723e0d0a09090909093c74723e0d0a0909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909090909093c7461626c65207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a303b20746578742d616c69676e3a6c6566743b2077696474683a31303025223e0d0a090909090909093c74686561643e0d0a09090909090909093c74723e0d0a0909090909090909093c74683e4974656d3c2f74683e0d0a0909090909090909093c74683e50726f64756374204e616d653c2f74683e0d0a0909090909090909093c74683e5175616e746974793c2f74683e0d0a0909090909090909093c74683e546f74616c3c2f74683e0d0a09090909090909093c2f74723e0d0a090909090909093c2f74686561643e0d0a090909090909093c74626f64793e0d0a09090909090909093c74723e0d0a0909090909090909093c74643e3c696d67207372633d227b494d475f5352437d22207374796c653d226865696768743a333470783b2077696474683a3530707822202f3e3c2f74643e0d0a0909090909090909093c74643e3c6120687265663d222322207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b4954454d5f4e414d457d3c2f613e3c2f74643e0d0a0909090909090909093c74643e313c2f74643e0d0a0909090909090909093c74643e7b50524943457d3c2f74643e0d0a09090909090909093c2f74723e0d0a09090909090909093c74723e0d0a0909090909090909093c746420636f6c7370616e3d2234223e7b544541424c455f524f577d3c2f74643e0d0a09090909090909093c2f74723e0d0a090909090909093c2f74626f64793e0d0a090909090909093c74666f6f743e0d0a090909090909093c2f74666f6f743e0d0a0909090909093c2f7461626c653e0d0a0909090909093c2f74643e0d0a09090909093c2f74723e0d0a090909093c2f74626f64793e0d0a0909093c2f7461626c653e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e0d0a0909093c703e496620796f752077616e7420636865636b20796f7572206d616e616765207061796d656e74206c6973742c20636c69636b206f6e2062656c6f77206c696e6b3c2f703e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e3c6120687265663d222322207374796c653d22646973706c61793a696e6c696e652d626c6f636b3b206261636b67726f756e642d636f6c6f723a233461633130323b20626f726465722d7261646975733a3370783b20666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20236666663b20746578742d6465636f726174696f6e3a20696e68657269743b206d617267696e3a20303b70616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e5669657720796f7572206f72646572733c2f613e3c2f74643e0d0a09093c2f74723e0d0a093c2f74626f64793e0d0a3c2f7461626c653e0d0a, 19, '2016-10-14 10:22:37', 1),
(20, 'Payment request', 0x3c7461626c65207374796c653d22666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a303b20746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70626f782d73697a696e673a626f726465722d626f783b2077696474683a31303025223e0d0a093c74626f64793e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c6832207374796c653d226d617267696e2d6c6566743a313570783b206d617267696e2d72696768743a313570783b20746578742d616c69676e3a63656e746572223e5061796d656e7420526571756573742066726f6d207b73656c6c65725f6e616d657d3c2f68323e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c6834207374796c653d226d617267696e2d6c6566743a3570783b206d617267696e2d72696768743a3570783b20746578742d616c69676e3a63656e746572223e7765262333393b6c6c206c657420796f75206b6e6f77207768656e20796f7572206974656d732061726520636f6d706c6574653c2f68343e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e0d0a0909093c7461626c65207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a32307078206175746f20303b20746578742d616c69676e3a6c6566743b2077696474683a31303025223e0d0a090909093c74626f64793e0d0a09090909093c74723e0d0a0909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e5472616e73616374696f6e2049443a207b50415950414c5f49447d3c6272202f3e0d0a09090909090942757965723a203c6120687265663d226a6176617363726970743a3b22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b62757965725f6e616d657d3c2f613e3c2f74643e0d0a09090909093c2f74723e0d0a09090909093c74723e0d0a0909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909090909093c7461626c65207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a303b20746578742d616c69676e3a6c6566743b2077696474683a31303025223e0d0a090909090909093c74686561643e0d0a09090909090909093c74723e0d0a0909090909090909093c74683e4974656d3c2f74683e0d0a0909090909090909093c74683e50726f64756374204e616d653c2f74683e0d0a0909090909090909093c74683e5175616e746974793c2f74683e0d0a0909090909090909093c74683e546f74616c3c2f74683e0d0a09090909090909093c2f74723e0d0a090909090909093c2f74686561643e0d0a090909090909093c74626f64793e0d0a09090909090909093c74723e0d0a0909090909090909093c74643e3c696d67207372633d227b494d475f5352437d22207374796c653d226865696768743a333470783b2077696474683a3530707822202f3e3c2f74643e0d0a0909090909090909093c74643e3c6120687265663d222322207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b4954454d5f4e414d457d3c2f613e3c2f74643e0d0a0909090909090909093c74643e313c2f74643e0d0a0909090909090909093c74643e7b50524943457d3c2f74643e0d0a09090909090909093c2f74723e0d0a09090909090909093c74723e0d0a0909090909090909093c746420636f6c7370616e3d2234223e7b544541424c455f524f577d3c2f74643e0d0a09090909090909093c2f74723e0d0a090909090909093c2f74626f64793e0d0a0909090909093c2f7461626c653e0d0a0909090909093c2f74643e0d0a09090909093c2f74723e0d0a090909093c2f74626f64793e0d0a0909093c2f7461626c653e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e3c6272202f3e0d0a090909496620796f752077616e7420636865636b20796f7572206d616e616765207061796d656e74206c6973742c20636c69636b206f6e2062656c6f77206c696e6b3c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e3c6272202f3e0d0a0909093c6120687265663d222322207374796c653d22646973706c61793a696e6c696e652d626c6f636b3b206261636b67726f756e642d636f6c6f723a233461633130323b20626f726465722d7261646975733a3370783b20666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20236666663b20746578742d6465636f726174696f6e3a20696e68657269743b206d617267696e3a20303b70616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e5669657720796f7572206f72646572733c2f613e3c2f74643e0d0a09093c2f74723e0d0a093c2f74626f64793e0d0a3c2f7461626c653e0d0a, 20, '2016-10-15 15:23:31', 1),
(21, 'multiple payment request', 0x3c7461626c65207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a303b20746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f703b2077696474683a31303025223e0d0a093c74626f64793e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c6832207374796c653d226d617267696e2d6c6566743a313570783b206d617267696e2d72696768743a313570783b20746578742d616c69676e3a63656e746572223e5061796d656e7420526571756573742066726f6d207b73656c6c65725f6e616d657d3c2f68323e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c6834207374796c653d226d617267696e2d6c6566743a3570783b206d617267696e2d72696768743a3570783b20746578742d616c69676e3a63656e746572223e7765262333393b6c6c206c657420796f75206b6e6f77207768656e20796f7572206974656d732061726520636f6d706c6574653c2f68343e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c7461626c65207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a303b20746578742d616c69676e3a6c6566743b2077696474683a31303025223e0d0a090909093c74686561643e0d0a09090909093c74723e0d0a0909090909093c7468207374796c653d22766572746963616c2d616c69676e3a746f70223e4f726465722049643c2f74683e0d0a0909090909093c7468207374796c653d22766572746963616c2d616c69676e3a746f70223e50726f64756374204e616d653c2f74683e0d0a0909090909093c7468207374796c653d22766572746963616c2d616c69676e3a746f70223e42757965723c2f74683e0d0a0909090909093c7468207374796c653d22766572746963616c2d616c69676e3a746f70223e546f74616c3c2f74683e0d0a09090909093c2f74723e0d0a090909093c2f74686561643e0d0a090909093c74626f64793e0d0a09090909093c74723e0d0a0909090909093c746420636f6c7370616e3d2234223e7b544541424c455f524f577d3c2f74643e0d0a09090909093c2f74723e0d0a090909093c2f74626f64793e0d0a0909093c2f7461626c653e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e3c6272202f3e0d0a090909496620796f752077616e7420636865636b20796f7572206d616e616765207061796d656e74206c6973742c20636c69636b206f6e2062656c6f77206c696e6b3c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e3c6272202f3e0d0a0909093c6120687265663d222322207374796c653d22646973706c61793a696e6c696e652d626c6f636b3b206261636b67726f756e642d636f6c6f723a233461633130323b20626f726465722d7261646975733a3370783b20666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20236666663b20746578742d6465636f726174696f6e3a20696e68657269743b206d617267696e3a20303b70616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e5669657720796f7572206f72646572733c2f613e3c2f74643e0d0a09093c2f74723e0d0a093c2f74626f64793e0d0a3c2f7461626c653e0d0a, 21, '2016-10-15 16:13:19', 1),
(22, 'Email seller accepts buyer request', 0x3c7461626c652063656c6c70616464696e673d2230222063656c6c73706163696e673d223022207374796c653d22766572746963616c2d616c69676e3a746f703b2077696474683a31303025223e0d0a093c74626f64793e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c68323e4869207b6769675f6f776e65727d3c2f68323e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c68343e596f7572206769672077697468207469746c65203c7374726f6e673e7b7469746c657d3c2f7374726f6e673e206861732061206e657720726571756573742066726f6d203c6120687265663d227b42555945525f4c494e4b7d22207374796c653d22636f6c6f723a23626261646663223e7b62757965725f6e616d657d3c2f613e20776974682074686520666f6c6c6f77696e6720726571756972656d656e74733c2f68343e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c7461626c65207374796c653d2277696474683a31303025223e0d0a090909093c74626f64793e0d0a09090909093c74723e0d0a0909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e5472616e73616374696f6e2049443a207b50415950414c5f49447d3c6272202f3e0d0a09090909090942757965723a203c6120687265663d226a6176617363726970743a3b22207374796c653d22636f6c6f723a2362626164666322207461726765743d225f626c616e6b223e7b62757965725f6e616d657d3c2f613e3c2f74643e0d0a09090909093c2f74723e0d0a09090909093c74723e0d0a0909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909090909093c7461626c65207374796c653d2277696474683a31303025223e0d0a090909090909093c74686561643e0d0a09090909090909093c74723e0d0a0909090909090909093c7468207374796c653d22626f726465723a31707820736f6c696420236537653765373b70616464696e673a203870783b223e4974656d3c2f74683e0d0a0909090909090909093c7468207374796c653d22626f726465723a31707820736f6c696420236537653765373b70616464696e673a203870783b223e50726f64756374204e616d653c2f74683e0d0a0909090909090909093c7468207374796c653d22626f726465723a31707820736f6c696420236537653765373b70616464696e673a203870783b223e5175616e746974793c2f74683e0d0a0909090909090909093c7468207374796c653d22626f726465723a31707820736f6c696420236537653765373b70616464696e673a203870783b223e546f74616c3c2f74683e0d0a09090909090909093c2f74723e0d0a090909090909093c2f74686561643e0d0a090909090909093c74626f64793e0d0a09090909090909093c74723e0d0a0909090909090909093c7464207374796c653d22626f726465723a31707820736f6c696420236537653765373b70616464696e673a203870783b223e3c696d67207372633d227b494d475f5352437d22207374796c653d226865696768743a333470783b2077696474683a3530707822202f3e3c2f74643e0d0a0909090909090909093c7464207374796c653d22626f726465723a31707820736f6c696420236537653765373b70616464696e673a203870783b223e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22636f6c6f723a2362626164666322207461726765743d225f626c616e6b223e7b4954454d5f4e414d457d3c2f613e3c2f74643e0d0a0909090909090909093c7464207374796c653d22626f726465723a31707820736f6c696420236537653765373b70616464696e673a203870783b223e313c2f74643e0d0a0909090909090909093c7464207374796c653d22626f726465723a31707820736f6c696420236537653765373b70616464696e673a203870783b223e7b50524943457d3c2f74643e0d0a09090909090909093c2f74723e0d0a09090909090909093c74723e0d0a0909090909090909093c746420636f6c7370616e3d2234223e7b544541424c455f524f577d3c2f74643e0d0a09090909090909093c2f74723e0d0a090909090909093c2f74626f64793e0d0a0909090909093c2f7461626c653e0d0a0909090909093c2f74643e0d0a09090909093c2f74723e0d0a090909093c2f74626f64793e0d0a0909093c2f7461626c653e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e3c6272202f3e0d0a090909466f72206d6f726520726571756972656d656e74732066726f6d2074686520636c69656e74202c20636c69636b206f6e2062656c6f77206c696e6b3c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e3c6272202f3e0d0a0909093c6120687265663d227b726571756573745f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20236262616466633b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e566965772073616c65733c2f613e3c2f74643e0d0a09093c2f74723e0d0a093c2f74626f64793e0d0a3c2f7461626c653e0d0a, 22, '2016-10-25 10:33:53', 1),
(23, 'contact email', 0x3c68323e4869207b746f5f757365726e616d657d2c3c2f68323e0d0a0d0a3c703e596f75206861766520726563656976656420746865206d6573736167652066726f6d203c6120687265663d227b757365725f70726f66696c655f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b66726f6d5f757365726e616d657d203c2f613e3c2f703e0d0a0d0a3c703e3c6120687265663d227b6d6573736167655f6c696e6b7d22207374796c653d22646973706c61793a696e6c696e652d626c6f636b3b206261636b67726f756e642d636f6c6f723a236262616466633b20626f726465722d7261646975733a3370783b20666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20236666663b20746578742d6465636f726174696f6e3a20696e68657269743b206d617267696e3a20303b70616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e566965773c2f613e3c2f703e0d0a0d0a3c703e5468616e6b20796f7520666f7220796f75722074696d6520616e6420636f6e73696465726174696f6e2e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e5468616e6b732c3c2f703e0d0a3c703e7b736974655f6e616d657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 23, '2016-10-26 09:55:08', 1),
(24, 'Buyer cancelled order', 0x3c7461626c652063656c6c70616464696e673d2230222063656c6c73706163696e673d223022207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a303b20746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f703b2077696474683a31303025223e0d0a093c74626f64793e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c6832207374796c653d226d617267696e2d6c6566743a313570783b206d617267696e2d72696768743a313570783b20746578742d616c69676e3a63656e746572223e4869207b6769675f6f776e65727d3c2f68323e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c6834207374796c653d226d617267696e2d6c6566743a3570783b206d617267696e2d72696768743a3570783b20746578742d616c69676e3a63656e746572223e596f757220676967203c6120687265663d227b6769675f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b223e7b7469746c657d3c2f613e20686173206265656e2043616e63656c6c65642066726f6d203c6120687265663d227b42555945525f4c494e4b7d22207374796c653d22636f6c6f723a236262616466633b223e7b62757965725f6e616d657d3c2f613e20776974682074686520666f6c6c6f77696e6720726571756972656d656e74733c2f68343e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e0d0a0909093c7461626c65207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a32307078206175746f20303b20746578742d616c69676e3a6c6566743b2077696474683a31303025223e0d0a090909093c74626f64793e0d0a09090909093c74723e0d0a0909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e7b50415950414c5f49447d3c2f74643e0d0a09090909093c2f74723e0d0a09090909093c74723e0d0a0909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909090909093c7461626c65207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a303b20746578742d616c69676e3a6c6566743b2077696474683a31303025223e0d0a090909090909093c74686561643e0d0a09090909090909093c74723e0d0a0909090909090909093c7468207374796c653d22766572746963616c2d616c69676e3a746f70223e4974656d3c2f74683e0d0a0909090909090909093c7468207374796c653d22766572746963616c2d616c69676e3a746f70223e50726f64756374204e616d653c2f74683e0d0a0909090909090909093c7468207374796c653d22766572746963616c2d616c69676e3a746f70223e5175616e746974793c2f74683e0d0a0909090909090909093c7468207374796c653d22766572746963616c2d616c69676e3a746f70223e546f74616c3c2f74683e0d0a09090909090909093c2f74723e0d0a090909090909093c2f74686561643e0d0a090909090909093c74666f6f743e0d0a090909090909093c2f74666f6f743e0d0a090909090909093c74626f64793e0d0a09090909090909093c74723e0d0a0909090909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e3c696d67207372633d227b494d475f5352437d22207374796c653d226865696768743a333470783b2077696474683a3530707822202f3e3c2f74643e0d0a0909090909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e3c6120687265663d227b6769675f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b4954454d5f4e414d457d3c2f613e3c2f74643e0d0a0909090909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e313c2f74643e0d0a0909090909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e7b50524943457d3c2f74643e0d0a09090909090909093c2f74723e0d0a09090909090909093c74723e0d0a0909090909090909093c746420636f6c7370616e3d2234223e7b544541424c455f524f577d3c2f74643e0d0a09090909090909093c2f74723e0d0a090909090909093c2f74626f64793e0d0a0909090909093c2f7461626c653e0d0a0909090909093c2f74643e0d0a09090909093c2f74723e0d0a090909093c2f74626f64793e0d0a0909093c2f7461626c653e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e3c6272202f3e0d0a090909796f75206861766520616363657074206f75722072657175657374202c20636c69636b206f6e2062656c6f77206c696e6b3c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e3c6272202f3e0d0a0909093c6120687265663d227b6163636570745f6c696e6b7d22207374796c653d22646973706c61793a696e6c696e652d626c6f636b3b206261636b67726f756e642d636f6c6f723a233461633130323b20626f726465722d7261646975733a3370783b20666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20236666663b20746578742d6465636f726174696f6e3a20696e68657269743b206d617267696e3a20303b70616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e4163636570743c2f613e3c2f74643e0d0a09093c2f74723e0d0a093c2f74626f64793e0d0a3c2f7461626c653e0d0a, 24, '2016-10-26 12:40:29', 1),
(25, 'seller declined order', 0x3c68323e4869207b62757965725f6e616d657d202c3c2f68323e0d0a0d0a3c703e596f7572206f72646572206973204465636c696e65642066726f6d203c6120687265663d227b757365725f70726f66696c655f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b6769675f6f776e65727d3c2f613e20666f722062656c6f7720746869732070726f647563743c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b7469746c657d3c2f613e3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e506c656173652061636365707420746865206465636c696e6520726571756573742e3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e3c6120687265663d227b70757263686173655f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20233461633130323b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e47697665204163636570743c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e5468616e6b732c3c2f703e0d0a0d0a3c703e7b736974655f6e616d657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 25, '2016-10-31 10:49:23', 1),
(26, 'Decline request accept', 0x3c68323e4869207b62757965725f6e616d657d202c3c2f68323e0d0a0d0a3c703e596f7572204465636c696e6520726571756573742061636365707465642066726f6d203c6120687265663d227b757365725f70726f66696c655f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b6769675f6f776e65727d3c2f613e20666f722062656c6f7720746869732070726f647563743c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b7469746c657d3c2f613e3c2f703e0d0a0d0a3c703e506c6561736520636865636b20746865206f726465722e204966206f72646572206973204465636c696e65642c20796f752063616e20676976652061636365707420666f72204465636c696e6564206f726465722e3c2f703e0d0a0d0a3c703e3c6120687265663d227b73616c65735f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20233461633130323b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e566965773c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e5468616e6b732c3c2f703e0d0a0d0a3c703e7b736974655f6e616d657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 26, '2016-11-01 15:54:49', 1),
(27, 'Cancel request accept', 0x3c68323e4869207b62757965725f6e616d657d2c3c2f68323e0d0a0d0a3c703e596f75722043616e63656c20726571756573742061636365707465642066726f6d203c6120687265663d227b757365725f70726f66696c655f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b6769675f6f776e65727d3c2f613e266e6273703b20666f722062656c6f7720746869732070726f647563743c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b7469746c657d3c2f613e3c2f703e0d0a0d0a3c703e506c6561736520636865636b20746865206f726465722e3c2f703e0d0a0d0a3c703e3c6120687265663d227b70757263686173655f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20233461633130323b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e566965773c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e5468616e6b732c3c2f703e0d0a0d0a3c703e7b736974655f6e616d657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 27, '2016-11-01 16:05:04', 1),
(28, 'Admin Completed Payment', 0x3c68323e4869207b73656c6c65725f6e616d657d202c3c2f68323e0d0a0d0a3c703e596f7572207061796d656e742072657175657374207375636365737366756c6c792073656e7420746f20796f7572206163636f756e7420666f722062656c6f7720746869732070726f647563743c2f703e0d0a0d0a3c703e506c6561736520636865636b20746865207061796d656e742e3c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b223e7b5449544c457d3c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e5468616e6b732c3c2f703e0d0a0d0a3c703e7b736974655f6e616d657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 28, '0000-00-00 00:00:00', 1),
(29, 'Order Complete Request ', 0x3c68323e4869207b62757965725f6e616d657d202c3c2f68323e0d0a0d0a3c703e596f752068617665207265636569766564206f7264657220636f6d706c6574656420726571756573743c2f703e0d0a0d0a3c703e506c65617365206163636570742074686520636f6d706c6574656420726571756573742e3c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b223e7b7469746c657d3c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e5468616e6b732c3c2f703e0d0a0d0a3c703e7b736974655f6e616d657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 29, '0000-00-00 00:00:00', 1),
(30, 'Complete Request Accepted', 0x3c68323e4869207b6769675f6f776e65727d202c3c2f68323e0d0a0d0a3c703e266e6273703b4f7264657220636f6d706c65746564207265717565737420266e6273703b61636365707465642062792062757965722e3c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b223e7b7469746c657d3c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e5468616e6b732c3c2f703e0d0a3c703e7b736974655f6e616d657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 30, '0000-00-00 00:00:00', 1),
(31, 'Cancel Request', 0x3c68323e4869207b73656c6c65725f6e616d657d202c3c2f68323e0d0a0d0a3c703e596f757220636f6d706c65746564207265717565737420686173206265656e2052656a6563746564206279203c6120687265663d227b757365725f70726f66696c655f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b62757965725f6e616d657d3c2f613e20666f722062656c6f7720746869732070726f647563743c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f707265766965775f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b7469746c657d3c2f613e3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20233461633130323b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e436865636b204e6f773c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e5468616e6b732c3c2f703e0d0a0d0a3c703e7b736974655f6e616d657d205465616d3c2f703e0d0a3c2f6469763e0d0a, 31, '0000-00-00 00:00:00', 1),
(32, 'Buyer reject completed request', 0x3c68323e4869207b61646d696e5f6e616d657d202c3c2f68323e0d0a0d0a3c703e596f7520686176652061204e65772052656a6563746564204f7264657220526571756573743c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c703e3c6120687265663d227b6769675f6c696e6b7d22207374796c653d22666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20234646463b20746578742d6465636f726174696f6e3a206e6f6e653b206c696e652d6865696768743a2032656d3b20637572736f723a20706f696e7465723b20646973706c61793a20696e6c696e652d626c6f636b3b20626f726465722d7261646975733a203570783b20746578742d7472616e73666f726d3a206361706974616c697a653b206261636b67726f756e642d636f6c6f723a20233461633130323b206d617267696e3a20303b2070616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e52656a6563746564204f72646572733c2f613e3c2f703e0d0a0d0a3c646976207374796c653d22666c6f61743a6c6566743b206d617267696e2d746f703a323070783b2077696474683a31303025223e0d0a3c703e5468616e6b732c3c2f703e0d0a0d0a3c703e7b62757965725f6e616d657d2e3c2f703e0d0a3c2f6469763e0d0a, 32, '0000-00-00 00:00:00', 1);
INSERT INTO `email_templates` (`template_id`, `template_title`, `template_content`, `template_type`, `template_created`, `template_status`) VALUES
(34, 'Buyer Refund Amount', 0x3c7461626c652063656c6c70616464696e673d2230222063656c6c73706163696e673d223022207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a303b20746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f703b2077696474683a31303025223e0d0a093c74626f64793e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c6832207374796c653d226d617267696e2d6c6566743a313570783b206d617267696e2d72696768743a313570783b20746578742d616c69676e3a63656e746572223e4869203c6120687265663d227b42555945525f4c494e4b7d223e7b62757965725f6e616d657d3c2f613e3c2f68323e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909093c6834207374796c653d226d617267696e2d6c6566743a3570783b206d617267696e2d72696768743a3570783b20746578742d616c69676e3a63656e746572223e43616e63656c6c6174696f6e20616d6f756e7420686173206265656e20726566756e64656420666f722074686520676967203c6120687265663d227b6769675f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b223e7b7469746c657d3c2f613e3c2f68343e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e0d0a0909093c7461626c65207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a32307078206175746f20303b20746578742d616c69676e3a6c6566743b2077696474683a31303025223e0d0a090909093c74626f64793e0d0a09090909093c74723e0d0a0909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e427579657220526566756e6420416d6f756e743c2f74643e0d0a09090909093c2f74723e0d0a09090909093c74723e0d0a0909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e0d0a0909090909093c7461626c65207374796c653d22626f782d73697a696e673a626f726465722d626f783b20666f6e742d66616d696c793a2748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20666f6e742d73697a653a313470783b206d617267696e3a303b20746578742d616c69676e3a6c6566743b2077696474683a31303025223e0d0a090909090909093c74686561643e0d0a09090909090909093c74723e0d0a0909090909090909093c7468207374796c653d22766572746963616c2d616c69676e3a746f70223e4974656d3c2f74683e0d0a0909090909090909093c7468207374796c653d22766572746963616c2d616c69676e3a746f70223e50726f64756374204e616d653c2f74683e0d0a0909090909090909093c7468207374796c653d22766572746963616c2d616c69676e3a746f70223e5175616e746974793c2f74683e0d0a0909090909090909093c7468207374796c653d22766572746963616c2d616c69676e3a746f70223e546f74616c3c2f74683e0d0a09090909090909093c2f74723e0d0a090909090909093c2f74686561643e0d0a090909090909093c74666f6f743e0d0a090909090909093c2f74666f6f743e0d0a090909090909093c74626f64793e0d0a09090909090909093c74723e0d0a0909090909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e3c696d67207372633d227b494d475f5352437d22207374796c653d226865696768743a333470783b2077696474683a3530707822202f3e3c2f74643e0d0a0909090909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e3c6120687265663d227b6769675f6c696e6b7d22207374796c653d22636f6c6f723a236262616466633b22207461726765743d225f626c616e6b223e7b4954454d5f4e414d457d3c2f613e3c2f74643e0d0a0909090909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e313c2f74643e0d0a0909090909090909093c7464207374796c653d22766572746963616c2d616c69676e3a746f70223e7b50524943457d3c2f74643e0d0a09090909090909093c2f74723e0d0a09090909090909093c74723e0d0a0909090909090909093c746420636f6c7370616e3d2234223e7b544541424c455f524f577d3c2f74643e0d0a09090909090909093c2f74723e0d0a090909090909093c2f74626f64793e0d0a0909090909093c2f7461626c653e0d0a0909090909093c2f74643e0d0a09090909093c2f74723e0d0a090909093c2f74626f64793e0d0a0909093c2f7461626c653e0d0a0909093c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e3c6272202f3e0d0a090909796f75206861766520616363657074206f75722072657175657374202c20636c69636b206f6e2062656c6f77206c696e6b3c2f74643e0d0a09093c2f74723e0d0a09093c74723e0d0a0909093c7464207374796c653d22746578742d616c69676e3a63656e7465723b20766572746963616c2d616c69676e3a746f70223e3c6272202f3e0d0a0909093c6120687265663d227b6163636570745f6c696e6b7d22207374796c653d22646973706c61793a696e6c696e652d626c6f636b3b206261636b67726f756e642d636f6c6f723a233461633130323b20626f726465722d7261646975733a3370783b20666f6e742d66616d696c793a202748656c766574696361204e657565272c48656c7665746963612c417269616c2c73616e732d73657269663b20626f782d73697a696e673a20626f726465722d626f783b20666f6e742d73697a653a20313470783b20636f6c6f723a20236666663b20746578742d6465636f726174696f6e3a20696e68657269743b206d617267696e3a20303b70616464696e673a35707820313070783b22207461726765743d225f626c616e6b223e4163636570743c2f613e3c2f74643e0d0a09093c2f74723e0d0a093c2f74626f64793e0d0a3c2f7461626c653e0d0a, 34, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `enquerys`
--

CREATE TABLE `enquerys` (
  `id` bigint(20) NOT NULL,
  `name` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `contact` varchar(500) NOT NULL,
  `message` varchar(500) NOT NULL,
  `notification_status` int(128) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquerys`
--

INSERT INTO `enquerys` (`id`, `name`, `email`, `contact`, `message`, `notification_status`) VALUES
(3, 'Deepak', 'deepakpatel@digimonk.in', '8435144608', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop p', 1),
(4, 'deepak patel', 'deepakpatel@digimonk.in', '07999908258', 'kljzbx asdjvhbfadmvb fadkhv vf adfvafdlhvbafdjv afdluiv adf,nv afdvafd,jv oaidflv adf,hvbadfv alfdvbjadf vliadfvbkljzbx asdjvhbfadmvb fadkhv vf adfvafdlhvbafdjv afdluiv adf,nv afdvafd,jv oaidflv adf,hvbadfv alfdvbjadf vliadfvbkljzbx asdjvhbfadmvb fadkhv vf adfvafdlhvbafdjv afdluiv adf,nv afdvafd,jv oaidflv adf,hvbadfv alfdvbjadf vliadfvbkljzbx asdjvhbfadmvb fadkhv vf adfvafdlhvbafdjv afdluiv adf,nv afdvafd,jv oaidflv adf,hvbadfv alfdvbjadf vliadfvb', 1),
(5, 'deepak patel', 'deepaksinghpatel052@gmail.com', '07999908258', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop p', 1),
(6, 'dpzfvfsjkvb', 'jzsdvshvbf@jbsdfhsjrg.jsdbhgb', '23524354', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop p', 1),
(7, 'Deepak', 'deepaksinghpatel052@gmail.com', '8435144608', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop p', 1),
(8, 'deepak patel', 'deepakpatel@digimonk.in', '07999908258', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop p', 1);

-- --------------------------------------------------------

--
-- Table structure for table `extra_gigs`
--

CREATE TABLE `extra_gigs` (
  `id` int(11) NOT NULL,
  `gigs_id` int(11) NOT NULL,
  `currency_type` char(5) NOT NULL,
  `currency_sign` char(5) NOT NULL,
  `extra_gigs` varchar(500) NOT NULL,
  `extra_gigs_amount` float NOT NULL,
  `extra_gigs_delivery` varchar(500) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `extra_gigs`
--

INSERT INTO `extra_gigs` (`id`, `gigs_id`, `currency_type`, `currency_sign`, `extra_gigs`, `extra_gigs_amount`, `extra_gigs_delivery`, `created_date`) VALUES
(19, 10, 'USD', '', 'i give template', 10, '1', '2018-09-29 13:58:42'),
(21, 9, 'USD', '', 'I can make it animated', 20, '1', '2018-09-29 14:00:58'),
(22, 7, 'USD', '', 'I can give more creative it ', 10, '1', '2018-09-29 14:02:45'),
(23, 6, 'USD', '', 'Make it HD', 5, '1', '2018-09-29 14:06:36'),
(24, 2, 'USD', '', 'I can add auto email', 10, '2', '2018-09-29 14:07:07'),
(25, 1, 'USD', '', '1 time revision', 10, '1', '2018-09-29 14:07:35'),
(26, 13, 'USD', '', 'I can handle also content regular', 50, '1', '2018-09-29 14:09:23'),
(27, 11, 'USD', '', 'i can give you  resume cover', 5, '1', '2018-09-29 14:10:45'),
(28, 5, 'USD', '', 'I make it animate', 10, '1', '2018-09-29 14:11:23'),
(29, 4, 'USD', '', 'I can also get more share ', 50, '10', '2018-09-29 14:13:04'),
(30, 3, 'USD', '', 'i can make it gif ', 50, '1', '2018-09-29 14:13:28'),
(31, 15, 'USD', '', 'content beautiful ', 10, '1', '2018-09-29 14:15:09'),
(32, 19, 'USD', '', 'dfvfg', 23, '1', '2018-10-25 11:39:48'),
(33, 20, 'USD', '', 'dgteh', 20, '10', '2018-10-26 07:24:22'),
(34, 21, 'USD', '', 'asndfbgjhdvb', 400, '1', '2018-10-26 13:37:58'),
(35, 22, 'USD', '', 'Test ', 12, '8', '2018-10-27 08:37:25'),
(36, 22, 'USD', '', 'Test 1', 8, '5', '2018-10-27 08:37:25'),
(38, 23, 'USD', '', 'jdcs', 10, '1', '2018-10-28 07:41:27'),
(40, 24, 'USD', '', 'pADVFD', 20, '1', '2018-10-28 08:12:19'),
(42, 26, 'USD', '', 'rtet ythyth uf', 10, '1', '2018-10-29 05:40:46'),
(43, 27, 'USD', '', 'drgrg', 12, '1', '2018-10-29 08:04:00'),
(44, 28, 'USD', '', 'dfvd', 12, '1', '2018-10-29 09:31:49'),
(45, 29, 'USD', '', 'dfgbdgb', 23, '1', '2018-10-29 11:17:01'),
(46, 30, 'USD', '', 'fdvdfb', 1, '1', '2018-10-29 12:07:31'),
(47, 31, 'USD', '', 'wefwefwefwef', 121, '1', '2018-10-29 12:48:58'),
(48, 32, 'USD', '', 'asdf ad fad f asdf', 45, '1', '2018-10-29 13:16:21'),
(49, 33, 'USD', '', 'dsfasd', 34, '1', '2018-10-29 13:21:57'),
(50, 35, 'USD', '', 'wefwefwefwef', 12, '1', '2018-10-29 15:54:17'),
(51, 37, 'USD', '', 'hi testing', 19, '1', '2018-10-29 17:58:08'),
(52, 38, 'USD', '', 'Test ', 12, '1', '2018-10-30 15:56:30'),
(53, 39, 'USD', '', 'Test ', 12, '1', '2018-10-30 15:56:31'),
(57, 40, 'USD', '', 'dfkjvsejk trsjhfukbgvf', 10, '1', '2018-10-31 08:05:32'),
(58, 42, 'USD', '', 'Test', 12, '1', '2018-10-31 10:35:34'),
(59, 43, 'USD', '', 'dfgvsfvf', 10, '1', '2018-10-31 12:35:50'),
(60, 47, 'USD', '', 'dgr th rthtrhtyhytehyeththth', 10, '1', '2018-10-31 14:44:47'),
(66, 49, 'USD', '', 'erdgtrbtrht', 10, '1', '2018-11-01 04:33:35'),
(68, 50, 'USD', '', 'dfgdf', 345, '4', '2018-11-01 05:15:48'),
(69, 48, 'USD', '', 'asdgasdf', 23, '14', '2018-11-01 05:24:39'),
(70, 54, 'USD', '', 'adskgj', 34, '1', '2018-11-01 12:55:21'),
(71, 55, 'USD', '', 'fgnthdnyndhg d', 10, '1', '2018-11-01 14:01:39'),
(72, 60, 'USD', '', 'adsf', 23, '14', '2018-11-02 12:35:57'),
(73, 61, 'USD', '', 'hkgyvg', 10, '25', '2018-11-02 12:58:07'),
(78, 59, 'USD', '', 'fthyjyjy', 14, '', '2018-11-02 14:07:59'),
(79, 62, 'USD', '', 'asdf', 456, '678', '2018-11-02 14:35:30'),
(80, 63, 'USD', '', 'dfghtrhrth tdhdh th ythh', 12, '10', '2018-11-03 04:51:51'),
(81, 64, 'USD', '', 'adf', 345, '198', '2018-11-03 05:36:01'),
(102, 84, 'USD', '', 'xvb', 23, '1', '2018-11-23 13:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `faqs_categories`
--

CREATE TABLE `faqs_categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `category_image` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faqs_categories`
--

INSERT INTO `faqs_categories` (`id`, `name`, `status`, `category_image`) VALUES
(1, 'Getting Started', '0', 'picture-frame-with-mountain-image_318-40293.jpg'),
(2, 'Knowledge', '0', 'picture-frame-with-mountain-image_318-402931.jpg'),
(3, 'Our Community', '0', 'picture-frame-with-mountain-image_318-402932.jpg'),
(4, 'Search', '0', 'picture-frame-with-mountain-image_318-402933.jpg'),
(5, 'Contact', '0', 'picture-frame-with-mountain-image_318-402934.jpg'),
(12, 'Influencer', '0', 'picture-frame-with-mountain-image_318-402935.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`id`, `user_id`, `gig_id`) VALUES
(1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `order_id` mediumint(9) NOT NULL DEFAULT '0',
  `comment` varchar(500) NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT '0',
  `time_zone` varchar(75) NOT NULL,
  `country_name` varchar(75) NOT NULL,
  `sent_recieved` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - sent , 1 - replay',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `mail_sent` int(11) NOT NULL DEFAULT '1',
  `notification_status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `from_user_id`, `to_user_id`, `gig_id`, `order_id`, `comment`, `rating`, `time_zone`, `country_name`, `sent_recieved`, `created_date`, `status`, `mail_sent`, `notification_status`) VALUES
(1, 141, 140, 68, 10, 'The work done was amazing and I like the developer. I would like to work again with the same developer', 5, 'Asia/Kolkata', '', 0, '2018-11-09 14:02:06', 1, 1, 0),
(2, 135, 134, 64, 25, 'hi you have done very good job.', 4, 'Asia/Kolkata', '', 0, '2018-11-09 18:29:37', 1, 1, 0),
(3, 141, 140, 70, 30, 'best person to work with', 5, 'Asia/Kolkata', '', 0, '2018-11-09 23:31:43', 1, 1, 0),
(4, 141, 140, 70, 49, 'Great working with him again, ', 5, 'Asia/Kolkata', '', 0, '2018-11-11 23:28:40', 1, 1, 0),
(5, 141, 140, 70, 48, 'This guy is awesome....', 5, 'Asia/Kolkata', '', 0, '2018-11-14 23:32:18', 1, 1, 0),
(6, 144, 0, 71, 56, 'grate work for this project it two good work.', 4, 'Asia/Kolkata', '', 0, '2018-11-19 16:37:01', 1, 1, 1),
(7, 144, 142, 71, 56, 'grate work for this project it two good work.', 4, 'Asia/Kolkata', '', 0, '2018-11-19 16:37:01', 1, 1, 0),
(8, 144, 142, 71, 56, 'lcvnbjkgbk ksfjgbkjfgb kgb gf gf', 4, 'Asia/Kolkata', '', 0, '2018-11-19 16:39:34', 1, 1, 0),
(9, 135, 142, 74, 58, 'hi bhai kya kaam kiya hai tumne', 4, 'Asia/Kolkata', '', 0, '2018-11-20 11:33:40', 1, 1, 1),
(10, 144, 142, 71, 64, 'asdgvrgqevgerwgwtg', 4, 'Asia/Kolkata', '', 0, '2018-11-20 17:31:13', 1, 1, 0),
(11, 144, 142, 71, 63, 'sDVear garegrgrgrfr g', 4, 'Asia/Kolkata', '', 0, '2018-11-20 17:31:23', 1, 1, 0),
(12, 144, 142, 71, 62, 'asdsergvsfb sg gtsrg strh', 4, 'Asia/Kolkata', '', 0, '2018-11-20 17:31:29', 1, 1, 0),
(13, 144, 142, 71, 61, 'Good work my project is done.', 5, 'Asia/Kolkata', '', 0, '2018-11-20 17:32:05', 1, 1, 0),
(14, 144, 142, 71, 65, 'Good work', 3, 'Asia/Kolkata', '', 0, '2018-11-20 18:42:00', 1, 1, 0),
(15, 142, 144, 71, 65, 'Thank You Deepak', 0, 'Asia/Kolkata', '', 1, '2018-11-20 18:42:33', 1, 1, 0),
(16, 160, 158, 81, 67, 'good job!!!!!', 4, 'Asia/Kolkata', '', 0, '2018-11-21 15:40:09', 1, 1, 0),
(17, 165, 164, 84, 68, 'good job!', 4, 'Asia/Kolkata', '', 0, '2018-11-23 19:42:17', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `footer_menu`
--

CREATE TABLE `footer_menu` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `footer_menu`
--

INSERT INTO `footer_menu` (`id`, `title`, `status`, `created_date`) VALUES
(3, 'Learn', 1, '2018-09-29 10:26:43'),
(5, 'Industry_Data', 1, '2018-09-29 10:27:14'),
(6, 'Feedback', 1, '2018-09-29 10:38:27');

-- --------------------------------------------------------

--
-- Table structure for table `footer_submenu`
--

CREATE TABLE `footer_submenu` (
  `id` int(11) NOT NULL,
  `footer_menu` int(11) NOT NULL,
  `footer_submenu` varchar(50) NOT NULL,
  `page_title` varchar(50) NOT NULL,
  `page_desc` longtext NOT NULL,
  `seo_title` varchar(50) NOT NULL,
  `seo_desc` varchar(500) NOT NULL,
  `seo_keyword` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `footer_submenu`
--

INSERT INTO `footer_submenu` (`id`, `footer_menu`, `footer_submenu`, `page_title`, `page_desc`, `seo_title`, `seo_desc`, `seo_keyword`, `status`, `created_date`) VALUES
(11, 3, 'Support', '', '', '', '', '', 0, '2018-09-29 10:34:22'),
(16, 3, 'Terms_of_services', '', '<div class=\"container\">\r\n<h1>&nbsp;</h1>\r\n<!--  <h1>Terms and Conditions (\"Terms\")</h1> -->\r\n\r\n<p>Last updated:17/11/2018</p>\r\n\r\n<p>Please read these Terms and Conditions (&quot;Terms&quot;, &quot;Terms and Conditions&quot;) carefully before using the work.digimonk.net website and the operated by influencer (&quot;us&quot;, &quot;we&quot;, or &quot;our&quot;).</p>\r\n\r\n<p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Service.</p>\r\n\r\n<p><strong>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service. </strong></p>\r\n\r\n<h2>Purchases</h2>\r\n\r\n<p>If you wish to purchase any product or service made available through the Service (&quot;Purchase&quot;), you may be asked to supply certain information relevant to your Purchase including, without limitation, your &hellip;</p>\r\n\r\n<p>The Purchases section is for businesses that sell online (physical or digital). For the full disclosure section, create your own Terms and Conditions.</p>\r\n\r\n<h2>Subscriptions</h2>\r\n\r\n<p>Some parts of the Service are billed on a subscription basis (&quot;Subscription(s)&quot;). You will be billed in advance on a recurring ...</p>\r\n\r\n<p>The Subscriptions section is for SaaS businesses. For the full disclosure section, create your own Terms and Conditions.</p>\r\n\r\n<h2>Content</h2>\r\n\r\n<p>Our Service allows you to post, link, store, share and otherwise make available certain information, text, graphics, videos, or other material (&quot;Content&quot;). You are responsible for the &hellip;</p>\r\n\r\n<p>The Content section is for businesses that allow users to create, edit, share, make content on their websites or apps. For the full disclosure section, create your own Terms and Conditions.</p>\r\n\r\n<h2>Links To Other Web Sites</h2>\r\n\r\n<p>9Our Service may contain links to third-party web sites or services that are not owned or controlled by Influencer.</p>\r\n\r\n<p>My Company (change this) has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party web sites or services. You further acknowledge and agree that My Company (change this) shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such web sites or services.</p>\r\n\r\n<h2>Changes</h2>\r\n\r\n<p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will try to provide at least 30 (change this) days&#39; notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>\r\n\r\n<h2>Contact Us</h2>\r\n\r\n<p>If you have any questions about these Terms, please contact us.</p>\r\n</div>\r\n', '', '', '', 1, '2018-10-24 08:04:33'),
(17, 3, 'Privacy_Policy', '', '<div class=\"container\">\r\n<h1>&nbsp;</h1>\r\n<!-- <h1>Privacy Policy</h1> -->\r\n\r\n<p>Effective date: November 06, 2018</p>\r\n\r\n<p>Influencer (&quot;us&quot;, &quot;we&quot;, or &quot;our&quot;) operates the Influencer.digimonk.net website (the &quot;Service&quot;).</p>\r\n\r\n<p>This page informs you of our policies regarding the collection, use, and disclosure of personal data when you use our Service and the choices you have associated with that data.</p>\r\n\r\n<p>We use your data to provide and improve the Service. By using the Service, you agree to the collection and use of information in accordance with this policy. Unless otherwise defined in this Privacy Policy, terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, accessible from Influencer.digimonk.net</p>\r\n\r\n<h2>Information Collection And Use</h2>\r\n\r\n<p>We collect several different types of information for various purposes to provide and improve our Service to you.</p>\r\n\r\n<h3>Types of Data Collected</h3>\r\n\r\n<h4>Personal Data</h4>\r\n\r\n<p>While using our Service, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you (&quot;Personal Data&quot;). Personally identifiable information may include, but is not limited to:</p>\r\n\r\n<ul>\r\n	<li>Email address</li>\r\n	<li>First name and last name</li>\r\n	<li>Phone number</li>\r\n	<li>Address, State, Province, ZIP/Postal code, City</li>\r\n	<li>Cookies and Usage Data</li>\r\n</ul>\r\n\r\n<h4>Usage Data</h4>\r\n\r\n<p>We may also collect information how the Service is accessed and used (&quot;Usage Data&quot;). This Usage Data may include information such as your computer&#39;s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that you visit, the time and date of your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</p>\r\n\r\n<h4>Tracking &amp; Cookies Data</h4>\r\n\r\n<p>We use cookies and similar tracking technologies to track the activity on our Service and hold certain information.</p>\r\n\r\n<p>Cookies are files with small amount of data which may include an anonymous unique identifier. Cookies are sent to your browser from a website and stored on your device. Tracking technologies also used are beacons, tags, and scripts to collect and track information and to improve and analyze our Service.</p>\r\n\r\n<p>You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Service.</p>\r\n\r\n<p>Examples of Cookies we use:</p>\r\n\r\n<ul>\r\n	<li><strong>Session Cookies.</strong> We use Session Cookies to operate our Service.</li>\r\n	<li><strong>Preference Cookies.</strong> We use Preference Cookies to remember your preferences and various settings.</li>\r\n	<li><strong>Security Cookies.</strong> We use Security Cookies for security purposes.</li>\r\n</ul>\r\n\r\n<h2>Use of Data</h2>\r\n\r\n<p>Influencer uses the collected data for various purposes:</p>\r\n\r\n<ul>\r\n	<li>To provide and maintain the Service</li>\r\n	<li>To notify you about changes to our Service</li>\r\n	<li>To allow you to participate in interactive features of our Service when you choose to do so</li>\r\n	<li>To provide customer care and support</li>\r\n	<li>To provide analysis or valuable information so that we can improve the Service</li>\r\n	<li>To monitor the usage of the Service</li>\r\n	<li>To detect, prevent and address technical issues</li>\r\n</ul>\r\n\r\n<h2>Transfer Of Data</h2>\r\n\r\n<p>Your information, including Personal Data, may be transferred to &mdash; and maintained on &mdash; computers located outside of your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from your jurisdiction.</p>\r\n\r\n<p>If you are located outside United States and choose to provide information to us, please note that we transfer the data, including Personal Data, to United States and process it there.</p>\r\n\r\n<p>Your consent to this Privacy Policy followed by your submission of such information represents your agreement to that transfer.</p>\r\n\r\n<p>Influencer will take all steps reasonably necessary to ensure that your data is treated securely and in accordance with this Privacy Policy and no transfer of your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of your data and other personal information.</p>\r\n\r\n<h2>Disclosure Of Data</h2>\r\n\r\n<h3>Legal Requirements</h3>\r\n\r\n<p>Influencer may disclose your Personal Data in the good faith belief that such action is necessary to:</p>\r\n\r\n<ul>\r\n	<li>To comply with a legal obligation</li>\r\n	<li>To protect and defend the rights or property of Influencer</li>\r\n	<li>To prevent or investigate possible wrongdoing in connection with the Service</li>\r\n	<li>To protect the personal safety of users of the Service or the public</li>\r\n	<li>To protect against legal liability</li>\r\n</ul>\r\n\r\n<h2>Security Of Data</h2>\r\n\r\n<p>The security of your data is important to us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your Personal Data, we cannot guarantee its absolute security.</p>\r\n\r\n<h2>Service Providers</h2>\r\n\r\n<p>We may employ third party companies and individuals to facilitate our Service (&quot;Service Providers&quot;), to provide the Service on our behalf, to perform Service-related services or to assist us in analyzing how our Service is used.</p>\r\n\r\n<p>These third parties have access to your Personal Data only to perform these tasks on our behalf and are obligated not to disclose or use it for any other purpose.</p>\r\n\r\n<h2>Links To Other Sites</h2>\r\n\r\n<p>Our Service may contain links to other sites that are not operated by us. If you click on a third party link, you will be directed to that third party&#39;s site. We strongly advise you to review the Privacy Policy of every site you visit.</p>\r\n\r\n<p>We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</p>\r\n\r\n<h2>Children&#39;s Privacy</h2>\r\n\r\n<p>Our Service does not address anyone under the age of 18 (&quot;Children&quot;).</p>\r\n\r\n<p>We do not knowingly collect personally identifiable information from anyone under the age of 18. If you are a parent or guardian and you are aware that your Children has provided us with Personal Data, please contact us. If we become aware that we have collected Personal Data from children without verification of parental consent, we take steps to remove that information from our servers.</p>\r\n\r\n<h2>Changes To This Privacy Policy</h2>\r\n\r\n<p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page.</p>\r\n\r\n<p>We will let you know via email and/or a prominent notice on our Service, prior to the change becoming effective and update the &quot;effective date&quot; at the top of this Privacy Policy.</p>\r\n\r\n<p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>\r\n\r\n<h2>Contact Us</h2>\r\n\r\n<p>If you have any questions about this Privacy Policy, please contact us:</p>\r\n\r\n<ul>\r\n	<li>&nbsp;</li>\r\n</ul>\r\n</div>\r\n', '', '', '', 1, '2018-10-24 08:05:20'),
(18, 3, 'Sitemap', '', '', '', '', '', 0, '2018-10-24 08:07:52'),
(19, 3, 'Cookie_Policy', '', '', '', '', '', 0, '2018-10-24 08:08:04'),
(20, 4, 'About_Us', '', '<div class=\"parallax well-1\" style=\"background-size:cover; background:url(http://work.digimonk.net/assets/images/parallax01.jpg)\">\r\n<div class=\"animated container fadeInUp text-center wow\" style=\"animation-name:fadeInUp; visibility:visible\">\r\n<div class=\"row\">\r\n<div class=\"col-md-10 col-md-offset-1\">\r\n<h1>We provide advice when your business needs it, not just when you ask for it!</h1>\r\n\r\n<h5>Learn the skills you&#39;ll need to promote and run a successful<br />\r\nbusiness.</h5>\r\n<a class=\"btn btn-primary\" href=\"#\">read more</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-6\">\r\n<div class=\"box-inset-1\">\r\n<h2>Welcome to our Site!</h2>\r\n\r\n<div class=\"line-inset-1\">\r\n<p>We are the unique set-up, that is ready to challenge and knock out such a global problem as unemployment. Our company gladly helps those, who are ready to learn, to develop and to gain new experience.</p>\r\n<a class=\"link\" href=\"#\">More</a></div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-md-6\">\r\n<p><img alt=\"an image of how freelancer economy works\" class=\"overviewPage-intro-img\" src=\"http://work.digimonk.net/assets/images/jobsearch-tailored.png\" /></p>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"container-fluid secondary-content secondary-grey\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"box-inset-1 col-md-5 col-md-offset-1 col-md-push-6 col-xs-12 row-content\">\r\n<div class=\"row-header\">Discover local jobs</div>\r\n\r\n<div class=\"row-body\">Learn about and find jobs in each city&#39;s most popular industries, top companies and job types.</div>\r\n<a class=\"btn btn-primary\" href=\"\">Local Jobs</a></div>\r\n\r\n<div class=\"col-md-6 col-md-pull-6 col-xs-12 row-image-wrapper\"><img alt=\"Local Jobs\" class=\"row-image\" src=\"http://work.digimonk.net/assets/images/discover-local-jobs.png\" /></div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"browse-banner container-fluid\" style=\"background:#000000 url(http://work.digimonk.net/assets/images/e4dbf8dbf4d24fc38d5dd504c330dc7e.jpg)\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"browse-panel col-md-3 col-md-offset-0 col-xs-12\"><a href=\"\"><img alt=\"Browse all Jobs\" class=\"row-image\" src=\"http://work.digimonk.net/assets/images/browse-jobs.png\" />Browse all Jobs</a>\r\n\r\n<div class=\"highlight\"><a href=\"\">&gt;</a></div>\r\n</div>\r\n\r\n<div class=\"browse-panel col-md-3 col-xs-12\"><a href=\"\"><img alt=\"Browse all Companies\" class=\"row-image\" src=\"http://work.digimonk.net/assets/images/browse-companies.png\" />Browse all Companies </a>\r\n\r\n<div class=\"highlight\"><a href=\"\">&gt;</a></div>\r\n</div>\r\n\r\n<div class=\"browse-panel col-md-3 col-xs-12\"><a href=\"\"><img alt=\"Browse all Cities\" class=\"row-image\" src=\"http://work.digimonk.net/assets/images/browse-cities.png\" />Browse all Cities </a>\r\n\r\n<div class=\"highlight\"><a href=\"\">&gt;</a></div>\r\n</div>\r\n\r\n<div class=\"browse-panel col-md-3 col-xs-12\"><a href=\"\"><img alt=\"Browse all Salaries\" class=\"row-image\" src=\"http://work.digimonk.net/assets/images/browse-salaries.png\" />Browse all Salaries </a>\r\n\r\n<div class=\"highlight\"><a href=\"\">&gt;</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"container\">\r\n<h1>News</h1>\r\n\r\n<hr />\r\n<div class=\"row\">\r\n<div class=\"col-md-4\">\r\n<div class=\"overviewPage-link-inner\"><a class=\"overviewPage-link-imgWrapper\" href=\"\"> <img alt=\"Press release image of Freelancer CEO\" class=\"overviewPage-link-img\" src=\"http://work.digimonk.net/assets/images/DmFLO5lUwAA4lR3.jpg\" /> </a>\r\n\r\n<h3>Press</h3>\r\n\r\n<p>Find out our press releases under this section</p>\r\n<a class=\"btn-plain btn\" href=\"\">View Press</a></div>\r\n</div>\r\n\r\n<div class=\"col-md-4\">\r\n<div class=\"overviewPage-link-inner\"><a class=\"overviewPage-link-imgWrapper\" href=\"\"> <img alt=\"Press release image of Freelancer CEO\" class=\"overviewPage-link-img\" src=\"http://work.digimonk.net/assets/images/Freelancer.jpg\" /> </a>\r\n\r\n<h3>Press</h3>\r\n\r\n<p>Find out our press releases under this section</p>\r\n<a class=\"btn-plain btn\" href=\"\">View Press</a></div>\r\n</div>\r\n\r\n<div class=\"col-md-4\">\r\n<div class=\"overviewPage-link-inner\"><a class=\"overviewPage-link-imgWrapper\" href=\"\"> <img alt=\"Press release image of Freelancer CEO\" class=\"overviewPage-link-img\" src=\"http://work.digimonk.net/assets/images/How-to-Become-a-Successful-Pakistani-Freelancer.jpg\" /> </a>\r\n\r\n<h3>Press</h3>\r\n\r\n<p>Find out our press releases under this section</p>\r\n<a class=\"btn-plain btn\" href=\"\">View Press</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n', '', '', '', 0, '2018-10-24 08:08:12'),
(21, 4, 'Contact_Us', '', '', '', '', '', 0, '2018-10-24 08:08:18'),
(22, 4, 'Blog', '', '<div style=\"background:#f0f0f0; padding:24px 0\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-8\">\r\n<div class=\"row\">\r\n<div class=\"col-md-6\">\r\n<div class=\"Card PageDashboard-card WidgetUserDetails\">\r\n<div class=\"blog_page_img\" style=\"background:url(http://refundrally.com/images/blog.jpg)\">&nbsp;</div>\r\n\r\n<div class=\"blog_page_content\">\r\n<div class=\"date_block\">\r\n<p>Date: 17 June 2018</p>\r\n</div>\r\n<a href=\"\" style=\"font-size: 20px; color: #000;\">demo 2</a>\r\n\r\n<p>&nbsp;<strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem... <a class=\"blog_btn\" href=\"\">Read More</a></p>\r\n\r\n<div class=\"clearfix\">&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-md-6\">\r\n<div class=\"Card PageDashboard-card WidgetUserDetails\">\r\n<div class=\"blog_page_img\" style=\"background:url(http://refundrally.com/images/blog.jpg)\">&nbsp;</div>\r\n\r\n<div class=\"blog_page_content\">\r\n<div class=\"date_block\">\r\n<p>Date: 17 June 2018</p>\r\n</div>\r\n<a href=\"\" style=\"font-size: 20px; color: #000;\">demo 2</a>\r\n\r\n<p>&nbsp;<strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem... <a class=\"blog_btn\" href=\"\">Read More</a></p>\r\n\r\n<div class=\"clearfix\">&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-md-6\">\r\n<div class=\"Card PageDashboard-card WidgetUserDetails\">\r\n<div class=\"blog_page_img\" style=\"background:url(http://refundrally.com/images/blog.jpg)\">&nbsp;</div>\r\n\r\n<div class=\"blog_page_content\">\r\n<div class=\"date_block\">\r\n<p>Date: 17 June 2018</p>\r\n</div>\r\n<a href=\"\" style=\"font-size: 20px; color: #000;\">demo 2</a>\r\n\r\n<p>&nbsp;<strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem... <a class=\"blog_btn\" href=\"\">Read More</a></p>\r\n\r\n<div class=\"clearfix\">&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-md-6\">\r\n<div class=\"Card PageDashboard-card WidgetUserDetails\">\r\n<div class=\"blog_page_img\" style=\"background:url(http://refundrally.com/images/blog.jpg)\">&nbsp;</div>\r\n\r\n<div class=\"blog_page_content\">\r\n<div class=\"date_block\">\r\n<p>Date: 17 June 2018</p>\r\n</div>\r\n<a href=\"\" style=\"font-size: 20px; color: #000;\">demo 2</a>\r\n\r\n<p>&nbsp;<strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem... <a class=\"blog_btn\" href=\"\">Read More</a></p>\r\n\r\n<div class=\"clearfix\">&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col-md-4\">\r\n<div class=\"seach_box_blog\"><!--<input type=\"text\" name=\"\" placeholder=\"Search here\"><button><i class=\"fa fa-search\"></i></button>-->\r\n<form action=\"\" method=\"GET\"><input name=\"search\" type=\"text\" />&nbsp;</form>\r\n</div>\r\n\r\n<div id=\"user-details\">\r\n<div class=\"Card PageDashboard-card WidgetUserDetails\">\r\n<div class=\"row\">\r\n<div class=\"col-sm-4\"><a class=\"blog-sidebar-link\" href=\"view_blog.php?blog_id=1\" target=\"_blank\"><img class=\"food_blog img-responsive\" src=\"http://refundrally.com/images/blog.jpg\" /> </a></div>\r\n\r\n<div class=\"col-sm-8\">\r\n<div class=\"wt-blog__post-summary wt-blog__post-summary--has-topic wt-blog__post-summary--no-img wt-blog__post-summary--text\">\r\n<div class=\"wt-blog__post-summary__content\">\r\n<h3><a class=\"blog-sidebar-link\" href=\"view_blog.php?blog_id=1\" target=\"_blank\">Lorem Ipsum est simplement du faux texte employ&eacute; dans la</a></h3>\r\n\r\n<div class=\"wt-blog__post-summary__meta\"><a class=\"blog-sidebar-link\" href=\"\"> 30 Oct 2018</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"Card PageDashboard-card WidgetUserDetails\">\r\n<div class=\"row\">\r\n<div class=\"col-sm-4\"><a class=\"blog-sidebar-link\" href=\"view_blog.php?blog_id=1\" target=\"_blank\"><img class=\"food_blog img-responsive\" src=\"http://refundrally.com/images/blog.jpg\" /> </a></div>\r\n\r\n<div class=\"col-sm-8\">\r\n<div class=\"wt-blog__post-summary wt-blog__post-summary--has-topic wt-blog__post-summary--no-img wt-blog__post-summary--text\">\r\n<div class=\"wt-blog__post-summary__content\">\r\n<h3><a class=\"blog-sidebar-link\" href=\"view_blog.php?blog_id=1\" target=\"_blank\">Lorem Ipsum est simplement du faux texte employ&eacute; dans la</a></h3>\r\n\r\n<div class=\"wt-blog__post-summary__meta\"><a class=\"blog-sidebar-link\" href=\"\"> 30 Oct 2018</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"Card PageDashboard-card WidgetUserDetails\">\r\n<div class=\"row\">\r\n<div class=\"col-sm-4\"><a class=\"blog-sidebar-link\" href=\"view_blog.php?blog_id=1\" target=\"_blank\"><img class=\"food_blog img-responsive\" src=\"http://refundrally.com/images/blog.jpg\" /> </a></div>\r\n\r\n<div class=\"col-sm-8\">\r\n<div class=\"wt-blog__post-summary wt-blog__post-summary--has-topic wt-blog__post-summary--no-img wt-blog__post-summary--text\">\r\n<div class=\"wt-blog__post-summary__content\">\r\n<h3><a class=\"blog-sidebar-link\" href=\"view_blog.php?blog_id=1\" target=\"_blank\">Lorem Ipsum est simplement du faux texte employ&eacute; dans la</a></h3>\r\n\r\n<div class=\"wt-blog__post-summary__meta\"><a class=\"blog-sidebar-link\" href=\"\"> 30 Oct 2018</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div id=\"user-details\">\r\n<div class=\"Card PageDashboard-card WidgetUserDetails\">\r\n<div class=\"WidgetUserDetails-info\">\r\n<div class=\"blog_category\">\r\n<div class=\"category_blog_nr recent_blogs\">\r\n<h3>Categories</h3>\r\n\r\n<ul>\r\n	<li><a href=\"\"> </a>\r\n\r\n	<h4><a href=\"\">demo 1 05</a></h4>\r\n	<a href=\"\"> </a></li>\r\n	<li><a href=\"\"> </a>\r\n	<h4><a href=\"\">demo 2 05</a></h4>\r\n	<a href=\"\"> </a></li>\r\n	<li><a href=\"\"> </a>\r\n	<h4><a href=\"\">demo 3 05</a></h4>\r\n	<a href=\"\"> </a></li>\r\n	<li><a href=\"\"> </a>\r\n	<h4><a href=\"\">help center 05</a></h4>\r\n	<a href=\"\"> </a></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '', '', '', 0, '2018-10-24 08:08:25'),
(23, 4, 'FAQs', '', '<div style=\"background:#f0f0f0; padding:24px 0\">\r\n<div class=\"container\">\r\n<div class=\"row search\">\r\n<div class=\"col-md-6 col-md-offset-3\">\r\n<div class=\"\'Roboto\', 47px; 70, 90); 91px;font-size: center; font-family: font-weight: lighter; line-height: rgb(55, row sans-serif;color: text-align: text-center\" id=\"search-heading\">\r\n<p style=\"text-align:center\"><span style=\"font-size:28px\">How can we help you?</span></p>\r\n\r\n<p style=\"text-align:center\">&nbsp;</p>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"row\">\r\n<div class=\"container help_center_wrapper\">\r\n<div class=\"container help_center_wrapper\">\r\n<p>Not able to find your Answer ? click <a href=\"#contactModal\">Here</a> for support</p>\r\n</div>\r\n\r\n<div class=\"col-md-4 help_center_inner text-center\">\r\n<h2>&nbsp;</h2>\r\n\r\n<h3>Getting Started</h3>\r\n</div>\r\n\r\n<div class=\"col-md-4 help_center_inner text-center\">\r\n<h2>&nbsp;</h2>\r\n\r\n<h3>Knowledge</h3>\r\n</div>\r\n\r\n<div class=\"col-md-4 help_center_inner text-center\">\r\n<h2>&nbsp;</h2>\r\n\r\n<h3>Developer Community</h3>\r\n</div>\r\n\r\n<div class=\"col-md-4 help_center_inner text-center\">\r\n<h2>&nbsp;</h2>\r\n\r\n<h3>Developer Community</h3>\r\n</div>\r\n\r\n<div class=\"col-md-4 help_center_inner text-center\">\r\n<h2>&nbsp;</h2>\r\n\r\n<h3>FAQ</h3>\r\n</div>\r\n\r\n<div class=\"col-md-4 help_center_inner text-center\">\r\n<h2>&nbsp;</h2>\r\n\r\n<h3>Contact</h3>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '', '', '', 0, '2018-10-24 08:08:32'),
(24, 5, 'For_Business', '', '<div class=\"container\">\r\n<div class=\"row\">\r\n<p style=\"text-align:center\"><span style=\"font-size:48px\">How to find your influencer</span></p>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:18px\">Save time and get a higher return on your investment by easily<br />\r\nfinding the right Buyer of your idea.</span></p>\r\n\r\n<hr /></div>\r\n\r\n<div class=\"row\">\r\n<div class=\"col-md-6\">\r\n<h3><span style=\"font-size:24px\"><strong>Creating Your Business Profile</strong></span></h3>\r\n\r\n<p><span style=\"font-size:18px\">First, you will need to create your business profile. Your profile is how you present yourself to the community. You are encouraged to present yourself in a professional manner.</span></p>\r\n\r\n<p><span style=\"font-size:18px\">1. First create your account as a business</span></p>\r\n<span style=\"font-size:18px\"><em>For more information, see: <a href=\"http://work.digimonk.net/signup\">Creating Your influencer Profile</a></em></span></div>\r\n\r\n<div class=\"col-md-6\"><iframe frameborder=\"0\" height=\"390\" src=\"https://www.youtube.com/embed/koJlF6YDqqA\" width=\"100%\"></iframe></div>\r\n</div>\r\n\r\n<div class=\"row\" style=\"padding:20px 0\">\r\n<div class=\"col-md-6\"><iframe frameborder=\"0\" height=\"390\" src=\"https://www.youtube.com/embed/9wecCt9udBU\" width=\"100%\"></iframe></div>\r\n\r\n<div class=\"col-md-6\">\r\n<h3><span style=\"font-size:24px\"><strong>Find your influencer</strong></span></h3>\r\n\r\n<p><span style=\"font-size:18px\">Use influencer search and side filters, to find the right influencer for your project. Once you&#39;ve found a service you&#39;d like to order, click the package. Choosing the right influencer is easy:</span></p>\r\n<span style=\"font-size:18px\"><em>For more information, see: <a href=\"http://work.digimonk.net/contact\">contact us</a></em></span></div>\r\n</div>\r\n</div>\r\n', '', '', '', 1, '2018-10-24 08:08:45'),
(25, 5, 'For_Influencers_', '', '<div class=\"container\">\r\n<div class=\"row\">\r\n<p style=\"text-align:center\"><span style=\"font-size:48px\">How to start selling with us</span></p>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:18px\">Save time and get a higher return on your investment by easily<br />\r\nfinding the right Buyer of your idea.</span></p>\r\n\r\n<hr /></div>\r\n\r\n<div class=\"row\">\r\n<div class=\"col-md-6\">\r\n<h3><strong><span style=\"font-size:24px\">Creating Your Influencer Profile</span></strong></h3>\r\n\r\n<p><span style=\"font-size:18px\">First, you will need to create your Influencer profile. Your profile is how you present yourself to the community. You are encouraged to present yourself in a professional manner.</span></p>\r\n\r\n<p><span style=\"font-size:18px\">1. First create your account as a influencer</span></p>\r\n<span style=\"font-size:18px\"><em>For more information, see: <a href=\"http://work.digimonk.net/signup\">Creating Your influencer Profile</a></em></span></div>\r\n\r\n<div class=\"col-md-6\"><iframe frameborder=\"0\" height=\"390\" src=\"https://www.youtube.com/embed/koJlF6YDqqA\" width=\"100%\"></iframe></div>\r\n</div>\r\n\r\n<div class=\"row\" style=\"padding:20px 0\">\r\n<div class=\"col-md-6\"><iframe frameborder=\"0\" height=\"390\" src=\"https://www.youtube.com/embed/gdpZCTiyDPo\" width=\"100%\"></iframe></div>\r\n\r\n<div class=\"col-md-6\">\r\n<h3><strong><span style=\"font-size:24px\">Create your package</span></strong></h3>\r\n\r\n<p><span style=\"font-size:18px\">Your package is the service that you sell on Influencer. Creating your Package is an opportunity to show off your talent and provide buyers with all the information they need to help them decide to do business with you.</span></p>\r\n\r\n<p><span style=\"font-size:18px\">1. Fisrt create your account</span></p>\r\n\r\n<p><span style=\"font-size:18px\">2.Go to my package</span></p>\r\n\r\n<p><span style=\"font-size:18px\">3.Click add new package</span></p>\r\n\r\n<p><span style=\"font-size:18px\">4.Create new package</span></p>\r\n<span style=\"font-size:18px\"><em>For more information, see: <a href=\"http://work.digimonk.net/sell-service\">Creating Your package</a></em></span></div>\r\n</div>\r\n</div>\r\n', '', '', '', 1, '2018-10-24 08:09:18'),
(26, 5, 'Careers', '', '', '', '', '', 0, '2018-10-24 08:09:29'),
(27, 6, 'Create_an_account', '', '', '', '', '', 0, '2018-10-24 08:09:39'),
(28, 6, 'Login', '', '', '', '', '', 0, '2018-10-24 08:09:47');

-- --------------------------------------------------------

--
-- Table structure for table `gigs_image`
--

CREATE TABLE `gigs_image` (
  `id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `gig_image_thumb` varchar(500) NOT NULL,
  `gig_image_tile` varchar(500) NOT NULL,
  `gig_image_medium` varchar(500) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gigs_image`
--

INSERT INTO `gigs_image` (`id`, `gig_id`, `image_path`, `gig_image_thumb`, `gig_image_tile`, `gig_image_medium`, `created_date`) VALUES
(3, 2, 'uploads/gig_images/680_460_gig_1538200361.png', 'uploads/gig_images/50_34_gig_1538200361.png', 'uploads/gig_images/100_68_gig_1538200361.png', 'uploads/gig_images/240_162_gig_1538200361.png', '2018-09-29 06:00:39'),
(4, 2, 'uploads/gig_images/680_460_gig_1538200684.png', 'uploads/gig_images/50_34_gig_1538200684.png', 'uploads/gig_images/100_68_gig_1538200684.png', 'uploads/gig_images/240_162_gig_1538200684.png', '2018-09-29 06:00:39'),
(5, 2, 'uploads/gig_images/680_460_gig_1538200695.png', 'uploads/gig_images/50_34_gig_1538200695.png', 'uploads/gig_images/100_68_gig_1538200695.png', 'uploads/gig_images/240_162_gig_1538200695.png', '2018-09-29 06:00:39'),
(6, 1, 'uploads/gig_images/680_460_gig_1538210567.png', 'uploads/gig_images/50_34_gig_1538210567.png', 'uploads/gig_images/100_68_gig_1538210567.png', 'uploads/gig_images/240_162_gig_1538210567.png', '2018-09-29 08:47:39'),
(7, 3, 'uploads/gig_images/680_460_gig_1538213134.png', 'uploads/gig_images/50_34_gig_1538213134.png', 'uploads/gig_images/100_68_gig_1538213134.png', 'uploads/gig_images/240_162_gig_1538213134.png', '2018-09-29 09:28:20'),
(8, 4, 'uploads/gig_images/680_460_gig_1538213996.png', 'uploads/gig_images/50_34_gig_1538213996.png', 'uploads/gig_images/100_68_gig_1538213996.png', 'uploads/gig_images/240_162_gig_1538213996.png', '2018-09-29 09:41:49'),
(9, 5, 'uploads/gig_images/680_460_gig_1538218623.png', 'uploads/gig_images/50_34_gig_1538218623.png', 'uploads/gig_images/100_68_gig_1538218623.png', 'uploads/gig_images/240_162_gig_1538218623.png', '2018-09-29 10:59:58'),
(10, 6, 'uploads/gig_images/680_460_gig_1538221366.png', 'uploads/gig_images/50_34_gig_1538221366.png', 'uploads/gig_images/100_68_gig_1538221366.png', 'uploads/gig_images/240_162_gig_1538221366.png', '2018-09-29 11:44:40'),
(11, 7, 'uploads/gig_images/680_460_gig_1538221797.png', 'uploads/gig_images/50_34_gig_1538221797.png', 'uploads/gig_images/100_68_gig_1538221797.png', 'uploads/gig_images/240_162_gig_1538221797.png', '2018-09-29 11:55:13'),
(12, 8, 'uploads/gig_images/680_460_gig_1538222591.png', 'uploads/gig_images/50_34_gig_1538222591.png', 'uploads/gig_images/100_68_gig_1538222591.png', 'uploads/gig_images/240_162_gig_1538222591.png', '2018-09-29 12:05:45'),
(13, 9, 'uploads/gig_images/680_460_gig_1538222996.png', 'uploads/gig_images/50_34_gig_1538222996.png', 'uploads/gig_images/100_68_gig_1538222996.png', 'uploads/gig_images/240_162_gig_1538222996.png', '2018-09-29 12:11:52'),
(14, 10, 'uploads/gig_images/680_460_gig_1538223424.png', 'uploads/gig_images/50_34_gig_1538223424.png', 'uploads/gig_images/100_68_gig_1538223424.png', 'uploads/gig_images/240_162_gig_1538223424.png', '2018-09-29 12:19:40'),
(15, 11, 'uploads/gig_images/680_460_gig_1538224579.png', 'uploads/gig_images/50_34_gig_1538224579.png', 'uploads/gig_images/100_68_gig_1538224579.png', 'uploads/gig_images/240_162_gig_1538224579.png', '2018-09-29 12:40:25'),
(16, 12, 'uploads/gig_images/680_460_gig_1538225139.png', 'uploads/gig_images/50_34_gig_1538225139.png', 'uploads/gig_images/100_68_gig_1538225139.png', 'uploads/gig_images/240_162_gig_1538225139.png', '2018-09-29 12:48:58'),
(17, 13, 'uploads/gig_images/680_460_gig_1538225754.png', 'uploads/gig_images/50_34_gig_1538225754.png', 'uploads/gig_images/100_68_gig_1538225754.png', 'uploads/gig_images/240_162_gig_1538225754.png', '2018-09-29 12:58:39'),
(18, 14, 'uploads/gig_images/680_460_gig_1538226167.png', 'uploads/gig_images/50_34_gig_1538226167.png', 'uploads/gig_images/100_68_gig_1538226167.png', 'uploads/gig_images/240_162_gig_1538226167.png', '2018-09-29 13:04:50'),
(19, 15, 'uploads/gig_images/680_460_gig_1538226585.png', 'uploads/gig_images/50_34_gig_1538226585.png', 'uploads/gig_images/100_68_gig_1538226585.png', 'uploads/gig_images/240_162_gig_1538226585.png', '2018-09-29 13:11:55'),
(20, 16, 'uploads/gig_images/680_460_gig_1538226950.png', 'uploads/gig_images/50_34_gig_1538226950.png', 'uploads/gig_images/100_68_gig_1538226950.png', 'uploads/gig_images/240_162_gig_1538226950.png', '2018-09-29 13:17:37'),
(21, 17, 'uploads/gig_images/680_460_gig_1538227222.png', 'uploads/gig_images/50_34_gig_1538227222.png', 'uploads/gig_images/100_68_gig_1538227222.png', 'uploads/gig_images/240_162_gig_1538227222.png', '2018-09-29 13:23:41'),
(22, 18, 'uploads/gig_images/680_460_gig_1538230831.png', 'uploads/gig_images/50_34_gig_1538230831.png', 'uploads/gig_images/100_68_gig_1538230831.png', 'uploads/gig_images/240_162_gig_1538230831.png', '2018-09-29 14:22:13'),
(23, 19, 'uploads/gig_images/680_460_gig_1540467565.png', 'uploads/gig_images/50_34_gig_1540467565.png', 'uploads/gig_images/100_68_gig_1540467565.png', 'uploads/gig_images/240_162_gig_1540467565.png', '2018-10-25 11:39:48'),
(24, 20, 'uploads/gig_images/680_460_gig_1540538560.png', 'uploads/gig_images/50_34_gig_1540538560.png', 'uploads/gig_images/100_68_gig_1540538560.png', 'uploads/gig_images/240_162_gig_1540538560.png', '2018-10-26 07:24:22'),
(25, 21, 'uploads/gig_images/680_460_gig_1540560830.png', 'uploads/gig_images/50_34_gig_1540560830.png', 'uploads/gig_images/100_68_gig_1540560830.png', 'uploads/gig_images/240_162_gig_1540560830.png', '2018-10-26 13:37:58'),
(26, 22, 'uploads/gig_images/680_460_gig_1540629305.png', 'uploads/gig_images/50_34_gig_1540629305.png', 'uploads/gig_images/100_68_gig_1540629305.png', 'uploads/gig_images/240_162_gig_1540629305.png', '2018-10-27 08:37:25'),
(27, 22, 'uploads/gig_images/680_460_gig_1540629313.png', 'uploads/gig_images/50_34_gig_1540629313.png', 'uploads/gig_images/100_68_gig_1540629313.png', 'uploads/gig_images/240_162_gig_1540629313.png', '2018-10-27 08:37:25'),
(28, 22, 'uploads/gig_images/680_460_gig_1540629321.png', 'uploads/gig_images/50_34_gig_1540629321.png', 'uploads/gig_images/100_68_gig_1540629321.png', 'uploads/gig_images/240_162_gig_1540629321.png', '2018-10-27 08:37:25'),
(29, 23, 'uploads/gig_images/680_460_gig_1540712369.png', 'uploads/gig_images/50_34_gig_1540712369.png', 'uploads/gig_images/100_68_gig_1540712369.png', 'uploads/gig_images/240_162_gig_1540712369.png', '2018-10-28 07:40:13'),
(30, 24, 'uploads/gig_images/680_460_gig_1540714233.png', 'uploads/gig_images/50_34_gig_1540714233.png', 'uploads/gig_images/100_68_gig_1540714233.png', 'uploads/gig_images/240_162_gig_1540714233.png', '2018-10-28 08:11:19'),
(31, 25, 'uploads/gig_images/680_460_gig_1540740003.png', 'uploads/gig_images/50_34_gig_1540740003.png', 'uploads/gig_images/100_68_gig_1540740003.png', 'uploads/gig_images/240_162_gig_1540740003.png', '2018-10-28 15:21:51'),
(32, 26, 'uploads/gig_images/680_460_gig_1540791518.png', 'uploads/gig_images/50_34_gig_1540791518.png', 'uploads/gig_images/100_68_gig_1540791518.png', 'uploads/gig_images/240_162_gig_1540791518.png', '2018-10-29 05:39:58'),
(33, 27, 'uploads/gig_images/680_460_gig_1540800221.png', 'uploads/gig_images/50_34_gig_1540800221.png', 'uploads/gig_images/100_68_gig_1540800221.png', 'uploads/gig_images/240_162_gig_1540800221.png', '2018-10-29 08:04:00'),
(34, 28, 'uploads/gig_images/680_460_gig_1540805491.png', 'uploads/gig_images/50_34_gig_1540805491.png', 'uploads/gig_images/100_68_gig_1540805491.png', 'uploads/gig_images/240_162_gig_1540805491.png', '2018-10-29 09:31:49'),
(35, 29, 'uploads/gig_images/680_460_gig_1540811788.png', 'uploads/gig_images/50_34_gig_1540811788.png', 'uploads/gig_images/100_68_gig_1540811788.png', 'uploads/gig_images/240_162_gig_1540811788.png', '2018-10-29 11:17:01'),
(36, 30, 'uploads/gig_images/680_460_gig_1540814752.png', 'uploads/gig_images/50_34_gig_1540814752.png', 'uploads/gig_images/100_68_gig_1540814752.png', 'uploads/gig_images/240_162_gig_1540814752.png', '2018-10-29 12:07:31'),
(37, 31, 'uploads/gig_images/680_460_gig_1540817240.png', 'uploads/gig_images/50_34_gig_1540817240.png', 'uploads/gig_images/100_68_gig_1540817240.png', 'uploads/gig_images/240_162_gig_1540817240.png', '2018-10-29 12:48:58'),
(38, 32, 'uploads/gig_images/680_460_gig_1540818750.png', 'uploads/gig_images/50_34_gig_1540818750.png', 'uploads/gig_images/100_68_gig_1540818750.png', 'uploads/gig_images/240_162_gig_1540818750.png', '2018-10-29 13:16:21'),
(39, 33, 'uploads/gig_images/680_460_gig_1540819225.png', 'uploads/gig_images/50_34_gig_1540819225.png', 'uploads/gig_images/100_68_gig_1540819225.png', 'uploads/gig_images/240_162_gig_1540819225.png', '2018-10-29 13:21:57'),
(40, 34, 'uploads/gig_images/680_460_gig_1540822615.png', 'uploads/gig_images/50_34_gig_1540822615.png', 'uploads/gig_images/100_68_gig_1540822615.png', 'uploads/gig_images/240_162_gig_1540822615.png', '2018-10-29 14:19:44'),
(41, 35, 'uploads/gig_images/680_460_gig_1540828419.png', 'uploads/gig_images/50_34_gig_1540828419.png', 'uploads/gig_images/100_68_gig_1540828419.png', 'uploads/gig_images/240_162_gig_1540828419.png', '2018-10-29 15:54:17'),
(42, 36, 'uploads/gig_images/680_460_gig_1540835495.png', 'uploads/gig_images/50_34_gig_1540835495.png', 'uploads/gig_images/100_68_gig_1540835495.png', 'uploads/gig_images/240_162_gig_1540835495.png', '2018-10-29 17:52:57'),
(43, 37, 'uploads/gig_images/680_460_gig_1540835798.png', 'uploads/gig_images/50_34_gig_1540835798.png', 'uploads/gig_images/100_68_gig_1540835798.png', 'uploads/gig_images/240_162_gig_1540835798.png', '2018-10-29 17:58:08'),
(44, 38, 'uploads/gig_images/680_460_gig_1540914930.png', 'uploads/gig_images/50_34_gig_1540914930.png', 'uploads/gig_images/100_68_gig_1540914930.png', 'uploads/gig_images/240_162_gig_1540914930.png', '2018-10-30 15:56:30'),
(45, 39, 'uploads/gig_images/680_460_gig_1540914930.png', 'uploads/gig_images/50_34_gig_1540914930.png', 'uploads/gig_images/100_68_gig_1540914930.png', 'uploads/gig_images/240_162_gig_1540914930.png', '2018-10-30 15:56:31'),
(47, 41, 'uploads/gig_images/680_460_gig_1540969832.png', 'uploads/gig_images/50_34_gig_1540969832.png', 'uploads/gig_images/100_68_gig_1540969832.png', 'uploads/gig_images/240_162_gig_1540969832.png', '2018-10-31 07:11:05'),
(48, 40, 'uploads/gig_images/680_460_gig_1540972629.png', 'uploads/gig_images/50_34_gig_1540972629.png', 'uploads/gig_images/100_68_gig_1540972629.png', 'uploads/gig_images/240_162_gig_1540972629.png', '2018-10-31 07:57:44'),
(49, 42, 'uploads/gig_images/680_460_gig_1540982065.png', 'uploads/gig_images/50_34_gig_1540982065.png', 'uploads/gig_images/100_68_gig_1540982065.png', 'uploads/gig_images/240_162_gig_1540982065.png', '2018-10-31 10:35:34'),
(50, 43, 'uploads/gig_images/680_460_gig_1540989329.png', 'uploads/gig_images/50_34_gig_1540989329.png', 'uploads/gig_images/100_68_gig_1540989329.png', 'uploads/gig_images/240_162_gig_1540989329.png', '2018-10-31 12:35:50'),
(51, 44, 'uploads/gig_images/680_460_gig_1540989444.png', 'uploads/gig_images/50_34_gig_1540989444.png', 'uploads/gig_images/100_68_gig_1540989444.png', 'uploads/gig_images/240_162_gig_1540989444.png', '2018-10-31 12:37:41'),
(52, 45, 'uploads/gig_images/680_460_gig_1540989783.png', 'uploads/gig_images/50_34_gig_1540989783.png', 'uploads/gig_images/100_68_gig_1540989783.png', 'uploads/gig_images/240_162_gig_1540989783.png', '2018-10-31 12:43:23'),
(53, 46, 'uploads/gig_images/680_460_gig_1540989891.png', 'uploads/gig_images/50_34_gig_1540989891.png', 'uploads/gig_images/100_68_gig_1540989891.png', 'uploads/gig_images/240_162_gig_1540989891.png', '2018-10-31 12:45:04'),
(54, 47, 'uploads/gig_images/680_460_gig_1540997040.png', 'uploads/gig_images/50_34_gig_1540997040.png', 'uploads/gig_images/100_68_gig_1540997040.png', 'uploads/gig_images/240_162_gig_1540997040.png', '2018-10-31 14:44:47'),
(55, 48, 'uploads/gig_images/680_460_gig_1540997179.png', 'uploads/gig_images/50_34_gig_1540997179.png', 'uploads/gig_images/100_68_gig_1540997179.png', 'uploads/gig_images/240_162_gig_1540997179.png', '2018-10-31 14:47:40'),
(57, 50, 'uploads/gig_images/680_460_gig_1540998018.png', 'uploads/gig_images/50_34_gig_1540998018.png', 'uploads/gig_images/100_68_gig_1540998018.png', 'uploads/gig_images/240_162_gig_1540998018.png', '2018-10-31 15:00:51'),
(58, 51, 'uploads/gig_images/680_460_gig_1541008141.png', 'uploads/gig_images/50_34_gig_1541008141.png', 'uploads/gig_images/100_68_gig_1541008141.png', 'uploads/gig_images/240_162_gig_1541008141.png', '2018-10-31 17:49:52'),
(59, 52, 'uploads/gig_images/680_460_gig_1541009299.png', 'uploads/gig_images/50_34_gig_1541009299.png', 'uploads/gig_images/100_68_gig_1541009299.png', 'uploads/gig_images/240_162_gig_1541009299.png', '2018-10-31 18:08:53'),
(60, 53, 'uploads/gig_images/680_460_gig_1541010714.png', 'uploads/gig_images/50_34_gig_1541010714.png', 'uploads/gig_images/100_68_gig_1541010714.png', 'uploads/gig_images/240_162_gig_1541010714.png', '2018-10-31 18:41:30'),
(61, 54, 'uploads/gig_images/680_460_gig_1541076870.png', 'uploads/gig_images/50_34_gig_1541076870.png', 'uploads/gig_images/100_68_gig_1541076870.png', 'uploads/gig_images/240_162_gig_1541076870.png', '2018-11-01 12:55:21'),
(62, 55, 'uploads/gig_images/680_460_gig_1541080850.png', 'uploads/gig_images/50_34_gig_1541080850.png', 'uploads/gig_images/100_68_gig_1541080850.png', 'uploads/gig_images/240_162_gig_1541080850.png', '2018-11-01 14:01:39'),
(63, 56, 'uploads/gig_images/680_460_gig_1541147261.png', 'uploads/gig_images/50_34_gig_1541147261.png', 'uploads/gig_images/100_68_gig_1541147261.png', 'uploads/gig_images/240_162_gig_1541147261.png', '2018-11-02 08:28:01'),
(64, 57, 'uploads/gig_images/680_460_gig_1541147335.png', 'uploads/gig_images/50_34_gig_1541147335.png', 'uploads/gig_images/100_68_gig_1541147335.png', 'uploads/gig_images/240_162_gig_1541147335.png', '2018-11-02 08:29:18'),
(65, 58, 'uploads/gig_images/680_460_gig_1541147394.png', 'uploads/gig_images/50_34_gig_1541147394.png', 'uploads/gig_images/100_68_gig_1541147394.png', 'uploads/gig_images/240_162_gig_1541147394.png', '2018-11-02 08:30:09'),
(66, 59, 'uploads/gig_images/680_460_gig_1541150964.png', 'uploads/gig_images/50_34_gig_1541150964.png', 'uploads/gig_images/100_68_gig_1541150964.png', 'uploads/gig_images/240_162_gig_1541150964.png', '2018-11-02 09:30:13'),
(67, 59, 'uploads/gig_images/680_460_gig_1541150985.png', 'uploads/gig_images/50_34_gig_1541150985.png', 'uploads/gig_images/100_68_gig_1541150985.png', 'uploads/gig_images/240_162_gig_1541150985.png', '2018-11-02 09:30:13'),
(68, 60, 'uploads/gig_images/680_460_gig_1541161527.png', 'uploads/gig_images/50_34_gig_1541161527.png', 'uploads/gig_images/100_68_gig_1541161527.png', 'uploads/gig_images/240_162_gig_1541161527.png', '2018-11-02 12:35:57'),
(69, 61, 'uploads/gig_images/680_460_gig_1541163438.png', 'uploads/gig_images/50_34_gig_1541163438.png', 'uploads/gig_images/100_68_gig_1541163438.png', 'uploads/gig_images/240_162_gig_1541163438.png', '2018-11-02 12:58:07'),
(70, 62, 'uploads/gig_images/680_460_gig_1541169051.png', 'uploads/gig_images/50_34_gig_1541169051.png', 'uploads/gig_images/100_68_gig_1541169051.png', 'uploads/gig_images/240_162_gig_1541169051.png', '2018-11-02 14:35:30'),
(71, 63, 'uploads/gig_images/680_460_gig_1541220129.png', 'uploads/gig_images/50_34_gig_1541220129.png', 'uploads/gig_images/100_68_gig_1541220129.png', 'uploads/gig_images/240_162_gig_1541220129.png', '2018-11-03 04:51:51'),
(72, 64, 'uploads/gig_images/680_460_gig_1541223271.png', 'uploads/gig_images/50_34_gig_1541223271.png', 'uploads/gig_images/100_68_gig_1541223271.png', 'uploads/gig_images/240_162_gig_1541223271.png', '2018-11-03 05:36:01'),
(76, 68, 'uploads/gig_images/680_460_gig_1541356767.png', 'uploads/gig_images/50_34_gig_1541356767.png', 'uploads/gig_images/100_68_gig_1541356767.png', 'uploads/gig_images/240_162_gig_1541356767.png', '2018-11-04 18:40:48'),
(77, 69, 'uploads/gig_images/680_460_gig_1541357041.png', 'uploads/gig_images/50_34_gig_1541357041.png', 'uploads/gig_images/100_68_gig_1541357041.png', 'uploads/gig_images/240_162_gig_1541357041.png', '2018-11-04 18:52:54'),
(78, 70, 'uploads/gig_images/680_460_gig_1541357653.png', 'uploads/gig_images/50_34_gig_1541357653.png', 'uploads/gig_images/100_68_gig_1541357653.png', 'uploads/gig_images/240_162_gig_1541357653.png', '2018-11-04 18:54:32'),
(79, 71, 'uploads/gig_images/680_460_gig_1541395001.png', 'uploads/gig_images/50_34_gig_1541395001.png', 'uploads/gig_images/100_68_gig_1541395001.png', 'uploads/gig_images/240_162_gig_1541395001.png', '2018-11-05 05:17:35'),
(83, 75, 'uploads/gig_images/680_460_gig_1542436683.png', 'uploads/gig_images/50_34_gig_1542436683.png', 'uploads/gig_images/100_68_gig_1542436683.png', 'uploads/gig_images/240_162_gig_1542436683.png', '2018-11-17 06:38:24'),
(84, 76, 'uploads/gig_images/680_460_gig_1542438403.png', 'uploads/gig_images/50_34_gig_1542438403.png', 'uploads/gig_images/100_68_gig_1542438403.png', 'uploads/gig_images/240_162_gig_1542438403.png', '2018-11-17 07:07:02'),
(91, 82, 'uploads/gig_images/680_460_gig_1542967978.png', 'uploads/gig_images/50_34_gig_1542967978.png', 'uploads/gig_images/100_68_gig_1542967978.png', 'uploads/gig_images/240_162_gig_1542967978.png', '2018-11-23 10:16:09'),
(92, 83, 'uploads/gig_images/680_460_gig_1542973095.png', 'uploads/gig_images/50_34_gig_1542973095.png', 'uploads/gig_images/100_68_gig_1542973095.png', 'uploads/gig_images/240_162_gig_1542973095.png', '2018-11-23 11:38:58'),
(93, 84, 'uploads/gig_images/680_460_gig_1542981073.png', 'uploads/gig_images/50_34_gig_1542981073.png', 'uploads/gig_images/100_68_gig_1542981073.png', 'uploads/gig_images/240_162_gig_1542981073.png', '2018-11-23 13:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `gigs_video`
--

CREATE TABLE `gigs_video` (
  `id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `video_path` varchar(500) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gigs_video`
--

INSERT INTO `gigs_video` (`id`, `gig_id`, `video_path`, `created_date`) VALUES
(1, 22, 'uploads/gigs_videos/1540629343final_video_123.mp4', '2018-10-27 08:37:25'),
(2, 60, 'uploads/gigs_videos/1541162056Amazon_Great_Indian_Festival_-_Diwali_Special.mp4', '2018-11-02 12:35:57'),
(3, 62, 'uploads/gigs_videos/1541169069Amazon_Great_Indian_Festival_-_Diwali_Special.mp4', '2018-11-02 14:35:30'),
(4, 64, 'uploads/gigs_videos/1541223283Amazon_Great_Indian_Festival_-_Diwali_Special.mp4', '2018-11-03 05:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `help_center_content`
--

CREATE TABLE `help_center_content` (
  `id` bigint(20) NOT NULL,
  `name` varchar(500) NOT NULL,
  `categorys` varchar(500) NOT NULL,
  `page_content` longtext NOT NULL,
  `status` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `help_center_content`
--

INSERT INTO `help_center_content` (`id`, `name`, `categorys`, `page_content`, `status`) VALUES
(1, 'Title 6', '3*#*14', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n', '0'),
(2, 'Title 5', '5*#*2', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n', '0'),
(3, 'Title 4', '1*#*2', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n', '0'),
(4, 'Title 3', '4*#*1', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n', '0'),
(5, 'Title 2', '3*#*4', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n', '0'),
(6, 'Title 1', '5*#*3', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n', '0');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `language` varchar(150) NOT NULL,
  `language_value` char(5) NOT NULL,
  `status` varchar(20) NOT NULL COMMENT '1.active 2.inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `language_management`
--

CREATE TABLE `language_management` (
  `sno` int(11) NOT NULL,
  `lang_key` varchar(100) CHARACTER SET utf8 NOT NULL,
  `lang_value` varchar(100) CHARACTER SET utf8 NOT NULL,
  `language` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `last_visited`
--

CREATE TABLE `last_visited` (
  `id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `last_visited`
--

INSERT INTO `last_visited` (`id`, `gig_id`, `user_id`, `created_date`) VALUES
(1, 1, 1, '2018-09-29 14:07:35'),
(2, 2, 1, '2018-09-29 14:07:07'),
(3, 2, 2, '2018-09-29 14:07:07'),
(4, 3, 2, '2018-10-13 16:14:05'),
(5, 1, 2, '2018-09-29 14:07:35'),
(6, 5, 1, '2018-09-29 14:16:39'),
(7, 17, 1, '2018-10-08 11:53:15'),
(8, 16, 1, '2018-10-08 11:52:12'),
(9, 10, 1, '2018-09-29 13:58:42'),
(10, 15, 1, '2018-09-29 14:15:09'),
(11, 9, 1, '2018-09-29 14:00:58'),
(12, 8, 1, '2018-09-29 14:01:36'),
(13, 7, 1, '2018-09-29 14:05:45'),
(14, 6, 1, '2018-09-29 14:06:36'),
(15, 8, 2, '2018-09-29 14:08:26'),
(16, 14, 2, '2018-10-17 12:57:57'),
(17, 13, 2, '2018-10-17 09:30:52'),
(18, 12, 2, '2018-09-29 14:10:04'),
(19, 11, 2, '2018-09-29 14:10:46'),
(20, 5, 2, '2018-09-29 14:16:39'),
(21, 4, 2, '2018-10-08 11:51:42'),
(22, 16, 2, '2018-10-08 11:52:12'),
(23, 18, 2, '2018-10-23 17:14:34'),
(24, 15, 2, '2018-09-30 19:58:13'),
(25, 10, 2, '2018-09-30 20:01:30'),
(26, 21, 34, '2018-10-27 10:03:01'),
(27, 22, 32, '2018-10-27 09:47:26'),
(28, 23, 36, '2018-10-28 07:41:27'),
(29, 24, 37, '2018-10-28 08:12:19'),
(30, 25, 38, '2018-10-28 15:59:28'),
(31, 25, 39, '2018-10-28 15:59:28'),
(32, 26, 40, '2018-10-29 05:40:46'),
(33, 27, 50, '2018-10-29 08:04:20'),
(34, 28, 52, '2018-10-29 09:38:47'),
(35, 29, 55, '2018-10-29 13:56:10'),
(36, 29, 57, '2018-10-29 13:56:10'),
(37, 31, 54, '2018-10-29 12:55:26'),
(38, 33, 56, '2018-10-29 14:38:52'),
(39, 33, 57, '2018-10-29 14:38:52'),
(40, 34, 58, '2018-11-01 11:43:12'),
(41, 35, 63, '2018-10-29 16:11:01'),
(42, 40, 107, '2018-10-31 12:47:05'),
(43, 49, 107, '2018-11-01 12:21:04'),
(44, 48, 113, '2018-11-01 05:24:39'),
(45, 50, 113, '2018-11-01 05:15:48'),
(46, 51, 65, '2018-10-31 18:12:08'),
(47, 42, 109, '2018-11-01 11:42:39'),
(48, 55, 126, '2018-11-02 07:06:00'),
(49, 59, 129, '2018-11-02 14:07:59'),
(50, 25, 129, '2018-11-02 10:31:34'),
(51, 62, 134, '2018-11-02 14:54:07'),
(52, 62, 135, '2018-11-02 14:54:07'),
(53, 64, 134, '2018-11-10 10:03:16'),
(54, 64, 135, '2018-11-10 10:03:16'),
(55, 66, 139, '2018-11-03 05:45:56'),
(56, 68, 141, '2018-11-09 08:24:43'),
(57, 70, 141, '2018-11-26 18:02:28'),
(58, 69, 141, '2018-11-26 18:17:49'),
(59, 71, 142, '2018-11-28 09:46:58'),
(60, 72, 138, '2018-11-12 09:16:34'),
(61, 72, 143, '2018-11-12 09:16:34'),
(62, 71, 137, '2018-11-28 09:46:58'),
(63, 73, 134, '2018-11-14 10:42:16'),
(64, 73, 135, '2018-11-14 10:42:16'),
(65, 72, 1, '2018-11-12 09:16:34'),
(66, 68, 140, '2018-11-09 08:24:43'),
(67, 73, 1, '2018-11-14 10:42:16'),
(68, 64, 1, '2018-11-10 10:03:16'),
(69, 70, 140, '2018-11-26 18:02:28'),
(70, 72, 144, '2018-11-12 09:16:34'),
(71, 74, 134, '2018-11-20 06:01:22'),
(72, 71, 134, '2018-11-28 09:46:58'),
(73, 74, 138, '2018-11-20 06:01:22'),
(74, 77, 146, '2018-11-17 08:20:58'),
(75, 71, 146, '2018-11-28 09:46:58'),
(76, 70, 146, '2018-11-26 18:02:28'),
(77, 71, 144, '2018-11-28 09:46:58'),
(78, 74, 142, '2018-11-20 06:01:22'),
(79, 74, 135, '2018-11-20 06:01:22'),
(80, 80, 149, '2018-11-20 14:21:03'),
(81, 81, 160, '2018-11-21 09:18:18'),
(82, 81, 158, '2018-11-21 10:09:03'),
(83, 82, 161, '2018-11-23 10:17:46'),
(84, 84, 165, '2018-11-28 09:05:37'),
(85, 71, 167, '2018-11-28 09:46:58'),
(86, 84, 142, '2018-11-28 09:05:37'),
(87, 71, 165, '2018-11-28 09:46:58'),
(88, 84, 164, '2018-11-28 11:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `USERID` bigint(20) NOT NULL,
  `facebook_id` varchar(250) NOT NULL,
  `google_id` varchar(250) NOT NULL,
  `unique_code` varchar(50) NOT NULL,
  `forget` text NOT NULL,
  `email` varchar(80) NOT NULL DEFAULT '',
  `pemail` varchar(100) NOT NULL,
  `username` varchar(80) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `contact` varchar(50) NOT NULL,
  `profession` int(11) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `funds` decimal(9,2) NOT NULL,
  `afunds` decimal(9,2) NOT NULL,
  `withdrawn` decimal(9,2) NOT NULL,
  `used` decimal(9,2) NOT NULL,
  `user_thumb_image` varchar(500) NOT NULL,
  `user_profile_image` varchar(500) NOT NULL,
  `fullname` varchar(100) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `rating` float NOT NULL DEFAULT '0',
  `ratingcount` bigint(10) NOT NULL DEFAULT '0',
  `profileviews` int(20) NOT NULL DEFAULT '0',
  `addtime` varchar(20) NOT NULL DEFAULT '',
  `lastlogin` varchar(20) NOT NULL DEFAULT '',
  `verified` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `profilepicture` varchar(100) NOT NULL DEFAULT '',
  `remember_me_key` varchar(32) DEFAULT NULL,
  `remember_me_time` datetime DEFAULT NULL,
  `ip` varchar(20) NOT NULL,
  `lip` varchar(20) NOT NULL,
  `aemail` varchar(100) NOT NULL,
  `country` int(11) NOT NULL,
  `state` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `zipcode` bigint(20) NOT NULL,
  `user_timezone` varchar(200) NOT NULL,
  `toprated` int(1) NOT NULL DEFAULT '0',
  `level` bigint(1) NOT NULL DEFAULT '1',
  `lang_speaks` text NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `lname` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `are_you` varchar(20) NOT NULL,
  `videos` varchar(500) NOT NULL,
  `feature_user` varchar(500) NOT NULL DEFAULT 'No'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`USERID`, `facebook_id`, `google_id`, `unique_code`, `forget`, `email`, `pemail`, `username`, `password`, `contact`, `profession`, `pwd`, `funds`, `afunds`, `withdrawn`, `used`, `user_thumb_image`, `user_profile_image`, `fullname`, `description`, `rating`, `ratingcount`, `profileviews`, `addtime`, `lastlogin`, `verified`, `status`, `profilepicture`, `remember_me_key`, `remember_me_time`, `ip`, `lip`, `aemail`, `country`, `state`, `city`, `address`, `zipcode`, `user_timezone`, `toprated`, `level`, `lang_speaks`, `created_date`, `lname`, `phone`, `are_you`, `videos`, `feature_user`) VALUES
(142, '', '', '142zklZniOBLgoEZK', '', 'pawan.sharma@digimonk.in', '', 'user_1541394806', 'e847303fea54a48f392ee7db70f6efd0', '', 0, '', '0.00', '0.00', '0.00', '0.00', 'uploads/profile_images/profile_image_142_50x50.png', 'uploads/profile_images/profile_image_142_200x200.png', 'pawan sharma', '', 0, 0, 0, '', '', 0, 0, '', NULL, NULL, '', '', '', 231, '3922', '', '', 123456, 'Asia/Kolkata', 0, 1, 'English', '2018-11-05 10:44:04', 'Sharma', '65153132131', 'Short', '1543306534add_amazon_produce_2.ogg', 'Yes'),
(140, '', '', '140CcSpP2zBnr1lMW', '', 'desidavaidotcom@gmail.com', '', 'user_1541356566', '7d3373c28a8e2bf61c551d0aabd40adb', '', 2, '', '0.00', '0.00', '0.00', '0.00', 'uploads/profile_images/profile_image_140_50x50.jpg', 'uploads/profile_images/profile_image_140_200x200.jpg', 'Gaurav Jain', 'WEB DESIGN AND DEVELOPMENT COMPANY YOU WANT\r\nThe INTERNET is transforming the way business works today. \r\nCompanies nowadays getting DIGITALIZED prior with a vision of accomplishing success, we help you in achieving it. \r\n\r\nAs an organization, we have a well-built network of clients globally. Our hardworking team devotes to the satisfaction and success of the client. Our objective is to make a dynamic platform for people and companies to connect with each other in the digital world.\r\n\r\nWe develop websites with the right technical expertise and creativity.\r\n\r\nWe create a quality product with customer satisfaction and after sales support.\r\n\r\nWe come with affordable pricing.', 0, 0, 0, '', '', 0, 0, '', NULL, NULL, '', '', '', 231, '3921', 'Los Angles', 'A 245 Martin St,', 123456, 'Asia/Kolkata', 0, 1, 'English, German', '2018-11-05 00:06:41', 'Jain', '9313590865', 'Short', '', 'Yes'),
(141, '', '', '141TfnqntlUNltPeM', '', 'gauravj@digimonk.in', '', 'user_1541358975', '7d3373c28a8e2bf61c551d0aabd40adb', '', 0, '', '0.00', '0.00', '0.00', '0.00', '', '', 'ADITYA JAIN', '', 0, 0, 0, '', '', 0, 0, '', NULL, NULL, '', '', '', 231, '3919', '', '', 0, 'Asia/Kolkata', 0, 1, '', '2018-11-05 00:46:54', 'JAIN', '1231231455', 'Long', '', 'No'),
(169, '', '', '', '', 'sanjeev.pal@digimonk.in', '', 'user_1543299489', 'fcc9a215009de59c85c88ae3bbcfd7e9', '', 0, '', '0.00', '0.00', '0.00', '0.00', '', '', 'deepak patel', '', 0, 0, 0, '', '', 0, 0, '', NULL, NULL, '', '', '', 231, '3929', '', '', 0, 'Asia/Calcutta', 0, 1, '', '2018-11-27 11:48:45', 'Patel', '7788992255', 'Short', '', 'No'),
(164, '', '', '1646ojn0nRIifCKIu', '', 'rohit.smrl1@gmail.com', '', 'user_1542980296', 'fcc9a215009de59c85c88ae3bbcfd7e9', '', 2, '', '0.00', '0.00', '0.00', '0.00', 'uploads/profile_images/profile_image_164_50x50.jpg', 'uploads/profile_images/profile_image_164_200x200.jpg', 'rohit', 'adsfgas', 0, 0, 0, '', '', 0, 0, '', NULL, NULL, '', '', '', 231, '3938', 'gwalior', 'sewa nagar gwalior', 474003, 'Asia/Kolkata', 0, 1, '', '2018-11-23 19:08:59', 'Arora', '07999908258', 'Short', 'Amazon_Great_Indian_Festival_-_Diwali_Special5.mp4', 'Yes'),
(167, '', '', '167sbmvbAdQIIOaMQ', '', 'deepaksinghpatel052@gmail.com', '', 'user_1543299115', 'fcc9a215009de59c85c88ae3bbcfd7e9', '', 0, '', '0.00', '0.00', '0.00', '0.00', '', '', 'deepak patel', '', 0, 0, 0, '', '', 0, 0, '', NULL, NULL, '', '', '', 231, '3929', '', '', 1, 'Asia/Kolkata', 0, 1, '', '2018-11-27 11:42:32', 'Patel', '8435144608', 'Short', '', 'No'),
(165, '', '', '165Uev66yKCDRtIWm', '', 'rohit.smrl@gmail.com', '', 'user_1542981617', 'fcc9a215009de59c85c88ae3bbcfd7e9', '', 0, '', '0.00', '0.00', '0.00', '0.00', '', '', 'Rohit Arora', '', 0, 0, 0, '', '', 0, 0, '', NULL, NULL, '', '', '', 231, '3932', '', '', 0, 'Asia/Kolkata', 0, 1, '', '2018-11-23 19:31:22', 'Arora', '1274564849', 'Long', '', 'No'),
(161, '', '', '161gqBGXQWEI5wREK', '', 'pk6884115@gmail.com', '', 'user_1542966690', 'e847303fea54a48f392ee7db70f6efd0', '', 0, '', '0.00', '0.00', '0.00', '0.00', 'uploads/profile_images/profile_image_161_50x50.jpg', 'uploads/profile_images/profile_image_161_200x200.jpg', 'ajay Sharma', '', 0, 0, 0, '', '', 0, 0, '', NULL, NULL, '', '', '', 231, '3922', '', '', 0, 'Asia/Kolkata', 0, 1, '', '2018-11-23 15:23:20', 'Sharma', '966932662', 'Short', '_Solvettube.com_Tekken_3_Video.mp4', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `one_signal_device_ids`
--

CREATE TABLE `one_signal_device_ids` (
  `id` int(11) NOT NULL,
  `device_id` varchar(256) NOT NULL,
  `device` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `our_blog`
--

CREATE TABLE `our_blog` (
  `id` bigint(20) NOT NULL,
  `categorys` varchar(500) NOT NULL,
  `title` varchar(500) NOT NULL,
  `image` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `date` varchar(500) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `our_blog`
--

INSERT INTO `our_blog` (`id`, `categorys`, `title`, `image`, `status`, `date`, `content`) VALUES
(2, '4*#*5', 'deepak patel', 'pexels-photo-2625084.jpeg', '0', '26-11-2018', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n'),
(3, '3*#*5', 'deepak patel', 'pexels-photo-2625083.jpeg', '0', '26-11-2018', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n'),
(4, '3*#*2*#*5', 'deepak patel', 'pexels-photo-262508.jpeg', '0', '26-11-2018', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n'),
(5, '2*#*5', 'New Blog', 'pexels-photo-2625085.jpeg', '0', '26-11-2018', '<p><strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem..<strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem..<strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem..<strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem..<strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem..<strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem..<strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem..<strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem..<strong>Lorem Ipsum</strong>&nbsp;est simplement du faux texte employ&eacute; dans la composition et la mise en page avant impression. Le Lorem..</p>\r\n'),
(6, '3*#*5', 'This is new blog', 'pexels-photo-2625086.jpeg', '0', '26-11-2018', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n'),
(7, '3*#*5', '3 Easy Ways For Small Businesses To Get Cyber Monday Ready', 'pexels-photo-2625088.jpeg', '0', '28-11-2018', '<p>With Cyber Monday coming fast on the heels of Black Friday and Small Business Saturday, small biz owners don&rsquo;t have much time to catch their breath. It&rsquo;s hard to prepare for this key shopping day when so much is going on in such a short time frame. The last thing you have time for is trying to spiff up your&nbsp;<a href=\"https://blog.fiverr.com/building-business-online-online-offline-promotions/\">online presence</a>&mdash;but a working website is essential to Cyber Monday success.</p>\r\n\r\n<p>Fortunately, thousands of talented professionals are ready to help you spread small business cheer ASAP. Here&rsquo;s how they can help you and your small biz prepare for Cyber Monday&mdash;and yes, there&rsquo;s still time!</p>\r\n\r\n<h2>The Tech Team</h2>\r\n\r\n<p>Step one: your website. Since is a day dedicated to online shopping, you need want to get the technology driving Cyber Monday to be spot on. With so much going on in such a short time frame, it&rsquo;s easy to feel overwhelmed when trying to prepare for this key shopping day. Your retail success depends on the experience you provide through your website. Don&rsquo;t leave your bottom line to chance. Work with a professional to ensure your site so you&rsquo;re prepared for the influx of online shoppers.</p>\r\n\r\n<p>For example, do you know *for sure* if your site can handle the strain of extra visitors and still be able to function optimally? Ask&nbsp;<a href=\"https://www.fiverr.com/search/gigs?acmpl=1&amp;utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=user%20testing&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=user%20testing&amp;search-autocomplete-available=false&amp;search-autocomplete-type=suggest&amp;search-autocomplete-position=0\">user-testing specialists</a>&nbsp;to assess your website&rsquo;s download speed. This will help you avoid losing customers who are frustrated because your pages load too slowly. These tech experts can also check and fix any broken links that otherwise would lead to&nbsp;<a href=\"https://blog.fiverr.com/online-holiday-shopping/\">shopping-cart abandonment</a>.</p>\r\n\r\n<p>Freelancer pros can also help with other technical aspects, such as building you a&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=chatbot&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=%5C\">chatbot</a>that interacts with visitors and answers questions for them around the clock. Or you can enlist the help of an&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=app%20developer&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=app%20developer\">app developer</a>&nbsp;who can provide back-end solutions that align your mobile app with real-time inventory so you can offer on-demand shopping.</p>\r\n\r\n<h2>Web Designers</h2>\r\n\r\n<p>Your competitors are hopping on the holiday bandwagon, so don&rsquo;t risk looking like the Grinch by leaving your website as-is! Consider adding&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=graphic%20design&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=graphic%20design\">festive touches</a>&nbsp;to your website to get customers in the shopping mood and special Cyber Monday deal landing pages directing shoppers to the best deals. Spread the word on social by elegantly integrating your channels into your website. Check out our roster of&nbsp;<a href=\"https://www.fiverr.com/search/gigs?acmpl=1&amp;utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;query=graphic%20designers&amp;search-autocomplete-original-term=graphic%20designers&amp;search-autocomplete-available=true&amp;search-autocomplete-type=suggest&amp;search-autocomplete-position=1&amp;search_in=category&amp;category=3&amp;sub_category=151\">skilled website designers</a>&nbsp;ready to hit the ground running faster than Rudolph and his sleigh!</p>\r\n\r\n<h2>Visual Artists</h2>\r\n\r\n<p>A picture&rsquo;s worth a thousand words (and sales). It&rsquo;s no secret that great visuals get people to click. In fact, 93% of consumers say &ldquo;visual appearance&rdquo; is the&nbsp;<a href=\"https://blog.justuno.com/ecommerce-consumer-psychology\">key deciding factor</a>&nbsp;when they buy something online. Online shopping always requires a leap of faith, so seeing a product up close and personal is *almost* as good as holding it in your hands. If you sell gorgeous products that no one can see, how wil they ever know (or trust) to purchase them?</p>\r\n\r\n<p>So it&rsquo;s worth it to tap into the Fiverr community of&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=product%20photography&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=product%20photography\">photographers</a>,&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=guest-homepage&amp;locale=en&amp;search_in=everywhere&amp;query=videographer&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=videographer\" rel=\"noopener\" target=\"_blank\">videographers</a>, and&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=photo%20editor&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=photo%20editor\">photo</a>&nbsp;and&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=video%20editor&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=video%20%20editor\">video editors</a>&nbsp;to create compelling visuals&mdash;or better yet, videos&mdash;that make your products look their holiday best.</p>\r\n\r\n<p>Think of Fiverr freelancers as your personal team of elves in the North Pole. With their skill set and quick turnaround at the ready, you can *actually* focus on running your business. With the extra time you gain from hiring technical, visual, and web experts, you&rsquo;ll more effectively target the right audiences and understand what they want from their holiday shopping experience, not only on Cyber Monday but throughout the season.</p>\r\n\r\n<p><em>How are you preparing for Cyber Monday? Share your tips in the comments below!</em></p>\r\n'),
(8, '4*#*5', 'The Big Picture: Why Every Freelancer Should Learn Photoshop', 'pexels-photo-2625089.jpeg', '0', '28-11-2018', '<p>&ldquo;Can you supply images to illustrate this story? Do you know Photoshop?&rdquo;</p>\r\n\r\n<p>If you&rsquo;re a freelance writer, you&rsquo;ve likely heard this question in response to a pitch. Having an eye-catching lead image to share on&nbsp;<a href=\"https://www.fiverr.com/categories/online-marketing/social-marketing\" rel=\"noopener\" target=\"_blank\">social media</a>&nbsp;is vital for increasing engagement and, as&nbsp;<a href=\"https://blog.fiverr.com/webdevelopervswebdesigner/\" rel=\"noopener\" target=\"_blank\">website design</a>&nbsp;advances, even simple articles are often placed in sophisticated, image-heavy layouts that mimic print magazines. But as budgets get tighter, few outlets are able to hire photographers. And stock photos often lack authenticity and diversity, or just aren&rsquo;t available for certain topics.</p>\r\n\r\n<p>This means that freelancers who can provide high-quality images to illustrate their work have a&nbsp;<a href=\"https://blog.fiverr.com/105-tips-to-become-a-successful-freelancer/\" rel=\"noopener\" target=\"_blank\">leg up on the competition</a>. Mobile phones are great for taking high-quality images, but not so hot when it comes to editing them (the Clarendon filter might get you the most Instagram likes, but it&rsquo;s not going to impress an editor). If you want to send photos that are as fine-tuned as your pitch,&nbsp;<a href=\"https://blog.fiverr.com/let-photo-editing-help-retain-customers/\" rel=\"noopener\" target=\"_blank\">basic photo editing skills are obligatory</a>. Few programs do more to tweak a photo from so-so to header-image quality than Adobe Photoshop, and it&rsquo;s easy to learn a few small tips and tricks to make your images pop.</p>\r\n\r\n<p>Here are three of the most useful Photoshop functions and why you need to know them:</p>\r\n\r\n<h3>1. Color correction</h3>\r\n\r\n<p>Ever taken a photo of a mouthwatering plate of food, only to find that your camera&rsquo;s lens had somehow rendered it as bland and drab? Or have you discovered that the sky in an outdoor shot isn&rsquo;t as blue as it is in your memory? In Photoshop, use the eyedropper tool to adjust the white balance and give your photos crisp contrast. Or amp up the saturation and vibrance to make a landscape really pop.</p>\r\n\r\n<h3>2. Cropping</h3>\r\n\r\n<p>Framing is everything. But what if you didn&rsquo;t get that snap set up quite right? With Photoshop, you can make sure your subject is central, adjust your photo to comply with the rule of thirds, or otherwise adjust your image to draw the viewer&rsquo;s eye to just the right spot with the cropping tool.</p>\r\n\r\n<h3>3. Retouching</h3>\r\n\r\n<p>Are ugly power lines marring that blue sky? Use the clone tool or content-aware fill to remove them. Or smooth out facial discolorations or distracting blemishes to make your portrait subjects as radiant as they deserve to be.</p>\r\n\r\n<h3>4. Adjust file size, resolution and type</h3>\r\n\r\n<p>Your editor will love you even more if you deliver your photos in the exact format they need. In Photoshop, you can easily resize images to their preferred dimensions, adjust the resolution (it will be far higher for print images than for those being used online), and the type of file (JPEG, GIF, PNG, etc.).</p>\r\n\r\n<p><a href=\"https://learn.fiverr.com/\">Learn From Fiverr</a>&nbsp;offers several different options for those who want to learn these techniques and more. Choose from Adobe Photoshop Fundamentals, Adobe Photoshop Mastery, and Photo Manipulation in Adobe Photoshop. Once you&rsquo;ve established your Photoshop chops, sending an image or two along with the magic phrase &ldquo;Yes! I&rsquo;d love to supply images to illustrate this story&rdquo; just might put you at the top of your editor&rsquo;s favorites list &ndash; and is sure to help you&nbsp;<a href=\"https://blog.fiverr.com/five-ways-to-build-your-freelance-writing-business/\" rel=\"noopener\" target=\"_blank\">build your freelance career</a>.</p>\r\n\r\n<p>And, of course, pocketing a little bit extra for those images is also another way to&nbsp;<a href=\"https://blog.fiverr.com/fiverr-pro-tips-optimize-gigs-maximize-sales/\" rel=\"noopener\" target=\"_blank\">maximize the earning potential</a>&nbsp;of your Gigs.</p>\r\n\r\n<p><em>Have you been asked for photos to illustrate your pitches? Have you successfully sold photos alongside a pitch? What is your favorite Photoshop trick? Tell us in the comments!</em></p>\r\n'),
(9, '3*#*4*#*5', 'Big Day for Small Biz: How to Make the Most of Small Business Saturday', 'pexels-photo-26250810.jpeg', '0', '28-11-2018', '<p>Black Friday is so 2010. November 24th is&nbsp;<a href=\"https://www.americanexpress.com/us/small-business/shop-small/about\">Small Business Saturday,&nbsp;</a>AmEx&rsquo;s annual celebration of the local entrepreneurs that strengthen our communities. The celebration encourages consumers to take advantage of the wonderful things that local small businesses offer, rather than just opt for the convenience of the larger &ldquo;big box&rdquo; stores.</p>\r\n\r\n<p>If you&rsquo;re a small business owner, this is an opportunity to attract the attention of customers both new and old. But first things first, you need to develop a&nbsp;<a href=\"https://blog.fiverr.com/something-to-celebrate-how-to-run-holiday-promotions/\">holiday marketing campaign</a>that appeals to potential customers and helps you stand out from the crowd on one of the busiest shopping days of the year.</p>\r\n\r\n<p>Daunted by the sound of taking on extra work before the holidays? Don&rsquo;t worry. Hire Fiverr freelance talent to make it a holly jolly Christmas shopping seasons without needing an entire workshop of North Pole elves.</p>\r\n\r\n<h2>Festive collateral</h2>\r\n\r\n<p>Deck the halls (and emails) with boughs of holly. Partner with a&nbsp;<a href=\"https://www.fiverr.com/search/gigs?acmpl=1&amp;utf8=%E2%9C%93&amp;source=guest-homepage&amp;locale=en&amp;search_in=everywhere&amp;query=graphic%20design&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=graphic%20deisgn&amp;search-autocomplete-type=suggest&amp;search-autocomplete-position=0\" rel=\"noopener\" target=\"_blank\">Fiverr graphic designer</a>&nbsp;to create everything from custom decorations for your physical storefront to festive holiday greetings for your existing customers to flyers announcing that Santa will be paying a visit to your studio on&nbsp;<a href=\"https://blog.fiverr.com/how-to-enjoy-big-success-on-small-business-saturday/\">Small Business Saturday</a>.</p>\r\n\r\n<p>Your holiday promotional collateral might list special shopping hours, specific discounts and deals, and/or information about an in-store party with snacks, beverages, and giveaways. A graphic designer can produce the holiday collateral for you quickly, so you&rsquo;re ready to share it in the days leading up to the holiday event.</p>\r\n\r\n<h2>Holiday content</h2>\r\n\r\n<p>Always mix up Rudolph with Frosty when trying to remember the lyrics to Christmas carols?&nbsp;Let&rsquo;s leave the words to the experts this holiday season. Work with a Fiverr&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=marketing%20content%20&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=marketing%20content%20\" rel=\"noopener\" target=\"_blank\">marketing copywriter</a>&nbsp;to craft the right content to accompany your image.</p>\r\n\r\n<p>But that&rsquo;s not the only right way to hire a writer. Collaborate with an&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=email%20marketing&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=email%20marketing\" rel=\"noopener\" target=\"_blank\">email marketer</a>&nbsp;to prepare the perfect call to action to get your customers off their phones and into your store. A&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=content-marketing%20&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=content-marketing%20\" rel=\"noopener\" target=\"_blank\">content-marketing</a>&nbsp;specialist can update your blog with custom gift guides and strategic posts that feature your top products.</p>\r\n\r\n<h2>Social media</h2>\r\n\r\n<p>With so much already on their plates, many small business owners it&rsquo;s challenging to stay on top of social. It&rsquo;s hard to beat the algorithms (and the competition) on any given day, let alone the holidays! Luckily, there&rsquo;s a wealth of&nbsp;<a href=\"https://www.fiverr.com/search/gigs?acmpl=1&amp;utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=social%20media%20manager&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=social%20medi&amp;search-autocomplete-type=suggest&amp;search-autocomplete-position=0\" rel=\"noopener\" target=\"_blank\">social media experts</a>&nbsp;on Fiverr ready to assist you with the nuances of each individual platform and create emotionally engaging campaigns that translate to every channel.</p>\r\n\r\n<p>Trying to get in the holiday spirit on social? Work with a seasoned social media manager to post behind-the-scenes stories as you welcome shoppers, put up merry decor, or share special discounts or deals. Ask a&nbsp;<a href=\"https://www.fiverr.com/gigs/copywriting\">digital copywriter</a>&nbsp;to whip up some Small Business Saturday copy about day-of promotions or your brand story. Or hire an&nbsp;<a href=\"https://www.fiverr.com/search/gigs?acmpl=1&amp;utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=instagram%20marketing&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=instagram%20&amp;search-autocomplete-available=true&amp;search-autocomplete-type=suggest&amp;search-autocomplete-position=2\">Instagram specialist</a>to leverage user-generated content (UGC) to have customers post images with some of your most popular products for the chance to win store credit.</p>\r\n\r\n<h3>Website updates, landing pages, and mobile optimization</h3>\r\n\r\n<p>Don&rsquo;t forget to grab the official Small Business Saturday logo that you can add to your website homepage and your physical storefront at&nbsp;<a href=\"http://www.shopsmall.com/\">www.shopsmall.com</a>. If you&rsquo;re not sure how to do this, a&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=website%20updates&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=website%20updates\" rel=\"noopener\" target=\"_blank\">web developer&nbsp;</a>can help you with these types of website updates.</p>\r\n\r\n<p>Maybe you want a go a little more National Lampoon&rsquo;s Christmas Vacation than understated this year. If you want to go big, a<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=guest-homepage&amp;locale=en&amp;search_in=everywhere&amp;query=web%20design&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=web%20design\" rel=\"noopener\" target=\"_blank\">&nbsp;web designer</a>&nbsp;can create a special landing page that features Small Business Saturday promotions or events that get folks to stop by your physical store or shop online. Don&rsquo;t forget to have them double-check that your website is optimized for&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=mobile%20optimization&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=mobile%20optimizatio\" rel=\"noopener\" target=\"_blank\">mobile use</a>&nbsp;and&nbsp;<a href=\"https://www.fiverr.com/search/gigs?utf8=%E2%9C%93&amp;source=top-bar&amp;locale=en&amp;search_in=everywhere&amp;query=seo&amp;search-autocomplete-original-term=&amp;search-autocomplete-original-term=seo\" rel=\"noopener\" target=\"_blank\">SEO while&nbsp;</a>they&rsquo;re at it!</p>\r\n\r\n<p>Many of the freelancers on Fiverr can handle more than one of the marketing strategies listed above, helping you get the best value for your holiday marketing investment. Now all you need to do is prepare for the crowds that you&rsquo;ll welcome this Small Business Saturday.</p>\r\n\r\n<p><em>Small business owners, how are you preparing for Small Business Saturday? Tell us in the comments below!</em></p>\r\n'),
(10, '3*#*5', 'Added Benefits: 5 Skills That Help Freelancers Win New Clients', 'pexels-photo-26250811.jpeg', '0', '28-11-2018', '<p>&ldquo;Business has changed.&rdquo;</p>\r\n\r\n<p>It&rsquo;s a mantra that we hear repeatedly, as social media and the internet continue to impact how we work. And almost everyone is affected &ndash; including freelance writers. Your English lit degree won&rsquo;t get you very far if you don&rsquo;t have the knowledge of current trends in technology and social media.</p>\r\n\r\n<p>Fortunately, e-learning courses on&nbsp;<a href=\"https://learn.fiverr.com/\">Learn From Fiverr</a>&nbsp;can help freelancers like you acquire new techniques that increase marketability. Here are five skills that will get clients knocking on your door.</p>\r\n\r\n<h3>1. Adobe Photoshop and Illustrator</h3>\r\n\r\n<p><a href=\"https://www.fiverr.com/categories/graphics-design?source=category_tree\" rel=\"noopener\" target=\"_blank\">Graphic designers</a>&nbsp;are highly valued these days. Design dictates what first catches someone&rsquo;s eye and companies know that. Copywriters can use this demand for skilled designers to their advantage by giving clients bigger bang for their buck. If you can design&nbsp;<em>and</em>&nbsp;write marketing materials, then your client will be thrilled that they don&rsquo;t have to hire two different people. The bonus for you is it allows you to use your creativity in a different way than you normally do. Take a Learn from Fiverr course in&nbsp;<a href=\"https://learn.fiverr.com/bundles/adobe-photoshop-program\">Adobe Photoshop</a>&nbsp;or&nbsp;<a href=\"https://learn.fiverr.com/bundles/Adobe-illustrator-program\">Illustrator</a>&nbsp;to add a little extra oompf to your resume.</p>\r\n\r\n<h3>2. Content marketing</h3>\r\n\r\n<p>One of the most popular ways for businesses to market themselves is via&nbsp;<a href=\"https://www.fiverr.com/categories/online-marketing/content-marketing?source=category_tree\" rel=\"noopener\" target=\"_blank\">editorial content</a>. Companies are making this a top priority and if you can provide the right type of content, you&rsquo;ll be considered invaluable. Learn to be able to adjust your writing voice to that of the company you&rsquo;re writing for. A quirky start-up will likely want something more fun than an established insurance company, for example, but always do your research. The best way to determine what the company wants is to read their past editorial content. Brush up on your&nbsp;<a href=\"https://learn.fiverr.com/courses/blog-content-strategy\">content marketing</a>&nbsp;expertise to stay ahead of the curve.&nbsp;</p>\r\n\r\n<h3>3. SEO literacy</h3>\r\n\r\n<p>Search engine optimization expertise is on every writer&rsquo;s resume these days. And there&rsquo;s a reason for that &ndash; all companies know that their content must be easy to find on the web (no one wants their website buried on page 12 of a Google search). You could be writing brilliant copy, but if no one is reading it, then you&rsquo;re of no use to your client. Learn how to determine the best search terms and watch your readership escalate with Learn from Fiverr&rsquo;s S<a href=\"https://learn.fiverr.com/courses/seo-website-technical-audit\">EO Technical Audit course</a>.</p>\r\n\r\n<h3>4. Data storytelling</h3>\r\n\r\n<p>Do you know how to&nbsp;<a href=\"https://www.forbes.com/sites/brentdykes/2016/03/31/data-storytelling-the-essential-data-science-skill-everyone-needs/#148733c252ad\" rel=\"noopener\" target=\"_blank\">create a narrative</a>&nbsp;from statistics? Companies are always investing in research, but while those researchers may be geniuses in their own right, they don&rsquo;t necessarily know how to translate dry statistics into catchy copy that a reader will enjoy. That&rsquo;s where you come in. Check out our&nbsp;<a href=\"https://learn.fiverr.com/collections?category=digital-marketing\">Data Storytelling course</a>&nbsp;and learn how to turn boring numbers into an engaging story&mdash;and make your client eternally grateful.</p>\r\n'),
(11, '3*#*4', 'Going Next Level: You’re Established, Now Do Even More', 'pexels-photo-26250812.jpeg', '0', '28-11-2018', '<p>Congratulations. You&nbsp;<a href=\"http://blog.fiverr.com/starting-scratch-tos-turning-idea-real-business\">started up</a>, and you lost sleep. You drank more coffee than you thought humanly possible. You kept going. And before you knew it, you&nbsp;<a href=\"http://blog.fiverr.com/scaling-need-knows-insider-tips-growth/\">scaled up</a>, and you had other people (clients, employees) to talk to in addition to your mom. And now, there&rsquo;s still not much sleep, but you&rsquo;re ready do even more with your business or brand. It&rsquo;s time to go big.</p>\r\n\r\n<p>In this guide, we&rsquo;ve got everything you need to make sure you&rsquo;re executing the day-to-day seamlessly, going above and beyond for your customers, for your product, and for yourself as a freelancer and small business owner. Go big or go home. And wouldn&rsquo;t you rather go big and then home to the big home you earned? Yeah, you would.</p>\r\n\r\n<h4>Always be Optimizing</h4>\r\n\r\n<p>We pretended&nbsp;<em>Glengarry Glen Ross</em>&nbsp;said it before, and we&rsquo;ll do it again: always be optimizing! Enhancing and improving your products and services regularly can only save you headaches and help your business in both the short and the long term. And this doesn&rsquo;t just mean making your site better looking (although you can totally do that,&nbsp;<a href=\"https://www.fiverr.com/categories/graphics-design/web-plus-mobile-design?source=category_tree&amp;page=1&amp;filter=auto\">here</a>. Take a look at ways to optimize your&nbsp;<a href=\"https://www.fiverr.com/categories/online-marketing/search-engine-marketing/#filter=auto&amp;page=1\">search engine marketing</a>,&nbsp;<a href=\"https://www.fiverr.com/categories/programming-tech/ecommerce-services?source=category_tree&amp;page=1&amp;filter=auto\">e-commerce</a>&nbsp;and&nbsp;<a href=\"https://www.fiverr.com/categories/programming-tech/web-cms-services/performance-security?source=category_filters&amp;page=1&amp;filter=auto\">site performance</a>. Ensuring all of these are running as efficiently as possible promises your customers are getting the best experience possible.</p>\r\n\r\n<h4>Show The Love</h4>\r\n\r\n<p>At this point, you&rsquo;ve got a good base of regular customers. They love the quality of your product or service, and you love seeing their orders pour in. And, according to Social Annex, loyal&nbsp;<a href=\"http://www.socialannex.com/blog/2016/02/05/ultimate-customer-loyalty-statistics-2016/\">customers are worth up to 10x as much as their first purchase</a>. So, how about rewarding them with exclusive promotions, special offers, and more? Give them some&nbsp;<a href=\"https://www.fiverr.com/categories/graphics-design/sample-business-cards-design?source=category_tree&amp;page=1&amp;filter=auto\">branded customer loyalty cards</a>, where each customer is given a specific code, or bestow some exclusive&nbsp;<a href=\"https://www.fiverr.com/categories/graphics-design/t-shirts?source=category_tree&amp;page=1&amp;filter=auto\">brand ambassador swag</a>&nbsp;on them, that&rsquo;s for high-frequency, VIP customers only. There&rsquo;s something about exclusivity that will drive people to spend that extra dollar or two, to let everyone know how special they are to your brand.</p>\r\n\r\n<h4>Take It On the Road</h4>\r\n\r\n<p>Speaking of swag, we know we&rsquo;re all about digital, but sometimes good ol&rsquo; fashioned face-to-face marketing works wonders. So take you swag and business swagger out on the road. Find out the biggest and most reputable trade shows or conferences in your industry, and if it&rsquo;s doable, plan on going.</p>\r\n\r\n<p>We know you love to hustle, and trade shows and conferences are a great way to network, build business relationships, and find new clients. It&rsquo;s also a chance to physically put your brand in a place it might not otherwise be, and in front of audiences who may not normally see it. So when you hit the road, go prepared with&nbsp;<a href=\"https://www.fiverr.com/categories/graphics-design/banner-ads?source=category_tree&amp;page=1&amp;filter=auto\">banners</a>,&nbsp;<a href=\"https://www.fiverr.com/categories/graphics-design/creative-brochure-design?source=category_tree&amp;page=1&amp;filter=auto\">flyers and posters</a>, and any other additional swag with&nbsp;<a href=\"https://www.fiverr.com/categories/graphics-design?source=category_tree\">custom branding</a>&nbsp;you can think of. Those trinkets will end up in pockets and bags, and remind anyone who met you to stay in touch or look up your business. Cha-ching!</p>\r\n\r\n<h4>Get Next-level on Social</h4>\r\n\r\n<p>Have you thought about how you can optimize your social media presence? We know, we know. We&rsquo;re starting to sound like a broken record with the whole optimizing thing, but going next level means EVERY level, including social media. And going next level could be as simple as corresponding with customers via social.&nbsp;<a href=\"https://blog.twitter.com/2016/study-twitter-customer-care-increases-willingness-to-pay-across-industries\">Twitter reports&nbsp;</a>that &ldquo;Customers who receive responses on Twitter from a business are 30% more likely to recommend the brand to others, and 44% more likely to share their experience online and off.&rdquo; That&rsquo;s awesome. And they let just about anyone have a Twitter account these days, so you&rsquo;re already winning.</p>\r\n\r\n<p>Think about incorporating seasonal or on-trend&nbsp;<a href=\"https://www.fiverr.com/categories/graphics-design/social-media-design?source=category_tree&amp;page=1&amp;filter=rating\">skin or avatar designs</a>&nbsp;in your social media pages. Or updating the type of content you&rsquo;re sharing with custom gifs,&nbsp;<a href=\"https://www.fiverr.com/categories/video-animation/whiteboard-explainer-videos?source=category_tree&amp;page=1&amp;filter=auto\">whiteboard</a>&nbsp;or&nbsp;<a href=\"https://www.fiverr.com/categories/video-animation/animated-characters-modeling?source=category_tree&amp;page=1&amp;filter=auto\">animated videos</a>.</p>\r\n\r\n<p>Looking for inspiration? Check out these&nbsp;<a href=\"https://www.entrepreneur.com/article/232548\">five social tricks from Entrepreneur</a>&nbsp;to boost your business.</p>\r\n\r\n<h4>Mobile is Key</h4>\r\n\r\n<p>In a time when even Grandma has a smartphone, the importance of building a mobile app to reflect your business or brand is essential. According to Statista&nbsp;<a href=\"https://www.statista.com/topics/1002/mobile-app-usage/\">mobile apps are forecasted to generate around 189 billion dollars</a>&nbsp;in the US alone by 2020. Wanna get a piece of that pie? Go next level and enhance your brand or business with it&rsquo;s own mobile app (LINK). Don&rsquo;t think you can create the next Angry Birds? You can still bring big revenues to your business by increasing your&nbsp;<a href=\"https://www.fiverr.com/categories/programming-tech/mobile-app-services?source=category_tree&amp;page=1&amp;filter=rating\">mobile advertising</a>&nbsp;budget. And if you&rsquo;re looking for more inspiration, check out these 10 mobile apps that every freelancer needs.</p>\r\n\r\n<h4>Go Global</h4>\r\n\r\n<p>Not to brag, but our community spans over 190 different countries, so, we know a thing or two about going global. The internet is an incredible tool that brings access to the world via our computers, and, surprise! can put more money in your pocket if utilized correctly. To understand the best ways to go global, check out these e-commerce trends, then learn how to stand out in a global marketplace so you can make a splash amongst other businesses in your industry.</p>\r\n\r\n<p>If you&rsquo;re really ready to go next level, take a look into translating your products and services into other markets,&nbsp;<a href=\"https://www.fiverr.com/pages/FB-Start-Translate\">here</a>. Bien suerte!</p>\r\n\r\n<h4>But Also Local</h4>\r\n\r\n<p>Okay okay, we just said go global. But hyper-focusing on your local market can also provide big opportunities for your business. Take a look at these five&nbsp;<a href=\"http://www.huffingtonpost.com/yatin-khulbe/5-effective-local-marketing-ideas-for-small-businesses_b_9006404.html\">effective local marketing ideas</a>. When you&rsquo;re done with that, create some&nbsp;<a href=\"https://www.fiverr.com/categories/online-marketing/local-listings?source=category_tree&amp;page=1&amp;filter=rating\">local listings</a>&nbsp;or hit the streets and put up&nbsp;<a href=\"https://www.fiverr.com/categories/advertising/handing-out-flyers?source=category_tree&amp;page=1&amp;filter=auto\">flyers or posters</a>&nbsp;around town. These things may seem so simple, and you may have blown right past them when you were establishing and scaling up your business, but turning your attention to your local market can be big for your bottom line. Also, the people love you! Look at you! You&rsquo;re a business superstar.</p>\r\n\r\n<h4>Go Beyond Social</h4>\r\n\r\n<p>Not to pick on Grandma, but she&rsquo;s probably on Instagram, and that&rsquo;s super, but it means in order to go next level, you need to look beyond social media. What&rsquo;s the next cool thing? Is there a marketing tactic you haven&rsquo;t tried, such as press releases, commercials, and audience promotion that can be&nbsp;<a href=\"https://www.fiverr.com/pages/FB-Start-Promote-Announce\">distributed beyond your social channels</a>. Do some research to learn more about your current and&nbsp;<a href=\"https://www.fiverr.com/pages/FB-Start-Research\">potential audiences for growth</a>.</p>\r\n\r\n<p>You&rsquo;ve struggled through endless work days and nights. You know going big with your business isn&rsquo;t something that can happen overnight. It&rsquo;s a mindset, and for a business as established as yours, you must always be optimizing. Keep looking for ways to better enhance and promote your product, and above all, keep doing.</p>\r\n\r\n<p><em>Have any tips or guidance we missed? Let us know in the comments below.</em></p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `page_id` int(11) NOT NULL,
  `page_name` varchar(45) NOT NULL,
  `page_content` text NOT NULL,
  `page_status` int(11) NOT NULL,
  `page_create` datetime NOT NULL,
  `page_modfied` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) NOT NULL,
  `USERID` bigint(20) NOT NULL,
  `gigs_id` int(11) NOT NULL,
  `extra_gig_ref` text NOT NULL,
  `currency_type` char(5) NOT NULL,
  `time_zone` varchar(250) NOT NULL,
  `seller_id` mediumint(9) NOT NULL,
  `item_amount` double NOT NULL,
  `currency` varchar(5) NOT NULL DEFAULT 'usd',
  `dollar_amount` double NOT NULL,
  `gig_price_dollar_rate` float NOT NULL,
  `created_at` datetime NOT NULL,
  `paypal_uid` varchar(255) NOT NULL,
  `stripe_charge` text NOT NULL,
  `stripe_refund` text NOT NULL,
  `refund_amount` decimal(10,2) NOT NULL,
  `commision` varchar(255) NOT NULL,
  `paypal_status` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `shipping_status` tinyint(4) NOT NULL DEFAULT '1',
  `pay_method` tinyint(4) NOT NULL DEFAULT '1',
  `buyer_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-default, 1- cancel request',
  `cancel_reason` varchar(500) NOT NULL,
  `canceled_at` datetime NOT NULL,
  `cancel_accept` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-default, 1- accept',
  `seller_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1.New 2.Pending 3.Processing 4.Refunded 5.Decline 6.Completed 7. Complete Request 8. Complete Request Accept ',
  `decline_accept` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-default, 1- accept',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-normal,1-payment request, 2-payment received',
  `update_date` datetime NOT NULL,
  `mail_sent` int(11) NOT NULL DEFAULT '1',
  `payment_returnmethod` tinyint(4) NOT NULL,
  `dispatch_date` datetime NOT NULL,
  `notification_status` tinyint(4) NOT NULL DEFAULT '1',
  `cancel_notification_status` tinyint(4) NOT NULL DEFAULT '0',
  `notification_paycomplete` tinyint(4) NOT NULL DEFAULT '0',
  `admin_notification_status` tinyint(4) NOT NULL DEFAULT '1',
  `payment_super_fast_delivery` int(11) NOT NULL,
  `delivery_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `extra_gig_indian_rupee` float NOT NULL,
  `extra_gig_dollar` float NOT NULL,
  `pay_status` varchar(100) NOT NULL,
  `source` varchar(100) NOT NULL,
  `amplify_verify` text NOT NULL,
  `txn_id` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `USERID`, `gigs_id`, `extra_gig_ref`, `currency_type`, `time_zone`, `seller_id`, `item_amount`, `currency`, `dollar_amount`, `gig_price_dollar_rate`, `created_at`, `paypal_uid`, `stripe_charge`, `stripe_refund`, `refund_amount`, `commision`, `paypal_status`, `status`, `shipping_status`, `pay_method`, `buyer_status`, `cancel_reason`, `canceled_at`, `cancel_accept`, `seller_status`, `decline_accept`, `payment_status`, `update_date`, `mail_sent`, `payment_returnmethod`, `dispatch_date`, `notification_status`, `cancel_notification_status`, `notification_paycomplete`, `admin_notification_status`, `payment_super_fast_delivery`, `delivery_date`, `extra_gig_indian_rupee`, `extra_gig_dollar`, `pay_status`, `source`, `amplify_verify`, `txn_id`) VALUES
(30, 141, 70, '\"\"', 'USD', 'Asia/Kolkata', 140, 999, 'USD', 999, 0, '2018-11-09 23:21:25', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 2, '2018-11-09 23:27:35', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-11 17:59:58', 0, 0, '', 'paypal', '', ''),
(29, 143, 72, '\"\"', 'USD', 'Asia/Kolkata', 138, 20, 'USD', 20, 0, '2018-11-09 19:58:06', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 2, '2018-11-09 19:59:07', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-10 08:18:18', 0, 0, '', 'paypal', '', ''),
(28, 143, 72, '\"\"', 'USD', 'Asia/Kolkata', 138, 20, 'USD', 20, 0, '2018-11-09 19:20:20', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 2, '2018-11-09 19:56:36', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-10 08:18:18', 0, 0, '', 'paypal', '', ''),
(32, 143, 72, '\"\"', 'USD', 'Asia/Kolkata', 138, 35, 'USD', 35, 0, '2018-11-10 10:43:31', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 3, 0, 0, '2018-11-10 10:45:39', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, 0, 1, '2018-11-10 05:15:39', 0, 0, '', 'paypal', '', ''),
(33, 137, 71, '\"\"', 'USD', 'Asia/Kolkata', 142, 100, 'USD', 100, 0, '2018-11-10 11:04:16', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-10 05:43:02', 0, 0, '', 'paypal', '', ''),
(31, 143, 72, '\"\"', 'USD', 'Asia/Kolkata', 138, 20, 'USD', 20, 0, '2018-11-10 10:11:34', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 2, '2018-11-10 10:40:54', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-10 08:18:18', 0, 0, '', 'paypal', '', ''),
(34, 137, 71, '\"\"', 'USD', 'Asia/Kolkata', 142, 100, 'USD', 100, 0, '2018-11-10 11:05:04', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-10 07:26:57', 0, 0, '', 'paypal', '', ''),
(35, 135, 73, '\"\"', 'USD', 'Asia/Kolkata', 134, 45, 'USD', 45, 0, '2018-11-10 11:56:21', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 2, '2018-11-10 15:38:53', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-10 10:20:42', 0, 0, '', 'paypal', '', ''),
(36, 143, 72, '\"\"', 'USD', 'Asia/Kolkata', 138, 35, 'USD', 35, 0, '2018-11-10 12:23:39', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 1, 0, 0, '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-10 06:55:45', 0, 0, '', 'paypal', '', ''),
(37, 143, 72, '\"\"', 'USD', 'Asia/Kolkata', 138, 35, 'USD', 35, 0, '2018-11-10 13:46:10', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 2, '2018-11-10 13:47:09', 1, 0, '0000-00-00 00:00:00', 1, 0, 1, 0, 1, '2018-11-10 08:43:27', 0, 0, '', 'paypal', '', ''),
(38, 143, 72, '\"\"', 'USD', 'Asia/Kolkata', 138, 35, 'USD', 35, 0, '2018-11-10 13:58:09', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-10 14:04:49', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, 0, 1, '2018-11-10 08:34:49', 0, 0, '', 'paypal', '', ''),
(39, 135, 64, '\"\"', 'USD', 'Asia/Kolkata', 134, 123, 'USD', 123, 0, '2018-11-10 14:02:10', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 2, '2018-11-12 10:08:41', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-12 04:53:13', 0, 0, '', 'paypal', '', ''),
(40, 143, 72, '\"\"', 'USD', 'Asia/Kolkata', 138, 35, 'USD', 35, 0, '2018-11-10 14:05:30', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-10 14:07:02', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, 0, 1, '2018-11-10 08:37:02', 0, 0, '', 'paypal', '', ''),
(41, 143, 72, '\"\"', 'USD', 'Asia/Kolkata', 138, 20, 'USD', 20, 0, '2018-11-10 14:09:19', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-10 14:10:14', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, 0, 1, '2018-11-10 08:40:14', 0, 0, '', 'paypal', '', ''),
(42, 135, 64, '\"\"', 'USD', 'Asia/Kolkata', 134, 123, 'USD', 123, 0, '2018-11-10 14:09:57', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 2, '2018-11-12 10:59:17', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-12 05:30:47', 0, 0, '', 'paypal', '', ''),
(44, 143, 72, '\"\"', 'USD', 'Asia/Kolkata', 138, 20, 'USD', 20, 0, '2018-11-10 14:33:08', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-10 14:34:43', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, 0, 1, '2018-11-10 09:04:43', 0, 0, '', 'paypal', '', ''),
(45, 143, 72, '\"\"', 'USD', 'Asia/Kolkata', 138, 20, 'USD', 20, 0, '2018-11-10 14:37:00', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-10 14:38:09', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, 0, 1, '2018-11-10 09:08:09', 0, 0, '', 'paypal', '', ''),
(46, 143, 72, '\"\"', 'USD', 'Asia/Kolkata', 138, 20, 'USD', 20, 0, '2018-11-10 14:44:07', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-10 14:45:06', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, 0, 1, '2018-11-10 09:15:06', 0, 0, '', 'paypal', '', ''),
(47, 135, 64, '\"\"', 'USD', 'Asia/Kolkata', 134, 123, 'USD', 123, 0, '2018-11-10 15:33:05', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 1, 0, 0, '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-10 10:05:17', 0, 0, '', 'paypal', '', ''),
(48, 141, 70, '\"\"', 'USD', 'Asia/Kolkata', 140, 999, 'USD', 999, 0, '2018-11-11 09:29:44', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 1, '2018-11-14 23:32:04', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-18 07:50:25', 0, 0, '', 'paypal', '', ''),
(49, 141, 70, '\"\"', 'USD', 'Asia/Kolkata', 140, 999, 'USD', 999, 0, '2018-11-11 23:23:03', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 2, '2018-11-11 23:27:46', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-11 18:04:31', 0, 0, '', 'paypal', '', ''),
(50, 135, 73, '\"\"', 'USD', 'Asia/Kolkata', 134, 45, 'USD', 45, 0, '2018-11-12 10:24:15', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 1, 0, 0, '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-12 05:20:44', 0, 0, '', 'paypal', '', ''),
(51, 135, 73, '\"\"', 'USD', 'Asia/Kolkata', 134, 45, 'USD', 45, 0, '2018-11-12 11:16:32', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 2, '2018-11-12 11:19:16', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-12 07:40:47', 0, 0, '', 'paypal', '', ''),
(59, 144, 71, '\"\"', 'USD', 'Asia/Kolkata', 142, 100, 'USD', 100, 0, '2018-11-20 15:53:07', '2UW45430FR655941P', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-20 16:04:06', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-20 13:14:21', 0, 0, '', 'paypal', '', ''),
(67, 160, 81, '\"\"', 'USD', 'Asia/Kolkata', 158, 349, 'USD', 349, 0, '2018-11-21 14:48:09', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 2, '2018-11-21 15:15:46', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-21 10:08:58', 0, 0, '', 'paypal', '', ''),
(54, 146, 71, '\"\"', 'USD', 'Asia/Kolkata', 142, 100, 'USD', 100, 0, '2018-11-17 15:25:45', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 1, 0, 0, '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-17 09:56:44', 0, 0, '', 'paypal', '', ''),
(56, 144, 71, '\"\"', 'USD', 'Asia/Kolkata', 142, 100, 'USD', 100, 0, '2018-11-19 16:31:16', '2VY98084VG0731103', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-19 16:34:01', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-19 11:15:43', 0, 0, '', 'paypal', '', ''),
(60, 144, 71, '\"\"', 'USD', 'Asia/Kolkata', 142, 100, 'USD', 100, 0, '2018-11-20 16:05:28', '0EV88898PY532015U', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-20 16:14:15', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-20 14:21:09', 0, 0, '', 'paypal', '', ''),
(61, 144, 71, '\"\"', 'USD', 'Asia/Kolkata', 142, 100, 'USD', 100, 0, '2018-11-20 16:17:11', '1YC20465P26626236', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-20 16:19:45', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-20 14:21:09', 0, 0, '', 'paypal', '', ''),
(62, 144, 71, '\"\"', 'USD', 'Asia/Kolkata', 142, 100, 'USD', 100, 0, '2018-11-20 16:20:14', '5DS2779721664101M', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-20 16:21:21', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-20 14:21:09', 0, 0, '', 'paypal', '', ''),
(63, 144, 71, '\"\"', 'USD', 'Asia/Kolkata', 142, 100, 'USD', 100, 0, '2018-11-20 16:24:38', '4TA7984202978335Y', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-20 16:28:04', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-20 14:21:09', 0, 0, '', 'paypal', '', ''),
(64, 144, 71, '\"\"', 'USD', 'Asia/Kolkata', 142, 100, 'USD', 100, 0, '2018-11-20 16:29:01', '54962980H99216336', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-20 16:30:36', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-20 14:21:09', 0, 0, '', 'paypal', '', ''),
(65, 144, 71, '\"\"', 'USD', 'Asia/Kolkata', 142, 100, 'USD', 100, 0, '2018-11-20 18:40:03', '5BG77265F2404163G', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-20 18:41:43', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-20 14:21:09', 0, 0, '', 'paypal', '', ''),
(66, 149, 80, '\"\"', 'USD', 'Asia/Kolkata', 148, 68, 'USD', 68, 0, '2018-11-20 19:49:50', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 0, 0, 0, '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, 0, 1, '2018-11-20 14:21:09', 0, 0, '', 'paypal', '', ''),
(68, 165, 84, '\"\"', 'USD', 'Asia/Kolkata', 164, 90, 'USD', 90, 0, '2018-11-23 19:33:37', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 2, '2018-11-23 19:36:04', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 1, '2018-11-23 14:08:12', 0, 0, '', 'paypal', '', ''),
(69, 142, 84, '\"\"', 'USD', 'Asia/Kolkata', 164, 90, 'USD', 90, 0, '2018-11-28 14:35:26', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 1, 0, 0, '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, 0, 1, '2018-11-28 09:06:38', 0, 0, '', 'paypal', '', ''),
(70, 165, 71, '\"\"', 'USD', 'Asia/Kolkata', 142, 100, 'USD', 100, 0, '2018-11-28 15:16:48', '', '', '', '0.00', '10', '', 1, 1, 1, 0, '', '0000-00-00 00:00:00', 0, 6, 0, 0, '2018-11-28 15:19:27', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, 0, 1, '2018-11-28 09:49:27', 0, 0, '', 'paypal', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` int(11) NOT NULL,
  `gateway_name` varchar(50) NOT NULL,
  `gateway_type` varchar(20) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `value` varchar(70) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '(0 Inactive, 1 Active)',
  `created_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `gateway_name`, `gateway_type`, `api_key`, `value`, `status`, `created_dt`) VALUES
(1, 'Stripe', 'sandbox', 'pk_test_Js15CigEZPZH69hjS2hgXjBx', 'sk_test_OVXvseuWuLVp2w0XOWvGKDQJ', 1, '2018-01-11 22:39:57'),
(2, 'Stripe', 'live', 'pk_live_Fcv2quS4tvCx6BwXhfoQQFTT', 'sk_live_juEOItnRuTNTkHuijyJCdSdt', 1, '2018-01-12 00:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_details`
--

CREATE TABLE `paypal_details` (
  `id` int(11) NOT NULL,
  `sandbox_email` varchar(50) NOT NULL,
  `sandbox_password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `developement` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paypal_details`
--

INSERT INTO `paypal_details` (`id`, `sandbox_email`, `sandbox_password`, `email`, `password`, `developement`) VALUES
(1, 'deepakpatel@digimonk.in', 'Deepak@123', '', '', 'sandbox');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_table`
--

CREATE TABLE `paypal_table` (
  `id` int(11) NOT NULL,
  `payer_id` varchar(60) DEFAULT NULL,
  `payment_date` varchar(50) DEFAULT NULL,
  `txn_id` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `payer_email` varchar(75) DEFAULT NULL,
  `payer_status` varchar(50) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `memo` tinytext,
  `item_name` varchar(127) DEFAULT NULL,
  `item_number` varchar(127) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `mc_gross` decimal(9,2) DEFAULT NULL,
  `mc_currency` char(3) DEFAULT NULL,
  `address_name` varchar(255) NOT NULL DEFAULT '',
  `address_street` varchar(255) NOT NULL DEFAULT '',
  `address_city` varchar(255) NOT NULL DEFAULT '',
  `address_state` varchar(255) NOT NULL DEFAULT '',
  `address_zip` varchar(255) NOT NULL DEFAULT '',
  `address_country` varchar(255) NOT NULL DEFAULT '',
  `address_status` varchar(255) NOT NULL DEFAULT '',
  `payer_business_name` varchar(255) NOT NULL DEFAULT '',
  `payment_status` varchar(255) NOT NULL DEFAULT '',
  `pending_reason` varchar(255) NOT NULL DEFAULT '',
  `reason_code` varchar(255) NOT NULL DEFAULT '',
  `txn_type` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `policy_settings`
--

CREATE TABLE `policy_settings` (
  `id` int(11) NOT NULL,
  `policy_name` varchar(100) NOT NULL,
  `policy_terms` varchar(150) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profession`
--

CREATE TABLE `profession` (
  `id` int(11) NOT NULL,
  `profession_name` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profession`
--

INSERT INTO `profession` (`id`, `profession_name`, `status`) VALUES
(1, 'Web Designer', 0),
(2, 'Digital Marketer ', 0),
(3, 'Web Developer ', 0),
(4, 'Graphic Designer', 0),
(5, 'Resume Maker', 0),
(6, 'Content Writer ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `seller_extra_gigs`
--

CREATE TABLE `seller_extra_gigs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `extra_gig_title` varchar(100) NOT NULL,
  `extra_gig_desc` varchar(500) NOT NULL,
  `extra_gig_amount` decimal(10,0) NOT NULL,
  `extra_gig_delivery` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sell_gigs`
--

CREATE TABLE `sell_gigs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `gig_price` float NOT NULL,
  `total_views` int(11) NOT NULL,
  `currency_type` char(5) NOT NULL,
  `cost_type` tinyint(4) NOT NULL COMMENT '0-static,1-dynamic',
  `delivering_time` varchar(500) NOT NULL,
  `gig_tags` text,
  `category_id` int(11) NOT NULL,
  `gig_details` text NOT NULL,
  `super_fast_charges` float NOT NULL,
  `super_fast_delivery` varchar(500) DEFAULT NULL,
  `super_fast_delivery_desc` varchar(250) NOT NULL,
  `super_fast_delivery_date` varchar(500) NOT NULL,
  `work_option` int(11) NOT NULL,
  `requirements` text NOT NULL,
  `youtube_url` varchar(500) NOT NULL,
  `vimeo_url` varchar(500) NOT NULL,
  `vimeo_video_id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `time_zone` varchar(100) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `notification_status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sell_gigs`
--

INSERT INTO `sell_gigs` (`id`, `user_id`, `title`, `gig_price`, `total_views`, `currency_type`, `cost_type`, `delivering_time`, `gig_tags`, `category_id`, `gig_details`, `super_fast_charges`, `super_fast_delivery`, `super_fast_delivery_desc`, `super_fast_delivery_date`, `work_option`, `requirements`, `youtube_url`, `vimeo_url`, `vimeo_video_id`, `status`, `time_zone`, `country_name`, `created_date`, `update_date`, `notification_status`) VALUES
(63, 136, 'ljkhdfkjblbgfkh', 250, 0, 'USD', 1, '25', 'Dftrdh', 16, '<p>fxhtdh trh trh hdrthrfh xherthfgcnhfnd nyhnttn eyteyteytne etty</p>\r\n', 25, 'yes', 'Sdfbtgrbr', '12', 0, '<p>dfgw restsrh dfht hyhytyttyh ythtfn fnyt</p>\r\n', '', '', 0, 1, 'Asia/Kolkata', '', '2018-11-03 10:21:51', '0000-00-00 00:00:00', 1),
(68, 140, 'facebook', 11, 8, 'USD', 1, '25', 'Facebook', 9, '<p>This is the package description i can write this at the time of adding the package.</p>\r\n', 0, '', '', '', 1, '<p>This is the content added by the influncer, what do they need from buyer.</p>\r\n', '', '', 0, 0, 'Asia/Kolkata', '', '2018-11-06 00:23:54', '0000-00-00 00:00:00', 0),
(69, 140, 'twitter-marketing', 199, 3, 'USD', 1, '30', 'Twitter', 8, '<p>WELCOME TO&nbsp;Digimonk</p>\r\n\r\n<p>We are a one-stop destination for all digital solution, be it website designing, digital marketing, SEO, mobile apps. Our refined group of Website Developers bestows their innovation and expertise who convert your idea into an amazing Website Design or Mobile App Development while keeping every custom project unique..</p>\r\n', 0, NULL, '', '', 1, '<h2>WEB DESIGN AND DEVELOPMENT COMPANY YOU WANT</h2>\r\n\r\n<p>The INTERNET is transforming the way business works today.&nbsp;<br />\r\nCompanies nowadays getting DIGITALIZED prior with a vision of accomplishing success, we help you in achieving it.&nbsp;<br />\r\n<br />\r\nAs an organization, we have a well-built network of clients globally. Our hardworking team devotes to the satisfaction and success of the client. Our objective is to make a dynamic platform for people and companies to connect with each other in the digital world.</p>\r\n\r\n<p>We develop websites with the right technical expertise and creativity.</p>\r\n\r\n<p>We create a quality product with customer satisfaction and after sales support.</p>\r\n\r\n<p>We come with affordable pricing.</p>\r\n', '', '', 0, 0, 'Asia/Kolkata', '', '2018-11-05 00:22:54', '0000-00-00 00:00:00', 0),
(70, 140, 'instagram-marketing', 999, 17, 'USD', 1, '25', 'Instagram', 9, '<h2>WEB DESIGN AND DEVELOPMENT COMPANY YOU WANT</h2>\r\n\r\n<p>The INTERNET is transforming the way business works today.&nbsp;<br />\r\nCompanies nowadays getting DIGITALIZED prior with a vision of accomplishing success, we help you in achieving it.&nbsp;<br />\r\n<br />\r\nAs an organization, we have a well-built network of clients globally. Our hardworking team devotes to the satisfaction and success of the client. Our objective is to make a dynamic platform for people and companies to connect with each other in the digital world.</p>\r\n\r\n<p>We develop websites with the right technical expertise and creativity.</p>\r\n\r\n<p>We create a quality product with customer satisfaction and after sales support.</p>\r\n\r\n<p>We come with affordable pricing.</p>\r\n', 0, NULL, '', '', 1, '<p>As an organization, we have a well-built network of clients globally. Our hardworking team devotes to the satisfaction and success of the client. Our objective is to make a dynamic platform for people and companies to connect with each other in the digital world.</p>\r\n', '', '', 0, 1, 'Asia/Kolkata', '', '2018-11-05 00:24:32', '0000-00-00 00:00:00', 1),
(71, 142, 'facebook', 100, 22, 'USD', 1, '2', 'Snapchat', 16, '<p>test test test test test test test&nbsp;test test test test test test test&nbsp;test test test test test test test&nbsp;test test test test test test test&nbsp;&nbsp;test test test test test test test&nbsp;test test test test test test test&nbsp;test test test test test test test&nbsp;test test test test test test test&nbsp;test test test test test test test</p>\r\n', 0, NULL, '', '', 0, '', '', '', 0, 0, 'Asia/Kolkata', '', '2018-11-05 10:47:35', '0000-00-00 00:00:00', 1),
(82, 161, 'freelancer', 100, 0, 'USD', 1, '5', 'Google', 2, '<p>find your perfact way of doing business and fine person&nbsp;who sell your business i m the perfact web designer&nbsp;</p>\r\n\r\n<p>find your perfact way of doing business and fine person&nbsp;who sell your business i m the perfact web designer&nbsp;</p>\r\n\r\n<p>find your perfact way of doing business and fine person&nbsp;who sell your business i m the perfact web designer&nbsp;&nbsp;&nbsp;</p>\r\n', 0, NULL, '', '', 0, '<p>find your perfact way of doing business and fine person&nbsp;who sell your business i m the perfact web designer&nbsp;</p>\r\n\r\n<p>find your perfact way of doing business and fine person&nbsp;who sell your business i m the perfact web designer&nbsp;</p>\r\n\r\n<p>find your perfact way of doing business and fine person&nbsp;who sell your business i m the perfact web designer&nbsp;&nbsp;&nbsp;</p>\r\n', '', '', 0, 0, 'Asia/Kolkata', '', '2018-11-23 15:46:09', '0000-00-00 00:00:00', 1),
(83, 142, 'dfv-weafbf-dbsfbghts', 23, 0, 'USD', 1, '23', 'Dv rsvfg', 16, '<p>aergerg strhstrh tsrh tsh tyhy</p>\r\n', 25, 'yes', 'Sdfgtrgt ', '1', 0, '<p>dxgwegreg trgtrgr fdgrgtgegrw</p>\r\n', '', '', 0, 1, 'Asia/Kolkata', '', '2018-11-23 17:08:58', '0000-00-00 00:00:00', 1),
(84, 164, 'rohit-package', 90, 5, 'USD', 1, '10', 'X  ,sehefh', 11, '<p>adgadgadg ad gads g adsg adsg ads gads g adsg ads gads g adsg adsg ads gads g adsg adsg adsg ads gads ga dsg adsg adsg adsg ads gads gads g adsg adsg ads gads ga dsg asdg ads gads ga dsg adsg adsg ag ads gads g adsg</p>\r\n', 100, 'yes', 'Sdfjkfjsd', '8', 0, '<p>adgadgadg ad gads g adsg adsg ads gads g adsg ads gads g adsg adsg ads gads g adsg adsg adsg ads gads ga dsg adsg adsg adsg ads gads gads g adsg adsg ads gads ga dsg asdg ads gads ga dsg adsg adsg ag ads gads g adsg</p>\r\n', '', '', 0, 0, 'Asia/Kolkata', '', '2018-11-23 19:22:16', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `social_profile`
--

CREATE TABLE `social_profile` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `facebook` varchar(250) NOT NULL,
  `instagram` varchar(250) NOT NULL,
  `twitter` varchar(250) NOT NULL,
  `pinterest` varchar(250) NOT NULL,
  `youtube` varchar(250) NOT NULL,
  `linkedin` varchar(250) NOT NULL,
  `snapchat` varchar(250) NOT NULL,
  `blog` varchar(250) NOT NULL,
  `podcast` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `social_profile`
--

INSERT INTO `social_profile` (`id`, `user_id`, `facebook`, `instagram`, `twitter`, `pinterest`, `youtube`, `linkedin`, `snapchat`, `blog`, `podcast`) VALUES
(2, 2, 'Facebook ', 'ins', 'twi', 'pint', 'youtube', 'Link', 'Snapchat', 'Blog', 'Podcast'),
(3, 14, '#', '#', '#', '#', '#', '#', '#', '#', '#'),
(4, 32, '#', '#', '#', '#', '#', '##', '#', '#', '#'),
(5, 38, 'www.facebook.com/myprofile/apsr', 'www.insta.com/myprofile/apsr', 'www.twitter.com/myprofile/apsr', 'www.pintrest.com/myprofile/apsr', 'www.mytube.com/myprofile/apsr', 'www.link.com/myprofile/apsr', 'www.SPAN.com/myprofile/apsr', 'www.blog.com/myprofile/apsr', 'www.cast.com/myprofile/apsr'),
(6, 55, 'facebook', 'instagram', 'rwitter', 'pinterest', 'youtube', 'linkedin', 'snapchat', 'blog', 'podcast'),
(7, 56, 'sfgfbhybhrvrg', '', '', '', '', '', '', '', ''),
(8, 63, '#', '', '#', '#', '', '#', '#', '#', '#'),
(9, 64, 'www.facebook.com/myprofile/apsr', 'www.insta.com/myprofile/apsr', 'www.twitter.com/myprofile/apsr', 'www.pintrest.com/myprofile/apsr', 'www.mytube.com/myprofile/apsr', 'www.link.com/myprofile/apsr', 'www.SPAN.com/myprofile/apsr', 'www.blog.com/myprofile/apsr', 'www.cast.com/myprofile/apsr'),
(10, 58, '#', '#', '#', '#', '#', '#', '#', '', ''),
(11, 107, 'deepak', 'deepak', 'deepak', 'deepak', 'deepak', 'deepak', 'deepak', 'deepak', 'deepak'),
(12, 65, 'www.facebook.com/myprofile/apsr', 'www.insta.com/myprofile/apsr', 'www.twitter.com/myprofile/apsr', 'www.pintrest.com/myprofile/apsr', 'www.mytube.com/myprofile/apsr', 'www.link.com/myprofile/apsr', 'www.SPAN.com/myprofile/apsr', 'www.blog.com/myprofile/apsr', 'www.cast.com/myprofile/apsr'),
(13, 126, 'sdrwe grtgwvgtrgtsgtrg tr', '', '', '', '', '', '', '', ''),
(14, 140, 'www.facebook.com/myprofile/apsr', 'www.insta.com/myprofile/apsr', 'www.twitter.com/myprofile/apsr', 'www.pintrest.com/myprofile/apsr', 'www.mytube.com/myprofile/apsr', 'www.link.com/myprofile/apsr', 'www.SPAN.com/myprofile/apsr', 'www.blog.com/myprofile/apsr', 'www.cast.com/myprofile/apsr'),
(15, 142, '#', '#', '#', '#', '#', '#', '#', '', '#'),
(16, 134, 'adsf', 'asdf', 'asdf', 'adsf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf'),
(17, 156, 'rohit.smrl@gmail.com', 'asjdflj', 'askldfjl', 'aklsdfjl', 'WWW.YOUTUBE.COM', 'AJDSFL', 'AKLSDJLF', 'AKLSDJFL', 'ALDSFJL'),
(18, 158, 'https://www.facebook.com/DigiMonkOfficial/', 'instagram', 'twitter', '', 'WWW.YOUTUBE.COM', 'Alsdfj', 'Alsdfjk', 'Askldjf', 'Adsfklj'),
(19, 161, '#', '#', '#', '#', '#', '#', '#', '', ''),
(20, 162, 'https://www.facebook.com/DigiMonkOfficial/', 'aldskfj', 'alskdfj', 'alsdkfj', 'WWW.YOUTUBE.COM', 'alkdsfj', 'aldskjf', 'alskdfj', ''),
(21, 164, 'https://www.facebook.com/DigiMonkOfficial/', 'asdgas', 'asdg', '', 'asdg', 'asdg', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `social_widgets`
--

CREATE TABLE `social_widgets` (
  `sw_id` int(11) NOT NULL,
  `twitter_name` varchar(255) NOT NULL DEFAULT '',
  `twitter_id` varchar(255) NOT NULL DEFAULT '',
  `fb_page_name` varchar(255) NOT NULL DEFAULT '',
  `sw_sts` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_widgets`
--

INSERT INTO `social_widgets` (`sw_id`, `twitter_name`, `twitter_id`, `fb_page_name`, `sw_sts`) VALUES
(1, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `state_id` int(11) NOT NULL,
  `state_name` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1',
  `state_status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_id`, `state_name`, `country_id`, `state_status`) VALUES
(1, 'Andaman and Nicobar Islands', 101, 1),
(2, 'Andhra Pradesh', 101, 1),
(3, 'Arunachal Pradesh', 101, 1),
(4, 'Assam', 101, 1),
(5, 'Bihar', 101, 1),
(6, 'Chandigarh', 101, 1),
(7, 'Chhattisgarh', 101, 1),
(8, 'Dadra and Nagar Haveli', 101, 1),
(9, 'Daman and Diu', 101, 1),
(10, 'Delhi', 101, 1),
(11, 'Goa', 101, 1),
(12, 'Gujarat', 101, 1),
(13, 'Haryana', 101, 1),
(14, 'Himachal Pradesh', 101, 1),
(15, 'Jammu and Kashmir', 101, 1),
(16, 'Jharkhand', 101, 1),
(17, 'Karnataka', 101, 1),
(18, 'Kenmore', 101, 1),
(19, 'Kerala', 101, 1),
(20, 'Lakshadweep', 101, 1),
(21, 'Madhya Pradesh', 101, 1),
(22, 'Maharashtra', 101, 1),
(23, 'Manipur', 101, 1),
(24, 'Meghalaya', 101, 1),
(25, 'Mizoram', 101, 1),
(26, 'Nagaland', 101, 1),
(27, 'Narora', 101, 1),
(28, 'Natwar', 101, 1),
(29, 'Odisha', 101, 1),
(30, 'Paschim Medinipur', 101, 1),
(31, 'Pondicherry', 101, 1),
(32, 'Punjab', 101, 1),
(33, 'Rajasthan', 101, 1),
(34, 'Sikkim', 101, 1),
(35, 'Tamil Nadu', 101, 1),
(36, 'Telangana', 101, 1),
(37, 'Tripura', 101, 1),
(38, 'Uttar Pradesh', 101, 1),
(39, 'Uttarakhand', 101, 1),
(40, 'Vaishali', 101, 1),
(41, 'West Bengal', 101, 1),
(42, 'Badakhshan', 1, 1),
(43, 'Badgis', 1, 1),
(44, 'Baglan', 1, 1),
(45, 'Balkh', 1, 1),
(46, 'Bamiyan', 1, 1),
(47, 'Farah', 1, 1),
(48, 'Faryab', 1, 1),
(49, 'Gawr', 1, 1),
(50, 'Gazni', 1, 1),
(51, 'Herat', 1, 1),
(52, 'Hilmand', 1, 1),
(53, 'Jawzjan', 1, 1),
(54, 'Kabul', 1, 1),
(55, 'Kapisa', 1, 1),
(56, 'Khawst', 1, 1),
(57, 'Kunar', 1, 1),
(58, 'Lagman', 1, 1),
(59, 'Lawghar', 1, 1),
(60, 'Nangarhar', 1, 1),
(61, 'Nimruz', 1, 1),
(62, 'Nuristan', 1, 1),
(63, 'Paktika', 1, 1),
(64, 'Paktiya', 1, 1),
(65, 'Parwan', 1, 1),
(66, 'Qandahar', 1, 1),
(67, 'Qunduz', 1, 1),
(68, 'Samangan', 1, 1),
(69, 'Sar-e Pul', 1, 1),
(70, 'Takhar', 1, 1),
(71, 'Uruzgan', 1, 1),
(72, 'Wardag', 1, 1),
(73, 'Zabul', 1, 1),
(74, 'Berat', 2, 1),
(75, 'Bulqize', 2, 1),
(76, 'Delvine', 2, 1),
(77, 'Devoll', 2, 1),
(78, 'Dibre', 2, 1),
(79, 'Durres', 2, 1),
(80, 'Elbasan', 2, 1),
(81, 'Fier', 2, 1),
(82, 'Gjirokaster', 2, 1),
(83, 'Gramsh', 2, 1),
(84, 'Has', 2, 1),
(85, 'Kavaje', 2, 1),
(86, 'Kolonje', 2, 1),
(87, 'Korce', 2, 1),
(88, 'Kruje', 2, 1),
(89, 'Kucove', 2, 1),
(90, 'Kukes', 2, 1),
(91, 'Kurbin', 2, 1),
(92, 'Lezhe', 2, 1),
(93, 'Librazhd', 2, 1),
(94, 'Lushnje', 2, 1),
(95, 'Mallakaster', 2, 1),
(96, 'Malsi e Madhe', 2, 1),
(97, 'Mat', 2, 1),
(98, 'Mirdite', 2, 1),
(99, 'Peqin', 2, 1),
(100, 'Permet', 2, 1),
(101, 'Pogradec', 2, 1),
(102, 'Puke', 2, 1),
(103, 'Sarande', 2, 1),
(104, 'Shkoder', 2, 1),
(105, 'Skrapar', 2, 1),
(106, 'Tepelene', 2, 1),
(107, 'Tirane', 2, 1),
(108, 'Tropoje', 2, 1),
(109, 'Vlore', 2, 1),
(110, '\'Ayn Daflah', 3, 1),
(111, '\'Ayn Tamushanat', 3, 1),
(112, 'Adrar', 3, 1),
(113, 'Algiers', 3, 1),
(114, 'Annabah', 3, 1),
(115, 'Bashshar', 3, 1),
(116, 'Batnah', 3, 1),
(117, 'Bijayah', 3, 1),
(118, 'Biskrah', 3, 1),
(119, 'Blidah', 3, 1),
(120, 'Buirah', 3, 1),
(121, 'Bumardas', 3, 1),
(122, 'Burj Bu Arririj', 3, 1),
(123, 'Ghalizan', 3, 1),
(124, 'Ghardayah', 3, 1),
(125, 'Ilizi', 3, 1),
(126, 'Jijili', 3, 1),
(127, 'Jilfah', 3, 1),
(128, 'Khanshalah', 3, 1),
(129, 'Masilah', 3, 1),
(130, 'Midyah', 3, 1),
(131, 'Milah', 3, 1),
(132, 'Muaskar', 3, 1),
(133, 'Mustaghanam', 3, 1),
(134, 'Naama', 3, 1),
(135, 'Oran', 3, 1),
(136, 'Ouargla', 3, 1),
(137, 'Qalmah', 3, 1),
(138, 'Qustantinah', 3, 1),
(139, 'Sakikdah', 3, 1),
(140, 'Satif', 3, 1),
(141, 'Sayda\'', 3, 1),
(142, 'Sidi ban-al-\'Abbas', 3, 1),
(143, 'Suq Ahras', 3, 1),
(144, 'Tamanghasat', 3, 1),
(145, 'Tibazah', 3, 1),
(146, 'Tibissah', 3, 1),
(147, 'Tilimsan', 3, 1),
(148, 'Tinduf', 3, 1),
(149, 'Tisamsilt', 3, 1),
(150, 'Tiyarat', 3, 1),
(151, 'Tizi Wazu', 3, 1),
(152, 'Umm-al-Bawaghi', 3, 1),
(153, 'Wahran', 3, 1),
(154, 'Warqla', 3, 1),
(155, 'Wilaya d Alger', 3, 1),
(156, 'Wilaya de Bejaia', 3, 1),
(157, 'Wilaya de Constantine', 3, 1),
(158, 'al-Aghwat', 3, 1),
(159, 'al-Bayadh', 3, 1),
(160, 'al-Jaza\'ir', 3, 1),
(161, 'al-Wad', 3, 1),
(162, 'ash-Shalif', 3, 1),
(163, 'at-Tarif', 3, 1),
(164, 'Eastern', 4, 1),
(165, 'Manu\'a', 4, 1),
(166, 'Swains Island', 4, 1),
(167, 'Western', 4, 1),
(168, 'Andorra la Vella', 5, 1),
(169, 'Canillo', 5, 1),
(170, 'Encamp', 5, 1),
(171, 'La Massana', 5, 1),
(172, 'Les Escaldes', 5, 1),
(173, 'Ordino', 5, 1),
(174, 'Sant Julia de Loria', 5, 1),
(175, 'Bengo', 6, 1),
(176, 'Benguela', 6, 1),
(177, 'Bie', 6, 1),
(178, 'Cabinda', 6, 1),
(179, 'Cunene', 6, 1),
(180, 'Huambo', 6, 1),
(181, 'Huila', 6, 1),
(182, 'Kuando-Kubango', 6, 1),
(183, 'Kwanza Norte', 6, 1),
(184, 'Kwanza Sul', 6, 1),
(185, 'Luanda', 6, 1),
(186, 'Lunda Norte', 6, 1),
(187, 'Lunda Sul', 6, 1),
(188, 'Malanje', 6, 1),
(189, 'Moxico', 6, 1),
(190, 'Namibe', 6, 1),
(191, 'Uige', 6, 1),
(192, 'Zaire', 6, 1),
(193, 'Other Provinces', 7, 1),
(194, 'Sector claimed by Argentina/Ch', 8, 1),
(195, 'Sector claimed by Argentina/UK', 8, 1),
(196, 'Sector claimed by Australia', 8, 1),
(197, 'Sector claimed by France', 8, 1),
(198, 'Sector claimed by New Zealand', 8, 1),
(199, 'Sector claimed by Norway', 8, 1),
(200, 'Unclaimed Sector', 8, 1),
(201, 'Barbuda', 9, 1),
(202, 'Saint George', 9, 1),
(203, 'Saint John', 9, 1),
(204, 'Saint Mary', 9, 1),
(205, 'Saint Paul', 9, 1),
(206, 'Saint Peter', 9, 1),
(207, 'Saint Philip', 9, 1),
(208, 'Buenos Aires', 10, 1),
(209, 'Catamarca', 10, 1),
(210, 'Chaco', 10, 1),
(211, 'Chubut', 10, 1),
(212, 'Cordoba', 10, 1),
(213, 'Corrientes', 10, 1),
(214, 'Distrito Federal', 10, 1),
(215, 'Entre Rios', 10, 1),
(216, 'Formosa', 10, 1),
(217, 'Jujuy', 10, 1),
(218, 'La Pampa', 10, 1),
(219, 'La Rioja', 10, 1),
(220, 'Mendoza', 10, 1),
(221, 'Misiones', 10, 1),
(222, 'Neuquen', 10, 1),
(223, 'Rio Negro', 10, 1),
(224, 'Salta', 10, 1),
(225, 'San Juan', 10, 1),
(226, 'San Luis', 10, 1),
(227, 'Santa Cruz', 10, 1),
(228, 'Santa Fe', 10, 1),
(229, 'Santiago del Estero', 10, 1),
(230, 'Tierra del Fuego', 10, 1),
(231, 'Tucuman', 10, 1),
(232, 'Aragatsotn', 11, 1),
(233, 'Ararat', 11, 1),
(234, 'Armavir', 11, 1),
(235, 'Gegharkunik', 11, 1),
(236, 'Kotaik', 11, 1),
(237, 'Lori', 11, 1),
(238, 'Shirak', 11, 1),
(239, 'Stepanakert', 11, 1),
(240, 'Syunik', 11, 1),
(241, 'Tavush', 11, 1),
(242, 'Vayots Dzor', 11, 1),
(243, 'Yerevan', 11, 1),
(244, 'Aruba', 12, 1),
(245, 'Auckland', 13, 1),
(246, 'Australian Capital Territory', 13, 1),
(247, 'Balgowlah', 13, 1),
(248, 'Balmain', 13, 1),
(249, 'Bankstown', 13, 1),
(250, 'Baulkham Hills', 13, 1),
(251, 'Bonnet Bay', 13, 1),
(252, 'Camberwell', 13, 1),
(253, 'Carole Park', 13, 1),
(254, 'Castle Hill', 13, 1),
(255, 'Caulfield', 13, 1),
(256, 'Chatswood', 13, 1),
(257, 'Cheltenham', 13, 1),
(258, 'Cherrybrook', 13, 1),
(259, 'Clayton', 13, 1),
(260, 'Collingwood', 13, 1),
(261, 'Frenchs Forest', 13, 1),
(262, 'Hawthorn', 13, 1),
(263, 'Jannnali', 13, 1),
(264, 'Knoxfield', 13, 1),
(265, 'Melbourne', 13, 1),
(266, 'New South Wales', 13, 1),
(267, 'Northern Territory', 13, 1),
(268, 'Perth', 13, 1),
(269, 'Queensland', 13, 1),
(270, 'South Australia', 13, 1),
(271, 'Tasmania', 13, 1),
(272, 'Templestowe', 13, 1),
(273, 'Victoria', 13, 1),
(274, 'Werribee south', 13, 1),
(275, 'Western Australia', 13, 1),
(276, 'Wheeler', 13, 1),
(277, 'Bundesland Salzburg', 14, 1),
(278, 'Bundesland Steiermark', 14, 1),
(279, 'Bundesland Tirol', 14, 1),
(280, 'Burgenland', 14, 1),
(281, 'Carinthia', 14, 1),
(282, 'Karnten', 14, 1),
(283, 'Liezen', 14, 1),
(284, 'Lower Austria', 14, 1),
(285, 'Niederosterreich', 14, 1),
(286, 'Oberosterreich', 14, 1),
(287, 'Salzburg', 14, 1),
(288, 'Schleswig-Holstein', 14, 1),
(289, 'Steiermark', 14, 1),
(290, 'Styria', 14, 1),
(291, 'Tirol', 14, 1),
(292, 'Upper Austria', 14, 1),
(293, 'Vorarlberg', 14, 1),
(294, 'Wien', 14, 1),
(295, 'Abseron', 15, 1),
(296, 'Baki Sahari', 15, 1),
(297, 'Ganca', 15, 1),
(298, 'Ganja', 15, 1),
(299, 'Kalbacar', 15, 1),
(300, 'Lankaran', 15, 1),
(301, 'Mil-Qarabax', 15, 1),
(302, 'Mugan-Salyan', 15, 1),
(303, 'Nagorni-Qarabax', 15, 1),
(304, 'Naxcivan', 15, 1),
(305, 'Priaraks', 15, 1),
(306, 'Qazax', 15, 1),
(307, 'Saki', 15, 1),
(308, 'Sirvan', 15, 1),
(309, 'Xacmaz', 15, 1),
(310, 'Abaco', 16, 1),
(311, 'Acklins Island', 16, 1),
(312, 'Andros', 16, 1),
(313, 'Berry Islands', 16, 1),
(314, 'Biminis', 16, 1),
(315, 'Cat Island', 16, 1),
(316, 'Crooked Island', 16, 1),
(317, 'Eleuthera', 16, 1),
(318, 'Exuma and Cays', 16, 1),
(319, 'Grand Bahama', 16, 1),
(320, 'Inagua Islands', 16, 1),
(321, 'Long Island', 16, 1),
(322, 'Mayaguana', 16, 1),
(323, 'New Providence', 16, 1),
(324, 'Ragged Island', 16, 1),
(325, 'Rum Cay', 16, 1),
(326, 'San Salvador', 16, 1),
(327, '\'Isa', 17, 1),
(328, 'Badiyah', 17, 1),
(329, 'Hidd', 17, 1),
(330, 'Jidd Hafs', 17, 1),
(331, 'Mahama', 17, 1),
(332, 'Manama', 17, 1),
(333, 'Sitrah', 17, 1),
(334, 'al-Manamah', 17, 1),
(335, 'al-Muharraq', 17, 1),
(336, 'ar-Rifa\'a', 17, 1),
(337, 'Bagar Hat', 18, 1),
(338, 'Bandarban', 18, 1),
(339, 'Barguna', 18, 1),
(340, 'Barisal', 18, 1),
(341, 'Bhola', 18, 1),
(342, 'Bogora', 18, 1),
(343, 'Brahman Bariya', 18, 1),
(344, 'Chandpur', 18, 1),
(345, 'Chattagam', 18, 1),
(346, 'Chittagong Division', 18, 1),
(347, 'Chuadanga', 18, 1),
(348, 'Dhaka', 18, 1),
(349, 'Dinajpur', 18, 1),
(350, 'Faridpur', 18, 1),
(351, 'Feni', 18, 1),
(352, 'Gaybanda', 18, 1),
(353, 'Gazipur', 18, 1),
(354, 'Gopalganj', 18, 1),
(355, 'Habiganj', 18, 1),
(356, 'Jaipur Hat', 18, 1),
(357, 'Jamalpur', 18, 1),
(358, 'Jessor', 18, 1),
(359, 'Jhalakati', 18, 1),
(360, 'Jhanaydah', 18, 1),
(361, 'Khagrachhari', 18, 1),
(362, 'Khulna', 18, 1),
(363, 'Kishorganj', 18, 1),
(364, 'Koks Bazar', 18, 1),
(365, 'Komilla', 18, 1),
(366, 'Kurigram', 18, 1),
(367, 'Kushtiya', 18, 1),
(368, 'Lakshmipur', 18, 1),
(369, 'Lalmanir Hat', 18, 1),
(370, 'Madaripur', 18, 1),
(371, 'Magura', 18, 1),
(372, 'Maimansingh', 18, 1),
(373, 'Manikganj', 18, 1),
(374, 'Maulvi Bazar', 18, 1),
(375, 'Meherpur', 18, 1),
(376, 'Munshiganj', 18, 1),
(377, 'Naral', 18, 1),
(378, 'Narayanganj', 18, 1),
(379, 'Narsingdi', 18, 1),
(380, 'Nator', 18, 1),
(381, 'Naugaon', 18, 1),
(382, 'Nawabganj', 18, 1),
(383, 'Netrakona', 18, 1),
(384, 'Nilphamari', 18, 1),
(385, 'Noakhali', 18, 1),
(386, 'Pabna', 18, 1),
(387, 'Panchagarh', 18, 1),
(388, 'Patuakhali', 18, 1),
(389, 'Pirojpur', 18, 1),
(390, 'Rajbari', 18, 1),
(391, 'Rajshahi', 18, 1),
(392, 'Rangamati', 18, 1),
(393, 'Rangpur', 18, 1),
(394, 'Satkhira', 18, 1),
(395, 'Shariatpur', 18, 1),
(396, 'Sherpur', 18, 1),
(397, 'Silhat', 18, 1),
(398, 'Sirajganj', 18, 1),
(399, 'Sunamganj', 18, 1),
(400, 'Tangayal', 18, 1),
(401, 'Thakurgaon', 18, 1),
(402, 'Christ Church', 19, 1),
(403, 'Saint Andrew', 19, 1),
(404, 'Saint George', 19, 1),
(405, 'Saint James', 19, 1),
(406, 'Saint John', 19, 1),
(407, 'Saint Joseph', 19, 1),
(408, 'Saint Lucy', 19, 1),
(409, 'Saint Michael', 19, 1),
(410, 'Saint Peter', 19, 1),
(411, 'Saint Philip', 19, 1),
(412, 'Saint Thomas', 19, 1),
(413, 'Brest', 20, 1),
(414, 'Homjel\'', 20, 1),
(415, 'Hrodna', 20, 1),
(416, 'Mahiljow', 20, 1),
(417, 'Mahilyowskaya Voblasts', 20, 1),
(418, 'Minsk', 20, 1),
(419, 'Minskaja Voblasts\'', 20, 1),
(420, 'Petrik', 20, 1),
(421, 'Vicebsk', 20, 1),
(422, 'Antwerpen', 21, 1),
(423, 'Berchem', 21, 1),
(424, 'Brabant', 21, 1),
(425, 'Brabant Wallon', 21, 1),
(426, 'Brussel', 21, 1),
(427, 'East Flanders', 21, 1),
(428, 'Hainaut', 21, 1),
(429, 'Liege', 21, 1),
(430, 'Limburg', 21, 1),
(431, 'Luxembourg', 21, 1),
(432, 'Namur', 21, 1),
(433, 'Ontario', 21, 1),
(434, 'Oost-Vlaanderen', 21, 1),
(435, 'Provincie Brabant', 21, 1),
(436, 'Vlaams-Brabant', 21, 1),
(437, 'Wallonne', 21, 1),
(438, 'West-Vlaanderen', 21, 1),
(439, 'Belize', 22, 1),
(440, 'Cayo', 22, 1),
(441, 'Corozal', 22, 1),
(442, 'Orange Walk', 22, 1),
(443, 'Stann Creek', 22, 1),
(444, 'Toledo', 22, 1),
(445, 'Alibori', 23, 1),
(446, 'Atacora', 23, 1),
(447, 'Atlantique', 23, 1),
(448, 'Borgou', 23, 1),
(449, 'Collines', 23, 1),
(450, 'Couffo', 23, 1),
(451, 'Donga', 23, 1),
(452, 'Littoral', 23, 1),
(453, 'Mono', 23, 1),
(454, 'Oueme', 23, 1),
(455, 'Plateau', 23, 1),
(456, 'Zou', 23, 1),
(457, 'Hamilton', 24, 1),
(458, 'Saint George', 24, 1),
(459, 'Bumthang', 25, 1),
(460, 'Chhukha', 25, 1),
(461, 'Chirang', 25, 1),
(462, 'Daga', 25, 1),
(463, 'Geylegphug', 25, 1),
(464, 'Ha', 25, 1),
(465, 'Lhuntshi', 25, 1),
(466, 'Mongar', 25, 1),
(467, 'Pemagatsel', 25, 1),
(468, 'Punakha', 25, 1),
(469, 'Rinpung', 25, 1),
(470, 'Samchi', 25, 1),
(471, 'Samdrup Jongkhar', 25, 1),
(472, 'Shemgang', 25, 1),
(473, 'Tashigang', 25, 1),
(474, 'Timphu', 25, 1),
(475, 'Tongsa', 25, 1),
(476, 'Wangdiphodrang', 25, 1),
(477, 'Beni', 26, 1),
(478, 'Chuquisaca', 26, 1),
(479, 'Cochabamba', 26, 1),
(480, 'La Paz', 26, 1),
(481, 'Oruro', 26, 1),
(482, 'Pando', 26, 1),
(483, 'Potosi', 26, 1),
(484, 'Santa Cruz', 26, 1),
(485, 'Tarija', 26, 1),
(486, 'Federacija Bosna i Hercegovina', 27, 1),
(487, 'Republika Srpska', 27, 1),
(488, 'Central Bobonong', 28, 1),
(489, 'Central Boteti', 28, 1),
(490, 'Central Mahalapye', 28, 1),
(491, 'Central Serowe-Palapye', 28, 1),
(492, 'Central Tutume', 28, 1),
(493, 'Chobe', 28, 1),
(494, 'Francistown', 28, 1),
(495, 'Gaborone', 28, 1),
(496, 'Ghanzi', 28, 1),
(497, 'Jwaneng', 28, 1),
(498, 'Kgalagadi North', 28, 1),
(499, 'Kgalagadi South', 28, 1),
(500, 'Kgatleng', 28, 1),
(501, 'Kweneng', 28, 1),
(502, 'Lobatse', 28, 1),
(503, 'Ngamiland', 28, 1),
(504, 'Ngwaketse', 28, 1),
(505, 'North East', 28, 1),
(506, 'Okavango', 28, 1),
(507, 'Orapa', 28, 1),
(508, 'Selibe Phikwe', 28, 1),
(509, 'South East', 28, 1),
(510, 'Sowa', 28, 1),
(511, 'Bouvet Island', 29, 1),
(512, 'Acre', 30, 1),
(513, 'Alagoas', 30, 1),
(514, 'Amapa', 30, 1),
(515, 'Amazonas', 30, 1),
(516, 'Bahia', 30, 1),
(517, 'Ceara', 30, 1),
(518, 'Distrito Federal', 30, 1),
(519, 'Espirito Santo', 30, 1),
(520, 'Estado de Sao Paulo', 30, 1),
(521, 'Goias', 30, 1),
(522, 'Maranhao', 30, 1),
(523, 'Mato Grosso', 30, 1),
(524, 'Mato Grosso do Sul', 30, 1),
(525, 'Minas Gerais', 30, 1),
(526, 'Para', 30, 1),
(527, 'Paraiba', 30, 1),
(528, 'Parana', 30, 1),
(529, 'Pernambuco', 30, 1),
(530, 'Piaui', 30, 1),
(531, 'Rio Grande do Norte', 30, 1),
(532, 'Rio Grande do Sul', 30, 1),
(533, 'Rio de Janeiro', 30, 1),
(534, 'Rondonia', 30, 1),
(535, 'Roraima', 30, 1),
(536, 'Santa Catarina', 30, 1),
(537, 'Sao Paulo', 30, 1),
(538, 'Sergipe', 30, 1),
(539, 'Tocantins', 30, 1),
(540, 'British Indian Ocean Territory', 31, 1),
(541, 'Belait', 32, 1),
(542, 'Brunei-Muara', 32, 1),
(543, 'Temburong', 32, 1),
(544, 'Tutong', 32, 1),
(545, 'Blagoevgrad', 33, 1),
(546, 'Burgas', 33, 1),
(547, 'Dobrich', 33, 1),
(548, 'Gabrovo', 33, 1),
(549, 'Haskovo', 33, 1),
(550, 'Jambol', 33, 1),
(551, 'Kardzhali', 33, 1),
(552, 'Kjustendil', 33, 1),
(553, 'Lovech', 33, 1),
(554, 'Montana', 33, 1),
(555, 'Oblast Sofiya-Grad', 33, 1),
(556, 'Pazardzhik', 33, 1),
(557, 'Pernik', 33, 1),
(558, 'Pleven', 33, 1),
(559, 'Plovdiv', 33, 1),
(560, 'Razgrad', 33, 1),
(561, 'Ruse', 33, 1),
(562, 'Shumen', 33, 1),
(563, 'Silistra', 33, 1),
(564, 'Sliven', 33, 1),
(565, 'Smoljan', 33, 1),
(566, 'Sofija grad', 33, 1),
(567, 'Sofijska oblast', 33, 1),
(568, 'Stara Zagora', 33, 1),
(569, 'Targovishte', 33, 1),
(570, 'Varna', 33, 1),
(571, 'Veliko Tarnovo', 33, 1),
(572, 'Vidin', 33, 1),
(573, 'Vraca', 33, 1),
(574, 'Yablaniza', 33, 1),
(575, 'Bale', 34, 1),
(576, 'Bam', 34, 1),
(577, 'Bazega', 34, 1),
(578, 'Bougouriba', 34, 1),
(579, 'Boulgou', 34, 1),
(580, 'Boulkiemde', 34, 1),
(581, 'Comoe', 34, 1),
(582, 'Ganzourgou', 34, 1),
(583, 'Gnagna', 34, 1),
(584, 'Gourma', 34, 1),
(585, 'Houet', 34, 1),
(586, 'Ioba', 34, 1),
(587, 'Kadiogo', 34, 1),
(588, 'Kenedougou', 34, 1),
(589, 'Komandjari', 34, 1),
(590, 'Kompienga', 34, 1),
(591, 'Kossi', 34, 1),
(592, 'Kouritenga', 34, 1),
(593, 'Kourweogo', 34, 1),
(594, 'Leraba', 34, 1),
(595, 'Mouhoun', 34, 1),
(596, 'Nahouri', 34, 1),
(597, 'Namentenga', 34, 1),
(598, 'Noumbiel', 34, 1),
(599, 'Oubritenga', 34, 1),
(600, 'Oudalan', 34, 1),
(601, 'Passore', 34, 1),
(602, 'Poni', 34, 1),
(603, 'Sanguie', 34, 1),
(604, 'Sanmatenga', 34, 1),
(605, 'Seno', 34, 1),
(606, 'Sissili', 34, 1),
(607, 'Soum', 34, 1),
(608, 'Sourou', 34, 1),
(609, 'Tapoa', 34, 1),
(610, 'Tuy', 34, 1),
(611, 'Yatenga', 34, 1),
(612, 'Zondoma', 34, 1),
(613, 'Zoundweogo', 34, 1),
(614, 'Bubanza', 35, 1),
(615, 'Bujumbura', 35, 1),
(616, 'Bururi', 35, 1),
(617, 'Cankuzo', 35, 1),
(618, 'Cibitoke', 35, 1),
(619, 'Gitega', 35, 1),
(620, 'Karuzi', 35, 1),
(621, 'Kayanza', 35, 1),
(622, 'Kirundo', 35, 1),
(623, 'Makamba', 35, 1),
(624, 'Muramvya', 35, 1),
(625, 'Muyinga', 35, 1),
(626, 'Ngozi', 35, 1),
(627, 'Rutana', 35, 1),
(628, 'Ruyigi', 35, 1),
(629, 'Banteay Mean Chey', 36, 1),
(630, 'Bat Dambang', 36, 1),
(631, 'Kampong Cham', 36, 1),
(632, 'Kampong Chhnang', 36, 1),
(633, 'Kampong Spoeu', 36, 1),
(634, 'Kampong Thum', 36, 1),
(635, 'Kampot', 36, 1),
(636, 'Kandal', 36, 1),
(637, 'Kaoh Kong', 36, 1),
(638, 'Kracheh', 36, 1),
(639, 'Krong Kaeb', 36, 1),
(640, 'Krong Pailin', 36, 1),
(641, 'Krong Preah Sihanouk', 36, 1),
(642, 'Mondol Kiri', 36, 1),
(643, 'Otdar Mean Chey', 36, 1),
(644, 'Phnum Penh', 36, 1),
(645, 'Pousat', 36, 1),
(646, 'Preah Vihear', 36, 1),
(647, 'Prey Veaeng', 36, 1),
(648, 'Rotanak Kiri', 36, 1),
(649, 'Siem Reab', 36, 1),
(650, 'Stueng Traeng', 36, 1),
(651, 'Svay Rieng', 36, 1),
(652, 'Takaev', 36, 1),
(653, 'Adamaoua', 37, 1),
(654, 'Centre', 37, 1),
(655, 'Est', 37, 1),
(656, 'Littoral', 37, 1),
(657, 'Nord', 37, 1),
(658, 'Nord Extreme', 37, 1),
(659, 'Nordouest', 37, 1),
(660, 'Ouest', 37, 1),
(661, 'Sud', 37, 1),
(662, 'Sudouest', 37, 1),
(663, 'Alberta', 38, 1),
(664, 'British Columbia', 38, 1),
(665, 'Manitoba', 38, 1),
(666, 'New Brunswick', 38, 1),
(667, 'Newfoundland and Labrador', 38, 1),
(668, 'Northwest Territories', 38, 1),
(669, 'Nova Scotia', 38, 1),
(670, 'Nunavut', 38, 1),
(671, 'Ontario', 38, 1),
(672, 'Prince Edward Island', 38, 1),
(673, 'Quebec', 38, 1),
(674, 'Saskatchewan', 38, 1),
(675, 'Yukon', 38, 1),
(676, 'Boavista', 39, 1),
(677, 'Brava', 39, 1),
(678, 'Fogo', 39, 1),
(679, 'Maio', 39, 1),
(680, 'Sal', 39, 1),
(681, 'Santo Antao', 39, 1),
(682, 'Sao Nicolau', 39, 1),
(683, 'Sao Tiago', 39, 1),
(684, 'Sao Vicente', 39, 1),
(685, 'Grand Cayman', 40, 1),
(686, 'Bamingui-Bangoran', 41, 1),
(687, 'Bangui', 41, 1),
(688, 'Basse-Kotto', 41, 1),
(689, 'Haut-Mbomou', 41, 1),
(690, 'Haute-Kotto', 41, 1),
(691, 'Kemo', 41, 1),
(692, 'Lobaye', 41, 1),
(693, 'Mambere-Kadei', 41, 1),
(694, 'Mbomou', 41, 1),
(695, 'Nana-Gribizi', 41, 1),
(696, 'Nana-Mambere', 41, 1),
(697, 'Ombella Mpoko', 41, 1),
(698, 'Ouaka', 41, 1),
(699, 'Ouham', 41, 1),
(700, 'Ouham-Pende', 41, 1),
(701, 'Sangha-Mbaere', 41, 1),
(702, 'Vakaga', 41, 1),
(703, 'Batha', 42, 1),
(704, 'Biltine', 42, 1),
(705, 'Bourkou-Ennedi-Tibesti', 42, 1),
(706, 'Chari-Baguirmi', 42, 1),
(707, 'Guera', 42, 1),
(708, 'Kanem', 42, 1),
(709, 'Lac', 42, 1),
(710, 'Logone Occidental', 42, 1),
(711, 'Logone Oriental', 42, 1),
(712, 'Mayo-Kebbi', 42, 1),
(713, 'Moyen-Chari', 42, 1),
(714, 'Ouaddai', 42, 1),
(715, 'Salamat', 42, 1),
(716, 'Tandjile', 42, 1),
(717, 'Aisen', 43, 1),
(718, 'Antofagasta', 43, 1),
(719, 'Araucania', 43, 1),
(720, 'Atacama', 43, 1),
(721, 'Bio Bio', 43, 1),
(722, 'Coquimbo', 43, 1),
(723, 'Libertador General Bernardo O\'', 43, 1),
(724, 'Los Lagos', 43, 1),
(725, 'Magellanes', 43, 1),
(726, 'Maule', 43, 1),
(727, 'Metropolitana', 43, 1),
(728, 'Metropolitana de Santiago', 43, 1),
(729, 'Tarapaca', 43, 1),
(730, 'Valparaiso', 43, 1),
(731, 'Anhui', 44, 1),
(732, 'Anhui Province', 44, 1),
(733, 'Anhui Sheng', 44, 1),
(734, 'Aomen', 44, 1),
(735, 'Beijing', 44, 1),
(736, 'Beijing Shi', 44, 1),
(737, 'Chongqing', 44, 1),
(738, 'Fujian', 44, 1),
(739, 'Fujian Sheng', 44, 1),
(740, 'Gansu', 44, 1),
(741, 'Guangdong', 44, 1),
(742, 'Guangdong Sheng', 44, 1),
(743, 'Guangxi', 44, 1),
(744, 'Guizhou', 44, 1),
(745, 'Hainan', 44, 1),
(746, 'Hebei', 44, 1),
(747, 'Heilongjiang', 44, 1),
(748, 'Henan', 44, 1),
(749, 'Hubei', 44, 1),
(750, 'Hunan', 44, 1),
(751, 'Jiangsu', 44, 1),
(752, 'Jiangsu Sheng', 44, 1),
(753, 'Jiangxi', 44, 1),
(754, 'Jilin', 44, 1),
(755, 'Liaoning', 44, 1),
(756, 'Liaoning Sheng', 44, 1),
(757, 'Nei Monggol', 44, 1),
(758, 'Ningxia Hui', 44, 1),
(759, 'Qinghai', 44, 1),
(760, 'Shaanxi', 44, 1),
(761, 'Shandong', 44, 1),
(762, 'Shandong Sheng', 44, 1),
(763, 'Shanghai', 44, 1),
(764, 'Shanxi', 44, 1),
(765, 'Sichuan', 44, 1),
(766, 'Tianjin', 44, 1),
(767, 'Xianggang', 44, 1),
(768, 'Xinjiang', 44, 1),
(769, 'Xizang', 44, 1),
(770, 'Yunnan', 44, 1),
(771, 'Zhejiang', 44, 1),
(772, 'Zhejiang Sheng', 44, 1),
(773, 'Christmas Island', 45, 1),
(774, 'Cocos (Keeling) Islands', 46, 1),
(775, 'Amazonas', 47, 1),
(776, 'Antioquia', 47, 1),
(777, 'Arauca', 47, 1),
(778, 'Atlantico', 47, 1),
(779, 'Bogota', 47, 1),
(780, 'Bolivar', 47, 1),
(781, 'Boyaca', 47, 1),
(782, 'Caldas', 47, 1),
(783, 'Caqueta', 47, 1),
(784, 'Casanare', 47, 1),
(785, 'Cauca', 47, 1),
(786, 'Cesar', 47, 1),
(787, 'Choco', 47, 1),
(788, 'Cordoba', 47, 1),
(789, 'Cundinamarca', 47, 1),
(790, 'Guainia', 47, 1),
(791, 'Guaviare', 47, 1),
(792, 'Huila', 47, 1),
(793, 'La Guajira', 47, 1),
(794, 'Magdalena', 47, 1),
(795, 'Meta', 47, 1),
(796, 'Narino', 47, 1),
(797, 'Norte de Santander', 47, 1),
(798, 'Putumayo', 47, 1),
(799, 'Quindio', 47, 1),
(800, 'Risaralda', 47, 1),
(801, 'San Andres y Providencia', 47, 1),
(802, 'Santander', 47, 1),
(803, 'Sucre', 47, 1),
(804, 'Tolima', 47, 1),
(805, 'Valle del Cauca', 47, 1),
(806, 'Vaupes', 47, 1),
(807, 'Vichada', 47, 1),
(808, 'Mwali', 48, 1),
(809, 'Njazidja', 48, 1),
(810, 'Nzwani', 48, 1),
(811, 'Bouenza', 49, 1),
(812, 'Brazzaville', 49, 1),
(813, 'Cuvette', 49, 1),
(814, 'Kouilou', 49, 1),
(815, 'Lekoumou', 49, 1),
(816, 'Likouala', 49, 1),
(817, 'Niari', 49, 1),
(818, 'Plateaux', 49, 1),
(819, 'Pool', 49, 1),
(820, 'Sangha', 49, 1),
(821, 'Bandundu', 50, 1),
(822, 'Bas-Congo', 50, 1),
(823, 'Equateur', 50, 1),
(824, 'Haut-Congo', 50, 1),
(825, 'Kasai-Occidental', 50, 1),
(826, 'Kasai-Oriental', 50, 1),
(827, 'Katanga', 50, 1),
(828, 'Kinshasa', 50, 1),
(829, 'Maniema', 50, 1),
(830, 'Nord-Kivu', 50, 1),
(831, 'Sud-Kivu', 50, 1),
(832, 'Aitutaki', 51, 1),
(833, 'Atiu', 51, 1),
(834, 'Mangaia', 51, 1),
(835, 'Manihiki', 51, 1),
(836, 'Mauke', 51, 1),
(837, 'Mitiaro', 51, 1),
(838, 'Nassau', 51, 1),
(839, 'Pukapuka', 51, 1),
(840, 'Rakahanga', 51, 1),
(841, 'Rarotonga', 51, 1),
(842, 'Tongareva', 51, 1),
(843, 'Alajuela', 52, 1),
(844, 'Cartago', 52, 1),
(845, 'Guanacaste', 52, 1),
(846, 'Heredia', 52, 1),
(847, 'Limon', 52, 1),
(848, 'Puntarenas', 52, 1),
(849, 'San Jose', 52, 1),
(850, 'Abidjan', 53, 1),
(851, 'Agneby', 53, 1),
(852, 'Bafing', 53, 1),
(853, 'Denguele', 53, 1),
(854, 'Dix-huit Montagnes', 53, 1),
(855, 'Fromager', 53, 1),
(856, 'Haut-Sassandra', 53, 1),
(857, 'Lacs', 53, 1),
(858, 'Lagunes', 53, 1),
(859, 'Marahoue', 53, 1),
(860, 'Moyen-Cavally', 53, 1),
(861, 'Moyen-Comoe', 53, 1),
(862, 'N\'zi-Comoe', 53, 1),
(863, 'Sassandra', 53, 1),
(864, 'Savanes', 53, 1),
(865, 'Sud-Bandama', 53, 1),
(866, 'Sud-Comoe', 53, 1),
(867, 'Vallee du Bandama', 53, 1),
(868, 'Worodougou', 53, 1),
(869, 'Zanzan', 53, 1),
(870, 'Bjelovar-Bilogora', 54, 1),
(871, 'Dubrovnik-Neretva', 54, 1),
(872, 'Grad Zagreb', 54, 1),
(873, 'Istra', 54, 1),
(874, 'Karlovac', 54, 1),
(875, 'Koprivnica-Krizhevci', 54, 1),
(876, 'Krapina-Zagorje', 54, 1),
(877, 'Lika-Senj', 54, 1),
(878, 'Medhimurje', 54, 1),
(879, 'Medimurska Zupanija', 54, 1),
(880, 'Osijek-Baranja', 54, 1),
(881, 'Osjecko-Baranjska Zupanija', 54, 1),
(882, 'Pozhega-Slavonija', 54, 1),
(883, 'Primorje-Gorski Kotar', 54, 1),
(884, 'Shibenik-Knin', 54, 1),
(885, 'Sisak-Moslavina', 54, 1),
(886, 'Slavonski Brod-Posavina', 54, 1),
(887, 'Split-Dalmacija', 54, 1),
(888, 'Varazhdin', 54, 1),
(889, 'Virovitica-Podravina', 54, 1),
(890, 'Vukovar-Srijem', 54, 1),
(891, 'Zadar', 54, 1),
(892, 'Zagreb', 54, 1),
(893, 'Camaguey', 55, 1),
(894, 'Ciego de Avila', 55, 1),
(895, 'Cienfuegos', 55, 1),
(896, 'Ciudad de la Habana', 55, 1),
(897, 'Granma', 55, 1),
(898, 'Guantanamo', 55, 1),
(899, 'Habana', 55, 1),
(900, 'Holguin', 55, 1),
(901, 'Isla de la Juventud', 55, 1),
(902, 'La Habana', 55, 1),
(903, 'Las Tunas', 55, 1),
(904, 'Matanzas', 55, 1),
(905, 'Pinar del Rio', 55, 1),
(906, 'Sancti Spiritus', 55, 1),
(907, 'Santiago de Cuba', 55, 1),
(908, 'Villa Clara', 55, 1),
(909, 'Government controlled area', 56, 1),
(910, 'Limassol', 56, 1),
(911, 'Nicosia District', 56, 1),
(912, 'Paphos', 56, 1),
(913, 'Turkish controlled area', 56, 1),
(914, 'Central Bohemian', 57, 1),
(915, 'Frycovice', 57, 1),
(916, 'Jihocesky Kraj', 57, 1),
(917, 'Jihochesky', 57, 1),
(918, 'Jihomoravsky', 57, 1),
(919, 'Karlovarsky', 57, 1),
(920, 'Klecany', 57, 1),
(921, 'Kralovehradecky', 57, 1),
(922, 'Liberecky', 57, 1),
(923, 'Lipov', 57, 1),
(924, 'Moravskoslezsky', 57, 1),
(925, 'Olomoucky', 57, 1),
(926, 'Olomoucky Kraj', 57, 1),
(927, 'Pardubicky', 57, 1),
(928, 'Plzensky', 57, 1),
(929, 'Praha', 57, 1),
(930, 'Rajhrad', 57, 1),
(931, 'Smirice', 57, 1),
(932, 'South Moravian', 57, 1),
(933, 'Straz nad Nisou', 57, 1),
(934, 'Stredochesky', 57, 1),
(935, 'Unicov', 57, 1),
(936, 'Ustecky', 57, 1),
(937, 'Valletta', 57, 1),
(938, 'Velesin', 57, 1),
(939, 'Vysochina', 57, 1),
(940, 'Zlinsky', 57, 1),
(941, 'Arhus', 58, 1),
(942, 'Bornholm', 58, 1),
(943, 'Frederiksborg', 58, 1),
(944, 'Fyn', 58, 1),
(945, 'Hovedstaden', 58, 1),
(946, 'Kobenhavn', 58, 1),
(947, 'Kobenhavns Amt', 58, 1),
(948, 'Kobenhavns Kommune', 58, 1),
(949, 'Nordjylland', 58, 1),
(950, 'Ribe', 58, 1),
(951, 'Ringkobing', 58, 1),
(952, 'Roervig', 58, 1),
(953, 'Roskilde', 58, 1),
(954, 'Roslev', 58, 1),
(955, 'Sjaelland', 58, 1),
(956, 'Soeborg', 58, 1),
(957, 'Sonderjylland', 58, 1),
(958, 'Storstrom', 58, 1),
(959, 'Syddanmark', 58, 1),
(960, 'Toelloese', 58, 1),
(961, 'Vejle', 58, 1),
(962, 'Vestsjalland', 58, 1),
(963, 'Viborg', 58, 1),
(964, '\'Ali Sabih', 59, 1),
(965, 'Dikhil', 59, 1),
(966, 'Jibuti', 59, 1),
(967, 'Tajurah', 59, 1),
(968, 'Ubuk', 59, 1),
(969, 'Saint Andrew', 60, 1),
(970, 'Saint David', 60, 1),
(971, 'Saint George', 60, 1),
(972, 'Saint John', 60, 1),
(973, 'Saint Joseph', 60, 1),
(974, 'Saint Luke', 60, 1),
(975, 'Saint Mark', 60, 1),
(976, 'Saint Patrick', 60, 1),
(977, 'Saint Paul', 60, 1),
(978, 'Saint Peter', 60, 1),
(979, 'Azua', 61, 1),
(980, 'Bahoruco', 61, 1),
(981, 'Barahona', 61, 1),
(982, 'Dajabon', 61, 1),
(983, 'Distrito Nacional', 61, 1),
(984, 'Duarte', 61, 1),
(985, 'El Seybo', 61, 1),
(986, 'Elias Pina', 61, 1),
(987, 'Espaillat', 61, 1),
(988, 'Hato Mayor', 61, 1),
(989, 'Independencia', 61, 1),
(990, 'La Altagracia', 61, 1),
(991, 'La Romana', 61, 1),
(992, 'La Vega', 61, 1),
(993, 'Maria Trinidad Sanchez', 61, 1),
(994, 'Monsenor Nouel', 61, 1),
(995, 'Monte Cristi', 61, 1),
(996, 'Monte Plata', 61, 1),
(997, 'Pedernales', 61, 1),
(998, 'Peravia', 61, 1),
(999, 'Puerto Plata', 61, 1),
(1000, 'Salcedo', 61, 1),
(1001, 'Samana', 61, 1),
(1002, 'San Cristobal', 61, 1),
(1003, 'San Juan', 61, 1),
(1004, 'San Pedro de Macoris', 61, 1),
(1005, 'Sanchez Ramirez', 61, 1),
(1006, 'Santiago', 61, 1),
(1007, 'Santiago Rodriguez', 61, 1),
(1008, 'Valverde', 61, 1),
(1009, 'Aileu', 62, 1),
(1010, 'Ainaro', 62, 1),
(1011, 'Ambeno', 62, 1),
(1012, 'Baucau', 62, 1),
(1013, 'Bobonaro', 62, 1),
(1014, 'Cova Lima', 62, 1),
(1015, 'Dili', 62, 1),
(1016, 'Ermera', 62, 1),
(1017, 'Lautem', 62, 1),
(1018, 'Liquica', 62, 1),
(1019, 'Manatuto', 62, 1),
(1020, 'Manufahi', 62, 1),
(1021, 'Viqueque', 62, 1),
(1022, 'Azuay', 63, 1),
(1023, 'Bolivar', 63, 1),
(1024, 'Canar', 63, 1),
(1025, 'Carchi', 63, 1),
(1026, 'Chimborazo', 63, 1),
(1027, 'Cotopaxi', 63, 1),
(1028, 'El Oro', 63, 1),
(1029, 'Esmeraldas', 63, 1),
(1030, 'Galapagos', 63, 1),
(1031, 'Guayas', 63, 1),
(1032, 'Imbabura', 63, 1),
(1033, 'Loja', 63, 1),
(1034, 'Los Rios', 63, 1),
(1035, 'Manabi', 63, 1),
(1036, 'Morona Santiago', 63, 1),
(1037, 'Napo', 63, 1),
(1038, 'Orellana', 63, 1),
(1039, 'Pastaza', 63, 1),
(1040, 'Pichincha', 63, 1),
(1041, 'Sucumbios', 63, 1),
(1042, 'Tungurahua', 63, 1),
(1043, 'Zamora Chinchipe', 63, 1),
(1044, 'Aswan', 64, 1),
(1045, 'Asyut', 64, 1),
(1046, 'Bani Suwayf', 64, 1),
(1047, 'Bur Sa\'id', 64, 1),
(1048, 'Cairo', 64, 1),
(1049, 'Dumyat', 64, 1),
(1050, 'Kafr-ash-Shaykh', 64, 1),
(1051, 'Matruh', 64, 1),
(1052, 'Muhafazat ad Daqahliyah', 64, 1),
(1053, 'Muhafazat al Fayyum', 64, 1),
(1054, 'Muhafazat al Gharbiyah', 64, 1),
(1055, 'Muhafazat al Iskandariyah', 64, 1),
(1056, 'Muhafazat al Qahirah', 64, 1),
(1057, 'Qina', 64, 1),
(1058, 'Sawhaj', 64, 1),
(1059, 'Sina al-Janubiyah', 64, 1),
(1060, 'Sina ash-Shamaliyah', 64, 1),
(1061, 'ad-Daqahliyah', 64, 1),
(1062, 'al-Bahr-al-Ahmar', 64, 1),
(1063, 'al-Buhayrah', 64, 1),
(1064, 'al-Fayyum', 64, 1),
(1065, 'al-Gharbiyah', 64, 1),
(1066, 'al-Iskandariyah', 64, 1),
(1067, 'al-Ismailiyah', 64, 1),
(1068, 'al-Jizah', 64, 1),
(1069, 'al-Minufiyah', 64, 1),
(1070, 'al-Minya', 64, 1),
(1071, 'al-Qahira', 64, 1),
(1072, 'al-Qalyubiyah', 64, 1),
(1073, 'al-Uqsur', 64, 1),
(1074, 'al-Wadi al-Jadid', 64, 1),
(1075, 'as-Suways', 64, 1),
(1076, 'ash-Sharqiyah', 64, 1),
(1077, 'Ahuachapan', 65, 1),
(1078, 'Cabanas', 65, 1),
(1079, 'Chalatenango', 65, 1),
(1080, 'Cuscatlan', 65, 1),
(1081, 'La Libertad', 65, 1),
(1082, 'La Paz', 65, 1),
(1083, 'La Union', 65, 1),
(1084, 'Morazan', 65, 1),
(1085, 'San Miguel', 65, 1),
(1086, 'San Salvador', 65, 1),
(1087, 'San Vicente', 65, 1),
(1088, 'Santa Ana', 65, 1),
(1089, 'Sonsonate', 65, 1),
(1090, 'Usulutan', 65, 1),
(1091, 'Annobon', 66, 1),
(1092, 'Bioko Norte', 66, 1),
(1093, 'Bioko Sur', 66, 1),
(1094, 'Centro Sur', 66, 1),
(1095, 'Kie-Ntem', 66, 1),
(1096, 'Litoral', 66, 1),
(1097, 'Wele-Nzas', 66, 1),
(1098, 'Anseba', 67, 1),
(1099, 'Debub', 67, 1),
(1100, 'Debub-Keih-Bahri', 67, 1),
(1101, 'Gash-Barka', 67, 1),
(1102, 'Maekel', 67, 1),
(1103, 'Semien-Keih-Bahri', 67, 1),
(1104, 'Harju', 68, 1),
(1105, 'Hiiu', 68, 1),
(1106, 'Ida-Viru', 68, 1),
(1107, 'Jarva', 68, 1),
(1108, 'Jogeva', 68, 1),
(1109, 'Laane', 68, 1),
(1110, 'Laane-Viru', 68, 1),
(1111, 'Parnu', 68, 1),
(1112, 'Polva', 68, 1),
(1113, 'Rapla', 68, 1),
(1114, 'Saare', 68, 1),
(1115, 'Tartu', 68, 1),
(1116, 'Valga', 68, 1),
(1117, 'Viljandi', 68, 1),
(1118, 'Voru', 68, 1),
(1119, 'Addis Abeba', 69, 1),
(1120, 'Afar', 69, 1),
(1121, 'Amhara', 69, 1),
(1122, 'Benishangul', 69, 1),
(1123, 'Diredawa', 69, 1),
(1124, 'Gambella', 69, 1),
(1125, 'Harar', 69, 1),
(1126, 'Jigjiga', 69, 1),
(1127, 'Mekele', 69, 1),
(1128, 'Oromia', 69, 1),
(1129, 'Somali', 69, 1),
(1130, 'Southern', 69, 1),
(1131, 'Tigray', 69, 1),
(1132, 'Christmas Island', 70, 1),
(1133, 'Cocos Islands', 70, 1),
(1134, 'Coral Sea Islands', 70, 1),
(1135, 'Falkland Islands', 71, 1),
(1136, 'South Georgia', 71, 1),
(1137, 'Klaksvik', 72, 1),
(1138, 'Nor ara Eysturoy', 72, 1),
(1139, 'Nor oy', 72, 1),
(1140, 'Sandoy', 72, 1),
(1141, 'Streymoy', 72, 1),
(1142, 'Su uroy', 72, 1),
(1143, 'Sy ra Eysturoy', 72, 1),
(1144, 'Torshavn', 72, 1),
(1145, 'Vaga', 72, 1),
(1146, 'Central', 73, 1),
(1147, 'Eastern', 73, 1),
(1148, 'Northern', 73, 1),
(1149, 'South Pacific', 73, 1),
(1150, 'Western', 73, 1),
(1151, 'Ahvenanmaa', 74, 1),
(1152, 'Etela-Karjala', 74, 1),
(1153, 'Etela-Pohjanmaa', 74, 1),
(1154, 'Etela-Savo', 74, 1),
(1155, 'Etela-Suomen Laani', 74, 1),
(1156, 'Ita-Suomen Laani', 74, 1),
(1157, 'Ita-Uusimaa', 74, 1),
(1158, 'Kainuu', 74, 1),
(1159, 'Kanta-Hame', 74, 1),
(1160, 'Keski-Pohjanmaa', 74, 1),
(1161, 'Keski-Suomi', 74, 1),
(1162, 'Kymenlaakso', 74, 1),
(1163, 'Lansi-Suomen Laani', 74, 1),
(1164, 'Lappi', 74, 1),
(1165, 'Northern Savonia', 74, 1),
(1166, 'Ostrobothnia', 74, 1),
(1167, 'Oulun Laani', 74, 1),
(1168, 'Paijat-Hame', 74, 1),
(1169, 'Pirkanmaa', 74, 1),
(1170, 'Pohjanmaa', 74, 1),
(1171, 'Pohjois-Karjala', 74, 1),
(1172, 'Pohjois-Pohjanmaa', 74, 1),
(1173, 'Pohjois-Savo', 74, 1),
(1174, 'Saarijarvi', 74, 1),
(1175, 'Satakunta', 74, 1),
(1176, 'Southern Savonia', 74, 1),
(1177, 'Tavastia Proper', 74, 1),
(1178, 'Uleaborgs Lan', 74, 1),
(1179, 'Uusimaa', 74, 1),
(1180, 'Varsinais-Suomi', 74, 1),
(1181, 'Ain', 75, 1),
(1182, 'Aisne', 75, 1),
(1183, 'Albi Le Sequestre', 75, 1),
(1184, 'Allier', 75, 1),
(1185, 'Alpes-Cote dAzur', 75, 1),
(1186, 'Alpes-Maritimes', 75, 1),
(1187, 'Alpes-de-Haute-Provence', 75, 1),
(1188, 'Alsace', 75, 1),
(1189, 'Aquitaine', 75, 1),
(1190, 'Ardeche', 75, 1),
(1191, 'Ardennes', 75, 1),
(1192, 'Ariege', 75, 1),
(1193, 'Aube', 75, 1),
(1194, 'Aude', 75, 1),
(1195, 'Auvergne', 75, 1),
(1196, 'Aveyron', 75, 1),
(1197, 'Bas-Rhin', 75, 1),
(1198, 'Basse-Normandie', 75, 1),
(1199, 'Bouches-du-Rhone', 75, 1),
(1200, 'Bourgogne', 75, 1),
(1201, 'Bretagne', 75, 1),
(1202, 'Brittany', 75, 1),
(1203, 'Burgundy', 75, 1),
(1204, 'Calvados', 75, 1),
(1205, 'Cantal', 75, 1),
(1206, 'Cedex', 75, 1),
(1207, 'Centre', 75, 1),
(1208, 'Charente', 75, 1),
(1209, 'Charente-Maritime', 75, 1),
(1210, 'Cher', 75, 1),
(1211, 'Correze', 75, 1),
(1212, 'Corse-du-Sud', 75, 1),
(1213, 'Cote-d\'Or', 75, 1),
(1214, 'Cotes-d\'Armor', 75, 1),
(1215, 'Creuse', 75, 1),
(1216, 'Crolles', 75, 1),
(1217, 'Deux-Sevres', 75, 1),
(1218, 'Dordogne', 75, 1),
(1219, 'Doubs', 75, 1),
(1220, 'Drome', 75, 1),
(1221, 'Essonne', 75, 1),
(1222, 'Eure', 75, 1),
(1223, 'Eure-et-Loir', 75, 1),
(1224, 'Feucherolles', 75, 1),
(1225, 'Finistere', 75, 1),
(1226, 'Franche-Comte', 75, 1),
(1227, 'Gard', 75, 1),
(1228, 'Gers', 75, 1),
(1229, 'Gironde', 75, 1),
(1230, 'Haut-Rhin', 75, 1),
(1231, 'Haute-Corse', 75, 1),
(1232, 'Haute-Garonne', 75, 1),
(1233, 'Haute-Loire', 75, 1),
(1234, 'Haute-Marne', 75, 1),
(1235, 'Haute-Saone', 75, 1),
(1236, 'Haute-Savoie', 75, 1),
(1237, 'Haute-Vienne', 75, 1),
(1238, 'Hautes-Alpes', 75, 1),
(1239, 'Hautes-Pyrenees', 75, 1),
(1240, 'Hauts-de-Seine', 75, 1),
(1241, 'Herault', 75, 1),
(1242, 'Ile-de-France', 75, 1),
(1243, 'Ille-et-Vilaine', 75, 1),
(1244, 'Indre', 75, 1),
(1245, 'Indre-et-Loire', 75, 1),
(1246, 'Isere', 75, 1),
(1247, 'Jura', 75, 1),
(1248, 'Klagenfurt', 75, 1),
(1249, 'Landes', 75, 1),
(1250, 'Languedoc-Roussillon', 75, 1),
(1251, 'Larcay', 75, 1),
(1252, 'Le Castellet', 75, 1),
(1253, 'Le Creusot', 75, 1),
(1254, 'Limousin', 75, 1),
(1255, 'Loir-et-Cher', 75, 1),
(1256, 'Loire', 75, 1),
(1257, 'Loire-Atlantique', 75, 1),
(1258, 'Loiret', 75, 1),
(1259, 'Lorraine', 75, 1),
(1260, 'Lot', 75, 1),
(1261, 'Lot-et-Garonne', 75, 1),
(1262, 'Lower Normandy', 75, 1),
(1263, 'Lozere', 75, 1),
(1264, 'Maine-et-Loire', 75, 1),
(1265, 'Manche', 75, 1),
(1266, 'Marne', 75, 1),
(1267, 'Mayenne', 75, 1),
(1268, 'Meurthe-et-Moselle', 75, 1),
(1269, 'Meuse', 75, 1),
(1270, 'Midi-Pyrenees', 75, 1),
(1271, 'Morbihan', 75, 1),
(1272, 'Moselle', 75, 1),
(1273, 'Nievre', 75, 1),
(1274, 'Nord', 75, 1),
(1275, 'Nord-Pas-de-Calais', 75, 1),
(1276, 'Oise', 75, 1),
(1277, 'Orne', 75, 1),
(1278, 'Paris', 75, 1),
(1279, 'Pas-de-Calais', 75, 1),
(1280, 'Pays de la Loire', 75, 1),
(1281, 'Pays-de-la-Loire', 75, 1),
(1282, 'Picardy', 75, 1),
(1283, 'Puy-de-Dome', 75, 1),
(1284, 'Pyrenees-Atlantiques', 75, 1),
(1285, 'Pyrenees-Orientales', 75, 1),
(1286, 'Quelmes', 75, 1),
(1287, 'Rhone', 75, 1),
(1288, 'Rhone-Alpes', 75, 1),
(1289, 'Saint Ouen', 75, 1),
(1290, 'Saint Viatre', 75, 1),
(1291, 'Saone-et-Loire', 75, 1),
(1292, 'Sarthe', 75, 1),
(1293, 'Savoie', 75, 1),
(1294, 'Seine-Maritime', 75, 1),
(1295, 'Seine-Saint-Denis', 75, 1),
(1296, 'Seine-et-Marne', 75, 1),
(1297, 'Somme', 75, 1),
(1298, 'Sophia Antipolis', 75, 1),
(1299, 'Souvans', 75, 1),
(1300, 'Tarn', 75, 1),
(1301, 'Tarn-et-Garonne', 75, 1),
(1302, 'Territoire de Belfort', 75, 1),
(1303, 'Treignac', 75, 1),
(1304, 'Upper Normandy', 75, 1),
(1305, 'Val-d\'Oise', 75, 1),
(1306, 'Val-de-Marne', 75, 1),
(1307, 'Var', 75, 1),
(1308, 'Vaucluse', 75, 1),
(1309, 'Vellise', 75, 1),
(1310, 'Vendee', 75, 1),
(1311, 'Vienne', 75, 1),
(1312, 'Vosges', 75, 1),
(1313, 'Yonne', 75, 1),
(1314, 'Yvelines', 75, 1),
(1315, 'Cayenne', 76, 1),
(1316, 'Saint-Laurent-du-Maroni', 76, 1),
(1317, 'Iles du Vent', 77, 1),
(1318, 'Iles sous le Vent', 77, 1),
(1319, 'Marquesas', 77, 1),
(1320, 'Tuamotu', 77, 1),
(1321, 'Tubuai', 77, 1),
(1322, 'Amsterdam', 78, 1),
(1323, 'Crozet Islands', 78, 1),
(1324, 'Kerguelen', 78, 1),
(1325, 'Estuaire', 79, 1),
(1326, 'Haut-Ogooue', 79, 1),
(1327, 'Moyen-Ogooue', 79, 1),
(1328, 'Ngounie', 79, 1),
(1329, 'Nyanga', 79, 1),
(1330, 'Ogooue-Ivindo', 79, 1),
(1331, 'Ogooue-Lolo', 79, 1),
(1332, 'Ogooue-Maritime', 79, 1),
(1333, 'Woleu-Ntem', 79, 1),
(1334, 'Banjul', 80, 1),
(1335, 'Basse', 80, 1),
(1336, 'Brikama', 80, 1),
(1337, 'Janjanbureh', 80, 1),
(1338, 'Kanifing', 80, 1),
(1339, 'Kerewan', 80, 1),
(1340, 'Kuntaur', 80, 1),
(1341, 'Mansakonko', 80, 1),
(1342, 'Abhasia', 81, 1),
(1343, 'Ajaria', 81, 1),
(1344, 'Guria', 81, 1),
(1345, 'Imereti', 81, 1),
(1346, 'Kaheti', 81, 1),
(1347, 'Kvemo Kartli', 81, 1),
(1348, 'Mcheta-Mtianeti', 81, 1),
(1349, 'Racha', 81, 1),
(1350, 'Samagrelo-Zemo Svaneti', 81, 1),
(1351, 'Samche-Zhavaheti', 81, 1),
(1352, 'Shida Kartli', 81, 1),
(1353, 'Tbilisi', 81, 1),
(1354, 'Auvergne', 82, 1),
(1355, 'Baden-Wurttemberg', 82, 1),
(1356, 'Bavaria', 82, 1),
(1357, 'Bayern', 82, 1),
(1358, 'Beilstein Wurtt', 82, 1),
(1359, 'Berlin', 82, 1),
(1360, 'Brandenburg', 82, 1),
(1361, 'Bremen', 82, 1),
(1362, 'Dreisbach', 82, 1),
(1363, 'Freistaat Bayern', 82, 1),
(1364, 'Hamburg', 82, 1),
(1365, 'Hannover', 82, 1),
(1366, 'Heroldstatt', 82, 1),
(1367, 'Hessen', 82, 1),
(1368, 'Kortenberg', 82, 1),
(1369, 'Laasdorf', 82, 1),
(1370, 'Land Baden-Wurttemberg', 82, 1),
(1371, 'Land Bayern', 82, 1),
(1372, 'Land Brandenburg', 82, 1),
(1373, 'Land Hessen', 82, 1),
(1374, 'Land Mecklenburg-Vorpommern', 82, 1),
(1375, 'Land Nordrhein-Westfalen', 82, 1),
(1376, 'Land Rheinland-Pfalz', 82, 1),
(1377, 'Land Sachsen', 82, 1),
(1378, 'Land Sachsen-Anhalt', 82, 1),
(1379, 'Land Thuringen', 82, 1),
(1380, 'Lower Saxony', 82, 1),
(1381, 'Mecklenburg-Vorpommern', 82, 1),
(1382, 'Mulfingen', 82, 1),
(1383, 'Munich', 82, 1),
(1384, 'Neubeuern', 82, 1),
(1385, 'Niedersachsen', 82, 1),
(1386, 'Noord-Holland', 82, 1),
(1387, 'Nordrhein-Westfalen', 82, 1),
(1388, 'North Rhine-Westphalia', 82, 1),
(1389, 'Osterode', 82, 1),
(1390, 'Rheinland-Pfalz', 82, 1),
(1391, 'Rhineland-Palatinate', 82, 1),
(1392, 'Saarland', 82, 1),
(1393, 'Sachsen', 82, 1),
(1394, 'Sachsen-Anhalt', 82, 1),
(1395, 'Saxony', 82, 1),
(1396, 'Schleswig-Holstein', 82, 1),
(1397, 'Thuringia', 82, 1),
(1398, 'Webling', 82, 1),
(1399, 'Weinstrabe', 82, 1),
(1400, 'schlobborn', 82, 1),
(1401, 'Ashanti', 83, 1),
(1402, 'Brong-Ahafo', 83, 1),
(1403, 'Central', 83, 1),
(1404, 'Eastern', 83, 1),
(1405, 'Greater Accra', 83, 1),
(1406, 'Northern', 83, 1),
(1407, 'Upper East', 83, 1),
(1408, 'Upper West', 83, 1),
(1409, 'Volta', 83, 1),
(1410, 'Western', 83, 1),
(1411, 'Gibraltar', 84, 1),
(1412, 'Acharnes', 85, 1),
(1413, 'Ahaia', 85, 1),
(1414, 'Aitolia kai Akarnania', 85, 1),
(1415, 'Argolis', 85, 1),
(1416, 'Arkadia', 85, 1),
(1417, 'Arta', 85, 1),
(1418, 'Attica', 85, 1),
(1419, 'Attiki', 85, 1),
(1420, 'Ayion Oros', 85, 1),
(1421, 'Crete', 85, 1),
(1422, 'Dodekanisos', 85, 1),
(1423, 'Drama', 85, 1),
(1424, 'Evia', 85, 1),
(1425, 'Evritania', 85, 1),
(1426, 'Evros', 85, 1),
(1427, 'Evvoia', 85, 1),
(1428, 'Florina', 85, 1),
(1429, 'Fokis', 85, 1),
(1430, 'Fthiotis', 85, 1),
(1431, 'Grevena', 85, 1),
(1432, 'Halandri', 85, 1),
(1433, 'Halkidiki', 85, 1),
(1434, 'Hania', 85, 1),
(1435, 'Heraklion', 85, 1),
(1436, 'Hios', 85, 1),
(1437, 'Ilia', 85, 1),
(1438, 'Imathia', 85, 1),
(1439, 'Ioannina', 85, 1),
(1440, 'Iraklion', 85, 1),
(1441, 'Karditsa', 85, 1),
(1442, 'Kastoria', 85, 1),
(1443, 'Kavala', 85, 1),
(1444, 'Kefallinia', 85, 1),
(1445, 'Kerkira', 85, 1),
(1446, 'Kiklades', 85, 1),
(1447, 'Kilkis', 85, 1),
(1448, 'Korinthia', 85, 1),
(1449, 'Kozani', 85, 1),
(1450, 'Lakonia', 85, 1),
(1451, 'Larisa', 85, 1),
(1452, 'Lasithi', 85, 1),
(1453, 'Lesvos', 85, 1),
(1454, 'Levkas', 85, 1),
(1455, 'Magnisia', 85, 1),
(1456, 'Messinia', 85, 1),
(1457, 'Nomos Attikis', 85, 1),
(1458, 'Nomos Zakynthou', 85, 1),
(1459, 'Pella', 85, 1),
(1460, 'Pieria', 85, 1),
(1461, 'Piraios', 85, 1),
(1462, 'Preveza', 85, 1),
(1463, 'Rethimni', 85, 1),
(1464, 'Rodopi', 85, 1),
(1465, 'Samos', 85, 1),
(1466, 'Serrai', 85, 1),
(1467, 'Thesprotia', 85, 1),
(1468, 'Thessaloniki', 85, 1),
(1469, 'Trikala', 85, 1),
(1470, 'Voiotia', 85, 1),
(1471, 'West Greece', 85, 1),
(1472, 'Xanthi', 85, 1),
(1473, 'Zakinthos', 85, 1),
(1474, 'Aasiaat', 86, 1),
(1475, 'Ammassalik', 86, 1),
(1476, 'Illoqqortoormiut', 86, 1),
(1477, 'Ilulissat', 86, 1),
(1478, 'Ivittuut', 86, 1),
(1479, 'Kangaatsiaq', 86, 1),
(1480, 'Maniitsoq', 86, 1),
(1481, 'Nanortalik', 86, 1),
(1482, 'Narsaq', 86, 1),
(1483, 'Nuuk', 86, 1),
(1484, 'Paamiut', 86, 1),
(1485, 'Qaanaaq', 86, 1),
(1486, 'Qaqortoq', 86, 1),
(1487, 'Qasigiannguit', 86, 1),
(1488, 'Qeqertarsuaq', 86, 1),
(1489, 'Sisimiut', 86, 1),
(1490, 'Udenfor kommunal inddeling', 86, 1),
(1491, 'Upernavik', 86, 1),
(1492, 'Uummannaq', 86, 1),
(1493, 'Carriacou-Petite Martinique', 87, 1),
(1494, 'Saint Andrew', 87, 1),
(1495, 'Saint Davids', 87, 1),
(1496, 'Saint George\'s', 87, 1),
(1497, 'Saint John', 87, 1),
(1498, 'Saint Mark', 87, 1),
(1499, 'Saint Patrick', 87, 1),
(1500, 'Basse-Terre', 88, 1),
(1501, 'Grande-Terre', 88, 1),
(1502, 'Iles des Saintes', 88, 1),
(1503, 'La Desirade', 88, 1),
(1504, 'Marie-Galante', 88, 1),
(1505, 'Saint Barthelemy', 88, 1),
(1506, 'Saint Martin', 88, 1),
(1507, 'Agana Heights', 89, 1),
(1508, 'Agat', 89, 1),
(1509, 'Barrigada', 89, 1),
(1510, 'Chalan-Pago-Ordot', 89, 1),
(1511, 'Dededo', 89, 1),
(1512, 'Hagatna', 89, 1),
(1513, 'Inarajan', 89, 1),
(1514, 'Mangilao', 89, 1),
(1515, 'Merizo', 89, 1),
(1516, 'Mongmong-Toto-Maite', 89, 1),
(1517, 'Santa Rita', 89, 1),
(1518, 'Sinajana', 89, 1),
(1519, 'Talofofo', 89, 1),
(1520, 'Tamuning', 89, 1),
(1521, 'Yigo', 89, 1),
(1522, 'Yona', 89, 1),
(1523, 'Alta Verapaz', 90, 1),
(1524, 'Baja Verapaz', 90, 1),
(1525, 'Chimaltenango', 90, 1),
(1526, 'Chiquimula', 90, 1),
(1527, 'El Progreso', 90, 1),
(1528, 'Escuintla', 90, 1),
(1529, 'Guatemala', 90, 1),
(1530, 'Huehuetenango', 90, 1),
(1531, 'Izabal', 90, 1),
(1532, 'Jalapa', 90, 1),
(1533, 'Jutiapa', 90, 1),
(1534, 'Peten', 90, 1),
(1535, 'Quezaltenango', 90, 1),
(1536, 'Quiche', 90, 1),
(1537, 'Retalhuleu', 90, 1),
(1538, 'Sacatepequez', 90, 1),
(1539, 'San Marcos', 90, 1),
(1540, 'Santa Rosa', 90, 1),
(1541, 'Solola', 90, 1),
(1542, 'Suchitepequez', 90, 1),
(1543, 'Totonicapan', 90, 1),
(1544, 'Zacapa', 90, 1),
(1545, 'Alderney', 91, 1),
(1546, 'Castel', 91, 1),
(1547, 'Forest', 91, 1),
(1548, 'Saint Andrew', 91, 1),
(1549, 'Saint Martin', 91, 1),
(1550, 'Saint Peter Port', 91, 1),
(1551, 'Saint Pierre du Bois', 91, 1),
(1552, 'Saint Sampson', 91, 1),
(1553, 'Saint Saviour', 91, 1),
(1554, 'Sark', 91, 1),
(1555, 'Torteval', 91, 1),
(1556, 'Vale', 91, 1),
(1557, 'Beyla', 92, 1),
(1558, 'Boffa', 92, 1),
(1559, 'Boke', 92, 1),
(1560, 'Conakry', 92, 1),
(1561, 'Coyah', 92, 1),
(1562, 'Dabola', 92, 1),
(1563, 'Dalaba', 92, 1),
(1564, 'Dinguiraye', 92, 1),
(1565, 'Faranah', 92, 1),
(1566, 'Forecariah', 92, 1),
(1567, 'Fria', 92, 1),
(1568, 'Gaoual', 92, 1),
(1569, 'Gueckedou', 92, 1),
(1570, 'Kankan', 92, 1),
(1571, 'Kerouane', 92, 1),
(1572, 'Kindia', 92, 1),
(1573, 'Kissidougou', 92, 1),
(1574, 'Koubia', 92, 1),
(1575, 'Koundara', 92, 1),
(1576, 'Kouroussa', 92, 1),
(1577, 'Labe', 92, 1),
(1578, 'Lola', 92, 1),
(1579, 'Macenta', 92, 1),
(1580, 'Mali', 92, 1),
(1581, 'Mamou', 92, 1),
(1582, 'Mandiana', 92, 1),
(1583, 'Nzerekore', 92, 1),
(1584, 'Pita', 92, 1),
(1585, 'Siguiri', 92, 1),
(1586, 'Telimele', 92, 1),
(1587, 'Tougue', 92, 1),
(1588, 'Yomou', 92, 1),
(1589, 'Bafata', 93, 1),
(1590, 'Bissau', 93, 1),
(1591, 'Bolama', 93, 1),
(1592, 'Cacheu', 93, 1),
(1593, 'Gabu', 93, 1),
(1594, 'Oio', 93, 1),
(1595, 'Quinara', 93, 1),
(1596, 'Tombali', 93, 1),
(1597, 'Barima-Waini', 94, 1),
(1598, 'Cuyuni-Mazaruni', 94, 1),
(1599, 'Demerara-Mahaica', 94, 1),
(1600, 'East Berbice-Corentyne', 94, 1),
(1601, 'Essequibo Islands-West Demerar', 94, 1),
(1602, 'Mahaica-Berbice', 94, 1),
(1603, 'Pomeroon-Supenaam', 94, 1),
(1604, 'Potaro-Siparuni', 94, 1),
(1605, 'Upper Demerara-Berbice', 94, 1),
(1606, 'Upper Takutu-Upper Essequibo', 94, 1),
(1607, 'Artibonite', 95, 1),
(1608, 'Centre', 95, 1),
(1609, 'Grand\'Anse', 95, 1),
(1610, 'Nord', 95, 1),
(1611, 'Nord-Est', 95, 1),
(1612, 'Nord-Ouest', 95, 1),
(1613, 'Ouest', 95, 1),
(1614, 'Sud', 95, 1),
(1615, 'Sud-Est', 95, 1),
(1616, 'Heard and McDonald Islands', 96, 1),
(1617, 'Atlantida', 97, 1),
(1618, 'Choluteca', 97, 1),
(1619, 'Colon', 97, 1),
(1620, 'Comayagua', 97, 1),
(1621, 'Copan', 97, 1),
(1622, 'Cortes', 97, 1),
(1623, 'Distrito Central', 97, 1),
(1624, 'El Paraiso', 97, 1),
(1625, 'Francisco Morazan', 97, 1),
(1626, 'Gracias a Dios', 97, 1),
(1627, 'Intibuca', 97, 1),
(1628, 'Islas de la Bahia', 97, 1),
(1629, 'La Paz', 97, 1),
(1630, 'Lempira', 97, 1),
(1631, 'Ocotepeque', 97, 1),
(1632, 'Olancho', 97, 1),
(1633, 'Santa Barbara', 97, 1),
(1634, 'Valle', 97, 1),
(1635, 'Yoro', 97, 1),
(1636, 'Hong Kong', 98, 1),
(1637, 'Bacs-Kiskun', 99, 1),
(1638, 'Baranya', 99, 1),
(1639, 'Bekes', 99, 1),
(1640, 'Borsod-Abauj-Zemplen', 99, 1),
(1641, 'Budapest', 99, 1),
(1642, 'Csongrad', 99, 1),
(1643, 'Fejer', 99, 1),
(1644, 'Gyor-Moson-Sopron', 99, 1),
(1645, 'Hajdu-Bihar', 99, 1),
(1646, 'Heves', 99, 1),
(1647, 'Jasz-Nagykun-Szolnok', 99, 1),
(1648, 'Komarom-Esztergom', 99, 1),
(1649, 'Nograd', 99, 1),
(1650, 'Pest', 99, 1),
(1651, 'Somogy', 99, 1),
(1652, 'Szabolcs-Szatmar-Bereg', 99, 1),
(1653, 'Tolna', 99, 1),
(1654, 'Vas', 99, 1),
(1655, 'Veszprem', 99, 1),
(1656, 'Zala', 99, 1),
(1657, 'Austurland', 100, 1),
(1658, 'Gullbringusysla', 100, 1),
(1659, 'Hofu borgarsva i', 100, 1),
(1660, 'Nor urland eystra', 100, 1),
(1661, 'Nor urland vestra', 100, 1),
(1662, 'Su urland', 100, 1),
(1663, 'Su urnes', 100, 1),
(1664, 'Vestfir ir', 100, 1),
(1665, 'Vesturland', 100, 1),
(1666, 'Aceh', 102, 1),
(1667, 'Bali', 102, 1),
(1668, 'Bangka-Belitung', 102, 1),
(1669, 'Banten', 102, 1),
(1670, 'Bengkulu', 102, 1),
(1671, 'Gandaria', 102, 1),
(1672, 'Gorontalo', 102, 1),
(1673, 'Jakarta', 102, 1),
(1674, 'Jambi', 102, 1),
(1675, 'Jawa Barat', 102, 1),
(1676, 'Jawa Tengah', 102, 1),
(1677, 'Jawa Timur', 102, 1),
(1678, 'Kalimantan Barat', 102, 1),
(1679, 'Kalimantan Selatan', 102, 1),
(1680, 'Kalimantan Tengah', 102, 1),
(1681, 'Kalimantan Timur', 102, 1),
(1682, 'Kendal', 102, 1),
(1683, 'Lampung', 102, 1),
(1684, 'Maluku', 102, 1),
(1685, 'Maluku Utara', 102, 1),
(1686, 'Nusa Tenggara Barat', 102, 1),
(1687, 'Nusa Tenggara Timur', 102, 1),
(1688, 'Papua', 102, 1),
(1689, 'Riau', 102, 1),
(1690, 'Riau Kepulauan', 102, 1),
(1691, 'Solo', 102, 1),
(1692, 'Sulawesi Selatan', 102, 1),
(1693, 'Sulawesi Tengah', 102, 1),
(1694, 'Sulawesi Tenggara', 102, 1),
(1695, 'Sulawesi Utara', 102, 1),
(1696, 'Sumatera Barat', 102, 1),
(1697, 'Sumatera Selatan', 102, 1),
(1698, 'Sumatera Utara', 102, 1),
(1699, 'Yogyakarta', 102, 1),
(1700, 'Ardabil', 103, 1),
(1701, 'Azarbayjan-e Bakhtari', 103, 1),
(1702, 'Azarbayjan-e Khavari', 103, 1),
(1703, 'Bushehr', 103, 1),
(1704, 'Chahar Mahal-e Bakhtiari', 103, 1),
(1705, 'Esfahan', 103, 1),
(1706, 'Fars', 103, 1),
(1707, 'Gilan', 103, 1),
(1708, 'Golestan', 103, 1),
(1709, 'Hamadan', 103, 1),
(1710, 'Hormozgan', 103, 1),
(1711, 'Ilam', 103, 1),
(1712, 'Kerman', 103, 1),
(1713, 'Kermanshah', 103, 1),
(1714, 'Khorasan', 103, 1),
(1715, 'Khuzestan', 103, 1),
(1716, 'Kohgiluyeh-e Boyerahmad', 103, 1),
(1717, 'Kordestan', 103, 1),
(1718, 'Lorestan', 103, 1),
(1719, 'Markazi', 103, 1),
(1720, 'Mazandaran', 103, 1),
(1721, 'Ostan-e Esfahan', 103, 1),
(1722, 'Qazvin', 103, 1),
(1723, 'Qom', 103, 1),
(1724, 'Semnan', 103, 1),
(1725, 'Sistan-e Baluchestan', 103, 1),
(1726, 'Tehran', 103, 1),
(1727, 'Yazd', 103, 1),
(1728, 'Zanjan', 103, 1),
(1729, 'Babil', 104, 1),
(1730, 'Baghdad', 104, 1),
(1731, 'Dahuk', 104, 1),
(1732, 'Dhi Qar', 104, 1),
(1733, 'Diyala', 104, 1),
(1734, 'Erbil', 104, 1),
(1735, 'Irbil', 104, 1),
(1736, 'Karbala', 104, 1),
(1737, 'Kurdistan', 104, 1),
(1738, 'Maysan', 104, 1),
(1739, 'Ninawa', 104, 1),
(1740, 'Salah-ad-Din', 104, 1),
(1741, 'Wasit', 104, 1),
(1742, 'al-Anbar', 104, 1),
(1743, 'al-Basrah', 104, 1),
(1744, 'al-Muthanna', 104, 1),
(1745, 'al-Qadisiyah', 104, 1),
(1746, 'an-Najaf', 104, 1),
(1747, 'as-Sulaymaniyah', 104, 1),
(1748, 'at-Ta\'mim', 104, 1),
(1749, 'Armagh', 105, 1),
(1750, 'Carlow', 105, 1),
(1751, 'Cavan', 105, 1),
(1752, 'Clare', 105, 1),
(1753, 'Cork', 105, 1),
(1754, 'Donegal', 105, 1),
(1755, 'Dublin', 105, 1),
(1756, 'Galway', 105, 1),
(1757, 'Kerry', 105, 1),
(1758, 'Kildare', 105, 1),
(1759, 'Kilkenny', 105, 1),
(1760, 'Laois', 105, 1),
(1761, 'Leinster', 105, 1),
(1762, 'Leitrim', 105, 1),
(1763, 'Limerick', 105, 1),
(1764, 'Loch Garman', 105, 1),
(1765, 'Longford', 105, 1),
(1766, 'Louth', 105, 1),
(1767, 'Mayo', 105, 1),
(1768, 'Meath', 105, 1),
(1769, 'Monaghan', 105, 1),
(1770, 'Offaly', 105, 1),
(1771, 'Roscommon', 105, 1),
(1772, 'Sligo', 105, 1),
(1773, 'Tipperary North Riding', 105, 1),
(1774, 'Tipperary South Riding', 105, 1),
(1775, 'Ulster', 105, 1),
(1776, 'Waterford', 105, 1),
(1777, 'Westmeath', 105, 1),
(1778, 'Wexford', 105, 1),
(1779, 'Wicklow', 105, 1),
(1780, 'Beit Hanania', 106, 1),
(1781, 'Ben Gurion Airport', 106, 1),
(1782, 'Bethlehem', 106, 1),
(1783, 'Caesarea', 106, 1),
(1784, 'Centre', 106, 1),
(1785, 'Gaza', 106, 1),
(1786, 'Hadaron', 106, 1),
(1787, 'Haifa District', 106, 1),
(1788, 'Hamerkaz', 106, 1),
(1789, 'Hazafon', 106, 1),
(1790, 'Hebron', 106, 1),
(1791, 'Jaffa', 106, 1),
(1792, 'Jerusalem', 106, 1),
(1793, 'Khefa', 106, 1),
(1794, 'Kiryat Yam', 106, 1),
(1795, 'Lower Galilee', 106, 1),
(1796, 'Qalqilya', 106, 1),
(1797, 'Talme Elazar', 106, 1),
(1798, 'Tel Aviv', 106, 1),
(1799, 'Tsafon', 106, 1),
(1800, 'Umm El Fahem', 106, 1),
(1801, 'Yerushalayim', 106, 1),
(1802, 'Abruzzi', 107, 1),
(1803, 'Abruzzo', 107, 1),
(1804, 'Agrigento', 107, 1),
(1805, 'Alessandria', 107, 1),
(1806, 'Ancona', 107, 1),
(1807, 'Arezzo', 107, 1),
(1808, 'Ascoli Piceno', 107, 1),
(1809, 'Asti', 107, 1),
(1810, 'Avellino', 107, 1),
(1811, 'Bari', 107, 1),
(1812, 'Basilicata', 107, 1),
(1813, 'Belluno', 107, 1),
(1814, 'Benevento', 107, 1),
(1815, 'Bergamo', 107, 1),
(1816, 'Biella', 107, 1),
(1817, 'Bologna', 107, 1),
(1818, 'Bolzano', 107, 1),
(1819, 'Brescia', 107, 1),
(1820, 'Brindisi', 107, 1),
(1821, 'Calabria', 107, 1),
(1822, 'Campania', 107, 1),
(1823, 'Cartoceto', 107, 1),
(1824, 'Caserta', 107, 1),
(1825, 'Catania', 107, 1),
(1826, 'Chieti', 107, 1),
(1827, 'Como', 107, 1),
(1828, 'Cosenza', 107, 1),
(1829, 'Cremona', 107, 1),
(1830, 'Cuneo', 107, 1),
(1831, 'Emilia-Romagna', 107, 1),
(1832, 'Ferrara', 107, 1),
(1833, 'Firenze', 107, 1),
(1834, 'Florence', 107, 1),
(1835, 'Forli-Cesena ', 107, 1),
(1836, 'Friuli-Venezia Giulia', 107, 1),
(1837, 'Frosinone', 107, 1),
(1838, 'Genoa', 107, 1),
(1839, 'Gorizia', 107, 1),
(1840, 'L\'Aquila', 107, 1),
(1841, 'Lazio', 107, 1),
(1842, 'Lecce', 107, 1),
(1843, 'Lecco', 107, 1),
(1844, 'Lecco Province', 107, 1),
(1845, 'Liguria', 107, 1),
(1846, 'Lodi', 107, 1),
(1847, 'Lombardia', 107, 1),
(1848, 'Lombardy', 107, 1),
(1849, 'Macerata', 107, 1),
(1850, 'Mantova', 107, 1),
(1851, 'Marche', 107, 1),
(1852, 'Messina', 107, 1),
(1853, 'Milan', 107, 1),
(1854, 'Modena', 107, 1),
(1855, 'Molise', 107, 1),
(1856, 'Molteno', 107, 1),
(1857, 'Montenegro', 107, 1),
(1858, 'Monza and Brianza', 107, 1),
(1859, 'Naples', 107, 1),
(1860, 'Novara', 107, 1),
(1861, 'Padova', 107, 1),
(1862, 'Parma', 107, 1),
(1863, 'Pavia', 107, 1),
(1864, 'Perugia', 107, 1),
(1865, 'Pesaro-Urbino', 107, 1),
(1866, 'Piacenza', 107, 1),
(1867, 'Piedmont', 107, 1),
(1868, 'Piemonte', 107, 1),
(1869, 'Pisa', 107, 1),
(1870, 'Pordenone', 107, 1),
(1871, 'Potenza', 107, 1),
(1872, 'Puglia', 107, 1),
(1873, 'Reggio Emilia', 107, 1),
(1874, 'Rimini', 107, 1),
(1875, 'Roma', 107, 1),
(1876, 'Salerno', 107, 1),
(1877, 'Sardegna', 107, 1),
(1878, 'Sassari', 107, 1),
(1879, 'Savona', 107, 1),
(1880, 'Sicilia', 107, 1),
(1881, 'Siena', 107, 1),
(1882, 'Sondrio', 107, 1),
(1883, 'South Tyrol', 107, 1),
(1884, 'Taranto', 107, 1),
(1885, 'Teramo', 107, 1),
(1886, 'Torino', 107, 1),
(1887, 'Toscana', 107, 1),
(1888, 'Trapani', 107, 1),
(1889, 'Trentino-Alto Adige', 107, 1),
(1890, 'Trento', 107, 1),
(1891, 'Treviso', 107, 1),
(1892, 'Udine', 107, 1),
(1893, 'Umbria', 107, 1),
(1894, 'Valle d\'Aosta', 107, 1),
(1895, 'Varese', 107, 1),
(1896, 'Veneto', 107, 1),
(1897, 'Venezia', 107, 1),
(1898, 'Verbano-Cusio-Ossola', 107, 1),
(1899, 'Vercelli', 107, 1),
(1900, 'Verona', 107, 1),
(1901, 'Vicenza', 107, 1),
(1902, 'Viterbo', 107, 1),
(1903, 'Buxoro Viloyati', 108, 1),
(1904, 'Clarendon', 108, 1),
(1905, 'Hanover', 108, 1),
(1906, 'Kingston', 108, 1),
(1907, 'Manchester', 108, 1),
(1908, 'Portland', 108, 1),
(1909, 'Saint Andrews', 108, 1),
(1910, 'Saint Ann', 108, 1),
(1911, 'Saint Catherine', 108, 1),
(1912, 'Saint Elizabeth', 108, 1),
(1913, 'Saint James', 108, 1),
(1914, 'Saint Mary', 108, 1),
(1915, 'Saint Thomas', 108, 1),
(1916, 'Trelawney', 108, 1),
(1917, 'Westmoreland', 108, 1),
(1918, 'Aichi', 109, 1),
(1919, 'Akita', 109, 1),
(1920, 'Aomori', 109, 1),
(1921, 'Chiba', 109, 1),
(1922, 'Ehime', 109, 1),
(1923, 'Fukui', 109, 1),
(1924, 'Fukuoka', 109, 1),
(1925, 'Fukushima', 109, 1),
(1926, 'Gifu', 109, 1),
(1927, 'Gumma', 109, 1),
(1928, 'Hiroshima', 109, 1),
(1929, 'Hokkaido', 109, 1),
(1930, 'Hyogo', 109, 1),
(1931, 'Ibaraki', 109, 1),
(1932, 'Ishikawa', 109, 1),
(1933, 'Iwate', 109, 1),
(1934, 'Kagawa', 109, 1);
INSERT INTO `states` (`state_id`, `state_name`, `country_id`, `state_status`) VALUES
(1935, 'Kagoshima', 109, 1),
(1936, 'Kanagawa', 109, 1),
(1937, 'Kanto', 109, 1),
(1938, 'Kochi', 109, 1),
(1939, 'Kumamoto', 109, 1),
(1940, 'Kyoto', 109, 1),
(1941, 'Mie', 109, 1),
(1942, 'Miyagi', 109, 1),
(1943, 'Miyazaki', 109, 1),
(1944, 'Nagano', 109, 1),
(1945, 'Nagasaki', 109, 1),
(1946, 'Nara', 109, 1),
(1947, 'Niigata', 109, 1),
(1948, 'Oita', 109, 1),
(1949, 'Okayama', 109, 1),
(1950, 'Okinawa', 109, 1),
(1951, 'Osaka', 109, 1),
(1952, 'Saga', 109, 1),
(1953, 'Saitama', 109, 1),
(1954, 'Shiga', 109, 1),
(1955, 'Shimane', 109, 1),
(1956, 'Shizuoka', 109, 1),
(1957, 'Tochigi', 109, 1),
(1958, 'Tokushima', 109, 1),
(1959, 'Tokyo', 109, 1),
(1960, 'Tottori', 109, 1),
(1961, 'Toyama', 109, 1),
(1962, 'Wakayama', 109, 1),
(1963, 'Yamagata', 109, 1),
(1964, 'Yamaguchi', 109, 1),
(1965, 'Yamanashi', 109, 1),
(1966, 'Grouville', 110, 1),
(1967, 'Saint Brelade', 110, 1),
(1968, 'Saint Clement', 110, 1),
(1969, 'Saint Helier', 110, 1),
(1970, 'Saint John', 110, 1),
(1971, 'Saint Lawrence', 110, 1),
(1972, 'Saint Martin', 110, 1),
(1973, 'Saint Mary', 110, 1),
(1974, 'Saint Peter', 110, 1),
(1975, 'Saint Saviour', 110, 1),
(1976, 'Trinity', 110, 1),
(1977, '\'Ajlun', 111, 1),
(1978, 'Amman', 111, 1),
(1979, 'Irbid', 111, 1),
(1980, 'Jarash', 111, 1),
(1981, 'Ma\'an', 111, 1),
(1982, 'Madaba', 111, 1),
(1983, 'al-\'Aqabah', 111, 1),
(1984, 'al-Balqa\'', 111, 1),
(1985, 'al-Karak', 111, 1),
(1986, 'al-Mafraq', 111, 1),
(1987, 'at-Tafilah', 111, 1),
(1988, 'az-Zarqa\'', 111, 1),
(1989, 'Akmecet', 112, 1),
(1990, 'Akmola', 112, 1),
(1991, 'Aktobe', 112, 1),
(1992, 'Almati', 112, 1),
(1993, 'Atirau', 112, 1),
(1994, 'Batis Kazakstan', 112, 1),
(1995, 'Burlinsky Region', 112, 1),
(1996, 'Karagandi', 112, 1),
(1997, 'Kostanay', 112, 1),
(1998, 'Mankistau', 112, 1),
(1999, 'Ontustik Kazakstan', 112, 1),
(2000, 'Pavlodar', 112, 1),
(2001, 'Sigis Kazakstan', 112, 1),
(2002, 'Soltustik Kazakstan', 112, 1),
(2003, 'Taraz', 112, 1),
(2004, 'Central', 113, 1),
(2005, 'Coast', 113, 1),
(2006, 'Eastern', 113, 1),
(2007, 'Nairobi', 113, 1),
(2008, 'North Eastern', 113, 1),
(2009, 'Nyanza', 113, 1),
(2010, 'Rift Valley', 113, 1),
(2011, 'Western', 113, 1),
(2012, 'Abaiang', 114, 1),
(2013, 'Abemana', 114, 1),
(2014, 'Aranuka', 114, 1),
(2015, 'Arorae', 114, 1),
(2016, 'Banaba', 114, 1),
(2017, 'Beru', 114, 1),
(2018, 'Butaritari', 114, 1),
(2019, 'Kiritimati', 114, 1),
(2020, 'Kuria', 114, 1),
(2021, 'Maiana', 114, 1),
(2022, 'Makin', 114, 1),
(2023, 'Marakei', 114, 1),
(2024, 'Nikunau', 114, 1),
(2025, 'Nonouti', 114, 1),
(2026, 'Onotoa', 114, 1),
(2027, 'Phoenix Islands', 114, 1),
(2028, 'Tabiteuea North', 114, 1),
(2029, 'Tabiteuea South', 114, 1),
(2030, 'Tabuaeran', 114, 1),
(2031, 'Tamana', 114, 1),
(2032, 'Tarawa North', 114, 1),
(2033, 'Tarawa South', 114, 1),
(2034, 'Teraina', 114, 1),
(2035, 'Chagangdo', 115, 1),
(2036, 'Hamgyeongbukto', 115, 1),
(2037, 'Hamgyeongnamdo', 115, 1),
(2038, 'Hwanghaebukto', 115, 1),
(2039, 'Hwanghaenamdo', 115, 1),
(2040, 'Kaeseong', 115, 1),
(2041, 'Kangweon', 115, 1),
(2042, 'Nampo', 115, 1),
(2043, 'Pyeonganbukto', 115, 1),
(2044, 'Pyeongannamdo', 115, 1),
(2045, 'Pyeongyang', 115, 1),
(2046, 'Yanggang', 115, 1),
(2047, 'Busan', 116, 1),
(2048, 'Cheju', 116, 1),
(2049, 'Chollabuk', 116, 1),
(2050, 'Chollanam', 116, 1),
(2051, 'Chungbuk', 116, 1),
(2052, 'Chungcheongbuk', 116, 1),
(2053, 'Chungcheongnam', 116, 1),
(2054, 'Chungnam', 116, 1),
(2055, 'Daegu', 116, 1),
(2056, 'Gangwon-do', 116, 1),
(2057, 'Goyang-si', 116, 1),
(2058, 'Gyeonggi-do', 116, 1),
(2059, 'Gyeongsang ', 116, 1),
(2060, 'Gyeongsangnam-do', 116, 1),
(2061, 'Incheon', 116, 1),
(2062, 'Jeju-Si', 116, 1),
(2063, 'Jeonbuk', 116, 1),
(2064, 'Kangweon', 116, 1),
(2065, 'Kwangju', 116, 1),
(2066, 'Kyeonggi', 116, 1),
(2067, 'Kyeongsangbuk', 116, 1),
(2068, 'Kyeongsangnam', 116, 1),
(2069, 'Kyonggi-do', 116, 1),
(2070, 'Kyungbuk-Do', 116, 1),
(2071, 'Kyunggi-Do', 116, 1),
(2072, 'Kyunggi-do', 116, 1),
(2073, 'Pusan', 116, 1),
(2074, 'Seoul', 116, 1),
(2075, 'Sudogwon', 116, 1),
(2076, 'Taegu', 116, 1),
(2077, 'Taejeon', 116, 1),
(2078, 'Taejon-gwangyoksi', 116, 1),
(2079, 'Ulsan', 116, 1),
(2080, 'Wonju', 116, 1),
(2081, 'gwangyoksi', 116, 1),
(2082, 'Al Asimah', 117, 1),
(2083, 'Hawalli', 117, 1),
(2084, 'Mishref', 117, 1),
(2085, 'Qadesiya', 117, 1),
(2086, 'Safat', 117, 1),
(2087, 'Salmiya', 117, 1),
(2088, 'al-Ahmadi', 117, 1),
(2089, 'al-Farwaniyah', 117, 1),
(2090, 'al-Jahra', 117, 1),
(2091, 'al-Kuwayt', 117, 1),
(2092, 'Batken', 118, 1),
(2093, 'Bishkek', 118, 1),
(2094, 'Chui', 118, 1),
(2095, 'Issyk-Kul', 118, 1),
(2096, 'Jalal-Abad', 118, 1),
(2097, 'Naryn', 118, 1),
(2098, 'Osh', 118, 1),
(2099, 'Talas', 118, 1),
(2100, 'Attopu', 119, 1),
(2101, 'Bokeo', 119, 1),
(2102, 'Bolikhamsay', 119, 1),
(2103, 'Champasak', 119, 1),
(2104, 'Houaphanh', 119, 1),
(2105, 'Khammouane', 119, 1),
(2106, 'Luang Nam Tha', 119, 1),
(2107, 'Luang Prabang', 119, 1),
(2108, 'Oudomxay', 119, 1),
(2109, 'Phongsaly', 119, 1),
(2110, 'Saravan', 119, 1),
(2111, 'Savannakhet', 119, 1),
(2112, 'Sekong', 119, 1),
(2113, 'Viangchan Prefecture', 119, 1),
(2114, 'Viangchan Province', 119, 1),
(2115, 'Xaignabury', 119, 1),
(2116, 'Xiang Khuang', 119, 1),
(2117, 'Aizkraukles', 120, 1),
(2118, 'Aluksnes', 120, 1),
(2119, 'Balvu', 120, 1),
(2120, 'Bauskas', 120, 1),
(2121, 'Cesu', 120, 1),
(2122, 'Daugavpils', 120, 1),
(2123, 'Daugavpils City', 120, 1),
(2124, 'Dobeles', 120, 1),
(2125, 'Gulbenes', 120, 1),
(2126, 'Jekabspils', 120, 1),
(2127, 'Jelgava', 120, 1),
(2128, 'Jelgavas', 120, 1),
(2129, 'Jurmala City', 120, 1),
(2130, 'Kraslavas', 120, 1),
(2131, 'Kuldigas', 120, 1),
(2132, 'Liepaja', 120, 1),
(2133, 'Liepajas', 120, 1),
(2134, 'Limbazhu', 120, 1),
(2135, 'Ludzas', 120, 1),
(2136, 'Madonas', 120, 1),
(2137, 'Ogres', 120, 1),
(2138, 'Preilu', 120, 1),
(2139, 'Rezekne', 120, 1),
(2140, 'Rezeknes', 120, 1),
(2141, 'Riga', 120, 1),
(2142, 'Rigas', 120, 1),
(2143, 'Saldus', 120, 1),
(2144, 'Talsu', 120, 1),
(2145, 'Tukuma', 120, 1),
(2146, 'Valkas', 120, 1),
(2147, 'Valmieras', 120, 1),
(2148, 'Ventspils', 120, 1),
(2149, 'Ventspils City', 120, 1),
(2150, 'Beirut', 121, 1),
(2151, 'Jabal Lubnan', 121, 1),
(2152, 'Mohafazat Liban-Nord', 121, 1),
(2153, 'Mohafazat Mont-Liban', 121, 1),
(2154, 'Sidon', 121, 1),
(2155, 'al-Biqa', 121, 1),
(2156, 'al-Janub', 121, 1),
(2157, 'an-Nabatiyah', 121, 1),
(2158, 'ash-Shamal', 121, 1),
(2159, 'Berea', 122, 1),
(2160, 'Butha-Buthe', 122, 1),
(2161, 'Leribe', 122, 1),
(2162, 'Mafeteng', 122, 1),
(2163, 'Maseru', 122, 1),
(2164, 'Mohale\'s Hoek', 122, 1),
(2165, 'Mokhotlong', 122, 1),
(2166, 'Qacha\'s Nek', 122, 1),
(2167, 'Quthing', 122, 1),
(2168, 'Thaba-Tseka', 122, 1),
(2169, 'Bomi', 123, 1),
(2170, 'Bong', 123, 1),
(2171, 'Grand Bassa', 123, 1),
(2172, 'Grand Cape Mount', 123, 1),
(2173, 'Grand Gedeh', 123, 1),
(2174, 'Loffa', 123, 1),
(2175, 'Margibi', 123, 1),
(2176, 'Maryland and Grand Kru', 123, 1),
(2177, 'Montserrado', 123, 1),
(2178, 'Nimba', 123, 1),
(2179, 'Rivercess', 123, 1),
(2180, 'Sinoe', 123, 1),
(2181, 'Ajdabiya', 124, 1),
(2183, 'Banghazi', 124, 1),
(2184, 'Darnah', 124, 1),
(2185, 'Ghadamis', 124, 1),
(2186, 'Gharyan', 124, 1),
(2187, 'Misratah', 124, 1),
(2188, 'Murzuq', 124, 1),
(2189, 'Sabha', 124, 1),
(2190, 'Sawfajjin', 124, 1),
(2191, 'Surt', 124, 1),
(2192, 'Tarabulus', 124, 1),
(2193, 'Tarhunah', 124, 1),
(2194, 'Tripolitania', 124, 1),
(2195, 'Tubruq', 124, 1),
(2196, 'Yafran', 124, 1),
(2197, 'Zlitan', 124, 1),
(2198, 'al-\'Aziziyah', 124, 1),
(2199, 'al-Fatih', 124, 1),
(2200, 'al-Jabal al Akhdar', 124, 1),
(2201, 'al-Jufrah', 124, 1),
(2202, 'al-Khums', 124, 1),
(2203, 'al-Kufrah', 124, 1),
(2204, 'an-Nuqat al-Khams', 124, 1),
(2205, 'ash-Shati\'', 124, 1),
(2206, 'az-Zawiyah', 124, 1),
(2207, 'Balzers', 125, 1),
(2208, 'Eschen', 125, 1),
(2209, 'Gamprin', 125, 1),
(2210, 'Mauren', 125, 1),
(2211, 'Planken', 125, 1),
(2212, 'Ruggell', 125, 1),
(2213, 'Schaan', 125, 1),
(2214, 'Schellenberg', 125, 1),
(2215, 'Triesen', 125, 1),
(2216, 'Triesenberg', 125, 1),
(2217, 'Vaduz', 125, 1),
(2218, 'Alytaus', 126, 1),
(2219, 'Anyksciai', 126, 1),
(2220, 'Kauno', 126, 1),
(2221, 'Klaipedos', 126, 1),
(2222, 'Marijampoles', 126, 1),
(2223, 'Panevezhio', 126, 1),
(2224, 'Panevezys', 126, 1),
(2225, 'Shiauliu', 126, 1),
(2226, 'Taurages', 126, 1),
(2227, 'Telshiu', 126, 1),
(2228, 'Telsiai', 126, 1),
(2229, 'Utenos', 126, 1),
(2230, 'Vilniaus', 126, 1),
(2231, 'Capellen', 127, 1),
(2232, 'Clervaux', 127, 1),
(2233, 'Diekirch', 127, 1),
(2234, 'Echternach', 127, 1),
(2235, 'Esch-sur-Alzette', 127, 1),
(2236, 'Grevenmacher', 127, 1),
(2237, 'Luxembourg', 127, 1),
(2238, 'Mersch', 127, 1),
(2239, 'Redange', 127, 1),
(2240, 'Remich', 127, 1),
(2241, 'Vianden', 127, 1),
(2242, 'Wiltz', 127, 1),
(2243, 'Macau', 128, 1),
(2244, 'Berovo', 129, 1),
(2245, 'Bitola', 129, 1),
(2246, 'Brod', 129, 1),
(2247, 'Debar', 129, 1),
(2248, 'Delchevo', 129, 1),
(2249, 'Demir Hisar', 129, 1),
(2250, 'Gevgelija', 129, 1),
(2251, 'Gostivar', 129, 1),
(2252, 'Kavadarci', 129, 1),
(2253, 'Kichevo', 129, 1),
(2254, 'Kochani', 129, 1),
(2255, 'Kratovo', 129, 1),
(2256, 'Kriva Palanka', 129, 1),
(2257, 'Krushevo', 129, 1),
(2258, 'Kumanovo', 129, 1),
(2259, 'Negotino', 129, 1),
(2260, 'Ohrid', 129, 1),
(2261, 'Prilep', 129, 1),
(2262, 'Probishtip', 129, 1),
(2263, 'Radovish', 129, 1),
(2264, 'Resen', 129, 1),
(2265, 'Shtip', 129, 1),
(2266, 'Skopje', 129, 1),
(2267, 'Struga', 129, 1),
(2268, 'Strumica', 129, 1),
(2269, 'Sveti Nikole', 129, 1),
(2270, 'Tetovo', 129, 1),
(2271, 'Valandovo', 129, 1),
(2272, 'Veles', 129, 1),
(2273, 'Vinica', 129, 1),
(2274, 'Antananarivo', 130, 1),
(2275, 'Antsiranana', 130, 1),
(2276, 'Fianarantsoa', 130, 1),
(2277, 'Mahajanga', 130, 1),
(2278, 'Toamasina', 130, 1),
(2279, 'Toliary', 130, 1),
(2280, 'Balaka', 131, 1),
(2281, 'Blantyre City', 131, 1),
(2282, 'Chikwawa', 131, 1),
(2283, 'Chiradzulu', 131, 1),
(2284, 'Chitipa', 131, 1),
(2285, 'Dedza', 131, 1),
(2286, 'Dowa', 131, 1),
(2287, 'Karonga', 131, 1),
(2288, 'Kasungu', 131, 1),
(2289, 'Lilongwe City', 131, 1),
(2290, 'Machinga', 131, 1),
(2291, 'Mangochi', 131, 1),
(2292, 'Mchinji', 131, 1),
(2293, 'Mulanje', 131, 1),
(2294, 'Mwanza', 131, 1),
(2295, 'Mzimba', 131, 1),
(2296, 'Mzuzu City', 131, 1),
(2297, 'Nkhata Bay', 131, 1),
(2298, 'Nkhotakota', 131, 1),
(2299, 'Nsanje', 131, 1),
(2300, 'Ntcheu', 131, 1),
(2301, 'Ntchisi', 131, 1),
(2302, 'Phalombe', 131, 1),
(2303, 'Rumphi', 131, 1),
(2304, 'Salima', 131, 1),
(2305, 'Thyolo', 131, 1),
(2306, 'Zomba Municipality', 131, 1),
(2307, 'Johor', 132, 1),
(2308, 'Kedah', 132, 1),
(2309, 'Kelantan', 132, 1),
(2310, 'Kuala Lumpur', 132, 1),
(2311, 'Labuan', 132, 1),
(2312, 'Melaka', 132, 1),
(2313, 'Negeri Johor', 132, 1),
(2314, 'Negeri Sembilan', 132, 1),
(2315, 'Pahang', 132, 1),
(2316, 'Penang', 132, 1),
(2317, 'Perak', 132, 1),
(2318, 'Perlis', 132, 1),
(2319, 'Pulau Pinang', 132, 1),
(2320, 'Sabah', 132, 1),
(2321, 'Sarawak', 132, 1),
(2322, 'Selangor', 132, 1),
(2323, 'Sembilan', 132, 1),
(2324, 'Terengganu', 132, 1),
(2325, 'Alif Alif', 133, 1),
(2326, 'Alif Dhaal', 133, 1),
(2327, 'Baa', 133, 1),
(2328, 'Dhaal', 133, 1),
(2329, 'Faaf', 133, 1),
(2330, 'Gaaf Alif', 133, 1),
(2331, 'Gaaf Dhaal', 133, 1),
(2332, 'Ghaviyani', 133, 1),
(2333, 'Haa Alif', 133, 1),
(2334, 'Haa Dhaal', 133, 1),
(2335, 'Kaaf', 133, 1),
(2336, 'Laam', 133, 1),
(2337, 'Lhaviyani', 133, 1),
(2338, 'Male', 133, 1),
(2339, 'Miim', 133, 1),
(2340, 'Nuun', 133, 1),
(2341, 'Raa', 133, 1),
(2342, 'Shaviyani', 133, 1),
(2343, 'Siin', 133, 1),
(2344, 'Thaa', 133, 1),
(2345, 'Vaav', 133, 1),
(2346, 'Bamako', 134, 1),
(2347, 'Gao', 134, 1),
(2348, 'Kayes', 134, 1),
(2349, 'Kidal', 134, 1),
(2350, 'Koulikoro', 134, 1),
(2351, 'Mopti', 134, 1),
(2352, 'Segou', 134, 1),
(2353, 'Sikasso', 134, 1),
(2354, 'Tombouctou', 134, 1),
(2355, 'Gozo and Comino', 135, 1),
(2356, 'Inner Harbour', 135, 1),
(2357, 'Northern', 135, 1),
(2358, 'Outer Harbour', 135, 1),
(2359, 'South Eastern', 135, 1),
(2360, 'Valletta', 135, 1),
(2361, 'Western', 135, 1),
(2362, 'Castletown', 136, 1),
(2363, 'Douglas', 136, 1),
(2364, 'Laxey', 136, 1),
(2365, 'Onchan', 136, 1),
(2366, 'Peel', 136, 1),
(2367, 'Port Erin', 136, 1),
(2368, 'Port Saint Mary', 136, 1),
(2369, 'Ramsey', 136, 1),
(2370, 'Ailinlaplap', 137, 1),
(2371, 'Ailuk', 137, 1),
(2372, 'Arno', 137, 1),
(2373, 'Aur', 137, 1),
(2374, 'Bikini', 137, 1),
(2375, 'Ebon', 137, 1),
(2376, 'Enewetak', 137, 1),
(2377, 'Jabat', 137, 1),
(2378, 'Jaluit', 137, 1),
(2379, 'Kili', 137, 1),
(2380, 'Kwajalein', 137, 1),
(2381, 'Lae', 137, 1),
(2382, 'Lib', 137, 1),
(2383, 'Likiep', 137, 1),
(2384, 'Majuro', 137, 1),
(2385, 'Maloelap', 137, 1),
(2386, 'Mejit', 137, 1),
(2387, 'Mili', 137, 1),
(2388, 'Namorik', 137, 1),
(2389, 'Namu', 137, 1),
(2390, 'Rongelap', 137, 1),
(2391, 'Ujae', 137, 1),
(2392, 'Utrik', 137, 1),
(2393, 'Wotho', 137, 1),
(2394, 'Wotje', 137, 1),
(2395, 'Fort-de-France', 138, 1),
(2396, 'La Trinite', 138, 1),
(2397, 'Le Marin', 138, 1),
(2398, 'Saint-Pierre', 138, 1),
(2399, 'Adrar', 139, 1),
(2400, 'Assaba', 139, 1),
(2401, 'Brakna', 139, 1),
(2402, 'Dhakhlat Nawadibu', 139, 1),
(2403, 'Hudh-al-Gharbi', 139, 1),
(2404, 'Hudh-ash-Sharqi', 139, 1),
(2405, 'Inshiri', 139, 1),
(2406, 'Nawakshut', 139, 1),
(2407, 'Qidimagha', 139, 1),
(2408, 'Qurqul', 139, 1),
(2409, 'Taqant', 139, 1),
(2410, 'Tiris Zammur', 139, 1),
(2411, 'Trarza', 139, 1),
(2412, 'Black River', 140, 1),
(2413, 'Eau Coulee', 140, 1),
(2414, 'Flacq', 140, 1),
(2415, 'Floreal', 140, 1),
(2416, 'Grand Port', 140, 1),
(2417, 'Moka', 140, 1),
(2418, 'Pamplempousses', 140, 1),
(2419, 'Plaines Wilhelm', 140, 1),
(2420, 'Port Louis', 140, 1),
(2421, 'Riviere du Rempart', 140, 1),
(2422, 'Rodrigues', 140, 1),
(2423, 'Rose Hill', 140, 1),
(2424, 'Savanne', 140, 1),
(2425, 'Mayotte', 141, 1),
(2426, 'Pamanzi', 141, 1),
(2427, 'Aguascalientes', 142, 1),
(2428, 'Baja California', 142, 1),
(2429, 'Baja California Sur', 142, 1),
(2430, 'Campeche', 142, 1),
(2431, 'Chiapas', 142, 1),
(2432, 'Chihuahua', 142, 1),
(2433, 'Coahuila', 142, 1),
(2434, 'Colima', 142, 1),
(2435, 'Distrito Federal', 142, 1),
(2436, 'Durango', 142, 1),
(2437, 'Estado de Mexico', 142, 1),
(2438, 'Guanajuato', 142, 1),
(2439, 'Guerrero', 142, 1),
(2440, 'Hidalgo', 142, 1),
(2441, 'Jalisco', 142, 1),
(2442, 'Mexico', 142, 1),
(2443, 'Michoacan', 142, 1),
(2444, 'Morelos', 142, 1),
(2445, 'Nayarit', 142, 1),
(2446, 'Nuevo Leon', 142, 1),
(2447, 'Oaxaca', 142, 1),
(2448, 'Puebla', 142, 1),
(2449, 'Queretaro', 142, 1),
(2450, 'Quintana Roo', 142, 1),
(2451, 'San Luis Potosi', 142, 1),
(2452, 'Sinaloa', 142, 1),
(2453, 'Sonora', 142, 1),
(2454, 'Tabasco', 142, 1),
(2455, 'Tamaulipas', 142, 1),
(2456, 'Tlaxcala', 142, 1),
(2457, 'Veracruz', 142, 1),
(2458, 'Yucatan', 142, 1),
(2459, 'Zacatecas', 142, 1),
(2460, 'Chuuk', 143, 1),
(2461, 'Kusaie', 143, 1),
(2462, 'Pohnpei', 143, 1),
(2463, 'Yap', 143, 1),
(2464, 'Balti', 144, 1),
(2465, 'Cahul', 144, 1),
(2466, 'Chisinau', 144, 1),
(2467, 'Chisinau Oras', 144, 1),
(2468, 'Edinet', 144, 1),
(2469, 'Gagauzia', 144, 1),
(2470, 'Lapusna', 144, 1),
(2471, 'Orhei', 144, 1),
(2472, 'Soroca', 144, 1),
(2473, 'Taraclia', 144, 1),
(2474, 'Tighina', 144, 1),
(2475, 'Transnistria', 144, 1),
(2476, 'Ungheni', 144, 1),
(2477, 'Fontvieille', 145, 1),
(2478, 'La Condamine', 145, 1),
(2479, 'Monaco-Ville', 145, 1),
(2480, 'Monte Carlo', 145, 1),
(2481, 'Arhangaj', 146, 1),
(2482, 'Bajan-Olgij', 146, 1),
(2483, 'Bajanhongor', 146, 1),
(2484, 'Bulgan', 146, 1),
(2485, 'Darhan-Uul', 146, 1),
(2486, 'Dornod', 146, 1),
(2487, 'Dornogovi', 146, 1),
(2488, 'Dundgovi', 146, 1),
(2489, 'Govi-Altaj', 146, 1),
(2490, 'Govisumber', 146, 1),
(2491, 'Hentij', 146, 1),
(2492, 'Hovd', 146, 1),
(2493, 'Hovsgol', 146, 1),
(2494, 'Omnogovi', 146, 1),
(2495, 'Orhon', 146, 1),
(2496, 'Ovorhangaj', 146, 1),
(2497, 'Selenge', 146, 1),
(2498, 'Suhbaatar', 146, 1),
(2499, 'Tov', 146, 1),
(2500, 'Ulaanbaatar', 146, 1),
(2501, 'Uvs', 146, 1),
(2502, 'Zavhan', 146, 1),
(2503, 'Montserrat', 147, 1),
(2504, 'Agadir', 148, 1),
(2505, 'Casablanca', 148, 1),
(2506, 'Chaouia-Ouardigha', 148, 1),
(2507, 'Doukkala-Abda', 148, 1),
(2508, 'Fes-Boulemane', 148, 1),
(2509, 'Gharb-Chrarda-Beni Hssen', 148, 1),
(2510, 'Guelmim', 148, 1),
(2511, 'Kenitra', 148, 1),
(2512, 'Marrakech-Tensift-Al Haouz', 148, 1),
(2513, 'Meknes-Tafilalet', 148, 1),
(2514, 'Oriental', 148, 1),
(2515, 'Oujda', 148, 1),
(2516, 'Province de Tanger', 148, 1),
(2517, 'Rabat-Sale-Zammour-Zaer', 148, 1),
(2518, 'Sala Al Jadida', 148, 1),
(2519, 'Settat', 148, 1),
(2520, 'Souss Massa-Draa', 148, 1),
(2521, 'Tadla-Azilal', 148, 1),
(2522, 'Tangier-Tetouan', 148, 1),
(2523, 'Taza-Al Hoceima-Taounate', 148, 1),
(2524, 'Wilaya de Casablanca', 148, 1),
(2525, 'Wilaya de Rabat-Sale', 148, 1),
(2526, 'Cabo Delgado', 149, 1),
(2527, 'Gaza', 149, 1),
(2528, 'Inhambane', 149, 1),
(2529, 'Manica', 149, 1),
(2530, 'Maputo', 149, 1),
(2531, 'Maputo Provincia', 149, 1),
(2532, 'Nampula', 149, 1),
(2533, 'Niassa', 149, 1),
(2534, 'Sofala', 149, 1),
(2535, 'Tete', 149, 1),
(2536, 'Zambezia', 149, 1),
(2537, 'Ayeyarwady', 150, 1),
(2538, 'Bago', 150, 1),
(2539, 'Chin', 150, 1),
(2540, 'Kachin', 150, 1),
(2541, 'Kayah', 150, 1),
(2542, 'Kayin', 150, 1),
(2543, 'Magway', 150, 1),
(2544, 'Mandalay', 150, 1),
(2545, 'Mon', 150, 1),
(2546, 'Nay Pyi Taw', 150, 1),
(2547, 'Rakhine', 150, 1),
(2548, 'Sagaing', 150, 1),
(2549, 'Shan', 150, 1),
(2550, 'Tanintharyi', 150, 1),
(2551, 'Yangon', 150, 1),
(2552, 'Caprivi', 151, 1),
(2553, 'Erongo', 151, 1),
(2554, 'Hardap', 151, 1),
(2555, 'Karas', 151, 1),
(2556, 'Kavango', 151, 1),
(2557, 'Khomas', 151, 1),
(2558, 'Kunene', 151, 1),
(2559, 'Ohangwena', 151, 1),
(2560, 'Omaheke', 151, 1),
(2561, 'Omusati', 151, 1),
(2562, 'Oshana', 151, 1),
(2563, 'Oshikoto', 151, 1),
(2564, 'Otjozondjupa', 151, 1),
(2565, 'Yaren', 152, 1),
(2566, 'Bagmati', 153, 1),
(2567, 'Bheri', 153, 1),
(2568, 'Dhawalagiri', 153, 1),
(2569, 'Gandaki', 153, 1),
(2570, 'Janakpur', 153, 1),
(2571, 'Karnali', 153, 1),
(2572, 'Koshi', 153, 1),
(2573, 'Lumbini', 153, 1),
(2574, 'Mahakali', 153, 1),
(2575, 'Mechi', 153, 1),
(2576, 'Narayani', 153, 1),
(2577, 'Rapti', 153, 1),
(2578, 'Sagarmatha', 153, 1),
(2579, 'Seti', 153, 1),
(2580, 'Bonaire', 154, 1),
(2581, 'Curacao', 154, 1),
(2582, 'Saba', 154, 1),
(2583, 'Sint Eustatius', 154, 1),
(2584, 'Sint Maarten', 154, 1),
(2585, 'Amsterdam', 155, 1),
(2586, 'Benelux', 155, 1),
(2587, 'Drenthe', 155, 1),
(2588, 'Flevoland', 155, 1),
(2589, 'Friesland', 155, 1),
(2590, 'Gelderland', 155, 1),
(2591, 'Groningen', 155, 1),
(2592, 'Limburg', 155, 1),
(2593, 'Noord-Brabant', 155, 1),
(2594, 'Noord-Holland', 155, 1),
(2595, 'Overijssel', 155, 1),
(2596, 'South Holland', 155, 1),
(2597, 'Utrecht', 155, 1),
(2598, 'Zeeland', 155, 1),
(2599, 'Zuid-Holland', 155, 1),
(2600, 'Iles', 156, 1),
(2601, 'Nord', 156, 1),
(2602, 'Sud', 156, 1),
(2603, 'Area Outside Region', 157, 1),
(2604, 'Auckland', 157, 1),
(2605, 'Bay of Plenty', 157, 1),
(2606, 'Canterbury', 157, 1),
(2607, 'Christchurch', 157, 1),
(2608, 'Gisborne', 157, 1),
(2609, 'Hawke\'s Bay', 157, 1),
(2610, 'Manawatu-Wanganui', 157, 1),
(2611, 'Marlborough', 157, 1),
(2612, 'Nelson', 157, 1),
(2613, 'Northland', 157, 1),
(2614, 'Otago', 157, 1),
(2615, 'Rodney', 157, 1),
(2616, 'Southland', 157, 1),
(2617, 'Taranaki', 157, 1),
(2618, 'Tasman', 157, 1),
(2619, 'Waikato', 157, 1),
(2620, 'Wellington', 157, 1),
(2621, 'West Coast', 157, 1),
(2622, 'Atlantico Norte', 158, 1),
(2623, 'Atlantico Sur', 158, 1),
(2624, 'Boaco', 158, 1),
(2625, 'Carazo', 158, 1),
(2626, 'Chinandega', 158, 1),
(2627, 'Chontales', 158, 1),
(2628, 'Esteli', 158, 1),
(2629, 'Granada', 158, 1),
(2630, 'Jinotega', 158, 1),
(2631, 'Leon', 158, 1),
(2632, 'Madriz', 158, 1),
(2633, 'Managua', 158, 1),
(2634, 'Masaya', 158, 1),
(2635, 'Matagalpa', 158, 1),
(2636, 'Nueva Segovia', 158, 1),
(2637, 'Rio San Juan', 158, 1),
(2638, 'Rivas', 158, 1),
(2639, 'Agadez', 159, 1),
(2640, 'Diffa', 159, 1),
(2641, 'Dosso', 159, 1),
(2642, 'Maradi', 159, 1),
(2643, 'Niamey', 159, 1),
(2644, 'Tahoua', 159, 1),
(2645, 'Tillabery', 159, 1),
(2646, 'Zinder', 159, 1),
(2647, 'Abia', 160, 1),
(2648, 'Abuja Federal Capital Territor', 160, 1),
(2649, 'Adamawa', 160, 1),
(2650, 'Akwa Ibom', 160, 1),
(2651, 'Anambra', 160, 1),
(2652, 'Bauchi', 160, 1),
(2653, 'Bayelsa', 160, 1),
(2654, 'Benue', 160, 1),
(2655, 'Borno', 160, 1),
(2656, 'Cross River', 160, 1),
(2657, 'Delta', 160, 1),
(2658, 'Ebonyi', 160, 1),
(2659, 'Edo', 160, 1),
(2660, 'Ekiti', 160, 1),
(2661, 'Enugu', 160, 1),
(2662, 'Gombe', 160, 1),
(2663, 'Imo', 160, 1),
(2664, 'Jigawa', 160, 1),
(2665, 'Kaduna', 160, 1),
(2666, 'Kano', 160, 1),
(2667, 'Katsina', 160, 1),
(2668, 'Kebbi', 160, 1),
(2669, 'Kogi', 160, 1),
(2670, 'Kwara', 160, 1),
(2671, 'Lagos', 160, 1),
(2672, 'Nassarawa', 160, 1),
(2673, 'Niger', 160, 1),
(2674, 'Ogun', 160, 1),
(2675, 'Ondo', 160, 1),
(2676, 'Osun', 160, 1),
(2677, 'Oyo', 160, 1),
(2678, 'Plateau', 160, 1),
(2679, 'Rivers', 160, 1),
(2680, 'Sokoto', 160, 1),
(2681, 'Taraba', 160, 1),
(2682, 'Yobe', 160, 1),
(2683, 'Zamfara', 160, 1),
(2684, 'Niue', 161, 1),
(2685, 'Norfolk Island', 162, 1),
(2686, 'Northern Islands', 163, 1),
(2687, 'Rota', 163, 1),
(2688, 'Saipan', 163, 1),
(2689, 'Tinian', 163, 1),
(2690, 'Akershus', 164, 1),
(2691, 'Aust Agder', 164, 1),
(2692, 'Bergen', 164, 1),
(2693, 'Buskerud', 164, 1),
(2694, 'Finnmark', 164, 1),
(2695, 'Hedmark', 164, 1),
(2696, 'Hordaland', 164, 1),
(2697, 'Moere og Romsdal', 164, 1),
(2698, 'Nord Trondelag', 164, 1),
(2699, 'Nordland', 164, 1),
(2700, 'Oestfold', 164, 1),
(2701, 'Oppland', 164, 1),
(2702, 'Oslo', 164, 1),
(2703, 'Rogaland', 164, 1),
(2704, 'Soer Troendelag', 164, 1),
(2705, 'Sogn og Fjordane', 164, 1),
(2706, 'Stavern', 164, 1),
(2707, 'Sykkylven', 164, 1),
(2708, 'Telemark', 164, 1),
(2709, 'Troms', 164, 1),
(2710, 'Vest Agder', 164, 1),
(2711, 'Vestfold', 164, 1),
(2712, 'ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚', 164, 1),
(2713, 'Al Buraimi', 165, 1),
(2714, 'Dhufar', 165, 1),
(2715, 'Masqat', 165, 1),
(2716, 'Musandam', 165, 1),
(2717, 'Rusayl', 165, 1),
(2718, 'Wadi Kabir', 165, 1),
(2719, 'ad-Dakhiliyah', 165, 1),
(2720, 'adh-Dhahirah', 165, 1),
(2721, 'al-Batinah', 165, 1),
(2722, 'ash-Sharqiyah', 165, 1),
(2723, 'Baluchistan', 166, 1),
(2724, 'Federal Capital Area', 166, 1),
(2725, 'Federally administered Tribal ', 166, 1),
(2726, 'North-West Frontier', 166, 1),
(2727, 'Northern Areas', 166, 1),
(2728, 'Punjab', 166, 1),
(2729, 'Sind', 166, 1),
(2730, 'Aimeliik', 167, 1),
(2731, 'Airai', 167, 1),
(2732, 'Angaur', 167, 1),
(2733, 'Hatobohei', 167, 1),
(2734, 'Kayangel', 167, 1),
(2735, 'Koror', 167, 1),
(2736, 'Melekeok', 167, 1),
(2737, 'Ngaraard', 167, 1),
(2738, 'Ngardmau', 167, 1),
(2739, 'Ngaremlengui', 167, 1),
(2740, 'Ngatpang', 167, 1),
(2741, 'Ngchesar', 167, 1),
(2742, 'Ngerchelong', 167, 1),
(2743, 'Ngiwal', 167, 1),
(2744, 'Peleliu', 167, 1),
(2745, 'Sonsorol', 167, 1),
(2746, 'Ariha', 168, 1),
(2747, 'Bayt Lahm', 168, 1),
(2748, 'Bethlehem', 168, 1),
(2749, 'Dayr-al-Balah', 168, 1),
(2750, 'Ghazzah', 168, 1),
(2751, 'Ghazzah ash-Shamaliyah', 168, 1),
(2752, 'Janin', 168, 1),
(2753, 'Khan Yunis', 168, 1),
(2754, 'Nabulus', 168, 1),
(2755, 'Qalqilyah', 168, 1),
(2756, 'Rafah', 168, 1),
(2757, 'Ram Allah wal-Birah', 168, 1),
(2758, 'Salfit', 168, 1),
(2759, 'Tubas', 168, 1),
(2760, 'Tulkarm', 168, 1),
(2761, 'al-Khalil', 168, 1),
(2762, 'al-Quds', 168, 1),
(2763, 'Bocas del Toro', 169, 1),
(2764, 'Chiriqui', 169, 1),
(2765, 'Cocle', 169, 1),
(2766, 'Colon', 169, 1),
(2767, 'Darien', 169, 1),
(2768, 'Embera', 169, 1),
(2769, 'Herrera', 169, 1),
(2770, 'Kuna Yala', 169, 1),
(2771, 'Los Santos', 169, 1),
(2772, 'Ngobe Bugle', 169, 1),
(2773, 'Panama', 169, 1),
(2774, 'Veraguas', 169, 1),
(2775, 'East New Britain', 170, 1),
(2776, 'East Sepik', 170, 1),
(2777, 'Eastern Highlands', 170, 1),
(2778, 'Enga', 170, 1),
(2779, 'Fly River', 170, 1),
(2780, 'Gulf', 170, 1),
(2781, 'Madang', 170, 1),
(2782, 'Manus', 170, 1),
(2783, 'Milne Bay', 170, 1),
(2784, 'Morobe', 170, 1),
(2785, 'National Capital District', 170, 1),
(2786, 'New Ireland', 170, 1),
(2787, 'North Solomons', 170, 1),
(2788, 'Oro', 170, 1),
(2789, 'Sandaun', 170, 1),
(2790, 'Simbu', 170, 1),
(2791, 'Southern Highlands', 170, 1),
(2792, 'West New Britain', 170, 1),
(2793, 'Western Highlands', 170, 1),
(2794, 'Alto Paraguay', 171, 1),
(2795, 'Alto Parana', 171, 1),
(2796, 'Amambay', 171, 1),
(2797, 'Asuncion', 171, 1),
(2798, 'Boqueron', 171, 1),
(2799, 'Caaguazu', 171, 1),
(2800, 'Caazapa', 171, 1),
(2801, 'Canendiyu', 171, 1),
(2802, 'Central', 171, 1),
(2803, 'Concepcion', 171, 1),
(2804, 'Cordillera', 171, 1),
(2805, 'Guaira', 171, 1),
(2806, 'Itapua', 171, 1),
(2807, 'Misiones', 171, 1),
(2808, 'Neembucu', 171, 1),
(2809, 'Paraguari', 171, 1),
(2810, 'Presidente Hayes', 171, 1),
(2811, 'San Pedro', 171, 1),
(2812, 'Amazonas', 172, 1),
(2813, 'Ancash', 172, 1),
(2814, 'Apurimac', 172, 1),
(2815, 'Arequipa', 172, 1),
(2816, 'Ayacucho', 172, 1),
(2817, 'Cajamarca', 172, 1),
(2818, 'Cusco', 172, 1),
(2819, 'Huancavelica', 172, 1),
(2820, 'Huanuco', 172, 1),
(2821, 'Ica', 172, 1),
(2822, 'Junin', 172, 1),
(2823, 'La Libertad', 172, 1),
(2824, 'Lambayeque', 172, 1),
(2825, 'Lima y Callao', 172, 1),
(2826, 'Loreto', 172, 1),
(2827, 'Madre de Dios', 172, 1),
(2828, 'Moquegua', 172, 1),
(2829, 'Pasco', 172, 1),
(2830, 'Piura', 172, 1),
(2831, 'Puno', 172, 1),
(2832, 'San Martin', 172, 1),
(2833, 'Tacna', 172, 1),
(2834, 'Tumbes', 172, 1),
(2835, 'Ucayali', 172, 1),
(2836, 'Batangas', 173, 1),
(2837, 'Bicol', 173, 1),
(2838, 'Bulacan', 173, 1),
(2839, 'Cagayan', 173, 1),
(2840, 'Caraga', 173, 1),
(2841, 'Central Luzon', 173, 1),
(2842, 'Central Mindanao', 173, 1),
(2843, 'Central Visayas', 173, 1),
(2844, 'Cordillera', 173, 1),
(2845, 'Davao', 173, 1),
(2846, 'Eastern Visayas', 173, 1),
(2847, 'Greater Metropolitan Area', 173, 1),
(2848, 'Ilocos', 173, 1),
(2849, 'Laguna', 173, 1),
(2850, 'Luzon', 173, 1),
(2851, 'Mactan', 173, 1),
(2852, 'Metropolitan Manila Area', 173, 1),
(2853, 'Muslim Mindanao', 173, 1),
(2854, 'Northern Mindanao', 173, 1),
(2855, 'Southern Mindanao', 173, 1),
(2856, 'Southern Tagalog', 173, 1),
(2857, 'Western Mindanao', 173, 1),
(2858, 'Western Visayas', 173, 1),
(2859, 'Pitcairn Island', 174, 1),
(2860, 'Biale Blota', 175, 1),
(2861, 'Dobroszyce', 175, 1),
(2862, 'Dolnoslaskie', 175, 1),
(2863, 'Dziekanow Lesny', 175, 1),
(2864, 'Hopowo', 175, 1),
(2865, 'Kartuzy', 175, 1),
(2866, 'Koscian', 175, 1),
(2867, 'Krakow', 175, 1),
(2868, 'Kujawsko-Pomorskie', 175, 1),
(2869, 'Lodzkie', 175, 1),
(2870, 'Lubelskie', 175, 1),
(2871, 'Lubuskie', 175, 1),
(2872, 'Malomice', 175, 1),
(2873, 'Malopolskie', 175, 1),
(2874, 'Mazowieckie', 175, 1),
(2875, 'Mirkow', 175, 1),
(2876, 'Opolskie', 175, 1),
(2877, 'Ostrowiec', 175, 1),
(2878, 'Podkarpackie', 175, 1),
(2879, 'Podlaskie', 175, 1),
(2880, 'Polska', 175, 1),
(2881, 'Pomorskie', 175, 1),
(2882, 'Poznan', 175, 1),
(2883, 'Pruszkow', 175, 1),
(2884, 'Rymanowska', 175, 1),
(2885, 'Rzeszow', 175, 1),
(2886, 'Slaskie', 175, 1),
(2887, 'Stare Pole', 175, 1),
(2888, 'Swietokrzyskie', 175, 1),
(2889, 'Warminsko-Mazurskie', 175, 1),
(2890, 'Warsaw', 175, 1),
(2891, 'Wejherowo', 175, 1),
(2892, 'Wielkopolskie', 175, 1),
(2893, 'Wroclaw', 175, 1),
(2894, 'Zachodnio-Pomorskie', 175, 1),
(2895, 'Zukowo', 175, 1),
(2896, 'Abrantes', 176, 1),
(2897, 'Acores', 176, 1),
(2898, 'Alentejo', 176, 1),
(2899, 'Algarve', 176, 1),
(2900, 'Braga', 176, 1),
(2901, 'Centro', 176, 1),
(2902, 'Distrito de Leiria', 176, 1),
(2903, 'Distrito de Viana do Castelo', 176, 1),
(2904, 'Distrito de Vila Real', 176, 1),
(2905, 'Distrito do Porto', 176, 1),
(2906, 'Lisboa e Vale do Tejo', 176, 1),
(2907, 'Madeira', 176, 1),
(2908, 'Norte', 176, 1),
(2909, 'Paivas', 176, 1),
(2910, 'Arecibo', 177, 1),
(2911, 'Bayamon', 177, 1),
(2912, 'Carolina', 177, 1),
(2913, 'Florida', 177, 1),
(2914, 'Guayama', 177, 1),
(2915, 'Humacao', 177, 1),
(2916, 'Mayaguez-Aguadilla', 177, 1),
(2917, 'Ponce', 177, 1),
(2918, 'Salinas', 177, 1),
(2919, 'San Juan', 177, 1),
(2920, 'Doha', 178, 1),
(2921, 'Jarian-al-Batnah', 178, 1),
(2922, 'Umm Salal', 178, 1),
(2923, 'ad-Dawhah', 178, 1),
(2924, 'al-Ghuwayriyah', 178, 1),
(2925, 'al-Jumayliyah', 178, 1),
(2926, 'al-Khawr', 178, 1),
(2927, 'al-Wakrah', 178, 1),
(2928, 'ar-Rayyan', 178, 1),
(2929, 'ash-Shamal', 178, 1),
(2930, 'Saint-Benoit', 179, 1),
(2931, 'Saint-Denis', 179, 1),
(2932, 'Saint-Paul', 179, 1),
(2933, 'Saint-Pierre', 179, 1),
(2934, 'Alba', 180, 1),
(2935, 'Arad', 180, 1),
(2936, 'Arges', 180, 1),
(2937, 'Bacau', 180, 1),
(2938, 'Bihor', 180, 1),
(2939, 'Bistrita-Nasaud', 180, 1),
(2940, 'Botosani', 180, 1),
(2941, 'Braila', 180, 1),
(2942, 'Brasov', 180, 1),
(2943, 'Bucuresti', 180, 1),
(2944, 'Buzau', 180, 1),
(2945, 'Calarasi', 180, 1),
(2946, 'Caras-Severin', 180, 1),
(2947, 'Cluj', 180, 1),
(2948, 'Constanta', 180, 1),
(2949, 'Covasna', 180, 1),
(2950, 'Dambovita', 180, 1),
(2951, 'Dolj', 180, 1),
(2952, 'Galati', 180, 1),
(2953, 'Giurgiu', 180, 1),
(2954, 'Gorj', 180, 1),
(2955, 'Harghita', 180, 1),
(2956, 'Hunedoara', 180, 1),
(2957, 'Ialomita', 180, 1),
(2958, 'Iasi', 180, 1),
(2959, 'Ilfov', 180, 1),
(2960, 'Maramures', 180, 1),
(2961, 'Mehedinti', 180, 1),
(2962, 'Mures', 180, 1),
(2963, 'Neamt', 180, 1),
(2964, 'Olt', 180, 1),
(2965, 'Prahova', 180, 1),
(2966, 'Salaj', 180, 1),
(2967, 'Satu Mare', 180, 1),
(2968, 'Sibiu', 180, 1),
(2969, 'Sondelor', 180, 1),
(2970, 'Suceava', 180, 1),
(2971, 'Teleorman', 180, 1),
(2972, 'Timis', 180, 1),
(2973, 'Tulcea', 180, 1),
(2974, 'Valcea', 180, 1),
(2975, 'Vaslui', 180, 1),
(2976, 'Vrancea', 180, 1),
(2977, 'Adygeja', 181, 1),
(2978, 'Aga', 181, 1),
(2979, 'Alanija', 181, 1),
(2980, 'Altaj', 181, 1),
(2981, 'Amur', 181, 1),
(2982, 'Arhangelsk', 181, 1),
(2983, 'Astrahan', 181, 1),
(2984, 'Bashkortostan', 181, 1),
(2985, 'Belgorod', 181, 1),
(2986, 'Brjansk', 181, 1),
(2987, 'Burjatija', 181, 1),
(2988, 'Chechenija', 181, 1),
(2989, 'Cheljabinsk', 181, 1),
(2990, 'Chita', 181, 1),
(2991, 'Chukotka', 181, 1),
(2992, 'Chuvashija', 181, 1),
(2993, 'Dagestan', 181, 1),
(2994, 'Evenkija', 181, 1),
(2995, 'Gorno-Altaj', 181, 1),
(2996, 'Habarovsk', 181, 1),
(2997, 'Hakasija', 181, 1),
(2998, 'Hanty-Mansija', 181, 1),
(2999, 'Ingusetija', 181, 1),
(3000, 'Irkutsk', 181, 1),
(3001, 'Ivanovo', 181, 1),
(3002, 'Jamalo-Nenets', 181, 1),
(3003, 'Jaroslavl', 181, 1),
(3004, 'Jevrej', 181, 1),
(3005, 'Kabardino-Balkarija', 181, 1),
(3006, 'Kaliningrad', 181, 1),
(3007, 'Kalmykija', 181, 1),
(3008, 'Kaluga', 181, 1),
(3009, 'Kamchatka', 181, 1),
(3010, 'Karachaj-Cherkessija', 181, 1),
(3011, 'Karelija', 181, 1),
(3012, 'Kemerovo', 181, 1),
(3013, 'Khabarovskiy Kray', 181, 1),
(3014, 'Kirov', 181, 1),
(3015, 'Komi', 181, 1),
(3016, 'Komi-Permjakija', 181, 1),
(3017, 'Korjakija', 181, 1),
(3018, 'Kostroma', 181, 1),
(3019, 'Krasnodar', 181, 1),
(3020, 'Krasnojarsk', 181, 1),
(3021, 'Krasnoyarskiy Kray', 181, 1),
(3022, 'Kurgan', 181, 1),
(3023, 'Kursk', 181, 1),
(3024, 'Leningrad', 181, 1),
(3025, 'Lipeck', 181, 1),
(3026, 'Magadan', 181, 1),
(3027, 'Marij El', 181, 1),
(3028, 'Mordovija', 181, 1),
(3029, 'Moscow', 181, 1),
(3030, 'Moskovskaja Oblast', 181, 1),
(3031, 'Moskovskaya Oblast', 181, 1),
(3032, 'Moskva', 181, 1),
(3033, 'Murmansk', 181, 1),
(3034, 'Nenets', 181, 1),
(3035, 'Nizhnij Novgorod', 181, 1),
(3036, 'Novgorod', 181, 1),
(3037, 'Novokusnezk', 181, 1),
(3038, 'Novosibirsk', 181, 1),
(3039, 'Omsk', 181, 1),
(3040, 'Orenburg', 181, 1),
(3041, 'Orjol', 181, 1),
(3042, 'Penza', 181, 1),
(3043, 'Perm', 181, 1),
(3044, 'Primorje', 181, 1),
(3045, 'Pskov', 181, 1),
(3046, 'Pskovskaya Oblast', 181, 1),
(3047, 'Rjazan', 181, 1),
(3048, 'Rostov', 181, 1),
(3049, 'Saha', 181, 1),
(3050, 'Sahalin', 181, 1),
(3051, 'Samara', 181, 1),
(3052, 'Samarskaya', 181, 1),
(3053, 'Sankt-Peterburg', 181, 1),
(3054, 'Saratov', 181, 1),
(3055, 'Smolensk', 181, 1),
(3056, 'Stavropol', 181, 1),
(3057, 'Sverdlovsk', 181, 1),
(3058, 'Tajmyrija', 181, 1),
(3059, 'Tambov', 181, 1),
(3060, 'Tatarstan', 181, 1),
(3061, 'Tjumen', 181, 1),
(3062, 'Tomsk', 181, 1),
(3063, 'Tula', 181, 1),
(3064, 'Tver', 181, 1),
(3065, 'Tyva', 181, 1),
(3066, 'Udmurtija', 181, 1),
(3067, 'Uljanovsk', 181, 1),
(3068, 'Ulyanovskaya Oblast', 181, 1),
(3069, 'Ust-Orda', 181, 1),
(3070, 'Vladimir', 181, 1),
(3071, 'Volgograd', 181, 1),
(3072, 'Vologda', 181, 1),
(3073, 'Voronezh', 181, 1),
(3074, 'Butare', 182, 1),
(3075, 'Byumba', 182, 1),
(3076, 'Cyangugu', 182, 1),
(3077, 'Gikongoro', 182, 1),
(3078, 'Gisenyi', 182, 1),
(3079, 'Gitarama', 182, 1),
(3080, 'Kibungo', 182, 1),
(3081, 'Kibuye', 182, 1),
(3082, 'Kigali-ngali', 182, 1),
(3083, 'Ruhengeri', 182, 1),
(3084, 'Ascension', 183, 1),
(3085, 'Gough Island', 183, 1),
(3086, 'Saint Helena', 183, 1),
(3087, 'Tristan da Cunha', 183, 1),
(3088, 'Christ Church Nichola Town', 184, 1),
(3089, 'Saint Anne Sandy Point', 184, 1),
(3090, 'Saint George Basseterre', 184, 1),
(3091, 'Saint George Gingerland', 184, 1),
(3092, 'Saint James Windward', 184, 1),
(3093, 'Saint John Capesterre', 184, 1),
(3094, 'Saint John Figtree', 184, 1),
(3095, 'Saint Mary Cayon', 184, 1),
(3096, 'Saint Paul Capesterre', 184, 1),
(3097, 'Saint Paul Charlestown', 184, 1),
(3098, 'Saint Peter Basseterre', 184, 1),
(3099, 'Saint Thomas Lowland', 184, 1),
(3100, 'Saint Thomas Middle Island', 184, 1),
(3101, 'Trinity Palmetto Point', 184, 1),
(3102, 'Anse-la-Raye', 185, 1),
(3103, 'Canaries', 185, 1),
(3104, 'Castries', 185, 1),
(3105, 'Choiseul', 185, 1),
(3106, 'Dennery', 185, 1),
(3107, 'Gros Inlet', 185, 1),
(3108, 'Laborie', 185, 1),
(3109, 'Micoud', 185, 1),
(3110, 'Soufriere', 185, 1),
(3111, 'Vieux Fort', 185, 1),
(3112, 'Miquelon-Langlade', 186, 1),
(3113, 'Saint-Pierre', 186, 1),
(3114, 'Charlotte', 187, 1),
(3115, 'Grenadines', 187, 1),
(3116, 'Saint Andrew', 187, 1),
(3117, 'Saint David', 187, 1),
(3118, 'Saint George', 187, 1),
(3119, 'Saint Patrick', 187, 1),
(3120, 'A\'ana', 188, 1),
(3121, 'Aiga-i-le-Tai', 188, 1),
(3122, 'Atua', 188, 1),
(3123, 'Fa\'asaleleaga', 188, 1),
(3124, 'Gaga\'emauga', 188, 1),
(3125, 'Gagaifomauga', 188, 1),
(3126, 'Palauli', 188, 1),
(3127, 'Satupa\'itea', 188, 1),
(3128, 'Tuamasaga', 188, 1),
(3129, 'Va\'a-o-Fonoti', 188, 1),
(3130, 'Vaisigano', 188, 1),
(3131, 'Acquaviva', 189, 1),
(3132, 'Borgo Maggiore', 189, 1),
(3133, 'Chiesanuova', 189, 1),
(3134, 'Domagnano', 189, 1),
(3135, 'Faetano', 189, 1),
(3136, 'Fiorentino', 189, 1),
(3137, 'Montegiardino', 189, 1),
(3138, 'San Marino', 189, 1),
(3139, 'Serravalle', 189, 1),
(3140, 'Agua Grande', 190, 1),
(3141, 'Cantagalo', 190, 1),
(3142, 'Lemba', 190, 1),
(3143, 'Lobata', 190, 1),
(3144, 'Me-Zochi', 190, 1),
(3145, 'Pague', 190, 1),
(3146, 'Al Khobar', 191, 1),
(3147, 'Aseer', 191, 1),
(3148, 'Ash Sharqiyah', 191, 1),
(3149, 'Asir', 191, 1),
(3150, 'Central Province', 191, 1),
(3151, 'Eastern Province', 191, 1),
(3152, 'Ha\'il', 191, 1),
(3153, 'Jawf', 191, 1),
(3154, 'Jizan', 191, 1),
(3155, 'Makkah', 191, 1),
(3156, 'Najran', 191, 1),
(3157, 'Qasim', 191, 1),
(3158, 'Tabuk', 191, 1),
(3159, 'Western Province', 191, 1),
(3160, 'al-Bahah', 191, 1),
(3161, 'al-Hudud-ash-Shamaliyah', 191, 1),
(3162, 'al-Madinah', 191, 1),
(3163, 'ar-Riyad', 191, 1),
(3164, 'Dakar', 192, 1),
(3165, 'Diourbel', 192, 1),
(3166, 'Fatick', 192, 1),
(3167, 'Kaolack', 192, 1),
(3168, 'Kolda', 192, 1),
(3169, 'Louga', 192, 1),
(3170, 'Saint-Louis', 192, 1),
(3171, 'Tambacounda', 192, 1),
(3172, 'Thies', 192, 1),
(3173, 'Ziguinchor', 192, 1),
(3174, 'Central Serbia', 193, 1),
(3175, 'Kosovo and Metohija', 193, 1),
(3176, 'Vojvodina', 193, 1),
(3177, 'Anse Boileau', 194, 1),
(3178, 'Anse Royale', 194, 1),
(3179, 'Cascade', 194, 1),
(3180, 'Takamaka', 194, 1),
(3181, 'Victoria', 194, 1),
(3182, 'Eastern', 195, 1),
(3183, 'Northern', 195, 1),
(3184, 'Southern', 195, 1),
(3185, 'Western', 195, 1),
(3186, 'Singapore', 196, 1),
(3187, 'Banskobystricky', 197, 1),
(3188, 'Bratislavsky', 197, 1),
(3189, 'Kosicky', 197, 1),
(3190, 'Nitriansky', 197, 1),
(3191, 'Presovsky', 197, 1),
(3192, 'Trenciansky', 197, 1),
(3193, 'Trnavsky', 197, 1),
(3194, 'Zilinsky', 197, 1),
(3195, 'Benedikt', 198, 1),
(3196, 'Gorenjska', 198, 1),
(3197, 'Gorishka', 198, 1),
(3198, 'Jugovzhodna Slovenija', 198, 1),
(3199, 'Koroshka', 198, 1),
(3200, 'Notranjsko-krashka', 198, 1),
(3201, 'Obalno-krashka', 198, 1),
(3202, 'Obcina Domzale', 198, 1),
(3203, 'Obcina Vitanje', 198, 1),
(3204, 'Osrednjeslovenska', 198, 1),
(3205, 'Podravska', 198, 1),
(3206, 'Pomurska', 198, 1),
(3207, 'Savinjska', 198, 1),
(3208, 'Slovenian Littoral', 198, 1),
(3209, 'Spodnjeposavska', 198, 1),
(3210, 'Zasavska', 198, 1),
(3211, 'Pitcairn', 199, 1),
(3212, 'Central', 200, 1),
(3213, 'Choiseul', 200, 1),
(3214, 'Guadalcanal', 200, 1),
(3215, 'Isabel', 200, 1),
(3216, 'Makira and Ulawa', 200, 1),
(3217, 'Malaita', 200, 1),
(3218, 'Rennell and Bellona', 200, 1),
(3219, 'Temotu', 200, 1),
(3220, 'Western', 200, 1),
(3221, 'Awdal', 201, 1),
(3222, 'Bakol', 201, 1),
(3223, 'Banadir', 201, 1),
(3224, 'Bari', 201, 1),
(3225, 'Bay', 201, 1),
(3226, 'Galgudug', 201, 1),
(3227, 'Gedo', 201, 1),
(3228, 'Hiran', 201, 1),
(3229, 'Jubbada Hose', 201, 1),
(3230, 'Jubbadha Dexe', 201, 1),
(3231, 'Mudug', 201, 1),
(3232, 'Nugal', 201, 1),
(3233, 'Sanag', 201, 1),
(3234, 'Shabellaha Dhexe', 201, 1),
(3235, 'Shabellaha Hose', 201, 1),
(3236, 'Togdher', 201, 1),
(3237, 'Woqoyi Galbed', 201, 1),
(3238, 'Eastern Cape', 202, 1),
(3239, 'Free State', 202, 1),
(3240, 'Gauteng', 202, 1),
(3241, 'Kempton Park', 202, 1),
(3242, 'Kramerville', 202, 1),
(3243, 'KwaZulu Natal', 202, 1),
(3244, 'Limpopo', 202, 1),
(3245, 'Mpumalanga', 202, 1),
(3246, 'North West', 202, 1),
(3247, 'Northern Cape', 202, 1),
(3248, 'Parow', 202, 1),
(3249, 'Table View', 202, 1),
(3250, 'Umtentweni', 202, 1),
(3251, 'Western Cape', 202, 1),
(3252, 'South Georgia', 203, 1),
(3253, 'Central Equatoria', 204, 1),
(3254, 'A Coruna', 205, 1),
(3255, 'Alacant', 205, 1),
(3256, 'Alava', 205, 1),
(3257, 'Albacete', 205, 1),
(3258, 'Almeria', 205, 1),
(3259, 'Andalucia', 205, 1),
(3260, 'Asturias', 205, 1),
(3261, 'Avila', 205, 1),
(3262, 'Badajoz', 205, 1),
(3263, 'Balears', 205, 1),
(3264, 'Barcelona', 205, 1),
(3265, 'Bertamirans', 205, 1),
(3266, 'Biscay', 205, 1),
(3267, 'Burgos', 205, 1),
(3268, 'Caceres', 205, 1),
(3269, 'Cadiz', 205, 1),
(3270, 'Cantabria', 205, 1),
(3271, 'Castello', 205, 1),
(3272, 'Catalunya', 205, 1),
(3273, 'Ceuta', 205, 1),
(3274, 'Ciudad Real', 205, 1),
(3275, 'Comunidad Autonoma de Canarias', 205, 1),
(3276, 'Comunidad Autonoma de Cataluna', 205, 1),
(3277, 'Comunidad Autonoma de Galicia', 205, 1),
(3278, 'Comunidad Autonoma de las Isla', 205, 1),
(3279, 'Comunidad Autonoma del Princip', 205, 1),
(3280, 'Comunidad Valenciana', 205, 1),
(3281, 'Cordoba', 205, 1),
(3282, 'Cuenca', 205, 1),
(3283, 'Gipuzkoa', 205, 1),
(3284, 'Girona', 205, 1),
(3285, 'Granada', 205, 1),
(3286, 'Guadalajara', 205, 1),
(3287, 'Guipuzcoa', 205, 1),
(3288, 'Huelva', 205, 1),
(3289, 'Huesca', 205, 1),
(3290, 'Jaen', 205, 1),
(3291, 'La Rioja', 205, 1),
(3292, 'Las Palmas', 205, 1),
(3293, 'Leon', 205, 1),
(3294, 'Lerida', 205, 1),
(3295, 'Lleida', 205, 1),
(3296, 'Lugo', 205, 1),
(3297, 'Madrid', 205, 1),
(3298, 'Malaga', 205, 1),
(3299, 'Melilla', 205, 1),
(3300, 'Murcia', 205, 1),
(3301, 'Navarra', 205, 1),
(3302, 'Ourense', 205, 1),
(3303, 'Pais Vasco', 205, 1),
(3304, 'Palencia', 205, 1),
(3305, 'Pontevedra', 205, 1),
(3306, 'Salamanca', 205, 1),
(3307, 'Santa Cruz de Tenerife', 205, 1),
(3308, 'Segovia', 205, 1),
(3309, 'Sevilla', 205, 1),
(3310, 'Soria', 205, 1),
(3311, 'Tarragona', 205, 1),
(3312, 'Tenerife', 205, 1),
(3313, 'Teruel', 205, 1),
(3314, 'Toledo', 205, 1),
(3315, 'Valencia', 205, 1),
(3316, 'Valladolid', 205, 1),
(3317, 'Vizcaya', 205, 1),
(3318, 'Zamora', 205, 1),
(3319, 'Zaragoza', 205, 1),
(3320, 'Amparai', 206, 1),
(3321, 'Anuradhapuraya', 206, 1),
(3322, 'Badulla', 206, 1),
(3323, 'Boralesgamuwa', 206, 1),
(3324, 'Colombo', 206, 1),
(3325, 'Galla', 206, 1),
(3326, 'Gampaha', 206, 1),
(3327, 'Hambantota', 206, 1),
(3328, 'Kalatura', 206, 1),
(3329, 'Kegalla', 206, 1),
(3330, 'Kilinochchi', 206, 1),
(3331, 'Kurunegala', 206, 1),
(3332, 'Madakalpuwa', 206, 1),
(3333, 'Maha Nuwara', 206, 1),
(3334, 'Malwana', 206, 1),
(3335, 'Mannarama', 206, 1),
(3336, 'Matale', 206, 1),
(3337, 'Matara', 206, 1),
(3338, 'Monaragala', 206, 1),
(3339, 'Mullaitivu', 206, 1),
(3340, 'North Eastern Province', 206, 1),
(3341, 'North Western Province', 206, 1),
(3342, 'Nuwara Eliya', 206, 1),
(3343, 'Polonnaruwa', 206, 1),
(3344, 'Puttalama', 206, 1),
(3345, 'Ratnapuraya', 206, 1),
(3346, 'Southern Province', 206, 1),
(3347, 'Tirikunamalaya', 206, 1),
(3348, 'Tuscany', 206, 1),
(3349, 'Vavuniyawa', 206, 1),
(3350, 'Western Province', 206, 1),
(3351, 'Yapanaya', 206, 1),
(3352, 'kadawatha', 206, 1),
(3353, 'A\'ali-an-Nil', 207, 1),
(3354, 'Bahr-al-Jabal', 207, 1),
(3355, 'Central Equatoria', 207, 1),
(3356, 'Gharb Bahr-al-Ghazal', 207, 1),
(3357, 'Gharb Darfur', 207, 1),
(3358, 'Gharb Kurdufan', 207, 1),
(3359, 'Gharb-al-Istiwa\'iyah', 207, 1),
(3360, 'Janub Darfur', 207, 1),
(3361, 'Janub Kurdufan', 207, 1),
(3362, 'Junqali', 207, 1),
(3363, 'Kassala', 207, 1),
(3364, 'Nahr-an-Nil', 207, 1),
(3365, 'Shamal Bahr-al-Ghazal', 207, 1),
(3366, 'Shamal Darfur', 207, 1),
(3367, 'Shamal Kurdufan', 207, 1),
(3368, 'Sharq-al-Istiwa\'iyah', 207, 1),
(3369, 'Sinnar', 207, 1),
(3370, 'Warab', 207, 1),
(3371, 'Wilayat al Khartum', 207, 1),
(3372, 'al-Bahr-al-Ahmar', 207, 1),
(3373, 'al-Buhayrat', 207, 1),
(3374, 'al-Jazirah', 207, 1),
(3375, 'al-Khartum', 207, 1),
(3376, 'al-Qadarif', 207, 1),
(3377, 'al-Wahdah', 207, 1),
(3378, 'an-Nil-al-Abyad', 207, 1),
(3379, 'an-Nil-al-Azraq', 207, 1),
(3380, 'ash-Shamaliyah', 207, 1),
(3381, 'Brokopondo', 208, 1),
(3382, 'Commewijne', 208, 1),
(3383, 'Coronie', 208, 1),
(3384, 'Marowijne', 208, 1),
(3385, 'Nickerie', 208, 1),
(3386, 'Para', 208, 1),
(3387, 'Paramaribo', 208, 1),
(3388, 'Saramacca', 208, 1),
(3389, 'Wanica', 208, 1),
(3390, 'Svalbard', 209, 1),
(3391, 'Hhohho', 210, 1),
(3392, 'Lubombo', 210, 1),
(3393, 'Manzini', 210, 1),
(3394, 'Shiselweni', 210, 1),
(3395, 'Alvsborgs Lan', 211, 1),
(3396, 'Angermanland', 211, 1),
(3397, 'Blekinge', 211, 1),
(3398, 'Bohuslan', 211, 1),
(3399, 'Dalarna', 211, 1),
(3400, 'Gavleborg', 211, 1),
(3401, 'Gaza', 211, 1),
(3402, 'Gotland', 211, 1),
(3403, 'Halland', 211, 1),
(3404, 'Jamtland', 211, 1),
(3405, 'Jonkoping', 211, 1),
(3406, 'Kalmar', 211, 1),
(3407, 'Kristianstads', 211, 1),
(3408, 'Kronoberg', 211, 1),
(3409, 'Norrbotten', 211, 1),
(3410, 'Orebro', 211, 1),
(3411, 'Ostergotland', 211, 1),
(3412, 'Saltsjo-Boo', 211, 1),
(3413, 'Skane', 211, 1),
(3414, 'Smaland', 211, 1),
(3415, 'Sodermanland', 211, 1),
(3416, 'Stockholm', 211, 1),
(3417, 'Uppsala', 211, 1),
(3418, 'Varmland', 211, 1),
(3419, 'Vasterbotten', 211, 1),
(3420, 'Vastergotland', 211, 1),
(3421, 'Vasternorrland', 211, 1),
(3422, 'Vastmanland', 211, 1),
(3423, 'Vastra Gotaland', 211, 1),
(3424, 'Aargau', 212, 1),
(3425, 'Appenzell Inner-Rhoden', 212, 1),
(3426, 'Appenzell-Ausser Rhoden', 212, 1),
(3427, 'Basel-Landschaft', 212, 1),
(3428, 'Basel-Stadt', 212, 1),
(3429, 'Bern', 212, 1),
(3430, 'Canton Ticino', 212, 1),
(3431, 'Fribourg', 212, 1),
(3432, 'Geneve', 212, 1),
(3433, 'Glarus', 212, 1),
(3434, 'Graubunden', 212, 1),
(3435, 'Heerbrugg', 212, 1),
(3436, 'Jura', 212, 1),
(3437, 'Kanton Aargau', 212, 1),
(3438, 'Luzern', 212, 1),
(3439, 'Morbio Inferiore', 212, 1),
(3440, 'Muhen', 212, 1),
(3441, 'Neuchatel', 212, 1),
(3442, 'Nidwalden', 212, 1),
(3443, 'Obwalden', 212, 1),
(3444, 'Sankt Gallen', 212, 1),
(3445, 'Schaffhausen', 212, 1),
(3446, 'Schwyz', 212, 1),
(3447, 'Solothurn', 212, 1),
(3448, 'Thurgau', 212, 1),
(3449, 'Ticino', 212, 1),
(3450, 'Uri', 212, 1),
(3451, 'Valais', 212, 1),
(3452, 'Vaud', 212, 1),
(3453, 'Vauffelin', 212, 1),
(3454, 'Zug', 212, 1),
(3455, 'Zurich', 212, 1),
(3456, 'Aleppo', 213, 1),
(3457, 'Dar\'a', 213, 1),
(3458, 'Dayr-az-Zawr', 213, 1),
(3459, 'Dimashq', 213, 1),
(3460, 'Halab', 213, 1),
(3461, 'Hamah', 213, 1),
(3462, 'Hims', 213, 1),
(3463, 'Idlib', 213, 1),
(3464, 'Madinat Dimashq', 213, 1),
(3465, 'Tartus', 213, 1),
(3466, 'al-Hasakah', 213, 1),
(3467, 'al-Ladhiqiyah', 213, 1),
(3468, 'al-Qunaytirah', 213, 1),
(3469, 'ar-Raqqah', 213, 1),
(3470, 'as-Suwayda', 213, 1),
(3471, 'Changhwa', 214, 1),
(3472, 'Chiayi Hsien', 214, 1),
(3473, 'Chiayi Shih', 214, 1),
(3474, 'Eastern Taipei', 214, 1),
(3475, 'Hsinchu Hsien', 214, 1),
(3476, 'Hsinchu Shih', 214, 1),
(3477, 'Hualien', 214, 1),
(3478, 'Ilan', 214, 1),
(3479, 'Kaohsiung Hsien', 214, 1),
(3480, 'Kaohsiung Shih', 214, 1),
(3481, 'Keelung Shih', 214, 1),
(3482, 'Kinmen', 214, 1),
(3483, 'Miaoli', 214, 1),
(3484, 'Nantou', 214, 1),
(3485, 'Northern Taiwan', 214, 1),
(3486, 'Penghu', 214, 1),
(3487, 'Pingtung', 214, 1),
(3488, 'Taichung', 214, 1),
(3489, 'Taichung Hsien', 214, 1),
(3490, 'Taichung Shih', 214, 1),
(3491, 'Tainan Hsien', 214, 1),
(3492, 'Tainan Shih', 214, 1),
(3493, 'Taipei Hsien', 214, 1),
(3494, 'Taipei Shih / Taipei Hsien', 214, 1),
(3495, 'Taitung', 214, 1),
(3496, 'Taoyuan', 214, 1),
(3497, 'Yilan', 214, 1),
(3498, 'Yun-Lin Hsien', 214, 1),
(3499, 'Yunlin', 214, 1),
(3500, 'Dushanbe', 215, 1),
(3501, 'Gorno-Badakhshan', 215, 1),
(3502, 'Karotegin', 215, 1),
(3503, 'Khatlon', 215, 1),
(3504, 'Sughd', 215, 1),
(3505, 'Arusha', 216, 1),
(3506, 'Dar es Salaam', 216, 1),
(3507, 'Dodoma', 216, 1),
(3508, 'Iringa', 216, 1),
(3509, 'Kagera', 216, 1),
(3510, 'Kigoma', 216, 1),
(3511, 'Kilimanjaro', 216, 1),
(3512, 'Lindi', 216, 1),
(3513, 'Mara', 216, 1),
(3514, 'Mbeya', 216, 1),
(3515, 'Morogoro', 216, 1),
(3516, 'Mtwara', 216, 1),
(3517, 'Mwanza', 216, 1),
(3518, 'Pwani', 216, 1),
(3519, 'Rukwa', 216, 1),
(3520, 'Ruvuma', 216, 1),
(3521, 'Shinyanga', 216, 1),
(3522, 'Singida', 216, 1),
(3523, 'Tabora', 216, 1),
(3524, 'Tanga', 216, 1),
(3525, 'Zanzibar and Pemba', 216, 1),
(3526, 'Amnat Charoen', 217, 1),
(3527, 'Ang Thong', 217, 1),
(3528, 'Bangkok', 217, 1),
(3529, 'Buri Ram', 217, 1),
(3530, 'Chachoengsao', 217, 1),
(3531, 'Chai Nat', 217, 1),
(3532, 'Chaiyaphum', 217, 1),
(3533, 'Changwat Chaiyaphum', 217, 1),
(3534, 'Chanthaburi', 217, 1),
(3535, 'Chiang Mai', 217, 1),
(3536, 'Chiang Rai', 217, 1),
(3537, 'Chon Buri', 217, 1),
(3538, 'Chumphon', 217, 1),
(3539, 'Kalasin', 217, 1),
(3540, 'Kamphaeng Phet', 217, 1),
(3541, 'Kanchanaburi', 217, 1),
(3542, 'Khon Kaen', 217, 1),
(3543, 'Krabi', 217, 1),
(3544, 'Krung Thep', 217, 1),
(3545, 'Lampang', 217, 1),
(3546, 'Lamphun', 217, 1),
(3547, 'Loei', 217, 1),
(3548, 'Lop Buri', 217, 1),
(3549, 'Mae Hong Son', 217, 1),
(3550, 'Maha Sarakham', 217, 1),
(3551, 'Mukdahan', 217, 1),
(3552, 'Nakhon Nayok', 217, 1),
(3553, 'Nakhon Pathom', 217, 1),
(3554, 'Nakhon Phanom', 217, 1),
(3555, 'Nakhon Ratchasima', 217, 1),
(3556, 'Nakhon Sawan', 217, 1),
(3557, 'Nakhon Si Thammarat', 217, 1),
(3558, 'Nan', 217, 1),
(3559, 'Narathiwat', 217, 1),
(3560, 'Nong Bua Lam Phu', 217, 1),
(3561, 'Nong Khai', 217, 1),
(3562, 'Nonthaburi', 217, 1),
(3563, 'Pathum Thani', 217, 1),
(3564, 'Pattani', 217, 1),
(3565, 'Phangnga', 217, 1),
(3566, 'Phatthalung', 217, 1),
(3567, 'Phayao', 217, 1),
(3568, 'Phetchabun', 217, 1),
(3569, 'Phetchaburi', 217, 1),
(3570, 'Phichit', 217, 1),
(3571, 'Phitsanulok', 217, 1),
(3572, 'Phra Nakhon Si Ayutthaya', 217, 1),
(3573, 'Phrae', 217, 1),
(3574, 'Phuket', 217, 1),
(3575, 'Prachin Buri', 217, 1),
(3576, 'Prachuap Khiri Khan', 217, 1),
(3577, 'Ranong', 217, 1),
(3578, 'Ratchaburi', 217, 1),
(3579, 'Rayong', 217, 1),
(3580, 'Roi Et', 217, 1),
(3581, 'Sa Kaeo', 217, 1),
(3582, 'Sakon Nakhon', 217, 1),
(3583, 'Samut Prakan', 217, 1),
(3584, 'Samut Sakhon', 217, 1),
(3585, 'Samut Songkhran', 217, 1),
(3586, 'Saraburi', 217, 1),
(3587, 'Satun', 217, 1),
(3588, 'Si Sa Ket', 217, 1),
(3589, 'Sing Buri', 217, 1),
(3590, 'Songkhla', 217, 1),
(3591, 'Sukhothai', 217, 1),
(3592, 'Suphan Buri', 217, 1),
(3593, 'Surat Thani', 217, 1),
(3594, 'Surin', 217, 1),
(3595, 'Tak', 217, 1),
(3596, 'Trang', 217, 1),
(3597, 'Trat', 217, 1),
(3598, 'Ubon Ratchathani', 217, 1),
(3599, 'Udon Thani', 217, 1),
(3600, 'Uthai Thani', 217, 1),
(3601, 'Uttaradit', 217, 1),
(3602, 'Yala', 217, 1),
(3603, 'Yasothon', 217, 1),
(3604, 'Centre', 218, 1),
(3605, 'Kara', 218, 1),
(3606, 'Maritime', 218, 1),
(3607, 'Plateaux', 218, 1),
(3608, 'Savanes', 218, 1),
(3609, 'Atafu', 219, 1),
(3610, 'Fakaofo', 219, 1),
(3611, 'Nukunonu', 219, 1),
(3612, 'Eua', 220, 1),
(3613, 'Ha\'apai', 220, 1),
(3614, 'Niuas', 220, 1),
(3615, 'Tongatapu', 220, 1),
(3616, 'Vava\'u', 220, 1),
(3617, 'Arima-Tunapuna-Piarco', 221, 1),
(3618, 'Caroni', 221, 1),
(3619, 'Chaguanas', 221, 1),
(3620, 'Couva-Tabaquite-Talparo', 221, 1),
(3621, 'Diego Martin', 221, 1),
(3622, 'Glencoe', 221, 1),
(3623, 'Penal Debe', 221, 1),
(3624, 'Point Fortin', 221, 1),
(3625, 'Port of Spain', 221, 1),
(3626, 'Princes Town', 221, 1),
(3627, 'Saint George', 221, 1),
(3628, 'San Fernando', 221, 1),
(3629, 'San Juan', 221, 1),
(3630, 'Sangre Grande', 221, 1),
(3631, 'Siparia', 221, 1),
(3632, 'Tobago', 221, 1),
(3633, 'Aryanah', 222, 1),
(3634, 'Bajah', 222, 1),
(3635, 'Bin \'Arus', 222, 1),
(3636, 'Binzart', 222, 1),
(3637, 'Gouvernorat de Ariana', 222, 1),
(3638, 'Gouvernorat de Nabeul', 222, 1),
(3639, 'Gouvernorat de Sousse', 222, 1),
(3640, 'Hammamet Yasmine', 222, 1),
(3641, 'Jundubah', 222, 1),
(3642, 'Madaniyin', 222, 1),
(3643, 'Manubah', 222, 1),
(3644, 'Monastir', 222, 1),
(3645, 'Nabul', 222, 1),
(3646, 'Qabis', 222, 1),
(3647, 'Qafsah', 222, 1),
(3648, 'Qibili', 222, 1),
(3649, 'Safaqis', 222, 1),
(3650, 'Sfax', 222, 1),
(3651, 'Sidi Bu Zayd', 222, 1),
(3652, 'Silyanah', 222, 1),
(3653, 'Susah', 222, 1),
(3654, 'Tatawin', 222, 1),
(3655, 'Tawzar', 222, 1),
(3656, 'Tunis', 222, 1),
(3657, 'Zaghwan', 222, 1),
(3658, 'al-Kaf', 222, 1),
(3659, 'al-Mahdiyah', 222, 1),
(3660, 'al-Munastir', 222, 1),
(3661, 'al-Qasrayn', 222, 1),
(3662, 'al-Qayrawan', 222, 1),
(3663, 'Adana', 223, 1),
(3664, 'Adiyaman', 223, 1),
(3665, 'Afyon', 223, 1),
(3666, 'Agri', 223, 1),
(3667, 'Aksaray', 223, 1),
(3668, 'Amasya', 223, 1),
(3669, 'Ankara', 223, 1),
(3670, 'Antalya', 223, 1),
(3671, 'Ardahan', 223, 1),
(3672, 'Artvin', 223, 1),
(3673, 'Aydin', 223, 1),
(3674, 'Balikesir', 223, 1),
(3675, 'Bartin', 223, 1),
(3676, 'Batman', 223, 1),
(3677, 'Bayburt', 223, 1),
(3678, 'Bilecik', 223, 1),
(3679, 'Bingol', 223, 1),
(3680, 'Bitlis', 223, 1),
(3681, 'Bolu', 223, 1),
(3682, 'Burdur', 223, 1),
(3683, 'Bursa', 223, 1),
(3684, 'Canakkale', 223, 1),
(3685, 'Cankiri', 223, 1),
(3686, 'Corum', 223, 1),
(3687, 'Denizli', 223, 1),
(3688, 'Diyarbakir', 223, 1),
(3689, 'Duzce', 223, 1),
(3690, 'Edirne', 223, 1),
(3691, 'Elazig', 223, 1),
(3692, 'Erzincan', 223, 1),
(3693, 'Erzurum', 223, 1),
(3694, 'Eskisehir', 223, 1),
(3695, 'Gaziantep', 223, 1),
(3696, 'Giresun', 223, 1),
(3697, 'Gumushane', 223, 1),
(3698, 'Hakkari', 223, 1),
(3699, 'Hatay', 223, 1),
(3700, 'Icel', 223, 1),
(3701, 'Igdir', 223, 1),
(3702, 'Isparta', 223, 1),
(3703, 'Istanbul', 223, 1),
(3704, 'Izmir', 223, 1),
(3705, 'Kahramanmaras', 223, 1),
(3706, 'Karabuk', 223, 1),
(3707, 'Karaman', 223, 1),
(3708, 'Kars', 223, 1),
(3709, 'Karsiyaka', 223, 1),
(3710, 'Kastamonu', 223, 1),
(3711, 'Kayseri', 223, 1),
(3712, 'Kilis', 223, 1),
(3713, 'Kirikkale', 223, 1),
(3714, 'Kirklareli', 223, 1),
(3715, 'Kirsehir', 223, 1),
(3716, 'Kocaeli', 223, 1),
(3717, 'Konya', 223, 1),
(3718, 'Kutahya', 223, 1),
(3719, 'Lefkosa', 223, 1),
(3720, 'Malatya', 223, 1),
(3721, 'Manisa', 223, 1),
(3722, 'Mardin', 223, 1),
(3723, 'Mugla', 223, 1),
(3724, 'Mus', 223, 1),
(3725, 'Nevsehir', 223, 1),
(3726, 'Nigde', 223, 1),
(3727, 'Ordu', 223, 1),
(3728, 'Osmaniye', 223, 1),
(3729, 'Rize', 223, 1),
(3730, 'Sakarya', 223, 1),
(3731, 'Samsun', 223, 1),
(3732, 'Sanliurfa', 223, 1),
(3733, 'Siirt', 223, 1),
(3734, 'Sinop', 223, 1),
(3735, 'Sirnak', 223, 1),
(3736, 'Sivas', 223, 1),
(3737, 'Tekirdag', 223, 1),
(3738, 'Tokat', 223, 1),
(3739, 'Trabzon', 223, 1),
(3740, 'Tunceli', 223, 1),
(3741, 'Usak', 223, 1),
(3742, 'Van', 223, 1),
(3743, 'Yalova', 223, 1),
(3744, 'Yozgat', 223, 1),
(3745, 'Zonguldak', 223, 1),
(3746, 'Ahal', 224, 1),
(3747, 'Asgabat', 224, 1),
(3748, 'Balkan', 224, 1),
(3749, 'Dasoguz', 224, 1),
(3750, 'Lebap', 224, 1),
(3751, 'Mari', 224, 1),
(3752, 'Grand Turk', 225, 1),
(3753, 'South Caicos and East Caicos', 225, 1),
(3754, 'Funafuti', 226, 1),
(3755, 'Nanumanga', 226, 1),
(3756, 'Nanumea', 226, 1),
(3757, 'Niutao', 226, 1),
(3758, 'Nui', 226, 1),
(3759, 'Nukufetau', 226, 1),
(3760, 'Nukulaelae', 226, 1),
(3761, 'Vaitupu', 226, 1),
(3762, 'Central', 227, 1),
(3763, 'Eastern', 227, 1),
(3764, 'Northern', 227, 1),
(3765, 'Western', 227, 1),
(3766, 'Cherkas\'ka', 228, 1),
(3767, 'Chernihivs\'ka', 228, 1),
(3768, 'Chernivets\'ka', 228, 1),
(3769, 'Crimea', 228, 1),
(3770, 'Dnipropetrovska', 228, 1),
(3771, 'Donets\'ka', 228, 1),
(3772, 'Ivano-Frankivs\'ka', 228, 1),
(3773, 'Kharkiv', 228, 1),
(3774, 'Kharkov', 228, 1),
(3775, 'Khersonska', 228, 1),
(3776, 'Khmel\'nyts\'ka', 228, 1),
(3777, 'Kirovohrad', 228, 1),
(3778, 'Krym', 228, 1),
(3779, 'Kyyiv', 228, 1),
(3780, 'Kyyivs\'ka', 228, 1),
(3781, 'L\'vivs\'ka', 228, 1),
(3782, 'Luhans\'ka', 228, 1),
(3783, 'Mykolayivs\'ka', 228, 1),
(3784, 'Odes\'ka', 228, 1),
(3785, 'Odessa', 228, 1),
(3786, 'Poltavs\'ka', 228, 1),
(3787, 'Rivnens\'ka', 228, 1),
(3788, 'Sevastopol\'', 228, 1),
(3789, 'Sums\'ka', 228, 1);
INSERT INTO `states` (`state_id`, `state_name`, `country_id`, `state_status`) VALUES
(3790, 'Ternopil\'s\'ka', 228, 1),
(3791, 'Volyns\'ka', 228, 1),
(3792, 'Vynnyts\'ka', 228, 1),
(3793, 'Zakarpats\'ka', 228, 1),
(3794, 'Zaporizhia', 228, 1),
(3795, 'Zhytomyrs\'ka', 228, 1),
(3796, 'Abu Zabi', 229, 1),
(3797, 'Ajman', 229, 1),
(3798, 'Dubai', 229, 1),
(3799, 'Ras al-Khaymah', 229, 1),
(3800, 'Sharjah', 229, 1),
(3801, 'Sharjha', 229, 1),
(3802, 'Umm al Qaywayn', 229, 1),
(3803, 'al-Fujayrah', 229, 1),
(3804, 'ash-Shariqah', 229, 1),
(3805, 'Aberdeen', 230, 1),
(3806, 'Aberdeenshire', 230, 1),
(3807, 'Argyll', 230, 1),
(3808, 'Armagh', 230, 1),
(3809, 'Bedfordshire', 230, 1),
(3810, 'Belfast', 230, 1),
(3811, 'Berkshire', 230, 1),
(3812, 'Birmingham', 230, 1),
(3813, 'Brechin', 230, 1),
(3814, 'Bridgnorth', 230, 1),
(3815, 'Bristol', 230, 1),
(3816, 'Buckinghamshire', 230, 1),
(3817, 'Cambridge', 230, 1),
(3818, 'Cambridgeshire', 230, 1),
(3819, 'Channel Islands', 230, 1),
(3820, 'Cheshire', 230, 1),
(3821, 'Cleveland', 230, 1),
(3822, 'Co Fermanagh', 230, 1),
(3823, 'Conwy', 230, 1),
(3824, 'Cornwall', 230, 1),
(3825, 'Coventry', 230, 1),
(3826, 'Craven Arms', 230, 1),
(3827, 'Cumbria', 230, 1),
(3828, 'Denbighshire', 230, 1),
(3829, 'Derby', 230, 1),
(3830, 'Derbyshire', 230, 1),
(3831, 'Devon', 230, 1),
(3832, 'Dial Code Dungannon', 230, 1),
(3833, 'Didcot', 230, 1),
(3834, 'Dorset', 230, 1),
(3835, 'Dunbartonshire', 230, 1),
(3836, 'Durham', 230, 1),
(3837, 'East Dunbartonshire', 230, 1),
(3838, 'East Lothian', 230, 1),
(3839, 'East Midlands', 230, 1),
(3840, 'East Sussex', 230, 1),
(3841, 'East Yorkshire', 230, 1),
(3842, 'England', 230, 1),
(3843, 'Essex', 230, 1),
(3844, 'Fermanagh', 230, 1),
(3845, 'Fife', 230, 1),
(3846, 'Flintshire', 230, 1),
(3847, 'Fulham', 230, 1),
(3848, 'Gainsborough', 230, 1),
(3849, 'Glocestershire', 230, 1),
(3850, 'Gwent', 230, 1),
(3851, 'Hampshire', 230, 1),
(3852, 'Hants', 230, 1),
(3853, 'Herefordshire', 230, 1),
(3854, 'Hertfordshire', 230, 1),
(3855, 'Ireland', 230, 1),
(3856, 'Isle Of Man', 230, 1),
(3857, 'Isle of Wight', 230, 1),
(3858, 'Kenford', 230, 1),
(3859, 'Kent', 230, 1),
(3860, 'Kilmarnock', 230, 1),
(3861, 'Lanarkshire', 230, 1),
(3862, 'Lancashire', 230, 1),
(3863, 'Leicestershire', 230, 1),
(3864, 'Lincolnshire', 230, 1),
(3865, 'Llanymynech', 230, 1),
(3866, 'London', 230, 1),
(3867, 'Ludlow', 230, 1),
(3868, 'Manchester', 230, 1),
(3869, 'Mayfair', 230, 1),
(3870, 'Merseyside', 230, 1),
(3871, 'Mid Glamorgan', 230, 1),
(3872, 'Middlesex', 230, 1),
(3873, 'Mildenhall', 230, 1),
(3874, 'Monmouthshire', 230, 1),
(3875, 'Newton Stewart', 230, 1),
(3876, 'Norfolk', 230, 1),
(3877, 'North Humberside', 230, 1),
(3878, 'North Yorkshire', 230, 1),
(3879, 'Northamptonshire', 230, 1),
(3880, 'Northants', 230, 1),
(3881, 'Northern Ireland', 230, 1),
(3882, 'Northumberland', 230, 1),
(3883, 'Nottinghamshire', 230, 1),
(3884, 'Oxford', 230, 1),
(3885, 'Powys', 230, 1),
(3886, 'Roos-shire', 230, 1),
(3887, 'SUSSEX', 230, 1),
(3888, 'Sark', 230, 1),
(3889, 'Scotland', 230, 1),
(3890, 'Scottish Borders', 230, 1),
(3891, 'Shropshire', 230, 1),
(3892, 'Somerset', 230, 1),
(3893, 'South Glamorgan', 230, 1),
(3894, 'South Wales', 230, 1),
(3895, 'South Yorkshire', 230, 1),
(3896, 'Southwell', 230, 1),
(3897, 'Staffordshire', 230, 1),
(3898, 'Strabane', 230, 1),
(3899, 'Suffolk', 230, 1),
(3900, 'Surrey', 230, 1),
(3901, 'Sussex', 230, 1),
(3902, 'Twickenham', 230, 1),
(3903, 'Tyne and Wear', 230, 1),
(3904, 'Tyrone', 230, 1),
(3905, 'Utah', 230, 1),
(3906, 'Wales', 230, 1),
(3907, 'Warwickshire', 230, 1),
(3908, 'West Lothian', 230, 1),
(3909, 'West Midlands', 230, 1),
(3910, 'West Sussex', 230, 1),
(3911, 'West Yorkshire', 230, 1),
(3912, 'Whissendine', 230, 1),
(3913, 'Wiltshire', 230, 1),
(3914, 'Wokingham', 230, 1),
(3915, 'Worcestershire', 230, 1),
(3916, 'Wrexham', 230, 1),
(3917, 'Wurttemberg', 230, 1),
(3918, 'Yorkshire', 230, 1),
(3919, 'Alabama', 231, 1),
(3920, 'Alaska', 231, 1),
(3921, 'Arizona', 231, 1),
(3922, 'Arkansas', 231, 1),
(3923, 'Byram', 231, 1),
(3924, 'California', 231, 1),
(3925, 'Cokato', 231, 1),
(3926, 'Colorado', 231, 1),
(3927, 'Connecticut', 231, 1),
(3928, 'Delaware', 231, 1),
(3929, 'District of Columbia', 231, 1),
(3930, 'Florida', 231, 1),
(3931, 'Georgia', 231, 1),
(3932, 'Hawaii', 231, 1),
(3933, 'Idaho', 231, 1),
(3934, 'Illinois', 231, 1),
(3935, 'Indiana', 231, 1),
(3936, 'Iowa', 231, 1),
(3937, 'Kansas', 231, 1),
(3938, 'Kentucky', 231, 1),
(3939, 'Louisiana', 231, 1),
(3940, 'Lowa', 231, 1),
(3941, 'Maine', 231, 1),
(3942, 'Maryland', 231, 1),
(3943, 'Massachusetts', 231, 1),
(3944, 'Medfield', 231, 1),
(3945, 'Michigan', 231, 1),
(3946, 'Minnesota', 231, 1),
(3947, 'Mississippi', 231, 1),
(3948, 'Missouri', 231, 1),
(3949, 'Montana', 231, 1),
(3950, 'Nebraska', 231, 1),
(3951, 'Nevada', 231, 1),
(3952, 'New Hampshire', 231, 1),
(3953, 'New Jersey', 231, 1),
(3954, 'New Jersy', 231, 1),
(3955, 'New Mexico', 231, 1),
(3956, 'New York', 231, 1),
(3957, 'North Carolina', 231, 1),
(3958, 'North Dakota', 231, 1),
(3959, 'Ohio', 231, 1),
(3960, 'Oklahoma', 231, 1),
(3961, 'Ontario', 231, 1),
(3962, 'Oregon', 231, 1),
(3963, 'Pennsylvania', 231, 1),
(3964, 'Ramey', 231, 1),
(3965, 'Rhode Island', 231, 1),
(3966, 'South Carolina', 231, 1),
(3967, 'South Dakota', 231, 1),
(3968, 'Sublimity', 231, 1),
(3969, 'Tennessee', 231, 1),
(3970, 'Texas', 231, 1),
(3971, 'Trimble', 231, 1),
(3972, 'Utah', 231, 1),
(3973, 'Vermont', 231, 1),
(3974, 'Virginia', 231, 1),
(3975, 'Washington', 231, 1),
(3976, 'West Virginia', 231, 1),
(3977, 'Wisconsin', 231, 1),
(3978, 'Wyoming', 231, 1),
(3979, 'United States Minor Outlying I', 232, 1),
(3980, 'Artigas', 233, 1),
(3981, 'Canelones', 233, 1),
(3982, 'Cerro Largo', 233, 1),
(3983, 'Colonia', 233, 1),
(3984, 'Durazno', 233, 1),
(3985, 'FLorida', 233, 1),
(3986, 'Flores', 233, 1),
(3987, 'Lavalleja', 233, 1),
(3988, 'Maldonado', 233, 1),
(3989, 'Montevideo', 233, 1),
(3990, 'Paysandu', 233, 1),
(3991, 'Rio Negro', 233, 1),
(3992, 'Rivera', 233, 1),
(3993, 'Rocha', 233, 1),
(3994, 'Salto', 233, 1),
(3995, 'San Jose', 233, 1),
(3996, 'Soriano', 233, 1),
(3997, 'Tacuarembo', 233, 1),
(3998, 'Treinta y Tres', 233, 1),
(3999, 'Andijon', 234, 1),
(4000, 'Buhoro', 234, 1),
(4001, 'Buxoro Viloyati', 234, 1),
(4002, 'Cizah', 234, 1),
(4003, 'Fargona', 234, 1),
(4004, 'Horazm', 234, 1),
(4005, 'Kaskadar', 234, 1),
(4006, 'Korakalpogiston', 234, 1),
(4007, 'Namangan', 234, 1),
(4008, 'Navoi', 234, 1),
(4009, 'Samarkand', 234, 1),
(4010, 'Sirdare', 234, 1),
(4011, 'Surhondar', 234, 1),
(4012, 'Toskent', 234, 1),
(4013, 'Malampa', 235, 1),
(4014, 'Penama', 235, 1),
(4015, 'Sanma', 235, 1),
(4016, 'Shefa', 235, 1),
(4017, 'Tafea', 235, 1),
(4018, 'Torba', 235, 1),
(4019, 'Vatican City State (Holy See)', 236, 1),
(4020, 'Amazonas', 237, 1),
(4021, 'Anzoategui', 237, 1),
(4022, 'Apure', 237, 1),
(4023, 'Aragua', 237, 1),
(4024, 'Barinas', 237, 1),
(4025, 'Bolivar', 237, 1),
(4026, 'Carabobo', 237, 1),
(4027, 'Cojedes', 237, 1),
(4028, 'Delta Amacuro', 237, 1),
(4029, 'Distrito Federal', 237, 1),
(4030, 'Falcon', 237, 1),
(4031, 'Guarico', 237, 1),
(4032, 'Lara', 237, 1),
(4033, 'Merida', 237, 1),
(4034, 'Miranda', 237, 1),
(4035, 'Monagas', 237, 1),
(4036, 'Nueva Esparta', 237, 1),
(4037, 'Portuguesa', 237, 1),
(4038, 'Sucre', 237, 1),
(4039, 'Tachira', 237, 1),
(4040, 'Trujillo', 237, 1),
(4041, 'Vargas', 237, 1),
(4042, 'Yaracuy', 237, 1),
(4043, 'Zulia', 237, 1),
(4044, 'Bac Giang', 238, 1),
(4045, 'Binh Dinh', 238, 1),
(4046, 'Binh Duong', 238, 1),
(4047, 'Da Nang', 238, 1),
(4048, 'Dong Bang Song Cuu Long', 238, 1),
(4049, 'Dong Bang Song Hong', 238, 1),
(4050, 'Dong Nai', 238, 1),
(4051, 'Dong Nam Bo', 238, 1),
(4052, 'Duyen Hai Mien Trung', 238, 1),
(4053, 'Hanoi', 238, 1),
(4054, 'Hung Yen', 238, 1),
(4055, 'Khu Bon Cu', 238, 1),
(4056, 'Long An', 238, 1),
(4057, 'Mien Nui Va Trung Du', 238, 1),
(4058, 'Thai Nguyen', 238, 1),
(4059, 'Thanh Pho Ho Chi Minh', 238, 1),
(4060, 'Thu Do Ha Noi', 238, 1),
(4061, 'Tinh Can Tho', 238, 1),
(4062, 'Tinh Da Nang', 238, 1),
(4063, 'Tinh Gia Lai', 238, 1),
(4064, 'Anegada', 239, 1),
(4065, 'Jost van Dyke', 239, 1),
(4066, 'Tortola', 239, 1),
(4067, 'Saint Croix', 240, 1),
(4068, 'Saint John', 240, 1),
(4069, 'Saint Thomas', 240, 1),
(4070, 'Alo', 241, 1),
(4071, 'Singave', 241, 1),
(4072, 'Wallis', 241, 1),
(4073, 'Bu Jaydur', 242, 1),
(4074, 'Wad-adh-Dhahab', 242, 1),
(4075, 'al-\'Ayun', 242, 1),
(4076, 'as-Samarah', 242, 1),
(4077, '\'Adan', 243, 1),
(4078, 'Abyan', 243, 1),
(4079, 'Dhamar', 243, 1),
(4080, 'Hadramaut', 243, 1),
(4081, 'Hajjah', 243, 1),
(4082, 'Hudaydah', 243, 1),
(4083, 'Ibb', 243, 1),
(4084, 'Lahij', 243, 1),
(4085, 'Ma\'rib', 243, 1),
(4086, 'Madinat San\'a', 243, 1),
(4087, 'Sa\'dah', 243, 1),
(4088, 'Sana', 243, 1),
(4089, 'Shabwah', 243, 1),
(4090, 'Ta\'izz', 243, 1),
(4091, 'al-Bayda', 243, 1),
(4092, 'al-Hudaydah', 243, 1),
(4093, 'al-Jawf', 243, 1),
(4094, 'al-Mahrah', 243, 1),
(4095, 'al-Mahwit', 243, 1),
(4096, 'Central Serbia', 244, 1),
(4097, 'Kosovo and Metohija', 244, 1),
(4098, 'Montenegro', 244, 1),
(4099, 'Republic of Serbia', 244, 1),
(4100, 'Serbia', 244, 1),
(4101, 'Vojvodina', 244, 1),
(4102, 'Central', 245, 1),
(4103, 'Copperbelt', 245, 1),
(4104, 'Eastern', 245, 1),
(4105, 'Luapala', 245, 1),
(4106, 'Lusaka', 245, 1),
(4107, 'North-Western', 245, 1),
(4108, 'Northern', 245, 1),
(4109, 'Southern', 245, 1),
(4110, 'Western', 245, 1),
(4111, 'Bulawayo', 246, 1),
(4112, 'Harare', 246, 1),
(4113, 'Manicaland', 246, 1),
(4114, 'Mashonaland Central', 246, 1),
(4115, 'Mashonaland East', 246, 1),
(4116, 'Mashonaland West', 246, 1),
(4117, 'Masvingo', 246, 1),
(4118, 'Matabeleland North', 246, 1),
(4119, 'Matabeleland South', 246, 1),
(4120, 'Midlands', 246, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stripe_bank_details`
--

CREATE TABLE `stripe_bank_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_holder_name` varchar(150) NOT NULL,
  `account_number` varchar(150) NOT NULL,
  `account_iban` varchar(100) NOT NULL,
  `bank_name` varchar(150) NOT NULL,
  `bank_address` varchar(256) NOT NULL,
  `sort_code` varchar(50) NOT NULL,
  `routing_number` varchar(50) NOT NULL,
  `account_ifsc` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stripe_bank_details`
--

INSERT INTO `stripe_bank_details` (`id`, `user_id`, `account_holder_name`, `account_number`, `account_iban`, `bank_name`, `bank_address`, `sort_code`, `routing_number`, `account_ifsc`) VALUES
(1, 140, 'Geetansh Madhok', '32413337814', '32413337814', 'State Bank of India', 'Gwalior, City Center', '', '', 'SBIN0004352');

-- --------------------------------------------------------

--
-- Table structure for table `super_fast_delivery_option`
--

CREATE TABLE `super_fast_delivery_option` (
  `id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `super_fast_delivery_desc` varchar(100) NOT NULL,
  `number_of_days` int(11) NOT NULL,
  `purchased_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delivery_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(11) NOT NULL DEFAULT '0',
  `super_fast_charges` float NOT NULL,
  `currency_type` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` smallint(6) NOT NULL,
  `key` varchar(250) NOT NULL,
  `value` text NOT NULL,
  `system` tinyint(150) NOT NULL DEFAULT '1',
  `groups` varchar(150) NOT NULL,
  `update_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `key`, `value`, `system`, `groups`, `update_date`, `status`) VALUES
(3, 'email_tittle', 'Digimonk Work', 1, 'config', '2018-09-28', 1),
(4, 'email_address', 'sandeep.sikarwar@digimonk.in', 1, 'config', '2018-09-28', 1),
(6, 'default_currency', 'USD', 1, 'config', '2018-09-28', 1),
(93, 'favicon', 'fevicon1.png', 1, '', '0000-00-00', 1),
(97, 'currency_option', 'USD', 1, 'config', '2018-09-28', 1),
(279, 'logo_front', 'uploads/logo/1539777409_rodolfo_logo.png', 1, 'config', '2018-10-17', 1),
(306, 'smtp_host', 'mail.digimonk.net', 1, 'config', '2018-10-25', 1),
(307, 'smtp_port', '465', 1, 'config', '2018-10-25', 1),
(308, 'smtp_user', 'deepak@digimonk.net', 1, 'config', '2018-10-25', 1),
(309, 'smtp_pass', 'Deepak@3096~~', 1, 'config', '2018-10-25', 1),
(440, 'website_name', 'Influencer', 1, 'config', '2018-11-20', 1),
(441, 'base_domain', 'http://work.digimonk.net/', 1, 'config', '2018-11-20', 1),
(442, 'website_slogan', '', 1, 'config', '2018-11-20', 1),
(443, 'price_option', 'dynamic', 1, 'config', '2018-11-20', 1),
(444, 'gig_price', '', 1, 'config', '2018-11-20', 1),
(445, 'extra_gig_price', '', 1, 'config', '2018-11-20', 1),
(446, 'admin_commision', '10', 1, 'config', '2018-11-20', 1),
(447, 'google_analytics_code', '', 1, 'config', '2018-11-20', 1),
(448, 'meta_title', '', 1, 'config', '2018-11-20', 1),
(449, 'meta_keywords', '', 1, 'config', '2018-11-20', 1),
(450, 'meta_description', '', 1, 'config', '2018-11-20', 1),
(451, 'facebook', 'https://www.facebook.com/DigiMonkOfficial/', 1, 'config', '2018-11-20', 1),
(452, 'twitter', 'https://twitter.com/teamdigimonk', 1, 'config', '2018-11-20', 1),
(453, 'google_plus', '', 1, 'config', '2018-11-20', 1),
(454, 'linkedIn', 'https://www.linkedin.com/company/pixel-online/', 1, 'config', '2018-11-20', 1),
(455, 'one_signal_subdomain', '', 1, 'config', '2018-11-20', 1),
(456, 'one_signal_app_id', '', 1, 'config', '2018-11-20', 1),
(457, 'one_signal_reset_key', '', 1, 'config', '2018-11-20', 1),
(458, 'paypal_option', '2', 1, 'config', '2018-11-20', 1),
(459, 'paypal_allow', '1', 1, 'config', '2018-11-20', 1),
(460, 'stripe_option', '2', 1, 'config', '2018-11-20', 1),
(461, 'stripe_allow', '1', 1, 'config', '2018-11-20', 1),
(462, 'publishable_key', 'pk_test_Js15CigEZPZH69hjS2hgXjBx', 1, 'config', '2018-11-20', 1),
(463, 'secret_key', 'sk_test_OVXvseuWuLVp2w0XOWvGKDQJ', 1, 'config', '2018-11-20', 1),
(464, 'live_publishable_key', 'pk_live_Fcv2quS4tvCx6BwXhfoQQFTT', 1, 'config', '2018-11-20', 1),
(465, 'live_secret_key', 'sk_live_juEOItnRuTNTkHuijyJCdSdt', 1, 'config', '2018-11-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `term`
--

CREATE TABLE `term` (
  `id` int(11) NOT NULL,
  `footer_submenu` varchar(222) NOT NULL,
  `page_desc` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_required_extra_gigs`
--

CREATE TABLE `user_required_extra_gigs` (
  `id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency_type` char(5) NOT NULL,
  `options` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `version_updates`
--

CREATE TABLE `version_updates` (
  `version_id` int(11) NOT NULL,
  `build` int(11) NOT NULL DEFAULT '0',
  `version` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Version Updates Details';

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `user_id`, `gig_id`) VALUES
(1, 2, 2),
(2, 2, 1),
(3, 1, 5),
(4, 2, 8),
(5, 2, 16),
(6, 2, 15),
(7, 2, 10),
(8, 39, 25),
(9, 57, 29),
(10, 57, 33),
(11, 129, 25),
(12, 135, 62),
(13, 135, 64),
(14, 141, 68),
(15, 141, 70),
(16, 141, 69),
(17, 143, 72),
(18, 137, 71),
(19, 135, 73),
(20, 1, 72),
(21, 1, 73),
(22, 1, 64),
(23, 144, 72),
(24, 134, 71),
(25, 138, 74),
(26, 146, 71),
(27, 146, 70),
(28, 144, 71),
(29, 142, 74),
(30, 135, 74),
(31, 149, 80),
(32, 160, 81),
(33, 165, 84),
(34, 167, 71),
(35, 142, 84),
(36, 165, 71);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`ADMINID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bank_account`
--
ALTER TABLE `bank_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buyer_rejected_list`
--
ALTER TABLE `buyer_rejected_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CATID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_from` (`chat_from`),
  ADD KEY `chat_to` (`chat_to`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crasol`
--
ALTER TABLE `crasol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_backup_details`
--
ALTER TABLE `db_backup_details`
  ADD PRIMARY KEY (`backup_id`);

--
-- Indexes for table `default_extra_gigs`
--
ALTER TABLE `default_extra_gigs`
  ADD PRIMARY KEY (`default_gig_id`);

--
-- Indexes for table `digital_download`
--
ALTER TABLE `digital_download`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `enquerys`
--
ALTER TABLE `enquerys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extra_gigs`
--
ALTER TABLE `extra_gigs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs_categories`
--
ALTER TABLE `faqs_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_menu`
--
ALTER TABLE `footer_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_submenu`
--
ALTER TABLE `footer_submenu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gigs_image`
--
ALTER TABLE `gigs_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gigs_video`
--
ALTER TABLE `gigs_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `help_center_content`
--
ALTER TABLE `help_center_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_management`
--
ALTER TABLE `language_management`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `last_visited`
--
ALTER TABLE `last_visited`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`USERID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `one_signal_device_ids`
--
ALTER TABLE `one_signal_device_ids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_blog`
--
ALTER TABLE `our_blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paypal_details`
--
ALTER TABLE `paypal_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paypal_table`
--
ALTER TABLE `paypal_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `txn_id` (`txn_id`),
  ADD KEY `txn_id_2` (`txn_id`);

--
-- Indexes for table `policy_settings`
--
ALTER TABLE `policy_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profession`
--
ALTER TABLE `profession`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_extra_gigs`
--
ALTER TABLE `seller_extra_gigs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sell_gigs`
--
ALTER TABLE `sell_gigs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_profile`
--
ALTER TABLE `social_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_widgets`
--
ALTER TABLE `social_widgets`
  ADD PRIMARY KEY (`sw_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `stripe_bank_details`
--
ALTER TABLE `stripe_bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `super_fast_delivery_option`
--
ALTER TABLE `super_fast_delivery_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_required_extra_gigs`
--
ALTER TABLE `user_required_extra_gigs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `version_updates`
--
ALTER TABLE `version_updates`
  ADD PRIMARY KEY (`version_id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `ADMINID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bank_account`
--
ALTER TABLE `bank_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `buyer_rejected_list`
--
ALTER TABLE `buyer_rejected_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CATID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `crasol`
--
ALTER TABLE `crasol`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_backup_details`
--
ALTER TABLE `db_backup_details`
  MODIFY `backup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `default_extra_gigs`
--
ALTER TABLE `default_extra_gigs`
  MODIFY `default_gig_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `digital_download`
--
ALTER TABLE `digital_download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `template_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `enquerys`
--
ALTER TABLE `enquerys`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `extra_gigs`
--
ALTER TABLE `extra_gigs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `faqs_categories`
--
ALTER TABLE `faqs_categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `footer_menu`
--
ALTER TABLE `footer_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `footer_submenu`
--
ALTER TABLE `footer_submenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `gigs_image`
--
ALTER TABLE `gigs_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `gigs_video`
--
ALTER TABLE `gigs_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `help_center_content`
--
ALTER TABLE `help_center_content`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_management`
--
ALTER TABLE `language_management`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `last_visited`
--
ALTER TABLE `last_visited`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `USERID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `one_signal_device_ids`
--
ALTER TABLE `one_signal_device_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `our_blog`
--
ALTER TABLE `our_blog`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `paypal_details`
--
ALTER TABLE `paypal_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paypal_table`
--
ALTER TABLE `paypal_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `policy_settings`
--
ALTER TABLE `policy_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profession`
--
ALTER TABLE `profession`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `seller_extra_gigs`
--
ALTER TABLE `seller_extra_gigs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell_gigs`
--
ALTER TABLE `sell_gigs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `social_profile`
--
ALTER TABLE `social_profile`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `social_widgets`
--
ALTER TABLE `social_widgets`
  MODIFY `sw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4121;

--
-- AUTO_INCREMENT for table `stripe_bank_details`
--
ALTER TABLE `stripe_bank_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `super_fast_delivery_option`
--
ALTER TABLE `super_fast_delivery_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=466;

--
-- AUTO_INCREMENT for table `term`
--
ALTER TABLE `term`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_required_extra_gigs`
--
ALTER TABLE `user_required_extra_gigs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `version_updates`
--
ALTER TABLE `version_updates`
  MODIFY `version_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
