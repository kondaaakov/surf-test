-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 10.0.2.30
-- Время создания: Мар 17 2023 г., 21:28
-- Версия сервера: 5.7.37-40
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `f0751641_surf`
--

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(45) NOT NULL,
  `spot_id` int(45) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `question_1` int(10) NOT NULL,
  `question_2` int(10) NOT NULL,
  `question_3` int(10) NOT NULL,
  `question_4` int(10) NOT NULL,
  `question_5` int(10) NOT NULL,
  `question_6` int(10) NOT NULL,
  `question_7` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `spot_id`, `created_date`, `question_1`, `question_2`, `question_3`, `question_4`, `question_5`, `question_6`, `question_7`) VALUES
(1, 2, 5, '2023-03-17 17:03:46', 5, 3, 4, 2, 3, 5, 5),
(2, 2, 1, '2023-03-17 17:04:16', 5, 5, 5, 5, 5, 5, 5),
(3, 2, 4, '2023-03-17 17:04:27', 4, 3, 2, 5, 3, 4, 5),
(4, 2, 1, '2023-02-17 17:44:01', 4, 5, 5, 3, 5, 5, 4),
(5, 2, 6, '2023-03-17 21:25:54', 4, 3, 5, 5, 5, 2, 5),
(6, 2, 2, '2023-03-17 21:26:29', 5, 5, 5, 5, 4, 4, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `spots`
--

CREATE TABLE `spots` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `spots`
--

INSERT INTO `spots` (`id`, `name`, `city_id`) VALUES
(1, 'Primary', 1),
(2, 'OTTO', 1),
(3, 'Base', 2),
(4, 'G34', 3),
(5, 'Navaga', 1),
(6, 'Test', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `spots_cities`
--

CREATE TABLE `spots_cities` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `title_ru` varchar(64) NOT NULL,
  `title_eng` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `spots_cities`
--

INSERT INTO `spots_cities` (`id`, `country_id`, `title_ru`, `title_eng`) VALUES
(1, 1, 'Москва', 'Moscow'),
(2, 1, 'Санкт-Петербург', 'Saint-Petersburg'),
(3, 1, 'Сочи', 'Sochi'),
(4, 2, 'Ереван', 'Erevan');

-- --------------------------------------------------------

--
-- Структура таблицы `spots_countries`
--

CREATE TABLE `spots_countries` (
  `id` int(11) NOT NULL,
  `title_ru` varchar(64) NOT NULL,
  `title_eng` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `spots_countries`
--

INSERT INTO `spots_countries` (`id`, `title_ru`, `title_eng`) VALUES
(1, 'Россия', 'Russia'),
(2, 'Армения', 'Armenia'),
(3, 'Грузия', 'Georgia');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `surname` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `patronymic` varchar(64) DEFAULT NULL,
  `mail` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `group_id` int(11) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `surname`, `name`, `patronymic`, `mail`, `password`, `created_date`, `group_id`) VALUES
(1, 'Админ', 'Админ', NULL, 'admin@admin.ru', '$2y$10$La4ouU/uoEWCv56Hi/x0juEX7c68qKIEo0V7odwRmbAAZvOMVCWhu', '2023-03-16 12:15:21', 1),
(2, 'Андреев', 'Андрей', 'Андреевич', 'ins@ins.ru', '$2y$10$7RaNaTZtLA0rifHYGTLBbO55B54Ugy4tDP0NA5./jpfXu4yTJdQ5e', '2023-03-17 10:27:16', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `code` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_groups`
--

INSERT INTO `users_groups` (`id`, `title`, `code`) VALUES
(1, 'Администратор', 'ADMIN'),
(2, 'Сотрудник проверки', 'INSPECTOR');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Индексы таблицы `spots`
--
ALTER TABLE `spots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Индексы таблицы `spots_cities`
--
ALTER TABLE `spots_cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Индексы таблицы `spots_countries`
--
ALTER TABLE `spots_countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail_UNIQUE` (`mail`);

--
-- Индексы таблицы `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `spots`
--
ALTER TABLE `spots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `spots_cities`
--
ALTER TABLE `spots_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `spots_countries`
--
ALTER TABLE `spots_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
