-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 17, 2023 at 04:21 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `testtable`
--

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `filename` varchar(256) NOT NULL,
  `link` varchar(256) NOT NULL,
  `owner` varchar(100) DEFAULT NULL,
  `date` varchar(50) NOT NULL,
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `filename`, `link`, `owner`, `date`, `comment`) VALUES
(65, '1628699684_52-p-zhirnii-kot-foto-58.jpg', 'uploads/1628699684_52-p-zhirnii-kot-foto-58.jpg', 'admin', '17-05-2023 17:53', NULL),
(69, 'meatball4.jpg', 'uploads/meatball4.jpg', 'admin', '17-05-2023 18:19', NULL),
(70, '1637813626_22-koshka-top-p-ochen-tolstii-kotik-27.jpg', 'uploads/1637813626_22-koshka-top-p-ochen-tolstii-kotik-27.jpg', 'admin', '17-05-2023 18:19', NULL),
(71, 'лло пол13.png', 'uploads/лло пол13.png', 'admin', '17-05-2023 18:19', NULL),
(72, '1625701332_10-funart-pro-p-tolstii-kot-zhivotnie-krasivo-foto-12.jpg', 'uploads/1625701332_10-funart-pro-p-tolstii-kot-zhivotnie-krasivo-foto-12.jpg', 'admin', '17-05-2023 18:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `user_login` varchar(30) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_hash` varchar(32) NOT NULL DEFAULT '',
  `user_ip` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_password`, `user_hash`, `user_ip`) VALUES
(1, 'admin', '14e1b600b1fd579f47433b88e8d85291', '313e51308f4e08b9c3cb2417913c54f9', 2130706433),
(2, 'odoi', '2f7b52aacfbf6f44e13d27656ecb1f59', '48f383b290303b08dbf7cadefe881965', 2130706433),
(3, 'admin3', '2952e1846b4ea765dfd0fdfcb7e21097', '43d50c678978c888b7d1246279af3770', 2130706433),
(4, 'admini', '224cf2b695a5e8ecaecfb9015161fa4b', '', 0),
(5, 'admini', '224cf2b695a5e8ecaecfb9015161fa4b', '', 0),
(6, 'adminnnn', '3cdf5666859f6906c283a1058cd5b9a7', '', 0),
(7, 'adminme', '70873e8580c9900986939611618d7b1e', 'cd1b8945e18b828578acef7d09c2b37b', 2130706433),
(8, 'OOOllll', 'd9b1d7db4cd6e70935368a1efb10e377', '90919be8228e5348c6e2384a004ca50f', 2130706433),
(9, 'author', '3cdf5666859f6906c283a1058cd5b9a7', '1f10579558a237d3b4737d8f958cc490', 2130706433),
(10, 'aaaaa', '3cdf5666859f6906c283a1058cd5b9a7', 'fae567f45d4c385ca35ac6d6d89f7cce', 2130706433),
(11, 'ffff', 'd9b1d7db4cd6e70935368a1efb10e377', 'bae8d85b231f22133e7af9dab9a319b4', 2130706433);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
