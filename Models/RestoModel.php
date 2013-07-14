<?php

require_once 'CNX.php';
require_once 'DAO.php';

class RestoModel extends CNX {

    // --- Methode de connexion à la base
    public function __construct($base, $user, $pwd) {
        parent::__construct($base, $user, $pwd);
    }

    // --- Insertion d'un restaurant

    function insertVille($nom, $cp) {

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
                $this->insertVille($nom, $cp);
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
            $req = $this->_bdd->prepare('SELECT *
                                            FROM restaurants
                                            id = :id');
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

    function updateResto($id, $pseudo, $email, $date_inscription, $statut, $actif) {
        $req = $this->_bdd->prepare('UPDATE users '
                . ' SET pseudo = :pseudo, email = :email, date_inscription = :date_inscription, statut = :statut, actif = :actif '
                . ' WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':date_inscription', $date_inscription, PDO::PARAM_STR);
        $req->bindParam(':statut', $statut, PDO::PARAM_STR);
        $req->bindParam(':actif', $actif, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

    function deleteResto($id) {
        $req = $this->_bdd->prepare('DELETE FROM users WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

}