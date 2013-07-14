<?php

require_once 'CNX.php';
require_once 'DAO.php';

class RestoModel extends CNX {

    // --- Methode de connexion à la base
    public function __construct($base, $user, $pwd) {
        parent::__construct($base, $user, $pwd);
    }

    // --- Insertion ou selection d'une ville

    function selectOrInsertVille($nom, $cp) {

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

    function insertResto($nom, $numero_tel, $email, $numero_voie, $nom_voie, $id_types_voie, $id_villes) {

        $tNomChampTable = ["nom", "numero_tel", "email", "numero_voie", "nom_voie", "id_types_voie", "id_villes"];
        $tValeurs = [":$nom", ":$numero_tel", ":$email", ":$numero_voie", ":$nom_voie", ":$id_types_voie", ":$id_villes"];

        // --- Demarage de la transaction

        $result = DAO::insert($this->_bdd, "restaurants", $tNomChampTable, $tValeurs);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function showRestos($id = null) {

        if (isset($id)) {
            $req = $this->_bdd->prepare('SELECT r.id, r.nom, r.numero_tel, r.email, r.numero_voie, r.nom_voie, r.id_types_voie, v.nom as nom_ville, v.cp 
                                                    FROM restaurants r 
                                                    JOIN villes v 
                                                    ON v.id = r.id_villes 
                                                    WHERE r.id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_STR);
        } else {
            $req = $this->_bdd->prepare('SELECT *
                                            FROM restaurants');
        }

        $req->execute();
        $resultAfficherUsers = $req->fetchAll();
        $req->closeCursor();
        return $resultAfficherUsers;
    }

    function showTypesVoie() {

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

    function showVilles() {

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

    function showCategories() {

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

    function updateResto($id, $nom, $numero_tel, $email, $numero_voie, $nom_voie, $id_types_voie, $id_villes) {

        $tNomChampTable = ["nom", "numero_tel", "email", "numero_voie", "nom_voie", "id_types_voie", "id_villes"];
        $tValeurs = [":$nom", ":$numero_tel", ":$email", ":$numero_voie", ":$nom_voie", ":$id_types_voie", ":$id_villes"];
        $twhere['id'] = $id;

        // --- Demarage de la transaction

        $result = DAO::update($this->_bdd, "restaurants", $tNomChampTable, $tValeurs, $twhere);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function deleteResto($id) {
        $req = $this->_bdd->prepare('DELETE FROM restaurants WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

}