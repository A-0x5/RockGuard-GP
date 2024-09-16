-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for rock_ground
CREATE DATABASE IF NOT EXISTS `rock_guard` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `rock_guard`;

-- Data exporting was unselected.

-- Dumping structure for table rock_ground.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- Dumping structure for table rock_ground.feedbacks
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `url` varchar(50) NOT NULL,
  `results` text NOT NULL,
  `is_save` char(50) DEFAULT NULL,
  `additional` varchar(50) DEFAULT NULL,
  `user_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_feedbacks_users` (`user_id`),
  CONSTRAINT `FK_feedbacks_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;


--table urls
CREATE TABLE urls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(2048) NOT NULL,
    label TINYINT(1) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);
