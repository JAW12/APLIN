-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2020 at 02:54 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id13772731_proyek_aplin`
--

-- --------------------------------------------------------

--
-- Table structure for table `CART`
--

CREATE TABLE `CART` (
  `ROW_ID_CUSTOMER` int(11) NOT NULL,
  `ROW_ID_PRODUK` int(11) NOT NULL,
  `QTY` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `CART`
--

INSERT INTO `CART` (`ROW_ID_CUSTOMER`, `ROW_ID_PRODUK`, `QTY`) VALUES
(6, 3, 50),
(6, 6, 10),
(6, 7, 1),
(6, 8, 0),
(6, 9, 50),
(6, 10, 0),
(7, 6, 2),
(7, 7, 1),
(7, 11, 2),
(8, 8, 12),
(9, 13, 10),
(9, 14, 5),
(10, 9, 3),
(10, 13, 7),
(12, 10, 5),
(12, 13, 2),
(13, 14, 1),
(15, 16, 20);

-- --------------------------------------------------------

--
-- Table structure for table `CUSTOMER`
--

CREATE TABLE `CUSTOMER` (
  `ROW_ID_CUSTOMER` int(11) NOT NULL,
  `USERNAME` varchar(20) NOT NULL,
  `PASSWORD` longtext NOT NULL,
  `EMAIL` varchar(320) NOT NULL,
  `NAMA_DEPAN_CUSTOMER` varchar(50) NOT NULL,
  `NAMA_BELAKANG_CUSTOMER` varchar(50) NOT NULL,
  `JENIS_KELAMIN_CUSTOMER` varchar(1) NOT NULL COMMENT 'L = Laki-laki; P = Perempuan; U=Undefined (untuk organisasi/perusahaan)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `CUSTOMER`
--

INSERT INTO `CUSTOMER` (`ROW_ID_CUSTOMER`, `USERNAME`, `PASSWORD`, `EMAIL`, `NAMA_DEPAN_CUSTOMER`, `NAMA_BELAKANG_CUSTOMER`, `JENIS_KELAMIN_CUSTOMER`) VALUES
(1, 'winda', '$2y$10$UCi1./JgsZBEW/cIGLf0qexKtpGVE3IbO0K/CHfxNCjBR1W8ZLoi.', 'wau959@gmail.com', 'Winda', 'Angelina', 'P'),
(2, 'bambang', '$2y$10$9FnstyKB7pna0Br8HwPSV.LDFq2cIxy.BcLmbOMVODgmnKcsZc6I6', 'bambangmantoel@yahoo.com', 'Bambang', 'Mantoel', 'L'),
(5, 'majujaya', '$2y$10$gi4Cok0Eb1b/jg8UeNKy5Ov8K6N01aUDrMULPiTPfKJoGsCW8Vr.q', 'majuselalu@gmail.com', 'PT MAJU ', 'JAYA', 'U'),
(6, 'Siti', '$2y$10$4g27PUpri3rKiBpYrImhVuDnX0jgww0OlwTCrLojiBScwHaIrXQeW', 'sitin1@gmail.com', 'Siti', 'Nurbaya', 'P'),
(7, 'Jamesj1', '$2y$10$HjUxKo1jjrLEyB5gSiiQMubmFAPxRp7GD5qLT2O3mRwdD.u73MOA2', 'jamesjeff@gmail.com', 'James', 'Jefferson', 'L'),
(8, 'nadya', '$2y$10$OVbkDxUynPGh1E1VowwTe.2B4GW8DKH4Frv70y3ylva2bGE0DJJFq', 'nadya@gmail.com', 'nadya', 'hamdani', 'L'),
(9, 'arnold', '$2y$10$9d2tPYrnXA.IKliZMJ8zLurxVdtb38pIGtEsxp4NVPdze3YkV1UDG', 'arnold@gmail.com', 'arnold', 'Christopher', 'L'),
(10, 'Raymond', '$2y$10$vdwkN/twytueNABEU8PagOPNeiWAVY31NeqFfIOJKjyZs9IgNm8b.', 'Raymond@yahoo.com', 'raymond', 'yaputra', 'L'),
(11, 'Felia', '$2y$10$erymxitULAoXjdQRRQBYIe.HPU4de4MnDd0a6MpM34oypUquz2gmi', 'felia@gmail.com', 'felia', 'subagyo', 'P'),
(12, 'juan', '$2y$10$.Ksj2CX9qIrF2rMeKf0x9.Sq.yDMS2refTFDqPtpuTajnmE1.QnEa', 'juan@gmail.com', 'juan', 'tjipta', 'L'),
(13, 'angel', '$2y$10$lV7T0NIe/D/v6UlTiVe5vO7FMx5.IWlQI67v6LXxpCbJTANCWgr/u', 'angel@gmail.com', 'angel', 'yaputri', 'P'),
(14, 'juci', '$2y$10$PM3e9kxez/RiGHMgMIsZn.jKzUw63WYCi3TeFNSpTw/tGVqA1qzzK', 'juci@gmail.com', 'juci', 'tjipta', 'U'),
(15, 'hamdani', '$2y$10$vh2giCeSaFCKroFiz3HUt.zBzcjkOFzq81.jIB/5b9ABSau.yjXoK', 'hamdani2@gmail.com', 'hamdani', 'evan', 'U'),
(24, 'windakece', '$2y$10$9EyCyWw1SnZHa4WkjBTqfugr6Ns2/0ffKEipS0CdZglMEE.jshrxq', 'winda1@mhs.stts.edu', 'winda', 'kece', 'P'),
(27, 'jem', '$2y$10$DgWR1wR6hDQFQIIt/e44ueEaYF99C/zeQVDmmJ4iqSN6zuguxPdVG', 'jem@mhs.stts.edu', 'jem', 'angkasa', 'L'),
(28, 'hendralw12', '$2y$10$Hy6U5TxJysqcHl03H5ZFwe1171q5okiGT2n4gN0K1KZuChFWdUd9O', 'hendralw3@gmail.com', 'Hendra Lingga', 'Wijaya', 'L'),
(32, 'YAULLAH', '$2y$10$mnauX1wW3et8S8F74M.mIOilicERMu4LZWsPCCOA.gzT5W1mDB8ze', 'hongary.kevin@stts.edu', 'honga', 'sadasad', 'L'),
(33, 'jaw', '$2y$10$1ptyvPgkOIWbbXkUZoPLPeDCzjocB3PEbCXfJjZZzUHGQSOYKIh3.', 'jem.angkasa91@gmail.com', 'jem', 'angkasa', 'L'),
(34, 'kevin', '$2y$10$Uoycw9Fz47yTidLGpXTrLOXyvctouiv3JW0pAsL8k/1IowYKwijjq', 'hongary@gmail.com', 'kevin', 'honga', 'L'),
(35, '000webhost', '$2y$10$wBFUUTyxDp7/OtIEAXTYkeevgcwThfPZwwtAPKbtqvWC2pSmEl8bi', 'hendrapogobiru@gmail.com', 'hendra', 'pogo', 'U'),
(36, 'jajal', '$2y$10$HtL4Mek22YgQ7048vgB13Onoi9snJqYLKuTJyp3HXKCBKi.nMAn4m', 'hongary.kevin@gmail.com', 'kevin', 'hong', 'L'),
(37, 'piekoe', '$2y$10$Uw4AeipCAcGQFphdUlOcMOqn3EwM.rKN9CGu6e.MVTOaxhiEn5Cfq', 'kevin3@mhs.stts.edu', 'kevin', 'mhs', 'L'),
(38, 'seque', '$2y$10$r69ecO8SvWSWTZ6uZxy5ludTjAXUomZ9uMj0EOndHRu8HCgXLzNki', 'squeeesstore24@gmail.com', 'sque', 'store', 'U');

-- --------------------------------------------------------

--
-- Table structure for table `DTRANS`
--

CREATE TABLE `DTRANS` (
  `ROW_ID_HTRANS` int(11) NOT NULL,
  `ROW_ID_PRODUK` int(11) NOT NULL,
  `QTY_PRODUK` int(11) NOT NULL,
  `HARGA_PRODUK` int(11) DEFAULT NULL,
  `SUBTOTAL` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `DTRANS`
--

INSERT INTO `DTRANS` (`ROW_ID_HTRANS`, `ROW_ID_PRODUK`, `QTY_PRODUK`, `HARGA_PRODUK`, `SUBTOTAL`) VALUES
(1, 3, 2, 472500, 945000),
(1, 5, 3, 195605, 586815),
(1, 6, 3, 1500000, 4500000),
(1, 7, 2, 259000, 518000),
(3, 11, 4, 1161000, 4644000),
(4, 13, 2, 4099000, 8198000),
(4, 14, 1, 489000, 489000),
(6, 10, 3, 381694, 1145082),
(7, 6, 2, 1500000, 3000000),
(8, 14, 7, 489000, 3423000),
(12, 11, 5, 1161000, 5805000),
(14, 5, 1, 195605, 195605),
(15, 9, 2, 1056400, 2112800),
(16, 13, 3, 4099000, 12297000),
(17, 11, 4, 1161000, 4644000),
(18, 3, 50, 472500, 23625000),
(18, 6, 10, 1500000, 15000000),
(18, 7, 1, 259000, 259000),
(18, 9, 50, 1056400, 52820000),
(18, 10, 0, 381694, 0),
(19, 10, 2, 381694, 763388),
(20, 7, 3, 259000, 777000),
(20, 8, 4, 1593150, 6372600),
(20, 10, 0, 381694, 0),
(21, 11, 4, 1161000, 4644000),
(21, 14, 4, 489000, 1956000),
(22, 13, 45, 4099000, 184455000),
(22, 14, 5, 489000, 2445000),
(23, 3, 1, 472500, 472500),
(23, 8, 996, 1593150, 1586777400),
(23, 10, 5, 381694, 1908470),
(23, 13, 245, 4099000, 1004255000),
(23, 16, 4, 1169000, 4676000),
(24, 6, 30, 1500000, 45000000),
(24, 8, 15, 1593150, 23897250),
(25, 7, 94, 259000, 24346000),
(25, 10, 5, 381694, 1908470),
(25, 16, 4, 1169000, 4676000),
(26, 10, 3895, 381694, 1486698130),
(27, 7, 12, 259000, 3108000),
(27, 8, 12, 1593150, 19117800),
(28, 11, 12, 1161000, 13932000),
(29, 7, 2, 259000, 518000),
(29, 10, 5, 381694, 1908470),
(30, 7, 6, 259000, 1554000),
(30, 11, 2, 1161000, 2322000),
(31, 7, 3, 259000, 777000),
(32, 7, 3, 259000, 777000),
(53, 7, 100, 259000, 25900000),
(53, 10, 100, 381694, 38169400),
(53, 11, 10, 1161000, 11610000),
(53, 14, 10, 489000, 4890000),
(53, 16, 100, 1169000, 116900000),
(54, 11, 100, 1161000, 116100000),
(54, 14, 100, 489000, 48900000),
(55, 7, 1, 259000, 259000),
(56, 7, 1, 259000, 259000),
(57, 7, 1, 259000, 259000),
(58, 10, 2, 381694, 763388),
(58, 29, 2, 35000, 70000),
(59, 7, 1, 259000, 259000),
(59, 8, 1, 1593150, 1593150),
(59, 10, 1, 381694, 381694),
(60, 7, 1, 259000, 259000),
(62, 7, 1, 259000, 259000),
(63, 7, 10, 259000, 2590000),
(63, 35, 20, 1500000, 30000000),
(68, 7, 1, 259000, 259000),
(69, 35, 1, 1500000, 1500000),
(71, 7, 11, 259000, 2849000),
(71, 14, 4, 489000, 1956000);

--
-- Triggers `DTRANS`
--
DELIMITER $$
CREATE TRIGGER `afterInsert_dtrans_check` AFTER INSERT ON `DTRANS` FOR EACH ROW BEGIN
SET @total = 0;
SET @qtyBeli = NEW.QTY_PRODUK;
SET @harga = NEW.HARGA_PRODUK;

SELECT SUM(SUBTOTAL) INTO @total FROM DTRANS WHERE ROW_ID_HTRANS = NEW.ROW_ID_HTRANS;

UPDATE HTRANS SET TOTAL_TRANS = @total WHERE ROW_ID_HTRANS = NEW.ROW_ID_HTRANS;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `afterUpdate_dtrans_check` AFTER UPDATE ON `DTRANS` FOR EACH ROW BEGIN
SET @total = 0;
SET @qtyBeli = NEW.QTY_PRODUK;
SET @qtyLama = OLD.QTY_PRODUK;

SELECT SUM(SUBTOTAL) INTO @total FROM DTRANS WHERE ROW_ID_HTRANS = NEW.ROW_ID_HTRANS;

UPDATE HTRANS SET TOTAL_TRANS = @total WHERE ROW_ID_HTRANS = NEW.ROW_ID_HTRANS;

UPDATE PRODUK SET STOK_PRODUK = STOK_PRODUK + @qtyLama WHERE ROW_ID_PRODUK = OLD.ROW_ID_PRODUK;

UPDATE PRODUK SET STOK_PRODUK = STOK_PRODUK - @qtyBeli WHERE ROW_ID_PRODUK = NEW.ROW_ID_PRODUK;


END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `beforeInsert_dtrans_check` BEFORE INSERT ON `DTRANS` FOR EACH ROW BEGIN
SET @harga = 0;
SET @qty = NEW.QTY_PRODUK;
SELECT HARGA_PRODUK INTO @harga FROM PRODUK WHERE ROW_ID_PRODUK = NEW.ROW_ID_PRODUK;
SET NEW.HARGA_PRODUK = @harga;
SET NEW.SUBTOTAL = @harga * @qty;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `HTRANS`
--

CREATE TABLE `HTRANS` (
  `ROW_ID_HTRANS` int(11) NOT NULL,
  `ROW_ID_CUSTOMER` int(11) NOT NULL,
  `TANGGAL_TRANS` datetime NOT NULL,
  `NO_NOTA` varchar(15) DEFAULT NULL,
  `TOTAL_TRANS` int(11) DEFAULT 0,
  `STATUS_PEMBAYARAN` int(11) NOT NULL COMMENT '0=Pending,  1= Accepted,  2=Rejected',
  `LOKASI_FOTO_BUKTI_PEMBAYARAN` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `HTRANS`
--

INSERT INTO `HTRANS` (`ROW_ID_HTRANS`, `ROW_ID_CUSTOMER`, `TANGGAL_TRANS`, `NO_NOTA`, `TOTAL_TRANS`, `STATUS_PEMBAYARAN`, `LOKASI_FOTO_BUKTI_PEMBAYARAN`) VALUES
(1, 1, '2020-02-20 02:33:56', '2020022000001', 6549815, 2, '1.jpg'),
(3, 1, '2020-04-14 02:36:31', '2020041400001', 4644000, 1, '3.jpg'),
(4, 1, '2020-04-16 02:01:01', '2020041600001', 8687000, 2, '4.jpg'),
(6, 2, '2020-04-17 02:02:04', '2020041700002', 1145082, 1, '6.jpg'),
(7, 2, '2020-04-17 02:02:25', '2020041700003', 3000000, 2, ''),
(8, 2, '2020-04-17 02:02:38', '2020041700004', 3423000, 1, '8.jpg'),
(12, 5, '2020-04-17 02:03:54', '2020041700006', 5805000, 1, ''),
(14, 5, '2020-04-17 02:04:16', '2020041700008', 195605, 1, ''),
(15, 5, '2020-04-17 02:04:28', '2020041700009', 2112800, 1, ''),
(16, 5, '2020-04-17 02:04:39', '2020041700010', 19311000, 2, ''),
(17, 2, '2020-04-17 02:04:48', '2020041700011', 4644000, 1, ''),
(18, 6, '2020-04-21 21:13:31', '2020042100001', 91704000, 1, ''),
(19, 2, '2020-05-06 00:00:00', '2020050600001', 763388, 1, NULL),
(20, 1, '2020-05-07 17:30:17', '2020050700001', 7149600, 2, ''),
(21, 1, '2020-05-07 17:30:51', '2020050700002', 6600000, 1, '21.jpg'),
(22, 2, '2020-05-05 00:00:00', '2020050500001', 186900000, 1, NULL),
(23, 2, '2020-05-07 17:55:59', '2020050700003', 2147483647, 1, ''),
(24, 5, '2020-05-07 18:01:55', '2020050700004', 68897250, 1, ''),
(25, 1, '2020-05-07 18:03:55', '2020050700005', 30930470, 1, ''),
(26, 1, '2020-05-07 18:07:21', '2020050700006', 1486698130, 1, ''),
(27, 1, '2020-05-08 12:03:47', '2020050800001', 22225800, 1, ''),
(28, 1, '2020-05-08 12:04:10', '2020050800002', 13932000, 2, ''),
(29, 1, '2020-05-13 17:12:44', '2020051300001', 2426470, 1, '29.jpg'),
(30, 1, '2020-05-11 17:13:17', '2020051300002', 3876000, 2, ''),
(31, 1, '2020-05-13 17:23:35', '2020051300003', 777000, 1, ''),
(32, 1, '2020-05-13 17:26:15', '2020051300004', 777000, 1, ''),
(45, 27, '2020-05-19 11:55:07', '', 0, 2, ''),
(53, 1, '2020-05-19 13:06:56', '2020051900001', 197469400, 2, ''),
(54, 1, '2020-05-19 13:10:19', '2020051900002', 165000000, 1, ''),
(55, 1, '2020-05-19 14:09:39', '2020051900003', 259000, 0, ''),
(56, 1, '2020-05-19 14:17:29', '2020051900004', 259000, 2, ''),
(57, 1, '2020-05-19 14:22:56', '2020051900005', 259000, 1, '57.jpg'),
(58, 27, '2020-05-19 15:46:30', '2020051900006', 833388, 1, '58.png'),
(59, 1, '2020-05-20 02:12:45', '2020052000001', 2233844, 1, ''),
(60, 1, '2020-05-20 02:24:27', '2020052000002', 259000, 1, ''),
(62, 1, '2020-05-20 02:28:30', '2020052000003', 259000, 0, ''),
(63, 1, '2020-05-20 02:29:57', '2020052000004', 32590000, 1, ''),
(68, 1, '2020-05-20 04:19:52', '2020052000005', 259000, 0, ''),
(69, 27, '2020-05-20 07:00:30', '2020052000006', 1500000, 1, ''),
(70, 33, '2020-05-20 07:35:10', '2020052000007', 0, 2, ''),
(71, 33, '2020-05-20 07:37:55', '2020052000008', 4805000, 1, '71.png');

--
-- Triggers `HTRANS`
--
DELIMITER $$
CREATE TRIGGER `beforeInsert_htrans_check` BEFORE INSERT ON `HTRANS` FOR EACH ROW BEGIN
	SET @prefixNota = '';
    SET @ctrNota = 0;
    SELECT DATE_FORMAT(NEW.TANGGAL_TRANS,'%Y%m%d') INTO @prefixNota;
    SELECT COUNT(ROW_ID_HTRANS) + 1 INTO @ctrNota FROM HTRANS WHERE NO_NOTA LIKE concat(@prefixNota COLLATE UTF8MB4_GENERAL_CI, '%' COLLATE UTF8MB4_GENERAL_CI);
    SET NEW.NO_NOTA = concat(@prefixNota, LPAD(@ctrNota,5,'0'));   
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `KATEGORI`
--

CREATE TABLE `KATEGORI` (
  `ROW_ID_KATEGORI` int(11) NOT NULL,
  `ROW_ID_KATEGORI_PARENT` int(11) DEFAULT NULL,
  `ID_KATEGORI` varchar(5) DEFAULT NULL,
  `NAMA_KATEGORI` varchar(30) NOT NULL,
  `STATUS_AKTIF_KATEGORI` varchar(1) NOT NULL COMMENT '1=aktif, 0= tidak aktif',
  `STATUS_PARENT` varchar(1) DEFAULT '0' COMMENT '1=parent, 0= bukan parent - default nya bukan parent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `KATEGORI`
--

INSERT INTO `KATEGORI` (`ROW_ID_KATEGORI`, `ROW_ID_KATEGORI_PARENT`, `ID_KATEGORI`, `NAMA_KATEGORI`, `STATUS_AKTIF_KATEGORI`, `STATUS_PARENT`) VALUES
(1, 28, 'BT001', 'BATH TUB', '1', '0'),
(2, 28, 'WA001', 'WASTAFEL', '1', '0'),
(3, 21, 'TI001', 'TILES', '1', '0'),
(6, 9, 'LB001', 'LIGHT BULB', '1', '0'),
(7, NULL, 'AP001', 'APPLIANCES', '1', '1'),
(9, NULL, 'EA001', 'ELECTRICAL AND LIGHTING', '1', '1'),
(10, 22, 'RC001', 'RICE COOKER', '1', '0'),
(20, NULL, 'HD001', 'HOME DECORATION', '1', '1'),
(21, NULL, 'WA002', 'WALL AND FLOORING', '1', '1'),
(22, NULL, 'HI001', 'HOME IMPROVEMENT', '1', '1'),
(23, NULL, 'OU001', 'OUTDOOR', '1', '1'),
(24, NULL, 'SA001', 'SAFETY AND  SECURITY', '1', '1'),
(25, NULL, 'KI001', 'KITCHEN', '1', '1'),
(26, NULL, 'TA001', 'TOOL AND HARDWARE', '1', '1'),
(27, NULL, 'DA001', 'DOOR AND WINDOW', '1', '1'),
(28, NULL, 'BA001', 'BATHROOM', '1', '1');

--
-- Triggers `KATEGORI`
--
DELIMITER $$
CREATE TRIGGER `beforeInsert_kategori_check` BEFORE INSERT ON `KATEGORI` FOR EACH ROW BEGIN
	SET @ctr = 0;
    SET @prefix = '';
    SET @pre1 = '';
    SET @pre2 = '';
    SET @idx = 0;
    SET @nama = NEW.NAMA_KATEGORI;
    
    SELECT INSTR(@nama, ' ') INTO @idx;
    IF @idx <= 0 THEN
    	SELECT SUBSTRING(@nama, 1, 2) INTO @prefix;
    ELSE
    	SELECT SUBSTRING(@nama, 1, 1) INTO @pre1;
        SELECT SUBSTRING(@nama, @idx + 1, 1) INTO @pre2;
        SELECT CONCAT(@pre1, @pre2) INTO @prefix;      
    END IF;
    SELECT COUNT(ROW_ID_KATEGORI) + 1 INTO @ctr FROM kategori WHERE ID_KATEGORI LIKE concat(@prefix, '%');
    SELECT UPPER(CONCAT(@prefix, LPAD(@ctr,3,'0'))) INTO @prefix;
    SET NEW.ID_KATEGORI = @prefix;   
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `KATEGORI_PRODUK`
--

CREATE TABLE `KATEGORI_PRODUK` (
  `ROW_ID_PRODUK` int(11) NOT NULL,
  `ROW_ID_KATEGORI_PARENT` int(11) NOT NULL,
  `ROW_ID_KATEGORI_CHILD` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `KATEGORI_PRODUK`
--

INSERT INTO `KATEGORI_PRODUK` (`ROW_ID_PRODUK`, `ROW_ID_KATEGORI_PARENT`, `ROW_ID_KATEGORI_CHILD`) VALUES
(3, 28, 2),
(5, 9, 6),
(6, 7, 2),
(7, 7, 10),
(8, 20, 27),
(9, 20, 27),
(10, 20, 27),
(11, 7, 22),
(13, 25, 26),
(14, 25, 9),
(16, 7, 26),
(23, 7, 3),
(27, 21, 3),
(28, 21, 3),
(29, 21, 3),
(31, 21, 3),
(35, 21, 3),
(38, 23, 6),
(39, 23, 2);

-- --------------------------------------------------------

--
-- Table structure for table `PRODUK`
--

CREATE TABLE `PRODUK` (
  `ROW_ID_PRODUK` int(11) NOT NULL,
  `ID_PRODUK` varchar(5) DEFAULT NULL,
  `NAMA_PRODUK` varchar(255) NOT NULL,
  `STATUS_AKTIF_PRODUK` varchar(1) NOT NULL COMMENT '1 = aktif, 0 = tidak aktif',
  `HARGA_PRODUK` int(11) NOT NULL,
  `DIMENSI_KEMASAN` varchar(30) NOT NULL,
  `DIMENSI_PRODUK` varchar(30) NOT NULL,
  `BERAT_PRODUK` varchar(10) NOT NULL,
  `SATUAN_PRODUK` varchar(10) NOT NULL,
  `DESKRIPSI_PRODUK` longtext DEFAULT NULL,
  `LOKASI_FOTO_PRODUK` longtext DEFAULT NULL,
  `STOK_PRODUK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `PRODUK`
--

INSERT INTO `PRODUK` (`ROW_ID_PRODUK`, `ID_PRODUK`, `NAMA_PRODUK`, `STATUS_AKTIF_PRODUK`, `HARGA_PRODUK`, `DIMENSI_KEMASAN`, `DIMENSI_PRODUK`, `BERAT_PRODUK`, `SATUAN_PRODUK`, `DESKRIPSI_PRODUK`, `LOKASI_FOTO_PRODUK`, `STOK_PRODUK`) VALUES
(3, 'CR001', 'CERAMAX ROJO FSB0371 W/HUNG BASIN', '1', 472500, '40cm X 40cm X 14cm', '38cm X 38cm X 12cm', '9 Kg', 'PCS', 'CERAMAX ROJO FSB0371 Wall Hung Wastafel\r\n\r\nSpesifikasi:\r\n\r\nTipe: Wall Hung Basin\r\nDimensi 380x380x120MM\r\nMaterial: Porselen\r\nFitur:\r\n\r\nHarga terjangkau\r\nMaterial berbahan porselen mudah dibersihkan dan tidak ada tepian yang tajam\r\nSistem pembuangan yang lancar\r\nDesain elegan\r\nHemat ruang', 'CR001.png', -46),
(5, 'P1001', 'PHILIPS 17401 59449 105 9W 65K MESON CD G3', '1', 195605, '14cm X 12cm X 12cm', '14cm X 12cm X 12cm', '200 gr', 'PCS', 'Keunggulan:\r\n\r\nLED Downlight dengan harga terjangku\r\nTermasuk lampu & driver terintegrasi, Anda bisa langsung\r\nmemasangnya\r\nMudah dipasang\r\nCahaya yang rata dengan diffuser anti silau\r\nHemat Listrik = Hemat Biaya!\r\nTahan lama, umur hingga 15.000 jam\r\nTersedia dalam berbagai macam pilihan ukuran & watt\r\nSpesifikasi:\r\n\r\nColor: Putih (cool day light)\r\nPower: 9W\r\nLumen: 650lm (6500K)\r\nDiameter: 120mm\r\nKetebalan: 47mm\r\nLubang Plafon / Cutout: 105mm / 4.1 inch\r\nKoneksi: flying wire\r\nUmur: hingga 15.000 jam\r\nCRI80\r\nIP20\r\n220-240V ~ 50-60 Hz\r\nTidak dapat diredupkan / Non Dimmable\r\nTidak dapat diganti lampu atau driver-nya saja\r\nUntuk pemakaian di dalam ruangan / Indoor use only', 'P1001.png', -12),
(6, 'TF001', 'TIDY FSA0042 WHITE ONE PIECE TOILET', '0', 1500000, '70cm X 44cm X 61cm', '68cm X 42cm X 59cm', '41kg', 'SET', 'TIDY FSA0042 WHITE ONE PIECE TOILET\r\n\r\nSpesifikasi:\r\n\r\nTipe: Monoblok / One piece toilet\r\nSistem pembuangan: Siphonic\r\nSoft closing seat cover\r\nAs/Jarak dinding/Rough-in/S-trap 300mm\r\nOutfall diameter 100mm\r\nMaterial: Porselen\r\nFitur:\r\n\r\nHarga relatif terjangkau\r\nOne piece toilet dengan ukuran yang sesuai dengan masyarakat Asia\r\nDesain modern\r\nHemat ruang\r\nSistem syphonic', 'TF001.png', -5),
(7, 'GX001', 'GLUCKLICH X01HI1 0.3LT 200W RICE COOKER', '1', 259000, '20cm X 20cm X 22cm', '18cm X 18cm X 20cm', '3kg', 'UNIT', 'Keunggulan:\r\n\r\nBagian dalam anti lengket\r\nFitur tetap hangat\r\nBahan lebih tebal\r\nPerlindungan sekering ganda\r\nPerlindungan suhu tunggi\r\nBaki pengukus tebal\r\nGaransi service 2 tahun\r\nDapat sendok, mangkuk takar, kabel\r\nSpesifikasi:\r\n\r\nGaris air: 0,3 liter\r\nVolume pot: 3 liter\r\nKetebalan: 0.75mm\r\nTegangan: 50/60Hz, 220V\r\nDaya: 200 Watt', 'GX001.png', 148),
(8, 'TA001', 'TIDY ALUMIX PVC MIN KC 2 / 02', '0', 1593150, '100cm x 100cm x 100cm', '20cm x 20cm x 20cm', '10KG', 'PCS', 'Ringan dan Kokoh -Tahan terhadap air -Tidak berkarat -Menggunakan kusen aluminium sehingga lebih awet dan tahan lama -Tidak berubah bentuk akibat cuaca', 'TA001.png', 1983),
(9, 'DU001', 'DOORWAY UPVC DOOR HW017L 3/4KC', '1', 1056400, '70cm x 70cm x 70cm', '20cm x 20 cm x 18cm', '4kg', 'UNIT', 'Pintu uPVC yang cocok untuk pintu kamar mandi, karena keunggulanya yaitu tahan air, tahan rayap, dan kokoh. ditambahkan lagi uPVC merupakan bahan yang akan meredam suara dan ramah lingkungan', 'DU001.png', -2),
(10, 'NF001', 'NIRO FLEUR GFL03 MARIGOLD PGVT', '1', 381694, '80cm x 80cm x 80cm', '19cm x 19cm x 19cm', '8kg', 'BOX', 'Granite Niro Exclusive Design Only at Mitra10. Granite lantai Glazed Polsihed Digital ukuran 80x80 glossy surface memberikan nuansa mewah untuk ruangan anda\r\n\r\n\r\nFungsi: granite porcelain, porcelain tiles, granite lantai, granite polished, granite 80x80, granite digital, granite niro, granite glaze\r\n\r\nGranite Niro Exclusive Design Only at Mitra10. Granite lantai Glazed Polsihed Digital ukuran 80x80 glossy surface memberikan nuansa mewah untuk ruangan anda\r\n\r\n\r\nFungsi: granite porcelain, porcelain tiles, granite lantai, granite polished, granite 80x80, granite digital, granite niro, granite glaze', 'NF001.png', 4992),
(11, 'ZT001', 'ZEHN TANGGA ALUMINIUM YKF-403 ( 3 X 4 STEP )', '0', 1161000, '20cm x 30cm x 30cm', '19cm x 20cm x 20cm', '20kg', 'SET', 'Zehn Tangga Aluminium 403 adalah jenis tangga yang bisa dilipat empat, dengan total panjang 3,70 m. Tangga ini bisa disetel/adjust (multipurpose)', 'ZT001.png', 825),
(13, 'PP001', 'POLYTRON PRM 28 QS/QB MIRROR 2D REFRIGERATOR', '1', 4099000, '75cm x 75cm x 75cm', '45cm x 45cm x 45', '20kg', 'SET', 'Polytron Belleza 3 hadir dengan mengusung “Zen Design” yang memberikan keseimbangan antara penyempurnaan tampilan dalam (interior) dan tampilan luar (eksterior) dengan menampilkan sentuhan borderless.', 'PP001.png', 745),
(14, 'EE001', 'ELECTROLUX ETS 3505 POP UP TOASTER', '1', 489000, '43cm x 43cm x 42cm', '34cm x 34cm x 34cm', '25kg', 'UNIT', 'ELECTROLUX ETS 3505 POP UP TOASTER\r\n\r\nMemanggang roti dengan kematangan yang sempurna. Membuat sarapan Anda tersaji dengan lebih baik dan lebih cepat.', 'EE001.png', 380),
(16, 'PM001', 'PANASONIC MC-CG300X546 VACUUM CLEANER', '1', 1169000, '35cm x 35cm x 35cm', '40cm x 40cm x 40cm', '45kg', 'SET', 'Panasonic MC-CG300X546 merupakan vacuum cleaner yang dapat membersihkan ruangan dari debu, bakteri, jamur, tungau dan allergen lainnya. Dengan Panasonic MC-CG300X546 Anda dapat membersihkan rumah dengan mudah tanpa membutuhkan tenaga ekstra dan menyita banyak waktu Anda.', 'PM001.png', 644),
(23, 'PK001', 'poster kassandra mantoel', '0', 9999999, '14 cm x 12 cm', '12 cm x 14 cm', '120 kg', 'PCS', 'EDIT COBA WOY', 'PK001.png', 124),
(27, 'KP001', 'Keramik Pokemon3', '1', 30000, '40 cm X 40 cm X 14 cm', '38 cm X 38 cm X 12 cm', '35 kg', 'PCS', 'This is a shiny pokemon tile', 'KP001.png', 2),
(28, 'KP002', 'Keramik Pokemon', '1', 35000, '40 cm X 40 cm X 14 cm', '38 cm X 38 cm X 12 cm', '35 kg', 'PCS', 'fwergerger', 'KP002.png', 2),
(29, 'KP003', 'Keramik Pokemon2', '1', 35000, '40 cm X 40 cm X 14 cm', '38 cm X 38 cm X 12 cm', '35 kg', 'PCS', 'fwergerger', 'KP003.png', 0),
(30, 'KP004', 'Keramik Pokemon2', '1', 35000, '40 cm X 40 cm X 14 cm', '38 cm X 38 cm X 12 cm', '35 kg', 'PCS', 'fwergerger', NULL, 2),
(31, 'KP005', 'Keramik Pokemon4', '0', 50000, '40 cm X 40 cm X 14 cm', '38 cm X 38 cm X 12 cm', '35 kg', 'PCS', 'tyjktyj', 'KP005.png', 20),
(35, 'KT001', 'KERAMIK TANPA FOTO', '1', 1500000, '14cm X 12cm X 12cm', '14cm X 12cm X 12cm', '200 gr', 'BOX', 'ini keramik yang ga punya foto ', NULL, 79),
(38, '019', 'LAMPU TAMAN', '1', 30000, '70 CM', '70 CM', '15 KG', 'UNIT', 'ini lampu taman', '019.png', 5),
(39, 'AM001', 'AIR MANCUR', '1', 425000, '120 CM', '120 CM', '20 KG', 'UNIT', 'ini air mancur', 'AM001.png', 30);

--
-- Triggers `PRODUK`
--
DELIMITER $$
CREATE TRIGGER `beforeInsert_produk_check` BEFORE INSERT ON `PRODUK` FOR EACH ROW BEGIN
	SET @ctr = 0;
    SET @prefix = '';
    SET @pre1 = '';
    SET @pre2 = '';
    SET @idx = 0;
    SET @nama = NEW.NAMA_PRODUK;
    
    SELECT INSTR(@nama, ' ') INTO @idx;
    IF @idx <= 0 THEN
    	SELECT SUBSTRING(@nama, 1, 2) INTO @prefix;
    ELSE
    	SELECT SUBSTRING(@nama, 1, 1) INTO @pre1;
        SELECT SUBSTRING(@nama, @idx + 1, 1) INTO @pre2;
        SELECT CONCAT(@pre1, @pre2) INTO @prefix;      
    END IF;
    SELECT COUNT(ROW_ID_PRODUK) + 1 INTO @ctr FROM PRODUK WHERE ID_PRODUK LIKE concat(@prefix, '%');
    SELECT UPPER(CONCAT(@prefix, LPAD(@ctr,3,'0'))) INTO @prefix;
    SET NEW.ID_PRODUK = @prefix;   
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `REVIEW_PRODUK`
--

CREATE TABLE `REVIEW_PRODUK` (
  `ROW_ID_REVIEW` int(11) NOT NULL,
  `ROW_ID_CUSTOMER` int(11) NOT NULL,
  `ROW_ID_HTRANS` int(11) NOT NULL,
  `ROW_ID_PRODUK` int(11) NOT NULL,
  `WAKTU_REVIEW` datetime NOT NULL,
  `KONTEN_REVIEW` longtext NOT NULL,
  `BINTANG_REVIEW` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `REVIEW_PRODUK`
--

INSERT INTO `REVIEW_PRODUK` (`ROW_ID_REVIEW`, `ROW_ID_CUSTOMER`, `ROW_ID_HTRANS`, `ROW_ID_PRODUK`, `WAKTU_REVIEW`, `KONTEN_REVIEW`, `BINTANG_REVIEW`) VALUES
(3, 1, 14, 14, '2020-05-08 01:32:35', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 4),
(6, 1, 29, 7, '2020-05-13 17:24:27', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 4),
(7, 1, 29, 10, '2020-05-13 17:24:51', 'ini keramik', 5),
(8, 1, 31, 7, '2020-05-13 17:26:41', 'ini review ke 2', 2),
(18, 27, 58, 10, '2020-05-19 08:49:26', 'ini keramik krem', 5),
(19, 33, 71, 7, '2020-05-20 01:17:16', 'ini rice cooker', 5);

-- --------------------------------------------------------

--
-- Table structure for table `VERIFIKASI_EMAIL`
--

CREATE TABLE `VERIFIKASI_EMAIL` (
  `ROW_ID_VERIFIKASI` int(11) NOT NULL,
  `ROW_ID_CUSTOMER` int(11) NOT NULL,
  `KODE_VERIFIKASI` varchar(30) NOT NULL,
  `STATUS_VERIFIKASI` varchar(1) NOT NULL COMMENT '''1'' = sudah verifikasi - ''0'' = belum verifikasi',
  `INSERT_DATE` datetime DEFAULT current_timestamp(),
  `UPDATE_DATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `VERIFIKASI_EMAIL`
--

INSERT INTO `VERIFIKASI_EMAIL` (`ROW_ID_VERIFIKASI`, `ROW_ID_CUSTOMER`, `KODE_VERIFIKASI`, `STATUS_VERIFIKASI`, `INSERT_DATE`, `UPDATE_DATE`) VALUES
(5, 24, '35497', '1', '2020-05-18 12:22:29', '2020-05-18 15:08:56'),
(8, 27, '76757', '1', '2020-05-18 12:26:02', '2020-05-18 15:08:56'),
(13, 32, '66488', '1', '2020-05-18 13:29:35', '2020-05-18 15:08:56'),
(14, 1, '1234', '1', '2020-05-18 15:00:28', '2020-05-18 15:08:56'),
(15, 2, '1234', '1', '2020-05-18 15:00:59', '2020-05-18 15:08:56'),
(16, 5, '1234', '1', '2020-05-18 15:03:02', '2020-05-18 15:08:56'),
(17, 6, '1234', '1', '2020-05-18 15:03:02', '2020-05-18 15:08:56'),
(18, 7, '1234', '1', '2020-05-18 15:03:02', '2020-05-18 15:08:56'),
(19, 8, '1234444', '1', '2020-05-18 15:03:02', '2020-05-18 15:08:56'),
(20, 9, '1234', '1', '2020-05-18 15:03:02', '2020-05-18 15:08:56'),
(21, 10, '1234', '1', '2020-05-18 15:03:02', '2020-05-18 15:08:56'),
(22, 11, '1234', '1', '2020-05-18 15:03:02', '2020-05-18 15:08:56'),
(23, 12, '1234', '1', '2020-05-18 15:03:02', '2020-05-18 15:08:56'),
(24, 13, '123412', '1', '2020-05-18 15:03:02', '2020-05-18 15:08:56'),
(25, 14, '1234', '1', '2020-05-18 15:03:02', '2020-05-18 15:08:56'),
(26, 15, '12233', '1', '2020-05-18 15:04:15', '2020-05-18 15:08:56'),
(27, 24, '12344', '1', '2020-05-18 15:04:15', '2020-05-18 15:08:56'),
(28, 27, '12344', '1', '2020-05-18 15:04:15', '2020-05-18 15:08:56'),
(29, 28, '1234444', '1', '2020-05-18 15:04:15', '2020-05-18 15:08:56'),
(30, 32, '12344', '1', '2020-05-18 15:04:15', '2020-05-18 15:08:56'),
(31, 33, '61586', '1', '2020-05-20 00:20:27', NULL),
(32, 34, '49816', '0', '2020-05-20 01:49:00', NULL),
(33, 35, '27932', '0', '2020-05-20 02:23:51', NULL),
(34, 36, '43875', '0', '2020-05-20 02:28:27', NULL),
(35, 37, '77529', '0', '2020-05-20 02:43:43', NULL),
(36, 38, '16914', '0', '2020-05-20 02:48:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `WISHLIST`
--

CREATE TABLE `WISHLIST` (
  `ROW_ID_CUSTOMER` int(11) NOT NULL,
  `ROW_ID_PRODUK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `WISHLIST`
--

INSERT INTO `WISHLIST` (`ROW_ID_CUSTOMER`, `ROW_ID_PRODUK`) VALUES
(1, 6),
(1, 10),
(1, 14),
(1, 16),
(6, 3),
(6, 5),
(7, 7),
(7, 16),
(9, 8),
(10, 9),
(10, 14),
(11, 11),
(12, 7),
(13, 6),
(14, 13),
(27, 5),
(27, 6),
(27, 35),
(33, 3),
(33, 7),
(33, 13),
(33, 27);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CART`
--
ALTER TABLE `CART`
  ADD PRIMARY KEY (`ROW_ID_CUSTOMER`,`ROW_ID_PRODUK`),
  ADD KEY `FK_CART_ROW_PRODUK` (`ROW_ID_PRODUK`);

--
-- Indexes for table `CUSTOMER`
--
ALTER TABLE `CUSTOMER`
  ADD PRIMARY KEY (`ROW_ID_CUSTOMER`),
  ADD UNIQUE KEY `unique_customer_username` (`USERNAME`),
  ADD UNIQUE KEY `unique_customer_email` (`EMAIL`);

--
-- Indexes for table `DTRANS`
--
ALTER TABLE `DTRANS`
  ADD PRIMARY KEY (`ROW_ID_HTRANS`,`ROW_ID_PRODUK`),
  ADD KEY `FK_DTRANS_PRODUK` (`ROW_ID_PRODUK`);

--
-- Indexes for table `HTRANS`
--
ALTER TABLE `HTRANS`
  ADD PRIMARY KEY (`ROW_ID_HTRANS`),
  ADD KEY `FK_HTRANS_CUSTOMER` (`ROW_ID_CUSTOMER`);

--
-- Indexes for table `KATEGORI`
--
ALTER TABLE `KATEGORI`
  ADD PRIMARY KEY (`ROW_ID_KATEGORI`),
  ADD UNIQUE KEY `ID_KATEGORI` (`ID_KATEGORI`),
  ADD KEY `FK_KATEGORI_PARENT` (`ROW_ID_KATEGORI_PARENT`);

--
-- Indexes for table `KATEGORI_PRODUK`
--
ALTER TABLE `KATEGORI_PRODUK`
  ADD PRIMARY KEY (`ROW_ID_PRODUK`,`ROW_ID_KATEGORI_PARENT`,`ROW_ID_KATEGORI_CHILD`),
  ADD KEY `FK_KATEGORI_PRODUK_ROW_KAT_PARENT` (`ROW_ID_KATEGORI_PARENT`),
  ADD KEY `FK_KATEGORI_PRODUK_ROW_KAT_CHILD` (`ROW_ID_KATEGORI_CHILD`);

--
-- Indexes for table `PRODUK`
--
ALTER TABLE `PRODUK`
  ADD PRIMARY KEY (`ROW_ID_PRODUK`);

--
-- Indexes for table `REVIEW_PRODUK`
--
ALTER TABLE `REVIEW_PRODUK`
  ADD PRIMARY KEY (`ROW_ID_REVIEW`),
  ADD KEY `FK_REVIEW_CUSTOMER` (`ROW_ID_CUSTOMER`),
  ADD KEY `FK_REVIEW_HTRANS` (`ROW_ID_HTRANS`),
  ADD KEY `FK_REVIEW_PRODUK` (`ROW_ID_PRODUK`);

--
-- Indexes for table `VERIFIKASI_EMAIL`
--
ALTER TABLE `VERIFIKASI_EMAIL`
  ADD PRIMARY KEY (`ROW_ID_VERIFIKASI`),
  ADD KEY `FK_VERIFIKASI_CUSTOMER` (`ROW_ID_CUSTOMER`);

--
-- Indexes for table `WISHLIST`
--
ALTER TABLE `WISHLIST`
  ADD PRIMARY KEY (`ROW_ID_CUSTOMER`,`ROW_ID_PRODUK`),
  ADD KEY `FK_WISHLIST_ROW_PRODUK` (`ROW_ID_PRODUK`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `CUSTOMER`
--
ALTER TABLE `CUSTOMER`
  MODIFY `ROW_ID_CUSTOMER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `HTRANS`
--
ALTER TABLE `HTRANS`
  MODIFY `ROW_ID_HTRANS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `KATEGORI`
--
ALTER TABLE `KATEGORI`
  MODIFY `ROW_ID_KATEGORI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `PRODUK`
--
ALTER TABLE `PRODUK`
  MODIFY `ROW_ID_PRODUK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `REVIEW_PRODUK`
--
ALTER TABLE `REVIEW_PRODUK`
  MODIFY `ROW_ID_REVIEW` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `VERIFIKASI_EMAIL`
--
ALTER TABLE `VERIFIKASI_EMAIL`
  MODIFY `ROW_ID_VERIFIKASI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `CART`
--
ALTER TABLE `CART`
  ADD CONSTRAINT `FK_CART_ROW_CUSTOMER` FOREIGN KEY (`ROW_ID_CUSTOMER`) REFERENCES `CUSTOMER` (`ROW_ID_CUSTOMER`),
  ADD CONSTRAINT `FK_CART_ROW_PRODUK` FOREIGN KEY (`ROW_ID_PRODUK`) REFERENCES `PRODUK` (`ROW_ID_PRODUK`);

--
-- Constraints for table `DTRANS`
--
ALTER TABLE `DTRANS`
  ADD CONSTRAINT `FK_DTRANS_HTRANS` FOREIGN KEY (`ROW_ID_HTRANS`) REFERENCES `HTRANS` (`ROW_ID_HTRANS`),
  ADD CONSTRAINT `FK_DTRANS_PRODUK` FOREIGN KEY (`ROW_ID_PRODUK`) REFERENCES `PRODUK` (`ROW_ID_PRODUK`);

--
-- Constraints for table `HTRANS`
--
ALTER TABLE `HTRANS`
  ADD CONSTRAINT `FK_HTRANS_CUSTOMER` FOREIGN KEY (`ROW_ID_CUSTOMER`) REFERENCES `CUSTOMER` (`ROW_ID_CUSTOMER`);

--
-- Constraints for table `KATEGORI`
--
ALTER TABLE `KATEGORI`
  ADD CONSTRAINT `FK_KATEGORI_PARENT` FOREIGN KEY (`ROW_ID_KATEGORI_PARENT`) REFERENCES `KATEGORI` (`ROW_ID_KATEGORI`);

--
-- Constraints for table `KATEGORI_PRODUK`
--
ALTER TABLE `KATEGORI_PRODUK`
  ADD CONSTRAINT `FK_KATEGORI_PRODUK_ROW_KAT_CHILD` FOREIGN KEY (`ROW_ID_KATEGORI_CHILD`) REFERENCES `KATEGORI` (`ROW_ID_KATEGORI`),
  ADD CONSTRAINT `FK_KATEGORI_PRODUK_ROW_KAT_PARENT` FOREIGN KEY (`ROW_ID_KATEGORI_PARENT`) REFERENCES `KATEGORI` (`ROW_ID_KATEGORI`),
  ADD CONSTRAINT `FK_KATEGORI_PRODUK_ROW_PRODUK` FOREIGN KEY (`ROW_ID_PRODUK`) REFERENCES `PRODUK` (`ROW_ID_PRODUK`);

--
-- Constraints for table `REVIEW_PRODUK`
--
ALTER TABLE `REVIEW_PRODUK`
  ADD CONSTRAINT `FK_REVIEW_CUSTOMER` FOREIGN KEY (`ROW_ID_CUSTOMER`) REFERENCES `CUSTOMER` (`ROW_ID_CUSTOMER`),
  ADD CONSTRAINT `FK_REVIEW_HTRANS` FOREIGN KEY (`ROW_ID_HTRANS`) REFERENCES `HTRANS` (`ROW_ID_HTRANS`),
  ADD CONSTRAINT `FK_REVIEW_PRODUK` FOREIGN KEY (`ROW_ID_PRODUK`) REFERENCES `PRODUK` (`ROW_ID_PRODUK`);

--
-- Constraints for table `VERIFIKASI_EMAIL`
--
ALTER TABLE `VERIFIKASI_EMAIL`
  ADD CONSTRAINT `FK_VERIFIKASI_CUSTOMER` FOREIGN KEY (`ROW_ID_CUSTOMER`) REFERENCES `CUSTOMER` (`ROW_ID_CUSTOMER`);

--
-- Constraints for table `WISHLIST`
--
ALTER TABLE `WISHLIST`
  ADD CONSTRAINT `FK_WISHLIST_ROW_CUSTOMER` FOREIGN KEY (`ROW_ID_CUSTOMER`) REFERENCES `CUSTOMER` (`ROW_ID_CUSTOMER`),
  ADD CONSTRAINT `FK_WISHLIST_ROW_PRODUK` FOREIGN KEY (`ROW_ID_PRODUK`) REFERENCES `PRODUK` (`ROW_ID_PRODUK`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
