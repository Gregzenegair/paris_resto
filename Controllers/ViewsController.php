<?php

session_start();




if (isset($_GET['action'])) {
    $action = $_GET['action'];


    switch ($action) {
        case "Connexion":


            break;


        default:
            break;
    }


    $redirect = "_" . $action . "Fragment.php";
}
header("Location: ./../Views/_MainView.php?fragment=" . $redirect);
?>
