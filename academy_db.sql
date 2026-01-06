

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `branch` varchar(50) NOT NULL,
  `grade` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `day_time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `classes` (`id`, `branch`, `grade`, `subject`, `day_time`) VALUES
(1, 'Horana', 'Grade 1', 'Primary 1 Class', 'Wednesday 3.30-5pm'),
(2, 'Horana', 'Grade 2', 'Primary 1 Class', 'Wednesday 3.30-5pm'),
(3, 'Horana', 'Nursery', 'Primary 1 Class', 'Wednesday 3.30-5pm'),
(4, 'Horana', 'Grade 3', 'Primary 2 Class', 'Wednesday 3.30-5pm'),
(5, 'Horana', 'Grade 4', 'Primary 2 Class', 'Wednesday 3.30-5pm'),
(6, 'Horana', 'Grade 5', 'Primary 2 Class', 'Wednesday 3.30-5pm'),
(7, 'Horana', 'Grade 6', 'Grade 6-11 Class', 'Wednesday 3.30-5.30pm'),
(8, 'Horana', 'Grade 7', 'Grade 6-11 Class', 'Wednesday 3.30-5.30pm'),
(9, 'Horana', 'Grade 8', 'Grade 6-11 Class', 'Wednesday 3.30-5.30pm'),
(10, 'Horana', 'Grade 9', 'Grade 6-11 Class', 'Wednesday 3.30-5.30pm'),
(11, 'Horana', 'Grade 10', 'Grade 6-11 Class', 'Wednesday 3.30-5.30pm'),
(12, 'Horana', 'Grade 11', 'Grade 6-11 Class', 'Wednesday 3.30-5.30pm'),
(13, 'Gampaha', 'Grade 1', 'Primary 1 Classes', 'Thursday 3.30-5pm'),
(14, 'Gampaha', 'Grade 2', 'Primary 1 Classes', 'Thursday 3.30-5pm'),
(15, 'Gampaha', 'Nursery', 'Primary 1 Classes', 'Thursday 3.30-5pm'),
(16, 'Gampaha', 'Grade 3', 'Primary 2 classes', 'Thursday 3.30-5pm'),
(17, 'Gampaha', 'Grade 4', 'Primary 2 classes', 'Thursday 3.30-5pm'),
(18, 'Gampaha', 'Grade 5', 'Primary 2 classes', 'Thursday 3.30-5pm'),
(19, 'Gampaha', 'Grade 6', 'Grade 6,7 classes', 'Thursday 3.30-5.30pm'),
(20, 'Gampaha', 'Grade 7', 'Grade 6,7 classes', 'Thursday 3.30-5.30pm'),
(21, 'Gampaha', 'Grade 8', 'Grade 8-13 Advanced Level', 'Thursday 3.30-5.30pm'),
(22, 'Gampaha', 'Grade 9', 'Grade 8-13 Advanced Level', 'Thursday 3.30-5.30pm'),
(23, 'Gampaha', 'Grade 10', 'Grade 8-13 Advanced Level', 'Thursday 3.30-5.30pm'),
(24, 'Gampaha', 'Grade 11', 'Grade 8-13 Advanced Level', 'Thursday 3.30-5.30pm'),
(25, 'Gampaha', 'Grade 12', 'Grade 8-13 Advanced Level', 'Thursday 3.30-5.30pm'),
(26, 'Gampaha', 'Grade 13', 'Grade 8-13 Advanced Level', 'Thursday 3.30-5.30pm'),
(27, 'Gampaha', 'A/L', 'Grade 8-13 Advanced Level', 'Thursday 3.30-5.30pm'),
(28, 'Kaduwela', 'Grade 1', 'Primary 1 Classes', 'Tue/Wed/Fri 4.30-6.00pm OR Sat/Sun 2.30-4.00pm (Select One)'),
(29, 'Kaduwela', 'Grade 2', 'Primary 1 Classes', 'Tue/Wed/Fri 4.30-6.00pm OR Sat/Sun 2.30-4.00pm (Select One)'),
(30, 'Kaduwela', 'Nursery', 'Primary 1 Classes', 'Tue/Wed/Fri 4.30-6.00pm OR Sat/Sun 2.30-4.00pm (Select One)'),
(31, 'Kaduwela', 'Grade 3', 'Primary 2 Classes', 'Tue/Wed/Fri 4.30-6.00pm OR Sat/Sun 2.30-4.00pm (Select One)'),
(32, 'Kaduwela', 'Grade 4', 'Primary 2 Classes', 'Tue/Wed/Fri 4.30-6.00pm OR Sat/Sun 2.30-4.00pm (Select One)'),
(33, 'Kaduwela', 'Grade 5', 'Primary 2 Classes', 'Tue/Wed/Fri 4.30-6.00pm OR Sat/Sun 2.30-4.00pm (Select One)'),
(34, 'Kaduwela', 'Grade 1', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(35, 'Kaduwela', 'Grade 2', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(36, 'Kaduwela', 'Grade 3', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(37, 'Kaduwela', 'Grade 4', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(38, 'Kaduwela', 'Grade 5', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(39, 'Kaduwela', 'Grade 6', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(40, 'Kaduwela', 'Grade 7', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(41, 'Kaduwela', 'Grade 8', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(42, 'Kaduwela', 'Grade 9', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(43, 'Kaduwela', 'Grade 10', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(44, 'Kaduwela', 'Grade 11', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(45, 'Kaduwela', 'A/L', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(46, 'Kaduwela', 'Adult', 'Drumming Classes', 'Fri 6.30-7.30pm OR Sat/Sun 3.00-4.00pm (Select One)'),
(47, 'Kaduwela', 'Grade 7', 'Grade 7 Class', 'Tue/Wed/Fri 4.30-6.30pm OR Sat/Sun 2.00-4.00pm (Select One)'),
(48, 'Kaduwela', 'Grade 10', 'Grade 10 Class', 'Tue/Wed/Fri 4.30-6.30pm OR Sat 4.30-6.30pm OR Sun 4.30-6.00pm (Select One)'),
(49, 'Kaduwela', 'Grade 11', 'Grade 11 Class', 'Tue/Wed/Fri 4.30-6.30pm OR Sat 4.30-6.30pm OR Sun 4.30-6.00pm (Select One)'),
(50, 'Kaduwela', 'A/L', 'Advanced Level Class', 'Tue 4.30-6.30pm OR Sat/Sun 8.30-10.30am (Select One)'),
(51, 'Kaduwela', 'Adult', 'Adult-Beginner Class', 'Tue 6-8pm OR Fri 4.30-6pm OR Sun 8.30-10.30am (Select One)');

CREATE TABLE `student_payments` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `paid_for_month` varchar(20) NOT NULL,
  `paid_for_year` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `skip_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO `student_payments` (`id`, `student_id`, `paid_for_month`, `paid_for_year`, `transaction_date`, `skip_reason`, `created_at`, `amount`) VALUES
(1, 'std_demo_01', 'November', 2025, '2025-11-22', NULL, '2025-11-22 13:15:56', 4000.00);

-- --------------------------------------------------------


--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','student') NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `branch` varchar(50) DEFAULT NULL,
  `enrolled_class_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO `users` (`id`, `username`, `password`, `role`, `full_name`, `grade`, `branch`, `enrolled_class_id`, `created_at`) VALUES
(1, 'admin', '$2y$10$hashedpasswordplaceholder...', 'admin', 'Academy Director', NULL, NULL, NULL, '2025-01-01 10:00:00'),
(2, 'staff_demo', '$2y$10$hashedpasswordplaceholder...', 'staff', 'Staff Member', NULL, NULL, NULL, '2025-01-01 10:00:00'),
(3, 'std_demo_01', '$2y$10$hashedpasswordplaceholder...', 'student', 'Sample Student', 'Grade 10', 'Horana', 11, '2025-01-01 10:00:00');


ALTER TABLE `classes` ADD PRIMARY KEY (`id`);
ALTER TABLE `student_payments` ADD PRIMARY KEY (`id`);
ALTER TABLE `users` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);



ALTER TABLE `classes` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
ALTER TABLE `student_payments` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

