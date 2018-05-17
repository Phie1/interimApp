-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 17 mai 2018 à 11:09
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `symfony`
--
CREATE DATABASE IF NOT EXISTS `symfony` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `symfony`;

-- --------------------------------------------------------

--
-- Structure de la table `contract`
--

DROP TABLE IF EXISTS `contract`;
CREATE TABLE IF NOT EXISTS `contract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interim_id` int(11) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E98F285929C96BD8` (`interim_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contract`
--

INSERT INTO `contract` (`id`, `interim_id`, `date_start`, `date_end`, `status`) VALUES
(1, 1, '2018-05-15 00:00:00', '2018-05-21 00:00:00', 'En cours'),
(3, 2, '2018-05-16 00:00:00', '2018-05-18 00:00:00', 'En attente'),
(5, 1, '2013-01-01 00:00:00', '2013-01-02 00:00:00', 'Terminé'),
(6, 1, '2013-01-03 00:00:00', '2013-01-07 00:00:00', 'Terminé'),
(7, 1, '2013-01-06 00:00:00', '2013-01-15 00:00:00', 'Terminé'),
(8, 2, '2013-01-20 00:00:00', '2013-01-25 00:00:00', 'Terminé'),
(9, 1, '2014-01-01 00:00:00', '2014-01-06 00:00:00', 'Terminé'),
(10, 3, '2018-05-17 00:00:00', '2018-05-20 00:00:00', 'En attente'),
(11, 4, '2018-05-16 00:00:00', '2018-05-20 00:00:00', 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `interim`
--

DROP TABLE IF EXISTS `interim`;
CREATE TABLE IF NOT EXISTS `interim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `interim`
--

INSERT INTO `interim` (`id`, `name`, `surname`, `mail`, `zip_code`, `city`) VALUES
(1, 'John', 'DOE', 'john.doe@mail.com', '38000', 'Grenoble'),
(2, 'Jane', 'DUH', 'jane.duh@mail.com', '69001', 'Lyon'),
(3, 'Xavier', 'FROSSARD', 'xavier.frossard@yahoo.fr', '38170', 'Seyssinet-Pariset'),
(4, 'Jean', 'DUPONT', 'jean_dupont@mail.com', '75001', 'Paris'),
(5, 'John', 'MODESTE', 'john.modeste@mail.com', '01000', 'Bourg-en-Bresse');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20180512163122'),
('20180513125100'),
('20180513190653');

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

DROP TABLE IF EXISTS `mission`;
CREATE TABLE IF NOT EXISTS `mission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interim_id` int(11) NOT NULL,
  `contract_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9067F23C2576E0FD` (`contract_id`),
  KEY `IDX_9067F23C29C96BD8` (`interim_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mission`
--

INSERT INTO `mission` (`id`, `interim_id`, `contract_id`, `rating`, `status`) VALUES
(1, 1, 1, 5, 'Supprimé'),
(5, 1, 5, 3, 'Supprimé'),
(6, 1, 6, 2, 'Supprimé'),
(7, 2, 3, 2, 'Supprimé'),
(8, 1, 7, 3, 'Supprimé'),
(10, 2, 8, 1, 'Actif'),
(11, 1, 9, 1, 'Actif'),
(12, 3, 10, 10, 'Actif');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contract`
--
ALTER TABLE `contract`
  ADD CONSTRAINT `FK_E98F285929C96BD8` FOREIGN KEY (`interim_id`) REFERENCES `interim` (`id`);

--
-- Contraintes pour la table `mission`
--
ALTER TABLE `mission`
  ADD CONSTRAINT `FK_9067F23C2576E0FD` FOREIGN KEY (`contract_id`) REFERENCES `contract` (`id`),
  ADD CONSTRAINT `FK_9067F23C29C96BD8` FOREIGN KEY (`interim_id`) REFERENCES `interim` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
