
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
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `idAp` VARCHAR(100),
    `nom_app` VARCHAR(100),
    `modele_PK` VARCHAR(100) NOT NULL,
    `marque_PK` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`,`modele_PK`,`marque_PK`),
    UNIQUE INDEX `appareil_u_69861a` (`idAp`),
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
-- piece
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `piece`;

CREATE TABLE `piece`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `reference` VARCHAR(100) NOT NULL,
    `description` VARCHAR(100),
    PRIMARY KEY (`id`,`reference`),
    UNIQUE INDEX `piece_u_d6e8ac` (`reference`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- piece_appareil
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `piece_appareil`;

CREATE TABLE `piece_appareil`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `idAp_PK` VARCHAR(100),
    `modele_PK` VARCHAR(100),
    `marque_PK` VARCHAR(100),
    `reference_PK` VARCHAR(100),
    PRIMARY KEY (`id`),
    INDEX `piece_appareil_fi_237925` (`idAp_PK`),
    INDEX `piece_appareil_fi_47db7e` (`modele_PK`),
    INDEX `piece_appareil_fi_041995` (`marque_PK`),
    INDEX `piece_appareil_fi_7cbc63` (`reference_PK`),
    CONSTRAINT `piece_appareil_fk_237925`
        FOREIGN KEY (`idAp_PK`)
        REFERENCES `appareil` (`idAp`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `piece_appareil_fk_47db7e`
        FOREIGN KEY (`modele_PK`)
        REFERENCES `modele` (`modele`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `piece_appareil_fk_041995`
        FOREIGN KEY (`marque_PK`)
        REFERENCES `marque` (`marque`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `piece_appareil_fk_7cbc63`
        FOREIGN KEY (`reference_PK`)
        REFERENCES `piece` (`reference`)
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
    `reference_FK` VARCHAR(100),
    PRIMARY KEY (`id`),
    INDEX `photo_piece_fi_0675ba` (`reference_FK`),
    CONSTRAINT `photo_piece_fk_0675ba`
        FOREIGN KEY (`reference_FK`)
        REFERENCES `piece` (`reference`)
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
    `etat` TINYINT(1),
    `idAp_PK` VARCHAR(100) NOT NULL,
    `modele_PK` VARCHAR(100) NOT NULL,
    `marque_PK` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`,`idAp_PK`,`modele_PK`,`marque_PK`),
    INDEX `photo_appareil_fi_237925` (`idAp_PK`),
    INDEX `photo_appareil_fi_47db7e` (`modele_PK`),
    INDEX `photo_appareil_fi_041995` (`marque_PK`),
    CONSTRAINT `photo_appareil_fk_237925`
        FOREIGN KEY (`idAp_PK`)
        REFERENCES `appareil` (`idAp`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `photo_appareil_fk_47db7e`
        FOREIGN KEY (`modele_PK`)
        REFERENCES `modele` (`modele`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `photo_appareil_fk_041995`
        FOREIGN KEY (`marque_PK`)
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
    `part_id` INTEGER NOT NULL AUTO_INCREMENT,
    `part_nom` VARCHAR(200),
    `part_adresse` VARCHAR(200),
    `part_tel` VARCHAR(15),
    `part_mail` VARCHAR(100),
    `part_logo` VARCHAR(100),
    PRIMARY KEY (`part_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- partenaire_piece
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `partenaire_piece`;

CREATE TABLE `partenaire_piece`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `quantite` INTEGER,
    `prix_achat` DOUBLE,
    `prix_vente` DOUBLE,
    `date_enreg` DATETIME,
    `reference_PK` VARCHAR(100),
    `part_id_PK` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `partenaire_piece_fi_7cbc63` (`reference_PK`),
    INDEX `partenaire_piece_fi_d7f41d` (`part_id_PK`),
    INDEX `i_referenced_document_fk_09403c_1` (`date_enreg`),
    CONSTRAINT `partenaire_piece_fk_7cbc63`
        FOREIGN KEY (`reference_PK`)
        REFERENCES `piece` (`reference`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `partenaire_piece_fk_d7f41d`
        FOREIGN KEY (`part_id_PK`)
        REFERENCES `partenaire` (`part_id`)
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
    `reference_FK` VARCHAR(100),
    `part_id_FK` INTEGER(100),
    `date_enreg_FK` DATETIME,
    PRIMARY KEY (`doc_num`),
    INDEX `document_fi_09403c` (`date_enreg_FK`),
    INDEX `document_fi_0675ba` (`reference_FK`),
    INDEX `document_fi_d36f5b` (`part_id_FK`),
    CONSTRAINT `document_fk_09403c`
        FOREIGN KEY (`date_enreg_FK`)
        REFERENCES `partenaire_piece` (`date_enreg`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `document_fk_0675ba`
        FOREIGN KEY (`reference_FK`)
        REFERENCES `piece` (`reference`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `document_fk_d36f5b`
        FOREIGN KEY (`part_id_FK`)
        REFERENCES `partenaire` (`part_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- depot
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `depot`;

CREATE TABLE `depot`
(
    `id_depot` INTEGER NOT NULL AUTO_INCREMENT,
    `depot_adresse` VARCHAR(200),
    PRIMARY KEY (`id_depot`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- partenaire_depot
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `partenaire_depot`;

CREATE TABLE `partenaire_depot`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `part_id_PK` INTEGER,
    `id_depot_PK` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `partenaire_depot_fi_d7f41d` (`part_id_PK`),
    INDEX `partenaire_depot_fi_c9a6f2` (`id_depot_PK`),
    CONSTRAINT `partenaire_depot_fk_d7f41d`
        FOREIGN KEY (`part_id_PK`)
        REFERENCES `partenaire` (`part_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `partenaire_depot_fk_c9a6f2`
        FOREIGN KEY (`id_depot_PK`)
        REFERENCES `depot` (`id_depot`)
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
    `date_arrivee` DATETIME,
    `date_depart` DATETIME,
    `reference_PK` VARCHAR(100),
    PRIMARY KEY (`stock_id`),
    INDEX `stock_fi_7cbc63` (`reference_PK`),
    CONSTRAINT `stock_fk_7cbc63`
        FOREIGN KEY (`reference_PK`)
        REFERENCES `piece` (`reference`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- stock_depot
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `stock_depot`;

CREATE TABLE `stock_depot`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `stock_id_PK` INTEGER,
    `reference_PK` VARCHAR(100),
    `id_depot_PK` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `stock_depot_fi_7c0009` (`stock_id_PK`),
    INDEX `stock_depot_fi_7cbc63` (`reference_PK`),
    INDEX `stock_depot_fi_c9a6f2` (`id_depot_PK`),
    CONSTRAINT `stock_depot_fk_7c0009`
        FOREIGN KEY (`stock_id_PK`)
        REFERENCES `stock` (`stock_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `stock_depot_fk_7cbc63`
        FOREIGN KEY (`reference_PK`)
        REFERENCES `piece` (`reference`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `stock_depot_fk_c9a6f2`
        FOREIGN KEY (`id_depot_PK`)
        REFERENCES `depot` (`id_depot`)
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
-- media
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `media`;

CREATE TABLE `media`
(
    `media_num` INTEGER NOT NULL AUTO_INCREMENT,
    `media_date` DATETIME,
    `description` VARCHAR(200),
    `media_url` VARCHAR(200),
    `commentaire` VARCHAR(200),
    `cat_FK` VARCHAR(100),
    `s_cat_FK` VARCHAR(100),
    PRIMARY KEY (`media_num`),
    INDEX `media_fi_b7e888` (`cat_FK`),
    INDEX `media_fi_8ca357` (`s_cat_FK`),
    CONSTRAINT `media_fk_b7e888`
        FOREIGN KEY (`cat_FK`)
        REFERENCES `categorie` (`categorie`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `media_fk_8ca357`
        FOREIGN KEY (`s_cat_FK`)
        REFERENCES `sous_categorie` (`sous_categorie`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- categorie
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `categorie`;

CREATE TABLE `categorie`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `categorie` VARCHAR(100),
    `commentaire` VARCHAR(255),
    `niveau` INTEGER(5),
    `ordre` INTEGER(5),
    `url` VARCHAR(200),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `categorie_u_715c48` (`categorie`, `niveau`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sous_categorie
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sous_categorie`;

CREATE TABLE `sous_categorie`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `sous_categorie` VARCHAR(100),
    `id_categorie_FK` INTEGER,
    `commentaire` VARCHAR(255),
    `ordre` INTEGER(5),
    `url` VARCHAR(200),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `sous_categorie_u_940b70` (`id_categorie_FK`, `sous_categorie`),
    INDEX `i_referenced_media_fk_8ca357_1` (`sous_categorie`),
    CONSTRAINT `sous_categorie_fk_54d197`
        FOREIGN KEY (`id_categorie_FK`)
        REFERENCES `categorie` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- article
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article`
(
    `art_num` INTEGER NOT NULL AUTO_INCREMENT,
    `titre` VARCHAR(255),
    `id_emp_FK` VARCHAR(25),
    `date_edit` DATETIME,
    `contenu` TEXT,
    `resume` TEXT,
    `img_laune` TEXT,
    `url` VARCHAR(200),
    `categorie_FK` VARCHAR(100) NOT NULL,
    `sous_categorie_FK` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`art_num`),
    INDEX `article_fi_c4d58e` (`id_emp_FK`),
    INDEX `article_fi_606d41` (`categorie_FK`),
    INDEX `article_fi_dfed82` (`sous_categorie_FK`),
    CONSTRAINT `article_fk_c4d58e`
        FOREIGN KEY (`id_emp_FK`)
        REFERENCES `employe` (`id_emp`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `article_fk_606d41`
        FOREIGN KEY (`categorie_FK`)
        REFERENCES `categorie` (`categorie`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `article_fk_dfed82`
        FOREIGN KEY (`sous_categorie_FK`)
        REFERENCES `sous_categorie` (`sous_categorie`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- publication
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `publication`;

CREATE TABLE `publication`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `date_pub` DATETIME,
    `etat` TINYINT(1),
    `slider` TINYINT(1),
    `art_num_PK` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `publication_fi_b98005` (`art_num_PK`),
    CONSTRAINT `publication_fk_b98005`
        FOREIGN KEY (`art_num_PK`)
        REFERENCES `article` (`art_num`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- message
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message`
(
    `id_msg` INTEGER NOT NULL AUTO_INCREMENT,
    `objet` VARCHAR(255),
    `nom_visiteur` VARCHAR(100),
    `mail_visiteur` VARCHAR(100),
    `telephone` VARCHAR(15),
    `msg` TEXT,
    `etat` TINYINT(1),
    PRIMARY KEY (`id_msg`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menus
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `menu` VARCHAR(100),
    `commentaire` VARCHAR(255),
    `niveau` INTEGER(5),
    `ordre` INTEGER(5),
    `url` VARCHAR(200),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `menus_u_4708bc` (`menu`, `niveau`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sous_menu
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sous_menu`;

CREATE TABLE `sous_menu`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `sous_menu` VARCHAR(100),
    `id_menu_FK` INTEGER,
    `commentaire` VARCHAR(255),
    `ordre` INTEGER(5),
    `url` VARCHAR(200),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `sous_menu_u_2a1f2b` (`id_menu_FK`, `sous_menu`),
    CONSTRAINT `sous_menu_fk_94eee5`
        FOREIGN KEY (`id_menu_FK`)
        REFERENCES `menus` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- widget
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `widget`;

CREATE TABLE `widget`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `num_bloc` INTEGER,
    `num_art` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `widget_fi_02ce95` (`num_art`),
    CONSTRAINT `widget_fk_02ce95`
        FOREIGN KEY (`num_art`)
        REFERENCES `article` (`art_num`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
