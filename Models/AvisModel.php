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
    public function showAvis($id) {

        $req = $this->_bdd->prepare('SELECT c.id, c.titre, c.description, u.pseudo, a.actif, a.id_restaurant FROM avis a
                                        JOIN commentaires c 
                                        ON c.id_avis = a.id 
                                        JOIN users u 
                                        ON u.id = a.id_user
                                        WHERE a.id_restaurant = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
        $resultAfficher = $req->fetchAll();
        $req->closeCursor();

        return $resultAfficher;
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

    public function modifierAvis($id, $actif) {
        $req = $this->_bdd->prepare('UPDATE avis SET actif = :actif WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->bindParam(':actif', $actif, PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

}