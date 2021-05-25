-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 19 2021 г., 23:21
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `chat`
--

-- --------------------------------------------------------

--
-- Структура таблицы `chats`
--

CREATE TABLE `chats` (
  `id` int NOT NULL,
  `title` text NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `chats`
--

INSERT INTO `chats` (`id`, `title`, `link`) VALUES
(1, 'Test Chat', '@testchat'),
(2, 'Test Chat 2', '@testchat2');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `userlink` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` text NOT NULL,
  `text` text NOT NULL,
  `time` text NOT NULL,
  `chatlink` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `userlink`, `username`, `text`, `time`, `chatlink`) VALUES
(1, '@admin', 'Admin', 'Test Message', '00:00 02.05.2021', '@testchat'),
(2, '@test', 'TestUser', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec quam a mi vulputate venenatis vel et enim. Nullam vitae est sodales augue eleifend feugiat. Nulla facilisi. Etiam ut quam ullamcorper, consectetur nulla ut, suscipit nisi. Duis sed turpis auctor, consectetur tortor dictum, ultrices enim. Quisque dui lorem, auctor a dapibus in, imperdiet id lacus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras elementum condimentum tristique. Nunc suscipit metus a iaculis hendrerit. Nam vitae justo nec risus facilisis interdum. Sed commodo magna eu fermentum egestas. Quisque blandit massa lorem, et sodales dolor egestas vel. Morbi accumsan, turpis ut vestibulum porta, velit libero laoreet dolor, laoreet hendrerit diam massa sed dolor.\r\n\r\nNunc ut odio egestas, interdum ante quis, mattis nisl. Etiam eget erat dolor. In ac gravida metus, non blandit erat. Suspendisse vitae facilisis augue. Nam eleifend ex vitae libero imperdiet, a facilisis purus ultrices. Sed non sodales tellus. Vestibulum vitae vulputate leo. Vivamus porta facilisis libero, vel vulputate neque lacinia vitae. Vestibulum in leo neque.\r\n\r\nMaecenas bibendum dolor at gravida vestibulum. Vestibulum aliquam lacus sed erat fringilla tempor in eget erat. Quisque finibus facilisis accumsan. Pellentesque nec suscipit neque. Donec mattis finibus diam, quis pharetra lectus bibendum sit amet. Proin ornare dapibus mi sed dictum. Pellentesque auctor arcu et facilisis hendrerit. Nam non justo non sapien viverra tincidunt. Nullam feugiat suscipit nulla, quis dictum ante tristique id. Nam accumsan iaculis vestibulum. Aliquam nec erat ultricies augue vestibulum viverra a sed nibh. Mauris non elit dignissim, imperdiet magna vitae, pulvinar dolor. Aliquam massa magna, placerat eleifend ante eu, vehicula blandit leo. In hac habitasse platea dictumst.\r\n\r\nMauris dapibus, mi ac tristique lacinia, lectus velit dignissim dolor, sed viverra dui augue a odio. Nunc id venenatis est, vel congue libero. Integer at nulla enim. Vestibulum aliquam metus non ultricies hendrerit. Quisque laoreet cursus arcu maximus efficitur. Nunc risus quam, euismod ac tellus eu, lobortis tincidunt nulla. Cras finibus dolor eget laoreet dictum. Sed a malesuada dui. Maecenas pulvinar dolor leo, sit amet efficitur nisi convallis ac. Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n\r\nAliquam condimentum augue dapibus, malesuada sem tempor, accumsan erat. Proin nisl eros, commodo eu orci tempus, blandit gravida mi. Sed at libero fringilla, tempor nibh ut, varius nunc. Ut ornare orci a commodo pretium. Nulla facilisi. Nunc ut nibh ac magna venenatis efficitur. Nunc sit amet viverra sapien, eget tempus sapien. Proin sed sem sagittis, tristique arcu sit amet, finibus nibh.', '17:02 05.05.2021', '@testchat'),
(4, '@test', 'TestUser', 'Сообщение для тестового чата 2', '20:41 15.05.2021', '@testchat2'),
(5, '@test', 'TestUser', 'И ещё одно, на всякий случай', '19:29 19.05.2021', '@testchat2'),
(6, '@admin', 'Admin', 'Aboba', '21:47 19.05.2021', '@testchat'),
(7, '@test', 'TestUser', 'Aboba', '21:47 19.05.2021', '@testchat'),
(8, '@admin', 'Admin', 'No U R Aboba', '21:47 19.05.2021', '@testchat'),
(9, '@test', 'TestUser', 'Nonono, U', '21:49 19.05.2021', '@testchat');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `password` text NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `link`, `password`, `status`) VALUES
(1, 'Admin', '@admin', 'admin', 0),
(2, 'TestUser', '@test', 'test', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_chats`
--

CREATE TABLE `user_chats` (
  `user_id` text NOT NULL,
  `chat_link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user_chats`
--

INSERT INTO `user_chats` (`user_id`, `chat_link`) VALUES
('1', '@testchat'),
('2', '@testchat'),
('2', '@testchat2'),
('1', '@testchat2');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
