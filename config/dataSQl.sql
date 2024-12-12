-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 12:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE user_management;
USE user_management;
-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `moduleName` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `moduleName`, `created_at`, `updated_at`) VALUES
(46, 'Python', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(47, 'JavaScript', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(48, 'Java', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(49, 'c#', '2024-11-15 04:06:17', '2024-11-25 17:45:01'),
(50, 'C++', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(51, 'Ruby', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(52, 'PHP', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(53, 'Swift', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(54, 'Go', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(55, 'Kotlin', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(56, 'Rust', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(57, 'TypeScript', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(58, 'SQL', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(59, 'Perl', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(60, 'Scala', '2024-11-15 04:06:17', '2024-11-15 04:06:17'),
(66, 'Nodejs', '2024-11-29 16:00:36', '2024-11-29 16:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `module_id`, `content`, `created_at`, `updated_at`) VALUES
(121, 34, 50, 'tet1', '2024-11-22 13:35:39', '2024-11-22 13:35:39'),
(122, 34, 56, 'tet3', '2024-11-22 13:36:18', '2024-11-22 13:36:18'),
(123, 34, 57, 'test4', '2024-11-22 13:36:46', '2024-11-22 13:36:46'),
(124, 34, 56, 'test5', '2024-11-22 13:37:52', '2024-11-22 13:37:52'),
(125, 34, 58, 'A new social media platform is growing very quickly. The social network Bluesky is getting over one million new users every day. The site opened to the public in February. However, it started gaining in popularity after the U.S. Presidential Election on November the 5th. Many people are signing up for Bluesky because they want an alternative to X, Facebook and Threads. Bluesky is currently the most downloaded free app in Apple\'s and Google\'s app stores. Digital media journalist Ben Collins said: \"Bluesky works and looks and feels just like Twitter.\" He said Bluesky has a fresher feel than other platforms and gives users more control.\r\n\r\nBluesky began in 2019 as a research project at Twitter. It was led by the co-founder and former CEO of Twitter Jack Dorsey. It launched as an invitation-only version in February 2023. The platform is very similar to Twitter. Even the logos are similar. Twitter had a blue bird logo; Bluesky has a blue butterfly. Mr Dorsey said the name Bluesky is from a Twitter idea that a bird could fly freely in an open blue sky. This open blue sky is a symbol of free speech. Bluesky allows users to control their feed and focus on posts they are interested in. It said if you \"want only posts that have cat photos, or only posts related to sports, you can simply pick your feed of choice from an open marketplace\".', '2024-11-22 13:39:06', '2024-11-22 13:39:06'),
(126, 34, 47, 'Bluesky began in 2019 as a research project at Twitter. It was led by the co-founder and former CEO of Twitter Jack Dorsey. It launched as an invitation-only version in February 2023. The platform is very similar to Twitter. Even the logos are similar. Twitter had a blue bird logo; Bluesky has a blue butterfly. Mr Dorsey said the name Bluesky is from a Twitter idea that a bird could fly freely in an open blue sky. This open blue sky is a symbol of free speech.', '2024-11-22 13:39:43', '2024-11-22 13:39:43'),
(127, 34, 56, 'A revision to a traffic law aimed at amending the behaviour of cyclists came into effect in Japan on Friday. ', '2024-11-22 13:40:19', '2024-11-22 13:40:19'),
(140, 36, 60, 'bskfkjwkefkjwekjfwkbf', '2024-11-25 17:41:23', '2024-11-25 17:41:23'),
(141, 36, 49, 'test', '2024-12-06 11:09:11', '2024-12-06 11:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `loginToken` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `loginToken`, `created_at`) VALUES
(106, 19, 'fc5613263466bc35d4b0c2dac80f47adee2e27aa', '2024-12-10 10:17:26'),
(107, 36, '73e24fc91d13e8f43a2fb22a371183208c85c3ae', '2024-12-11 08:11:37');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `upload` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `user_id`, `post_id`, `upload`) VALUES
(100, 34, 121, 'https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282544/askQuestionUpload/rkoqfl8bkjpqwqyrnryz.jpg'),
(101, 34, 122, 'https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282585/askQuestionUpload/zk9tbrsg3reo2cynx5bx.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282588/askQuestionUpload/btcym8zkjb6h3xogd7pq.jpg'),
(102, 34, 123, 'https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282611/askQuestionUpload/hnmwihn62o9xjjtzke5p.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282617/askQuestionUpload/gzruf7srs1qe1yyejdpq.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282623/askQuestionUpload/c6cdwa403o2woqsfwzcc.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282630/askQuestionUpload/eegtus3zuexmmpfci70w.jpg'),
(103, 34, 124, 'https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282681/askQuestionUpload/ao5q14nggf5pyljkc8k4.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282688/askQuestionUpload/qr0fp0mg36qzayrdt5ud.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282696/askQuestionUpload/tqgejp4duhjsdpnjrfa7.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282702/askQuestionUpload/k5wkdyogwjdysgdmpsu5.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282708/askQuestionUpload/yd8slq3qrouaiv0qs32c.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282711/askQuestionUpload/hneko5k7jjigcq0snkwz.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732282717/askQuestionUpload/r6g2vaf0m3w3ggx0vb4y.jpg'),
(112, 36, 140, 'https://res.cloudinary.com/dipxjgwt3/image/upload/v1732556491/askQuestionUpload/criwwprbwkr6ksufvqqh.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732556494/askQuestionUpload/zqls4qjykv5rjv0vgri0.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732556497/askQuestionUpload/udueqa3f7dd3lapwmxm6.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732556501/askQuestionUpload/uzrehh69eqjdv22igh7p.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732556505/askQuestionUpload/vh5oqtjpbpf6lyclvdl0.jpg,https://res.cloudinary.com/dipxjgwt3/image/upload/v1732556510/askQuestionUpload/szhzhdodtwuv12uoinyv.jpg'),
(113, 36, 141, 'https://res.cloudinary.com/dipxjgwt3/image/upload/v1733483352/askQuestionUpload/k5pcefx6ebqfkqzddxmi.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `activeToken` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `role` tinyint(4) DEFAULT 0,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `activeToken`, `status`, `role`, `create_at`, `update_at`) VALUES
(19, 'admin', 'tonguyen0903@gmail.com', '$2y$10$ElsSQSmmESlkymputMw3f.mAjlckPfLHBdjlFoEAewy5ljxXXKUJO', NULL, 1, 1, '2024-11-13 05:17:35', '2024-11-21 18:21:25'),
(34, 'Seeley', 'tonguyen090304@gmail.com', '$2y$10$ly4tcmnlgpdBLsbIT8IjxOr/Uu/KHMHy8ajWkkglbwIq5uqK1E9AG', NULL, 1, 2, '2024-11-22 13:34:41', '2024-11-22 13:35:10'),
(36, 'Tô Nguyễn', 'nguyentgcs220690@fpt.edu.vn', '$2y$10$l3N0zLHdFQqZZlX5IPUnBeFoyTRPkIbdWpq3STcILEjy6lHXpybkq', NULL, 1, 2, '2024-11-23 11:27:04', '2024-11-23 11:28:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`moduleName`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `uploads_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;


