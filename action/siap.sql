/*
 Navicat Premium Data Transfer

 Source Server         : SIAP MIE
 Source Server Type    : MySQL
 Source Server Version : 110809 (11.8.9-MariaDB-log)
 Source Host           : srv1235.hstgr.io:3306
 Source Schema         : u674869047_siap_mie

 Target Server Type    : MySQL
 Target Server Version : 110809 (11.8.9-MariaDB-log)
 File Encoding         : 65001

 Date: 25/11/2026 15:01:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for absensi
-- ----------------------------
DROP TABLE IF EXISTS `absensi`;
CREATE TABLE `absensi`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint NULL DEFAULT NULL,
  `karyawan_id` bigint NULL DEFAULT NULL,
  `jenis_absen` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_waktu` datetime NULL DEFAULT NULL,
  `status` int NULL DEFAULT NULL COMMENT ' 0 = Foto Belum Divalidasi\r\n 1 = Validasi Ditolak\r\n 2 = Validasi Diterima',
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of absensi
-- ----------------------------
INSERT INTO `absensi` VALUES (1, 2, 1, 'Masuk', '2024-12-15 08:37:06', 1, NULL);
INSERT INTO `absensi` VALUES (2, 2, 1, 'Masuk', '2024-12-15 14:01:49', 1, NULL);
INSERT INTO `absensi` VALUES (3, 2, 1, 'Masuk', '2024-12-15 14:21:31', 0, NULL);
INSERT INTO `absensi` VALUES (4, 2, 1, 'Pulang', '2024-12-15 14:21:35', 1, NULL);
INSERT INTO `absensi` VALUES (5, 2, 1, 'Masuk', '2024-12-15 14:21:40', 1, NULL);
INSERT INTO `absensi` VALUES (6, 2, 1, 'Pulang', '2024-12-15 14:21:45', 1, NULL);
INSERT INTO `absensi` VALUES (7, 2, 1, 'Masuk', '2024-12-15 14:21:50', 1, NULL);
INSERT INTO `absensi` VALUES (9, 2, 1, 'Masuk', '2024-12-16 16:53:52', 1, NULL);
INSERT INTO `absensi` VALUES (10, 2, 1, 'Masuk', '2024-12-16 18:36:07', 0, NULL);
INSERT INTO `absensi` VALUES (11, 2, 1, 'Masuk', '2024-12-17 07:36:29', 0, NULL);
INSERT INTO `absensi` VALUES (12, 2, 1, 'Masuk', '2025-10-08 15:12:48', 0, NULL);

-- ----------------------------
-- Table structure for bank
-- ----------------------------
DROP TABLE IF EXISTS `bank`;
CREATE TABLE `bank`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama_bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_rekening` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor_rekening` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kantor_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of bank
-- ----------------------------
INSERT INTO `bank` VALUES (1, 'Bank Central Asia', 'FREN COOL GROUP PT', '811-530-858-7', NULL);
INSERT INTO `bank` VALUES (2, 'Bank Rakyat Indonesia', 'Khairul Amri Dalimunthe', '208301034529501', NULL);
INSERT INTO `bank` VALUES (3, 'BRI', 'FREN COOL GROUP PT', '208301000717302', 'KCP WILLEM ISKANDAR');

-- ----------------------------
-- Table structure for barang
-- ----------------------------
DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kode` varchar(255) CHARACTER SET utf32 COLLATE utf32_general_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `merek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kapasitas_pk` decimal(10, 2) NULL DEFAULT NULL,
  `btuh` decimal(20, 2) NULL DEFAULT NULL,
  `ukuran` decimal(20, 2) NULL DEFAULT NULL,
  `satuan_id` bigint NULL DEFAULT NULL,
  `harga_beli` decimal(20, 2) NULL DEFAULT NULL,
  `harga_jual` decimal(20, 2) NULL DEFAULT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `diskon_jenis_customer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 129 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of barang
-- ----------------------------
INSERT INTO `barang` VALUES (4, NULL, '001', 'AC', 'DAIKIN', 'STC15YV', 'SPLIT WALL MOUNTED', 'SUPER MINI SPLIT (SMS)', 0.50, 5000.00, NULL, 6, 3706540.00, 3840000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STC15YV', NULL, NULL);
INSERT INTO `barang` VALUES (6, NULL, '001', 'AC', 'DAIKIN', 'STC25YV', 'SPLIT WALL MOUNTED', 'SUPER MINI SPLIT (SMS)', 1.00, 9000.00, NULL, 6, 4391993.00, 4570000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STC25YV', NULL, NULL);
INSERT INTO `barang` VALUES (7, NULL, '001', 'AC', 'DAIKIN', 'STC35YV', 'SPLIT WALL MOUNTED', 'SUPER MINI SPLIT (SMS)', 1.50, 12000.00, NULL, 6, 5440693.00, 5600000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STC35YV', NULL, NULL);
INSERT INTO `barang` VALUES (8, NULL, '001', 'AC', 'DAIKIN', 'STC50YV', 'SPLIT WALL MOUNTED', 'SUPER MINI SPLIT (SMS)', 2.00, 17100.00, NULL, 6, 7251269.00, 7550000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STC50YV', NULL, NULL);
INSERT INTO `barang` VALUES (9, NULL, '001', 'AC', 'DAIKIN', 'STP15AV', 'SPLIT WALL MOUNTED', 'BREEZE', 0.50, 5000.00, NULL, 6, 2956000.00, 3300000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STP15AV', NULL, NULL);
INSERT INTO `barang` VALUES (10, NULL, '001', 'AC', 'DAIKIN', 'STKE15YV', 'SPLIT WALL MOUNTED', 'BETA INVERTER', 0.50, 5000.00, NULL, 6, 4558426.00, 4600000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKE15YV', NULL, NULL);
INSERT INTO `barang` VALUES (11, NULL, '001', 'AC', 'DAIKIN', 'STKE20YV', 'SPLIT WALL MOUNTED', 'BETA INVERTER', 0.75, 7000.00, NULL, 6, 4734000.00, 4930000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKE20YV', NULL, NULL);
INSERT INTO `barang` VALUES (12, NULL, '001', 'AC', 'DAIKIN', 'STKE25YV', 'SPLIT WALL MOUNTED', 'BETA INVERTER', 1.00, 9000.00, NULL, 6, 5029987.00, 5240000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKE25YV', NULL, NULL);
INSERT INTO `barang` VALUES (13, NULL, '001', 'AC', 'DAIKIN', 'STKE35YV', 'SPLIT WALL MOUNTED', 'BETA INVERTER', 1.50, 12300.00, NULL, 6, 6148790.00, 6400000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKE35YV', NULL, NULL);
INSERT INTO `barang` VALUES (14, NULL, '001', 'AC', 'DAIKIN', 'STKE50YV', 'SPLIT WALL MOUNTED', 'BETA INVERTER', 2.00, 18000.00, NULL, 6, 8340000.00, 8410000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKE50YV', NULL, NULL);
INSERT INTO `barang` VALUES (15, NULL, '001', 'AC', 'DAIKIN', 'STKH15YV', 'SPLIT WALL MOUNTED', 'ALFA INVERTER', 0.50, 5100.00, NULL, 6, 5920000.00, 6220000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKH15YV', NULL, NULL);
INSERT INTO `barang` VALUES (16, NULL, '001', 'AC', 'DAIKIN', 'STKH50YV /IU-FTKH50YV14 /OU-RKH50YV14', 'SPLIT WALL MOUNTED', 'ALFA INVERTER', 2.00, 19000.00, NULL, 6, 10633000.00, 12170000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKH50YV', NULL, NULL);
INSERT INTO `barang` VALUES (17, NULL, '001', 'AC', 'MIDEA', 'MSFCE-05CRN2X', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2303000.00, 2400000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFCE-05CRN2X', NULL, NULL);
INSERT INTO `barang` VALUES (18, NULL, '001', 'AC', 'MIDEA', 'MSAFE-05CRN2X', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2401000.00, 2480000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSAFE-05CRN2X', NULL, NULL);
INSERT INTO `barang` VALUES (19, NULL, '001', 'AC', 'GREE', 'GWC-05N1A', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 3289000.00, 3510000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'GWC-05N1A', NULL, NULL);
INSERT INTO `barang` VALUES (20, NULL, '001', 'AC', 'GREE', 'GWC-09N1A', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9300.00, NULL, 6, 3939000.00, 4176000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'GWC-09N1A', NULL, NULL);
INSERT INTO `barang` VALUES (21, NULL, '001', 'AC', 'AQUA', 'AQA-KCR9FQDL', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2778300.00, 3180000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AQA-KCR9FQDL', NULL, NULL);
INSERT INTO `barang` VALUES (22, NULL, '001', 'AC', 'PANASONIC', 'YN18WKJ', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 6300000.00, 6600000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'YN18WKJ', NULL, NULL);
INSERT INTO `barang` VALUES (23, NULL, '001', 'AC', 'SHARP', 'AH-A5BEY', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2793000.00, 2850000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A5BEY', NULL, NULL);
INSERT INTO `barang` VALUES (24, NULL, '001', 'AC', 'SHARP', 'AH-A9BEY', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3243800.00, 3350000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A9BEY', NULL, NULL);
INSERT INTO `barang` VALUES (25, NULL, '001', 'AC', 'SHARP', 'AH-A9DEY', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3105000.00, 3225000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A9DEY', NULL, NULL);
INSERT INTO `barang` VALUES (27, NULL, '001', 'AC', 'POLYTRON', 'PAC05VZI', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2827300.00, 2920000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'PAC05VZI', NULL, NULL);
INSERT INTO `barang` VALUES (28, NULL, '001', 'AC', 'POLYTRON', 'PAC09VH', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3023300.00, 3120000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'PAC09VH', NULL, NULL);
INSERT INTO `barang` VALUES (30, NULL, '001', 'AC', 'POLYTRON', 'PAC18VH', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 6050000.00, 6240000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'PAC18VH', NULL, NULL);
INSERT INTO `barang` VALUES (31, NULL, '001', 'AC', 'TCL', 'TAC05CSD', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2597000.00, 2680000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'TAC05CSD', NULL, NULL);
INSERT INTO `barang` VALUES (32, NULL, '001', 'AC', 'TCL', 'TAC09CSD', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2744000.00, 2830000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'TAC09CSD', NULL, NULL);
INSERT INTO `barang` VALUES (33, NULL, '001', 'AC', 'TCL', 'TAC18CSD', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 5096000.00, 5250000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'TAC18CSD', NULL, NULL);
INSERT INTO `barang` VALUES (34, NULL, '001', 'AC', 'BESTLIFE', 'BEST05SUMO', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2254000.00, 2330000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'BEST05SUMO', NULL, NULL);
INSERT INTO `barang` VALUES (35, NULL, '001', 'AC', 'BESTLIFE', 'BEST09SUMO', 'SPLIT WALL MOUNTED	', 'STANDARD', 1.00, 9000.00, NULL, 6, 2750000.00, 2840000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'BEST09SUMO', NULL, NULL);
INSERT INTO `barang` VALUES (36, NULL, '001', 'AC', 'LG', 'K05NSA', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2964500.00, 3060000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'K05NSA', NULL, NULL);
INSERT INTO `barang` VALUES (37, NULL, '001', 'AC', 'LG', 'K09NSA', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3513300.00, 3620000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'H09TN4', NULL, NULL);
INSERT INTO `barang` VALUES (38, NULL, '001', 'AC', 'MIDEA', 'MSAFE-09CRN2X', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2910600.00, 2950000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSAFE-09CRN2X', NULL, NULL);
INSERT INTO `barang` VALUES (39, NULL, '001', 'AC', 'MIDEA', 'MSFCE-09CRN2X', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2910000.00, 3000000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFCE-09CRN2X', NULL, NULL);
INSERT INTO `barang` VALUES (40, NULL, '001', 'AC', 'AQUA', 'AQA-KCR5FQDL', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2538200.00, 2600000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AQA-KCR05FQDL', NULL, NULL);
INSERT INTO `barang` VALUES (41, NULL, '001', 'AC', 'PANASONIC', 'YN9AKJ', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3861200.00, 3980000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'YN9AKJ', NULL, NULL);
INSERT INTO `barang` VALUES (42, NULL, '001', 'AC', 'GREE', 'GWC-12N1A', 'SPLIT WALL MOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 5069000.00, 5329000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'GWC-12N1A', NULL, NULL);
INSERT INTO `barang` VALUES (43, NULL, '001', 'AC', 'GREE', 'GWC-18N1A', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 6919000.00, 7200000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'GWC-18N1A', NULL, NULL);
INSERT INTO `barang` VALUES (44, NULL, '001', 'AC', 'SHARP', 'AH-A18ZCY', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 6713000.00, 6600000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A18ZCY', NULL, NULL);
INSERT INTO `barang` VALUES (45, NULL, '001', 'AC', 'SHARP', 'AH-A9ZCY', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3050000.00, 3150000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A9ZCY', NULL, NULL);
INSERT INTO `barang` VALUES (46, NULL, '001', 'AC', 'DAIKIN', 'STV60CXV', 'SPLIT WALL MOUNTED', 'STANDARD', 2.50, 22000.00, NULL, 6, 9143000.00, 9300000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STV60CXV', NULL, NULL);
INSERT INTO `barang` VALUES (47, NULL, '002', 'AC', 'GREE', 'GKC-24KT', 'CASSETTE', 'STANDARD', 3.00, 25000.00, NULL, 6, 14770000.00, 14770000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'GKC-24KT', NULL, NULL);
INSERT INTO `barang` VALUES (48, NULL, '001', 'AC', 'MIDEA', 'MSFL-05CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2401000.00, 2480000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFL-05CRN8', NULL, NULL);
INSERT INTO `barang` VALUES (49, NULL, '001', 'AC', 'CHANGHONG', 'CSC-09NVB4', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2866500.00, 3210000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CSC-09NVB4', NULL, NULL);
INSERT INTO `barang` VALUES (50, NULL, '001', 'AC', 'CHANGHONG', 'CSC-05NVB4', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2450000.00, 2600000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CSC-05NVB4', NULL, NULL);
INSERT INTO `barang` VALUES (51, NULL, '001', 'AC', 'MIDEA', 'MSFQ-09CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2979200.00, 3111000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFQ-09CRN8', NULL, NULL);
INSERT INTO `barang` VALUES (52, NULL, '001', 'AC', 'SHARP', 'AH-A12ZCY', 'SPLIT WALL MOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 4434500.00, 4570000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A12ZCY', NULL, NULL);
INSERT INTO `barang` VALUES (53, NULL, '001', 'AC', 'SAMSUNG', 'AR40F05D0AMNSE', 'SPLIT WALL MOUNTED', 'INVERTER', 0.50, 5000.00, NULL, 6, 2684000.00, 2790000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AR40F05D0AMNSE', NULL, NULL);
INSERT INTO `barang` VALUES (54, NULL, '001', 'AC', 'PANASONIC', 'CU-DN05CKJ', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 3225000.00, 3330000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CU-DN05CKJ', NULL, NULL);
INSERT INTO `barang` VALUES (55, NULL, '001', 'AC', 'PANASONIC', 'CU-DN09CKJ', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3597000.00, 3710000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CU-DN09CKJ', NULL, NULL);
INSERT INTO `barang` VALUES (56, NULL, '001', 'AC', 'SHARP', 'AH-A12SAY', 'SPLIT WALL MOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 4620700.00, 4760000.00, NULL, '[]', 'AH-A12SAY', NULL, NULL);
INSERT INTO `barang` VALUES (57, NULL, '001', 'AC', 'AQUA', 'AQA-KCR18FQAL', 'SPLIT WALL MAOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 5390000.00, 5560000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AQA-KCR18FQAL', NULL, NULL);
INSERT INTO `barang` VALUES (58, NULL, '001', 'AC', 'BESTLIFE', 'BEST12QFR3', 'SPLIT WALL MAOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 3822000.00, 3900000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'BEST12QFR3', NULL, NULL);
INSERT INTO `barang` VALUES (60, NULL, '001', 'AC', 'POLYTRON', 'PAC05VH', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2699900.00, 2790000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'PAC05VH', NULL, NULL);
INSERT INTO `barang` VALUES (61, NULL, '001', 'AC', 'POLYTRON', 'PAC09VZI', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3284960.00, 3350000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'PAC09VZI', NULL, NULL);
INSERT INTO `barang` VALUES (62, NULL, '001', 'AC', 'CHANGHONG', 'CSC-05NVS4', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2631300.00, 2720000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CSC-05NVS4', NULL, NULL);
INSERT INTO `barang` VALUES (63, NULL, '001', 'AC', 'CHANGHONG', 'CSC-18NVB', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 12000.00, NULL, 6, 5250000.00, 5560000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CSC-18NVB', NULL, NULL);
INSERT INTO `barang` VALUES (64, NULL, '001', 'AC', 'LG', 'K09NVA', 'SPLIT WALL MOUNTED', 'INVERTER', 1.00, 9000.00, NULL, 6, 4250000.00, 4377000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'K09NVA', NULL, NULL);
INSERT INTO `barang` VALUES (65, NULL, '001', 'AC', 'MIDEA', 'MSFT-05CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2500000.00, 2600000.00, '[{\"kategori_id\":\"4\"}]', '[]', 'MSFT-05CRN8', NULL, NULL);
INSERT INTO `barang` VALUES (66, NULL, '001', 'AC', 'MIDEA', 'MSFT-09CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3050000.00, 3180000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFT-09CRN8', NULL, NULL);
INSERT INTO `barang` VALUES (67, NULL, '001', 'AC', 'MIDEA', 'MSFT-12CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 4332000.00, 4420000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SPLIT WALL MOUNTED	', NULL, NULL);
INSERT INTO `barang` VALUES (68, NULL, '001', 'AC', 'MIDEA', 'MSFQ-18CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 2.00, 18000.00, NULL, 6, 5785500.00, 6020000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFQ-18CRN8', NULL, NULL);
INSERT INTO `barang` VALUES (69, NULL, '001', 'AC', 'SAMSUNG', 'AR40F09D0AMNSE', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3063000.00, 3160000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AR40F09D0AMNSE', NULL, NULL);
INSERT INTO `barang` VALUES (70, NULL, '001', 'AC', 'DAIKIN', 'SVC85AV-L', 'FLOORSTANDING', 'STANDARD', 3.50, 29000.00, NULL, 6, 17361000.00, 19270710.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVC85AV', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (71, NULL, '001', 'AC', 'DAIKIN', 'SVC85AY-L', 'FLOORSTANDING', 'STANDARD', 3.50, 29000.00, NULL, 6, 18846000.00, 20919060.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVC85AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (72, NULL, '001', 'AC', 'DAIKIN', 'SVC100AY-L', 'FLOORSTANDING', 'STANDARD', 4.00, 36000.00, NULL, 6, 23571000.00, 26163810.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVC100AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (73, NULL, '001', 'AC', 'DAIKIN', 'SVC125AY-L', 'FLOORSTANDING', 'STANDARD', 5.00, 42000.00, NULL, 6, 26253000.00, 25125871.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVC125AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (74, NULL, '001', 'AC', 'DAIKIN', 'SVC140AY-L', 'FLOORSTANDING', 'STANDARD', 6.00, 48000.00, NULL, 6, 31905000.00, 35414550.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVC140AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (75, NULL, '001', 'AC', 'DAIKIN', 'SVFC71AGV-L', 'FLOORSTANDING', 'INVERTER', 3.00, 24200.00, NULL, 6, 22888800.00, 25406568.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVFC71AGV-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (76, NULL, '001', 'AC', 'DAIKIN', 'SVFC85AGV-L', 'FLOORSTANDING', 'INVERTER', 3.50, 29000.00, NULL, 6, 26159760.00, 29037334.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVFC85AGV-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (77, NULL, '001', 'AC', 'DAIKIN', 'SVFC100AGV-L', 'FLOORSTANDING', 'INVERTER', 4.00, 34100.00, NULL, 6, 28329840.00, 31446122.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVFC100AGV-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (78, NULL, '001', 'AC', 'DAIKIN', 'SVFC125AGY-L', 'FLOORSTANDING', 'INVERTER', 5.00, 42700.00, NULL, 6, 32986800.00, 36615348.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVFC125AGY-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (79, NULL, '001', 'AC', 'DAIKIN', 'SVFC140AGY-L', 'FLOORSTANDING', 'INVERTER', 6.00, 46500.00, NULL, 6, 40510800.00, 44966988.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SVFC140AGY-L', NULL, NULL);
INSERT INTO `barang` VALUES (80, NULL, '001', 'AC', 'DAIKIN', 'SDMC50AV-L', 'SPLIT DUCT', 'STANDARD', 2.00, 18500.00, NULL, 6, 11208000.00, 12440880.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC50AV-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (81, NULL, '001', 'AC', 'DAIKIN', 'SDMC60AV-L', 'SPLIT DUCT', 'STANDARD', 2.50, 23500.00, NULL, 6, 14640000.00, 16250400.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC60AV-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (82, NULL, '001', 'AC', 'DAIKIN', 'SDMC85AV-L', 'SPLIT DUCT', 'STANDARD', 3.50, 30000.00, NULL, 6, 16856000.00, 18710160.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC85AV-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (83, NULL, '001', 'AC', 'DAIKIN', 'SDMC85AY-L', 'SPLIT DUCT', 'STANDARD', 3.50, 29500.00, NULL, 6, 18176000.00, 20175360.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC85AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (84, NULL, '001', 'AC', 'DAIKIN', 'SDMC100AY-L', 'SPLIT DUCT', 'STANDARD', 4.00, 36000.00, NULL, 6, 19320000.00, 21445200.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC100AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (85, NULL, '001', 'AC', 'DAIKIN', 'SDMC125AY-L', 'SPLIT DUCT', 'STANDARD', 5.00, 42000.00, NULL, 6, 24080000.00, 26728000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC125AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (86, NULL, '001', 'AC', 'DAIKIN', 'SDMC140AY-L', 'SPLIT DUCT', 'STANDARD', 6.00, 48000.00, NULL, 6, 27440000.00, 30458000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDMC140AY-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (87, NULL, '001', 'AC', 'DAIKIN', 'SCE50AV-L', 'CASSETTE', 'STANDARD', 2.00, 18500.00, NULL, 6, 12064000.00, 13391040.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SCE50AV-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (88, NULL, '001', 'AC', 'DAIKIN', 'SCE71AV-L', 'CASSETTE', 'STANDARD', 3.00, 24000.00, NULL, 6, 15720000.00, 17449200.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SCE71AV-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (89, NULL, '001', 'AC', 'DAIKIN', 'SCE125AV-L', 'CASSETTE', 'STANDARD', 5.00, 42000.00, NULL, 6, 25568000.00, 28380480.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SCE125AV-L', NULL, 'WIRELESS');
INSERT INTO `barang` VALUES (90, NULL, '001', 'AC', 'POLYTRON', 'PAC12VH', 'SPLIT WALL MOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 4424700.00, 4560000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'PAC12VH', NULL, NULL);
INSERT INTO `barang` VALUES (91, NULL, '001', 'AC', 'DAIKIN', 'SDN80H', 'SPLIT DUCT', 'STANDARD', 8.90, 80000.00, NULL, 6, 47511090.00, 52737310.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN80H', NULL, NULL);
INSERT INTO `barang` VALUES (92, NULL, '001', 'AC', 'DAIKIN', 'SDN100H', 'SPLIT DUCT', 'STANDARD', 11.10, 100000.00, NULL, 6, 55488510.00, 61592246.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN100H', NULL, NULL);
INSERT INTO `barang` VALUES (93, NULL, '001', 'AC', 'DAIKIN', 'SDN125H', 'SPLIT DUCT', 'STANDARD', 13.90, 125000.00, NULL, 6, 69305940.00, 76929593.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN125H', NULL, NULL);
INSERT INTO `barang` VALUES (94, NULL, '001', 'AC', 'DAIKIN', 'SDN150H', 'SPLIT DUCT	', 'STANDARD', 16.70, 150000.00, NULL, 6, 79984575.00, 88782878.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN150H', NULL, NULL);
INSERT INTO `barang` VALUES (95, NULL, '001', 'AC', 'DAIKIN', 'SDN100V', 'SPLIT DUCT', 'STANDARD', 11.10, 100000.00, NULL, 6, 55488510.00, 61595546.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN100V', NULL, NULL);
INSERT INTO `barang` VALUES (96, NULL, '001', 'AC', 'DAIKIN', 'SDN125V', 'SPLIT DUCT', 'STANDARD', 13.90, 125000.00, NULL, 6, 70006000.00, 77706660.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN125V', NULL, NULL);
INSERT INTO `barang` VALUES (97, NULL, '001', 'AC', 'DAIKIN', 'SDN150V', 'SPLIT DUCT', 'STANDARD', 16.70, 150000.00, NULL, 6, 80792500.00, 89679675.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SDN150V', NULL, NULL);
INSERT INTO `barang` VALUES (98, NULL, '001', 'AC', 'DAIKIN', 'FXFQ 100 AV4', 'CEILING MOUNTED CASSETTE', 'VRV', 4.00, 38200.00, NULL, 6, 10938400.00, 24860000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'FXFQ 100 AV4', NULL, NULL);
INSERT INTO `barang` VALUES (99, NULL, '001', 'AC', 'DAIKIN', 'FXFQ 63 AV4', 'CEILING MOUNTED CASSETTE', 'VRV', 2.50, 24200.00, NULL, 6, 10432400.00, 23710000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'FXFQ 63 AV4', NULL, NULL);
INSERT INTO `barang` VALUES (100, NULL, '001', 'AC', 'DAIKIN', 'FXAQ 20 AVM4', 'WALL MOUNTED TYPE', 'VRV', 0.80, 7500.00, NULL, 6, 5918000.00, 13450000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'FXAQ 20 AVM4', NULL, NULL);
INSERT INTO `barang` VALUES (101, NULL, '001', 'AC', 'DAIKIN', 'FXAQ 32 AVM4', 'WALL MOUNTED TYPE', 'VRV', 1.30, 12300.00, NULL, 6, 6402000.00, 14550000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'FXAQ 32 AVM4', NULL, NULL);
INSERT INTO `barang` VALUES (102, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'BYCQ125EAF', 'OPTION LIST Panel', 'VRV ACCESSORIES', 0.00, 0.00, NULL, 9, 3280000.00, 4470000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'BYCQ125EAF', NULL, NULL);
INSERT INTO `barang` VALUES (103, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'BAF552A160', 'OPTION LIST  Daikin Air Filter (MERV8)', 'VRV ACCESSORIES', 0.00, 0.00, NULL, 9, 440000.00, 550000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'BAF552A160', NULL, NULL);
INSERT INTO `barang` VALUES (104, NULL, '001', 'AC', 'DAIKIN', 'RXQ 28 BY14', 'VRV 6A', 'VRV OUTDOOR UNIT', 28.00, 268000.00, NULL, 6, 150466800.00, 341970000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'RXQ 8 BY14', NULL, NULL);
INSERT INTO `barang` VALUES (105, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'BRC1E63', 'Wired remote controller', 'VRV ACCESSORIES', 0.00, 0.00, NULL, 9, 696000.00, 696000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'BRC1E63', NULL, NULL);
INSERT INTO `barang` VALUES (106, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'KHRP26A22T7', 'REFNET JOINT & HEADER', 'VRV ACCESSORIES', 0.00, 0.00, NULL, 9, 448000.00, 560000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'KHRP26A22T7', NULL, NULL);
INSERT INTO `barang` VALUES (107, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'KHRP26A33T7', 'REFNET JOINT & HEADER', 'VRV ACCESSORIES', 0.00, 0.00, NULL, 9, 472000.00, 590000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'KHRP26A33T7', NULL, NULL);
INSERT INTO `barang` VALUES (108, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'KHRP26A72T7', 'REFNET JOINT & HEADER', 'VRV ACCESSORIES	', 0.00, 0.00, NULL, 9, 744000.00, 930000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'KHRP26A72T7', NULL, NULL);
INSERT INTO `barang` VALUES (109, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'KHRP26A73T7', 'REFNET JOINT & HEADER', 'VRV ACCESSORIES', 0.00, 0.00, NULL, 9, 1240000.00, 1550000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'KHRP26A73T7', NULL, NULL);
INSERT INTO `barang` VALUES (110, NULL, '001', 'ACCESSORIES', 'DAIKIN', 'KHRP26M73TP7', 'REFNET JOINT & HEADER', 'VRV ACCESSORIES	', 0.00, 0.00, NULL, 9, 496000.00, 620000.00, '[{\"kategori_id\":\"5\"}]', '[]', 'KHRP26M73TP7', NULL, NULL);
INSERT INTO `barang` VALUES (111, NULL, '001', 'AC', 'MIDEA', 'MSFQ-05CRN8', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2600000.00, 2710000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSFQ-05CRN8', NULL, NULL);
INSERT INTO `barang` VALUES (112, NULL, '001', 'AC ', 'GREE', 'GPC-05P2', 'PORTABLE', 'STANDARD', 0.50, 5100.00, NULL, 6, 3769000.00, 3693620.00, '[{\"kategori_id\":\"1\"}]', '[]', 'GPC-05P2', NULL, NULL);
INSERT INTO `barang` VALUES (114, NULL, '001', 'AC', 'DAIKIN', 'STKH25YV', 'SPLIT WALL MOUNTED', 'ALFA INVERTER', 1.00, 9000.00, NULL, 6, 6426000.00, 6400000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKH25YV', NULL, NULL);
INSERT INTO `barang` VALUES (115, NULL, '001', 'AC', 'BESTLIFE', 'BEST05DSC ', 'SPLIT WALL MOUNTED', 'STANDARD', 0.50, 5000.00, NULL, 6, 2425000.00, 2500000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'BEST05DSC ', NULL, NULL);
INSERT INTO `barang` VALUES (116, NULL, '001', 'AC', 'BESTLIFE', 'BEST09LCN', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 2775000.00, 2860000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'BEST09LCN', NULL, NULL);
INSERT INTO `barang` VALUES (117, NULL, '002', 'AIR CURTAIN', 'GREE', 'FM-1.25-12-K', 'WALL MOUNTED', 'AIR CURTAIN', 0.00, 0.00, NULL, 6, 3029000.00, 3500000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'FM-1.25-12-K', NULL, NULL);
INSERT INTO `barang` VALUES (118, NULL, '001', 'AC', 'SHARP', 'AH-A9CAY', 'SPLIT WALL MOUNTED', 'STANDARD', 1.00, 9000.00, NULL, 6, 3038000.00, 3130000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AH-A9CAY', NULL, NULL);
INSERT INTO `barang` VALUES (119, NULL, '001', 'AC', 'MIDEA', 'MSAFE-12CRN2X', 'SPLIT WALL MOUNTED', 'STANDARD', 1.50, 12000.00, NULL, 6, 4194400.00, 4510000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'MSAFE-12CRN2X', NULL, NULL);
INSERT INTO `barang` VALUES (120, NULL, '001', 'AC', 'SAMSUNG', 'AR40F18D0AMNSE', 'SPLIT WALL MOUNTED', 'INVERTER', 2.00, NULL, NULL, 6, 6209000.00, 6333180.00, '[{\"kategori_id\":\"1\"}]', '[]', 'AR40F18D0AMNSE', NULL, NULL);
INSERT INTO `barang` VALUES (121, NULL, '001', 'AC', 'DAIKIN', 'CTKM25RVM4', 'WALL MOUNTED INDOOR UNIT', 'MULTI-NX', 2.50, 0.00, NULL, 6, 3519255.00, 3730000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'CTKM25RVM4', NULL, NULL);
INSERT INTO `barang` VALUES (122, NULL, '001', 'AC', 'DAIKIN', '4MKM68RVM4', 'OUTDOOR UNIT', 'MULTI-NX', 6.80, 0.00, NULL, 6, 19417230.00, 20580000.00, '[{\"kategori_id\":\"1\"}]', '[]', '4MKM68RVM4', NULL, NULL);
INSERT INTO `barang` VALUES (123, NULL, '001', 'AC', 'DAIKIN', 'STKH60YV', 'SPLIT WALL MOUNTED', 'ALFA INVERTER', 2.50, 22500.00, NULL, 6, 13068419.00, 14580000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'STKH60YV', NULL, NULL);
INSERT INTO `barang` VALUES (124, NULL, '001', 'AC', 'DAIKIN', 'SCFC125DY-R', 'CASSETTE', 'INVERTER', 5.00, 42700.00, NULL, 6, 38619742.00, 43930000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SCFC125DY-R', NULL, NULL);
INSERT INTO `barang` VALUES (125, NULL, '002', 'AIR PURIFIER', 'DAIKIN', 'MCQ30ZVM7-H', NULL, NULL, 0.00, 0.00, NULL, 6, 1519035.00, 1610000.00, '[{\"kategori_id\":\"6\"}]', '[]', 'MCQ30ZVM7-H', NULL, NULL);
INSERT INTO `barang` VALUES (126, NULL, '002', 'AIR PURIFIER', 'DAIKIN', 'MC55UVM6-7', NULL, NULL, 0.00, 0.00, NULL, 6, 3670215.00, 3890000.00, '[{\"kategori_id\":\"6\"}]', '[]', 'MC55UVM6-7', NULL, NULL);
INSERT INTO `barang` VALUES (127, NULL, '001', 'AC', 'DAIKIN', 'SCFE125DY-L', 'CASSETTE', 'INVERTER', 5.00, 42000.00, NULL, 6, 36115000.00, 36566000.00, '[{\"kategori_id\":\"1\"}]', '[]', 'SCFCE125DY-L', NULL, NULL);
INSERT INTO `barang` VALUES (128, NULL, 'SP1', 'Kabel', 'CMY', NULL, NULL, NULL, NULL, NULL, 1.00, 2, NULL, 10000.00, '[{\"kategori_id\":\"2\"}]', '[]', 'Meter', NULL, NULL);

-- ----------------------------
-- Table structure for barang_masuk
-- ----------------------------
DROP TABLE IF EXISTS `barang_masuk`;
CREATE TABLE `barang_masuk`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `tanggal` date NULL DEFAULT NULL,
  `gudang_id` bigint NULL DEFAULT NULL,
  `sumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of barang_masuk
-- ----------------------------
INSERT INTO `barang_masuk` VALUES (1, '2026-11-24', 1, 'Pembelian', '[{\"id\":1,\"barang_masuk_id\":1,\"pembelian_detail_id\":1,\"rak_id\":1,\"jumlah\":10,\"terjual\":null,\"dikirim\":null,\"mutasi\":null,\"retur\":null,\"rusak\":null,\"hilang\":null}]', '2026-11-24 02:08:10', 'sebastian', NULL, NULL);
INSERT INTO `barang_masuk` VALUES (2, '2026-11-24', 1, 'Pembelian', '[{\"id\":2,\"barang_masuk_id\":2,\"pembelian_detail_id\":2,\"rak_id\":1,\"jumlah\":1,\"terjual\":1,\"dikirim\":1,\"mutasi\":null,\"retur\":null,\"rusak\":null,\"hilang\":null},{\"id\":3,\"barang_masuk_id\":2,\"pembelian_detail_id\":2,\"rak_id\":2,\"jumlah\":9,\"terjual\":null,\"dikirim\":null,\"mutasi\":null,\"retur\":null,\"rusak\":null,\"hilang\":null}]', '2026-11-24 02:14:38', 'sebastian', NULL, NULL);

-- ----------------------------
-- Table structure for barang_masuk_detail
-- ----------------------------
DROP TABLE IF EXISTS `barang_masuk_detail`;
CREATE TABLE `barang_masuk_detail`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `barang_masuk_id` bigint NULL DEFAULT NULL,
  `pembelian_detail_id` bigint NULL DEFAULT NULL,
  `rak_id` bigint NULL DEFAULT NULL,
  `jumlah` decimal(20, 2) NULL DEFAULT NULL,
  `terjual` decimal(20, 2) NULL DEFAULT NULL,
  `dikirim` decimal(20, 2) NULL DEFAULT NULL,
  `mutasi` decimal(20, 2) NULL DEFAULT NULL,
  `retur` decimal(20, 2) NULL DEFAULT NULL,
  `rusak` decimal(20, 2) NULL DEFAULT NULL,
  `hilang` decimal(20, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of barang_masuk_detail
-- ----------------------------
INSERT INTO `barang_masuk_detail` VALUES (1, 1, 1, 1, 10.00, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `barang_masuk_detail` VALUES (2, 2, 2, 1, 1.00, 1.00, 1.00, NULL, NULL, NULL, NULL);
INSERT INTO `barang_masuk_detail` VALUES (3, 2, 2, 2, 9.00, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for cabang
-- ----------------------------
DROP TABLE IF EXISTS `cabang`;
CREATE TABLE `cabang`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `kabupaten_kota` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `no_wa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cabang
-- ----------------------------
INSERT INTO `cabang` VALUES (1, 'Medan', 'Jl. Suka Cerdas IV. 3 B STM Ujung, Suka Maju, Kec. Medan Johor', 'Medan', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for catatan_penawaran
-- ----------------------------
DROP TABLE IF EXISTS `catatan_penawaran`;
CREATE TABLE `catatan_penawaran`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `catatan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of catatan_penawaran
-- ----------------------------
INSERT INTO `catatan_penawaran` VALUES (1, 'Berlaku 14 Hari', '[\"Penawaran berlaku 14 hari\",\"Hal-hal diluar penawaran akan dikenakan biaya tambahan\"]');

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `jenis_customer_id` bigint NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `no_wa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `credit_limit` decimal(20, 2) NULL DEFAULT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jumlah_transaksi` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES (1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp\":\"08127127123\"}]', '[{\"no_wa\":\"08127127123\"}]', NULL, 7.00, NULL, 1);

-- ----------------------------
-- Table structure for gudang
-- ----------------------------
DROP TABLE IF EXISTS `gudang`;
CREATE TABLE `gudang`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gudang
-- ----------------------------
INSERT INTO `gudang` VALUES (1, 1, 'Medan Johor', 'Jl. Suka Cerdas IV. 3 B STM Ujung, Suka Maju, Kec. Medan Johor, Kota Medan, Sumatera Utara 20147', NULL);

-- ----------------------------
-- Table structure for hari_libur
-- ----------------------------
DROP TABLE IF EXISTS `hari_libur`;
CREATE TABLE `hari_libur`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint NULL DEFAULT NULL,
  `dari_tanggal` date NULL DEFAULT NULL,
  `sampai_tanggal` date NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of hari_libur
-- ----------------------------

-- ----------------------------
-- Table structure for izin
-- ----------------------------
DROP TABLE IF EXISTS `izin`;
CREATE TABLE `izin`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint NULL DEFAULT NULL,
  `karyawan_id` bigint NULL DEFAULT NULL,
  `dari_tanggal` date NULL DEFAULT NULL,
  `sampai_tanggal` date NULL DEFAULT NULL,
  `jenis_izin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of izin
-- ----------------------------

-- ----------------------------
-- Table structure for jabatan
-- ----------------------------
DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE `jabatan`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of jabatan
-- ----------------------------
INSERT INTO `jabatan` VALUES (1, 'Admin');
INSERT INTO `jabatan` VALUES (2, 'Sales');
INSERT INTO `jabatan` VALUES (3, 'MANAGER');

-- ----------------------------
-- Table structure for jam_kerja
-- ----------------------------
DROP TABLE IF EXISTS `jam_kerja`;
CREATE TABLE `jam_kerja`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `jam_kerja` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of jam_kerja
-- ----------------------------
INSERT INTO `jam_kerja` VALUES (1, '08 Pagi');

-- ----------------------------
-- Table structure for jasa
-- ----------------------------
DROP TABLE IF EXISTS `jasa`;
CREATE TABLE `jasa`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `jasa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga` decimal(20, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jasa
-- ----------------------------
INSERT INTO `jasa` VALUES (1, 'PAKET A PEMASANGAN AC PIPA RIIFO 3 METER  (1/2-1PK)', 620000.00);
INSERT INTO `jasa` VALUES (2, 'PAKET B PEMASANGAN AC PIPA RIIFO 3 METER (1/2-1PK)', 580000.00);
INSERT INTO `jasa` VALUES (3, 'PAKET A PEMASANGAN AC PIPA RIIFO 3 METER (1,5-2PK)', 800000.00);
INSERT INTO `jasa` VALUES (4, 'PAKET B PEMASANGAN AC PIPA RIIFO 3 METER (1,5-2PK)', 740000.00);
INSERT INTO `jasa` VALUES (5, 'PAKET A PEMASANGAN AC PIPA RIIFO 2 METER (1/2-1PK)', 550000.00);
INSERT INTO `jasa` VALUES (6, 'PAKET B PEMASANGAN AC PIPA RIIFO 2 METER (1/2-1PK)', 510000.00);
INSERT INTO `jasa` VALUES (7, 'PAKET A PEMASANGAN AC PIPA RIIFO 2 METER (1,5-2PK)', 710000.00);
INSERT INTO `jasa` VALUES (8, 'PAKET B PEMASANGAN AC PIPA RIIFO 2 METER (1,5-2PK)', 660000.00);
INSERT INTO `jasa` VALUES (9, 'PAKET A PEMASANGAN AC PIPA AUB 3 METER (1/2-1PK)', 710000.00);
INSERT INTO `jasa` VALUES (10, 'PAKET B PEMASANGAN AC PIPA AUB 3 METER (1/2-1PK)', 650000.00);
INSERT INTO `jasa` VALUES (11, 'PAKET A PEMASANGAN AC PIPA AUB 3 METER (1,5-2PK)', 930000.00);
INSERT INTO `jasa` VALUES (12, 'PAKET B PEMASANGAN AC PIPA AUB 3 METER (1,5-2PK)', 850000.00);
INSERT INTO `jasa` VALUES (13, 'PAKET A PEMASANGAN AC PIPA AUB 2 METER (1/2-1PK)', 570000.00);
INSERT INTO `jasa` VALUES (14, 'PAKET B PEMASANGAN AC PIPA AUB 2 METER (1/2-1PK)', 530000.00);
INSERT INTO `jasa` VALUES (15, 'PAKET A PEMASANGAN AC PIPA AUB 2 METER (1,5-2PK)', 750000.00);
INSERT INTO `jasa` VALUES (16, 'PAKET B PEMASANGAN AC PIPA AUB 2 METER (1,5-2PK)', 700000.00);

-- ----------------------------
-- Table structure for jenis_customer
-- ----------------------------
DROP TABLE IF EXISTS `jenis_customer`;
CREATE TABLE `jenis_customer`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `jenis_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of jenis_customer
-- ----------------------------
INSERT INTO `jenis_customer` VALUES (1, 'Personal');
INSERT INTO `jenis_customer` VALUES (2, 'Perusahaan');
INSERT INTO `jenis_customer` VALUES (4, 'Lembaga  Pemerintahan');
INSERT INTO `jenis_customer` VALUES (5, 'Lembaga Swasta');

-- ----------------------------
-- Table structure for jenis_supplier
-- ----------------------------
DROP TABLE IF EXISTS `jenis_supplier`;
CREATE TABLE `jenis_supplier`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `jenis_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of jenis_supplier
-- ----------------------------
INSERT INTO `jenis_supplier` VALUES (1, 'Pabrik');
INSERT INTO `jenis_supplier` VALUES (2, 'Distributor');
INSERT INTO `jenis_supplier` VALUES (3, 'Toko');
INSERT INTO `jenis_supplier` VALUES (4, 'Personal');
INSERT INTO `jenis_supplier` VALUES (6, 'Principal');

-- ----------------------------
-- Table structure for karyawan
-- ----------------------------
DROP TABLE IF EXISTS `karyawan`;
CREATE TABLE `karyawan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint NULL DEFAULT NULL,
  `nik` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `nama` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT '',
  `jabatan_id` int NULL DEFAULT NULL,
  `no_hp` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `gaji_per_bulan` decimal(20, 2) NULL DEFAULT NULL,
  `gaji_per_hari` decimal(20, 2) NULL DEFAULT NULL,
  `persenan_insentif` decimal(10, 2) NULL DEFAULT NULL,
  `ss_insentif_akumulatif_id` bigint NULL DEFAULT NULL,
  `uang_makan_per_hari` decimal(20, 2) NULL DEFAULT NULL,
  `uang_makan_lembur_per_hari` decimal(20, 2) NULL DEFAULT NULL,
  `uang_pulsa_per_bulan` decimal(20, 2) NULL DEFAULT NULL,
  `uang_lembur_per_jam` decimal(20, 2) NULL DEFAULT NULL,
  `uang_servis_kendaraan_per_bulan` decimal(20, 2) NULL DEFAULT NULL,
  `tunjangan_harian` decimal(20, 2) NULL DEFAULT NULL,
  `tunjangan_jabatan_per_bulan` decimal(20, 2) NULL DEFAULT NULL,
  `tunjangan_kesehatan_per_bulan` decimal(20, 2) NULL DEFAULT NULL,
  `tunjangan_transportasi_per_bulan` decimal(20, 2) NULL DEFAULT NULL,
  `potongan_per_tidak_masuk` decimal(20, 2) NULL DEFAULT NULL,
  `potongan_per_izin_cuti` decimal(20, 2) NULL DEFAULT NULL,
  `potongan_per_terlambat_masuk` decimal(20, 2) NULL DEFAULT NULL,
  `potongan_per_pulang_sebelum_waktunya` decimal(20, 2) NULL DEFAULT NULL,
  `potongan_per_tidak_absen_masuk` decimal(20, 2) NULL DEFAULT NULL,
  `potongan_per_tidak_absen_pulang` decimal(20, 2) NULL DEFAULT NULL,
  `tanggal_masuk` date NULL DEFAULT NULL,
  `tanggal_gajian_tiap_bulan` int NULL DEFAULT NULL,
  `terakhir_gajian` date NULL DEFAULT NULL,
  `status_aktif` int NULL DEFAULT 1,
  `file_foto` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `utang` int NULL DEFAULT 0,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `last_login` datetime NULL DEFAULT NULL,
  `jam_kerja_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of karyawan
-- ----------------------------
INSERT INTO `karyawan` VALUES (1, 1, '001', 'Dedi Wijaya', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for kata_pengantar
-- ----------------------------
DROP TABLE IF EXISTS `kata_pengantar`;
CREATE TABLE `kata_pengantar`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `tipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kata_pengantar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kata_pengantar
-- ----------------------------
INSERT INTO `kata_pengantar` VALUES (2, 'Surat Penawaran', '<p>Dengan hormat,<br />\nSehubungan dengan permintaan penawaran harga pemasangan AC, maka dengan ini kami <strong>PT. FREN COOL GROUP</strong> bermaksud untuk mengajukan penawaran, adapun rincian jasa dan materialnya sebagai berikut :</p>\n');

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (1, 'Unit AC');
INSERT INTO `kategori` VALUES (2, 'Sparepart AC');
INSERT INTO `kategori` VALUES (4, 'Material AC');
INSERT INTO `kategori` VALUES (5, 'Accessories AC');
INSERT INTO `kategori` VALUES (6, 'Air Purifier ');

-- ----------------------------
-- Table structure for log_barang_masuk
-- ----------------------------
DROP TABLE IF EXISTS `log_barang_masuk`;
CREATE TABLE `log_barang_masuk`  (
  `id` bigint NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `gudang_id` bigint NULL DEFAULT NULL,
  `sumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `deleted_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_urut` int NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of log_barang_masuk
-- ----------------------------
INSERT INTO `log_barang_masuk` VALUES (1, '2026-11-24', 1, 'Pembelian', '[{\"id\":1,\"barang_masuk_id\":1,\"pembelian_detail_id\":1,\"rak_id\":1,\"jumlah\":10,\"terjual\":null,\"dikirim\":null,\"mutasi\":null,\"retur\":null,\"rusak\":null,\"hilang\":null}]', '2026-11-24 02:08:10', 'sebastian', NULL, NULL, NULL, NULL, 1);
INSERT INTO `log_barang_masuk` VALUES (2, '2026-11-24', 1, 'Pembelian', '[{\"id\":2,\"barang_masuk_id\":2,\"pembelian_detail_id\":2,\"rak_id\":1,\"jumlah\":5,\"terjual\":null,\"dikirim\":null,\"mutasi\":null,\"retur\":null,\"rusak\":null,\"hilang\":null},{\"id\":3,\"barang_masuk_id\":2,\"pembelian_detail_id\":2,\"rak_id\":2,\"jumlah\":5,\"terjual\":null,\"dikirim\":null,\"mutasi\":null,\"retur\":null,\"rusak\":null,\"hilang\":null}]', '2026-11-24 02:14:38', 'sebastian', NULL, NULL, NULL, NULL, 1);

-- ----------------------------
-- Table structure for log_pembelian
-- ----------------------------
DROP TABLE IF EXISTS `log_pembelian`;
CREATE TABLE `log_pembelian`  (
  `id` bigint NULL DEFAULT NULL,
  `cabang_id` bigint NULL DEFAULT NULL,
  `kode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor` int NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `tanda_tangan_id` bigint NULL DEFAULT NULL,
  `supplier_id` bigint NULL DEFAULT NULL,
  `nama_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_wa_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `sub_total` decimal(20, 2) NULL DEFAULT NULL,
  `persen_diskon` decimal(20, 2) NULL DEFAULT NULL,
  `diskon` decimal(20, 2) NULL DEFAULT NULL,
  `dpp` decimal(20, 2) NULL DEFAULT NULL,
  `persen_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `ppn` decimal(20, 2) NULL DEFAULT NULL,
  `total` decimal(20, 2) NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `deleted_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_urut` int NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of log_pembelian
-- ----------------------------
INSERT INTO `log_pembelian` VALUES (1, 1, 'PO', 1, 2026, '2026-11-24', 2, 1, 'Sebarga', 'Jl. AH. Nasution No. 17', '[{\"no_telp_supplier\":\"08122281231\"}]', '[{\"no_wa_supplier\":\"08122281231\"}]', NULL, '[{\"id\":1,\"pembelian_id\":1,\"barang_id\":4,\"harga\":3000000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":3000000,\"jumlah\":10,\"sub_total\":30000000,\"sub_total_sebelum_ppn\":30000000,\"diskon_item\":0,\"diskon_item_detail\":null,\"diskon_faktur\":0,\"dpp\":30000000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":30000000,\"masuk_gudang\":null,\"retur\":null}]', 30000000.00, NULL, NULL, 30000000.00, NULL, 0.00, 30000000.00, '2026-11-24 02:07:38', 'sebastian', NULL, NULL, NULL, NULL, 1);
INSERT INTO `log_pembelian` VALUES (2, 1, 'PO', 2, 2026, '2026-11-24', 2, 1, 'Sebarga', 'Jl. AH. Nasution No. 17', '[{\"no_telp_supplier\":\"08122281231\"}]', '[{\"no_wa_supplier\":\"08122281231\"}]', NULL, '[{\"id\":2,\"pembelian_id\":2,\"barang_id\":6,\"harga\":3500000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":3500000,\"jumlah\":10,\"sub_total\":35000000,\"sub_total_sebelum_ppn\":35000000,\"diskon_item\":0,\"diskon_item_detail\":null,\"diskon_faktur\":0,\"dpp\":35000000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":35000000,\"masuk_gudang\":null,\"retur\":null}]', 35000000.00, NULL, NULL, 35000000.00, NULL, 0.00, 35000000.00, '2026-11-24 02:12:33', 'sebastian', NULL, NULL, NULL, NULL, 1);

-- ----------------------------
-- Table structure for log_penawaran
-- ----------------------------
DROP TABLE IF EXISTS `log_penawaran`;
CREATE TABLE `log_penawaran`  (
  `id` bigint NULL DEFAULT NULL,
  `cabang_id` bigint NULL DEFAULT NULL,
  `kode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor` int NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `kata_pengantar_id` bigint NULL DEFAULT NULL,
  `catatan_penawaran_id` bigint NULL DEFAULT NULL,
  `tanda_tangan_id` bigint NULL DEFAULT NULL,
  `batas_waktu` int NULL DEFAULT NULL,
  `karyawan_id` bigint NULL DEFAULT NULL,
  `customer_id` bigint NULL DEFAULT NULL,
  `nama_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_wa_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `credit_limit_customer` decimal(20, 2) NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `jumlah` decimal(20, 2) NULL DEFAULT NULL,
  `jumlah_pesanan` decimal(20, 2) NULL DEFAULT NULL,
  `sub_total` decimal(20, 2) NULL DEFAULT NULL,
  `persen_diskon` decimal(20, 2) NULL DEFAULT NULL,
  `diskon` decimal(20, 2) NULL DEFAULT NULL,
  `dpp` decimal(20, 2) NULL DEFAULT NULL,
  `persen_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `ppn` decimal(20, 2) NULL DEFAULT NULL,
  `total` decimal(20, 2) NULL DEFAULT NULL,
  `approved_at` datetime NULL DEFAULT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approved_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rejected_at` datetime NULL DEFAULT NULL,
  `rejected_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `deleted_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_urut` int NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of log_penawaran
-- ----------------------------
INSERT INTO `log_penawaran` VALUES (1, 1, '02', 1, 2026, '2026-11-23', 2, 1, 2, 7, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":1,\"penawaran_id\":1,\"barang_id\":4,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC15YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 0,5 PK (5.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":3840000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":3840000,\"jumlah\":1,\"jumlah_pesanan\":null,\"sub_total\":3840000,\"sub_total_sebelum_ppn\":3840000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":3840000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":3840000,\"approved_at\":\"2026-11-23 21:04:44\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"retur\":null}]', 1.00, NULL, 3840000.00, NULL, NULL, 3840000.00, NULL, 0.00, 3840000.00, '2026-11-23 21:04:44', 'sebastian', 'auto', NULL, NULL, '2026-11-23 21:04:44', 'sebastian', NULL, NULL, NULL, NULL, 1);
INSERT INTO `log_penawaran` VALUES (2, 1, '02', 2, 2026, '2026-11-24', 2, 1, 2, 8, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":2,\"penawaran_id\":2,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"jumlah_pesanan\":null,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":4570000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4570000,\"approved_at\":\"2026-11-24 02:17:17\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"retur\":null}]', 1.00, NULL, 4570000.00, NULL, NULL, 4570000.00, NULL, 0.00, 4570000.00, '2026-11-24 02:17:17', 'sebastian', 'auto', NULL, NULL, '2026-11-24 02:17:17', 'sebastian', NULL, NULL, NULL, NULL, 1);
INSERT INTO `log_penawaran` VALUES (2, 1, '02', 2, 2026, '2026-11-24', 2, 1, 2, 8, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":2,\"penawaran_id\":2,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"jumlah_pesanan\":null,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":457000,\"dpp\":4113000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4113000,\"approved_at\":null,\"approved_by\":null,\"approved_type\":null,\"rejected_at\":null,\"rejected_by\":null,\"retur\":null}]', 1.00, NULL, 4570000.00, 10.00, 457000.00, 4113000.00, NULL, 0.00, 4113000.00, NULL, NULL, 'auto', NULL, NULL, '2026-11-24 02:17:17', 'sebastian', '2026-11-24 02:19:11', 'sebastian', NULL, NULL, 2);

-- ----------------------------
-- Table structure for log_penjualan
-- ----------------------------
DROP TABLE IF EXISTS `log_penjualan`;
CREATE TABLE `log_penjualan`  (
  `id` bigint NULL DEFAULT NULL,
  `cabang_id` bigint NULL DEFAULT NULL,
  `kode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor` int NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `pesanan_id` bigint NULL DEFAULT NULL,
  `karyawan_id` bigint NULL DEFAULT NULL,
  `batas_waktu_pembayaran` int NULL DEFAULT NULL,
  `tanda_tangan_id` bigint NULL DEFAULT NULL,
  `customer_id` bigint NULL DEFAULT NULL,
  `nama_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_wa_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `credit_limit_customer` decimal(20, 2) NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `sub_total` decimal(20, 2) NULL DEFAULT NULL,
  `persen_diskon` decimal(20, 2) NULL DEFAULT NULL,
  `diskon` decimal(20, 2) NULL DEFAULT NULL,
  `dpp` decimal(20, 2) NULL DEFAULT NULL,
  `persen_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `ppn` decimal(20, 2) NULL DEFAULT NULL,
  `total` decimal(20, 2) NULL DEFAULT NULL,
  `bank_id` bigint NULL DEFAULT NULL,
  `termin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `dibayar` decimal(20, 2) NULL DEFAULT NULL,
  `pembayaran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `approved_at` datetime NULL DEFAULT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approved_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rejected_at` datetime NULL DEFAULT NULL,
  `rejected_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `deleted_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_urut` int NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of log_penjualan
-- ----------------------------
INSERT INTO `log_penjualan` VALUES (1, 1, 'INV', 1, 2026, '2026-11-23', NULL, 1, NULL, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":1,\"penjualan_id\":1,\"pesanan_detail_id\":null,\"barang_id\":4,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC15YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 0,5 PK (5.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":3840000,\"jenis_ppn\":\"Non PPN\",\"harga_sebelum_ppn\":3840000,\"jumlah\":1,\"sub_total\":3840000,\"sub_total_sebelum_ppn\":3840000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":0,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":3840000,\"approved_at\":\"2026-11-23 12:49:49\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"jumlah_ditandai\":0,\"jumlah_dikirim\":null,\"ditandai\":[],\"jumlah_retur\":null}]', 3840000.00, NULL, NULL, 0.00, NULL, 0.00, 3840000.00, 1, '[]', 3840000.00, NULL, '2026-11-23 12:49:49', 'sebastian', 'auto', NULL, NULL, '2026-11-23 12:49:49', 'sebastian', NULL, NULL, NULL, NULL, 1);
INSERT INTO `log_penjualan` VALUES (2, 1, 'INV', 1, 2026, '2026-11-24', NULL, 1, NULL, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":2,\"penjualan_id\":2,\"pesanan_detail_id\":2,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":457000,\"dpp\":4113000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4113000,\"approved_at\":\"2026-11-24 02:23:43\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"jumlah_ditandai\":0,\"jumlah_dikirim\":null,\"ditandai\":[],\"jumlah_retur\":null}]', 4570000.00, 10.00, 457000.00, 4113000.00, NULL, 0.00, 4113000.00, 1, '[]', 4113000.00, NULL, '2026-11-24 02:23:43', 'sebastian', 'auto', NULL, NULL, '2026-11-24 02:23:43', 'sebastian', NULL, NULL, NULL, NULL, 1);
INSERT INTO `log_penjualan` VALUES (2, 1, 'INV', 1, 2026, '2026-11-24', NULL, 1, NULL, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":3,\"penjualan_id\":2,\"pesanan_detail_id\":null,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Non PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":0,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4570000,\"approved_at\":null,\"approved_by\":null,\"approved_type\":null,\"rejected_at\":null,\"rejected_by\":null,\"jumlah_ditandai\":0,\"jumlah_dikirim\":null,\"ditandai\":[],\"jumlah_retur\":null}]', 4570000.00, NULL, NULL, 0.00, NULL, 0.00, 4570000.00, 2, '[{\"id\":1,\"penjualan_id\":2,\"tanggal\":\"2026-12-01\",\"nominal\":1000000,\"dibayar\":null},{\"id\":2,\"penjualan_id\":2,\"tanggal\":\"2026-12-09\",\"nominal\":1000000,\"dibayar\":null},{\"id\":3,\"penjualan_id\":2,\"tanggal\":\"2026-12-16\",\"nominal\":1570000,\"dibayar\":null}]', 4113000.00, NULL, '2026-11-24 02:25:26', 'sebastian', 'auto', NULL, NULL, '2026-11-24 02:23:43', 'sebastian', '2026-11-24 02:25:26', 'sebastian', NULL, NULL, 2);
INSERT INTO `log_penjualan` VALUES (1, 1, 'INV', 1, 2026, '2026-11-23', NULL, 1, NULL, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":1,\"penjualan_id\":1,\"pesanan_detail_id\":null,\"barang_id\":4,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC15YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 0,5 PK (5.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":3840000,\"jenis_ppn\":\"Non PPN\",\"harga_sebelum_ppn\":3840000,\"jumlah\":1,\"sub_total\":3840000,\"sub_total_sebelum_ppn\":3840000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":0,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":3840000,\"approved_at\":\"2026-11-23 12:49:49\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"jumlah_ditandai\":0,\"jumlah_dikirim\":null,\"ditandai\":[],\"jumlah_retur\":null}]', 3840000.00, NULL, NULL, 0.00, NULL, 0.00, 3840000.00, 1, '[]', NULL, '[]', '2026-11-23 12:49:49', 'sebastian', 'auto', NULL, NULL, '2026-11-23 12:49:49', 'sebastian', NULL, NULL, '2026-11-24 02:25:52', 'sebastian', 2);
INSERT INTO `log_penjualan` VALUES (2, 1, 'INV', 1, 2026, '2026-11-24', NULL, 1, NULL, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":3,\"penjualan_id\":2,\"pesanan_detail_id\":null,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Non PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":0,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4570000,\"approved_at\":null,\"approved_by\":null,\"approved_type\":null,\"rejected_at\":null,\"rejected_by\":null,\"jumlah_ditandai\":0,\"jumlah_dikirim\":null,\"ditandai\":[],\"jumlah_retur\":null}]', 4570000.00, NULL, NULL, 0.00, NULL, 0.00, 4570000.00, 2, '[{\"id\":1,\"penjualan_id\":2,\"tanggal\":\"2026-12-01\",\"nominal\":1000000,\"dibayar\":null},{\"id\":2,\"penjualan_id\":2,\"tanggal\":\"2026-12-09\",\"nominal\":1000000,\"dibayar\":null},{\"id\":3,\"penjualan_id\":2,\"tanggal\":\"2026-12-16\",\"nominal\":1570000,\"dibayar\":null}]', NULL, '[]', '2026-11-24 02:25:26', 'sebastian', 'auto', NULL, NULL, '2026-11-24 02:23:43', 'sebastian', '2026-11-24 02:25:26', 'sebastian', '2026-11-24 02:25:55', 'sebastian', 3);
INSERT INTO `log_penjualan` VALUES (3, 1, 'INV', 1, 2026, '2026-11-24', NULL, 1, NULL, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":4,\"penjualan_id\":3,\"pesanan_detail_id\":null,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Non PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":0,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4570000,\"approved_at\":\"2026-11-24 02:26:22\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"jumlah_ditandai\":0,\"jumlah_dikirim\":null,\"ditandai\":[],\"jumlah_retur\":null}]', 4570000.00, NULL, NULL, 0.00, NULL, 0.00, 4570000.00, 1, '[{\"id\":4,\"penjualan_id\":3,\"tanggal\":\"2026-12-01\",\"nominal\":1000000,\"dibayar\":null},{\"id\":5,\"penjualan_id\":3,\"tanggal\":\"2026-12-09\",\"nominal\":1000000,\"dibayar\":null},{\"id\":6,\"penjualan_id\":3,\"tanggal\":\"2026-12-16\",\"nominal\":1570000,\"dibayar\":null}]', NULL, NULL, '2026-11-24 02:26:22', 'sebastian', 'auto', NULL, NULL, '2026-11-24 02:26:22', 'sebastian', NULL, NULL, NULL, NULL, 1);
INSERT INTO `log_penjualan` VALUES (3, 1, 'INV', 1, 2026, '2026-11-24', NULL, 1, NULL, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":4,\"penjualan_id\":3,\"pesanan_detail_id\":null,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Non PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":0,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4570000,\"approved_at\":\"2026-11-24 02:26:22\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"jumlah_ditandai\":1,\"jumlah_dikirim\":null,\"ditandai\":[{\"id\":1,\"penjualan_detail_id\":4,\"barang_masuk_detail_id\":2,\"jumlah\":1,\"dikirim\":null}],\"jumlah_retur\":null}]', 4570000.00, NULL, NULL, 0.00, NULL, 0.00, 4570000.00, 1, '[{\"id\":4,\"penjualan_id\":3,\"tanggal\":\"2026-12-01\",\"nominal\":1000000,\"dibayar\":1000000},{\"id\":5,\"penjualan_id\":3,\"tanggal\":\"2026-12-09\",\"nominal\":1000000,\"dibayar\":0},{\"id\":6,\"penjualan_id\":3,\"tanggal\":\"2026-12-16\",\"nominal\":1570000,\"dibayar\":0},{\"id\":7,\"penjualan_id\":3,\"tanggal\":\"2026-11-24\",\"nominal\":1000000,\"dibayar\":null}]', 1000000.00, '[{\"id\":3,\"penjualan_id\":3,\"tanggal\":\"2026-11-24\",\"nominal\":1000000,\"metode_pembayaran_id\":2,\"keterangan\":null,\"created_at\":\"2026-11-24 02:26:42\",\"created_by\":\"sebastian\",\"updated_at\":null,\"updated_by\":null}]', '2026-11-24 02:29:25', 'sebastian', 'auto', NULL, NULL, '2026-11-24 02:26:22', 'sebastian', '2026-11-24 02:29:25', 'sebastian', NULL, NULL, 2);

-- ----------------------------
-- Table structure for log_penjualan_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `log_penjualan_pembayaran`;
CREATE TABLE `log_penjualan_pembayaran`  (
  `id` bigint NULL DEFAULT NULL,
  `penjualan_id` bigint NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `nominal` decimal(20, 2) NULL DEFAULT NULL,
  `metode_pembayaran_id` bigint NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `deleted_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_urut` int NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of log_penjualan_pembayaran
-- ----------------------------
INSERT INTO `log_penjualan_pembayaran` VALUES (1, 1, '2026-11-23', 3840000.00, 2, NULL, '2026-11-23 12:49:49', 'sebastian', NULL, NULL, NULL, NULL, 1);
INSERT INTO `log_penjualan_pembayaran` VALUES (2, 2, '2026-11-24', 4113000.00, 2, NULL, '2026-11-24 02:23:43', 'sebastian', NULL, NULL, NULL, NULL, 1);
INSERT INTO `log_penjualan_pembayaran` VALUES (2, 2, '2026-11-24', 4113000.00, 2, NULL, '2026-11-24 02:23:43', 'sebastian', NULL, NULL, '2026-11-24 02:25:45', 'sebastian', 2);
INSERT INTO `log_penjualan_pembayaran` VALUES (1, 1, '2026-11-23', 3840000.00, 2, NULL, '2026-11-23 12:49:49', 'sebastian', NULL, NULL, '2026-11-24 02:25:49', 'sebastian', 2);
INSERT INTO `log_penjualan_pembayaran` VALUES (3, 3, '2026-11-24', 1000000.00, 2, NULL, '2026-11-24 02:26:42', 'sebastian', NULL, NULL, NULL, NULL, 1);

-- ----------------------------
-- Table structure for log_pesanan
-- ----------------------------
DROP TABLE IF EXISTS `log_pesanan`;
CREATE TABLE `log_pesanan`  (
  `id` bigint NULL DEFAULT NULL,
  `cabang_id` bigint NULL DEFAULT NULL,
  `kode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor` int NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `nomor_po` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `batas_waktu` int NULL DEFAULT NULL,
  `karyawan_id` bigint NULL DEFAULT NULL,
  `customer_id` bigint NULL DEFAULT NULL,
  `nama_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_wa_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `credit_limit_customer` decimal(20, 2) NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `jumlah` decimal(20, 2) NULL DEFAULT NULL,
  `jumlah_penjualan` decimal(20, 2) NULL DEFAULT NULL,
  `sub_total` decimal(20, 2) NULL DEFAULT NULL,
  `persen_diskon` decimal(20, 2) NULL DEFAULT NULL,
  `diskon` decimal(20, 2) NULL DEFAULT NULL,
  `dpp` decimal(20, 2) NULL DEFAULT NULL,
  `persen_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `ppn` decimal(20, 2) NULL DEFAULT NULL,
  `total` decimal(20, 2) NULL DEFAULT NULL,
  `approved_at` datetime NULL DEFAULT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approved_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rejected_at` datetime NULL DEFAULT NULL,
  `rejected_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `deleted_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_urut` int NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of log_pesanan
-- ----------------------------
INSERT INTO `log_pesanan` VALUES (1, 1, '01', 1, 2026, '2026-11-23', 'PO1', 8, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":1,\"pesanan_id\":1,\"penawaran_detail_id\":null,\"barang_id\":4,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC15YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 0,5 PK (5.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":3840000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":3840000,\"jumlah\":2,\"jumlah_penjualan\":null,\"sub_total\":7680000,\"sub_total_sebelum_ppn\":7680000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":7680000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":7680000,\"approved_at\":\"2026-11-23 21:27:16\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"retur\":null}]', 2.00, NULL, 7680000.00, NULL, NULL, 7680000.00, NULL, 0.00, 7680000.00, '2026-11-23 21:27:16', 'sebastian', 'auto', NULL, NULL, '2026-11-23 21:27:16', 'sebastian', NULL, NULL, NULL, NULL, 1);
INSERT INTO `log_pesanan` VALUES (2, 1, '01', 2, 2026, '2026-11-24', 'PO2', 9, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":2,\"pesanan_id\":2,\"penawaran_detail_id\":2,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"jumlah_penjualan\":null,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":457000,\"dpp\":4113000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4113000,\"approved_at\":\"2026-11-24 02:20:16\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"retur\":null}]', 1.00, NULL, 4570000.00, 10.00, 457000.00, 4113000.00, NULL, 0.00, 4113000.00, '2026-11-24 02:20:16', 'sebastian', 'auto', NULL, NULL, '2026-11-24 02:20:16', 'sebastian', NULL, NULL, NULL, NULL, 1);

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` int NOT NULL,
  `id_induk` int NULL DEFAULT NULL,
  `menu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_urut` int NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, NULL, 'Dashboard', 'area-chart', 'dashboard', 1);
INSERT INTO `menu` VALUES (3, NULL, 'Data Master', 'database', NULL, 3);
INSERT INTO `menu` VALUES (4, 3, 'Cabang', 'anchor', 'cabang', 4);
INSERT INTO `menu` VALUES (5, 3, 'Gudang', 'home', 'gudang', 5);
INSERT INTO `menu` VALUES (6, 3, 'Rak', 'server', 'rak', 6);
INSERT INTO `menu` VALUES (7, 3, 'Satuan', 'shield', 'satuan', 7);
INSERT INTO `menu` VALUES (8, 3, 'Kategori', 'hashtag', 'kategori', 8);
INSERT INTO `menu` VALUES (9, 3, 'Barang', 'cubes', 'barang', 9);
INSERT INTO `menu` VALUES (10, 3, 'Jasa', 'handshake-o', 'jasa', 10);
INSERT INTO `menu` VALUES (11, 3, 'Jenis Customer', 'map-signs', 'jenis-customer', 11);
INSERT INTO `menu` VALUES (12, 3, 'Customer', 'address-book-o', 'customer', 12);
INSERT INTO `menu` VALUES (13, 3, 'Jenis Supplier', 'inbox', 'jenis-supplier', 13);
INSERT INTO `menu` VALUES (14, 3, 'Supplier', 'user-secret', 'supplier', 14);
INSERT INTO `menu` VALUES (15, 3, 'Bank', 'bank', 'bank', 15);
INSERT INTO `menu` VALUES (16, 3, 'Metode Pembayaran', 'credit-card-alt', 'metode-pembayaran', 16);
INSERT INTO `menu` VALUES (17, 3, 'Kata Pengantar', 'envelope-o', 'kata-pengantar', 17);
INSERT INTO `menu` VALUES (18, 3, 'Catatan Penawaran', 'sticky-note-o', 'catatan-penawaran', 18);
INSERT INTO `menu` VALUES (19, 3, 'Tanda Tangan', 'pencil-square', 'tanda-tangan', 19);
INSERT INTO `menu` VALUES (20, NULL, 'Persediaan', 'book', NULL, 20);
INSERT INTO `menu` VALUES (21, 20, 'Katalog', 'book', 'katalog', 21);
INSERT INTO `menu` VALUES (22, 20, 'Pembelian', 'shopping-basket', 'pembelian', 22);
INSERT INTO `menu` VALUES (23, 20, 'Barang Masuk', 'download', 'barang-masuk', 23);
INSERT INTO `menu` VALUES (24, 20, 'Penawaran', 'send-o', 'penawaran', 24);
INSERT INTO `menu` VALUES (25, 20, 'Pesanan', 'shopping-cart', 'pesanan', 25);
INSERT INTO `menu` VALUES (26, 20, 'Penjualan', 'tag', 'penjualan', 26);
INSERT INTO `menu` VALUES (27, 20, 'Pengiriman', 'truck', 'pengiriman', 27);
INSERT INTO `menu` VALUES (28, 20, 'Pindah Rak', 'inbox', 'pindah-rak', 28);
INSERT INTO `menu` VALUES (29, NULL, 'SDM', 'group', NULL, 29);
INSERT INTO `menu` VALUES (30, 29, 'Jabatan', 'heartbeat', 'jabatan', 30);
INSERT INTO `menu` VALUES (31, 29, 'Jam Kerja', 'clock-o', 'jam-kerja', 31);
INSERT INTO `menu` VALUES (32, 29, 'Karyawan', 'users', 'karyawan', 32);
INSERT INTO `menu` VALUES (33, 29, 'Validasi Absensi', 'check-square-o', 'validasi-absensi', 33);
INSERT INTO `menu` VALUES (34, 29, 'Hari Libur', 'calendar', 'hari-libur', 34);
INSERT INTO `menu` VALUES (35, 29, 'Izin', 'clone', 'izin', 35);
INSERT INTO `menu` VALUES (36, 29, 'Absensi', 'address-card', 'absensi', 36);
INSERT INTO `menu` VALUES (37, NULL, 'Approval', 'bell', NULL, 37);
INSERT INTO `menu` VALUES (38, 37, 'Penawaran', 'handshake-o', 'approval-penawaran', 38);
INSERT INTO `menu` VALUES (39, 37, 'Pesanan', 'shopping-cart', 'approval-pesanan', 39);
INSERT INTO `menu` VALUES (40, 37, 'Penjualan', 'tag', 'approval-penjualan', 40);
INSERT INTO `menu` VALUES (41, NULL, 'Laporan', 'book', NULL, 41);
INSERT INTO `menu` VALUES (42, 41, 'Lap. Stok', 'file-pdf-o', 'laporan-stok', 42);
INSERT INTO `menu` VALUES (43, 41, 'Lap. Pesanan', 'file-pdf-o', 'laporan-pesanan', 43);
INSERT INTO `menu` VALUES (44, 41, 'Lap. Pembelian', 'file-pdf-o', 'laporan-pembelian', 44);
INSERT INTO `menu` VALUES (45, 41, 'Lap. Penjualan', 'file-pdf-o', 'laporan-penjualan', 45);
INSERT INTO `menu` VALUES (46, 41, 'Lap. Piutang Customer', 'file-pdf-o', 'laporan-piutang-customer', 46);
INSERT INTO `menu` VALUES (47, 41, 'Lap. Penerimaan Pembayaran', 'money', 'laporan-penerimaan-pembayaran', 47);
INSERT INTO `menu` VALUES (123, NULL, 'Users', 'lock', 'users', 123);
INSERT INTO `menu` VALUES (124, NULL, 'Users Level', 'key', 'users-level', 124);

-- ----------------------------
-- Table structure for menu_akses
-- ----------------------------
DROP TABLE IF EXISTS `menu_akses`;
CREATE TABLE `menu_akses`  (
  `users_level_id` int NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu_akses
-- ----------------------------
INSERT INTO `menu_akses` VALUES (3, 'anggota', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'berita', 'form.php');
INSERT INTO `menu_akses` VALUES (3, 'berita', 'hapus.php');
INSERT INTO `menu_akses` VALUES (3, 'berita', 'simpan.php');
INSERT INTO `menu_akses` VALUES (3, 'berita', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'berita', 'ubah.php');
INSERT INTO `menu_akses` VALUES (3, 'berita-acara', 'form.php');
INSERT INTO `menu_akses` VALUES (3, 'berita-acara', 'simpan.php');
INSERT INTO `menu_akses` VALUES (3, 'berita-acara', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'berita-acara', 'ubah.php');
INSERT INTO `menu_akses` VALUES (3, 'cash-on-hand', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'dashboard', 'akumulasi.php');
INSERT INTO `menu_akses` VALUES (3, 'laporan-transaksi-keuangan', 'download.php');
INSERT INTO `menu_akses` VALUES (3, 'laporan-transaksi-keuangan', 'form.php');
INSERT INTO `menu_akses` VALUES (3, 'laporan-transaksi-keuangan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'laporan-transaksi-keuangan', 'transaksi-keuangan.xlsx');
INSERT INTO `menu_akses` VALUES (3, 'laporan-transaksi-keuangan-rahasia', 'download.php');
INSERT INTO `menu_akses` VALUES (3, 'laporan-transaksi-keuangan-rahasia', 'form.php');
INSERT INTO `menu_akses` VALUES (3, 'laporan-transaksi-keuangan-rahasia', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'laporan-transaksi-keuangan-rahasia', 'transaksi-keuangan.xlsx');
INSERT INTO `menu_akses` VALUES (3, 'pengeluaran', 'form.php');
INSERT INTO `menu_akses` VALUES (3, 'pengeluaran', 'hapus.php');
INSERT INTO `menu_akses` VALUES (3, 'pengeluaran', 'load-file.php');
INSERT INTO `menu_akses` VALUES (3, 'pengeluaran', 'simpan.php');
INSERT INTO `menu_akses` VALUES (3, 'pengeluaran', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'pengeluaran', 'ubah.php');
INSERT INTO `menu_akses` VALUES (3, 'pengeluaran-study-tour', 'form.php');
INSERT INTO `menu_akses` VALUES (3, 'pengeluaran-study-tour', 'hapus.php');
INSERT INTO `menu_akses` VALUES (3, 'pengeluaran-study-tour', 'load-file.php');
INSERT INTO `menu_akses` VALUES (3, 'pengeluaran-study-tour', 'simpan.php');
INSERT INTO `menu_akses` VALUES (3, 'pengeluaran-study-tour', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'pengeluaran-study-tour', 'ubah.php');
INSERT INTO `menu_akses` VALUES (3, 'pengumuman', 'form.php');
INSERT INTO `menu_akses` VALUES (3, 'pengumuman', 'hapus.php');
INSERT INTO `menu_akses` VALUES (3, 'pengumuman', 'simpan.php');
INSERT INTO `menu_akses` VALUES (3, 'pengumuman', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'pengumuman', 'ubah.php');
INSERT INTO `menu_akses` VALUES (3, 'pertemuan', 'form.php');
INSERT INTO `menu_akses` VALUES (3, 'pertemuan', 'load-file.php');
INSERT INTO `menu_akses` VALUES (3, 'pertemuan', 'simpan.php');
INSERT INTO `menu_akses` VALUES (3, 'pertemuan', 'tampil-broadcast.php');
INSERT INTO `menu_akses` VALUES (3, 'pertemuan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'pertemuan', 'ubah.php');
INSERT INTO `menu_akses` VALUES (3, 'pertemuan', 'upload-file.php');
INSERT INTO `menu_akses` VALUES (3, 'peserta-toefl', 'simpan-pembayaran.php');
INSERT INTO `menu_akses` VALUES (3, 'peserta-toefl', 'tampil-pembayaran.php');
INSERT INTO `menu_akses` VALUES (3, 'peserta-toefl', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'peserta-toefl', 'ubah-pembayaran.php');
INSERT INTO `menu_akses` VALUES (3, 'peserta-study-tour', 'simpan-pembayaran.php');
INSERT INTO `menu_akses` VALUES (3, 'peserta-study-tour', 'tampil-pembayaran.php');
INSERT INTO `menu_akses` VALUES (3, 'peserta-study-tour', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'peserta-study-tour', 'ubah-pembayaran.php');
INSERT INTO `menu_akses` VALUES (3, 'setor', 'batal-setor.php');
INSERT INTO `menu_akses` VALUES (3, 'setor', 'setor.php');
INSERT INTO `menu_akses` VALUES (3, 'setor', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'setor-study-tour', 'batal-setor.php');
INSERT INTO `menu_akses` VALUES (3, 'setor-study-tour', 'setor.php');
INSERT INTO `menu_akses` VALUES (3, 'setor-study-tour', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'surat-peminjaman-kelas', 'cetak.php');
INSERT INTO `menu_akses` VALUES (3, 'surat-peminjaman-kelas', 'form.php');
INSERT INTO `menu_akses` VALUES (3, 'surat-peminjaman-kelas', 'hapus.php');
INSERT INTO `menu_akses` VALUES (3, 'surat-peminjaman-kelas', 'simpan.php');
INSERT INTO `menu_akses` VALUES (3, 'surat-peminjaman-kelas', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'surat-peminjaman-kelas', 'ubah.php');
INSERT INTO `menu_akses` VALUES (3, 'terima', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'terima', 'terima.php');
INSERT INTO `menu_akses` VALUES (3, 'terima-study-tour', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'terima-study-tour', 'terima.php');
INSERT INTO `menu_akses` VALUES (3, 'transaksi-keuangan', 'form.php');
INSERT INTO `menu_akses` VALUES (3, 'transaksi-keuangan', 'hapus.php');
INSERT INTO `menu_akses` VALUES (3, 'transaksi-keuangan', 'load-file.php');
INSERT INTO `menu_akses` VALUES (3, 'transaksi-keuangan', 'simpan.php');
INSERT INTO `menu_akses` VALUES (3, 'transaksi-keuangan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'transaksi-keuangan', 'ubah.php');
INSERT INTO `menu_akses` VALUES (3, 'transaksi-keuangan-rahasia', 'form.php');
INSERT INTO `menu_akses` VALUES (3, 'transaksi-keuangan-rahasia', 'hapus.php');
INSERT INTO `menu_akses` VALUES (3, 'transaksi-keuangan-rahasia', 'load-file.php');
INSERT INTO `menu_akses` VALUES (3, 'transaksi-keuangan-rahasia', 'simpan.php');
INSERT INTO `menu_akses` VALUES (3, 'transaksi-keuangan-rahasia', 'tampil.php');
INSERT INTO `menu_akses` VALUES (3, 'transaksi-keuangan-rahasia', 'ubah.php');
INSERT INTO `menu_akses` VALUES (4, 'anggota', 'form.php');
INSERT INTO `menu_akses` VALUES (4, 'anggota', 'hapus.php');
INSERT INTO `menu_akses` VALUES (4, 'anggota', 'simpan.php');
INSERT INTO `menu_akses` VALUES (4, 'anggota', 'tampil-pertemuan.php');
INSERT INTO `menu_akses` VALUES (4, 'anggota', 'tampil.php');
INSERT INTO `menu_akses` VALUES (4, 'anggota', 'ubah.php');
INSERT INTO `menu_akses` VALUES (4, 'berita-acara', 'form.php');
INSERT INTO `menu_akses` VALUES (4, 'berita-acara', 'hapus.php');
INSERT INTO `menu_akses` VALUES (4, 'berita-acara', 'simpan.php');
INSERT INTO `menu_akses` VALUES (4, 'berita-acara', 'tampil.php');
INSERT INTO `menu_akses` VALUES (4, 'berita-acara', 'ubah.php');
INSERT INTO `menu_akses` VALUES (4, 'dashboard', 'akumulasi.php');
INSERT INTO `menu_akses` VALUES (4, 'laporan-transaksi-keuangan', 'download.php');
INSERT INTO `menu_akses` VALUES (4, 'laporan-transaksi-keuangan', 'form.php');
INSERT INTO `menu_akses` VALUES (4, 'laporan-transaksi-keuangan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (4, 'laporan-transaksi-keuangan', 'transaksi-keuangan.xlsx');
INSERT INTO `menu_akses` VALUES (5, 'anggota', 'form.php');
INSERT INTO `menu_akses` VALUES (5, 'anggota', 'tampil-pertemuan.php');
INSERT INTO `menu_akses` VALUES (5, 'anggota', 'tampil.php');
INSERT INTO `menu_akses` VALUES (5, 'berita-acara', 'form.php');
INSERT INTO `menu_akses` VALUES (5, 'berita-acara', 'tampil.php');
INSERT INTO `menu_akses` VALUES (5, 'dashboard', 'akumulasi.php');
INSERT INTO `menu_akses` VALUES (5, 'laporan-transaksi-keuangan', 'download.php');
INSERT INTO `menu_akses` VALUES (5, 'laporan-transaksi-keuangan', 'form.php');
INSERT INTO `menu_akses` VALUES (5, 'laporan-transaksi-keuangan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (5, 'laporan-transaksi-keuangan', 'transaksi-keuangan.xlsx');
INSERT INTO `menu_akses` VALUES (5, 'pertemuan', 'form.php');
INSERT INTO `menu_akses` VALUES (5, 'pertemuan', 'load-file.php');
INSERT INTO `menu_akses` VALUES (5, 'pertemuan', 'tampil-broadcast.php');
INSERT INTO `menu_akses` VALUES (5, 'pertemuan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (2, 'dashboard', 'Salinan akumulasi.php');
INSERT INTO `menu_akses` VALUES (2, 'dashboard', 'akumulasi.php');
INSERT INTO `menu_akses` VALUES (2, 'dashboard', 'form.php');
INSERT INTO `menu_akses` VALUES (2, 'katalog', 'form.php');
INSERT INTO `menu_akses` VALUES (2, 'katalog', 'tampil.php');
INSERT INTO `menu_akses` VALUES (2, 'laporan-penjualan', 'form.php');
INSERT INTO `menu_akses` VALUES (2, 'laporan-penjualan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (2, 'laporan-stok', 'form.php');
INSERT INTO `menu_akses` VALUES (2, 'laporan-stok', 'tampil.php');
INSERT INTO `menu_akses` VALUES (2, 'penawaran', 'cetak.php');
INSERT INTO `menu_akses` VALUES (2, 'penawaran', 'form.php');
INSERT INTO `menu_akses` VALUES (2, 'penawaran', 'get-email.php');
INSERT INTO `menu_akses` VALUES (2, 'penawaran', 'get-karyawan.php');
INSERT INTO `menu_akses` VALUES (2, 'penawaran', 'get-no-telp.php');
INSERT INTO `menu_akses` VALUES (2, 'penawaran', 'simpan-customer.php');
INSERT INTO `menu_akses` VALUES (2, 'penawaran', 'simpan.php');
INSERT INTO `menu_akses` VALUES (2, 'penawaran', 'tampil-barang.php');
INSERT INTO `menu_akses` VALUES (2, 'penawaran', 'tampil-customer.php');
INSERT INTO `menu_akses` VALUES (2, 'penawaran', 'tampil-jasa.php');
INSERT INTO `menu_akses` VALUES (2, 'penawaran', 'tampil.php');
INSERT INTO `menu_akses` VALUES (2, 'penawaran', 'ubah.php');
INSERT INTO `menu_akses` VALUES (2, 'pengiriman', 'cetak.php');
INSERT INTO `menu_akses` VALUES (2, 'pengiriman', 'form.php');
INSERT INTO `menu_akses` VALUES (2, 'pengiriman', 'function.php');
INSERT INTO `menu_akses` VALUES (2, 'pengiriman', 'simpan-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` VALUES (2, 'pengiriman', 'simpan.php');
INSERT INTO `menu_akses` VALUES (2, 'pengiriman', 'tampil-add-kirim.php');
INSERT INTO `menu_akses` VALUES (2, 'pengiriman', 'tampil-barang-masuk-detail.php');
INSERT INTO `menu_akses` VALUES (2, 'pengiriman', 'tampil-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` VALUES (2, 'pengiriman', 'tampil-penjualan.php');
INSERT INTO `menu_akses` VALUES (2, 'pengiriman', 'tampil.php');
INSERT INTO `menu_akses` VALUES (2, 'pengiriman', 'ubah.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'cetak-kwitansi.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'cetak.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'form.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'get-email.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'get-karyawan.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'get-no-telp.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'hapus-pembayaran.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'hapus.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'simpan-customer.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'simpan-pembayaran.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'simpan-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'simpan.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'tampil-barang-masuk-detail.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'tampil-barang.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'tampil-customer.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'tampil-jasa.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'tampil-pembayaran.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'tampil-penawaran.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'tampil-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'tampil-pesanan.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'ubah-pembayaran.php');
INSERT INTO `menu_akses` VALUES (2, 'penjualan', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'absensi', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'absensi', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'absensi', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'bank', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'bank', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'bank', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'bank', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'bank', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'barang', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'barang', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'barang', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'barang', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'barang', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'barang', 'upload.php');
INSERT INTO `menu_akses` VALUES (1, 'barang-masuk', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'barang-masuk', 'get-rak.php');
INSERT INTO `menu_akses` VALUES (1, 'barang-masuk', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'barang-masuk', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'barang-masuk', 'tampil-barang.php');
INSERT INTO `menu_akses` VALUES (1, 'barang-masuk', 'tampil-pembelian-detail.php');
INSERT INTO `menu_akses` VALUES (1, 'barang-masuk', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'barang-masuk', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'cabang', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'cabang', 'get-email.php');
INSERT INTO `menu_akses` VALUES (1, 'cabang', 'get-no-telp.php');
INSERT INTO `menu_akses` VALUES (1, 'cabang', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'cabang', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'cabang', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'cabang', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'catatan-penawaran', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'catatan-penawaran', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'catatan-penawaran', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'catatan-penawaran', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'catatan-penawaran', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'customer', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'customer', 'get-email.php');
INSERT INTO `menu_akses` VALUES (1, 'customer', 'get-no-telp.php');
INSERT INTO `menu_akses` VALUES (1, 'customer', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'customer', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'customer', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'customer', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'dashboard', 'Salinan akumulasi.php');
INSERT INTO `menu_akses` VALUES (1, 'dashboard', 'akumulasi.php');
INSERT INTO `menu_akses` VALUES (1, 'dashboard', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'dashboard', 'tampil-pembelian.php');
INSERT INTO `menu_akses` VALUES (1, 'dashboard', 'tampil-penawaran.php');
INSERT INTO `menu_akses` VALUES (1, 'dashboard', 'tampil-penjualan.php');
INSERT INTO `menu_akses` VALUES (1, 'dashboard', 'tampil-pesanan.php');
INSERT INTO `menu_akses` VALUES (1, 'dashboard', 'tampil-tanggapan.php');
INSERT INTO `menu_akses` VALUES (1, 'gudang', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'gudang', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'gudang', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'gudang', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'gudang', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'hari-libur', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'hari-libur', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'hari-libur', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'hari-libur', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'hari-libur', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'izin', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'izin', 'get-karyawan.php');
INSERT INTO `menu_akses` VALUES (1, 'izin', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'izin', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'izin', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'izin', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'jabatan', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'jabatan', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'jabatan', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'jabatan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'jabatan', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'jam-kerja', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'jam-kerja', 'hapus-shift-jam-kerja.php');
INSERT INTO `menu_akses` VALUES (1, 'jam-kerja', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'jam-kerja', 'simpan-shift-jam-kerja.php');
INSERT INTO `menu_akses` VALUES (1, 'jam-kerja', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'jam-kerja', 'tampil-shift-jam-kerja.php');
INSERT INTO `menu_akses` VALUES (1, 'jam-kerja', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'jam-kerja', 'ubah-shift-jam-kerja.php');
INSERT INTO `menu_akses` VALUES (1, 'jam-kerja', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'jasa', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'jasa', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'jasa', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'jasa', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'jasa', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'jenis-customer', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'jenis-customer', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'jenis-customer', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'jenis-customer', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'jenis-customer', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'jenis-supplier', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'jenis-supplier', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'jenis-supplier', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'jenis-supplier', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'jenis-supplier', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'karyawan', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'karyawan', 'get-no-hp.php');
INSERT INTO `menu_akses` VALUES (1, 'karyawan', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'karyawan', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'karyawan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'karyawan', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'karyawan', 'upload-foto.php');
INSERT INTO `menu_akses` VALUES (1, 'kata-pengantar', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'kata-pengantar', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'kata-pengantar', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'kata-pengantar', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'kata-pengantar', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'katalog', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'katalog', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'kategori', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'kategori', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'kategori', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'kategori', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'kategori', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-pembelian', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-pembelian', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-penerimaan-pembayaran', '.DS_Store');
INSERT INTO `menu_akses` VALUES (1, 'laporan-penerimaan-pembayaran', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-penerimaan-pembayaran', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-penjualan', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-penjualan', 'get-customer.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-penjualan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-pesanan', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-pesanan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-piutang-customer', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-piutang-customer', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-stok', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'laporan-stok', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'metode-pembayaran', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'metode-pembayaran', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'metode-pembayaran', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'metode-pembayaran', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'metode-pembayaran', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'pembelian', 'cetak.php');
INSERT INTO `menu_akses` VALUES (1, 'pembelian', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'pembelian', 'get-email.php');
INSERT INTO `menu_akses` VALUES (1, 'pembelian', 'get-no-telp.php');
INSERT INTO `menu_akses` VALUES (1, 'pembelian', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'pembelian', 'simpan-supplier.php');
INSERT INTO `menu_akses` VALUES (1, 'pembelian', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'pembelian', 'tampil-barang.php');
INSERT INTO `menu_akses` VALUES (1, 'pembelian', 'tampil-pemesanan.php');
INSERT INTO `menu_akses` VALUES (1, 'pembelian', 'tampil-supplier.php');
INSERT INTO `menu_akses` VALUES (1, 'pembelian', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'pembelian', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'cetak.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'get-email.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'get-karyawan.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'get-no-telp.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'simpan-customer.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'tampil-barang.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'tampil-customer.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'tampil-jasa.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'penawaran', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'approval-penawaran', '.DS_Store');
INSERT INTO `menu_akses` VALUES (1, 'approval-penawaran', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'approval-penawaran', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'approval-penawaran', 'terima.php');
INSERT INTO `menu_akses` VALUES (1, 'approval-penawaran', 'tolak.php');
INSERT INTO `menu_akses` VALUES (1, 'pengiriman', 'cetak.php');
INSERT INTO `menu_akses` VALUES (1, 'pengiriman', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'pengiriman', 'function.php');
INSERT INTO `menu_akses` VALUES (1, 'pengiriman', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'pengiriman', 'simpan-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` VALUES (1, 'pengiriman', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'pengiriman', 'tampil-add-kirim.php');
INSERT INTO `menu_akses` VALUES (1, 'pengiriman', 'tampil-barang-masuk-detail.php');
INSERT INTO `menu_akses` VALUES (1, 'pengiriman', 'tampil-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` VALUES (1, 'pengiriman', 'tampil-penjualan.php');
INSERT INTO `menu_akses` VALUES (1, 'pengiriman', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'pengiriman', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', '.DS_Store');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'Salinan tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'cetak-kwitansi.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'cetak.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'get-email.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'get-karyawan.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'get-no-telp.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'hapus-pembayaran.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'simpan-customer.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'simpan-pembayaran.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'simpan-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'tampil-barang-masuk-detail.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'tampil-barang.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'tampil-customer.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'tampil-jasa.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'tampil-pembayaran.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'tampil-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'tampil-pesanan.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'ubah-pembayaran.php');
INSERT INTO `menu_akses` VALUES (1, 'penjualan', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'approval-penjualan', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'approval-penjualan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'approval-penjualan', 'terima.php');
INSERT INTO `menu_akses` VALUES (1, 'approval-penjualan', 'tolak.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'cetak.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'get-email.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'get-karyawan.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'get-no-telp.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'simpan-customer.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'tampil-barang.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'tampil-customer.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'tampil-jasa.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'tampil-penawaran.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'pesanan', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'approval-pesanan', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'approval-pesanan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'approval-pesanan', 'terima.php');
INSERT INTO `menu_akses` VALUES (1, 'approval-pesanan', 'tolak.php');
INSERT INTO `menu_akses` VALUES (1, 'pindah-rak', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'pindah-rak', 'get-rak.php');
INSERT INTO `menu_akses` VALUES (1, 'pindah-rak', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'pindah-rak', 'tampil-penjualan-detail-ditandai.php');
INSERT INTO `menu_akses` VALUES (1, 'pindah-rak', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'rak', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'rak', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'rak', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'rak', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'rak', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'satuan', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'satuan', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'satuan', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'satuan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'satuan', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'supplier', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'supplier', 'get-email.php');
INSERT INTO `menu_akses` VALUES (1, 'supplier', 'get-no-telp.php');
INSERT INTO `menu_akses` VALUES (1, 'supplier', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'supplier', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'supplier', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'supplier', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'tanda-tangan', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'tanda-tangan', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'tanda-tangan', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'tanda-tangan', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'tanda-tangan', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'users', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'users', 'get-karyawan.php');
INSERT INTO `menu_akses` VALUES (1, 'users', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'users', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'users', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'users', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'users-level', 'form-akses-menu.php');
INSERT INTO `menu_akses` VALUES (1, 'users-level', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'users-level', 'hapus.php');
INSERT INTO `menu_akses` VALUES (1, 'users-level', 'simpan-akses.php');
INSERT INTO `menu_akses` VALUES (1, 'users-level', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'users-level', 'tampil.php');
INSERT INTO `menu_akses` VALUES (1, 'users-level', 'ubah.php');
INSERT INTO `menu_akses` VALUES (1, 'validasi-absensi', 'form.php');
INSERT INTO `menu_akses` VALUES (1, 'validasi-absensi', 'simpan.php');
INSERT INTO `menu_akses` VALUES (1, 'validasi-absensi', 'tampil.php');

-- ----------------------------
-- Table structure for metode_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `metode_pembayaran`;
CREATE TABLE `metode_pembayaran`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `metode_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of metode_pembayaran
-- ----------------------------
INSERT INTO `metode_pembayaran` VALUES (1, 'Tunai');
INSERT INTO `metode_pembayaran` VALUES (2, 'Transfer Ke Bank Mandiri');

-- ----------------------------
-- Table structure for pembelian
-- ----------------------------
DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE `pembelian`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint NULL DEFAULT NULL,
  `kode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor` int NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `tanda_tangan_id` bigint NULL DEFAULT NULL,
  `supplier_id` bigint NULL DEFAULT NULL,
  `nama_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_wa_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `sub_total` decimal(20, 2) NULL DEFAULT NULL,
  `persen_diskon` decimal(20, 2) NULL DEFAULT NULL,
  `diskon` decimal(20, 2) NULL DEFAULT NULL,
  `dpp` decimal(20, 2) NULL DEFAULT NULL,
  `persen_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `ppn` decimal(20, 2) NULL DEFAULT NULL,
  `total` decimal(20, 2) NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pembelian
-- ----------------------------
INSERT INTO `pembelian` VALUES (1, 1, 'PO', 1, 2026, '2026-11-24', 2, 1, 'Sebarga', 'Jl. AH. Nasution No. 17', '[{\"no_telp_supplier\":\"08122281231\"}]', '[{\"no_wa_supplier\":\"08122281231\"}]', NULL, '[{\"id\":1,\"pembelian_id\":1,\"barang_id\":4,\"harga\":3000000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":3000000,\"jumlah\":10,\"sub_total\":30000000,\"sub_total_sebelum_ppn\":30000000,\"diskon_item\":0,\"diskon_item_detail\":null,\"diskon_faktur\":0,\"dpp\":30000000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":30000000,\"masuk_gudang\":10,\"retur\":null}]', 30000000.00, NULL, NULL, 30000000.00, NULL, 0.00, 30000000.00, '2026-11-24 02:07:38', 'sebastian', NULL, NULL);
INSERT INTO `pembelian` VALUES (2, 1, 'PO', 2, 2026, '2026-11-24', 2, 1, 'Sebarga', 'Jl. AH. Nasution No. 17', '[{\"no_telp_supplier\":\"08122281231\"}]', '[{\"no_wa_supplier\":\"08122281231\"}]', NULL, '[{\"id\":2,\"pembelian_id\":2,\"barang_id\":6,\"harga\":3500000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":3500000,\"jumlah\":10,\"sub_total\":35000000,\"sub_total_sebelum_ppn\":35000000,\"diskon_item\":0,\"diskon_item_detail\":null,\"diskon_faktur\":0,\"dpp\":35000000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":35000000,\"masuk_gudang\":10,\"retur\":null}]', 35000000.00, NULL, NULL, 35000000.00, NULL, 0.00, 35000000.00, '2026-11-24 02:12:33', 'sebastian', NULL, NULL);

-- ----------------------------
-- Table structure for pembelian_detail
-- ----------------------------
DROP TABLE IF EXISTS `pembelian_detail`;
CREATE TABLE `pembelian_detail`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pembelian_id` bigint NULL DEFAULT NULL,
  `barang_id` bigint NULL DEFAULT NULL,
  `harga` decimal(20, 2) NULL DEFAULT NULL,
  `jenis_ppn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga_sebelum_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `jumlah` decimal(20, 2) NULL DEFAULT NULL,
  `sub_total` decimal(20, 2) NULL DEFAULT NULL,
  `sub_total_sebelum_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `diskon_item` decimal(20, 2) NULL DEFAULT NULL,
  `diskon_item_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `diskon_faktur` decimal(20, 2) NULL DEFAULT NULL,
  `dpp` decimal(20, 2) NULL DEFAULT NULL,
  `persen_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `nominal_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `total` decimal(20, 2) NULL DEFAULT NULL,
  `masuk_gudang` decimal(20, 2) NULL DEFAULT NULL,
  `retur` decimal(20, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pembelian_detail
-- ----------------------------
INSERT INTO `pembelian_detail` VALUES (1, 1, 4, 3000000.00, 'Belum PPN', 3000000.00, 10.00, 30000000.00, 30000000.00, 0.00, NULL, 0.00, 30000000.00, 0.00, 0.00, 30000000.00, 10.00, NULL);
INSERT INTO `pembelian_detail` VALUES (2, 2, 6, 3500000.00, 'Belum PPN', 3500000.00, 10.00, 35000000.00, 35000000.00, 0.00, NULL, 0.00, 35000000.00, 0.00, 0.00, 35000000.00, 10.00, NULL);

-- ----------------------------
-- Table structure for penawaran
-- ----------------------------
DROP TABLE IF EXISTS `penawaran`;
CREATE TABLE `penawaran`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint NULL DEFAULT NULL,
  `kode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor` int NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `kata_pengantar_id` bigint NULL DEFAULT NULL,
  `catatan_penawaran_id` bigint NULL DEFAULT NULL,
  `tanda_tangan_id` bigint NULL DEFAULT NULL,
  `batas_waktu` decimal(20, 2) NULL DEFAULT NULL,
  `karyawan_id` bigint NULL DEFAULT NULL,
  `customer_id` bigint NULL DEFAULT NULL,
  `nama_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_wa_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `credit_limit_customer` decimal(20, 2) NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `jumlah` decimal(20, 2) NULL DEFAULT NULL,
  `jumlah_pesanan` decimal(20, 2) NULL DEFAULT NULL,
  `sub_total` decimal(20, 2) NULL DEFAULT NULL,
  `persen_diskon` decimal(20, 2) NULL DEFAULT NULL,
  `diskon` decimal(20, 2) NULL DEFAULT NULL,
  `dpp` decimal(20, 2) NULL DEFAULT NULL,
  `persen_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `ppn` decimal(20, 2) NULL DEFAULT NULL,
  `total` decimal(20, 2) NULL DEFAULT NULL,
  `approved_at` datetime NULL DEFAULT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approved_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rejected_at` datetime NULL DEFAULT NULL,
  `rejected_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penawaran
-- ----------------------------
INSERT INTO `penawaran` VALUES (1, 1, '02', 1, 2026, '2026-11-23', 2, 1, 2, 7.00, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":1,\"penawaran_id\":1,\"barang_id\":4,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC15YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 0,5 PK (5.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":3840000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":3840000,\"jumlah\":1,\"jumlah_pesanan\":null,\"sub_total\":3840000,\"sub_total_sebelum_ppn\":3840000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":3840000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":3840000,\"approved_at\":\"2026-11-23 21:04:44\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"retur\":null}]', 1.00, NULL, 3840000.00, NULL, NULL, 3840000.00, NULL, 0.00, 3840000.00, '2026-11-23 21:04:44', 'sebastian', 'auto', NULL, NULL, '2026-11-23 21:04:44', 'sebastian', NULL, NULL);
INSERT INTO `penawaran` VALUES (2, 1, '02', 2, 2026, '2026-11-24', 2, 1, 2, 8.00, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":2,\"penawaran_id\":2,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"jumlah_pesanan\":1,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":457000,\"dpp\":4113000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4113000,\"approved_at\":\"2026-11-24 02:19:24\",\"approved_by\":\"sebastian\",\"approved_type\":\"confirm\",\"rejected_at\":null,\"rejected_by\":null,\"retur\":null}]', 1.00, 1.00, 4570000.00, 10.00, 457000.00, 4113000.00, NULL, 0.00, 4113000.00, '2026-11-24 02:19:24', 'sebastian', 'confirm', NULL, NULL, '2026-11-24 02:17:17', 'sebastian', '2026-11-24 02:19:11', 'sebastian');

-- ----------------------------
-- Table structure for penawaran_detail
-- ----------------------------
DROP TABLE IF EXISTS `penawaran_detail`;
CREATE TABLE `penawaran_detail`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `penawaran_id` bigint NULL DEFAULT NULL,
  `barang_id` bigint NULL DEFAULT NULL,
  `jasa_id` bigint NULL DEFAULT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga` decimal(20, 2) NULL DEFAULT NULL,
  `jenis_ppn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga_sebelum_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `jumlah` decimal(20, 2) NULL DEFAULT NULL,
  `jumlah_pesanan` decimal(20, 2) NULL DEFAULT NULL,
  `sub_total` decimal(20, 2) NULL DEFAULT NULL,
  `sub_total_sebelum_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `diskon_item` decimal(20, 2) NULL DEFAULT NULL,
  `diskon_item_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `diskon_faktur` decimal(20, 2) NULL DEFAULT NULL,
  `dpp` decimal(20, 2) NULL DEFAULT NULL,
  `persen_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `nominal_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `total` decimal(20, 2) NULL DEFAULT NULL,
  `approved_at` datetime NULL DEFAULT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approved_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rejected_at` datetime NULL DEFAULT NULL,
  `rejected_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `retur` decimal(20, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penawaran_detail
-- ----------------------------
INSERT INTO `penawaran_detail` VALUES (1, 1, 4, NULL, '001 - AC DAIKIN STC15YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 0,5 PK (5.000 BTU/H)', 'Unit', 3840000.00, 'Belum PPN', 3840000.00, 1.00, NULL, 3840000.00, 3840000.00, 0.00, '[]', 0.00, 3840000.00, 0.00, 0.00, 3840000.00, '2026-11-23 21:04:44', 'sebastian', 'auto', NULL, NULL, NULL);
INSERT INTO `penawaran_detail` VALUES (2, 2, 6, NULL, '001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)', 'Unit', 4570000.00, 'Belum PPN', 4570000.00, 1.00, 1.00, 4570000.00, 4570000.00, 0.00, '[]', 457000.00, 4113000.00, 0.00, 0.00, 4113000.00, '2026-11-24 02:19:24', 'sebastian', 'confirm', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for pengiriman
-- ----------------------------
DROP TABLE IF EXISTS `pengiriman`;
CREATE TABLE `pengiriman`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint NULL DEFAULT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor` int NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `penjualan_id` bigint NULL DEFAULT NULL,
  `jenis_pengiriman` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pengiriman
-- ----------------------------
INSERT INTO `pengiriman` VALUES (1, 1, 'DO', 1, 2026, '2026-11-23', 3, 'Diambil', '[{\"id\":1,\"pengiriman_id\":1,\"penjualan_detail_ditandai_id\":1,\"jumlah\":1}]', '2026-11-24 02:31:09', 'sebastian', NULL, NULL);

-- ----------------------------
-- Table structure for pengiriman_detail
-- ----------------------------
DROP TABLE IF EXISTS `pengiriman_detail`;
CREATE TABLE `pengiriman_detail`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pengiriman_id` bigint NULL DEFAULT NULL,
  `penjualan_detail_ditandai_id` bigint NULL DEFAULT NULL,
  `jumlah` decimal(20, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pengiriman_detail
-- ----------------------------
INSERT INTO `pengiriman_detail` VALUES (1, 1, 1, 1.00);

-- ----------------------------
-- Table structure for penjualan
-- ----------------------------
DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE `penjualan`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint NULL DEFAULT NULL,
  `kode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor` int NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `pesanan_id` bigint NULL DEFAULT NULL,
  `karyawan_id` bigint NULL DEFAULT NULL,
  `batas_waktu_pembayaran` int NULL DEFAULT NULL,
  `tanda_tangan_id` bigint NULL DEFAULT NULL,
  `customer_id` bigint NULL DEFAULT NULL,
  `nama_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_wa_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `credit_limit_customer` decimal(20, 2) NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `sub_total` decimal(20, 2) NULL DEFAULT NULL,
  `persen_diskon` decimal(20, 2) NULL DEFAULT NULL,
  `diskon` decimal(20, 2) NULL DEFAULT NULL,
  `dpp` decimal(20, 2) NULL DEFAULT NULL,
  `persen_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `ppn` decimal(20, 2) NULL DEFAULT NULL,
  `total` decimal(20, 2) NULL DEFAULT NULL,
  `bank_id` bigint NULL DEFAULT NULL,
  `termin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `dibayar` decimal(20, 2) NULL DEFAULT NULL,
  `pembayaran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `approved_at` datetime NULL DEFAULT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approved_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rejected_at` datetime NULL DEFAULT NULL,
  `rejected_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penjualan
-- ----------------------------
INSERT INTO `penjualan` VALUES (3, 1, 'INV', 1, 2026, '2026-11-24', NULL, 1, NULL, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":4,\"penjualan_id\":3,\"pesanan_detail_id\":null,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Non PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":0,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4570000,\"approved_at\":\"2026-11-24 02:29:25\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"jumlah_ditandai\":1,\"jumlah_dikirim\":1,\"ditandai\":[{\"id\":1,\"penjualan_detail_id\":4,\"barang_masuk_detail_id\":2,\"jumlah\":1,\"dikirim\":1}],\"jumlah_retur\":null}]', 4570000.00, NULL, NULL, 0.00, NULL, 0.00, 4570000.00, 1, '[{\"id\":4,\"penjualan_id\":3,\"tanggal\":\"2026-12-01\",\"nominal\":1000000,\"dibayar\":1000000},{\"id\":5,\"penjualan_id\":3,\"tanggal\":\"2026-12-09\",\"nominal\":1000000,\"dibayar\":0},{\"id\":6,\"penjualan_id\":3,\"tanggal\":\"2026-12-16\",\"nominal\":1570000,\"dibayar\":0},{\"id\":7,\"penjualan_id\":3,\"tanggal\":\"2026-11-24\",\"nominal\":1000000,\"dibayar\":null}]', 1000000.00, '[{\"id\":3,\"penjualan_id\":3,\"tanggal\":\"2026-11-24\",\"nominal\":1000000,\"metode_pembayaran_id\":2,\"keterangan\":null,\"created_at\":\"2026-11-24 02:26:42\",\"created_by\":\"sebastian\",\"updated_at\":null,\"updated_by\":null}]', '2026-11-24 02:29:25', 'sebastian', 'auto', NULL, NULL, '2026-11-24 02:26:22', 'sebastian', '2026-11-24 02:29:25', 'sebastian');

-- ----------------------------
-- Table structure for penjualan_detail
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_detail`;
CREATE TABLE `penjualan_detail`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `penjualan_id` bigint NULL DEFAULT NULL,
  `pesanan_detail_id` bigint NULL DEFAULT NULL,
  `barang_id` bigint NULL DEFAULT NULL,
  `jasa_id` bigint NULL DEFAULT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga` decimal(20, 2) NULL DEFAULT NULL,
  `jenis_ppn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga_sebelum_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `jumlah` decimal(20, 2) NULL DEFAULT NULL,
  `sub_total` decimal(20, 2) NULL DEFAULT NULL,
  `sub_total_sebelum_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `diskon_item` decimal(20, 2) NULL DEFAULT NULL,
  `diskon_item_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `diskon_faktur` decimal(20, 2) NULL DEFAULT NULL,
  `dpp` decimal(20, 2) NULL DEFAULT NULL,
  `persen_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `nominal_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `total` decimal(20, 2) NULL DEFAULT NULL,
  `approved_at` datetime NULL DEFAULT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approved_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rejected_at` datetime NULL DEFAULT NULL,
  `rejected_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jumlah_ditandai` decimal(20, 2) NULL DEFAULT NULL,
  `jumlah_dikirim` decimal(20, 2) NULL DEFAULT NULL,
  `ditandai` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `jumlah_retur` decimal(20, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penjualan_detail
-- ----------------------------
INSERT INTO `penjualan_detail` VALUES (4, 3, NULL, 6, NULL, '001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)', 'Unit', 4570000.00, 'Non PPN', 4570000.00, 1.00, 4570000.00, 4570000.00, 0.00, '[]', 0.00, 0.00, 0.00, 0.00, 4570000.00, '2026-11-24 02:29:25', 'sebastian', 'auto', NULL, NULL, 1.00, 1.00, '[{\"id\":1,\"penjualan_detail_id\":4,\"barang_masuk_detail_id\":2,\"jumlah\":1,\"dikirim\":1}]', NULL);

-- ----------------------------
-- Table structure for penjualan_detail_ditandai
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_detail_ditandai`;
CREATE TABLE `penjualan_detail_ditandai`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `penjualan_detail_id` bigint NULL DEFAULT NULL,
  `barang_masuk_detail_id` bigint NULL DEFAULT NULL,
  `jumlah` decimal(20, 2) NULL DEFAULT NULL,
  `dikirim` decimal(20, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penjualan_detail_ditandai
-- ----------------------------
INSERT INTO `penjualan_detail_ditandai` VALUES (1, 4, 2, 1.00, 1.00);

-- ----------------------------
-- Table structure for penjualan_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_pembayaran`;
CREATE TABLE `penjualan_pembayaran`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `penjualan_id` bigint NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `nominal` decimal(20, 2) NULL DEFAULT NULL,
  `metode_pembayaran_id` bigint NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penjualan_pembayaran
-- ----------------------------
INSERT INTO `penjualan_pembayaran` VALUES (3, 3, '2026-11-24', 1000000.00, 2, NULL, '2026-11-24 02:26:42', 'sebastian', NULL, NULL);

-- ----------------------------
-- Table structure for penjualan_termin
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_termin`;
CREATE TABLE `penjualan_termin`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `penjualan_id` bigint NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `nominal` decimal(20, 2) NULL DEFAULT NULL,
  `dibayar` decimal(20, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan_termin
-- ----------------------------
INSERT INTO `penjualan_termin` VALUES (4, 3, '2026-12-01', 1000000.00, 0.00);
INSERT INTO `penjualan_termin` VALUES (5, 3, '2026-12-09', 1000000.00, 0.00);
INSERT INTO `penjualan_termin` VALUES (6, 3, '2026-12-16', 1570000.00, 0.00);
INSERT INTO `penjualan_termin` VALUES (7, 3, '2026-11-24', 1000000.00, 1000000.00);

-- ----------------------------
-- Table structure for perusahaan
-- ----------------------------
DROP TABLE IF EXISTS `perusahaan`;
CREATE TABLE `perusahaan`  (
  `kode_perusahaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_perusahaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of perusahaan
-- ----------------------------
INSERT INTO `perusahaan` VALUES ('MIE', 'PT Mitra Integrasi Engineering');

-- ----------------------------
-- Table structure for pesanan
-- ----------------------------
DROP TABLE IF EXISTS `pesanan`;
CREATE TABLE `pesanan`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cabang_id` bigint NULL DEFAULT NULL,
  `kode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor` int NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `nomor_po` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `batas_waktu` int NULL DEFAULT NULL,
  `karyawan_id` bigint NULL DEFAULT NULL,
  `customer_id` bigint NULL DEFAULT NULL,
  `nama_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_wa_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `credit_limit_customer` decimal(20, 2) NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `jumlah` decimal(20, 2) NULL DEFAULT NULL,
  `jumlah_penjualan` decimal(20, 2) NULL DEFAULT NULL,
  `sub_total` decimal(20, 2) NULL DEFAULT NULL,
  `persen_diskon` decimal(20, 2) NULL DEFAULT NULL,
  `diskon` decimal(20, 2) NULL DEFAULT NULL,
  `dpp` decimal(20, 2) NULL DEFAULT NULL,
  `persen_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `ppn` decimal(20, 2) NULL DEFAULT NULL,
  `total` decimal(20, 2) NULL DEFAULT NULL,
  `approved_at` datetime NULL DEFAULT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approved_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rejected_at` datetime NULL DEFAULT NULL,
  `rejected_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pesanan
-- ----------------------------
INSERT INTO `pesanan` VALUES (1, 1, '01', 1, 2026, '2026-11-23', 'PO1', 8, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":1,\"pesanan_id\":1,\"penawaran_detail_id\":null,\"barang_id\":4,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC15YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 0,5 PK (5.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":3840000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":3840000,\"jumlah\":2,\"jumlah_penjualan\":null,\"sub_total\":7680000,\"sub_total_sebelum_ppn\":7680000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":0,\"dpp\":7680000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":7680000,\"approved_at\":\"2026-11-23 21:27:16\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"retur\":null}]', 2.00, NULL, 7680000.00, NULL, NULL, 7680000.00, NULL, 0.00, 7680000.00, '2026-11-23 21:27:16', 'sebastian', 'auto', NULL, NULL, '2026-11-23 21:27:16', 'sebastian', NULL, NULL);
INSERT INTO `pesanan` VALUES (2, 1, '01', 2, 2026, '2026-11-24', 'PO2', 9, 1, 1, 'Bapak Sumanto', 'Jl. Sidodadi No. 17', '[{\"no_telp_customer\":\"08127127123\"}]', '[{\"no_wa_customer\":\"08127127123\"}]', NULL, 7.00, '[{\"id\":2,\"pesanan_id\":2,\"penawaran_detail_id\":2,\"barang_id\":6,\"jasa_id\":null,\"nama_produk\":\"001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)\",\"satuan\":\"Unit\",\"harga\":4570000,\"jenis_ppn\":\"Belum PPN\",\"harga_sebelum_ppn\":4570000,\"jumlah\":1,\"jumlah_penjualan\":0,\"sub_total\":4570000,\"sub_total_sebelum_ppn\":4570000,\"diskon_item\":0,\"diskon_item_detail\":[],\"diskon_faktur\":457000,\"dpp\":4113000,\"persen_ppn\":0,\"nominal_ppn\":0,\"total\":4113000,\"approved_at\":\"2026-11-24 02:20:16\",\"approved_by\":\"sebastian\",\"approved_type\":\"auto\",\"rejected_at\":null,\"rejected_by\":null,\"retur\":null}]', 1.00, 0.00, 4570000.00, 10.00, 457000.00, 4113000.00, NULL, 0.00, 4113000.00, '2026-11-24 02:20:16', 'sebastian', 'auto', NULL, NULL, '2026-11-24 02:20:16', 'sebastian', NULL, NULL);

-- ----------------------------
-- Table structure for pesanan_detail
-- ----------------------------
DROP TABLE IF EXISTS `pesanan_detail`;
CREATE TABLE `pesanan_detail`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint NULL DEFAULT NULL,
  `penawaran_detail_id` bigint NULL DEFAULT NULL,
  `barang_id` bigint NULL DEFAULT NULL,
  `jasa_id` bigint NULL DEFAULT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga` decimal(20, 2) NULL DEFAULT NULL,
  `jenis_ppn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga_sebelum_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `jumlah` decimal(20, 2) NULL DEFAULT NULL,
  `jumlah_penjualan` decimal(20, 2) NULL DEFAULT NULL,
  `sub_total` decimal(20, 2) NULL DEFAULT NULL,
  `sub_total_sebelum_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `diskon_item` decimal(20, 2) NULL DEFAULT NULL,
  `diskon_item_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `diskon_faktur` decimal(20, 2) NULL DEFAULT NULL,
  `dpp` decimal(20, 2) NULL DEFAULT NULL,
  `persen_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `nominal_ppn` decimal(20, 2) NULL DEFAULT NULL,
  `total` decimal(20, 2) NULL DEFAULT NULL,
  `approved_at` datetime NULL DEFAULT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approved_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rejected_at` datetime NULL DEFAULT NULL,
  `rejected_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `retur` decimal(20, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pesanan_detail
-- ----------------------------
INSERT INTO `pesanan_detail` VALUES (1, 1, NULL, 4, NULL, '001 - AC DAIKIN STC15YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 0,5 PK (5.000 BTU/H)', 'Unit', 3840000.00, 'Belum PPN', 3840000.00, 2.00, NULL, 7680000.00, 7680000.00, 0.00, '[]', 0.00, 7680000.00, 0.00, 0.00, 7680000.00, '2026-11-23 21:27:16', 'sebastian', 'auto', NULL, NULL, NULL);
INSERT INTO `pesanan_detail` VALUES (2, 2, 2, 6, NULL, '001 - AC DAIKIN STC25YV SPLIT WALL MOUNTED SUPER MINI SPLIT (SMS) 1 PK (9.000 BTU/H)', 'Unit', 4570000.00, 'Belum PPN', 4570000.00, 1.00, 0.00, 4570000.00, 4570000.00, 0.00, '[]', 457000.00, 4113000.00, 0.00, 0.00, 4113000.00, '2026-11-24 02:20:16', 'sebastian', 'auto', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for rak
-- ----------------------------
DROP TABLE IF EXISTS `rak`;
CREATE TABLE `rak`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `gudang_id` bigint NULL DEFAULT NULL,
  `nama_rak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `karantina` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of rak
-- ----------------------------
INSERT INTO `rak` VALUES (1, 1, 'Lantai 1', 0);
INSERT INTO `rak` VALUES (2, 1, 'Lantai 2', 0);
INSERT INTO `rak` VALUES (3, 1, 'Lantai 3', 0);

-- ----------------------------
-- Table structure for satuan
-- ----------------------------
DROP TABLE IF EXISTS `satuan`;
CREATE TABLE `satuan`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of satuan
-- ----------------------------
INSERT INTO `satuan` VALUES (1, 'Pcs');
INSERT INTO `satuan` VALUES (2, 'Meter');
INSERT INTO `satuan` VALUES (3, 'Roll');
INSERT INTO `satuan` VALUES (6, 'Unit');
INSERT INTO `satuan` VALUES (7, 'Batang');
INSERT INTO `satuan` VALUES (8, 'Kegiatan');
INSERT INTO `satuan` VALUES (9, 'Set');
INSERT INTO `satuan` VALUES (10, 'Ls');
INSERT INTO `satuan` VALUES (11, 'Lot');

-- ----------------------------
-- Table structure for shift_jam_kerja
-- ----------------------------
DROP TABLE IF EXISTS `shift_jam_kerja`;
CREATE TABLE `shift_jam_kerja`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `jam_kerja_id` int NULL DEFAULT NULL,
  `shift` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jam_masuk` time NULL DEFAULT NULL,
  `jam_pulang` time NULL DEFAULT NULL,
  `senin` int NULL DEFAULT NULL,
  `selasa` int NULL DEFAULT NULL,
  `rabu` int NULL DEFAULT NULL,
  `kamis` int NULL DEFAULT NULL,
  `jumat` int NULL DEFAULT NULL,
  `sabtu` int NULL DEFAULT NULL,
  `minggu` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of shift_jam_kerja
-- ----------------------------
INSERT INTO `shift_jam_kerja` VALUES (3, 1, 'AA', '08:31:00', '13:40:00', 1, 1, 1, 1, 1, 1, 0);

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `jenis_supplier_id` bigint NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `no_wa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES (1, 2, 'Sebarga', 'Jl. AH. Nasution No. 17', '[{\"no_telp\":\"08122281231\"}]', '[{\"no_wa\":\"08122281231\"}]', NULL);

-- ----------------------------
-- Table structure for tanda_tangan
-- ----------------------------
DROP TABLE IF EXISTS `tanda_tangan`;
CREATE TABLE `tanda_tangan`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `tanda_tangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `file_ttd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tanda_tangan
-- ----------------------------
INSERT INTO `tanda_tangan` VALUES (1, 'Berisi', 'VRATIKA', 'DIREKTUR', '20260415114647.png');
INSERT INTO `tanda_tangan` VALUES (2, 'Kosong', 'VRATIKA', 'DIREKTUR', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `users_level_id` int NULL DEFAULT NULL COMMENT '1 = Publik\r\n2 = Admin',
  `cabang_id` bigint NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `karyawan_id` bigint NULL DEFAULT NULL,
  `last_login` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('001', NULL, 2, 1, 'Dedi Wijaya', 'Admin', 1, NULL);
INSERT INTO `users` VALUES ('admin', 'D020BBE760B03D57B3DAFFD56DA97A88', 3, NULL, NULL, NULL, NULL, '2026-05-09 09:42:03');
INSERT INTO `users` VALUES ('emi', 'B8D85278BA64E65A5A42EC6EF3AEF773', 3, NULL, NULL, NULL, NULL, '2026-11-21 19:23:06');
INSERT INTO `users` VALUES ('sebastian', '4EF85E04C537B51F6CE117869B64EE64', 1, NULL, 'Sebastian', NULL, 6, '2026-11-25 14:10:01');
INSERT INTO `users` VALUES ('tasya', '3830DFE131B2B227176795DD6DF39C6916F25D384E066476575F030368625A87', 3, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for users_level
-- ----------------------------
DROP TABLE IF EXISTS `users_level`;
CREATE TABLE `users_level`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users_level
-- ----------------------------
INSERT INTO `users_level` VALUES (1, 'Developer');
INSERT INTO `users_level` VALUES (2, 'Sales');
INSERT INTO `users_level` VALUES (3, 'Admin');

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
