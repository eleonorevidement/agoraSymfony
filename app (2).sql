-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 31 mai 2024 à 09:50
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `app`
--

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BA388B7A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart_item`
--

DROP TABLE IF EXISTS `cart_item`;
CREATE TABLE IF NOT EXISTS `cart_item` (
  `cart_id` int NOT NULL,
  `item_id` int NOT NULL,
  PRIMARY KEY (`cart_id`,`item_id`),
  KEY `IDX_F0FE25271AD5CDBF` (`cart_id`),
  KEY `IDX_F0FE2527126F525E` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240527182515', '2024-05-27 18:25:44', 216),
('DoctrineMigrations\\Version20240528204150', '2024-05-28 20:45:39', 32),
('DoctrineMigrations\\Version20240529205544', '2024-05-29 20:55:56', 146),
('DoctrineMigrations\\Version20240529211744', '2024-05-29 21:17:48', 44),
('DoctrineMigrations\\Version20240530105058', '2024-05-30 10:51:14', 122),
('DoctrineMigrations\\Version20240531091113', '2024-05-31 09:11:26', 265);

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` double NOT NULL,
  `category` int NOT NULL,
  `created_by_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1F1B251EB03A8386` (`created_by_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id`, `name`, `description`, `price`, `category`, `created_by_id`) VALUES
(1, 'Chaise', 'Chaise de bureau', 60, 1, NULL),
(2, 'Tapis', 'Tapis en peau de chevre', 1200, 2, NULL),
(6, 'Bureau', 'Bureau en bois d\'acajou', 1600, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `cart_id` int DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`),
  UNIQUE KEY `UNIQ_8D93D6491AD5CDBF` (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `password`, `profile_picture`, `email`, `roles`, `cart_id`, `first_name`, `last_name`) VALUES
(6, '$2y$13$InhV95x.O3mMn2Vm31vxRuz2ReScvggGyqejdfhxpxP4epvn5WUhi', NULL, 'eleonore.vidementdupouy@edu.ece.fr', '[\"ROLE_ADMIN\"]', NULL, 'Eleonore', 'Videment'),
(7, '$2y$13$drxWxO5l5X1DIWke3ZP4r..fmr45DGYyek48qdEYb7mkwpOG.U.QG', NULL, 'cedric.gourhant@edu.ece.fr', '[\"ROLE_ADMIN\"]', NULL, 'Cedric', 'Gourhant'),
(8, '$2y$13$4eRBwSNYjEug8xIiEh8FauNI6dpnJxbmRhjUgCbne2IcZsgwJ5Oae', NULL, 'luna.rondineau@edu.ece.fr', '[\"ROLE_ADMIN\"]', NULL, 'Luna', 'Rondineau'),
(9, '$2y$13$nfx3gX7Rv0ojubDpW1RcUe8YmnEMYsOl3DzLAx18WmWGm5x9zSQpi', NULL, 'halima.ghazi@edu.ece.fr', '[\"ROLE_ADMIN\"]', NULL, 'Halima', 'Ghazi'),
(10, '$2y$13$M3nTqPwskwDV6rzA7BmdKeEzRf/Bsuw2vix9QF7gudpxksAvNSiQ.', NULL, 'user0@gmail.com', '[]', NULL, 'Seller', 'User'),
(11, '$2y$13$x5ueg3qJKV0xiyl1OiS0quRJICaMSIGRGT6LpxXJvyPQ7XWyyxuly', NULL, 'user1@gmail.com', '[]', NULL, 'Seller', 'User'),
(12, '$2y$13$1U9bTj9oHjB5xiElUk8muuMq0afMTbwMSvtsWZKvEJ9QYptmzuDP2', NULL, 'user2@gmail.com', '[]', NULL, 'Seller', 'User'),
(13, '$2y$13$Os8rHg071bvxy2Kh4kWuxOXqeoMhD25RfRfnFETexkqdXGpbO16Cq', NULL, 'user3@gmail.com', '[]', NULL, 'Seller', 'User'),
(16, '$2y$13$mYftlezypfObpcVHoSaZeu4NUAmTBHdnp2iLraP0wLNoRwNlODxX2', NULL, 'paul.mirabel@edu.ece.fr', '[]', NULL, 'Paul', 'Mirabelle'),
(20, '$2y$13$/zxGF7a2BXxK0vZ0vTxED.Co14yEp3MR03vVshQlHFc6vPJRnJk3y', NULL, 'test@gmail.com', '[]', NULL, 'registered', 'byAdmin'),
(21, '$2y$13$2dvsfhrQy/eD619urRWKSe4MElLYOAX2bK9DiOr6yDsB7gg1sj.2i', NULL, 'test2@gmail.com', '[\"ROLE_ADMIN\"]', NULL, 'registered', 'byAdmin');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `FK_F0FE2527126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F0FE25271AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_1F1B251EB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6491AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
