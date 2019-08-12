-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 31 juil. 2019 à 00:05
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `shop`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `catID` tinyint(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT '0',
  `cat_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `comID` int(12) NOT NULL,
  `content` text NOT NULL,
  `comDate` datetime NOT NULL,
  `itemID` int(12) NOT NULL,
  `userID` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Structure de la table `follower`
--

CREATE TABLE `follower` (
  `userID` int(16) NOT NULL,
  `followerID` int(16) NOT NULL,
  `follow_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;


-- --------------------------------------------------------

--
-- Structure de la table `items`
--

CREATE TABLE `items` (
  `itemID` int(12) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_description` text NOT NULL,
  `price` varchar(50) NOT NULL,
  `add_date` datetime NOT NULL,
  `wilaya` varchar(30) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image1` varchar(120) NOT NULL,
  `image2` varchar(120) NOT NULL,
  `image3` varchar(120) NOT NULL,
  `status` varchar(50) NOT NULL,
  `sim_card` int(1) NOT NULL,
  `tags` text NOT NULL,
  `type` int(1) NOT NULL,
  `RAM` int(11) NOT NULL,
  `CPU` varchar(50) NOT NULL,
  `Capacity` int(11) NOT NULL,
  `Screen` varchar(50) NOT NULL,
  `front_camera` varchar(50) NOT NULL,
  `back_camera` varchar(50) NOT NULL,
  `OS` varchar(50) NOT NULL,
  `pending` int(1) NOT NULL,
  `views` int(11) NOT NULL,
  `catID` tinyint(4) NOT NULL,
  `userID` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `languages`
--

CREATE TABLE `languages` (
  `language` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `itemID` int(12) NOT NULL,
  `userID` int(12) NOT NULL,
  `like_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mark`
--

CREATE TABLE `mark` (
  `markID` int(12) NOT NULL,
  `mark_name` varchar(30) NOT NULL,
  `catID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `ID` int(12) NOT NULL,
  `user1` varchar(50) NOT NULL,
  `user2` varchar(50) NOT NULL,
  `sender` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lue` tinyint(1) NOT NULL,
  `message_type` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `notifID` int(11) NOT NULL,
  `type_notif` varchar(50) NOT NULL,
  `fr_content` varchar(100) NOT NULL,
  `en_content` varchar(100) NOT NULL,
  `notif_date` datetime NOT NULL,
  `seen` int(1) NOT NULL DEFAULT '0',
  `userID` int(12) NOT NULL,
  `triggeur` int(12) NOT NULL,
  `concerned` int(12) NOT NULL,
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `rating`
--

CREATE TABLE `rating` (
  `ratID` int(12) NOT NULL,
  `user` int(12) NOT NULL,
  `target` int(12) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;



-- --------------------------------------------------------

--
-- Structure de la table `reply`
--

CREATE TABLE `reply` (
  `repID` int(12) NOT NULL,
  `rep_content` text NOT NULL,
  `rep_date` datetime NOT NULL,
  `userID` int(12) NOT NULL,
  `subID` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `subject`
--

CREATE TABLE `subject` (
  `subID` int(12) NOT NULL,
  `title` varchar(50) NOT NULL,
  `sub_content` text NOT NULL,
  `sub_type` varchar(50) NOT NULL,
  `sub_date` date NOT NULL,
  `sub_views` int(11) NOT NULL DEFAULT '0',
  `userID` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `userID` int(12) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `groupID` int(1) NOT NULL DEFAULT '0',
  `truststatus` int(2) NOT NULL DEFAULT '0',
  `regDate` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `telephone` int(12) NOT NULL,
  `birthDate` date DEFAULT NULL,
  `wilaya` varchar(50) NOT NULL,
  `interests` text NOT NULL,
  `super` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `user_likes`
--

CREATE TABLE `user_likes` (
  `userID` int(12) NOT NULL,
  `itemID` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Structure de la table `wilayas`
--

CREATE TABLE `wilayas` (
  `wilaya` varchar(50) CHARACTER SET utf8 NOT NULL,
  `code` int(11) NOT NULL,
  `percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `wilayas`
--

INSERT INTO `wilayas` (`wilaya`, `code`, `percentage`) VALUES
('Adrar', 1, 4),
('Aïn Defla', 44, 0),
('Aïn Témouchent', 46, 0),
('Alger', 16, 12),
('Annaba', 23, 0),
('Batna', 5, 1),
('Béchar', 8, 0),
('Béjaia', 6, 0),
('Biskra', 7, 0),
('Blida', 9, 0),
('Bordj Bou Arréridj', 34, 0),
('Bouira', 10, 0),
('Boumerdés', 35, 0),
('Chlef', 2, 5),
('Constantine', 25, 1),
('Djelfa', 17, 0),
('El Biyadh', 32, 0),
('El Oued', 39, 0),
('El Taref', 36, 0),
('Ghardaïa', 47, 0),
('Guelma', 24, 0),
('Illizi', 33, 0),
('Jijel', 18, 0),
('Khenchla', 40, 2),
('Laghouat', 3, 0),
('M\'sila', 28, 0),
('Mascara', 29, 0),
('Médéa', 26, 0),
('Mila', 43, 0),
('Mostaganem', 27, 0),
('Naâma', 45, 0),
('Oran', 31, 0),
('Ouargla', 30, 0),
('Oum El Bouaghi', 4, 0),
('Relizane', 48, 0),
('Saida', 20, 0),
('Sétif', 19, 0),
('Sidi Bel Abbes', 22, 0),
('Skikda', 21, 0),
('Souk Ahras', 41, 0),
('Tamanrasset', 11, 0),
('Tébessa', 12, 0),
('Tiaret', 14, 0),
('Tindouf', 37, 0),
('Tipaza', 42, 0),
('Tissemsilt', 38, 0),
('Tizi Ouzou', 15, 1),
('Tlemcen', 13, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`catID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comID`),
  ADD KEY `fk_item` (`itemID`),
  ADD KEY `fk_users1` (`userID`);

--
-- Index pour la table `follower`
--
ALTER TABLE `follower`
  ADD PRIMARY KEY (`userID`,`followerID`),
  ADD KEY `fk_follower` (`followerID`);

--
-- Index pour la table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `fk_users` (`userID`),
  ADD KEY `fk_cat` (`catID`);

--
-- Index pour la table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`language`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`itemID`,`userID`),
  ADD KEY `fk_userLike` (`userID`);

--
-- Index pour la table `mark`
--
ALTER TABLE `mark`
  ADD PRIMARY KEY (`markID`),
  ADD UNIQUE KEY `mark` (`mark_name`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_user1` (`user1`),
  ADD KEY `fk_user2` (`user2`),
  ADD KEY `fk_sender` (`sender`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notifID`),
  ADD KEY `fk_concernedUser` (`userID`),
  ADD KEY `fk_triggerUser` (`triggeur`);

--
-- Index pour la table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`ratID`),
  ADD KEY `fk_userRating` (`user`),
  ADD KEY `fk_userTarget` (`target`);

--
-- Index pour la table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`repID`),
  ADD KEY `fk_userReply` (`userID`),
  ADD KEY `fk_subReplay` (`subID`);

--
-- Index pour la table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subID`),
  ADD KEY `fk_userSub` (`userID`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `user_likes`
--
ALTER TABLE `user_likes`
  ADD KEY `fk_itemView` (`itemID`),
  ADD KEY `fk_userView` (`userID`);

--
-- Index pour la table `wilayas`
--
ALTER TABLE `wilayas`
  ADD PRIMARY KEY (`wilaya`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `catID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `comID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `items`
--
ALTER TABLE `items`
  MODIFY `itemID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `mark`
--
ALTER TABLE `mark`
  MODIFY `markID` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `notifID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT pour la table `rating`
--
ALTER TABLE `rating`
  MODIFY `ratID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `reply`
--
ALTER TABLE `reply`
  MODIFY `repID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `subject`
--
ALTER TABLE `subject`
  MODIFY `subID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_item` FOREIGN KEY (`itemID`) REFERENCES `items` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `follower`
--
ALTER TABLE `follower`
  ADD CONSTRAINT `fk_follower` FOREIGN KEY (`followerID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userID` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_cat` FOREIGN KEY (`catID`) REFERENCES `category` (`catID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_itemLike` FOREIGN KEY (`itemID`) REFERENCES `items` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userLike` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_sender` FOREIGN KEY (`sender`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user1` FOREIGN KEY (`user1`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user2` FOREIGN KEY (`user2`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_concernedUser` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_triggerUser` FOREIGN KEY (`triggeur`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `fk_userRating` FOREIGN KEY (`user`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userTarget` FOREIGN KEY (`target`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `fk_subReplay` FOREIGN KEY (`subID`) REFERENCES `subject` (`subID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userReply` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `fk_userSub` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_likes`
--
ALTER TABLE `user_likes`
  ADD CONSTRAINT `fk_itemView` FOREIGN KEY (`itemID`) REFERENCES `items` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userView` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
