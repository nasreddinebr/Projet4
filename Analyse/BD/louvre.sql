-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost:80
-- Generation Time: Sep 24, 2017 at 06:49 PM
-- Server version: 5.5.57-0+deb8u1
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `louvre`
--

-- --------------------------------------------------------

--
-- Table structure for table `billets`
--

CREATE TABLE IF NOT EXISTS `billets` (
`id` int(11) NOT NULL,
  `paiment_id` int(11) NOT NULL,
  `numero_billet` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_resrvation` date NOT NULL,
  `prix_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
`id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `pays` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jours_fermeture`
--

CREATE TABLE IF NOT EXISTS `jours_fermeture` (
`id` int(11) NOT NULL,
  `jours_fermeture` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jours_fermeture`
--

INSERT INTO `jours_fermeture` (`id`, `jours_fermeture`) VALUES
(1, '01/05'),
(2, '01/11'),
(3, '25/12');

-- --------------------------------------------------------

--
-- Table structure for table `paiements`
--

CREATE TABLE IF NOT EXISTS `paiements` (
`id` int(11) NOT NULL,
  `date_paiement` datetime NOT NULL,
  `titulaire_carte` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_charge_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `somme_payee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

CREATE TABLE IF NOT EXISTS `produits` (
`id` int(11) NOT NULL,
  `nom_produit` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`id`, `nom_produit`) VALUES
(1, 'Journee'),
(2, 'Demi-journee');

-- --------------------------------------------------------

--
-- Table structure for table `tarifs`
--

CREATE TABLE IF NOT EXISTS `tarifs` (
`id` int(11) NOT NULL,
  `nom_tarif` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tarifs`
--

INSERT INTO `tarifs` (`id`, `nom_tarif`) VALUES
(1, 'normal'),
(2, 'enfant'),
(3, 'senior'),
(4, 'reduit');

-- --------------------------------------------------------

--
-- Table structure for table `tarif_produit`
--

CREATE TABLE IF NOT EXISTS `tarif_produit` (
`id` int(11) NOT NULL,
  `tarif_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `localisateur_prix` int(11) NOT NULL,
  `prixUnitaire` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tarif_produit`
--

INSERT INTO `tarif_produit` (`id`, `tarif_id`, `produit_id`, `localisateur_prix`, `prixUnitaire`) VALUES
(1, 1, 1, 131, 16.00),
(2, 1, 2, 132, 9.00),
(3, 2, 1, 121, 8.00),
(4, 2, 2, 122, 5.00),
(5, 3, 1, 601, 12.00),
(6, 3, 2, 602, 7.00),
(7, 4, 1, 101, 10.00),
(8, 4, 2, 102, 6.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billets`
--
ALTER TABLE `billets`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_4FCF9B6878789290` (`paiment_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_C82E7444973C78` (`billet_id`);

--
-- Indexes for table `jours_fermeture`
--
ALTER TABLE `jours_fermeture`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paiements`
--
ALTER TABLE `paiements`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produits`
--
ALTER TABLE `produits`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tarifs`
--
ALTER TABLE `tarifs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tarif_produit`
--
ALTER TABLE `tarif_produit`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_5AC49E623690902` (`localisateur_prix`), ADD KEY `IDX_5AC49E62357C0A59` (`tarif_id`), ADD KEY `IDX_5AC49E62F347EFB` (`produit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billets`
--
ALTER TABLE `billets`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jours_fermeture`
--
ALTER TABLE `jours_fermeture`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `paiements`
--
ALTER TABLE `paiements`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produits`
--
ALTER TABLE `produits`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tarifs`
--
ALTER TABLE `tarifs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tarif_produit`
--
ALTER TABLE `tarif_produit`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `billets`
--
ALTER TABLE `billets`
ADD CONSTRAINT `FK_4FCF9B6878789290` FOREIGN KEY (`paiment_id`) REFERENCES `paiements` (`id`);

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
ADD CONSTRAINT `FK_C82E7444973C78` FOREIGN KEY (`billet_id`) REFERENCES `billets` (`id`);

--
-- Constraints for table `tarif_produit`
--
ALTER TABLE `tarif_produit`
ADD CONSTRAINT `FK_5AC49E62357C0A59` FOREIGN KEY (`tarif_id`) REFERENCES `tarifs` (`id`),
ADD CONSTRAINT `FK_5AC49E62F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
