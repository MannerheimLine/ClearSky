-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 15 2019 г., 09:17
-- Версия сервера: 8.0.15
-- Версия PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `profiles`
--

CREATE TABLE `profiles` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id',
  `user` int(10) UNSIGNED NOT NULL COMMENT 'ссылка на пользователя',
  `surname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'фамилия',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'имя'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Профили';

--
-- Дамп данных таблицы `profiles`
--

INSERT INTO `profiles` (`id`, `user`, `surname`, `name`) VALUES
(1, 1, 'Петров', 'Петр');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id',
  `login` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'логин',
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'пароль',
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'email'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Пользователи';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`) VALUES
(1, 'admin', '12345', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
