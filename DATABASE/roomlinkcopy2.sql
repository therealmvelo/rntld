-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 23, 2024 at 08:11 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roomlinkcopy2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `adminID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `imgProfile` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  PRIMARY KEY (`adminID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `name`, `surname`, `email`, `password`, `imgProfile`, `token`) VALUES
(6, 'MVELO', 'MTHEMBU', '2020130474@students.elangeni.edu.za', '$2y$10$/K9OilYGpNSmTmzOr087R.7FUWHzX.0C0wfwoylFJA9KCiUnMdc8C', 'k.jpg.webp', '66152a0a5e4e7776a2c56369355c7c93854c71f98adfc2eaf66a817806b46e4a');

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

DROP TABLE IF EXISTS `amenities`;
CREATE TABLE IF NOT EXISTS `amenities` (
  `AmenitiesID` int NOT NULL AUTO_INCREMENT,
  `FK_PropertyID` int DEFAULT NULL,
  `WiFi` bit(1) DEFAULT b'0',
  `Bed` bit(1) NOT NULL DEFAULT b'0',
  `TV` bit(1) NOT NULL DEFAULT b'0',
  `Electricity` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`AmenitiesID`),
  KEY `FK_PropertyID` (`FK_PropertyID`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`AmenitiesID`, `FK_PropertyID`, `WiFi`, `Bed`, `TV`, `Electricity`) VALUES
(78, 103, b'0', b'1', b'0', b'0'),
(79, 104, b'0', b'0', b'0', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `BookingID` int NOT NULL AUTO_INCREMENT,
  `FK_PropertyID` int NOT NULL,
  `FK_StudentID` int NOT NULL,
  PRIMARY KEY (`BookingID`),
  UNIQUE KEY `unique_booking` (`FK_StudentID`,`FK_PropertyID`),
  KEY `FK_PropertyID` (`FK_PropertyID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_request`
--

DROP TABLE IF EXISTS `booking_request`;
CREATE TABLE IF NOT EXISTS `booking_request` (
  `RequestID` int NOT NULL AUTO_INCREMENT,
  `FK_StudentID` int NOT NULL,
  `FK_PropertyID` int NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Pending',
  `RequestDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `checkInDate` date NOT NULL,
  `checkOutDate` date NOT NULL,
  PRIMARY KEY (`RequestID`),
  KEY `FK_StudentID` (`FK_StudentID`),
  KEY `FK_PropertyID` (`FK_PropertyID`)
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `booking_request`
--

INSERT INTO `booking_request` (`RequestID`, `FK_StudentID`, `FK_PropertyID`, `Status`, `RequestDate`, `checkInDate`, `checkOutDate`) VALUES
(193, 84, 103, 'reject', '2024-04-21 20:03:45', '2024-04-26', '2024-06-06'),
(194, 84, 104, 'accept', '2024-04-22 04:16:05', '2024-04-18', '2024-04-12'),
(195, 84, 103, 'Pending', '2024-04-22 17:09:43', '2024-04-17', '2024-04-24');

-- --------------------------------------------------------

--
-- Table structure for table `campuses`
--

DROP TABLE IF EXISTS `campuses`;
CREATE TABLE IF NOT EXISTS `campuses` (
  `CampusID` int NOT NULL AUTO_INCREMENT,
  `CampusName` varchar(200) NOT NULL,
  `CampusImage` varchar(255) NOT NULL,
  `CLatitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `CLongitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`CampusID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `campuses`
--

INSERT INTO `campuses` (`CampusID`, `CampusName`, `CampusImage`, `CLatitude`, `CLongitude`) VALUES
(3, 'Elangeni TVET College - Kwamashu Campus', 'Municipal_Office_of_the_City_of_Matlosana_Local_Municipality.jpg', '-29.7425444931447', ' 30.990595569059455'),
(4, 'Elangeni TVET College - Ntuzuma Campus', 'RENTLAD_LOGO.png', '-29.72407938415557', '30.944100903304705');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `CityID` int NOT NULL AUTO_INCREMENT,
  `CityName` varchar(100) NOT NULL,
  `CityImage` varchar(255) NOT NULL,
  PRIMARY KEY (`CityID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`CityID`, `CityName`, `CityImage`) VALUES
(18, 'Uitenhage', 'ec.jpeg'),
(19, 'Durban', 'dbn.jpeg'),
(20, 'Johannesburg', 'jhb.jpeg'),
(21, 'Pretoria', '1024px-Krugerstandbeeld,_Kerkplein,_b,_Pretoria.jpg'),
(23, 'Klerksdorp', 'Municipal_Office_of_the_City_of_Matlosana_Local_Municipality.jpg'),
(24, 'Welkom', ''),
(25, 'Mbombela', ''),
(26, 'Vanderbijlpark', ''),
(27, 'Polokwane', ''),
(28, 'Cape Town', ''),
(29, 'Bloemfontein', '');

-- --------------------------------------------------------

--
-- Table structure for table `landlord`
--

DROP TABLE IF EXISTS `landlord`;
CREATE TABLE IF NOT EXISTS `landlord` (
  `LandlordID` int NOT NULL AUTO_INCREMENT,
  `lndName` varchar(20) NOT NULL,
  `lndSurname` varchar(25) NOT NULL,
  `lndEmail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lndPhone` varchar(10) NOT NULL,
  `lndPassword` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lndProfileImage` varchar(255) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `isVerified` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `vtoken_hash` varchar(64) DEFAULT NULL,
  `vtoken_hash_expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`LandlordID`),
  UNIQUE KEY `lndEmail` (`lndEmail`),
  UNIQUE KEY `lndPhone` (`lndPhone`),
  UNIQUE KEY `reset_token_hash` (`reset_token_hash`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `landlord`
--

INSERT INTO `landlord` (`LandlordID`, `lndName`, `lndSurname`, `lndEmail`, `lndPhone`, `lndPassword`, `lndProfileImage`, `reset_token_hash`, `reset_token_expires_at`, `isVerified`, `vtoken_hash`, `vtoken_hash_expires_at`) VALUES
(44, 'MVELO', 'MTHEMBU', 'mvelondumisomthembu@gmail.com', '0215848685', '$2y$10$ind6BF9DpkK31K6hf/9dJ.THtBYScQkSgpyLzly62gIMVpEOm.nre', 'k.jpg.webp', '066266ceefbf0f260e4afe5f976b5f562c9fcb8c1b2fbcc8196ca8a3f217db47', '2024-01-21 22:36:20', '', NULL, NULL),
(45, 'MVELO', 'MTHEMBU', 'mve@g.nko', '78777899', '$2y$10$P8hkp.oVzdzmVP98ez/xge1tOjeDaHWTOUSXNHBm5ntFHT39gqQn2', 'k.jpg.webp', '84d220dc34ce4d05856396cc7a1bfafb04fee1227a78cd8bfc010e5944d776d2', '2024-01-24 01:02:55', '', NULL, NULL),
(71, 'MVELO', 'MTHEMBU', 'x@gmail.com', '1101001101', '$2y$10$kkNtE4mrEZD4Fkxcmjv8AeJ7Sq1xTNrJtdWOcc/y54XuUiQcuE04e', 'IMG_20220729_111503.jpg', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

DROP TABLE IF EXISTS `property`;
CREATE TABLE IF NOT EXISTS `property` (
  `PropertyID` int NOT NULL AUTO_INCREMENT,
  `PropertyTitle` varchar(80) NOT NULL,
  `PropertyDescription` varchar(200) NOT NULL,
  `PropertyRules` varchar(250) NOT NULL,
  `NumberofRooms` int NOT NULL,
  `Price` int NOT NULL,
  `Suburb` varchar(50) NOT NULL,
  `Street` varchar(100) NOT NULL,
  `HouseNumber` int NOT NULL,
  `NearestCampus` varchar(150) NOT NULL,
  `imgFrontView` varchar(255) NOT NULL,
  `imgSideView` varchar(255) NOT NULL,
  `imgInside1` varchar(255) NOT NULL,
  `imgInside2` varchar(255) NOT NULL,
  `imgFence` varchar(255) NOT NULL,
  `imgAdditional` varchar(255) NOT NULL,
  `isFeatured` bit(1) NOT NULL DEFAULT b'0',
  `datePosted` datetime DEFAULT CURRENT_TIMESTAMP,
  `FK_CityID` int NOT NULL,
  `FK_LandlordID` int NOT NULL,
  `ViewCount` int DEFAULT '0',
  `Latitude` varchar(255) NOT NULL,
  `Longitude` varchar(255) NOT NULL,
  `FK_CampusID` int NOT NULL,
  PRIMARY KEY (`PropertyID`),
  KEY `FK_CityID` (`FK_CityID`),
  KEY `FK_LandlordID` (`FK_LandlordID`),
  KEY `FK_CampusID` (`FK_CampusID`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`PropertyID`, `PropertyTitle`, `PropertyDescription`, `PropertyRules`, `NumberofRooms`, `Price`, `Suburb`, `Street`, `HouseNumber`, `NearestCampus`, `imgFrontView`, `imgSideView`, `imgInside1`, `imgInside2`, `imgFence`, `imgAdditional`, `isFeatured`, `datePosted`, `FK_CityID`, `FK_LandlordID`, `ViewCount`, `Latitude`, `Longitude`, `FK_CampusID`) VALUES
(103, 'ty jtyj tjhytn  je7yt 7wj jni7w25t luh mkl8lcde l', 'yj kyj ekjyjtey67huq uhj q6yjy6 ky6edx ukklethg mukkuu k6rdt u', 'uyjk kuttttttt jkueduj wikj k75we ij 75ykew k 3kiy7kkm k edkmd kme mk6tkk,kl6k 6tkm l, lk6', 2, 1000, '57', 'Mpukane Road', 9, 'Elangeni TVET College - Kwamashu Campus', 'Municipal_Office_of_the_City_of_Matlosana_Local_Municipality.jpg', 'inside2.jpeg', 'logo.jpg', 'inside1.jpeg', 'property.jpeg', 'RENTLAD_LOGO.png', b'0', '2024-04-21 09:17:33', 20, 44, 72, '-29.73037993171121', '30.970841728854793', 3),
(104, 'ty jtyj tjhytn  je7yt 7wj jni7w25t luh mkl8lcde l', 'ty jtyj tjhytn  je7yt 7wj jni7w25t luh mkl8lcde l ty jtyj tjhytn  je7yt 7wj jni7w25t luh mkl8lcde l', 'ty jtyj tjhytn ty jtyj tjhytn  je7yt 7wj jni7w25t luh mkl8lcde l je7yt 7wj jni7w25t luh mkl8lcde l', 1, 300, '57', 'Impinda Way', 9, 'Elangeni TVET College - Kwamashu Campus', 'fence.jpeg', '1024px-Krugerstandbeeld,_Kerkplein,_b,_Pretoria.jpg', 'sideview.jpeg', 'additional.jpeg', 'sideview.jpeg', 'inside2.jpeg', b'0', '2024-04-21 10:16:58', 20, 44, 22, '-29.717634033597133', '30.96693915379764', 3);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `StudentID` int NOT NULL AUTO_INCREMENT,
  `stdName` varchar(20) NOT NULL,
  `stdSurname` varchar(25) NOT NULL,
  `stdEmail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stdPhone` varchar(10) NOT NULL,
  `stdPassword` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stdProfileImage` varchar(255) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `isVerified` varchar(3) DEFAULT NULL,
  `vtoken_hash` varchar(64) DEFAULT NULL,
  `vtoken_hash_expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`StudentID`),
  UNIQUE KEY `stdEmail` (`stdEmail`),
  UNIQUE KEY `stdPhone` (`stdPhone`),
  UNIQUE KEY `reset_token_hash` (`reset_token_hash`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`StudentID`, `stdName`, `stdSurname`, `stdEmail`, `stdPhone`, `stdPassword`, `stdProfileImage`, `reset_token_hash`, `reset_token_expires_at`, `isVerified`, `vtoken_hash`, `vtoken_hash_expires_at`) VALUES
(84, 'MVELO', 'MTHEMBU', 'me.voidcache@gmail.com', '78777899', '$2y$10$16QPvseIsfwQ0ieE3iIW2eulfSolwiWrEXpgCmA5Uymo90MP/RSUO', 'ec.jpeg', NULL, NULL, NULL, '09781edae6b54cb2768397b4342bfe99c2a630c0e209d693603c87fd169ffe02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suburb`
--

DROP TABLE IF EXISTS `suburb`;
CREATE TABLE IF NOT EXISTS `suburb` (
  `SuburbID` int NOT NULL AUTO_INCREMENT,
  `SuburbName` varchar(80) NOT NULL,
  `CityID` int NOT NULL,
  PRIMARY KEY (`SuburbID`),
  KEY `CityID` (`CityID`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `suburb`
--

INSERT INTO `suburb` (`SuburbID`, `SuburbName`, `CityID`) VALUES
(50, 'kh ku', 19),
(51, 'gnn', 24),
(52, 'gnn', 25),
(53, 'gnn', 26),
(54, 'gnn', 27),
(55, 'gnn', 28),
(56, 'gnn', 29),
(57, 'gnn', 20);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amenities`
--
ALTER TABLE `amenities`
  ADD CONSTRAINT `amenities_ibfk_1` FOREIGN KEY (`FK_PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`FK_PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`FK_StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking_request`
--
ALTER TABLE `booking_request`
  ADD CONSTRAINT `booking_request_ibfk_1` FOREIGN KEY (`FK_StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_request_ibfk_2` FOREIGN KEY (`FK_PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `FK_CampusID` FOREIGN KEY (`FK_CampusID`) REFERENCES `campuses` (`CampusID`),
  ADD CONSTRAINT `property_ibfk_1` FOREIGN KEY (`FK_CityID`) REFERENCES `city` (`CityID`),
  ADD CONSTRAINT `property_ibfk_2` FOREIGN KEY (`FK_LandlordID`) REFERENCES `landlord` (`LandlordID`);

--
-- Constraints for table `suburb`
--
ALTER TABLE `suburb`
  ADD CONSTRAINT `suburb_ibfk_1` FOREIGN KEY (`CityID`) REFERENCES `city` (`CityID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
