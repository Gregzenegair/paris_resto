<?php

include_once '../Models/CategorieModel.php';
session_start();




if (isset($_GET['action'])) {
    $action = $_GET['action'];

    $CNX = new CategorieModel("paris_resto", "root", "");

    switch ($action) {

        case "GererPhoto":
            $resultPhotos = $CNX->showPhotos();
            $_SESSION['afficherPhotos'] = $resultPhotos;
            break;

        default:
            break;
    }




    $redirect = "_" . $action . "Fragment.php";
}
header("Location: ./../Views/_MainView.php?fragment=" . $redirect);
?>
