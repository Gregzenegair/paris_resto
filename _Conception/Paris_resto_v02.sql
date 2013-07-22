CREATE DATABASE IF NOT EXISTS `paris_resto`;
USE `paris_resto`;

CREATE TABLE  `paris_resto`.`adresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_voie` int(10) unsigned NOT NULL,
  `nom_voie` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `id_ville` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `paris_resto`.`categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `paris_resto`.`commentaires` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_insertion` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `paris_resto`.`lignotes` (
  `id_restaurant` int(10) unsigned NOT NULL,
  `id_note` int(10) unsigned NOT NULL,
  `id_commentaire` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `paris_resto`.`ligphotos` (
  `id_restaurant` int(10) unsigned NOT NULL,
  `id_photo` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `paris_resto`.`notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_type_note` int(10) unsigned NOT NULL,
  `valeur` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `paris_resto`.`photos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom_fichier` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date_insertion` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `paris_resto`.`restaurants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `id_categorie` int(10) unsigned NOT NULL,
  `numero_tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_adresse` int(10) unsigned NOT NULL,
  `id_note` int(10) unsigned NOT NULL,
  `id_photo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `paris_resto`.`statuts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `paris_resto`.`type_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `paris_resto`.`types_voie` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `paris_resto`.`users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `mdp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `statut` int(2) unsigned NOT NULL,
  `date_inscription` date NOT NULL,
  `email_check` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `actif` tinyint(1) NOT NULL DEFAULT '0',
  `commentaire` varchar(1000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `paris_resto`.`villes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cp` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;