SET FOREIGN_KEY_CHECKS=0;

INSERT INTO `comment` VALUES ('2', null, '7', '1', 'Hola mundo!', '2014-04-22 23:38:42', '2014-04-22 23:38:42', '1');
INSERT INTO `comment` VALUES ('3', null, '7', '1', 'Hola mundo 2', '2014-04-22 23:40:15', '2014-04-22 23:40:15', '1');
INSERT INTO `comment` VALUES ('6', null, '9', '1', 'Testin', '2014-04-23 21:49:21', '2014-04-23 21:49:21', '1');
INSERT INTO `comment` VALUES ('7', null, '10', '1', 'Cerrada hoy', '2014-04-29 22:29:43', '2014-04-29 22:29:43', '1');

INSERT INTO `document` VALUES ('1', 'Boleta', '');
INSERT INTO `document` VALUES ('2', 'Factura', '');

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

INSERT INTO `item` VALUES ('2', '7', '1', '1', '', '2014-04-15 02:05:09', '2014-04-23 16:28:52', '1', '123124', '156480126', '', '2014-04-17', '0', '0', '23123');
INSERT INTO `item` VALUES ('3', '8', '1', '1', '', '2014-04-15 02:09:37', '2014-04-23 23:27:24', '1', '23456', '156480126', '', '2014-04-25', '0', '0', '2132');
INSERT INTO `item` VALUES ('4', '9', '1', '1', '', '2014-04-15 02:10:36', '2014-04-23 21:53:48', '2', '76543', '156480126', '', '2014-04-10', '0', '0', '76543');
INSERT INTO `item` VALUES ('5', '7', '1', '1', 'Descripcion de muestra', '2014-04-16 18:04:28', '2014-04-23 16:28:54', '1', '765432', '156480126', '', '2014-04-11', '0', '0', '34532');
INSERT INTO `item` VALUES ('6', '10', '1', '2', 'Test', '2014-04-29 13:57:26', '2014-05-01 22:21:01', '2', '12345678', '66430510', 'La boleta', '2014-04-22', '0', '0', '2432433');
INSERT INTO `item` VALUES ('7', '11', '1', '2', '', '2014-05-01 21:58:25', '2014-05-01 22:11:49', '1', '4214342', '66572145', 'sdasda', '2014-05-21', '0', '0', '42234');

INSERT INTO `moderatorgrouplinker` VALUES ('2', '1');
INSERT INTO `moderatorgrouplinker` VALUES ('2', '6');

INSERT INTO `registry` VALUES ('7', '1', '1', 'Holi', '2014-04-20 17:21:43', '2014-04-23 16:42:28', '2', '1');
INSERT INTO `registry` VALUES ('8', '1', '1', '', '2014-04-23 23:19:46', '2014-04-23 23:27:28', '2', '3');
INSERT INTO `registry` VALUES ('9', '1', '1', '', '2014-04-23 19:38:43', '2014-04-23 22:18:53', '3', '2');
INSERT INTO `registry` VALUES ('10', '2', '2', '', '2014-04-29 13:57:46', '2014-05-01 22:21:07', '3', '1');
INSERT INTO `registry` VALUES ('11', '3', '2', '', '2014-05-01 21:58:29', '2014-05-01 22:11:51', '2', '1');

INSERT INTO `user` VALUES ('1', 'Jean Rumeau', '156480126', '$2y$14$MH9F4e4L/05JyVhDP3z5JeY0GtUKnnI657zDpUp3x0PTfSTtb7Djy', 'rumeau@gmail.com', null, null, null, null, 'N;', '2014-04-04 16:33:23', '2014-05-01 21:47:30', '1', null, '6');
INSERT INTO `user` VALUES ('2', 'Jean Paul', '66572145', '$2y$14$MH9F4e4L/05JyVhDP3z5JeY0GtUKnnI657zDpUp3x0PTfSTtb7Djy', 'jean.rumeau@jprumeau.com', '', '', '', '', 'N;', '2014-04-27 23:57:40', '2014-05-01 21:56:02', '1', null, '6');
INSERT INTO `user` VALUES ('3', 'Test', '66430510', '$2y$14$MH9F4e4L/05JyVhDP3z5JeY0GtUKnnI657zDpUp3x0PTfSTtb7Djy', 'f_insane@hotmail.com', '', '', '', '', 'N;', '2014-05-01 21:55:44', '2014-05-01 21:55:44', '1', null, '6');

INSERT INTO `usergroup` VALUES ('1', 'Default', 'Grupo por defecto', '1', '1');
INSERT INTO `usergroup` VALUES ('6', 'Gerentes', '', '1', '0');
INSERT INTO `usergroup` VALUES ('8', 'Test', '', '1', '0');

INSERT INTO `userrole` VALUES ('1', null, 'guest', '1');
INSERT INTO `userrole` VALUES ('2', '1', 'user', '0');
INSERT INTO `userrole` VALUES ('3', '2', 'moderator', '0');
INSERT INTO `userrole` VALUES ('4', '3', 'administrator', '0');

INSERT INTO `userrolelinker` VALUES ('1', '2');
INSERT INTO `userrolelinker` VALUES ('1', '3');
INSERT INTO `userrolelinker` VALUES ('1', '4');
INSERT INTO `userrolelinker` VALUES ('2', '1');
INSERT INTO `userrolelinker` VALUES ('2', '2');
INSERT INTO `userrolelinker` VALUES ('2', '3');
INSERT INTO `userrolelinker` VALUES ('3', '1');
INSERT INTO `userrolelinker` VALUES ('3', '2');

SET FOREIGN_KEY_CHECKS=1;
