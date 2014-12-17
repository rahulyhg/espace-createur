-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2014 at 11:55 AM
-- Server version: 5.5.37
-- PHP Version: 5.5.19-1~dotdeb.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ec_espace-createur`
--

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE IF NOT EXISTS `collections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `commentaries`
--

CREATE TABLE IF NOT EXISTS `commentaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `additionnalInfo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `constant`
--

CREATE TABLE IF NOT EXISTS `constant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `isRead` int(11) NOT NULL DEFAULT '0',
  `isAdmin` int(11) NOT NULL DEFAULT '0',
  `userId` int(11) NOT NULL,
  `isDone` int(11) NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL,
  `additionnalInfo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `shortDescription` text NOT NULL,
  `ugs` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `img` text CHARACTER SET latin1 NOT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  `collection` text NOT NULL,
  `type` text NOT NULL,
  `website` text NOT NULL,
  `currentWebsite` text NOT NULL,
  `userId` int(11) NOT NULL,
  `color` text NOT NULL,
  `size` text NOT NULL,
  `addDate` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` varchar(55) NOT NULL,
  `clientInfo` text NOT NULL,
  `addressInfo` text NOT NULL,
  `quoteInfo` text NOT NULL,
  `priceInfo` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `creatorId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `assigned` int(11) NOT NULL,
  `text` text NOT NULL,
  `user` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `website` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `subscriptionDate` date NOT NULL,
  `lastLoginDate` date NOT NULL,
  `nickName` varchar(50) NOT NULL,
  `isConfirmed` int(11) NOT NULL DEFAULT '0',
  `creator_com` int(11) NOT NULL DEFAULT '10',
  `infos` text NOT NULL,
  `firstConnection` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `websites`
--

CREATE TABLE IF NOT EXISTS `websites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `url` varchar(50) CHARACTER SET latin1 NOT NULL,
  `type` int(11) NOT NULL,
  `apiKey` varchar(255) CHARACTER SET latin1 NOT NULL,
  `apiSecret` varchar(255) CHARACTER SET latin1 NOT NULL,
  `loginFtp` varchar(50) NOT NULL,
  `passFtp` varchar(50) NOT NULL,
  `baseUrl` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
