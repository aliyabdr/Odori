-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 01. Jul 2024 um 01:05
-- Server-Version: 10.4.27-MariaDB
-- PHP-Version: 8.2.0

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
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_url` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `ads`
--

INSERT INTO `ads` (`id`, `title`, `description`, `price`, `brand`, `color`, `condition`, `user_id`, `created_at`, `image_url`, `category`) VALUES
(1, 'Leichter Wander-Rucksack', 'Ein leichter und robuster Wander-Rucksack, perfekt für Tagesausflüge.', '45.00', 'Deuter', 'Blau', 'gebraucht', 1, '2024-06-14 18:54:15', '../uploads/Diseño sin título.jpg', 'Rucksäcke'),
(2, 'Trekkingzelt für 2 Personen', 'Wetterfestes Zelt für 2 Personen, ideal für längere Trekkingtouren.', '120.00', 'Vaude', 'Grün', 'neu', 2, '2024-06-14 18:54:15', '../uploads/pexels-uriel-mont-6271505.jpg', 'Zelte'),
(3, 'Wanderstöcke aus Aluminium', 'Leichte und stabile Wanderstöcke, ausziehbar und mit komfortablen Griffen.', '30.00', 'Leki', 'Schwarz', 'gebraucht', 3, '2024-06-14 18:54:15', '../uploads/pexels-anastasia-shuraeva-8795587.jpg', 'Wanderstöcke'),
(4, 'Kletterschuhe Größe 42', 'Bequeme und griffige Kletterschuhe, kaum benutzt.', '60.00', 'La Sportiva', 'Gelb', 'neu', 4, '2024-06-14 18:54:15', '../uploads/pexels-pavel-danilyuk-7591328.jpg', 'Kletterschuhe'),
(5, 'Outdoor-Kocher', 'Kompakter und leistungsstarker Kocher, ideal für Camping und Trekking.', '35.00', 'Primus', 'Silber', 'neu', 5, '2024-06-14 18:54:15', '../uploads/pexels-taryn-elliott-8052670.jpg', 'Kocher'),
(6, 'Schlafsack für extreme Kälte', 'Hochwertiger Schlafsack, geeignet für sehr niedrige Temperaturen.', '150.00', 'Mammut', 'Rot', 'neu', 6, '2024-06-14 18:54:15', '../uploads/pexels-tima-miroshnichenko-7010173.jpg', 'Schlafsäcke'),
(7, 'Trinkflasche 1L', 'Robuste und BPA-freie Trinkflasche, perfekt für Outdoor-Aktivitäten.', '15.00', 'Nalgene', 'Transparent', 'neu', 7, '2024-06-14 18:54:15', '../uploads/pexels-gabriel-peter-219375-1188649.jpg', 'Trinkflaschen'),
(8, 'Campingstuhl faltbar', 'Bequemer und faltbarer Campingstuhl, leicht zu transportieren.', '25.00', 'Helinox', 'Schwarz', 'gebraucht', 8, '2024-06-14 18:54:15', '../uploads/pexels-rdne-7348607.jpg', 'Campingmöbel'),
(9, 'GPS-Uhr', 'Multifunktionale GPS-Uhr mit Höhenmesser und Barometer.', '200.00', 'Garmin', 'Schwarz', 'neu', 9, '2024-06-14 18:54:15', '../uploads/pexels-mikebirdy-3683938.jpg', 'Navigation'),
(10, 'Wasserdichter Rucksack', 'Wasserdichter Rucksack, ideal für Kajak- und Rafting-Touren.', '80.00', 'Ortlieb', 'Gelb', 'gebraucht', 14, '2024-06-14 18:54:15', '../uploads/pexels-rafal-bubala-243126766-19503239.jpg', 'Rucksäcke'),
(11, 'Wanderstiefel Lowa in braun', 'Wanderstiefel der Marke Lowa (Gr.38) mit einer griffigen Außensohle. Gebraucht aber in gutem Zustand. \r\n', '35.00', 'Andere', 'Braun', 'gebraucht', 16, '2024-06-17 10:49:45', '../uploads/clay-banks-BSL837tTPAw-unsplash.jpg', 'Wandern'),
(15, 'blauer Wander- und Skirucksack', 'Blauer Ortovox Rucksack, perfekt fürs Wandern oder als Skiruckssack.', '50.00', 'Andere', 'Blau', 'gebraucht', 16, '2024-06-24 11:44:09', '../uploads/Imagen de WhatsApp 2024-04-08 a las 10.44.14_3215be80.jpg', 'Wandern');

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
(80, 5, 3, 5, 'Perfekt! Schneller Versand und super Ware.', '2024-06-14 19:05:21'),
(81, 16, 17, 5, 'Hat alles super geklappt. Gerne wieder!', '2024-06-30 18:24:45');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `saved_ads` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `postal_code`, `location`, `profile_picture`, `created_at`, `saved_ads`) VALUES
(1, 'OutdoorQueen02', '$2y$10$UyrOFxaLYZy5NIugbrZE/.a7LxTnCDpUtPJD8PrJE0pDOWZA64Kba', 'aliya02@hotmail.com', '70563', 'Stuttgart', '../uploads/pexels-brenda-lelis-1006720-2899744.jpg', '2024-05-28 10:38:18', NULL),
(2, 'Baerrr555', '$2y$10$AsVii8pMaa0lkwdOYhRTd.Hn95Z3RWWYciOQftHH8u5BNRNNwOMVK', 'natha05@hotmail.com', '70563', 'Stuttgart', '../uploads/pexels-cottonbro-3205777.jpg', '2024-05-28 11:00:01', NULL),
(3, 'maggus42', '$2y$10$IYkFNRHLrBbkbMrvFIPPduShKB82Yt7SpFkv0.qZq.oGROfVvu0iS', 'hallo@googel.com', '71126', 'Gäufelden', '../uploads/pexels-cottonbro-4911006.jpg', '2024-05-28 12:17:15', NULL),
(4, 'outdoorenthusiast', 'password_hash_4', 'outdoorenthusiast@example.com', '60311', 'Frankfurt', '../uploads/pexels-jangogh-418924060-15272230.jpg', '2024-06-14 19:04:16', NULL),
(5, 'ingridv9', '$2y$10$V4dS8SgeQhgfiNOminXhEOlnRok6mfxLvUQOUO0rWyyQx5EzHsnTy', 'iv010@hdm-stuttgart.de', '70569', 'Stuttgart', NULL, '2024-06-12 07:09:16', NULL),
(6, 'miaw0405', 'password_hash_1', 'miaw0405@example.com', '10115', 'Berlin', '../uploads/pexels-cottonbro-4911143.jpg', '2024-06-14 18:55:53', NULL),
(7, 'hiker123', 'password_hash_2', 'hiker123@example.com', '20095', 'Hamburg', '../uploads/pexels-lukas-rodriguez-1845331-3680219.jpg', '2024-06-14 18:55:53', NULL),
(8, 'mountainlover', 'password_hash_3', 'mountainlover@example.com', '80331', 'München', '../uploads/pexels-itislit-2866784.jpg', '2024-06-14 18:55:53', NULL),
(9, 'naturefan', 'password_hash_4', 'naturefan@example.com', '60311', 'Frankfurt', '../uploads/pexels-cottonbro-4911143.jpg', '2024-06-14 18:55:53', NULL),
(10, 'trekker', 'password_hash_5', 'trekker@example.com', '50667', 'Köln', '../uploads/pexels-dariabuntaria-2938922.jpg', '2024-06-14 18:55:53', NULL),
(11, 'climber', 'password_hash_6', 'climber@example.com', '70173', 'Stuttgart', '../uploads/pexels-snoopy42-20761797.jpg', '2024-06-14 18:55:53', NULL),
(12, 'adventureguy', 'password_hash_7', 'adventureguy@example.com', '40213', 'Düsseldorf', '../uploads/pexels-vome-15444465.jpg', '2024-06-14 18:55:53', NULL),
(13, 'trailblazer', 'password_hash_8', 'trailblazer@example.com', '04109', 'Leipzig', '../uploads/pexels-tugce-acikyurek-3099881-20693559.jpg', '2024-06-14 18:55:53', NULL),
(14, 'forestwanderer', 'password_hash_9', 'forestwanderer@example.com', '01067', 'Dresden', NULL, '2024-06-14 18:55:53', NULL),
(15, 'wildlifeenthusiast', 'password_hash_10', 'wildlifeenthusiast@example.com', '30159', 'Hannover', NULL, '2024-06-14 18:55:53', NULL),
(16, '1234567890', '$2y$10$gIRiw7qdWp9gbStoHNBf2.TZi18XfmwjALg7d.fcUOsTMV7P4zMaO', '123@hotmail.com', '70569', 'Stuttgart', '../uploads/Imagen de WhatsApp 2024-04-16 a las 11.12.46_88c00d5b.jpg', '2024-06-16 11:11:36', ',1'),
(17, 'aliyaoutdoor2002', '$2y$10$2wcNvuW2S7XXsouSRsODEOGjP0ZS/FF31DG0vrwN6KIChnCH6T01y', 'hallo@googlemail.com', '73230', 'Kirchheim', '../uploads/pexels-thefatmansvision-3850526.jpg', '2024-06-30 18:12:47', ''),
(18, 'freakyoutdoor', '$2y$10$UYePj3CDzNONojcZrhoQieR.9Pu4Al.6IFWdcBKuqlfrxILELg4FG', 'aliya@gmail.com', '30159', 'Hannover', NULL, '2024-06-30 18:14:30', NULL),
(19, 'outdoorlol', '$2y$10$Mrvhuv13kD8g6.8GosPKNejSUlGmVPcRDjsm5lJIe28JymUA17Qui', 'aliya@web.de', '50667', 'Köln', NULL, '2024-06-30 18:15:11', NULL),
(20, 'maria', '$2y$10$SIhdqEHAbHfyKRGXiaXtceS6YF9tKFCFd16L/MIw7IpHKwKb8kroC', 'mari@hotmail.de', '78647', 'Trossingen', NULL, '2024-06-30 22:53:25', NULL),
(21, 'Adventure', '$2y$10$BWqGJBckkrHHtaDcj09rv.VukTumX/ZOLkFcFLFuUq/4Tmozs584O', 'andre12@yahoo.com', '78647', 'Trossingen', NULL, '2024-06-30 22:59:55', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT für Tabelle `ad_images`
--
ALTER TABLE `ad_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
