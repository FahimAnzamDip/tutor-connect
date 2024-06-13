-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 13, 2024 at 09:19 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tutor_connect`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint NOT NULL,
  `teacher_id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `rating` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `teacher_id`, `user_id`, `rating`) VALUES
(3, 2, 2, 5),
(4, 2, 6, 4),
(5, 1, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `icon`) VALUES
(1, 'Booking and Scheduling', 'students to book tutoring sessions with available tutors and manage their schedules easily. This service includes reminders and calendar.', 'bi bi-kanban'),
(2, 'Earning Potential', 'Facilitates secure online payment for tutoring sessions. Users can pay per session or purchase packages, with multiple payment methods supported for convenience.', 'bi bi-kanban'),
(3, 'Tutor Search and Profiles', 'Allows users to search for tutors by subject, location, and availability. Each tutor has a profile with their qualifications, experience, and reviews from other students.', 'bi bi-kanban');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `site_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `about_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `about_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `about_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hero_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hero_subtitle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `hero_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `about_title`, `about_content`, `about_image`, `contact_mobile`, `contact_email`, `contact_address`, `hero_title`, `hero_subtitle`, `hero_image`) VALUES
(1, 'Tutor Connect', 'Who We Are', 'At Tutor Connect, we believe in the power of personalized education. Our platform bridges the gap between students and experienced tutors across a variety of subjects. We provide a platform for students to find the perfect tutor for their needs. Our tutors are experienced in their respective fields and are dedicated to helping students succeed.\r\n<br><br>\r\nOur platform is easy to use and allows students to connect with tutors in a matter of minutes. We offer a wide range of subjects and topics, so you can find the perfect tutor for your needs. Whether you need help with math, science, history, or any other subject, we have you covered.\r\n<br><br>\r\nOur tutors are passionate about helping students succeed and are dedicated to providing personalized instruction. We believe that every student is unique and deserves a personalized approach to learning. Our tutors work with students one-on-one to help them achieve their academic goals.', 'about_us_image.svg', '+1 234 567 890', 'tutorconnect@mail.com', '123, Main Street, New York, NY 10001', 'Find the best tutor for you', 'At Tutor Connect, we believe in the power of personalized education. Our platform bridges the gap between students and experienced tutors across a variety of subjects.', 'hero_image.svg');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint NOT NULL,
  `subject_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`) VALUES
(1, 'Mathematics'),
(2, 'English'),
(3, 'Bangla'),
(4, 'Physics'),
(5, 'Chemistry'),
(6, 'Biology'),
(8, 'Social Science');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `class` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `address`, `image`, `short_description`, `description`, `class`, `featured`, `approved`) VALUES
(1, 3, 'New York, United States of America', 'person_placeholder.png', 'Professional teacher with over 10 years of eperience.', 'Beyond English, [Teacher&#039;s Name] is a champion of Bangla language and culture. He guides students on a journey of discovery, helping them understand the rich tapestry of Bangla literature and communication. His lessons not only enhance their linguistic skills but also foster a deeper appreciation for their heritage.\r\n&lt;br&gt;&lt;br&gt;\r\nSocial Science takes on a whole new dimension with [Teacher&#039;s Name] at the helm. He transforms seemingly dry topics into engaging narratives, connecting history, government, and social dynamics to the real world. Students find themselves transported to different eras, analyzing historical events, and critically evaluating current issues.\r\n&lt;br&gt;&lt;br&gt;\r\n[Teacher&#039;s Name] is more than just a dispenser of knowledge. He is a passionate guide who ignites a love of learning in his students. His enthusiasm for his subjects is contagious, and his dedication to their success is evident in his teaching style. He fosters a collaborative learning environment where students feel comfortable asking questions and exploring their interests.', 'Class 10-12', 1, 1),
(2, 4, 'Tangail Sadar, Tangail, Bangladesh', '', 'Professional teacher with over 2 years of eperience.', 'Teachers play an essential role in shaping the minds and futures of their students. They are not only educators but also mentors and guides who help students navigate through their academic journeys and personal growth. A teacher&#039;s influence extends far beyond the classroom, as they inspire curiosity, foster a love for learning, and encourage students to strive for excellence in all areas of life. Their dedication and passion for teaching create a positive and supportive learning environment where students can thrive and reach their full potential.\r\n&lt;br&gt;&lt;br&gt;\r\nIn addition to imparting knowledge, teachers are responsible for nurturing critical thinking, creativity, and problem-solving skills in their students. They use a variety of teaching methods and strategies to accommodate different learning styles and needs, ensuring that each student receives a comprehensive and inclusive education. Teachers also collaborate with parents, administrators, and other educators to develop effective curricula and programs that enhance student learning and development. Their commitment to continuous professional development ensures they stay updated with the latest educational trends and best practices.\r\n&lt;br&gt;&lt;br&gt;\r\nTeachers also serve as role models, demonstrating the importance of integrity, hard work, and perseverance. They help students develop strong character and social skills, preparing them to become responsible and contributing members of society. Through their encouragement and support, teachers empower students to overcome challenges and believe in their abilities. The lasting impact of a teacher&#039;s guidance and mentorship can be seen in the success and achievements of their students, making teaching one of the most rewarding and impactful professions.', 'Class 1-5', 1, 1),
(3, 5, 'Gazipur, Dhaka, Bangladesh', '', 'Professional teacher with over 6 years of eperience.', 'Teachers play an essential role in shaping the minds and futures of their students. They are not only educators but also mentors and guides who help students navigate through their academic journeys and personal growth. A teacher&#039;s influence extends far beyond the classroom, as they inspire curiosity, foster a love for learning, and encourage students to strive for excellence in all areas of life. Their dedication and passion for teaching create a positive and supportive learning environment where students can thrive and reach their full potential.\r\n&lt;br&gt;&lt;br&gt;\r\nIn addition to imparting knowledge, teachers are responsible for nurturing critical thinking, creativity, and problem-solving skills in their students. They use a variety of teaching methods and strategies to accommodate different learning styles and needs, ensuring that each student receives a comprehensive and inclusive education. Teachers also collaborate with parents, administrators, and other educators to develop effective curricula and programs that enhance student learning and development. Their commitment to continuous professional development ensures they stay updated with the latest educational trends and best practices.\r\n&lt;br&gt;&lt;br&gt;\r\nTeachers also serve as role models, demonstrating the importance of integrity, hard work, and perseverance. They help students develop strong character and social skills, preparing them to become responsible and contributing members of society. Through their encouragement and support, teachers empower students to overcome challenges and believe in their abilities. The lasting impact of a teacher&#039;s guidance and mentorship can be seen in the success and achievements of their students, making teaching one of the most rewarding and impactful professions.', 'Class 5-10', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_student_messages`
--

CREATE TABLE `teacher_student_messages` (
  `id` bigint NOT NULL,
  `date` date DEFAULT NULL,
  `student_id` bigint NOT NULL,
  `teacher_id` bigint NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `sent_by` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_student_messages`
--

INSERT INTO `teacher_student_messages` (`id`, `date`, `student_id`, `teacher_id`, `message`, `sent_by`) VALUES
(1, '2024-06-14', 2, 3, 'Hello do you time for a schedule?', 'Student'),
(3, '2024-06-14', 2, 3, 'I want to learn English from you. Lets discuss more in email.', 'Student'),
(5, '2024-06-13', 2, 3, 'Let&#039;s meet at Hatir Jheel at 4 PM.', 'Teacher'),
(6, '2024-06-13', 2, 3, 'Okay Sure. See you soon!', 'Student'),
(9, '2024-06-13', 6, 4, 'Hello, Are you available?', 'Student'),
(10, '2024-06-13', 6, 3, 'Hey, Are you available for a talk?', 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_subjects`
--

CREATE TABLE `teacher_subjects` (
  `id` bigint NOT NULL,
  `subject_id` bigint DEFAULT NULL,
  `teacher_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_subjects`
--

INSERT INTO `teacher_subjects` (`id`, `subject_id`, `teacher_id`) VALUES
(25, 2, 1),
(26, 3, 1),
(27, 8, 1),
(30, 1, 3),
(31, 2, 3),
(36, 1, 2),
(37, 2, 2),
(38, 3, 2),
(39, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `mobile`, `password`, `role`, `avatar`) VALUES
(1, 'Fahim Anzam Dip', 'Administrator', 'super.admin@mail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'Admin', NULL),
(2, 'Fahim Anzam Dip', 'fahimanzam', 'fahimanzam9@gmail.com', '', 'bc4414675990e44d90528d006efaa24d', 'Student', NULL),
(3, 'Jack Sparrow', 'jack123', 'jack99@gmail.com', '1283519312', 'e0c406e9f0957a1d2886252208c301d8', 'Teacher', 'person_placeholder.png'),
(4, 'Karim Janat', 'karim123', 'karim99@gmail.com', '499123632', '63c83d902e80c7708d607b3adfbfea56', 'Teacher', ''),
(5, 'Hasan Mahmud', 'hasan123', 'hasan@gmail.com', '0324129128', '514537a05a1ffb7de4faaef299b6e52a', 'Teacher', ''),
(6, 'Saad Rahaman', 'saad123', 'saad@triangeltech.com', '467234123', 'b57190434e37308d6fbe7c2341c743ec', 'Student', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teachers_review` (`teacher_id`),
  ADD KEY `users_review` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_teachers` (`user_id`);

--
-- Indexes for table `teacher_student_messages`
--
ALTER TABLE `teacher_student_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_message` (`student_id`),
  ADD KEY `teacher_message` (`teacher_id`);

--
-- Indexes for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teacher_student_messages`
--
ALTER TABLE `teacher_student_messages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `teachers_review` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_review` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `users_teachers` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_student_messages`
--
ALTER TABLE `teacher_student_messages`
  ADD CONSTRAINT `student_message` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_message` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD CONSTRAINT `subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
