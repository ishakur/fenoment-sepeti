/*
 Navicat MySQL Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100424 (10.4.24-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : fenocity

 Target Server Type    : MySQL
 Target Server Version : 100424 (10.4.24-MariaDB)
 File Encoding         : 65001

 Date: 12/10/2022 15:24:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for adcategories
-- ----------------------------
DROP TABLE IF EXISTS `adcategories`;
CREATE TABLE `adcategories`  (
                                 `categoryID` int UNSIGNED NOT NULL AUTO_INCREMENT,
                                 `categoryName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                 PRIMARY KEY (`categoryID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of adcategories
-- ----------------------------

-- ----------------------------
-- Table structure for agencies
-- ----------------------------
DROP TABLE IF EXISTS `agencies`;
CREATE TABLE `agencies`  (
                             `agencyID` int UNSIGNED NOT NULL AUTO_INCREMENT,
                             `fullName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                             `taxNumber` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                             PRIMARY KEY (`agencyID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of agencies
-- ----------------------------

-- ----------------------------
-- Table structure for influencers
-- ----------------------------
DROP TABLE IF EXISTS `influencers`;
CREATE TABLE `influencers`  (
                                `infID` int UNSIGNED NOT NULL AUTO_INCREMENT,
                                `fullName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                `userName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                `followerCount` int UNSIGNED NOT NULL DEFAULT 0,
                                `followingCount` int UNSIGNED NOT NULL DEFAULT 0,
                                `mediaCount` int UNSIGNED NOT NULL DEFAULT 0,
                                `avarageLikeCount` int UNSIGNED NOT NULL DEFAULT 0,
                                `avarageViewCount` int UNSIGNED NOT NULL DEFAULT 0,
                                `profilePhoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                `bannerPhoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                `categoryType` enum('1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '1=Instagram,\r\n2=Tiktok',
                                `fenocityPoint` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00,
                                `fenocitySaleCount` int UNSIGNED NOT NULL DEFAULT 0,
                                `loginKey` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                `loginKeyLastDate` timestamp NULL DEFAULT NULL,
                                `bioVerifyCode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                `infVerify` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Sosyal medya profiline kod ekleme onayÄ±\r\n\r\n0=OnaysÄ±z\r\n1=OnaylÄ±\r\n',
                                `statsVerify` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'PaylaÅŸÄ±m istatistiklerinin manuel onayÄ±\r\n\r\n0=OnaysÄ±z,\r\n1=OnaylÄ±',
                                `socialVerify` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Sosyal medya profilinin mavi tikli olma durumu\r\n\r\n0=OnaysÄ±z,\r\n1=OnaylÄ±',
                                `addedDate` timestamp NOT NULL DEFAULT current_timestamp,
                                `taxPayer` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '0=Vergi mÃ¼kellefi deÄŸilim\r\n1=Vergi mÃ¼kellefiyim',
                                `hasAgency` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '0=Ajansa kayıtlı değil,\r\n1=Ajansa kayıtlı',
                                PRIMARY KEY (`infID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of influencers
-- ----------------------------

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
                           `orderID` int UNSIGNED NOT NULL AUTO_INCREMENT,
                           `userID` int NOT NULL,
                           `priceID` int NOT NULL,
                           `createdDate` timestamp NULL DEFAULT NULL,
                           `endDate` timestamp NULL DEFAULT NULL,
                           `state` enum('1','2','3','4','5','6') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '1=Onay Bekliyor,\r\n2=Onaylanmadı,\r\n3=Onaylandı,\r\n4=İşlemde,\r\n5=Başarılı,\r\n6=Başarısız,',
                           PRIMARY KEY (`orderID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for prices
-- ----------------------------
DROP TABLE IF EXISTS `prices`;
CREATE TABLE `prices`  (
                           `priceID` int UNSIGNED NOT NULL AUTO_INCREMENT,
                           `infD` int NOT NULL,
                           `categoryID` int NOT NULL,
                           `price` decimal(10, 2) NOT NULL,
                           PRIMARY KEY (`priceID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of prices
-- ----------------------------

-- ----------------------------
-- Table structure for statistics
-- ----------------------------
DROP TABLE IF EXISTS `statistics`;
CREATE TABLE `statistics`  (
                               `statiscticID` int UNSIGNED NOT NULL AUTO_INCREMENT,
                               `infID` int NOT NULL,
                               `storyViewCount` int NULL DEFAULT NULL,
                               `reachedAccountCount` int NULL DEFAULT NULL COMMENT 'erişilen hesaplar',
                               `enagagedAccountCount` int NULL DEFAULT NULL COMMENT 'etkileşime girilen hesaplar',
                               `saveCount` int NULL DEFAULT NULL COMMENT 'kaydedilmeler',
                               `shareCount` int NULL DEFAULT NULL,
                               PRIMARY KEY (`statiscticID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of statistics
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
                          `userID` int UNSIGNED NOT NULL AUTO_INCREMENT,
                          `nameSurname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                          `userName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                          `eMail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                          `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                          `phoneNumber` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                          `profilePhoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                          `userType` enum('0','1','2','3','4') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '0=Yasakli Uye,\r\n1=Reklam Veren,\r\n2=Kurumsal Reklam Veren,\r\n3=Influencer,\r\n4=Ajans',
                          `eMailVerify` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                          `phoneVerify` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                          `eMailVerifyKey` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                          `phoneVerifyKey` int UNSIGNED NULL DEFAULT NULL,
                          `secretKey` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                          `balance` decimal(10, 2) UNSIGNED NULL DEFAULT 0.00,
                          `lastLoginDate` timestamp NULL DEFAULT current_timestamp,
                          `registerDate` timestamp NULL DEFAULT current_timestamp,
                          PRIMARY KEY (`userID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
