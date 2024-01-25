-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-01-2024 a las 21:28:05
-- Versión del servidor: 10.6.16-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u972166336_main`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `idComment` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `idGame` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(200) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`idComment`, `idUser`, `idGame`, `text`, `type`) VALUES
(17, 2, 51, 'Estoy muy emocionada por presentaros este juego, espero que os guste', 'feedback'),
(18, 4, 54, 'Esto es lo que la comunidad necesitaba', 'feedback'),
(19, 5, 51, '¡Que juegazo Celia, muy bien hecho!', 'feedback'),
(20, 5, 52, 'Wow, impresionante videojuego', 'feedback'),
(21, 5, 56, 'Cuánta nostalgia en un solo fangame', 'feedback'),
(22, 4, 52, 'Me encantan las animaciones', 'feedback'),
(23, 4, 57, 'Me encanta el estilo que le has dado a este juego, aunque hay que solucionar algunos bugs', 'feedback'),
(24, 4, 58, 'La mayor aberración que he jugado nunca. Lleno de bugs y una tasa de refresco nefasta', 'feedback'),
(27, 1, 55, 'No entiedo cómo semejante joya puede ser gratis', 'feedback'),
(29, 13, 52, 'wtf, en plan oh my god', 'feedback');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `follows`
--

CREATE TABLE `follows` (
  `userFollows_id` bigint(20) UNSIGNED NOT NULL,
  `userFollowed_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `follows`
--

INSERT INTO `follows` (`userFollows_id`, `userFollowed_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(1, 5),
(1, 6),
(1, 13),
(2, 1),
(4, 1),
(4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `games`
--

CREATE TABLE `games` (
  `idGame` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `downloadLink` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `installInstructions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `games`
--

INSERT INTO `games` (`idGame`, `idUser`, `name`, `downloadLink`, `thumbnail`, `description`, `installInstructions`) VALUES
(51, 2, 'sonic 5', 'games/sonic 56577c5e564003.zip', 'game-thumbnails/sonic 56577c60cabf5c.avif', 'Un juego fan de sonic hecho con unos colegas', '<ol><li>Descomprime el archivo .zip</li><li>Ejecuta el archivo sonic 5.exe</li></ol>'),
(52, 1, 'Juego de adivinar cartas de pokemon', 'games/Juego de adivinar cartas de pokemon6577c8886fa56.zip', 'game-thumbnails/Juego de adivinar cartas de pokemon6577c88870d7f.webp', 'Un juego que consiste en levantar cartas y adivinar las parejas y con temática de Pokemon', '<ol><li>Extraer el archivo .zip</li><li>Entrar en la carpeta resultante de la extracción</li><li>Hacer click en index.html</li></ol>'),
(53, 1, 'Super Mariano', 'games/Super Mariano6578f6570a7d7.zip', 'game-thumbnails/Super Mariano6578f656f0fd4.jpeg', 'Un juego fan de Super Mario.', '<ol><li>Descomprime el archivo .zip</li><li>Ejecuta el archivo .exe</li></ol>'),
(54, 5, 'Pou 2.0', 'games/Pou 2.06578f7abb6bd9.zip', 'game-thumbnails/Pou 2.06578f7aba860f.webp', 'Una versión mejorada del clásico pou', '<ol><li>Descomprimir el .zip</li><li>Ejecutar el archivo .apk</li></ol>'),
(55, 4, 'Atalo\'s adventure', 'games/Atalo\'s adventure6579dd6fa19d2.zip', 'game-thumbnails/Atalo\'s adventure6579dd6f92de7.jpg', 'Un videojuego basado en hechos reales. Un chaval que estudia robótica deberá ir en busca de su amiga Silvana y salvarla de un malvado monstruo', '<ol><li>Descomprimir el .zip</li><li>Ejecutar el archivo .exe</li></ol>'),
(56, 4, 'Los guardianes del sol', 'games/Los guardianes del sol6579e031ebef7.zip', 'game-thumbnails/Los guardianes del sol6579e353490de.webp', 'Una recreación del mítico videojuego de la serie \"Hora de aventuras\"', '<ol><li>Descomprime el archivo .zip</li><li>Ejecutar el archivo .exe</li></ol>'),
(57, 1, 'Ratchet & Clank Java', 'games/Ratchet & Clank Java6579e9ed4d771.zip', 'game-thumbnails/Ratchet & Clank Java6579e9ed45b1b.png', 'Un juego fan de Ratchet & Clank al estilo de los móviles antiguos', '<ol><li>Descomprime el archivo .zip</li><li>Ejecuta el archivo .apk</li></ol>'),
(58, 5, 'Flying Gorilla pc version', 'games/Flying Gorilla pc version6579f0d4c1fc1.zip', 'game-thumbnails/Flying Gorilla pc version6579f0d4b4ae7.png', 'El mítico Flying Gorilla de Android, ahora para pc', '<ol><li>Descomprime el archivo .zip</li><li>Ejecuta el archivo .exe</li></ol>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `game_versions`
--

CREATE TABLE `game_versions` (
  `idVersion` bigint(20) UNSIGNED NOT NULL,
  `idGame` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `game_versions`
--

INSERT INTO `game_versions` (`idVersion`, `idGame`, `version`, `content`) VALUES
(35, 51, '1.0.0', 'No se han especificado detalles'),
(36, 52, '1.0.0', 'No se han especificado detalles'),
(37, 53, '1.0.0', 'No se han especificado detalles'),
(38, 54, '1.0.0', 'No se han especificado detalles'),
(39, 55, '1.0.0', 'No se han especificado detalles'),
(40, 56, '1.0.0', '<ol><li>Lanzamiento del videojuego</li></ol>'),
(41, 57, '1.0.0', 'No se han especificado detalles'),
(42, 58, '0.5.0', '<ol><li>se han corregido 50 de 1000 errores reportados</li></ol>'),
(43, 58, '1.0.0', '<ol><li>Lanzamiento del juego</li><li>Se han corregido 750 bugs de los 950 que habían en la versión anterior</li></ol>'),
(48, 52, '1.1.0', '<ol><li>Se han añadido nuevas cartas</li><li>Corrección de fallos</li></ol>'),
(49, 53, '2.0.0', '<ol><li>Nuevos niveles</li><li>Nueva música</li><li>Nuevos enemigos</li><li>Corrección de fallos</li><li>Introducción de mecánicas</li></ol>'),
(50, 51, '1.2.3', '<ol><li>Corección de bugs</li><li>Nuevos niveles</li><li>Nuevo personaje jugable</li></ol>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `userId` bigint(20) UNSIGNED NOT NULL,
  `idGame` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`userId`, `idGame`) VALUES
(1, 51),
(1, 52),
(2, 51),
(4, 54),
(4, 56);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_11_25_102644_follows', 1),
(6, '2023_11_29_224823_game', 1),
(7, '2023_11_29_224849_likes', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `bannedAccount` timestamp NULL DEFAULT NULL,
  `followers` int(11) DEFAULT NULL,
  `follows` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `profile_image`, `email_verified_at`, `password`, `admin`, `bannedAccount`, `followers`, `follows`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'pablo', 'pmarmor', 'pablo@gmail.com', 'user-avatars/pablo657a06aaa40c1.avif', NULL, '$2y$12$DuXid4PuJngRKPKK72B7H.hzHXQQZdVuGzN6oPuFRvu7IjDDS/Gwy', 2, NULL, 0, 0, 'crkJO3L9FjsjCrv95v8BQvoTeqxQK1KOaDAuf6rZ8GLNpeUGLEw982CdjSaD', '2023-12-08 15:57:32', '2023-12-13 18:31:54'),
(2, 'celia', 'laceli', 'celi@mail.com', 'user-avatars/celia657633d5aedd1.avif', NULL, '$2y$12$Vyw.8160sWB2JoS.UoSBlu5Psa8Gx1677LqjIaR1aflX/ZBDRKW0y', 1, NULL, 0, 0, 'a6ZRVLO5ZyejzcToTz2cUPvD8yP6D8HhH6uaOGicQLp0wK9eOwAkuCjT3B0R', '2023-12-08 16:37:02', '2023-12-19 17:11:51'),
(4, 'ricardo', 'richi', 'richi@mail.com', 'user-avatars/ricardo6578f0126356e.avif', NULL, '$2y$12$XebeKaXvdLUYh2NebasUHOWKkhJsQ7HfwmTXJfllcMHMntSGfOUSC', 0, '2023-12-24 20:14:00', 0, 0, NULL, '2023-12-12 22:42:55', '2023-12-13 19:14:13'),
(5, 'Martina', 'martina01', 'martina@mail.com', 'user-avatars/Martina6578f74cf3d3c.png', NULL, '$2y$12$6Zo7ByBGN59K.aL5Gw3raOzNKdDnDF0eITxlOHRWimoRxv29t1fGi', 0, NULL, 0, 0, NULL, '2023-12-12 23:11:25', '2023-12-12 23:14:05'),
(6, 'roberto', 'robert', 'robert@gmail.com', 'user-avatars/default-avatar.jpg', NULL, '$2y$12$C6VtGU4CbMILVH.JWfZ.o.BbcPg6RXdaRhEHGuvqc59fGtcavdIxa', 0, NULL, 0, 0, NULL, '2023-12-13 16:34:47', '2023-12-13 16:34:47'),
(13, 'Pedro', 'pedrojz98', 'pedrojz98@gmail.com', 'user-avatars/Pedro65805e4017844.png', NULL, '$2y$12$uGClpZRPvXnJ7UsPZTCuFuJzAOYAx.Ii690n5cdgIv66.uMHM.a.S', 0, NULL, 0, 0, NULL, '2023-12-18 14:57:48', '2023-12-18 14:59:12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`idComment`),
  ADD KEY `idGame` (`idGame`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `follows`
--
ALTER TABLE `follows`
  ADD UNIQUE KEY `noRepeat` (`userFollows_id`,`userFollowed_id`),
  ADD KEY `follows_userfollowed_id_foreign` (`userFollowed_id`);

--
-- Indices de la tabla `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`idGame`),
  ADD KEY `games_iduser_foreign` (`idUser`);

--
-- Indices de la tabla `game_versions`
--
ALTER TABLE `game_versions`
  ADD PRIMARY KEY (`idVersion`),
  ADD KEY `idGame` (`idGame`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD UNIQUE KEY `noRepeat` (`userId`,`idGame`),
  ADD KEY `likes_idgame_foreign` (`idGame`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `idComment` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `games`
--
ALTER TABLE `games`
  MODIFY `idGame` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `game_versions`
--
ALTER TABLE `game_versions`
  MODIFY `idVersion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`idGame`) REFERENCES `games` (`idGame`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_userfollowed_id_foreign` FOREIGN KEY (`userFollowed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_userfollows_id_foreign` FOREIGN KEY (`userFollows_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_iduser_foreign` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `game_versions`
--
ALTER TABLE `game_versions`
  ADD CONSTRAINT `game_versions_ibfk_1` FOREIGN KEY (`idGame`) REFERENCES `games` (`idGame`) ON DELETE CASCADE;

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_idgame_foreign` FOREIGN KEY (`idGame`) REFERENCES `games` (`idGame`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
