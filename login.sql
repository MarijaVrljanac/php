-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2021 at 11:44 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `userId` int(11) NOT NULL,
  `imePrezime` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `lozinka` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`userId`, `imePrezime`, `email`, `lozinka`) VALUES
(6, 'Marija', 'marija@gmail.com', '2e33a9b0b06aa0a01ede70995674ee23'),
(7, 'Marija Vrljanac', 'mv20180047@student.fon.bg.ac.rs', 'e3afed0047b08059d0fada10f400c1e5'),
(8, 'Admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `kozmeticari`
--

CREATE TABLE `kozmeticari` (
  `kozmeticarID` int(11) NOT NULL,
  `imePrezimeKozmeticara` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tretmanID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kozmeticari`
--

INSERT INTO `kozmeticari` (`kozmeticarID`, `imePrezimeKozmeticara`, `email`, `tretmanID`) VALUES
(10, 'Stefan Simic', 'stefan@blossombeauty.com', 2),
(11, 'Sara Savic', 'sara@blossombeauty.com', 1),
(12, 'Ksenija Jovic', 'ksenija@blossombeauty.com', 1),
(14, 'Jovana Obradovic', 'jovana@blossombeauty.com', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tretmani`
--

CREATE TABLE `tretmani` (
  `tretmanID` int(11) NOT NULL,
  `nazivTretmana` varchar(255) NOT NULL,
  `adresaLokala` varchar(255) NOT NULL,
  `kozmeticar` int(11) NOT NULL,
  `datumIVreme` datetime NOT NULL DEFAULT current_timestamp(),
  `cena` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tretmani`
--

INSERT INTO `tretmani` (`tretmanID`, `nazivTretmana`, `adresaLokala`, `kozmeticar`, `datumIVreme`, `cena`) VALUES
(1, 'Manikir i pedikir\r\n', 'Pozeska 26\r\n', 11, '2021-12-29 12:00:00', 2500),
(2, 'Tretman lica\r\n', 'Francuska 12', 10, '2021-12-25 09:30:00', 3000),
(3, 'Masaza\r\n', 'Pozeska 26', 14, '2021-12-16 16:15:00', 2000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `kozmeticari`
--
ALTER TABLE `kozmeticari`
  ADD PRIMARY KEY (`kozmeticarID`),
  ADD KEY `tretmanID` (`tretmanID`);

--
-- Indexes for table `tretmani`
--
ALTER TABLE `tretmani`
  ADD PRIMARY KEY (`tretmanID`),
  ADD KEY `kozmeticar` (`kozmeticar`),
  ADD KEY `kozmeticar_2` (`kozmeticar`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kozmeticari`
--
ALTER TABLE `kozmeticari`
  MODIFY `kozmeticarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tretmani`
--
ALTER TABLE `tretmani`
  MODIFY `tretmanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tretmani`
--
ALTER TABLE `tretmani`
  ADD CONSTRAINT `tretmani_ibfk_1` FOREIGN KEY (`kozmeticar`) REFERENCES `kozmeticari` (`kozmeticarID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
