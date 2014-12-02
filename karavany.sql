-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `karavany` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci */;
USE `karavany`;

DROP TABLE IF EXISTS `aktualni_karavany`;
CREATE TABLE `aktualni_karavany` (
  `id_nabidka` int(11) NOT NULL AUTO_INCREMENT,
  `id_karavan` int(11) NOT NULL,
  `id_zaklad` int(11) NOT NULL,
  `datum_do` date NOT NULL,
  PRIMARY KEY (`id_nabidka`),
  KEY `id_karavan` (`id_karavan`),
  KEY `id_zaklad` (`id_zaklad`),
  CONSTRAINT `aktualni_karavany_ibfk_1` FOREIGN KEY (`id_karavan`) REFERENCES `karavany` (`id_karavan`) ON DELETE CASCADE,
  CONSTRAINT `aktualni_karavany_ibfk_2` FOREIGN KEY (`id_zaklad`) REFERENCES `karavany` (`id_karavan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `clanky`;
CREATE TABLE `clanky` (
  `id_clanek` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `nadpis` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `perex` text COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL,
  `novinka` tinyint(1) NOT NULL DEFAULT '0',
  `datum_vytvoreni` date NOT NULL,
  PRIMARY KEY (`id_clanek`),
  KEY `id_autor` (`id_autor`),
  CONSTRAINT `clanky_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `uzivatele` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `galerie`;
CREATE TABLE `galerie` (
  `id_foto` int(11) NOT NULL,
  `nazev` varchar(255) CHARACTER SET utf32 COLLATE utf32_czech_ci NOT NULL,
  `hlavni` tinyint(1) NOT NULL COMMENT 'Pokud je obrázek hlavní vlož 1',
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_foto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `galerie` (`id_foto`, `nazev`, `hlavni`, `datum`) VALUES
(535165008,	'dghd1c873xrcqzhv1wjc4rp3.jpg',	0,	'2014-07-14 19:05:15'),
(605522581,	'77r0u94jfgf94ekzqjqy7q3y.jpg',	1,	'2014-07-14 19:06:44'),
(621808047,	'hkho66djidjv5zdd0ogghdv4.jpg',	0,	'2014-07-14 19:05:15'),
(629905657,	'unojfenaek12ppffr477oq3o.jpg',	0,	'2014-07-14 19:06:45'),
(675578250,	'yulgtj1wenw94qc8nrdojrac.jpg',	0,	'2014-07-14 19:06:46'),
(1717879022,	'r73lismrw8aw4nnlo82vzpg8.jpg',	0,	'2014-07-14 19:06:47'),
(2143947537,	'xyhjawqsjrgs7vu0kjrlq3t9.jpg',	0,	'2014-07-14 19:05:14'),
(2147483647,	'7r8jewdcztxs6kt9pxr99y0x.jpg',	1,	'2014-07-14 19:05:14');

DROP TABLE IF EXISTS `galerie_kategorie`;
CREATE TABLE `galerie_kategorie` (
  `id_kategorie` int(11) NOT NULL,
  `id_karavan` int(11) NOT NULL,
  `id_foto` int(11) NOT NULL,
  KEY `id_kategorie` (`id_kategorie`),
  KEY `id_karavan` (`id_karavan`),
  KEY `id_foto` (`id_foto`),
  CONSTRAINT `galerie_kategorie_ibfk_1` FOREIGN KEY (`id_kategorie`) REFERENCES `kategorie` (`id_kategorie`) ON DELETE CASCADE,
  CONSTRAINT `galerie_kategorie_ibfk_2` FOREIGN KEY (`id_karavan`) REFERENCES `karavany` (`id_karavan`) ON DELETE CASCADE,
  CONSTRAINT `galerie_kategorie_ibfk_3` FOREIGN KEY (`id_foto`) REFERENCES `galerie` (`id_foto`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `galerie_kategorie` (`id_kategorie`, `id_karavan`, `id_foto`) VALUES
(3,	992699,	2143947537),
(3,	992699,	535165008),
(3,	992699,	621808047),
(2,	805417,	629905657),
(2,	805417,	675578250),
(2,	805417,	1717879022);

DROP TABLE IF EXISTS `hlavni_obrazky_karavany`;
CREATE TABLE `hlavni_obrazky_karavany` (
  `id_foto` int(11) NOT NULL,
  `id_karavan` int(11) NOT NULL,
  KEY `id_foto` (`id_foto`),
  KEY `id_karavan` (`id_karavan`),
  CONSTRAINT `hlavni_obrazky_karavany_ibfk_1` FOREIGN KEY (`id_foto`) REFERENCES `galerie` (`id_foto`) ON DELETE CASCADE,
  CONSTRAINT `hlavni_obrazky_karavany_ibfk_2` FOREIGN KEY (`id_karavan`) REFERENCES `karavany` (`id_karavan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `hlavni_obrazky_karavany` (`id_foto`, `id_karavan`) VALUES
(2147483647,	992699),
(605522581,	805417);

DROP TABLE IF EXISTS `karavany`;
CREATE TABLE `karavany` (
  `id_karavan` int(11) NOT NULL,
  `znacka` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `typ` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `cena` int(5) NOT NULL COMMENT 'Kč bez DPH',
  `sirka` int(3) NOT NULL COMMENT 'cm',
  `delka` int(3) NOT NULL COMMENT 'cm',
  `vyska` int(3) NOT NULL COMMENT 'cm',
  `nastavba_sirka` int(3) DEFAULT NULL,
  `nastavba_delka` int(3) DEFAULT NULL,
  `nastavba_vyska` int(3) DEFAULT NULL,
  `vyska_vnitrni` int(3) DEFAULT NULL,
  `luzko_delka` int(3) DEFAULT NULL COMMENT 'cm',
  `luzko_sirka` int(3) DEFAULT NULL COMMENT 'cm',
  `hmotnost_p` int(4) DEFAULT NULL COMMENT 'pohotovostni [kg]',
  `hmotnost_pb` int(4) DEFAULT NULL COMMENT 'pohotovostni brzdena [kg]',
  `hmotnost_c` int(4) DEFAULT NULL COMMENT 'celkova [kg]',
  `hmotnost_t` int(4) DEFAULT NULL COMMENT 'technicka povolena [kg]',
  `hmotnost_max` int(4) DEFAULT NULL COMMENT 'maximalni',
  `podvozek` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `exterier` text COLLATE utf8_czech_ci,
  `podvozek2` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL,
  `pneu` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL,
  `napajeni` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `datum_vlozeni` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `vybava` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Standardní výbava',
  `popis` text COLLATE utf8_czech_ci,
  `barva` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_karavan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `karavany` (`id_karavan`, `znacka`, `typ`, `cena`, `sirka`, `delka`, `vyska`, `nastavba_sirka`, `nastavba_delka`, `nastavba_vyska`, `vyska_vnitrni`, `luzko_delka`, `luzko_sirka`, `hmotnost_p`, `hmotnost_pb`, `hmotnost_c`, `hmotnost_t`, `hmotnost_max`, `podvozek`, `exterier`, `podvozek2`, `pneu`, `napajeni`, `datum_vlozeni`, `vybava`, `popis`, `barva`) VALUES
(805417,	'sss',	'sss',	77777,	888,	888,	888,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	'aaaaaa',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'aaaaaaaaaaa',	'',	''),
(992699,	'xxx',	'yyy',	999999,	888,	888,	888,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	0,	'sss',	'',	'',	'',	'',	'0000-00-00 00:00:00',	'sss',	'',	'');

DROP TABLE IF EXISTS `karavany_vybava`;
CREATE TABLE `karavany_vybava` (
  `id_karavan` int(11) NOT NULL,
  `id_vybava` int(11) NOT NULL,
  KEY `id_karavan` (`id_karavan`),
  KEY `id_vybava` (`id_vybava`),
  CONSTRAINT `karavany_vybava_ibfk_1` FOREIGN KEY (`id_karavan`) REFERENCES `karavany` (`id_karavan`) ON DELETE CASCADE,
  CONSTRAINT `karavany_vybava_ibfk_2` FOREIGN KEY (`id_vybava`) REFERENCES `vybava_specialni` (`id_vybava`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `kategorie`;
CREATE TABLE `kategorie` (
  `id_kategorie` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_kategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `kategorie` (`id_kategorie`, `nazev`) VALUES
(2,	'Interiér'),
(3,	'Exteriér'),
(4,	'Ahoja'),
(5,	'jjj'),
(6,	'aaa');

DROP TABLE IF EXISTS `log_prihlaseni`;
CREATE TABLE `log_prihlaseni` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `ip` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  KEY `id` (`id`),
  CONSTRAINT `log_prihlaseni_ibfk_1` FOREIGN KEY (`id`) REFERENCES `uzivatele` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `sestavy`;
CREATE TABLE `sestavy` (
  `id_sestava` int(11) NOT NULL AUTO_INCREMENT,
  `id_karavan` int(11) NOT NULL,
  `cena` int(5) NOT NULL COMMENT 'Kč bez DPH',
  `nazev` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_sestava`),
  KEY `id_karavan` (`id_karavan`),
  CONSTRAINT `sestavy_ibfk_1` FOREIGN KEY (`id_karavan`) REFERENCES `karavany` (`id_karavan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `sestavy_vybava`;
CREATE TABLE `sestavy_vybava` (
  `id_sestava` int(11) NOT NULL,
  `id_vybava` int(11) NOT NULL,
  PRIMARY KEY (`id_sestava`,`id_vybava`),
  KEY `id_vybava` (`id_vybava`),
  CONSTRAINT `sestavy_vybava_ibfk_1` FOREIGN KEY (`id_sestava`) REFERENCES `sestavy` (`id_sestava`) ON DELETE CASCADE,
  CONSTRAINT `sestavy_vybava_ibfk_2` FOREIGN KEY (`id_vybava`) REFERENCES `vybava_specialni` (`id_vybava`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `uzivatele`;
CREATE TABLE `uzivatele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `uzivatele` (`id`, `jmeno`, `prijmeni`, `email`, `heslo`) VALUES
(1,	'Admin',	'Adminovič',	'admin@admin.cz',	'$2y$10$6Mv5OZMLLSdOHwuYqlbSi.IUUz8LOWsXUKU167hQ6UYEj3AOs4VLe');

DROP TABLE IF EXISTS `vybava_specialni`;
CREATE TABLE `vybava_specialni` (
  `id_vybava` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `cena` int(5) NOT NULL COMMENT 'Kč bez DPH',
  `popis` text COLLATE utf8_czech_ci,
  PRIMARY KEY (`id_vybava`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


-- 2014-07-14 19:34:37
