<?php

require_once 'DAO.php';
require_once 'CNX.php';

class UserModel extends CNX {

    // --- Methode de connexion à la base
    public function __construct($base, $user, $pwd) {
        parent::__construct($base, $user, $pwd);
    }

    // --- Connection d'un utilisateur
    function connectUser($email, $mdp) {

        $aResultats = [];

        $req = $this->_bdd->prepare('SELECT id, mdp, statut, actif FROM users where email = :email');
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->execute();

        while ($donnees = $req->fetch()) {
            $mdp5 = md5($mdp);
            if ($donnees['mdp'] == $mdp5) {
                $id = $donnees['id'];
                $statut_membre = $donnees['statut'];
                $actif_membre = $donnees['actif'];

                array_push($aResultats, $id);
                array_push($aResultats, $statut_membre);
                array_push($aResultats, $actif_membre);

                $req->closeCursor();
                return $aResultats;
            } else {
                array_push($aResultats, 0);
                array_push($aResultats, 0);
                array_push($aResultats, 0);
                $req->closeCursor();
                return $aResultats;
            }
        }
    }

    // --- Insertion d'un utilisateur
    function insertUser($pseudo, $email, $mdp, $statut) {

        $email_check = md5(microtime(TRUE) * 100000);

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

    // --- envoi d'un email
    private function sendEmail($pseudo, $email, $email_check) {
        $destinataire = $email;
        $sujet = "Activation de votre compte";
        $entete = "From: gregzenegair@gmail.com";

        $message = 'Bienvenue sur Paris Resto,
 
                    Pour activer votre compte, veuillez cliquer sur le lien ci dessous :
 
                    http://localhost/Paris_Resto/Models/Activation.php?pseudo=' . urlencode($pseudo) . '&email_check=' . urlencode($email_check) . '

 
_______________
Ceci est un mail automatique, Merci de ne pas y répondre.';


        mail($destinataire, $sujet, $message, $entete); // --- Envoi du mail
    }

    // --- Afficher un ou plusieurs utilisateur
    function showUsers($id = null) {

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

    // --- pour le select des statuts
    function showStatuts() {

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

    // --- Mettre à jour un utilisateur
    function updateUser($id, $pseudo, $email, $date_inscription, $statut, $actif) {

        $tNomChampTable = ["pseudo", "email", "date_inscription", "statut", "actif"];
        $tValeurs = [":$pseudo", ":$email", ":$date_inscription", ":$statut", ":$actif"];
        $twhere['id'] = $id;
        
        DAO::update($this->_bdd, "users", $tNomChampTable, $tValeurs, $twhere);

    }

// --- Supprimer un utilisateur
    function deleteUser($id) {
        $req = $this->_bdd->prepare('DELETE FROM users WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

}