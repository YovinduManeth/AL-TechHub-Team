-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2026 at 11:34 AM
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
-- Database: `al_techhub_team`
--

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
(1, 28, '01', 'Area and Volume', 'Learn the fundamental concepts and calculations related to area and volume.', 'uploads/videos/sft-unit-01-area-volume.mp4', 'uploads/videos/sft-unit-01-area-volume-1080p.mp4', 'uploads/videos/sft-unit-01-area-volume-720p.mp4', 'uploads/videos/sft-unit-01-area-volume-480p.mp4', 'uploads/videos/sft-unit-01-area-volume.mp4', 'uploads/audios/sft-unit-01-area-volume.mp3', 153, '2026-09-17 09:42:52');

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
(1, 28, 'SFT Unit 01 - Area and Volume Quiz', 15, '2026-09-17 08:10:28');

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
(4, 2, 1, 100, 100, 100.00, 10, '2026-09-17 13:23:25');

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
(40, 4, 10, 'A', 'A');

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
(10, 1, 'According to the given principles, how does the volume of material in a hollow object compare with its total external volume?', 'It is strictly less than the total external volume.', 'It is always equal to the total external volume.', 'It is always greater than the total external volume.', 'It has no relationship with the total external volume.', 'A');

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
(1, 2, 1, 1, '2026-09-17 16:27:38');

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
(6, 2, 4);

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
(2, 'yovindu maneth', 'yovindu@gmail.com', 'yoviya', '$2y$10$Ti3URMI122hqKMAwjZJuaemY5DTcM6la1bP6eK3ZlXJbG0iyheksG', 'student', '2026-09-17 02:59:23', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`),
  ADD KEY `unit_id` (`unit_id`);

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
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quiz_attempt_answers`
--
ALTER TABLE `quiz_attempt_answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_subjects`
--
ALTER TABLE `student_subjects`
  MODIFY `student_subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`) ON DELETE CASCADE;

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
