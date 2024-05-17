-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Апр 30 2024 г., 09:56
-- Версия сервера: 5.7.39
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `study`
--

-- --------------------------------------------------------

--
-- Структура таблицы `diplom_1`
--

CREATE TABLE `diplom_1` (
  `id` int(11) NOT NULL,
  `is_admin` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `workplace` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `vk` varchar(255) DEFAULT NULL,
  `tg` varchar(255) DEFAULT NULL,
  `insta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `diplom_1`
--

INSERT INTO `diplom_1` (`id`, `is_admin`, `email`, `password`, `name`, `workplace`, `phone_number`, `location`, `job_title`, `avatar`, `status`, `vk`, `tg`, `insta`) VALUES
(29, 'admin', 'admin@admin.com', '$2y$10$Y9zCIJvmbs1teyceUU4ppu8dQjZfQAd2ME3VNewArZ6ajtC/nHJV.', 'Admin', 'Home', '1-123-456-78-90', 'Miami', NULL, 'avatarjesus662ff397bb8e5.png', 'success', 'ya.ru', 'ya.ru', 'ya.ru'),
(30, NULL, 'user@user.com', '$2y$10$c3Nm2M37zP6eVwWV2F9o2.U86nvXRg/pwBxayix6cTB.KWqO3Wkbe', 'user', 'User', '8123123123', 'User', NULL, 'avatara662ff3e0437b5.png', 'warning', '', '', ''),
(31, NULL, 'hello@hello.com', '$2y$10$rf7eedLl1psYZCDM4oK4MesSn5RUKtC89xl4HjSxf8eKKVpo6cg4y', 'User_2', 'sodsoidi', 'j39i2-30ei', 'divjsodjvo', NULL, 'avatarj662ff43e4be63.png', 'danger', '', '', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `diplom_1`
--
ALTER TABLE `diplom_1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `diplom_1`
--
ALTER TABLE `diplom_1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
