-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 16. Jun 2024 um 12:26
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `kleinanzeigenplattform`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `condition` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_url` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `ads`
--

INSERT INTO `ads` (`id`, `title`, `description`, `price`, `brand`, `color`, `condition`, `location`, `user_id`, `created_at`, `image_url`, `category`) VALUES
(1, 'Leichter Wander-Rucksack', 'Ein leichter und robuster Wander-Rucksack, perfekt für Tagesausflüge.', 45.00, 'Deuter', 'Blau', 'Gebraucht', 'Berlin, Deutschland', 1, '2024-06-14 18:54:15', NULL, 'Rucksäcke'),
(2, 'Trekkingzelt für 2 Personen', 'Wetterfestes Zelt für 2 Personen, ideal für längere Trekkingtouren.', 120.00, 'Vaude', 'Grün', 'Neu', 'Hamburg, Deutschland', 2, '2024-06-14 18:54:15', NULL, 'Zelte'),
(3, 'Wanderstöcke aus Aluminium', 'Leichte und stabile Wanderstöcke, ausziehbar und mit komfortablen Griffen.', 30.00, 'Leki', 'Schwarz', 'Gebraucht', 'München, Deutschland', 3, '2024-06-14 18:54:15', NULL, 'Wanderstöcke'),
(4, 'Kletterschuhe Größe 42', 'Bequeme und griffige Kletterschuhe, kaum benutzt.', 60.00, 'La Sportiva', 'Gelb', 'Wie Neu', 'Frankfurt, Deutschland', 4, '2024-06-14 18:54:15', NULL, 'Kletterschuhe'),
(5, 'Outdoor-Kocher', 'Kompakter und leistungsstarker Kocher, ideal für Camping und Trekking.', 35.00, 'Primus', 'Silber', 'Neu', 'Köln, Deutschland', 5, '2024-06-14 18:54:15', NULL, 'Kocher'),
(6, 'Schlafsack für extreme Kälte', 'Hochwertiger Schlafsack, geeignet für sehr niedrige Temperaturen.', 150.00, 'Mammut', 'Rot', 'Wie Neu', 'Stuttgart, Deutschland', 6, '2024-06-14 18:54:15', NULL, 'Schlafsäcke'),
(7, 'Trinkflasche 1L', 'Robuste und BPA-freie Trinkflasche, perfekt für Outdoor-Aktivitäten.', 15.00, 'Nalgene', 'Transparent', 'Neu', 'Düsseldorf, Deutschland', 7, '2024-06-14 18:54:15', NULL, 'Trinkflaschen'),
(8, 'Campingstuhl faltbar', 'Bequemer und faltbarer Campingstuhl, leicht zu transportieren.', 25.00, 'Helinox', 'Schwarz', 'Gebraucht', 'Leipzig, Deutschland', 8, '2024-06-14 18:54:15', NULL, 'Campingmöbel'),
(9, 'GPS-Uhr', 'Multifunktionale GPS-Uhr mit Höhenmesser und Barometer.', 200.00, 'Garmin', 'Schwarz', 'Neu', 'Dresden, Deutschland', 9, '2024-06-14 18:54:15', NULL, 'Navigation'),
(10, 'Wasserdichter Rucksack', 'Wasserdichter Rucksack, ideal für Kajak- und Rafting-Touren.', 80.00, 'Ortlieb', 'Gelb', 'Gebraucht', 'Hannover, Deutschland', 10, '2024-06-14 18:54:15', NULL, 'Rucksäcke');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ad_images`
--

CREATE TABLE `ad_images` (
  `id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reviewer_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `reviewer_id`, `rating`, `review`, `created_at`) VALUES
(61, 1, 3, 5, 'Toller Verkäufer! Schneller Versand und Artikel wie beschrieben.', '2024-06-14 19:05:21'),
(62, 3, 1, 4, 'Guter Kauf, aber die Verpackung war etwas beschädigt.', '2024-06-14 19:05:21'),
(63, 3, 5, 5, 'Super netter Kontakt und schnelle Abwicklung. Sehr empfehlenswert!', '2024-06-14 19:05:21'),
(64, 5, 3, 3, 'Der Artikel war in Ordnung, aber der Versand hat etwas länger gedauert.', '2024-06-14 19:05:21'),
(65, 5, 6, 5, 'Perfekt! Sehr freundlicher Verkäufer und Artikel in Top-Zustand.', '2024-06-14 19:05:21'),
(66, 6, 5, 4, 'Artikel wie beschrieben, aber die Kommunikation hätte besser sein können.', '2024-06-14 19:05:21'),
(67, 7, 8, 5, 'Schneller Versand und Artikel wie neu. Gerne wieder!', '2024-06-14 19:05:21'),
(68, 8, 7, 5, 'Sehr zufrieden mit dem Kauf. Alles lief reibungslos.', '2024-06-14 19:05:21'),
(69, 9, 10, 4, 'Gute Ware, schneller Versand, aber die Verpackung war etwas knapp.', '2024-06-14 19:05:21'),
(70, 10, 9, 5, 'Alles bestens. Artikel wie beschrieben und sehr schneller Versand.', '2024-06-14 19:05:21'),
(71, 1, 3, 5, 'Sehr nette Kommunikation und schneller Versand. Artikel in einwandfreiem Zustand.', '2024-06-14 19:05:21'),
(72, 3, 5, 4, 'Artikel wie beschrieben, allerdings war die Verpackung beschädigt.', '2024-06-14 19:05:21'),
(73, 5, 6, 5, 'Einwandfreie Abwicklung und sehr freundlicher Kontakt.', '2024-06-14 19:05:21'),
(74, 6, 7, 3, 'Artikel kam verspätet an, aber ansonsten alles okay.', '2024-06-14 19:05:21'),
(75, 7, 8, 5, 'Top Verkäufer! Artikel war in hervorragendem Zustand.', '2024-06-14 19:05:21'),
(76, 8, 9, 4, 'Gute Erfahrung, allerdings hätte der Versand schneller sein können.', '2024-06-14 19:05:21'),
(77, 9, 10, 5, 'Sehr zufrieden! Jederzeit wieder.', '2024-06-14 19:05:21'),
(78, 10, 1, 5, 'Reibungsloser Ablauf und netter Kontakt.', '2024-06-14 19:05:21'),
(79, 1, 5, 4, 'Alles gut, aber die Verpackung war nicht optimal.', '2024-06-14 19:05:21'),
(80, 5, 3, 5, 'Perfekt! Schneller Versand und super Ware.', '2024-06-14 19:05:21');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `profile_picture` text DEFAULT NULL,
  `about_me` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `postal_code`, `location`, `profile_picture`, `about_me`, `created_at`) VALUES
(1, 'OutdoorQueen02', '$2y$10$UyrOFxaLYZy5NIugbrZE/.a7LxTnCDpUtPJD8PrJE0pDOWZA64Kba', 'aliya02@hotmail.com', '70563', 'Stuttgart', NULL, NULL, '2024-05-28 10:38:18'),
(2, 'Baerrr555', '$2y$10$AsVii8pMaa0lkwdOYhRTd.Hn95Z3RWWYciOQftHH8u5BNRNNwOMVK', 'natha05@hotmail.com', '70563', 'Stuttgart', NULL, NULL, '2024-05-28 11:00:01'),
(3, 'maggus42', '$2y$10$IYkFNRHLrBbkbMrvFIPPduShKB82Yt7SpFkv0.qZq.oGROfVvu0iS', 'hallo@googel.com', '71126', 'Gäufelden', NULL, NULL, '2024-05-28 12:17:15'),
(4, 'outdoorenthusiast', 'password_hash_4', 'outdoorenthusiast@example.com', '60311', 'Frankfurt, Deutschland', NULL, 'Ich liebe es, die Natur zu erkunden und neue Abenteuer zu erleben. Spezialisiert auf Trekking und Camping.', '2024-06-14 19:04:16'),
(5, 'ingridv9', '$2y$10$V4dS8SgeQhgfiNOminXhEOlnRok6mfxLvUQOUO0rWyyQx5EzHsnTy', 'iv010@hdm-stuttgart.de', '70569', 'Stuttgart', NULL, NULL, '2024-06-12 07:09:16'),
(6, 'miaw0405', 'password_hash_1', 'miaw0405@example.com', '10115', 'Berlin, Deutschland', NULL, 'Hi! Ich bin Mia und meine Hobbys sind Wandern und Klettern.', '2024-06-14 18:55:53'),
(7, 'hiker123', 'password_hash_2', 'hiker123@example.com', '20095', 'Hamburg, Deutschland', NULL, 'Ich liebe es, neue Wanderwege zu entdecken.', '2024-06-14 18:55:53'),
(8, 'mountainlover', 'password_hash_3', 'mountainlover@example.com', '80331', 'München, Deutschland', NULL, 'Berge sind meine Leidenschaft.', '2024-06-14 18:55:53'),
(9, 'naturefan', 'password_hash_4', 'naturefan@example.com', '60311', 'Frankfurt, Deutschland', NULL, 'Natur und Abenteuer - das bin ich.', '2024-06-14 18:55:53'),
(10, 'trekker', 'password_hash_5', 'trekker@example.com', '50667', 'Köln, Deutschland', NULL, 'Ich bin Trekker, immer auf der Suche nach dem nächsten Abenteuer.', '2024-06-14 18:55:53'),
(11, 'climber', 'password_hash_6', 'climber@example.com', '70173', 'Stuttgart, Deutschland', NULL, 'Klettern ist mein Leben.', '2024-06-14 18:55:53'),
(12, 'adventureguy', 'password_hash_7', 'adventureguy@example.com', '40213', 'Düsseldorf, Deutschland', NULL, 'Ich liebe Outdoor-Abenteuer.', '2024-06-14 18:55:53'),
(13, 'trailblazer', 'password_hash_8', 'trailblazer@example.com', '04109', 'Leipzig, Deutschland', NULL, 'Trailrunning und mehr.', '2024-06-14 18:55:53'),
(14, 'forestwanderer', 'password_hash_9', 'forestwanderer@example.com', '01067', 'Dresden, Deutschland', NULL, 'Ich wandere gerne durch Wälder.', '2024-06-14 18:55:53'),
(15, 'wildlifeenthusiast', 'password_hash_10', 'wildlifeenthusiast@example.com', '30159', 'Hannover, Deutschland', NULL, 'Wildlife-Fotografie ist meine Leidenschaft.', '2024-06-14 18:55:53');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ad_images`
--
ALTER TABLE `ad_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ad_id` (`ad_id`);

--
-- Indizes für die Tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `reviewer_id` (`reviewer_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `ad_images`
--
ALTER TABLE `ad_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ad_images`
--
ALTER TABLE `ad_images`
  ADD CONSTRAINT `ad_images_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
