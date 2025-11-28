-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2025 at 01:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dibassories`
--

CREATE DATABASE IF NOT EXISTS dibassories;

USE dibassories;

-- --------------------------------------------------------

--
-- Table structure for table `dibas_accounts`
--

CREATE TABLE IF NOT EXISTS `dibas_accounts` (
  `id` varchar(32) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(320) NOT NULL,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `pangirno` varchar(12) NOT NULL,
  `address` varchar(512) NOT NULL,
  `zipcode` varchar(16) NOT NULL,
  `card_number` varchar(16) DEFAULT NULL,
  `card_terminal` varchar(32) DEFAULT NULL,
  `wallet_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `instagram` varchar(128) DEFAULT NULL,
  `telegram` varchar(128) DEFAULT NULL,
  `role` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dibas_accounts_confirm`
--

CREATE TABLE IF NOT EXISTS `dibas_accounts_confirm` (
  `id` varchar(32) NOT NULL,
  `user` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dibas_cart_sessions`
--

CREATE TABLE IF NOT EXISTS `dibas_cart_sessions` (
  `id` varchar(32) NOT NULL,
  `owner` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dibas_orders`
--

CREATE TABLE IF NOT EXISTS `dibas_orders` (
  `id` varchar(32) NOT NULL,
  `owner` varchar(32) NOT NULL,
  `provider` varchar(32) NOT NULL,
  `product` varchar(32) NOT NULL,
  `product_color` varchar(32) NOT NULL,
  `product_material` varchar(32) NOT NULL,
  `product_size` varchar(32) NOT NULL,
  `count` int(11) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address` varchar(512) NOT NULL,
  `zipcode` varchar(16) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dibas_products`
--

CREATE TABLE IF NOT EXISTS `dibas_products` (
  `id` varchar(32) NOT NULL,
  `owner` varchar(32) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(512) NOT NULL,
  `count` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `offer` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dibas_products_color`
--

CREATE TABLE IF NOT EXISTS `dibas_products_color` (
  `id` varchar(32) NOT NULL,
  `product` varchar(32) NOT NULL,
  `color_name` varchar(32) NOT NULL,
  `color_hex` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dibas_products_material`
--

CREATE TABLE IF NOT EXISTS `dibas_products_material` (
  `id` varchar(32) NOT NULL,
  `product` varchar(32) NOT NULL,
  `material` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dibas_products_size`
--

CREATE TABLE IF NOT EXISTS `dibas_products_size` (
  `id` varchar(32) NOT NULL,
  `product` varchar(32) NOT NULL,
  `size` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dibas_shopping_carts`
--

CREATE TABLE IF NOT EXISTS `dibas_shopping_carts` (
  `id` varchar(32) NOT NULL,
  `owner` varchar(32) NOT NULL,
  `product` varchar(32) NOT NULL,
  `product_color` varchar(32) NOT NULL,
  `product_size` varchar(32) NOT NULL,
  `product_material` varchar(32) NOT NULL,
  `count` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dibas_transactions`
--

CREATE TABLE IF NOT EXISTS `dibas_transactions` (
  `id` varchar(32) NOT NULL,
  `wallet` varchar(32) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dibas_accounts`
--
ALTER TABLE `dibas_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `pangirno` (`pangirno`);

--
-- Indexes for table `dibas_accounts_confirm`
--
ALTER TABLE `dibas_accounts_confirm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `dibas_cart_sessions`
--
ALTER TABLE `dibas_cart_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `dibas_orders`
--
ALTER TABLE `dibas_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `provider` (`provider`);

--
-- Indexes for table `dibas_products`
--
ALTER TABLE `dibas_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `dibas_products_color`
--
ALTER TABLE `dibas_products_color`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`product`);

--
-- Indexes for table `dibas_products_material`
--
ALTER TABLE `dibas_products_material`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`product`);

--
-- Indexes for table `dibas_products_size`
--
ALTER TABLE `dibas_products_size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`product`);

--
-- Indexes for table `dibas_shopping_carts`
--
ALTER TABLE `dibas_shopping_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `dibas_transactions`
--
ALTER TABLE `dibas_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet` (`wallet`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
