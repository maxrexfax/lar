-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Окт 31 2020 г., 11:54
-- Версия сервера: 8.0.22-0ubuntu0.20.04.2
-- Версия PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `laravel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lon` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `name`, `description`, `lat`, `lon`, `created_at`, `updated_at`) VALUES
(1, 'ZP', 'Описание города Запорожья', '47.871633', '35.053650', '2020-10-12 06:34:52', '2020-10-12 06:34:52'),
(2, 'Kiev', 'Описание города Киев', '50.4529137', '30.2525158', '2020-10-12 06:34:52', '2020-10-12 06:34:52'),
(3, 'Lviv', 'Описание города Львов', '49.8326679', '23.9421962', '2020-10-12 06:34:52', '2020-10-12 06:34:52'),
(4, 'Dnepr', 'Описание города Днепр', '48.4622135', '34.8602746', '2020-10-12 06:34:52', '2020-10-12 06:34:52');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `author_id` bigint UNSIGNED DEFAULT NULL,
  `target_id` int DEFAULT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `parent_id`, `author_id`, `target_id`, `text`, `message_date`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 2, 'Message from admin to maxrexfax', '2020-10-10 20:27:26', NULL, NULL),
(2, NULL, 2, 1, 'Answer from maxrexfax to admin', '2020-10-15 20:27:42', NULL, NULL),
(7, NULL, 1, 3, 'Message from admin to id=3 user', '2020-10-11 20:27:53', NULL, NULL),
(8, NULL, 1, 4, 'Message from admin to id=4 user', '2020-10-12 20:27:57', NULL, NULL),
(9, NULL, 1, 2, 'Another message to maxrexfax from admin', '2020-10-14 20:29:21', NULL, NULL),
(10, NULL, 2, 1, 'Another message from maxrexfax to admin text text text text text text text text text text text text text text ', '2020-10-15 20:29:21', NULL, NULL),
(11, NULL, 1, 2, 'Test message from admin to maxrexfax in popup window', '2020-10-19 12:19:42', '2020-10-19 09:19:42', '2020-10-19 09:19:42'),
(12, NULL, 1, 2, 'Test message from admin to maxrexfax in popup window 1', '2020-10-19 12:29:03', '2020-10-19 09:29:03', '2020-10-19 09:29:03'),
(13, NULL, 1, 2, 'Test message from admin to maxrexfax in popup window 2', '2020-10-19 12:29:37', '2020-10-19 09:29:37', '2020-10-19 09:29:37'),
(14, NULL, 1, 2, 'Test message from admin to maxrexfax in popup window 3', '2020-10-19 12:30:07', '2020-10-19 09:30:07', '2020-10-19 09:30:07'),
(15, NULL, 2, 1, 'Test from max to admin', '2020-10-19 12:38:56', '2020-10-19 09:38:56', '2020-10-19 09:38:56'),
(16, NULL, 1, 2, 'Answ from admin to max', '2020-10-19 12:39:44', '2020-10-19 09:39:44', '2020-10-19 09:39:44'),
(17, NULL, 2, 1, 'Test from max to admin', '2020-10-19 12:39:54', '2020-10-19 09:39:54', '2020-10-19 09:39:54'),
(18, NULL, 1, 2, 'Test msg', '2020-10-19 13:33:05', '2020-10-19 10:33:05', '2020-10-19 10:33:05'),
(19, NULL, 1, 4, 'Hello Zaraznij!', '2020-10-19 14:29:33', '2020-10-19 11:29:33', '2020-10-19 11:29:33'),
(20, NULL, 1, 11, 'Hello testvalue12!', '2020-10-19 14:29:54', '2020-10-19 11:29:54', '2020-10-19 11:29:54'),
(21, NULL, 1, 11, '1234', '2020-10-20 14:18:51', '2020-10-20 11:18:51', '2020-10-20 11:18:51'),
(22, NULL, 1, 2, 'egdrg', '2020-10-20 14:30:29', '2020-10-20 11:30:29', '2020-10-20 11:30:29'),
(23, NULL, 2, 1, '14\'s message', '2020-10-21 09:30:24', '2020-10-21 06:30:24', '2020-10-21 06:30:24'),
(24, NULL, 2, 1, '15\'s message', '2020-10-21 09:30:59', '2020-10-21 06:30:59', '2020-10-21 06:30:59'),
(25, NULL, 2, 1, '16\'s message', '2020-10-21 09:32:05', '2020-10-21 06:32:05', '2020-10-21 06:32:05'),
(26, NULL, 4, 1, 'Hello admin!', '2020-10-21 12:32:59', '2020-10-21 09:32:59', '2020-10-21 09:32:59'),
(27, NULL, 1, 4, 'Hello zaraznij', '2020-10-21 12:34:07', '2020-10-21 09:34:07', '2020-10-21 09:34:07'),
(28, NULL, 4, 1, 'Hello admin 111!', '2020-10-21 12:34:14', '2020-10-21 09:34:14', '2020-10-21 09:34:14'),
(29, NULL, 1, 4, 'Hello zaraznij 2222', '2020-10-21 12:34:19', '2020-10-21 09:34:19', '2020-10-21 09:34:19'),
(30, NULL, 4, 1, 'Buy', '2020-10-21 12:34:29', '2020-10-21 09:34:29', '2020-10-21 09:34:29'),
(31, NULL, 1, 2, 'A->M', '2020-10-23 15:32:54', '2020-10-23 12:32:54', '2020-10-23 12:32:54'),
(32, NULL, 2, 1, 'M->A', '2020-10-23 15:33:03', '2020-10-23 12:33:03', '2020-10-23 12:33:03'),
(33, NULL, 1, 2, 'A->M', '2020-10-23 15:39:38', '2020-10-23 12:39:38', '2020-10-23 12:39:38'),
(34, NULL, 1, 2, 'A->M', '2020-10-23 15:43:38', '2020-10-23 12:43:38', '2020-10-23 12:43:38'),
(35, NULL, 1, 2, 'A->M', '2020-10-23 18:50:11', '2020-10-23 15:50:11', '2020-10-23 15:50:11'),
(36, NULL, 2, 1, 'M to A', '2020-10-23 19:07:19', '2020-10-23 16:07:19', '2020-10-23 16:07:19');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(12, '2014_10_12_000000_create_users_table', 1),
(13, '2014_10_12_100000_create_password_resets_table', 1),
(14, '2019_08_19_000000_create_failed_jobs_table', 1),
(15, '2020_10_09_115037_create_tables_cities', 1),
(16, '2020_10_09_115044_create_tables_messages', 1),
(17, '2020_10_12_091644_create_test_table', 2),
(18, '2020_10_12_091726_create_cities_table', 3),
(19, '2020_10_12_091911_create_users_table', 4),
(20, '2020_10_12_092205_create_messages_table', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `test`
--

CREATE TABLE `test` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int NOT NULL,
  `city_id` bigint UNSIGNED DEFAULT NULL,
  `is_eaten` int DEFAULT NULL,
  `last_logined_date` datetime DEFAULT NULL,
  `last_logined_ip` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_logined_city` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `first_name`, `middle_name`, `last_name`, `birthday`, `email`, `email_verified_at`, `phone_number`, `role_id`, `city_id`, `is_eaten`, `last_logined_date`, `last_logined_ip`, `last_logined_city`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin_5', '$2y$10$HBvM2ATs6yqmsJjBMKHatOczqqMsTd66Z/Sim.Bu8xvypI/hE2.7y', 'Admin first5', 'Admin SN', 'Admin LN', '1980-05-05', '8eeXzkLj3q@gmail.com', '2020-10-12 06:41:33', NULL, 1, 1, 1, '2020-10-31 11:49:02', '93.76.118.140', 'Zaporizhzhya', 'Eb7Gvh5TegGoTB3wg1H6roWAnfjnRAJIztutDjzYtM3zFgJxtiBg4HG9rRj0', '2020-10-12 06:41:33', '2020-10-31 09:49:02'),
(2, 'maxrexfax', '$2y$10$HBvM2ATs6yqmsJjBMKHatOczqqMsTd66Z/Sim.Bu8xvypI/hE2.7y', 'Maxim f n maxrexfax', 'Maxim SN maxrexfax', 'Maxim LN maxrexfax', '1982-06-06', 'max@ya.ru', NULL, NULL, 1, 2, 1, '2020-10-26 20:53:00', '93.76.118.140', 'Zaporizhzhya', NULL, '2020-10-12 09:03:22', '2020-10-26 18:53:00'),
(3, 'User user', '$2y$10$HBvM2ATs6yqmsJjBMKHatOczqqMsTd66Z/Sim.Bu8xvypI/hE2.7y', 'User fn', 'User mn', 'User LN', '1982-07-07', 'user@ya.ru', NULL, '+380501234567', 1, 4, 0, '2020-01-02 00:00:00', '', '', NULL, NULL, '2020-10-21 09:02:17'),
(4, 'Zaraznij', '$2y$10$HBvM2ATs6yqmsJjBMKHatOczqqMsTd66Z/Sim.Bu8xvypI/hE2.7y', 'ZarazniyNameF', 'ZarazniyNameM', 'ZarazniyNameL', '1978-05-07', 'zaraza@mail.ru', NULL, '+380502349587', 3, 3, 0, '2020-10-21 12:31:59', '', '', NULL, NULL, '2020-10-21 09:31:59'),
(5, 'testvalue', '$2y$10$HBvM2ATs6yqmsJjBMKHatOczqqMsTd66Z/Sim.Bu8xvypI/hE2.7y', 'testvalue', 'testvalue', 'testvalue', '2020-10-09', 'testvalue@mail.ru', NULL, 'testvalue', 3, 1, 0, '2020-01-03 00:00:00', '', '', NULL, '2020-10-13 11:15:31', '2020-10-14 07:42:36'),
(8, 'testvalue1', '$2y$10$HBvM2ATs6yqmsJjBMKHatOczqqMsTd66Z/Sim.Bu8xvypI/hE2.7y', 'testvalue1', 'testvalue1', 'testvalue1', '2020-10-03', 'testvalue1@mail.ru', NULL, 'testvalue1', 3, 1, 0, '2020-01-04 00:00:00', '', '', NULL, '2020-10-13 11:17:22', '2020-10-13 11:17:22'),
(11, 'testvalue12', '$2y$10$HBvM2ATs6yqmsJjBMKHatOczqqMsTd66Z/Sim.Bu8xvypI/hE2.7y', 'testvalue1', 'testvalue1', 'testvalue1', '2020-10-03', 'testvalue21@mail.ru', NULL, 'testvalue1', 3, 1, 1, '2020-01-05 00:00:00', '', '', NULL, '2020-10-13 11:22:07', '2020-10-13 11:37:52'),
(22, 'testvaluery5y ', '$2y$10$sXWT0gDKw7dSfuVtk2zgE.xMe1/YsTv.m1RTPwCQo9ueWkjQMoSha', 'testvalue', NULL, NULL, NULL, 'testvalue5@mail.ru', NULL, NULL, 3, 3, 1, '2020-01-07 00:00:00', '', '', NULL, '2020-10-13 12:03:02', '2020-10-20 12:13:45'),
(26, 'testvalue777777', '$2y$10$m.UpOGkJ0nx.x7I2LXp4NuDSSR65zvHF4fmZDhMC8N7.Ezuy1Uzpu', 'testvalue7', 'testvalue7', 'testvalue7', '2020-10-15', 'testvalue777@mail.ru', NULL, '777777777777', 3, 2, 0, '2020-10-14 00:00:00', '', '', NULL, '2020-10-14 08:34:41', '2020-10-14 13:50:35'),
(27, 'test-login-value11аа', '$2y$10$Iej/Qd49dD26RHpdF.WtDuhOWGtltYwBOuy0uh/WDWYbSZLd94RT6', 'test-fname-value-ее', 'test-mname-value', 'test-lname-value', '2020-10-16', 'testemail11111@mail.ru', NULL, '+380123456789', 3, 1, 0, '2020-10-14 00:00:00', '', '', NULL, '2020-10-14 15:04:27', '2020-10-15 05:09:21'),
(28, 'test-login-value5567', '$2y$10$2o.dteJA4U3cx9N1FaEy0uSrgyJsDQ5gjYkdry/o8QPGz38vjEjBu', 'test-fname-value5567', 'test-mname-value5567', 'test-lname-value5567', '2020-10-01', 'testemai5567l@mail.ru', NULL, '+380123456789', 3, 1, 0, '2020-10-14 00:00:00', '', '', NULL, '2020-10-14 15:38:52', '2020-10-14 15:38:52'),
(30, 'test-login-value', '$2y$10$sl/aPqHWiGo2CaI.zwEJauAcN9hZc4FFMfRA2GkJGb0unlZ2M1mr2', 'test-fname-value', 'test-mname-value', 'test-lname-value', '2020-10-05', 'testem33ail@mail.ru', NULL, '+380123456789', 3, 1, 0, '2020-10-14 00:00:00', '', '', NULL, '2020-10-14 15:39:40', '2020-10-14 15:39:40'),
(34, 'test-login-value1', '$2y$10$//0cBnl9GXN2VxUHBp0sku3X0hxt4xfyvaJ/QuPVQfyaAsVv1IVYm', 'test-fname-value', 'test-mname-value', 'test-lname-value', '2020-10-01', 'testemaidsfefl@mail.ru', NULL, '+380123456789', 3, 1, 0, '2020-10-15 00:00:00', '', '', NULL, '2020-10-15 06:17:02', '2020-10-15 06:17:02'),
(35, 'testhhh-login-value', '$2y$10$X.JKOemqckq9szKXljOMB.9HxlsjBIcXZ5yzgv/HPFX71SV3B.iL2', 'test-fname-value', 'test-mname-value', 'test-lname-value', '2020-10-02', 'testhhhhemail@mail.ru', NULL, '+380123456789', 3, 1, 0, '2020-10-15 00:00:00', '', '', NULL, '2020-10-15 06:41:30', '2020-10-15 06:41:30'),
(36, 'test-login-valuewwe', '$2y$10$15ZhYgIKdQ50oT36ohXLg.597Grznu83VOuIqdac1oMcjbqjvErFK', 'test-fname-value', 'test-mname-value', 'test-lname-value', '2020-10-13', 'testemail@mail.ru', NULL, '+380123456789', 3, 1, 0, '2020-10-15 19:34:29', '', '', NULL, '2020-10-15 16:34:29', '2020-10-15 16:34:29'),
(37, 'оооооооооооооо1', '$2y$10$BDDGbGc98LFbygih/e5OVelsDXtMvBsqHlTnjfB8tPBOJrZDFT8D6', 'оооооооооооооо1', 'ооооооооооооооо1', 'ооооооооооооооо1', '2020-10-01', 'qqqqqqqqqqqq@fffff.com', NULL, '7786876876786', 3, 1, 0, '2020-10-22 07:27:36', '', '', NULL, '2020-10-18 15:18:24', '2020-10-22 04:27:36'),
(38, 'Turbotest_login', '$2y$10$FnR2N7p2TDFKr9ubiQsuE.31O7wxJYMdvfZBVXLC1qOSUjeGOiBTW', 'Turbotest_FN', 'Turbotest_MN', 'Turbotest_LN', '2020-10-02', 'Turbotest@mail.ru', NULL, '+38468468464', 3, 2, 0, '2020-10-20 08:57:56', '', '', NULL, '2020-10-20 05:57:56', '2020-10-20 05:57:56'),
(39, 'testvalue44', '$2y$10$NlTyLoQv728x3s6A/LuGVux63BtlhjgZxQbchfK3kFXPjVqBtdXZq', 'ggregr', 'gdgdfrgr', 'gdgdrgrg', '2020-10-08', 'rgrgr@sgrgr.rg', '2020-10-20 11:41:02', '555555555555555555', 3, 1, 1, '2020-10-20 14:41:02', '', '', NULL, '2020-10-20 11:41:02', '2020-10-20 12:02:07'),
(40, 'admin_544', '$2y$10$OVfae8MkOEhAVEiLw.6QxekN9Cnl2M2htHfeiRqqHtC9ATbKPkfhW', '44', '44', '444', '2020-10-01', 'qqqqqqq444qqqqq@fffff.com', '2020-10-20 11:44:42', '55555555555555', 3, 1, 0, '2020-10-20 14:44:42', '', '', NULL, '2020-10-20 11:44:42', '2020-10-20 11:44:42'),
(41, 'ad33min_544', '$2y$10$L8srg1fEsc5ZUiqeeQlP8.alaw8dZC1Ge7w.LXrbedWii8DLZpcBu', '44', '44', '444', '2020-10-01', 'qqqqqqq444qqq3qq@fffff.com', '2020-10-20 11:46:54', '222eeeee', 3, 1, 0, '2020-10-20 14:46:54', '', '', NULL, '2020-10-20 11:46:54', '2020-10-21 04:54:22'),
(42, 'admin_5222', '$2y$10$7Z47QzYHHsK400UZD5T/4OYW1Iv4EmlOl3XSnu4ryY4KZwTUr0wvy', 'пппппппппппп1111', 'testvalue1', 'кккк', '2020-10-09', 'ma1x@ya.ru', '2020-10-20 11:56:39', '555555555', 3, 1, 0, '2020-10-20 14:56:39', '', '', NULL, '2020-10-20 11:56:39', '2020-10-21 15:34:00'),
(43, 'barannikm123', '$2y$10$cDiZYnOTyHssv0W4T0/6Ku9WKOmi8B5oNf/5rmrKsJtPBb4bpyRi2', 'barannikm123', 'barannikm123', 'barannikm123', '2020-10-02', 'barannikm123@fffff.com', '2020-10-23 07:27:23', '1111111111111111', 3, 4, 0, '2020-10-23 10:27:23', '', '', NULL, '2020-10-23 07:27:23', '2020-10-23 07:27:23'),
(44, 'barannikm345', '$2y$10$jThwcXpOF1GPtjqzCDj7m.3czN62JKWWgWlGe4.HX/q/Wd4iun9L2', 'barannikm345', 'barannikm345', 'barannikm345', '2020-10-02', 'barannikm345@fffff.com', '2020-10-23 07:30:42', '11111111111', 3, 1, 0, '2020-10-23 10:30:42', '', '', NULL, '2020-10-23 07:30:42', '2020-10-23 07:30:42'),
(45, 'barannikm4444', '$2y$10$5UzeS2OB5hAorAaoi7HGi.DbS6LP4iS5dlYugkdIwU1qJmfwjtftO', 'barannikm4444', 'barannikm4444', 'barannikm4444', '2020-10-02', 'barannikm4444@fffff.com', '2020-10-23 07:44:24', '1111111111111', 3, 1, 0, '2020-10-23 10:44:24', '', '', NULL, '2020-10-23 07:44:24', '2020-10-23 07:44:24'),
(46, 'barannikm789', '$2y$10$uPkw1/uSPZaB7CMaVp.99.mLd8WLIEyGkpgV5hxKFfwylV9s5BQES', 'barannikm789', 'barannikm789', 'barannikm789', '2020-10-02', 'barannikm789@fffff.com', '2020-10-23 07:53:03', '22222222222', 3, 1, 0, '2020-10-23 10:53:03', '', '', NULL, '2020-10-23 07:53:03', '2020-10-23 07:53:03'),
(47, 'barannikm3333', '$2y$10$TaWRfjqn.bc.bzPAP9hXT.K8RosiKKCd90M8gLvOcMQ0lGR06BirO', 'barannikm3333', 'barannikm3333', 'barannikm3333', '2020-10-02', 'barannikm3333@fffff.com', '2020-10-23 07:55:16', '3333333333333', 3, 1, 0, '2020-10-23 10:55:16', '', '', NULL, '2020-10-23 07:55:16', '2020-10-23 07:55:16'),
(48, 'barannikm454354', '$2y$10$xVtNITzIgoCE2G5e9p/7S.0NaEE5QtVDodr9JI6oL.f9Ej6mubWWe', 'barannikm454354', 'barannikm454354', 'barannikm454354', '2020-10-01', 'barannikm454354@fffff.com', '2020-10-23 07:58:53', '33333333333', 3, 1, 0, '2020-10-23 10:58:53', '', '', NULL, '2020-10-23 07:58:53', '2020-10-23 07:58:53'),
(49, 'barannikm3453454', '$2y$10$VB3AIuXQ8hqiOvkQ2DMGN.Lg9xpjNrxBjMFDuum4.p6A7WIHnA8UC', 'barannikm3453454', 'barannikm3453454', 'barannikm3453454', '2020-10-01', 'barannikm3453454@fffff.com', '2020-10-23 07:59:54', '333333333333333', 3, 1, 0, '2020-10-23 10:59:54', '', '', NULL, '2020-10-23 07:59:54', '2020-10-23 07:59:54'),
(50, 'barannikmTet', '$2y$10$pEOVkRZVLkuFr4bJpO8lHuIF1c22VLAzXVi.h2/BsmeKz2Hbb/C8S', 'barannikmTet', 'barannikmTet', 'barannikmTet', '2020-10-02', 'barannikmTet@fffff.com', '2020-10-23 08:10:41', '333333333333', 3, 1, 0, '2020-10-23 11:10:41', '', '', NULL, '2020-10-23 08:10:41', '2020-10-23 08:10:41'),
(51, 'barannikmTet111', '$2y$10$vG3gPPpMfOndXGeFHoUo3Oxv5Y/jkvpu3tm0yOAeH9oi04GNV4nu2', 'barannikmTet', 'barannikmTet', 'barannikmTet', '2020-10-02', 'barannik111mTet@fffff.com', '2020-10-23 08:12:16', '333333333333', 3, 1, 0, '2020-10-23 11:12:16', '', '', NULL, '2020-10-23 08:12:16', '2020-10-23 08:12:16');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_parent_id_foreign` (`parent_id`),
  ADD KEY `messages_author_id_foreign` (`author_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `users_city_id_foreign` (`city_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `test`
--
ALTER TABLE `test`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
