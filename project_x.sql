-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 29. Mai 2018 um 15:14
-- Server-Version: 10.1.31-MariaDB
-- PHP-Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `martin`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(127) NOT NULL,
  `flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer`, `flag`) VALUES
(1, 1, 'Christian', 1),
(2, 1, 'Martin', 0),
(3, 1, 'RenÃ©', 0),
(4, 1, 'Gott', 0),
(5, 2, 'Ja!', 1),
(6, 2, 'Definitv', 1),
(7, 2, 'SelbstverstÃ¤ndlich', 1),
(8, 2, 'Vielleicht.', 0),
(9, 3, 'MÃ¤nnertag', 1),
(10, 3, 'Festival', 0),
(11, 3, 'Weihnachten', 0),
(12, 3, 'Fastenzeit', 0),
(13, 4, 'Ja', 0),
(14, 4, 'Nein', 1),
(15, 4, 'Banane', 0),
(16, 4, '42', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `given_answers`
--

CREATE TABLE `given_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `given_answers`
--

INSERT INTO `given_answers` (`id`, `user_id`, `question_id`, `answer_id`, `time`, `flag`) VALUES
(1, 3, 1, 1, '2018-05-29 13:13:15', 1),
(2, 3, 3, 9, '2018-05-29 13:13:22', 1),
(3, 3, 2, 6, '2018-05-29 13:13:28', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `creator_id` int(11) NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `questions`
--

INSERT INTO `questions` (`id`, `question`, `creator_id`, `creation_time`, `end_time`) VALUES
(1, 'Wer hat diese Frage erstellt?', 1, '2018-05-29 12:51:42', NULL),
(2, 'Wird dieser Beleg mit 1,0 bewertet?', 1, '2018-05-29 12:52:18', NULL),
(3, 'An welchem Tag wird am meisten getrunken?', 2, '2018-05-29 12:54:56', NULL),
(4, 'Ist Rot = GrÃ¼n?', 3, '2018-05-29 13:07:08', '2018-05-29 13:09:39');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `real_name` varchar(50) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `registrationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `real_name`, `user_group_id`, `registrationdate`) VALUES
(1, 'Superuser', '$2y$10$0IQ2312cEvS5B5M4CdKZZORpbIJvkGPAaVC0jhBhIVYOuH1yHRb7W', 'Gott', 1, '2018-05-29 12:50:52'),
(2, 'Admin', '$2y$10$iE8pBqbBot7RjrrwO8sqOuj4JB7J9NrVdeb2QOwHqMxRHtUWc6g.O', 'Admin MC Adface', 2, '2018-05-29 12:53:34'),
(3, 'User', '$2y$10$2gPlaI3RZLlWjz7geH6dSuR8mQPjBS1HMmsUMS0BC1YADeICO3XpG', 'Achim der Zigeuner', 3, '2018-05-29 12:55:38');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user_group`
--

INSERT INTO `user_group` (`id`, `bezeichnung`) VALUES
(1, 'Superadmin'),
(2, 'Admin'),
(3, 'Studenten');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indizes für die Tabelle `given_answers`
--
ALTER TABLE `given_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `answer_id` (`answer_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indizes für die Tabelle `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_group_id` (`user_group_id`);

--
-- Indizes für die Tabelle `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `given_answers`
--
ALTER TABLE `given_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints der Tabelle `given_answers`
--
ALTER TABLE `given_answers`
  ADD CONSTRAINT `given_answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `given_answers_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`),
  ADD CONSTRAINT `given_answers_ibfk_3` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints der Tabelle `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_group_id`) REFERENCES `user_group` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
