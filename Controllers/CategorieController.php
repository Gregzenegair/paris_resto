<?php

include_once '../Models/CategorieModel.php';
session_start();




if (isset($_GET['action'])) {
    $action = $_GET['action'];

    $CNX = new CategorieModel("paris_resto", "root", "");

    switch ($action) {

        case "GererCategories":
            $resultCategories = $CNX->showCategories();
            $_SESSION['afficherCategories'] = $resultCategories;
            break;

        case "Rechercher":
            $resultCategories = $CNX->seekCategories($_POST['rechercher']);
            $_SESSION['afficherCategories'] = $resultCategories;
            $action = "GererCategories";
            break;
        
        case "SupprimerCategorie":
            $resultCategories = $CNX->deleteCategorie($_GET['id']);
            header("Location: ./CategorieController.php?action=GererCategories");
            return;
            break;

        default:
            break;
    }




    $redirect = "_" . $action . "Fragment.php";
}
header("Location: ./../Views/_MainView.php?fragment=" . $redirect);
?>
