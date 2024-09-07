-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 28, 2024 at 09:37 AM
-- Server version: 8.3.0
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barktopia`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE IF NOT EXISTS `authors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `last_name`) VALUES
(1, 'Brie', 'Brynza'),
(2, 'Taiga', 'Buran');

-- --------------------------------------------------------

--
-- Table structure for table `authors_news`
--

DROP TABLE IF EXISTS `authors_news`;
CREATE TABLE IF NOT EXISTS `authors_news` (
  `id_news` int NOT NULL,
  `id_authors` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`) VALUES
(1, 'Barista Dogs Open Their First Café with an Original Menu', 'In the small town of Barkville, an extraordinary event took place: a team of anthropomorphic barista dogs opened their own café called \"The Sandy Bowl.\" Instead of regular coffee machines, the menu features unique drinks like \"Bone Cappuccino\" and \"Chicken Broth Mocha.\" Additionally, the café offers free snacks for furry guests—turkey and cheese dog biscuits. Visitors say the atmosphere of the place is indescribable—it\'s simply paradise for those who love both coffee and furry friends!', '1.png'),
(2, 'Dog Teacher Launches \'Dog Language\' Classes for Kids', 'At the \"Rainbow\" school, a new subject is now being taught—\"Dog Language.\" An anthropomorphic dog named Lola, who holds a PhD in Cinematics, is now teaching children the art of canine communication. The lessons cover intriguing topics like \"How to Make Your Tail Express Joy\" and \"Why Licking Faces is a Good Sign.\" Parents note that their children have become more attentive and empathetic to their pets\' feelings, and the dogs at Lola\'s school feel like true stars!', '2.png'),
(3, 'Designer Dog Wins Fashion Contest with \'Summer for Paws\' Collection', 'The famous anthropomorphic dog designer named Roxy has won a prestigious fashion contest with her new collection, \"Summer for Paws.\" The collection features comfortable outfits for sunny days, including water-repellent jackets with treat pockets and stylish sun hats. The fashion show was held in a park, where Roxy\'s fluffy friends strutted down the runway alongside her, showcasing the clothing. The show ended with a festive dinner with treats for all participants, and even the judges were moved by Roxy\'s creativity and kindness!', '3.png'),
(4, 'Dog Psychologists Organize Unique Course on \'Happy Barking\'', 'A new training course called \"Happy Barking\" has appeared in the city center, developed by a group of anthropomorphic dog psychologists. This course helps both dogs and their owners learn to manage emotions and express their feelings through special \"calming barks\" and \"happiness scales.\" The program includes sessions on relaxing barking, modules on \"Staying Calm When Meeting Another Dog,\" and \"Joyful Circles.\" Course participants report that their furry friends have become much calmer and happier, and they now better understand how to make their pets feel joyful.', '4.png'),
(5, 'Culinary Dog Launches New Cooking Channel with Recipes for \'Canine Gourmets\'', 'An anthropomorphic dog named Sherlock, a passionate cook and author of the cookbook \"Secrets of the Tail,\" is launching a new cooking channel called \"Canine Gourmet.\" Sherlock will share recipes for dogs, including delicacies like \"Chicken Muffins with Carrots\" and \"Salmon Burgers with Mashed Potatoes.\" He also plans to host weekly live streams, where he will demonstrate how to prepare favorite dishes for dogs and share funny stories about his culinary adventures. The first episode has already garnered a large number of subscribers and positive reviews, with viewers claiming that their pets absolutely love the new treats!', '5.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`) VALUES
(1, 'Funky Corgi', 'funkycorgi@dog.com'),
(2, 'Labrador', 'labrador@dog.com'),
(3, 'Chiwawa', 'chiwawa@dog.com'),
(4, 'Brie', 'brie@dog.com'),
(5, 'Brie', 'brie@dog.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
