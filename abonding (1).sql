-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 05:10 PM
-- Server version: 9.1.0
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abonding`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--_general_

CREATE TABLE `about_us` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `company_description` text,
  `vision` text,
  `mission` text,
  `process` text,
  `strengths` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `title`, `company_description`, `vision`, `mission`, `process`, `strengths`, `created_at`, `updated_at`) VALUES
(1, 'About Abonding', 'We “ ABONDING”, introducing our self as a Manufacturer and Supplier of various type of Lab products which included Lab Furniture, Lab Equipment, Consumables, Food / Feed / Water / Milk / Beverages Testing kits and Instruments. We are offering International standard products. \r\nOur team of skilled and experienced personnel and professional environment provided by us is helpful in the fostering our quality products and attaining customer satisfaction.\r\nNo wonder, I feel so glad and fulfilling to realize the fact that our company is able to be a part of millions of lives in India through our food related products in their everyday use.\r\n         Also we provide consulting/Testing/certification services for Food, Feed, Water, Dairy, Beverage and Agri products.\r\n            Our clients list included Food Processing and Manufacturing Industries, Feed Manufacturers, Meat Processing industries, Sea Food Company, Dairy Industries, Beverage Industries, Food Testing Labs, Educational Institutions, Colleges, Hospitals, Research Organizations, All types of Analytical Labs all types of Industries,  Atomic Power Plants, Space and Defense Organizations.\r\n \r\n', 'To become the preferred Global Conglomerate offering unique and value added solutions to Food Industries and mankind to their delight.', 'To provide unique and value added solutions through innovation and solution orientation with excellence customer service.', 'Our rigorous process ensures quality at every step', 'Experienced team, Quality products, Customer focus, Industry expertise, Innovative solutions', '2025-05-21 15:11:22', '2025-05-22 12:28:52');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password_hash`, `full_name`, `email`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User', 'admin@abonding.com', 1, NULL, '2025-05-21 15:12:14', '2025-05-21 15:12:14');

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`id`, `name`, `image_path`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Food Safety Excellence Award', 'https://abonding.com/public/assets/img/award1.jpg', 'Recognized for excellence in food safety standards', 1, '2025-05-21 15:11:04', '2025-05-21 15:11:04'),
(3, 'Best Brix Consistency Recognition', 'https://abonding.com/public/assets/img/award1.jpg', 'Recognized for maintaining best Brix consistency', 1, '2025-05-21 15:11:04', '2025-05-21 15:11:04'),
(4, 'Allergen-Free Product Innovator', 'https://abonding.com/public/assets/img/award1.jpg', 'Awarded for innovation in allergen-free products', 1, '2025-05-21 15:11:04', '2025-05-21 15:11:04'),
(5, 'sdfbsdefbgsfdg', 'uploads/awards/682f1bbb41989_22CS404 - 108.jpg', 'WEFAWEFSEW ERGDRFTG SERG ERG WSER ', 1, '2025-05-22 12:42:35', '2025-05-22 12:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `is_read`, `created_at`) VALUES
(1, 'shgsrth', 'sergtsergserg@gmail.com', '9873426534', 'dtgjhd', 'srthdrthdrt', 0, '2025-05-23 15:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

CREATE TABLE `industries` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `industries`
--

INSERT INTO `industries` (`id`, `name`, `description`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Dairy', 'Dairy industry solutions', 'uploads/industries/682f3eb50f24f_Screenshot 2024-11-21 105114.png', 1, '2025-05-21 15:10:57', '2025-05-22 15:11:49'),
(2, 'Bakery', 'Bakery industry solutions', 'uploads/industries/682f3ea360ebc_Screenshot 2024-02-08 101529.png', 1, '2025-05-21 15:10:57', '2025-05-22 15:11:31'),
(3, 'Confectionery', 'Confectionery industry solutions', 'uploads/industries/682f3eaad3eb8_Screenshot (1).png', 1, '2025-05-21 15:10:57', '2025-05-22 15:11:38'),
(4, 'Water Treatment', 'Water treatment solutions', 'uploads/industries/682f3ec63bb1d_Screenshot 2024-11-21 104934.png', 1, '2025-05-21 15:10:57', '2025-05-22 15:12:06'),
(5, 'Detergent Chemicals', 'Detergent chemical solutions', 'uploads/industries/682f3e99a9e92_Screenshot 2024-02-10 155318.png', 1, '2025-05-21 15:10:57', '2025-05-22 15:11:21'),
(6, 'Leather Processing', 'Leather processing solutions', 'uploads/industries/682f3ebdeeee2_Screenshot 2024-11-09 135248.png', 1, '2025-05-21 15:10:57', '2025-05-22 15:11:57'),
(7, 'ASERGWSERG', 'GERG WER TGEWRG ERG ERTG RSD GSDREG ', 'uploads/industries/682f1c80c2ec6_22CS404 - 109.jpg', 1, '2025-05-22 12:45:52', '2025-05-22 12:45:52');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text,
  `link` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `image_path`, `description`, `link`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 4, 'SERGSER', 'uploads/products/682f2cad276bf_22CS404_-_108.jpg', 'GSEGSER', 'https://abonding.com/#', 1, '2025-05-22 13:54:53', '2025-05-22 13:54:53'),
(2, 11, 'aswgfasf', 'uploads/products/682f2cc9bc57f_22CS404_-_109.jpg', 'asfasdf', '', 1, '2025-05-22 13:55:21', '2025-05-22 13:55:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text,
  `applications` text,
  `benefits` text,
  `manufacturer` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `image_path`, `description`, `applications`, `benefits`, `manufacturer`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Dairy', 'uploads/product_categories/682f3dc391215_Screenshot 2024-02-08 101529.png', 'Aflatoxin M1 / Microbial / Hygiene Monitoring System / Enzymes / Antibiotics / Adultration Testing Kits and Equipment, Vitamins, Starter Cultures UHT – Milk (Special vial), sterility testing, Shelf-life testing, Challenge testing.', NULL, NULL, NULL, 1, '2025-05-21 15:10:50', '2025-05-22 15:07:47'),
(2, 'Feeds', 'uploads/product_categories/682f3dda46aa4_Screenshot 2024-11-23 122448.png', 'Mycotoxin (Aflatoxin / Ochratoxins, Fumonisins, Trichothecenes (T2/Ht2), Deoxynivalenol (DON), and Zearalenone), Microbial, Pathogens, Enzymes Testing Kits and Equipment, Toxin Binder / Vitamins / Minerals / Yeast / Natural Antibiotics / Probiotics / Raw Materials (Corn).', NULL, NULL, NULL, 1, '2025-05-21 15:10:50', '2025-05-22 15:08:10'),
(3, 'Foods', 'uploads/product_categories/682f3de67d69b_Screenshot 2025-01-07 092315.png', 'Food: Aflatoxin / Ochratoxin, Allergens (Almond, Peanut, Total Milk, Egg, Soy, Sesame, Coconut, Mustard, Crustacea, Hazelnut, Gluten etc.), Microbial (Aerobic Count, E-Coli, Coliform, Enterobacteriaceae, Yeast and Mould, Lactic Acid Bacteria, Staphylococcus Aureus, Aqua Heterophic, Salmonella, Listeria, E-Coli O157, Campylobacter, Cronobacter, STEC & STEC stx), Hygiene Monitoring System, Pesticides Residue / Insecticides Residue / Heavy Metals Residue.', NULL, NULL, NULL, 1, '2025-05-21 15:10:50', '2025-05-22 15:08:22'),
(4, 'Beverage', 'uploads/product_categories/682f3db86d91b_Screenshot 2024-11-22 150124.png', 'Beverages: TVC, Coliform, E. coli, Enterobacteriaceae, Alicyclobacillus, Gram Negative, Lactic Acid, Staphylococcus, Pseudomonas, Orange Serum Broth, Salmonella spp', NULL, NULL, NULL, 1, '2025-05-21 15:10:50', '2025-05-22 15:07:36'),
(5, 'Mycotoxin', 'uploads/product_categories/683073151cab5_Screenshot 2025-04-03 134131.png', 'Mycotoxins are naturally occurring toxins produced by certain molds found in food and feed. They can cause serious health problems in both humans and animals. This product helps in the effective detection and control of mycotoxins, ensuring food and feed safety. It is a vital tool for regulatory compliance and maintaining public health standards.', 'Food and Feed Industry', 'Reduces toxin levels, improves safety', 'AgroTech Solutions', 1, '2025-05-21 15:11:30', '2025-05-23 13:07:33'),
(6, 'Allergens', 'uploads/product_categories/682f3d97cde0d_Screenshot 2024-11-22 145804.png', 'Allergens are substances that can provoke allergic reactions, posing serious health risks to sensitive individuals. This product is designed to detect and help eliminate common food and pharmaceutical allergens. It plays a crucial role in ensuring product labeling accuracy and regulatory compliance. Ideal for manufacturers aiming to deliver allergen-free, consumer-safe products.', 'Food and Pharmaceutical Industry', 'Ensures allergen-free products', 'BioSafe Inc.', 1, '2025-05-21 15:11:30', '2025-05-23 12:36:22'),
(7, 'Microbial', 'uploads/product_categories/6830735e0079f_Screenshot 2025-04-21 093208.png', 'Microbial contamination can compromise product quality and pose health risks. This product enables the detection and control of a wide range of microorganisms. It supports stringent hygiene protocols in research, healthcare, and industrial environments. Reliable and efficient, it enhances safety and operational standards.', 'Medical and Research Industry', 'Enhances safety and hygiene', 'MicroLabs Ltd.', 1, '2025-05-21 15:11:30', '2025-05-23 13:08:46'),
(8, 'Pathogens', 'uploads/product_categories/68307307c3f83_Screenshot 2024-11-20 141848.png', 'Pathogens are harmful microorganisms that can cause severe illnesses and contamination. This product helps in their identification and neutralization across healthcare and food sectors. It is engineered to meet modern safety standards, preventing outbreaks and ensuring public health. A critical component for food safety management and infection control programs.', 'Healthcare and Food Safety', 'Prevents infections and foodborne diseases', 'SafeHealth Solutions', 1, '2025-05-21 15:11:30', '2025-05-23 13:07:19'),
(9, 'Enzymes', 'uploads/product_categories/683072914a731_Screenshot 2024-11-19 143140.png', 'Enzymes are biological molecules that accelerate chemical reactions, essential in many industries. This product enhances processing efficiency in food production, pharmaceuticals, and biotech applications. It ensures consistent quality, improved yields, and sustainable practices. Highly effective under diverse conditions and scalable for various production needs.', 'Food Processing, Pharmaceuticals', 'Enhances digestion, improves efficiency', 'BioEnzyme Labs', 1, '2025-05-21 15:11:30', '2025-05-23 13:05:21'),
(10, 'Antibiotics', 'uploads/product_categories/682f3da7073b6_Screenshot 2024-10-23 161421.png', 'Antibiotics are key tools in treating bacterial infections in both humans and animals. This product provides a targeted and effective solution for combating pathogenic bacteria. It contributes to fast recovery, infection control, and improved patient outcomes. Formulated for optimal absorption and minimal resistance development.', 'Medical and Veterinary Industry', 'Treats bacterial infections', 'PharmaTech Ltd.', 1, '2025-05-21 15:11:30', '2025-05-23 12:45:19'),
(11, 'Adulteration', 'uploads/product_categories/682f3d8b036bf_Screenshot 2024-02-10 155318.png', 'Adulteration undermines food quality, safety, and consumer trust. This product is developed to detect a wide range of adulterants in food and chemical products. It aids manufacturers and regulators in maintaining purity and compliance with standards. An essential tool for quality assurance and consumer protection.', 'Food Quality Control', 'Ensures product purity', 'QualityCheck Solutions', 1, '2025-05-21 15:11:30', '2025-05-23 12:45:19'),
(12, 'Ingredients', 'uploads/product_categories/6830734e09d07_Screenshot 2024-11-22 180733.png', 'High-quality ingredients form the foundation of food and pharmaceutical products. This product includes a broad spectrum of essential raw materials meeting strict quality standards. It enhances product stability, taste, and efficacy. Backed by rigorous sourcing and testing protocols for superior performance.', 'Food and Drug Industry', 'Enhances product formulation', 'NutriTech Solutions', 1, '2025-05-21 15:11:30', '2025-05-23 13:08:30'),
(13, 'Toxin Binder', 'uploads/product_categories/683072b09ef45_Screenshot 2024-12-18 094228.png', 'Toxin binders play a critical role in animal nutrition by neutralizing harmful substances. This product binds mycotoxins and other contaminants in animal feed. It supports digestive health, boosts immunity, and improves livestock productivity. Safe, effective, and easy to incorporate into existing feeding programs.', 'Animal Feed Industry', 'Improves animal health', 'AgroCare Ltd.', 1, '2025-05-21 15:11:30', '2025-05-23 13:05:52'),
(14, 'Minerals', 'uploads/product_categories/6830732414155_Screenshot 2024-11-23 151608.png', 'Minerals are vital nutrients required for various physiological functions. This product delivers essential minerals that support growth, reproduction, and overall health. It is designed for use in both agricultural and dietary applications. Ensures balanced nutrition and long-term well-being.', 'Nutritional Supplements, Agriculture', 'Supports growth and metabolism', 'NutriLife Inc.', 1, '2025-05-21 15:11:30', '2025-05-23 13:07:48'),
(15, 'Vitamins', 'uploads/product_categories/683072bef101f_Screenshot 2025-01-06 112127.png', 'Vitamins are organic compounds that play crucial roles in maintaining health. This product provides a complete spectrum of vitamins to prevent deficiencies and enhance immunity. It supports growth, metabolism, and energy production. Formulated for maximum bioavailability and consistent results.', 'Pharmaceutical and Health Industry', 'Boosts immunity, prevents deficiencies', 'VitaHealth Solutions', 1, '2025-05-21 15:11:30', '2025-05-23 13:06:06'),
(16, 'Lab Furniture', 'uploads/product_categories/6830736d10c51_Screenshot 2024-11-21 152346.png', 'Specialized lab furniture is essential for safe and efficient laboratory operations. This product includes ergonomic and durable setups tailored for research and education labs. It improves workflow, minimizes contamination risks, and ensures long-term usability. Designed for flexibility, durability, and compliance with lab safety standards.', 'Research and Educational Labs', 'Enhances work efficiency', 'LabFurnish Ltd.', 1, '2025-05-21 15:11:30', '2025-05-23 13:09:01'),
(17, 'Equipment', 'uploads/product_categories/6830729eec36b_Screenshot 2024-04-22 102443.png', 'Scientific equipment is the backbone of accurate experimentation and diagnostics. This product line includes high-precision instruments for healthcare, research, and industry. Engineered for reliability, ease of use, and data integrity. Supports modern laboratory and field-based applications across disciplines.', 'Research, Industry, Healthcare', 'Improves accuracy and efficiency', 'TechLab Solutions', 1, '2025-05-21 15:11:30', '2025-05-23 13:05:34'),
(18, 'Pesticides Residue', 'uploads/product_categories/683072fbd962e_Screenshot 2024-11-09 141517.png', 'Pesticide residues in food can pose serious health threats to consumers. This product enables accurate detection of multiple pesticide types in agricultural produce. It ensures compliance with regulatory standards and consumer safety. A powerful tool for quality control and export assurance.', 'Agriculture and Food Safety', 'Ensures safe food consumption', 'AgriSafe Labs', 1, '2025-05-21 15:11:30', '2025-05-23 13:07:07'),
(19, 'Insecticide Residue', 'uploads/product_categories/6830737d3a7f3_Screenshot (1).png', 'Insecticide residues can contaminate food and disrupt ecosystems. This product helps identify and quantify insecticide traces in crops and the environment. It contributes to environmental safety, regulatory compliance, and public health. Recommended for agricultural labs, exporters, and food processors.', 'Agriculture, Environmental Safety', 'Prevents harmful chemical exposure', 'EcoCheck Solutions', 1, '2025-05-21 15:11:30', '2025-05-23 13:09:17'),
(20, 'Heavy Metals', 'uploads/product_categories/683073397adee_Screenshot 2025-01-07 085608.png', 'Heavy metals like lead and mercury pose significant risks to health and the environment. This product detects and quantifies toxic metal levels in various matrices. Essential for environmental monitoring, food safety, and industrial compliance. Offers accurate, repeatable results to support regulatory reporting.', 'Food, Water, Environmental Safety', 'Reduces health risks', 'SafeMetal Labs', 1, '2025-05-21 15:11:30', '2025-05-23 13:08:09'),
(21, 'Yeast', 'uploads/product_categories/683072e33e0f7_Screenshot 2024-02-08 101414.png', 'Yeast is a cornerstone in fermentation-based industries like baking and brewing. This product offers high-performance strains for consistent and efficient fermentation. It improves flavor profiles, texture, and nutritional value. Suitable for artisanal and industrial production alike.', 'Baking, Brewing, Biotechnology', 'Enhances product quality', 'BioFerment Ltd.', 1, '2025-05-21 15:11:30', '2025-05-23 13:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `footer_copyright` text,
  `contact_whatsapp` varchar(20) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `industries_description` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `logo_path`, `footer_copyright`, `contact_whatsapp`, `contact_phone`, `created_at`, `updated_at`, `industries_description`) VALUES
(1, 'Abonding', 'uploads/68307cb556f96_logo (1).png', 'Copyright 2024', '+919442576397', '+919442576397', '2025-05-21 15:09:14', '2025-05-23 13:48:37', 'Each year, hundreds of clients across the country, from many types of industries, rely on the expertise of Trading in food ingredients and industrial chemicals. Utilizing our vast network, technical know-how of products, business development strategies, customer orientation, as well as state-of-the-art branches and warehouses, we serve the leading manufacturing corporates with end-to-end marketing solutions.');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `title` text,
  `description` text,
  `button_text` varchar(50) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `display_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `image_path`, `title`, `description`, `button_text`, `button_link`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'uploads/sliders/682f33884bd41_Screenshot (4).png', 'Welcome to Abonding', 'One Stop Solution for Food / Feed/ Dairy/ Water & Beverages Industries Thank You for Visiting Our Website!', 'Read More', '/productrange', 1, 1, '2025-05-21 15:10:44', '2025-05-22 14:24:08'),
(2, 'uploads/sliders/682f3390f1f40_Screenshot 2024-02-08 101529.png', '50+ Years of Service', 'More than 5 decades of Dedicated Service to Industry', 'Read More', '/productrange', 1, 2, '2025-05-21 15:10:44', '2025-05-22 14:24:16'),
(3, 'uploads/sliders/682f33ad5c4b3_Screenshot 2024-11-19 143140.png', 'Industry Leaders', 'More than 5 decades of Dedicated Service to Industry', 'Read More', '/productrange', 1, 3, '2025-05-21 15:10:44', '2025-05-22 14:24:45'),
(4, 'uploads/sliders/682f2bbb921e2_22CS404 - 107.jpg', '', 'szdgfvr werg wer gersg ', 'Read More', 'https://abonding.com/#', 1, 1, '2025-05-22 13:50:51', '2025-05-22 13:50:51');

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

CREATE TABLE `statistics` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statistics`
--

INSERT INTO `statistics` (`id`, `name`, `value`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Turnover', '111Cr+', 'our Turnover(FY:2024-2025)', 1, '2025-05-21 15:11:15', '2025-05-21 15:11:15'),
(2, 'Products', '300+', 'Our Products', 1, '2025-05-21 15:11:15', '2025-05-21 15:11:15'),
(3, 'Clients', '3,500+', 'Our clients', 1, '2025-05-21 15:11:15', '2025-05-21 15:11:15'),
(4, 'Product Ranges', '20+', 'Our Product Ranges', 1, '2025-05-21 15:11:15', '2025-05-21 15:11:15'),
(5, 'Industries Served', '20+', 'Industries Served', 1, '2025-05-21 15:11:15', '2025-05-21 15:11:15'),
(6, 'Presence', '10+', 'Our Presence', 1, '2025-05-21 15:11:15', '2025-05-21 15:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `bio` text,
  `display_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `industries`
--
ALTER TABLE `industries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `industries`
--
ALTER TABLE `industries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `statistics`
--
ALTER TABLE `statistics`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
