/*
Navicat MySQL Data Transfer

Source Server         : MySQL Local
Source Server Version : 50613
Source Host           : localhost:3306
Source Database       : rendiciones

Target Server Type    : MYSQL
Target Server Version : 50613
File Encoding         : 65001

Date: 2014-05-08 00:52:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `comment`
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `registry_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` longtext COLLATE utf8_unicode_ci,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5BC96BF0126F525E` (`item_id`),
  KEY `IDX_5BC96BF04CB707ED` (`registry_id`),
  KEY `IDX_5BC96BF0A76ED395` (`user_id`),
  CONSTRAINT `FK_5BC96BF0126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  CONSTRAINT `FK_5BC96BF04CB707ED` FOREIGN KEY (`registry_id`) REFERENCES `registry` (`id`),
  CONSTRAINT `FK_5BC96BF0A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of comment
-- ----------------------------
INSERT INTO `comment` VALUES ('2', null, '7', '1', 'Hola mundo!', '2014-04-22 23:38:42', '2014-04-22 23:38:42', '1');
INSERT INTO `comment` VALUES ('3', null, '7', '1', 'Hola mundo 2', '2014-04-22 23:40:15', '2014-04-22 23:40:15', '1');
INSERT INTO `comment` VALUES ('6', null, '9', '1', 'Testin', '2014-04-23 21:49:21', '2014-04-23 21:49:21', '1');
INSERT INTO `comment` VALUES ('7', null, '10', '1', 'Cerrada hoy', '2014-04-29 22:29:43', '2014-04-29 22:29:43', '1');

-- ----------------------------
-- Table structure for `document`
-- ----------------------------
DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of document
-- ----------------------------
INSERT INTO `document` VALUES ('1', 'Boleta', '');
INSERT INTO `document` VALUES ('2', 'Factura', '');

-- ----------------------------
-- Table structure for `ext_log_entries`
-- ----------------------------
DROP TABLE IF EXISTS `ext_log_entries`;
CREATE TABLE `ext_log_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `logged_at` datetime NOT NULL,
  `object_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` int(11) NOT NULL,
  `data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_class_lookup_idx` (`object_class`),
  KEY `log_date_lookup_idx` (`logged_at`),
  KEY `log_user_lookup_idx` (`username`),
  KEY `log_version_lookup_idx` (`object_id`,`object_class`,`version`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ext_log_entries
-- ----------------------------
INSERT INTO `ext_log_entries` VALUES ('1', 'update', '2014-05-08 00:52:50', '7', 'Registry\\Entity\\Registry', '1', 'a:2:{s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-08 00:52:47\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Anguilla\";}}', null);

-- ----------------------------
-- Table structure for `file`
-- ----------------------------
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mimeType` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` decimal(10,0) DEFAULT NULL,
  `itemId` int(11) DEFAULT NULL,
  `registryId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2CAD992EB5F8B771` (`itemId`),
  KEY `IDX_2CAD992EB3540A09` (`registryId`),
  CONSTRAINT `FK_8C9F3610B3540A09` FOREIGN KEY (`registryId`) REFERENCES `registry` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_8C9F3610B5F8B771` FOREIGN KEY (`itemId`) REFERENCES `item` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of file
-- ----------------------------
INSERT INTO `file` VALUES ('1', 'C:\\htdocs\\rendiciones\\data\\uploads/60ca8b6606c9753118e25486ab2cecea5ef542e5.jpg', '60ca8b6606c9753118e25486ab2cecea5ef542e5.jpg', 'image/jpeg', '13052', null, null);
INSERT INTO `file` VALUES ('2', 'C:\\htdocs\\rendiciones\\data\\uploads/8178077613163f13aacfeeb83d3d0a2bbdb5d0c4.jpg', '8178077613163f13aacfeeb83d3d0a2bbdb5d0c4.jpg', 'image/jpeg', '13052', '2', '7');
INSERT INTO `file` VALUES ('3', 'C:\\htdocs\\rendiciones\\data\\uploads/530e247d3cef793a69f004c60e82cb8d6f4196e0.jpg', '530e247d3cef793a69f004c60e82cb8d6f4196e0.jpg', 'image/jpeg', '13052', '2', '7');
INSERT INTO `file` VALUES ('4', 'C:\\htdocs\\rendiciones\\data\\uploads/111d014ba32ea866c2080dd35c8b7965b8caa87f.jpg', '111d014ba32ea866c2080dd35c8b7965b8caa87f.jpg', 'image/jpeg', '13052', '5', '7');
INSERT INTO `file` VALUES ('5', 'C:\\htdocs\\rendiciones\\data\\uploads/79c74864e08edcc43068bb060764e06d4d36b586.jpg', '79c74864e08edcc43068bb060764e06d4d36b586.jpg', 'image/jpeg', '13052', '2', '7');
INSERT INTO `file` VALUES ('6', 'C:\\htdocs\\rendiciones\\data\\uploads/02958b76c38811725339d31b15097b71f66f6a8a.jpg', '02958b76c38811725339d31b15097b71f66f6a8a.jpg', 'image/jpeg', '13052', '5', '7');
INSERT INTO `file` VALUES ('15', 'C:\\htdocs\\rendiciones\\data\\uploads/1e47319a8e73267ed9d490f21f3848e25b844dad.jpg', '1e47319a8e73267ed9d490f21f3848e25b844dad.jpg', 'image/jpeg', '13052', '4', '9');
INSERT INTO `file` VALUES ('16', 'C:\\htdocs\\rendiciones\\data\\uploads/7091474dff6c4de8cc72b577e85db149d2cf9058.jpg', '7091474dff6c4de8cc72b577e85db149d2cf9058.jpg', 'image/jpeg', '13052', '3', '8');
INSERT INTO `file` VALUES ('17', 'C:\\htdocs\\rendiciones\\data\\uploads/fd879a30198ba779feb08c93eabc105d70c140cf.jpg', 'fd879a30198ba779feb08c93eabc105d70c140cf.jpg', 'image/jpeg', '239006', '6', '10');
INSERT INTO `file` VALUES ('18', 'C:\\htdocs\\rendiciones\\data\\uploads/3c64b02220843b27d5661715e16a0e1209ad481d.jpg', '3c64b02220843b27d5661715e16a0e1209ad481d.jpg', 'image/jpeg', '28896', '7', '11');

-- ----------------------------
-- Table structure for `item`
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registry_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `item_number` int(11) DEFAULT NULL,
  `item_identifier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_date` date DEFAULT NULL,
  `item_gross` double DEFAULT NULL,
  `item_vat` double DEFAULT NULL,
  `item_total` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BF298A204CB707ED` (`registry_id`),
  KEY `IDX_BF298A20C33F7837` (`document_id`),
  KEY `IDX_BF298A2025F94802` (`modified_by`),
  CONSTRAINT `FK_1F1B251E4CB707ED` FOREIGN KEY (`registry_id`) REFERENCES `registry` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_BF298A2025F94802` FOREIGN KEY (`modified_by`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_BF298A20C33F7837` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('2', '7', '1', '1', '', '2014-04-15 02:05:09', '2014-05-08 00:51:53', '1', '123124', '156480126', '', '2014-04-17', '0', '0', '23123');
INSERT INTO `item` VALUES ('3', '8', '1', '1', '', '2014-04-15 02:09:37', '2014-04-23 23:27:24', '1', '23456', '156480126', '', '2014-04-25', '0', '0', '2132');
INSERT INTO `item` VALUES ('4', '9', '1', '1', '', '2014-04-15 02:10:36', '2014-04-23 21:53:48', '2', '76543', '156480126', '', '2014-04-10', '0', '0', '76543');
INSERT INTO `item` VALUES ('5', '7', '1', '1', 'Descripcion de muestra', '2014-04-16 18:04:28', '2014-05-08 00:51:53', '1', '765432', '156480126', '', '2014-04-11', '0', '0', '34532');
INSERT INTO `item` VALUES ('6', '10', '1', '2', 'Test', '2014-04-29 13:57:26', '2014-05-01 22:21:01', '2', '12345678', '66430510', 'La boleta', '2014-04-22', '0', '0', '2432433');
INSERT INTO `item` VALUES ('7', '11', '1', '2', '', '2014-05-01 21:58:25', '2014-05-01 22:11:49', '1', '4214342', '66572145', 'sdasda', '2014-05-21', '0', '0', '42234');

-- ----------------------------
-- Table structure for `moderatorgrouplinker`
-- ----------------------------
DROP TABLE IF EXISTS `moderatorgrouplinker`;
CREATE TABLE `moderatorgrouplinker` (
  `moderator_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`moderator_id`,`group_id`),
  KEY `IDX_B636C79ED0AFA354` (`moderator_id`),
  KEY `IDX_B636C79EFE54D947` (`group_id`),
  CONSTRAINT `FK_B636C79ED0AFA354` FOREIGN KEY (`moderator_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B636C79EFE54D947` FOREIGN KEY (`group_id`) REFERENCES `usergroup` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of moderatorgrouplinker
-- ----------------------------
INSERT INTO `moderatorgrouplinker` VALUES ('2', '1');
INSERT INTO `moderatorgrouplinker` VALUES ('2', '6');

-- ----------------------------
-- Table structure for `registry`
-- ----------------------------
DROP TABLE IF EXISTS `registry`;
CREATE TABLE `registry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_34DE7F5CA76ED395` (`user_id`),
  KEY `IDX_34DE7F5C25F94802` (`modified_by`),
  CONSTRAINT `FK_34DE7F5C25F94802` FOREIGN KEY (`modified_by`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_34DE7F5CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of registry
-- ----------------------------
INSERT INTO `registry` VALUES ('7', '1', '1', 'Holi', '2014-04-20 17:21:43', '2014-05-08 00:52:47', '1', '1');
INSERT INTO `registry` VALUES ('8', '1', '1', '', '2014-04-23 23:19:46', '2014-04-23 23:27:28', '2', '3');
INSERT INTO `registry` VALUES ('9', '1', '1', '', '2014-04-23 19:38:43', '2014-04-23 22:18:53', '3', '2');
INSERT INTO `registry` VALUES ('10', '2', '2', '', '2014-04-29 13:57:46', '2014-05-01 22:21:07', '4', '1');
INSERT INTO `registry` VALUES ('11', '3', '2', '', '2014-05-01 21:58:29', '2014-05-01 22:11:51', '2', '1');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `identity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `credential` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `work_phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `options` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `hash` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2DA179776A95E9C4` (`identity`),
  KEY `IDX_8D93D649FE54D947` (`group_id`),
  CONSTRAINT `FK_8D93D649FE54D947` FOREIGN KEY (`group_id`) REFERENCES `usergroup` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'Jean Rumeau', '156480126', '$2y$14$MH9F4e4L/05JyVhDP3z5JeY0GtUKnnI657zDpUp3x0PTfSTtb7Djy', 'rumeau@gmail.com', null, null, null, null, 'N;', '2014-04-04 16:33:23', '2014-05-08 00:47:29', '1', null, '1');
INSERT INTO `user` VALUES ('2', 'Jean Paul', '66572145', '$2y$14$MH9F4e4L/05JyVhDP3z5JeY0GtUKnnI657zDpUp3x0PTfSTtb7Djy', 'jean.rumeau@jprumeau.com', '', '', '', '', 'N;', '2014-04-27 23:57:40', '2014-05-08 00:47:29', '1', null, '6');
INSERT INTO `user` VALUES ('3', 'Test', '66430510', '$2y$14$MH9F4e4L/05JyVhDP3z5JeY0GtUKnnI657zDpUp3x0PTfSTtb7Djy', 'f_insane@hotmail.com', '', '', '', '', 'N;', '2014-05-01 21:55:44', '2014-05-08 00:19:39', '1', null, '6');

-- ----------------------------
-- Table structure for `usergroup`
-- ----------------------------
DROP TABLE IF EXISTS `usergroup`;
CREATE TABLE `usergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `status` int(11) NOT NULL,
  `is_default` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of usergroup
-- ----------------------------
INSERT INTO `usergroup` VALUES ('1', 'Default', 'Grupo por defecto', '1', '1');
INSERT INTO `usergroup` VALUES ('6', 'Gerentes', '', '1', '0');
INSERT INTO `usergroup` VALUES ('8', 'Test', '', '1', '0');

-- ----------------------------
-- Table structure for `userrole`
-- ----------------------------
DROP TABLE IF EXISTS `userrole`;
CREATE TABLE `userrole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `role_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_role` (`role_id`),
  UNIQUE KEY `UNIQ_A8503F73727ACA70` (`parent_id`),
  CONSTRAINT `FK_A8503F73727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `userrole` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of userrole
-- ----------------------------
INSERT INTO `userrole` VALUES ('1', null, 'guest', '1');
INSERT INTO `userrole` VALUES ('2', '1', 'user', '0');
INSERT INTO `userrole` VALUES ('3', '2', 'moderator', '0');
INSERT INTO `userrole` VALUES ('4', '3', 'administrator', '0');

-- ----------------------------
-- Table structure for `userrolelinker`
-- ----------------------------
DROP TABLE IF EXISTS `userrolelinker`;
CREATE TABLE `userrolelinker` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_D62106C9A76ED395` (`user_id`),
  KEY `IDX_D62106C9D60322AC` (`role_id`),
  CONSTRAINT `FK_D62106C9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_D62106C9D60322AC` FOREIGN KEY (`role_id`) REFERENCES `userrole` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of userrolelinker
-- ----------------------------
INSERT INTO `userrolelinker` VALUES ('1', '2');
INSERT INTO `userrolelinker` VALUES ('1', '3');
INSERT INTO `userrolelinker` VALUES ('1', '4');
INSERT INTO `userrolelinker` VALUES ('2', '1');
INSERT INTO `userrolelinker` VALUES ('2', '2');
INSERT INTO `userrolelinker` VALUES ('2', '3');
INSERT INTO `userrolelinker` VALUES ('3', '1');
INSERT INTO `userrolelinker` VALUES ('3', '2');

-- ----------------------------
-- Function structure for `newRegistryNumber`
-- ----------------------------
DROP FUNCTION IF EXISTS `newRegistryNumber`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `newRegistryNumber`(`registry_id` int) RETURNS int(11)
BEGIN
	DECLARE nextnumber INT;

	SELECT MAX(number) + 1 INTO nextnumber FROM registry WHERE id = registry_id;

	RETURN nextnumber;
END
;;
DELIMITER ;
