<?php

require_once 'Utils/DAO.php';require_once 'Utils/CNX.php';

class CategorieModel extends CNX {

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
     * pour le select des categories
     * @return array
     */
    public function showCategories() {

        $req = $this->_bdd->prepare('SELECT c.id, c.nom FROM categories c');
        $req->execute();
        $resultAfficherStatuts = $req->fetchAll();
        $req->closeCursor();

        return $resultAfficherStatuts;
    }

    public function seekCategories($recherche) {
        $recherche = "%" . $recherche . "%";
        $req = $this->_bdd->prepare('SELECT c.id, c.nom FROM categories c
                                                    WHERE c.nom like :recherche');
        $req->bindParam(':recherche', $recherche, PDO::PARAM_STR);

        $req->execute();
        $resultAfficherUsers = $req->fetchAll();
        $req->closeCursor();
        return $resultAfficherUsers;
    }

    public function deleteCategorie($id) {
        $req = $this->_bdd->prepare('DELETE FROM categories WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

}
