-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 25 juin 2023 à 16:21
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `groupe4`
--

-- --------------------------------------------------------

--
-- Structure de la table `booking`
--

CREATE TABLE `booking` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `housing_id` smallint(5) UNSIGNED NOT NULL,
  `client_id` smallint(5) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('reserved','in progress','done','cancelled') DEFAULT 'reserved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `booking`
--

INSERT INTO `booking` (`id`, `housing_id`, `client_id`, `start_date`, `end_date`, `status`) VALUES
(1, 13, 6, '2023-06-22', '2023-07-01', 'cancelled'),
(2, 13, 6, '2023-06-22', '2023-06-24', 'done'),
(3, 13, 7, '2023-06-25', '2023-06-29', 'in progress'),
(4, 13, 7, '2023-06-25', '2023-06-27', 'in progress'),
(5, 13, 7, '2023-07-01', '2023-07-05', 'reserved');

-- --------------------------------------------------------

--
-- Structure de la table `housing`
--

CREATE TABLE `housing` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(127) NOT NULL,
  `position` enum('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20') DEFAULT NULL,
  `address` varchar(127) NOT NULL,
  `capacity` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `price` smallint(5) UNSIGNED NOT NULL,
  `discount` decimal(5,2) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `housing`
--

INSERT INTO `housing` (`id`, `name`, `position`, `address`, `capacity`, `price`, `discount`, `description`) VALUES
(13, 'Celestial', '1', '22 Rue Levalois 98111 Paris France', 5, 2000, '0.00', 'Un logement très cool. '),
(14, 'LUMINEX', '2', '31 Av de l\'EST, 92300, Paris France', 10, 5000, '0.00', 'Lorelm ipsum'),
(15, 'Le LUXE', '3', '23 Rue Levalois 98111  Paris France', 8, 4500, '0.00', 'le luxe'),
(16, 'PEACE&JOY', '4', '22 Rue Levalois 98111 Paris France', 5, 3000, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(17, 'COOK\'s House', '5', '22 Rue Levalois 98111  Paris France', 3, 1500, '10.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(18, 'Family House', '6', '22 Rue Levalois 98111 Paris France ', 10, 10000, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(19, 'LIBERTY', '7', '22 Rue Levalois 98111 Paris France ', 2, 7000, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(20, 'LUXIOUS', '8', '22 Rue Levalois 98111 Paris France', 2, 2500, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(21, 'Team REST', '9', '22 Rue Levalois 98111  Paris France', 12, 2800, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(22, 'LUMIÈRE', '3', '22 Rue Levalois 98111 Paris France', 4, 4300, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(23, 'WORK & WORK', '10', '22 Rue Levalois 98111 Paris France', 12, 5000, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(24, 'LUCIOL', '12', '22 Rue Levalois 98111 Paris France', 6, 6000, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(25, 'Paris\'s LOVER', '13', '22 Rue Levalois 98111 Paris France', 2, 12000, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(26, 'STAY', '15', '22 Rue Levalois 98111 Paris France', 6, 20000, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(27, 'KING DOM', '18', '22 Rue Levalois 98111  Paris France', 4, 12000, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(28, 'LIGHT', '19', '22 Rue Levalois 98111 Paris France ', 3, 14000, '10.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(29, 'CAPTIVITY', '20', '22 Rue Levalois 98111  Paris France', 12, 16800, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(30, 'CRISTAL', '17', '22 Rue Levalois 98111 Paris France ', 0, 12900, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(31, 'BUSINESS', '14', '22 Rue Levalois 98111  Paris France', 6, 20000, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(32, 'ROYALTY', '15', '22 Rue Levalois 98111 Paris France', 1, 12000, '0.00', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. '),
(33, 'EXPERT', '18', '22 Rue Levalois 98111 Paris France ', 12, 10000, '2.20', 'Il est composé de 5 pièces: il y a une grande\r\nentrée, une salle de bains, une cuisine et deux chambres à coucher. Dans mon appartement il n\'y\r\na pas de couloirs et je n\'ai pas de cave ni de garage ou de jardin. Je partage mon appart avec mon\r\ncolocataire, il s\'appelle Luca. Il est fort sympa! Comme nous n\'avons pas de salle à manger ou de\r\nsalon, nous mangeons dans l\'entrée. Elle est grande: il y a une table, des chaises et un grand\r\nplacard que nous utilisons comme garde-manger. ');

-- --------------------------------------------------------

--
-- Structure de la table `housing_benefits`
--

CREATE TABLE `housing_benefits` (
  `housing_id` smallint(5) UNSIGNED NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `housing_benefits`
--

INSERT INTO `housing_benefits` (`housing_id`, `content`) VALUES
(13, 'Terrace,Jardin,Services_supplémentaires,Assistance_par Chat'),
(14, 'Ascenseur,Terrace,Jardin'),
(15, 'Piscine,Ascenseur,Terrace'),
(16, 'Ascenseur,Terrace'),
(17, 'Piscine,Ascenseur'),
(18, 'Piscine,Terrace,Jardin'),
(19, 'Piscine,Ascenseur,Terrace'),
(20, 'Piscine,Ascenseur,Terrace'),
(21, 'Piscine,Terrace,Jardin'),
(22, 'Piscine,Ascenseur,Terrace'),
(23, 'Piscine,Terrace'),
(24, 'Terrace,Jardin'),
(25, 'Piscine,Ascenseur'),
(26, 'Piscine,Ascenseur,Terrace,Jardin,Champagne_au FRIGO'),
(27, 'Piscine,Ascenseur,Terrace,Jardin'),
(28, 'Piscine,Ascenseur,Terrace,TV'),
(29, 'Piscine,Ascenseur,Terrace,Jardin'),
(30, 'Piscine,Ascenseur,Terrace,Jardin'),
(31, 'Piscine,Ascenseur,Terrace,Jardin'),
(32, 'Piscine,Ascenseur,Terrace,Jardin,Baignoire'),
(33, 'Piscine,Ascenseur,Terrace,Jardin');

-- --------------------------------------------------------

--
-- Structure de la table `housing_pictures`
--

CREATE TABLE `housing_pictures` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `housing_id` smallint(5) UNSIGNED NOT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `housing_pictures`
--

INSERT INTO `housing_pictures` (`id`, `housing_id`, `url`) VALUES
(34, 13, '13/1_dinning-table-4272043_1920.jpg'),
(35, 14, '14/1_apartment-1256663_1920.jpg'),
(36, 14, '14/2_dining-room-6686053_1920.jpg'),
(37, 14, '14/3_home-4137379_1920.jpg'),
(40, 15, '15/1_apartment-4489573_1920.jpg'),
(41, 15, '15/2_kitchen-75553_1920.jpg'),
(42, 16, '16/1_dining-room-332207_1280.jpg'),
(43, 16, '16/2_kitchen-2677871_1920.jpg'),
(44, 17, '17/1_kitchen-1543489_1920.jpg'),
(45, 17, '17/2_kitchen-1543497_1920.jpg'),
(46, 18, '18/1_family-room-54581_1920.jpg'),
(47, 19, '19/1_house-6006723_1920.jpg'),
(48, 20, '20/1_interior-design-7217386_1280.jpg'),
(49, 21, '21/1_dining-room-1476060_1920.jpg'),
(50, 22, '22/1_indoor-4176940_1920.jpg'),
(51, 23, '23/1_home-4137379_1920.jpg'),
(52, 23, '23/2_interior-design-7061458_1920.jpg'),
(53, 24, '24/1_kitchen-2165756_1920.jpg'),
(54, 25, '25/1_living-room-4787115_1920.jpg'),
(55, 26, '26/1_kitchen-5570468_1920.jpg'),
(56, 27, '27/1_living-and-dining-room-5535179_1920.jpg'),
(57, 28, '28/1_living-room-930800_1920.jpg'),
(58, 29, '29/1_living-room-2732939_1920.jpg'),
(59, 30, '30/1_living-room-6479429_1920.jpg'),
(60, 31, '31/1_chairs-2181994_1920.jpg'),
(61, 32, '32/1_bedroom-389254_1920.jpg'),
(62, 32, '32/2_living-room-581073_1920.jpg'),
(63, 33, '33/1_apartment-7349942_1920.jpg'),
(64, 33, '33/2_bathtub-3609070_1920.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `housing_unavailabilities`
--

CREATE TABLE `housing_unavailabilities` (
  `housing_id` smallint(5) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `status` enum('to define','defined','in progress','done','cancelled') DEFAULT 'to define',
  `housing_id` smallint(5) UNSIGNED NOT NULL,
  `team_id` smallint(5) UNSIGNED DEFAULT NULL,
  `maintenance_date` date DEFAULT NULL,
  `due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `maintenance`
--

INSERT INTO `maintenance` (`id`, `status`, `housing_id`, `team_id`, `maintenance_date`, `due_date`) VALUES
(1, 'to define', 14, NULL, NULL, '2023-06-24'),
(2, 'to define', 13, NULL, NULL, '2023-06-22'),
(3, 'to define', 13, NULL, NULL, '2023-06-22'),
(4, 'to define', 13, NULL, NULL, '2023-06-25'),
(5, 'to define', 13, NULL, NULL, '2023-06-25'),
(6, 'to define', 13, NULL, NULL, '2023-07-01');

-- --------------------------------------------------------

--
-- Structure de la table `maintenance_notes`
--

CREATE TABLE `maintenance_notes` (
  `maintenance_id` smallint(5) UNSIGNED NOT NULL,
  `content` varchar(255) NOT NULL,
  `status` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `maintenance_todo`
--

CREATE TABLE `maintenance_todo` (
  `maintenance_id` smallint(5) UNSIGNED NOT NULL,
  `bedding` bit(1) DEFAULT b'0',
  `dust` bit(1) DEFAULT b'0',
  `sanitized` bit(1) DEFAULT b'0',
  `fridge` bit(1) DEFAULT b'0',
  `bathroom` bit(1) DEFAULT b'0',
  `electronics` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `booking_id` smallint(5) UNSIGNED NOT NULL,
  `sender_id` smallint(5) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `booking_id`, `sender_id`, `content`, `date`) VALUES
(25, 1, 6, 'salut', '2023-06-23 08:03:57'),
(26, 1, 7, 'oui slut', '2023-06-23 08:04:55'),
(27, 2, 7, 'Salut', '2023-06-24 11:51:55'),
(28, 1, 7, 'anjazeaknj', '2023-06-25 14:09:30');

-- --------------------------------------------------------

--
-- Structure de la table `teams`
--

CREATE TABLE `teams` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `teams`
--

INSERT INTO `teams` (`id`, `active`) VALUES
(4, b'1');

-- --------------------------------------------------------

--
-- Structure de la table `team_members`
--

CREATE TABLE `team_members` (
  `team_id` smallint(5) UNSIGNED NOT NULL,
  `member_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `team_members`
--

INSERT INTO `team_members` (`team_id`, `member_id`) VALUES
(4, 8);

-- --------------------------------------------------------

--
-- Structure de la table `testimonies`
--

CREATE TABLE `testimonies` (
  `housing_id` smallint(5) UNSIGNED NOT NULL,
  `client_id` smallint(5) UNSIGNED NOT NULL,
  `content` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `testimonies`
--

INSERT INTO `testimonies` (`housing_id`, `client_id`, `content`, `id`, `date`) VALUES
(13, 7, 'De derniers essais', 32, '2023-06-25 15:47:58');

-- --------------------------------------------------------

--
-- Structure de la table `tokens`
--

CREATE TABLE `tokens` (
  `token` varchar(31) NOT NULL,
  `user_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(63) NOT NULL,
  `first_name` varchar(63) NOT NULL,
  `last_name` varchar(63) NOT NULL,
  `role` enum('maintenance','logistic','management','admin','customer','sudo') DEFAULT 'customer',
  `active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `mail`, `password`, `first_name`, `last_name`, `role`, `active`) VALUES
(1, 'test@projet.eu', '$2y$10$XVu0XVKv/KqqEMJcY5FsTu7uKlsOuO13JLZm4kQLZe5EO2BMQs/LW', 'ADMINOA', 'Administrator', 'admin', b'1'),
(4, 'logistic@logistic.fr', '$2y$10$WkHKqEAMl4L2uCFYyyLnZOBv0iq69QsCuhp7adAUSNGdiXvZF0ORe', '', 'logistic', 'logistic', b'1'),
(5, 'manager@manager.fr', '$2y$10$RCUgaUs/Gq0xZtKB2ag2BuJa0A058VAiVcOzgC2GaRqPBeNULscZm', 'MANAGER', 'manager', 'management', b'1'),
(6, 'client@client.eu', '$2y$10$cxFhuw1EtcR6he3TPuJq.eCADLxCaL7QPXQNOxPzkWaOHDeXVgCly', 'Client ', ' N°1', 'customer', b'1'),
(7, 'sudo@sudo.fr', '$2y$10$QS5.RyDV9i4/xAiHMh/Zi.9rMHDbtBw1UwEDWFhRqFsrZqYfZTJ4m', 'SUPER', 'User', 'sudo', b'1'),
(8, 'maintenance@maintenance.fr', '$2y$10$HE7KnzthuRpZ7Nkwwy3wTuvFUO.WGr0Fa3wGDAX3EJlTvbMzcfiLq', '', 'maintenance', 'maintenance', b'1');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_housing_fk` (`housing_id`),
  ADD KEY `booking_user_fk` (`client_id`);

--
-- Index pour la table `housing`
--
ALTER TABLE `housing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_id` (`id`),
  ADD KEY `idx_position` (`position`),
  ADD KEY `idx_capacity` (`capacity`),
  ADD KEY `idx_price` (`price`),
  ADD KEY `idx_discount` (`discount`);

--
-- Index pour la table `housing_benefits`
--
ALTER TABLE `housing_benefits`
  ADD PRIMARY KEY (`housing_id`) USING BTREE;

--
-- Index pour la table `housing_pictures`
--
ALTER TABLE `housing_pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pictures_housing_fk` (`housing_id`);

--
-- Index pour la table `housing_unavailabilities`
--
ALTER TABLE `housing_unavailabilities`
  ADD PRIMARY KEY (`housing_id`,`start_date`,`end_date`),
  ADD KEY `idx_start_date` (`start_date`),
  ADD KEY `idx_end_date` (`end_date`);

--
-- Index pour la table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_id` (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `maintenance_housing_fk` (`housing_id`),
  ADD KEY `maintenance_team_fk` (`team_id`);

--
-- Index pour la table `maintenance_notes`
--
ALTER TABLE `maintenance_notes`
  ADD PRIMARY KEY (`maintenance_id`,`content`),
  ADD KEY `idx_status` (`status`);

--
-- Index pour la table `maintenance_todo`
--
ALTER TABLE `maintenance_todo`
  ADD PRIMARY KEY (`maintenance_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_booking_id` (`booking_id`),
  ADD KEY `message_sender_fk` (`sender_id`);

--
-- Index pour la table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_id` (`id`);

--
-- Index pour la table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`team_id`,`member_id`),
  ADD KEY `teammember_member_fk` (`member_id`);

--
-- Index pour la table `testimonies`
--
ALTER TABLE `testimonies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testimonies_user_fk` (`client_id`),
  ADD KEY `testimony_client` (`housing_id`) USING BTREE;

--
-- Index pour la table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token`),
  ADD KEY `tokens_user_fk` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_id` (`id`),
  ADD KEY `idx_mail` (`mail`),
  ADD KEY `idx_first_name` (`first_name`),
  ADD KEY `idx_last_name` (`last_name`),
  ADD KEY `idx_role` (`role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `housing`
--
ALTER TABLE `housing`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `housing_pictures`
--
ALTER TABLE `housing_pictures`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `testimonies`
--
ALTER TABLE `testimonies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_housing_fk` FOREIGN KEY (`housing_id`) REFERENCES `housing` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_user_fk` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `housing_benefits`
--
ALTER TABLE `housing_benefits`
  ADD CONSTRAINT `benefits_housing_fk` FOREIGN KEY (`housing_id`) REFERENCES `housing` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `housing_pictures`
--
ALTER TABLE `housing_pictures`
  ADD CONSTRAINT `pictures_housing_fk` FOREIGN KEY (`housing_id`) REFERENCES `housing` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `housing_unavailabilities`
--
ALTER TABLE `housing_unavailabilities`
  ADD CONSTRAINT `unavailabilty_housing_fk` FOREIGN KEY (`housing_id`) REFERENCES `housing` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_housing_fk` FOREIGN KEY (`housing_id`) REFERENCES `housing` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_team_fk` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `maintenance_notes`
--
ALTER TABLE `maintenance_notes`
  ADD CONSTRAINT `note_maintenance_fk` FOREIGN KEY (`maintenance_id`) REFERENCES `maintenance` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `maintenance_todo`
--
ALTER TABLE `maintenance_todo`
  ADD CONSTRAINT `todo_maintenance_fk` FOREIGN KEY (`maintenance_id`) REFERENCES `maintenance` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
