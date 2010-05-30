-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 30. Mai 2010 um 17:24
-- Server Version: 5.1.36
-- PHP-Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `notremenage2`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buyings`
--

CREATE TABLE IF NOT EXISTS `buyings` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(32) NOT NULL,
  `date` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=399 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `productcategories`
--

CREATE TABLE IF NOT EXISTS `productcategories` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `productpurchases`
--

CREATE TABLE IF NOT EXISTS `productpurchases` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `buying_id` varchar(32) NOT NULL,
  `product_id` int(32) NOT NULL,
  `offprice` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3823 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `productcategory_id` int(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=252 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stores`
--

CREATE TABLE IF NOT EXISTS `stores` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;
