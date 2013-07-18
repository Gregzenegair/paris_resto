<?php

require_once 'CNX.php';
require_once 'DAO.php';

class RestoModel extends CNX {

// --- Methode de connexion à la base
    public function __construct($base, $user, $pwd) {
        parent::__construct($base, $user, $pwd);
    }

    /**
     * Insertion ou selection d'une ville, si la ville n'existe pas, elle sera ajoutee
     * @param type $nom
     * @param type $cp
     * @return boolean
     */
    public function selectOrInsertVille($nom, $cp) {

        if ($nom == "") {
            return false;
        }

        $nom = ucfirst($nom);
        $tNomChampTable = ["nom", "cp"];
        $tValeurs = [":$nom", ":$cp"];

        $sPrepareSelect = "SELECT id, count(*) as result FROM villes WHERE nom = :nom AND cp = :cp";

        $bdd = $this->_bdd;
        $req = $bdd->prepare($sPrepareSelect);
        $req->execute(array(':nom' => $nom, ':cp' => $cp));

        while ($donnees = $req->fetch()) {
            if ($donnees['result'] == "1") {
                $resultSelect = $donnees['id'];
            } else {
                DAO::insert($this->_bdd, "villes", $tNomChampTable, $tValeurs);
                $resultSelect = $this->selectOrInsertVille($nom, $cp);
            }
        }
        if ($resultSelect) {
            return $resultSelect;
        } else {
            return false;
        }
    }

    /**
     * Insertion ou selection d'une categorie, si la categorie n'existe pas, elle sera ajoutee
     * @param type $nom
     * @param type $cp
     * @return boolean
     */
    public function selectOrInsertCategorie($nom) {

        if ($nom == "") {
            return false;
        }

        $nom = ucfirst($nom);
        $tNomChampTable = ["nom"];
        $tValeurs = [":$nom"];

        $sPrepareSelect = "SELECT id, count(*) as result FROM categories WHERE nom = :nom";

        $bdd = $this->_bdd;
        $req = $bdd->prepare($sPrepareSelect);
        $req->execute(array(':nom' => $nom));

        while ($donnees = $req->fetch()) {
            if ($donnees['result'] == "1") {
                $resultSelect = $donnees['id'];
            } else {
                DAO::insert($this->_bdd, "categories", $tNomChampTable, $tValeurs);
                $resultSelect = $this->selectOrInsertCategorie($nom);
            }
        }
        if ($resultSelect) {
            return $resultSelect;
        } else {
            return false;
        }
    }

    /**
     * Retourne l'id ou faux en fonction du succès de l'insertion d'un nouveau restaurant
     * @param type $nom
     * @param type $numero_tel
     * @param type $email
     * @param type $numero_voie
     * @param type $nom_voie
     * @param type $type_voie
     * @param type $id_villes
     * @return boolean ou id
     */
    public function insertResto($nom, $numero_tel, $email, $numero_voie, $nom_voie, $type_voie, $id_ville, $description, $horraires, $prix) {

        $email = strtolower($email);
        $tNomChampTable = ["nom", "numero_tel", "email", "numero_voie", "nom_voie", "type_voie", "id_ville", "date_insertion", "description", "horraires", "prix"];
        $tValeurs = [":$nom", ":$numero_tel", ":$email", ":$numero_voie", ":$nom_voie", ":$type_voie", ":$id_ville", "now()", ":$description", ":$horraires", ":$prix"];

// --- Demarage de la transaction

        $result = DAO::insert($this->_bdd, "restaurants", $tNomChampTable, $tValeurs);

        if ($result) {
            return $this->_bdd->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * Met à jour le restaurant indiqué par rapport à son id.
     * @param type $id
     * @param type $nom
     * @param type $numero_tel
     * @param type $email
     * @param type $numero_voie
     * @param type $nom_voie
     * @param type $type_voie
     * @param type $id_villes
     * @return boolean ou id
     */
    public function updateResto($id, $nom, $numero_tel, $email, $numero_voie, $nom_voie, $type_voie, $id_ville, $description, $horraires, $prix) {

        $tNomChampTable = ["nom", "numero_tel", "email", "numero_voie", "nom_voie", "type_voie", "id_ville", "date_insertion", "description", "horraires", "prix"];
        $tValeurs = [":$nom", ":$numero_tel", ":$email", ":$numero_voie", ":$nom_voie", ":$type_voie", ":$id_ville", "now()", ":$description", ":$horraires", ":$prix"];
        $twhere['id'] = $id;

// --- Demarage de la transaction

        $result = DAO::update($this->_bdd, "restaurants", $tNomChampTable, $tValeurs, $twhere);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retourne en resultat le tableau de recherche
     * @param type $recherche
     * @return type
     */
    public function seekRestos($recherche) {
        $recherche = "%" . $recherche . "%";
        $req = $this->_bdd->prepare('SELECT r.id, r.nom, GROUP_CONCAT(c.nom) as categories, r.numero_tel, r.email, r.numero_voie, r.nom_voie, t.nom as type_voie, v.nom as nom_ville, v.cp
                                                    FROM restaurants r
                                                    LEFT JOIN villes v
                                                    ON v.id = r.id_ville
                                                    LEFT JOIN ligcategories lig
                                                    ON r.id = lig.id_restaurant
                                                    LEFT JOIN categories c
                                                    ON c.id = lig.id_categorie
                                                    LEFT JOIN types_voie t
                                                    ON t.id = r.type_voie
                                                    WHERE r.nom like :recherche
                                                    OR c.nom like :recherche
                                                    OR v.nom like :recherche
                                                    OR v.cp like :recherche
                                                    ORDER BY date_insertion DESC
                                                    GROUP BY r.id');
        $req->bindParam(':recherche', $recherche, PDO::PARAM_STR);

        $req->execute();
        $resultAfficherUsers = $req->fetchAll();
        $req->closeCursor();
        return $resultAfficherUsers;
    }

    /**
     * Retroune un tableau avec tous les restaurants
     * @param type $id
     * @return array
     */
    public function showRestos($id = null, $limiteBasse = null, $pagination = null) {

        $limiteBasse = (int) $limiteBasse;
        $pagination = (int) $pagination;
        if (isset($id)) {
            $req = $this->_bdd->prepare('SELECT r.id, r.nom, GROUP_CONCAT(c.nom) as categories, r.numero_tel, r.email, r.numero_voie, r.nom_voie, r.type_voie, r.type_voie, v.nom as nom_ville, v.cp, r.description, r.horraires, r.prix
                                                    FROM restaurants r
                                                    LEFT JOIN villes v
                                                    ON v.id = r.id_ville
                                                    LEFT JOIN ligcategories lig
                                                    on r.id = lig.id_restaurant
                                                    LEFT JOIN categories c
                                                    on c.id = lig.id_categorie
                                                    WHERE r.id = :id
                                                    ORDER BY r.date_insertion DESC');
            $req->bindParam(':id', $id, PDO::PARAM_STR);
        } else {
            $req = $this->_bdd->prepare('SELECT r.id, r.nom, GROUP_CONCAT(c.nom) as categories, r.numero_tel, r.email, r.numero_voie, r.nom_voie, r.type_voie, v.nom as nom_ville, v.cp, r.description, r.horraires, r.prix
                                                    FROM restaurants r
                                                    LEFT JOIN villes v
                                                    ON v.id = r.id_ville
                                                    LEFT JOIN ligcategories lig
                                                    ON r.id = lig.id_restaurant
                                                    LEFT JOIN categories c
                                                    ON c.id = lig.id_categorie
                                                    GROUP BY r.id
                                                    ORDER BY r.date_insertion DESC
                                                    LIMIT :limiteBasse, :pagination');
            $req->bindParam(':limiteBasse', $limiteBasse, PDO::PARAM_INT);
            $req->bindParam(':pagination', $pagination, PDO::PARAM_INT);
        }

        $req->execute();
        $resultAfficherUsers = $req->fetchAll();
        $req->closeCursor();
        return $resultAfficherUsers;
    }

    /**
     * 
     * @return type
     */
    public function countRestos() {

        $req = $this->_bdd->prepare('SELECT count(*) as count FROM restaurants');
        $req->execute();
        $resultAfficher = $req->fetchAll();
        $req->closeCursor();
        foreach ($resultAfficher as $value) {
            $result = $value['count'];
        }

        return $result;
    }

    /**
     * Retourne la liste des voies avec leur id en clef
     * @return array
     */
    public function showTypesVoie() {

        $req = $this->_bdd->prepare('SELECT id, nom FROM types_voie ORDER BY nom');
        $req->execute();
        $resultAfficherTypesVoies = $req->fetchAll();
        $req->closeCursor();

        $resultat = array();
        foreach ($resultAfficherTypesVoies as $value) {
            $resultat[$value['id']] = $value['nom'];
        }
        return $resultat;
    }

    /**
     * Retourne une liste de ville simple
     * @return array (1 dimension)
     */
    public function showVilles() {

        $req = $this->_bdd->prepare('SELECT DISTINCT nom FROM villes ORDER BY nom');
        $req->execute();
        $resultAfficherVilless = $req->fetchAll();
        $req->closeCursor();

        $resultat = array();
        foreach ($resultAfficherVilless as $value) {
            array_push($resultat, $value['nom']);
        }
        return $resultat;
    }

    /**
     * Retourne la liste des catégories simple
     * @return array (1 dimension)
     */
    public function showCategories() {

        $req = $this->_bdd->prepare('SELECT nom FROM categories ORDER BY nom');
        $req->execute();
        $resultAfficherStatuts = $req->fetchAll();
        $req->closeCursor();

        $resultat = array();
        foreach ($resultAfficherStatuts as $value) {
            array_push($resultat, $value['nom']);
        }
        return $resultat;
    }

    public function insertLigcategories($id_categorie, $id_restaurant) {
        $tNomChampTable = ["id_categorie", "id_restaurant"];
        $tValeurs = [":$id_categorie", ":$id_restaurant"];

// --- Demarage de la transaction

        $result = DAO::insert($this->_bdd, "ligcategories", $tNomChampTable, $tValeurs);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Utiliser la suppression des categories afin d'appliquer les modifications
     * depuis le formulaire
     * @param type $id
     */
    public function deleteLigcategories($id) {
        $req = $this->_bdd->prepare('DELETE FROM ligcategories WHERE id_restaurant = :id');
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

    /**
     * Supprime le restaurant par rapport à son id
     * @param type $id
     */
    public function deleteResto($id) {
        $req = $this->_bdd->prepare('DELETE FROM restaurants WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

}