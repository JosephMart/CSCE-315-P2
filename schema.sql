SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET GLOBAL time_zone = '-6:00';
SET GLOBAL time_zone = 'US/Central';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `josephmart`
--
CREATE DATABASE IF NOT EXISTS `josephmart` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `josephmart`;

-- --------------------------------------------------------

--
-- Table structure for table `ParkingLot`
--

CREATE TABLE `ParkingLot` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Vehicle`
--

CREATE TABLE `Vehicle` (
  `id` int(10) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `entering` tinyint(1) NOT NULL DEFAULT 0,
  `lot_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ParkingLot`
--
ALTER TABLE `ParkingLot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Vehicle`
--
ALTER TABLE `Vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lot_id` (`lot_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ParkingLot`
--
ALTER TABLE `ParkingLot`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Vehicle`
--
ALTER TABLE `Vehicle`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Vehicle`
--
ALTER TABLE `Vehicle`
  ADD CONSTRAINT `Vehicle_ibfk_1` FOREIGN KEY (`lot_id`) REFERENCES `ParkingLot` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Project 1 Legacy
--
CREATE DATABASE IF NOT EXISTS `legacy` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `legacy`;

CREATE TABLE `WalkingCounterDatabase` (
  `Count` int(11) NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Count`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=latin1;