-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 06, 2022 at 04:43 PM
-- Server version: 8.0.31-0ubuntu0.22.04.1
-- PHP Version: 8.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalProjectDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_users`
--

CREATE TABLE `auth_users` (
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `f_name` varchar(50) DEFAULT NULL,
  `l_name` varchar(50) DEFAULT NULL,
  `id` int NOT NULL
) 

--
-- Dumping data for table `auth_users`
--

INSERT INTO `auth_users` (`username`, `password`, `f_name`, `l_name`, `id`) VALUES
('jdoe', 'd35514736146439b7277437016cdb40d7fb65497', 'John', 'Doe', 1),
('rmckay', 'cad3695ebadec0a8c21846e612324ef95dc08ee4', 'Ron', 'McKay', 2),
('ljones', '0bb5a7d1b7246d57278448897fba40a4208ce741', 'Leslie', 'Jones', 3),
('mdoe', 'e43325245ace83ef7a979b7af10e19cd63966df9', 'Mary', 'Doe', 4),
('cchum', '34669e18919b51be0293c9186c7fa5a851cb64d1', 'ChunHo', 'Chum', 5);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `firstname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cust_id` int NOT NULL
) ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`firstname`, `lastname`, `email`, `password`, `cust_id`) VALUES
('peter', 'john', 'jp@gmail.com', 'b7a875fc1ea228b9061041b7cec4bd3c52ab3ce3', 9000),
('Jackson', 'Doe', 'jdoe@gmail.com', 'b7a875fc1ea228b9061041b7cec4bd3c52ab3ce3', 9001),
('John', 'Wall', 'jw@gmail.com', 'b7a875fc1ea228b9061041b7cec4bd3c52ab3ce3', 9003),
('hello', 'pp', 'ppp@gmail.com', 'b7a875fc1ea228b9061041b7cec4bd3c52ab3ce3', 9004),
('tom', 'hi', 'th@gmail.com', 'b7a875fc1ea228b9061041b7cec4bd3c52ab3ce3', 9005),
('jason', 'hanna', 'jason@gmail.com', '7b52009b64fd0a2a49e6d8a939753077792b0554', 9015);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `product` varchar(30) NOT NULL,
  `price` double NOT NULL,
  `quantity` int NOT NULL,
  `category` varchar(30) NOT NULL,
  `pro_id` int NOT NULL COMMENT '1000'
) 

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`product`, `price`, `quantity`, `category`, `pro_id`) VALUES
('chicken', 4.5, 200, 'meat', 1001),
('corn', 0.8, 200, 'vege', 1002),
('soda', 1.2, 400, 'drink', 1003),
('salt', 1.2, 300, 'season', 1004),
('steak', 12, 200, 'meat', 1008),
('potato', 0.5, 200, 'vege', 1009);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `cust_id` int NOT NULL,
  `date` date NOT NULL
) 

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `cust_id`, `date`) VALUES
(25, 9000, '2022-12-04'),
(34, 9004, '2022-12-04'),
(35, 9004, '2022-12-05'),
(42, 9007, '2022-12-06'),
(43, 9008, '2022-12-06'),
(59, 9012, '2022-12-06'),
(74, 9015, '2022-12-06'),
(75, 9015, '2022-12-06');

-- --------------------------------------------------------

--
-- Table structure for table `pro_qty`
--

CREATE TABLE `pro_qty` (
  `prod_id` int NOT NULL,
  `order_id` int NOT NULL,
  `qty` int NOT NULL
) 

--
-- Dumping data for table `pro_qty`
--

INSERT INTO `pro_qty` (`prod_id`, `order_id`, `qty`) VALUES
(1001, 25, 3),
(1001, 35, 5),
(1001, 42, 4),
(1001, 43, 5),
(1001, 59, 3),
(1001, 74, 4),
(1001, 75, 6),
(1002, 25, 1),
(1002, 35, 4),
(1002, 42, 5),
(1002, 43, 3),
(1002, 74, 4),
(1002, 75, 3),
(1003, 25, 1),
(1003, 34, 2),
(1003, 35, 2),
(1003, 75, 4),
(1004, 34, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_users`
--
ALTER TABLE `auth_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `pro_qty`
--
ALTER TABLE `pro_qty`
  ADD PRIMARY KEY (`prod_id`,`order_id`),
  ADD KEY `pro_qty_ibfk_1` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_users`
--
ALTER TABLE `auth_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9016;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `pro_id` int NOT NULL AUTO_INCREMENT COMMENT '1000', AUTO_INCREMENT=1010;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `pro_qty`
--
ALTER TABLE `pro_qty`
  ADD CONSTRAINT `pro_qty_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `pro_qty_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `inventory` (`pro_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
