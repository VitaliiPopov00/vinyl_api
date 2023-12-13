-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 13 2023 г., 10:40
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vinyl`
--

-- --------------------------------------------------------

--
-- Структура таблицы `album`
--

CREATE TABLE `album` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `artist_id` int(10) UNSIGNED NOT NULL,
  `year_release_album` int(11) NOT NULL,
  `year_release_plate` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `album`
--

INSERT INTO `album` (`id`, `title`, `artist_id`, `year_release_album`, `year_release_plate`, `price`, `logo`) VALUES
(1, '30', 1, 2021, 2023, 3500, 'img/vinyl/adele_30.png'),
(2, 'Beyonce', 2, 2013, 2013, 5000, 'img/vinyl/beyonce_beyonce.png'),
(3, 'Unorthodox Jukebox', 3, 2012, 2013, 1500, 'img/vinyl/brunomars_unorthodoxjukebox.png'),
(4, 'Parachutes', 4, 2000, 2005, 2000, 'img/vinyl/coldplay_parachutes.png'),
(5, 'Views', 5, 2016, 2016, 10000, 'img/vinyl/drake_views.png'),
(6, 'Autumn Variations', 6, 2023, 2023, 1000, 'img/vinyl/edsheeran_autumnvariations.png'),
(7, 'Kamikaze', 7, 2018, 2023, 1500, 'img/vinyl/eminem_kamikaze.png'),
(8, 'The Blueprint', 8, 2001, 2001, 3500, 'img/vinyl/jay-z_theblueprint.png'),
(9, 'Changes', 9, 2020, 2020, 3500, 'img/vinyl/justinbieber_changes.png'),
(10, 'Ye', 10, 2018, 2020, 10000, 'img/vinyl/kanyewest_ye.png'),
(11, 'Smile', 11, 2020, 2020, 8000, 'img/vinyl/katyperry_smile.png'),
(12, 'Joanne', 12, 2016, 2016, 6000, 'img/vinyl/ladygaga_joanne.png'),
(13, 'Madonna', 13, 1983, 2000, 5500, 'img/vinyl/madonna_madonna.png'),
(14, 'V', 14, 2014, 2014, 3000, 'img/vinyl/maroon5_v.png'),
(15, 'Ben', 15, 1972, 1972, 30000, 'img/vinyl/michaeljackson_ben.png'),
(16, 'Anti', 16, 2016, 2016, 2500, 'img/vinyl/rihanna_anti.png'),
(17, 'The Thrill of It All', 17, 2017, 2019, 2500, 'img/vinyl/samsmith_thethrillofitall.png'),
(18, 'Animals', 18, 1977, 1977, 50000, 'img/vinyl/pinkfloyd_animals.png'),
(19, 'Red', 19, 2012, 2015, 50000, 'img/vinyl/taylorswift_red.png'),
(20, 'Abbey Road', 20, 1969, 2018, 15000, 'img/vinyl/thebeatles_abbeyroad.jpg'),
(21, 'Starboy', 21, 2016, 2020, 2500, 'img/vinyl/theweeknd_starboy.png'),
(22, 'Nevermind', 22, 1991, 1992, 1000, 'img/vinyl/nirvana_nevermind.png'),
(23, 'Positions', 23, 2020, 2020, 5500, 'img/vinyl/arianagrande_positions.png'),
(24, 'Happier Than Ever', 24, 2021, 2021, 1000, 'img/vinyl/billieeilish_happierthanever.png'),
(25, 'Blue Moves', 25, 1976, 1990, 9000, 'img/vinyl/eltonjohn_bluemoves.png'),
(26, 'Endless Summer Vacation', 26, 2023, 2023, 9000, 'img/vinyl/mileycyrus_endlesssummervacation.png'),
(27, 'Stoney', 27, 2016, 2020, 2500, 'img/vinyl/postmalone_stoney.png'),
(28, 'Jazz', 28, 1978, 1990, 50000, 'img/vinyl/queen_jazz.png'),
(29, 'This Is Acting', 29, 2016, 2016, 10000, 'img/vinyl/sia_thisisacting.png'),
(30, 'Iowa', 30, 2001, 2002, 15000, 'img/vinyl/slipknot_iowa.png'),
(31, 'Immortalized', 31, 2015, 2017, 15000, 'img/vinyl/disturbed_immortalized.png');

-- --------------------------------------------------------

--
-- Структура таблицы `album_genre`
--

CREATE TABLE `album_genre` (
  `album_id` int(10) UNSIGNED NOT NULL,
  `genre_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `album_genre`
--

INSERT INTO `album_genre` (`album_id`, `genre_id`) VALUES
(1, 17),
(1, 10),
(1, 13),
(2, 14),
(3, 14),
(3, 13),
(3, 16),
(4, 16),
(5, 8),
(5, 14),
(5, 5),
(6, 7),
(7, 8),
(8, 8),
(9, 13),
(9, 14),
(9, 32),
(10, 8),
(11, 13),
(12, 5),
(12, 16),
(13, 5),
(13, 20),
(14, 13),
(14, 16),
(14, 6),
(15, 13),
(15, 14),
(16, 13),
(16, 14),
(16, 5),
(17, 17),
(17, 13),
(18, 16),
(19, 13),
(19, 16),
(20, 16),
(21, 14),
(21, 13),
(22, 16),
(22, 24),
(22, 27),
(23, 14),
(23, 13),
(23, 32),
(24, 6),
(24, 10),
(24, 13),
(25, 16),
(25, 13),
(26, 13),
(26, 5),
(27, 8),
(28, 16),
(28, 28),
(28, 13),
(29, 13),
(30, 15),
(31, 15),
(31, 28),
(31, 27);

-- --------------------------------------------------------

--
-- Структура таблицы `artist`
--

CREATE TABLE `artist` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `artist`
--

INSERT INTO `artist` (`id`, `title`) VALUES
(1, 'Adele'),
(2, 'Beyoncé'),
(3, 'Bruno Mars'),
(4, 'Coldplay'),
(5, 'Drake'),
(6, 'Ed Sheeran'),
(7, 'Eminem'),
(8, 'JAY-Z'),
(9, 'Justin Bieber'),
(10, 'Kanye West'),
(11, 'Katy Perry'),
(12, 'Lady Gaga'),
(13, 'Madonna'),
(14, 'Maroon 5'),
(15, 'Michael Jackson'),
(16, 'Rihanna'),
(17, 'Sam Smith'),
(18, 'Pink Floyd'),
(19, 'Taylor Swift'),
(20, 'The Beatles'),
(21, 'The Weeknd'),
(22, 'Nirvana'),
(23, 'Ariana Grande'),
(24, 'Billie Eilish'),
(25, 'Elton John'),
(26, 'Miley Cyrus'),
(27, 'Post Malone'),
(28, 'Queen'),
(29, 'Sia'),
(30, 'Slipknot'),
(31, 'Disturbed');

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

CREATE TABLE `genre` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id`, `title`) VALUES
(1, 'Alternative'),
(2, 'Blues'),
(3, 'Classical'),
(5, 'Dance'),
(6, 'Electronic'),
(7, 'Folk'),
(8, 'Hip Hop'),
(9, 'Indie'),
(10, 'Jazz'),
(12, 'Metal'),
(13, 'Pop'),
(14, 'R&B'),
(15, 'Nu-Metal'),
(16, 'Rock'),
(17, 'Soul'),
(20, 'Disco'),
(24, 'Punk'),
(27, 'Hard rock'),
(28, 'Heavy metal'),
(31, 'Rap'),
(32, 'Trap'),
(33, 'Dubstep'),
(34, 'Drum and bass'),
(35, 'Salsa'),
(36, 'Rapcore'),
(40, 'Instrumental'),
(41, 'Ambient'),
(49, 'House'),
(50, 'Techno');

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `order_status`
--

CREATE TABLE `order_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `order_status`
--

INSERT INTO `order_status` (`id`, `title`) VALUES
(1, 'Принят в работу'),
(2, 'Доставляется'),
(3, 'Выполнен');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `title`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `email`, `created_at`, `updated_at`, `token`, `role_id`) VALUES
(3, 'vpopov', '$2y$13$YfeGEhJ8mhbCZ1JjHYju7e5ONSyDFRvW31Gi9wb8ckGjri0uqOpa6', 'vpopov@gmail.com', '2023-12-12 14:12:34', '2023-12-13 07:34:28', NULL, 1),
(4, 'vpopov1', '$2y$13$w0QeIFp.zi0sw0Ay7Mzoz./1WSBnglGlVrXJCfEjdvZxP6XeB7yCS', 'vpopov1@gmail.com', '2023-12-13 06:16:27', '2023-12-13 06:16:27', NULL, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- Индексы таблицы `album_genre`
--
ALTER TABLE `album_genre`
  ADD KEY `album_id` (`album_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Индексы таблицы `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Индексы таблицы `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `album`
--
ALTER TABLE `album`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `artist`
--
ALTER TABLE `artist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`);

--
-- Ограничения внешнего ключа таблицы `album_genre`
--
ALTER TABLE `album_genre`
  ADD CONSTRAINT `album_genre_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`),
  ADD CONSTRAINT `album_genre_ibfk_2` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`);

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `order_status` (`id`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
