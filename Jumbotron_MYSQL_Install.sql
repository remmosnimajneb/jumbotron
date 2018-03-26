--
-- Database: `jumbotron`
--
CREATE DATABASE IF NOT EXISTS `jumbotron` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `jumbotron`;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
CREATE TABLE IF NOT EXISTS `content` (
  `ContentID` int(9) NOT NULL AUTO_INCREMENT,
  `ContentType` varchar(40) NOT NULL,
  `Content` varchar(240) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  PRIMARY KEY (`ContentID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`ContentID`, `ContentType`, `Content`, `StartDate`, `EndDate`) VALUES
(1, 'announcement', 'Welcome to Example Company!', '2000-01-01', '2999-01-01'),
(2, 'slideshow', 'Stock_Image_1.jpg', '2000-01-01', '2999-01-01'),
(3, 'slideshow', 'Stock_Image_2.jpg', '2000-01-01', '2999-01-01'),
COMMIT;