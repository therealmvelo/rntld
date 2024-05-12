SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Create a table for cities
CREATE TABLE IF NOT EXISTS `city` (
  `CityID` int NOT NULL AUTO_INCREMENT,
  `CityName` varchar(100) NOT NULL,
  `CityImage` varchar(255) NOT NULL,
  PRIMARY KEY (`CityID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create a table for suburbs
CREATE TABLE IF NOT EXISTS `suburb` (
  `SuburbID` INT NOT NULL AUTO_INCREMENT,
  `SuburbName` varchar(80) NOT NULL,
  `CityID` int NOT NULL,
  PRIMARY KEY (`SuburbID`),
  FOREIGN KEY (`CityID`) REFERENCES `city` (`CityID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create a table for landlords
CREATE TABLE IF NOT EXISTS `landlord` (
  `LandlordID` int NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(25) NOT NULL,
  `Email` varchar(50) UNIQUE NOT NULL,
  `Phone` varchar(10) UNIQUE NOT NULL,
  `Password` varchar(255) NOT NULL, -- Store hashed passwords securely
  `ProfileImage` varchar(255) NOT NULL,
  PRIMARY KEY (`LandlordID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create a table for students
CREATE TABLE IF NOT EXISTS `student` (
  `StudentID` int NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(25) NOT NULL,
  `Email` varchar(50) UNIQUE NOT NULL,
  `Phone` varchar(10) UNIQUE NOT NULL,
  `Password` varchar(255) NOT NULL, -- Store hashed passwords securely
  `ProfileImage` varchar(255) NOT NULL,
  PRIMARY KEY (`StudentID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create a table for amenities
CREATE TABLE IF NOT EXISTS `amenities` (
  `AmenitiesID` int NOT NULL AUTO_INCREMENT,
  `PropertyID` int NOT NULL,
  `WiFi` BIT(1) DEFAULT b'0',
  `Bed` BIT(1) NOT NULL DEFAULT b'0',
  `TV` BIT(1) NOT NULL DEFAULT b'0',
  `Electricity` BIT(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`AmenitiesID`),
  FOREIGN KEY (`PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create a table for properties
CREATE TABLE IF NOT EXISTS `property` (
  `PropertyID` int NOT NULL AUTO_INCREMENT,
  `Title` varchar(80) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `Rules` varchar(250) NOT NULL,
  `NumberOfRooms` int NOT NULL,
  `Price` int NOT NULL,
  `FK_SuburbID` int NOT NULL,
  `Street` varchar(100) NOT NULL,
  `HouseNumber` int NOT NULL,
  `NearestCampus` varchar(150) NOT NULL,
  `FrontViewImage` varchar(255) NOT NULL,
  `SideViewImage` varchar(255) NOT NULL,
  `InsideImage1` varchar(255) NOT NULL,
  `InsideImage2` varchar(255) NOT NULL,
  `FenceImage` varchar(255) NOT NULL,
  `AdditionalImage` varchar(255) NOT NULL,
  `IsFeatured` BIT(1) NOT NULL DEFAULT b'0',
  `DatePosted` datetime DEFAULT CURRENT_TIMESTAMP,
  `FK_LandlordID` int NOT NULL,
  `ViewCount` int DEFAULT NULL,
  PRIMARY KEY (`PropertyID`),
  FOREIGN KEY (`FK_SuburbID`) REFERENCES `suburb` (`SuburbID`),
  FOREIGN KEY (`FK_LandlordID`) REFERENCES `landlord` (`LandlordID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create a table for bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `BookingID` int NOT NULL AUTO_INCREMENT,
  `PropertyID` int NOT NULL,
  `StudentID` int NOT NULL,
  PRIMARY KEY (`BookingID`),
  FOREIGN KEY (`PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

COMMIT;
