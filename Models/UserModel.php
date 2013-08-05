<?php

require_once 'Utils/DAO.php';
require_once 'Utils/CNX.php';

class UserModel extends CNX {

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
     * Connection d'un utilisateur, retourne les informations propres à l'utilisateur
     * @param type $email
     * @param type $mdp
     * @return array
     */
    public function connectUser($email, $mdp) {

        $aResultats = array();

        $email = $this->cleanArgForBdd($email);
        $req = $this->_bdd->prepare('SELECT id, mdp, statut, actif FROM users where email = :email');
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->execute();

        while ($donnees = $req->fetch()) {
            $mdp5 = md5($mdp);
            if ($donnees['mdp'] == $mdp5) {
                $req->closeCursor();
                return $donnees;
            } else {
                array_push($aResultats, 0);
                $req->closeCursor();
                return $aResultats;
            }
        }
    }

    /**
     * retourne vrai ou faux en fonction de l'existence ou non de l'email dans
     * la bse d'users
     * @param type $email
     * @return boolean
     */
    public function selectUserEmail($email) {
        $req = $this->_bdd->prepare('SELECT count(*) as count FROM users where email = :email');
        $req->bindParam(':email', $this->cleanArgForBdd($email), PDO::PARAM_STR);
        $req->execute();

        while ($donnees = $req->fetch()) {
            if ($donnees['count'] == 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Insertion d'un utilisateur, envoie également un mail à l'utilisateur
     * si l'insert s'est bien passé
     * @param type $pseudo
     * @param type $email
     * @param type $mdp
     * @param type $statut
     * @return boolean
     */
    public function insertUser($pseudo, $email, $mdp, $statut) {

        $pseudo = $this->$this->cleanArgForBdd($pseudo);
        $email = $this->$this->cleanArgForBdd($email);
        $mdp = $this->$this->cleanArgForBdd($mdp);
        $statut = $this->$this->cleanArgForBdd($statut);

        $email_check = md5(microtime(TRUE) * 100000);
        $email = strtolower($email);
        $tNomChampTable = ["pseudo", "email", "mdp", "statut", "date_inscription", "email_check"];
        $tValeurs = [":$pseudo", ":$email", ":$mdp", ":$statut", "now()", ":$email_check"];

        $result = DAO::insert($this->_bdd, "users", $tNomChampTable, $tValeurs);

        if ($result) {
            $this->sendEmail($pseudo, $email, $email_check);
            return true;
        } else {
            return false;
        }
    }

    /**
     * envoi d'un email
     * @param type $pseudo
     * @param type $email
     * @param type $email_check
     */
    private function sendEmail($pseudo, $email, $email_check) {

        $pseudo = $this->cleanArgForBdd($pseudo);
        $email = $this->cleanArgForBdd($email);
        $email_check = $this->cleanArgForBdd($email_check);

        $destinataire = $email;
        $sujet = "Activation de votre compte";
        $entete = "From: paris_resto@restos.com";

        $message = 'Bienvenue sur Paris Resto,
 
                    Pour activer votre compte, veuillez cliquer sur le lien ci dessous :
 
                    http://localhost/Paris_Resto/Models/Activation.php?pseudo=' . urlencode($pseudo) . '&email_check=' . urlencode($email_check) . '

 
_______________
Ceci est un mail automatique, Merci de ne pas y répondre.';


        mail($destinataire, $sujet, $message, $entete); // --- Envoi du mail
    }

    public function seekUsers($recherche) {

        $recherche = $this->cleanArgForBdd($recherche);
        $recherche = "%" . $recherche . "%";
        $req = $this->_bdd->prepare('SELECT u.id, u.pseudo, u.email, s.nom as statut, u.date_inscription, u.actif 
                                            FROM users u
                                            JOIN statuts s
                                            ON u.statut = s.id
                                            WHERE u.pseudo like :recherche
                                            OR u.email like :recherche
                                            OR s.nom like :recherche');
        $req->bindParam(':recherche', $recherche, PDO::PARAM_STR);
        $req->execute();
        $resultAfficherUsers = $req->fetchAll();
        $resultAfficherUsers = $this->arrangeResultUser($resultAfficherUsers);
        $req->closeCursor();
        return $resultAfficherUsers;
    }

    /**
     * Afficher un ou plusieurs utilisateur (si id est renseigné ou pas)
     * Retourne un tableau avec un ou plusieurs utilisateurs
     * @param type $id
     * @return array
     */
    public function showUsers($id = null, $limiteBasse = null, $pagination = null) {

        $limiteBasse = (int) $limiteBasse;
        $pagination = (int) $pagination;

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
                                            ON u.statut = s.id
                                            ORDER BY u.date_inscription DESC
                                            LIMIT :limiteBasse, :pagination');

            $req->bindParam(':limiteBasse', $limiteBasse, PDO::PARAM_INT);
            $req->bindParam(':pagination', $pagination, PDO::PARAM_INT);
        }

        $req->execute();
        $resultAfficherUsers = $req->fetchAll();
        if (!isset($id)) {
            $resultAfficherUsers = $this->arrangeResultUser($resultAfficherUsers);
        } else {
            if ($resultAfficherUsers[0]['actif'] == 0) {
                $result[0]['actif'] = "Inactif";
            } else {
                $result[0]['actif'] = "Actif";
            }
        }
        $req->closeCursor();
        return $resultAfficherUsers;
    }

    public function countUsers() {

        $req = $this->_bdd->prepare('SELECT count(*) as count FROM users');
        $req->execute();
        $resultAfficher = $req->fetchAll();
        $req->closeCursor();
        foreach ($resultAfficher as $value) {
            $result = $value['count'];
        }
        return $result;
    }

    /**
     * pour le select des statuts
     * @return array (1 dimension)
     */
    public function showStatuts() {

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

    /**
     *  Mettre à jour un utilisateur
     * @param type $id
     * @param type $pseudo
     * @param type $email
     * @param type $date_inscription
     * @param type $statut
     * @param type $actif
     */
    public function updateUser($id, $pseudo, $email, $date_inscription, $statut, $actif) {

        $pseudo = $this->cleanArgForBdd($pseudo);
        $email = $this->cleanArgForBdd($email);
        $date_inscription = $this->cleanArgForBdd($date_inscription);
        $statut = $this->cleanArgForBdd($statut);

        $tNomChampTable = ["pseudo", "email", "date_inscription", "statut", "actif"];
        $tValeurs = [":$pseudo", ":$email", ":$date_inscription", ":$statut", ":$actif"];
        $twhere['id'] = $id;

        DAO::update($this->_bdd, "users", $tNomChampTable, $tValeurs, $twhere);
    }

    /**
     * Supprimer un utilisateur
     * @param type $id
     */
    public function deleteUser($id) {
        $req = $this->_bdd->prepare('DELETE FROM users WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

    private function arrangeResultUser($result) {
        foreach ($result as $key => $value) {
            $split = explode("-", $value['date_inscription']);
            $date = $split[2] . "/" . $split[1] . "/" . $split[0];
            $result[$key]['date_inscription'] = $date;

            if ($result[$key]['actif'] == 0) {
                $result[$key]['actif'] = "Inactif";
            } else {
                $result[$key]['actif'] = "Actif";
            }
        }
        return $result;
    }

}
