SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS `amenities` (
  `AmenitiesID` int NOT NULL AUTO_INCREMENT,
  `FK_PropertyID` int DEFAULT NULL,
  `WiFi` BIT(1) DEFAULT b'0',
  `Bed` BIT(1) NOT NULL DEFAULT b'0',
  `TV` BIT(1) NOT NULL DEFAULT b'0',
  `Electricity` BIT(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`AmenitiesID`),
  FOREIGN KEY (`FK_PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `booking` (
  `BookingID` int NOT NULL AUTO_INCREMENT,
  `FK_PropertyID` int NOT NULL,
  `FK_StudentID` int NOT NULL,
  PRIMARY KEY (`BookingID`),
  FOREIGN KEY (`FK_PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`FK_StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `city` (
  `CityID` int NOT NULL AUTO_INCREMENT,
  `CityName` varchar(100) NOT NULL,
  `CityImage` varchar(255) NOT NULL,
  PRIMARY KEY (`CityID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `landlord` (
  `LandlordID` int NOT NULL AUTO_INCREMENT,
  `lndName` varchar(20) NOT NULL,
  `lndSurname` varchar(25) NOT NULL,
  `lndEmail` varchar(50) UNIQUE NOT NULL,
  `lndPhone` varchar(10) UNIQUE NOT NULL,
  `lndPassword` varchar(25) NOT NULL,
  `lndProfileImage` varchar(255) NOT NULL,
  PRIMARY KEY (`LandlordID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


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
  `isFeatured` BIT(1) NOT NULL DEFAULT b'0',
  `datePosted` datetime DEFAULT CURRENT_TIMESTAMP,
  `FK_CityID` int NOT NULL,
  `FK_LandlordID` int NOT NULL,
  `ViewCount` int DEFAULT NULL,
  PRIMARY KEY (`PropertyID`),
  FOREIGN KEY (`FK_CityID`) REFERENCES `city` (`CityID`),
  FOREIGN KEY (`FK_LandlordID`) REFERENCES `landlord` (`LandlordID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `student` (
  `StudentID` int NOT NULL AUTO_INCREMENT,
  `stdName` varchar(20) NOT NULL,
  `stdSurname` varchar(25)  NOT NULL,
  `stdEmail` varchar(50) UNIQUE NOT NULL,
  `stdPhone` varchar(10) UNIQUE NOT NULL,
  `stdPassword` varchar(25) NOT NULL,
  `stdProfileImage` varchar(255) NOT NULL,
  PRIMARY KEY (`StudentID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `suburb` (
  `SuburbID` INT NOT NULL AUTO_INCREMENT,
  `SuburbName` varchar(80) NOT NULL,
  `CityID` int NOT NULL,
  PRIMARY KEY (`SuburbID`),
  FOREIGN KEY (`CityID`) REFERENCES `city` (`CityID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
