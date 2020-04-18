-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2020 at 10:07 PM
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
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `ROW_ID_CUSTOMER` int(11) NOT NULL,
  `USERNAME` varchar(20) NOT NULL,
  `PASSWORD` text NOT NULL,
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
(7, 'Jamesj1', 'jsj1', 'jamesjeff@gmail.com', 'James', 'Jefferson', 'L'),
(8, 'nadya', 'nadya1', 'nadya@gmail.com', 'nadya', 'hamdani', 'L'),
(9, 'arnold', 'arnold2', 'arnold@gmail.com', 'arnold', 'Christopher', 'L'),
(10, 'Raymond', 'raymond1', 'Raymond@yahoo.com', 'raymond', 'yaputra', 'L'),
(11, 'Felia', 'felia1', 'felia@gmail.com', 'felia', 'subagyo', 'P'),
(12, 'juan', 'juan1', 'juan@gmail.com', 'juan', 'tjipta', 'L'),
(13, 'angel', 'angel1', 'angel@gmail.com', 'angel', 'yaputri', 'P'),
(14, 'juci', 'juci1', 'juci@gmail.com', 'juci', 'tjipta', 'U'),
(15, 'hamdani', 'hamdani1', 'hamdani2@gmail.com', 'hamdani', 'evan', 'U');

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
(17, 11, 4, 1161000, 4644000);

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
(1, 1, '2020-02-20 02:33:56', '2020022000001', 5604815, 1, '1.jpg'),
(2, 1, '2020-03-18 02:35:55', '2020031800001', 0, 2, '2.jpg'),
(3, 1, '2020-04-14 02:36:31', '2020041400001', 4644000, 0, '3.jpg'),
(4, 1, '2020-04-16 02:01:01', '2020041600001', 8687000, 1, NULL),
(5, 2, '2020-04-17 02:01:44', '2020041700001', 0, 0, NULL),
(6, 2, '2020-04-17 02:02:04', '2020041700002', 1145082, 2, NULL),
(7, 2, '2020-04-17 02:02:25', '2020041700003', 3000000, 0, NULL),
(8, 2, '2020-04-17 02:02:38', '2020041700004', 3423000, 1, NULL),
(11, 5, '2020-04-17 02:03:42', '2020041700005', 0, 1, NULL),
(12, 5, '2020-04-17 02:03:54', '2020041700006', 5805000, 0, NULL),
(13, 5, '2020-04-17 02:04:03', '2020041700007', 0, 2, NULL),
(14, 5, '2020-04-17 02:04:16', '2020041700008', 195605, 1, NULL),
(15, 5, '2020-04-17 02:04:28', '2020041700009', 2112800, 1, NULL),
(16, 5, '2020-04-17 02:04:39', '2020041700010', 19311000, 2, NULL),
(17, 2, '2020-04-17 02:04:48', '2020041700011', 4644000, 1, NULL);

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
(10, 'RC001', 'RICE COOKER', '1'),
(20, 'HD001', 'HOME DECORATION', '1'),
(21, 'FA001', 'FLOOR AND WALL', '0'),
(22, 'HI001', 'HOME IMPROVEMENT', '0'),
(23, 'OU001', 'OUTDOOR', '1'),
(24, 'SA001', 'SAFETY AND  SECURITY', '0'),
(25, 'KI001', 'KITCHEN', '1'),
(26, 'TA001', 'TOOL AND HARDWARE', '0'),
(27, 'DA001', 'DOOR AND WINDOW', '1');

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
(7, 7, 10),
(8, 3, 27),
(9, 20, 27),
(10, 20, 27),
(11, 7, 22),
(13, 25, 26),
(14, 25, 9),
(16, 7, 26);

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
(3, 'CR001', 'CERAMAX ROJO FSB0371 W/HUNG BASIN', '1', 472500, '40cm X 40cm X 14cm', '38cm X 38cm X 12cm', '9 Kg', 'PCS', 'CERAMAX ROJO FSB0371 Wall Hung Wastafel\r\n\r\nSpesifikasi:\r\n\r\nTipe: Wall Hung Basin\r\nDimensi 380x380x120MM\r\nMaterial: Porselen\r\nFitur:\r\n\r\nHarga terjangkau\r\nMaterial berbahan porselen mudah dibersihkan dan tidak ada tepian yang tajam\r\nSistem pembuangan yang lancar\r\nDesain elegan\r\nHemat ruang', 'res/img/produk/CR001.jpg', 54),
(5, 'P1001', 'PHILIPS 17401 59449 105 9W 65K MESON CD G3 (3PC)', '1', 195605, '14cm X 12cm X 12cm', '14cm X 12cm X 12cm', '200 gr', 'PCS', 'Keunggulan:\r\n\r\nLED Downlight dengan harga terjangku\r\nTermasuk lampu & driver terintegrasi, Anda bisa langsung\r\nmemasangnya\r\nMudah dipasang\r\nCahaya yang rata dengan diffuser anti silau\r\nHemat Listrik = Hemat Biaya!\r\nTahan lama, umur hingga 15.000 jam\r\nTersedia dalam berbagai macam pilihan ukuran & watt\r\nSpesifikasi:\r\n\r\nColor: Putih (cool day light)\r\nPower: 9W\r\nLumen: 650lm (6500K)\r\nDiameter: 120mm\r\nKetebalan: 47mm\r\nLubang Plafon / Cutout: 105mm / 4.1 inch\r\nKoneksi: flying wire\r\nUmur: hingga 15.000 jam\r\nCRI80\r\nIP20\r\n220-240V ~ 50-60 Hz\r\nTidak dapat diredupkan / Non Dimmable\r\nTidak dapat diganti lampu atau driver-nya saja\r\nUntuk pemakaian di dalam ruangan / Indoor use only', 'res/img/produk/P1001.jpg', -12),
(6, 'TF001', 'TIDY FSA0042 WHITE ONE PIECE TOILET', '1', 1500000, '70cm X 44cm X 61cm', '68cm X 42cm X 59cm', '41kg', 'SET', 'TIDY FSA0042 WHITE ONE PIECE TOILET\r\n\r\nSpesifikasi:\r\n\r\nTipe: Monoblok / One piece toilet\r\nSistem pembuangan: Siphonic\r\nSoft closing seat cover\r\nAs/Jarak dinding/Rough-in/S-trap 300mm\r\nOutfall diameter 100mm\r\nMaterial: Porselen\r\nFitur:\r\n\r\nHarga relatif terjangkau\r\nOne piece toilet dengan ukuran yang sesuai dengan masyarakat Asia\r\nDesain modern\r\nHemat ruang\r\nSistem syphonic', 'res/img/produk/TF001.jpg', 45),
(7, 'GX001', 'GLUCKLICH X01HI1 0.3LT 200W RICE COOKER', '1', 259000, '20cm X 20cm X 22cm', '18cm X 18cm X 20cm', '3kg', 'UNIT', 'Keunggulan:\r\n\r\nBagian dalam anti lengket\r\nFitur tetap hangat\r\nBahan lebih tebal\r\nPerlindungan sekering ganda\r\nPerlindungan suhu tunggi\r\nBaki pengukus tebal\r\nGaransi service 2 tahun\r\nDapat sendok, mangkuk takar, kabel\r\nSpesifikasi:\r\n\r\nGaris air: 0,3 liter\r\nVolume pot: 3 liter\r\nKetebalan: 0.75mm\r\nTegangan: 50/60Hz, 220V\r\nDaya: 200 Watt', 'res/img/produk/GX001.jpg', 198),
(8, 'TA001', 'TIDY ALUMIX PVC MIN KC 2 / 02', '1', 1593150, '100cm x 100cm x 100cm', '20cm x 20cm x 20cm', '10KG', 'PCS', 'Ringan dan Kokoh -Tahan terhadap air -Tidak berkarat -Menggunakan kusen aluminium sehingga lebih awet dan tahan lama -Tidak berubah bentuk akibat cuaca', 'res/img/produk/TA001.jpg', 2000),
(9, 'DU001', 'DOORWAY UPVC DOOR HW017L 3/4KC', '0', 1056400, '70cm x 70cm x 70cm', '20cm x 20 cm x 18cm', '4kg', 'UNIT', 'Pintu uPVC yang cocok untuk pintu kamar mandi, karena keunggulanya yaitu tahan air, tahan rayap, dan kokoh. ditambahkan lagi uPVC merupakan bahan yang akan meredam suara dan ramah lingkungan', 'res/img/produk/DU001.jpg', 98),
(10, 'NF001', 'NIRO FLEUR GFL03 MARIGOLD PGVT', '0', 381694, '80cm x 80cm x 80cm', '19cm x 19cm x 19cm', '8kg', 'BOX', 'Granite Niro Exclusive Design Only at Mitra10. Granite lantai Glazed Polsihed Digital ukuran 80x80 glossy surface memberikan nuansa mewah untuk ruangan anda\r\n\r\n\r\nFungsi: granite porcelain, porcelain tiles, granite lantai, granite polished, granite 80x80, granite digital, granite niro, granite glaze\r\n\r\nGranite Niro Exclusive Design Only at Mitra10. Granite lantai Glazed Polsihed Digital ukuran 80x80 glossy surface memberikan nuansa mewah untuk ruangan anda\r\n\r\n\r\nFungsi: granite porcelain, porcelain tiles, granite lantai, granite polished, granite 80x80, granite digital, granite niro, granite glaze', 'res/img/produk/NF001.jpg', 8997),
(11, 'ZT001', 'ZEHN TANGGA ALUMINIUM YKF-403 ( 3 X 4 STEP )', '1', 1161000, '20cm x 30cm x 30cm', '19cm x 20cm x 20cm', '20kg', 'SET', 'Zehn Tangga Aluminium 403 adalah jenis tangga yang bisa dilipat empat, dengan total panjang 3,70 m. Tangga ini bisa disetel/adjust (multipurpose)', 'res/img/produk/ZT001.jpg', 937),
(13, 'PP001', 'POLYTRON PRM 28 QS/QB MIRROR 2D REFRIGERATOR', '0', 4099000, '75cm x 75cm x 75cm', '45cm x 45cm x 45', '20kg', 'SET', 'Polytron Belleza 3 hadir dengan mengusung “Zen Design” yang memberikan keseimbangan antara penyempurnaan tampilan dalam (interior) dan tampilan luar (eksterior) dengan menampilkan sentuhan borderless.', 'res/img/produk/PP001.jpg', 745),
(14, 'EE001', 'ELECTROLUX ETS 3505 POP UP TOASTER', '0', 489000, '43cm x 43cm x 42cm', '34cm x 34cm x 34cm', '25kg', 'UNIT', 'ELECTROLUX ETS 3505 POP UP TOASTER\r\n\r\nMemanggang roti dengan kematangan yang sempurna. Membuat sarapan Anda tersaji dengan lebih baik dan lebih cepat.', 'res/img/produk/EE001.jpg', 492),
(16, 'PM001', 'PANASONIC MC-CG300X546 VACUUM CLEANER', '0', 1169000, '35cm x 35cm x 35cm', '40cm x 40cm x 40cm', '45kg', 'SET', 'Panasonic MC-CG300X546 merupakan vacuum cleaner yang dapat membersihkan ruangan dari debu, bakteri, jamur, tungau dan allergen lainnya. Dengan Panasonic MC-CG300X546 Anda dapat membersihkan rumah dengan mudah tanpa membutuhkan tenaga ekstra dan menyita banyak waktu Anda.', 'res/img/produk/PM001.jpg', 644);

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
(1, 5),
(6, 5),
(6, 6),
(7, 7),
(7, 16),
(9, 8),
(10, 9),
(10, 14),
(11, 11),
(12, 7),
(13, 6),
(14, 13);

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
  ADD UNIQUE KEY `unique_htrans_no_nota` (`NO_NOTA`),
  ADD KEY `FK_HTRANS_CUSTOMER` (`ROW_ID_CUSTOMER`);

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
  MODIFY `ROW_ID_CUSTOMER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `htrans`
--
ALTER TABLE `htrans`
  MODIFY `ROW_ID_HTRANS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `ROW_ID_KATEGORI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `ROW_ID_PRODUK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
-- Constraints for table `htrans`
--
ALTER TABLE `htrans`
  ADD CONSTRAINT `FK_HTRANS_CUSTOMER` FOREIGN KEY (`ROW_ID_CUSTOMER`) REFERENCES `customer` (`ROW_ID_CUSTOMER`);

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
