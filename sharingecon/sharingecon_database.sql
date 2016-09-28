-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 28. Sep 2016 um 14:24
-- Server-Version: 10.0.27-MariaDB-0ubuntu0.16.04.1
-- PHP-Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `hz_sharecon`
--
CREATE DATABASE IF NOT EXISTS `hz_sharecon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `hz_sharecon`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `enquiries`
--

CREATE TABLE `enquiries` (
  `ID` int(11) NOT NULL,
  `ObjectID` int(11) NOT NULL,
  `CustomerID` char(255) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `favorites`
--

CREATE TABLE `favorites` (
  `ID` int(11) NOT NULL,
  `ChannelID` char(255) NOT NULL,
  `ObjectID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `locations`
--

CREATE TABLE `locations` (
  `ID` int(11) NOT NULL,
  `ChannelID` char(255) NOT NULL,
  `Address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sharedObjects`
--

CREATE TABLE `sharedObjects` (
  `ID` int(11) NOT NULL,
  `Title` char(255) NOT NULL,
  `Description` text NOT NULL,
  `OwnerID` char(255) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `Imagename` tinytext NOT NULL,
  `Type` tinyint(4) NOT NULL,
  `Visibility` tinyint(4) NOT NULL,
  `Location` tinytext NOT NULL,
  `Tags` text NOT NULL,
  `TagBranch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tagBranches`
--

CREATE TABLE `tagBranches` (
  `ID` int(11) NOT NULL,
  `Parent` int(11) DEFAULT NULL,
  `Title` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tags`
--

CREATE TABLE `tags` (
  `ID` int(11) NOT NULL,
  `BranchID` int(11) NOT NULL,
  `Tag` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transactions`
--

CREATE TABLE `transactions` (
  `ID` int(11) NOT NULL,
  `ObjectID` int(11) NOT NULL,
  `CustomerID` char(255) NOT NULL,
  `Rating` tinyint(4) DEFAULT NULL,
  `LendingStart` date NOT NULL,
  `LendingEnd` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `visibilityRange`
--

CREATE TABLE `visibilityRange` (
  `ID` int(11) NOT NULL,
  `ObjectID` int(11) NOT NULL,
  `VisibleFor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `sharedObjects`
--
ALTER TABLE `sharedObjects`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `tagBranches`
--
ALTER TABLE `tagBranches`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `visibilityRange`
--
ALTER TABLE `visibilityRange`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `favorites`
--
ALTER TABLE `favorites`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT für Tabelle `locations`
--
ALTER TABLE `locations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `sharedObjects`
--
ALTER TABLE `sharedObjects`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT für Tabelle `tagBranches`
--
ALTER TABLE `tagBranches`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `tags`
--
ALTER TABLE `tags`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `transactions`
--
ALTER TABLE `transactions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT für Tabelle `visibilityRange`
--
ALTER TABLE `visibilityRange`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
