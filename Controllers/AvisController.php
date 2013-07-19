<?php

include_once '../Models/AvisModel.php';
session_start();




if (isset($_GET['action'])) {
    $action = $_GET['action'];

    $CNX = new AvisModel("paris_resto", "root", "");

    switch ($action) {

        case "GererAvis":
            $resultAvis = $CNX->showAvis($_GET['id']);
            $_SESSION['afficherAvis'] = $resultAvis;
            break;

        case "Rechercher":
            $resultAvis = $CNX->seekAvis($_POST['rechercher']);
            $_SESSION['afficherAvis'] = $resultAvis;
            $action = "GererAvis";
            break;
        
        case "ModifierAvis":
            $resultAvis = $CNX->modifierAvis($_GET['id'], $_GET['actif']);
            header("Location: ./AvisController.php?action=GererAvis&id=$_GET[id_restaurant]");
            return;
            break;

        default:
            break;
    }




    $redirect = "_" . $action . "Fragment.php";
}
header("Location: ./../Views/_MainView.php?fragment=" . $redirect);
?>
