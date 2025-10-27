-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 27, 2025 at 07:13 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinica_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `proforma_invoices`
--

CREATE TABLE `proforma_invoices` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `issue_date` date DEFAULT curdate(),
  `due_date` date DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'MZN',
  `subtotal` decimal(12,2) DEFAULT 0.00,
  `tax` decimal(12,2) DEFAULT 0.00,
  `total` decimal(12,2) DEFAULT 0.00,
  `status` enum('PENDING','APPROVED','CANCELLED') DEFAULT 'PENDING',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `proforma_invoices`
--

INSERT INTO `proforma_invoices` (`id`, `invoice_number`, `client_name`, `issue_date`, `due_date`, `currency`, `subtotal`, `tax`, `total`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'PF-000001', 'Aurelio', '2025-10-27', '2025-11-26', 'MZN', 1600.00, 256.00, 1856.00, 'PENDING', 'Felitos de consulta', '2025-10-27 06:17:34', '2025-10-27 06:17:34'),
(2, 'PF-000002', 'AZAM COMPANY', '2025-10-27', '2025-11-26', 'MZN', 4000.00, 640.00, 4640.00, 'PENDING', '', '2025-10-27 06:21:51', '2025-10-27 06:21:51'),
(3, 'PF-000003', 'Aurelio', '2025-10-27', '2025-11-26', 'MZN', 33.00, 5.28, 38.28, 'PENDING', 'ggg', '2025-10-27 08:10:58', '2025-10-27 08:10:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `proforma_invoices`
--
ALTER TABLE `proforma_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `proforma_invoices`
--
ALTER TABLE `proforma_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
