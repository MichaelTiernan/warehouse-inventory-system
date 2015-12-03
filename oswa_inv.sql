CREATE DATABASE oswa_inv;
USE oswa_inv;


-- Table structure for table `categories`

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table 'categories'

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'TV'),
(2, 'ASUS'),
(3, 'Internett'),
(4, 'Bedrift');

-- Table structure for table `media`

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) unsigned NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `media`

INSERT INTO `media` (`id`, `file_name`, `file_type`) VALUES
(1, 'Asus.jpg', 'image/jpeg'),
(2, 'Asus-ekstender.jpg', 'image/jpeg'),
(3, 'tv-startpakke.jpg', 'image/jpeg'),
(4, 'tv-mottaker.jpg', 'image/jpeg'),
(5, 'Fjernkontroll.jpg', 'image/jpeg'),
(6, 'Dekoder.jpg', 'image/jpeg'),
(7, 'harddisk.jpg', 'image/jpeg'),
(8, 'FMG.jpg', 'image/jpeg'),
(9, 'Cisco-sg.jpg', 'image/jpeg'),
(10, 'Wifi-pluss.png', 'image/png'),
(11, 'zyxel.jpg', 'image/png');


-- Table structure for table `products`

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) unsigned DEFAULT NULL,
  `ks_storage` int(11) unsigned DEFAULT NULL,
  `tradein` int(11) DEFAULT NULL,
  `buy_price` decimal(25,2),
  `sale_price` decimal(25,2) NOT NULL,
  `categorie_id` int(11) unsigned NOT NULL,
  `media_id` int(11) DEFAULT '0',
  `bedrift` boolean DEFAULT FALSE,
  `product_number` varchar(15) DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `products`

INSERT INTO `products` (`id`, `name`, `quantity`, `ks_storage`, `buy_price`, `sale_price`, `categorie_id`, `media_id`, `bedrift`, `product_number`, `date`) VALUES
(1, 'ASUS RT-AC66U', 100, 15, '990.00', '1090.00', 2, 1, 0, 'Customer', '2015-11-23 10:02:30'),
(2, 'Asus Extender', 100, 15, '990.00', '1090.00', 2, 2, 0, 'Customer', '2015-11-23 10:02:41'),
(3, 'Trådløs Tv - Ekstra mottaker', 100, 15, '599.00', '990.00', 1, 4, 0, 'DIV-1071', '2015-11-23 10:03:10'),
(4, 'Trådløs TV - Startpakke', 100, 15, '990.00', '1390.00', 1, 3, 0, 'DIV-760', '2015-11-23 10:03:30'),
(5, 'Fjernkontroll', 100, 15, '99.00', '149.00', 1, 5, 0, 'DIV-83', '2015-11-23 10:03:49'),
(6, 'Dekoder', 100, 15, '99.00', '49.00', 1, 6, 0, '115', '2015-11-23 10:04:04'),
(7, 'PVR Module', 100, 15, '399.00', '599.00', 1, 7, 0, 'Customer', '2015-11-23 10:04:25'),
(8, 'FMG-Fibermodem', 100, 15, '599.00', '999.00', 3, 8, 0, 'Customer', '2015-11-23 10:04:41'),
(9, 'Cisco SG-300', 100, 15, '599.00', '999.00', 4, 9, 1, 'Customer', '2015-11-23 10:04:41'),
(10, 'Tafjord Wifi Pluss', 10, 990, '990.00', '1490.00', 3, 10, 0, 'DIV-1113', '2015-11-24 12:59:02'),
(11, 'ZyXEL P2812', 100, 599, '599.00', '990.00', 3, 11, 0, 'BB101', '2015-12-01 12:05:18');


-- Table structure for table `sales`

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` date NOT NULL,
  `custnr` int(11) NOT NULL,
  `comment` text,
  `FK_userID` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `trade` (
  `id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` date NOT NULL,
  `custnr` int(11) NOT NULL,
  `comment` text,
  `FK_userID` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Table structure for table `users`

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'tafjord.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `email` VARCHAR(255)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- Dumping data for table `users`

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'Admin User', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'tafjord.jpg', 1, '2015-09-27 22:00:53'),
(2, 'Leveranse', 'leveranse', 'ba36b97a41e7faf742ab09bf88405ac04f99599a', 2, 'tafjord.jpg', 1, '2015-09-27 21:59:59'),
(3, 'Kundesenter', 'ks', '12dea96fec20593566ab75692c9949596833adc9', 3, 'tafjord.jpg', 1, '2015-09-27 22:00:15'),
(4,'Resepsjon', 'resepsjon', 'cf4f49bd2af3be569f17f1ddd4055a44a87db9f9' , 4, 'tafjord.jpg', 1, NULL);

-- Table structure for table `user_groups`

CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- Indexes for table `categories`

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);


-- Dumping data for table `user_groups`

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'Leveranse', 2, 1),
(3, 'Kundesenter', 3, 1),
(4, 'Resepsjon', 4, 1);

-- Indexes for table `media`

ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);


-- Indexes for table `products`

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `media_id` (`media_id`);


-- Indexes for table `sales`

ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `FK_userID` (`FK_userID`);

ALTER TABLE `trade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `FK_userID` (`FK_userID`);



-- Indexes for table `users`

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_level` (`user_level`),
  ADD UNIQUE KEY (`username`);


-- Indexes for table `user_groups`

ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);


-- AUTO_INCREMENT for table `categories`

ALTER TABLE `categories`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;


-- AUTO_INCREMENT for table `media`

ALTER TABLE `media`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;


-- AUTO_INCREMENT for table `products`

ALTER TABLE `products`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;


-- AUTO_INCREMENT for table `sales`

ALTER TABLE `sales`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;


ALTER TABLE `trade`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;


-- AUTO_INCREMENT for table `users`

ALTER TABLE `users`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;


-- AUTO_INCREMENT for table `user_groups`

ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;


-- Constraints for table `products`

ALTER TABLE `products`
  ADD CONSTRAINT `FK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


-- Constraints for table `sales`

ALTER TABLE `sales`
  ADD CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_UID` FOREIGN KEY (`FK_userID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


-- Constraints for table `users`

ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
