<?php

include_once '../Models/VilleModel.php';
session_start();




if (isset($_GET['action'])) {
    $action = $_GET['action'];

    $CNX = new VilleModel("paris_resto", "root", "");

    switch ($action) {

        case "GererVilles":
            $resultVilles = $CNX->showVilles();
            $_SESSION['afficherVilles'] = $resultVilles;
            break;

        case "Rechercher":
            $resultVilles = $CNX->seekVilles($_POST['rechercher']);
            $_SESSION['afficherVilles'] = $resultVilles;
            $action = "GererVilles";
            break;
        
        case "SupprimerVille":
            $resultVilles = $CNX->deleteVille($_GET['id']);
            header("Location: ./VilleController.php?action=GererVilles");
            return;
            break;

        default:
            break;
    }




    $redirect = "_" . $action . "Fragment.php";
}
header("Location: ./../Views/_MainView.php?fragment=" . $redirect);
?>
