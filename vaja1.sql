-- --------------------------------------------------------
-- Strežnik:                     127.0.0.1
-- Verzija strežnika:            8.0.30 - MySQL Community Server - GPL
-- Operacijski sistem strežnika: Win64
-- HeidiSQL Različica:           12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for vaja1
CREATE DATABASE IF NOT EXISTS `vaja1` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `vaja1`;

-- Dumping structure for tabela vaja1.ads
CREATE TABLE IF NOT EXISTS `ads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `user_id` int NOT NULL,
  `image` longblob NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Dumping data for table vaja1.ads: 2 rows
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;
INSERT INTO `ads` (`id`, `title`, `description`, `user_id`, `image`, `created_at`, `views`) VALUES
INSERT INTO `ads` (`id`, `title`, `description`, `user_id`, `image`, `created_at`, `views`) VALUES
/*!40000 ALTER TABLE `ads` ENABLE KEYS */;

-- Dumping structure for tabela vaja1.ad_category
CREATE TABLE IF NOT EXISTS `ad_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ad_id` int NOT NULL DEFAULT '0',
  `category_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Dumping data for table vaja1.ad_category: ~6 rows (približno)
INSERT INTO `ad_category` (`id`, `ad_id`, `category_id`) VALUES
	(45, 44, 1),
	(46, 44, 3),
	(48, 45, 1),
	(49, 45, 3),
	(57, 46, 3),
	(58, 46, 4),
	(62, 48, 1),
	(63, 48, 3),
	(66, 47, 3),
	(67, 47, 4);

-- Dumping structure for tabela vaja1.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Dumping data for table vaja1.category: ~8 rows (približno)
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'narava'),
	(2, 'zabava'),
	(3, 'živali'),
	(4, 'mačka'),
	(5, 'pes'),
	(6, 'hrana'),
	(7, 'torta'),
	(8, 'ovca');

-- Dumping structure for tabela vaja1.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `password` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `name` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `lastname` text COLLATE utf8mb3_slovenian_ci NOT NULL,
  `email` text COLLATE utf8mb3_slovenian_ci NOT NULL,
  `address` text COLLATE utf8mb3_slovenian_ci,
  `postal_number` int DEFAULT '0',
  `tel` text COLLATE utf8mb3_slovenian_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Dumping data for table vaja1.users: 3 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `name`, `lastname`, `email`, `address`, `postal_number`, `tel`) VALUES
	(10, 'bina', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Bina', 'Pauric', 'sabina.pauic@gmail.com', '', 0, ''),
	(9, 'Sarapa', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Sara', 'Paurič', 'sabina.pauric@gmail.com', 'Proletarskih brigad 59', 2000, '031640335'),
	(8, 'Sabinapa', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Sabina', 'Pauric', 'sabina.pauric@gmail.com', '', 0, '');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;