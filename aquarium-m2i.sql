-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 24 août 2021 à 12:21
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `aquarium-m2i`
--

-- --------------------------------------------------------

--
-- Structure de la table `aquarium`
--

DROP TABLE IF EXISTS `aquarium`;
CREATE TABLE IF NOT EXISTS `aquarium` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `aquarium`
--

INSERT INTO `aquarium` (`id`, `name`) VALUES
(1, 'my-aqua-1'),
(2, 'my-aqua-2'),
(3, 'my-aqua-2'),
(4, 'my-aqua-2');

-- --------------------------------------------------------

--
-- Structure de la table `aquarium-config`
--

DROP TABLE IF EXISTS `aquarium-config`;
CREATE TABLE IF NOT EXISTS `aquarium-config` (
  `id_aquarium` int(11) NOT NULL,
  `id_foreign` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `aquarium-config`
--

INSERT INTO `aquarium-config` (`id_aquarium`, `id_foreign`, `type`) VALUES
(1, 1, 'Light'),
(1, 1, 'Food');

-- --------------------------------------------------------

--
-- Structure de la table `aquarium-data`
--

DROP TABLE IF EXISTS `aquarium-data`;
CREATE TABLE IF NOT EXISTS `aquarium-data` (
  `id_aquarium` int(11) NOT NULL,
  `id_data` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `aquarium-data`
--

INSERT INTO `aquarium-data` (`id_aquarium`, `id_data`) VALUES
(1, 1),
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `aquarium-user`
--

DROP TABLE IF EXISTS `aquarium-user`;
CREATE TABLE IF NOT EXISTS `aquarium-user` (
  `id_aquarium` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `aquarium-user`
--

INSERT INTO `aquarium-user` (`id_aquarium`, `id_user`) VALUES
(1, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `camera`
--

DROP TABLE IF EXISTS `camera`;
CREATE TABLE IF NOT EXISTS `camera` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `data`
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ph` float NOT NULL,
  `temperature` float NOT NULL,
  `humidite` float NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `data`
--

INSERT INTO `data` (`id`, `ph`, `temperature`, `humidite`, `timestamp`) VALUES
(1, 1, 23.2, 30.5, '2021-07-15 11:27:38'),
(2, 2, 30, 20.2, '2021-07-15 18:12:39'),
(3, 7, 25.2, 48.5, '2021-07-15 18:12:39');

-- --------------------------------------------------------

--
-- Structure de la table `food`
--

DROP TABLE IF EXISTS `food`;
CREATE TABLE IF NOT EXISTS `food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `last_give_food` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `food`
--

INSERT INTO `food` (`id`, `name`, `status`, `last_give_food`) VALUES
(1, 'main', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `light`
--

DROP TABLE IF EXISTS `light`;
CREATE TABLE IF NOT EXISTS `light` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `light`
--

INSERT INTO `light` (`id`, `name`, `status`) VALUES
(1, 'rear', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `email`) VALUES
(1, 'edenskull', '$2y$10$oTb258mUCjqbZYd/UZtGR.Zw151xzFFWYfMvSCeMPDlYXb5ehZUwi', 'maxchamp@live.fr'),
(2, 'eden', '$2y$10$Eo.Zpd1W4z3lSr7OUqnaNeW1u58ysrYzX7lBb9iK3IeYs8AGPkLFe', 'mxc@live.fr');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
