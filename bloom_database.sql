-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for bloom
DROP DATABASE IF EXISTS `bloom`;
CREATE DATABASE IF NOT EXISTS `bloom` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `bloom`;

-- Dumping structure for table bloom.chudegopy
DROP TABLE IF EXISTS `chudegopy`;
CREATE TABLE IF NOT EXISTS `chudegopy` (
  `cdgy_ma` int(11) NOT NULL,
  `cdgy_ten` varchar(255) NOT NULL,
  PRIMARY KEY (`cdgy_ma`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table bloom.chudegopy: ~0 rows (approximately)

-- Dumping structure for table bloom.dondathang
DROP TABLE IF EXISTS `dondathang`;
CREATE TABLE IF NOT EXISTS `dondathang` (
  `dh_ma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dh_ngaylap` datetime NOT NULL,
  `dh_ngaygiao` datetime DEFAULT NULL,
  `dh_noigiao` varchar(255) DEFAULT '0',
  `dh_trangthaithanhtoan` int(11) DEFAULT NULL,
  `httt_ma` int(11) unsigned NOT NULL,
  `kh_tendangnhap` varchar(50) NOT NULL,
  PRIMARY KEY (`dh_ma`),
  KEY `FK_dondathang_hinhthucthanhtoan` (`httt_ma`),
  KEY `FK_dondathang_khachhang` (`kh_tendangnhap`),
  CONSTRAINT `FK_dondathang_hinhthucthanhtoan` FOREIGN KEY (`httt_ma`) REFERENCES `hinhthucthanhtoan` (`httt_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_dondathang_khachhang` FOREIGN KEY (`kh_tendangnhap`) REFERENCES `khachhang` (`kh_tendangnhap`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bloom.dondathang: ~5 rows (approximately)
INSERT INTO `dondathang` (`dh_ma`, `dh_ngaylap`, `dh_ngaygiao`, `dh_noigiao`, `dh_trangthaithanhtoan`, `httt_ma`, `kh_tendangnhap`) VALUES
	(28, '2023-11-30 22:41:11', '0000-00-00 00:00:00', 'Cần Thơ', 0, 3, 'admin'),
	(29, '2023-11-30 23:21:21', '0000-00-00 00:00:00', 'Cần Thơ', 0, 3, 'admin'),
	(32, '2023-11-30 23:27:27', '0000-00-00 00:00:00', 'Cần Thơ', 0, 3, 'admin'),
	(33, '2023-11-30 23:29:08', '0000-00-00 00:00:00', 'Cần Thơ', 0, 1, 'admin'),
	(34, '2023-11-30 23:33:26', '0000-00-00 00:00:00', 'Cần Thơ', 0, 3, 'admin'),
	(35, '2023-11-30 23:34:45', '0000-00-00 00:00:00', 'Cần Thơ', 0, 1, 'admin'),
	(36, '2023-11-30 23:36:26', '0000-00-00 00:00:00', 'Cần Thơ', 0, 3, 'admin'),
	(37, '2023-11-30 23:40:29', '0000-00-00 00:00:00', 'Cần Thơ', 0, 2, 'admin'),
	(38, '2023-11-30 23:41:39', '0000-00-00 00:00:00', 'Cần Thơ', 0, 2, 'admin'),
	(39, '2023-11-30 23:42:13', '0000-00-00 00:00:00', 'Cần Thơ', 0, 1, 'admin'),
	(40, '2023-11-30 23:42:40', '0000-00-00 00:00:00', 'Cần Thơ', 0, 1, 'admin'),
	(41, '2023-11-30 23:44:44', '0000-00-00 00:00:00', 'Cần Thơ', 0, 1, 'admin'),
	(42, '2023-11-30 23:45:51', '0000-00-00 00:00:00', 'Cần Thơ', 0, 1, 'admin'),
	(43, '2023-11-30 23:47:49', '0000-00-00 00:00:00', 'Cần Thơ', 0, 2, 'admin'),
	(44, '2023-11-30 23:51:24', '0000-00-00 00:00:00', 'Cần Thơ', 0, 1, 'admin'),
	(45, '2023-11-30 23:51:52', '0000-00-00 00:00:00', 'Cần Thơ', 0, 3, 'admin');

-- Dumping structure for table bloom.gopy
DROP TABLE IF EXISTS `gopy`;
CREATE TABLE IF NOT EXISTS `gopy` (
  `gy_ma` int(11) NOT NULL,
  `gy_hoten` varchar(45) DEFAULT NULL,
  `gy_email` varchar(45) DEFAULT NULL,
  `gy_diachi` varchar(100) DEFAULT NULL,
  `gy_dienthoai` varchar(45) DEFAULT NULL,
  `gy_tieude` varchar(255) DEFAULT NULL,
  `gy_noidung` text DEFAULT NULL,
  `gy_ngaygopy` datetime DEFAULT NULL,
  `cdgy_ma` int(11) DEFAULT NULL,
  PRIMARY KEY (`gy_ma`) USING BTREE,
  KEY `gopy_chudegopy_idx` (`cdgy_ma`) USING BTREE,
  CONSTRAINT `gopy_ibfk_1` FOREIGN KEY (`cdgy_ma`) REFERENCES `chudegopy` (`cdgy_ma`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table bloom.gopy: ~0 rows (approximately)

-- Dumping structure for table bloom.hinhsanpham
DROP TABLE IF EXISTS `hinhsanpham`;
CREATE TABLE IF NOT EXISTS `hinhsanpham` (
  `hsp_ma` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hsp_tentaptin` varchar(255) DEFAULT NULL,
  `sp_ma` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`hsp_ma`),
  KEY `FK_hinhsanpham_sanpham` (`sp_ma`),
  CONSTRAINT `FK_hinhsanpham_sanpham` FOREIGN KEY (`sp_ma`) REFERENCES `sanpham` (`sp_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bloom.hinhsanpham: ~15 rows (approximately)
INSERT INTO `hinhsanpham` (`hsp_ma`, `hsp_tentaptin`, `sp_ma`) VALUES
	(9, '20231126_214422_hoa_hong_2.jpg', 1),
	(10, '20230908_172800_huong_duong.webp', 2),
	(11, '20230908_172806_cam_chuong.jpg', 3),
	(12, '20230908_172811_ho_diep.webp', 4),
	(15, '20230911_172249_lily.jpg', 5),
	(16, '20231126_093910_20231121_215151_hoa_tong_hop.webp', 15),
	(17, '20231126_093923_20231121_215219_hoa_tong_hop_2.webp', 15),
	(18, '20231126_093933_20231121_215252_hoa_tong_hop_3.webp', 15),
	(19, '20231126_093955_20231121_215042_hoa_rum.webp', 16),
	(20, '20231126_094007_20231121_215059_hoa_rum_2.webp', 16),
	(21, '20231126_094020_20231121_215116_hoa_rum_3.webp', 16),
	(22, '20231126_094032_20231121_215322_lan-nghe_thuat.webp', 17),
	(23, '20231126_094040_20231121_215338_lan_nghe_thuat_2.webp', 17),
	(24, '20231126_213548_bo_cong_anh.jpg', 11),
	(25, '20231126_214139_lavander.jpg', 6),
	(26, '20231126_214430_hoa_hong_3.jpg', 1);

-- Dumping structure for table bloom.hinhthucthanhtoan
DROP TABLE IF EXISTS `hinhthucthanhtoan`;
CREATE TABLE IF NOT EXISTS `hinhthucthanhtoan` (
  `httt_ma` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `httt_ten` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`httt_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bloom.hinhthucthanhtoan: ~3 rows (approximately)
INSERT INTO `hinhthucthanhtoan` (`httt_ma`, `httt_ten`) VALUES
	(1, 'Tiền mặt'),
	(2, 'Chuyển khoản'),
	(3, 'Ship COD');

-- Dumping structure for table bloom.khachhang
DROP TABLE IF EXISTS `khachhang`;
CREATE TABLE IF NOT EXISTS `khachhang` (
  `kh_tendangnhap` varchar(50) NOT NULL DEFAULT 'guest',
  `kh_matkhau` varchar(100) DEFAULT NULL,
  `kh_ho` varchar(100) NOT NULL,
  `kh_ten` varchar(50) NOT NULL,
  `kh_diachi` varchar(100) NOT NULL,
  `kh_dienthoai` varchar(50) NOT NULL,
  `kh_quantri` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`kh_tendangnhap`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bloom.khachhang: ~5 rows (approximately)
INSERT INTO `khachhang` (`kh_tendangnhap`, `kh_matkhau`, `kh_ho`, `kh_ten`, `kh_diachi`, `kh_dienthoai`, `kh_quantri`) VALUES
	('admin', 'bcbe3365e6ac95ea2c0343a2395834dd', 'Admin', 'Admin', 'abc street4678', '0123456789', 0),
	('guest', '', 'testooo', 'ugagaboogaaa', 'eeeeeeeee', '22222222222222', 0),
	('phung', 'bcbe3365e6ac95ea2c0343a2395834dd', 'Nguyễn Duy Diễm', 'Phụng', 'def', '082-6745-666', 1),
	('test', 'bcbe3365e6ac95ea2c0343a2395834dd', 'Người dùng', 'test', '', '332233322233', 0),
	('uggbu', 'bcbe3365e6ac95ea2c0343a2395834dd', 'ugga', 'booga', 'dcsedft advbgfh', '0111122223456', 0);

-- Dumping structure for table bloom.khuyenmai
DROP TABLE IF EXISTS `khuyenmai`;
CREATE TABLE IF NOT EXISTS `khuyenmai` (
  `km_ma` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `km_ten` varchar(100) DEFAULT NULL,
  `km_tungay` datetime DEFAULT NULL,
  `km_denngay` datetime DEFAULT curdate(),
  PRIMARY KEY (`km_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bloom.khuyenmai: ~4 rows (approximately)
INSERT INTO `khuyenmai` (`km_ma`, `km_ten`, `km_tungay`, `km_denngay`) VALUES
	(1, 'valentine giảm 50% cho mỗi bó bông hồng', '2024-02-14 00:00:00', '2024-02-14 23:59:59'),
	(2, 'giảm 10%', '2023-08-18 00:00:00', '2023-08-30 23:59:59'),
	(3, 'giảm 30%', '2023-09-04 00:00:00', '2023-09-05 12:00:00'),
	(4, 'giảm 100% - miễn phí 1 bó hoa', '2023-08-14 19:42:44', '2023-08-14 19:42:45');

-- Dumping structure for table bloom.loaisanpham
DROP TABLE IF EXISTS `loaisanpham`;
CREATE TABLE IF NOT EXISTS `loaisanpham` (
  `lsp_ma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lsp_ten` varchar(100) DEFAULT NULL,
  `lsp_tentaptin` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`lsp_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bloom.loaisanpham: ~6 rows (approximately)
INSERT INTO `loaisanpham` (`lsp_ma`, `lsp_ten`, `lsp_tentaptin`) VALUES
	(1, 'Hoa tình yêu', '20231126_085822_20231118_100703_tinh_yeu.jpg'),
	(2, 'Hoa cảm ơn', '20231126_085901_20231118_100727_cam_on.png'),
	(3, 'Hoa chúc mừng', '20231126_085915_20231118_100738_chuc_mung.jpg'),
	(4, 'Hoa sinh nhật', '20231126_085932_20231118_102020_sinh_nhat_2.jpg'),
	(7, 'Hoa tình bạn', '20231126_085948_20231118_100756_tinh_ban.jpg'),
	(8, 'Hoa trang trí', '20231126_090003_20231118_100811_trang_tri.jpg');

-- Dumping structure for table bloom.sanpham
DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `sp_ma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sp_ten` varchar(100) NOT NULL,
  `sp_gia` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sp_giacu` decimal(12,2) DEFAULT 0.00,
  `sp_mota` text DEFAULT NULL,
  `sp_soluong` int(100) unsigned NOT NULL DEFAULT 0,
  `lsp_ma` int(11) unsigned DEFAULT NULL,
  `km_ma` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`sp_ma`),
  KEY `FK_sanpham_loaisanpham` (`lsp_ma`),
  KEY `FK_sanpham_khuyenmai` (`km_ma`),
  CONSTRAINT `FK_sanpham_khuyenmai` FOREIGN KEY (`km_ma`) REFERENCES `khuyenmai` (`km_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_sanpham_loaisanpham` FOREIGN KEY (`lsp_ma`) REFERENCES `loaisanpham` (`lsp_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bloom.sanpham: ~10 rows (approximately)
INSERT INTO `sanpham` (`sp_ma`, `sp_ten`, `sp_gia`, `sp_giacu`, `sp_mota`, `sp_soluong`, `lsp_ma`, `km_ma`) VALUES
	(1, 'hoa hồng', 1200000.00, 0.00, 'hồng xinh xắn, đẹp dễ thương, tươi tốt', 20, 1, 1),
	(2, 'hoa hướng dương', 600000.00, 720000.00, 'hướng dương', 13, 7, NULL),
	(3, 'hoa cẩm chướng', 3300000.00, 2970000.00, NULL, 45, 3, 2),
	(4, 'lan hồ điệp', 2500000.00, 0.00, 'hồ điệp đẹp', 8, 3, NULL),
	(5, 'hoa ly', 800000.00, 560000.00, 'nhỏ', 50, 3, 3),
	(6, 'lavender', 150000.00, 170000.00, 'lavender tím', 2, 8, NULL),
	(11, 'hoa bồ công anh', 3100000.00, 0.00, 'bồ công anhhh', 70, 3, NULL),
	(15, 'Hoa tồng hợp', 3500000.00, 0.00, 'đỏ và trắng', 10, 1, NULL),
	(16, 'hoa rum', 600000.00, 700000.00, '', 50, 3, NULL),
	(17, 'Lan nghệ thuật', 5000000.00, 0.00, '', 2, 8, NULL);

-- Dumping structure for table bloom.sanpham_dondathang
DROP TABLE IF EXISTS `sanpham_dondathang`;
CREATE TABLE IF NOT EXISTS `sanpham_dondathang` (
  `sp_ma` int(11) unsigned NOT NULL,
  `dh_ma` int(11) unsigned NOT NULL,
  `sp_dh_soluong` int(11) NOT NULL,
  `sp_dh_dongia` decimal(12,2) NOT NULL,
  PRIMARY KEY (`sp_ma`,`dh_ma`),
  KEY `FK_sanpham_dondathang_dondathang` (`dh_ma`),
  CONSTRAINT `FK_sanpham_dondathang_dondathang` FOREIGN KEY (`dh_ma`) REFERENCES `dondathang` (`dh_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_sanpham_dondathang_sanpham` FOREIGN KEY (`sp_ma`) REFERENCES `sanpham` (`sp_ma`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bloom.sanpham_dondathang: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
