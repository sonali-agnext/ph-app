-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 01, 2022 at 03:36 PM
-- Server version: 5.7.39-0ubuntu0.18.04.2
-- PHP Version: 7.2.24-0ubuntu0.18.04.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ph_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_profiles`
--

CREATE TABLE `admin_profiles` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `avatar` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_profiles`
--

INSERT INTO `admin_profiles` (`id`, `user_id`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 1, '1661172854apple-icon-72x72.png', '2022-08-18 04:05:30', '2022-08-22 07:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_types`
--

CREATE TABLE `applicant_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `applicant_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicant_types`
--

INSERT INTO `applicant_types` (`id`, `applicant_type_name`, `created_at`, `updated_at`) VALUES
(1, 'Individual', '2022-08-04 06:30:00', '2022-08-04 09:30:00'),
(2, 'Company', '2022-08-09 09:30:00', '2022-08-09 09:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `bkscheme_categories`
--

CREATE TABLE `bkscheme_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `govt_scheme_id` bigint(20) NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bkscheme_categories`
--

INSERT INTO `bkscheme_categories` (`id`, `govt_scheme_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'MIDH', '2022-08-07 09:30:00', '2022-08-22 06:50:40'),
(2, 1, 'MIDH', '2022-08-07 09:30:00', '2022-08-22 06:50:40');

-- --------------------------------------------------------

--
-- Table structure for table `caste_categories`
--

CREATE TABLE `caste_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `caste_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `caste_categories`
--

INSERT INTO `caste_categories` (`id`, `caste_name`, `created_at`, `updated_at`) VALUES
(1, 'General', '2022-08-08 09:30:00', '2022-08-09 09:30:00'),
(2, 'OBC', '2022-08-09 07:11:03', '2022-08-09 22:43:43'),
(3, 'SC', '2022-08-09 07:11:39', '2022-08-09 07:11:39');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tehsil_id` bigint(20) UNSIGNED NOT NULL,
  `city_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `tehsil_id`, `city_name`, `created_at`, `updated_at`) VALUES
(1, 3, 'Beas Pind', '2022-08-04 08:59:20', '2022-08-10 05:32:44'),
(2, 3, 'Alipur', '2022-08-04 09:30:00', '2022-08-04 09:30:00'),
(3, 4, 'Ali Khel', '2022-08-04 09:30:00', '2022-08-04 09:30:00'),
(4, 4, 'Mustfapur', '2022-08-04 07:52:19', '2022-08-04 09:30:00'),
(5, 1, 'Test', '2022-08-10 09:30:00', '2022-08-10 09:30:00'),
(6, 2, 'Test2', '2022-08-10 09:30:00', '2022-08-10 09:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `district_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `district_name`, `created_at`, `updated_at`) VALUES
(1, 'Amritsar', '2022-08-04 09:30:00', '2022-08-22 22:18:25'),
(2, 'Jalandhar', '2022-08-04 09:30:00', '2022-08-04 09:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `farmers`
--

CREATE TABLE `farmers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicant_type_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_husband_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resident` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aadhar_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caste_category_id` bigint(20) UNSIGNED NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Punjab',
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `tehsil_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `farmer_unique_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `farmers`
--

INSERT INTO `farmers` (`id`, `user_id`, `language`, `applicant_type_id`, `name`, `mobile_number`, `father_husband_name`, `gender`, `resident`, `aadhar_number`, `pan_number`, `caste_category_id`, `state`, `district_id`, `tehsil_id`, `city_id`, `farmer_unique_id`, `full_address`, `pin_code`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 2, 'hi', 1, 'Test', '4565767776', 'Test', 'Female', 'test', 'w34353656', '5654465', 1, 'Punjab', 2, 1, 1, 'PUJAAM000001', 'Test', '123456', '16607179459cd820d8-3ada-4392-a13f-036052b466b5.svg', '2022-08-05 01:22:15', '2022-08-17 05:09:54'),
(2, 3, 'en', 1, 'sonali', '4565767778', 'Test', 'Female', 'india', '187828878723', '1Cczzffafa', 1, 'Punjab', 1, 1, 5, 'PUJABA000002', 'thisvillage', '123458', '1660735965Screenshot (2).png', '2022-08-17 04:44:05', '2022-08-17 06:07:00'),
(3, 4, 'en', 2, 'Test Farmers', '5678900000', 'Father name', 'Male', 'Indian', '444444444444', '4444444444', 1, 'Punjab', 1, 1, 1, '', 'C-184, Industrial Area, Sector 75, SAS', '140308', '1661172050icon-gd4c15d675_640.png', '2022-08-22 07:10:50', '2022-08-22 23:15:48');

-- --------------------------------------------------------

--
-- Table structure for table `govt_schemes`
--

CREATE TABLE `govt_schemes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `govt_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `govt_schemes`
--

INSERT INTO `govt_schemes` (`id`, `govt_name`, `created_at`, `updated_at`) VALUES
(1, 'State Scheme', '2022-08-07 09:30:00', '2022-08-22 22:15:54'),
(2, 'Central Scheme', '2022-08-07 09:30:00', '2022-08-07 09:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `market_prices`
--

CREATE TABLE `market_prices` (
  `id` bigint(20) NOT NULL,
  `state` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `market` varchar(255) NOT NULL,
  `commodity` varchar(255) NOT NULL,
  `variety` varchar(255) NOT NULL,
  `arrival_date` date NOT NULL,
  `min_price` varchar(255) NOT NULL,
  `max_price` varchar(255) NOT NULL,
  `modal_price` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `market_prices`
--

INSERT INTO `market_prices` (`id`, `state`, `district`, `market`, `commodity`, `variety`, `arrival_date`, `min_price`, `max_price`, `modal_price`, `created_at`, `updated_at`) VALUES
(1, 'Punjab', 'Amritsar', 'Mehta', 'Bhindi(Ladies Finger)', 'Bhindi', '2022-08-31', '1300', '1300', '1300', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(2, 'Punjab', 'Amritsar', 'Mehta', 'Bottle gourd', 'Bottle Gourd', '2022-08-31', '1800', '1800', '1800', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(3, 'Punjab', 'Amritsar', 'Mehta', 'Brinjal', 'Arkasheela Mattigulla', '2022-08-31', '1100', '1100', '1100', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(4, 'Punjab', 'Amritsar', 'Mehta', 'Capsicum', 'Capsicum', '2022-08-19', '5600', '5600', '5600', '2022-08-23 01:23:19', '2022-08-23 01:23:19'),
(5, 'Punjab', 'Amritsar', 'Mehta', 'Cauliflower', 'African Sarson', '2022-08-31', '3900', '3900', '3900', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(6, 'Punjab', 'Amritsar', 'Mehta', 'Raddish', 'Other', '2022-08-31', '1800', '1800', '1800', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(7, 'Punjab', 'Amritsar', 'Mehta', 'Tomato', 'Deshi', '2022-08-31', '2900', '2900', '2900', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(8, 'Punjab', 'Amritsar', 'Rayya', 'Bhindi(Ladies Finger)', 'Bhindi', '2022-08-31', '1300', '1300', '1300', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(9, 'Punjab', 'Amritsar', 'Rayya', 'Brinjal', 'Brinjal', '2022-08-31', '1500', '1500', '1500', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(10, 'Punjab', 'Amritsar', 'Rayya', 'Cauliflower', 'Local', '2022-08-31', '2200', '2200', '2200', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(11, 'Punjab', 'Amritsar', 'Rayya', 'Green Chilli', 'Green Chilly', '2022-08-31', '3000', '3000', '3000', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(12, 'Punjab', 'Amritsar', 'Rayya', 'Onion', 'Red', '2022-08-31', '2100', '2100', '2100', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(13, 'Punjab', 'Amritsar', 'Rayya', 'Potato', 'Other', '2022-08-31', '1800', '1800', '1800', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(14, 'Punjab', 'Amritsar', 'Rayya', 'Raddish', 'Other', '2022-08-31', '1600', '1600', '1600', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(15, 'Punjab', 'Amritsar', 'Rayya', 'Tomato', 'Hybrid', '2022-08-31', '3100', '3100', '3100', '2022-08-23 01:23:19', '2022-08-31 08:30:02'),
(16, 'Punjab', 'Bhatinda', 'Bathinda', 'Apple', 'Other', '2022-08-19', '6500', '15500', '10500', '2022-08-23 01:23:19', '2022-08-23 01:23:19'),
(17, 'Punjab', 'Bhatinda', 'Bathinda', 'Banana', 'Other', '2022-08-19', '1600', '1700', '1650', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(18, 'Punjab', 'Bhatinda', 'Bathinda', 'Brinjal', 'Other', '2022-08-19', '1500', '2500', '1500', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(19, 'Punjab', 'Bhatinda', 'Bathinda', 'Cabbage', 'Other', '2022-08-19', '3000', '3500', '3000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(20, 'Punjab', 'Bhatinda', 'Bathinda', 'Carrot', 'Other', '2022-08-19', '2200', '2200', '2200', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(21, 'Punjab', 'Bhatinda', 'Bathinda', 'Cauliflower', 'Other', '2022-08-19', '2000', '4235', '2000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(22, 'Punjab', 'Bhatinda', 'Bathinda', 'Garlic', 'Average', '2022-08-19', '2474', '3500', '2474', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(23, 'Punjab', 'Bhatinda', 'Bathinda', 'Grapes', 'Other', '2022-08-19', '8000', '15000', '12000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(24, 'Punjab', 'Bhatinda', 'Bathinda', 'Mango', 'Other', '2022-08-19', '7500', '10000', '8500', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(25, 'Punjab', 'Bhatinda', 'Bathinda', 'Mousambi(Sweet Lime)', 'Other', '2022-08-19', '3400', '4000', '3700', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(26, 'Punjab', 'Bhatinda', 'Bathinda', 'Onion', 'Other', '2022-08-19', '1300', '1600', '1300', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(27, 'Punjab', 'Bhatinda', 'Bathinda', 'Pomegranate', 'Other', '2022-08-19', '6000', '10000', '8000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(28, 'Punjab', 'Bhatinda', 'Bathinda', 'Potato', 'Other', '2022-08-19', '1000', '1400', '1000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(29, 'Punjab', 'Bhatinda', 'Bathinda', 'Tomato', 'Other', '2022-08-19', '2000', '2500', '2000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(30, 'Punjab', 'Bhatinda', 'Raman', 'Banana', 'Other', '2022-08-19', '1500', '1600', '1560', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(31, 'Punjab', 'Bhatinda', 'Raman', 'Green Chilli', 'Other', '2022-08-19', '4700', '5000', '4900', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(32, 'Punjab', 'Bhatinda', 'Raman', 'Mango', 'Other', '2022-08-19', '6700', '7200', '6900', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(33, 'Punjab', 'Bhatinda', 'Raman', 'Onion', 'Other', '2022-08-19', '1250', '1340', '1300', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(34, 'Punjab', 'Bhatinda', 'Raman', 'Potato', 'Other', '2022-08-19', '1230', '1340', '1290', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(35, 'Punjab', 'Bhatinda', 'Raman', 'Tomato', 'Other', '2022-08-19', '2200', '2300', '2250', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(36, 'Punjab', 'Gurdaspur', 'Dera Baba Nanak', 'Ashgourd', 'Other', '2022-08-19', '1600', '1800', '1700', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(37, 'Punjab', 'Gurdaspur', 'Dera Baba Nanak', 'Bhindi(Ladies Finger)', 'Bhindi', '2022-08-19', '1500', '1700', '1600', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(38, 'Punjab', 'Gurdaspur', 'Dera Baba Nanak', 'Bitter gourd', 'Other', '2022-08-19', '1700', '1900', '1800', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(39, 'Punjab', 'Gurdaspur', 'Dera Baba Nanak', 'Brinjal', 'Round', '2022-08-19', '1600', '1800', '1700', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(40, 'Punjab', 'Gurdaspur', 'Dera Baba Nanak', 'Colacasia', 'Other', '2022-08-19', '1700', '1900', '1800', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(41, 'Punjab', 'Gurdaspur', 'Dera Baba Nanak', 'Cucumbar(Kheera)', 'Other', '2022-08-19', '1400', '1600', '1500', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(42, 'Punjab', 'Gurdaspur', 'Dera Baba Nanak', 'Pumpkin', 'Other', '2022-08-19', '1500', '1700', '1600', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(43, 'Punjab', 'Gurdaspur', 'Dinanagar', 'Apple', 'Apple', '2022-08-19', '6000', '8000', '7000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(44, 'Punjab', 'Gurdaspur', 'Dinanagar', 'Banana', 'Medium', '2022-08-19', '2200', '2600', '2400', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(45, 'Punjab', 'Gurdaspur', 'Dinanagar', 'Bhindi(Ladies Finger)', 'Bhindi', '2022-08-19', '2500', '3000', '3000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(46, 'Punjab', 'Gurdaspur', 'Dinanagar', 'Cauliflower', 'Cauliflower', '2022-08-19', '4000', '4500', '4500', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(47, 'Punjab', 'Gurdaspur', 'Dinanagar', 'Ginger(Green)', 'Green Ginger', '2022-08-19', '7000', '7000', '7000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(48, 'Punjab', 'Gurdaspur', 'Dinanagar', 'Green Chilli', 'Green Chilly', '2022-08-19', '2500', '3000', '3000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(49, 'Punjab', 'Gurdaspur', 'Dinanagar', 'Onion', 'Other', '2022-08-19', '1700', '1900', '1800', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(50, 'Punjab', 'Gurdaspur', 'Dinanagar', 'Papaya', 'Papaya', '2022-08-19', '3500', '4000', '3500', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(51, 'Punjab', 'Gurdaspur', 'Dinanagar', 'Potato', 'Potato', '2022-08-19', '1800', '2000', '1900', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(52, 'Punjab', 'Gurdaspur', 'Dinanagar', 'Tomato', 'Tomato', '2022-08-19', '3500', '4000', '3500', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(53, 'Punjab', 'kapurthala', 'Bhulath', 'Bhindi(Ladies Finger)', 'Bhindi', '2022-08-19', '3500', '3500', '3500', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(54, 'Punjab', 'kapurthala', 'Bhulath', 'Bitter gourd', 'Bitter Gourd', '2022-08-19', '2700', '2700', '2700', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(55, 'Punjab', 'kapurthala', 'Bhulath', 'Bottle gourd', 'Bottle Gourd', '2022-08-19', '2600', '2600', '2600', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(56, 'Punjab', 'kapurthala', 'Bhulath', 'Brinjal', 'Round/Long', '2022-08-19', '2300', '2300', '2300', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(57, 'Punjab', 'kapurthala', 'Bhulath', 'Colacasia', 'Colacasia', '2022-08-19', '2100', '2100', '2100', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(58, 'Punjab', 'kapurthala', 'Bhulath', 'Pumpkin', 'Pumpkin', '2022-08-19', '2400', '2400', '2400', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(59, 'Punjab', 'kapurthala', 'Bhulath', 'Ridgeguard(Tori)', 'Ridgeguard(Tori)', '2022-08-19', '2200', '2200', '2200', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(60, 'Punjab', 'kapurthala', 'Bhulath (Nadala)', 'Bhindi(Ladies Finger)', 'Bhindi', '2022-08-19', '3500', '3500', '3500', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(61, 'Punjab', 'kapurthala', 'Bhulath (Nadala)', 'Bitter gourd', 'Bitter Gourd', '2022-08-19', '2700', '2700', '2700', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(62, 'Punjab', 'kapurthala', 'Bhulath (Nadala)', 'Brinjal', 'Brinjal', '2022-08-19', '2300', '2300', '2300', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(63, 'Punjab', 'kapurthala', 'Bhulath (Nadala)', 'Pumpkin', 'Pumpkin', '2022-08-19', '2400', '2400', '2400', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(64, 'Punjab', 'kapurthala', 'Bhulath (Nadala)', 'Ridgeguard(Tori)', 'Ridgeguard(Tori)', '2022-08-19', '2200', '2200', '2200', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(65, 'Punjab', 'Ludhiana', 'Doraha', 'Bhindi(Ladies Finger)', 'Other', '2022-08-19', '2500', '2500', '2500', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(66, 'Punjab', 'Ludhiana', 'Doraha', 'Capsicum', 'Capsicum', '2022-08-19', '6000', '6000', '6000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(67, 'Punjab', 'Ludhiana', 'Doraha', 'Cauliflower', 'Other', '2022-08-19', '3000', '4000', '3644', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(68, 'Punjab', 'Ludhiana', 'Doraha', 'Ginger(Green)', 'Green Ginger', '2022-08-19', '5000', '5000', '5000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(69, 'Punjab', 'Ludhiana', 'Doraha', 'Green Chilli', 'Other', '2022-08-19', '2500', '4000', '3649', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(70, 'Punjab', 'Ludhiana', 'Doraha', 'Onion', 'Other', '2022-08-19', '1500', '1800', '1723', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(71, 'Punjab', 'Ludhiana', 'Doraha', 'Potato', 'Other', '2022-08-19', '1400', '2000', '1649', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(72, 'Punjab', 'Ludhiana', 'Doraha', 'Tomato', 'Other', '2022-08-19', '2600', '4000', '3264', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(73, 'Punjab', 'Ludhiana', 'Ludhiana', 'Apple', 'Other', '2022-08-19', '2000', '8200', '6000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(74, 'Punjab', 'Ludhiana', 'Ludhiana', 'Ashgourd', 'Other', '2022-08-19', '1000', '1300', '1200', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(75, 'Punjab', 'Ludhiana', 'Ludhiana', 'Bhindi(Ladies Finger)', 'Other', '2022-08-19', '600', '1300', '800', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(76, 'Punjab', 'Ludhiana', 'Ludhiana', 'Bitter gourd', 'Other', '2022-08-19', '600', '1400', '1000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(77, 'Punjab', 'Ludhiana', 'Ludhiana', 'Capsicum', 'Other', '2022-08-19', '800', '1800', '1200', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(78, 'Punjab', 'Ludhiana', 'Ludhiana', 'Carrot', 'Other', '2022-08-19', '1000', '1200', '1100', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(79, 'Punjab', 'Ludhiana', 'Ludhiana', 'Colacasia', 'Other', '2022-08-19', '1000', '1600', '1300', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(80, 'Punjab', 'Ludhiana', 'Ludhiana', 'Cucumbar(Kheera)', 'Other', '2022-08-19', '400', '1000', '700', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(81, 'Punjab', 'Ludhiana', 'Ludhiana', 'Garlic', 'Other', '2022-08-19', '1000', '2000', '1500', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(82, 'Punjab', 'Ludhiana', 'Ludhiana', 'Ginger(Dry)', 'Other', '2022-08-19', '2000', '2500', '2300', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(83, 'Punjab', 'Ludhiana', 'Ludhiana', 'Grapes', 'Other', '2022-08-19', '2000', '4600', '3000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(84, 'Punjab', 'Ludhiana', 'Ludhiana', 'Green Chilli', 'Other', '2022-08-19', '500', '1500', '1000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(85, 'Punjab', 'Ludhiana', 'Ludhiana', 'Guava', 'Other', '2022-08-19', '1600', '3400', '2500', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(86, 'Punjab', 'Ludhiana', 'Ludhiana', 'Lemon', 'Other', '2022-08-19', '2500', '3000', '2700', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(87, 'Punjab', 'Ludhiana', 'Ludhiana', 'Mango', 'Other', '2022-08-19', '3000', '5000', '4000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(88, 'Punjab', 'Ludhiana', 'Ludhiana', 'Mousambi(Sweet Lime)', 'Other', '2022-08-19', '1200', '2600', '1800', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(89, 'Punjab', 'Ludhiana', 'Ludhiana', 'Onion', 'Other', '2022-08-19', '850', '1500', '1200', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(90, 'Punjab', 'Ludhiana', 'Ludhiana', 'Peas Wet', 'Other', '2022-08-19', '2500', '4500', '3500', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(91, 'Punjab', 'Ludhiana', 'Ludhiana', 'Pomegranate', 'Other', '2022-08-19', '1200', '5000', '3000', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(92, 'Punjab', 'Ludhiana', 'Ludhiana', 'Pumpkin', 'Other', '2022-08-19', '400', '1000', '700', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(93, 'Punjab', 'Ludhiana', 'Ludhiana', 'Raddish', 'Other', '2022-08-19', '1000', '1400', '1200', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(94, 'Punjab', 'Ludhiana', 'Ludhiana', 'Ridgeguard(Tori)', 'Other', '2022-08-19', '400', '1800', '1200', '2022-08-23 01:23:20', '2022-08-23 01:23:20'),
(95, 'Punjab', 'Ludhiana', 'Ludhiana', 'Tomato', 'Other', '2022-08-19', '2000', '6000', '4000', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(96, 'Punjab', 'Ludhiana', 'Ludhiana', 'Water Melon', 'Other', '2022-08-19', '700', '1800', '1200', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(97, 'Punjab', 'Ludhiana', 'Sahnewal', 'Cauliflower', 'Cauliflower', '2022-08-19', '4000', '4000', '4000', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(98, 'Punjab', 'Ludhiana', 'Sahnewal', 'Green Chilli', 'Green Chilly', '2022-08-19', '4000', '4000', '4000', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(99, 'Punjab', 'Ludhiana', 'Sahnewal', 'Onion', 'Onion', '2022-08-19', '1400', '1400', '1400', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(100, 'Punjab', 'Ludhiana', 'Sahnewal', 'Potato', 'Potato', '2022-08-19', '1300', '1300', '1300', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(101, 'Punjab', 'Ludhiana', 'Sahnewal', 'Tomato', 'Tomato', '2022-08-19', '2400', '2500', '2400', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(102, 'Punjab', 'Mansa', 'Mansa', 'Apple', 'Apple', '2022-08-19', '8500', '11500', '9000', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(103, 'Punjab', 'Mansa', 'Mansa', 'Banana', 'Banana - Ripe', '2022-08-19', '1900', '2400', '2000', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(104, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Apple', 'Apple', '2022-08-19', '4000', '5000', '4500', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(105, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Banana', 'Medium', '2022-08-19', '2000', '3000', '2500', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(106, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Bhindi(Ladies Finger)', 'Bhindi', '2022-08-19', '1500', '2000', '1800', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(107, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Bottle gourd', 'Bottle Gourd', '2022-08-19', '1500', '2000', '1800', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(108, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Brinjal', 'Brinjal', '2022-08-19', '1000', '1500', '1200', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(109, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Cabbage', 'Cabbage', '2022-08-19', '1500', '2500', '2000', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(110, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Capsicum', 'Capsicum', '2022-08-19', '3500', '4500', '4000', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(111, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Cauliflower', 'Other', '2022-08-19', '2000', '3000', '2500', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(112, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Colacasia', 'Colacasia', '2022-08-19', '1500', '2000', '1800', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(113, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Coriander(Leaves)', 'Coriander', '2022-08-19', '3000', '4000', '3500', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(114, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Cucumbar(Kheera)', 'Cucumbar', '2022-08-19', '1500', '2000', '1800', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(115, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Garlic', 'Garlic', '2022-08-19', '3000', '4000', '3500', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(116, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Ginger(Green)', 'Green Ginger', '2022-08-19', '3000', '4000', '3500', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(117, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Green Chilli', 'Green Chilly', '2022-08-19', '2000', '3000', '2500', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(118, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Mousambi(Sweet Lime)', 'Mousambi', '2022-08-19', '2000', '3000', '2500', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(119, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Onion', 'Onion', '2022-08-19', '1000', '1500', '1200', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(120, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Papaya', 'Papaya', '2022-08-19', '2000', '3000', '2500', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(121, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Peas Wet', 'Peas Wet', '2022-08-19', '6000', '7000', '6500', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(122, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Pineapple', 'Pine Apple', '2022-08-19', '2000', '3000', '2500', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(123, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Potato', 'Potato', '2022-08-19', '600', '800', '700', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(124, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Raddish', 'Raddish', '2022-08-19', '1000', '1500', '1200', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(125, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Ridgeguard(Tori)', 'Ridgeguard(Tori)', '2022-08-19', '1500', '2000', '1800', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(126, 'Punjab', 'Ropar (Rupnagar)', 'Morinda', 'Tomato', 'Deshi', '2022-08-19', '1500', '2000', '1800', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(127, 'Punjab', 'Sangrur', 'Ahmedgarh', 'Bottle gourd', 'Other', '2022-08-19', '2100', '2300', '2200', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(128, 'Punjab', 'Sangrur', 'Ahmedgarh', 'Cauliflower', 'Other', '2022-08-19', '3000', '3300', '3200', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(129, 'Punjab', 'Sangrur', 'Ahmedgarh', 'Ridgeguard(Tori)', 'Other', '2022-08-19', '1300', '1500', '1400', '2022-08-23 01:23:21', '2022-08-23 01:23:21'),
(130, 'Punjab', 'Amritsar', 'Mehta', 'Cabbage', 'Cabbage', '2022-08-31', '2100', '2100', '2100', '2022-08-31 06:40:44', '2022-08-31 08:30:02'),
(131, 'Punjab', 'Amritsar', 'Mehta', 'Carrot', 'Carrot', '2022-08-31', '2800', '2800', '2800', '2022-08-31 06:40:44', '2022-08-31 08:30:02'),
(132, 'Punjab', 'Bhatinda', 'Bhagta Bhai Ka', 'Apple', 'Other', '2022-08-31', '4200', '4200', '4200', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(133, 'Punjab', 'Bhatinda', 'Bhagta Bhai Ka', 'Banana', 'Other', '2022-08-31', '2500', '2500', '2500', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(134, 'Punjab', 'Bhatinda', 'Bhagta Bhai Ka', 'Bhindi(Ladies Finger)', 'Bhindi', '2022-08-31', '1900', '1900', '1900', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(135, 'Punjab', 'Bhatinda', 'Bhagta Bhai Ka', 'Brinjal', 'Other', '2022-08-31', '1600', '1600', '1600', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(136, 'Punjab', 'Bhatinda', 'Bhagta Bhai Ka', 'Cabbage', 'Other', '2022-08-31', '4000', '4000', '4000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(137, 'Punjab', 'Bhatinda', 'Bhagta Bhai Ka', 'Green Chilli', 'Other', '2022-08-31', '4100', '4100', '4100', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(138, 'Punjab', 'Bhatinda', 'Bhagta Bhai Ka', 'Onion', 'Other', '2022-08-31', '1600', '1600', '1600', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(139, 'Punjab', 'Bhatinda', 'Bhagta Bhai Ka', 'Potato', 'Other', '2022-08-31', '1300', '1300', '1300', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(140, 'Punjab', 'Bhatinda', 'Bhagta Bhai Ka', 'Pumpkin', 'Other', '2022-08-31', '1900', '1900', '1900', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(141, 'Punjab', 'Bhatinda', 'Bhagta Bhai Ka', 'Tomato', 'Other', '2022-08-31', '2000', '2000', '2000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(142, 'Punjab', 'Bhatinda', 'Maur', 'Apple', 'Apple', '2022-08-31', '4500', '4800', '4700', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(143, 'Punjab', 'Bhatinda', 'Maur', 'Banana', 'Banana - Ripe', '2022-08-31', '2500', '3200', '3000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(144, 'Punjab', 'Bhatinda', 'Maur', 'Bhindi(Ladies Finger)', 'Bhindi', '2022-08-31', '3200', '3600', '3400', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(145, 'Punjab', 'Bhatinda', 'Maur', 'Brinjal', 'Brinjal', '2022-08-31', '1200', '1500', '1400', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(146, 'Punjab', 'Bhatinda', 'Maur', 'Carrot', 'Other', '2022-08-31', '2500', '3000', '2800', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(147, 'Punjab', 'Bhatinda', 'Maur', 'Cauliflower', 'Cauliflower', '2022-08-31', '4500', '4800', '4600', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(148, 'Punjab', 'Bhatinda', 'Maur', 'Cowpea(Veg)', 'Cowpea (Veg)', '2022-08-31', '2500', '3000', '2800', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(149, 'Punjab', 'Bhatinda', 'Maur', 'Cucumbar(Kheera)', 'Cucumbar', '2022-08-31', '2800', '3500', '3000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(150, 'Punjab', 'Bhatinda', 'Maur', 'Ginger(Green)', 'Green Ginger', '2022-08-31', '4000', '4500', '4200', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(151, 'Punjab', 'Bhatinda', 'Maur', 'Green Chilli', 'Green Chilly', '2022-08-31', '5000', '6000', '5500', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(152, 'Punjab', 'Bhatinda', 'Maur', 'Guava', 'Guava', '2022-08-31', '4000', '5000', '4500', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(153, 'Punjab', 'Bhatinda', 'Maur', 'Onion', 'Other', '2022-08-31', '1500', '2000', '1800', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(154, 'Punjab', 'Bhatinda', 'Maur', 'Papaya', 'Other', '2022-08-31', '2800', '3200', '3000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(155, 'Punjab', 'Bhatinda', 'Maur', 'Potato', 'Other', '2022-08-31', '1000', '1400', '1200', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(156, 'Punjab', 'Bhatinda', 'Maur', 'Pumpkin', 'Pumpkin', '2022-08-31', '1500', '2000', '1800', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(157, 'Punjab', 'Bhatinda', 'Maur', 'Ridgeguard(Tori)', 'Ridgeguard(Tori)', '2022-08-31', '2500', '3000', '2800', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(158, 'Punjab', 'Bhatinda', 'Maur', 'Tomato', 'Other', '2022-08-31', '1500', '2000', '1800', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(159, 'Punjab', 'Bhatinda', 'Rampuraphul(Nabha Mandi)', 'Apple', 'Other', '2022-08-31', '4000', '7000', '5000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(160, 'Punjab', 'Bhatinda', 'Rampuraphul(Nabha Mandi)', 'Potato', 'Other', '2022-08-31', '800', '1100', '900', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(161, 'Punjab', 'Gurdaspur', 'Kalanaur', 'Cauliflower', 'Other', '2022-08-31', '4000', '4000', '4000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(162, 'Punjab', 'Gurdaspur', 'Kalanaur', 'Green Chilli', 'Green Chilly', '2022-08-31', '5000', '5000', '5000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(163, 'Punjab', 'Gurdaspur', 'Kalanaur', 'Tomato', 'Other', '2022-08-31', '5000', '5000', '5000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(164, 'Punjab', 'Jalandhar', 'Lohian Khas', 'Bhindi(Ladies Finger)', 'Other', '2022-08-31', '1100', '1300', '1200', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(165, 'Punjab', 'Jalandhar', 'Lohian Khas', 'Bitter gourd', 'Other', '2022-08-31', '800', '1000', '900', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(166, 'Punjab', 'Jalandhar', 'Lohian Khas', 'Brinjal', 'Other', '2022-08-31', '800', '1000', '900', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(167, 'Punjab', 'Jalandhar', 'Lohian Khas', 'Potato', 'Other', '2022-08-31', '600', '800', '700', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(168, 'Punjab', 'Jalandhar', 'Lohian Khas', 'Pumpkin', 'Other', '2022-08-31', '300', '500', '400', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(169, 'Punjab', 'Jalandhar', 'Lohian Khas', 'Ridgeguard(Tori)', 'Other', '2022-08-31', '1400', '1600', '1500', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(170, 'Punjab', 'Jalandhar', 'Lohian Khas', 'Round gourd', 'Other', '2022-08-31', '800', '1000', '900', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(171, 'Punjab', 'Jalandhar', 'Lohian Khas', 'Spinach', 'Other', '2022-08-31', '400', '600', '500', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(172, 'Punjab', 'Jalandhar', 'Lohian Khas', 'Tomato', 'Other', '2022-08-31', '1000', '1200', '1100', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(173, 'Punjab', 'Mohali', 'Lalru', 'Bhindi(Ladies Finger)', 'Other', '2022-08-31', '1700', '1700', '1700', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(174, 'Punjab', 'Mohali', 'Lalru', 'Bottle gourd', 'Other', '2022-08-31', '500', '1000', '1000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(175, 'Punjab', 'Mohali', 'Lalru', 'Brinjal', 'Other', '2022-08-31', '1200', '1200', '1200', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(176, 'Punjab', 'Mohali', 'Lalru', 'Cauliflower', 'Other', '2022-08-31', '3500', '4200', '4000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(177, 'Punjab', 'Mohali', 'Lalru', 'Colacasia', 'Other', '2022-08-31', '1800', '2000', '2000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(178, 'Punjab', 'Mohali', 'Lalru', 'French Beans (Frasbean)', 'French Beans (Frasbean)', '2022-08-31', '2500', '2500', '2500', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(179, 'Punjab', 'Mohali', 'Lalru', 'Garlic', 'Average', '2022-08-31', '2500', '2500', '2500', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(180, 'Punjab', 'Mohali', 'Lalru', 'Green Chilli', 'Other', '2022-08-31', '2000', '4000', '3500', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(181, 'Punjab', 'Mohali', 'Lalru', 'Onion', 'Other', '2022-08-31', '1200', '1500', '1500', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(182, 'Punjab', 'Mohali', 'Lalru', 'Peas Wet', 'Other', '2022-08-31', '12000', '12000', '12000', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(183, 'Punjab', 'Mohali', 'Lalru', 'Potato', 'Other', '2022-08-31', '1000', '1700', '1200', '2022-08-31 06:40:44', '2022-08-31 08:30:03'),
(184, 'Punjab', 'Mohali', 'Lalru', 'Pumpkin', 'Other', '2022-08-31', '1200', '1700', '1700', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(185, 'Punjab', 'Mohali', 'Lalru', 'Ridgeguard(Tori)', 'Other', '2022-08-31', '1000', '1000', '1000', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(186, 'Punjab', 'Mohali', 'Lalru', 'Spinach', 'Other', '2022-08-31', '800', '2000', '2000', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(187, 'Punjab', 'Mohali', 'Lalru', 'Tomato', 'Other', '2022-08-31', '1600', '2000', '2000', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(188, 'Punjab', 'Patiala', 'Dudhansadhan', 'Apple', 'Other', '2022-08-31', '6000', '6500', '6200', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(189, 'Punjab', 'Patiala', 'Dudhansadhan', 'Banana', 'Other', '2022-08-31', '3300', '3500', '3400', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(190, 'Punjab', 'Patiala', 'Dudhansadhan', 'Bhindi(Ladies Finger)', 'Other', '2022-08-31', '2500', '3000', '2700', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(191, 'Punjab', 'Patiala', 'Dudhansadhan', 'Bottle gourd', 'Other', '2022-08-31', '1800', '2200', '2000', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(192, 'Punjab', 'Patiala', 'Dudhansadhan', 'Brinjal', 'Other', '2022-08-31', '1200', '1500', '1400', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(193, 'Punjab', 'Patiala', 'Dudhansadhan', 'Cauliflower', 'Other', '2022-08-31', '4000', '4500', '4200', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(194, 'Punjab', 'Patiala', 'Dudhansadhan', 'Mousambi(Sweet Lime)', 'Other', '2022-08-31', '4500', '5000', '4800', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(195, 'Punjab', 'Patiala', 'Dudhansadhan', 'Onion', 'Other', '2022-08-31', '1700', '2000', '1800', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(196, 'Punjab', 'Patiala', 'Dudhansadhan', 'Papaya', 'Other', '2022-08-31', '3500', '4000', '3700', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(197, 'Punjab', 'Patiala', 'Dudhansadhan', 'Potato', 'Other', '2022-08-31', '1800', '2200', '2000', '2022-08-31 06:40:45', '2022-08-31 08:30:03'),
(198, 'Punjab', 'Patiala', 'Dudhansadhan', 'Tomato', 'Other', '2022-08-31', '2500', '3000', '2700', '2022-08-31 06:40:45', '2022-08-31 08:30:03');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '2014_10_12_000000_create_users_table', 1),
(10, '2014_10_12_100000_create_password_resets_table', 1),
(11, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2022_08_01_054423_create_roles_table', 1),
(13, '2022_08_03_084932_create_districts_table', 2),
(14, '2022_08_03_085005_create_cities_table', 3),
(15, '2019_12_14_000001_create_personal_access_tokens_table', 4),
(16, '2022_08_04_105624_create_caste_categories_table', 5),
(17, '2022_08_04_105607_create_applicant_types_table', 6),
(20, '2022_08_06_055751_create_scheme_categories_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(3, 'App\\Models\\User', 2, 'auth_token', '18e01f96ec9f9b13ab181d52976990e9cbbd8a3566a29d89a76f3e712f8fc0e4', '[\"*\"]', NULL, '2022-08-05 23:39:50', '2022-08-05 23:39:50'),
(4, 'App\\Models\\User', 2, 'auth_token', '7aadbd6c2ce62d024a4458da987608f14160c009747c21c61590e898af5ddcaa', '[\"*\"]', '2022-08-17 05:09:54', '2022-08-08 00:28:48', '2022-08-17 05:09:54'),
(5, 'App\\Models\\User', 3, 'auth_token', 'd7b01de901ec3ead9e6cbd3810d29f9cd80352185ee4e0560addc7f361a83ae2', '[\"*\"]', '2022-08-17 05:56:59', '2022-08-16 00:07:31', '2022-08-17 05:56:59'),
(6, 'App\\Models\\User', 4, 'auth_token', 'd3d637bc8e59f593bf763549de81e724963960188506a5a89acc25e4f563d249', '[\"*\"]', NULL, '2022-08-17 04:38:49', '2022-08-17 04:38:49'),
(7, 'App\\Models\\User', 3, 'auth_token', '9d9e4ed4e3e484711f33a06c558ba3111f0fd846870911b653610dd80a91d524', '[\"*\"]', '2022-08-18 04:37:51', '2022-08-17 04:44:05', '2022-08-18 04:37:51'),
(8, 'App\\Models\\User', 2, 'auth_token', '02143394c8e5a465cb8ed37f5e85d9b1e722f9f8ab9b528d1696d3dfd4ac2000', '[\"*\"]', '2022-08-31 11:29:41', '2022-08-18 04:38:44', '2022-08-31 11:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2022-08-02 04:06:30', NULL),
(2, 'Farmer', '2022-08-02 07:46:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schemes`
--

CREATE TABLE `schemes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheme_subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `scheme_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subsidy` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_norms` decimal(10,2) NOT NULL,
  `terms` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `detailed_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `videos` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `videos_title` longtext COLLATE utf8mb4_unicode_ci,
  `scheme_image` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector` longtext COLLATE utf8mb4_unicode_ci,
  `sector_description` longtext COLLATE utf8mb4_unicode_ci,
  `is_featured` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schemes`
--

INSERT INTO `schemes` (`id`, `scheme_subcategory_id`, `scheme_name`, `subsidy`, `cost_norms`, `terms`, `detailed_description`, `videos`, `videos_title`, `scheme_image`, `sector`, `sector_description`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 2, 'Rejuvenation', '45-100', '40000.00', '[\"Terms Title\"]', 'Test Description', '[\"http:\\/\\/commondatastorage.googleapis.com\\/gtv-videos-bucket\\/sample\\/ElephantsDream.mp4\"]', '[\"Test Video1\"]', '', '[\"Subsidy Title\"]', '[\"Sector Description\"]', '1', '2022-08-08 09:30:00', '2022-08-22 23:23:36'),
(2, 1, 'Test', '45-100', '34536.00', '[\"Term 1\",\"Term 2\"]', 'Test', '[\"http:\\/\\/commondatastorage.googleapis.com\\/gtv-videos-bucket\\/sample\\/ElephantsDream.mp4\",\"http:\\/\\/commondatastorage.googleapis.com\\/gtv-videos-bucket\\/sample\\/ElephantsDream.mp4\"]', '[\"Test Video1\",\"Test Video2\"]', '180X180.png', '[\"Test\",\"Test\",\"Test\"]', '[\"1\",\"2\",\"3\"]', '0', '2022-08-12 03:26:48', '2022-08-22 07:31:30');

-- --------------------------------------------------------

--
-- Table structure for table `scheme_categories`
--

CREATE TABLE `scheme_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `govt_scheme_id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scheme_categories`
--

INSERT INTO `scheme_categories` (`id`, `govt_scheme_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 2, 'MIDH', '2022-08-07 04:00:00', '2022-08-31 06:44:05'),
(2, 1, 'AIF', '2022-08-07 04:00:00', '2022-08-22 22:17:32'),
(3, 2, 'New Central Scheme', '2022-08-22 22:12:48', '2022-08-22 22:12:48');

-- --------------------------------------------------------

--
-- Table structure for table `scheme_sub_categories`
--

CREATE TABLE `scheme_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheme_category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scheme_sub_categories`
--

INSERT INTO `scheme_sub_categories` (`id`, `scheme_category_id`, `subcategory_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Rejuvenation', '2022-08-07 09:30:00', '2022-08-11 03:14:45'),
(2, 1, 'Organic Farming', '2022-08-07 09:30:00', '2022-08-07 09:30:00'),
(3, 2, 'New Category', '2022-08-22 22:10:20', '2022-08-22 22:10:33');

-- --------------------------------------------------------

--
-- Table structure for table `tehsils`
--

CREATE TABLE `tehsils` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `tehsil_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tehsils`
--

INSERT INTO `tehsils` (`id`, `district_id`, `tehsil_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Amritsar -I', '2022-08-04 09:30:00', '2022-08-10 05:49:43'),
(2, 1, 'Baba Bakala', '2022-08-04 09:30:00', '2022-08-04 09:30:00'),
(3, 2, 'Jalandhar – I', '2022-08-04 08:59:20', '2022-08-04 09:30:00'),
(4, 2, 'Jalandhar – II', '2022-08-04 09:30:00', '2022-08-04 09:30:00'),
(5, 2, 'test', '2022-08-10 05:14:11', '2022-08-10 05:16:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'sonali@agnext.in', NULL, '$2y$10$bFjL7BLl1TPIKolAyhqsR.lm7DJCyoHpyI.nwx.9V5jptXCNRK8eS', '2ES9qd2CHsKCGPMPoElqxMxFKcOjpEYyyajRneMJwmQxb2RW19q0IrcKxjt5', '2022-08-02 03:49:13', '2022-08-22 07:25:37'),
(2, 2, '4565767776', '4565767776@gmail.com', NULL, '$2y$10$5BtgwCVa5i.vBhxpcZw3tOdv6Okyl/XHRuGUfPgwGdZEG8M2ofgle', 'pspXd2Ed861ZmWx7lo3apbfwGUyHvZEBZEr6j8PIKf8yqca4djsftGMSqRB7', '2022-08-05 01:22:15', '2022-08-17 04:19:01'),
(3, 2, '4565767778', '4565767778@gmail.com', NULL, '$2y$10$C0ILcNhhsHETqyHW.Vg2rerwK1GYpppIPm1NHa5MLgyYHEflPpgIe', NULL, '2022-08-17 04:44:05', '2022-08-17 04:44:05'),
(4, 2, '5678900000', '5678900000@gmail.com', NULL, '$2y$10$Fdyx1rDxwv.GfafIQEoezu.TV21gp67Fw78lxJZhsfdbIXrfYfR7G', NULL, '2022-08-22 07:10:50', '2022-08-22 23:15:48');

-- --------------------------------------------------------

--
-- Table structure for table `youtube_videos`
--

CREATE TABLE `youtube_videos` (
  `id` int(11) NOT NULL,
  `video_id` varchar(255) NOT NULL,
  `etag` varchar(255) NOT NULL,
  `channel_id` varchar(255) NOT NULL,
  `title` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `thumbnail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` varchar(255) NOT NULL,
  `publish_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `youtube_videos`
--

INSERT INTO `youtube_videos` (`id`, `video_id`, `etag`, `channel_id`, `title`, `description`, `thumbnail`, `views`, `publish_time`, `created_at`, `updated_at`) VALUES
(1, 'fUJ9y3VmiZA', 'AEYwDwvN0zoVK2NvUeo7D4N7FoY', 'UCnjxYF8TSTdBDf27ULeDR7Q', 'फसलों का डॉक्टर अब आपके मोबाइल में। FREE CROP DIAGNOSIS | PLANTIX APP | GET IT ON GOOGLE PLAY STORE', '𝐃𝐞𝐬𝐜𝐫𝐢𝐩𝐭𝐢𝐨𝐧 :-\nPlantix App Free Download: https://app.adjust.net.in/d5sevsh\n\nHeal your crops and reap higher yields with the Plantix App! \n\nPlantix turns your Android phone into a mobile crop doctor with which you can accurately detect pests and diseases on crops within seconds. Plantix serves as a complete solution for crop production and management. \n\nThe Plantix app covers 30 major crops and detects 400+ plant damages — just by taking a photo of a sick crop. It’s available in 18 languages and has been downloaded more than 10 million times . This makes Plantix the #1 agricultural app for damage detection, pest and disease control, and yield improvement for farmers worldwide.\n\nप्लांटिक्स ऐप मुफ्त डाउनलोड: https://app.adjust.net.in/d5sevsh\n\nप्लांटिक्स ऐप से अपनी फ़सलों को ठीक करें और अधिक पैदावार प्राप्त करें!\n\nप्लांटिक्स आपके एंड्रॉइड फोन को मोबाइल क्रॉप डॉक्टर में बदल देता है जिसके साथ आप सेकंड के भीतर फसलों पर कीटों और बीमारियों का सटीक पता लगा सकते हैं। प्लांटिक्स फसल उत्पादन और प्रबंधन के लिए एक संपूर्ण समाधान के रूप में कार्य करता है।\n\nHeal your crops and reap higher yields with the Plantix App!\nVisit our website at\nhttps://www.plantix.net\nJoin us on Facebook at\nhttps://www.facebook.com/plantix\n\nWhat Plantix Offers\n\n🌾 Heal Your Crop:\nDetect pests and diseases on crops and get recommended treatments\n⚠️ Disease Alerts:\nBe the first to know when a disease is about to strike in your district\n💬 Farmer Community:\nAsk crop-related questions and get answers from 500+ community experts\n💡 Cultivation Tips:\nFollow effective agricultural practices throughout your whole crop cycle\n⛅ Agri Weather Forecast:\nKnow the best time to weed, spray and harvest\n🧮 Fertilizer Calculator:\nCalculate fertilizer demands for your crop based on the plot size\nDiagnose and Treat Crop Issues\nWhether your crops are suffering from a pest, disease or nutrient deficiency, just by clicking a picture of it with the Plantix app you will get a diagnosis and suggested treatments within seconds.', 'https://i.ytimg.com/vi/fUJ9y3VmiZA/hqdefault.jpg', '6309', '2022-08-26 11:02:28', '2022-08-31 11:25:39', '2022-09-01 06:13:08'),
(2, 'nQAXvH-FneI', 'MSx7SaEypcI7TrSs8zg7xqq6mpA', 'UCuVuHrghkZeJHQTjesosDJA', 'क्या भाव हैं आज फूल का😀कमेंट कीजिये🌼#indianfarmer #shorts #farming #ganeshchaturthi #ganpati', 'क्या भाव हैं आज फूल का😀कमेंट कीजिये🌼 #indianfarmer #shorts #farming #ganeshchaturthi #ganpati #ganpatibappamorya #festival #shortvideo #agriculture \n\n---------------------------------------------------- \n\nFOLLOW ME ON:\n📸 Instagram: https://www.instagram.com/indianfarmer/\n📧MAIL: indianfarmer94@gmail.com\n🏪MY STORE: https://amzn.to/3iqNwzy\n🔗For More: https://linktr.ee/indianfarmer\n\n#indianfarmer #farming #shortvideo\n\nMusic by - http://audionautix.com/', 'https://i.ytimg.com/vi/nQAXvH-FneI/hqdefault.jpg', '27123', '2022-08-31 05:30:05', '2022-08-31 10:55:02', '2022-09-01 06:05:12'),
(3, 'sUzxy3-UR0I', 'C6cTdXLqZAitUWcAvgJWsjysIIg', 'UCnjxYF8TSTdBDf27ULeDR7Q', 'मक्खियों की नस्ल खत्म करने वाली तकनीक Fly trap 📱9811000194 📞9810701073', '', 'https://i.ytimg.com/vi/sUzxy3-UR0I/hqdefault.jpg', '2427', '2022-09-01 03:30:17', '2022-09-01 05:30:47', '2022-09-01 06:13:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicant_types`
--
ALTER TABLE `applicant_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bkscheme_categories`
--
ALTER TABLE `bkscheme_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `caste_categories`
--
ALTER TABLE `caste_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_tehsil_id` (`tehsil_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farmers`
--
ALTER TABLE `farmers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `farmers_user_id` (`user_id`),
  ADD KEY `farmers_applicant_type_id` (`applicant_type_id`),
  ADD KEY `farmers_caste_category_id` (`caste_category_id`),
  ADD KEY `farmers_district_id` (`district_id`),
  ADD KEY `farmers_tehsil_id` (`tehsil_id`),
  ADD KEY `farmers_city_id` (`city_id`);

--
-- Indexes for table `govt_schemes`
--
ALTER TABLE `govt_schemes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `market_prices`
--
ALTER TABLE `market_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schemes`
--
ALTER TABLE `schemes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schemes_scheme_subcategory_id` (`scheme_subcategory_id`);

--
-- Indexes for table `scheme_categories`
--
ALTER TABLE `scheme_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scheme_sub_categories`
--
ALTER TABLE `scheme_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schemes_scheme_category_id` (`scheme_category_id`);

--
-- Indexes for table `tehsils`
--
ALTER TABLE `tehsils`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tehsils_district_id` (`district_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id` (`role_id`);

--
-- Indexes for table `youtube_videos`
--
ALTER TABLE `youtube_videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `applicant_types`
--
ALTER TABLE `applicant_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bkscheme_categories`
--
ALTER TABLE `bkscheme_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `caste_categories`
--
ALTER TABLE `caste_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `farmers`
--
ALTER TABLE `farmers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `govt_schemes`
--
ALTER TABLE `govt_schemes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `market_prices`
--
ALTER TABLE `market_prices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `schemes`
--
ALTER TABLE `schemes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `scheme_categories`
--
ALTER TABLE `scheme_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `scheme_sub_categories`
--
ALTER TABLE `scheme_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tehsils`
--
ALTER TABLE `tehsils`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `youtube_videos`
--
ALTER TABLE `youtube_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_tehsil_id` FOREIGN KEY (`tehsil_id`) REFERENCES `tehsils` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `farmers`
--
ALTER TABLE `farmers`
  ADD CONSTRAINT `farmers_applicant_type_id` FOREIGN KEY (`applicant_type_id`) REFERENCES `applicant_types` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `farmers_caste_category_id` FOREIGN KEY (`caste_category_id`) REFERENCES `caste_categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `farmers_city_id` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `farmers_district_id` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `farmers_tehsil_id` FOREIGN KEY (`tehsil_id`) REFERENCES `tehsils` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `farmers_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `schemes`
--
ALTER TABLE `schemes`
  ADD CONSTRAINT `schemes_scheme_subcategory_id` FOREIGN KEY (`scheme_subcategory_id`) REFERENCES `scheme_sub_categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `scheme_sub_categories`
--
ALTER TABLE `scheme_sub_categories`
  ADD CONSTRAINT `schemes_scheme_category_id` FOREIGN KEY (`scheme_category_id`) REFERENCES `scheme_categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tehsils`
--
ALTER TABLE `tehsils`
  ADD CONSTRAINT `tehsils_district_id` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
