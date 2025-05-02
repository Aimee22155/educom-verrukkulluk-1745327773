-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 02 mei 2025 om 10:37
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verrukkulluk`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `packaging` varchar(100) DEFAULT NULL,
  `calories` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `article`
--

INSERT INTO `article` (`id`, `name`, `description`, `unit`, `price`, `packaging`, `calories`) VALUES
(1, 'Spaghetti', 'Dried pasta', 'gram', 1.99, '500', 710),
(2, 'Tomato sauce', 'Tomato sauce for pasta', 'ml', 2.49, '500', 100),
(3, 'Vegetarian minced meat', 'Plant-based minced meat', 'gram', 3.99, '250', 250),
(4, 'Onion', 'Yellow onion', 'piece', 3.25, '6', 40),
(5, 'Garlic', 'Clove of garlic', 'piece', 2.10, '6', 4),
(6, 'Herb mix', 'Italian herbs', 'teaspoon', 0.05, '50', 150),
(7, 'Nacho chips', 'Tortilla chips', 'bag', 1.49, '200', 1000),
(8, 'Minced meat', 'Beef minced meat', 'gram', 2.99, '250', 250),
(9, 'Cheese', 'Grated cheese', 'gram', 1.59, '150', 600),
(10, 'Lasagna sheets', 'Pasta for lasagna', 'gram', 1.49, '250', 850),
(11, 'Bechamel sauce', 'White sauce', 'ml', 1.89, '200', 200),
(12, 'Bread', 'Whole wheat sandwich', 'slice', 4.20, '10', 80),
(13, 'Chocolate sprinkles', 'Dark chocolate sprinkles', 'gram', 2.50, '200', 1040),
(14, 'Butter', 'Plant-based margarine', 'gram', 3.30, '250', 180);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dishes`
--

CREATE TABLE `dishes` (
  `id` int(11) NOT NULL,
  `kitchen_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `short_description` text DEFAULT NULL,
  `long_description` text DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `dishes`
--

INSERT INTO `dishes` (`id`, `kitchen_id`, `type_id`, `user_id`, `date_added`, `title`, `short_description`, `long_description`, `image`) VALUES
(1, 1, 4, 1, '2025-05-01 14:47:44', 'Spaghetti Bolognese', 'Vegetarian Italian pasta with minced sauce.', 'Rich tomato sauce with vegetarian minced meat, onion, garlic, and herbs. Served with spaghetti.', 'spaghetti.jpg'),
(2, 2, 5, 2, '2025-05-01 14:47:44', 'Nachos', 'Mexican oven dish with minced meat and cheese.', 'Crispy nacho chips with seasoned minced meat, cheese, jalapeño, and fresh guacamole.', 'nacho.jpg'),
(3, 1, 5, 3, '2025-05-01 14:47:44', 'Lasagna', 'Layers of pasta with sauce and cheese.', 'Layers of pasta, bolognese sauce, and bechamel sauce with melted cheese on top.', 'lasagna.jpg'),
(4, 3, 6, 2, '2025-05-01 14:47:44', 'Sandwich with chocolate sprinkles', 'Sandwich with dark chocolate sprinkles.', 'Whole wheat sandwich with plant-based butter and dark chocolate sprinkles.', 'sandwich.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dish_info`
--

CREATE TABLE `dish_info` (
  `id` int(11) NOT NULL,
  `record_type` enum('C','P','R','F') NOT NULL,
  `dish_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `numberfield` int(11) DEFAULT NULL,
  `textfield` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `dish_info`
--

INSERT INTO `dish_info` (`id`, `record_type`, `dish_id`, `user_id`, `date`, `numberfield`, `textfield`) VALUES
(1, 'C', 1, 1, '2025-05-01', NULL, 'Goed te volgen recept'),
(2, 'C', 1, 2, '2025-05-01', NULL, 'Dit gerecht was makkelijk te bereiden!'),
(3, 'P', 2, NULL, '2025-05-01', 1, 'Verwarm de oven voor op 200 graden Celsius'),
(4, 'P', 2, NULL, '2025-05-01', 2, 'Kook een ruime hoeveelheid water in een grote pan'),
(5, 'R', 3, 3, '2025-05-01', 3, ''),
(6, 'F', 4, 2, '2025-05-01', NULL, '[toegevoegd/verwijderd van/uit favorieten]'),
(7, 'C', 3, 3, '2025-05-01', NULL, 'Good lasagne! The preparation steps where a little unclear, but the result was delicious!'),
(8, 'P', 1, NULL, '2025-05-01', 1, 'Breng een ruime hoeveelheid water aan de kook in een grote pan'),
(9, 'R', 3, 2, '2025-05-01', 4, NULL),
(10, 'R', 3, 1, '2025-05-01', 5, NULL),
(11, 'R', 4, 1, '2025-05-01', 1, NULL),
(12, 'R', 4, 3, '2025-05-01', 5, NULL),
(13, 'R', 1, 1, '2025-05-02', 4, NULL),
(14, 'P', 1, NULL, '2025-05-01', 2, 'Snij de groente'),
(15, 'P', 1, NULL, '2025-05-01', 3, 'Rul het gehakt in een beetje olie'),
(16, 'R', 1, 2, '2025-05-02', 3, NULL),
(17, 'F', 1, 1, '2025-05-01', NULL, NULL),
(33, 'R', 2, 4, '2025-05-01', 3, NULL),
(34, 'F', 1, 4, '2025-05-02', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ingredient`
--

INSERT INTO `ingredient` (`id`, `dish_id`, `article_id`, `quantity`) VALUES
(1, 1, 1, 100),
(2, 1, 2, 200),
(3, 1, 3, 150),
(4, 1, 4, 1),
(5, 1, 5, 2),
(6, 1, 6, 2),
(7, 2, 7, 1),
(8, 2, 2, 100),
(9, 2, 8, 150),
(10, 2, 9, 100),
(11, 2, 4, 1),
(12, 2, 5, 2),
(13, 3, 10, 200),
(14, 3, 8, 150),
(15, 3, 2, 150),
(16, 3, 11, 200),
(17, 3, 9, 100),
(18, 4, 12, 1),
(19, 4, 14, 10),
(20, 4, 13, 20);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `kitchen_type`
--

CREATE TABLE `kitchen_type` (
  `id` int(11) NOT NULL,
  `record_type` enum('K','T') NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `kitchen_type`
--

INSERT INTO `kitchen_type` (`id`, `record_type`, `description`) VALUES
(1, 'K', 'Italian'),
(2, 'K', 'Mexican'),
(3, 'K', 'Dutch'),
(4, 'T', 'Vegetarian'),
(5, 'T', 'Meat'),
(6, 'T', 'Vegan');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `email`, `image`) VALUES
(1, 'chef_tom', 'passwordoftom', 'tom@example.com', 'tom.jpg'),
(2, 'chef_anna', 'passwordofanna', 'anna@example.com', 'anna.jpg'),
(3, 'chef_klaas', 'passwordofklaas', 'klaas@example.com', 'klaas.jpg'),
(4, 'chef_kim', 'passwordofkim', 'kim@example.com', 'kim.jpg');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kitchen_id` (`kitchen_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `dish_info`
--
ALTER TABLE `dish_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `dish_id` (`dish_id`);

--
-- Indexen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `dish_id` (`dish_id`);

--
-- Indexen voor tabel `kitchen_type`
--
ALTER TABLE `kitchen_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `dish_info`
--
ALTER TABLE `dish_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT voor een tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT voor een tabel `kitchen_type`
--
ALTER TABLE `kitchen_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `dishes`
--
ALTER TABLE `dishes`
  ADD CONSTRAINT `dishes_ibfk_1` FOREIGN KEY (`kitchen_id`) REFERENCES `kitchen_type` (`id`),
  ADD CONSTRAINT `dishes_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `kitchen_type` (`id`),
  ADD CONSTRAINT `dishes_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `dish_info`
--
ALTER TABLE `dish_info`
  ADD CONSTRAINT `dish_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `dish_info_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`);

--
-- Beperkingen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `ingredient_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `ingredient_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
