DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
                                           `id` int(11),
    `name` varchar(30),
    `since` bigint unsigned,
    `revenue` decimal(10,2),
    PRIMARY KEY (`id`)
    );
INSERT INTO `customers` (`id`, `name`, `since`, `revenue`) VALUES (1, 'Coca Cola', 1403923153, 492.12);
INSERT INTO `customers` (`id`, `name`, `since`, `revenue`) VALUES (2, 'Teamleader', 1421301600, 1505.95);
INSERT INTO `customers` (`id`, `name`, `since`, `revenue`) VALUES (3, 'Jeroen De Wit', 1455221001, 0.00);

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
                            `id` varchar(4),
                            `description` text,
                            `category` smallint,
                            `price` decimal(10,2),
                            PRIMARY KEY (`id`)
);
INSERT INTO `products` (`id`, `description`, `category`, `price`) VALUES ('A101', 'Screwdriver', 1, 9.75);
INSERT INTO `products` (`id`, `description`, `category`, `price`) VALUES ('A102', 'Electric screwdriver', 1, 49.50);
INSERT INTO `products` (`id`, `description`, `category`, `price`) VALUES ('B101', 'Basic on-off switch', 2, 4.99);
INSERT INTO `products` (`id`, `description`, `category`, `price`) VALUES ('B102', 'Press button', 2, 4.99);
INSERT INTO `products` (`id`, `description`, `category`, `price`) VALUES ('B103', 'Switch with motion detector', 2, 12.95);