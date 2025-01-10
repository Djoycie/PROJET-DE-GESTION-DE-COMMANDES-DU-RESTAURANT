-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 10 jan. 2025 à 12:34
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `resto`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(155) NOT NULL,
  `adresse` varchar(155) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `moyen_paiement` varchar(50) NOT NULL,
  `articles` text NOT NULL,
  `date_commande` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `nom`, `adresse`, `telephone`, `moyen_paiement`, `articles`, `date_commande`) VALUES
(1, 'yasmine bouba', 'ngousso', '699049472', 'paypal', '[{\"id\":\"18\",\"nom\":\"Jambon aux legumes\",\"quantite\":\"3\",\"categorie\":\"plat de resistance\",\"prix\":25500}]', '2024-12-31 16:36:49'),
(2, 'Nguepi Lind', 'Mendong', '671728623', 'orange_money', '{\"1\":{\"id\":\"11\",\"nom\":\"Cokctail\",\"quantite\":\"3\",\"categorie\":\"Boissons\",\"prix\":4500}}', '2024-12-31 16:37:45'),
(3, 'johnny atangana', 'nkolbiss', '675432187', 'mtn_money', '[{\"id\":\"9\",\"nom\":\"Salade Mayonnaise\",\"quantite\":\"3\",\"categorie\":\"Entree\",\"prix\":12000}]', '2024-12-31 16:38:41'),
(4, 'ivana kom', 'nkolbisson', '699049472', 'paypal', '[{\"id\":\"8\",\"nom\":\"Salade\",\"quantite\":\"4\",\"categorie\":\"Entree\",\"prix\":8000}]', '2024-12-31 16:40:13'),
(5, 'alex dongmo', 'eloumdem', '675432047', 'mtn_money', '[{\"id\":\"11\",\"nom\":\"Cokctail\",\"quantite\":\"5\",\"categorie\":\"Boissons\",\"prix\":7500}]', '2024-12-31 16:41:03'),
(6, 'mezamguim', 'Mendong', '681728663', 'paypal', '{\"1\":{\"id\":\"9\",\"nom\":\"Salade Mayonnaise\",\"quantite\":\"6\",\"categorie\":\"Entree\",\"prix\":24000}}', '2024-12-31 16:42:48'),
(7, 'corine', 'simbock', '654321098', 'mtn_money', '[{\"id\":\"11\",\"nom\":\"Cokctail\",\"quantite\":\"3\",\"categorie\":\"Boissons\",\"prix\":4500}]', '2024-12-31 16:44:54'),
(8, 'Signe', 'Biyemassi', '698654324', 'orange_money', '[{\"id\":\"9\",\"nom\":\"Salade Mayonnaise\",\"quantite\":\"1\",\"categorie\":\"Entree\",\"prix\":4000}]', '2025-01-07 10:31:50'),
(9, 'lucas', 'odza', '654378920', 'orange_money', '[{\"id\":\"21\",\"nom\":\"Legumes frais\",\"quantite\":\"1\",\"categorie\":\"Entree\",\"prix\":2000}]', '2025-01-08 11:17:25');

-- --------------------------------------------------------

--
-- Structure de la table `commande_article`
--

DROP TABLE IF EXISTS `commande_article`;
CREATE TABLE IF NOT EXISTS `commande_article` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_commande` int UNSIGNED NOT NULL,
  `id_article` int UNSIGNED NOT NULL,
  `quantite` int UNSIGNED NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_commande` (`id_commande`),
  KEY `id_article` (`id_article`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`id`, `nom`, `description`, `image`, `prix`) VALUES
(9, 'Pizza', 'une pizza au ingredients de qualité et au saveurs italiennes ', 'images/c3.jpg', '7000.00'),
(11, 'Des pattes carbonaras', 'Une autre maniere de cuisiner les pattes', 'images/p5.jpg', '4000.00'),
(7, 'Viande fume', 'De la viande fumée ', 'images/bg-item3-min.jpg', '7000.00');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`id`, `nom`, `description`, `image`, `prix`, `categorie`) VALUES
(21, 'Legumes frais', 'Un petit dejeuner delicieux', 'images/breakfast-banner-menupage-1024x483-min.jpg', '2000.00', 'Entree'),
(19, 'Viande braisee', 'De la viande au gout de la braise', 'images/c7.jpg', '8500.00', 'plat de resistance'),
(8, 'Salade', 'Une salade aux legumes frais', 'images/c1.jpg', '2000.00', 'Entree'),
(9, 'Salade Mayonnaise', 'Une salade aux saveurs du persil', 'images/c2.jpg', '4000.00', 'Entree'),
(11, 'Cokctail', 'Un melange de fruits rares', 'images/cocktail.jpg', '1500.00', 'Boissons'),
(18, 'Jambon aux legumes', 'Une autre maniere de cuisiner le jambon', 'images/c4.jpg', '8500.00', 'plat de resistance'),
(13, 'Crevettes', 'Des crevettes fraiches', 'images/c9.jpg', '10000.00', 'plat de résistance'),
(22, 'Pizza bolognaise', 'encore de la pizza', 'images/lunch-banner-menupage-m-min-1.jpg', '4500.00', 'plat de résistance');

-- --------------------------------------------------------

--
-- Structure de la table `temoignage`
--

DROP TABLE IF EXISTS `temoignage`;
CREATE TABLE IF NOT EXISTS `temoignage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `temoignage` text NOT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `temoignage`
--

INSERT INTO `temoignage` (`id`, `temoignage`, `date_creation`) VALUES
(7, 'le restaurant le master chef c\'est la qualite et la quantite dans la meme plat. Allez s\'y faire un tour c\'est une dinguerie les gars.', '2025-01-06 12:00:12'),
(2, 'Moi c\'est le tiktokeur Akesou Faites s\'y un tour . Trop parler c\'est maladie; Ce n\'est pas les rhumeras', '2024-12-31 11:15:06'),
(3, 'Master Chef is good . The services are specials and cleans.', '2024-12-31 11:23:57'),
(5, 'Le restaurant est tres propre mais le service est lent.\r\n', '2024-12-31 11:29:52');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
