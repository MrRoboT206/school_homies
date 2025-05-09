-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 08, 2025 alle 20:14
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_homies`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `comments`
--

CREATE TABLE `comments` (
  `id_comment` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `comments`
--

INSERT INTO `comments` (`id_comment`, `text`, `id_user`, `id_post`) VALUES
(1, 'Grazie per gli appunti!', 3, 1),
(3, 'PORCODIO', 4, 1),
(514, 'trjrfnd', 1, 11),
(521, 'gianluca un po\' di contegno', 5, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `folders`
--

CREATE TABLE `folders` (
  `id_folder` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `folders`
--

INSERT INTO `folders` (`id_folder`, `id_user`, `type`, `name`) VALUES
(1, 1, 'Appunti', 'matematica'),
(2, 2, 'Eventi', 'cinema'),
(3, 5, 'privata', 'Algebra'),
(4, 5, 'public', 'Italiano');

-- --------------------------------------------------------

--
-- Struttura della tabella `foldersnotes`
--

CREATE TABLE `foldersnotes` (
  `id_folder` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `foldersnotes`
--

INSERT INTO `foldersnotes` (`id_folder`, `id_post`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipantsevents`
--

CREATE TABLE `partecipantsevents` (
  `id_partecipant` int(11) NOT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `partecipantsevents`
--

INSERT INTO `partecipantsevents` (`id_partecipant`, `id_event`) VALUES
(1, 14),
(2, 15),
(3, 14),
(4, 14);

-- --------------------------------------------------------

--
-- Struttura della tabella `posts`
--

CREATE TABLE `posts` (
  `id_post` int(11) NOT NULL,
  `type_post` int(11) NOT NULL COMMENT '1: post semplice\r\n2:evento\r\n3:appunti\r\n4:richiesta appunti',
  `date` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_event` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `path_folder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `posts`
--

INSERT INTO `posts` (`id_post`, `type_post`, `date`, `title`, `description`, `date_event`, `id_user`, `path_folder`) VALUES
(1, 1, '2025-02-01', 'Lezione di Matematica', 'Appunti sulla lezione di algebra', NULL, 1, 1),
(2, 1, '2025-02-15', 'Evento di Fisica', 'Conferenza sulla fisica quantistica', NULL, 2, 2),
(3, 0, '0000-00-00', 'erg', 'werg', NULL, NULL, 0),
(4, 0, '0000-00-00', 'tre', 'tre', NULL, NULL, 0),
(5, 0, '0000-00-00', 'sacsd', 'cwecfwecw', NULL, NULL, 0),
(6, 0, '0000-00-00', 'rftgyjnm', 'erthj', NULL, NULL, 0),
(7, 0, '0000-00-00', 'rftgyjnm', 'erthj', NULL, 1, 0),
(8, 0, '0000-00-00', 'qwefefqw', 'qefqweffq', NULL, 1, 0),
(10, 0, '0000-00-00', 'cacca', 'piscio\r\n', NULL, 1, 0),
(11, 0, '2025-03-13', 'SONO LKE 11:57', 'diomerdaaaaaaaaaaaaa', NULL, 1, 0),
(12, 0, '2025-03-13', 'ascsqw', 'xcqscqc', NULL, 1, 0),
(14, 2, '2025-03-13', 'evento di domani', 'domani', '2025-03-14 09:45:40', 1, 0),
(15, 2, '2025-03-13', 'evento di domani', 'domani', '2025-03-14 09:45:40', 1, 0);

--
-- Trigger `posts`
--
DELIMITER $$
CREATE TRIGGER `data_add` BEFORE INSERT ON `posts` FOR EACH ROW SET NEW.date = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `publicationstags`
--

CREATE TABLE `publicationstags` (
  `id_tag` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `publicationstags`
--

INSERT INTO `publicationstags` (`id_tag`, `id_post`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `tags`
--

CREATE TABLE `tags` (
  `id_tag` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tags`
--

INSERT INTO `tags` (`id_tag`, `name`) VALUES
(1, 'Matematica'),
(2, 'Fisica');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `is_verified`, `name`, `surname`, `bio`, `user_type`) VALUES
(1, 'mario.rossi@example.com', 'password123', 0, 'Mario', 'Rossi', 't678yu8io', 'student'),
(2, 'luigi.verdi@example.com', 'password123', 0, 'Luigi', 'Verdi', NULL, 'teacher'),
(3, 'anna.bianchi@example.com', 'password123', 0, 'Anna', 'Bianchi', NULL, 'student'),
(4, 'Gianluca.marroni@example.com', '', 0, 'gianluca', 'cognome', NULL, 'normale'),
(5, 'caccapalle@itisgalileiroma.it', '$2y$10$FKk9ypKm2ClCfKWeO3EkDuIdIGYBP3eXgNdumGY3kXLGvnCYcxlLO', 0, 'cacca', 'palle', 'cacca', 'normale'),
(6, 'pisciocazzo@itisgalileiroma.it', '$2y$10$.mzEjA/INp64JrSHDYFe6OXX5Ou5Vi72eQHW12uFGyqUsMB2rzW2K', 0, 'piscio', 'cazzo', NULL, 'normale');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD UNIQUE KEY `id_comment` (`id_comment`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_post` (`id_post`);

--
-- Indici per le tabelle `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `id_user` (`id_user`);

--
-- Indici per le tabelle `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id_folder`),
  ADD UNIQUE KEY `id_folder` (`id_folder`),
  ADD KEY `folders_fk1` (`id_user`);

--
-- Indici per le tabelle `foldersnotes`
--
ALTER TABLE `foldersnotes`
  ADD PRIMARY KEY (`id_folder`,`id_post`),
  ADD UNIQUE KEY `id_post` (`id_post`);

--
-- Indici per le tabelle `partecipantsevents`
--
ALTER TABLE `partecipantsevents`
  ADD PRIMARY KEY (`id_partecipant`,`id_event`),
  ADD KEY `partecipantsevents_fk1` (`id_event`);

--
-- Indici per le tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`),
  ADD UNIQUE KEY `id_post` (`id_post`),
  ADD KEY `posts_fk5` (`id_user`);

--
-- Indici per le tabelle `publicationstags`
--
ALTER TABLE `publicationstags`
  ADD PRIMARY KEY (`id_tag`,`id_post`),
  ADD KEY `publicationstags_fk1` (`id_post`);

--
-- Indici per le tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id_tag`),
  ADD UNIQUE KEY `id_tag` (`id_tag`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=524;

--
-- AUTO_INCREMENT per la tabella `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `folders`
--
ALTER TABLE `folders`
  MODIFY `id_folder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `foldersnotes`
--
ALTER TABLE `foldersnotes`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `tags`
--
ALTER TABLE `tags`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD CONSTRAINT `email_verifications_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Limiti per la tabella `folders`
--
ALTER TABLE `folders`
  ADD CONSTRAINT `folders_fk1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `foldersnotes`
--
ALTER TABLE `foldersnotes`
  ADD CONSTRAINT `foldersnotes_fk0` FOREIGN KEY (`id_folder`) REFERENCES `folders` (`id_folder`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foldersnotes_fk1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `partecipantsevents`
--
ALTER TABLE `partecipantsevents`
  ADD CONSTRAINT `partecipantsevents_fk0` FOREIGN KEY (`id_partecipant`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partecipantsevents_fk1` FOREIGN KEY (`id_event`) REFERENCES `posts` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_fk5` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `publicationstags`
--
ALTER TABLE `publicationstags`
  ADD CONSTRAINT `publicationstags_fk0` FOREIGN KEY (`id_tag`) REFERENCES `tags` (`id_tag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publicationstags_fk1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
