SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web-chat`
--
CREATE DATABASE IF NOT EXISTS `web-chat` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `web-chat`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
);

-- --------------------------------------------------------

--
-- Table structure for table `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` varchar(8) NOT NULL,
  `chat_title` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `owner` varchar(15) NOT NULL,
  `chat_type` enum('private','public') NOT NULL DEFAULT 'private',
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_id` (`room_id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` varchar(8) DEFAULT NULL,
  `username` varchar(15) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `msg_content` text DEFAULT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `room_id` (`room_id`),
  KEY `username` (`username`),
  FOREIGN KEY (`room_id`) REFERENCES `chat_rooms` (`room_id`) ON DELETE CASCADE,
  FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE
);

-- --------------------------------------------------------

--
-- Adding system to the `users`
--

INSERT INTO `users` (`username`, `email`, `password`) VALUES ('system', 'system@mnuvq.com', 'system');



COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
