-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Mar 16 Juillet 2013 à 21:19
-- Version du serveur: 5.5.27
-- Version de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `paris_resto`
--

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(1, 'Fast-Food'),
(2, 'Classique'),
(3, 'Gastronomique'),
(5, 'Caféteria'),
(6, 'Française'),
(7, 'Américain'),
(8, 'Traditionnel');

--
-- Contenu de la table `villes`
--

INSERT INTO `villes` (`id`, `nom`, `cp`) VALUES
(1, 'Saint Ouen l''Aumône', '95310'),
(2, 'Pontoise', '95200'),
(3, 'Osny', '95410'),
(4, 'Gennevilliers', '92230'),
(5, 'Cergy', '95000');

--
-- Contenu de la table `restaurants`
--

INSERT INTO `restaurants` (`id`, `nom`, `numero_tel`, `email`, `nom_voie`, `numero_voie`, `id_villes`, `id_types_voie`) VALUES
(1, 'Mac Donald''s', '01 34 64 24 84', 'M@cdo.fr', 'des Canards', 9, 1, 5),
(2, 'Campanile', '01 12 27 32 64', 'Camp@nile.fr', 'Magenta', 11, 1, 3),
(3, 'Quick', '01 30 37 32 52', 'quick@gmail.com', 'Saint Martin', 7, 2, 3),
(4, 'Burger King', '887 888 760', 'burger@king.com', 'des gros', 3, 2, 3),
(5, 'Flunch', '01 20 20 40 30', 'Fluch@er.fr', 'des Vaches', 558, 3, 7),
(6, 'Campanile', '01 24 52 45 65', 'camp@nile.fr', 'des Nouilles', 120, 4, 4),
(7, 'Buffalo Grill', '01 34 64 24 12', '', 'de Bonds', 5, 5, 2);

--
-- Contenu de la table `statuts`
--

INSERT INTO `statuts` (`id`, `nom`) VALUES
(0, 'Utilisateur'),
(8, 'Modérateur'),
(10, 'Administrateur');

--
-- Contenu de la table `types_voie`
--

INSERT INTO `types_voie` (`id`, `nom`) VALUES
(1, 'allée'),
(2, 'avenue'),
(3, 'boulevard'),
(4, 'chemin'),
(5, 'impasse'),
(6, 'lieu dit'),
(7, 'rue');

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `mdp`, `date_inscription`, `email_check`, `actif`, `commentaire`, `statut`) VALUES
(1, 'Gregzenegair', 'gregzenegair@gmail.com', 'f3a9a329e27cadab29f42a2b74b93f3a', '2013-07-16', '8dc7404de2d0b406cb6d32e5b7809224', 1, '', 10);



--
-- Contenu de la table `ligcategories`
--

INSERT INTO `ligcategories` (`id_restaurants`, `id_categories`) VALUES
(1, 1),
(3, 1),
(4, 1),
(2, 2),
(6, 2),
(2, 3),
(5, 5),
(6, 6),
(7, 7),
(6, 8);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;