<?php

include_once '../Models/RestoModel.php';
session_start();




if (isset($_GET['action'])) {
    $action = $_GET['action'];

    $CNX = new RestoModel("paris_resto", "root", "");

    switch ($action) {

        case "GererRestos":
            $resultRestos = $CNX->showRestos();
            $_SESSION['afficherRestos'] = $resultRestos;
            break;

        case "AjouterResto":
            $resultCategories = $CNX->showCategories();
            $_SESSION['afficherCategories'] = $resultCategories;
            $resultTypesVoie = $CNX->showTypesVoie();
            $_SESSION['afficherTypesVoie'] = $resultTypesVoie;
            $resultVilles = $CNX->showVilles();
            $_SESSION['afficherVilles'] = $resultVilles;
            break;

        case "Ajout":

            $id_villes = $CNX->insertVille($_POST['nom_ville'], $_POST['cp']);

            $CNX->insertResto($_POST['nom'], $_POST['numero_tel'], $_POST['email'], $_POST['numero_voie'], $_POST['nom_voie'], $_POST['type_voie'], $id_villes);

            header("Location: ./UserController.php?action=GererRestos");
            return;

            break;

        default:
            break;
    }




    $redirect = "_" . $action . "Fragment.php";
}
header("Location: ./../Views/_MainView.php?fragment=" . $redirect);
?>
