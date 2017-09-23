-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 23 Septembre 2017 à 16:03
-- Version du serveur :  5.5.57-0+deb8u1
-- Version de PHP :  5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `louvre`
--

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

CREATE TABLE IF NOT EXISTS `billets` (
`id` int(11) NOT NULL,
  `numero_billet` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_resrvation` date NOT NULL,
  `prix_total` decimal(10,2) NOT NULL,
  `paiment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
`id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `pays` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jours_fermeture`
--

CREATE TABLE IF NOT EXISTS `jours_fermeture` (
`id` int(11) NOT NULL,
  `jours_fermeture` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
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
-- Structure de la table `produits`
--

CREATE TABLE IF NOT EXISTS `produits` (
`id` int(11) NOT NULL,
  `nom_produit` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tarifs`
--

CREATE TABLE IF NOT EXISTS `tarifs` (
`id` int(11) NOT NULL,
  `nom_tarif` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tarif_produit`
--

CREATE TABLE IF NOT EXISTS `tarif_produit` (
`id` int(11) NOT NULL,
  `tarif_id` int(11) NOT NULL,
  `prixUnitaire` decimal(10,2) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `localisateur_prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `billets`
--
ALTER TABLE `billets`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_4FCF9B6878789290` (`paiment_id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_C82E7444973C78` (`billet_id`);

--
-- Index pour la table `jours_fermeture`
--
ALTER TABLE `jours_fermeture`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tarifs`
--
ALTER TABLE `tarifs`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tarif_produit`
--
ALTER TABLE `tarif_produit`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_5AC49E623690902` (`localisateur_prix`), ADD KEY `IDX_5AC49E62357C0A59` (`tarif_id`), ADD KEY `IDX_5AC49E62F347EFB` (`produit_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `billets`
--
ALTER TABLE `billets`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `jours_fermeture`
--
ALTER TABLE `jours_fermeture`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tarifs`
--
ALTER TABLE `tarifs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tarif_produit`
--
ALTER TABLE `tarif_produit`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `billets`
--
ALTER TABLE `billets`
ADD CONSTRAINT `FK_4FCF9B6878789290` FOREIGN KEY (`paiment_id`) REFERENCES `paiements` (`id`);

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
ADD CONSTRAINT `FK_C82E7444973C78` FOREIGN KEY (`billet_id`) REFERENCES `billets` (`id`);

--
-- Contraintes pour la table `tarif_produit`
--
ALTER TABLE `tarif_produit`
ADD CONSTRAINT `FK_5AC49E62F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`),
ADD CONSTRAINT `FK_5AC49E62357C0A59` FOREIGN KEY (`tarif_id`) REFERENCES `tarifs` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
