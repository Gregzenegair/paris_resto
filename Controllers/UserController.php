<?php

class UserController {

    private $action;
    private $CNX;

    function __construct($action) {
        include_once '../Models/UserModel.php';

        $this->action = $action;
        $this->CNX = new UserModel("paris_resto", "root", "");
    }

    private function GererUtilisateus() {

        // Limite basse represente la page en cours
        if (isset($_GET['limiteBasse'])) {
            $limiteBasse = $_GET['limiteBasse'];
        } else {
            $limiteBasse = $_GET['limiteBasse'] = 0;
        }
        // -- Determine la pagination de l'affichage des restaurants
        $this->pagination = 50;
        $this->userCount = $this->CNX->countUsers();
        $this->afficherUsers = $this->CNX->showUsers(null, $limiteBasse, $this->pagination);
        $this->action = "GererUtilisateurs";
    }

    public function rooting() {
        if (isset($_GET['action'])) {
            $this->action = $_GET['action'];

            switch ($this->action) {
                case "Inscription":
                    $result = $this->CNX->insertUser($_POST['pseudo'], $_POST['email'], md5($_POST['mdp']), 0);
                    $this->action = "Accueil";

                    break;

                case "Connexion":
                    $result = $this->CNX->connectUser($_POST['email'], $_POST['mdp']);

                    if ($result[0] != 0) {
                        if ($result['actif'] == 1) {
                            $_SESSION['user'] = $result;
                        } else {
                            $_SESSION['user'] = "inactif";
                        }
                    } else {
                        $_SESSION['user'] = "";
                    }
                    $this->action = "Accueil";

                    break;

                case "Deconnexion":

                    $_SESSION['user'] = "";
                    $this->action = "Accueil";

                    break;

                // --- Lorsque l'on clique sur le bouton pour voir la liste des utilisateurs
                case "GererUtilisateurs":

                    if (isset($_GET['limiteBasse'])) {
                        $limiteBasse = $_GET['limiteBasse'];
                    } else {
                        $limiteBasse = $_GET['limiteBasse'] = 0;
                    }
                    // -- Determine la pagination de l'affichage des utilisateurs
                    $this->GererUtilisateus();
                    $pagination = $this->pagination;
                    $usersCount = $this->userCount;
                    $afficherUsers = $this->afficherUsers;

                    break;

                case "RechercherUtilisateur":
                    $afficherUsers = $this->CNX->seekUsers($_POST['rechercher']);
                    $this->action = "GererUtilisateurs";
                    break;

                // --- Lorsque l'on clique sur le bouton pour aller modifier 1 utilisateur
                case "ModifierUtilisateur":

                    $afficherUser = $this->CNX->showUsers($_GET['id']);
                    $afficherUserStatuts = $this->CNX->showStatuts();

                    break;

                // --- Lorsque l'on clique sur le bouton pour modifier (valider la modification) un utilisateur
                case "ModificationUtilisateur":

                    if (!empty($_POST['modifier'])) {
                        $this->CNX->updateUser($_POST['id'], $_POST['pseudo'], $_POST['email'], $_POST['date_inscription'], $_POST['statut'], $_POST['actif']);
                    } else if (!empty($_POST['supprimer'])) {
                        $this->CNX->deleteUser($_POST['id']);
                    }
                    $this->GererUtilisateus();
                    $pagination = $this->pagination;
                    $usersCount = $this->userCount;
                    $afficherUsers = $this->afficherUsers;
                    $this->action = "GererUtilisateurs";
                    break;
                default:
                    break;
            }


            $fragment = "_" . $this->action . "Fragment.php";
        }

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/_MainView.php";
    }

}
