
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- marque
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `marque`;

CREATE TABLE `marque`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `marque` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `marque_u_9860e4` (`marque`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- modele
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `modele`;

CREATE TABLE `modele`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `modele` VARCHAR(100),
    `marque_FK` VARCHAR(100),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `modele_u_284f72` (`marque_FK`, `modele`),
    INDEX `i_referenced_appareil_fk_47db7e_1` (`modele`),
    CONSTRAINT `modele_fk_6c9792`
        FOREIGN KEY (`marque_FK`)
        REFERENCES `marque` (`marque`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- appareil
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `appareil`;

CREATE TABLE `appareil`
(
    `idAp` INTEGER NOT NULL AUTO_INCREMENT,
    `Immatriculation` VARCHAR(100),
    `nom_app` VARCHAR(100),
    `modele_PK` VARCHAR(100) NOT NULL,
    `marque_PK` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`idAp`,`modele_PK`,`marque_PK`),
    INDEX `appareil_fi_041995` (`marque_PK`),
    INDEX `appareil_fi_47db7e` (`modele_PK`),
    CONSTRAINT `appareil_fk_041995`
        FOREIGN KEY (`marque_PK`)
        REFERENCES `marque` (`marque`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `appareil_fk_47db7e`
        FOREIGN KEY (`modele_PK`)
        REFERENCES `modele` (`modele`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- typepiece
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `typepiece`;

CREATE TABLE `typepiece`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `type` VARCHAR(20),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `typepiece_u_319010` (`type`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- piece
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `piece`;

CREATE TABLE `piece`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `reference` VARCHAR(100),
    `type_FK` VARCHAR(100),
    `description` VARCHAR(100),
    `pn` VARCHAR(80),
    `alt_pn` VARCHAR(80),
    `otan` VARCHAR(80),
    `ispaperboard` TINYINT(1),
    `comment` TEXT,
    PRIMARY KEY (`id`),
    INDEX `piece_fi_c644ad` (`type_FK`),
    CONSTRAINT `piece_fk_c644ad`
        FOREIGN KEY (`type_FK`)
        REFERENCES `typepiece` (`type`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- piece_appareil
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `piece_appareil`;

CREATE TABLE `piece_appareil`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `idAp_PK` INTEGER,
    `id_piece_PK` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `piece_appareil_u_9a3fb7` (`idAp_PK`, `id_piece_PK`),
    INDEX `piece_appareil_fi_41f57d` (`id_piece_PK`),
    CONSTRAINT `piece_appareil_fk_237925`
        FOREIGN KEY (`idAp_PK`)
        REFERENCES `appareil` (`idAp`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `piece_appareil_fk_41f57d`
        FOREIGN KEY (`id_piece_PK`)
        REFERENCES `piece` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- photo_appareil
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `photo_appareil`;

CREATE TABLE `photo_appareil`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `url_photo` VARCHAR(200),
    `date_photo` DATETIME,
    `titre_photo` VARCHAR(100),
    `commentaire` TEXT,
    `idAp_PK` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `photo_appareil_fi_237925` (`idAp_PK`),
    CONSTRAINT `photo_appareil_fk_237925`
        FOREIGN KEY (`idAp_PK`)
        REFERENCES `appareil` (`idAp`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- societe
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `societe`;

CREATE TABLE `societe`
(
    `soc_id` INTEGER NOT NULL AUTO_INCREMENT,
    `societe` VARCHAR(80),
    `dirigeant` VARCHAR(80),
    `mail` VARCHAR(100),
    `website` VARCHAR(100),
    `tel` VARCHAR(25),
    `fax` VARCHAR(25),
    `adresse` VARCHAR(200),
    `cp` VARCHAR(20),
    `ville` VARCHAR(25),
    `pays` VARCHAR(25),
    `notes` TEXT,
    `notes_activite` TEXT,
    `scrRIB` VARCHAR(200),
    `fabricant` VARCHAR(100),
    `logo` VARCHAR(200),
    `fraude` TINYINT(1),
    `dte_maj_soc` DATETIME,
    `dte_maj_act` DATETIME,
    `dte_maj_gen` DATETIME,
    `actif` TINYINT(1),
    PRIMARY KEY (`soc_id`),
    UNIQUE INDEX `societe_u_f8e1f9` (`societe`),
    INDEX `societe_fi_eca8d2` (`pays`),
    INDEX `societe_fi_2c8b9c` (`fabricant`),
    CONSTRAINT `societe_fk_eca8d2`
        FOREIGN KEY (`pays`)
        REFERENCES `pays` (`pays`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `societe_fk_2c8b9c`
        FOREIGN KEY (`fabricant`)
        REFERENCES `marque` (`marque`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- partenaire
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `partenaire`;

CREATE TABLE `partenaire`
(
    `indx` INTEGER NOT NULL AUTO_INCREMENT,
    `partenaire` VARCHAR(80),
    `id_part` VARCHAR(80),
    `code` VARCHAR(80),
    `lien` VARCHAR(200),
    `mail` VARCHAR(100),
    `type_part` VARCHAR(80),
    PRIMARY KEY (`indx`),
    UNIQUE INDEX `partenaire_u_fb5a81` (`partenaire`, `type_part`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- annonceur
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `annonceur`;

CREATE TABLE `annonceur`
(
    `indx_part` INTEGER NOT NULL,
    `stock_en_ligne` TINYINT(1),
    PRIMARY KEY (`indx_part`),
    CONSTRAINT `annonceur_fk_16911e`
        FOREIGN KEY (`indx_part`)
        REFERENCES `partenaire` (`indx`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- finance_part
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `finance_part`;

CREATE TABLE `finance_part`
(
    `indx_part` INTEGER NOT NULL,
    `abonnement` TINYINT(1),
    `notes` TEXT,
    `dte_maj` DATETIME,
    `id_contact` INTEGER,
    PRIMARY KEY (`indx_part`),
    INDEX `finance_part_fi_db81d0` (`id_contact`),
    CONSTRAINT `finance_part_fk_16911e`
        FOREIGN KEY (`indx_part`)
        REFERENCES `partenaire` (`indx`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `finance_part_fk_db81d0`
        FOREIGN KEY (`id_contact`)
        REFERENCES `contact` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- infos_concerne_pays
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `infos_concerne_pays`;

CREATE TABLE `infos_concerne_pays`
(
    `indx_infos` INTEGER NOT NULL,
    `indx_pays` INTEGER NOT NULL,
    PRIMARY KEY (`indx_infos`,`indx_pays`),
    INDEX `infos_concerne_pays_fi_459795` (`indx_pays`),
    CONSTRAINT `infos_concerne_pays_fk_6f72fe`
        FOREIGN KEY (`indx_infos`)
        REFERENCES `finance_part` (`indx_part`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `infos_concerne_pays_fk_459795`
        FOREIGN KEY (`indx_pays`)
        REFERENCES `pays` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- base_infos
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `base_infos`;

CREATE TABLE `base_infos`
(
    `indx` INTEGER NOT NULL AUTO_INCREMENT,
    `type_infos` VARCHAR(80),
    `usage` VARCHAR(80),
    PRIMARY KEY (`indx`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- soc_part
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `soc_part`;

CREATE TABLE `soc_part`
(
    `soc_fraude` INTEGER NOT NULL,
    `plaig_part` INTEGER,
    `plaig_soc` INTEGER,
    `plaignant` VARCHAR(80),
    `dte_plainte` DATETIME,
    PRIMARY KEY (`soc_fraude`),
    INDEX `soc_part_fi_b3e6c0` (`plaig_part`),
    INDEX `soc_part_fi_278a6e` (`plaig_soc`),
    CONSTRAINT `soc_part_fk_b3e6c0`
        FOREIGN KEY (`plaig_part`)
        REFERENCES `partenaire` (`indx`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `soc_part_fk_1bca9d`
        FOREIGN KEY (`soc_fraude`)
        REFERENCES `societe` (`soc_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `soc_part_fk_278a6e`
        FOREIGN KEY (`plaig_soc`)
        REFERENCES `societe` (`soc_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- base_part
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `base_part`;

CREATE TABLE `base_part`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `disponible` TINYINT(1),
    `indx_base` INTEGER,
    `indx_part` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `base_part_fi_16911e` (`indx_part`),
    INDEX `base_part_fi_ccdd8c` (`indx_base`),
    CONSTRAINT `base_part_fk_16911e`
        FOREIGN KEY (`indx_part`)
        REFERENCES `partenaire` (`indx`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `base_part_fk_ccdd8c`
        FOREIGN KEY (`indx_base`)
        REFERENCES `base_infos` (`indx`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- pays
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `pays`;

CREATE TABLE `pays`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `pays` VARCHAR(80),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `pays_u_1c0cc8` (`pays`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- centre_mro
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `centre_mro`;

CREATE TABLE `centre_mro`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `societe_FK` VARCHAR(80),
    `mro` VARCHAR(80),
    `actif` TINYINT(1),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `centre_mro_u_d718a6` (`mro`, `societe_FK`),
    INDEX `centre_mro_fi_f06e61` (`societe_FK`),
    CONSTRAINT `centre_mro_fk_f06e61`
        FOREIGN KEY (`societe_FK`)
        REFERENCES `societe` (`societe`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `centre_mro_fk_5822cd`
        FOREIGN KEY (`mro`)
        REFERENCES `societe` (`societe`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cond
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cond`;

CREATE TABLE `cond`
(
    `cond` VARCHAR(25) NOT NULL,
    `commentaire` VARCHAR(255),
    PRIMARY KEY (`cond`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- transport
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `transport`;

CREATE TABLE `transport`
(
    `transport` VARCHAR(25) NOT NULL,
    `commentaire` VARCHAR(255),
    PRIMARY KEY (`transport`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- fournisseur
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fournisseur`;

CREATE TABLE `fournisseur`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `quantite` INTEGER,
    `prix_achat` VARCHAR(25),
    `prix_vente` VARCHAR(25),
    `date_enreg` DATETIME,
    `production` TINYINT(1),
    `delai` VARCHAR(15),
    `id_piece_FK` INTEGER,
    `condition_FK` VARCHAR(10),
    `transport_FK` VARCHAR(25),
    `soc_id_FK` INTEGER,
    `annee_fab` VARCHAR(10),
    `tmp_rest` VARCHAR(10),
    `tmp_total` VARCHAR(10),
    `duree_vie` VARCHAR(10),
    `old_app` VARCHAR(80),
    `new_app` VARCHAR(80),
    `nbr_oh` VARCHAR(10),
    `note` TEXT,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fournisseur_u_011c3c` (`soc_id_FK`, `id_piece_FK`, `date_enreg`),
    INDEX `fournisseur_fi_c677b2` (`id_piece_FK`),
    INDEX `fournisseur_fi_0e9203` (`condition_FK`),
    INDEX `fournisseur_fi_9c2971` (`transport_FK`),
    CONSTRAINT `fournisseur_fk_c677b2`
        FOREIGN KEY (`id_piece_FK`)
        REFERENCES `piece` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `fournisseur_fk_9b0af3`
        FOREIGN KEY (`soc_id_FK`)
        REFERENCES `societe` (`soc_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `fournisseur_fk_0e9203`
        FOREIGN KEY (`condition_FK`)
        REFERENCES `cond` (`cond`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `fournisseur_fk_9c2971`
        FOREIGN KEY (`transport_FK`)
        REFERENCES `transport` (`transport`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- commande
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `commande`;

CREATE TABLE `commande`
(
    `id_commande` INTEGER NOT NULL AUTO_INCREMENT,
    `reference` VARCHAR(25),
    `soc_id_FK` INTEGER,
    `transport_FK` VARCHAR(25),
    `quantite` INTEGER,
    `prix` VARCHAR(25),
    `delai` DECIMAL,
    `dte_commande` DATETIME,
    `priorite` DECIMAL,
    `note` TEXT,
    PRIMARY KEY (`id_commande`),
    UNIQUE INDEX `commande_u_fd6b1f` (`soc_id_FK`, `dte_commande`, `reference`),
    INDEX `commande_fi_9c2971` (`transport_FK`),
    CONSTRAINT `commande_fk_9b0af3`
        FOREIGN KEY (`soc_id_FK`)
        REFERENCES `societe` (`soc_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `commande_fk_9c2971`
        FOREIGN KEY (`transport_FK`)
        REFERENCES `transport` (`transport`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- commande_condition
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `commande_condition`;

CREATE TABLE `commande_condition`
(
    `id_commande_FK` INTEGER NOT NULL,
    `condition_FK` VARCHAR(25) NOT NULL,
    `id_piece_FK` INTEGER NOT NULL,
    PRIMARY KEY (`id_commande_FK`,`condition_FK`,`id_piece_FK`),
    INDEX `commande_condition_fi_c677b2` (`id_piece_FK`),
    INDEX `commande_condition_fi_0e9203` (`condition_FK`),
    CONSTRAINT `commande_condition_fk_5b99a8`
        FOREIGN KEY (`id_commande_FK`)
        REFERENCES `commande` (`id_commande`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `commande_condition_fk_c677b2`
        FOREIGN KEY (`id_piece_FK`)
        REFERENCES `piece` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `commande_condition_fk_0e9203`
        FOREIGN KEY (`condition_FK`)
        REFERENCES `cond` (`cond`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- vendeur
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `vendeur`;

CREATE TABLE `vendeur`
(
    `id_vte` INTEGER NOT NULL AUTO_INCREMENT,
    `id_commande_FK` INTEGER,
    `id_piece_FK` INTEGER,
    `frs_id` INTEGER,
    `mo` VARCHAR(25),
    `note` TEXT,
    `dte_propos` DATETIME,
    PRIMARY KEY (`id_vte`),
    UNIQUE INDEX `vendeur_u_617cc2` (`id_commande_FK`, `id_piece_FK`, `frs_id`),
    INDEX `vendeur_fi_17d501` (`frs_id`),
    INDEX `vendeur_fi_c677b2` (`id_piece_FK`),
    CONSTRAINT `vendeur_fk_5b99a8`
        FOREIGN KEY (`id_commande_FK`)
        REFERENCES `commande` (`id_commande`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `vendeur_fk_17d501`
        FOREIGN KEY (`frs_id`)
        REFERENCES `fournisseur` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `vendeur_fk_c677b2`
        FOREIGN KEY (`id_piece_FK`)
        REFERENCES `piece` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- piece_cmd
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `piece_cmd`;

CREATE TABLE `piece_cmd`
(
    `id_commande_FK` INTEGER NOT NULL,
    `pc_id` INTEGER NOT NULL,
    `pn_clt` VARCHAR(80),
    `quantite` INTEGER,
    `prix_clt` VARCHAR(25),
    `note_pce` TEXT,
    `delai` DECIMAL,
    `dte_propos` DATETIME,
    PRIMARY KEY (`id_commande_FK`,`pc_id`),
    INDEX `piece_cmd_fi_d786a3` (`pc_id`),
    CONSTRAINT `piece_cmd_fk_5b99a8`
        FOREIGN KEY (`id_commande_FK`)
        REFERENCES `commande` (`id_commande`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `piece_cmd_fk_d786a3`
        FOREIGN KEY (`pc_id`)
        REFERENCES `piece` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- enduser
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `enduser`;

CREATE TABLE `enduser`
(
    `id_end_user` INTEGER NOT NULL AUTO_INCREMENT,
    `nameuser` VARCHAR(80),
    `adresses` VARCHAR(255),
    PRIMARY KEY (`id_end_user`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- commande_enduser
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `commande_enduser`;

CREATE TABLE `commande_enduser`
(
    `id_commande_FK` INTEGER NOT NULL,
    `id_end_user_FK` INTEGER NOT NULL,
    `id_piece_FK` INTEGER NOT NULL,
    PRIMARY KEY (`id_commande_FK`,`id_end_user_FK`,`id_piece_FK`),
    INDEX `commande_enduser_fi_c677b2` (`id_piece_FK`),
    INDEX `commande_enduser_fi_e05785` (`id_end_user_FK`),
    CONSTRAINT `commande_enduser_fk_5b99a8`
        FOREIGN KEY (`id_commande_FK`)
        REFERENCES `commande` (`id_commande`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `commande_enduser_fk_c677b2`
        FOREIGN KEY (`id_piece_FK`)
        REFERENCES `piece` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `commande_enduser_fk_e05785`
        FOREIGN KEY (`id_end_user_FK`)
        REFERENCES `enduser` (`id_end_user`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- typedoc
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `typedoc`;

CREATE TABLE `typedoc`
(
    `type` VARCHAR(25) NOT NULL,
    `comment` VARCHAR(255),
    PRIMARY KEY (`type`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cmd_doc
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cmd_doc`;

CREATE TABLE `cmd_doc`
(
    `type_doc_FK` VARCHAR(25) NOT NULL,
    `id_commande_FK` INTEGER NOT NULL,
    PRIMARY KEY (`type_doc_FK`,`id_commande_FK`),
    INDEX `cmd_doc_fi_5b99a8` (`id_commande_FK`),
    CONSTRAINT `cmd_doc_fk_5b99a8`
        FOREIGN KEY (`id_commande_FK`)
        REFERENCES `commande` (`id_commande`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `cmd_doc_fk_56d426`
        FOREIGN KEY (`type_doc_FK`)
        REFERENCES `typedoc` (`type`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cmd_app
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cmd_app`;

CREATE TABLE `cmd_app`
(
    `idAp_FK` INTEGER NOT NULL,
    `id_commande_FK` INTEGER NOT NULL,
    `id_piece_FK` INTEGER NOT NULL,
    PRIMARY KEY (`idAp_FK`,`id_commande_FK`,`id_piece_FK`),
    INDEX `cmd_app_fi_5b99a8` (`id_commande_FK`),
    INDEX `cmd_app_fi_c677b2` (`id_piece_FK`),
    CONSTRAINT `cmd_app_fk_5b99a8`
        FOREIGN KEY (`id_commande_FK`)
        REFERENCES `commande` (`id_commande`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `cmd_app_fk_c677b2`
        FOREIGN KEY (`id_piece_FK`)
        REFERENCES `piece` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `cmd_app_fk_90f6ca`
        FOREIGN KEY (`idAp_FK`)
        REFERENCES `appareil` (`idAp`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- societe_app
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `societe_app`;

CREATE TABLE `societe_app`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `societe_FK` VARCHAR(80),
    `idAp_FK` INTEGER,
    `flotte` TINYINT(1),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `societe_app_u_584d61` (`idAp_FK`, `societe_FK`),
    INDEX `societe_app_fi_f06e61` (`societe_FK`),
    CONSTRAINT `societe_app_fk_f06e61`
        FOREIGN KEY (`societe_FK`)
        REFERENCES `societe` (`societe`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `societe_app_fk_90f6ca`
        FOREIGN KEY (`idAp_FK`)
        REFERENCES `appareil` (`idAp`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- contact
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `contact`;

CREATE TABLE `contact`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(80),
    `fonction` VARCHAR(80),
    `telephone` VARCHAR(25),
    `mail` VARCHAR(80),
    `ordre` INTEGER(5),
    `note` TEXT,
    `societe_FK` VARCHAR(80),
    PRIMARY KEY (`id`),
    INDEX `contact_fi_f06e61` (`societe_FK`),
    CONSTRAINT `contact_fk_f06e61`
        FOREIGN KEY (`societe_FK`)
        REFERENCES `societe` (`societe`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- certificat
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `certificat`;

CREATE TABLE `certificat`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `agrement` VARCHAR(25),
    `srcweb` VARCHAR(100),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `certificat_u_b0bed6` (`agrement`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- appcertificat
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `appcertificat`;

CREATE TABLE `appcertificat`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `idAp_PK` INTEGER,
    `agrement_PK` VARCHAR(25),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `appcertificat_u_8b1df7` (`idAp_PK`, `agrement_PK`),
    INDEX `appcertificat_fi_1115e9` (`agrement_PK`),
    CONSTRAINT `appcertificat_fk_237925`
        FOREIGN KEY (`idAp_PK`)
        REFERENCES `appareil` (`idAp`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `appcertificat_fk_1115e9`
        FOREIGN KEY (`agrement_PK`)
        REFERENCES `certificat` (`agrement`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- soccertificat
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `soccertificat`;

CREATE TABLE `soccertificat`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `societe_PK` VARCHAR(80),
    `agrement_PK` VARCHAR(25),
    `idAp_PK` INTEGER,
    `isMRO` TINYINT(1),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `soccertificat_u_eb238c` (`societe_PK`, `agrement_PK`, `IdAp_PK`),
    INDEX `soccertificat_fi_1115e9` (`agrement_PK`),
    INDEX `soccertificat_fi_237925` (`idAp_PK`),
    CONSTRAINT `soccertificat_fk_83645d`
        FOREIGN KEY (`societe_PK`)
        REFERENCES `societe` (`societe`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `soccertificat_fk_1115e9`
        FOREIGN KEY (`agrement_PK`)
        REFERENCES `certificat` (`agrement`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `soccertificat_fk_237925`
        FOREIGN KEY (`idAp_PK`)
        REFERENCES `appareil` (`idAp`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- socmetier
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `socmetier`;

CREATE TABLE `socmetier`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `societe_PK` VARCHAR(80),
    `metier_PK` VARCHAR(80),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `socmetier_u_b8b2ee` (`societe_PK`, `metier_PK`),
    INDEX `socmetier_fi_ef5604` (`metier_PK`),
    CONSTRAINT `socmetier_fk_83645d`
        FOREIGN KEY (`societe_PK`)
        REFERENCES `societe` (`societe`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `socmetier_fk_ef5604`
        FOREIGN KEY (`metier_PK`)
        REFERENCES `metier` (`metier`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- soctypepiece
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `soctypepiece`;

CREATE TABLE `soctypepiece`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `societe_PK` VARCHAR(80),
    `type_PK` VARCHAR(20),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `soctypepiece_u_1b668a` (`societe_PK`, `type_PK`),
    INDEX `soctypepiece_fi_1fc46f` (`type_PK`),
    CONSTRAINT `soctypepiece_fk_83645d`
        FOREIGN KEY (`societe_PK`)
        REFERENCES `societe` (`societe`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `soctypepiece_fk_1fc46f`
        FOREIGN KEY (`type_PK`)
        REFERENCES `typepiece` (`type`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sochistorique
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sochistorique`;

CREATE TABLE `sochistorique`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `societe_PK` VARCHAR(80),
    `historique_PK` VARCHAR(80),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `sochistorique_u_ffa740` (`historique_PK`, `societe_PK`),
    INDEX `sochistorique_fi_83645d` (`societe_PK`),
    CONSTRAINT `sochistorique_fk_83645d`
        FOREIGN KEY (`societe_PK`)
        REFERENCES `societe` (`societe`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `sochistorique_fk_88d3c8`
        FOREIGN KEY (`historique_PK`)
        REFERENCES `historique` (`historique`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- document
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `document`;

CREATE TABLE `document`
(
    `doc_num` INTEGER NOT NULL AUTO_INCREMENT,
    `doc_lien` VARCHAR(100),
    `doc_name` VARCHAR(100),
    `id_fournisseur_FK` INTEGER,
    `date_enreg_FK` DATETIME,
    PRIMARY KEY (`doc_num`),
    INDEX `document_fi_6519aa` (`id_fournisseur_FK`),
    CONSTRAINT `document_fk_6519aa`
        FOREIGN KEY (`id_fournisseur_FK`)
        REFERENCES `fournisseur` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- photo_piece
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `photo_piece`;

CREATE TABLE `photo_piece`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `url_photo` VARCHAR(200),
    `date_photo` DATETIME,
    `titre_photo` VARCHAR(100),
    `commentaire` TEXT,
    `id_fournisseur_FK` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `photo_piece_fi_6519aa` (`id_fournisseur_FK`),
    CONSTRAINT `photo_piece_fk_6519aa`
        FOREIGN KEY (`id_fournisseur_FK`)
        REFERENCES `fournisseur` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- stock
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock`
(
    `stock_id` INTEGER NOT NULL AUTO_INCREMENT,
    `date_depart` DATETIME,
    `id_piece_FK` INTEGER,
    PRIMARY KEY (`stock_id`),
    INDEX `stock_fi_c677b2` (`id_piece_FK`),
    CONSTRAINT `stock_fk_c677b2`
        FOREIGN KEY (`id_piece_FK`)
        REFERENCES `piece` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- employe
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `employe`;

CREATE TABLE `employe`
(
    `id_emp` VARCHAR(25) NOT NULL,
    `nom` VARCHAR(100),
    `prenom` VARCHAR(100),
    `adresses` VARCHAR(200),
    `cp` INTEGER,
    `fonction` VARCHAR(100),
    `telephone` VARCHAR(100),
    `email` VARCHAR(100),
    `passe` VARCHAR(200),
    `acces` CHAR,
    `avatard` VARCHAR(200),
    `etat` TINYINT(1),
    PRIMARY KEY (`id_emp`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- session
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `session`;

CREATE TABLE `session`
(
    `IDS` INTEGER NOT NULL AUTO_INCREMENT,
    `date_connexion` DATETIME,
    `id_emp_FK` VARCHAR(25),
    PRIMARY KEY (`IDS`),
    INDEX `session_fi_c4d58e` (`id_emp_FK`),
    CONSTRAINT `session_fk_c4d58e`
        FOREIGN KEY (`id_emp_FK`)
        REFERENCES `employe` (`id_emp`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cv
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cv`;

CREATE TABLE `cv`
(
    `cv_num` INTEGER NOT NULL AUTO_INCREMENT,
    `id_emp_FK` VARCHAR(25),
    `cv_url` VARCHAR(200),
    PRIMARY KEY (`cv_num`),
    INDEX `cv_fi_c4d58e` (`id_emp_FK`),
    CONSTRAINT `cv_fk_c4d58e`
        FOREIGN KEY (`id_emp_FK`)
        REFERENCES `employe` (`id_emp`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- infos_box
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `infos_box`;

CREATE TABLE `infos_box`
(
    `ibox_id` INTEGER NOT NULL AUTO_INCREMENT,
    `titre` VARCHAR(200),
    `logo` VARCHAR(200),
    `slogan` VARCHAR(200),
    `telephone` VARCHAR(15),
    `mail` VARCHAR(100),
    `num_rue` VARCHAR(5),
    `nom_rue` VARCHAR(100),
    `cp` VARCHAR(5),
    `ville` VARCHAR(40),
    `txt_slider` VARCHAR(255),
    PRIMARY KEY (`ibox_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rubrique
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rubrique`;

CREATE TABLE `rubrique`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `rubrique` VARCHAR(80),
    `url` VARCHAR(200),
    `Niveau` VARCHAR(200),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `rubrique_u_e1e26e` (`rubrique`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rubrique_primaire
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rubrique_primaire`;

CREATE TABLE `rubrique_primaire`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `rubrique_primaire` VARCHAR(80),
    `rubrique_FK` VARCHAR(80),
    `url` VARCHAR(200),
    PRIMARY KEY (`id`),
    INDEX `rubrique_primaire_fi_f4564a` (`rubrique_FK`),
    CONSTRAINT `rubrique_primaire_fk_f4564a`
        FOREIGN KEY (`rubrique_FK`)
        REFERENCES `rubrique` (`rubrique`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rubrique_secondaire
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rubrique_secondaire`;

CREATE TABLE `rubrique_secondaire`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `rubrique_secondaire` VARCHAR(80),
    `rubrique_FK` VARCHAR(80),
    `url` VARCHAR(200),
    PRIMARY KEY (`id`),
    INDEX `rubrique_secondaire_fi_f4564a` (`rubrique_FK`),
    CONSTRAINT `rubrique_secondaire_fk_f4564a`
        FOREIGN KEY (`rubrique_FK`)
        REFERENCES `rubrique` (`rubrique`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- metier
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `metier`;

CREATE TABLE `metier`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `metier` VARCHAR(80),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `metier_u_355992` (`metier`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- historique
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `historique`;

CREATE TABLE `historique`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `historique` VARCHAR(80),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `historique_u_8caca5` (`historique`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- financiere
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `financiere`;

CREATE TABLE `financiere`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `immatricule` VARCHAR(20),
    `societe_FK` VARCHAR(80),
    `capital` DOUBLE,
    `form` VARCHAR(80),
    `dte_creation` DATETIME,
    `notes` TEXT,
    `dte_maj` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `financiere_fi_f06e61` (`societe_FK`),
    CONSTRAINT `financiere_fk_f06e61`
        FOREIGN KEY (`societe_FK`)
        REFERENCES `societe` (`societe`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- chiffreaffaire
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `chiffreaffaire`;

CREATE TABLE `chiffreaffaire`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `annee` INTEGER(4),
    `ca` DOUBLE,
    `nbremp` INTEGER,
    `filiale` TINYINT(1),
    `societe_FK` VARCHAR(80),
    PRIMARY KEY (`id`),
    INDEX `chiffreaffaire_fi_f06e61` (`societe_FK`),
    CONSTRAINT `chiffreaffaire_fk_f06e61`
        FOREIGN KEY (`societe_FK`)
        REFERENCES `societe` (`societe`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sourceweb
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sourceweb`;

CREATE TABLE `sourceweb`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `descr` VARCHAR(200),
    `scr` VARCHAR(200),
    `societe_FK` VARCHAR(80),
    PRIMARY KEY (`id`),
    INDEX `sourceweb_fi_f06e61` (`societe_FK`),
    CONSTRAINT `sourceweb_fk_f06e61`
        FOREIGN KEY (`societe_FK`)
        REFERENCES `societe` (`societe`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- tbindex
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tbindex`;

CREATE TABLE `tbindex`
(
    `indx` INTEGER NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`indx`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
