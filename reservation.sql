-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 26, 2012 at 04:47 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `form_cars`
--

CREATE TABLE IF NOT EXISTS `form_cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_type` varchar(255) DEFAULT NULL,
  `car_capacity` int(11) DEFAULT NULL,
  `car_luggage` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `form_car_fees`
--

CREATE TABLE IF NOT EXISTS `form_car_fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trip` int(11) DEFAULT NULL,
  `car` int(11) DEFAULT NULL,
  `fee` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `form_locations`
--

CREATE TABLE IF NOT EXISTS `form_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `form_settings`
--

CREATE TABLE IF NOT EXISTS `form_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nys_tax` float DEFAULT NULL,
  `pro_fee` float DEFAULT NULL,
  `mid_tax` float DEFAULT NULL,
  `lin_tax` float DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `form_settings`
--

INSERT INTO `form_settings` (`id`, `nys_tax`, `pro_fee`, `mid_tax`, `lin_tax`, `username`, `password`) VALUES
(1, 8.875, 0.3, 5, 5, 'username', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `form_trip_fees`
--

CREATE TABLE IF NOT EXISTS `form_trip_fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_a` int(11) DEFAULT NULL,
  `fee` float DEFAULT NULL,
  `more_fee` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
