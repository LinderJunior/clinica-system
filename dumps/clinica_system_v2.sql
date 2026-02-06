-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 06-Fev-2026 às 14:27
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `clinica_system`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `client_weights`
--

CREATE TABLE `client_weights` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `height` decimal(4,2) NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `bmi` decimal(5,2) DEFAULT NULL,
  `classification` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `nameEntinty` varchar(50) NOT NULL,
  `nuit` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `consult`
--

CREATE TABLE `consult` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `consult`
--

INSERT INTO `consult` (`id`, `date`, `time`, `type`, `status`, `patient_id`, `doctor_id`) VALUES
(13, '2025-12-10', '10:10:00', 'Rotina', 0, 23, 16),
(14, '1997-10-02', '10:25:00', 'Rotina', 0, 23, 16),
(15, '0005-02-01', '02:15:00', 'Rotina', 1, 25, 16),
(16, '2002-12-10', '10:10:00', 'Triagem', 0, 25, 16),
(17, '2025-10-10', '10:10:00', 'Triagem', 0, 24, 16),
(18, '2025-02-01', '10:10:00', 'Triagem', 1, 24, 16),
(19, '2025-11-01', '10:10:00', 'Triagem', 2, 25, 16),
(20, '2025-11-04', '12:30:00', 'Triagem', 1, 24, 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `diagnosis`
--

CREATE TABLE `diagnosis` (
  `id` int(11) NOT NULL,
  `details` varchar(50) NOT NULL,
  `file` varchar(50) NOT NULL,
  `consult_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `bi` varchar(50) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL,
  `doctor` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `employee`
--

INSERT INTO `employee` (`id`, `name`, `bi`, `phoneNumber`, `doctor`) VALUES
(16, 'Candido Baltazar Actualizado', '025452502552B', '876700936', '1'),
(17, 'Manuela Virginia', '042504865236C', '845698569', '1'),
(18, 'Cristiano Ronaldo', '8456253856856L', '845056598', '1'),
(19, 'Medico Rosario', '0423653323526P', '845898569', '1'),
(20, 'Rosario Linder Narciso', '8564854523254C', '845658987', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `employee_position`
--

CREATE TABLE `employee_position` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `employee_position`
--

INSERT INTO `employee_position` (`id`, `position_id`, `employee_id`) VALUES
(38, 6, 16),
(40, 5, 19),
(41, 6, 19),
(44, 1, 20),
(45, 5, 20),
(46, 6, 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `medication`
--

CREATE TABLE `medication` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `dateProduction` date NOT NULL,
  `dateExpiry` date NOT NULL,
  `qty` int(11) NOT NULL,
  `loteNumber` int(11) NOT NULL,
  `purchasePrice` double NOT NULL,
  `salePrice` double NOT NULL,
  `registationDate` date NOT NULL,
  `description` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dateBirth` date NOT NULL,
  `bi` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `neighborhood` varchar(50) NOT NULL,
  `phoneNumber` varchar(9) NOT NULL,
  `iswhatsapp` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `patient`
--

INSERT INTO `patient` (`id`, `name`, `dateBirth`, `bi`, `province`, `city`, `neighborhood`, `phoneNumber`, `iswhatsapp`) VALUES
(23, 'Lourenco do Rosario Linder ', '2025-10-15', '845855658C', 'Zambézia', 'Quelimane', 'Filipe Samuel Magaia', '845898569', 2),
(24, 'Vanessa do Rosario Linder ', '2025-10-15', '845855658C', 'Zambézia', 'Quelimane', 'Filipe Samuel Magaia', '845898569', 2),
(25, 'Carolina Pedro', '2025-10-08', '845855658C', 'Zambézia', 'Quelimane', 'Janeiro', '856589856', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `type` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `position`
--

INSERT INTO `position` (`id`, `type`, `description`) VALUES
(1, 'Psicologo', 'Especialista formado em psicologia'),
(4, 'Analista clinico', 'Medico analista clinico para diversas patologias'),
(5, 'Cardiologista ', 'Cardiologista especializado '),
(6, 'Medico chefe', 'Medico chefe do Hospital');

-- --------------------------------------------------------

--
-- Estrutura da tabela `proforma_invoices`
--

CREATE TABLE `proforma_invoices` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `client_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `issue_date` date DEFAULT curdate(),
  `due_date` date DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'MZN',
  `subtotal` decimal(12,2) DEFAULT 0.00,
  `tax` decimal(12,2) DEFAULT 0.00,
  `total` decimal(12,2) DEFAULT 0.00,
  `status` enum('PENDING','APPROVED','CANCELLED') COLLATE utf8_unicode_ci DEFAULT 'PENDING',
  `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `proforma_invoices`
--

INSERT INTO `proforma_invoices` (`id`, `invoice_number`, `client_name`, `issue_date`, `due_date`, `currency`, `subtotal`, `tax`, `total`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(7, 'PF-000001', 'Rosario Linder', '2025-10-16', '2025-11-18', 'USD', '200.00', '32.00', '232.00', 'PENDING', 'Nova factura', '2025-10-30 15:06:06', '2025-10-30 15:06:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `proforma_items`
--

CREATE TABLE `proforma_items` (
  `id` int(11) NOT NULL,
  `proforma_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `unit_price` decimal(12,2) NOT NULL,
  `total_price` decimal(12,2) GENERATED ALWAYS AS (`quantity` * `unit_price`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `proforma_items`
--

INSERT INTO `proforma_items` (`id`, `proforma_id`, `description`, `quantity`, `unit_price`) VALUES
(7, 7, 'Desc factura', 1, '200.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `recipe`
--

CREATE TABLE `recipe` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `consult_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `recipe_medication`
--

CREATE TABLE `recipe_medication` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `medication_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `dosage` varchar(50) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `stock_movement`
--

CREATE TABLE `stock_movement` (
  `id` int(11) NOT NULL,
  `medication_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `movement_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `employee_id`, `role_id`) VALUES
(4, 'admin', '$2y$10$QGWI.6OyXCzLAPeZMHgH2.yFsAjq41xYfQOGhKINJrf6eWLzSxKJy', 1, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `client_weights`
--
ALTER TABLE `client_weights`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `consult`
--
ALTER TABLE `consult`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `employee_position`
--
ALTER TABLE `employee_position`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee` (`employee_id`),
  ADD KEY `fk_position` (`position_id`);

--
-- Índices para tabela `medication`
--
ALTER TABLE `medication`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `proforma_invoices`
--
ALTER TABLE `proforma_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`);

--
-- Índices para tabela `proforma_items`
--
ALTER TABLE `proforma_items`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `recipe_medication`
--
ALTER TABLE `recipe_medication`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `stock_movement`
--
ALTER TABLE `stock_movement`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `client_weights`
--
ALTER TABLE `client_weights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `consult`
--
ALTER TABLE `consult`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `diagnosis`
--
ALTER TABLE `diagnosis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `employee_position`
--
ALTER TABLE `employee_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `medication`
--
ALTER TABLE `medication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `proforma_invoices`
--
ALTER TABLE `proforma_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `proforma_items`
--
ALTER TABLE `proforma_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `recipe_medication`
--
ALTER TABLE `recipe_medication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `stock_movement`
--
ALTER TABLE `stock_movement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `employee_position`
--
ALTER TABLE `employee_position`
  ADD CONSTRAINT `fk_employee` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_position` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
