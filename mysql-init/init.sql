DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  PRIMARY KEY (`id`)
);

LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES (1, 'Phil');
UNLOCK TABLES;
