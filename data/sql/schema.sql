/*
Navicat MySQL Data Transfer

Source Server         : MySQL Local
Source Server Version : 50613
Source Host           : localhost:3306
Source Database       : rendiciones

Target Server Type    : MYSQL
Target Server Version : 50613
File Encoding         : 65001

Date: 2014-05-06 01:35:33
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=550 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ext_log_entries
-- ----------------------------
INSERT INTO `ext_log_entries` VALUES ('1', 'create', '2014-05-05 18:02:46', '78', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 18:02:45\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('2', 'create', '2014-05-05 18:02:46', '74', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('3', 'remove', '2014-05-05 18:02:46', '74', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('4', 'remove', '2014-05-05 18:02:46', '78', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('5', 'create', '2014-05-05 18:02:46', '79', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 18:02:46\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('6', 'create', '2014-05-05 18:02:46', '75', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('7', 'update', '2014-05-05 18:02:47', '79', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 18:02:47\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('8', 'update', '2014-05-05 18:02:47', '79', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 18:02:47\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('9', 'update', '2014-05-05 18:02:48', '79', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 18:02:48\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('10', 'update', '2014-05-05 18:02:48', '79', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 18:02:48\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('11', 'remove', '2014-05-05 18:02:48', '75', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('12', 'remove', '2014-05-05 18:02:48', '79', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('13', 'create', '2014-05-05 19:09:21', '80', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 19:09:20\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('14', 'create', '2014-05-05 19:09:21', '76', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('15', 'remove', '2014-05-05 19:09:21', '76', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('16', 'remove', '2014-05-05 19:09:21', '80', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('17', 'create', '2014-05-05 19:09:21', '81', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 19:09:21\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('18', 'create', '2014-05-05 19:09:21', '77', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('19', 'update', '2014-05-05 19:09:22', '81', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 19:09:22\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('20', 'update', '2014-05-05 19:09:22', '81', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 19:09:22\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('21', 'update', '2014-05-05 19:09:23', '81', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 19:09:23\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('22', 'update', '2014-05-05 19:09:23', '81', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 19:09:23\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('23', 'remove', '2014-05-05 19:09:24', '77', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('24', 'remove', '2014-05-05 19:09:24', '81', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('25', 'create', '2014-05-05 22:05:26', '82', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:05:26\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('26', 'create', '2014-05-05 22:05:26', '78', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('27', 'remove', '2014-05-05 22:05:26', '78', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('28', 'remove', '2014-05-05 22:05:26', '82', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('29', 'create', '2014-05-05 22:05:26', '83', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:05:26\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('30', 'create', '2014-05-05 22:05:26', '79', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('31', 'update', '2014-05-05 22:05:27', '83', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:05:27\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('32', 'update', '2014-05-05 22:05:27', '83', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:05:27\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('33', 'update', '2014-05-05 22:05:28', '83', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:05:28\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('34', 'update', '2014-05-05 22:05:28', '83', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:05:28\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('35', 'remove', '2014-05-05 22:05:28', '79', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('36', 'remove', '2014-05-05 22:05:28', '83', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('37', 'create', '2014-05-05 22:05:49', '84', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:05:49\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('38', 'create', '2014-05-05 22:05:49', '80', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('39', 'remove', '2014-05-05 22:05:49', '80', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('40', 'remove', '2014-05-05 22:05:49', '84', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('41', 'create', '2014-05-05 22:05:50', '85', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:05:50\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('42', 'create', '2014-05-05 22:05:50', '81', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('43', 'update', '2014-05-05 22:05:50', '85', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:05:50\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('44', 'update', '2014-05-05 22:05:50', '85', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:05:50\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('45', 'update', '2014-05-05 22:05:51', '85', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:05:51\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('46', 'update', '2014-05-05 22:05:51', '85', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:05:51\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('47', 'remove', '2014-05-05 22:05:52', '81', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('48', 'remove', '2014-05-05 22:05:52', '85', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('49', 'create', '2014-05-05 22:07:08', '86', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:07:08\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('50', 'create', '2014-05-05 22:07:08', '82', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('51', 'remove', '2014-05-05 22:07:08', '82', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('52', 'remove', '2014-05-05 22:07:08', '86', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('53', 'create', '2014-05-05 22:07:08', '87', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:07:08\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('54', 'create', '2014-05-05 22:07:08', '83', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('55', 'update', '2014-05-05 22:07:09', '87', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:07:09\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('56', 'update', '2014-05-05 22:07:09', '87', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:07:09\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('57', 'update', '2014-05-05 22:07:09', '87', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:07:09\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('58', 'update', '2014-05-05 22:07:10', '87', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:07:10\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('59', 'remove', '2014-05-05 22:07:10', '83', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('60', 'remove', '2014-05-05 22:07:10', '87', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('61', 'create', '2014-05-05 22:20:21', '88', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:20:21\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('62', 'create', '2014-05-05 22:20:21', '84', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('63', 'remove', '2014-05-05 22:20:21', '84', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('64', 'remove', '2014-05-05 22:20:21', '88', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('65', 'create', '2014-05-05 22:20:22', '89', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:20:22\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('66', 'create', '2014-05-05 22:20:22', '85', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('67', 'update', '2014-05-05 22:20:22', '89', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:20:22\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('68', 'update', '2014-05-05 22:20:22', '89', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:20:22\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('69', 'remove', '2014-05-05 22:20:23', '85', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('70', 'remove', '2014-05-05 22:20:23', '89', 'Registry\\Entity\\Registry', '4', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('71', 'create', '2014-05-05 22:20:23', '89', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:20:22\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('72', 'create', '2014-05-05 22:20:23', '85', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";s:1:\"1\";}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('73', 'remove', '2014-05-05 22:20:24', '86', 'Registry\\Entity\\Item', '1', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('74', 'remove', '2014-05-05 22:20:24', '90', 'Registry\\Entity\\Registry', '1', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('75', 'create', '2014-05-05 22:22:37', '91', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:22:37\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('76', 'create', '2014-05-05 22:22:37', '87', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('77', 'remove', '2014-05-05 22:22:37', '87', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('78', 'remove', '2014-05-05 22:22:37', '91', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('79', 'create', '2014-05-05 22:22:37', '92', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:22:37\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('80', 'create', '2014-05-05 22:22:37', '88', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('81', 'update', '2014-05-05 22:22:38', '92', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:22:38\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('82', 'update', '2014-05-05 22:22:38', '92', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:22:38\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('83', 'update', '2014-05-05 22:22:39', '92', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:22:39\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('84', 'update', '2014-05-05 22:22:39', '92', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:22:39\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('85', 'remove', '2014-05-05 22:22:39', '88', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('86', 'remove', '2014-05-05 22:22:39', '92', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('87', 'create', '2014-05-05 22:46:43', '93', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:46:43\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('88', 'create', '2014-05-05 22:46:43', '89', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('89', 'remove', '2014-05-05 22:46:43', '89', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('90', 'remove', '2014-05-05 22:46:43', '93', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('91', 'create', '2014-05-05 22:46:43', '94', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:46:43\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('92', 'create', '2014-05-05 22:46:43', '90', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('93', 'update', '2014-05-05 22:46:44', '94', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:46:44\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('94', 'update', '2014-05-05 22:46:44', '94', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:46:44\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('95', 'update', '2014-05-05 22:46:45', '94', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:46:45\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('96', 'update', '2014-05-05 22:46:45', '94', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:46:45\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('97', 'remove', '2014-05-05 22:46:45', '90', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('98', 'remove', '2014-05-05 22:46:45', '94', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('99', 'create', '2014-05-05 22:47:57', '95', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:47:57\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('100', 'create', '2014-05-05 22:47:57', '91', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('101', 'remove', '2014-05-05 22:47:57', '91', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('102', 'remove', '2014-05-05 22:47:57', '95', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('103', 'create', '2014-05-05 22:47:58', '96', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:47:58\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('104', 'create', '2014-05-05 22:47:58', '92', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('105', 'update', '2014-05-05 22:47:58', '96', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:47:58\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('106', 'update', '2014-05-05 22:47:58', '96', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:47:58\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('107', 'update', '2014-05-05 22:47:59', '96', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:47:59\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('108', 'update', '2014-05-05 22:47:59', '96', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:47:59\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('109', 'remove', '2014-05-05 22:48:00', '92', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('110', 'remove', '2014-05-05 22:48:00', '96', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('111', 'create', '2014-05-05 22:50:40', '97', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:50:40\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('112', 'create', '2014-05-05 22:50:40', '93', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('113', 'remove', '2014-05-05 22:50:40', '93', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('114', 'remove', '2014-05-05 22:50:40', '97', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('115', 'create', '2014-05-05 22:50:41', '98', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:50:41\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('116', 'create', '2014-05-05 22:50:41', '94', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('117', 'update', '2014-05-05 22:50:41', '98', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:50:41\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('118', 'update', '2014-05-05 22:50:41', '98', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:50:41\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('119', 'update', '2014-05-05 22:50:42', '98', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:50:42\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('120', 'update', '2014-05-05 22:50:42', '98', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 22:50:42\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('121', 'remove', '2014-05-05 22:50:43', '94', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('122', 'remove', '2014-05-05 22:50:43', '98', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('123', 'create', '2014-05-05 23:02:57', '99', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:02:57\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('124', 'create', '2014-05-05 23:02:57', '95', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('125', 'remove', '2014-05-05 23:02:58', '95', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('126', 'remove', '2014-05-05 23:02:58', '99', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('127', 'create', '2014-05-05 23:02:58', '100', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:02:58\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('128', 'create', '2014-05-05 23:02:58', '96', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('129', 'update', '2014-05-05 23:02:59', '100', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:02:58\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('130', 'update', '2014-05-05 23:02:59', '100', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:02:59\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('131', 'update', '2014-05-05 23:02:59', '100', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:02:59\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('132', 'update', '2014-05-05 23:02:59', '100', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:02:59\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('133', 'remove', '2014-05-05 23:03:00', '96', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('134', 'remove', '2014-05-05 23:03:00', '100', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('135', 'create', '2014-05-05 23:05:16', '101', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:05:16\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('136', 'create', '2014-05-05 23:05:16', '97', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('137', 'remove', '2014-05-05 23:05:17', '97', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('138', 'remove', '2014-05-05 23:05:17', '101', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('139', 'create', '2014-05-05 23:05:17', '102', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:05:17\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('140', 'create', '2014-05-05 23:05:17', '98', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('141', 'update', '2014-05-05 23:05:17', '102', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:05:17\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('142', 'update', '2014-05-05 23:05:17', '102', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:05:17\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('143', 'update', '2014-05-05 23:05:18', '102', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:05:18\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('144', 'update', '2014-05-05 23:05:18', '102', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:05:18\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('145', 'remove', '2014-05-05 23:05:19', '98', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('146', 'remove', '2014-05-05 23:05:19', '102', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('147', 'create', '2014-05-05 23:06:43', '103', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:06:43\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('148', 'create', '2014-05-05 23:06:43', '99', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('149', 'remove', '2014-05-05 23:06:44', '99', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('150', 'remove', '2014-05-05 23:06:44', '103', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('151', 'create', '2014-05-05 23:06:44', '104', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:06:44\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('152', 'create', '2014-05-05 23:06:44', '100', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('153', 'update', '2014-05-05 23:06:44', '104', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:06:44\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('154', 'update', '2014-05-05 23:06:44', '104', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:06:44\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('155', 'update', '2014-05-05 23:06:45', '104', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:06:45\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('156', 'update', '2014-05-05 23:06:45', '104', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:06:45\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('157', 'remove', '2014-05-05 23:06:46', '100', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('158', 'remove', '2014-05-05 23:06:46', '104', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('159', 'create', '2014-05-05 23:07:25', '105', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:07:25\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('160', 'create', '2014-05-05 23:07:25', '101', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('161', 'remove', '2014-05-05 23:07:26', '101', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('162', 'remove', '2014-05-05 23:07:26', '105', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('163', 'create', '2014-05-05 23:07:26', '106', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:07:26\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('164', 'create', '2014-05-05 23:07:26', '102', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('165', 'update', '2014-05-05 23:07:27', '106', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:07:27\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('166', 'update', '2014-05-05 23:07:27', '106', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:07:27\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('167', 'update', '2014-05-05 23:07:27', '106', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:07:27\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('168', 'update', '2014-05-05 23:07:27', '106', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:07:27\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('169', 'remove', '2014-05-05 23:07:28', '102', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('170', 'remove', '2014-05-05 23:07:28', '106', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('171', 'create', '2014-05-05 23:08:32', '107', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:08:32\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('172', 'create', '2014-05-05 23:08:32', '103', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('173', 'remove', '2014-05-05 23:08:32', '103', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('174', 'remove', '2014-05-05 23:08:32', '107', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('175', 'create', '2014-05-05 23:08:33', '108', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:08:33\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('176', 'create', '2014-05-05 23:08:33', '104', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('177', 'update', '2014-05-05 23:08:33', '108', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:08:33\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('178', 'update', '2014-05-05 23:08:33', '108', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:08:33\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('179', 'update', '2014-05-05 23:08:34', '108', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:08:34\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('180', 'update', '2014-05-05 23:08:34', '108', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:08:34\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('181', 'remove', '2014-05-05 23:08:35', '104', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('182', 'remove', '2014-05-05 23:08:35', '108', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('183', 'create', '2014-05-05 23:11:09', '109', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:11:09\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('184', 'create', '2014-05-05 23:11:09', '105', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('185', 'remove', '2014-05-05 23:11:09', '105', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('186', 'remove', '2014-05-05 23:11:09', '109', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('187', 'create', '2014-05-05 23:11:09', '110', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:11:09\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('188', 'create', '2014-05-05 23:11:09', '106', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('189', 'update', '2014-05-05 23:11:10', '110', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:11:10\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('190', 'update', '2014-05-05 23:11:10', '110', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:11:10\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('191', 'update', '2014-05-05 23:11:11', '110', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:11:11\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('192', 'update', '2014-05-05 23:11:11', '110', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:11:11\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('193', 'remove', '2014-05-05 23:11:11', '106', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('194', 'remove', '2014-05-05 23:11:11', '110', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('195', 'create', '2014-05-05 23:23:03', '111', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:23:03\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('196', 'create', '2014-05-05 23:23:03', '107', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('197', 'remove', '2014-05-05 23:23:03', '107', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('198', 'remove', '2014-05-05 23:23:03', '111', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('199', 'create', '2014-05-05 23:23:04', '112', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:23:04\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('200', 'create', '2014-05-05 23:23:04', '108', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('201', 'update', '2014-05-05 23:23:04', '112', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:23:04\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('202', 'update', '2014-05-05 23:23:04', '112', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:23:04\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('203', 'update', '2014-05-05 23:23:05', '112', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:23:05\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('204', 'update', '2014-05-05 23:23:05', '112', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:23:05\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('205', 'remove', '2014-05-05 23:23:06', '108', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('206', 'remove', '2014-05-05 23:23:06', '112', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('207', 'create', '2014-05-05 23:58:48', '113', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:58:48\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('208', 'create', '2014-05-05 23:58:48', '109', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('209', 'remove', '2014-05-05 23:58:48', '109', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('210', 'remove', '2014-05-05 23:58:48', '113', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('211', 'create', '2014-05-05 23:58:48', '114', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:58:48\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('212', 'create', '2014-05-05 23:58:48', '110', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('213', 'update', '2014-05-05 23:58:49', '114', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:58:49\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('214', 'update', '2014-05-05 23:58:49', '114', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:58:49\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('215', 'update', '2014-05-05 23:58:50', '114', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:58:50\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('216', 'update', '2014-05-05 23:58:50', '114', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-05 23:58:50\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('217', 'remove', '2014-05-05 23:58:50', '110', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('218', 'remove', '2014-05-05 23:58:50', '114', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('219', 'create', '2014-05-06 00:09:19', '115', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:09:19\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('220', 'create', '2014-05-06 00:09:19', '111', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('221', 'remove', '2014-05-06 00:09:19', '111', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('222', 'remove', '2014-05-06 00:09:19', '115', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('223', 'create', '2014-05-06 00:09:20', '116', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:09:20\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('224', 'create', '2014-05-06 00:09:20', '112', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('225', 'update', '2014-05-06 00:09:20', '116', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:09:20\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('226', 'update', '2014-05-06 00:09:20', '116', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:09:20\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('227', 'update', '2014-05-06 00:09:21', '116', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:09:21\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('228', 'update', '2014-05-06 00:09:21', '116', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:09:21\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('229', 'remove', '2014-05-06 00:09:22', '112', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('230', 'remove', '2014-05-06 00:09:22', '116', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('231', 'create', '2014-05-06 00:12:08', '117', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:12:08\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('232', 'create', '2014-05-06 00:12:08', '113', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('233', 'remove', '2014-05-06 00:12:08', '113', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('234', 'remove', '2014-05-06 00:12:08', '117', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('235', 'create', '2014-05-06 00:12:09', '118', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:12:09\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('236', 'create', '2014-05-06 00:12:09', '114', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('237', 'update', '2014-05-06 00:12:09', '118', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:12:09\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('238', 'update', '2014-05-06 00:12:09', '118', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:12:09\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('239', 'update', '2014-05-06 00:12:10', '118', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:12:10\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('240', 'update', '2014-05-06 00:12:10', '118', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:12:10\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('241', 'remove', '2014-05-06 00:12:11', '114', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('242', 'remove', '2014-05-06 00:12:11', '118', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('243', 'create', '2014-05-06 00:14:22', '119', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:14:22\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('244', 'create', '2014-05-06 00:14:22', '115', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('245', 'remove', '2014-05-06 00:14:22', '115', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('246', 'remove', '2014-05-06 00:14:22', '119', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('247', 'create', '2014-05-06 00:14:22', '120', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:14:22\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('248', 'create', '2014-05-06 00:14:22', '116', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('249', 'update', '2014-05-06 00:14:23', '120', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:14:23\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('250', 'update', '2014-05-06 00:14:23', '120', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:14:23\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('251', 'update', '2014-05-06 00:14:24', '120', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:14:24\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('252', 'update', '2014-05-06 00:14:24', '120', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:14:24\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('253', 'remove', '2014-05-06 00:14:24', '116', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('254', 'remove', '2014-05-06 00:14:24', '120', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('255', 'create', '2014-05-06 00:15:44', '121', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:15:44\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('256', 'create', '2014-05-06 00:15:44', '117', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('257', 'remove', '2014-05-06 00:15:44', '117', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('258', 'remove', '2014-05-06 00:15:44', '121', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('259', 'create', '2014-05-06 00:15:45', '122', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:15:45\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('260', 'create', '2014-05-06 00:15:45', '118', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('261', 'update', '2014-05-06 00:15:45', '122', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:15:45\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('262', 'update', '2014-05-06 00:15:45', '122', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:15:45\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('263', 'update', '2014-05-06 00:15:46', '122', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:15:46\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('264', 'update', '2014-05-06 00:15:46', '122', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:15:46\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('265', 'remove', '2014-05-06 00:15:47', '118', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('266', 'remove', '2014-05-06 00:15:47', '122', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('267', 'update', '2014-05-06 00:15:48', '2', 'Registry\\Entity\\Item', '1', 'a:1:{s:6:\"status\";i:2;}', null);
INSERT INTO `ext_log_entries` VALUES ('268', 'create', '2014-05-06 00:17:28', '123', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:17:28\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('269', 'create', '2014-05-06 00:17:28', '119', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('270', 'remove', '2014-05-06 00:17:28', '119', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('271', 'remove', '2014-05-06 00:17:28', '123', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('272', 'create', '2014-05-06 00:17:28', '124', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:17:28\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('273', 'create', '2014-05-06 00:17:28', '120', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('274', 'update', '2014-05-06 00:17:29', '124', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:17:29\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('275', 'update', '2014-05-06 00:17:29', '124', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:17:29\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('276', 'update', '2014-05-06 00:17:30', '124', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:17:30\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('277', 'update', '2014-05-06 00:17:30', '124', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:17:30\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('278', 'remove', '2014-05-06 00:17:30', '120', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('279', 'remove', '2014-05-06 00:17:30', '124', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('280', 'create', '2014-05-06 00:21:18', '125', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:21:18\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('281', 'create', '2014-05-06 00:21:18', '121', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('282', 'remove', '2014-05-06 00:21:18', '121', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('283', 'remove', '2014-05-06 00:21:18', '125', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('284', 'create', '2014-05-06 00:21:18', '126', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:21:18\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('285', 'create', '2014-05-06 00:21:18', '122', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('286', 'update', '2014-05-06 00:21:19', '126', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:21:19\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('287', 'update', '2014-05-06 00:21:19', '126', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:21:19\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('288', 'update', '2014-05-06 00:21:19', '126', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:21:19\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('289', 'update', '2014-05-06 00:21:20', '126', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:21:20\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('290', 'remove', '2014-05-06 00:21:20', '122', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('291', 'remove', '2014-05-06 00:21:20', '126', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('292', 'create', '2014-05-06 00:21:47', '127', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:21:47\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('293', 'create', '2014-05-06 00:21:47', '123', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('294', 'remove', '2014-05-06 00:21:47', '123', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('295', 'remove', '2014-05-06 00:21:47', '127', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('296', 'create', '2014-05-06 00:21:48', '128', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:21:48\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('297', 'create', '2014-05-06 00:21:48', '124', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('298', 'update', '2014-05-06 00:21:48', '128', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:21:48\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('299', 'update', '2014-05-06 00:21:48', '128', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:21:48\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('300', 'update', '2014-05-06 00:21:49', '128', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:21:49\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('301', 'update', '2014-05-06 00:21:49', '128', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:21:49\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('302', 'remove', '2014-05-06 00:21:50', '124', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('303', 'remove', '2014-05-06 00:21:50', '128', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('304', 'create', '2014-05-06 00:24:50', '129', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:24:50\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('305', 'create', '2014-05-06 00:24:50', '125', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('306', 'remove', '2014-05-06 00:24:50', '125', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('307', 'remove', '2014-05-06 00:24:50', '129', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('308', 'create', '2014-05-06 00:24:50', '130', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:24:50\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('309', 'create', '2014-05-06 00:24:50', '126', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('310', 'update', '2014-05-06 00:24:51', '130', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:24:51\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('311', 'update', '2014-05-06 00:24:51', '130', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:24:51\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('312', 'update', '2014-05-06 00:24:52', '130', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:24:51\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('313', 'update', '2014-05-06 00:24:52', '130', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:24:52\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('314', 'remove', '2014-05-06 00:24:52', '126', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('315', 'remove', '2014-05-06 00:24:52', '130', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('316', 'create', '2014-05-06 00:25:57', '131', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:25:57\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('317', 'create', '2014-05-06 00:25:57', '127', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('318', 'remove', '2014-05-06 00:25:57', '127', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('319', 'remove', '2014-05-06 00:25:57', '131', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('320', 'create', '2014-05-06 00:25:58', '132', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:25:58\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('321', 'create', '2014-05-06 00:25:58', '128', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('322', 'update', '2014-05-06 00:25:58', '132', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:25:58\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('323', 'update', '2014-05-06 00:25:58', '132', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:25:58\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('324', 'update', '2014-05-06 00:25:59', '132', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:25:59\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('325', 'update', '2014-05-06 00:25:59', '132', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:25:59\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('326', 'remove', '2014-05-06 00:25:59', '128', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('327', 'remove', '2014-05-06 00:25:59', '132', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('328', 'create', '2014-05-06 00:26:24', '133', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:26:24\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('329', 'create', '2014-05-06 00:26:24', '129', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('330', 'remove', '2014-05-06 00:26:24', '129', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('331', 'remove', '2014-05-06 00:26:24', '133', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('332', 'create', '2014-05-06 00:26:24', '134', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:26:24\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('333', 'create', '2014-05-06 00:26:24', '130', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('334', 'update', '2014-05-06 00:26:25', '134', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:26:25\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('335', 'update', '2014-05-06 00:26:25', '134', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:26:25\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('336', 'update', '2014-05-06 00:26:26', '134', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:26:26\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('337', 'update', '2014-05-06 00:26:26', '134', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:26:26\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('338', 'remove', '2014-05-06 00:26:26', '130', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('339', 'remove', '2014-05-06 00:26:26', '134', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('340', 'create', '2014-05-06 00:27:23', '135', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:27:23\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('341', 'create', '2014-05-06 00:27:23', '131', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('342', 'remove', '2014-05-06 00:27:23', '131', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('343', 'remove', '2014-05-06 00:27:23', '135', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('344', 'create', '2014-05-06 00:27:23', '136', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:27:23\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('345', 'create', '2014-05-06 00:27:23', '132', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('346', 'update', '2014-05-06 00:27:24', '136', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:27:24\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('347', 'update', '2014-05-06 00:27:24', '136', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:27:24\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('348', 'update', '2014-05-06 00:27:25', '136', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:27:25\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('349', 'update', '2014-05-06 00:27:25', '136', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:27:25\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('350', 'remove', '2014-05-06 00:27:26', '132', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('351', 'remove', '2014-05-06 00:27:26', '136', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('352', 'create', '2014-05-06 00:28:14', '137', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:28:14\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('353', 'create', '2014-05-06 00:28:14', '133', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('354', 'remove', '2014-05-06 00:28:14', '133', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('355', 'remove', '2014-05-06 00:28:14', '137', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('356', 'create', '2014-05-06 00:28:14', '138', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:28:14\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('357', 'create', '2014-05-06 00:28:14', '134', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('358', 'update', '2014-05-06 00:28:15', '138', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:28:15\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('359', 'update', '2014-05-06 00:28:15', '138', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:28:15\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('360', 'update', '2014-05-06 00:28:16', '138', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:28:16\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('361', 'update', '2014-05-06 00:28:16', '138', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:28:16\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('362', 'remove', '2014-05-06 00:28:16', '134', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('363', 'remove', '2014-05-06 00:28:16', '138', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('364', 'create', '2014-05-06 00:30:03', '139', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:30:03\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('365', 'create', '2014-05-06 00:30:03', '135', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('366', 'remove', '2014-05-06 00:30:03', '135', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('367', 'remove', '2014-05-06 00:30:03', '139', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('368', 'create', '2014-05-06 00:30:03', '140', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:30:03\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('369', 'create', '2014-05-06 00:30:03', '136', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('370', 'update', '2014-05-06 00:30:04', '140', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:30:04\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('371', 'update', '2014-05-06 00:30:04', '140', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:30:04\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('372', 'update', '2014-05-06 00:30:04', '140', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:30:04\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('373', 'update', '2014-05-06 00:30:05', '140', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:30:05\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('374', 'remove', '2014-05-06 00:30:05', '136', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('375', 'remove', '2014-05-06 00:30:05', '140', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('376', 'create', '2014-05-06 00:33:06', '141', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:33:06\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('377', 'create', '2014-05-06 00:33:06', '137', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('378', 'remove', '2014-05-06 00:33:07', '137', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('379', 'remove', '2014-05-06 00:33:07', '141', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('380', 'create', '2014-05-06 00:33:07', '142', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:33:07\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('381', 'create', '2014-05-06 00:33:07', '138', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('382', 'update', '2014-05-06 00:33:07', '142', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:33:07\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('383', 'update', '2014-05-06 00:33:07', '142', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:33:07\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('384', 'update', '2014-05-06 00:33:08', '142', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:33:08\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('385', 'update', '2014-05-06 00:33:08', '142', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:33:08\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('386', 'remove', '2014-05-06 00:33:09', '138', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('387', 'remove', '2014-05-06 00:33:09', '142', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('388', 'create', '2014-05-06 00:33:47', '143', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:33:47\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('389', 'create', '2014-05-06 00:33:47', '139', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('390', 'remove', '2014-05-06 00:33:47', '139', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('391', 'remove', '2014-05-06 00:33:47', '143', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('392', 'create', '2014-05-06 00:33:47', '144', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:33:47\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('393', 'create', '2014-05-06 00:33:47', '140', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('394', 'update', '2014-05-06 00:33:48', '144', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:33:48\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('395', 'update', '2014-05-06 00:33:48', '144', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:33:48\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('396', 'update', '2014-05-06 00:33:48', '144', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:33:48\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('397', 'update', '2014-05-06 00:33:48', '144', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:33:48\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('398', 'remove', '2014-05-06 00:33:49', '140', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('399', 'remove', '2014-05-06 00:33:49', '144', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('400', 'update', '2014-05-06 00:33:50', '2', 'Registry\\Entity\\Item', '2', 'a:1:{s:6:\"status\";i:2;}', null);
INSERT INTO `ext_log_entries` VALUES ('401', 'create', '2014-05-06 00:36:08', '145', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:36:08\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('402', 'create', '2014-05-06 00:36:08', '141', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('403', 'remove', '2014-05-06 00:36:08', '141', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('404', 'remove', '2014-05-06 00:36:08', '145', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('405', 'create', '2014-05-06 00:36:08', '146', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:36:08\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('406', 'create', '2014-05-06 00:36:08', '142', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('407', 'update', '2014-05-06 00:36:09', '146', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:36:09\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('408', 'update', '2014-05-06 00:36:09', '146', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:36:09\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('409', 'update', '2014-05-06 00:36:10', '146', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:36:10\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('410', 'update', '2014-05-06 00:36:10', '146', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:36:10\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('411', 'remove', '2014-05-06 00:36:10', '142', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('412', 'remove', '2014-05-06 00:36:10', '146', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('413', 'create', '2014-05-06 00:38:12', '147', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:38:12\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('414', 'create', '2014-05-06 00:38:12', '143', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('415', 'remove', '2014-05-06 00:38:12', '143', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('416', 'remove', '2014-05-06 00:38:12', '147', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('417', 'create', '2014-05-06 00:38:12', '148', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:38:12\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('418', 'create', '2014-05-06 00:38:12', '144', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('419', 'update', '2014-05-06 00:38:13', '148', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:38:13\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('420', 'update', '2014-05-06 00:38:13', '148', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:38:13\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('421', 'update', '2014-05-06 00:38:14', '148', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:38:14\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('422', 'update', '2014-05-06 00:38:14', '148', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:38:14\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('423', 'remove', '2014-05-06 00:38:15', '144', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('424', 'remove', '2014-05-06 00:38:15', '148', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('425', 'create', '2014-05-06 00:38:43', '149', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:38:43\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('426', 'create', '2014-05-06 00:38:43', '145', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('427', 'remove', '2014-05-06 00:38:43', '145', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('428', 'remove', '2014-05-06 00:38:43', '149', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('429', 'create', '2014-05-06 00:38:43', '150', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:38:43\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('430', 'create', '2014-05-06 00:38:43', '146', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('431', 'update', '2014-05-06 00:38:44', '150', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:38:44\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('432', 'update', '2014-05-06 00:38:44', '150', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:38:44\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('433', 'update', '2014-05-06 00:38:44', '150', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:38:44\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('434', 'update', '2014-05-06 00:38:44', '150', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:38:44\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('435', 'remove', '2014-05-06 00:38:45', '146', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('436', 'remove', '2014-05-06 00:38:45', '150', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('437', 'create', '2014-05-06 00:39:33', '151', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:39:33\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('438', 'create', '2014-05-06 00:39:33', '147', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('439', 'remove', '2014-05-06 00:39:33', '147', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('440', 'remove', '2014-05-06 00:39:33', '151', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('441', 'create', '2014-05-06 00:39:33', '152', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:39:33\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('442', 'create', '2014-05-06 00:39:33', '148', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('443', 'update', '2014-05-06 00:39:34', '152', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:39:34\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('444', 'update', '2014-05-06 00:39:34', '152', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:39:34\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('445', 'update', '2014-05-06 00:39:35', '152', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:39:35\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('446', 'update', '2014-05-06 00:39:35', '152', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:39:35\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('447', 'remove', '2014-05-06 00:39:35', '148', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('448', 'remove', '2014-05-06 00:39:35', '152', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('449', 'create', '2014-05-06 00:41:18', '153', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:41:18\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('450', 'create', '2014-05-06 00:41:18', '149', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('451', 'remove', '2014-05-06 00:41:18', '149', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('452', 'remove', '2014-05-06 00:41:18', '153', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('453', 'create', '2014-05-06 00:41:18', '154', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:41:18\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('454', 'create', '2014-05-06 00:41:18', '150', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('455', 'update', '2014-05-06 00:41:19', '154', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:41:19\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('456', 'update', '2014-05-06 00:41:19', '154', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:41:19\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('457', 'update', '2014-05-06 00:41:20', '154', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:41:20\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('458', 'update', '2014-05-06 00:41:20', '154', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:41:20\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('459', 'remove', '2014-05-06 00:41:21', '150', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('460', 'remove', '2014-05-06 00:41:21', '154', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('461', 'create', '2014-05-06 00:42:57', '155', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:42:57\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('462', 'create', '2014-05-06 00:42:57', '151', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('463', 'remove', '2014-05-06 00:42:57', '151', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('464', 'remove', '2014-05-06 00:42:57', '155', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('465', 'create', '2014-05-06 00:42:57', '156', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:42:57\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('466', 'create', '2014-05-06 00:42:57', '152', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('467', 'update', '2014-05-06 00:42:57', '156', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:42:57\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('468', 'update', '2014-05-06 00:42:57', '156', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:42:57\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('469', 'update', '2014-05-06 00:42:58', '156', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:42:58\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('470', 'update', '2014-05-06 00:42:58', '156', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:42:58\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('471', 'remove', '2014-05-06 00:42:59', '152', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('472', 'remove', '2014-05-06 00:42:59', '156', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('473', 'create', '2014-05-06 00:43:37', '157', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:43:37\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('474', 'create', '2014-05-06 00:43:37', '153', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('475', 'remove', '2014-05-06 00:43:37', '153', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('476', 'remove', '2014-05-06 00:43:37', '157', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('477', 'create', '2014-05-06 00:43:38', '158', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:43:38\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('478', 'create', '2014-05-06 00:43:38', '154', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('479', 'update', '2014-05-06 00:43:38', '158', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:43:38\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('480', 'update', '2014-05-06 00:43:38', '158', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:43:38\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('481', 'update', '2014-05-06 00:43:39', '158', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:43:39\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('482', 'update', '2014-05-06 00:43:39', '158', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:43:39\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('483', 'remove', '2014-05-06 00:43:40', '154', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('484', 'remove', '2014-05-06 00:43:40', '158', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('485', 'create', '2014-05-06 00:44:28', '159', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:44:28\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('486', 'create', '2014-05-06 00:44:28', '155', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('487', 'remove', '2014-05-06 00:44:28', '155', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('488', 'remove', '2014-05-06 00:44:28', '159', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('489', 'create', '2014-05-06 00:44:28', '160', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:44:28\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('490', 'create', '2014-05-06 00:44:28', '156', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('491', 'update', '2014-05-06 00:44:29', '160', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:44:29\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('492', 'update', '2014-05-06 00:44:29', '160', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:44:29\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('493', 'update', '2014-05-06 00:44:29', '160', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:44:29\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('494', 'update', '2014-05-06 00:44:30', '160', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:44:30\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('495', 'remove', '2014-05-06 00:44:30', '156', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('496', 'remove', '2014-05-06 00:44:30', '160', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('497', 'create', '2014-05-06 00:45:06', '161', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:45:06\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('498', 'create', '2014-05-06 00:45:06', '157', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('499', 'remove', '2014-05-06 00:45:06', '157', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('500', 'remove', '2014-05-06 00:45:06', '161', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('501', 'create', '2014-05-06 00:45:06', '162', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:45:06\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('502', 'create', '2014-05-06 00:45:06', '158', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('503', 'update', '2014-05-06 00:45:07', '162', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:45:07\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('504', 'update', '2014-05-06 00:45:07', '162', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:45:07\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('505', 'update', '2014-05-06 00:45:08', '162', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:45:08\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('506', 'update', '2014-05-06 00:45:08', '162', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:45:08\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('507', 'remove', '2014-05-06 00:45:08', '158', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('508', 'remove', '2014-05-06 00:45:08', '162', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('509', 'create', '2014-05-06 00:57:19', '163', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:57:19\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('510', 'create', '2014-05-06 00:57:19', '159', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('511', 'remove', '2014-05-06 00:57:19', '159', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('512', 'remove', '2014-05-06 00:57:19', '163', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('513', 'create', '2014-05-06 00:57:19', '164', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:57:19\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('514', 'create', '2014-05-06 00:57:19', '160', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('515', 'update', '2014-05-06 00:57:20', '164', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:57:20\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('516', 'update', '2014-05-06 00:57:20', '164', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:57:20\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('517', 'update', '2014-05-06 00:57:21', '164', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:57:21\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('518', 'update', '2014-05-06 00:57:21', '164', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 00:57:21\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('519', 'remove', '2014-05-06 00:57:21', '160', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('520', 'remove', '2014-05-06 00:57:21', '164', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('521', 'update', '2014-05-06 01:02:06', '7', 'Registry\\Entity\\Registry', '1', 'a:2:{s:6:\"status\";i:2;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:02:06\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('522', 'create', '2014-05-06 01:04:58', '165', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:04:58\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('523', 'create', '2014-05-06 01:04:59', '161', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('524', 'remove', '2014-05-06 01:04:59', '161', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('525', 'remove', '2014-05-06 01:04:59', '165', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('526', 'create', '2014-05-06 01:04:59', '166', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:04:59\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('527', 'create', '2014-05-06 01:04:59', '162', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('528', 'update', '2014-05-06 01:04:59', '166', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:04:59\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('529', 'update', '2014-05-06 01:04:59', '166', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:04:59\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('530', 'update', '2014-05-06 01:05:00', '166', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:05:00\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('531', 'update', '2014-05-06 01:05:00', '166', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:05:00\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('532', 'remove', '2014-05-06 01:05:01', '162', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('533', 'remove', '2014-05-06 01:05:01', '166', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('534', 'update', '2014-05-06 01:05:03', '7', 'Registry\\Entity\\Registry', '2', 'a:2:{s:6:\"status\";i:2;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:05:03\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('535', 'update', '2014-05-06 01:05:03', '7', 'Registry\\Entity\\Registry', '3', 'a:2:{s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:05:03\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('536', 'create', '2014-05-06 01:06:01', '167', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:06:01\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('537', 'create', '2014-05-06 01:06:01', '163', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('538', 'remove', '2014-05-06 01:06:01', '163', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('539', 'remove', '2014-05-06 01:06:01', '167', 'Registry\\Entity\\Registry', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('540', 'create', '2014-05-06 01:06:01', '168', 'Registry\\Entity\\Registry', '1', 'a:5:{s:6:\"number\";i:0;s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:06:01\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}s:6:\"status\";i:0;s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('541', 'create', '2014-05-06 01:06:01', '164', 'Registry\\Entity\\Item', '1', 'a:3:{s:6:\"status\";i:0;s:8:\"document\";a:1:{s:2:\"id\";i:1;}s:10:\"modifiedBy\";N;}', null);
INSERT INTO `ext_log_entries` VALUES ('542', 'update', '2014-05-06 01:06:02', '168', 'Registry\\Entity\\Registry', '2', 'a:2:{s:11:\"description\";s:11:\"TEST EDITED\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:06:02\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('543', 'update', '2014-05-06 01:06:02', '168', 'Registry\\Entity\\Registry', '3', 'a:2:{s:11:\"description\";s:4:\"TEST\";s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:06:02\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('544', 'update', '2014-05-06 01:06:02', '168', 'Registry\\Entity\\Registry', '4', 'a:3:{s:6:\"number\";s:1:\"4\";s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:06:02\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('545', 'update', '2014-05-06 01:06:02', '168', 'Registry\\Entity\\Registry', '5', 'a:3:{s:6:\"number\";i:0;s:6:\"status\";i:0;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:06:02\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('546', 'remove', '2014-05-06 01:06:03', '164', 'Registry\\Entity\\Item', '2', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('547', 'remove', '2014-05-06 01:06:03', '168', 'Registry\\Entity\\Registry', '6', 'N;', null);
INSERT INTO `ext_log_entries` VALUES ('548', 'update', '2014-05-06 01:06:05', '7', 'Registry\\Entity\\Registry', '4', 'a:2:{s:6:\"status\";i:2;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:06:05\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);
INSERT INTO `ext_log_entries` VALUES ('549', 'update', '2014-05-06 01:06:05', '7', 'Registry\\Entity\\Registry', '5', 'a:2:{s:6:\"status\";i:1;s:12:\"modifiedDate\";O:8:\"DateTime\":3:{s:4:\"date\";s:19:\"2014-05-06 01:06:05\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:16:\"America/Santiago\";}}', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('2', '7', '1', '1', '', '2014-04-15 02:05:09', '2014-05-06 00:33:50', '2', '123124', '156480126', '', '2014-04-17', '0', '0', '23123');
INSERT INTO `item` VALUES ('3', '8', '1', '1', '', '2014-04-15 02:09:37', '2014-04-23 23:27:24', '1', '23456', '156480126', '', '2014-04-25', '0', '0', '2132');
INSERT INTO `item` VALUES ('4', '9', '1', '1', '', '2014-04-15 02:10:36', '2014-04-23 21:53:48', '2', '76543', '156480126', '', '2014-04-10', '0', '0', '76543');
INSERT INTO `item` VALUES ('5', '7', '1', '1', 'Descripcion de muestra', '2014-04-16 18:04:28', '2014-04-23 16:28:54', '1', '765432', '156480126', '', '2014-04-11', '0', '0', '34532');
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
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of registry
-- ----------------------------
INSERT INTO `registry` VALUES ('7', '1', '1', 'Holi', '2014-04-20 17:21:43', '2014-05-06 01:06:05', '1', '1');
INSERT INTO `registry` VALUES ('8', '1', '1', '', '2014-04-23 23:19:46', '2014-04-23 23:27:28', '2', '3');
INSERT INTO `registry` VALUES ('9', '1', '1', '', '2014-04-23 19:38:43', '2014-04-23 22:18:53', '3', '2');
INSERT INTO `registry` VALUES ('10', '2', '2', '', '2014-04-29 13:57:46', '2014-05-01 22:21:07', '3', '1');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'Jean Rumeau', '156480126', '$2y$14$MH9F4e4L/05JyVhDP3z5JeY0GtUKnnI657zDpUp3x0PTfSTtb7Djy', 'rumeau@gmail.com', null, null, null, null, 'N;', '2014-04-04 16:33:23', '2014-05-01 21:47:30', '1', null, '6');
INSERT INTO `user` VALUES ('2', 'Jean Paul', '66572145', '$2y$14$MH9F4e4L/05JyVhDP3z5JeY0GtUKnnI657zDpUp3x0PTfSTtb7Djy', 'jean.rumeau@jprumeau.com', '', '', '', '', 'N;', '2014-04-27 23:57:40', '2014-05-01 21:56:02', '1', null, '6');
INSERT INTO `user` VALUES ('3', 'Test', '66430510', '$2y$14$MH9F4e4L/05JyVhDP3z5JeY0GtUKnnI657zDpUp3x0PTfSTtb7Djy', 'f_insane@hotmail.com', '', '', '', '', 'N;', '2014-05-01 21:55:44', '2014-05-01 21:55:44', '1', null, '6');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
