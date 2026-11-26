/*
 Navicat Premium Dump SQL

 Source Server         : Lokal
 Source Server Type    : MySQL
 Source Server Version : 100428 (10.4.28-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : siap

 Target Server Type    : MySQL
 Target Server Version : 100428 (10.4.28-MariaDB)
 File Encoding         : 65001

 Date: 26/11/2026 19:26:04
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for absensi
-- ----------------------------
DROP TABLE IF EXISTS `absensi`;
CREATE TABLE `absensi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) DEFAULT NULL,
  `karyawan_id` bigint(20) DEFAULT NULL,
  `jenis_absen` varchar(20) DEFAULT NULL,
  `tanggal_waktu` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT ' 0 = Foto Belum Divalidasi\r\n 1 = Validasi Ditolak\r\n 2 = Validasi Diterima',
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of absensi
-- ----------------------------
BEGIN;
INSERT INTO `absensi` (`id`, `cabang_id`, `karyawan_id`, `jenis_absen`, `tanggal_waktu`, `status`, `keterangan`) VALUES (1, 2, 1, 'Masuk', '2024-12-15 08:37:06', 1, NULL);
INSERT INTO `absensi` (`id`, `cabang_id`, `karyawan_id`, `jenis_absen`, `tanggal_waktu`, `status`, `keterangan`) VALUES (2, 2, 1, 'Masuk', '2024-12-15 14:01:49', 1, NULL);
INSERT INTO `absensi` (`id`, `cabang_id`, `karyawan_id`, `jenis_absen`, `tanggal_waktu`, `status`, `keterangan`) VALUES (3, 2, 1, 'Masuk', '2024-12-15 14:21:31', 0, NULL);
INSERT INTO `absensi` (`id`, `cabang_id`, `karyawan_id`, `jenis_absen`, `tanggal_waktu`, `status`, `keterangan`) VALUES (4, 2, 1, 'Pulang', '2024-12-15 14:21:35', 1, NULL);
INSERT INTO `absensi` (`id`, `cabang_id`, `karyawan_id`, `jenis_absen`, `tanggal_waktu`, `status`, `keterangan`) VALUES (5, 2, 1, 'Masuk', '2024-12-15 14:21:40', 1, NULL);
INSERT INTO `absensi` (`id`, `cabang_id`, `karyawan_id`, `jenis_absen`, `tanggal_waktu`, `status`, `keterangan`) VALUES (6, 2, 1, 'Pulang', '2024-12-15 14:21:45', 1, NULL);
INSERT INTO `absensi` (`id`, `cabang_id`, `karyawan_id`, `jenis_absen`, `tanggal_waktu`, `status`, `keterangan`) VALUES (7, 2, 1, 'Masuk', '2024-12-15 14:21:50', 1, NULL);
INSERT INTO `absensi` (`id`, `cabang_id`, `karyawan_id`, `jenis_absen`, `tanggal_waktu`, `status`, `keterangan`) VALUES (9, 2, 1, 'Masuk', '2024-12-16 16:53:52', 1, NULL);
INSERT INTO `absensi` (`id`, `cabang_id`, `karyawan_id`, `jenis_absen`, `tanggal_waktu`, `status`, `keterangan`) VALUES (10, 2, 1, 'Masuk', '2024-12-16 18:36:07', 0, NULL);
INSERT INTO `absensi` (`id`, `cabang_id`, `karyawan_id`, `jenis_absen`, `tanggal_waktu`, `status`, `keterangan`) VALUES (11, 2, 1, 'Masuk', '2024-12-17 07:36:29', 0, NULL);
INSERT INTO `absensi` (`id`, `cabang_id`, `karyawan_id`, `jenis_absen`, `tanggal_waktu`, `status`, `keterangan`) VALUES (12, 2, 1, 'Masuk', '2025-10-08 15:12:48', 0, NULL);
COMMIT;

-- ----------------------------
-- Table structure for bank
-- ----------------------------
DROP TABLE IF EXISTS `bank`;
CREATE TABLE `bank` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_bank` varchar(255) DEFAULT NULL,
  `nama_rekening` varchar(255) DEFAULT NULL,
  `nomor_rekening` varchar(255) DEFAULT NULL,
  `kantor_cabang` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of bank
-- ----------------------------
BEGIN;
INSERT INTO `bank` (`id`, `nama_bank`, `nama_rekening`, `nomor_rekening`, `kantor_cabang`) VALUES (1, 'Bank Central Asia', 'FREN COOL GROUP PT', '811-530-858-7', NULL);
INSERT INTO `bank` (`id`, `nama_bank`, `nama_rekening`, `nomor_rekening`, `kantor_cabang`) VALUES (2, 'Bank Rakyat Indonesia', 'Khairul Amri Dalimunthe', '208301034529501', NULL);
INSERT INTO `bank` (`id`, `nama_bank`, `nama_rekening`, `nomor_rekening`, `kantor_cabang`) VALUES (3, 'BRI', 'FREN COOL GROUP PT', '208301000717302', 'KCP WILLEM ISKANDAR');
COMMIT;

-- ----------------------------
-- Table structure for barang
-- ----------------------------
DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `foto` varchar(255) DEFAULT NULL,
  `kode` varchar(255) CHARACTER SET utf32 COLLATE utf32_general_ci DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `merek` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `tipe` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `kapasitas_pk` decimal(10,2) DEFAULT NULL,
  `btuh` decimal(20,2) DEFAULT NULL,
  `ukuran` decimal(20,2) DEFAULT NULL,
  `satuan_id` bigint(20) DEFAULT NULL,
  `harga_beli` decimal(20,2) DEFAULT NULL,
  `harga_jual` decimal(20,2) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `diskon_jenis_customer` text DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `cap` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of barang
-- ----------------------------
BEGIN;
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (4, NULL, '001', 'AC', 'DAIKIN', 'STC15YV', 'SPLIT WALL MOUNTED', 'SUPER MINI SPLIT (SMS)', 0.50, 5000.00, NULL, 6, 3706540.00, 3840000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STC15YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (6, NULL, '001', 'AC', 'DAIKIN', 'STC25YV', 'SPLIT WALL MOUNTED', 'SUPER MINI SPLIT (SMS)', 1.00, 9000.00, NULL, 6, 4391993.00, 4570000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STC25YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (7, NULL, '001', 'AC', 'DAIKIN', 'STC35YV', 'SPLIT WALL MOUNTED', 'SUPER MINI SPLIT (SMS)', 1.50, 12000.00, NULL, 6, 5440693.00, 5600000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STC35YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (8, NULL, '001', 'AC', 'DAIKIN', 'STC50YV', 'SPLIT WALL MOUNTED', 'SUPER MINI SPLIT (SMS)', 2.00, 17100.00, NULL, 6, 7251269.00, 7550000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STC50YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (9, NULL, '001', 'AC', 'DAIKIN', 'STP15AV', 'SPLIT WALL MOUNTED', 'BREEZE', 0.50, 5000.00, NULL, 6, 2956000.00, 3300000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STP15AV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (10, NULL, '001', 'AC', 'DAIKIN', 'STKE15YV', 'SPLIT WALL MOUNTED', 'BETA INVERTER', 0.50, 5000.00, NULL, 6, 4558426.00, 4600000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKE15YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (11, NULL, '001', 'AC', 'DAIKIN', 'STKE20YV', 'SPLIT WALL MOUNTED', 'BETA INVERTER', 0.75, 7000.00, NULL, 6, 4734000.00, 4930000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKE20YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (12, NULL, '001', 'AC', 'DAIKIN', 'STKE25YV', 'SPLIT WALL MOUNTED', 'BETA INVERTER', 1.00, 9000.00, NULL, 6, 5029987.00, 5240000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKE25YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (13, NULL, '001', 'AC', 'DAIKIN', 'STKE35YV', 'SPLIT WALL MOUNTED', 'BETA INVERTER', 1.50, 12300.00, NULL, 6, 6148790.00, 6400000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKE35YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (14, NULL, '001', 'AC', 'DAIKIN', 'STKE50YV', 'SPLIT WALL MOUNTED', 'BETA INVERTER', 2.00, 18000.00, NULL, 6, 8340000.00, 8410000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKE50YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (15, NULL, '001', 'AC', 'DAIKIN', 'STKH15YV', 'SPLIT WALL MOUNTED', 'ALFA INVERTER', 0.50, 5100.00, NULL, 6, 5920000.00, 6220000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKH15YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (16, NULL, '001', 'AC', 'DAIKIN', 'STKH50YV /IU-FTKH50YV14 /OU-RKH50YV14', 'SPLIT WALL MOUNTED', 'ALFA INVERTER', 2.00, 19000.00, NULL, 6, 10633000.00, 12170000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKH50YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (17, NULL, '001', 'AC', 'MIDEA', 'MSFCE-05CRN2X', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2303000.00, 2400000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFCE-05CRN2X', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (18, NULL, '001', 'AC', 'MIDEA', 'MSAFE-05CRN2X', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2401000.00, 2480000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSAFE-05CRN2X', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (19, NULL, '001', 'AC', 'GREE', 'GWC-05N1A', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 3289000.00, 3510000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'GWC-05N1A', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (20, NULL, '001', 'AC', 'GREE', 'GWC-09N1A', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9300.00, NULL, 6, 3939000.00, 4176000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'GWC-09N1A', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (21, NULL, '001', 'AC', 'AQUA', 'AQA-KCR9FQDL', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2778300.00, 3180000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AQA-KCR9FQDL', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (22, NULL, '001', 'AC', 'PANASONIC', 'YN18WKJ', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 6300000.00, 6600000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'YN18WKJ', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (23, NULL, '001', 'AC', 'SHARP', 'AH-A5BEY', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2793000.00, 2850000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A5BEY', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (24, NULL, '001', 'AC', 'SHARP', 'AH-A9BEY', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3243800.00, 3350000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A9BEY', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (25, NULL, '001', 'AC', 'SHARP', 'AH-A9DEY', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3105000.00, 3225000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A9DEY', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (27, NULL, '001', 'AC', 'POLYTRON', 'PAC05VZI', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2827300.00, 2920000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'PAC05VZI', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (28, NULL, '001', 'AC', 'POLYTRON', 'PAC09VH', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3023300.00, 3120000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'PAC09VH', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (30, NULL, '001', 'AC', 'POLYTRON', 'PAC18VH', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 6050000.00, 6240000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'PAC18VH', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (31, NULL, '001', 'AC', 'TCL', 'TAC05CSD', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2597000.00, 2680000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'TAC05CSD', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (32, NULL, '001', 'AC', 'TCL', 'TAC09CSD', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2744000.00, 2830000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'TAC09CSD', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (33, NULL, '001', 'AC', 'TCL', 'TAC18CSD', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 5096000.00, 5250000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'TAC18CSD', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (34, NULL, '001', 'AC', 'BESTLIFE', 'BEST05SUMO', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2254000.00, 2330000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'BEST05SUMO', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (35, NULL, '001', 'AC', 'BESTLIFE', 'BEST09SUMO', 'SPLIT WALL MOUNTED	', 'STANDARD', 1.00, 9000.00, NULL, 6, 2750000.00, 2840000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'BEST09SUMO', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (36, NULL, '001', 'AC', 'LG', 'K05NSA', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2964500.00, 3060000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'K05NSA', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (37, NULL, '001', 'AC', 'LG', 'K09NSA', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3513300.00, 3620000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'H09TN4', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (38, NULL, '001', 'AC', 'MIDEA', 'MSAFE-09CRN2X', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2910600.00, 2950000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSAFE-09CRN2X', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (39, NULL, '001', 'AC', 'MIDEA', 'MSFCE-09CRN2X', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2910000.00, 3000000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFCE-09CRN2X', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (40, NULL, '001', 'AC', 'AQUA', 'AQA-KCR5FQDL', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2538200.00, 2600000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AQA-KCR05FQDL', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (41, NULL, '001', 'AC', 'PANASONIC', 'YN9AKJ', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3861200.00, 3980000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'YN9AKJ', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (42, NULL, '001', 'AC', 'GREE', 'GWC-12N1A', 'SPLIT WALL MOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 5069000.00, 5329000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'GWC-12N1A', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (43, NULL, '001', 'AC', 'GREE', 'GWC-18N1A', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 6919000.00, 7200000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'GWC-18N1A', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (44, NULL, '001', 'AC', 'SHARP', 'AH-A18ZCY', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 6713000.00, 6600000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A18ZCY', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (45, NULL, '001', 'AC', 'SHARP', 'AH-A9ZCY', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3050000.00, 3150000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A9ZCY', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (46, NULL, '001', 'AC', 'DAIKIN', 'STV60CXV', 'SPLIT WALL MOUNTED', 'STANDARD', 2.50, 22000.00, NULL, 6, 9143000.00, 9300000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STV60CXV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (47, NULL, '002', 'AC', 'GREE', 'GKC-24KT', 'CASSETTE', 'STANDARD', 3.00, 25000.00, NULL, 6, 14770000.00, 14770000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'GKC-24KT', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (48, NULL, '001', 'AC', 'MIDEA', 'MSFL-05CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2401000.00, 2480000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFL-05CRN8', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (49, NULL, '001', 'AC', 'CHANGHONG', 'CSC-09NVB4', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2866500.00, 3210000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CSC-09NVB4', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (50, NULL, '001', 'AC', 'CHANGHONG', 'CSC-05NVB4', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2450000.00, 2600000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CSC-05NVB4', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (51, NULL, '001', 'AC', 'MIDEA', 'MSFQ-09CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2979200.00, 3111000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFQ-09CRN8', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (52, NULL, '001', 'AC', 'SHARP', 'AH-A12ZCY', 'SPLIT WALL MOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 4434500.00, 4570000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A12ZCY', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (53, NULL, '001', 'AC', 'SAMSUNG', 'AR40F05D0AMNSE', 'SPLIT WALL MOUNTED', 'INVERTER', 0.50, 5000.00, NULL, 6, 2684000.00, 2790000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AR40F05D0AMNSE', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (54, NULL, '001', 'AC', 'PANASONIC', 'CU-DN05CKJ', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 3225000.00, 3330000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CU-DN05CKJ', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (55, NULL, '001', 'AC', 'PANASONIC', 'CU-DN09CKJ', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3597000.00, 3710000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CU-DN09CKJ', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (56, NULL, '001', 'AC', 'SHARP', 'AH-A12SAY', 'SPLIT WALL MOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 4620700.00, 4760000.00, NULL, '[]', 'AH-A12SAY', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (57, NULL, '001', 'AC', 'AQUA', 'AQA-KCR18FQAL', 'SPLIT WALL MAOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 5390000.00, 5560000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AQA-KCR18FQAL', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (58, NULL, '001', 'AC', 'BESTLIFE', 'BEST12QFR3', 'SPLIT WALL MAOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 3822000.00, 3900000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'BEST12QFR3', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (60, NULL, '001', 'AC', 'POLYTRON', 'PAC05VH', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2699900.00, 2790000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'PAC05VH', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (61, NULL, '001', 'AC', 'POLYTRON', 'PAC09VZI', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3284960.00, 3350000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'PAC09VZI', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (62, NULL, '001', 'AC', 'CHANGHONG', 'CSC-05NVS4', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2631300.00, 2720000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CSC-05NVS4', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (63, NULL, '001', 'AC', 'CHANGHONG', 'CSC-18NVB', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 12000.00, NULL, 6, 5250000.00, 5560000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CSC-18NVB', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (64, NULL, '001', 'AC', 'LG', 'K09NVA', 'SPLIT WALL MOUNTED', 'INVERTER', 1.00, 9000.00, NULL, 6, 4250000.00, 4377000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'K09NVA', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (65, NULL, '001', 'AC', 'MIDEA', 'MSFT-05CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2500000.00, 2600000.00, '[{\"kategori_id\":\"4\"}]', '[]', 'MSFT-05CRN8', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (66, NULL, '001', 'AC', 'MIDEA', 'MSFT-09CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3050000.00, 3180000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFT-09CRN8', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (67, NULL, '001', 'AC', 'MIDEA', 'MSFT-12CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 4332000.00, 4420000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SPLIT WALL MOUNTED	', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (68, NULL, '001', 'AC', 'MIDEA', 'MSFQ-18CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 5785500.00, 6020000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFQ-18CRN8', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (69, NULL, '001', 'AC', 'SAMSUNG', 'AR40F09D0AMNSE', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3063000.00, 3160000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AR40F09D0AMNSE', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (70, NULL, '001', 'AC', 'DAIKIN', 'SVC85AV-L', 'FLOORSTANDING', 'STANDARD', 3.50, 29000.00, NULL, 6, 17361000.00, 19270710.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVC85AV', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (71, NULL, '001', 'AC', 'DAIKIN', 'SVC85AY-L', 'FLOORSTANDING', 'STANDARD', 3.50, 29000.00, NULL, 6, 18846000.00, 20919060.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVC85AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (72, NULL, '001', 'AC', 'DAIKIN', 'SVC100AY-L', 'FLOORSTANDING', 'STANDARD', 4.00, 36000.00, NULL, 6, 23571000.00, 26163810.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVC100AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (73, NULL, '001', 'AC', 'DAIKIN', 'SVC125AY-L', 'FLOORSTANDING', 'STANDARD', 5.00, 42000.00, NULL, 6, 26253000.00, 25125871.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVC125AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (74, NULL, '001', 'AC', 'DAIKIN', 'SVC140AY-L', 'FLOORSTANDING', 'STANDARD', 6.00, 48000.00, NULL, 6, 31905000.00, 35414550.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVC140AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (75, NULL, '001', 'AC', 'DAIKIN', 'SVFC71AGV-L', 'FLOORSTANDING', 'INVERTER', 3.00, 24200.00, NULL, 6, 22888800.00, 25406568.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVFC71AGV-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (76, NULL, '001', 'AC', 'DAIKIN', 'SVFC85AGV-L', 'FLOORSTANDING', 'INVERTER', 3.50, 29000.00, NULL, 6, 26159760.00, 29037334.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVFC85AGV-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (77, NULL, '001', 'AC', 'DAIKIN', 'SVFC100AGV-L', 'FLOORSTANDING', 'INVERTER', 4.00, 34100.00, NULL, 6, 28329840.00, 31446122.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVFC100AGV-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (78, NULL, '001', 'AC', 'DAIKIN', 'SVFC125AGY-L', 'FLOORSTANDING', 'INVERTER', 5.00, 42700.00, NULL, 6, 32986800.00, 36615348.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVFC125AGY-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (79, NULL, '001', 'AC', 'DAIKIN', 'SVFC140AGY-L', 'FLOORSTANDING', 'INVERTER', 6.00, 46500.00, NULL, 6, 40510800.00, 44966988.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVFC140AGY-L', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (80, NULL, '001', 'AC', 'DAIKIN', 'SDMC50AV-L', 'SPLIT DUCT', 'STANDARD', 2.00, 18500.00, NULL, 6, 11208000.00, 12440880.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC50AV-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (81, NULL, '001', 'AC', 'DAIKIN', 'SDMC60AV-L', 'SPLIT DUCT', 'STANDARD', 2.50, 23500.00, NULL, 6, 14640000.00, 16250400.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC60AV-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (82, NULL, '001', 'AC', 'DAIKIN', 'SDMC85AV-L', 'SPLIT DUCT', 'STANDARD', 3.50, 30000.00, NULL, 6, 16856000.00, 18710160.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC85AV-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (83, NULL, '001', 'AC', 'DAIKIN', 'SDMC85AY-L', 'SPLIT DUCT', 'STANDARD', 3.50, 29500.00, NULL, 6, 18176000.00, 20175360.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC85AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (84, NULL, '001', 'AC', 'DAIKIN', 'SDMC100AY-L', 'SPLIT DUCT', 'STANDARD', 4.00, 36000.00, NULL, 6, 19320000.00, 21445200.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC100AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (85, NULL, '001', 'AC', 'DAIKIN', 'SDMC125AY-L', 'SPLIT DUCT', 'STANDARD', 5.00, 42000.00, NULL, 6, 24080000.00, 26728000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC125AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (86, NULL, '001', 'AC', 'DAIKIN', 'SDMC140AY-L', 'SPLIT DUCT', 'STANDARD', 6.00, 48000.00, NULL, 6, 27440000.00, 30458000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC140AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (87, NULL, '001', 'AC', 'DAIKIN', 'SCE50AV-L', 'CASSETTE', 'STANDARD', 2.00, 18500.00, NULL, 6, 12064000.00, 13391040.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SCE50AV-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (88, NULL, '001', 'AC', 'DAIKIN', 'SCE71AV-L', 'CASSETTE', 'STANDARD', 3.00, 24000.00, NULL, 6, 15720000.00, 17449200.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SCE71AV-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (89, NULL, '001', 'AC', 'DAIKIN', 'SCE125AV-L', 'CASSETTE', 'STANDARD', 5.00, 42000.00, NULL, 6, 25568000.00, 28380480.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SCE125AV-L', NULL, 'WIRELESS');
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (90, NULL, '001', 'AC', 'POLYTRON', 'PAC12VH', 'SPLIT WALL MOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 4424700.00, 4560000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'PAC12VH', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (91, NULL, '001', 'AC', 'DAIKIN', 'SDN80H', 'SPLIT DUCT', 'STANDARD', 8.90, 80000.00, NULL, 6, 47511090.00, 52737310.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN80H', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (92, NULL, '001', 'AC', 'DAIKIN', 'SDN100H', 'SPLIT DUCT', 'STANDARD', 11.10, 100000.00, NULL, 6, 55488510.00, 61592246.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN100H', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (93, NULL, '001', 'AC', 'DAIKIN', 'SDN125H', 'SPLIT DUCT', 'STANDARD', 13.90, 125000.00, NULL, 6, 69305940.00, 76929593.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN125H', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (94, NULL, '001', 'AC', 'DAIKIN', 'SDN150H', 'SPLIT DUCT	', 'STANDARD', 16.70, 150000.00, NULL, 6, 79984575.00, 88782878.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN150H', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (95, NULL, '001', 'AC', 'DAIKIN', 'SDN100V', 'SPLIT DUCT', 'STANDARD', 11.10, 100000.00, NULL, 6, 55488510.00, 61595546.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN100V', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (96, NULL, '001', 'AC', 'DAIKIN', 'SDN125V', 'SPLIT DUCT', 'STANDARD', 13.90, 125000.00, NULL, 6, 70006000.00, 77706660.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN125V', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (97, NULL, '001', 'AC', 'DAIKIN', 'SDN150V', 'SPLIT DUCT', 'STANDARD', 16.70, 150000.00, NULL, 6, 80792500.00, 89679675.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN150V', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (98, NULL, '001', 'AC', 'DAIKIN', 'FXFQ 100 AV4', 'CEILING MOUNTED CASSETTE', 'VRV', 4.00, 38200.00, NULL, 6, 10938400.00, 24860000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'FXFQ 100 AV4', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (99, NULL, '001', 'AC', 'DAIKIN', 'FXFQ 63 AV4', 'CEILING MOUNTED CASSETTE', 'VRV', 2.50, 24200.00, NULL, 6, 10432400.00, 23710000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'FXFQ 63 AV4', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (100, NULL, '001', 'AC', 'DAIKIN', 'FXAQ 20 AVM4', 'WALL MOUNTED TYPE', 'VRV', 0.80, 7500.00, NULL, 6, 5918000.00, 13450000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'FXAQ 20 AVM4', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (101, NULL, '001', 'AC', 'DAIKIN', 'FXAQ 32 AVM4', 'WALL MOUNTED TYPE', 'VRV', 1.30, 12300.00, NULL, 6, 6402000.00, 14550000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'FXAQ 32 AVM4', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (102, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'BYCQ125EAF', 'OPTION LIST Panel', 'VRV ACCESSORIES', 0.00, 0.00, NULL, 9, 3280000.00, 4470000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'BYCQ125EAF', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (103, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'BAF552A160', 'OPTION LIST  Daikin Air Filter (MERV8)', 'VRV ACCESSORIES', 0.00, 0.00, NULL, 9, 440000.00, 550000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'BAF552A160', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (104, NULL, '001', 'AC', 'DAIKIN', 'RXQ 28 BY14', 'VRV 6A', 'VRV OUTDOOR UNIT', 28.00, 268000.00, NULL, 6, 150466800.00, 341970000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'RXQ 8 BY14', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (105, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'BRC1E63', 'Wired remote controller', 'VRV ACCESSORIES', 0.00, 0.00, NULL, 9, 696000.00, 696000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'BRC1E63', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (106, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'KHRP26A22T7', 'REFNET JOINT & HEADER', 'VRV ACCESSORIES', 0.00, 0.00, NULL, 9, 448000.00, 560000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'KHRP26A22T7', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (107, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'KHRP26A33T7', 'REFNET JOINT & HEADER', 'VRV ACCESSORIES', 0.00, 0.00, NULL, 9, 472000.00, 590000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'KHRP26A33T7', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (108, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'KHRP26A72T7', 'REFNET JOINT & HEADER', 'VRV ACCESSORIES	', 0.00, 0.00, NULL, 9, 744000.00, 930000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'KHRP26A72T7', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (109, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'KHRP26A73T7', 'REFNET JOINT & HEADER', 'VRV ACCESSORIES', 0.00, 0.00, NULL, 9, 1240000.00, 1550000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'KHRP26A73T7', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (110, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'KHRP26M73TP7', 'REFNET JOINT & HEADER', 'VRV ACCESSORIES	', 0.00, 0.00, NULL, 9, 496000.00, 620000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'KHRP26M73TP7', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (111, NULL, '001', 'AC', 'MIDEA', 'MSFQ-05CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2600000.00, 2710000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFQ-05CRN8', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (112, NULL, '001', 'AC ', 'GREE', 'GPC-05P2', 'PORTABLE', 'STANDARD', 0.50, 5100.00, NULL, 6, 3769000.00, 3693620.00, '[{\"kategori_id\":\"1\"}]', '[]', 'GPC-05P2', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (114, NULL, '001', 'AC', 'DAIKIN', 'STKH25YV', 'SPLIT WALL MOUNTED', 'ALFA INVERTER', 1.00, 9000.00, NULL, 6, 6426000.00, 6400000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKH25YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (115, NULL, '001', 'AC', 'BESTLIFE', 'BEST05DSC ', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2425000.00, 2500000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'BEST05DSC ', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (116, NULL, '001', 'AC', 'BESTLIFE', 'BEST09LCN', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2775000.00, 2860000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'BEST09LCN', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (117, NULL, '002', 'AIR CURTAIN', 'GREE', 'FM-1.25-12-K', 'WALL MOUNTED', 'AIR CURTAIN', 0.00, 0.00, NULL, 6, 3029000.00, 3500000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'FM-1.25-12-K', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (118, NULL, '001', 'AC', 'SHARP', 'AH-A9CAY', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3038000.00, 3130000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A9CAY', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (119, NULL, '001', 'AC', 'MIDEA', 'MSAFE-12CRN2X', 'SPLIT WALL MOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 4194400.00, 4510000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSAFE-12CRN2X', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (120, NULL, '001', 'AC', 'SAMSUNG', 'AR40F18D0AMNSE', 'SPLIT WALL MOUNTED', 'INVERTER', 2.00, NULL, NULL, 6, 6209000.00, 6333180.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AR40F18D0AMNSE', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (121, NULL, '001', 'AC', 'DAIKIN', 'CTKM25RVM4', 'WALL MOUNTED INDOOR UNIT', 'MULTI-NX', 2.50, 0.00, NULL, 6, 3519255.00, 3730000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CTKM25RVM4', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (122, NULL, '001', 'AC', 'DAIKIN', '4MKM68RVM4', 'OUTDOOR UNIT', 'MULTI-NX', 6.80, 0.00, NULL, 6, 19417230.00, 20580000.00, '[{\"kategori_id\":\"1\"}]', '[]', '4MKM68RVM4', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (123, NULL, '001', 'AC', 'DAIKIN', 'STKH60YV', 'SPLIT WALL MOUNTED', 'ALFA INVERTER', 2.50, 22500.00, NULL, 6, 13068419.00, 14580000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKH60YV', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (124, NULL, '001', 'AC', 'DAIKIN', 'SCFC125DY-R', 'CASSETTE', 'INVERTER', 5.00, 42700.00, NULL, 6, 38619742.00, 43930000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SCFC125DY-R', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (125, NULL, '002', 'AIR PURIFIER', 'DAIKIN', 'MCQ30ZVM7-H', NULL, NULL, 0.00, 0.00, NULL, 6, 1519035.00, 1610000.00, '[{\"kategori_id\":\"6\"}]', '[]', 'MCQ30ZVM7-H', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (126, NULL, '002', 'AIR PURIFIER', 'DAIKIN', 'MC55UVM6-7', NULL, NULL, 0.00, 0.00, NULL, 6, 3670215.00, 3890000.00, '[{\"kategori_id\":\"6\"}]', '[]', 'MC55UVM6-7', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (127, NULL, '001', 'AC', 'DAIKIN', 'SCFE125DY-L', 'CASSETTE', 'INVERTER', 5.00, 42000.00, NULL, 6, 36115000.00, 36566000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SCFCE125DY-L', NULL, NULL);
INSERT INTO `barang` (`id`, `foto`, `kode`, `nama`, `merek`, `model`, `tipe`, `jenis`, `kapasitas_pk`, `btuh`, `ukuran`, `satuan_id`, `harga_beli`, `harga_jual`, `kategori`, `diskon_jenis_customer`, `unit`, `cap`, `description`) VALUES (128, NULL, 'SP1', 'Kabel', 'CMY', NULL, NULL, NULL, NULL, NULL, 1.00, 2, NULL, 10000.00, '[{\"kategori_id\":\"2\"}]', '[]', 'Meter', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for barang_masuk
-- ----------------------------
DROP TABLE IF EXISTS `barang_masuk`;
CREATE TABLE `barang_masuk` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `gudang_id` bigint(20) DEFAULT NULL,
  `sumber` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of barang_masuk
-- ----------------------------
BEGIN;
INSERT INTO `barang_masuk` (`id`, `tanggal`, `gudang_id`, `sumber`, `detail`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (1, '2026-11-24', 1, 'Pembelian', '[{\"id\":1,\"barang_masuk_id\":1,\"pembelian_detail_id\":1,\"rak_id\":1,\"jumlah\":10,\"terjual\":null,\"dikirim\":null,\"mutasi\":null,\"retur\":null,\"rusak\":null,\"hilang\":null}]', '2026-11-24 02:08:10', 'sebastian', NULL, NULL);
INSERT INTO `barang_masuk` (`id`, `tanggal`, `gudang_id`, `sumber`, `detail`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (2, '2026-11-24', 1, 'Pembelian', '[{\"id\":2,\"barang_masuk_id\":2,\"pembelian_detail_id\":2,\"rak_id\":1,\"jumlah\":1,\"terjual\":1,\"dikirim\":1,\"mutasi\":null,\"retur\":null,\"rusak\":null,\"hilang\":null},{\"id\":3,\"barang_masuk_id\":2,\"pembelian_detail_id\":2,\"rak_id\":2,\"jumlah\":9,\"terjual\":null,\"dikirim\":null,\"mutasi\":null,\"retur\":null,\"rusak\":null,\"hilang\":null}]', '2026-11-24 02:14:38', 'sebastian', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for barang_masuk_detail
-- ----------------------------
DROP TABLE IF EXISTS `barang_masuk_detail`;
CREATE TABLE `barang_masuk_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `barang_masuk_id` bigint(20) DEFAULT NULL,
  `pembelian_detail_id` bigint(20) DEFAULT NULL,
  `rak_id` bigint(20) DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  `terjual` decimal(20,2) DEFAULT NULL,
  `dikirim` decimal(20,2) DEFAULT NULL,
  `mutasi` decimal(20,2) DEFAULT NULL,
  `retur` decimal(20,2) DEFAULT NULL,
  `rusak` decimal(20,2) DEFAULT NULL,
  `hilang` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of barang_masuk_detail
-- ----------------------------
BEGIN;
INSERT INTO `barang_masuk_detail` (`id`, `barang_masuk_id`, `pembelian_detail_id`, `rak_id`, `jumlah`, `terjual`, `dikirim`, `mutasi`, `retur`, `rusak`, `hilang`) VALUES (1, 1, 1, 1, 10.00, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `barang_masuk_detail` (`id`, `barang_masuk_id`, `pembelian_detail_id`, `rak_id`, `jumlah`, `terjual`, `dikirim`, `mutasi`, `retur`, `rusak`, `hilang`) VALUES (2, 2, 2, 1, 1.00, 1.00, 1.00, NULL, NULL, NULL, NULL);
INSERT INTO `barang_masuk_detail` (`id`, `barang_masuk_id`, `pembelian_detail_id`, `rak_id`, `jumlah`, `terjual`, `dikirim`, `mutasi`, `retur`, `rusak`, `hilang`) VALUES (3, 2, 2, 2, 9.00, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for cabang
-- ----------------------------
DROP TABLE IF EXISTS `cabang`;
CREATE TABLE `cabang` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kabupaten_kota` varchar(255) DEFAULT NULL,
  `no_telp` text DEFAULT NULL,
  `no_wa` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of cabang
-- ----------------------------
BEGIN;
INSERT INTO `cabang` (`id`, `nama`, `alamat`, `kabupaten_kota`, `no_telp`, `no_wa`, `email`) VALUES (1, 'Medan', 'Jl. Suka Cerdas IV. 3 B STM Ujung, Suka Maju, Kec. Medan Johor', 'Medan', NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for catatan_penawaran
-- ----------------------------
DROP TABLE IF EXISTS `catatan_penawaran`;
CREATE TABLE `catatan_penawaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) DEFAULT NULL,
  `catatan` longtext DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of catatan_penawaran
-- ----------------------------
BEGIN;
INSERT INTO `catatan_penawaran` (`id`, `judul`, `catatan`) VALUES (1, 'Berlaku 14 Hari', '[\"Penawaran berlaku 14 hari\",\"Hal-hal diluar penawaran akan dikenakan biaya tambahan\"]');
COMMIT;

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_customer_id` bigint(20) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telp` text DEFAULT NULL,
  `no_wa` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `credit_limit` decimal(20,2) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `jumlah_transaksi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of customer
-- ----------------------------
BEGIN;
INSERT INTO `customer` (`id`, `jenis_customer_id`, `nama`, `alamat`, `no_telp`, `no_wa`, `email`, `credit_limit`, `lokasi`, `jumlah_transaksi`) VALUES (1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp\":\"08127127123\"}]', '[{\"no_wa\":\"08127127123\"}]', NULL, 7.00, NULL, 1);
INSERT INTO `customer` (`id`, `jenis_customer_id`, `nama`, `alamat`, `no_telp`, `no_wa`, `email`, `credit_limit`, `lokasi`, `jumlah_transaksi`) VALUES (2, 1, 'Sebastian', 'Jl. Namorambe', '[{\"no_telp\":\"0812881712321\"}]', '[{\"no_wa\":\"0812881712321\"}]', '[{\"email\":\"sbastian@gmail.com\"}]', NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for gudang
-- ----------------------------
DROP TABLE IF EXISTS `gudang`;
CREATE TABLE `gudang` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telp` text DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gudang
-- ----------------------------
BEGIN;
INSERT INTO `gudang` (`id`, `cabang_id`, `nama`, `alamat`, `no_telp`) VALUES (1, 1, 'Medan Johor', 'Jl. Suka Cerdas IV. 3 B STM Ujung, Suka Maju, Kec. Medan Johor, Kota Medan, Sumatera Utara 20147', NULL);
COMMIT;

-- ----------------------------
-- Table structure for hari_libur
-- ----------------------------
DROP TABLE IF EXISTS `hari_libur`;
CREATE TABLE `hari_libur` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) DEFAULT NULL,
  `dari_tanggal` date DEFAULT NULL,
  `sampai_tanggal` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of hari_libur
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for izin
-- ----------------------------
DROP TABLE IF EXISTS `izin`;
CREATE TABLE `izin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) DEFAULT NULL,
  `karyawan_id` bigint(20) DEFAULT NULL,
  `dari_tanggal` date DEFAULT NULL,
  `sampai_tanggal` date DEFAULT NULL,
  `jenis_izin` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of izin
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for jabatan
-- ----------------------------
DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE `jabatan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jabatan
-- ----------------------------
BEGIN;
INSERT INTO `jabatan` (`id`, `jabatan`) VALUES (1, 'Admin');
INSERT INTO `jabatan` (`id`, `jabatan`) VALUES (2, 'Sales');
INSERT INTO `jabatan` (`id`, `jabatan`) VALUES (3, 'MANAGER');
COMMIT;

-- ----------------------------
-- Table structure for jam_kerja
-- ----------------------------
DROP TABLE IF EXISTS `jam_kerja`;
CREATE TABLE `jam_kerja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jam_kerja` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jam_kerja
-- ----------------------------
BEGIN;
INSERT INTO `jam_kerja` (`id`, `jam_kerja`) VALUES (1, '08 Pagi');
COMMIT;

-- ----------------------------
-- Table structure for jasa
-- ----------------------------
DROP TABLE IF EXISTS `jasa`;
CREATE TABLE `jasa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jasa` varchar(255) DEFAULT NULL,
  `harga` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jasa
-- ----------------------------
BEGIN;
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (1, 'PAKET A PEMASANGAN AC PIPA RIIFO 3 METER  (1/2-1PK)', 620000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (2, 'PAKET B PEMASANGAN AC PIPA RIIFO 3 METER (1/2-1PK)', 580000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (3, 'PAKET A PEMASANGAN AC PIPA RIIFO 3 METER (1,5-2PK)', 800000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (4, 'PAKET B PEMASANGAN AC PIPA RIIFO 3 METER (1,5-2PK)', 740000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (5, 'PAKET A PEMASANGAN AC PIPA RIIFO 2 METER (1/2-1PK)', 550000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (6, 'PAKET B PEMASANGAN AC PIPA RIIFO 2 METER (1/2-1PK)', 510000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (7, 'PAKET A PEMASANGAN AC PIPA RIIFO 2 METER (1,5-2PK)', 710000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (8, 'PAKET B PEMASANGAN AC PIPA RIIFO 2 METER (1,5-2PK)', 660000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (9, 'PAKET A PEMASANGAN AC PIPA AUB 3 METER (1/2-1PK)', 710000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (10, 'PAKET B PEMASANGAN AC PIPA AUB 3 METER (1/2-1PK)', 650000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (11, 'PAKET A PEMASANGAN AC PIPA AUB 3 METER (1,5-2PK)', 930000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (12, 'PAKET B PEMASANGAN AC PIPA AUB 3 METER (1,5-2PK)', 850000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (13, 'PAKET A PEMASANGAN AC PIPA AUB 2 METER (1/2-1PK)', 570000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (14, 'PAKET B PEMASANGAN AC PIPA AUB 2 METER (1/2-1PK)', 530000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (15, 'PAKET A PEMASANGAN AC PIPA AUB 2 METER (1,5-2PK)', 750000.00);
INSERT INTO `jasa` (`id`, `jasa`, `harga`) VALUES (16, 'PAKET B PEMASANGAN AC PIPA AUB 2 METER (1,5-2PK)', 700000.00);
COMMIT;

-- ----------------------------
-- Table structure for jenis_customer
-- ----------------------------
DROP TABLE IF EXISTS `jenis_customer`;
CREATE TABLE `jenis_customer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_customer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jenis_customer
-- ----------------------------
BEGIN;
INSERT INTO `jenis_customer` (`id`, `jenis_customer`) VALUES (1, 'Personal');
INSERT INTO `jenis_customer` (`id`, `jenis_customer`) VALUES (2, 'Perusahaan');
INSERT INTO `jenis_customer` (`id`, `jenis_customer`) VALUES (4, 'Lembaga  Pemerintahan');
INSERT INTO `jenis_customer` (`id`, `jenis_customer`) VALUES (5, 'Lembaga Swasta');
COMMIT;

-- ----------------------------
-- Table structure for jenis_supplier
-- ----------------------------
DROP TABLE IF EXISTS `jenis_supplier`;
CREATE TABLE `jenis_supplier` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_supplier` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jenis_supplier
-- ----------------------------
BEGIN;
INSERT INTO `jenis_supplier` (`id`, `jenis_supplier`) VALUES (1, 'Pabrik');
INSERT INTO `jenis_supplier` (`id`, `jenis_supplier`) VALUES (2, 'Distributor');
INSERT INTO `jenis_supplier` (`id`, `jenis_supplier`) VALUES (3, 'Toko');
INSERT INTO `jenis_supplier` (`id`, `jenis_supplier`) VALUES (4, 'Personal');
INSERT INTO `jenis_supplier` (`id`, `jenis_supplier`) VALUES (6, 'Principal');
COMMIT;

-- ----------------------------
-- Table structure for karyawan
-- ----------------------------
DROP TABLE IF EXISTS `karyawan`;
CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `nama` varchar(250) DEFAULT '',
  `jabatan_id` int(11) DEFAULT NULL,
  `no_hp` text DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `gaji_per_bulan` decimal(20,2) DEFAULT NULL,
  `gaji_per_hari` decimal(20,2) DEFAULT NULL,
  `persenan_insentif` decimal(10,2) DEFAULT NULL,
  `ss_insentif_akumulatif_id` bigint(20) DEFAULT NULL,
  `uang_makan_per_hari` decimal(20,2) DEFAULT NULL,
  `uang_makan_lembur_per_hari` decimal(20,2) DEFAULT NULL,
  `uang_pulsa_per_bulan` decimal(20,2) DEFAULT NULL,
  `uang_lembur_per_jam` decimal(20,2) DEFAULT NULL,
  `uang_servis_kendaraan_per_bulan` decimal(20,2) DEFAULT NULL,
  `tunjangan_harian` decimal(20,2) DEFAULT NULL,
  `tunjangan_jabatan_per_bulan` decimal(20,2) DEFAULT NULL,
  `tunjangan_kesehatan_per_bulan` decimal(20,2) DEFAULT NULL,
  `tunjangan_transportasi_per_bulan` decimal(20,2) DEFAULT NULL,
  `potongan_per_tidak_masuk` decimal(20,2) DEFAULT NULL,
  `potongan_per_izin_cuti` decimal(20,2) DEFAULT NULL,
  `potongan_per_terlambat_masuk` decimal(20,2) DEFAULT NULL,
  `potongan_per_pulang_sebelum_waktunya` decimal(20,2) DEFAULT NULL,
  `potongan_per_tidak_absen_masuk` decimal(20,2) DEFAULT NULL,
  `potongan_per_tidak_absen_pulang` decimal(20,2) DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `tanggal_gajian_tiap_bulan` int(11) DEFAULT NULL,
  `terakhir_gajian` date DEFAULT NULL,
  `status_aktif` int(11) DEFAULT 1,
  `file_foto` varchar(40) DEFAULT NULL,
  `utang` int(11) DEFAULT 0,
  `password` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `jam_kerja_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of karyawan
-- ----------------------------
BEGIN;
INSERT INTO `karyawan` (`id`, `cabang_id`, `nik`, `nama`, `jabatan_id`, `no_hp`, `alamat`, `gaji_per_bulan`, `gaji_per_hari`, `persenan_insentif`, `ss_insentif_akumulatif_id`, `uang_makan_per_hari`, `uang_makan_lembur_per_hari`, `uang_pulsa_per_bulan`, `uang_lembur_per_jam`, `uang_servis_kendaraan_per_bulan`, `tunjangan_harian`, `tunjangan_jabatan_per_bulan`, `tunjangan_kesehatan_per_bulan`, `tunjangan_transportasi_per_bulan`, `potongan_per_tidak_masuk`, `potongan_per_izin_cuti`, `potongan_per_terlambat_masuk`, `potongan_per_pulang_sebelum_waktunya`, `potongan_per_tidak_absen_masuk`, `potongan_per_tidak_absen_pulang`, `tanggal_masuk`, `tanggal_gajian_tiap_bulan`, `terakhir_gajian`, `status_aktif`, `file_foto`, `utang`, `password`, `last_login`, `jam_kerja_id`) VALUES (1, 1, '001', 'Dedi Wijaya', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for kata_pengantar
-- ----------------------------
DROP TABLE IF EXISTS `kata_pengantar`;
CREATE TABLE `kata_pengantar` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipe` varchar(255) DEFAULT NULL,
  `kata_pengantar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of kata_pengantar
-- ----------------------------
BEGIN;
INSERT INTO `kata_pengantar` (`id`, `tipe`, `kata_pengantar`) VALUES (2, 'Surat Penawaran', '<p>Dengan hormat,<br />\nSehubungan dengan permintaan penawaran harga pemasangan AC, maka dengan ini kami <strong>PT. FREN COOL GROUP</strong> bermaksud untuk mengajukan penawaran, adapun rincian jasa dan materialnya sebagai berikut :</p>\n');
COMMIT;

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of kategori
-- ----------------------------
BEGIN;
INSERT INTO `kategori` (`id`, `kategori`) VALUES (1, 'Unit AC');
INSERT INTO `kategori` (`id`, `kategori`) VALUES (2, 'Sparepart AC');
INSERT INTO `kategori` (`id`, `kategori`) VALUES (4, 'Material AC');
INSERT INTO `kategori` (`id`, `kategori`) VALUES (5, 'Accessories AC');
INSERT INTO `kategori` (`id`, `kategori`) VALUES (6, 'Air Purifier ');
COMMIT;

-- ----------------------------
-- Table structure for log_barang_masuk
-- ----------------------------
DROP TABLE IF EXISTS `log_barang_masuk`;
CREATE TABLE `log_barang_masuk` (
  `id` bigint(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `gudang_id` bigint(20) DEFAULT NULL,
  `sumber` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `no_urut` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of log_barang_masuk
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for log_pembelian
-- ----------------------------
DROP TABLE IF EXISTS `log_pembelian`;
CREATE TABLE `log_pembelian` (
  `id` bigint(20) DEFAULT NULL,
  `cabang_id` bigint(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tanda_tangan_id` bigint(20) DEFAULT NULL,
  `supplier_id` bigint(20) DEFAULT NULL,
  `nama_supplier` varchar(255) DEFAULT NULL,
  `alamat_supplier` varchar(255) DEFAULT NULL,
  `no_telp_supplier` varchar(255) DEFAULT NULL,
  `no_wa_supplier` varchar(255) DEFAULT NULL,
  `email_supplier` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `persen_diskon` decimal(20,2) DEFAULT NULL,
  `diskon` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `no_urut` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of log_pembelian
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for log_penawaran
-- ----------------------------
DROP TABLE IF EXISTS `log_penawaran`;
CREATE TABLE `log_penawaran` (
  `id` bigint(20) DEFAULT NULL,
  `cabang_id` bigint(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kata_pengantar_id` bigint(20) DEFAULT NULL,
  `catatan_penawaran_id` bigint(20) DEFAULT NULL,
  `tanda_tangan_id` bigint(20) DEFAULT NULL,
  `batas_waktu` int(11) DEFAULT NULL,
  `karyawan_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `nama_customer` varchar(255) DEFAULT NULL,
  `alamat_customer` varchar(255) DEFAULT NULL,
  `no_telp_customer` varchar(255) DEFAULT NULL,
  `no_wa_customer` varchar(255) DEFAULT NULL,
  `email_customer` varchar(255) DEFAULT NULL,
  `credit_limit_customer` decimal(20,2) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  `jumlah_pesanan` decimal(20,2) DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `persen_diskon` decimal(20,2) DEFAULT NULL,
  `diskon` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_type` varchar(255) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejected_by` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `no_urut` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of log_penawaran
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for log_penawaran_proyek
-- ----------------------------
DROP TABLE IF EXISTS `log_penawaran_proyek`;
CREATE TABLE `log_penawaran_proyek` (
  `id` bigint(20) DEFAULT NULL,
  `cabang_id` bigint(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kata_pengantar_id` bigint(20) DEFAULT NULL,
  `catatan_penawaran_id` bigint(20) DEFAULT NULL,
  `tanda_tangan_id` bigint(20) DEFAULT NULL,
  `batas_waktu` int(11) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `nama_customer` varchar(255) DEFAULT NULL,
  `alamat_customer` varchar(255) DEFAULT NULL,
  `no_telp_customer` varchar(255) DEFAULT NULL,
  `no_wa_customer` varchar(255) DEFAULT NULL,
  `email_customer` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  `jumlah_pesanan` decimal(20,2) DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `persen_diskon` decimal(20,2) DEFAULT NULL,
  `diskon` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_type` varchar(255) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejected_by` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `no_urut` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of log_penawaran_proyek
-- ----------------------------
BEGIN;
INSERT INTO `log_penawaran_proyek` (`id`, `cabang_id`, `kode`, `nomor`, `tahun`, `tanggal`, `kata_pengantar_id`, `catatan_penawaran_id`, `tanda_tangan_id`, `batas_waktu`, `customer_id`, `nama_customer`, `alamat_customer`, `no_telp_customer`, `no_wa_customer`, `email_customer`, `detail`, `jumlah`, `jumlah_pesanan`, `sub_total`, `persen_diskon`, `diskon`, `dpp`, `persen_ppn`, `ppn`, `total`, `approved_at`, `approved_by`, `approved_type`, `rejected_at`, `rejected_by`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`, `no_urut`) VALUES (1, 1, '02', 1, 2026, '2026-11-26', 2, 1, 1, 7, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-26 16:05:26', 'sebastian', NULL, NULL, NULL, NULL, 1);
INSERT INTO `log_penawaran_proyek` (`id`, `cabang_id`, `kode`, `nomor`, `tahun`, `tanggal`, `kata_pengantar_id`, `catatan_penawaran_id`, `tanda_tangan_id`, `batas_waktu`, `customer_id`, `nama_customer`, `alamat_customer`, `no_telp_customer`, `no_wa_customer`, `email_customer`, `detail`, `jumlah`, `jumlah_pesanan`, `sub_total`, `persen_diskon`, `diskon`, `dpp`, `persen_ppn`, `ppn`, `total`, `approved_at`, `approved_by`, `approved_type`, `rejected_at`, `rejected_by`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`, `no_urut`) VALUES (1, 1, '02', 1, 2026, '2026-11-26', 2, 1, 1, 7, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-26 16:05:26', 'sebastian', NULL, NULL, '2026-11-26 16:06:35', 'sebastian', 2);
COMMIT;

-- ----------------------------
-- Table structure for log_penjualan
-- ----------------------------
DROP TABLE IF EXISTS `log_penjualan`;
CREATE TABLE `log_penjualan` (
  `id` bigint(20) DEFAULT NULL,
  `cabang_id` bigint(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `pesanan_id` bigint(20) DEFAULT NULL,
  `karyawan_id` bigint(20) DEFAULT NULL,
  `batas_waktu_pembayaran` int(11) DEFAULT NULL,
  `tanda_tangan_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `nama_customer` varchar(255) DEFAULT NULL,
  `alamat_customer` varchar(255) DEFAULT NULL,
  `no_telp_customer` varchar(255) DEFAULT NULL,
  `no_wa_customer` varchar(255) DEFAULT NULL,
  `email_customer` varchar(255) DEFAULT NULL,
  `credit_limit_customer` decimal(20,2) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `persen_diskon` decimal(20,2) DEFAULT NULL,
  `diskon` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `bank_id` bigint(20) DEFAULT NULL,
  `termin` text DEFAULT NULL,
  `dibayar` decimal(20,2) DEFAULT NULL,
  `pembayaran` text DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_type` varchar(255) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejected_by` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `no_urut` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of log_penjualan
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for log_penjualan_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `log_penjualan_pembayaran`;
CREATE TABLE `log_penjualan_pembayaran` (
  `id` bigint(20) DEFAULT NULL,
  `penjualan_id` bigint(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nominal` decimal(20,2) DEFAULT NULL,
  `metode_pembayaran_id` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `no_urut` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of log_penjualan_pembayaran
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for log_pesanan
-- ----------------------------
DROP TABLE IF EXISTS `log_pesanan`;
CREATE TABLE `log_pesanan` (
  `id` bigint(20) DEFAULT NULL,
  `cabang_id` bigint(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nomor_po` varchar(255) DEFAULT NULL,
  `batas_waktu` int(11) DEFAULT NULL,
  `karyawan_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `nama_customer` varchar(255) DEFAULT NULL,
  `alamat_customer` varchar(255) DEFAULT NULL,
  `no_telp_customer` varchar(255) DEFAULT NULL,
  `no_wa_customer` varchar(255) DEFAULT NULL,
  `email_customer` varchar(255) DEFAULT NULL,
  `credit_limit_customer` decimal(20,2) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  `jumlah_penjualan` decimal(20,2) DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `persen_diskon` decimal(20,2) DEFAULT NULL,
  `diskon` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_type` varchar(255) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejected_by` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `no_urut` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of log_pesanan
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `id_induk` int(11) DEFAULT NULL,
  `menu` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `no_urut` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of menu
-- ----------------------------
BEGIN;
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (1, NULL, 'Dashboard', 'area-chart', 'dashboard', 1);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (3, NULL, 'Data Master', 'database', NULL, 3);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (4, 3, 'Cabang', 'anchor', 'cabang', 4);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (5, 3, 'Gudang', 'home', 'gudang', 5);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (6, 3, 'Rak', 'server', 'rak', 6);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (7, 3, 'Satuan', 'shield', 'satuan', 7);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (8, 3, 'Kategori', 'hashtag', 'kategori', 8);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (9, 3, 'Barang', 'cubes', 'barang', 9);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (10, 3, 'Jasa', 'handshake-o', 'jasa', 10);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (11, 3, 'Jenis Customer', 'map-signs', 'jenis-customer', 11);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (12, 3, 'Customer', 'address-book-o', 'customer', 12);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (13, 3, 'Jenis Supplier', 'inbox', 'jenis-supplier', 13);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (14, 3, 'Supplier', 'user-secret', 'supplier', 14);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (15, 3, 'Bank', 'bank', 'bank', 15);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (16, 3, 'Metode Pembayaran', 'credit-card-alt', 'metode-pembayaran', 16);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (17, 3, 'Kata Pengantar', 'envelope-o', 'kata-pengantar', 17);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (18, 3, 'Catatan Penawaran', 'sticky-note-o', 'catatan-penawaran', 18);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (19, 3, 'Tanda Tangan', 'pencil-square', 'tanda-tangan', 19);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (20, NULL, 'Proyek', 'handshake-o', NULL, 20);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (21, 20, 'Penawaran', 'send-o', 'penawaran-proyek', 21);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (22, NULL, 'Persediaan', 'book', NULL, 22);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (23, 22, 'Katalog', 'book', 'katalog', 23);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (24, 22, 'Pembelian', 'shopping-basket', 'pembelian', 24);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (25, 22, 'Barang Masuk', 'download', 'barang-masuk', 25);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (26, 22, 'Penawaran', 'send-o', 'penawaran', 26);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (27, 22, 'Pesanan', 'shopping-cart', 'pesanan', 27);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (28, 22, 'Penjualan', 'tag', 'penjualan', 28);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (29, 22, 'Pengiriman', 'truck', 'pengiriman', 29);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (30, 22, 'Pindah Rak', 'inbox', 'pindah-rak', 30);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (31, NULL, 'SDM', 'group', NULL, 31);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (32, 31, 'Jabatan', 'heartbeat', 'jabatan', 32);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (33, 31, 'Jam Kerja', 'clock-o', 'jam-kerja', 33);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (34, 31, 'Karyawan', 'users', 'karyawan', 34);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (35, 31, 'Validasi Absensi', 'check-square-o', 'validasi-absensi', 35);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (36, 31, 'Hari Libur', 'calendar', 'hari-libur', 36);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (37, 31, 'Izin', 'clone', 'izin', 37);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (38, 31, 'Absensi', 'address-card', 'absensi', 38);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (39, NULL, 'Approval', 'bell', NULL, 39);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (40, 39, 'Penawaran', 'handshake-o', 'approval-penawaran', 40);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (41, 39, 'Pesanan', 'shopping-cart', 'approval-pesanan', 41);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (42, 39, 'Penjualan', 'tag', 'approval-penjualan', 42);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (43, NULL, 'Laporan', 'book', NULL, 43);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (44, 43, 'Lap. Stok', 'file-pdf-o', 'laporan-stok', 44);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (45, 43, 'Lap. Pesanan', 'file-pdf-o', 'laporan-pesanan', 45);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (46, 43, 'Lap. Pembelian', 'file-pdf-o', 'laporan-pembelian', 46);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (47, 43, 'Lap. Penjualan', 'file-pdf-o', 'laporan-penjualan', 47);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (48, 43, 'Lap. Piutang Customer', 'file-pdf-o', 'laporan-piutang-customer', 48);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (49, 43, 'Lap. Penerimaan Pembayaran', 'money', 'laporan-penerimaan-pembayaran', 49);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (125, NULL, 'Users', 'lock', 'users', 125);
INSERT INTO `menu` (`id`, `id_induk`, `menu`, `icon`, `url`, `no_urut`) VALUES (126, NULL, 'Users Level', 'key', 'users-level', 126);
COMMIT;

-- ----------------------------
-- Table structure for menu_akses
-- ----------------------------
DROP TABLE IF EXISTS `menu_akses`;
CREATE TABLE `menu_akses` (
  `users_level_id` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT '',
  `action` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of menu_akses
-- ----------------------------
BEGIN;
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'anggota', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'berita', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'berita', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'berita', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'berita', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'berita', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'berita-acara', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'berita-acara', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'berita-acara', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'berita-acara', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'cash-on-hand', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'dashboard', 'akumulasi.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'laporan-transaksi-keuangan', 'download.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'laporan-transaksi-keuangan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'laporan-transaksi-keuangan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'laporan-transaksi-keuangan', 'transaksi-keuangan.xlsx');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'laporan-transaksi-keuangan-rahasia', 'download.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'laporan-transaksi-keuangan-rahasia', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'laporan-transaksi-keuangan-rahasia', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'laporan-transaksi-keuangan-rahasia', 'transaksi-keuangan.xlsx');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengeluaran', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengeluaran', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengeluaran', 'load-file.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengeluaran', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengeluaran', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengeluaran', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengeluaran-study-tour', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengeluaran-study-tour', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengeluaran-study-tour', 'load-file.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengeluaran-study-tour', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengeluaran-study-tour', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengeluaran-study-tour', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengumuman', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengumuman', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengumuman', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengumuman', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pengumuman', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pertemuan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pertemuan', 'load-file.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pertemuan', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pertemuan', 'tampil-broadcast.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pertemuan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pertemuan', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'pertemuan', 'upload-file.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'peserta-toefl', 'simpan-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'peserta-toefl', 'tampil-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'peserta-toefl', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'peserta-toefl', 'ubah-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'peserta-study-tour', 'simpan-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'peserta-study-tour', 'tampil-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'peserta-study-tour', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'peserta-study-tour', 'ubah-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'setor', 'batal-setor.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'setor', 'setor.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'setor', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'setor-study-tour', 'batal-setor.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'setor-study-tour', 'setor.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'setor-study-tour', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'surat-peminjaman-kelas', 'cetak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'surat-peminjaman-kelas', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'surat-peminjaman-kelas', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'surat-peminjaman-kelas', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'surat-peminjaman-kelas', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'surat-peminjaman-kelas', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'terima', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'terima', 'terima.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'terima-study-tour', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'terima-study-tour', 'terima.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'transaksi-keuangan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'transaksi-keuangan', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'transaksi-keuangan', 'load-file.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'transaksi-keuangan', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'transaksi-keuangan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'transaksi-keuangan', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'transaksi-keuangan-rahasia', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'transaksi-keuangan-rahasia', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'transaksi-keuangan-rahasia', 'load-file.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'transaksi-keuangan-rahasia', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'transaksi-keuangan-rahasia', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (3, 'transaksi-keuangan-rahasia', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'anggota', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'anggota', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'anggota', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'anggota', 'tampil-pertemuan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'anggota', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'anggota', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'berita-acara', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'berita-acara', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'berita-acara', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'berita-acara', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'berita-acara', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'dashboard', 'akumulasi.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'laporan-transaksi-keuangan', 'download.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'laporan-transaksi-keuangan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'laporan-transaksi-keuangan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (4, 'laporan-transaksi-keuangan', 'transaksi-keuangan.xlsx');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'anggota', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'anggota', 'tampil-pertemuan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'anggota', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'berita-acara', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'berita-acara', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'dashboard', 'akumulasi.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'laporan-transaksi-keuangan', 'download.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'laporan-transaksi-keuangan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'laporan-transaksi-keuangan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'laporan-transaksi-keuangan', 'transaksi-keuangan.xlsx');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'pertemuan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'pertemuan', 'load-file.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'pertemuan', 'tampil-broadcast.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (5, 'pertemuan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'dashboard', 'Salinan akumulasi.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'dashboard', 'akumulasi.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'dashboard', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'katalog', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'katalog', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'laporan-penjualan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'laporan-penjualan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'laporan-stok', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'laporan-stok', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penawaran', 'cetak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penawaran', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penawaran', 'get-email.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penawaran', 'get-karyawan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penawaran', 'get-no-telp.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penawaran', 'simpan-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penawaran', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penawaran', 'tampil-barang.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penawaran', 'tampil-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penawaran', 'tampil-jasa.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penawaran', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penawaran', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'pengiriman', 'cetak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'pengiriman', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'pengiriman', 'function.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'pengiriman', 'simpan-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'pengiriman', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'pengiriman', 'tampil-add-kirim.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'pengiriman', 'tampil-barang-masuk-detail.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'pengiriman', 'tampil-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'pengiriman', 'tampil-penjualan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'pengiriman', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'pengiriman', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'cetak-kwitansi.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'cetak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'get-email.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'get-karyawan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'get-no-telp.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'hapus-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'simpan-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'simpan-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'simpan-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'tampil-barang-masuk-detail.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'tampil-barang.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'tampil-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'tampil-jasa.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'tampil-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'tampil-penawaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'tampil-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'tampil-pesanan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'ubah-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (2, 'penjualan', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'absensi', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'absensi', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'absensi', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'bank', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'bank', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'bank', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'bank', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'bank', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang', 'upload.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang-masuk', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang-masuk', 'get-rak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang-masuk', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang-masuk', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang-masuk', 'tampil-barang.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang-masuk', 'tampil-pembelian-detail.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang-masuk', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'barang-masuk', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'cabang', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'cabang', 'get-email.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'cabang', 'get-no-telp.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'cabang', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'cabang', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'cabang', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'cabang', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'catatan-penawaran', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'catatan-penawaran', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'catatan-penawaran', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'catatan-penawaran', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'catatan-penawaran', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'customer', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'customer', 'get-email.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'customer', 'get-no-telp.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'customer', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'customer', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'customer', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'customer', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'dashboard', 'Salinan akumulasi.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'dashboard', 'akumulasi.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'dashboard', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'dashboard', 'tampil-pembelian.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'dashboard', 'tampil-penawaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'dashboard', 'tampil-penjualan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'dashboard', 'tampil-pesanan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'dashboard', 'tampil-tanggapan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'gudang', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'gudang', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'gudang', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'gudang', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'gudang', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'hari-libur', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'hari-libur', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'hari-libur', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'hari-libur', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'hari-libur', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'izin', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'izin', 'get-karyawan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'izin', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'izin', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'izin', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'izin', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jabatan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jabatan', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jabatan', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jabatan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jabatan', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jam-kerja', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jam-kerja', 'hapus-shift-jam-kerja.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jam-kerja', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jam-kerja', 'simpan-shift-jam-kerja.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jam-kerja', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jam-kerja', 'tampil-shift-jam-kerja.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jam-kerja', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jam-kerja', 'ubah-shift-jam-kerja.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jam-kerja', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jasa', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jasa', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jasa', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jasa', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jasa', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jenis-customer', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jenis-customer', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jenis-customer', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jenis-customer', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jenis-customer', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jenis-supplier', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jenis-supplier', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jenis-supplier', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jenis-supplier', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'jenis-supplier', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'karyawan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'karyawan', 'get-no-hp.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'karyawan', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'karyawan', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'karyawan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'karyawan', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'karyawan', 'upload-foto.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'kata-pengantar', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'kata-pengantar', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'kata-pengantar', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'kata-pengantar', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'kata-pengantar', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'katalog', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'katalog', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'kategori', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'kategori', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'kategori', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'kategori', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'kategori', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-pembelian', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-pembelian', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-penerimaan-pembayaran', '.DS_Store');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-penerimaan-pembayaran', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-penerimaan-pembayaran', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-penjualan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-penjualan', 'get-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-penjualan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-pesanan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-pesanan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-piutang-customer', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-piutang-customer', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-stok', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'laporan-stok', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'metode-pembayaran', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'metode-pembayaran', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'metode-pembayaran', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'metode-pembayaran', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'metode-pembayaran', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pembelian', 'cetak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pembelian', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pembelian', 'get-email.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pembelian', 'get-no-telp.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pembelian', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pembelian', 'simpan-supplier.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pembelian', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pembelian', 'tampil-barang.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pembelian', 'tampil-pemesanan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pembelian', 'tampil-supplier.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pembelian', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pembelian', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'cetak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'get-email.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'get-karyawan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'get-no-telp.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'simpan-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'tampil-barang.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'tampil-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'tampil-jasa.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran-proyek', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'cetak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'get-email.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'get-karyawan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'get-no-telp.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'simpan-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'tampil-barang.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'tampil-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'tampil-jasa.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penawaran', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-penawaran', '.DS_Store');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-penawaran', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-penawaran', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-penawaran', 'terima.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-penawaran', 'tolak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pengiriman', 'cetak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pengiriman', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pengiriman', 'function.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pengiriman', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pengiriman', 'simpan-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pengiriman', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pengiriman', 'tampil-add-kirim.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pengiriman', 'tampil-barang-masuk-detail.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pengiriman', 'tampil-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pengiriman', 'tampil-penjualan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pengiriman', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pengiriman', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', '.DS_Store');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'cetak-kwitansi.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'cetak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'get-email.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'get-karyawan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'get-no-telp.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'hapus-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'simpan-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'simpan-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'simpan-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'tampil-barang-masuk-detail.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'tampil-barang.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'tampil-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'tampil-jasa.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'tampil-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'tampil-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'tampil-pesanan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'ubah-pembayaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'penjualan', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-penjualan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-penjualan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-penjualan', 'terima.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-penjualan', 'tolak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'cetak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'get-email.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'get-karyawan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'get-no-telp.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'simpan-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'tampil-barang.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'tampil-customer.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'tampil-jasa.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'tampil-penawaran.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pesanan', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-pesanan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-pesanan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-pesanan', 'terima.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'approval-pesanan', 'tolak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pindah-rak', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pindah-rak', 'get-rak.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pindah-rak', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pindah-rak', 'tampil-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'pindah-rak', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'rak', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'rak', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'rak', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'rak', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'rak', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'satuan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'satuan', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'satuan', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'satuan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'satuan', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'supplier', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'supplier', 'get-email.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'supplier', 'get-no-telp.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'supplier', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'supplier', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'supplier', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'supplier', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'tanda-tangan', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'tanda-tangan', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'tanda-tangan', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'tanda-tangan', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'tanda-tangan', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users', 'get-karyawan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users-level', 'form-akses-menu.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users-level', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users-level', 'hapus.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users-level', 'simpan-akses.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users-level', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users-level', 'tampil.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'users-level', 'ubah.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'validasi-absensi', 'form.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'validasi-absensi', 'simpan.php');
INSERT INTO `menu_akses` (`users_level_id`, `url`, `action`) VALUES (1, 'validasi-absensi', 'tampil.php');
COMMIT;

-- ----------------------------
-- Table structure for metode_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `metode_pembayaran`;
CREATE TABLE `metode_pembayaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `metode_pembayaran` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of metode_pembayaran
-- ----------------------------
BEGIN;
INSERT INTO `metode_pembayaran` (`id`, `metode_pembayaran`) VALUES (1, 'Tunai');
INSERT INTO `metode_pembayaran` (`id`, `metode_pembayaran`) VALUES (2, 'Transfer Ke Bank Mandiri');
COMMIT;

-- ----------------------------
-- Table structure for pembelian
-- ----------------------------
DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE `pembelian` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tanda_tangan_id` bigint(20) DEFAULT NULL,
  `supplier_id` bigint(20) DEFAULT NULL,
  `nama_supplier` varchar(255) DEFAULT NULL,
  `alamat_supplier` varchar(255) DEFAULT NULL,
  `no_telp_supplier` varchar(255) DEFAULT NULL,
  `no_wa_supplier` varchar(255) DEFAULT NULL,
  `email_supplier` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `persen_diskon` decimal(20,2) DEFAULT NULL,
  `diskon` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pembelian
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for pembelian_detail
-- ----------------------------
DROP TABLE IF EXISTS `pembelian_detail`;
CREATE TABLE `pembelian_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pembelian_id` bigint(20) DEFAULT NULL,
  `barang_id` bigint(20) DEFAULT NULL,
  `harga` decimal(20,2) DEFAULT NULL,
  `jenis_ppn` varchar(100) DEFAULT NULL,
  `harga_sebelum_ppn` decimal(20,2) DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `sub_total_sebelum_ppn` decimal(20,2) DEFAULT NULL,
  `diskon_item` decimal(20,2) DEFAULT NULL,
  `diskon_item_detail` text DEFAULT NULL,
  `diskon_faktur` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `nominal_ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `masuk_gudang` decimal(20,2) DEFAULT NULL,
  `retur` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pembelian_detail
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for penawaran
-- ----------------------------
DROP TABLE IF EXISTS `penawaran`;
CREATE TABLE `penawaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kata_pengantar_id` bigint(20) DEFAULT NULL,
  `catatan_penawaran_id` bigint(20) DEFAULT NULL,
  `tanda_tangan_id` bigint(20) DEFAULT NULL,
  `batas_waktu` decimal(20,2) DEFAULT NULL,
  `karyawan_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `nama_customer` varchar(255) DEFAULT NULL,
  `alamat_customer` varchar(255) DEFAULT NULL,
  `no_telp_customer` varchar(255) DEFAULT NULL,
  `no_wa_customer` varchar(255) DEFAULT NULL,
  `email_customer` varchar(255) DEFAULT NULL,
  `credit_limit_customer` decimal(20,2) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  `jumlah_pesanan` decimal(20,2) DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `persen_diskon` decimal(20,2) DEFAULT NULL,
  `diskon` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_type` varchar(255) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejected_by` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of penawaran
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for penawaran_detail
-- ----------------------------
DROP TABLE IF EXISTS `penawaran_detail`;
CREATE TABLE `penawaran_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `penawaran_id` bigint(20) DEFAULT NULL,
  `barang_id` bigint(20) DEFAULT NULL,
  `jasa_id` bigint(20) DEFAULT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `harga` decimal(20,2) DEFAULT NULL,
  `jenis_ppn` varchar(100) DEFAULT NULL,
  `harga_sebelum_ppn` decimal(20,2) DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  `jumlah_pesanan` decimal(20,2) DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `sub_total_sebelum_ppn` decimal(20,2) DEFAULT NULL,
  `diskon_item` decimal(20,2) DEFAULT NULL,
  `diskon_item_detail` text DEFAULT NULL,
  `diskon_faktur` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `nominal_ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_type` varchar(255) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejected_by` varchar(255) DEFAULT NULL,
  `retur` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of penawaran_detail
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for penawaran_proyek
-- ----------------------------
DROP TABLE IF EXISTS `penawaran_proyek`;
CREATE TABLE `penawaran_proyek` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kata_pengantar_id` bigint(20) DEFAULT NULL,
  `catatan_penawaran_id` bigint(20) DEFAULT NULL,
  `tanda_tangan_id` bigint(20) DEFAULT NULL,
  `batas_waktu` decimal(20,2) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `nama_customer` varchar(255) DEFAULT NULL,
  `alamat_customer` varchar(255) DEFAULT NULL,
  `no_telp_customer` varchar(255) DEFAULT NULL,
  `no_wa_customer` varchar(255) DEFAULT NULL,
  `email_customer` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  `jumlah_pesanan` decimal(20,2) DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `persen_diskon` decimal(20,2) DEFAULT NULL,
  `diskon` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_type` varchar(255) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejected_by` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of penawaran_proyek
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for penawaran_proyek_detail
-- ----------------------------
DROP TABLE IF EXISTS `penawaran_proyek_detail`;
CREATE TABLE `penawaran_proyek_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `penawaran_proyek_id` bigint(20) DEFAULT NULL,
  `no_kelompok` int(11) DEFAULT NULL,
  `nama_kelompok` varchar(255) DEFAULT NULL,
  `uraian` varchar(255) DEFAULT NULL,
  `harga` decimal(20,2) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of penawaran_proyek_detail
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for pengiriman
-- ----------------------------
DROP TABLE IF EXISTS `pengiriman`;
CREATE TABLE `pengiriman` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `penjualan_id` bigint(20) DEFAULT NULL,
  `jenis_pengiriman` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pengiriman
-- ----------------------------
BEGIN;
INSERT INTO `pengiriman` (`id`, `cabang_id`, `kode`, `nomor`, `tahun`, `tanggal`, `penjualan_id`, `jenis_pengiriman`, `detail`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (1, 1, 'DO', 1, 2026, '2026-11-23', 3, 'Diambil', '[{\"id\":1,\"pengiriman_id\":1,\"penjualan_detail_ditandai_id\":1,\"jumlah\":1}]', '2026-11-24 02:31:09', 'sebastian', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for pengiriman_detail
-- ----------------------------
DROP TABLE IF EXISTS `pengiriman_detail`;
CREATE TABLE `pengiriman_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pengiriman_id` bigint(20) DEFAULT NULL,
  `penjualan_detail_ditandai_id` bigint(20) DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pengiriman_detail
-- ----------------------------
BEGIN;
INSERT INTO `pengiriman_detail` (`id`, `pengiriman_id`, `penjualan_detail_ditandai_id`, `jumlah`) VALUES (1, 1, 1, 1.00);
COMMIT;

-- ----------------------------
-- Table structure for penjualan
-- ----------------------------
DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE `penjualan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `pesanan_id` bigint(20) DEFAULT NULL,
  `karyawan_id` bigint(20) DEFAULT NULL,
  `batas_waktu_pembayaran` int(11) DEFAULT NULL,
  `tanda_tangan_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `nama_customer` varchar(255) DEFAULT NULL,
  `alamat_customer` varchar(255) DEFAULT NULL,
  `no_telp_customer` varchar(255) DEFAULT NULL,
  `no_wa_customer` varchar(255) DEFAULT NULL,
  `email_customer` varchar(255) DEFAULT NULL,
  `credit_limit_customer` decimal(20,2) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `persen_diskon` decimal(20,2) DEFAULT NULL,
  `diskon` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `bank_id` bigint(20) DEFAULT NULL,
  `termin` text DEFAULT NULL,
  `dibayar` decimal(20,2) DEFAULT NULL,
  `pembayaran` text DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_type` varchar(255) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejected_by` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of penjualan
-- ----------------------------
BEGIN;
INSERT INTO `penjualan` (`id`, `cabang_id`, `kode`, `nomor`, `tahun`, `tanggal`, `pesanan_id`, `karyawan_id`, `batas_waktu_pembayaran`, `tanda_tangan_id`, `customer_id`, `nama_customer`, `alamat_customer`, `no_telp_customer`, `no_wa_customer`, `email_customer`, `credit_limit_customer`, `detail`, `sub_total`, `persen_diskon`, `diskon`, `dpp`, `persen_ppn`, `ppn`, `total`, `bank_id`, `termin`, `dibayar`, `pembayaran`, `approved_at`, `approved_by`, `approved_type`, `rejected_at`, `rejected_by`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (3, 1, 'INV', 1, 2026, '2026-11-24', NULL, 1, NULL, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":4,\"penjualan_id\":3,\"pesanan_detail_id\":null,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Non PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":0,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4570000,\"approved_at\":\"2026-11-24 02:29:25\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"jumlah_ditandai\":1,\"jumlah_dikirim\":1,\"ditandai\":[{\"id\":1,\"penjualan_detail_id\":4,\"barang_masuk_detail_id\":2,\"jumlah\":1,\"dikirim\":1}],\"jumlah_retur\":null}]', 4570000.00, NULL, NULL, 0.00, NULL, 0.00, 4570000.00, 1, '[{\"id\":4,\"penjualan_id\":3,\"tanggal\":\"2026-12-01\",\"nominal\":1000000,\"dibayar\":1000000},{\"id\":5,\"penjualan_id\":3,\"tanggal\":\"2026-12-09\",\"nominal\":1000000,\"dibayar\":0},{\"id\":6,\"penjualan_id\":3,\"tanggal\":\"2026-12-16\",\"nominal\":1570000,\"dibayar\":0},{\"id\":7,\"penjualan_id\":3,\"tanggal\":\"2026-11-24\",\"nominal\":1000000,\"dibayar\":null}]', 1000000.00, '[{\"id\":3,\"penjualan_id\":3,\"tanggal\":\"2026-11-24\",\"nominal\":1000000,\"metode_pembayaran_id\":2,\"keterangan\":null,\"created_at\":\"2026-11-24 02:26:42\",\"created_by\":\"sebastian\",\"updated_at\":null,\"updated_by\":null}]', '2026-11-24 02:29:25', 'sebastian', 'auto', NULL, NULL, '2026-11-24 02:26:22', 'sebastian', '2026-11-24 02:29:25', 'sebastian');
COMMIT;

-- ----------------------------
-- Table structure for penjualan_detail
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_detail`;
CREATE TABLE `penjualan_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `penjualan_id` bigint(20) DEFAULT NULL,
  `pesanan_detail_id` bigint(20) DEFAULT NULL,
  `barang_id` bigint(20) DEFAULT NULL,
  `jasa_id` bigint(20) DEFAULT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `harga` decimal(20,2) DEFAULT NULL,
  `jenis_ppn` varchar(255) DEFAULT NULL,
  `harga_sebelum_ppn` decimal(20,2) DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `sub_total_sebelum_ppn` decimal(20,2) DEFAULT NULL,
  `diskon_item` decimal(20,2) DEFAULT NULL,
  `diskon_item_detail` text DEFAULT NULL,
  `diskon_faktur` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `nominal_ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_type` varchar(255) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejected_by` varchar(255) DEFAULT NULL,
  `jumlah_ditandai` decimal(20,2) DEFAULT NULL,
  `jumlah_dikirim` decimal(20,2) DEFAULT NULL,
  `ditandai` text DEFAULT NULL,
  `jumlah_retur` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of penjualan_detail
-- ----------------------------
BEGIN;
INSERT INTO `penjualan_detail` (`id`, `penjualan_id`, `pesanan_detail_id`, `barang_id`, `jasa_id`, `nama_produk`, `satuan`, `harga`, `jenis_ppn`, `harga_sebelum_ppn`, `jumlah`, `sub_total`, `sub_total_sebelum_ppn`, `diskon_item`, `diskon_item_detail`, `diskon_faktur`, `dpp`, `persen_ppn`, `nominal_ppn`, `total`, `approved_at`, `approved_by`, `approved_type`, `rejected_at`, `rejected_by`, `jumlah_ditandai`, `jumlah_dikirim`, `ditandai`, `jumlah_retur`) VALUES (4, 3, NULL, 6, NULL, '001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)', 'Unit', 4570000.00, 'Non PPN', 4570000.00, 1.00, 4570000.00, 4570000.00, 0.00, '[]', 0.00, 0.00, 0.00, 0.00, 4570000.00, '2026-11-24 02:29:25', 'sebastian', 'auto', NULL, NULL, 1.00, 1.00, '[{\"id\":1,\"penjualan_detail_id\":4,\"barang_masuk_detail_id\":2,\"jumlah\":1,\"dikirim\":1}]', NULL);
COMMIT;

-- ----------------------------
-- Table structure for penjualan_detail_ditandai
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_detail_ditandai`;
CREATE TABLE `penjualan_detail_ditandai` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `penjualan_detail_id` bigint(20) DEFAULT NULL,
  `barang_masuk_detail_id` bigint(20) DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  `dikirim` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of penjualan_detail_ditandai
-- ----------------------------
BEGIN;
INSERT INTO `penjualan_detail_ditandai` (`id`, `penjualan_detail_id`, `barang_masuk_detail_id`, `jumlah`, `dikirim`) VALUES (1, 4, 2, 1.00, 1.00);
COMMIT;

-- ----------------------------
-- Table structure for penjualan_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_pembayaran`;
CREATE TABLE `penjualan_pembayaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `penjualan_id` bigint(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nominal` decimal(20,2) DEFAULT NULL,
  `metode_pembayaran_id` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of penjualan_pembayaran
-- ----------------------------
BEGIN;
INSERT INTO `penjualan_pembayaran` (`id`, `penjualan_id`, `tanggal`, `nominal`, `metode_pembayaran_id`, `keterangan`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (3, 3, '2026-11-24', 1000000.00, 2, NULL, '2026-11-24 02:26:42', 'sebastian', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for penjualan_termin
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_termin`;
CREATE TABLE `penjualan_termin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `penjualan_id` bigint(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nominal` decimal(20,2) DEFAULT NULL,
  `dibayar` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of penjualan_termin
-- ----------------------------
BEGIN;
INSERT INTO `penjualan_termin` (`id`, `penjualan_id`, `tanggal`, `nominal`, `dibayar`) VALUES (4, 3, '2026-12-01', 1000000.00, 0.00);
INSERT INTO `penjualan_termin` (`id`, `penjualan_id`, `tanggal`, `nominal`, `dibayar`) VALUES (5, 3, '2026-12-09', 1000000.00, 0.00);
INSERT INTO `penjualan_termin` (`id`, `penjualan_id`, `tanggal`, `nominal`, `dibayar`) VALUES (6, 3, '2026-12-16', 1570000.00, 0.00);
INSERT INTO `penjualan_termin` (`id`, `penjualan_id`, `tanggal`, `nominal`, `dibayar`) VALUES (7, 3, '2026-11-24', 1000000.00, 1000000.00);
COMMIT;

-- ----------------------------
-- Table structure for perusahaan
-- ----------------------------
DROP TABLE IF EXISTS `perusahaan`;
CREATE TABLE `perusahaan` (
  `kode_perusahaan` varchar(255) DEFAULT NULL,
  `nama_perusahaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of perusahaan
-- ----------------------------
BEGIN;
INSERT INTO `perusahaan` (`kode_perusahaan`, `nama_perusahaan`) VALUES ('MIE', 'PT Mitra Integrasi Engineering');
COMMIT;

-- ----------------------------
-- Table structure for pesanan
-- ----------------------------
DROP TABLE IF EXISTS `pesanan`;
CREATE TABLE `pesanan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nomor_po` varchar(255) DEFAULT NULL,
  `batas_waktu` int(11) DEFAULT NULL,
  `karyawan_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `nama_customer` varchar(255) DEFAULT NULL,
  `alamat_customer` varchar(255) DEFAULT NULL,
  `no_telp_customer` varchar(255) DEFAULT NULL,
  `no_wa_customer` varchar(255) DEFAULT NULL,
  `email_customer` varchar(255) DEFAULT NULL,
  `credit_limit_customer` decimal(20,2) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  `jumlah_penjualan` decimal(20,2) DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `persen_diskon` decimal(20,2) DEFAULT NULL,
  `diskon` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_type` varchar(255) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejected_by` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pesanan
-- ----------------------------
BEGIN;
INSERT INTO `pesanan` (`id`, `cabang_id`, `kode`, `nomor`, `tahun`, `tanggal`, `nomor_po`, `batas_waktu`, `karyawan_id`, `customer_id`, `nama_customer`, `alamat_customer`, `no_telp_customer`, `no_wa_customer`, `email_customer`, `credit_limit_customer`, `detail`, `jumlah`, `jumlah_penjualan`, `sub_total`, `persen_diskon`, `diskon`, `dpp`, `persen_ppn`, `ppn`, `total`, `approved_at`, `approved_by`, `approved_type`, `rejected_at`, `rejected_by`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (1, 1, '01', 1, 2026, '2026-11-23', 'PO1', 8, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":1,\"pesanan_id\":1,\"penawaran_detail_id\":null,\"barang_id\":4,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC15YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 0,5 PK (5.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":3840000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":3840000,\"jumlah\":2,\"jumlah_penjualan\":null,\"sub_total\":7680000,\"sub_total_sebelum_ppn\":7680000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":7680000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":7680000,\"approved_at\":\"2026-11-23 21:27:16\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"retur\":null}]', 2.00, NULL, 7680000.00, NULL, NULL, 7680000.00, NULL, 0.00, 7680000.00, '2026-11-23 21:27:16', 'sebastian', 'auto', NULL, NULL, '2026-11-23 21:27:16', 'sebastian', NULL, NULL);
INSERT INTO `pesanan` (`id`, `cabang_id`, `kode`, `nomor`, `tahun`, `tanggal`, `nomor_po`, `batas_waktu`, `karyawan_id`, `customer_id`, `nama_customer`, `alamat_customer`, `no_telp_customer`, `no_wa_customer`, `email_customer`, `credit_limit_customer`, `detail`, `jumlah`, `jumlah_penjualan`, `sub_total`, `persen_diskon`, `diskon`, `dpp`, `persen_ppn`, `ppn`, `total`, `approved_at`, `approved_by`, `approved_type`, `rejected_at`, `rejected_by`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (2, 1, '01', 2, 2026, '2026-11-24', 'PO2', 9, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":2,\"pesanan_id\":2,\"penawaran_detail_id\":2,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"jumlah_penjualan\":0,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":457000,\"dpp\":4113000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4113000,\"approved_at\":\"2026-11-24 02:20:16\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"retur\":null}]', 1.00, 0.00, 4570000.00, 10.00, 457000.00, 4113000.00, NULL, 0.00, 4113000.00, '2026-11-24 02:20:16', 'sebastian', 'auto', NULL, NULL, '2026-11-24 02:20:16', 'sebastian', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for pesanan_detail
-- ----------------------------
DROP TABLE IF EXISTS `pesanan_detail`;
CREATE TABLE `pesanan_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint(20) DEFAULT NULL,
  `penawaran_detail_id` bigint(20) DEFAULT NULL,
  `barang_id` bigint(20) DEFAULT NULL,
  `jasa_id` bigint(20) DEFAULT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `harga` decimal(20,2) DEFAULT NULL,
  `jenis_ppn` varchar(100) DEFAULT NULL,
  `harga_sebelum_ppn` decimal(20,2) DEFAULT NULL,
  `jumlah` decimal(20,2) DEFAULT NULL,
  `jumlah_penjualan` decimal(20,2) DEFAULT NULL,
  `sub_total` decimal(20,2) DEFAULT NULL,
  `sub_total_sebelum_ppn` decimal(20,2) DEFAULT NULL,
  `diskon_item` decimal(20,2) DEFAULT NULL,
  `diskon_item_detail` text DEFAULT NULL,
  `diskon_faktur` decimal(20,2) DEFAULT NULL,
  `dpp` decimal(20,2) DEFAULT NULL,
  `persen_ppn` decimal(20,2) DEFAULT NULL,
  `nominal_ppn` decimal(20,2) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_type` varchar(255) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejected_by` varchar(255) DEFAULT NULL,
  `retur` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pesanan_detail
-- ----------------------------
BEGIN;
INSERT INTO `pesanan_detail` (`id`, `pesanan_id`, `penawaran_detail_id`, `barang_id`, `jasa_id`, `nama_produk`, `satuan`, `harga`, `jenis_ppn`, `harga_sebelum_ppn`, `jumlah`, `jumlah_penjualan`, `sub_total`, `sub_total_sebelum_ppn`, `diskon_item`, `diskon_item_detail`, `diskon_faktur`, `dpp`, `persen_ppn`, `nominal_ppn`, `total`, `approved_at`, `approved_by`, `approved_type`, `rejected_at`, `rejected_by`, `retur`) VALUES (1, 1, NULL, 4, NULL, '001 - AC DAIKIN STC15YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 0,5 PK (5.000 BTU/H)', 'Unit', 3840000.00, 'Belum PPN', 3840000.00, 2.00, NULL, 7680000.00, 7680000.00, 0.00, '[]', 0.00, 7680000.00, 0.00, 0.00, 7680000.00, '2026-11-23 21:27:16', 'sebastian', 'auto', NULL, NULL, NULL);
INSERT INTO `pesanan_detail` (`id`, `pesanan_id`, `penawaran_detail_id`, `barang_id`, `jasa_id`, `nama_produk`, `satuan`, `harga`, `jenis_ppn`, `harga_sebelum_ppn`, `jumlah`, `jumlah_penjualan`, `sub_total`, `sub_total_sebelum_ppn`, `diskon_item`, `diskon_item_detail`, `diskon_faktur`, `dpp`, `persen_ppn`, `nominal_ppn`, `total`, `approved_at`, `approved_by`, `approved_type`, `rejected_at`, `rejected_by`, `retur`) VALUES (2, 2, 2, 6, NULL, '001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)', 'Unit', 4570000.00, 'Belum PPN', 4570000.00, 1.00, 0.00, 4570000.00, 4570000.00, 0.00, '[]', 457000.00, 4113000.00, 0.00, 0.00, 4113000.00, '2026-11-24 02:20:16', 'sebastian', 'auto', NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for rak
-- ----------------------------
DROP TABLE IF EXISTS `rak`;
CREATE TABLE `rak` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gudang_id` bigint(20) DEFAULT NULL,
  `nama_rak` varchar(255) DEFAULT NULL,
  `karantina` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of rak
-- ----------------------------
BEGIN;
INSERT INTO `rak` (`id`, `gudang_id`, `nama_rak`, `karantina`) VALUES (1, 1, 'Lantai 1', 0);
INSERT INTO `rak` (`id`, `gudang_id`, `nama_rak`, `karantina`) VALUES (2, 1, 'Lantai 2', 0);
INSERT INTO `rak` (`id`, `gudang_id`, `nama_rak`, `karantina`) VALUES (3, 1, 'Lantai 3', 0);
COMMIT;

-- ----------------------------
-- Table structure for satuan
-- ----------------------------
DROP TABLE IF EXISTS `satuan`;
CREATE TABLE `satuan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `satuan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of satuan
-- ----------------------------
BEGIN;
INSERT INTO `satuan` (`id`, `satuan`) VALUES (1, 'Pcs');
INSERT INTO `satuan` (`id`, `satuan`) VALUES (2, 'Meter');
INSERT INTO `satuan` (`id`, `satuan`) VALUES (3, 'Roll');
INSERT INTO `satuan` (`id`, `satuan`) VALUES (6, 'Unit');
INSERT INTO `satuan` (`id`, `satuan`) VALUES (7, 'Batang');
INSERT INTO `satuan` (`id`, `satuan`) VALUES (8, 'Kegiatan');
INSERT INTO `satuan` (`id`, `satuan`) VALUES (9, 'Set');
INSERT INTO `satuan` (`id`, `satuan`) VALUES (10, 'Ls');
INSERT INTO `satuan` (`id`, `satuan`) VALUES (11, 'Lot');
COMMIT;

-- ----------------------------
-- Table structure for shift_jam_kerja
-- ----------------------------
DROP TABLE IF EXISTS `shift_jam_kerja`;
CREATE TABLE `shift_jam_kerja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jam_kerja_id` int(11) DEFAULT NULL,
  `shift` varchar(255) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `senin` int(11) DEFAULT NULL,
  `selasa` int(11) DEFAULT NULL,
  `rabu` int(11) DEFAULT NULL,
  `kamis` int(11) DEFAULT NULL,
  `jumat` int(11) DEFAULT NULL,
  `sabtu` int(11) DEFAULT NULL,
  `minggu` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of shift_jam_kerja
-- ----------------------------
BEGIN;
INSERT INTO `shift_jam_kerja` (`id`, `jam_kerja_id`, `shift`, `jam_masuk`, `jam_pulang`, `senin`, `selasa`, `rabu`, `kamis`, `jumat`, `sabtu`, `minggu`) VALUES (3, 1, 'AA', '08:31:00', '13:40:00', 1, 1, 1, 1, 1, 1, 0);
COMMIT;

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_supplier_id` bigint(20) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telp` text DEFAULT NULL,
  `no_wa` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of supplier
-- ----------------------------
BEGIN;
INSERT INTO `supplier` (`id`, `jenis_supplier_id`, `nama`, `alamat`, `no_telp`, `no_wa`, `email`) VALUES (1, 2, 'Sebarga', 'Jl. AH. Nasution No. 17', '[{\"no_telp\":\"08122281231\"}]', '[{\"no_wa\":\"08122281231\"}]', NULL);
COMMIT;

-- ----------------------------
-- Table structure for tanda_tangan
-- ----------------------------
DROP TABLE IF EXISTS `tanda_tangan`;
CREATE TABLE `tanda_tangan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tanda_tangan` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `file_ttd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tanda_tangan
-- ----------------------------
BEGIN;
INSERT INTO `tanda_tangan` (`id`, `tanda_tangan`, `nama`, `jabatan`, `file_ttd`) VALUES (1, 'Berisi', 'VRATIKA', 'DIREKTUR', '20260415114647.png');
INSERT INTO `tanda_tangan` (`id`, `tanda_tangan`, `nama`, `jabatan`, `file_ttd`) VALUES (2, 'Kosong', 'VRATIKA', 'DIREKTUR', NULL);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `users_level_id` int(11) DEFAULT NULL COMMENT '1 = Publik\r\n2 = Admin',
  `cabang_id` bigint(20) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `karyawan_id` bigint(20) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`username`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` (`username`, `password`, `users_level_id`, `cabang_id`, `nama`, `jabatan`, `karyawan_id`, `last_login`) VALUES ('001', NULL, 2, 1, 'Dedi Wijaya', 'Admin', 1, NULL);
INSERT INTO `users` (`username`, `password`, `users_level_id`, `cabang_id`, `nama`, `jabatan`, `karyawan_id`, `last_login`) VALUES ('admin', 'D020BBE760B03D57B3DAFFD56DA97A88', 3, NULL, NULL, NULL, NULL, '2026-05-09 09:42:03');
INSERT INTO `users` (`username`, `password`, `users_level_id`, `cabang_id`, `nama`, `jabatan`, `karyawan_id`, `last_login`) VALUES ('emi', 'B8D85278BA64E65A5A42EC6EF3AEF773', 3, NULL, NULL, NULL, NULL, '2026-11-21 19:23:06');
INSERT INTO `users` (`username`, `password`, `users_level_id`, `cabang_id`, `nama`, `jabatan`, `karyawan_id`, `last_login`) VALUES ('sebastian', '4EF85E04C537B51F6CE117869B64EE64', 1, NULL, 'Sebastian', NULL, 6, '2026-11-26 15:54:52');
INSERT INTO `users` (`username`, `password`, `users_level_id`, `cabang_id`, `nama`, `jabatan`, `karyawan_id`, `last_login`) VALUES ('tasya', '3830DFE131B2B227176795DD6DF39C6916F25D384E066476575F030368625A87', 3, NULL, NULL, NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for users_level
-- ----------------------------
DROP TABLE IF EXISTS `users_level`;
CREATE TABLE `users_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of users_level
-- ----------------------------
BEGIN;
INSERT INTO `users_level` (`id`, `level`) VALUES (1, 'Developer');
INSERT INTO `users_level` (`id`, `level`) VALUES (2, 'Sales');
INSERT INTO `users_level` (`id`, `level`) VALUES (3, 'Admin');
COMMIT;

-- ----------------------------
-- Function structure for to_roman
-- ----------------------------
DROP FUNCTION IF EXISTS `to_roman`;
delimiter ;;
CREATE FUNCTION `to_roman`(n INT)
 RETURNS varchar(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
  DETERMINISTIC
BEGIN
    DECLARE result VARCHAR(50) DEFAULT '';

    WHILE n >= 1000 DO
        SET result = CONCAT(result, 'M');
        SET n = n - 1000;
    END WHILE;

    IF n >= 900 THEN SET result = CONCAT(result, 'CM'); SET n = n - 900; END IF;
    IF n >= 500 THEN SET result = CONCAT(result, 'D'); SET n = n - 500; END IF;
    IF n >= 400 THEN SET result = CONCAT(result, 'CD'); SET n = n - 400; END IF;

    WHILE n >= 100 DO
        SET result = CONCAT(result, 'C');
        SET n = n - 100;
    END WHILE;

    IF n >= 90 THEN SET result = CONCAT(result, 'XC'); SET n = n - 90; END IF;
    IF n >= 50 THEN SET result = CONCAT(result, 'L'); SET n = n - 50; END IF;
    IF n >= 40 THEN SET result = CONCAT(result, 'XL'); SET n = n - 40; END IF;

    WHILE n >= 10 DO
        SET result = CONCAT(result, 'X');
        SET n = n - 10;
    END WHILE;

    IF n >= 9 THEN SET result = CONCAT(result, 'IX'); SET n = n - 9; END IF;
    IF n >= 5 THEN SET result = CONCAT(result, 'V'); SET n = n - 5; END IF;
    IF n >= 4 THEN SET result = CONCAT(result, 'IV'); SET n = n - 4; END IF;

    WHILE n >= 1 DO
        SET result = CONCAT(result, 'I');
        SET n = n - 1;
    END WHILE;

    RETURN result;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
