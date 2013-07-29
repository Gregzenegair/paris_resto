<?php

require_once 'Utils/DAO.php';
require_once 'Utils/CNX.php';

class PhotoModel extends CNX {

    /**
     * Methode de connexion à la base
     * @param type $base
     * @param type $user
     * @param type $pwd
     */
    public function __construct($base, $user, $pwd) {
        parent::__construct($base, $user, $pwd);
    }

    /**
     * pour le select des photos
     * @return array
     */
    public function showPhotos($id = null) {

        if ($id == null) {
            $req = $this->_bdd->prepare('SELECT p.id, p.nom_fichier FROM photos p');
        } else {
            $req = $this->_bdd->prepare('SELECT p.id, p.nom_fichier FROM photos p WHERE id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_INT);
        }

        $req->execute();
        $resultAfficherPhotos = $req->fetchAll();
        $req->closeCursor();

        return $resultAfficherPhotos;
    }

    public function deletePhoto($id) {
        $req = $this->_bdd->prepare('DELETE FROM photos WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

    public function insertPhoto($nom_fichier, $id_restaurant) {
        // -- test de l'extension, si ok alors ...
        $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
        $extension_upload = strtolower(substr(strrchr($_FILES['imageFile']['name'], '.'), 1));
        if (in_array($extension_upload, $extensions_valides)) {
            $tNomChampTable = ["nom_fichier", "id_restaurant", "date_insertion"];
            $tValeurs = [":$nom_fichier", ":$id_restaurant", "now()"];

            // --- Demarage de la transaction

            $result = DAO::insert($this->_bdd, "photos", $tNomChampTable, $tValeurs);
            return $result;
        }
    }

}
