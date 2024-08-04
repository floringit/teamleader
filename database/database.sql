DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(30) NOT NULL,
    `since` bigint unsigned NOT NULL,
    `revenue` decimal(10,2) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `customers` (`name`, `since`, `revenue`) VALUES ('Coca Cola', 1403923153, 492.12);
INSERT INTO `customers` (`name`, `since`, `revenue`) VALUES ('Teamleader', 1421301600, 1505.95);
INSERT INTO `customers` (`name`, `since`, `revenue`) VALUES ('Jeroen De Wit', 1455221001, 0.00);

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
    `id` varchar(4) NOT NULL,
    `description` text NOT NULL,
    `category` smallint NOT NULL,
    `price` decimal(10,2) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `products` (`id`, `description`, `category`, `price`) VALUES ('A101', 'Screwdriver', 1, 9.75);
INSERT INTO `products` (`id`, `description`, `category`, `price`) VALUES ('A102', 'Electric screwdriver', 1, 49.50);
INSERT INTO `products` (`id`, `description`, `category`, `price`) VALUES ('B101', 'Basic on-off switch', 2, 4.99);
INSERT INTO `products` (`id`, `description`, `category`, `price`) VALUES ('B102', 'Press button', 2, 4.99);
INSERT INTO `products` (`id`, `description`, `category`, `price`) VALUES ('B103', 'Switch with motion detector', 2, 12.95);