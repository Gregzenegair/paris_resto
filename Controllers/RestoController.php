<?php

include_once '../Models/UserModel.php';
session_start();




if (isset($_GET['action'])) {
    $action = $_GET['action'];

    $CNX = new UserModel("paris_resto", "root", "");

    switch ($action) {
        case "Ajout":


            break;

        default:
            break;
    }


    $redirect = "_" . $action . "Fragment.php";
}
header("Location: ./../Views/_MainView.php?fragment=" . $redirect);
?>
