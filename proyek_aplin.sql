-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2020 at 09:39 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

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

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `F_HELLO` (`PESAN` VARCHAR(20)) RETURNS TEXT CHARSET utf8 BEGIN
	RETURN PESAN;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `ROW_ID_CUSTOMER` int(11) NOT NULL,
  `ROW_ID_PRODUK` int(11) NOT NULL,
  `QTY` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`ROW_ID_CUSTOMER`, `ROW_ID_PRODUK`, `QTY`) VALUES
(2, 3, 1),
(5, 6, 30),
(6, 7, 1),
(7, 6, 2),
(7, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `ROW_ID_CUSTOMER` int(11) NOT NULL,
  `USERNAME` varchar(20) NOT NULL,
  `PASSWORD` varchar(20) NOT NULL,
  `EMAIL` varchar(320) NOT NULL,
  `NAMA_DEPAN_CUSTOMER` varchar(50) NOT NULL,
  `NAMA_BELAKANG_CUSTOMER` varchar(50) NOT NULL,
  `JENIS_KELAMIN_CUSTOMER` varchar(1) NOT NULL COMMENT 'L = Laki-laki; P = Perempuan; U=Undefined (untuk organisasi/perusahaan)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`ROW_ID_CUSTOMER`, `USERNAME`, `PASSWORD`, `EMAIL`, `NAMA_DEPAN_CUSTOMER`, `NAMA_BELAKANG_CUSTOMER`, `JENIS_KELAMIN_CUSTOMER`) VALUES
(1, 'winda', 'winda1234', 'wau959@gmail.com', 'Winda', 'Angelina', 'P'),
(2, 'bambang', 'bambang1234', 'bambangmantoel@yahoo.com', 'Bambang', 'Mantoel', 'L'),
(5, 'majujaya', 'majujaya1234', 'majuselalu@gmail.com', 'PT MAJU ', 'JAYA', 'U'),
(6, 'Siti', 'siti001', 'sitin1@gmail.com', 'Siti', 'Nurbaya', 'P'),
(7, 'Jamesj1', 'jsj1', 'jamesjeff@gmail.com', 'James', 'Jefferson', 'L');

-- --------------------------------------------------------

--
-- Table structure for table `dtrans`
--

CREATE TABLE `dtrans` (
  `ROW_ID_HTRANS` int(11) NOT NULL,
  `ROW_ID_PRODUK` int(11) NOT NULL,
  `QTY_PRODUK` int(11) NOT NULL,
  `HARGA_PRODUK` int(11) DEFAULT NULL,
  `SUBTOTAL` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dtrans`
--

INSERT INTO `dtrans` (`ROW_ID_HTRANS`, `ROW_ID_PRODUK`, `QTY_PRODUK`, `HARGA_PRODUK`, `SUBTOTAL`) VALUES
(1, 5, 3, 195605, 586815),
(1, 6, 3, 1500000, 4500000),
(1, 7, 2, 259000, 518000);

--
-- Triggers `dtrans`
--
DELIMITER $$
CREATE TRIGGER `afterInsert_dtrans_check` AFTER INSERT ON `dtrans` FOR EACH ROW BEGIN
SET @total = 0;
SET @qtyBeli = NEW.QTY_PRODUK;
SET @harga = NEW.HARGA_PRODUK;

SELECT SUM(SUBTOTAL) INTO @total FROM dtrans WHERE ROW_ID_HTRANS = NEW.ROW_ID_HTRANS;

UPDATE produk SET STOK_PRODUK = STOK_PRODUK - @qtyBeli WHERE ROW_ID_PRODUK = NEW.ROW_ID_PRODUK;

UPDATE htrans SET TOTAL_TRANS = @total WHERE ROW_ID_HTRANS = NEW.ROW_ID_HTRANS;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `afterUpdate_dtrans_check` AFTER UPDATE ON `dtrans` FOR EACH ROW BEGIN
SET @total = 0;
SET @qtyBeli = NEW.QTY_PRODUK;
SET @qtyLama = OLD.QTY_PRODUK;

SELECT SUM(SUBTOTAL) INTO @total FROM dtrans WHERE ROW_ID_HTRANS = NEW.ROW_ID_HTRANS;

UPDATE htrans SET TOTAL_TRANS = @total WHERE ROW_ID_HTRANS = NEW.ROW_ID_HTRANS;

UPDATE produk SET STOK_PRODUK = STOK_PRODUK + @qtyLama WHERE ROW_ID_PRODUK = OLD.ROW_ID_PRODUK;

UPDATE produk SET STOK_PRODUK = STOK_PRODUK - @qtyBeli WHERE ROW_ID_PRODUK = NEW.ROW_ID_PRODUK;


END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `beforeInsert_dtrans_check` BEFORE INSERT ON `dtrans` FOR EACH ROW BEGIN
SET @harga = 0;
SET @qty = NEW.QTY_PRODUK;
SELECT HARGA_PRODUK INTO @harga FROM produk WHERE ROW_ID_PRODUK = NEW.ROW_ID_PRODUK;
SET NEW.HARGA_PRODUK = @harga;
SET NEW.SUBTOTAL = @harga * @qty;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `htrans`
--

CREATE TABLE `htrans` (
  `ROW_ID_HTRANS` int(11) NOT NULL,
  `TANGGAL_TRANS` datetime NOT NULL,
  `NO_NOTA` varchar(15) DEFAULT NULL,
  `TOTAL_TRANS` int(11) DEFAULT 0,
  `STATUS_PEMBAYARAN` int(11) NOT NULL COMMENT '0=Pending,  1= Accepted,  2=Rejected',
  `LOKASI_FOTO_BUKTI_PEMBAYARAN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `htrans`
--

INSERT INTO `htrans` (`ROW_ID_HTRANS`, `TANGGAL_TRANS`, `NO_NOTA`, `TOTAL_TRANS`, `STATUS_PEMBAYARAN`, `LOKASI_FOTO_BUKTI_PEMBAYARAN`) VALUES
(1, '2020-02-20 02:33:56', '2020022000001', 5604815, 1, NULL),
(2, '2020-03-18 02:35:55', '2020031800001', 0, 2, NULL),
(3, '2020-04-14 02:36:31', '2020041400001', 0, 0, NULL);

--
-- Triggers `htrans`
--
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

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `ROW_ID_KATEGORI` int(11) NOT NULL,
  `ID_KATEGORI` varchar(5) DEFAULT NULL,
  `NAMA_KATEGORI` varchar(30) NOT NULL,
  `STATUS_AKTIF_KATEGORI` varchar(1) NOT NULL COMMENT '1=aktif, 0= tidak aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`ROW_ID_KATEGORI`, `ID_KATEGORI`, `NAMA_KATEGORI`, `STATUS_AKTIF_KATEGORI`) VALUES
(1, 'BT001', 'BATH TUB', '1'),
(2, 'WA001', 'WASTAFEL', '0'),
(3, 'KE001', 'KERAMIK', '1'),
(6, 'BO001', 'BOHLAM', '1'),
(7, 'AP001', 'APPLIANCES', '1'),
(9, 'EA001', 'ELECTRICAL AND LIGHTING', '1'),
(10, 'RC001', 'RICE COOKER', '1');

--
-- Triggers `kategori`
--
DELIMITER $$
CREATE TRIGGER `beforeInsert_kategori_check` BEFORE INSERT ON `kategori` FOR EACH ROW BEGIN
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
-- Table structure for table `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `ROW_ID_PRODUK` int(11) NOT NULL,
  `ROW_ID_KATEGORI_PARENT` int(11) NOT NULL,
  `ROW_ID_KATEGORI_CHILD` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`ROW_ID_PRODUK`, `ROW_ID_KATEGORI_PARENT`, `ROW_ID_KATEGORI_CHILD`) VALUES
(5, 9, 6),
(6, 7, 2),
(7, 7, 10);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `ROW_ID_PRODUK` int(11) NOT NULL,
  `ID_PRODUK` varchar(5) DEFAULT NULL,
  `NAMA_PRODUK` varchar(255) NOT NULL,
  `STATUS_AKTIF_PRODUK` varchar(1) NOT NULL COMMENT '1 = aktif, 0 = tidak aktif',
  `HARGA_PRODUK` int(11) NOT NULL,
  `DIMENSI_KEMASAN` varchar(30) NOT NULL,
  `DIMENSI_PRODUK` varchar(30) NOT NULL,
  `BERAT_PRODUK` varchar(10) NOT NULL,
  `SATUAN_PRODUK` varchar(10) NOT NULL,
  `DESKRIPSI_PRODUK` text DEFAULT NULL,
  `LOKASI_FOTO_PRODUK` text DEFAULT NULL,
  `STOK_PRODUK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`ROW_ID_PRODUK`, `ID_PRODUK`, `NAMA_PRODUK`, `STATUS_AKTIF_PRODUK`, `HARGA_PRODUK`, `DIMENSI_KEMASAN`, `DIMENSI_PRODUK`, `BERAT_PRODUK`, `SATUAN_PRODUK`, `DESKRIPSI_PRODUK`, `LOKASI_FOTO_PRODUK`, `STOK_PRODUK`) VALUES
(3, 'CR001', 'CERAMAX ROJO FSB0371 W/HUNG BA', '1', 472500, '40cm X 40cm X 14cm', '38cm X 38cm X 12cm', '9 Kg', 'PCS', NULL, 'CERAMAX ROJO FSB0371 Wall Hung Wastafel\r\n\r\nSpesifikasi:\r\n\r\nTipe: Wall Hung Basin\r\nDimensi 380x380x120MM\r\nMaterial: Porselen\r\nFitur:\r\n\r\nHarga terjangkau\r\nMaterial berbahan porselen mudah dibersihkan dan tidak ada tepian yang tajam\r\nSistem pembuangan yang lancar\r\nDesain elegan\r\nHemat ruang', 54),
(4, 'CR002', 'CERAMAX ROJO FSB0372 W/HUNG BA', '1', 772500, '40cm X 40cm X 14cm', '38cm X 38cm X 12cm', '15 Kg', 'PCS', 'CERAMAX ROJO FSB0371 Wall Hung Wastafel\r\n\r\nSpesifikasi:\r\n\r\nTipe: Wall Hung Basin\r\nDimensi 380x380x120MM\r\nMaterial: Porselen\r\nFitur:\r\n\r\nHarga terjangkau\r\nMaterial berbahan porselen mudah dibersihkan dan tidak ada tepian yang tajam\r\nSistem pembuangan yang lancar\r\nDesain elegan\r\nHemat ruang', '', 6),
(5, 'P1001', 'PHILIPS 17401 59449 105 9W 65K MESON CD G3 (3PC)', '1', 195605, '14cm X 12cm X 12cm', '14cm X 12cm X 12cm', '200 gr', 'PCS', 'Keunggulan:\r\n\r\nLED Downlight dengan harga terjangku\r\nTermasuk lampu & driver terintegrasi, Anda bisa langsung\r\nmemasangnya\r\nMudah dipasang\r\nCahaya yang rata dengan diffuser anti silau\r\nHemat Listrik = Hemat Biaya!\r\nTahan lama, umur hingga 15.000 jam\r\nTersedia dalam berbagai macam pilihan ukuran & watt\r\nSpesifikasi:\r\n\r\nColor: Putih (cool day light)\r\nPower: 9W\r\nLumen: 650lm (6500K)\r\nDiameter: 120mm\r\nKetebalan: 47mm\r\nLubang Plafon / Cutout: 105mm / 4.1 inch\r\nKoneksi: flying wire\r\nUmur: hingga 15.000 jam\r\nCRI80\r\nIP20\r\n220-240V ~ 50-60 Hz\r\nTidak dapat diredupkan / Non Dimmable\r\nTidak dapat diganti lampu atau driver-nya saja\r\nUntuk pemakaian di dalam ruangan / Indoor use only', NULL, -11),
(6, 'TF001', 'TIDY FSA0042 WHITE ONE PIECE TOILET', '1', 1500000, '70cm X 44cm X 61cm', '68cm X 42cm X 59cm', '41kg', 'SET', 'TIDY FSA0042 WHITE ONE PIECE TOILET\r\n\r\nSpesifikasi:\r\n\r\nTipe: Monoblok / One piece toilet\r\nSistem pembuangan: Siphonic\r\nSoft closing seat cover\r\nAs/Jarak dinding/Rough-in/S-trap 300mm\r\nOutfall diameter 100mm\r\nMaterial: Porselen\r\nFitur:\r\n\r\nHarga relatif terjangkau\r\nOne piece toilet dengan ukuran yang sesuai dengan masyarakat Asia\r\nDesain modern\r\nHemat ruang\r\nSistem syphonic', NULL, 47),
(7, 'GX001', 'GLUCKLICH X01HI1 0.3LT 200W RICE COOKER', '1', 259000, '20cm X 20cm X 22cm', '18cm X 18cm X 20cm', '3kg', 'UNIT', 'Keunggulan:\r\n\r\nBagian dalam anti lengket\r\nFitur tetap hangat\r\nBahan lebih tebal\r\nPerlindungan sekering ganda\r\nPerlindungan suhu tunggi\r\nBaki pengukus tebal\r\nGaransi service 2 tahun\r\nDapat sendok, mangkuk takar, kabel\r\nSpesifikasi:\r\n\r\nGaris air: 0,3 liter\r\nVolume pot: 3 liter\r\nKetebalan: 0.75mm\r\nTegangan: 50/60Hz, 220V\r\nDaya: 200 Watt', NULL, 198);

--
-- Triggers `produk`
--
DELIMITER $$
CREATE TRIGGER `beforeInsert_produk_check` BEFORE INSERT ON `produk` FOR EACH ROW BEGIN
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
    SELECT COUNT(ROW_ID_PRODUK) + 1 INTO @ctr FROM produk WHERE ID_PRODUK LIKE concat(@prefix, '%');
    SELECT UPPER(CONCAT(@prefix, LPAD(@ctr,3,'0'))) INTO @prefix;
    SET NEW.ID_PRODUK = @prefix;   
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `ROW_ID_CUSTOMER` int(11) NOT NULL,
  `ROW_ID_PRODUK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`ROW_ID_CUSTOMER`, `ROW_ID_PRODUK`) VALUES
(6, 5),
(6, 6),
(7, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ROW_ID_CUSTOMER`,`ROW_ID_PRODUK`),
  ADD KEY `FK_CART_ROW_PRODUK` (`ROW_ID_PRODUK`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`ROW_ID_CUSTOMER`),
  ADD UNIQUE KEY `unique_customer_username` (`USERNAME`),
  ADD UNIQUE KEY `unique_customer_email` (`EMAIL`);

--
-- Indexes for table `dtrans`
--
ALTER TABLE `dtrans`
  ADD PRIMARY KEY (`ROW_ID_HTRANS`,`ROW_ID_PRODUK`),
  ADD KEY `FK_DTRANS_ROW_PRODUK` (`ROW_ID_PRODUK`);

--
-- Indexes for table `htrans`
--
ALTER TABLE `htrans`
  ADD PRIMARY KEY (`ROW_ID_HTRANS`),
  ADD UNIQUE KEY `unique_htrans_no_nota` (`NO_NOTA`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`ROW_ID_KATEGORI`);

--
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`ROW_ID_PRODUK`,`ROW_ID_KATEGORI_PARENT`,`ROW_ID_KATEGORI_CHILD`),
  ADD KEY `FK_KATEGORI_PRODUK_ROW_KAT_PARENT` (`ROW_ID_KATEGORI_PARENT`),
  ADD KEY `FK_KATEGORI_PRODUK_ROW_KAT_CHILD` (`ROW_ID_KATEGORI_CHILD`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`ROW_ID_PRODUK`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`ROW_ID_CUSTOMER`,`ROW_ID_PRODUK`),
  ADD KEY `FK_WISHLIST_ROW_PRODUK` (`ROW_ID_PRODUK`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `ROW_ID_CUSTOMER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `htrans`
--
ALTER TABLE `htrans`
  MODIFY `ROW_ID_HTRANS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `ROW_ID_KATEGORI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `ROW_ID_PRODUK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_CART_ROW_CUSTOMER` FOREIGN KEY (`ROW_ID_CUSTOMER`) REFERENCES `customer` (`ROW_ID_CUSTOMER`),
  ADD CONSTRAINT `FK_CART_ROW_PRODUK` FOREIGN KEY (`ROW_ID_PRODUK`) REFERENCES `produk` (`ROW_ID_PRODUK`);

--
-- Constraints for table `dtrans`
--
ALTER TABLE `dtrans`
  ADD CONSTRAINT `FK_DTRANS_ROW_HTRANS` FOREIGN KEY (`ROW_ID_HTRANS`) REFERENCES `htrans` (`ROW_ID_HTRANS`),
  ADD CONSTRAINT `FK_DTRANS_ROW_PRODUK` FOREIGN KEY (`ROW_ID_PRODUK`) REFERENCES `produk` (`ROW_ID_PRODUK`);

--
-- Constraints for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD CONSTRAINT `FK_KATEGORI_PRODUK_ROW_KAT_CHILD` FOREIGN KEY (`ROW_ID_KATEGORI_CHILD`) REFERENCES `kategori` (`ROW_ID_KATEGORI`),
  ADD CONSTRAINT `FK_KATEGORI_PRODUK_ROW_KAT_PARENT` FOREIGN KEY (`ROW_ID_KATEGORI_PARENT`) REFERENCES `kategori` (`ROW_ID_KATEGORI`),
  ADD CONSTRAINT `FK_KATEGORI_PRODUK_ROW_PRODUK` FOREIGN KEY (`ROW_ID_PRODUK`) REFERENCES `produk` (`ROW_ID_PRODUK`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `FK_WISHLIST_ROW_CUSTOMER` FOREIGN KEY (`ROW_ID_CUSTOMER`) REFERENCES `customer` (`ROW_ID_CUSTOMER`),
  ADD CONSTRAINT `FK_WISHLIST_ROW_PRODUK` FOREIGN KEY (`ROW_ID_PRODUK`) REFERENCES `produk` (`ROW_ID_PRODUK`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
