-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2026 at 03:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `al_techhub_team_recovery_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`message_id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Yovindu Maneth', 'yovi@gmail.com', 'Technical Support', 'test msg', '2026-09-19 15:15:23'),
(2, 'Yovindu Maneth', 'yovi@gmail.com', 'Account Problem', 'test msg', '2026-09-19 15:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `lesson_number` varchar(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `video_1080p_path` varchar(255) DEFAULT NULL,
  `video_720p_path` varchar(255) DEFAULT NULL,
  `video_480p_path` varchar(255) DEFAULT NULL,
  `video_360p_path` varchar(255) DEFAULT NULL,
  `audio_path` varchar(255) DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`lesson_id`, `unit_id`, `lesson_number`, `title`, `description`, `video_path`, `video_1080p_path`, `video_720p_path`, `video_480p_path`, `video_360p_path`, `audio_path`, `duration_minutes`, `created_at`) VALUES
(2, 7, '01', 'Development of Agriculture in Sri Lanka', 'Learn about the development of agriculture in Sri Lanka.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 01:23:41'),
(3, 8, '01', 'Climatic Factors and Crop Production', 'Learn how climatic factors influence crop production.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 01:23:41'),
(4, 9, '01', 'Soil Environment', 'Learn about the soil environment and its importance in crop cultivation.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 01:23:41'),
(5, 10, '01', 'Pest Control', 'Learn about pest control in agriculture.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 04:15:07'),
(6, 11, '02', 'Food Technology', 'Learn about food technology in agriculture.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 04:15:07'),
(7, 12, '03', 'Post Harvest', 'Learn about post-harvest practices and technology.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-02 04:15:07'),
(8, 22, '01', 'Weather Conditions Suitable for Biological Systems', 'Learn about weather conditions suitable for biological systems.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-05 16:01:44'),
(9, 23, '01', 'Soil in Biological Systems', 'Learn about soil and its role in biological systems.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-05 16:01:44'),
(10, 24, '01', 'Surveying and Levelling', 'Learn about surveying and levelling.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-05 16:01:44'),
(11, 25, '01', 'Mechanization', 'Learn about mechanization in biological systems.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-05 16:01:44'),
(12, 26, '02', 'Sustainable Timber and Non-Timber Based Products', 'Learn about sustainable timber and non-timber based products.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-05 16:01:44'),
(13, 27, '03', 'Plantation and Minor Export Crops Based Products', 'Learn about plantation and minor export crops based products.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-05 16:01:44'),
(14, 16, '01', 'Introduction to Engineering Technology', 'Learn about the introduction to engineering technology.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-06 06:51:17'),
(15, 17, '01', 'Engineering Drawing', 'Learn about engineering drawing.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-06 06:51:17'),
(16, 18, '01', 'Health and Safety for Technology', 'Learn about health and safety for technology.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-06 06:51:17'),
(17, 19, '01', 'Engineering Standards and Specifications', 'Learn about engineering standards and specifications.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-06 06:51:17'),
(18, 20, '01', 'Generation, Transmission, Distribution and Utilization of Electrical Power', 'Learn about the generation, transmission, distribution and utilization of electrical power.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-06 06:51:17'),
(19, 21, '01', 'Electronic Technology', 'Learn about electronic technology.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-06 06:51:17'),
(20, 4, '01', 'Concept of ICT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 18:05:22'),
(21, 5, '01', 'Introduction to Computer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 18:05:22'),
(22, 6, '01', 'Number System', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 18:05:22'),
(23, 13, '01', 'System Analysis and Design', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 18:05:22'),
(24, 14, '01', 'Database Management', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 18:05:22'),
(25, 15, '01', 'Programming', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-14 18:05:22'),
(26, 28, '01', 'Area and Volume', 'Learn about Area and Volume in Science for Technology.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 04:25:25'),
(27, 29, '01', 'Measuring Units and Measuring Instruments', 'Learn about Measuring Units and Measuring Instruments in Science for Technology.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 04:25:25'),
(28, 30, '01', 'Pythagoras Relationship', 'Learn about Pythagoras Relationship in Science for Technology.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 04:25:25'),
(29, 31, '01', 'Polymers', 'Learn about Polymers in Science for Technology.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 04:25:25'),
(30, 32, '01', 'Mechanical Properties of Matter', 'Learn about Mechanical Properties of Matter in Science for Technology.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 04:25:25'),
(31, 33, '01', 'Fluid Mechanics', 'Learn about Fluid Mechanics in Science for Technology.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-15 04:25:25');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_parts`
--

CREATE TABLE `lesson_parts` (
  `part_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `part_number` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `video_1080p_path` varchar(255) DEFAULT NULL,
  `video_720p_path` varchar(255) DEFAULT NULL,
  `video_480p_path` varchar(255) DEFAULT NULL,
  `video_360p_path` varchar(255) DEFAULT NULL,
  `audio_path` varchar(255) DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson_parts`
--

INSERT INTO `lesson_parts` (`part_id`, `lesson_id`, `part_number`, `title`, `video_path`, `video_1080p_path`, `video_720p_path`, `video_480p_path`, `video_360p_path`, `audio_path`, `duration_minutes`, `created_at`) VALUES
(1, 2, 1, 'Development of Agriculture in Sri Lanka - Part 01', NULL, 'uploads/videos/agri-unit-01-Development of Agriculture in Sri Lanka-part-01-1080p.mp4', 'uploads/videos/agri-unit-01-Development of Agriculture in Sri Lanka-part-01-720p.mp4', 'uploads/videos/agri-unit-01-Development of Agriculture in Sri Lanka-part-01-480p.mp4', 'uploads/videos/agri-unit-01-Development of Agriculture in Sri Lanka-part-01-360p.mp4', NULL, NULL, '2026-10-02 01:24:39'),
(2, 2, 2, 'Development of Agriculture in Sri Lanka - Part 02', NULL, 'uploads/videos/agri-unit-01-Development of Agriculture in Sri Lanka-part-02-1080p.mp4', 'uploads/videos/agri-unit-01-Development of Agriculture in Sri Lanka-part-02-720p.mp4', 'uploads/videos/agri-unit-01-Development of Agriculture in Sri Lanka-part-02-480p.mp4', 'uploads/videos/agri-unit-01-Development of Agriculture in Sri Lanka-part-02-360p.mp4', 'uploads/audios/agri-unit-01-Development of Agriculture in Sri Lanka-part-02.mp3', NULL, '2026-10-02 01:24:39'),
(3, 2, 3, 'Development of Agriculture in Sri Lanka - Part 03', NULL, 'uploads/videos/agri-unit-01-Development of Agriculture in Sri Lanka-part-03-1080p.mp4', 'uploads/videos/agri-unit-01-Development of Agriculture in Sri Lanka-part-03-720p.mp4', 'uploads/videos/agri-unit-01-Development of Agriculture in Sri Lanka-part-03-480p.mp4', 'uploads/videos/agri-unit-01-Development of Agriculture in Sri Lanka-part-03-360p.mp4', 'uploads/audios/agri-unit-01-Development of Agriculture in Sri Lanka-part-03.mp3', NULL, '2026-10-02 01:24:39'),
(4, 3, 1, 'Climatic Factors and Crop Production - Part 01', NULL, 'uploads/videos/agri-unit-02- Climatic Factors and Crop Production-part-01-1080p.mp4', 'uploads/videos/agri-unit-02- Climatic Factors and Crop Production-part-01-720p.mp4', 'uploads/videos/agri-unit-02- Climatic Factors and Crop Production-part-01-480p.mp4', 'uploads/videos/agri-unit-02- Climatic Factors and Crop Production-part-01-360p.mp4', 'uploads/audios/agri-unit-02- Climatic Factors and Crop Production-part-01.mp3', NULL, '2026-10-02 01:24:39'),
(5, 3, 2, 'Climatic Factors and Crop Production - Part 02', NULL, 'uploads/videos/agri-unit-02- Climatic Factors and Crop Production-part-02-1080p.mp4', 'uploads/videos/agri-unit-02- Climatic Factors and Crop Production-part-02-720p.mp4', 'uploads/videos/agri-unit-02- Climatic Factors and Crop Production-part-02-480p.mp4', 'uploads/videos/agri-unit-02- Climatic Factors and Crop Production-part-02-360p.mp4', 'uploads/audios/agri-unit-02- Climatic Factors and Crop Production-part-02.mp3', NULL, '2026-10-02 01:24:39'),
(6, 3, 3, 'Climatic Factors and Crop Production - Part 03', NULL, 'uploads/videos/agri-unit-02- Climatic Factors and Crop Production-part-03-1080p.mp4', 'uploads/videos/agri-unit-02- Climatic Factors and Crop Production-part-03-720p.mp4', 'uploads/videos/agri-unit-02- Climatic Factors and Crop Production-part-03-480p.mp4', 'uploads/videos/agri-unit-02- Climatic Factors and Crop Production-part-03-360p.mp4', 'uploads/audios/agri-unit-02- Climatic Factors and Crop Production-part-03.mp3', NULL, '2026-10-02 01:24:39'),
(7, 4, 1, 'Soil Environment - Part 01', NULL, 'uploads/videos/agri-unit-03- Soil Environment-part-01-1080p.mp4', 'uploads/videos/agri-unit-03- Soil Environment-part-01-720p.mp4', 'uploads/videos/agri-unit-03- Soil Environment-part-01-480p.mp4', 'uploads/videos/agri-unit-03- Soil Environment-part-01-360p.mp4', 'uploads/audios/agri-unit-03- Soil Environment-part-01.mp3', NULL, '2026-10-02 01:24:39'),
(8, 4, 2, 'Soil Environment - Part 02', NULL, 'uploads/videos/agri-unit-03- Soil Environment-part-02-1080p.mp4', 'uploads/videos/agri-unit-03- Soil Environment-part-02-720p.mp4', 'uploads/videos/agri-unit-03- Soil Environment-part-02-480p.mp4', 'uploads/videos/agri-unit-03- Soil Environment-part-02-360p.mp4', 'uploads/audios/agri-unit-03- Soil Environment-part-02.mp3', NULL, '2026-10-02 01:24:39'),
(9, 4, 3, 'Soil Environment - Part 03', NULL, 'uploads/videos/agri-unit-03- Soil Environment-part-03-1080p.mp4', 'uploads/videos/agri-unit-03- Soil Environment-part-03-720p.mp4', 'uploads/videos/agri-unit-03- Soil Environment-part-03-480p.mp4', 'uploads/videos/agri-unit-03- Soil Environment-part-03-360p.mp4', 'uploads/audios/agri-unit-03- Soil Environment-part-03.mp3', NULL, '2026-10-02 01:24:39'),
(10, 5, 1, 'Pest Control - Part 01', 'uploads/videos/agri-unit-01- Pest Control-part-01.mp4', 'uploads/videos/agri-unit-01- Pest Control-part-01-1080p.mp4', 'uploads/videos/agri-unit-01- Pest Control-part-01-720p.mp4', 'uploads/videos/agri-unit-01- Pest Control-part-01-480p.mp4', 'uploads/videos/agri-unit-01- Pest Control-part-01-360p.mp4', 'uploads/audios/agri-unit-01- Pest Control-part-01.mp3', NULL, '2026-10-02 04:16:51'),
(11, 5, 2, 'Pest Control - Part 02', 'uploads/videos/agri-unit-01- Pest Control-part-02.mp4', 'uploads/videos/agri-unit-01- Pest Control-part-02-1080p.mp4', 'uploads/videos/agri-unit-01- Pest Control-part-02-720p.mp4', 'uploads/videos/agri-unit-01- Pest Control-part-02-480p.mp4', 'uploads/videos/agri-unit-01- Pest Control-part-02-360p.mp4', 'uploads/audios/agri-unit-01- Pest Control-part-02.mp3', NULL, '2026-10-02 04:16:51'),
(12, 5, 3, 'Pest Control - Part 03', 'uploads/videos/agri-unit-01- Pest Control-part-03.mp4', 'uploads/videos/agri-unit-01- Pest Control-part-03-1080p.mp4', 'uploads/videos/agri-unit-01- Pest Control-part-03-720p.mp4', 'uploads/videos/agri-unit-01- Pest Control-part-03-480p.mp4', 'uploads/videos/agri-unit-01- Pest Control-part-03-360p.mp4', 'uploads/audios/agri-unit-01- Pest Control-part-03.mp3', NULL, '2026-10-02 04:16:51'),
(13, 6, 1, 'Food Technology - Part 01', 'uploads/videos/agri-unit-02- Food Technology-part-01.mp4', 'uploads/videos/agri-unit-02- Food Technology-part-01-1080p.mp4', 'uploads/videos/agri-unit-02- Food Technology-part-01-720p.mp4', 'uploads/videos/agri-unit-02- Food Technology-part-01-480p.mp4', 'uploads/videos/agri-unit-02- Food Technology-part-01-360p.mp4', 'uploads/audios/agri-unit-02- Food Technology-part-01.mp3', NULL, '2026-10-02 04:16:51'),
(14, 6, 2, 'Food Technology - Part 02', 'uploads/videos/agri-unit-02- Food Technology-part-02.mp4', 'uploads/videos/agri-unit-02- Food Technology-part-02-1080p.mp4', 'uploads/videos/agri-unit-02- Food Technology-part-02-720p.mp4', 'uploads/videos/agri-unit-02- Food Technology-part-02-480p.mp4', 'uploads/videos/agri-unit-02- Food Technology-part-02-360p.mp4', NULL, NULL, '2026-10-02 04:16:51'),
(15, 6, 3, 'Food Technology - Part 03', 'uploads/videos/agri-unit-02- Food Technology-part-03.mp4', 'uploads/videos/agri-unit-02- Food Technology-part-03-1080p.mp4', 'uploads/videos/agri-unit-02- Food Technology-part-03-720p.mp4', 'uploads/videos/agri-unit-02- Food Technology-part-03-480p.mp4', 'uploads/videos/agri-unit-02- Food Technology-part-03-360p.mp4', NULL, NULL, '2026-10-02 04:16:51'),
(16, 7, 1, 'Post Harvest - Part 01', 'uploads/videos/agri-unit-03- Post Harvest-part-01.mp4', 'uploads/videos/agri-unit-03- Post Harvest-part-01-1080p.mp4', 'uploads/videos/agri-unit-03- Post Harvest-part-01-720p.mp4', 'uploads/videos/agri-unit-03- Post Harvest-part-01-480p.mp4', 'uploads/videos/agri-unit-03- Post Harvest-part-01-360p.mp4', 'uploads/audios/agri-unit-03- Post Harvest-part-01.mp3', NULL, '2026-10-02 04:16:51'),
(17, 7, 2, 'Post Harvest - Part 02', 'uploads/videos/agri-unit-03- Post Harvest-part-02.mp4', 'uploads/videos/agri-unit-03- Post Harvest-part-02-1080p.mp4', 'uploads/videos/agri-unit-03- Post Harvest-part-02-720p.mp4', 'uploads/videos/agri-unit-03- Post Harvest-part-02-480p.mp4', 'uploads/videos/agri-unit-03- Post Harvest-part-02-360p.mp4', 'uploads/audios/agri-unit-03- Post Harvest-part-02.mp3', NULL, '2026-10-02 04:16:51'),
(18, 7, 3, 'Post Harvest - Part 03', 'uploads/videos/agri-unit-03- Post Harvest-part-03.mp4', 'uploads/videos/agri-unit-03- Post Harvest-part-03-1080p.mp4', 'uploads/videos/agri-unit-03- Post Harvest-part-03-720p.mp4', 'uploads/videos/agri-unit-03- Post Harvest-part-03-480p.mp4', 'uploads/videos/agri-unit-03- Post Harvest-part-03-360p.mp4', 'uploads/audios/agri-unit-03- Post Harvest-part-03.mp3', NULL, '2026-10-02 04:16:51'),
(19, 8, 1, 'Weather Conditions Suitable for Biological Systems - Part 01', 'uploads/videos/bst-unit-01- Weather_Conditions-part-01.mp4', 'uploads/videos/bst-unit-01- Weather_Conditions-part-01-1080p.mp4', 'uploads/videos/bst-unit-01- Weather_Conditions-part-01-720p.mp4', 'uploads/videos/bst-unit-01- Weather_Conditions-part-01-480p.mp4', 'uploads/videos/bst-unit-01- Weather_Conditions-part-01-360p.mp4', 'uploads/videos/bst-unit-01- Weather_Conditions-part-01.mp3', NULL, '2026-10-05 16:02:46'),
(20, 8, 2, 'Weather Conditions Suitable for Biological Systems - Part 02', 'uploads/videos/bst-unit-01- Weather_Conditions-part-02-repaired.mp4', 'uploads/videos/bst-unit-01- Weather_Conditions-part-02-1080p.mp4', 'uploads/videos/bst-unit-01- Weather_Conditions-part-02-720p.mp4', 'uploads/videos/bst-unit-01- Weather_Conditions-part-02-480p.mp4', 'uploads/videos/bst-unit-01- Weather_Conditions-part-02-360p.mp4', 'uploads/videos/bst-unit-01- Weather_Conditions-part-02.mp3', NULL, '2026-10-05 16:02:46'),
(21, 9, 1, 'Soil in Biological Systems - Part 01', 'uploads/videos/bst-unit-02- Soil_Biological-part-01.mp4', 'uploads/videos/bst-unit-02- Soil_Biological-part-01-1080p.mp4', 'uploads/videos/bst-unit-02- Soil_Biological-part-01-720p.mp4', 'uploads/videos/bst-unit-02- Soil_Biological-part-01-480p.mp4', 'uploads/videos/bst-unit-02- Soil_Biological-part-01-360p.mp4', 'uploads/videos/bst-unit-02- Soil_Biological-part-01.mp3', NULL, '2026-10-05 16:02:46'),
(22, 9, 2, 'Soil in Biological Systems - Part 02', 'uploads/videos/bst-unit-02- Soil_Biological-part-02.mp4', 'uploads/videos/bst-unit-02- Soil_Biological-part-02-1080p.mp4', 'uploads/videos/bst-unit-02- Soil_Biological-part-02-720p.mp4', 'uploads/videos/bst-unit-02- Soil_Biological-part-02-480p.mp4', 'uploads/videos/bst-unit-02- Soil_Biological-part-02-360p.mp4', 'uploads/videos/bst-unit-02- Soil_Biological-part-02.mp3', NULL, '2026-10-05 16:02:46'),
(23, 10, 1, 'Surveying and Levelling - Part 01', 'uploads/videos/bst-unit-03- Surveying_and_levelling-part-01.mp4', 'uploads/videos/bst-unit-03- Surveying_and_levelling-part-01-1080p.mp4', 'uploads/videos/bst-unit-03- Surveying_and_levelling-part-01-720p.mp4', 'uploads/videos/bst-unit-03- Surveying_and_levelling-part-01-480p.mp4', 'uploads/videos/bst-unit-03- Surveying_and_levelling-part-01-360p.mp4', 'uploads/videos/bst-unit-03- Surveying_and_levelling-part-01.mp3', NULL, '2026-10-05 16:02:46'),
(24, 11, 1, 'Mechanization - Part 01', 'uploads/videos/bst-unit-01- Mechanization-part-01.mp4', 'uploads/videos/bst-unit-01- Mechanization-part-01-1080p.mp4', 'uploads/videos/bst-unit-01- Mechanization-part-01-720p.mp4', 'uploads/videos/bst-unit-01- Mechanization-part-01-480p.mp4', 'uploads/videos/bst-unit-01- Mechanization-part-01-360p.mp4', 'uploads/videos/bst-unit-01- Mechanization-part-01.mp3', NULL, '2026-10-05 16:02:46'),
(25, 12, 1, 'Sustainable Timber and Non-Timber Based Products - Part 01', 'uploads/videos/bst-unit-02- Sustainable_and_Non_Sustainable-part-01.mp4', 'uploads/videos/bst-unit-02- Sustainable_and_Non_Sustainable-part-01-1080p.mp4', 'uploads/videos/bst-unit-02- Sustainable_and_Non_Sustainable-part-01-720p.mp4', 'uploads/videos/bst-unit-02- Sustainable_and_Non_Sustainable-part-01-480p.mp4', 'uploads/videos/bst-unit-02- Sustainable_and_Non_Sustainable-part-01-360p.mp4', 'uploads/videos/bst-unit-02- Sustainable_and_Non_Sustainable-part-01.mp3', NULL, '2026-10-05 16:02:46'),
(26, 13, 1, 'Plantation and Minor Export Crops Based Products - Part 01', 'uploads/videos/bst-unit-03- Plantation_and_Minor_Exports-part-01.mp4', 'uploads/videos/bst-unit-03- Plantation_and_Minor_Exports-part-01-1080p.mp4', 'uploads/videos/bst-unit-03- Plantation_and_Minor_Exports-part-01-720p.mp4', 'uploads/videos/bst-unit-03- Plantation_and_Minor_Exports-part-01-480p.mp4', 'uploads/videos/bst-unit-03- Plantation_and_Minor_Exports-part-01-360p.mp4', 'uploads/videos/bst-unit-03- Plantation_and_Minor_Exports-part-01.mp3', NULL, '2026-10-05 16:02:46'),
(27, 14, 1, 'Introduction to Engineering Technology - Part 01', 'uploads/videos/et-unit-01- Introduction_to_Engineering_Technology-part-01.mp4', 'uploads/videos/et-unit-01- Introduction_to_Engineering_Technology-part-01-1080p.mp4', 'uploads/videos/et-unit-01- Introduction_to_Engineering_Technology-part-01-720p.mp4', 'uploads/videos/et-unit-01- Introduction_to_Engineering_Technology-part-01-480p.mp4', 'uploads/videos/et-unit-01- Introduction_to_Engineering_Technology-part-01-360p.mp4', 'uploads/videos/et-unit-01- Introduction_to_Engineering_Technology-part-01.mp3', 30, '2026-10-06 06:53:01'),
(28, 14, 2, 'Introduction to Engineering Technology - Part 02', 'uploads/videos/et-unit-01- Introduction_to_Engineering_Technology-part-02.mp4', 'uploads/videos/et-unit-01- Introduction_to_Engineering_Technology-part-02-1080p.mp4', 'uploads/videos/et-unit-01- Introduction_to_Engineering_Technology-part-02-720p.mp4', 'uploads/videos/et-unit-01- Introduction_to_Engineering_Technology-part-02-480p.mp4', 'uploads/videos/et-unit-01- Introduction_to_Engineering_Technology-part-02-360p.mp4', 'uploads/videos/et-unit-01- Introduction_to_Engineering_Technology-part-02.mp3', 42, '2026-10-06 06:53:01'),
(29, 15, 1, 'Engineering Drawing - Part 01', 'uploads/videos/et-unit-02- Engineering_Drawing-part-01.mp4', 'uploads/videos/et-unit-02- Engineering_Drawing-part-01-1080p.mp4', 'uploads/videos/et-unit-02- Engineering_Drawing-part-01-720p.mp4', 'uploads/videos/et-unit-02- Engineering_Drawing-part-01-480p.mp4', 'uploads/videos/et-unit-02- Engineering_Drawing-part-01-360p.mp4', 'uploads/videos/et-unit-02- Engineering_Drawing-part-01.mp3', 51, '2026-10-06 06:53:01'),
(30, 16, 1, 'Health and Safety for Technology - Part 01', 'uploads/videos/et-unit-01- Health_and_Safety_For_Technology-part-01.mp4', 'uploads/videos/et-unit-01- Health_and_Safety_For_Technology-part-01-1080p.mp4', 'uploads/videos/et-unit-01- Health_and_Safety_For_Technology-part-01-720p.mp4', 'uploads/videos/et-unit-01- Health_and_Safety_For_Technology-part-01-480p.mp4', 'uploads/videos/et-unit-01- Health_and_Safety_For_Technology-part-01-360p.mp4', 'uploads/videos/et-unit-01- Health_and_Safety_For_Technology-part-01.mp3', 25, '2026-10-06 06:53:01'),
(31, 17, 1, 'Engineering Standards and Specifications - Part 01', 'uploads/videos/et-unit-01- Engineering_Standards_and_Specifications-part-01.mp4', 'uploads/videos/et-unit-01- Engineering_Standards_and_Specifications-part-01-1080p.mp4', 'uploads/videos/et-unit-01- Engineering_Standards_and_Specifications-part-01-720p.mp4', 'uploads/videos/et-unit-01- Engineering_Standards_and_Specifications-part-01-480p.mp4', 'uploads/videos/et-unit-01- Engineering_Standards_and_Specifications-part-01-360p.mp4', 'uploads/videos/et-unit-01- Engineering_Standards_and_Specifications-part-01.mp3', 22, '2026-10-06 06:53:01'),
(32, 17, 2, 'Engineering Standards and Specifications - Part 02', 'uploads/videos/et-unit-01- Engineering_Standards_and_Specifications-part-02.mp4', 'uploads/videos/et-unit-01- Engineering_Standards_and_Specifications-part-02-1080p.mp4', 'uploads/videos/et-unit-01- Engineering_Standards_and_Specifications-part-02-720p.mp4', 'uploads/videos/et-unit-01- Engineering_Standards_and_Specifications-part-02-480p.mp4', 'uploads/videos/et-unit-01- Engineering_Standards_and_Specifications-part-02-360p.mp4', 'uploads/videos/et-unit-01- Engineering_Standards_and_Specifications-part-02.mp3', 20, '2026-10-06 06:53:01'),
(33, 18, 1, 'Generation, Transmission, Distribution and Utilization of Electrical Power - Part 01', 'uploads/videos/et-unit-02- Generation, Transmission, Distribution_of_Electrical_Power-part-01.mp4', 'uploads/videos/et-unit-02- Generation, Transmission, Distribution_of_Electrical_Power-part-01-1080p.mp4', 'uploads/videos/et-unit-02- Generation, Transmission, Distribution_of_Electrical_Power-part-01-720p.mp4', 'uploads/videos/et-unit-02- Generation, Transmission, Distribution_of_Electrical_Power-part-01-480p.mp4', 'uploads/videos/et-unit-02- Generation, Transmission, Distribution_of_Electrical_Power-part-01-360p.mp4', 'uploads/videos/et-unit-02- Generation, Transmission, Distribution_of_Electrical_Power-part-01.mp3', 31, '2026-10-06 06:53:01'),
(34, 19, 1, 'Electronic Technology - Part 01', 'uploads/videos/et-unit-03- Electronic_Technology-part-01.mp4', 'uploads/videos/et-unit-03- Electronic_Technology-part-01-1080p.mp4', 'uploads/videos/et-unit-03- Electronic_Technology-part-01-720p.mp4', 'uploads/videos/et-unit-03- Electronic_Technology-part-01-480p.mp4', 'uploads/videos/et-unit-03- Electronic_Technology-part-01-360p.mp4', 'uploads/videos/et-unit-03- Electronic_Technology-part-01.mp3', 54, '2026-10-06 06:53:01'),
(35, 19, 2, 'Electronic Technology - Part 02', 'uploads/videos/et-unit-03- Electronic_Technology-part-02.mp4.mp4', 'uploads/videos/et-unit-03- Electronic_Technology-part-02-1080p.mp4', 'uploads/videos/et-unit-03- Electronic_Technology-part-02-720p.mp4', 'uploads/videos/et-unit-03- Electronic_Technology-part-02-480p.mp4', 'uploads/videos/et-unit-03- Electronic_Technology-part-02-360p.mp4', 'uploads/videos/et-unit-03- Electronic_Technology-part-02.mp3', 59, '2026-10-06 06:53:01'),
(36, 20, 1, 'Concept of ICT - Part 01', 'uploads/videos/ict-unit-01- Concept_of_ICT-part-01.mp4', 'uploads/videos/ict-unit-01- Concept_of_ICT-part-01-1080p.mp4', 'uploads/videos/ict-unit-01- Concept_of_ICT-part-01-720p.mp4', 'uploads/videos/ict-unit-01- Concept_of_ICT-part-01-480p.mp4', 'uploads/videos/ict-unit-01- Concept_of_ICT-part-01-360p.mp4', 'uploads/videos/ict-unit-01- Concept_of_ICT-part-01.mp3', 39, '2026-10-14 18:08:21'),
(37, 21, 1, 'Introduction to Computer - Part 01', 'uploads/videos/ict-unit-02- Introduction_to_Computer-part-01.mp4', 'uploads/videos/ict-unit-02- Introduction_to_Computer-part-01-1080p.mp4', 'uploads/videos/ict-unit-02- Introduction_to_Computer-part-01-720p.mp4', 'uploads/videos/ict-unit-02- Introduction_to_Computer-part-01-480p.mp4', 'uploads/videos/ict-unit-02- Introduction_to_Computer-part-01-360p.mp4', 'uploads/videos/ict-unit-02- Introduction_to_Computer-part-01.mp3', 28, '2026-10-14 18:08:21'),
(38, 21, 2, 'Introduction to Computer - Part 02', 'uploads/videos/ict-unit-02- Introduction_to_Computer-part-02.mp4', 'uploads/videos/ict-unit-02- Introduction_to_Computer-part-02-1080p.mp4', 'uploads/videos/ict-unit-02- Introduction_to_Computer-part-02-720p.mp4', 'uploads/videos/ict-unit-02- Introduction_to_Computer-part-02-480p.mp4', 'uploads/videos/ict-unit-02- Introduction_to_Computer-part-02-360p.mp4', 'uploads/videos/ict-unit-02- Introduction_to_Computer-part-02.mp3', 31, '2026-10-14 18:08:21'),
(39, 22, 1, 'Number System - Part 01', 'uploads/videos/ict-unit-03- Number_Systems-part-01.mp4', 'uploads/videos/ict-unit-03- Number_Systems-part-01-1080p.mp4', 'uploads/videos/ict-unit-03- Number_Systems-part-01-720p.mp4', 'uploads/videos/ict-unit-03- Number_Systems-part-01-480p.mp4', 'uploads/videos/ict-unit-03- Number_Systems-part-01-360p.mp4', 'uploads/videos/ict-unit-03- Number_Systems-part-01.mp3', 51, '2026-10-14 18:08:21'),
(40, 22, 2, 'Number System - Part 02', 'uploads/videos/ict-unit-03- Number_Systems-part-02.mp4', 'uploads/videos/ict-unit-03- Number_Systems-part-02-1080p.mp4', 'uploads/videos/ict-unit-03- Number_Systems-part-02-720p.mp4', 'uploads/videos/ict-unit-03- Number_Systems-part-02-480p.mp4', 'uploads/videos/ict-unit-03- Number_Systems-part-02-360p.mp4', 'uploads/videos/ict-unit-03- Number_Systems-part-02.mp3', 55, '2026-10-14 18:08:21'),
(41, 23, 1, 'System Analysis and Design - Part 01', 'uploads/videos/ict-unit-01- System_Analysis_and_Design-part-01.mp4', 'uploads/videos/ict-unit-01- System_Analysis_and_Design-part-01-1080p.mp4', 'uploads/videos/ict-unit-01- System_Analysis_and_Design-part-01-720p.mp4', 'uploads/videos/ict-unit-01- System_Analysis_and_Design-part-01-480p.mp4', 'uploads/videos/ict-unit-01- System_Analysis_and_Design-part-01-360p.mp4', 'uploads/videos/ict-unit-01- System_Analysis_and_Design-part-01.mp3', 57, '2026-10-14 18:08:21'),
(42, 23, 2, 'System Analysis and Design - Part 02', 'uploads/videos/ict-unit-01- System_Analysis_and_Design-part-02.mp4', 'uploads/videos/ict-unit-01- System_Analysis_and_Design-part-02-1080p.mp4', 'uploads/videos/ict-unit-01- System_Analysis_and_Design-part-02-720p.mp4', 'uploads/videos/ict-unit-01- System_Analysis_and_Design-part-02-480p.mp4', 'uploads/videos/ict-unit-01- System_Analysis_and_Design-part-02-360p.mp4', 'uploads/videos/ict-unit-01- System_Analysis_and_Design-part-02.mp3', 59, '2026-10-14 18:08:21'),
(43, 24, 1, 'Database Management - Part 01', 'uploads/videos/ict-unit-02- Database_Management-part-01.mp4', 'uploads/videos/ict-unit-02- Database_Management-part-01-1080p.mp4', 'uploads/videos/ict-unit-02- Database_Management-part-01-720p.mp4', 'uploads/videos/ict-unit-02- Database_Management-part-01-480p.mp4', 'uploads/videos/ict-unit-02- Database_Management-part-01-360p.mp4', 'uploads/videos/ict-unit-02- Database_Management-part-01.mp3', 74, '2026-10-14 18:08:21'),
(44, 25, 1, 'Programming - Part 01', 'uploads/videos/ict-unit-03- Programming-part-01.mp4.mp4', 'uploads/videos/ict-unit-03- Programming-part-01-1080p.mp4', 'uploads/videos/ict-unit-03- Programming-part-01-720p.mp4', 'uploads/videos/ict-unit-03- Programming-part-01-480p.mp4', 'uploads/videos/ict-unit-03- Programming-part-01-360p.mp4', 'uploads/videos/ict-unit-03- Programming-part-01.mp3', 118, '2026-10-14 18:08:21'),
(45, 26, 1, 'Area and Volume - Part 01', 'uploads/videos/sft-unit-01- Area_and_Volume-part-01.mp4', 'uploads/videos/sft-unit-01- Area_and_Volume-part-01-1080p.mp4', 'uploads/videos/sft-unit-01- Area_and_Volume-part-01-720p.mp4', 'uploads/videos/sft-unit-01- Area_and_Volume-part-01-480p.mp4', 'uploads/videos/sft-unit-01- Area_and_Volume-part-01-360p.mp4', 'uploads/videos/sft-unit-01- Area_and_Volume-part-01.mp3', 21, '2026-10-15 04:30:30'),
(46, 26, 2, 'Area and Volume - Part 02', 'uploads/videos/sft-unit-01- Area_and_Volume-part-02.mp4', 'uploads/videos/sft-unit-01- Area_and_Volume-part-02-1080p.mp4', 'uploads/videos/sft-unit-01- Area_and_Volume-part-02-720p.mp4', 'uploads/videos/sft-unit-01- Area_and_Volume-part-02-480p.mp4', 'uploads/videos/sft-unit-01- Area_and_Volume-part-02-360p.mp4', 'uploads/videos/sft-unit-01- Area_and_Volume-part-02.mp3', 22, '2026-10-15 04:30:30'),
(47, 27, 1, 'Measuring Units and Measuring Instruments - Part 01', 'uploads/videos/sft-unit-02- Measuring_Units_and_Measuring_Instruments-part-01.mp4', 'uploads/videos/sft-unit-02- Measuring_Units_and_Measuring_Instruments-part-01-1080p.mp4', 'uploads/videos/sft-unit-02- Measuring_Units_and_Measuring_Instruments-part-01-720p.mp4', 'uploads/videos/sft-unit-02- Measuring_Units_and_Measuring_Instruments-part-01-480p.mp4', 'uploads/videos/sft-unit-02- Measuring_Units_and_Measuring_Instruments-part-01-360p.mp4', 'uploads/videos/sft-unit-02- Measuring_Units_and_Measuring_Instruments-part-01.mp3', 13, '2026-10-15 04:30:30'),
(48, 28, 1, 'Pythagoras Relationship - Part 01', 'uploads/videos/sft-unit-03- Pythagoras_Relationship-part-01.mp4', 'uploads/videos/sft-unit-03- Pythagoras_Relationship-part-01-1080p.mp4', 'uploads/videos/sft-unit-03- Pythagoras_Relationship-part-01-720p.mp4', 'uploads/videos/sft-unit-03- Pythagoras_Relationship-part-01-480p.mp4', 'uploads/videos/sft-unit-03- Pythagoras_Relationship-part-01-360p.mp4', 'uploads/videos/sft-unit-03- Pythagoras_Relationship-part-01.mp3', 16, '2026-10-15 04:30:30'),
(49, 29, 1, 'Polymers - Part 01', 'uploads/videos/sft-unit-01- Polymers-part-01.mp4', 'uploads/videos/sft-unit-01- Polymers-part-01-1080p.mp4', 'uploads/videos/sft-unit-01- Polymers-part-01-720p.mp4', 'uploads/videos/sft-unit-01- Polymers-part-01-480p.mp4', 'uploads/videos/sft-unit-01- Polymers-part-01-360p.mp4', 'uploads/videos/sft-unit-01- Polymers-part-01.mp3', 14, '2026-10-15 04:30:30'),
(50, 30, 1, 'Mechanical Properties of Matter - Part 01', 'uploads/videos/sft-unit-02- Mechanical_Properties_of_Matter-part-01.mp4', 'uploads/videos/sft-unit-02- Mechanical_Properties_of_Matter-part-01-1080p.mp4', 'uploads/videos/sft-unit-02- Mechanical_Properties_of_Matter-part-01-720p.mp4', 'uploads/videos/sft-unit-02- Mechanical_Properties_of_Matter-part-01-480p.mp4', 'uploads/videos/sft-unit-02- Mechanical_Properties_of_Matter-part-01-360p.mp4', 'uploads/videos/sft-unit-02- Mechanical_Properties_of_Matter-part-01.mp3', 18, '2026-10-15 04:30:30'),
(51, 31, 1, 'Fluid Mechanics - Part 01', 'uploads/videos/sft-unit-03- Fluid_Mechanics-part-01.mp4', 'uploads/videos/sft-unit-03- Fluid_Mechanics-part-01-1080p.mp4', 'uploads/videos/sft-unit-03- Fluid_Mechanics-part-01-720p.mp4', 'uploads/videos/sft-unit-03- Fluid_Mechanics-part-01-480p.mp4', 'uploads/videos/sft-unit-03- Fluid_Mechanics-part-01-360p.mp4', 'uploads/videos/sft-unit-03- Fluid_Mechanics-part-01.mp3', 13, '2026-10-15 04:30:30');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `past_papers`
--

CREATE TABLE `past_papers` (
  `paper_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `title` varchar(200) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `past_papers`
--

INSERT INTO `past_papers` (`paper_id`, `subject_id`, `year`, `title`, `file_path`, `created_at`) VALUES
(1, 5, '2016', 'G.C.E. A/L Agricultural Science Past Paper 2016', 'uploads/past_papers/agri-2016-paper.pdf', '2026-09-17 04:02:56'),
(2, 5, '2017', 'G.C.E. A/L Agricultural Science Past Paper 2017', 'uploads/past_papers/agri-2017-paper.pdf', '2026-09-17 04:06:38'),
(3, 5, '2018', 'G.C.E. A/L Agricultural Science Past Paper 2018', 'uploads/past_papers/agri-2018-paper.pdf', '2026-09-17 04:06:38'),
(4, 5, '2019', 'G.C.E. A/L Agricultural Science Past Paper 2019', 'uploads/past_papers/agri-2019-paper.pdf', '2026-09-17 04:06:38'),
(5, 5, '2020', 'G.C.E. A/L Agricultural Science Past Paper 2020', 'uploads/past_papers/agri-2020-paper.pdf', '2026-09-17 04:06:38'),
(6, 3, '2016', 'G.C.E. A/L Bio Systems Technology Past Paper 2016', 'uploads/past_papers/bst-2016-paper.pdf', '2026-09-17 04:06:38'),
(7, 3, '2017', 'G.C.E. A/L Bio Systems Technology Past Paper 2017', 'uploads/past_papers/bst-2017-paper.pdf', '2026-09-17 04:06:38'),
(8, 3, '2018', 'G.C.E. A/L Bio Systems Technology Past Paper 2018', 'uploads/past_papers/bst-2018-paper.pdf', '2026-09-17 04:06:38'),
(9, 3, '2019', 'G.C.E. A/L Bio Systems Technology Past Paper 2019', 'uploads/past_papers/bst-2019-paper.pdf', '2026-09-17 04:06:38'),
(10, 3, '2020', 'G.C.E. A/L Bio Systems Technology Past Paper 2020', 'uploads/past_papers/bst-2020-paper.pdf', '2026-09-17 04:06:38'),
(11, 2, '2016', 'G.C.E. A/L Engineering Technology Past Paper 2016', 'uploads/past_papers/et-2016-paper.pdf', '2026-09-17 04:06:38'),
(12, 2, '2017', 'G.C.E. A/L Engineering Technology Past Paper 2017', 'uploads/past_papers/et-2017-paper.pdf', '2026-09-17 04:06:38'),
(13, 2, '2018', 'G.C.E. A/L Engineering Technology Past Paper 2018', 'uploads/past_papers/et-2018-paper.pdf', '2026-09-17 04:06:38'),
(14, 2, '2019', 'G.C.E. A/L Engineering Technology Past Paper 2019', 'uploads/past_papers/et-2019-paper.pdf', '2026-09-17 04:06:38'),
(15, 2, '2020', 'G.C.E. A/L Engineering Technology Past Paper 2020', 'uploads/past_papers/et-2020-paper.pdf', '2026-09-17 04:06:38'),
(16, 1, '2015', 'G.C.E. A/L Science for Technology Past Paper 2015', 'uploads/past_papers/sft-2015-paper.pdf', '2026-09-17 04:06:38'),
(17, 1, '2016', 'G.C.E. A/L Science for Technology Past Paper 2016', 'uploads/past_papers/sft-2016-paper.pdf', '2026-09-17 04:06:38'),
(18, 1, '2017', 'G.C.E. A/L Science for Technology Past Paper 2017', 'uploads/past_papers/sft-2017-paper.pdf', '2026-09-17 04:06:38'),
(19, 1, '2018', 'G.C.E. A/L Science for Technology Past Paper 2018', 'uploads/past_papers/sft-2018-paper.pdf', '2026-09-17 04:06:38'),
(20, 1, '2019', 'G.C.E. A/L Science for Technology Past Paper 2019', 'uploads/past_papers/sft-2019-paper.pdf', '2026-09-17 04:06:38'),
(21, 1, '2020', 'G.C.E. A/L Science for Technology Past Paper 2020', 'uploads/past_papers/sft-2020-paper.pdf', '2026-09-17 04:06:38');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `time_limit` int(11) DEFAULT 15,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `unit_id`, `title`, `time_limit`, `created_at`) VALUES
(1, 28, 'SFT Unit 01 - Area and Volume Quiz', 15, '2026-09-17 08:10:28'),
(2, 16, 'ET Grade 12 Unit 01 - Introduction to Engineering Technology Quiz', 15, '2026-09-19 08:57:39'),
(3, 17, 'ET Grade 12 Unit 02 - Engineering Drawing Quiz', 15, '2026-09-19 08:59:25'),
(4, 18, 'ET Grade 12 Unit 03 - Health and Safety for Technology Quiz', 15, '2026-09-19 09:00:44'),
(5, 4, 'ICT Grade 12 Unit 01 - Concept of ICT Quiz', 15, '2026-09-19 09:05:24'),
(6, 5, 'ICT Grade 12 Unit 02 - Introduction to Computer Quiz', 15, '2026-09-19 09:09:25'),
(7, 6, 'ICT Grade 12 Unit 03 - Data Representation - Number Systems Quiz', 15, '2026-09-19 09:14:35'),
(8, 29, 'SFT Grade 12 Unit 02 - Measuring Units and Measuring Instruments Quiz', 15, '2026-09-19 09:21:41'),
(9, 30, 'SFT Grade 12 Unit 03 - Pythagoras Relationship Quiz', 15, '2026-09-19 09:28:15'),
(10, 22, 'BST Grade 12 Unit 01 - Weather Quiz', 15, '2026-09-19 09:33:01'),
(11, 23, 'BST Grade 12 Unit 02 - Soil Quiz', 15, '2026-09-19 09:35:29'),
(12, 24, 'BST Grade 12 Unit 03 - Surveying and Levelling Quiz', 15, '2026-09-19 09:36:46'),
(13, 25, 'BST Grade 13 Unit 01 - Mechanization Quiz', 15, '2026-09-19 09:38:46'),
(14, 26, 'BST Grade 13 Unit 02 - Sustainable Timber and Non-Timber Based Products Quiz', 15, '2026-09-19 09:40:10'),
(15, 27, 'BST Grade 13 Unit 03 - Plantation and Minor Export Crops Based Products Quiz', 15, '2026-09-19 09:41:35'),
(16, 7, 'Agriculture Grade 12 Unit 01 - Development of Agriculture in Sri Lanka Quiz', 15, '2026-09-19 09:48:52'),
(17, 8, 'Agriculture Grade 12 Unit 02 - Climatic Factors and Crop Production Quiz', 15, '2026-09-19 09:51:19'),
(18, 9, 'Agriculture Grade 12 Unit 03 - Soil Environment and Crop Cultivation Quiz', 15, '2026-09-19 09:52:40'),
(19, 10, 'Agriculture Grade 13 Unit 01 - Pest Management Quiz', 15, '2026-09-19 09:59:43'),
(20, 11, 'Agriculture Grade 13 Unit 02 - Food Technology Quiz', 15, '2026-09-19 10:01:03'),
(21, 12, 'Agriculture Grade 13 Unit 03 - Post-Harvest Technology Quiz', 15, '2026-09-19 10:03:39'),
(22, 31, 'SFT Grade 13 Unit 01 - Polymers Quiz', 15, '2026-09-19 10:13:12'),
(23, 32, 'SFT Grade 13 Unit 02 - Mechanical Properties of Matter Quiz', 15, '2026-09-19 10:14:47'),
(24, 33, 'SFT Grade 13 Unit 03 - Fluid Mechanics Quiz', 15, '2026-09-19 10:16:04'),
(25, 19, 'ET Grade 13 Unit 01 - Engineering Standards and Specifications Quiz', 15, '2026-09-19 10:21:49'),
(26, 20, 'ET Grade 13 Unit 02 - Generation, Transmission, Distribution and Utilization of Electrical Power Quiz', 15, '2026-09-19 10:23:20'),
(27, 21, 'ET Grade 13 Unit 03 - Electronic Technology Quiz', 15, '2026-09-19 10:24:50'),
(28, 13, 'ICT Grade 13 Unit 01 - System Analysis and Design Quiz', 15, '2026-09-19 10:32:09'),
(29, 14, 'ICT Grade 13 Unit 02 - Database Management Quiz', 15, '2026-09-19 10:33:40'),
(30, 15, 'ICT Grade 13 Unit 03 - Programming Quiz', 15, '2026-09-19 10:34:55'),
(31, 22, 'BST Grade 12 Unit 01 - Weather Conditions Suitable for Biological Systems Quiz', 15, '2026-09-19 14:03:19'),
(32, 23, 'BST Grade 12 Unit 02 - Soil in Biological Systems Quiz', 15, '2026-09-19 14:06:08'),
(33, 24, 'BST Grade 12 Unit 03 - Surveying and Levelling Quiz', 15, '2026-09-19 14:08:25'),
(34, 25, 'BST Grade 13 Unit 01 - Mechanization Quiz', 15, '2026-09-19 14:09:58'),
(35, 26, 'BST Grade 13 Unit 02 - Sustainable Timber and Non-Timber Based Products Quiz', 15, '2026-09-19 14:12:40'),
(36, 27, 'BST Grade 13 Unit 03 - Plantation and Minor Export Crops Based Products Quiz', 15, '2026-09-19 14:15:46'),
(37, 10, 'Example Title', 20, '2026-11-17 06:45:41');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `attempt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `total_marks` int(11) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `correct_count` int(11) NOT NULL,
  `attempted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`attempt_id`, `user_id`, `quiz_id`, `score`, `total_marks`, `percentage`, `correct_count`, `attempted_at`) VALUES
(1, 2, 1, 40, 100, 40.00, 4, '2026-09-17 09:06:22'),
(2, 2, 1, 30, 100, 30.00, 3, '2026-09-17 09:09:54'),
(3, 2, 1, 30, 100, 30.00, 3, '2026-09-17 09:18:24'),
(4, 2, 1, 100, 100, 100.00, 10, '2026-09-17 13:23:25'),
(5, 2, 5, 40, 100, 40.00, 4, '2026-09-19 14:22:59'),
(6, 7, 8, 20, 100, 20.00, 2, '2026-11-13 09:14:04'),
(7, 3, 1, 50, 100, 50.00, 5, '2026-11-16 10:26:37');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempt_answers`
--

CREATE TABLE `quiz_attempt_answers` (
  `answer_id` int(11) NOT NULL,
  `attempt_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_answer` char(1) NOT NULL,
  `correct_answer` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_attempt_answers`
--

INSERT INTO `quiz_attempt_answers` (`answer_id`, `attempt_id`, `question_id`, `selected_answer`, `correct_answer`) VALUES
(1, 1, 6, 'A', 'C'),
(2, 1, 5, 'B', 'C'),
(3, 1, 8, 'C', 'B'),
(4, 1, 4, 'B', 'B'),
(5, 1, 3, 'B', 'A'),
(6, 1, 1, 'A', 'A'),
(7, 1, 9, 'A', 'A'),
(8, 1, 10, 'B', 'A'),
(9, 1, 2, 'C', 'B'),
(10, 1, 7, 'B', 'B'),
(11, 2, 7, 'C', 'B'),
(12, 2, 5, 'C', 'C'),
(13, 2, 10, 'D', 'A'),
(14, 2, 6, 'B', 'C'),
(15, 2, 8, 'C', 'B'),
(16, 2, 1, 'A', 'A'),
(17, 2, 4, 'C', 'B'),
(18, 2, 9, 'B', 'A'),
(19, 2, 3, 'B', 'A'),
(20, 2, 2, 'B', 'B'),
(21, 3, 1, 'A', 'A'),
(22, 3, 7, 'A', 'B'),
(23, 3, 3, 'A', 'A'),
(24, 3, 10, 'B', 'A'),
(25, 3, 8, 'A', 'B'),
(26, 3, 9, 'C', 'A'),
(27, 3, 5, 'B', 'C'),
(28, 3, 2, 'C', 'B'),
(29, 3, 6, 'B', 'C'),
(30, 3, 4, 'B', 'B'),
(31, 4, 5, 'C', 'C'),
(32, 4, 1, 'A', 'A'),
(33, 4, 6, 'C', 'C'),
(34, 4, 8, 'B', 'B'),
(35, 4, 2, 'B', 'B'),
(36, 4, 4, 'B', 'B'),
(37, 4, 3, 'A', 'A'),
(38, 4, 9, 'A', 'A'),
(39, 4, 7, 'B', 'B'),
(40, 4, 10, 'A', 'A'),
(41, 5, 43, 'D', 'D'),
(42, 5, 44, 'B', 'B'),
(43, 5, 47, 'C', 'D'),
(44, 5, 49, 'C', 'C'),
(45, 5, 42, 'C', 'A'),
(46, 5, 48, 'D', 'B'),
(47, 5, 50, 'B', 'D'),
(48, 5, 41, 'C', 'C'),
(49, 5, 45, 'A', 'C'),
(50, 5, 46, 'B', 'A'),
(51, 6, 71, 'A', 'C'),
(52, 6, 76, 'B', 'A'),
(53, 6, 80, 'C', 'D'),
(54, 6, 78, 'B', 'B'),
(55, 6, 72, 'B', 'A'),
(56, 6, 77, 'A', 'D'),
(57, 6, 79, 'B', 'C'),
(58, 6, 73, 'C', 'D'),
(59, 6, 75, 'B', 'C'),
(60, 6, 74, 'B', 'B'),
(61, 7, 7, 'B', 'B'),
(62, 7, 9, 'A', 'A'),
(63, 7, 4, 'C', 'B'),
(64, 7, 6, 'B', 'C'),
(65, 7, 10, 'A', 'A'),
(66, 7, 3, 'C', 'A'),
(67, 7, 1, 'B', 'A'),
(68, 7, 5, 'C', 'C'),
(69, 7, 2, 'B', 'B'),
(70, 7, 8, 'A', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(500) NOT NULL,
  `option_b` varchar(500) NOT NULL,
  `option_c` varchar(500) NOT NULL,
  `option_d` varchar(500) NOT NULL,
  `correct_answer` enum('A','B','C','D') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`question_id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`) VALUES
(1, 1, 'A square has a side length of 8 cm. What is its area?', '64 cm²', '32 cm²', '16 cm²', '128 cm²', 'A'),
(2, 1, 'A trapezium has parallel sides of 10 cm and 6 cm, with a perpendicular height of 4 cm. What is its area?', '24 cm²', '32 cm²', '40 cm²', '64 cm²', 'B'),
(3, 1, 'A triangle has a base of 12 cm and a perpendicular height of 5 cm. What is its area?', '30 cm²', '60 cm²', '17 cm²', '120 cm²', 'A'),
(4, 1, 'A cylinder has radius 3 cm and height 5 cm. What is its total surface area in terms of π?', '30π cm²', '48π cm²', '60π cm²', '96π cm²', 'B'),
(5, 1, 'A cuboid has length 4 cm, width 3 cm, and height 2 cm. What is its total surface area?', '26 cm²', '48 cm²', '52 cm²', '104 cm²', 'C'),
(6, 1, 'A cube has a side length of 4 cm. What is its volume?', '16 cm³', '32 cm³', '64 cm³', '128 cm³', 'C'),
(7, 1, 'A cuboid has dimensions 5 cm × 3 cm × 2 cm. What is its volume?', '10 cm³', '30 cm³', '60 cm³', '15 cm³', 'B'),
(8, 1, 'A cylinder has radius 2 cm and height 7 cm. What is its volume in terms of π?', '14π cm³', '28π cm³', '56π cm³', '49π cm³', 'B'),
(9, 1, 'A cone has radius 3 cm and height 4 cm. What is its volume in terms of π?', '12π cm³', '36π cm³', '9π cm³', '48π cm³', 'A'),
(10, 1, 'According to the given principles, how does the volume of material in a hollow object compare with its total external volume?', 'It is strictly less than the total external volume.', 'It is always equal to the total external volume.', 'It is always greater than the total external volume.', 'It has no relationship with the total external volume.', 'A'),
(11, 2, 'What is Engineering Technology mainly concerned with?', 'Studying history', 'Applying engineering knowledge to practical problems', 'Learning languages', 'Studying literature', 'B'),
(12, 2, 'Which field is closely related to Engineering Technology?', 'Music', 'History', 'Philosophy', 'Engineering', 'D'),
(13, 2, 'What is technology?', 'Application of knowledge to solve practical problems', 'Only the use of computers', 'Study of ancient objects', 'A type of sport', 'A'),
(14, 2, 'Which is an example of Engineering Technology?', 'Writing a poem', 'Painting a picture', 'Designing a bridge', 'Singing a song', 'C'),
(15, 2, 'Which resource is important for technological development?', 'Rumours', 'Knowledge', 'Guessing', 'Entertainment', 'B'),
(16, 2, 'What is the main purpose of engineering?', 'To memorize stories', 'To create songs', 'To study languages', 'To solve problems using scientific and mathematical principles', 'D'),
(17, 2, 'Which one is a branch of engineering?', 'Civil Engineering', 'Literature', 'History', 'Geography', 'A'),
(18, 2, 'Civil Engineering mainly deals with:', 'Computer software only', 'Food preparation', 'Buildings and infrastructure', 'Clothing design', 'C'),
(19, 2, 'Mechanical Engineering is mainly related to:', 'Farming only', 'Literature', 'Music', 'Machines and mechanical systems', 'D'),
(20, 2, 'Electrical Engineering mainly deals with:', 'Agriculture only', 'Electricity and electrical systems', 'Painting', 'History', 'B'),
(21, 3, 'What is Engineering Drawing?', 'A type of music', 'A written story', 'A graphical method of representing engineering ideas', 'A painting technique', 'C'),
(22, 3, 'Which instrument is used to draw straight horizontal lines?', 'T-square', 'Compass', 'Protractor', 'Divider', 'A'),
(23, 3, 'Which instrument is used to measure angles?', 'T-square', 'Compass', 'Ruler', 'Protractor', 'D'),
(24, 3, 'Which instrument is mainly used to draw circles?', 'T-square', 'Compass', 'Set square', 'Scale', 'B'),
(25, 3, 'What is the purpose of a ruler/scale in engineering drawing?', 'To erase lines', 'To draw circles only', 'To measure and draw lines', 'To measure temperature', 'C'),
(26, 3, 'Which line is normally used to represent visible outlines?', 'Continuous thick line', 'Dashed line', 'Chain thin line', 'Freehand line', 'A'),
(27, 3, 'Hidden details are commonly represented using:', 'Thick continuous lines', 'Freehand lines', 'Double lines', 'Dashed lines', 'D'),
(28, 3, 'What is dimensioning?', 'Colouring a drawing', 'Showing the measurements of an object', 'Erasing a drawing', 'Folding paper', 'B'),
(29, 3, 'What does scale represent in a drawing?', 'Colour of the drawing', 'Weight of the object', 'Relationship between drawing size and actual size', 'Material of the object', 'C'),
(30, 3, 'Which instrument is used to draw specific angles?', 'Set square', 'Compass', 'Eraser', 'Divider', 'A'),
(31, 4, 'What is the main purpose of workplace safety?', 'To increase accidents', 'To make work slower', 'To avoid using tools', 'To prevent accidents and injuries', 'D'),
(32, 4, 'What does PPE stand for?', 'Personal Power Equipment', 'Personal Protective Equipment', 'Public Protection Environment', 'Professional Product Engineering', 'B'),
(33, 4, 'Which is an example of PPE?', 'Mobile phone', 'Notebook', 'Safety helmet', 'Calculator', 'C'),
(34, 4, 'Safety goggles are used to protect the:', 'Eyes', 'Feet', 'Ears', 'Hands', 'A'),
(35, 4, 'Safety gloves mainly protect the:', 'Eyes', 'Head', 'Ears', 'Hands', 'D'),
(36, 4, 'Safety shoes are mainly used to protect the:', 'Eyes', 'Feet', 'Head', 'Hands', 'B'),
(37, 4, 'What should you do before using a machine?', 'Start it immediately', 'Remove safety guards', 'Check the machine and safety conditions', 'Ignore instructions', 'C'),
(38, 4, 'What is a hazard?', 'Something that can cause harm', 'A safety rule', 'A protective device', 'A first-aid box', 'A'),
(39, 4, 'Which is an example of a physical hazard?', 'Clean table', 'Safety helmet', 'First-aid box', 'Slippery floor', 'D'),
(40, 4, 'What should be done with spilled liquid on the floor?', 'Clean it immediately', 'Ignore it', 'Walk over it', 'Add more liquid', 'A'),
(41, 5, 'What does ICT stand for?', 'Information and Computer Technology', 'Internet and Communication Technology', 'Information and Communication Technology', 'Information Control Technology', 'C'),
(42, 5, 'What is the main purpose of ICT?', 'To process, store and communicate information', 'To increase paper usage', 'To manufacture computers only', 'To replace electricity', 'A'),
(43, 5, 'Which of the following is an example of ICT?', 'Hammer', 'Spoon', 'Chair', 'Television', 'D'),
(44, 5, 'Which device is commonly used to communicate through the internet?', 'Ruler', 'Smartphone', 'Hammer', 'Chair', 'B'),
(45, 5, 'What is information?', 'Raw facts only', 'A computer program', 'Processed data that has meaning', 'A storage device', 'C'),
(46, 5, 'What is data?', 'Raw facts and figures', 'Processed information', 'A computer network', 'A communication device', 'A'),
(47, 5, 'Which technology allows people to communicate over long distances?', 'Agriculture', 'Construction', 'Carpentry', 'ICT', 'D'),
(48, 5, 'Which of the following is an ICT service?', 'Farming', 'E-mail', 'Cooking', 'Painting', 'B'),
(49, 5, 'Which ICT application is commonly used in education?', 'Wood cutting', 'Brick making', 'Online learning', 'Welding', 'C'),
(50, 5, 'Which of the following is an advantage of ICT in education?', 'Reduces access to information', 'Prevents communication', 'Increases manual work', 'Provides quick access to learning resources', 'D'),
(51, 6, 'What is a computer?', 'A mechanical tool only', 'An electronic device that processes data', 'A communication cable', 'A type of furniture', 'B'),
(52, 6, 'Which unit is known as the brain of the computer?', 'Monitor', 'Keyboard', 'Speaker', 'CPU', 'D'),
(53, 6, 'What does CPU stand for?', 'Central Processing Unit', 'Computer Processing Utility', 'Central Program Unit', 'Computer Power Unit', 'A'),
(54, 6, 'Which device is used to enter text into a computer?', 'Monitor', 'Speaker', 'Keyboard', 'Projector', 'C'),
(55, 6, 'Which device displays information on a screen?', 'Keyboard', 'Monitor', 'Mouse', 'Scanner', 'B'),
(56, 6, 'Which device is used to point, select and click items on a computer?', 'Printer', 'Speaker', 'Monitor', 'Mouse', 'D'),
(57, 6, 'Which of the following is an output device?', 'Keyboard', 'Mouse', 'Monitor', 'Scanner', 'C'),
(58, 6, 'Which device is used to print information on paper?', 'Printer', 'Scanner', 'Keyboard', 'Mouse', 'A'),
(59, 6, 'Which device is used to scan a printed document?', 'Speaker', 'Monitor', 'Projector', 'Scanner', 'D'),
(60, 6, 'What is hardware?', 'Computer instructions only', 'Physical parts of a computer', 'Internet connection', 'Digital information only', 'B'),
(61, 7, 'What is a number system?', 'A type of computer hardware', 'A programming language only', 'A method of representing numbers', 'A storage device', 'C'),
(62, 7, 'Which number system uses only 0 and 1?', 'Binary', 'Decimal', 'Octal', 'Hexadecimal', 'A'),
(63, 7, 'What is the base of the binary number system?', '8', '10', '16', '2', 'D'),
(64, 7, 'What is the base of the decimal number system?', '2', '10', '8', '16', 'B'),
(65, 7, 'What is the base of the octal number system?', '2', '10', '8', '16', 'C'),
(66, 7, 'What is the base of the hexadecimal number system?', '16', '2', '8', '10', 'A'),
(67, 7, 'Which digits are used in the decimal system?', '0–1', '0–7', '0–F', '0–9', 'D'),
(68, 7, 'Which symbols are used in hexadecimal after 9?', 'G–L', 'A–F', 'X–Z', 'P–U', 'B'),
(69, 7, 'What is the binary equivalent of decimal 2?', '01', '11', '10', '100', 'C'),
(70, 7, 'What is the binary equivalent of decimal 5?', '100', '110', '111', '101', 'D'),
(71, 8, 'What is the SI unit of length?', 'Centimetre', 'Kilometre', 'Metre', 'Millimetre', 'C'),
(72, 8, 'What is the SI unit of mass?', 'Kilogram', 'Gram', 'Milligram', 'Tonne', 'A'),
(73, 8, 'What is the SI unit of time?', 'Minute', 'Hour', 'Day', 'Second', 'D'),
(74, 8, 'Which instrument is used to measure length?', 'Thermometer', 'Ruler', 'Balance', 'Stopwatch', 'B'),
(75, 8, 'Which instrument is used to measure temperature?', 'Vernier caliper', 'Measuring cylinder', 'Thermometer', 'Balance', 'C'),
(76, 8, 'Which instrument is used to measure mass?', 'Balance', 'Stopwatch', 'Ruler', 'Thermometer', 'A'),
(77, 8, 'Which instrument is suitable for measuring the internal diameter of a small pipe?', 'Measuring tape', 'Stopwatch', 'Thermometer', 'Vernier caliper', 'D'),
(78, 8, 'Which instrument is commonly used to measure the diameter of a thin wire accurately?', 'Measuring cylinder', 'Micrometer screw gauge', 'Ruler', 'Spring balance', 'B'),
(79, 8, 'Which instrument is used to measure the volume of a liquid?', 'Vernier caliper', 'Balance', 'Measuring cylinder', 'Stopwatch', 'C'),
(80, 8, 'Which instrument is used to measure time accurately in an experiment?', 'Ruler', 'Balance', 'Thermometer', 'Stopwatch', 'D'),
(81, 9, 'The Pythagorean relationship applies to which type of triangle?', 'Equilateral triangle', 'Right-angled triangle', 'Isosceles triangle only', 'Obtuse triangle only', 'B'),
(82, 9, 'Which formula represents the Pythagorean relationship?', 'a + b = c', 'a² + c² = b²', 'a × b = c²', 'a² + b² = c²', 'D'),
(83, 9, 'In a right-angled triangle, what is the hypotenuse?', 'The side opposite the right angle', 'The shortest side', 'Any side', 'The vertical side only', 'A'),
(84, 9, 'Which side is always the longest side of a right-angled triangle?', 'Base', 'Height', 'Hypotenuse', 'Shortest side', 'C'),
(85, 9, 'A right triangle has sides 3 cm and 4 cm. What is the hypotenuse?', '5 cm', '6 cm', '7 cm', '12 cm', 'A'),
(86, 9, 'A right triangle has legs of 6 cm and 8 cm. Find the hypotenuse.', '8 cm', '12 cm', '14 cm', '10 cm', 'D'),
(87, 9, 'If the hypotenuse is 13 cm and one side is 5 cm, what is the other side?', '8 cm', '12 cm', '10 cm', '14 cm', 'B'),
(88, 9, 'If a = 5 and b = 12, what is c?', '10', '11', '13', '12', 'C'),
(89, 9, 'Which equation is used to find a missing leg when the hypotenuse is known?', 'a² = c² − b²', 'a² = c² + b²', 'a = b + c', 'a² = b² − c²', 'A'),
(90, 9, 'A ladder 5 m long reaches a wall. Its bottom is 3 m away from the wall. How high does it reach?', '2 m', '3 m', '5 m', '4 m', 'D'),
(91, 10, 'What is weather?', 'The long-term average of climate only', 'The condition of soil only', 'The condition of the atmosphere at a particular time and place', 'The amount of water in a plant', 'C'),
(92, 10, 'Which factor is important for plant growth?', 'Sound', 'Temperature', 'Noise', 'Colour of buildings', 'B'),
(93, 10, 'Which instrument is used to measure air temperature?', 'Barometer', 'Anemometer', 'Rain gauge', 'Thermometer', 'D'),
(94, 10, 'Which instrument measures atmospheric pressure?', 'Barometer', 'Thermometer', 'Hygrometer', 'Rain gauge', 'A'),
(95, 10, 'Which instrument is used to measure wind speed?', 'Thermometer', 'Barometer', 'Anemometer', 'Hygrometer', 'C'),
(96, 10, 'Which instrument measures rainfall?', 'Barometer', 'Rain gauge', 'Thermometer', 'Anemometer', 'B'),
(97, 10, 'Humidity refers to the amount of:', 'Dust in the air', 'Oxygen in soil', 'Heat in water', 'Water vapour in the air', 'D'),
(98, 10, 'Which instrument is used to measure humidity?', 'Hygrometer', 'Barometer', 'Anemometer', 'Rain gauge', 'A'),
(99, 10, 'Why is sunlight important for green plants?', 'It increases soil weight', 'It prevents respiration', 'It provides energy for photosynthesis', 'It produces nitrogen directly', 'C'),
(100, 10, 'Photosynthesis mainly requires sunlight, carbon dioxide and:', 'Sand', 'Water', 'Nitrogen gas only', 'Oxygen only', 'B'),
(101, 11, 'What is soil?', 'Pure water', 'Atmospheric gas', 'A type of metal', 'The upper layer of the Earth\'s surface that supports plant growth', 'D'),
(102, 11, 'Which component is normally found in soil?', 'Only water', 'Mineral particles', 'Only air', 'Only organic matter', 'B'),
(103, 11, 'Soil contains:', 'Mineral matter, organic matter, water and air', 'Water only', 'Minerals only', 'Air only', 'A'),
(104, 11, 'Which soil component is formed mainly from decomposed plant and animal materials?', 'Sand', 'Gravel', 'Organic matter', 'Clay', 'C'),
(105, 11, 'Which soil particle is the largest among sand, silt and clay?', 'Silt', 'Clay', 'Humus', 'Sand', 'D'),
(106, 11, 'Which soil particle is the smallest?', 'Clay', 'Sand', 'Gravel', 'Silt', 'A'),
(107, 11, 'Soil texture depends mainly on the proportions of:', 'Water and air only', 'Roots and leaves', 'Sand, silt and clay', 'Rocks only', 'C'),
(108, 11, 'Which soil type generally has good drainage?', 'Clay soil', 'Sandy soil', 'Heavy clay soil', 'Waterlogged soil', 'B'),
(109, 11, 'Which soil type has a high water-holding capacity?', 'Sandy soil', 'Gravel', 'Rocky soil', 'Clay soil', 'D'),
(110, 11, 'Loam soil contains a balanced mixture of:', 'Sand, silt and clay', 'Rocks only', 'Clay only', 'Sand only', 'A'),
(111, 12, 'What is surveying?', 'The study of plants', 'The measurement of temperature', 'The process of measuring and determining positions of points on or near the Earth\'s surface', 'The study of weather only', 'C'),
(112, 12, 'What is the main purpose of surveying?', 'To obtain measurements and prepare plans or maps', 'To measure rainfall', 'To identify plant diseases', 'To measure air pressure', 'A'),
(113, 12, 'Which instrument is commonly used for measuring horizontal and vertical angles in surveying?', 'Thermometer', 'Barometer', 'Rain gauge', 'Theodolite', 'D'),
(114, 12, 'Which instrument is commonly used for measuring distances?', 'Barometer', 'Measuring tape', 'Hygrometer', 'Thermometer', 'B'),
(115, 12, 'What is levelling?', 'Measuring rainfall', 'Measuring wind speed', 'Determining the relative heights of points', 'Measuring soil pH', 'C'),
(116, 12, 'Which instrument is traditionally used for levelling?', 'Level instrument', 'Compass only', 'Thermometer', 'Rain gauge', 'A'),
(117, 12, 'What is a benchmark in surveying?', 'A measuring tape', 'A type of soil', 'A weather station', 'A point with a known elevation', 'D'),
(118, 12, 'What does RL mean in levelling?', 'Road Length', 'Reduced Level', 'Reference Line', 'Relative Length', 'B'),
(119, 12, 'What is a levelling staff used for?', 'Measuring temperature', 'Measuring rainfall', 'Reading vertical measurements', 'Measuring wind direction', 'C'),
(120, 12, 'A temporary benchmark is:', 'A fixed point established for temporary surveying work', 'A type of instrument', 'A weather measurement', 'A soil sample', 'A'),
(121, 13, 'What is mechanization?', 'Using only manual labour', 'Stopping agricultural activities', 'Using machines to perform tasks', 'Using animals only', 'C'),
(122, 13, 'What is the main purpose of mechanization in agriculture?', 'To improve efficiency and reduce labour requirements', 'To increase manual work', 'To reduce productivity', 'To increase production time', 'A'),
(123, 13, 'Which machine is commonly used for ploughing?', 'Sprayer only', 'Harvester only', 'Water pump', 'Tractor', 'D'),
(124, 13, 'A tractor is mainly used to:', 'Measure rainfall', 'Provide power for agricultural operations', 'Store seeds', 'Test soil pH', 'B'),
(125, 13, 'Which implement is commonly used for primary tillage?', 'Sprayer', 'Trailer only', 'Plough', 'Harvester', 'C'),
(126, 13, 'What is tillage?', 'Preparation and cultivation of soil', 'Harvesting fruits only', 'Storing crops', 'Processing timber', 'A'),
(127, 13, 'Which machine can be used for sowing seeds?', 'Plough', 'Harvester', 'Water tank', 'Seed drill', 'D'),
(128, 13, 'What is the main function of a seed drill?', 'Harvest mature crops', 'Place seeds at suitable depth and spacing', 'Spray pesticides', 'Pump water', 'B'),
(129, 13, 'Which equipment is commonly used for spraying agricultural chemicals?', 'Plough', 'Seeder', 'Sprayer', 'Thresher', 'C'),
(130, 13, 'What is harvesting?', 'Collecting mature crops from the field', 'Preparing soil', 'Sowing seeds', 'Irrigating crops', 'A'),
(131, 14, 'What is timber?', 'A type of soil', 'A metal product', 'A chemical fertilizer', 'Wood suitable for construction and other uses', 'D'),
(132, 14, 'What does sustainable forestry mean?', 'Cutting all trees in a forest', 'Managing forests to meet present needs while maintaining them for the future', 'Preventing all forest use', 'Removing forest plants permanently', 'B'),
(133, 14, 'Which is a timber product?', 'Honey', 'Rubber latex', 'Furniture', 'Mushroom', 'C'),
(134, 14, 'Which is a non-timber forest product?', 'Honey', 'Wooden table', 'Timber beam', 'Plywood', 'A'),
(135, 14, 'Non-timber forest products are obtained from forests without primarily using:', 'Leaves', 'Fruits', 'Natural materials', 'Timber from trees', 'D'),
(136, 14, 'Which is an example of a non-timber forest product?', 'Wooden door', 'Medicinal plants', 'Timber board', 'Wooden chair', 'B'),
(137, 14, 'Bamboo can be used to produce:', 'Petrol', 'Cement', 'Furniture and handicrafts', 'Steel', 'C'),
(138, 14, 'Which product can be obtained from rubber trees without cutting down the tree?', 'Latex', 'Timber only', 'Charcoal', 'Plywood', 'A'),
(139, 14, 'What is the main purpose of reforestation?', 'To remove forests', 'To increase soil erosion', 'To reduce biodiversity', 'To restore forests by planting trees', 'D'),
(140, 14, 'What is deforestation?', 'Planting trees', 'Removal of forests or trees from an area', 'Forest conservation', 'Natural regeneration', 'B'),
(141, 15, 'What is a plantation crop?', 'A crop grown only in home gardens', 'A wild plant that is never cultivated', 'A crop cultivated on a relatively large scale for commercial purposes', 'A forest tree only', 'C'),
(142, 15, 'Which is a major plantation crop in Sri Lanka?', 'Tea', 'Carrot', 'Cabbage', 'Onion', 'A'),
(143, 15, 'Which of the following is a plantation crop?', 'Tomato', 'Brinjal', 'Pumpkin', 'Rubber', 'D'),
(144, 15, 'Coconut is important because it can provide:', 'Only timber', 'Many different products', 'Only drinking water', 'Only animal feed', 'B'),
(145, 15, 'Which product is made from coconut fibre?', 'Steel', 'Cement', 'Coir products', 'Glass', 'C'),
(146, 15, 'Which product is obtained from rubber latex?', 'Rubber gloves', 'Tea leaves', 'Coconut oil', 'Cinnamon bark', 'A'),
(147, 15, 'Tea is mainly processed to produce:', 'Rubber products', 'Timber products', 'Cement products', 'Tea products for consumption', 'D'),
(148, 15, 'Which is considered a minor export crop?', 'Paddy', 'Cinnamon', 'Maize', 'Potato', 'B'),
(149, 15, 'Which part of the cinnamon plant is mainly used as a spice?', 'Root only', 'Flower only', 'Bark', 'Seed only', 'C'),
(150, 15, 'Which product can be made from cinnamon?', 'Cinnamon oil', 'Rubber tyre', 'Plywood', 'Paper pulp only', 'A'),
(151, 16, 'What is agriculture?', 'The study of computers', 'The science and practice of cultivating crops and rearing animals', 'The construction of buildings', 'The production of vehicles', 'B'),
(152, 16, 'Which crop has been traditionally important in Sri Lankan agriculture?', 'Wheat', 'Apple', 'Olive', 'Rice', 'D'),
(153, 16, 'What was one of the main reasons for developing ancient irrigation systems in Sri Lanka?', 'To provide water for agriculture', 'To produce electricity only', 'To transport vehicles', 'To develop cities', 'A'),
(154, 16, 'Which ancient structure was mainly used to store water for cultivation?', 'Railway', 'Bridge', 'Tank', 'Factory', 'C'),
(155, 16, 'What is paddy cultivation?', 'Growing tea plants', 'Growing rice plants', 'Growing rubber trees', 'Growing coconut trees', 'B'),
(156, 16, 'Which irrigation system is important for agriculture in the dry zone of Sri Lanka?', 'Natural forests only', 'Railway systems', 'Highways', 'Irrigation tanks', 'D'),
(157, 16, 'Which sector provides raw materials for many industries?', 'Agriculture', 'Tourism only', 'Banking', 'Transport only', 'A'),
(158, 16, 'Which crop is an important plantation crop in Sri Lanka?', 'Wheat', 'Barley', 'Tea', 'Cornflakes', 'C'),
(159, 16, 'Which crop is commonly associated with the wet zone highlands of Sri Lanka?', 'Rice only', 'Tea', 'Wheat', 'Cotton', 'B'),
(160, 16, 'Which is an important agricultural export crop of Sri Lanka?', 'Potato chips', 'Bread', 'Wheat flour', 'Tea', 'D'),
(161, 17, 'What is climate?', 'The condition of soil only', 'The amount of fertilizer used', 'The long-term pattern of weather in an area', 'The type of farming tool', 'C'),
(162, 17, 'Which of the following is a climatic factor affecting crop production?', 'Temperature', 'Soil colour only', 'Farm size only', 'Seed shape only', 'A'),
(163, 17, 'Which climatic factor provides energy for photosynthesis?', 'Wind', 'Humidity', 'Rainfall', 'Sunlight', 'D'),
(164, 17, 'What is rainfall?', 'Water stored in a tank only', 'Water that falls from the atmosphere to the Earth\'s surface', 'Water absorbed by roots only', 'Water released from leaves', 'B'),
(165, 17, 'Why is rainfall important for crop production?', 'It prevents photosynthesis', 'It destroys all crops', 'It provides water needed for plant growth', 'It increases soil salinity always', 'C'),
(166, 17, 'What is temperature?', 'A measure of how hot or cold something is', 'The amount of water in soil', 'The speed of wind only', 'The amount of fertilizer', 'A'),
(167, 17, 'How can very high temperatures affect crops?', 'They always increase yield', 'They stop evaporation completely', 'They increase soil fertility automatically', 'They can cause water loss and reduce growth', 'D'),
(168, 17, 'What is humidity?', 'The amount of water in a tank', 'The amount of water vapour in the air', 'The temperature of soil', 'The amount of sunlight', 'B'),
(169, 17, 'Which climatic factor can influence the rate of evaporation from plants?', 'Soil colour only', 'Seed size', 'Wind', 'Fertilizer type only', 'C'),
(170, 17, 'What is photosynthesis?', 'The process by which green plants produce food using light energy', 'The process of absorbing fertilizer', 'The process of harvesting crops', 'The process of seed storage', 'A'),
(171, 18, 'What is soil?', 'A type of fertilizer only', 'The natural medium in which many plants grow', 'A farming machine', 'A climatic factor', 'B'),
(172, 18, 'Which component is commonly found in soil?', 'Plastic only', 'Metal only', 'Glass only', 'Mineral particles', 'D'),
(173, 18, 'What is soil texture?', 'The relative proportion of sand, silt and clay particles', 'The colour of soil only', 'The amount of fertilizer applied', 'The temperature of soil only', 'A'),
(174, 18, 'Which soil particle is the largest?', 'Silt', 'Clay', 'Sand', 'Humus', 'C'),
(175, 18, 'Which soil particle is the smallest among sand, silt and clay?', 'Sand', 'Clay', 'Silt', 'Gravel', 'B'),
(176, 18, 'What is soil structure?', 'The colour of soil', 'The depth of rainfall', 'The type of crop grown', 'The arrangement of soil particles into aggregates', 'D'),
(177, 18, 'What is soil pH?', 'A measure of soil acidity or alkalinity', 'A measure of soil temperature', 'A measure of soil depth', 'A measure of soil colour', 'A'),
(178, 18, 'A soil with a pH below 7 is generally considered:', 'Neutral', 'Alkaline', 'Acidic', 'Saline', 'C'),
(179, 18, 'A soil with a pH of 7 is considered:', 'Acidic', 'Neutral', 'Strongly alkaline', 'Saline', 'B'),
(180, 18, 'Why is soil organic matter important?', 'It always reduces soil fertility', 'It prevents root growth', 'It removes all microorganisms', 'It improves soil properties and provides nutrients', 'D'),
(181, 19, 'What is a pest?', 'A useful fertilizer', 'An organism that causes harm to crops or agricultural products', 'A type of irrigation system', 'A farming machine', 'B'),
(182, 19, 'Which of the following is an example of an insect pest?', 'Honeybee', 'Earthworm', 'Butterfly', 'Aphid', 'D'),
(183, 19, 'What is pest management?', 'Managing pests to reduce their harmful effects', 'Removing all insects from an ecosystem', 'Increasing pest populations', 'Stopping crop cultivation', 'A'),
(184, 19, 'What does IPM stand for?', 'Insect Protection Management', 'Integrated Plant Method', 'Integrated Pest Management', 'International Pest Method', 'C'),
(185, 19, 'What is the main objective of Integrated Pest Management?', 'To eliminate every insect', 'To manage pests effectively while minimizing harmful effects', 'To use pesticides continuously', 'To increase pest populations', 'B'),
(186, 19, 'Which method uses natural enemies to control pests?', 'Chemical control', 'Mechanical control', 'Physical irrigation', 'Biological control', 'D'),
(187, 19, 'Which of the following is a biological control agent?', 'Ladybird beetle', 'Herbicide', 'Fertilizer', 'Fungicide', 'A'),
(188, 19, 'What is chemical pest control?', 'Using natural enemies only', 'Removing weeds by hand', 'Using pesticides to control pests', 'Changing the planting season', 'C'),
(189, 19, 'Which of the following is a mechanical method of pest control?', 'Applying insecticides', 'Releasing predators', 'Using resistant varieties', 'Hand-picking insects', 'D'),
(190, 19, 'What is cultural pest control?', 'Using only chemical pesticides', 'Using agricultural practices to reduce pest problems', 'Removing all beneficial organisms', 'Increasing crop diseases', 'B'),
(191, 20, 'What is food technology?', 'The study of farm machinery only', 'The production of fertilizers', 'The application of science and technology to food processing and preservation', 'The study of soil only', 'C'),
(192, 20, 'Why is food processing carried out?', 'To improve food safety, quality and shelf life', 'To reduce food safety', 'To increase food spoilage', 'To remove all nutrients', 'A'),
(193, 20, 'What is food preservation?', 'Increasing food spoilage', 'Removing all water from every food', 'Increasing microbial growth', 'Preventing or slowing food deterioration', 'D'),
(194, 20, 'Which microorganism can cause food spoilage?', 'Earthworm', 'Bacteria', 'Butterfly', 'Fish', 'B'),
(195, 20, 'What is pasteurization?', 'Freezing food at very low temperatures', 'Drying food completely', 'Controlled heating of food to reduce harmful microorganisms', 'Adding salt only', 'C'),
(196, 20, 'Which method uses low temperature to preserve food?', 'Refrigeration', 'Boiling', 'Sun drying', 'Smoking', 'A'),
(197, 20, 'What is freezing used for in food preservation?', 'Increasing microbial growth', 'Increasing food temperature', 'Removing all nutrients', 'Slowing microbial growth and chemical reactions', 'D'),
(198, 20, 'Which method removes water from food to increase shelf life?', 'Freezing', 'Drying', 'Refrigeration', 'Blanching', 'B'),
(199, 20, 'Why does drying help preserve food?', 'It increases water content', 'It increases microbial growth', 'It reduces available water for microorganisms', 'It increases spoilage', 'C'),
(200, 20, 'What is fermentation?', 'A biological process in which microorganisms convert substances in food', 'A method of freezing food', 'A method of packaging only', 'A method of washing food', 'A'),
(201, 21, 'What is post-harvest technology?', 'The production of seeds only', 'The application of fertilizer', 'The preparation of land before planting', 'The handling, processing and storage of agricultural products after harvesting', 'D'),
(202, 21, 'When does post-harvest technology begin?', 'Before land preparation', 'After harvesting the crop', 'Before seed germination', 'Before planting', 'B'),
(203, 21, 'Why is proper post-harvest handling important?', 'To increase food spoilage', 'To reduce shelf life', 'To reduce losses and maintain product quality', 'To damage crops', 'C'),
(204, 21, 'What is post-harvest loss?', 'Loss of quantity or quality of agricultural products after harvesting', 'Increase in crop yield', 'Increase in soil fertility', 'Increase in rainfall', 'A'),
(205, 21, 'Which factor can cause post-harvest losses?', 'Proper packaging', 'Good transportation', 'Appropriate temperature control', 'Improper storage', 'D'),
(206, 21, 'What is grading?', 'Washing all products', 'Separating agricultural products according to quality or size', 'Drying products only', 'Cooking products', 'B'),
(207, 21, 'What is sorting?', 'Adding fertilizer', 'Irrigating crops', 'Separating damaged or unwanted products from good products', 'Planting seeds', 'C'),
(208, 21, 'Why are fruits and vegetables washed after harvesting?', 'To remove dirt and some contaminants', 'To increase soil content', 'To increase pests', 'To reduce cleanliness', 'A'),
(209, 21, 'What is drying in post-harvest management?', 'Increasing moisture content', 'Adding water to crops', 'Freezing crops', 'Reducing moisture content of agricultural products', 'D'),
(210, 21, 'Why is drying important for grains?', 'It increases fungal growth', 'It helps reduce spoilage during storage', 'It increases moisture content', 'It reduces storage life', 'B'),
(211, 22, 'What is a polymer?', 'A pure metal', 'A type of gas only', 'A substance made of repeating molecular units', 'A single atom', 'C'),
(212, 22, 'The small molecules that join together to form polymers are called:', 'Monomers', 'Catalysts', 'Solvents', 'Electrolytes', 'A'),
(213, 22, 'The process of joining monomers to form a polymer is called:', 'Evaporation', 'Condensation only', 'Filtration', 'Polymerization', 'D'),
(214, 22, 'Which of the following is a natural polymer?', 'PVC', 'Cellulose', 'Nylon', 'Polythene', 'B'),
(215, 22, 'Which of the following is a synthetic polymer?', 'Cellulose', 'Starch', 'PVC', 'Protein', 'C'),
(216, 22, 'PVC stands for:', 'Polyvinyl Chloride', 'Polyvinyl Carbon', 'Polymer Vinyl Compound', 'Plastic Vinyl Calcium', 'A'),
(217, 22, 'Which polymer is commonly used to manufacture plastic bags?', 'Nylon', 'Protein', 'Cellulose', 'Polyethylene', 'D'),
(218, 22, 'Which polymer is commonly used to make fibres and ropes?', 'Starch', 'Nylon', 'Cellulose', 'PVC', 'B'),
(219, 22, 'Thermoplastics can generally be:', 'Melted only once', 'Converted into metals', 'Softened by heating and hardened by cooling repeatedly', 'Burned without changing', 'C'),
(220, 22, 'Which is an example of a thermoplastic?', 'PVC', 'Bakelite', 'Melamine', 'Epoxy resin', 'A'),
(221, 23, 'What is a mechanical property?', 'A property related only to colour', 'A property describing how a material behaves when subjected to forces', 'A chemical reaction', 'A type of electrical circuit', 'B'),
(222, 23, 'The ability of a material to resist deformation is related to its:', 'Colour', 'Temperature only', 'Density only', 'Strength', 'D'),
(223, 23, 'Stress is defined as:', 'Force per unit area', 'Area per unit force', 'Force × area', 'Mass per unit volume', 'A'),
(224, 23, 'The SI unit of stress is:', 'Newton', 'Joule', 'Pascal', 'Watt', 'C'),
(225, 23, 'Strain is:', 'Force divided by area', 'Deformation divided by original dimension', 'Mass divided by volume', 'Energy divided by time', 'B'),
(226, 23, 'Strain is generally:', 'Measured in pascals', 'Measured in newtons', 'Measured in joules', 'Dimensionless', 'D'),
(227, 23, 'Young\'s modulus is the ratio of:', 'Tensile stress to tensile strain', 'Force to mass', 'Pressure to volume', 'Energy to time', 'A'),
(228, 23, 'A material that returns to its original shape after removing the load shows:', 'Plasticity', 'Brittleness', 'Elasticity', 'Hardness only', 'C'),
(229, 23, 'Plastic deformation is:', 'Temporary deformation only', 'No deformation', 'Thermal expansion only', 'Permanent deformation', 'D'),
(230, 23, 'Which property describes the ability of a material to withstand scratching or indentation?', 'Hardness', 'Elasticity', 'Ductility', 'Plasticity', 'A'),
(231, 24, 'What is a fluid?', 'A substance that cannot change shape', 'A solid material only', 'A substance that can flow', 'A metal only', 'C'),
(232, 24, 'Which of the following is a fluid?', 'Water', 'Steel', 'Wood', 'Glass', 'A'),
(233, 24, 'Density is defined as:', 'Volume per unit mass', 'Force per unit area', 'Mass × volume', 'Mass per unit volume', 'D'),
(234, 24, 'The SI unit of density is:', 'N/m²', 'kg/m³', 'kg/m', 'N/m', 'B'),
(235, 24, 'Pressure is defined as:', 'Force × area', 'Area per unit mass', 'Force per unit area', 'Mass per unit volume', 'C'),
(236, 24, 'The SI unit of pressure is:', 'Pascal', 'Newton', 'Joule', 'Watt', 'A'),
(237, 24, 'Fluid pressure at a depth in a liquid generally:', 'Decreases with depth', 'Remains zero', 'Does not depend on depth', 'Increases with depth', 'D'),
(238, 24, 'Hydrostatic pressure is pressure caused by:', 'A moving solid', 'A fluid at rest', 'An electric current', 'A magnetic field', 'B'),
(239, 24, 'The pressure due to a liquid column depends on:', 'Colour only', 'Temperature only', 'Density, gravitational acceleration, and depth', 'Container colour', 'C'),
(240, 24, 'Pascal\'s principle states that pressure applied to an enclosed fluid is:', 'Transmitted throughout the fluid', 'Completely lost', 'Transmitted only upward', 'Transmitted only downward', 'A'),
(241, 25, 'What is an engineering standard?', 'A personal opinion', 'A document that provides agreed technical requirements', 'A drawing only', 'A financial report', 'B'),
(242, 25, 'What is the main purpose of engineering standards?', 'To increase production errors', 'To reduce safety', 'To avoid measurements', 'To ensure quality, safety, and consistency', 'D'),
(243, 25, 'What is a specification?', 'A detailed description of requirements for a product or process', 'A type of machine', 'A safety helmet', 'A mathematical formula only', 'A'),
(244, 25, 'Which organization develops international standards?', 'FIFA', 'WHO only', 'ISO', 'UNESCO only', 'C'),
(245, 25, 'What does ISO stand for?', 'International Safety Organization', 'International Organization for Standardization', 'Institute of Standard Operations', 'International System Office', 'B'),
(246, 25, 'What does IEC mainly deal with?', 'Electrical and electronic standards', 'Agricultural standards only', 'Sports regulations', 'Road traffic rules only', 'A'),
(247, 25, 'Why are standards important in manufacturing?', 'They increase product defects', 'They eliminate measurements', 'They prevent production', 'They help maintain consistent quality', 'D'),
(248, 25, 'Which factor is important when preparing an engineering specification?', 'Favourite colour of the engineer', 'Personal hobbies', 'Required performance', 'Weather only', 'C'),
(249, 25, 'Standards can help improve:', 'Safety', 'Accidents', 'Confusion', 'Product defects', 'A'),
(250, 25, 'What is standardization?', 'Removing all measurements', 'Establishing common requirements or rules', 'Producing random products', 'Avoiding quality control', 'B'),
(251, 26, 'What is electrical power generation?', 'Storing water only', 'Using electrical appliances', 'Producing electrical energy from another form of energy', 'Measuring temperature', 'C'),
(252, 26, 'Which device converts mechanical energy into electrical energy?', 'Generator', 'Transformer', 'Motor', 'Battery charger', 'A'),
(253, 26, 'Which energy source is used in a hydroelectric power plant?', 'Coal only', 'Natural gas only', 'Nuclear fuel only', 'Water', 'D'),
(254, 26, 'What is the main purpose of electrical transmission?', 'To produce electricity in homes', 'To transfer electrical power over long distances', 'To store electricity', 'To consume electricity', 'B'),
(255, 26, 'Why is high voltage used for transmission?', 'To increase current losses', 'To stop electricity flow', 'To reduce transmission losses', 'To reduce generator speed', 'C'),
(256, 26, 'Which device is used to increase voltage for transmission?', 'Step-up transformer', 'Step-down transformer', 'Motor', 'Rectifier', 'A'),
(257, 26, 'Which device reduces voltage for distribution or utilization?', 'Step-up transformer', 'Generator', 'Alternator only', 'Step-down transformer', 'D'),
(258, 26, 'What is electrical distribution?', 'Producing electricity from coal', 'Supplying electrical power from substations to consumers', 'Generating mechanical energy', 'Storing electricity in batteries only', 'B'),
(259, 26, 'Which voltage is generally used by consumers compared with transmission voltage?', 'Higher voltage', 'Extremely high voltage', 'Lower voltage', 'No voltage', 'C'),
(260, 26, 'What is the function of a transformer?', 'To change AC voltage levels', 'To generate fuel', 'To store mechanical energy', 'To measure temperature', 'A'),
(261, 27, 'What is electronics mainly concerned with?', 'Study of plants', 'Building roads only', 'Studying languages', 'Control and flow of electrons in circuits', 'D'),
(262, 27, 'Which component is used to limit current in a circuit?', 'Capacitor', 'Resistor', 'Transformer', 'Switch only', 'B'),
(263, 27, 'The unit of electrical resistance is:', 'Volt', 'Ampere', 'Ohm', 'Watt', 'C'),
(264, 27, 'What is the function of a capacitor?', 'To store electrical charge', 'To produce mechanical energy', 'To measure temperature', 'To increase wire length', 'A'),
(265, 27, 'The unit of capacitance is:', 'Ohm', 'Henry', 'Watt', 'Farad', 'D'),
(266, 27, 'A diode mainly allows current to flow:', 'In all directions equally', 'In one direction', 'In no direction', 'Only through air', 'B'),
(267, 27, 'Which semiconductor material is commonly used in electronic components?', 'Wood', 'Glass', 'Silicon', 'Rubber', 'C'),
(268, 27, 'What is the main function of an LED?', 'To emit light when current flows through it', 'To store electrical energy', 'To increase resistance only', 'To measure voltage', 'A'),
(269, 27, 'LED stands for:', 'Low Energy Device', 'Light Electronic Display', 'Linear Emitting Device', 'Light Emitting Diode', 'D'),
(270, 27, 'Which component can be used as an electronic switch and amplifier?', 'Resistor', 'Transistor', 'Capacitor', 'Fuse', 'B'),
(271, 28, 'What is the main purpose of system analysis?', 'To purchase computers', 'To write advertisements', 'To understand the requirements and problems of a system', 'To install games', 'C'),
(272, 28, 'What does SDLC stand for?', 'System Development Life Cycle', 'Software Data Link Control', 'System Data Level Computer', 'Software Design Learning Cycle', 'A'),
(273, 28, 'Which is the first phase of the SDLC?', 'Testing', 'Maintenance', 'Implementation', 'Planning', 'D'),
(274, 28, 'What is a feasibility study used for?', 'To design a logo', 'To check whether a proposed system is practical and achievable', 'To write computer games', 'To print documents', 'B'),
(275, 28, 'Who are stakeholders in a system?', 'Only programmers', 'Only managers', 'People who are affected by or interested in the system', 'Only customers', 'C'),
(276, 28, 'What is a requirement?', 'A need or condition that the system should satisfy', 'A computer virus', 'A programming error', 'A hardware component', 'A'),
(277, 28, 'Which requirement describes what a system should do?', 'Physical requirement', 'Hardware requirement', 'Network requirement', 'Functional requirement', 'D'),
(278, 28, 'Which diagram is commonly used to represent the flow of data in a system?', 'Pie chart', 'DFD', 'Bar chart', 'Histogram', 'B'),
(279, 28, 'What does DFD stand for?', 'Data File Design', 'Digital Flow Data', 'Data Flow Diagram', 'Database File Diagram', 'C'),
(280, 28, 'Which symbol represents an external entity in a DFD?', 'Rectangle', 'Circle', 'Arrow', 'Double line', 'A'),
(281, 29, 'What is a database?', 'A computer monitor', 'A programming language', 'An organized collection of related data', 'A network cable', 'C'),
(282, 29, 'What does DBMS stand for?', 'Database Management System', 'Data Backup Management Software', 'Database Machine System', 'Digital Base Management Service', 'A'),
(283, 29, 'Which of the following is a DBMS?', 'Microsoft Paint', 'VLC Player', 'Calculator', 'MySQL', 'D'),
(284, 29, 'What is a table in a relational database?', 'A computer screen', 'A collection of rows and columns', 'A programming language', 'A network device', 'B'),
(285, 29, 'What is a row in a database table called?', 'Field', 'Attribute', 'Record', 'Column', 'C'),
(286, 29, 'What is a column in a database table called?', 'Field', 'Record', 'Tuple', 'Database', 'A'),
(287, 29, 'What is a primary key?', 'A password for the computer', 'A database backup', 'A type of software', 'A field that uniquely identifies each record', 'D'),
(288, 29, 'Which property should a primary key have?', 'Duplicate values', 'Unique values', 'Only text values', 'Empty values', 'B'),
(289, 29, 'What is a foreign key?', 'A computer password', 'A database backup', 'A field that links one table to another', 'A programming variable', 'C'),
(290, 29, 'What does SQL stand for?', 'Simple Question Language', 'System Query Logic', 'Structured Query Language', 'Structured Quick Link', 'C'),
(291, 30, 'What is programming?', 'Repairing computer hardware', 'Designing a computer table', 'The process of writing instructions for a computer', 'Connecting a printer', 'C'),
(292, 30, 'What is a programming language?', 'A language used to write computer programs', 'A human spoken language only', 'A type of hardware', 'A database table', 'A'),
(293, 30, 'Which of the following is a programming language?', 'Keyboard', 'Monitor', 'Printer', 'Python', 'D'),
(294, 30, 'What is an algorithm?', 'A computer monitor', 'A step-by-step procedure for solving a problem', 'A storage device', 'A network cable', 'B'),
(295, 30, 'What is a variable?', 'A computer screen', 'A printer', 'A named memory location used to store a value', 'A database server', 'C'),
(296, 30, 'Which symbol is commonly used for assignment in many programming languages?', '=', '+', '*', '/', 'A'),
(297, 30, 'Which data type is normally used to store whole numbers?', 'String', 'Boolean', 'Character', 'Integer', 'D'),
(298, 30, 'Which data type is used to store text?', 'Integer', 'String', 'Boolean', 'Float', 'B'),
(299, 30, 'Which data type represents True or False?', 'Integer', 'String', 'Boolean', 'Float', 'C'),
(300, 30, 'Which operator is used for addition?', '+', '-', '*', '/', 'A'),
(301, 2, 'Which of the following is a technological product?', 'Smartphone', 'Tree', 'River', 'Mountain', 'A'),
(302, 2, 'What is innovation?', 'Introducing a new or improved idea, product, or method', 'Copying everything without changes', 'Avoiding technology', 'Memorizing information', 'A'),
(303, 2, 'Which subject is important in Engineering Technology?', 'Mathematics', 'Poetry only', 'Music only', 'Drama only', 'A'),
(304, 2, 'Why is science important in technology?', 'It provides knowledge used to develop technological solutions', 'It is only used for entertainment', 'It replaces all machines', 'It is unrelated to technology', 'A'),
(305, 2, 'Which person is commonly involved in technological development?', 'Engineer', 'Singer', 'Actor', 'Poet', 'A'),
(306, 2, 'What is a technological system?', 'A combination of components working together to achieve a purpose', 'A collection of books', 'A type of poem', 'A musical instrument', 'A'),
(307, 2, 'Which is a benefit of technology?', 'Improving efficiency and solving problems', 'Increasing problems only', 'Preventing communication', 'Reducing knowledge', 'A'),
(308, 2, 'Which one is an example of renewable energy technology?', 'Solar power system', 'Coal burning', 'Petrol engine', 'Diesel generator', 'A'),
(309, 2, 'Engineering Technology can help to:', 'Develop useful products and systems', 'Stop all technological development', 'Eliminate scientific knowledge', 'Avoid problem solving', 'A'),
(310, 2, 'What is one important quality of a technologist?', 'Problem-solving ability', 'Laziness', 'Carelessness', 'Ignoring safety', 'A'),
(311, 3, 'What is a freehand sketch?', 'A drawing made without drawing instruments', 'A drawing made only with a compass', 'A computer-generated drawing', 'A printed drawing', 'A'),
(312, 3, 'Which paper is commonly used for engineering drawings?', 'Drawing paper', 'Newspaper', 'Tissue paper', 'Wrapping paper', 'A'),
(313, 3, 'What is the purpose of a title block?', 'To provide important information about the drawing', 'To colour the drawing', 'To erase dimensions', 'To draw circles', 'A'),
(314, 3, 'Which information can be included in a title block?', 'Drawing title', 'Weather report', 'Food menu', 'Story title only', 'A'),
(315, 3, 'Orthographic projection is used to show:', 'Different views of an object', 'Only the colour of an object', 'The weight of an object', 'The temperature of an object', 'A'),
(316, 3, 'Which is a common orthographic view?', 'Front view', 'Music view', 'Sound view', 'Colour view', 'A'),
(317, 3, 'What is an isometric drawing used for?', 'Showing a three-dimensional appearance of an object', 'Showing only text', 'Measuring temperature', 'Recording sound', 'A'),
(318, 3, 'What is the purpose of an eraser?', 'To remove unwanted lines', 'To draw circles', 'To measure angles', 'To draw dimensions', 'A'),
(319, 3, 'Why is accuracy important in Engineering Drawing?', 'To represent the object correctly', 'To make the drawing colourful', 'To increase the paper size', 'To make the drawing difficult', 'A'),
(320, 3, 'Engineering drawings are mainly used to:', 'Communicate technical information', 'Write stories', 'Create music', 'Record conversations', 'A'),
(321, 4, 'Why should tools be stored properly?', 'To prevent accidents and damage', 'To make them difficult to find', 'To increase hazards', 'To waste space', 'A'),
(322, 4, 'What is the correct action when an accident occurs?', 'Report it immediately', 'Hide it', 'Ignore it', 'Continue working without informing anyone', 'A'),
(323, 4, 'What is first aid?', 'Immediate basic help given to an injured person', 'A type of machine', 'A safety sign', 'A type of engineering drawing', 'A'),
(324, 4, 'Why are safety signs used?', 'To provide warnings and safety information', 'To decorate workplaces', 'To identify workers', 'To show prices', 'A'),
(325, 4, 'What does a warning sign usually indicate?', 'Possible danger or hazard', 'Food availability', 'Working hours', 'Product price', 'A'),
(326, 4, 'Electrical equipment should be used with:', 'Proper safety precautions', 'Wet hands', 'Damaged wires', 'Removed safety covers', 'A'),
(327, 4, 'Why should electrical equipment not be operated with wet hands?', 'It can increase the risk of electric shock', 'It improves performance', 'It saves electricity', 'It makes the equipment cleaner', 'A'),
(328, 4, 'What is good housekeeping in a workplace?', 'Keeping the workplace clean and organized', 'Leaving tools on the floor', 'Blocking exits', 'Leaving waste everywhere', 'A'),
(329, 4, 'Emergency exits should be:', 'Kept clear and accessible', 'Locked permanently', 'Used for storage', 'Blocked with equipment', 'A'),
(330, 4, 'Who is responsible for following safety rules?', 'Everyone in the workplace', 'Only the teacher', 'Only the manager', 'Only visitors', 'A'),
(331, 25, 'Which is an advantage of using standards?', 'Compatibility between products', 'Increased uncertainty', 'Reduced safety', 'Increased defects', 'A'),
(332, 25, 'Engineering specifications should be:', 'Clear and measurable', 'Vague and confusing', 'Based only on opinions', 'Unwritten', 'A'),
(333, 25, 'Which organization is responsible for Sri Lankan national standards?', 'Sri Lanka Standards Institution (SLSI)', 'FIFA', 'NASA', 'IMF', 'A'),
(334, 25, 'What does SLS stand for in Sri Lankan standards?', 'Sri Lanka Standard', 'Safety Level System', 'Standard Legal Service', 'Sri Lankan Laboratory System', 'A'),
(335, 25, 'Why are tolerances used in engineering?', 'To specify acceptable variation in dimensions', 'To remove all measurements', 'To increase errors', 'To change the material colour', 'A'),
(336, 25, 'Which is an example of an engineering specification?', 'Maximum operating temperature', 'Favourite food', 'Employee\'s hobby', 'Office decoration', 'A'),
(337, 25, 'Standards are useful for ensuring:', 'Interchangeability of components', 'Random production', 'Uncontrolled quality', 'Unnecessary waste', 'A'),
(338, 25, 'What can happen if engineering specifications are not followed?', 'Product performance and safety may be affected', 'Quality always improves', 'Safety always increases', 'Production becomes automatically perfect', 'A'),
(339, 25, 'Which is an important feature of a good standard?', 'It should be understandable and practical', 'It should be confusing', 'It should have no requirements', 'It should change randomly', 'A'),
(340, 25, 'Engineering standards mainly support:', 'Safety, quality, reliability, and compatibility', 'Entertainment', 'Advertising only', 'Personal preferences', 'A'),
(341, 26, 'What is electrical power generation?', 'Producing electrical energy from another form of energy', 'Storing water only', 'Using electrical appliances', 'Measuring temperature', 'A');
INSERT INTO `quiz_questions` (`question_id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`) VALUES
(342, 26, 'Which device converts mechanical energy into electrical energy?', 'Generator', 'Transformer', 'Motor', 'Battery charger', 'A'),
(343, 26, 'Which energy source is used in a hydroelectric power plant?', 'Water', 'Coal only', 'Natural gas only', 'Nuclear fuel only', 'A'),
(344, 26, 'What is the main purpose of electrical transmission?', 'To transfer electrical power over long distances', 'To produce electricity in homes', 'To store electricity', 'To consume electricity', 'A'),
(345, 26, 'Why is high voltage used for transmission?', 'To reduce transmission losses', 'To increase current losses', 'To stop electricity flow', 'To reduce generator speed', 'A'),
(346, 26, 'Which device is used to increase voltage for transmission?', 'Step-up transformer', 'Step-down transformer', 'Motor', 'Rectifier', 'A'),
(347, 26, 'Which device reduces voltage for distribution or utilization?', 'Step-down transformer', 'Step-up transformer', 'Generator', 'Alternator only', 'A'),
(348, 26, 'What is electrical distribution?', 'Supplying electrical power from substations to consumers', 'Producing electricity from coal', 'Generating mechanical energy', 'Storing electricity in batteries only', 'A'),
(349, 26, 'Which voltage is generally used by consumers compared with transmission voltage?', 'Lower voltage', 'Higher voltage', 'Extremely high voltage', 'No voltage', 'A'),
(350, 26, 'What is the function of a transformer?', 'To change AC voltage levels', 'To generate fuel', 'To store mechanical energy', 'To measure temperature', 'A'),
(351, 26, 'Which power plant uses sunlight to generate electricity?', 'Solar power plant', 'Thermal power plant', 'Diesel power plant', 'Hydroelectric plant', 'A'),
(352, 26, 'Which is a renewable source of electrical energy?', 'Wind', 'Coal', 'Diesel', 'Petrol', 'A'),
(353, 26, 'What is the main function of a substation?', 'Transform and control electrical power', 'Manufacture electrical appliances', 'Produce petrol', 'Store food', 'A'),
(354, 26, 'Electrical power is commonly transmitted using:', 'Transmission lines', 'Water pipes', 'Gas pipes', 'Telephone cables only', 'A'),
(355, 26, 'Which quantity is measured in watts?', 'Electrical power', 'Electrical resistance', 'Voltage', 'Electric charge', 'A'),
(356, 26, 'Which unit is used to measure electrical energy consumed by households?', 'Kilowatt-hour (kWh)', 'Volt', 'Ampere', 'Ohm', 'A'),
(357, 26, 'Which appliance converts electrical energy mainly into mechanical energy?', 'Electric motor', 'Electric heater', 'Lamp', 'Iron', 'A'),
(358, 26, 'An electric lamp mainly converts electrical energy into:', 'Light and heat', 'Mechanical energy only', 'Chemical energy only', 'Sound only', 'A'),
(359, 26, 'What is one major source of power loss in transmission lines?', 'Resistance of conductors', 'Colour of conductors', 'Shape of houses', 'Size of switches only', 'A'),
(360, 26, 'Which sequence correctly represents the electrical power system?', 'Generation → Transmission → Distribution → Utilization', 'Distribution → Generation → Utilization → Transmission', 'Utilization → Distribution → Generation → Transmission', 'Transmission → Utilization → Generation → Distribution', 'A'),
(361, 27, 'What is electronics mainly concerned with?', 'Control and flow of electrons in circuits', 'Study of plants', 'Building roads only', 'Studying languages', 'A'),
(362, 27, 'Which component is used to limit current in a circuit?', 'Resistor', 'Capacitor', 'Transformer', 'Switch only', 'A'),
(363, 27, 'The unit of electrical resistance is:', 'Ohm', 'Volt', 'Ampere', 'Watt', 'A'),
(364, 27, 'What is the function of a capacitor?', 'To store electrical charge', 'To produce mechanical energy', 'To measure temperature', 'To increase wire length', 'A'),
(365, 27, 'The unit of capacitance is:', 'Farad', 'Ohm', 'Henry', 'Watt', 'A'),
(366, 27, 'A diode mainly allows current to flow:', 'In one direction', 'In all directions equally', 'In no direction', 'Only through air', 'A'),
(367, 27, 'Which semiconductor material is commonly used in electronic components?', 'Silicon', 'Wood', 'Glass', 'Rubber', 'A'),
(368, 27, 'What is the main function of an LED?', 'To emit light when current flows through it', 'To store electrical energy', 'To increase resistance only', 'To measure voltage', 'A'),
(369, 27, 'LED stands for:', 'Light Emitting Diode', 'Low Energy Device', 'Light Electronic Display', 'Linear Emitting Device', 'A'),
(370, 27, 'Which component can be used as an electronic switch and amplifier?', 'Transistor', 'Resistor', 'Capacitor', 'Fuse', 'A'),
(371, 27, 'What is a transistor made mainly from?', 'Semiconductor material', 'Wood', 'Paper', 'Ceramic only', 'A'),
(372, 27, 'Which component protects a circuit from excessive current?', 'Fuse', 'Capacitor', 'LED', 'Transistor', 'A'),
(373, 27, 'What happens when a fuse carries excessive current?', 'It melts and breaks the circuit', 'It produces more current', 'It stores energy', 'It increases voltage', 'A'),
(374, 27, 'What is an integrated circuit (IC)?', 'A circuit containing many electronic components on a single chip', 'A type of electrical wire', 'A mechanical gear', 'A battery case', 'A'),
(375, 27, 'Which device converts AC into DC?', 'Rectifier', 'Transformer only', 'Motor', 'Oscillator', 'A'),
(376, 27, 'Which component is commonly used to smooth a rectified DC output?', 'Capacitor', 'Switch', 'Fuse', 'Resistor only', 'A'),
(377, 27, 'What does PCB stand for?', 'Printed Circuit Board', 'Power Control Battery', 'Printed Current Box', 'Power Circuit Battery', 'A'),
(378, 27, 'What is the purpose of a PCB?', 'To mechanically support and electrically connect electronic components', 'To store fuel', 'To generate electricity from water', 'To measure temperature only', 'A'),
(379, 27, 'Which instrument is commonly used to measure voltage, current, and resistance?', 'Multimeter', 'Oscillator', 'Transformer', 'Motor', 'A'),
(380, 27, 'Which device is commonly used to amplify electronic signals?', 'Transistor', 'Fuse', 'Switch', 'Resistor only', 'A'),
(381, 28, 'What is a polymer?', 'A substance made of repeating molecular units', 'A pure metal', 'A type of gas only', 'A single atom', 'A'),
(382, 28, 'The small molecules that join together to form polymers are called:', 'Monomers', 'Catalysts', 'Solvents', 'Electrolytes', 'A'),
(383, 28, 'The process of joining monomers to form a polymer is called:', 'Polymerization', 'Evaporation', 'Condensation only', 'Filtration', 'A'),
(384, 28, 'Which of the following is a natural polymer?', 'Cellulose', 'PVC', 'Nylon', 'Polythene', 'A'),
(385, 28, 'Which of the following is a synthetic polymer?', 'PVC', 'Cellulose', 'Starch', 'Protein', 'A'),
(386, 28, 'PVC stands for:', 'Polyvinyl Chloride', 'Polyvinyl Carbon', 'Polymer Vinyl Compound', 'Plastic Vinyl Calcium', 'A'),
(387, 28, 'Which polymer is commonly used to manufacture plastic bags?', 'Polyethylene', 'Nylon', 'Protein', 'Cellulose', 'A'),
(388, 28, 'Which polymer is commonly used to make fibres and ropes?', 'Nylon', 'Starch', 'Cellulose', 'PVC', 'A'),
(389, 28, 'Thermoplastics can generally be:', 'Softened by heating and hardened by cooling repeatedly', 'Melted only once', 'Converted into metals', 'Burned without changing', 'A'),
(390, 28, 'Which is an example of a thermoplastic?', 'PVC', 'Bakelite', 'Melamine', 'Epoxy resin', 'A'),
(391, 28, 'Thermosetting polymers generally:', 'Cannot be softened and reshaped repeatedly after curing', 'Melt every time they are heated', 'Behave exactly like metals', 'Dissolve in water easily', 'A'),
(392, 28, 'Which is a thermosetting polymer?', 'Bakelite', 'Polythene', 'PVC', 'Polypropylene', 'A'),
(393, 28, 'Elastomers are polymers that can:', 'Undergo large deformation and return approximately to their original shape', 'Conduct electricity like copper', 'Become metals when heated', 'Dissolve completely in water', 'A'),
(394, 28, 'Which is an example of an elastomer?', 'Natural rubber', 'Glass', 'Copper', 'Aluminium', 'A'),
(395, 28, 'Which property makes many polymers useful as electrical insulators?', 'Low electrical conductivity', 'High density', 'High electrical conductivity', 'High melting point only', 'A'),
(396, 28, 'Which polymer is commonly used for making water pipes?', 'PVC', 'Cotton', 'Protein', 'Natural starch', 'A'),
(397, 28, 'A major environmental problem associated with many plastics is:', 'Slow degradation', 'High water production', 'Rapid conversion into oxygen', 'Easy decomposition in all environments', 'A'),
(398, 28, 'Biodegradable polymers are designed to:', 'Break down through biological processes under suitable conditions', 'Never change', 'Become metals', 'Produce electricity', 'A'),
(399, 28, 'Which one is a carbohydrate polymer?', 'Starch', 'PVC', 'Nylon', 'Bakelite', 'A'),
(400, 28, 'Which of the following is an important advantage of polymers?', 'They can be lightweight and easily shaped', 'They are always stronger than all metals', 'They always conduct electricity well', 'They cannot be processed into different shapes', 'A'),
(401, 29, 'What is ductility?', 'The ability of a material to be drawn into wires', 'The ability to resist all heat', 'The tendency to break suddenly', 'The ability to resist electrical current', 'A'),
(402, 29, 'Malleability is the ability of a material to:', 'Be hammered or rolled into thin sheets', 'Be drawn into wires only', 'Resist electricity', 'Return to its original shape', 'A'),
(403, 29, 'A brittle material tends to:', 'Fracture with little plastic deformation', 'Stretch greatly before breaking', 'Return completely to its original shape', 'Flow like a liquid', 'A'),
(404, 29, 'Toughness is the ability of a material to:', 'Absorb energy before fracture', 'Conduct electricity', 'Resist only temperature', 'Change colour', 'A'),
(405, 29, 'The ability of a material to resist sudden impact is related to:', 'Toughness', 'Density', 'Colour', 'Conductivity', 'A'),
(406, 29, 'A material that can withstand a large tensile force before breaking has high:', 'Tensile strength', 'Brittleness', 'Porosity', 'Conductivity', 'A'),
(407, 29, 'When a material is subjected to a pulling force, it experiences:', 'Tensile stress', 'Compressive stress', 'Shear stress only', 'Thermal stress only', 'A'),
(408, 29, 'When a material is subjected to a pushing force, it experiences:', 'Compressive stress', 'Tensile stress', 'Electrical stress', 'Magnetic stress', 'A'),
(409, 29, 'Shear stress acts:', 'Parallel to the surface', 'Only vertically downward', 'Only upward', 'Perpendicular to every surface', 'A'),
(410, 29, 'Which material property is particularly important when selecting a material for a load-bearing structure?', 'Strength', 'Colour', 'Transparency only', 'Odour', 'A'),
(411, 30, 'Hydraulic machines operate mainly using:', 'Pascal\'s principle', 'Ohm\'s law', 'Newton\'s law of cooling', 'Hooke\'s law only', 'A'),
(412, 30, 'Which device is an application of hydraulic principles?', 'Hydraulic jack', 'Electric bulb', 'Transformer', 'Thermometer', 'A'),
(413, 30, 'Buoyant force acts on an immersed object in which direction?', 'Upward', 'Downward', 'Horizontally only', 'Randomly', 'A'),
(414, 30, 'Archimedes\' principle is related to:', 'Buoyant force', 'Electrical resistance', 'Heat conduction', 'Magnetic fields', 'A'),
(415, 30, 'An object floats when the buoyant force is:', 'Equal to its weight', 'Always zero', 'Less than its weight', 'Greater than its mass', 'A'),
(416, 30, 'Viscosity is a measure of a fluid\'s:', 'Resistance to flow', 'Density only', 'Temperature', 'Pressure only', 'A'),
(417, 30, 'Which fluid generally has higher viscosity?', 'Honey', 'Water', 'Air', 'Petrol', 'A'),
(418, 30, 'Fluid flow in which layers move smoothly with little mixing is called:', 'Laminar flow', 'Turbulent flow', 'Random flow', 'Circular flow only', 'A'),
(419, 30, 'Turbulent flow is characterized by:', 'Irregular and chaotic fluid motion', 'Perfectly parallel layers', 'No movement', 'Zero velocity', 'A'),
(420, 30, 'The continuity principle for steady flow of an incompressible fluid is based on conservation of:', 'Mass', 'Temperature', 'Pressure only', 'Energy only', 'A'),
(481, 31, 'What is weather?', 'The condition of the atmosphere at a particular time and place', 'The long-term average of climate only', 'The condition of soil only', 'The amount of water in a plant', 'A'),
(482, 31, 'Which factor is important for plant growth?', 'Temperature', 'Sound', 'Noise', 'Colour of buildings', 'A'),
(483, 31, 'Which instrument is used to measure air temperature?', 'Thermometer', 'Barometer', 'Anemometer', 'Rain gauge', 'A'),
(484, 31, 'Which instrument measures atmospheric pressure?', 'Barometer', 'Thermometer', 'Hygrometer', 'Rain gauge', 'A'),
(485, 31, 'Which instrument is used to measure wind speed?', 'Anemometer', 'Thermometer', 'Barometer', 'Hygrometer', 'A'),
(486, 31, 'Which instrument measures rainfall?', 'Rain gauge', 'Barometer', 'Thermometer', 'Anemometer', 'A'),
(487, 31, 'Humidity refers to the amount of:', 'Water vapour in the air', 'Dust in the air', 'Oxygen in soil', 'Heat in water', 'A'),
(488, 31, 'Which instrument is used to measure humidity?', 'Hygrometer', 'Barometer', 'Anemometer', 'Rain gauge', 'A'),
(489, 31, 'Why is sunlight important for green plants?', 'It provides energy for photosynthesis', 'It increases soil weight', 'It prevents respiration', 'It produces nitrogen directly', 'A'),
(490, 31, 'Photosynthesis mainly requires sunlight, carbon dioxide and:', 'Water', 'Sand', 'Nitrogen gas only', 'Oxygen only', 'A'),
(491, 31, 'Excessive rainfall can cause:', 'Waterlogging and soil erosion', 'Increased soil aeration always', 'Drought', 'Reduced water availability', 'A'),
(492, 31, 'A long period without sufficient rainfall can result in:', 'Drought', 'Flooding', 'Waterlogging', 'Increased humidity only', 'A'),
(493, 31, 'Wind is important in agriculture because it can influence:', 'Pollination and evaporation', 'Soil colour only', 'Seed colour only', 'Rock formation only', 'A'),
(494, 31, 'Very high temperature can cause plants to:', 'Lose water rapidly', 'Stop needing water', 'Produce unlimited food', 'Increase soil moisture automatically', 'A'),
(495, 31, 'Transpiration is the loss of water mainly from plants in the form of:', 'Water vapour', 'Ice', 'Soil particles', 'Oxygen', 'A'),
(496, 31, 'Which weather factor directly affects evaporation?', 'Temperature', 'Soil colour only', 'Rock type only', 'Plant height only', 'A'),
(497, 31, 'Cloud cover can affect:', 'The amount of solar radiation reaching plants', 'Soil texture only', 'Soil colour only', 'Plant roots directly', 'A'),
(498, 31, 'Which condition is generally suitable for most crop growth?', 'Suitable temperature, water, and sunlight', 'Continuous drought', 'Extreme temperature only', 'Continuous flooding', 'A'),
(499, 31, 'Weather information is useful in agriculture for:', 'Planning agricultural activities', 'Changing soil minerals', 'Producing seeds artificially only', 'Measuring plant height only', 'A'),
(500, 31, 'Which combination contains mainly weather elements?', 'Temperature, rainfall, humidity and wind', 'Soil colour, soil texture and soil depth', 'Plant height, root length and leaf size', 'Rock type, mineral type and soil colour', 'A'),
(521, 32, 'What is soil?', 'The upper layer of the Earth\'s surface that supports plant growth', 'Pure water', 'Atmospheric gas', 'A type of metal', 'A'),
(522, 32, 'Which component is normally found in soil?', 'Mineral particles', 'Only water', 'Only air', 'Only organic matter', 'A'),
(523, 32, 'Soil contains:', 'Mineral matter, organic matter, water and air', 'Water only', 'Minerals only', 'Air only', 'A'),
(524, 32, 'Which soil component is formed mainly from decomposed plant and animal materials?', 'Organic matter', 'Sand', 'Gravel', 'Clay', 'A'),
(525, 32, 'Which soil particle is the largest among sand, silt and clay?', 'Sand', 'Silt', 'Clay', 'Humus', 'A'),
(526, 32, 'Which soil particle is the smallest?', 'Clay', 'Sand', 'Gravel', 'Silt', 'A'),
(527, 32, 'Soil texture depends mainly on the proportions of:', 'Sand, silt and clay', 'Water and air only', 'Roots and leaves', 'Rocks only', 'A'),
(528, 32, 'Which soil type generally has good drainage?', 'Sandy soil', 'Clay soil', 'Heavy clay soil', 'Waterlogged soil', 'A'),
(529, 32, 'Which soil type has a high water-holding capacity?', 'Clay soil', 'Sandy soil', 'Gravel', 'Rocky soil', 'A'),
(530, 32, 'Loam soil contains a balanced mixture of:', 'Sand, silt and clay', 'Rocks only', 'Clay only', 'Sand only', 'A'),
(531, 32, 'Soil pH indicates the:', 'Acidity or alkalinity of soil', 'Soil temperature only', 'Soil weight', 'Soil colour', 'A'),
(532, 32, 'A soil with pH below 7 is generally:', 'Acidic', 'Neutral', 'Alkaline', 'Salty only', 'A'),
(533, 32, 'A soil with pH of 7 is considered:', 'Neutral', 'Acidic', 'Strongly alkaline', 'Saline', 'A'),
(534, 32, 'Which nutrient is required by plants in relatively large amounts?', 'Nitrogen', 'Gold', 'Silver', 'Mercury', 'A'),
(535, 32, 'Which nutrient is important for root development and energy transfer in plants?', 'Phosphorus', 'Sodium', 'Mercury', 'Lead', 'A'),
(536, 32, 'Potassium is important for:', 'Plant growth and regulation of physiological processes', 'Making soil completely dry', 'Removing all microorganisms', 'Preventing photosynthesis', 'A'),
(537, 32, 'Soil microorganisms are important because they:', 'Help decompose organic matter and recycle nutrients', 'Always destroy all plants', 'Remove all water from soil', 'Prevent nutrient cycling', 'A'),
(538, 32, 'What is soil erosion?', 'Removal of soil particles by water or wind', 'Addition of nutrients to soil', 'Formation of plant roots', 'Increase of soil organic matter', 'A'),
(539, 32, 'Which practice helps reduce soil erosion?', 'Planting vegetation', 'Removing all plants', 'Overgrazing', 'Leaving soil bare', 'A'),
(540, 32, 'Why is soil important in biological systems?', 'It provides support, water and nutrients for plants', 'It only provides colour', 'It prevents plant growth', 'It contains no living organisms', 'A'),
(541, 33, 'What is surveying?', 'The process of measuring and determining positions of points on or near the Earth\'s surface', 'The study of plants', 'The measurement of temperature', 'The study of weather only', 'A'),
(542, 33, 'What is the main purpose of surveying?', 'To obtain measurements and prepare plans or maps', 'To measure rainfall', 'To identify plant diseases', 'To measure air pressure', 'A'),
(543, 33, 'Which instrument is commonly used for measuring horizontal and vertical angles in surveying?', 'Theodolite', 'Thermometer', 'Barometer', 'Rain gauge', 'A'),
(544, 33, 'Which instrument is commonly used for measuring distances?', 'Measuring tape', 'Barometer', 'Hygrometer', 'Thermometer', 'A'),
(545, 33, 'What is levelling?', 'Determining the relative heights of points', 'Measuring rainfall', 'Measuring wind speed', 'Measuring soil pH', 'A'),
(546, 33, 'Which instrument is traditionally used for levelling?', 'Level instrument', 'Compass only', 'Thermometer', 'Rain gauge', 'A'),
(547, 33, 'What is a benchmark in surveying?', 'A point with a known elevation', 'A measuring tape', 'A type of soil', 'A weather station', 'A'),
(548, 33, 'What does RL mean in levelling?', 'Reduced Level', 'Road Length', 'Reference Line', 'Relative Length', 'A'),
(549, 33, 'What is a levelling staff used for?', 'Reading vertical measurements', 'Measuring temperature', 'Measuring rainfall', 'Measuring wind direction', 'A'),
(550, 33, 'A temporary benchmark is:', 'A fixed point established for temporary surveying work', 'A type of instrument', 'A weather measurement', 'A soil sample', 'A'),
(551, 33, 'What is a contour line?', 'A line joining points of equal elevation', 'A line joining points of equal temperature', 'A line showing rainfall', 'A line showing soil colour', 'A'),
(552, 33, 'Closely spaced contour lines generally indicate:', 'A steep slope', 'A flat surface', 'A river only', 'A horizontal surface only', 'A'),
(553, 33, 'Widely spaced contour lines generally indicate:', 'A gentle slope', 'A very steep slope', 'A vertical wall', 'A deep hole only', 'A'),
(554, 33, 'What is a field book used for?', 'Recording field measurements and observations', 'Recording weather forecasts only', 'Drawing electrical circuits', 'Storing soil samples', 'A'),
(555, 33, 'What is a ranging rod used for?', 'Marking points and aligning survey lines', 'Measuring temperature', 'Measuring pressure', 'Measuring humidity', 'A'),
(556, 33, 'Which instrument can be used to determine direction during surveying?', 'Compass', 'Thermometer', 'Barometer', 'Rain gauge', 'A'),
(557, 33, 'What is a map?', 'A graphical representation of an area', 'A type of measuring instrument', 'A soil sample', 'A weather instrument', 'A'),
(558, 33, 'What is a plan in surveying?', 'A scaled drawing representing features of a relatively small area', 'A weather report', 'A soil classification', 'A type of levelling staff', 'A'),
(559, 33, 'Why is accuracy important in surveying?', 'To obtain reliable measurements and correct plans', 'To increase measurement errors', 'To make maps colourful', 'To reduce the usefulness of the survey', 'A'),
(560, 33, 'Surveying is important in biological and agricultural systems because it can help with:', 'Land measurement, planning and field layout', 'Measuring blood pressure', 'Identifying weather clouds only', 'Measuring animal temperature only', 'A'),
(561, 34, 'What is mechanization?', 'Using machines to perform tasks', 'Using only manual labour', 'Stopping agricultural activities', 'Using animals only', 'A'),
(562, 34, 'What is the main purpose of mechanization in agriculture?', 'To improve efficiency and reduce labour requirements', 'To increase manual work', 'To reduce productivity', 'To increase production time', 'A'),
(563, 34, 'Which machine is commonly used for ploughing?', 'Tractor', 'Sprayer only', 'Harvester only', 'Water pump', 'A'),
(564, 34, 'A tractor is mainly used to:', 'Provide power for agricultural operations', 'Measure rainfall', 'Store seeds', 'Test soil pH', 'A'),
(565, 34, 'Which implement is commonly used for primary tillage?', 'Plough', 'Sprayer', 'Trailer only', 'Harvester', 'A'),
(566, 34, 'What is tillage?', 'Preparation and cultivation of soil', 'Harvesting fruits only', 'Storing crops', 'Processing timber', 'A'),
(567, 34, 'Which machine can be used for sowing seeds?', 'Seed drill', 'Plough', 'Harvester', 'Water tank', 'A'),
(568, 34, 'What is the main function of a seed drill?', 'Place seeds at suitable depth and spacing', 'Harvest mature crops', ' Spray pesticides', 'Pump water', 'A'),
(569, 34, 'Which equipment is commonly used for spraying agricultural chemicals?', 'Sprayer', 'Plough', 'Seeder', 'Thresher', 'A'),
(570, 34, 'What is harvesting?', 'Collecting mature crops from the field', 'Preparing soil', 'Sowing seeds', 'Irrigating crops', 'A'),
(571, 34, 'Which machine is used to separate grains from harvested crops?', 'Thresher', 'Plough', 'Sprayer', 'Seeder', 'A'),
(572, 34, 'Mechanization can help reduce:', 'Time required for agricultural operations', 'Crop productivity', 'Work efficiency', 'Accuracy', 'A'),
(573, 34, 'Which is a disadvantage of excessive mechanization?', 'High initial investment', 'Improved efficiency', 'Reduced operation time', 'Better timeliness', 'A'),
(574, 34, 'Proper machine maintenance helps to:', 'Increase machine life and reduce breakdowns', 'Increase fuel wastage', 'Reduce machine efficiency', 'Cause more accidents', 'A'),
(575, 34, 'Which factor should be considered when selecting agricultural machinery?', 'Type and size of the farm', 'Colour of the machine only', 'Operator\'s favourite colour', 'Weather forecast only', 'A'),
(576, 34, 'What is irrigation mechanization mainly concerned with?', 'Using equipment to supply water to crops', 'Harvesting timber', 'Processing seeds', 'Measuring land', 'A'),
(577, 34, 'Which machine is commonly used to pump water?', 'Water pump', 'Thresher', 'Plough', 'Seeder', 'A'),
(578, 34, 'Mechanization can improve agricultural operations by providing:', 'Greater speed and precision', 'More manual labour', 'Less productivity', 'More delays', 'A'),
(579, 34, 'The Power Take-Off (PTO) of a tractor is used to:', 'Transfer mechanical power to attached implements', 'Store fuel', 'Measure soil moisture', 'Control rainfall', 'A'),
(580, 34, 'Safe operation of agricultural machinery requires:', 'Following safety procedures and using appropriate protective equipment', 'Ignoring the operator\'s manual', 'Removing safety guards', 'Operating machines carelessly', 'A'),
(581, 35, 'What is timber?', 'Wood suitable for construction and other uses', 'A type of soil', 'A metal product', 'A chemical fertilizer', 'A'),
(582, 35, 'What does sustainable forestry mean?', 'Managing forests to meet present needs while maintaining them for the future', 'Cutting all trees in a forest', 'Preventing all forest use', 'Removing forest plants permanently', 'A'),
(583, 35, 'Which is a timber product?', 'Furniture', 'Honey', 'Rubber latex', 'Mushroom', 'A'),
(584, 35, 'Which is a non-timber forest product?', 'Honey', 'Wooden table', 'Timber beam', 'Plywood', 'A'),
(585, 35, 'Non-timber forest products are obtained from forests without primarily using:', 'Timber from trees', 'Leaves', 'Fruits', 'Natural materials', 'A'),
(586, 35, 'Which is an example of a non-timber forest product?', 'Medicinal plants', 'Wooden door', 'Timber board', 'Wooden chair', 'A'),
(587, 35, 'Bamboo can be used to produce:', 'Furniture and handicrafts', 'Petrol', 'Cement', 'Steel', 'A'),
(588, 35, 'Which product can be obtained from rubber trees without cutting down the tree?', 'Latex', 'Timber only', 'Charcoal', 'Plywood', 'A'),
(589, 35, 'What is the main purpose of reforestation?', 'To restore forests by planting trees', 'To remove forests', 'To increase soil erosion', 'To reduce biodiversity', 'A'),
(590, 35, 'What is deforestation?', 'Removal of forests or trees from an area', 'Planting trees', 'Forest conservation', 'Natural regeneration', 'A'),
(591, 35, 'Sustainable timber production aims to:', 'Balance timber production with forest conservation', 'Remove all trees quickly', 'Stop all forest management', 'Increase forest destruction', 'A'),
(592, 35, 'Which practice helps maintain forest resources?', 'Replanting harvested areas', 'Uncontrolled cutting', 'Burning forests', 'Removing young trees', 'A'),
(593, 35, 'What is forest biodiversity?', 'Variety of living organisms in a forest', 'Number of timber products only', 'Amount of rainfall only', 'Number of buildings in a forest', 'A'),
(594, 35, 'Which product is commonly obtained from coconut palms as a non-timber-based product?', 'Coir', 'Steel', 'Cement', 'Glass', 'A'),
(595, 35, 'Which is a benefit of using non-timber forest products sustainably?', 'Provides income while supporting forest conservation', 'Always destroys forests', 'Eliminates biodiversity', 'Increases deforestation', 'A'),
(596, 35, 'Wood can be preserved by:', 'Applying suitable wood preservatives', 'Keeping it continuously wet', 'Exposing it to pests', 'Storing it in unsuitable conditions', 'A'),
(597, 35, 'Which organism can damage timber?', 'Termites', 'Earthworms only', 'Fish', 'Birds only', 'A'),
(598, 35, 'Proper seasoning of timber helps to:', 'Reduce moisture content and improve stability', 'Increase water content', 'Increase fungal growth', 'Make timber softer', 'A'),
(599, 35, 'Which approach supports sustainable forest management?', 'Controlled harvesting', 'Uncontrolled logging', 'Forest burning', 'Illegal cutting', 'A'),
(600, 35, 'Why are sustainable timber and non-timber products important?', 'They can provide economic benefits while conserving natural resources', 'They always destroy forests', 'They cannot provide useful products', 'They reduce all biodiversity', 'A'),
(601, 36, 'What is a plantation crop?', 'A crop cultivated on a relatively large scale for commercial purposes', 'A crop grown only in home gardens', 'A wild plant that is never cultivated', 'A forest tree only', 'A'),
(602, 36, 'Which is a major plantation crop in Sri Lanka?', 'Tea', 'Carrot', 'Cabbage', 'Onion', 'A'),
(603, 36, 'Which of the following is a plantation crop?', 'Rubber', 'Tomato', 'Brinjal', 'Pumpkin', 'A'),
(604, 36, 'Coconut is important because it can provide:', 'Many different products', 'Only timber', 'Only drinking water', 'Only animal feed', 'A'),
(605, 36, 'Which product is made from coconut fibre?', 'Coir products', 'Steel', 'Cement', 'Glass', 'A'),
(606, 36, 'Which product is obtained from rubber latex?', 'Rubber gloves', 'Tea leaves', 'Coconut oil', 'Cinnamon bark', 'A'),
(607, 36, 'Tea is mainly processed to produce:', 'Tea products for consumption', 'Rubber products', 'Timber products', 'Cement products', 'A'),
(608, 36, 'Which is considered a minor export crop?', 'Cinnamon', 'Paddy', 'Maize', 'Potato', 'A'),
(609, 36, 'Which part of the cinnamon plant is mainly used as a spice?', 'Bark', 'Root only', 'Flower only', 'Seed only', 'A'),
(610, 36, 'Which product can be made from cinnamon?', 'Cinnamon oil', 'Rubber tyre', 'Plywood', 'Paper pulp only', 'A'),
(611, 36, 'Which is another important minor export crop in Sri Lanka?', 'Pepper', 'Paddy', 'Potato', 'Cabbage', 'A'),
(612, 36, 'Black pepper is mainly used as:', 'A spice', 'A building material', 'A textile fibre', 'A fuel', 'A'),
(613, 36, 'Which product can be obtained from cloves?', 'Clove oil', 'Rubber latex', 'Coconut milk', 'Timber', 'A'),
(614, 36, 'Cardamom is mainly used as:', 'A spice', 'A construction material', 'A plastic', 'A fuel', 'A'),
(615, 36, 'What is value addition?', 'Increasing the value of a raw agricultural product through processing or improvement', 'Reducing the quality of a product', 'Destroying agricultural products', 'Selling only raw materials', 'A'),
(616, 36, 'Which is an example of value addition to coconut?', 'Producing coconut oil', 'Throwing away the coconut', 'Leaving coconuts unprocessed', 'Burning all coconut products', 'A'),
(617, 36, 'Processing plantation crops can help to:', 'Increase product value and market opportunities', 'Reduce product quality always', 'Eliminate employment', 'Prevent exports', 'A'),
(618, 36, 'What is the main purpose of packaging agricultural products?', 'To protect the product and improve handling and marketing', 'To damage the product', 'To increase contamination', 'To reduce shelf life', 'A'),
(619, 36, 'Which factor is important for producing quality export products?', 'Proper processing and quality control', 'Poor storage', 'Contamination', 'Improper packaging', 'A'),
(620, 36, 'Plantation and minor export crops are important to the economy because they can:', 'Generate income and support employment and exports', 'Reduce all agricultural production', 'Eliminate rural employment', 'Prevent international trade', 'A'),
(621, 37, 'Example question ?', 'Answer 1', 'Answer 2', 'Answer 3', 'Answer 3', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `result_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `total_marks` int(11) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `short_notes`
--

CREATE TABLE `short_notes` (
  `note_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `short_notes`
--

INSERT INTO `short_notes` (`note_id`, `unit_id`, `title`, `file_path`, `created_at`) VALUES
(1, 4, 'ICT Grade 12 - Concept of ICT', 'uploads/notes/grade-12/ict/ict-grade12-unit01.pdf', '2026-09-17 05:48:12'),
(2, 5, 'ICT Grade 12 - Introduction to Computer', 'uploads/notes/grade-12/ict/ict-grade12-unit02.pdf', '2026-09-17 05:48:12'),
(3, 6, 'ICT Grade 12 - Number System', 'uploads/notes/grade-12/ict/ict-grade12-unit03.pdf', '2026-09-17 05:48:12'),
(4, 7, 'Agriculture Grade 12 - Development of Agriculture in Sri Lanka', 'uploads/notes/grade-12/agri/agri-grade12-unit01.pdf', '2026-09-17 06:14:14'),
(5, 8, 'Agriculture Grade 12 - Climatic Factors and Crop Production', 'uploads/notes/grade-12/agri/agri-grade12-unit02.pdf', '2026-09-17 06:14:14'),
(6, 9, 'Agriculture Grade 12 - Soil Environment and Crop Cultivation', 'uploads/notes/grade-12/agri/agri-grade12-unit03.pdf', '2026-09-17 06:14:14'),
(7, 10, 'Agriculture Grade 13 - Pest Management', 'uploads/notes/grade-13/agri/agri-grade13-unit01.pdf', '2026-09-17 06:14:14'),
(8, 11, 'Agriculture Grade 13 - Food Technology', 'uploads/notes/grade-13/agri/agri-grade13-unit02.pdf', '2026-09-17 06:14:14'),
(9, 12, 'Agriculture Grade 13 - Post-Harvest Technology', 'uploads/notes/grade-13/agri/agri-grade13-unit03.pdf', '2026-09-17 06:14:14'),
(10, 13, 'ICT Grade 13 - System Analysis and Design', 'uploads/notes/grade-13/ict/ict-grade13-unit01.pdf', '2026-09-17 06:27:50'),
(11, 14, 'ICT Grade 13 - Database Management', 'uploads/notes/grade-13/ict/ict-grade13-unit02.pdf', '2026-09-17 06:27:50'),
(12, 15, 'ICT Grade 13 - Programming', 'uploads/notes/grade-13/ict/ict-grade13-unit03.pdf', '2026-09-17 06:27:50'),
(13, 16, 'Engineering Technology Grade 12 - Introduction to Engineering Technology', 'uploads/notes/grade-12/et/et-grade12-unit01.pdf', '2026-09-17 06:49:59'),
(14, 17, 'Engineering Technology Grade 12 - Engineering Drawing', 'uploads/notes/grade-12/et/et-grade12-unit02.pdf', '2026-09-17 06:49:59'),
(15, 18, 'Engineering Technology Grade 12 - Health and Safety for Technology', 'uploads/notes/grade-12/et/et-grade12-unit03.pdf', '2026-09-17 06:49:59'),
(16, 19, 'Engineering Technology Grade 13 - Engineering Standards and Specifications', 'uploads/notes/grade-13/et/et-grade13-unit01.pdf', '2026-09-17 06:49:59'),
(17, 20, 'Engineering Technology Grade 13 - Generation, Transmission, Distribution and Utilization of Electrical Power', 'uploads/notes/grade-13/et/et-grade13-unit02.pdf', '2026-09-17 06:49:59'),
(18, 21, 'Engineering Technology Grade 13 - Electronic Technology', 'uploads/notes/grade-13/et/et-grade13-unit03.pdf', '2026-09-17 06:49:59'),
(19, 28, 'Area and Volume', 'uploads/notes/grade-12/sft/sft-grade12-unit01.pdf', '2026-09-17 08:03:43'),
(20, 29, 'Measuring Units and Measuring Instruments', 'uploads/notes/grade-12/sft/sft-grade12-unit02.pdf', '2026-09-17 08:03:43'),
(21, 30, 'Pythagoras Relationship', 'uploads/notes/grade-12/sft/sft-grade12-unit03.pdf', '2026-09-17 08:03:43'),
(22, 31, 'Polymers', 'uploads/notes/grade-13/sft/sft-grade13-unit01.pdf', '2026-09-17 08:03:43'),
(23, 32, 'Mechanical Properties of Matter', 'uploads/notes/grade-13/sft/sft-grade13-unit02.pdf', '2026-09-17 08:03:43'),
(24, 33, 'Fluid Mechanics', 'uploads/notes/grade-13/sft/sft-grade13-unit03.pdf', '2026-09-17 08:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `student_progress`
--

CREATE TABLE `student_progress` (
  `progress_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `completed` tinyint(1) DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_progress`
--

INSERT INTO `student_progress` (`progress_id`, `user_id`, `lesson_id`, `completed`, `completed_at`) VALUES
(2, 3, 26, 1, '2026-11-16 10:28:19'),
(3, 7, 27, 1, '2026-11-13 09:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `student_subjects`
--

CREATE TABLE `student_subjects` (
  `student_subject_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_subjects`
--

INSERT INTO `student_subjects` (`student_subject_id`, `user_id`, `subject_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 4),
(4, 2, 1),
(5, 2, 2),
(6, 2, 4),
(7, 3, 1),
(8, 3, 3),
(9, 3, 5),
(10, 4, 1),
(11, 4, 3),
(12, 4, 5),
(13, 5, 1),
(14, 5, 2),
(15, 5, 4),
(16, 6, 1),
(17, 6, 2),
(18, 6, 4),
(19, 7, 1),
(20, 7, 3),
(21, 7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `student_unit_progress`
--

CREATE TABLE `student_unit_progress` (
  `progress_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(10) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `basket` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_name`, `basket`) VALUES
(1, 'SFT', 'Science for Technology', 'Core'),
(2, 'ET', 'Engineering Technology', 'Basket 02'),
(3, 'BST', 'Bio Systems Technology', 'Basket 02'),
(4, 'ICT', 'Information & Communication Technology', 'Basket 03'),
(5, 'AGRI', 'Agricultural Science', 'Basket 03');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unit_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade` enum('12','13') NOT NULL,
  `unit_number` int(11) NOT NULL,
  `unit_title` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `subject_id`, `grade`, `unit_number`, `unit_title`) VALUES
(4, 4, '12', 1, 'Concept of ICT'),
(5, 4, '12', 2, 'Introduction to Computer'),
(6, 4, '12', 3, 'Number System'),
(7, 5, '12', 1, 'Development of Agriculture in Sri Lanka'),
(8, 5, '12', 2, 'Climatic Factors and Crop Production'),
(9, 5, '12', 3, 'Soil Environment and Crop Cultivation'),
(10, 5, '13', 1, 'Pest Management'),
(11, 5, '13', 2, 'Food Technology'),
(12, 5, '13', 3, 'Post-Harvest Technology'),
(13, 4, '13', 1, 'System Analysis and Design'),
(14, 4, '13', 2, 'Database Management'),
(15, 4, '13', 3, 'Programming'),
(16, 2, '12', 1, 'Introduction to Engineering Technology'),
(17, 2, '12', 2, 'Engineering Drawing'),
(18, 2, '12', 3, 'Health and Safety for Technology'),
(19, 2, '13', 1, 'Engineering Standards and Specifications'),
(20, 2, '13', 2, 'Generation, Transmission, Distribution and Utilization of Electrical Power'),
(21, 2, '13', 3, 'Electronic Technology'),
(22, 3, '12', 1, 'Weather Conditions Suitable for Biological Systems'),
(23, 3, '12', 2, 'Soil in Biological Systems'),
(24, 3, '12', 3, 'Surveying and Levelling'),
(25, 3, '13', 1, 'Mechanization'),
(26, 3, '13', 2, 'Sustainable Timber and Non-Timber Based Products'),
(27, 3, '13', 3, 'Plantation and Minor Export Crops Based Products'),
(28, 1, '12', 1, 'Area and Volume'),
(29, 1, '12', 2, 'Measuring Units and Measuring Instruments'),
(30, 1, '12', 3, 'Pythagoras Relationship'),
(31, 1, '13', 1, 'Polymers'),
(32, 1, '13', 2, 'Mechanical Properties of Matter'),
(33, 1, '13', 3, 'Fluid Mechanics');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `username`, `password`, `role`, `created_at`, `remember_token`) VALUES
(1, 'Dinundu Rashmika', 'dinurash74@gmail.com', 'dinundu', '$2y$10$kIPW6GRy/xXpOLaSuqlXaeRXPML3APNNvfOQiToUx5UZAVZZ5g/c2', 'student', '2026-09-16 19:19:34', 'f985f1211b21b54ab0f17156bedd75f8603f0a2933ea88d45311f62c257dbb82'),
(2, 'yovindu maneth', 'yovindu@gmail.com', 'yoviya', '$2y$10$uSRpsXWK7jpwRlFKJU2GG.pCAaB2egOu4CzTTNfAyRGb6q3lMjKIO', 'admin', '2026-09-17 02:59:23', 'f7d962ec5c93db3718718b31ecf4106723a392e46138d7c91785fd7c02662781'),
(3, 'user full name', 'user@gmail.com', 'user@test', '$2y$10$5nOeFgIZK0aFfbb.Ckx7M.U0Ry7zvWVkuck5y1xovjCsnjKxQANHG', 'student', '2026-09-19 09:30:39', NULL),
(4, 'yovibst', 'yovibst@gmail.com', 'yovibst', '$2y$10$JUrHw5flmRxENo8wRlUIkeMLQqRC8vILV62Er06lwpcwyeAi.rRta', 'student', '2026-10-02 01:27:20', '8f5162dd22e66cd5a904615fff87950f80341047d570c9e95d9b21890b0a7f63'),
(5, 'yoviya', 'yoviet@gmail.com', 'yoviet', '$2y$10$QXRg/hYfVwWy5JOsmwNnRuycHjTY8x/xgOq9xU3tirxPyeNcZYt3u', 'student', '2026-10-06 06:56:24', 'd71981b0c850b592e257d51172d3617afad80c40624112487a6e1867536bf801'),
(6, 'yovi et bro', 'yoviet123@gmail.com', 'yoviet12', '$2y$10$62LzRcjYonXOJskQFmXMFeCTcYCIVgP6E.ohtw1yN.vDuUI3kOY7.', 'student', '2026-10-15 02:31:48', '5b44ed69e3ee5e0a4c657548ca633cf35528ad3e00ea428b40c19e5d52421704'),
(7, 'Chathumi Ekanayaka', 'chathuekanayaka1230@gmail.com', 'chathu2004', '$2y$10$IMQPaddAV7bygb9ATsqtPuA08FO9LiiL0AtqbbzooRvdkYcDBx7Xi', 'student', '2026-11-13 09:08:03', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `lesson_parts`
--
ALTER TABLE `lesson_parts`
  ADD PRIMARY KEY (`part_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `past_papers`
--
ALTER TABLE `past_papers`
  ADD PRIMARY KEY (`paper_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_attempt_answers`
--
ALTER TABLE `quiz_attempt_answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `attempt_id` (`attempt_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `short_notes`
--
ALTER TABLE `short_notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `student_progress`
--
ALTER TABLE `student_progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD UNIQUE KEY `user_lesson_unique` (`user_id`,`lesson_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD PRIMARY KEY (`student_subject_id`),
  ADD UNIQUE KEY `user_subject_unique` (`user_id`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `student_unit_progress`
--
ALTER TABLE `student_unit_progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD UNIQUE KEY `unique_student_unit` (`user_id`,`unit_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `subject_code` (`subject_code`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unit_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `lesson_parts`
--
ALTER TABLE `lesson_parts`
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `past_papers`
--
ALTER TABLE `past_papers`
  MODIFY `paper_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `quiz_attempt_answers`
--
ALTER TABLE `quiz_attempt_answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=622;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `short_notes`
--
ALTER TABLE `short_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `student_progress`
--
ALTER TABLE `student_progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_subjects`
--
ALTER TABLE `student_subjects`
  MODIFY `student_subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `student_unit_progress`
--
ALTER TABLE `student_unit_progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_parts`
--
ALTER TABLE `lesson_parts`
  ADD CONSTRAINT `lesson_parts_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `past_papers`
--
ALTER TABLE `past_papers`
  ADD CONSTRAINT `past_papers_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `quiz_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_attempts_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_attempt_answers`
--
ALTER TABLE `quiz_attempt_answers`
  ADD CONSTRAINT `quiz_attempt_answers_ibfk_1` FOREIGN KEY (`attempt_id`) REFERENCES `quiz_attempts` (`attempt_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_attempt_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `fk_quiz_questions_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_results_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `short_notes`
--
ALTER TABLE `short_notes`
  ADD CONSTRAINT `short_notes_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_progress`
--
ALTER TABLE `student_progress`
  ADD CONSTRAINT `student_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_progress_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD CONSTRAINT `student_subjects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_unit_progress`
--
ALTER TABLE `student_unit_progress`
  ADD CONSTRAINT `student_unit_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_unit_progress_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`) ON DELETE CASCADE;

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
