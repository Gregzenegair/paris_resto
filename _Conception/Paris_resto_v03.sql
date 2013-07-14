#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
DROP DATABASE paris_resto;
create database paris_resto character set utf8 COLLATE utf8_general_ci;
USE paris_resto;

CREATE TABLE adresses(
        id             Int NOT NULL ,
        nom_voie       Varchar (50) NOT NULL ,
        numero_voie    Varchar (10) NOT NULL ,
        id_restaurants Int NOT NULL ,
        id_villes      Int NOT NULL ,
        id_types_voie  Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


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
        id          Int NOT NULL ,
        nom         Varchar (50) NOT NULL ,
        numero_tel  Varchar (20) NOT NULL ,
        email       Varchar (50) NOT NULL ,
        id_adresses Int NOT NULL ,
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
        pseudo           Varchar (30) NOT NULL ,
        email            Varchar (30) NOT NULL ,
        mdp              Varchar (100) NOT NULL ,
        date_inscription Date NOT NULL ,
        email_check      Varchar (32) NOT NULL ,
        actif            Bool NOT NULL ,
        commentaire      Varchar (1000) NOT NULL ,
        id_statuts       Int NOT NULL ,
        PRIMARY KEY (id ) ,
        INDEX (email )
)ENGINE=InnoDB;


CREATE TABLE villes(
        id  Int NOT NULL ,
        nom Varchar (50) NOT NULL ,
        cp  Varchar (5) NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


CREATE TABLE Avis(
        id              Int NOT NULL ,
        id_commentaires Int NOT NULL ,
        id_users        Int NOT NULL ,
        id_restaurants  Int NOT NULL ,
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

ALTER TABLE adresses ADD CONSTRAINT FK_adresses_id_restaurants FOREIGN KEY (id_restaurants) REFERENCES restaurants(id);
ALTER TABLE adresses ADD CONSTRAINT FK_adresses_id_villes FOREIGN KEY (id_villes) REFERENCES villes(id);
ALTER TABLE adresses ADD CONSTRAINT FK_adresses_id_types_voie FOREIGN KEY (id_types_voie) REFERENCES types_voie(id);
ALTER TABLE commentaires ADD CONSTRAINT FK_commentaires_id_Avis FOREIGN KEY (id_Avis) REFERENCES Avis(id);
ALTER TABLE photos ADD CONSTRAINT FK_photos_id_restaurants FOREIGN KEY (id_restaurants) REFERENCES restaurants(id);
ALTER TABLE restaurants ADD CONSTRAINT FK_restaurants_id_adresses FOREIGN KEY (id_adresses) REFERENCES adresses(id);
ALTER TABLE users ADD CONSTRAINT FK_users_id_statuts FOREIGN KEY (id_statuts) REFERENCES statuts(id);
ALTER TABLE Avis ADD CONSTRAINT FK_Avis_id_commentaires FOREIGN KEY (id_commentaires) REFERENCES commentaires(id);
ALTER TABLE Avis ADD CONSTRAINT FK_Avis_id_users FOREIGN KEY (id_users) REFERENCES users(id);
ALTER TABLE Avis ADD CONSTRAINT FK_Avis_id_restaurants FOREIGN KEY (id_restaurants) REFERENCES restaurants(id);
ALTER TABLE ligcategorie_note ADD CONSTRAINT FK_ligcategorie_note_id_categorie_note FOREIGN KEY (id_categorie_note) REFERENCES categorie_note(id);
ALTER TABLE ligcategorie_note ADD CONSTRAINT FK_ligcategorie_note_id_notes FOREIGN KEY (id_notes) REFERENCES notes(id);
ALTER TABLE ligcategories ADD CONSTRAINT FK_ligcategories_id_restaurants FOREIGN KEY (id_restaurants) REFERENCES restaurants(id);
ALTER TABLE ligcategories ADD CONSTRAINT FK_ligcategories_id_categories FOREIGN KEY (id_categories) REFERENCES categories(id);
ALTER TABLE lignotes ADD CONSTRAINT FK_lignotes_id_Avis FOREIGN KEY (id_Avis) REFERENCES Avis(id);
ALTER TABLE lignotes ADD CONSTRAINT FK_lignotes_id_notes FOREIGN KEY (id_notes) REFERENCES notes(id);
