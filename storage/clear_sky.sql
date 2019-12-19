-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 19 2019 г., 14:44
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
-- База данных: `clear_sky`
--

-- --------------------------------------------------------

--
-- Структура таблицы `alive_status`
--

CREATE TABLE `alive_status` (
  `id` tinyint(1) UNSIGNED NOT NULL COMMENT 'id - записи',
  `is_alive` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'статус'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица со статусами жизни';

--
-- Дамп данных таблицы `alive_status`
--

INSERT INTO `alive_status` (`id`, `is_alive`) VALUES
(1, 'Живой'),
(2, 'Мертвый');

-- --------------------------------------------------------

--
-- Структура таблицы `attach_status`
--

CREATE TABLE `attach_status` (
  `id` tinyint(1) UNSIGNED NOT NULL COMMENT 'id - записи',
  `is_attached` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'статус прикрепления'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица со статусами о прикреплении пациента';

--
-- Дамп данных таблицы `attach_status`
--

INSERT INTO `attach_status` (`id`, `is_attached`) VALUES
(1, 'Прикреплен'),
(2, 'Откреплен');

-- --------------------------------------------------------

--
-- Структура таблицы `being_edited_patient_cards`
--

CREATE TABLE `being_edited_patient_cards` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id - записи',
  `patient_card_id` int(10) UNSIGNED NOT NULL COMMENT 'id - карты которая редактируется',
  `user_account` smallint(5) UNSIGNED NOT NULL COMMENT 'учетная запись пользователя заблокировавшего карту',
  `block_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'время и дата блокировки карты в статусе "редактируется"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с заблокированными для редактирования картами' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `districts`
--

CREATE TABLE `districts` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'id - записи',
  `district_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'имя района',
  `region` tinyint(3) UNSIGNED NOT NULL COMMENT 'id региона'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с данными о районах';

--
-- Дамп данных таблицы `districts`
--

INSERT INTO `districts` (`id`, `district_name`, `region`) VALUES
(1, 'Анучинский Район', 25),
(2, 'Дальнегорский городской округ', 25),
(3, 'Дальнереченский Район', 25),
(4, 'Кавалеровский Район', 25),
(5, 'Кировский Район', 25),
(6, 'Красноармейский Район', 25),
(7, 'Лазовский Район', 25),
(8, 'Лесозаводский городской округ', 25),
(9, 'Михайловский Район', 25),
(10, 'Надеждинский Район', 25),
(11, 'Октябрьский Район', 25),
(12, 'Ольгинский Район', 25),
(13, 'Партизанский Район', 25),
(14, 'Пограничный Район', 25),
(15, 'Пожарский Район', 25),
(16, 'Спасский городской округ', 25),
(17, 'Тернейский Район', 25),
(18, 'Уссурйиский городской округ', 25),
(19, 'Ханкайский Район', 25),
(20, 'Хасанский Район', 25),
(21, 'Хорольский Район', 25),
(22, 'Черниговский Район', 25),
(23, 'Чугуевский Район', 25),
(24, 'Шкотовский Район', 25),
(25, 'Яковлевский Район', 25);

-- --------------------------------------------------------

--
-- Структура таблицы `gender`
--

CREATE TABLE `gender` (
  `id` tinyint(1) UNSIGNED NOT NULL COMMENT 'id - записи',
  `system_name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'системное имя',
  `description` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'описание'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с данными о поле';

--
-- Дамп данных таблицы `gender`
--

INSERT INTO `gender` (`id`, `system_name`, `description`) VALUES
(1, 'male', 'мужчина'),
(2, 'female', 'женщина');

-- --------------------------------------------------------

--
-- Структура таблицы `insurance_companies`
--

CREATE TABLE `insurance_companies` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'id - записи',
  `insurance_company_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'название страховой компании',
  `insurer_code` char(2) NOT NULL COMMENT 'код страховщика'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с названиями страховых организаций';

--
-- Дамп данных таблицы `insurance_companies`
--

INSERT INTO `insurance_companies` (`id`, `insurance_company_name`, `insurer_code`) VALUES
(1, 'Восточной страховой альянс', '11'),
(2, 'Спасские ворота', '16');

-- --------------------------------------------------------

--
-- Структура таблицы `localities`
--

CREATE TABLE `localities` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id - записи',
  `locality_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'название населенного пункта',
  `district` smallint(5) UNSIGNED NOT NULL COMMENT 'район'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с названиями населенных пунктов';

--
-- Дамп данных таблицы `localities`
--

INSERT INTO `localities` (`id`, `locality_name`, `district`) VALUES
(1, 'Антоновка', 23),
(2, 'Архиповка', 23),
(3, 'Березовка', 23),
(4, 'Булыга-Фадеево', 23),
(5, 'Варпаховка', 23),
(6, 'Верхняя Бреевка', 23),
(7, 'Заветное', 23),
(8, 'Заметное', 23),
(9, 'Извилинка', 23),
(10, 'Изюбринный', 23),
(11, 'Каменка', 23),
(12, 'Кокшаровка', 23),
(13, 'Ленино', 23),
(14, 'Лесогорье', 23),
(15, 'Медвежий Кут', 23),
(16, 'Михайловка', 23),
(17, 'Нижние Лужки', 23),
(18, 'Новомихайловка', 23),
(19, 'Новочугуевка', 23),
(20, 'Окраинка', 23),
(21, 'Павловка', 23),
(22, 'Полыниха', 23),
(23, 'Пшеницино', 23),
(24, 'Самарка', 23),
(25, 'Саратовка', 23),
(26, 'Соколовка', 23),
(27, 'Тополевый', 23),
(28, 'Уборка', 23),
(29, 'Цветкова', 23),
(30, 'Чугуевка', 23),
(31, 'Шумный', 23),
(32, 'Ясное', 23);

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE `menu` (
  `id` tinyint(3) UNSIGNED NOT NULL COMMENT 'id - записи',
  `menu_name` varchar(50) NOT NULL,
  `menu_description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Меню существующие в системе';

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `menu_name`, `menu_description`) VALUES
(1, 'administrator_menu', 'Административное меню'),
(2, 'application_menu', 'Меню приложения');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_links`
--

CREATE TABLE `menu_links` (
  `id` tinyint(3) UNSIGNED NOT NULL COMMENT 'id - записи',
  `link` varchar(255) NOT NULL COMMENT 'ссылка меню',
  `menu` tinyint(3) UNSIGNED NOT NULL COMMENT 'меню к которому относится ссылка',
  `icon` varchar(50) NOT NULL COMMENT 'иконка меню',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'наименование ссылки',
  `name` varchar(20) NOT NULL COMMENT 'имя ссылки',
  `priority` tinyint(3) UNSIGNED NOT NULL COMMENT 'приоритет отображения'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица со ссылками меню';

--
-- Дамп данных таблицы `menu_links`
--

INSERT INTO `menu_links` (`id`, `link`, `menu`, `icon`, `title`, `name`, `priority`) VALUES
(1, '/app/desktop', 2, 'fa fa-desktop', 'Рабочий стол', 'desktop-link', 0),
(2, '/app/patient-card', 2, 'fa fa-id-card-alt', 'Карта пациента', 'patient-card-link', 0),
(3, '/administrator/desktop', 2, 'fa fa-cogs', 'Администрирование', 'desktop-link', 0),
(4, '/administrator/desktop', 1, 'fa fa-desktop', 'Рабочий стол', 'desktop-link', 0),
(5, '/administrator/users', 1, 'fa fa-users', 'Пользователи', 'users-link', 0),
(6, '/administrator/database', 1, 'fa fa-database', 'База данных', 'db-link', 0),
(7, '/administrator/patient-cards', 1, 'fa fa-id-card-alt', 'Медицинская карта', 'emr-link', 0),
(8, '/administrator/menu', 1, 'fa fa-bars', 'Управление меню', 'menus-link', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `patient_cards`
--

CREATE TABLE `patient_cards` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id - записи',
  `card_number` varchar(10) NOT NULL COMMENT 'номер карты пациента',
  `is_alive` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'статус жив или нет',
  `is_attached` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'статус прикреплен или нет',
  `surname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'фамилия',
  `firstname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'имя',
  `secondname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'отчество',
  `gender` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'пол',
  `date_birth` date NOT NULL DEFAULT '1900-01-01' COMMENT 'дата рождения',
  `telephone_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'номер телефона для связи',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'email адрес для связи',
  `insurance_certificate` char(14) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'снилс',
  `policy_number` char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'номер полиса',
  `insurance_company` smallint(5) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'страховая компания выдавшая полис',
  `passport_serial` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'серия паспорта',
  `passport_number` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'номер паспорта',
  `fms_department` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'отдел ФМС выдавший паспорт',
  `birth_certificate_serial` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'серия свидетельства о рождении',
  `birth_certificate_number` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'номер свидетельства о рождении',
  `registry_office` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'отдел ЗАГСа выдавший свидетельство',
  `region` tinyint(3) UNSIGNED DEFAULT '25' COMMENT 'регион',
  `district` smallint(5) UNSIGNED DEFAULT '23' COMMENT 'район',
  `locality` int(10) UNSIGNED DEFAULT '30' COMMENT 'населенный пункт',
  `street` int(10) UNSIGNED DEFAULT NULL COMMENT 'название улицы',
  `house_number` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'номер дома',
  `apartment` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'номер квартиры',
  `work_place` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'место работы',
  `profession` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'профессия',
  `notation` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'примечание к карте'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с данными о пациентах';

--
-- Дамп данных таблицы `patient_cards`
--

INSERT INTO `patient_cards` (`id`, `card_number`, `is_alive`, `is_attached`, `surname`, `firstname`, `secondname`, `gender`, `date_birth`, `telephone_number`, `email`, `insurance_certificate`, `policy_number`, `insurance_company`, `passport_serial`, `passport_number`, `fms_department`, `birth_certificate_serial`, `birth_certificate_number`, `registry_office`, `region`, `district`, `locality`, `street`, `house_number`, `apartment`, `work_place`, `profession`, `notation`) VALUES
(1, '12345', 1, 1, 'Иванов', 'Юрий', 'Витальевич', 1, '1987-03-01', '8(914)231-23-32', 'ivanov@mail.ru', '324-234-234 23', '8601985125200533', 1, '0504', '212134', 'Отдел МВД России по Чугуевскому району 25.01.2007 года', NULL, NULL, '', 25, 23, 30, NULL, '330', '1', 'Почта', 'Оператор', 'Просто примечание'),
(2, '123434', 1, 2, 'Иванов', 'Игорь', 'Семенович', 1, '1989-02-05', '', '', '324-234-234 21', '8601985125200531', 2, NULL, NULL, '', NULL, NULL, '', 25, 23, 30, NULL, '', '', '', '', ''),
(3, '12345111', 1, 1, 'Иванова', 'Клавдия', 'Владимировна', 2, '1960-09-03', '8(912)343-21-51', 'ivanova@mail.ru', '111-222-333 44', '1132432432434334', 1, '0502', '123654', 'Отдел МВД России по Чугуевскому району', '12-32', '132323', 'Чугуевский Загс', 23, 23, 19, NULL, '200', '1', 'ЖД станция', 'вахтер', 'Дополнений нет'),
(5, '1231232', 1, 2, 'Иванова', 'Юлия', 'Викторовна', 2, '1992-11-02', '', 'ivanova@mail.ru', '123-321-123 21', '123412341234', 1, '0504', '123443', '', NULL, NULL, '', 25, 23, 30, NULL, '', '', '', '', ''),
(6, '12345111', 1, 1, 'Иванов', 'Сергей', 'Георгиевич', 1, '2002-01-15', '', '', '221-321-213 44', '3214321432143214', 1, NULL, NULL, '', '-', NULL, '', 25, 23, 30, NULL, '', '', '', '', ''),
(7, '12345111', 1, 1, 'Иванов', 'Виктор', 'Семенович', 1, '1956-01-01', '', '', '221-321-213 43', '1212343456567878', 1, NULL, NULL, '', '-', NULL, '', 25, 23, 30, NULL, '', '', '', '', ''),
(8, '12345111', 1, 1, 'Иванов', 'Сергей', 'Станиславович', 1, '1951-01-01', '89023221253', '', '123-321-221 01', '1231123212331234', 1, '', NULL, NULL, NULL, NULL, NULL, 25, 23, 30, NULL, '', '', '', '', ''),
(9, '12345111', 1, 1, 'Иванов', 'Игорь', 'Петрович', 1, '2001-09-01', '', '', '231-231-233 21', '1221343421343213', 1, '', NULL, NULL, NULL, NULL, NULL, 25, 23, 30, NULL, '1', '1', '', '', ''),
(10, '12345111', 1, 1, 'Виторган', 'Виталий', 'Григорьевич', 1, '2012-12-12', '', '', '123-456-121 22', '1212343456566565', 1, '0304', '123432', '', NULL, NULL, '', 25, 23, 30, NULL, '', '', 'ЛЗК', 'Слесарь', ''),
(11, '12345111', 1, 1, 'Иванов', 'Святослав', 'Сергеевич', 1, '1992-12-12', '', '', '321-312-321 23', '3233122222342211', 1, '0504', '323212', NULL, NULL, NULL, NULL, 25, 23, 26, NULL, '', '', '', '', ''),
(12, '12314', 1, 1, 'Иванов', 'Сергей', 'Викторович', 1, '1981-02-01', '', '', '312-432-432 34', '1212321234321111', 1, NULL, NULL, '', NULL, NULL, '', 25, 23, 30, 2, '', '', '', '', ''),
(14, '3213', 1, 1, 'Иванов', 'Игорь', 'Витальвич', 1, '1992-10-09', NULL, NULL, '312-312-331 23', '1111232143211232', 1, NULL, NULL, NULL, NULL, NULL, NULL, 25, 23, 30, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '12312312', 1, 1, 'Иванов', 'Юлиан', 'Юрьевич', 1, '1992-03-04', NULL, NULL, '123-123-213 13', '1212323212213443', 1, NULL, NULL, NULL, NULL, NULL, NULL, 25, 23, 30, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '323123', 1, 1, 'Иванова', 'Алена', 'Филлиповна', 2, '1993-02-01', NULL, NULL, '213-214-234 11', '1233123312334321', 1, NULL, NULL, NULL, NULL, NULL, NULL, 25, 23, 30, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '4234', 1, 1, 'Иванова', 'Людмила', 'Васильевна', 2, '1967-04-01', '', '', '123-21-111 21', '3211121234547642', 1, NULL, NULL, '', NULL, NULL, '', 25, 23, 30, NULL, '', '', '', '', ''),
(18, '2312123', 1, 1, 'Иванова', 'Софья', 'Андреевна', 2, '1999-04-03', NULL, NULL, '324-312-311 23', '6543564323145463', 1, NULL, NULL, NULL, NULL, NULL, NULL, 25, 23, 30, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '31232', 1, 1, 'Иванов', 'Георгий', 'Александрович', 1, '1978-01-01', '', '', '123-213-131 33', '7654321343425463', 1, NULL, NULL, '', NULL, NULL, '', 25, 23, 30, NULL, '', '', '', '', ''),
(20, '4232323', 1, 1, 'Иванов', 'Витольд', 'Сидорович', 1, '1938-01-12', NULL, NULL, '312-312-321 11', '1233212325676542', 1, NULL, NULL, NULL, NULL, NULL, NULL, 25, 23, 30, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '312311', 1, 1, 'Иванова', 'Святославна', 'Ярославовна', 2, '1992-01-11', '', 'ivanova.ya.ya@mail.ru', '145-213-642 77', '6524521345431235', 1, '4322', '121111', 'Чугуевский УФМС', NULL, NULL, '', 25, 23, 30, 4, '1', '', '', '', ''),
(22, '2312312', 1, 1, 'Иванов', 'Сандро', 'Геннадьевич', 1, '1989-01-01', NULL, NULL, '312-453-244 33', '6352142535261253', 1, NULL, NULL, NULL, NULL, NULL, NULL, 25, 23, 30, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '312313', 1, 1, 'Иванов', 'Рафаил', '', 1, '1993-01-02', NULL, NULL, '122-432-424 24', '6452432163521452', 1, NULL, NULL, NULL, NULL, NULL, NULL, 25, 23, 30, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '32123123', 1, 1, 'Иванова', 'Светлана', '', 2, '1976-01-02', NULL, NULL, '443-243-121 32', '6435243212344321', 1, NULL, NULL, NULL, NULL, NULL, NULL, 25, 23, 30, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '32432123', 1, 1, 'Иванова', 'Алевтина', '', 2, '1986-01-01', NULL, NULL, '412-312-412 43', '6543345612344321', 1, NULL, NULL, NULL, NULL, NULL, NULL, 25, 23, 30, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '21321', 1, 1, 'Иванов', 'Георгий', 'Андреевич', 1, '2012-12-21', '', '', '860-198-512 52', '324-234-234 21', 1, NULL, NULL, '', '-', NULL, '', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(66, '32213', 1, 2, 'Иванов', 'Валентин', '', 1, '2001-01-01', '', '', '324-234-234 25', '1232123443211342', 1, NULL, NULL, '', '-', NULL, '', NULL, NULL, NULL, NULL, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id - записи',
  `permission_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'имя привелегии',
  `permission_description` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'описание привилегии'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Привелегии пользователя системы';

--
-- Дамп данных таблицы `permissions`
--

INSERT INTO `permissions` (`id`, `permission_name`, `permission_description`) VALUES
(1, 'patientCardAccess', 'Доступ в карты пациентов'),
(2, 'patientCardEdit', 'Редактирование карт'),
(3, 'patientCardDelete', 'Удаление карты');

-- --------------------------------------------------------

--
-- Структура таблицы `regions`
--

CREATE TABLE `regions` (
  `id` tinyint(3) UNSIGNED NOT NULL COMMENT 'id - записи',
  `region_number` varchar(3) NOT NULL COMMENT 'номер региона',
  `region_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'имя региона'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с регионами России';

--
-- Дамп данных таблицы `regions`
--

INSERT INTO `regions` (`id`, `region_number`, `region_name`) VALUES
(1, '01', 'Республика Адыгея'),
(2, '02', 'Башкортостан Республика'),
(3, '03', ' Бурятия Республика'),
(4, '04', 'Алтай Республика'),
(5, '05', 'Дагестан Республика'),
(6, '06', 'Ингушетия Республика'),
(7, '07', 'Кабардино-Балкарская Республика'),
(8, '08', 'Калмыкия Республика'),
(9, '09', 'Карачаево-Черкесская Республика'),
(10, '10', 'Карелия Республика'),
(11, '11', 'Коми Республика'),
(12, '12', 'Марий Эл Республика'),
(13, '13', 'Мордовия Республика'),
(14, '14', 'Саха /Якутия/ Республика'),
(15, '15', 'Северная Осетия - Алания Республика'),
(16, '16', 'Татарстан Республика'),
(17, '17', 'Тыва Республика'),
(18, '18', 'Удмуртская Республика'),
(19, '19', 'Хакасия Республика'),
(20, '20', 'Чеченская Республика'),
(21, '21', 'Чувашская Республика - Чувашия'),
(22, '22', 'Алтайский Край'),
(23, '23', 'Краснодарский Край'),
(24, '24', 'Красноярский Край'),
(25, '25', 'Приморский Край');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id - записи',
  `role_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'имя роли',
  `role_description` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'описание роли'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Роли пользователя системы';

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_description`) VALUES
(1, 'administrator', 'Администратор'),
(2, 'user', 'Пользователь');

-- --------------------------------------------------------

--
-- Структура таблицы `role_permission`
--

CREATE TABLE `role_permission` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id - соотношений',
  `role_id` int(10) UNSIGNED NOT NULL COMMENT 'id - роли',
  `permission_id` int(10) UNSIGNED NOT NULL COMMENT 'id - привелегии'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Связь ролей с их привелегиями';

--
-- Дамп данных таблицы `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 1),
(5, 2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `streets`
--

CREATE TABLE `streets` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id - записи',
  `street_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'название улицы'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с названиями улиц';

--
-- Дамп данных таблицы `streets`
--

INSERT INTO `streets` (`id`, `street_name`) VALUES
(1, '50 лет Октября'),
(2, 'Алексея Лапика'),
(3, 'Арсеньева'),
(4, 'Банивура'),
(5, 'Бархатная'),
(6, 'Береговая'),
(7, 'Весенняя'),
(8, 'Восточная'),
(9, 'Всеволода Сибирцева'),
(10, 'Высокая'),
(11, 'Горный переулок'),
(12, 'Шоферская');

-- --------------------------------------------------------

--
-- Структура таблицы `streets_localities`
--

CREATE TABLE `streets_localities` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id - записи',
  `street_id` int(10) UNSIGNED NOT NULL COMMENT 'id - улицы',
  `locality_id` int(10) UNSIGNED NOT NULL COMMENT 'id - населенного пункта'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица соотношений улиц и населенных пунктов';

--
-- Дамп данных таблицы `streets_localities`
--

INSERT INTO `streets_localities` (`id`, `street_id`, `locality_id`) VALUES
(1, 1, 30),
(2, 2, 30),
(3, 3, 30),
(4, 4, 30),
(5, 5, 30),
(6, 6, 30),
(7, 7, 30),
(8, 8, 30),
(9, 9, 30),
(10, 10, 30),
(11, 11, 30),
(12, 12, 30);

-- --------------------------------------------------------

--
-- Структура таблицы `user_accounts`
--

CREATE TABLE `user_accounts` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'id - записи',
  `login` char(20) NOT NULL COMMENT 'имя учетной записи',
  `password_hash` char(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'hash пароля',
  `secret_key` varchar(255) NOT NULL COMMENT 'секретный ключ (соль)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с учетными записями пользователей';

--
-- Дамп данных таблицы `user_accounts`
--

INSERT INTO `user_accounts` (`id`, `login`, `password_hash`, `secret_key`) VALUES
(1, 'Mikki', '$2y$12$6fqLeiNwWGZcVBUIa2G3n.H56eDtuvhu44QABz0PvsPD/qtbfTxFm', '980dba8ba1552941d46c2cd92e89e248d54ee739'),
(2, 'Rain', '$2y$12$n/Wl2ddTpZylNVD72kL5reD2LGItb4aoOUHLSma/nW6uj0eByF2gS', '');

-- --------------------------------------------------------

--
-- Структура таблицы `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'id - записи',
  `surname` varchar(50) NOT NULL COMMENT 'фамилия',
  `firstname` varchar(50) NOT NULL COMMENT 'имя',
  `secondname` varchar(50) DEFAULT NULL COMMENT 'отчество',
  `account` smallint(5) UNSIGNED NOT NULL COMMENT 'аккаунт к которому привязан профиль'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с профилями пользователей';

--
-- Дамп данных таблицы `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `surname`, `firstname`, `secondname`, `account`) VALUES
(1, 'Коваленко', 'Михаил', 'Федорович', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id - записи',
  `user_id` smallint(5) UNSIGNED NOT NULL COMMENT 'id - пользователя',
  `role_id` int(10) UNSIGNED NOT NULL COMMENT 'id - роли'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Соответствие ролей пользователю';

--
-- Дамп данных таблицы `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `alive_status`
--
ALTER TABLE `alive_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `attach_status`
--
ALTER TABLE `attach_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `being_edited_patient_cards`
--
ALTER TABLE `being_edited_patient_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_account` (`user_account`),
  ADD KEY `patient_card_id` (`patient_card_id`);

--
-- Индексы таблицы `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `region` (`region`);

--
-- Индексы таблицы `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `insurance_companies`
--
ALTER TABLE `insurance_companies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `localities`
--
ALTER TABLE `localities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district` (`district`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `menu_links`
--
ALTER TABLE `menu_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu` (`menu`);

--
-- Индексы таблицы `patient_cards`
--
ALTER TABLE `patient_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `policy_number` (`policy_number`),
  ADD UNIQUE KEY `insurance_certificate` (`insurance_certificate`) USING BTREE,
  ADD UNIQUE KEY `pasport_number` (`passport_number`),
  ADD KEY `district` (`district`),
  ADD KEY `locality` (`locality`),
  ADD KEY `street` (`street`),
  ADD KEY `insurance_company` (`insurance_company`),
  ADD KEY `is_alive` (`is_alive`),
  ADD KEY `is_attached` (`is_attached`),
  ADD KEY `region` (`region`) USING BTREE,
  ADD KEY `gender` (`gender`) USING BTREE;

--
-- Индексы таблицы `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_id` (`permission_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Индексы таблицы `streets`
--
ALTER TABLE `streets`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `streets_localities`
--
ALTER TABLE `streets_localities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locality_id` (`locality_id`),
  ADD KEY `street_id` (`street_id`);

--
-- Индексы таблицы `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`);

--
-- Индексы таблицы `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `alive_status`
--
ALTER TABLE `alive_status`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `attach_status`
--
ALTER TABLE `attach_status`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `being_edited_patient_cards`
--
ALTER TABLE `being_edited_patient_cards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=288;

--
-- AUTO_INCREMENT для таблицы `districts`
--
ALTER TABLE `districts`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `gender`
--
ALTER TABLE `gender`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `insurance_companies`
--
ALTER TABLE `insurance_companies`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `localities`
--
ALTER TABLE `localities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `menu_links`
--
ALTER TABLE `menu_links`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `patient_cards`
--
ALTER TABLE `patient_cards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `regions`
--
ALTER TABLE `regions`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - соотношений', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `streets`
--
ALTER TABLE `streets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `streets_localities`
--
ALTER TABLE `streets_localities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id - записи', AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `being_edited_patient_cards`
--
ALTER TABLE `being_edited_patient_cards`
  ADD CONSTRAINT `being_edited_patient_cards_ibfk_1` FOREIGN KEY (`user_account`) REFERENCES `user_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `being_edited_patient_cards_ibfk_2` FOREIGN KEY (`patient_card_id`) REFERENCES `patient_cards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_ibfk_1` FOREIGN KEY (`region`) REFERENCES `regions` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `localities`
--
ALTER TABLE `localities`
  ADD CONSTRAINT `localities_ibfk_1` FOREIGN KEY (`district`) REFERENCES `districts` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `menu_links`
--
ALTER TABLE `menu_links`
  ADD CONSTRAINT `menu_links_ibfk_1` FOREIGN KEY (`menu`) REFERENCES `menu` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `patient_cards`
--
ALTER TABLE `patient_cards`
  ADD CONSTRAINT `patient_cards_ibfk_1` FOREIGN KEY (`gender`) REFERENCES `gender` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `patient_cards_ibfk_2` FOREIGN KEY (`region`) REFERENCES `regions` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `patient_cards_ibfk_3` FOREIGN KEY (`district`) REFERENCES `districts` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `patient_cards_ibfk_4` FOREIGN KEY (`locality`) REFERENCES `localities` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `patient_cards_ibfk_5` FOREIGN KEY (`street`) REFERENCES `streets` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `patient_cards_ibfk_6` FOREIGN KEY (`insurance_company`) REFERENCES `insurance_companies` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `patient_cards_ibfk_8` FOREIGN KEY (`is_alive`) REFERENCES `alive_status` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `patient_cards_ibfk_9` FOREIGN KEY (`is_attached`) REFERENCES `attach_status` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_permission_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `streets_localities`
--
ALTER TABLE `streets_localities`
  ADD CONSTRAINT `streets_localities_ibfk_1` FOREIGN KEY (`locality_id`) REFERENCES `localities` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `streets_localities_ibfk_2` FOREIGN KEY (`street_id`) REFERENCES `streets` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`account`) REFERENCES `user_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
