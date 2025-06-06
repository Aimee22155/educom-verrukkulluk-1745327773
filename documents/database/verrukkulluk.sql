-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 28 mei 2025 om 09:10
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
  `calories` int(11) DEFAULT NULL,
  `plaatje` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `article`
--

INSERT INTO `article` (`id`, `name`, `description`, `unit`, `price`, `packaging`, `calories`, `plaatje`) VALUES
(1, 'spaghetti', 'Dried pasta', 'gram', 1.99, '500', 710, 'spaghetti_a.jpg'),
(2, 'tomato sauce', 'Tomato sauce for pasta', 'ml', 2.49, '500', 100, 'tomatensaus.jpg'),
(3, 'vegetarian meat', 'Vegetarian plant-based minced meat', 'gram', 3.99, '250', 250, 'Vega_gehakt.jpg'),
(4, 'onion', 'Yellow onion', 'piece', 3.25, '6', 40, 'ui.jpg'),
(5, 'garlic', 'Clove of garlic', 'piece', 2.10, '6', 4, 'garlic.jpg'),
(6, 'Herb mix', 'Italian herbs', 'teaspoon', 0.05, '50', 150, 'italiaanse_kruiden.jpg'),
(7, 'Nacho chips', 'Tortilla chips', 'bag', 1.49, '200', 1000, 'Nacho_chips.jpg'),
(8, 'Meat', 'Beef minced meat', 'gram', 2.99, '250', 250, 'gehakt.jpg'),
(9, 'Cheese', 'Grated cheese', 'gram', 1.59, '150', 600, 'kaas.jpg'),
(10, 'Lasagna sheets', 'Pasta for lasagna', 'gram', 1.49, '250', 850, 'lasagna_bladen.jpg'),
(11, 'Bechamel sauce', 'White sauce', 'ml', 1.89, '200', 200, 'Bechamel.jpg'),
(12, 'Bread', 'Whole wheat sandwich', 'slice', 4.20, '10', 80, 'brood.jpg'),
(13, 'Chocolate sprinkles', 'Dark chocolate sprinkles', 'gram', 2.50, '200', 1040, 'hagelslag.jpg'),
(14, 'Butter', 'Plant-based margarine', 'gram', 3.30, '250', 180, 'margarine.jpg'),
(15, 'Vegetables', 'Vegetable mix with red onion, leek, pepper, tomato and basil.', 'gram', 2.00, '200', 146, 'Groentemix_1.jpg'),
(16, 'Vegetables', 'Vegetable mix with bell pepper, green and red peppers, corn, cucumber, coriander and tomato.', 'gram', 2.00, '200', 170, 'Groentemix_2.jpg');

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
(1, 1, 4, 1, '2025-05-01 14:47:44', 'Spaghetti', 'Vegetarian Italian pasta with rich tomato sauce with vegetarian minced meat, onion, garlic, and herbs. Served with spaghetti.\r\n', 'Savor the delightful flavors of our Vegetarian Italian pasta.\r\nThis dish features a rich and vibrant tomato sauce as its base.\r\nWe\'ve added vegetarian minced meat to enhance the texture and taste.\r\nFinely chopped onion and fragrant garlic are sautéed to build a flavorful foundation. A blend of traditional Italian herbs infuses the sauce with aromatic notes. This hearty and satisfying meal is served over a bed of perfectly cooked spaghetti. It\'s a comforting and classic Italian dish, entirely plant-based. Enjoy a taste of Italy with this wholesome and flavorful vegetarian offering.', 'Spaghetti.jpg'),
(2, 2, 5, 2, '2025-05-01 14:47:44', 'Nachos', 'Mexican oven dish with crispy nacho chips and seasoned minced meat, cheese, jalapeño, and fresh guacamole.', 'Experience our delectable Mexican oven dish, a layered delight starting with a bed of crispy nacho chips and richly seasoned minced meat. Generous amounts of melted cheese create a gooey, satisfying texture, while fiery jalapeño slices add a kick of heat. Topped with a vibrant and freshly made guacamole, it offers a cool and creamy contrast. This oven-baked creation delivers a burst of authentic Mexican flavors in every warm and inviting serving.', 'nachos.jpg'),
(3, 1, 5, 3, '2025-05-01 14:47:44', 'Lasagna', 'Layers of pasta, bolognese sauce, and bechamel sauce with melted cheese on top.\r\n\r\n', 'Indulge in our classic Italian lasagna, featuring rich layers of tender pasta and a hearty bolognese sauce. A smooth and creamy bechamel sauce is generously spread throughout, adding a luxurious touch. Finally, the dish is topped with a blanket of melted cheese, creating a golden and bubbly crust. Each forkful offers a comforting and satisfying taste of traditional Italian cuisine.', 'Lasagna.jpg'),
(4, 3, 6, 2, '2025-05-01 14:47:44', 'Sandwich', 'Whole wheat sandwich with plant-based butter and dark chocolate sprinkles.\r\n\r\n', 'Enjoy our simple yet satisfying whole wheat sandwich, spread with creamy plant-based butter for a smooth base. We then generously top it with delightful dark chocolate sprinkles, adding a touch of sweetness and a hint of rich cocoa flavor. This offers a light and tasty option, perfect for a quick bite. Experience the subtle nuttiness of the whole wheat combined with the pleasant sweetness of the chocolate.', 'Boterham.jpg');

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
(1, 'C', 1, 1, '2025-05-01', NULL, 'Easy recipe!'),
(2, 'C', 1, 2, '2025-05-01', NULL, 'Dit gerecht was makkelijk te bereiden!'),
(3, 'P', 2, NULL, '2025-05-01', 1, 'Verwarm de oven voor op 200 graden Celsius'),
(4, 'P', 2, NULL, '2025-05-01', 2, 'Rul het gehakt bruin in een grote pan.'),
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
(18, 'R', 2, 4, '2025-05-01', 3, NULL),
(20, 'C', 2, 3, '2025-05-20', NULL, 'Awesome dish! Really deserves 5 stars.'),
(21, 'P', 3, NULL, '2025-05-20', 1, 'Verwarm de oven voor op 220c⁰ graden.'),
(22, 'P', 3, NULL, '0000-00-00', 2, 'Rul het gehakt bruin in een pan'),
(23, 'P', 3, NULL, '0000-00-00', 3, 'Voeg de 2 sauzen na elkaar toe en breng deze aan de kook (let op: zodra het kook draai je het vuur laag en laat je het met de deksel erop zo\'n 10min sudderen).'),
(246, 'P', 3, NULL, '2025-05-20', 4, 'Vet een ovenschaal in en giet 1/3 van het gehakt met de saus erin. Verdeel mooi over de bodem.'),
(247, 'P', 3, NULL, '2025-05-20', 5, 'Leg nu 3 lasagne bladen naast elkaar over de lengte in de ovenschaal. Herhaal nu stap 4 en 5 nog twee keer.'),
(248, 'P', 4, NULL, '2025-05-20', 1, 'Pak een snee brood en smeer hier een laagje boter op. '),
(249, 'P', 4, NULL, '2025-05-20', 2, 'Strooi nu hagelslag op de boterham. Zorg ervoor dat de hele boterham bedekt is, maar niet dat het laagje hagelslag te dik wordt.'),
(250, 'P', 2, NULL, '2025-05-20', 3, 'Voeg de groente toe.'),
(251, 'P', 2, NULL, '2025-05-20', 4, 'voeg nu de saus toe, breng aan de kook en laat het 10 min sudderen.'),
(252, 'P', 2, NULL, '2025-05-20', 5, 'Vet een ovenschaal in en leg hier het gehakt met de saus in.'),
(253, 'P', 2, NULL, '2025-05-20', 6, 'Steek nu een paar nacho ships in de schaal en verkruimel er een paar bovenop. '),
(254, 'P', 2, NULL, '2025-05-20', 7, 'Zet de schaal in de oven en laat zo\'n 15min bakken.'),
(255, 'P', 3, NULL, '2025-05-20', 6, 'Zet de schaal in de oven en laat zo\'n 30min bakken.'),
(256, 'P', 1, NULL, '2025-05-20', 4, 'Zodra het water kook voeg je de spaghetti toe. Laat dit zo\'n 11min koken, zodat het a la dente wordt.'),
(257, 'P', 1, NULL, '2025-05-20', 5, 'Voeg de groente toe aan het gehakt.'),
(258, 'P', 1, NULL, '2025-05-20', 6, 'Voeg de saus toe en breng aan de kook. Laat het geheel zo\'n 10min sudderen.'),
(259, 'P', 1, NULL, '2025-05-20', 7, 'Giet de spaghetti af.'),
(343, 'R', 3, NULL, '2025-05-22', 1, NULL),
(344, 'R', 3, NULL, '2025-05-22', 1, NULL),
(345, 'R', 3, NULL, '2025-05-22', 1, NULL),
(346, 'R', 3, NULL, '2025-05-22', 1, NULL),
(347, 'R', 1, NULL, '2025-05-22', 5, NULL),
(348, 'R', 1, NULL, '2025-05-22', 5, NULL),
(375, 'R', 1, NULL, '2025-05-27', 1, NULL),
(376, 'R', 1, NULL, '2025-05-27', 2, NULL),
(378, 'R', 1, NULL, '2025-05-28', 2, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groceries_list`
--

CREATE TABLE `groceries_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `article_name` varchar(255) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `total_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `groceries_list`
--

INSERT INTO `groceries_list` (`id`, `user_id`, `article_id`, `article_name`, `unit`, `total_quantity`) VALUES
(1, 1, 1, 'Spaghetti', 'gram', 9500),
(2, 1, 2, 'Tomato sauce', 'ml', 19000),
(3, 1, 3, 'Vegetarian minced meat', 'gram', 14250),
(4, 1, 4, 'Onion', 'piece', 95),
(5, 1, 5, 'Garlic', 'piece', 190),
(6, 1, 6, 'Herb mix', 'teaspoon', 190),
(7, 2, 7, 'Nacho chips', 'bag', 1),
(8, 2, 2, 'Tomato sauce', 'ml', 100),
(9, 2, 8, 'Minced meat', 'gram', 150),
(10, 2, 9, 'Cheese', 'gram', 100),
(11, 2, 4, 'Onion', 'piece', 1),
(12, 2, 5, 'Garlic', 'piece', 2),
(13, 1, 15, 'Spaghetti groentemix', 'gram', 1400);

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
(20, 4, 13, 20),
(21, 1, 15, 200),
(22, 2, 16, 200);

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
(1, 'Tom', 'passwordoftom', 'tom@example.com', 'tom.jpg'),
(2, 'Anna', 'passwordofanna', 'anna@example.com', 'anna.jpg'),
(3, 'Klaas', 'passwordofklaas', 'klaas@example.com', 'klaas.jpg'),
(4, 'Kim', 'passwordofkim', 'kim@example.com', 'kim.jpg');

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
-- Indexen voor tabel `groceries_list`
--
ALTER TABLE `groceries_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `article_id` (`article_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT voor een tabel `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `dish_info`
--
ALTER TABLE `dish_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=380;

--
-- AUTO_INCREMENT voor een tabel `groceries_list`
--
ALTER TABLE `groceries_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT voor een tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
-- Beperkingen voor tabel `groceries_list`
--
ALTER TABLE `groceries_list`
  ADD CONSTRAINT `groceries_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `groceries_list_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE;

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
