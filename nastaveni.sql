-- phpMyAdmin SQL Dump
-- version 3.5.FORPSI
-- http://www.phpmyadmin.net
--
-- Počítač: 81.2.194.146
-- Vygenerováno: Pát 05. pro 2014, 00:25
-- Verze MySQL: 5.5.37-35.1-log
-- Verze PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `f62049`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `nastaveni`
--

CREATE TABLE IF NOT EXISTS `nastaveni` (
  `id_jazyk` int(2) NOT NULL,
  `tax_rate` int(2) NOT NULL,
  `exchange_rate` float NOT NULL,
  PRIMARY KEY (`id_jazyk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `nastaveni`
--

INSERT INTO `nastaveni` (`id_jazyk`, `tax_rate`, `exchange_rate`) VALUES
(21, 21, 1),
(22, 21, 0.04);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
