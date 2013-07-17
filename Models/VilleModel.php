<?php

require_once 'DAO.php';
require_once 'CNX.php';

class VilleModel extends CNX {

    /**
     * Methode de connexion à la base
     * @param type $base
     * @param type $user
     * @param type $pwd
     */
    public function __construct($base, $user, $pwd) {
        parent::__construct($base, $user, $pwd);
    }

    public function countVilles() {

        $req = $this->_bdd->prepare('SELECT count(*) as count FROM villes_france');
        $req->execute();
        $resultAfficherStatuts = $req->fetchAll();
        $req->closeCursor();
        foreach ($resultAfficherStatuts as $value) {
            $result = $value['count'];
        }

        return $result;
    }

    /**
     * pour le select des villes
     * @return array
     */
    public function showVilles($limiteBasse, $limiteHaute) {

        $limiteBasse = (int) $limiteBasse;
        $limiteHaute = (int) $limiteHaute;

        $req = $this->_bdd->prepare('SELECT v.id, v.nom, v.cp FROM villes_france v LIMIT :limiteBasse, :limiteHaute');
        $req->bindParam(':limiteBasse', $limiteBasse, PDO::PARAM_INT);
        $req->bindParam(':limiteHaute', $limiteHaute, PDO::PARAM_INT);
        $req->execute();
        $resultAfficherStatuts = $req->fetchAll();
        $req->closeCursor();

        return $resultAfficherStatuts;
    }

    public function seekVilles($recherche) {
        $recherche = "%" . $recherche . "%";
        $req = $this->_bdd->prepare('SELECT v.id, v.nom, v.cp FROM villes_france v
                                                    WHERE v.nom like :recherche
                                                    OR v.cp like :recherche
                                                    LIMIT 100');
        $req->bindParam(':recherche', $recherche, PDO::PARAM_STR);

        $req->execute();
        $resultAfficherUsers = $req->fetchAll();
        $req->closeCursor();
        return $resultAfficherUsers;
    }

    public function deleteVille($id) {
        $req = $this->_bdd->prepare('DELETE FROM villes_france WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

}