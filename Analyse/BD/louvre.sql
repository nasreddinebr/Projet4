-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost:80
-- Généré le :  Ven 20 Octobre 2017 à 11:55
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `billets`
--

INSERT INTO `billets` (`id`, `paiement_id`, `produit_id`, `numero_billet`, `date_resrvation`, `prix_total`) VALUES
(1, 1, 1, '201711Oct-1000', '2017-10-18', 12.00),
(2, 2, 1, '201711Oct-1001', '2017-10-18', 12.00),
(3, 3, 1, '201711Oct-1002', '2017-10-18', 12.00),
(4, 4, 1, '201711Oct-1003', '2017-10-19', 16.00),
(5, 5, 2, '201711Oct-1004', '2017-10-11', 6.00),
(6, 6, 1, '201713Oct-1005', '2017-10-19', 10.00),
(7, 7, 1, '201716Oct-1006', '2017-10-19', 16.00),
(8, 8, 1, '201719Oct-1007', '2017-10-26', 16.00),
(9, 9, 1, '201719Oct-1008', '2017-10-26', 16.00),
(10, 10, 1, '201719Oct-1009', '2017-10-26', 16.00),
(11, 11, 1, '201720Oct-1010', '2017-10-28', 8.00),
(12, 12, 1, '201720Oct-1011', '2017-10-27', 16.00);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`id`, `billet_id`, `tarif_id`, `nom`, `prenom`, `date_naissance`, `pays`, `tarifReduit`, `dateReservation`) VALUES
(1, 1, 3, 'test', 'test', '1897-01-01', 'AF', 0, '2017-10-18'),
(2, 2, 3, 'test', 'test', '1897-01-01', 'AF', 0, '2017-10-18'),
(3, 3, 3, 'trr', 'trr', '1897-01-01', 'AF', 0, '2017-10-18'),
(4, 4, 1, 'rrr', 'rrr', '1980-01-01', 'AF', 0, '2017-10-19'),
(5, 5, 4, 'tt', 'tt', '1997-01-01', 'AF', 1, '2017-10-11'),
(6, 6, 4, 'NASREDDINE', 'BERRACHED', '1897-01-01', 'AF', 1, '2017-10-19'),
(7, 7, 1, 'rtet', 'rtet', '1980-08-17', 'AF', 0, '2017-10-19'),
(8, 8, 1, 'test', 'test', '1987-10-21', 'AF', 0, '2017-10-26'),
(9, 9, 1, 'test', 'test', '1990-10-25', 'AF', 0, '2017-10-26'),
(10, 10, 1, 'ttt', 'ttt', '1985-10-09', 'AF', 0, '2017-10-26'),
(11, 11, 2, 'fgh', 'fgh', '2013-10-12', 'AF', 0, '2017-10-28'),
(12, 12, 1, 'nasreddine', 'test', '1992-10-22', 'AF', 0, '2017-10-27');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `paiements`
--

INSERT INTO `paiements` (`id`, `titulaire_carte`, `email`, `stripe_client_id`, `stripe_charge_id`, `somme_payee`) VALUES
(1, 'test', 'test@hotmail.fr', 'cli21548796363', 'user42515884555', 12.00),
(2, 'test', 'test@hotmail.fr', 'cli21548796363', 'user42515884555', 12.00),
(3, 'test', 'test@hotmail.fr', 'cli21548796363', 'user42515884555', 12.00),
(4, 'test', 'test@hotmail.fr', 'cli21548796363', 'user42515884555', 16.00),
(5, 'test', 'test@hotmail.fr', 'cli21548796363', 'user42515884555', 6.00),
(6, 'BERRACHED NASREDDINE', 'nasreddine.be@hotmail.fr', 'cli21548796363', 'user42515884555', 10.00),
(7, 'test', 'test@hotmail.fr', 'cli21548796363', 'user42515884555', 16.00),
(8, 'BERRACHED NASREDDINE', 'nasreddine.be@hotmail.fr', 'cli21548796363', 'user42515884555', 16.00),
(9, 'BERRACHED NASREDDINE', 'nasreddine.be@hotmail.fr', 'cli21548796363', 'user42515884555', 16.00),
(10, 'BERRACHED NASREDDINE', 'nasreddine.be@hotmail.fr', 'cli21548796363', 'user42515884555', 16.00),
(11, 'test', 'test@hotmail.fr', 'cus_BcAtRuuFNT2jvY', 'ch_1BEwXhGqcPu4aEB4Bl3wvFwN', 8.00),
(12, 'nasr test', 'nasreddine.be@hotmail.fr', 'cus_BcBUAuODBJl8gJ', 'ch_1BEx7FGqcPu4aEB4I9sK2c4P', 16.00);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
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
ADD CONSTRAINT `FK_4FCF9B682A4C4478` FOREIGN KEY (`paiement_id`) REFERENCES `paiements` (`id`),
ADD CONSTRAINT `FK_4FCF9B68F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);

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
