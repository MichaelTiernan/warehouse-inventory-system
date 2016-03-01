ALTER TABLE products
ADD m_storage int(11) unsigned;

INSERT INTO user_groups (group_name, group_level, group_status) VALUES ('Montør', 5, 1);

CREATE TABLE IF NOT EXISTS `entre_sales` (
  `id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` date NOT NULL,
  `custnr` int(11) NOT NULL,
  `comment` text,
  `FK_userID` int(11) unsigned NOT NULL,
  `mac` text
);

ALTER TABLE `entre_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `FK_userID` (`FK_userID`);

ALTER TABLE entre_sales
	MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;

ALTER TABLE `entre_sales`
	ADD CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `FK_UID` FOREIGN KEY (`FK_userID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

  ALTER TABLE sales modify mac text;
  ALTER TABLE trade modify mac text;