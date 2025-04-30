-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 30 apr 2025 om 10:25
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
  `packaging` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `article`
--

INSERT INTO `article` (`id`, `name`, `description`, `unit`, `price`, `packaging`) VALUES
(1, 'Spaghetti', 'Dried pasta', 'gram', 1.99, 'Bag 500g'),
(2, 'Tomato sauce', 'Tomato sauce for pasta', 'ml', 2.49, 'Bottle 500ml'),
(3, 'Vegetarian minced meat', 'Plant-based minced meat', 'gram', 3.99, 'Tray 250g'),
(4, 'Onion', 'Yellow onion', 'piece', 0.25, 'Loose'),
(5, 'Garlic', 'Clove of garlic', 'piece', 0.10, 'Loose'),
(6, 'Herb mix', 'Italian herbs', 'teaspoon', 0.05, 'Bottle 50g'),
(7, 'Nacho chips', 'Tortilla chips', 'bag', 1.49, 'Bag 200g'),
(8, 'Minced meat', 'Beef minced meat', 'gram', 2.99, 'Tray 250g'),
(9, 'Cheese', 'Grated cheese', 'gram', 1.59, 'Bag 150g'),
(10, 'Lasagna sheets', 'Pasta for lasagna', 'gram', 1.49, 'Box 250g'),
(11, 'Bechamel sauce', 'White sauce', 'ml', 1.89, 'Bottle 200ml'),
(12, 'Bread', 'Whole wheat sandwich', 'slice', 0.20, 'Loose'),
(13, 'Chocolate sprinkles', 'Dark chocolate sprinkles', 'gram', 0.05, 'Box 200g'),
(14, 'Butter', 'Plant-based margarine', 'gram', 0.30, 'Piece 25g');

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
(1, 1, 4, 2, '2025-04-30 10:11:30', 'Spaghetti Bolognese', 'Vegetarian Italian pasta with minced sauce.', 'Rich tomato sauce with vegetarian minced meat, onion, garlic, and herbs. Served with spaghetti.', 'spaghetti.jpg'),
(2, 2, 5, 2, '2025-04-30 10:11:30', 'Nachos', 'Mexican oven dish with minced meat and cheese.', 'Crispy nacho chips with seasoned minced meat, cheese, jalapeño, and fresh guacamole.', 'nacho.jpg'),
(3, 1, 5, 2, '2025-04-30 10:11:30', 'Lasagna', 'Layers of pasta with sauce and cheese.', 'Layers of pasta, bolognese sauce, and bechamel sauce with melted cheese on top.', 'lasagna.jpg'),
(4, 3, 6, 2, '2025-04-30 10:11:30', 'Sandwich with chocolate sprinkles', 'Sandwich with dark chocolate sprinkles.', 'Whole wheat sandwich with plant-based butter and dark chocolate sprinkles.', 'sandwich.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dish_info`
--

CREATE TABLE `dish_info` (
  `id` int(11) NOT NULL,
  `record_type` enum('C','P','R','F') NOT NULL,
  `dish_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `numberfield` int(11) DEFAULT NULL,
  `textfield` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `dish_info`
--

INSERT INTO `dish_info` (`id`, `record_type`, `dish_id`, `user_id`, `date`, `numberfield`, `textfield`) VALUES
(1, 'C', 1, 2, '2025-04-30', 5, 'Record C with text and value.'),
(2, 'P', 2, 2, '2025-04-30', 3, 'Record P with text and value.'),
(3, 'R', 3, 2, '2025-04-30', 7, 'Record R with text and value.'),
(4, 'F', 4, 2, '2025-04-30', 7, 'Record F with text and value.');

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
(9, 3, 10, 200),
(10, 3, 8, 150),
(11, 3, 2, 150),
(12, 3, 11, 200),
(13, 3, 9, 100),
(14, 4, 12, 1),
(15, 4, 14, 10),
(16, 4, 13, 20);

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
(2, 'chef_anna', 'passwordofanna', 'anna@example.com', 'anna.jpg');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT voor een tabel `kitchen_type`
--
ALTER TABLE `kitchen_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
