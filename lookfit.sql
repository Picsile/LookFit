-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.4
-- Время создания: Фев 26 2026 г., 17:04
-- Версия сервера: 8.4.4
-- Версия PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lookfit`
--

-- --------------------------------------------------------

--
-- Структура таблицы `board`
--

CREATE TABLE `board` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `visibility_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `board_post`
--

CREATE TABLE `board_post` (
  `board_id` int UNSIGNED NOT NULL,
  `post_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int UNSIGNED NOT NULL,
  `parent_id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int UNSIGNED NOT NULL,
  `post_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `generation`
--

CREATE TABLE `generation` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `prompt` text NOT NULL,
  `resolution_id` int UNSIGNED NOT NULL,
  `ratio_id` int UNSIGNED NOT NULL,
  `created_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `generation_image`
--

CREATE TABLE `generation_image` (
  `generation_id` int UNSIGNED NOT NULL,
  `image_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `generation_item`
--

CREATE TABLE `generation_item` (
  `generation_id` int UNSIGNED NOT NULL,
  `post_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `image`
--

CREATE TABLE `image` (
  `id` int UNSIGNED NOT NULL,
  `path` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `item_link`
--

CREATE TABLE `item_link` (
  `post_id` int UNSIGNED NOT NULL,
  `link_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `like`
--

CREATE TABLE `like` (
  `user_id` int UNSIGNED NOT NULL,
  `post_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `link`
--

CREATE TABLE `link` (
  `id` int UNSIGNED NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1769697330);

-- --------------------------------------------------------

--
-- Структура таблицы `outfit_item`
--

CREATE TABLE `outfit_item` (
  `outfit_id` int UNSIGNED NOT NULL,
  `item_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE `post` (
  `id` int UNSIGNED NOT NULL,
  `type_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `post_status_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `post_category`
--

CREATE TABLE `post_category` (
  `post_id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `post_image`
--

CREATE TABLE `post_image` (
  `post_id` int UNSIGNED NOT NULL,
  `image_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `post_status`
--

CREATE TABLE `post_status` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `post_tag`
--

CREATE TABLE `post_tag` (
  `post_id` int UNSIGNED NOT NULL,
  `tag_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `post_type`
--

CREATE TABLE `post_type` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `ratio`
--

CREATE TABLE `ratio` (
  `id` int UNSIGNED NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `resolution`
--

CREATE TABLE `resolution` (
  `id` int UNSIGNED NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `title`) VALUES
(1, 'Account'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Структура таблицы `tag`
--

CREATE TABLE `tag` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `background_path` varchar(255) DEFAULT NULL,
  `role_id` int UNSIGNED NOT NULL DEFAULT '1',
  `auth_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `login`, `password`, `email`, `phone`, `avatar_path`, `background_path`, `role_id`, `auth_key`) VALUES
(7, 'Picsile', 'Picsile', '$2y$13$3IDyttjFCdoN1IipUo/rZuRaSb6TS2bQQl281G7lE1soaX68or4T2', 'picsile23@gmail.com', NULL, NULL, NULL, 1, 'qB98dnhfa70VTevK_Gke0jJ-kcxnu3GM'),
(8, 'q', 'q', '$2y$13$ZKmXLeNwYEHePvYW7YWtqelwV9DRJceBhkz9AxS3oe.34vZNIvn.q', 'q@q.com', NULL, NULL, NULL, 1, '_MRlqDsHnF92waXDOqViFgYmHc2qN5gw');

-- --------------------------------------------------------

--
-- Структура таблицы `wardrobe`
--

CREATE TABLE `wardrobe` (
  `user_id` int UNSIGNED NOT NULL,
  `post_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`id`),
  ADD KEY `board_ibfk_1` (`user_id`),
  ADD KEY `board_ibfk_2` (`visibility_id`);

--
-- Индексы таблицы `board_post`
--
ALTER TABLE `board_post`
  ADD PRIMARY KEY (`board_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Индексы таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `generation`
--
ALTER TABLE `generation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `generation_ibfk_2` (`ratio_id`),
  ADD KEY `generation_ibfk_3` (`resolution_id`);

--
-- Индексы таблицы `generation_image`
--
ALTER TABLE `generation_image`
  ADD PRIMARY KEY (`generation_id`,`image_id`),
  ADD KEY `generation_image_ibfk_2` (`image_id`);

--
-- Индексы таблицы `generation_item`
--
ALTER TABLE `generation_item`
  ADD PRIMARY KEY (`generation_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `item_link`
--
ALTER TABLE `item_link`
  ADD PRIMARY KEY (`post_id`,`link_id`),
  ADD KEY `link_id` (`link_id`);

--
-- Индексы таблицы `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `link`
--
ALTER TABLE `link`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `outfit_item`
--
ALTER TABLE `outfit_item`
  ADD PRIMARY KEY (`outfit_id`,`item_id`),
  ADD KEY `outfit_item_ibfk_1` (`item_id`);

--
-- Индексы таблицы `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `visibility_id` (`post_status_id`);

--
-- Индексы таблицы `post_category`
--
ALTER TABLE `post_category`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `post_image`
--
ALTER TABLE `post_image`
  ADD PRIMARY KEY (`post_id`,`image_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Индексы таблицы `post_status`
--
ALTER TABLE `post_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `post_tag_ibfk_2` (`tag_id`);

--
-- Индексы таблицы `post_type`
--
ALTER TABLE `post_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ratio`
--
ALTER TABLE `ratio`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `resolution`
--
ALTER TABLE `resolution`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login_2` (`login`,`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Индексы таблицы `wardrobe`
--
ALTER TABLE `wardrobe`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `board`
--
ALTER TABLE `board`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `generation`
--
ALTER TABLE `generation`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `image`
--
ALTER TABLE `image`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `link`
--
ALTER TABLE `link`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `post`
--
ALTER TABLE `post`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `post_status`
--
ALTER TABLE `post_status`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `post_type`
--
ALTER TABLE `post_type`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ratio`
--
ALTER TABLE `ratio`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `resolution`
--
ALTER TABLE `resolution`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `board`
--
ALTER TABLE `board`
  ADD CONSTRAINT `board_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `board_ibfk_2` FOREIGN KEY (`visibility_id`) REFERENCES `post_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `board_post`
--
ALTER TABLE `board_post`
  ADD CONSTRAINT `board_post_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `board_post_ibfk_2` FOREIGN KEY (`board_id`) REFERENCES `board` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `generation`
--
ALTER TABLE `generation`
  ADD CONSTRAINT `generation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `generation_ibfk_2` FOREIGN KEY (`ratio_id`) REFERENCES `ratio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `generation_ibfk_3` FOREIGN KEY (`resolution_id`) REFERENCES `resolution` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `generation_image`
--
ALTER TABLE `generation_image`
  ADD CONSTRAINT `generation_image_ibfk_1` FOREIGN KEY (`generation_id`) REFERENCES `generation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `generation_image_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `generation_item`
--
ALTER TABLE `generation_item`
  ADD CONSTRAINT `generation_item_ibfk_1` FOREIGN KEY (`generation_id`) REFERENCES `generation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `generation_item_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `item_link`
--
ALTER TABLE `item_link`
  ADD CONSTRAINT `item_link_ibfk_1` FOREIGN KEY (`link_id`) REFERENCES `link` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_link_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `outfit_item`
--
ALTER TABLE `outfit_item`
  ADD CONSTRAINT `outfit_item_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `outfit_item_ibfk_2` FOREIGN KEY (`outfit_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `post_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_3` FOREIGN KEY (`post_status_id`) REFERENCES `post_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post_category`
--
ALTER TABLE `post_category`
  ADD CONSTRAINT `post_category_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post_image`
--
ALTER TABLE `post_image`
  ADD CONSTRAINT `post_image_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_image_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `wardrobe`
--
ALTER TABLE `wardrobe`
  ADD CONSTRAINT `wardrobe_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wardrobe_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
