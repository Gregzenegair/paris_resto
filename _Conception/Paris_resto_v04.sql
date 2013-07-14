#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
DROP DATABASE IF EXISTS paris_resto;
create database paris_resto character set utf8 COLLATE utf8_general_ci;
USE paris_resto;

CREATE TABLE categories(
        id  Int NOT NULL ,
        nom Varchar (50) NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE commentaires(
        id             Int NOT NULL ,
        titre          Varchar (50) NOT NULL ,
        description    Varchar (1024) NOT NULL ,
        date_insertion Date NOT NULL ,
        id_Avis        Int ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE notes(
        id     Int NOT NULL ,
        valeur Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE photos(
        id             Int NOT NULL ,
        nom_fichier    Varchar (50) NOT NULL ,
        date_insertion Date NOT NULL ,
        id_restaurants Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE restaurants(
        id            Int NOT NULL ,
        nom           Varchar (50) NOT NULL ,
        numero_tel    Varchar (20) NOT NULL ,
        email         Varchar (50) NOT NULL ,
        nom_voie      Varchar (50) ,
        numero_voie   Numeric ,
        id_villes     Int ,
        id_types_voie Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE statuts(
        id  Int NOT NULL ,
        nom Varchar (50) NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE categorie_note(
        id  Int NOT NULL ,
        nom Varchar (20) NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE types_voie(
        id  Int NOT NULL ,
        nom Varchar (50) NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE users(
        id               Int NOT NULL ,
        pseudo           Varchar (100) NOT NULL ,
        email            Varchar (100) NOT NULL ,
        mdp              Varchar (100) NOT NULL ,
        date_inscription Date NOT NULL ,
        email_check      Varchar (100) NOT NULL ,
        actif            Bool NOT NULL ,
        commentaire      Varchar (1000) NOT NULL ,
        statut       Int NOT NULL ,
        PRIMARY KEY (id ) ,
        INDEX (email )
)ENGINE=InnoDB;


CREATE TABLE villes(
        id  int (11) Auto_increment  NOT NULL ,
        nom Varchar (50) NOT NULL ,
        cp  Varchar (5) NOT NULL ,
        PRIMARY KEY (id ) ,
        INDEX (nom )
)ENGINE=InnoDB;


CREATE TABLE Avis(
        id             Int NOT NULL ,
        id_users       Int NOT NULL ,
        id_restaurants Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE ligcategorie_note(
        id_categorie_note Int NOT NULL ,
        id_notes          Int NOT NULL ,
        PRIMARY KEY (id_categorie_note ,id_notes )
)ENGINE=InnoDB;


CREATE TABLE ligcategories(
        id_restaurants Int NOT NULL ,
        id_categories  Int NOT NULL ,
        PRIMARY KEY (id_restaurants ,id_categories )
)ENGINE=InnoDB;


CREATE TABLE lignotes(
        id_Avis  Int NOT NULL ,
        id_notes Int NOT NULL ,
        PRIMARY KEY (id_Avis ,id_notes )
)ENGINE=InnoDB;




#-- Definition des AUTO_INCREMENT
ALTER TABLE `paris_resto`.`avis` MODIFY COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paris_resto`.`categorie_note` MODIFY COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paris_resto`.`categories` MODIFY COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paris_resto`.`commentaires` MODIFY COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paris_resto`.`notes` MODIFY COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paris_resto`.`photos` MODIFY COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paris_resto`.`restaurants` MODIFY COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paris_resto`.`types_voie` MODIFY COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paris_resto`.`users` MODIFY COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paris_resto`.`villes` MODIFY COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `paris_resto`.`restaurants` MODIFY COLUMN `nom` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 MODIFY COLUMN `numero_tel` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci,
 MODIFY COLUMN `email` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci;


#-- Definition de clef unique
ALTER TABLE `paris_resto`.`users` DROP INDEX `email`,
 ADD UNIQUE INDEX `email` USING BTREE(`email`);



#-- Definition de DEFAULT pour les NULL
ALTER TABLE `paris_resto`.`users` MODIFY COLUMN `actif` TINYINT(1) DEFAULT 1;
ALTER TABLE `paris_resto`.`users` MODIFY COLUMN `statut` INT(11) DEFAULT 0;
ALTER TABLE `paris_resto`.`users` MODIFY COLUMN `commentaire` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '';



#-- Definition des FOREIGN KEYs
ALTER TABLE commentaires ADD CONSTRAINT FK_commentaires_id_Avis FOREIGN KEY (id_Avis) REFERENCES Avis(id);
ALTER TABLE photos ADD CONSTRAINT FK_photos_id_restaurants FOREIGN KEY (id_restaurants) REFERENCES restaurants(id);
ALTER TABLE restaurants ADD CONSTRAINT FK_restaurants_id_villes FOREIGN KEY (id_villes) REFERENCES villes(id);
ALTER TABLE restaurants ADD CONSTRAINT FK_restaurants_id_types_voie FOREIGN KEY (id_types_voie) REFERENCES types_voie(id);
ALTER TABLE users ADD CONSTRAINT FK_users_statut FOREIGN KEY (statut) REFERENCES statuts(id);
ALTER TABLE Avis ADD CONSTRAINT FK_Avis_id_users FOREIGN KEY (id_users) REFERENCES users(id);
ALTER TABLE Avis ADD CONSTRAINT FK_Avis_id_restaurants FOREIGN KEY (id_restaurants) REFERENCES restaurants(id);
ALTER TABLE ligcategorie_note ADD CONSTRAINT FK_ligcategorie_note_id_categorie_note FOREIGN KEY (id_categorie_note) REFERENCES categorie_note(id);
ALTER TABLE ligcategorie_note ADD CONSTRAINT FK_ligcategorie_note_id_notes FOREIGN KEY (id_notes) REFERENCES notes(id);
ALTER TABLE ligcategories ADD CONSTRAINT FK_ligcategories_id_restaurants FOREIGN KEY (id_restaurants) REFERENCES restaurants(id);
ALTER TABLE ligcategories ADD CONSTRAINT FK_ligcategories_id_categories FOREIGN KEY (id_categories) REFERENCES categories(id);
ALTER TABLE lignotes ADD CONSTRAINT FK_lignotes_id_Avis FOREIGN KEY (id_Avis) REFERENCES Avis(id);
ALTER TABLE lignotes ADD CONSTRAINT FK_lignotes_id_notes FOREIGN KEY (id_notes) REFERENCES notes(id);


#-- Insertions des paramètres fixes
INSERT INTO statuts (id, nom) VALUES (0,'Utilisateur'),(8,'Modérateur'),(10,'Administrateur');
INSERT INTO types_voie (nom) VALUES ('allée'), ('avenue'), ('boulevard'), ('chemin'), ('impasse'), ('lieu dit'), ('rue');