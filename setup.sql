CREATE DATABASE josephmart;
USE josephmart;

-- --------------------------------------------------------
--
-- Table structure for table `ParkingLot`
--
CREATE TABLE `ParkingLot` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `Vehicle`
--

CREATE TABLE `Vehicle` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `entering` tinyint(1) NOT NULL DEFAULT 0,
  `lot_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lot_id` (`lot_id`),
  FOREIGN KEY (`lot_id`) REFERENCES `ParkingLot`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------
