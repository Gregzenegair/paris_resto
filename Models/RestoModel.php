<?php

class RestoModel {

    // --- Connexion active à la base
    private $_bdd;

    // --- Methode de connexion à la base
    public function __construct($base, $user, $pwd) {
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=' . $base, $user, $pwd);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $bdd->exec("SET CHARACTER SET utf8");

        $this->_bdd = $bdd;
    }

    // --- Connection d'un utilisateur

    function insertResto($nom, $id_categorie, $numero_tel, $email, $id_adresse, $id_note, $id_photo) {

        $tNomChampTable = ["nom", "id_categorie", "numero_tel", "email", "id_adresse", "id_note", "id_photo"];
        $tValeurs = [":$nom", ":$id_categorie", ":$numero_tel", ":$email", ":$id_adresse", ":$id_note", ":$id_photo"];
        
        $result = DAO::insert($this->_bdd, "restaurants", $tNomChampTable, $tValeurs);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function showRestos($id = null) {

        if (isset($id)) {
            $req = $this->_bdd->prepare('SELECT u.id, u.pseudo, u.email, s.nom as statut, u.date_inscription, u.actif 
                                            FROM users u
                                            JOIN statuts s
                                            ON u.statut = s.id
                                            WHERE u.id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_STR);
        } else {
            $req = $this->_bdd->prepare('SELECT u.id, u.pseudo, u.email, s.nom as statut, u.date_inscription, u.actif 
                                            FROM users u
                                            JOIN statuts s
                                            ON u.statut = s.id');
        }

        $req->execute();
        $resultAfficherUsers = $req->fetchAll();
        $req->closeCursor();
        return $resultAfficherUsers;
    }

    function showCategoriess() {

        $req = $this->_bdd->prepare('SELECT s.id, s.nom as statut FROM statuts s');
        $req->execute();
        $resultAfficherStatuts = $req->fetchAll();
        $req->closeCursor();

        $resultat = array();
        foreach ($resultAfficherStatuts as $value) {
            $resultat[$value['id']] = $value['statut'];
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