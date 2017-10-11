-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost:80
-- Généré le :  Mer 11 Octobre 2017 à 15:33
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
  `paiement_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `numero_billet` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_resrvation` date NOT NULL,
  `prix_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
`id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL,
  `tarif_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `pays` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tarifReduit` tinyint(1) DEFAULT NULL,
  `dateReservation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formCollection`
--

CREATE TABLE IF NOT EXISTS `formCollection` (
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `form_collection_billets`
--

CREATE TABLE IF NOT EXISTS `form_collection_billets` (
  `form_collection_id` int(11) NOT NULL,
  `billets_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `form_collection_clients`
--

CREATE TABLE IF NOT EXISTS `form_collection_clients` (
  `form_collection_id` int(11) NOT NULL,
  `clients_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jours_fermeture`
--

CREATE TABLE IF NOT EXISTS `jours_fermeture` (
`id` int(11) NOT NULL,
  `jours_fermeture` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `jours_fermeture`
--

INSERT INTO `jours_fermeture` (`id`, `jours_fermeture`) VALUES
(1, '1/5'),
(2, '1/11'),
(3, '25/12');

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE IF NOT EXISTS `paiements` (
`id` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `produits`
--

INSERT INTO `produits` (`id`, `nom_produit`) VALUES
(1, 'Journee'),
(2, 'Demi-journee');

-- --------------------------------------------------------

--
-- Structure de la table `tarifs`
--

CREATE TABLE IF NOT EXISTS `tarifs` (
`id` int(11) NOT NULL,
  `nom_tarif` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `localisateur_tarif` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `tarifs`
--

INSERT INTO `tarifs` (`id`, `nom_tarif`, `localisateur_tarif`) VALUES
(1, 'normal', 13),
(2, 'enfant', 12),
(3, 'senior', 60),
(4, 'reduit', 5);

-- --------------------------------------------------------

--
-- Structure de la table `tarif_produit`
--

CREATE TABLE IF NOT EXISTS `tarif_produit` (
`id` int(11) NOT NULL,
  `tarif_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `prixUnitaire` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `tarif_produit`
--

INSERT INTO `tarif_produit` (`id`, `tarif_id`, `produit_id`, `prixUnitaire`) VALUES
(1, 1, 1, 16.00),
(2, 1, 2, 9.00),
(3, 2, 1, 8.00),
(4, 2, 2, 5.00),
(5, 3, 1, 12.00),
(6, 3, 2, 7.00),
(7, 4, 1, 10.00),
(8, 4, 2, 6.00);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `billets`
--
ALTER TABLE `billets`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_4FCF9B682A4C4478` (`paiement_id`), ADD KEY `IDX_4FCF9B68F347EFB` (`produit_id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_C82E7444973C78` (`billet_id`), ADD KEY `IDX_C82E74357C0A59` (`tarif_id`);

--
-- Index pour la table `formCollection`
--
ALTER TABLE `formCollection`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `form_collection_billets`
--
ALTER TABLE `form_collection_billets`
 ADD PRIMARY KEY (`form_collection_id`,`billets_id`), ADD KEY `IDX_327F00C2F29F11C2` (`form_collection_id`), ADD KEY `IDX_327F00C2B9EBD317` (`billets_id`);

--
-- Index pour la table `form_collection_clients`
--
ALTER TABLE `form_collection_clients`
 ADD PRIMARY KEY (`form_collection_id`,`clients_id`), ADD KEY `IDX_7D78B5DEF29F11C2` (`form_collection_id`), ADD KEY `IDX_7D78B5DEAB014612` (`clients_id`);

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
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_F9B8C4966C5812F5` (`localisateur_tarif`);

--
-- Index pour la table `tarif_produit`
--
ALTER TABLE `tarif_produit`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_5AC49E62357C0A59` (`tarif_id`), ADD KEY `IDX_5AC49E62F347EFB` (`produit_id`);

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
-- AUTO_INCREMENT pour la table `formCollection`
--
ALTER TABLE `formCollection`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `jours_fermeture`
--
ALTER TABLE `jours_fermeture`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `tarifs`
--
ALTER TABLE `tarifs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `tarif_produit`
--
ALTER TABLE `tarif_produit`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `billets`
--
ALTER TABLE `billets`
ADD CONSTRAINT `FK_4FCF9B68F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`),
ADD CONSTRAINT `FK_4FCF9B682A4C4478` FOREIGN KEY (`paiement_id`) REFERENCES `paiements` (`id`);

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
ADD CONSTRAINT `FK_C82E74357C0A59` FOREIGN KEY (`tarif_id`) REFERENCES `tarifs` (`id`),
ADD CONSTRAINT `FK_C82E7444973C78` FOREIGN KEY (`billet_id`) REFERENCES `billets` (`id`);

--
-- Contraintes pour la table `form_collection_billets`
--
ALTER TABLE `form_collection_billets`
ADD CONSTRAINT `FK_327F00C2B9EBD317` FOREIGN KEY (`billets_id`) REFERENCES `billets` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `FK_327F00C2F29F11C2` FOREIGN KEY (`form_collection_id`) REFERENCES `formCollection` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `form_collection_clients`
--
ALTER TABLE `form_collection_clients`
ADD CONSTRAINT `FK_7D78B5DEAB014612` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `FK_7D78B5DEF29F11C2` FOREIGN KEY (`form_collection_id`) REFERENCES `formCollection` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tarif_produit`
--
ALTER TABLE `tarif_produit`
ADD CONSTRAINT `FK_5AC49E62357C0A59` FOREIGN KEY (`tarif_id`) REFERENCES `tarifs` (`id`),
ADD CONSTRAINT `FK_5AC49E62F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
