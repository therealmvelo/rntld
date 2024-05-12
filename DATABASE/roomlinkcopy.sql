-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 30, 2023 at 09:00 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Table structure for table `amenities`
DROP TABLE IF EXISTS `amenities`;
CREATE TABLE IF NOT EXISTS `amenities` (
  `AmenitiesID` int NOT NULL AUTO_INCREMENT,
  `PropertyID` int DEFAULT NULL,
  `Amenity` varchar(25) NOT NULL,
  PRIMARY KEY (`AmenitiesID`),
  KEY `PropertyID` (`PropertyID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
--
-- Table structure for table `bookings`
--
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `BookingID` int NOT NULL AUTO_INCREMENT,
  `LandlordID` int DEFAULT NULL,
  `StudentID` int DEFAULT NULL,
  `PropertyID` int DEFAULT NULL,
  PRIMARY KEY (`BookingID`),
  KEY `LandlordID` (`LandlordID`),
  KEY `StudentID` (`StudentID`),
  KEY `PropertyID` (`PropertyID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--
INSERT INTO `bookings` (`BookingID`, `LandlordID`, `StudentID`, `PropertyID`) VALUES
(1, 1, 2, 1),
(2, 2, 3, 2),
(3, 3, 4, 3),
(4, 4, 1, 4);

--
-- Table structure for table `city`
CREATE TABLE `city` (
  `CityID` int NOT NULL AUTO_INCREMENT,
  `CityName` varchar(100) NOT NULL,
  `CityImage` varbinary(400) DEFAULT NULL,
  PRIMARY KEY (`CityID`),
  KEY `idx_CityName_Country` (`CityName`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`CityID`, `CityName`, `CityImage`) VALUES
(1, 'Cityville', NULL),
(2, 'Downtown City', NULL),
(3, 'Metroville', NULL),
(4, 'Cityscape', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `landlord`
CREATE TABLE `landlord` (
  `LandlordID` int NOT NULL AUTO_INCREMENT,
  `lndName` varchar(20) NOT NULL,
  `lndSurname` varchar(25) NOT NULL,
  `lndEmail` varchar(50) NOT NULL,
  `lndPhone` varchar(10) NOT NULL,
  `lndPassword` varchar(25) NOT NULL,
  `lndCategory` varchar(5) NOT NULL,
  `lndProfileImage` varbinary(300) NOT NULL,
  `CityID` int DEFAULT NULL,
  PRIMARY KEY (`LandlordID`),
  KEY `idx_Landlord_CityID` (`CityID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `landlord`
--

INSERT INTO `landlord` (`LandlordID`, `lndName`, `lndSurname`, `lndEmail`, `lndPhone`, `lndPassword`, `lndCategory`, `lndProfileImage`, `CityID`) VALUES
(1, 'Mark', 'Johnson', 'mark.johnson@example.com', '123-456-78', 'hashed_password_5', 'Landl', 0x70726f66696c655f696d6167655f646174615f35, 1),
(2, 'Emily', 'Williams', 'emily.williams@example.com', '987-654-32', 'hashed_password_6', 'Landl', 0x70726f66696c655f696d6167655f646174615f36, 2),
(3, 'David', 'Smith', 'david.smith@example.com', '555-666-77', 'hashed_password_7', 'Landl', 0x70726f66696c655f696d6167655f646174615f37, 3),
(4, 'Sophie', 'Doe', 'sophie.doe@example.com', '111-222-33', 'hashed_password_8', 'Landl', 0x70726f66696c655f696d6167655f646174615f38, 4),
(5, 'Oliver', 'Taylor', 'oliver.taylor@example.com', '777-888-99', 'hashed_password_11', 'Landl', 0x70726f66696c655f696d6167655f646174615f3131, NULL),
(6, 'Grace', 'Baker', 'grace.baker@example.com', '222-333-44', 'hashed_password_12', 'Landl', 0x70726f66696c655f696d6167655f646174615f3132, NULL),
(8, 'Mvelo', 'Mthembu', 'me.mvelo@example.com', '1234567890', 'hashed_password_5', 'Landl', 0x70726f66696c655f696d6167655f646174615f35, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property`
CREATE TABLE `property` (
  `PropertyID` int NOT NULL AUTO_INCREMENT,
  `PropertyTitle` varchar(80) NOT NULL,
  `PropertyDescription` varchar(200) NOT NULL,
  `PropertyRules` varchar(250) NOT NULL,
  `NumberofRooms` int NOT NULL,
  `Price` int NOT NULL,
  `City` varchar(100) NOT NULL,
  `Suburb` varchar(50) NOT NULL,
  `Street` varchar(100) NOT NULL,
  `HouseNumber` int NOT NULL,
  `NearestCampus` varchar(150) NOT NULL,
  `imgFrontView` varbinary(400) NOT NULL,
  `imgSideView` varbinary(400) NOT NULL,
  `imgInside1` varbinary(400) NOT NULL,
  `imgInside2` varbinary(400) NOT NULL,
  `imgFence` varbinary(400) NOT NULL,
  `imgAdditional` varbinary(400) NOT NULL,
  `isFeatured` varchar(3) DEFAULT NULL,
  `datePosted` datetime DEFAULT CURRENT_TIMESTAMP,
  `CityID` int DEFAULT NULL,
  PRIMARY KEY (`PropertyID`),
  KEY `idx_CityID` (`CityID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`PropertyID`, `PropertyTitle`, `PropertyDescription`, `PropertyRules`, `NumberofRooms`, `Price`, `City`, `Suburb`, `Street`, `HouseNumber`, `NearestCampus`, `imgFrontView`, `imgSideView`, `imgInside1`, `imgInside2`, `imgFence`, `imgAdditional`, `isFeatured`, `datePosted`, `CityID`) VALUES
(1, 'Cozy Apartment near Campus', 'A comfortable apartment with great amenities.', 'No pets allowed. Quiet hours after 10 PM.', 2, 1200, 'Cityville', 'SuburbA', 'Oak Street', 123, 'University of Cityville', 0x66726f6e745f766965775f696d6167655f64617461, 0x736964655f766965775f696d6167655f64617461, 0x696e73696465315f696d6167655f64617461, 0x696e73696465325f696d6167655f64617461, 0x66656e63655f696d6167655f64617461, 0x6164646974696f6e616c5f696d6167655f64617461, 'Yes', '2023-12-29 11:31:35', 1),
(2, 'Modern Studio Apartment', 'Modern studio with a view of the city.', 'No smoking allowed. Utilities included.', 1, 800, 'Downtown City', 'Central District', 'Main Avenue', 456, 'Downtown University', 0x66726f6e745f766965775f696d6167655f64617461, 0x736964655f766965775f696d6167655f64617461, 0x696e73696465315f696d6167655f64617461, 0x696e73696465325f696d6167655f64617461, 0x66656e63655f696d6167655f64617461, 0x6164646974696f6e616c5f696d6167655f64617461, 'No', '2023-12-29 11:31:35', 2),
(3, 'Spacious House for Students', 'Large house with multiple bedrooms and common areas.', 'Pets allowed with restrictions. Shared responsibilities for maintenance.', 5, 2500, 'Metroville', 'Student District', 'Maple Lane', 789, 'Metro University', 0x66726f6e745f766965775f696d6167655f64617461, 0x736964655f766965775f696d6167655f64617461, 0x696e73696465315f696d6167655f64617461, 0x696e73696465325f696d6167655f64617461, 0x66656e63655f696d6167655f64617461, 0x6164646974696f6e616c5f696d6167655f64617461, 'Yes', '2023-12-29 11:31:35', 3),
(4, 'City View Penthouse', 'Luxurious penthouse with stunning city views.', 'No parties allowed. Security deposit required.', 3, 3500, 'Cityscape', 'Skyline Heights', 'High Street', 101, 'Cityscape University', 0x66726f6e745f766965775f696d6167655f64617461, 0x736964655f766965775f696d6167655f64617461, 0x696e73696465315f696d6167655f64617461, 0x696e73696465325f696d6167655f64617461, 0x66656e63655f696d6167655f64617461, 0x6164646974696f6e616c5f696d6167655f64617461, 'Yes', '2023-12-29 11:31:35', 4);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--
CREATE TABLE `student` (
  `StudentID` int NOT NULL AUTO_INCREMENT,
  `stdName` varchar(20) NOT NULL,
  `stdSurname` varchar(25) NOT NULL,
  `stdEmail` varchar(50) NOT NULL,
  `stdPhone` varchar(10) NOT NULL,
  `stdPassword` varchar(25) NOT NULL,
  `stdCategory` varchar(5) NOT NULL,
  `stdProfileImage` varbinary(300) NOT NULL,
  PRIMARY KEY (`StudentID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`StudentID`, `stdName`, `stdSurname`, `stdEmail`, `stdPhone`, `stdPassword`, `stdCategory`, `stdProfileImage`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', '1234567890', 'hashed_password_1', 'Stude', 0x70726f66696c655f696d6167655f646174615f31),
(2, 'Jane', 'Smith', 'jane.smith@example.com', '9876543210', 'hashed_password_2', 'Stude', 0x70726f66696c655f696d6167655f646174615f32),
(3, 'Bob', 'Johnson', 'bob.johnson@example.com', '5556667777', 'hashed_password_3', 'Stude', 0x70726f66696c655f696d6167655f646174615f33),
(4, 'Alice', 'Williams', 'alice.williams@example.com', '1112223333', 'hashed_password_4', 'Stude', 0x70726f66696c655f696d6167655f646174615f34),
(5, 'Eva', 'Martin', 'eva.martin@example.com', '4445556666', 'hashed_password_9', 'Stude', 0x70726f66696c655f696d6167655f646174615f39),
(6, 'Alex', 'Miller', 'alex.miller@example.com', '9998887777', 'hashed_password_10', 'Stude', 0x70726f66696c655f696d6167655f646174615f3130);

-- --------------------------------------------------------

--
-- Table structure for table `surburb`
CREATE TABLE `surburb` (
  `LandlordSuburbID` int NOT NULL AUTO_INCREMENT,
  `LandlordID` int DEFAULT NULL,
  `Suburb` varchar(50) DEFAULT NULL,
  `PropertyID` int DEFAULT NULL,
  PRIMARY KEY (`LandlordSuburbID`),
  KEY `PropertyID` (`PropertyID`),
  KEY `idx_LandlordID_Suburb` (`LandlordID`,`Suburb`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surburb`
--

INSERT INTO `surburb` (`LandlordSuburbID`, `LandlordID`, `Suburb`, `PropertyID`) VALUES
(1, 1, 'SuburbA', 1),
(2, 2, 'Central District', 2),
(3, 3, 'Student District', 3),
(4, 4, 'Skyline Heights', 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amenities`
--
ALTER TABLE `amenities`
  ADD CONSTRAINT `amenities_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `property` (`PropertyID`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`LandlordID`) REFERENCES `landlord` (`LandlordID`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`PropertyID`) REFERENCES `property` (`PropertyID`);

--
-- Constraints for table `landlord`
--
ALTER TABLE `landlord`
  ADD CONSTRAINT `landlord_ibfk_1` FOREIGN KEY (`CityID`) REFERENCES `city` (`CityID`);

--
-- Constraints for table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `property_ibfk_1` FOREIGN KEY (`CityID`) REFERENCES `city` (`CityID`);

--
-- Constraints for table `surburb`
--
ALTER TABLE `surburb`
  ADD CONSTRAINT `surburb_ibfk_1` FOREIGN KEY (`LandlordID`) REFERENCES `landlord` (`LandlordID`),
  ADD CONSTRAINT `surburb_ibfk_2` FOREIGN KEY (`PropertyID`) REFERENCES `property` (`PropertyID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
