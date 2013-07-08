<?php

include_once '../Models/UserModel.php';
session_start();




if (isset($_GET['action'])) {
    $action = $_GET['action'];

    $CNX = new UserModel("paris_resto", "root", "");

    switch ($action) {
        case "Inscription":
            $result = $CNX->insertUser($_POST['pseudo'], $_POST['email'], md5($_POST['mdp']), 0);
            $action = "Accueil";

            break;

        case "Connexion":
            $result = $CNX->connectUser($_POST['email'], $_POST['mdp']);

            if ($result[0] != 0) {
                if ($result[2] == 1) {
                    $_SESSION['user'] = $result;
                } else {
                    $_SESSION['user'] = "inactif";
                }
            } else {
                $_SESSION['user'] = "";
            }
            $action = "Accueil";

            break;

        case "Deconnexion":

            $_SESSION['user'] = "";
            $action = "Accueil";

            break;

        case "GererUtilisateurs":

            $result = $CNX->showUsers();
            foreach ($result as $key => $value) {
                $split = split("-", $value['date_inscription']);
                $date = $split[2] . "/" . $split[1] . "/" . $split[0];
                $result[$key]['date_inscription'] = $date;

                if ($result[$key]['actif'] == 0) {
                    $result[$key]['actif'] = "Inactif";
                } else {
                    $result[$key]['actif'] = "Actif";
                }
            }
            $_SESSION['afficherUsers'] = $result;

            break;

        case "ModifierUtilisateur":

            $result = $CNX->showUsers($_GET['id']);
            if ($result[0]['actif'] == 0) {
                $result[0]['actif'] = "Inactif";
            } else {
                $result[0]['actif'] = "Actif";
            }
            $result2 = $CNX->showStatuts();
            $_SESSION['afficherStatuts'] = $result2;
            $_SESSION['afficherUser'] = $result;

            break;
        case "Modification":

            if (!empty($_POST['modifier'])) {
                $CNX->updateUser($_POST['id'], $_POST['pseudo'], $_POST['email'], $_POST['date_inscription'], $_POST['statut'], $_POST['actif']);
            } else if (!empty($_POST['supprimer'])) {
                $CNX->deleteUser($_POST['id']);
            }

            header("Location: ./UserController.php?action=GererUtilisateurs");
            return;
            break;
        default:
            break;
    }


    $redirect = "_" . $action . "Fragment.php";
}
header("Location: ./../Views/_MainView.php?fragment=" . $redirect);
?>
