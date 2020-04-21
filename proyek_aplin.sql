-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2020 at 08:41 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyek_aplin`
--

-- --------------------------------------------------------

--
-- Table structure for table `htrans`
--

DROP TABLE IF EXISTS `htrans`;
CREATE TABLE `htrans` (
  `ROW_ID_HTRANS` int(11) NOT NULL,
  `ROW_ID_CUSTOMER` int(11) NOT NULL,
  `TANGGAL_TRANS` datetime NOT NULL,
  `NO_NOTA` varchar(15) DEFAULT NULL,
  `TOTAL_TRANS` int(11) DEFAULT 0,
  `STATUS_PEMBAYARAN` int(11) NOT NULL COMMENT '0=Pending,  1= Accepted,  2=Rejected',
  `LOKASI_FOTO_BUKTI_PEMBAYARAN` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `htrans`
--

INSERT INTO `htrans` (`ROW_ID_HTRANS`, `ROW_ID_CUSTOMER`, `TANGGAL_TRANS`, `NO_NOTA`, `TOTAL_TRANS`, `STATUS_PEMBAYARAN`, `LOKASI_FOTO_BUKTI_PEMBAYARAN`) VALUES
(1, 1, '2020-02-20 02:33:56', '2020022000001', 5604815, 2, '1.jpg'),
(2, 1, '2020-03-18 02:35:55', '2020031800001', 0, 1, '2.jpg'),
(3, 1, '2020-04-14 02:36:31', '2020041400001', 4644000, 1, '3.jpg'),
(4, 1, '2020-04-16 02:01:01', '2020041600001', 8687000, 1, '4.jpg'),
(5, 2, '2020-04-17 02:01:44', '2020041700001', 0, 1, ''),
(6, 2, '2020-04-17 02:02:04', '2020041700002', 1145082, 1, ''),
(7, 2, '2020-04-17 02:02:25', '2020041700003', 3000000, 2, ''),
(8, 2, '2020-04-17 02:02:38', '2020041700004', 3423000, 1, '8.jpg'),
(11, 5, '2020-04-17 02:03:42', '2020041700005', 0, 1, ''),
(12, 5, '2020-04-17 02:03:54', '2020041700006', 5805000, 1, ''),
(13, 5, '2020-04-17 02:04:03', '2020041700007', 0, 2, ''),
(14, 5, '2020-04-17 02:04:16', '2020041700008', 195605, 1, ''),
(15, 5, '2020-04-17 02:04:28', '2020041700009', 2112800, 1, ''),
(16, 5, '2020-04-17 02:04:39', '2020041700010', 19311000, 2, ''),
(17, 2, '2020-04-17 02:04:48', '2020041700011', 4644000, 1, ''),
(18, 6, '2020-04-21 21:13:31', '2020042100001', 91704000, 1, '');

--
-- Triggers `htrans`
--
DROP TRIGGER IF EXISTS `beforeInsert_htrans_check`;
DELIMITER $$
CREATE TRIGGER `beforeInsert_htrans_check` BEFORE INSERT ON `htrans` FOR EACH ROW BEGIN
	SET @prefixNota = '';
    SET @ctrNota = 0;
    SELECT DATE_FORMAT(NEW.TANGGAL_TRANS,'%Y%m%d') INTO @prefixNota;
    SELECT COUNT(ROW_ID_HTRANS) + 1 INTO @ctrNota FROM htrans WHERE NO_NOTA LIKE concat(@prefixNota, '%');
    SET NEW.NO_NOTA = concat(@prefixNota, LPAD(@ctrNota,5,'0'));   
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `htrans`
--
ALTER TABLE `htrans`
  ADD PRIMARY KEY (`ROW_ID_HTRANS`),
  ADD UNIQUE KEY `unique_htrans_no_nota` (`NO_NOTA`),
  ADD KEY `FK_HTRANS_CUSTOMER` (`ROW_ID_CUSTOMER`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `htrans`
--
ALTER TABLE `htrans`
  MODIFY `ROW_ID_HTRANS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `htrans`
--
ALTER TABLE `htrans`
  ADD CONSTRAINT `FK_HTRANS_CUSTOMER` FOREIGN KEY (`ROW_ID_CUSTOMER`) REFERENCES `customer` (`ROW_ID_CUSTOMER`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
