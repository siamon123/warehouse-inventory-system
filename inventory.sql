-- phpMyAdmin SQL Dump
-- version 4.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 24, 2015 at 12:28 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Automotive and Industrial'),
(3, 'Computers and Electronics '),
(4, 'Fire Tablets and Phone'),
(5, 'Games and Toys'),
(2, 'Home, Garden and Tools');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `buy_price` decimal(25,2) DEFAULT NULL,
  `sale_price` decimal(25,2) NOT NULL,
  `categorie_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `buy_price`, `sale_price`, `categorie_id`) VALUES
(1, 'Transformers Rescue Bots Playskool Heroes Hoist the Tow-Bot Figure', '20', '12.99', '14.99', 5),
(2, 'Transformers Prime Weaponizer Bumblebee Figure 8.5 Inches', '30', '45.99', '50.99', 5),
(3, 'Transformers Prime Weaponizer Optimus Prime Figure 8.5 Inches', '40', '46.50', '55.00', 5),
(4, 'Chefman RJ11-17-GP Precision Electric Kettle, Silver', '9', '40.99', '44.99', 2),
(5, 'Cuisinart TEA-100 PerfecTemp Programmable Tea Steeper and Kettle', '2', '29.99', '35.99', 2),
(6, 'iphone 6 plus', '45', '700.00', '749.00', 4),
(7, 'iphone 6 ', '8', '599.00', '650.00', 4),
(8, 'ipad', '36', '550.00', '650.00', 4),
(9, 'imac', '10', '1099.00', '1199.00', 3),
(10, 'macbook air', '10', '799.00', '899.00', 3);

-- --------------------------------------------------------

--
-- Stand-in structure for view `product_views`
--
CREATE TABLE IF NOT EXISTS `product_views` (
`id` int(11) unsigned
,`name` varchar(255)
,`quantity` varchar(50)
,`buy_price` decimal(25,2)
,`sale_price` decimal(25,2)
,`categorie_name` varchar(60)
);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `qty`, `price`, `date`) VALUES
(1, 7, 2, '1300.00', '2015-06-22'),
(2, 8, 4, '2600.00', '2015-06-24'),
(3, 4, 1, '44.99', '2015-06-22'),
(4, 5, 3, '107.97', '2015-06-22');

-- --------------------------------------------------------

--
-- Stand-in structure for view `sale_views`
--
CREATE TABLE IF NOT EXISTS `sale_views` (
`id` int(11) unsigned
,`qty` int(11)
,`price` decimal(25,2)
,`date` date
,`name` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `last_login`) VALUES
(1, 'siamon hasan', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', NULL);

-- --------------------------------------------------------

--
-- Structure for view `product_views`
--
DROP TABLE IF EXISTS `product_views`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product_views` AS select `p`.`id` AS `id`,`p`.`name` AS `name`,`p`.`quantity` AS `quantity`,`p`.`buy_price` AS `buy_price`,`p`.`sale_price` AS `sale_price`,`c`.`name` AS `categorie_name` from (`products` `p` left join `categories` `c` on((`c`.`id` = `p`.`categorie_id`))) order by `p`.`id`;

-- --------------------------------------------------------

--
-- Structure for view `sale_views`
--
DROP TABLE IF EXISTS `sale_views`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sale_views` AS select `s`.`id` AS `id`,`s`.`qty` AS `qty`,`s`.`price` AS `price`,`s`.`date` AS `date`,`p`.`name` AS `name` from (`sales` `s` left join `products` `p` on((`s`.`product_id` = `p`.`id`))) order by `s`.`id`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `PK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
