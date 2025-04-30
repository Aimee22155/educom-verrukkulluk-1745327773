-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 28 apr 2025 om 13:55
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
-- Database: `recepten`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `omschrijving` text DEFAULT NULL,
  `eenheid` varchar(50) DEFAULT NULL,
  `prijs` decimal(10,2) NOT NULL,
  `verpakking` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `artikel`
--

INSERT INTO `artikel` (`id`, `naam`, `omschrijving`, `eenheid`, `prijs`, `verpakking`) VALUES
(1, 'Spaghetti', 'Gedroogde pasta', 'gram', 1.99, 'Zak 500g'),
(2, 'Tomatensaus', 'Tomatensaus voor pasta', 'ml', 2.49, 'Fles 500ml'),
(3, 'Vegetarisch gehakt', 'Plantaardig gehakt', 'gram', 3.99, 'bakje 250g'),
(4, 'Ui', 'Gele ui', 'stuk', 0.25, 'Los'),
(5, 'Knoflook', 'Teentje knoflook', 'stuk', 0.10, 'Los'),
(6, 'Kruidenmix', 'Italiaanse kruiden', 'theelepel', 0.05, 'flesje 50g'),
(7, 'Nacho chips', 'Tortilla chips', 'zak', 1.49, 'Zak 200g'),
(8, 'Gehakt', 'Rundergehakt', 'gram', 2.99, 'Bakje 250g'),
(9, 'Kaas', 'Geraspte kaas', 'gram', 1.59, 'Zakje 150g'),
(10, 'Lasagnebladen', 'Pasta voor lasagne', 'gram', 1.49, 'Doos 250g'),
(11, 'Bechamelsaus', 'Witte saus', 'ml', 1.89, 'Fles 200ml'),
(12, 'Brood', 'Volkoren boterham', 'snede', 0.20, 'Los'),
(13, 'Hagelslag', 'Pure chocolade hagelslag', 'gram', 0.05, 'doos 200g'),
(14, 'Boter', 'Plantaardige margarine', 'gram', 0.30, 'stukje 25g');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerechten`
--

CREATE TABLE `gerechten` (
  `id` int(11) NOT NULL,
  `keuken_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datum_toegevoegd` datetime NOT NULL,
  `titel` varchar(100) NOT NULL,
  `korte_omschrijving` text DEFAULT NULL,
  `lange_omschrijving` text DEFAULT NULL,
  `afbeelding` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gerechten`
--

INSERT INTO `gerechten` (`id`, `keuken_id`, `type_id`, `user_id`, `datum_toegevoegd`, `titel`, `korte_omschrijving`, `lange_omschrijving`, `afbeelding`) VALUES
(1, 1, 4, 1, '2025-04-28 09:12:59', 'Spaghetti Bolognese', 'Vegetarische Italiaanse pasta met gehaktsaus.', 'Rijke tomatensaus met vegetarisch gehakt, ui, knoflook en kruiden. Geserveerd met spaghetti.', 'spaghetti.jpg'),
(2, 2, 5, 1, '2025-04-28 09:12:59', 'Nachos', 'Mexicaanse ovenschotel met gehakt en kaas.', 'Knapperige nacho chips met gekruid gehakt, kaas, jalapeño en verse guacamole.', 'nacho.jpg'),
(3, 1, 5, 1, '2025-04-28 09:12:59', 'Lasagne', 'Laagjes pasta met saus en kaas.', 'Laagjes pasta, bolognesesaus en bechamelsaus met gesmolten kaas bovenop.', 'lasagne.jpg'),
(4, 3, 6, 1, '2025-04-28 09:12:59', 'Boterham met hagelslag', 'Boterham met pure chocolade hagelslag.', 'Volkoren boterham met plantaardige boter en pure hagelslag.', 'boterham.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht_info`
--

CREATE TABLE `gerecht_info` (
  `id` int(11) NOT NULL,
  `record_type` enum('O','B','W','F') NOT NULL,
  `gerecht_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `nummeriekveld` int(11) DEFAULT NULL,
  `tekstveld` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gerecht_info`
--

INSERT INTO `gerecht_info` (`id`, `record_type`, `gerecht_id`, `user_id`, `datum`, `nummeriekveld`, `tekstveld`) VALUES
(1, 'O', 1, 1, '2025-04-28', 5, 'Record O met tekst en waarde.'),
(2, 'B', 2, 1, '2025-04-28', 3, 'Record B met tekst en waarde.'),
(3, 'W', 3, 1, '2025-04-28', 7, 'Record W met tekst en waarde.'),
(4, 'F', 4, 1, '2025-04-28', 7, 'Record F met tekst en waarde.');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `gerecht_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `aantal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ingredient`
--

INSERT INTO `ingredient` (`id`, `gerecht_id`, `artikel_id`, `aantal`) VALUES
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
-- Tabelstructuur voor tabel `keuken_type`
--

CREATE TABLE `keuken_type` (
  `id` int(11) NOT NULL,
  `record_type` enum('K','T') NOT NULL,
  `omschrijving` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `keuken_type`
--

INSERT INTO `keuken_type` (`id`, `record_type`, `omschrijving`) VALUES
(1, 'K', 'Italiaans'),
(2, 'K', 'Mexicaans'),
(3, 'K', 'Nederlands'),
(4, 'T', 'Vegetarisch'),
(5, 'T', 'Vlees'),
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
  `afbeelding` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `email`, `afbeelding`) VALUES
(1, 'chef_tom', 'wachtwoordvantom', 'tom@example.com', 'tom.jpg');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `gerechten`
--
ALTER TABLE `gerechten`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `keuken_type`
--
ALTER TABLE `keuken_type`
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
-- AUTO_INCREMENT voor een tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `gerechten`
--
ALTER TABLE `gerechten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT voor een tabel `keuken_type`
--
ALTER TABLE `keuken_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
