<?php

include_once '../Models/RestoModel.php';
session_start();




if (isset($_GET['action'])) {
    $action = $_GET['action'];

    $CNX = new RestoModel("paris_resto", "root", "");

    switch ($action) {
        case "Ajout":

            $CNX->insertResto($_POST['nom'], $_POST['id_categorie'], $_POST['numero_tel'], $_POST['email'], $_POST['id_adresse'], $_POST['id_note'], $_POST['id_photo']);

            $action = "GererRestos";
            break;

        default:
            break;
    }


    $redirect = "_" . $action . "Fragment.php";
}
header("Location: ./../Views/_MainView.php?fragment=" . $redirect);
?>
