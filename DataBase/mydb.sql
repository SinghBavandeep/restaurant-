-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 13 déc. 2023 à 09:47
-- Version du serveur : 8.1.0
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mydb`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `IdAdmin` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(1000) NOT NULL,
  `Email` varchar(1000) NOT NULL,
  `Password` varchar(1000) NOT NULL,
  PRIMARY KEY (`IdAdmin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`IdAdmin`, `Nom`, `Email`, `Password`) VALUES
(1, 'admin', 'admin@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCategorie` int NOT NULL,
  `Nom` varchar(255) NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `Nom`) VALUES
(1, 'Entrée'),
(2, 'Plat principal'),
(3, 'Dessert'),
(5, 'Boisson');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `IdClient` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdClient`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`IdClient`, `Nom`, `Email`, `Password`) VALUES
(1, 'John Doe', 'john@example.com', 'password1'),
(2, 'Jane Smith', 'jane@example.com', 'password2'),
(3, 'Alice Johnson', 'alice@example.com', 'password3'),
(4, 'Bob Williams', 'bob@example.com', 'password4'),
(5, 'Eva Davis', 'eva@example.com', 'password5'),
(7, '', '', ''),
(8, '', '', ''),
(9, '', '', ''),
(10, 'ss', 'amira@example.com', '$2y$10$qWAlzED31j.bhKs9bjCCZOjSNIxlzTFCsnl8upRC6tTbVb8C7LP2C'),
(11, 'test', 'test@test.com', '$2y$10$08.jTpJ8LGZ/Kiv5UZ1i3OtcvbIpNhI6f7oph1jBaQsfdBila69me'),
(12, 'test', 'test@test.com', '$2y$10$y6zH.m74PqjDY0MD.raEkOcT3LxwuJAeXblxGICkoCrJZRd6ZA16i'),
(13, 'abrar', 'abrar@example.com', '$2y$10$sH0VGg.RLt86NhNZHjp8keZBZ9OZN9r0xWkCNG08juFu9ZDQF91Ki');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `idCommande` int NOT NULL AUTO_INCREMENT,
  `userEmail` varchar(255) DEFAULT NULL,
  `dateCommande` date DEFAULT NULL,
  `produit` varchar(2000) NOT NULL,
  PRIMARY KEY (`idCommande`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`idCommande`, `userEmail`, `dateCommande`, `produit`) VALUES
(1, 'amira@example.com', '2023-12-12', ''),
(2, 'amira@example.com', '2023-12-12', 'Pâtes Carbonara (Quantité: 1, Prix: 12.00), Burger Classique (Quantité: 1, Prix: 9.00), Salade César (Quantité: 1, Prix: 15.00)'),
(3, 'amira@example.com', '2023-12-12', 'Pâtes Carbonara (Quantité: 1, Prix: 13.00), Burger Classique (Quantité: 1, Prix: 10.00)'),
(4, 'amira@example.com', '2023-12-13', 'Pâtes Carbonara (Quantité: 1, Prix: 13.00), Pâtes Carbonara (Quantité: 10, Prix: 130.00)');

-- --------------------------------------------------------

--
-- Structure de la table `commande_has_plat`
--

DROP TABLE IF EXISTS `commande_has_plat`;
CREATE TABLE IF NOT EXISTS `commande_has_plat` (
  `Commande_idCommande` int NOT NULL,
  `Commande_Client_idClient` int NOT NULL,
  `Commande_Employe_idEmploye` int NOT NULL,
  `Commande_Table_IdTable` int NOT NULL,
  `Commande_Table_Facture_idFacture` int NOT NULL,
  `Commande_Table_Employe_idEmploye` int NOT NULL,
  `Plat_idPlat` int NOT NULL,
  `Plat_Categorie_idCategorie` int NOT NULL,
  PRIMARY KEY (`Commande_idCommande`,`Commande_Client_idClient`,`Commande_Employe_idEmploye`,`Commande_Table_IdTable`,`Commande_Table_Facture_idFacture`,`Commande_Table_Employe_idEmploye`,`Plat_idPlat`,`Plat_Categorie_idCategorie`),
  KEY `fk_Commande_has_Plat_Plat1_idx` (`Plat_idPlat`,`Plat_Categorie_idCategorie`),
  KEY `fk_Commande_has_Plat_Commande1_idx` (`Commande_idCommande`,`Commande_Client_idClient`,`Commande_Employe_idEmploye`,`Commande_Table_IdTable`,`Commande_Table_Facture_idFacture`,`Commande_Table_Employe_idEmploye`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

DROP TABLE IF EXISTS `employe`;
CREATE TABLE IF NOT EXISTS `employe` (
  `Idemploye` int NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Role` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Idemploye`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`Idemploye`, `Nom`, `Email`, `Password`, `Role`) VALUES
(1, 'amira', 'amira@example.com', 'password1', 'Chef'),
(2, 'Jane Smith', 'jane@example.com', 'password2', 'serveur'),
(3, 'Alice Johnson', 'alice@example.com', 'password3', 'livreur'),
(4, 'Bob Williams', 'bob@example.com', 'password4', 'co-chef'),
(5, 'Eva Davis', 'eva@example.com', 'password5', 'etudiants'),
(9, 'amira', 'ss@hotmail.com', 'test', 'TEST'),
(55512, 'r vrvcx', 'amira@example.com', 'test', 'Chef'),
(46512357, 'esfdb', 'ss@hotmail.com', '7465321', 'sdwxvc'),
(951321518, 'tes test', 'test@gmail.com', 'test', 'RRRS');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `idFacture` int NOT NULL,
  `Montant` float NOT NULL,
  `idTable` int NOT NULL,
  PRIMARY KEY (`idFacture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `idCart` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(1000) NOT NULL,
  `quantite` int NOT NULL,
  `totalprice` float(10,2) NOT NULL,
  PRIMARY KEY (`idCart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `plat`
--

DROP TABLE IF EXISTS `plat`;
CREATE TABLE IF NOT EXISTS `plat` (
  `idPlat` int NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `idCategorie` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `image` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`idPlat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `plat`
--

INSERT INTO `plat` (`idPlat`, `Nom`, `prix`, `idCategorie`, `image`, `description`) VALUES
(1, 'Pâtes Carbonara', '13.00', '2', 'carbonara.jpg', 'Spaghetti avec une sauce à la crème, du bacon et du parmesan.'),
(2, 'Burger Classique', '10.00', '2', 'burger.jpg', 'Steak de bœuf, fromage, laitue, tomate et oignons dans un pain moelleux.'),
(3, 'Salade César', '16.00', '1', 'cesar.jpg', 'Laitue romaine, croûtons, parmesan et vinaigrette césar.'),
(4, 'Pizza Margherita', '11.00', '2', 'margherita.jpg', 'Tomate, mozzarella, basilic sur une croûte fine.'),
(5, 'Saumon Grillé', '19.00', '2', 'saumon.jpg', 'Saumon grillé servi avec des légumes sautés.'),
(6, 'Risotto aux Champignons', '15.00', '2', 'risotto.jpg', 'Risotto crémeux avec des champignons sautés.'),
(7, 'Tacos au Poulet', '12.00', '2', 'tacos.jpg', 'Tortillas garnies de poulet grillé, salsa et guacamole.'),
(8, 'Gâteau au Chocolat', '9.00', '3', 'gateau.jpg', 'Moelleux au chocolat avec glaçage fondant.'),
(9, 'Sushi Assorti', '23.00', '2', 'sushi.jpg', 'Assortiment de sushis variés.'),
(10, 'Le millésime 1945', '482000.00', '5', 'le_millésime_1945.jpg', 'C\'est en 2018 que le millésime 1945 du domaine de la Romanée-Conti pulvérise les records.'),
(11, 'deepssalde', '9999.00', '1', 'cesar.jpg', 'la meilleur salade du monde');

-- --------------------------------------------------------

--
-- Structure de la table `table`
--

DROP TABLE IF EXISTS `table`;
CREATE TABLE IF NOT EXISTS `table` (
  `IdTable` int NOT NULL,
  `numeroTable` int NOT NULL,
  `capacite` int NOT NULL,
  `Facture_idFacture` int NOT NULL,
  `Employe_idEmploye` int NOT NULL,
  PRIMARY KEY (`IdTable`,`Facture_idFacture`,`Employe_idEmploye`),
  KEY `fk_Table_Facture1_idx` (`Facture_idFacture`),
  KEY `fk_Table_Employe1_idx` (`Employe_idEmploye`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `IdUser` int NOT NULL AUTO_INCREMENT,
  `role` varchar(200) NOT NULL,
  PRIMARY KEY (`IdUser`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`IdUser`, `role`) VALUES
(1, 'admin'),
(2, 'client'),
(3, 'employe');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `table`
--
ALTER TABLE `table`
  ADD CONSTRAINT `fk_Table_Facture1` FOREIGN KEY (`Facture_idFacture`) REFERENCES `facture` (`idFacture`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
