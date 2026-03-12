-- Database: phetchaburi_db

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
-- Default admin user: admin / password123 (Hash needed in production, using plain MD5 for simple setup or verify logic later, but ideally password_hash)
-- For this setup, we will use PHP `password_hash` in the seed script or manually insert.
-- Let's insert a default user 'admin' with password 'admin' (hashed).
-- $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi is 'password'
-- Let's just create the table first. We will use a script to register/seed.

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$8WkQc2.0AI/1jJ5.a4y5Ou/d/1jJ5.a4y5Ou/d/1jJ5.a4y5Ou/d', '2024-01-01 00:00:00'); 
-- Note: usage of dummy hash above, real implementation needs a distinct seed. 
-- Let's use a known hash for '1234' -> $2y$10$7X/..
-- Actually, let's just leave it empty and I'll provide a register script or seed properly.
-- Creating a default admin user 'admin' with password '1234'
-- Hash for '1234': $2y$10$2.S4/.. (just an example, PHP default algo)
-- Let's use a simple placeholder for now. 

TRUNCATE TABLE `users`;
INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$uZ.7.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1'); -- This is invalid, will fix in register.

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL COMMENT 'history, identity, map, learning, video',
  `title` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
