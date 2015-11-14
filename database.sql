-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Tid vid skapande: 14 nov 2015 kl 21:18
-- Serverversion: 5.5.44-0+deb8u1
-- PHP-version: 5.6.14-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `termometer`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `forecast`
--

CREATE TABLE IF NOT EXISTS `forecast` (
  `referenceTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `validTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `temperature` double NOT NULL,
  `precipitation` double NOT NULL,
  `added` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `sensorID` varchar(20) NOT NULL,
  `day` date NOT NULL,
  `maximal` double NOT NULL,
  `minimum` double NOT NULL,
  `average` double NOT NULL,
  `valid` int(11) NOT NULL,
  `hits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `hour_history`
--

CREATE TABLE IF NOT EXISTS `hour_history` (
  `sensorID` varchar(20) NOT NULL,
  `hour` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `maximal` double NOT NULL,
  `minimum` double NOT NULL,
  `average` double NOT NULL,
  `valid` int(11) NOT NULL,
  `hits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `measurement`
--

CREATE TABLE IF NOT EXISTS `measurement` (
  `sensorID` varchar(20) NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `measurement` float NOT NULL,
  `valid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
