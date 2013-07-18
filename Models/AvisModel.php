<?php

require_once 'DAO.php';
require_once 'CNX.php';

class AvisModel extends CNX {

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
     * pour le select des aviss
     * @return array
     */
    public function showAvis() {

        $req = $this->_bdd->prepare('SELECT a.id, a.nom FROM avis a');
        $req->execute();
        $resultAfficherStatuts = $req->fetchAll();
        $req->closeCursor();

        return $resultAfficherStatuts;
    }

    public function seekAvis($recherche) {
        $recherche = "%" . $recherche . "%";
        $req = $this->_bdd->prepare('SELECT a.id, a.nom FROM avis a
                                                    WHERE a.nom like :recherche');
        $req->bindParam(':recherche', $recherche, PDO::PARAM_STR);

        $req->execute();
        $resultAfficherUsers = $req->fetchAll();
        $req->closeCursor();
        return $resultAfficherUsers;
    }

    public function deleteAvis($id) {
        $req = $this->_bdd->prepare('DELETE FROM avis WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

}