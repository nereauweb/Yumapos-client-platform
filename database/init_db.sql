-- phpMyAdmin SQL Dump
-- version 5.1.0-3.el7.remi
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mar 30, 2022 alle 01:49
-- Versione del server: 10.5.10-MariaDB
-- Versione PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yuma.clienttest`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `agent_operations`
--

CREATE TABLE `agent_operations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_operation_id` bigint(20) UNSIGNED NOT NULL,
  `original_amount` decimal(10,3) DEFAULT 0.000,
  `applied_commission_id` bigint(20) DEFAULT NULL,
  `commission` decimal(10,3) DEFAULT 0.000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `email_template`
--

CREATE TABLE `email_template` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `example`
--

CREATE TABLE `example` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `folder`
--

CREATE TABLE `folder` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder_id` int(10) UNSIGNED DEFAULT NULL,
  `resource` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `form`
--

CREATE TABLE `form` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL,
  `edit` tinyint(1) NOT NULL,
  `add` tinyint(1) NOT NULL,
  `delete` tinyint(1) NOT NULL,
  `pagination` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `form_field`
--

CREATE TABLE `form_field` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browse` tinyint(1) NOT NULL,
  `read` tinyint(1) NOT NULL,
  `edit` tinyint(1) NOT NULL,
  `add` tinyint(1) NOT NULL,
  `relation_table` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relation_column` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_id` int(10) UNSIGNED NOT NULL,
  `column_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `menulist`
--

CREATE TABLE `menulist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `menulist`
--

INSERT INTO `menulist` (`id`, `name`) VALUES
(1, 'sidebar menu'),
(2, 'top menu');

-- --------------------------------------------------------

--
-- Struttura della tabella `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `href` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `sequence` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `menus`
--

INSERT INTO `menus` (`id`, `href`, `icon`, `slug`, `parent_id`, `menu_id`, `sequence`, `deleted_at`) VALUES
(1, '/backend', 'cil-speedometer', 'link', NULL, 1, 1, NULL),
(3, '/notes', NULL, 'link', NULL, 1, 41, NULL),
(4, '/users', NULL, 'link', NULL, 1, 12, NULL),
(5, '/menu/menu', NULL, 'link', 113, 1, 31, NULL),
(6, '/roles', NULL, 'link', 113, 1, 27, NULL),
(7, '/media', NULL, 'link', 113, 1, 29, NULL),
(8, '/bread', NULL, 'link', 113, 1, 30, NULL),
(9, '/mail', NULL, 'link', 113, 1, 28, NULL),
(10, '/languages', NULL, 'link', 113, 1, 24, NULL),
(11, '/login', 'cil-account-logout', 'link', NULL, 1, 34, NULL),
(12, '/register', 'cil-account-logout', 'link', NULL, 1, 33, NULL),
(16, NULL, NULL, 'dropdown', NULL, 1, 2, NULL),
(65, NULL, NULL, 'title', NULL, 1, 22, NULL),
(80, '/', NULL, 'link', NULL, 2, 37, NULL),
(81, '/notes', NULL, 'link', NULL, 2, 81, '2020-08-09 12:03:44'),
(82, '/users', NULL, 'link', NULL, 2, 80, NULL),
(83, NULL, NULL, 'dropdown', NULL, 2, 83, NULL),
(84, '/menu/menu', NULL, 'link', 83, 2, 84, NULL),
(85, '/menu/element', NULL, 'link', 83, 2, 85, NULL),
(86, '/languages', NULL, 'link', 83, 2, 86, '2020-08-10 05:18:02'),
(87, '/roles', NULL, 'link', 83, 2, 87, '2020-08-10 05:17:59'),
(88, '/media', NULL, 'link', 83, 2, 88, NULL),
(89, '/bread', NULL, 'link', 83, 2, 89, '2020-08-10 05:17:41'),
(90, '/admin/service', NULL, 'link', 16, 1, 8, NULL),
(91, '/users/services/input', NULL, 'link', NULL, 1, 9, '2020-11-13 13:05:15'),
(92, NULL, NULL, 'title', NULL, 1, 13, NULL),
(93, '/admin/users/groups/', NULL, 'link', 16, 1, 11, NULL),
(94, '/admin/contents', NULL, 'link', 113, 1, 23, NULL),
(95, NULL, NULL, 'dropdown', NULL, 1, 35, '2022-03-29 15:17:25'),
(96, '/admin/api/reloadly', NULL, 'link', 95, 1, 36, '2022-03-29 15:17:19'),
(97, '/users/reports/operations', NULL, 'link', NULL, 1, 15, NULL),
(98, '/users/settings/account', NULL, 'link', NULL, 1, 24, NULL),
(99, '/users/settings/account', NULL, 'link', NULL, 1, 24, '2020-08-09 12:06:11'),
(100, '/users/settings/account', NULL, 'link', 83, 2, 90, NULL),
(101, '/admin/report', NULL, 'link', NULL, 1, 18, NULL),
(102, '/admin/payments', NULL, 'link', NULL, 1, 4, NULL),
(103, NULL, NULL, 'title', NULL, 1, 37, NULL),
(104, '/users/info', NULL, 'link', NULL, 1, 38, NULL),
(105, '/admin/report/calls/reloadly', NULL, 'link', 92, 1, 20, '2022-03-29 15:20:48'),
(106, '/users/payments', NULL, 'link', NULL, 1, 14, NULL),
(107, '/sales/reports/operations', NULL, 'link', NULL, 1, 16, NULL),
(108, '/admin/service/ding/', NULL, 'link', 16, 1, 6, '2022-03-29 15:15:50'),
(109, '/admin/service/pricing', NULL, 'link', 16, 1, 5, NULL),
(110, '/admin/api/ding', NULL, 'link', 95, 1, 39, '2022-03-29 15:17:14'),
(111, '/sales/user/create', NULL, 'link', NULL, 1, 10, NULL),
(112, '/admin/report/agents', NULL, 'link', NULL, 1, 19, NULL),
(113, NULL, NULL, 'dropdown', NULL, 1, 32, NULL),
(114, '/admin/report', NULL, 'link', NULL, 2, 82, NULL),
(115, '/admin/report/calls/ding', NULL, 'link', 92, 1, 41, '2022-03-29 15:16:14'),
(116, '/admin/account', NULL, 'link', NULL, 1, 40, NULL),
(117, '/admin/api/mbs/', NULL, 'link', 95, 1, 41, '2021-02-21 15:49:47'),
(118, '/admin/report/ticket', NULL, 'link', 92, 1, 40, '2021-02-21 15:51:00'),
(119, '/admin/report/ticket', NULL, 'link', NULL, 1, 26, NULL),
(120, '/admin/api/mbs', NULL, 'link', 95, 1, 42, '2022-03-29 15:17:06'),
(121, '/admin/service/mbs/', NULL, 'link', 16, 1, 7, '2022-03-29 15:15:55'),
(122, '/admin/report/calls/mbs', NULL, 'link', 92, 1, 43, '2022-03-29 15:20:55'),
(123, '/users/reports/ticket', NULL, 'link', NULL, 1, 21, NULL),
(124, '/admin/providers', NULL, 'link', 16, 1, 45, NULL),
(125, '/admin/api/calls', NULL, 'link', NULL, 1, 17, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `menus_lang`
--

CREATE TABLE `menus_lang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menus_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `menus_lang`
--

INSERT INTO `menus_lang` (`id`, `name`, `lang`, `menus_id`) VALUES
(21, 'Login', 'en', 11),
(23, 'Register', 'en', 12),
(35, 'Breadcrumb', 'en', 18),
(37, 'Cards', 'en', 19),
(39, 'Carousel', 'en', 20),
(41, 'Collapse', 'en', 21),
(43, 'Jumbotron', 'en', 22),
(45, 'List group', 'en', 23),
(47, 'Navs', 'en', 24),
(49, 'Pagination', 'en', 25),
(51, 'Popovers', 'en', 26),
(53, 'Progress', 'en', 27),
(55, 'Scrollspy', 'en', 28),
(57, 'Switches', 'en', 29),
(59, 'Tabs', 'en', 30),
(61, 'Tooltips', 'en', 31),
(65, 'Buttons', 'en', 33),
(67, 'Brand Buttons', 'en', 34),
(69, 'Buttons Group', 'en', 35),
(71, 'Dropdowns', 'en', 36),
(73, 'Loading Buttons', 'en', 37),
(79, 'Code Editor', 'en', 40),
(81, 'Markdown', 'en', 41),
(83, 'Rich Text Editor', 'en', 42),
(87, 'Basic Forms', 'en', 44),
(89, 'Advanced', 'en', 45),
(91, 'Validation', 'en', 46),
(97, 'CoreUI Icons', 'en', 49),
(99, 'Flags', 'en', 50),
(101, 'Brands', 'en', 51),
(107, 'Badge', 'en', 54),
(109, 'Modals', 'en', 55),
(111, 'Toastr', 'en', 56),
(115, 'Calendar', 'en', 58),
(117, 'Draggable', 'en', 59),
(119, 'Spinners', 'en', 60),
(123, 'Standard Tables', 'en', 62),
(125, 'DataTables', 'en', 63),
(133, 'Login', 'en', 67),
(135, 'Register', 'en', 68),
(137, 'Error 404', 'en', 69),
(139, 'Error 500', 'en', 70),
(143, 'Invoicing', 'en', 72),
(145, 'Invoice', 'en', 73),
(147, 'Email', 'en', 74),
(149, 'Inbox', 'en', 75),
(151, 'Message', 'en', 76),
(153, 'Compose', 'en', 77),
(175, 'Media', 'en', 88),
(185, 'Notes', 'en', 3),
(186, 'Note', 'it', 3),
(195, 'Users', 'en', 4),
(196, 'Utenti', 'it', 4),
(231, 'Account', 'en', 100),
(232, 'Account', 'it', 100),
(233, 'Settings', 'en', 83),
(234, 'Impostazioni', 'it', 83),
(237, 'Operations', 'en', 101),
(238, 'Operazioni', 'it', 101),
(245, 'Pagamenti', 'it', 102),
(246, 'Payments', 'en', 102),
(253, 'Commissioni agente', 'it', 107),
(254, 'Sales commissions', 'en', 107),
(267, 'Pagamenti', 'it', 106),
(268, 'Payments', 'en', 106),
(269, 'Dashboard', 'it', 1),
(270, 'Dashboard', 'en', 1),
(271, 'Info', 'it', 104),
(272, 'Info', 'en', 104),
(279, 'Account', 'it', 98),
(280, 'Account', 'en', 98),
(281, 'Support', 'it', 103),
(282, 'Support', 'en', 103),
(283, 'Operazioni', 'it', 97),
(284, 'Operations', 'en', 97),
(289, 'Proponi point', 'it', 111),
(290, 'Propose point', 'en', 111),
(293, 'Operazioni agenti', 'it', 112),
(294, 'Agent operations', 'en', 112),
(295, 'Impostazioni', 'it', 65),
(296, 'Settings', 'en', 65),
(297, 'Impostazioni', 'it', 113),
(298, 'Settings', 'en', 113),
(299, 'Contenuti', 'it', 94),
(300, 'Contents', 'en', 94),
(301, 'Lingue', 'it', 10),
(302, 'Languages', 'en', 10),
(303, 'Ruoli', 'it', 6),
(304, 'Roles', 'en', 6),
(305, 'Email', 'it', 9),
(306, 'Email', 'en', 9),
(307, 'Media', 'it', 7),
(308, 'Media', 'en', 7),
(309, 'Viste', 'it', 8),
(310, 'Bread', 'en', 8),
(311, 'Gestisci menu', 'it', 5),
(312, 'Edit menu', 'en', 5),
(321, 'Dashboard', 'it', 80),
(322, 'Dashboard', 'en', 80),
(323, 'Utenti', 'it', 82),
(324, 'Users', 'en', 82),
(325, 'Gestisci elementi menu', 'it', 85),
(326, 'Edit menu elements', 'en', 85),
(327, 'Gestione menu', 'it', 84),
(328, 'Edit menu', 'en', 84),
(331, 'Operazioni', 'it', 114),
(332, 'Operations', 'en', 114),
(343, 'Cambia password', 'it', 116),
(344, 'Change password', 'en', 116),
(345, 'Ticket', 'it', 119),
(346, 'Ticket', 'en', 119),
(367, 'Ticket', 'it', 123),
(368, 'Ticket', 'en', 123),
(369, 'Gestione', 'it', 16),
(370, 'Manage', 'en', 16),
(377, 'Servizi', 'it', 90),
(378, 'Services', 'en', 90),
(379, 'Gruppi utente', 'it', 93),
(380, 'User groups', 'en', 93),
(383, 'Fornitori', 'it', 124),
(384, 'Providers', 'en', 124),
(387, 'Prezzi', 'it', 109),
(388, 'Pricing', 'en', 109),
(391, 'Report', 'it', 92),
(392, 'Report', 'en', 92),
(393, 'Chiamate API', 'it', 125),
(394, 'API Calls', 'en', 125);

-- --------------------------------------------------------

--
-- Struttura della tabella `menu_lang_lists`
--

CREATE TABLE `menu_lang_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `menu_lang_lists`
--

INSERT INTO `menu_lang_lists` (`id`, `name`, `short_name`, `is_default`, `deleted_at`) VALUES
(1, 'Italiano', 'it', 1, NULL),
(2, 'English', 'en', 0, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `menu_role`
--

CREATE TABLE `menu_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menus_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `menu_role`
--

INSERT INTO `menu_role` (`id`, `role_name`, `menus_id`) VALUES
(13, 'guest', 11),
(14, 'guest', 12),
(25, 'user', 18),
(26, 'admin', 18),
(27, 'user', 19),
(28, 'admin', 19),
(29, 'user', 20),
(30, 'admin', 20),
(31, 'user', 21),
(32, 'admin', 21),
(33, 'user', 22),
(34, 'admin', 22),
(35, 'user', 23),
(36, 'admin', 23),
(37, 'user', 24),
(38, 'admin', 24),
(39, 'user', 25),
(40, 'admin', 25),
(41, 'user', 26),
(42, 'admin', 26),
(43, 'user', 27),
(44, 'admin', 27),
(45, 'user', 28),
(46, 'admin', 28),
(47, 'user', 29),
(48, 'admin', 29),
(49, 'user', 30),
(50, 'admin', 30),
(51, 'user', 31),
(52, 'admin', 31),
(55, 'user', 33),
(56, 'admin', 33),
(57, 'user', 34),
(58, 'admin', 34),
(59, 'user', 35),
(60, 'admin', 35),
(61, 'user', 36),
(62, 'admin', 36),
(63, 'user', 37),
(64, 'admin', 37),
(69, 'user', 40),
(70, 'admin', 40),
(71, 'user', 41),
(72, 'admin', 41),
(73, 'user', 42),
(74, 'admin', 42),
(77, 'user', 44),
(78, 'admin', 44),
(79, 'user', 45),
(80, 'admin', 45),
(81, 'user', 46),
(82, 'admin', 46),
(87, 'user', 49),
(88, 'admin', 49),
(89, 'user', 50),
(90, 'admin', 50),
(91, 'user', 51),
(92, 'admin', 51),
(97, 'user', 54),
(98, 'admin', 54),
(99, 'user', 55),
(100, 'admin', 55),
(101, 'user', 56),
(102, 'admin', 56),
(105, 'user', 58),
(106, 'admin', 58),
(107, 'user', 59),
(108, 'admin', 59),
(109, 'user', 60),
(110, 'admin', 60),
(113, 'user', 62),
(114, 'admin', 62),
(115, 'user', 63),
(116, 'admin', 63),
(123, 'user', 67),
(124, 'admin', 67),
(125, 'user', 68),
(126, 'admin', 68),
(127, 'user', 69),
(128, 'admin', 69),
(129, 'user', 70),
(130, 'admin', 70),
(133, 'user', 72),
(134, 'admin', 72),
(135, 'user', 73),
(136, 'admin', 73),
(137, 'user', 74),
(138, 'admin', 74),
(139, 'user', 75),
(140, 'admin', 75),
(141, 'user', 76),
(142, 'admin', 76),
(143, 'user', 77),
(144, 'admin', 77),
(162, 'admin', 88),
(172, 'admin', 3),
(181, 'admin', 4),
(200, 'user', 100),
(201, 'admin', 83),
(202, 'user', 83),
(204, 'admin', 101),
(208, 'admin', 102),
(212, 'sales', 107),
(220, 'user', 106),
(221, 'sales', 106),
(222, 'admin', 1),
(223, 'user', 1),
(224, 'guest', 1),
(225, 'sales', 1),
(226, 'user', 104),
(227, 'sales', 104),
(237, 'user', 98),
(238, 'sales', 98),
(239, 'user', 103),
(240, 'sales', 103),
(241, 'user', 97),
(242, 'sales', 97),
(245, 'sales', 111),
(248, 'admin', 112),
(249, 'user', 65),
(250, 'sales', 65),
(251, 'admin', 113),
(252, 'admin', 94),
(253, 'admin', 10),
(254, 'admin', 6),
(255, 'admin', 9),
(256, 'admin', 7),
(257, 'admin', 8),
(258, 'admin', 5),
(265, 'admin', 80),
(266, 'user', 80),
(267, 'guest', 80),
(268, 'admin', 82),
(269, 'admin', 85),
(270, 'admin', 84),
(272, 'admin', 114),
(280, 'admin', 116),
(281, 'admin', 119),
(289, 'user', 123),
(290, 'sales', 123),
(291, 'admin', 16),
(292, 'sales', 16),
(296, 'admin', 90),
(297, 'admin', 93),
(299, 'admin', 124),
(301, 'admin', 109),
(303, 'admin', 92),
(304, 'user', 92),
(305, 'manager', 92),
(306, 'admin', 125);

-- --------------------------------------------------------

--
-- Struttura della tabella `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `note_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applies_to_date` date NOT NULL,
  `users_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `target_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `update_balance` tinyint(4) DEFAULT 0,
  `update_credit` tinyint(4) NOT NULL DEFAULT 0,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `payments_file`
--

CREATE TABLE `payments_file` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `filename` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'browse bread 1', 'web', '2020-07-11 15:25:26', '2020-07-11 15:25:26'),
(2, 'read bread 1', 'web', '2020-07-11 15:25:26', '2020-07-11 15:25:26'),
(3, 'edit bread 1', 'web', '2020-07-11 15:25:26', '2020-07-11 15:25:26'),
(4, 'add bread 1', 'web', '2020-07-11 15:25:26', '2020-07-11 15:25:26'),
(5, 'delete bread 1', 'web', '2020-07-11 15:25:26', '2020-07-11 15:25:26');

-- --------------------------------------------------------

--
-- Struttura della tabella `providers`
--

CREATE TABLE `providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` text COLLATE utf8_roman_ci DEFAULT NULL,
  `legal_seat` text COLLATE utf8_roman_ci DEFAULT NULL,
  `legal_seat_address` text COLLATE utf8_roman_ci DEFAULT NULL,
  `legal_seat_zip` text COLLATE utf8_roman_ci DEFAULT NULL,
  `legal_seat_city` text COLLATE utf8_roman_ci DEFAULT NULL,
  `legal_seat_region` text COLLATE utf8_roman_ci DEFAULT NULL,
  `legal_seat_country` text COLLATE utf8_roman_ci DEFAULT NULL,
  `operative_seat` text COLLATE utf8_roman_ci DEFAULT NULL,
  `operative_seat_address` text COLLATE utf8_roman_ci DEFAULT NULL,
  `operative_seat_zip` text COLLATE utf8_roman_ci DEFAULT NULL,
  `operative_seat_city` text COLLATE utf8_roman_ci DEFAULT NULL,
  `operative_seat_region` text COLLATE utf8_roman_ci DEFAULT NULL,
  `operative_seat_country` text COLLATE utf8_roman_ci DEFAULT NULL,
  `vat` text COLLATE utf8_roman_ci DEFAULT NULL,
  `tax_unique_code` text COLLATE utf8_roman_ci DEFAULT NULL,
  `pec` text COLLATE utf8_roman_ci DEFAULT NULL,
  `email` text COLLATE utf8_roman_ci DEFAULT NULL,
  `phone` text COLLATE utf8_roman_ci DEFAULT NULL,
  `website` text COLLATE utf8_roman_ci DEFAULT NULL,
  `support_email` text COLLATE utf8_roman_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

--
-- Dump dei dati per la tabella `providers`
--

INSERT INTO `providers` (`id`, `company_name`, `legal_seat`, `legal_seat_address`, `legal_seat_zip`, `legal_seat_city`, `legal_seat_region`, `legal_seat_country`, `operative_seat`, `operative_seat_address`, `operative_seat_zip`, `operative_seat_city`, `operative_seat_region`, `operative_seat_country`, `vat`, `tax_unique_code`, `pec`, `email`, `phone`, `website`, `support_email`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test', NULL, NULL, NULL, NULL, '---', NULL, NULL, NULL, NULL, NULL, '---', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'test@test.it', '2020-10-20 17:13:23', '2020-10-20 17:13:23', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `providers_referents`
--

CREATE TABLE `providers_referents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `role` text COLLATE utf8_roman_ci DEFAULT NULL,
  `name` text COLLATE utf8_roman_ci DEFAULT NULL,
  `surname` text COLLATE utf8_roman_ci DEFAULT NULL,
  `pec` text COLLATE utf8_roman_ci DEFAULT NULL,
  `email` text COLLATE utf8_roman_ci DEFAULT NULL,
  `phone` text COLLATE utf8_roman_ci DEFAULT NULL,
  `mobile` text COLLATE utf8_roman_ci DEFAULT NULL,
  `skype` text COLLATE utf8_roman_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

--
-- Dump dei dati per la tabella `providers_referents`
--

INSERT INTO `providers_referents` (`id`, `provider_id`, `role`, `name`, `surname`, `pec`, `email`, `phone`, `mobile`, `skype`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'test', NULL, 'test', NULL, NULL, NULL, NULL, NULL, '2020-10-20 21:04:08', '2020-10-20 21:04:08', NULL),
(2, 1, 'test2', NULL, 'test2', NULL, NULL, NULL, NULL, NULL, '2020-10-20 21:13:40', '2020-10-21 09:38:56', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2020-07-11 15:25:25', '2020-07-11 15:25:25'),
(2, 'user', 'web', '2020-07-11 15:25:25', '2020-07-11 15:25:25'),
(3, 'guest', 'web', '2020-07-11 15:25:25', '2020-07-11 15:25:25'),
(4, 'sales', 'web', '2020-08-08 03:01:41', '2020-08-08 03:01:41'),
(5, 'manager', 'web', '2021-11-27 17:18:44', '2021-11-27 17:18:44');

-- --------------------------------------------------------

--
-- Struttura della tabella `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `role_hierarchy`
--

CREATE TABLE `role_hierarchy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `hierarchy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `role_hierarchy`
--

INSERT INTO `role_hierarchy` (`id`, `role_id`, `hierarchy`) VALUES
(1, 1, 1),
(2, 2, 3),
(3, 3, 4),
(4, 4, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_list_type` enum('include','exclude') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'include',
  `operator_list_type` enum('include','exclude') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'include',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `country_list_type`, `operator_list_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Ricariche nazionali  <span style=\"color:#00f91b;margin-left: 10px;\">(NEW!)</span>', 'include', 'include', '2020-10-26 14:04:44', '2021-04-09 13:05:12', NULL),
(2, 'Ricariche internazionali', 'exclude', 'exclude', '2020-10-26 14:05:55', '2020-11-26 15:46:30', NULL),
(3, 'Pagamenti utenze internazionali', 'include', 'include', '2020-10-26 14:06:38', '2021-08-27 14:04:15', '2021-08-27 14:04:15'),
(4, 'Pacchetti Dati/ Bundle internazionali', 'include', 'include', '2021-02-03 02:37:48', '2021-02-03 02:39:45', '2021-02-03 02:39:45');

-- --------------------------------------------------------

--
-- Struttura della tabella `service_categories_countries`
--

CREATE TABLE `service_categories_countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dump dei dati per la tabella `service_categories_countries`
--

INSERT INTO `service_categories_countries` (`id`, `category_id`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 1, 120, '2020-11-03 09:04:21', NULL),
(2, 2, 120, '2020-11-03 09:08:31', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `service_categories_operators`
--

CREATE TABLE `service_categories_operators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `operator_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dump dei dati per la tabella `service_categories_operators`
--

INSERT INTO `service_categories_operators` (`id`, `category_id`, `operator_id`, `created_at`, `updated_at`) VALUES
(3, 1, 486, '2020-11-13 00:57:18', NULL),
(4, 1, 560, '2020-11-13 00:57:18', NULL),
(5, 1, 311, '2020-11-13 00:57:18', NULL),
(6, 2, 486, '2020-11-26 15:46:30', NULL),
(7, 2, 560, '2020-11-26 15:46:30', NULL),
(8, 2, 559, '2020-11-26 15:46:30', NULL),
(9, 2, 313, '2020-11-26 15:46:30', NULL),
(10, 2, 315, '2020-11-26 15:46:30', NULL),
(11, 2, 311, '2020-11-26 15:46:30', NULL),
(12, 2, 566, '2020-11-26 15:46:30', NULL),
(13, 2, 312, '2020-11-26 15:46:30', NULL),
(14, 2, 901, '2020-11-26 15:46:30', NULL),
(15, 3, 586, '2020-12-22 15:36:29', NULL),
(16, 3, 584, '2020-12-22 15:36:29', NULL),
(17, 3, 585, '2020-12-22 15:36:29', NULL),
(18, 3, 583, '2020-12-22 15:36:29', NULL),
(19, 2, 1232, '2021-01-04 11:16:20', NULL),
(20, 2, 271, '2021-01-04 11:16:20', NULL),
(21, 2, 637, '2021-01-04 11:16:20', NULL),
(22, 2, 272, '2021-01-04 11:16:20', NULL),
(23, 2, 1238, '2021-01-04 11:16:20', NULL),
(24, 2, 1239, '2021-01-04 11:16:20', NULL),
(25, 2, 273, '2021-01-04 11:16:20', NULL),
(26, 2, 1243, '2021-01-04 11:16:20', NULL),
(27, 2, 1244, '2021-01-04 11:16:20', NULL),
(28, 2, 274, '2021-01-04 11:16:20', NULL),
(29, 2, 270, '2021-01-04 11:16:20', NULL),
(30, 2, 586, '2021-02-04 11:45:58', NULL),
(31, 2, 584, '2021-02-04 11:45:58', NULL),
(32, 2, 585, '2021-02-04 11:45:58', NULL),
(33, 2, 583, '2021-02-04 11:45:58', NULL),
(34, 2, 1321, '2021-04-01 08:22:48', NULL),
(35, 2, 1323, '2021-04-01 08:23:19', NULL),
(36, 2, 1307, '2021-04-18 16:13:43', NULL),
(37, 2, 516, '2021-04-18 16:13:43', NULL),
(38, 2, 1313, '2021-04-18 16:13:43', NULL),
(39, 2, 576, '2021-04-18 16:13:43', NULL),
(40, 2, 514, '2021-04-18 16:13:43', NULL),
(41, 2, 1107, '2021-04-18 16:13:43', NULL),
(42, 2, 1312, '2021-04-18 16:13:43', NULL),
(43, 2, 1336, '2021-04-18 16:13:43', NULL),
(44, 2, 1116, '2021-04-18 16:13:43', NULL),
(45, 2, 1314, '2021-04-18 16:13:43', NULL),
(46, 2, 1315, '2021-04-18 16:13:43', NULL),
(47, 2, 1233, '2021-04-18 16:13:43', NULL),
(48, 2, 1234, '2021-04-18 16:13:43', NULL),
(49, 2, 1235, '2021-04-18 16:13:43', NULL),
(50, 2, 562, '2021-04-18 16:13:43', NULL),
(51, 2, 564, '2021-04-18 16:13:43', NULL),
(52, 2, 1236, '2021-04-18 16:13:43', NULL),
(53, 2, 578, '2021-04-18 16:13:43', NULL),
(54, 2, 723, '2021-04-18 16:13:43', NULL),
(55, 2, 724, '2021-04-18 16:13:43', NULL),
(56, 2, 579, '2021-04-18 16:13:43', NULL),
(57, 2, 1124, '2021-04-18 16:13:43', NULL),
(58, 2, 1126, '2021-04-18 16:13:43', NULL),
(59, 2, 1274, '2021-04-18 16:13:43', NULL),
(60, 2, 1240, '2021-04-18 16:13:43', NULL),
(61, 2, 1308, '2021-04-18 16:13:43', NULL),
(62, 2, 1309, '2021-04-18 16:13:43', NULL),
(63, 2, 1219, '2021-04-18 16:13:43', NULL),
(64, 2, 1316, '2021-04-18 16:13:43', NULL),
(65, 2, 1220, '2021-04-18 16:13:43', NULL),
(66, 2, 1241, '2021-04-18 16:13:43', NULL),
(67, 2, 1318, '2021-04-18 16:13:43', NULL),
(68, 2, 1224, '2021-04-18 16:13:43', NULL),
(69, 2, 1015, '2021-04-18 16:13:43', NULL),
(70, 2, 1319, '2021-04-18 16:13:43', NULL),
(71, 2, 1320, '2021-04-18 16:13:43', NULL),
(72, 2, 1017, '2021-04-18 16:13:43', NULL),
(73, 2, 1020, '2021-04-18 16:13:43', NULL),
(74, 2, 1023, '2021-04-18 16:13:43', NULL),
(75, 2, 1025, '2021-04-18 16:13:43', NULL),
(76, 2, 289, '2021-04-18 16:13:43', NULL),
(77, 2, 1322, '2021-04-18 16:13:43', NULL),
(78, 2, 1310, '2021-04-18 16:13:43', NULL),
(79, 2, 1324, '2021-04-18 16:13:43', NULL),
(80, 2, 1311, '2021-04-18 16:13:43', NULL),
(81, 2, 1325, '2021-04-18 16:13:43', NULL),
(82, 2, 1326, '2021-04-18 16:13:43', NULL),
(83, 2, 1350, '2021-04-18 16:13:43', NULL),
(84, 2, 1137, '2021-04-18 16:13:43', NULL),
(85, 2, 1327, '2021-04-18 16:13:43', NULL),
(86, 2, 577, '2021-04-18 16:13:43', NULL),
(87, 2, 1214, '2021-04-18 16:13:43', NULL),
(88, 2, 1351, '2021-04-18 16:13:43', NULL),
(89, 2, 1245, '2021-04-18 16:13:43', NULL),
(90, 2, 450, '2021-04-18 16:13:43', NULL),
(91, 2, 1247, '2021-04-18 16:13:43', NULL),
(92, 2, 1145, '2021-04-18 16:13:43', NULL),
(93, 2, 1249, '2021-04-18 16:13:43', NULL),
(94, 2, 1147, '2021-04-18 16:13:43', NULL),
(95, 2, 1296, '2021-04-18 16:13:43', NULL),
(96, 2, 1328, '2021-04-18 16:13:43', NULL),
(97, 2, 1149, '2021-04-18 16:13:43', NULL),
(98, 2, 1252, '2021-04-18 16:13:43', NULL),
(99, 2, 1228, '2021-04-18 16:13:43', NULL),
(100, 2, 1151, '2021-04-18 16:13:43', NULL),
(101, 2, 1230, '2021-04-18 16:13:43', NULL),
(102, 2, 863, '2021-04-18 16:13:43', NULL),
(103, 2, 1335, '2021-04-18 16:13:43', NULL),
(104, 2, 527, '2021-04-18 16:13:43', NULL),
(105, 2, 1182, '2021-04-18 16:13:43', NULL),
(106, 2, 1253, '2021-04-18 16:13:43', NULL),
(107, 1, 485, '2021-10-21 06:59:53', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `service_countries`
--

CREATE TABLE `service_countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `iso` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `service_countries`
--

INSERT INTO `service_countries` (`id`, `iso`, `name`, `created_at`, `updated_at`) VALUES
(1, 'GY', 'Guyana', '2020-10-31 15:13:33', '2020-10-31 15:13:33'),
(2, 'AI', 'Anguilla', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(3, 'AG', 'Antigua and Barbuda', '2020-11-03 15:11:32', '2020-11-03 15:11:32'),
(4, 'DM', 'Dominica', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(5, 'GD', 'Grenada', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(6, 'KN', 'Saint Kitts And Nevis', '2020-11-03 15:11:32', '2020-11-03 15:11:32'),
(7, 'LC', 'Saint Lucia', '2020-11-03 15:11:32', '2020-11-03 15:11:32'),
(8, 'VC', 'Saint Vincent And The Grenadines', '2020-11-03 15:11:32', '2020-11-03 15:11:32'),
(9, 'BB', 'Barbados', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(10, 'TT', 'Trinidad and Tobago', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(11, 'SV', 'El Salvador', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(12, 'LK', 'Sri Lanka', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(13, 'BM', 'Bermuda', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(14, 'TC', 'Turks And Caicos Islands', '2020-11-12 16:35:51', '2020-11-12 16:35:51'),
(15, 'SR', 'Suriname', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(16, 'PK', 'Pakistan', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(17, 'IN', 'India', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(18, 'KY', 'Cayman Islands', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(19, 'CO', 'Colombia', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(20, 'TO', 'Tonga', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(21, 'VU', 'Vanuatu', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(22, 'FJ', 'Fiji', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(23, 'MD', 'Moldova', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(24, 'PA', 'Panama', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(25, 'AW', 'Aruba', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(26, 'VG', 'British Virgin Islands', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(27, 'GF', 'French Guiana', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(28, 'GP', 'Guadeloupe', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(29, 'MQ', 'Martinique', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(30, 'RO', 'Romania', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(31, 'LA', 'Laos', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(32, 'DO', 'Dominican Republic', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(33, 'MX', 'Mexico', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(34, 'PH', 'Philippines', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(35, 'AF', 'Afghanistan', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(36, 'PE', 'Peru', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(37, 'KH', 'Cambodia', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(38, 'BO', 'Bolivia', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(39, 'UG', 'Uganda', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(40, 'CU', 'Cuba', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(41, 'AM', 'Armenia', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(42, 'LR', 'Liberia', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(43, 'BR', 'Brazil', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(44, 'CW', 'Curacao', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(45, 'NG', 'Nigeria', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(46, 'BZ', 'Belize', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(47, 'PY', 'Paraguay', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(48, 'GN', 'Guinea', '2021-03-31 23:39:14', '2021-03-31 23:39:14'),
(49, 'NE', 'Niger', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(50, 'GH', 'Ghana', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(51, 'PR', 'Puerto Rico', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(52, 'SN', 'Senegal', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(53, 'CI', 'Ivory Coast', '2021-03-31 23:39:15', '2021-03-31 23:39:15'),
(54, 'ML', 'Mali', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(55, 'MG', 'Madagascar', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(56, 'EG', 'Egypt', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(57, 'CM', 'Cameroon', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(58, 'RW', 'Rwanda', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(59, 'TN', 'Tunisia', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(60, 'KE', 'Kenya', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(61, 'GW', 'Guinea Bissau', '2021-03-01 18:57:47', '2021-03-01 18:57:47'),
(62, 'GE', 'Georgia', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(63, 'CY', 'Cyprus', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(64, 'ZW', 'Zimbabwe', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(65, 'SZ', 'Eswatini', '2020-11-12 16:51:52', '2020-11-12 16:51:52'),
(66, 'MY', 'Malaysia', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(67, 'KW', 'Kuwait', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(68, 'HN', 'Honduras', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(69, 'HT', 'Haiti', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(70, 'PS', 'Palestine', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(71, 'UA', 'Ukraine', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(72, 'CF', 'Central African Republic', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(73, 'DE', 'Germany', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(74, 'ZM', 'Zambia', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(75, 'AL', 'Albania', '2020-10-31 15:16:44', '2020-10-31 15:16:44'),
(76, 'BT', 'Bhutan', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(77, 'CD', 'The Democratic Republic Of Congo', '2021-10-12 13:22:05', '2021-10-12 13:22:05'),
(78, 'TZ', 'Tanzania', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(79, 'TR', 'Turkey', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(80, 'BJ', 'Benin', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(81, 'AR', 'Argentina', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(82, 'BF', 'Burkina Faso', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(83, 'IQ', 'Iraq', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(84, 'BI', 'Burundi', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(85, 'GM', 'Gambia', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(86, 'PL', 'Poland', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(87, 'VN', 'Vietnam', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(88, 'TJ', 'Tajikistan', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(89, 'EC', 'Ecuador', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(90, 'XK', 'Kosovo', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(91, 'NP', 'Nepal', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(92, 'LT', 'Lithuania', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(93, 'WS', 'Samoa', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(94, 'PG', 'Papua New Guinea', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(95, 'TH', 'Thailand', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(96, 'JM', 'Jamaica', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(97, 'BH', 'Bahrain', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(98, 'US', 'United States', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(99, 'MW', 'Malawi', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(100, 'ES', 'Spain', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(101, 'MS', 'Montserrat', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(102, 'SL', 'Sierra Leone', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(103, 'GT', 'Guatemala', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(104, 'UZ', 'Uzbekistan', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(105, 'PT', 'Portugal', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(106, 'AZ', 'Azerbaijan', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(107, 'RU', 'Russia', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(108, 'BY', 'Belarus', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(109, 'ZA', 'South Africa', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(110, 'SG', 'Singapore', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(111, 'GB', 'United Kingdom', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(112, 'BD', 'Bangladesh', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(113, 'CV', 'Cape Verde', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(114, 'YE', 'Yemen', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(115, 'AE', 'United Arab Emirates', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(116, 'MA', 'Morocco', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(117, 'TG', 'Togo', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(118, 'SA', 'Saudi Arabia', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(119, 'MM', 'Myanmar', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(120, 'IT', 'Italy', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(121, 'KG', 'Kyrgyzstan', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(122, 'CR', 'Costa Rica', '2020-10-31 15:16:45', '2020-10-31 15:16:45'),
(123, 'MZ', 'Mozambique', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(124, 'QA', 'Qatar', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(125, 'KM', 'Comoros', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(126, 'CA', 'Canada', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(127, 'NI', 'Nicaragua', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(128, 'UY', 'Uruguay', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(129, 'ID', 'Indonesia', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(130, 'IE', 'Ireland', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(131, 'BW', 'Botswana', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(132, 'BE', 'Belgium', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(133, 'OM', 'Oman', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(134, 'CL', 'Chile', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(135, 'KZ', 'Kazakhstan', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(136, 'LU', 'Luxembourg', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(137, 'NL', 'Netherlands', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(138, 'CG', 'Congo', '2020-11-03 15:11:33', '2020-11-03 15:11:33'),
(139, 'JO', 'Jordan', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(140, 'ET', 'Ethiopia', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(141, 'GR', 'Greece', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(142, 'CN', 'China', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(143, 'DZ', 'Algeria', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(144, 'CH', 'Switzerland', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(145, 'MR', 'Mauritania', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(146, 'VE', 'Venezuela', '2020-10-31 15:16:46', '2020-10-31 15:16:46'),
(147, 'AO', 'Angola', '2020-10-31 15:16:47', '2020-10-31 15:16:47'),
(148, 'AU', 'Australia', '2020-10-31 15:16:47', '2020-10-31 15:16:47'),
(149, 'BS', 'Bahamas', '2020-11-12 21:12:54', '2020-11-12 21:12:54'),
(150, 'SO', 'Somaliland', '2020-11-03 15:10:40', '2020-11-03 15:10:40'),
(151, 'AS', 'American Samoa', '2020-10-31 15:16:47', '2020-10-31 15:16:47'),
(152, 'FR', 'France', '2020-10-31 15:16:47', '2020-10-31 15:16:47'),
(153, 'AN', 'Netherlands Antilles', '2020-10-31 15:16:47', '2020-10-31 15:16:47'),
(154, 'NR', 'Nauru', '2020-10-31 15:16:47', '2020-10-31 15:16:47'),
(155, 'NA', 'Namibia', '2020-10-31 15:16:48', '2020-10-31 15:16:48'),
(156, 'LB', 'Lebanon', '2020-10-31 15:16:49', '2020-10-31 15:16:49'),
(157, 'KR', 'South Korea', '2021-01-26 19:01:33', '2021-01-26 19:01:33'),
(158, 'BQ', 'Bonaire', '2021-09-03 17:28:29', '2021-09-03 17:28:29'),
(159, 'IR', 'Iran', '2021-09-03 17:28:31', '2021-09-03 17:28:31'),
(160, 'GA', 'Gabon', '2022-01-09 13:37:51', '2022-01-09 13:37:51'),
(161, 'AT', 'Austria', '2022-02-17 15:49:11', '2022-02-17 15:49:11');

-- --------------------------------------------------------

--
-- Struttura della tabella `service_operations`
--

CREATE TABLE `service_operations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider` enum('reloadly','ding','mbs') COLLATE utf8mb4_unicode_ci DEFAULT 'reloadly',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `api_reloadly_calls_id` bigint(20) UNSIGNED DEFAULT NULL,
  `api_reloadly_operations_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reloadly_transactionId` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ding_TransferRef` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_ding_call_id` bigint(20) UNSIGNED DEFAULT NULL,
  `api_ding_operation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `api_mbs_operation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `result` tinyint(1) NOT NULL,
  `request_operatorId` bigint(20) UNSIGNED DEFAULT NULL,
  `request_ProviderCode` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_Prodotto` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_amount` decimal(10,3) DEFAULT NULL,
  `request_local` tinyint(1) DEFAULT 0,
  `request_country_iso` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_recipient_phone` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_expected_destination_amount` decimal(10,3) DEFAULT 0.000,
  `final_expected_destination_amount` decimal(10,3) DEFAULT 0.000,
  `sent_amount` decimal(10,3) DEFAULT 0.000,
  `user_amount` decimal(10,2) DEFAULT 0.00,
  `user_gain` decimal(10,3) DEFAULT 0.000,
  `final_amount` decimal(10,3) DEFAULT 0.000,
  `user_discount` decimal(10,3) DEFAULT 0.000,
  `platform_commission` decimal(10,3) NOT NULL DEFAULT 0.000,
  `user_old_plafond` decimal(10,3) DEFAULT 0.000,
  `user_new_plafond` decimal(10,3) DEFAULT 0.000,
  `user_total_gain` decimal(10,3) DEFAULT 0.000,
  `agent_commission` decimal(10,3) DEFAULT 0.000,
  `platform_total_gain` decimal(10,3) DEFAULT 0.000,
  `pin` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_status` enum('reported','confirmed','sent','rejected','refunded') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `service_operators`
--

CREATE TABLE `service_operators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint(20) NOT NULL,
  `master` enum('ding','reloadly') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ding_ProviderCode` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reloadly_operatorId` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `status`
--

CREATE TABLE `status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `status`
--

INSERT INTO `status` (`id`, `name`, `class`) VALUES
(1, 'ongoing', 'badge badge-pill badge-primary'),
(2, 'stopped', 'badge badge-pill badge-secondary'),
(3, 'completed', 'badge badge-pill badge-success'),
(4, 'expired', 'badge badge-pill badge-warning');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `first_access` int(11) NOT NULL DEFAULT 1,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menuroles` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plafond` decimal(10,3) NOT NULL DEFAULT 0.000,
  `credit` decimal(10,2) DEFAULT 0.00,
  `debt_limit` decimal(10,3) DEFAULT 0.000,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_percent` decimal(10,2) DEFAULT 0.00,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state` tinyint(1) DEFAULT 1,
  `api_token` varchar(124) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `first_access`, `password`, `menuroles`, `remember_token`, `plafond`, `credit`, `debt_limit`, `parent_id`, `parent_percent`, `group_id`, `agent_group_id`, `state`, `api_token`, `tag`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@admin.com', '2020-07-11 15:25:25', 1, '$2y$10$NpkQe3Z2ZEWGsWg2FiqAxegHFgasgp85CSUj25UOkw7ZL8qUjO.Aq', 'user,admin', 'XXfk9MW3iy1g1KhdVhPijIfdNu7JHRIlJAuzg0FLR6IWaBjg8VTUw6XKzVDo', '1168.660', '0.00', '0.000', 0, '0.00', NULL, NULL, 1, NULL, NULL, '2020-07-11 15:25:25', '2022-03-29 15:21:46', NULL),
(2, 'test_point', 'testpoint@test.it', NULL, 0, '$2y$10$5sf6rCpQleXc2u51cXRpTea4x9ic7sK/.9AiMkA.FGcnbw2Ex06.m', 'user', 'qVZ4LwxpNizSIoYB8UufQcUj8K9tYJcGKOyLKwfzB7avYm6PSUcFTmYu2GQd', '0.000', '0.00', '0.000', NULL, '0.00', 7, NULL, 1, NULL, NULL, '2020-08-05 17:25:03', '2022-03-29 15:24:22', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `users_company_data`
--

CREATE TABLE `users_company_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` text COLLATE utf8_roman_ci DEFAULT NULL,
  `legal_seat` text COLLATE utf8_roman_ci DEFAULT NULL,
  `legal_seat_address` text COLLATE utf8_roman_ci DEFAULT NULL,
  `legal_seat_zip` text COLLATE utf8_roman_ci DEFAULT NULL,
  `legal_seat_city` text COLLATE utf8_roman_ci DEFAULT NULL,
  `legal_seat_region` text COLLATE utf8_roman_ci DEFAULT NULL,
  `legal_seat_country` text COLLATE utf8_roman_ci DEFAULT NULL,
  `operative_seat` text COLLATE utf8_roman_ci DEFAULT NULL,
  `operative_seat_address` text COLLATE utf8_roman_ci DEFAULT NULL,
  `operative_seat_zip` text COLLATE utf8_roman_ci DEFAULT NULL,
  `operative_seat_city` text COLLATE utf8_roman_ci DEFAULT NULL,
  `operative_seat_region` text COLLATE utf8_roman_ci DEFAULT NULL,
  `operative_seat_country` text COLLATE utf8_roman_ci DEFAULT NULL,
  `vat` text COLLATE utf8_roman_ci DEFAULT NULL,
  `tax_unique_code` text COLLATE utf8_roman_ci DEFAULT NULL,
  `vat_percent` decimal(5,2) DEFAULT 22.00,
  `witholding_tax_percent` decimal(5,2) DEFAULT 0.00,
  `pec` text COLLATE utf8_roman_ci DEFAULT NULL,
  `email` text COLLATE utf8_roman_ci DEFAULT NULL,
  `phone` text COLLATE utf8_roman_ci DEFAULT NULL,
  `mobile` text COLLATE utf8_roman_ci DEFAULT NULL,
  `referent_name` text COLLATE utf8_roman_ci DEFAULT NULL,
  `referent_surname` text COLLATE utf8_roman_ci DEFAULT NULL,
  `referent_mobile` text COLLATE utf8_roman_ci DEFAULT NULL,
  `shop_sign` text COLLATE utf8_roman_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

--
-- Dump dei dati per la tabella `users_company_data`
--

INSERT INTO `users_company_data` (`id`, `user_id`, `company_name`, `legal_seat`, `legal_seat_address`, `legal_seat_zip`, `legal_seat_city`, `legal_seat_region`, `legal_seat_country`, `operative_seat`, `operative_seat_address`, `operative_seat_zip`, `operative_seat_city`, `operative_seat_region`, `operative_seat_country`, `vat`, `tax_unique_code`, `vat_percent`, `witholding_tax_percent`, `pec`, `email`, `phone`, `mobile`, `referent_name`, `referent_surname`, `referent_mobile`, `shop_sign`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-05 17:25:03', '2020-08-08 17:32:10', NULL),
(2, 2, 'test', NULL, NULL, NULL, NULL, 'Abruzzo', NULL, NULL, NULL, NULL, NULL, 'Abruzzo', NULL, NULL, NULL, '22.00', '0.00', NULL, NULL, NULL, NULL, 'Test2', 'De Testis', '123', 'test', '2020-08-05 17:27:50', '2020-08-06 22:20:58', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `users_configuration`
--

CREATE TABLE `users_configuration` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `default_gain` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dump dei dati per la tabella `users_configuration`
--

INSERT INTO `users_configuration` (`id`, `user_id`, `default_gain`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '10.00', '2020-08-09 06:14:25', '2020-08-13 18:39:52', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `users_groups`
--

CREATE TABLE `users_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(4) DEFAULT 1,
  `name` varchar(128) COLLATE utf8_roman_ci NOT NULL,
  `description` varchar(512) COLLATE utf8_roman_ci DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `use_margin` tinyint(1) NOT NULL DEFAULT 1,
  `logo` text COLLATE utf8_roman_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci ROW_FORMAT=COMPACT;

--
-- Dump dei dati per la tabella `users_groups`
--

INSERT INTO `users_groups` (`id`, `type`, `name`, `description`, `discount`, `use_margin`, `logo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 1, 'STANDARD', 'STANDARD PRICING', '0.00', 1, NULL, '2020-08-08 16:37:35', '2020-08-08 21:58:27', NULL),
(7, 1, 'PREMIUM', 'PREMIUM PRICING', '0.00', 1, NULL, '2020-08-08 16:38:11', '2020-08-08 21:59:06', NULL),
(10, 2, 'Agente Standard', 'test', '0.00', 1, NULL, '2020-11-17 12:25:24', '2020-11-17 12:25:24', NULL),
(11, 2, 'Agente ping', 'ping', '0.00', 1, NULL, '2020-11-17 12:28:25', '2021-08-25 10:38:23', NULL),
(12, 1, 'ping', 'ping', NULL, 0, 'logo1629887142.png', '2021-06-04 11:57:09', '2021-08-25 10:33:09', NULL),
(13, 1, 'test', 'test', '0.00', 0, NULL, '2021-08-26 07:25:30', '2021-08-26 07:25:55', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `users_groups_configurations`
--

CREATE TABLE `users_groups_configurations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `target_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('percent','value','total_percent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `users_groups_configurations`
--

INSERT INTO `users_groups_configurations` (`id`, `group_id`, `target_group_id`, `category_id`, `type`, `amount`, `created_at`, `updated_at`) VALUES
(1, 10, 6, 1, 'percent', '0.20', '2020-11-17 12:25:24', '2020-11-19 13:27:22'),
(2, 10, 6, 2, 'percent', '3.00', '2020-11-17 12:25:24', '2020-11-17 12:27:21'),
(3, 10, 6, 3, 'value', '0.50', '2020-11-17 12:25:24', '2020-11-19 13:27:22'),
(4, 10, 7, 1, 'percent', '0.20', '2020-11-17 12:25:24', '2020-11-19 13:27:22'),
(5, 10, 7, 2, 'percent', '1.00', '2020-11-17 12:25:24', '2020-11-19 13:27:22'),
(6, 10, 7, 3, 'value', '0.50', '2020-11-17 12:25:24', '2020-11-19 13:27:22'),
(7, 11, 6, 1, 'percent', '2.00', '2020-11-17 12:28:25', '2020-11-17 12:28:25'),
(8, 11, 6, 2, 'percent', '3.00', '2020-11-17 12:28:25', '2021-09-04 12:59:12'),
(9, 11, 6, 3, 'value', '5.00', '2020-11-17 12:28:25', '2020-11-17 12:28:25'),
(10, 11, 7, 1, 'percent', '3.00', '2020-11-17 12:28:25', '2020-11-17 12:28:25'),
(11, 11, 7, 2, 'percent', '1.00', '2020-11-17 12:28:25', '2021-09-04 12:59:12'),
(12, 11, 7, 3, 'value', '6.00', '2020-11-17 12:28:25', '2020-11-17 12:28:25'),
(13, 11, 12, 1, 'percent', '0.20', '2021-08-25 10:38:23', '2021-08-25 10:38:23'),
(14, 11, 12, 2, 'total_percent', '12.00', '2021-08-25 10:38:23', '2021-09-04 12:59:12'),
(15, 11, 12, 3, 'percent', '5.00', '2021-08-25 10:38:23', '2021-08-25 10:38:23');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `agent_operations`
--
ALTER TABLE `agent_operations`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `email_template`
--
ALTER TABLE `email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `example`
--
ALTER TABLE `example`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `folder`
--
ALTER TABLE `folder`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `form_field`
--
ALTER TABLE `form_field`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indici per le tabelle `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `menus_lang`
--
ALTER TABLE `menus_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `menu_lang_lists`
--
ALTER TABLE `menu_lang_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `menu_role`
--
ALTER TABLE `menu_role`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indici per le tabelle `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indici per le tabelle `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indici per le tabelle `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `payments_file`
--
ALTER TABLE `payments_file`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `providers_referents`
--
ALTER TABLE `providers_referents`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indici per le tabelle `role_hierarchy`
--
ALTER TABLE `role_hierarchy`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `service_categories_countries`
--
ALTER TABLE `service_categories_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `service_categories_operators`
--
ALTER TABLE `service_categories_operators`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `service_countries`
--
ALTER TABLE `service_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `service_operations`
--
ALTER TABLE `service_operations`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `service_operators`
--
ALTER TABLE `service_operators`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indici per le tabelle `users_company_data`
--
ALTER TABLE `users_company_data`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users_configuration`
--
ALTER TABLE `users_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users_groups_configurations`
--
ALTER TABLE `users_groups_configurations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `agent_operations`
--
ALTER TABLE `agent_operations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `email_template`
--
ALTER TABLE `email_template`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `example`
--
ALTER TABLE `example`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `folder`
--
ALTER TABLE `folder`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `form`
--
ALTER TABLE `form`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `form_field`
--
ALTER TABLE `form_field`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT per la tabella `menus_lang`
--
ALTER TABLE `menus_lang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=395;

--
-- AUTO_INCREMENT per la tabella `menu_lang_lists`
--
ALTER TABLE `menu_lang_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `menu_role`
--
ALTER TABLE `menu_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=307;

--
-- AUTO_INCREMENT per la tabella `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `payments_file`
--
ALTER TABLE `payments_file`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `providers`
--
ALTER TABLE `providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `providers_referents`
--
ALTER TABLE `providers_referents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `role_hierarchy`
--
ALTER TABLE `role_hierarchy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `service_categories_countries`
--
ALTER TABLE `service_categories_countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `service_categories_operators`
--
ALTER TABLE `service_categories_operators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT per la tabella `service_countries`
--
ALTER TABLE `service_countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT per la tabella `service_operations`
--
ALTER TABLE `service_operations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `service_operators`
--
ALTER TABLE `service_operators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `users_company_data`
--
ALTER TABLE `users_company_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `users_configuration`
--
ALTER TABLE `users_configuration`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `users_groups_configurations`
--
ALTER TABLE `users_groups_configurations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
