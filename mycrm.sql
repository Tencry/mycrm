-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 6.0.189.1
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 07.08.2013 10:57:25
-- Версия сервера: 5.5.32
-- Версия клиента: 4.1

-- 
-- Отключение внешних ключей
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

-- 
-- Установка базы данных по умолчанию
--
USE mycrm;

--
-- Описание для таблицы groups
--
DROP TABLE IF EXISTS groups;
CREATE TABLE groups (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) DEFAULT NULL,
  seminar_id INT(11) DEFAULT NULL,
  descr TEXT DEFAULT NULL,
  date DATE DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 12
AVG_ROW_LENGTH = 1638
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы link_clients_groups
--
DROP TABLE IF EXISTS link_clients_groups;
CREATE TABLE link_clients_groups (
  clients_id INT(11) NOT NULL,
  groups_id INT(11) NOT NULL,
  PRIMARY KEY (clients_id, groups_id)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 963
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы link_clients_users
--
DROP TABLE IF EXISTS link_clients_users;
CREATE TABLE link_clients_users (
  clients_id INT(11) NOT NULL DEFAULT 0,
  users_id INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (users_id, clients_id)
)
ENGINE = MYISAM
AVG_ROW_LENGTH = 9
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы managers
--
DROP TABLE IF EXISTS managers;
CREATE TABLE managers (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) DEFAULT NULL,
  login VARCHAR(255) DEFAULT NULL,
  password VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 4
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы seminars
--
DROP TABLE IF EXISTS seminars;
CREATE TABLE seminars (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) DEFAULT NULL,
  descr VARCHAR(255) DEFAULT NULL,
  price DECIMAL(19, 2) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 7
AVG_ROW_LENGTH = 2730
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы sessions
--
DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) DEFAULT NULL,
  sid VARCHAR(255) DEFAULT NULL,
  time_start DATETIME DEFAULT NULL,
  time_last DATETIME DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 108
AVG_ROW_LENGTH = 8192
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы users
--
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) DEFAULT NULL,
  login VARCHAR(255) DEFAULT NULL,
  password VARCHAR(255) DEFAULT NULL,
  email VARCHAR(255) DEFAULT NULL,
  groups_id INT(11) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 35
AVG_ROW_LENGTH = 780
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы users_groups
--
DROP TABLE IF EXISTS users_groups;
CREATE TABLE users_groups (
  users_id INT(11) NOT NULL DEFAULT 0,
  groups_id INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (users_id, groups_id)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы clients
--
DROP TABLE IF EXISTS clients;
CREATE TABLE clients (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) DEFAULT NULL,
  users_id INT(11) DEFAULT NULL,
  orgs_id INT(11) DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX users_id (users_id),
  CONSTRAINT clients_ibfk_1 FOREIGN KEY (users_id)
    REFERENCES users(id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 14
AVG_ROW_LENGTH = 218
CHARACTER SET utf8
COLLATE utf8_general_ci;

-- 
-- Вывод данных для таблицы groups
--
INSERT INTO groups VALUES
(1, 'Группа №1', 3, '(ГП)', '2013-08-02'),
(2, 'Группа №2', 6, '', '2013-07-01'),
(3, 'Группа №3', 6, 'для начинающих', '2013-06-03'),
(4, 'Группа №4', 2, 'для гос органов', '2013-08-12'),
(5, 'Группа №5', 1, 'для гос. органов', '2013-02-25'),
(6, 'Группа №6', 5, '', '2013-08-28'),
(7, 'Группа №7', 4, 'для гос. органов', '2013-02-05'),
(8, 'Группа №8', 5, 'Алматы', '2013-08-19'),
(9, 'НН (Астана)', 4, 'Семинар по Налогам и налогообложению', '2013-05-06'),
(10, 'БУ (Павлодар)', 5, 'Бух. учет в соответствии с МСФО', '2013-10-14'),
(11, 'ГП (Костанай)', 3, 'Семинар по Гражданскому праву', '2013-08-19');

-- 
-- Вывод данных для таблицы link_clients_groups
--
INSERT INTO link_clients_groups VALUES
(5, 4),
(5, 8),
(6, 9),
(6, 11),
(7, 8),
(7, 10),
(8, 4),
(8, 5),
(9, 6),
(9, 7),
(9, 8),
(10, 3),
(10, 4),
(10, 10),
(11, 2),
(12, 2),
(13, 2);

-- 
-- Вывод данных для таблицы link_clients_users
--
INSERT INTO link_clients_users VALUES
(76, 2),
(5, 6),
(6, 19),
(105, 26),
(101, 27),
(106, 27),
(5, 28),
(15, 28),
(81, 28),
(115, 28),
(13, 32),
(81, 32),
(106, 32),
(107, 32),
(108, 32),
(112, 32),
(113, 32),
(114, 32),
(115, 32),
(5, 34),
(15, 34);

-- 
-- Вывод данных для таблицы managers
--
INSERT INTO managers VALUES
(1, 'Арман Сарсенов', 'arman', 'unreal88'),
(2, 'Павел Фоменко', 'pavel', 'q1w2e3r4t5y6'),
(3, 'Demo', 'demo', 'demo');

-- 
-- Вывод данных для таблицы seminars
--
INSERT INTO seminars VALUES
(1, 'МСФООС 48ч', '', 30000.00),
(2, 'МСФООС 80ч', '', 60000.00),
(3, 'Гражданское право', '', 40000.00),
(4, 'Налоги и налогообложение', '', 40000.00),
(5, 'Бух. учет в соответствии с МСФО', '', 60000.00),
(6, 'Тайм-менеджмент', '', 50000.00);

-- 
-- Вывод данных для таблицы sessions
--
INSERT INTO sessions VALUES
(69, 0, 'Mz30twqefW', '2013-01-21 06:41:28', '2013-01-21 06:57:45'),
(70, 1, '2U0PsdkCV2', '2013-01-21 06:57:45', '2013-01-21 07:12:04'),
(71, 1, 'Z2gtTI7JSM', '2013-08-07 06:02:35', '2013-08-07 06:02:35'),
(72, 1, 'z5MlV2Va3E', '2013-08-07 06:04:26', '2013-08-07 06:04:26'),
(73, 1, 'Pojdao4zBV', '2013-08-07 06:04:50', '2013-08-07 06:04:50'),
(74, 1, 'joOQy095gQ', '2013-08-07 06:05:23', '2013-08-07 06:05:23'),
(75, 1, 'i61xfUljfQ', '2013-08-07 06:06:45', '2013-08-07 06:06:45'),
(76, 1, 'IMfI6iLxxm', '2013-08-07 06:07:14', '2013-08-07 06:07:14'),
(77, 1, 'HeGz7Dy1Xz', '2013-08-07 06:10:50', '2013-08-07 06:10:50'),
(78, 1, 'Dkt0s8jyCA', '2013-08-07 06:11:01', '2013-08-07 06:11:01'),
(79, 1, 'u7qgaTRjXl', '2013-08-07 06:18:27', '2013-08-07 06:18:27'),
(80, 1, 'DZmML5MFxY', '2013-08-07 06:22:25', '2013-08-07 06:22:25'),
(81, 1, 'TeG0kQOUVF', '2013-08-07 06:24:52', '2013-08-07 06:24:52'),
(82, 1, 'xczxg2duQu', '2013-08-07 06:25:33', '2013-08-07 06:25:33'),
(83, 1, 'CfWExTV1Lv', '2013-08-07 06:27:53', '2013-08-07 06:27:53'),
(84, 1, 'OSrDeDb6D6', '2013-08-07 06:27:53', '2013-08-07 06:27:53'),
(85, 1, 'km0WQ5OUVW', '2013-08-07 06:29:37', '2013-08-07 06:29:37'),
(86, 1, 'XlA0Sv0Nbg', '2013-08-07 06:29:38', '2013-08-07 06:29:38'),
(87, 1, 'KSbGA8vfxy', '2013-08-07 06:29:39', '2013-08-07 06:29:39'),
(88, 1, 'EhHbO0AMv3', '2013-08-07 06:29:40', '2013-08-07 06:29:40'),
(89, 1, 'WtINA2bG5o', '2013-08-07 06:29:42', '2013-08-07 06:29:42'),
(90, 1, 'a4u6UaoqZT', '2013-08-07 06:29:43', '2013-08-07 06:29:43'),
(91, 1, 'iNaauszXnY', '2013-08-07 06:29:44', '2013-08-07 06:29:44'),
(92, 1, 'ZJxFep3jEt', '2013-08-07 06:29:45', '2013-08-07 06:29:45'),
(93, 1, 'Idmk2CvoAy', '2013-08-07 06:30:32', '2013-08-07 06:30:32'),
(94, 3, 'dMlSJh6FOL', '2013-08-07 06:32:52', '2013-08-07 06:32:52'),
(95, 3, 'RMvxIAIzTH', '2013-08-07 06:32:52', '2013-08-07 06:32:52'),
(96, 3, '9icPYpBESp', '2013-08-07 06:32:54', '2013-08-07 06:32:54'),
(97, 3, 'qY2BlY7qAn', '2013-08-07 06:32:58', '2013-08-07 06:32:58'),
(98, 3, 'Jx0G9YYOJ0', '2013-08-07 06:32:58', '2013-08-07 06:32:58'),
(99, 3, 'veJM6tRjQA', '2013-08-07 06:33:01', '2013-08-07 06:33:01'),
(100, 3, 'DoXr4qUz55', '2013-08-07 06:46:14', '2013-08-07 06:46:14'),
(101, 3, 'yPDmq3JVjA', '2013-08-07 06:52:04', '2013-08-07 06:52:04'),
(102, 3, 'IltpOIDajF', '2013-08-07 06:54:55', '2013-08-07 06:54:55'),
(103, 3, 'DaOSaEplDs', '2013-08-07 06:55:05', '2013-08-07 06:55:05'),
(104, 3, 'r2hsYYBnYe', '2013-08-07 06:55:18', '2013-08-07 06:55:18'),
(105, 3, 'b4j6OUQFo6', '2013-08-07 06:56:29', '2013-08-07 06:56:29'),
(106, 3, 'iqaoKBVO7E', '2013-08-07 06:56:52', '2013-08-07 06:56:52'),
(107, 3, 'ZbtwZ92ae1', '2013-08-07 06:57:04', '2013-08-07 06:57:04');

-- 
-- Вывод данных для таблицы users
--
INSERT INTO users VALUES
(1, 'admin1-2', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 2),
(2, 'uuu1', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', NULL, 9),
(3, 'asd123', 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', NULL, 4),
(4, 'Manager2', 'manager', '1d0258c2440a8d19e716292b231e3190', 'manager@mycrm.com', 5),
(5, 'Manager', 'manager', '1d0258c2440a8d19e716292b231e3190', 'manager@mycrm.com', 5),
(6, 'User2', 'user2', '7e58d63b60197ceb55a1c487989a3720', 'user2@mycrm.com', 2),
(7, 'User23435', 'user2343', NULL, NULL, 1),
(8, 'User221', 'user22', NULL, NULL, 5),
(9, 'User2', 'user1111', NULL, NULL, 5),
(10, 'User191', 'user22', NULL, NULL, 2),
(15, 'dffd12', 'fdfd', NULL, NULL, 10),
(16, 'User222', 'user2', NULL, NULL, 1),
(17, 'User2211', 'user2', NULL, NULL, 5),
(19, '123-', '321', NULL, NULL, 5),
(20, 'dffd-', 'fdfd1', NULL, NULL, 5),
(25, 'test1', 'test', NULL, NULL, 1),
(26, 'new22', 'new', NULL, NULL, 4),
(27, 'fgfg', 'fggf', NULL, NULL, 5),
(28, 'AAAAAAAAAA', 'pavel.fomenko', NULL, NULL, 5),
(32, 'ла', 'оа', NULL, NULL, 7),
(34, 'ЕЕЕ1-2', 'ЕЕЕЕ', NULL, NULL, 1);

-- 
-- Вывод данных для таблицы users_groups
--
INSERT INTO users_groups VALUES
(1, 1),
(1, 2),
(1, 3);

-- 
-- Вывод данных для таблицы clients
--
INSERT INTO clients VALUES
(5, 'Жанна Кальман', 2, 0),
(6, 'Сара Кнаусс', 2, NULL),
(7, 'Люси Ханна', 4, NULL),
(8, 'Мария Луиза Мейлер', 4, NULL),
(9, 'Мария Эстер де Каповилья', 2, NULL),
(10, 'Танэ Икаи', 9, NULL),
(11, 'Элизабет Болден', 6, NULL),
(12, 'Бесси Купер', 2, NULL),
(13, 'Дзироэмон Кимура', 3, NULL);

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;