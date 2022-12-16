-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 16 dec 2022 om 10:02
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.6

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

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `weborderlines`
--

CREATE TABLE `weborderlines` (
  `OrderLineID` int(11) NOT NULL,
  `WebOrderID` int(11) NOT NULL,
  `StockItemID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `weborderlines`
--

INSERT INTO `weborderlines` (`OrderLineID`, `WebOrderID`, `StockItemID`, `Quantity`) VALUES
(1, 1, 76, 1),
(2, 2, 76, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `webshopklant`
--

CREATE TABLE `webshopklant` (
  `WebCustomerID` int(11) NOT NULL,
  `CustomerName` varchar(45) NOT NULL,
  `CustomerCountry` varchar(45) NOT NULL,
  `CustomerCity` varchar(85) NOT NULL,
  `CustomerAddress` varchar(45) NOT NULL,
  `CustomerPostalcode` varchar(12) NOT NULL,
  `CustomerTelNr` varchar(20) NOT NULL,
  `CustomerEmail` varchar(45) NOT NULL,
  `CustomerPassword` varchar(45) DEFAULT NULL,
  `isloggable` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `webshopklant`
--

INSERT INTO `webshopklant` (`WebCustomerID`, `CustomerName`, `CustomerCountry`, `CustomerCity`, `CustomerAddress`, `CustomerPostalcode`, `CustomerTelNr`, `CustomerEmail`, `CustomerPassword`, `isloggable`) VALUES
(1, 'wa', 'NAN', 'wa', 'laan1', '1234AB', '+31-0612345678', 'wa@gmail.com', '0', 0),
(2, 'woah', 'NLD', 'woo', 'Bloemlaan 5', '2932CE', '+31-0612345678', 'cool@gmail.com', 'woah123', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `webshoporders`
--

CREATE TABLE `webshoporders` (
  `WebOrderID` int(11) NOT NULL,
  `WebCustomerID` int(11) NOT NULL,
  `OrderDate` date NOT NULL,
  `OrderIsBusiness` tinyint(4) NOT NULL,
  `WebOrderCountry` varchar(45) NOT NULL,
  `WebOrderCity` varchar(85) NOT NULL,
  `WebOrderAddress` varchar(45) NOT NULL,
  `WebOrderPostalcode` varchar(12) NOT NULL,
  `WebOrderBusiness` varchar(60) DEFAULT NULL,
  `OrderTotalPrice` double(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `webshoporders`
--

INSERT INTO `webshoporders` (`WebOrderID`, `WebCustomerID`, `OrderDate`, `OrderIsBusiness`, `WebOrderCountry`, `WebOrderCity`, `WebOrderAddress`, `WebOrderPostalcode`, `WebOrderBusiness`, `OrderTotalPrice`) VALUES
(1, 1, '2022-12-16', 0, 'NAN', 'wa', 'laan1', '1234AB', '', 30.95),
(2, 2, '2022-12-16', 0, 'NLD', 'woo', 'Bloemlaan 5', '2932CE', '', 30.95);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `weborderlines`
--
ALTER TABLE `weborderlines`
  ADD PRIMARY KEY (`OrderLineID`,`WebOrderID`),
  ADD KEY `fk_weborderlines_webshoporders1_idx` (`WebOrderID`);

--
-- Indexen voor tabel `webshopklant`
--
ALTER TABLE `webshopklant`
  ADD PRIMARY KEY (`WebCustomerID`);

--
-- Indexen voor tabel `webshoporders`
--
ALTER TABLE `webshoporders`
  ADD PRIMARY KEY (`WebOrderID`),
  ADD KEY `fk_WebshopOrders_WebshopKlant_idx` (`WebCustomerID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `weborderlines`
--
ALTER TABLE `weborderlines`
  MODIFY `OrderLineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `webshopklant`
--
ALTER TABLE `webshopklant`
  MODIFY `WebCustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `webshoporders`
--
ALTER TABLE `webshoporders`
  MODIFY `WebOrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `weborderlines`
--
ALTER TABLE `weborderlines`
  ADD CONSTRAINT `fk_weborderlines_webshoporders1` FOREIGN KEY (`WebOrderID`) REFERENCES `webshoporders` (`WebOrderID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `webshoporders`
--
ALTER TABLE `webshoporders`
  ADD CONSTRAINT `fk_WebshopOrders_WebshopKlant` FOREIGN KEY (`WebCustomerID`) REFERENCES `webshopklant` (`WebCustomerID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
