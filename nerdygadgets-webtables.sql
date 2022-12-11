-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2022 at 05:06 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nerdygadgets`
--
CREATE DATABASE IF NOT EXISTS `nerdygadgets` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `nerdygadgets`;

-- --------------------------------------------------------

--
-- Table structure for table `weborderlines`
--

CREATE TABLE `weborderlines` (
  `OrderLineID` int(11) NOT NULL,
  `WebOrderID` int(11) NOT NULL,
  `StockItemID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weborderlines`
--

INSERT INTO `weborderlines` (`OrderLineID`, `WebOrderID`, `StockItemID`, `Quantity`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `webshopklant`
--

CREATE TABLE `webshopklant` (
  `WebCustomerID` int(11) NOT NULL,
  `CustomerName` varchar(45) NOT NULL,
  `CustomerCountry` varchar(45) NOT NULL,
  `CustomerAddress` varchar(45) NOT NULL,
  `CustomerPostalcode` varchar(12) NOT NULL,
  `CustomerTelNr` varchar(20) NOT NULL,
  `CustomerEmail` varchar(45) DEFAULT NULL,
  `CustomerPassword` varchar(45) DEFAULT NULL,
  `isloggable` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webshopklant`
--

INSERT INTO `webshopklant` (`WebCustomerID`, `CustomerName`, `CustomerCountry`, `CustomerAddress`, `CustomerPostalcode`, `CustomerTelNr`, `CustomerEmail`, `CustomerPassword`, `isloggable`) VALUES
(1, '1', '1', '1', '1', '1', '1', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `webshoporders`
--

CREATE TABLE `webshoporders` (
  `WebOrderID` int(11) NOT NULL,
  `WebCustomerID` int(11) NOT NULL,
  `OrderDate` date NOT NULL,
  `OrderIsBusiness` tinyint(4) NOT NULL,
  `WebOrderCountry` varchar(45) NOT NULL,
  `WebOrderAddress` varchar(45) NOT NULL,
  `WebOrderPostalcode` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webshoporders`
--

INSERT INTO `webshoporders` (`WebOrderID`, `WebCustomerID`, `OrderDate`, `OrderIsBusiness`, `WebOrderCountry`, `WebOrderAddress`, `WebOrderPostalcode`) VALUES
(1, 1, '0000-00-00', 1, '1', '1', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `webshopklant`
--
ALTER TABLE `webshopklant`
  ADD PRIMARY KEY (`WebCustomerID`);

--
-- Indexes for table `webshoporders`
--
ALTER TABLE `webshoporders`
  ADD PRIMARY KEY (`WebOrderID`),
  ADD KEY `fk_WebshopOrders_WebshopKlant_idx` (`WebCustomerID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `webshoporders`
--
ALTER TABLE `webshoporders`
  ADD CONSTRAINT `fk_WebshopOrders_WebshopKlant` FOREIGN KEY (`WebCustomerID`) REFERENCES `webshopklant` (`WebCustomerID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
