<?php

require_once 'CategorieController.php';
require_once 'RestoController.php';
require_once 'UserController.php';
include_once 'VilleController.php';
include_once 'PhotoController.php';

// Capture de l'element action s'il est defini.
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {

        // -- L'accueil
        case "Accueil":
            include $_SERVER["DOCUMENT_ROOT"] . "/Views/_MainView.php";
            exit();
            break;

        // -- Les catergories
        case "GererCategories": case "RechercherCategorie": case "SupprimerCategorie":
            $CategorieController = new CategorieController($action);
            $CategorieController->rooting();
            exit();
            break;

        // -- Les villes
        case "GererVilles": case "RechercherVille": case "SupprimerVille":
            $UserController = new VilleController($action);
            $UserController->rooting();
            exit();
            break;

        // -- Les restaurants
        case "GererRestos": case "RechercherResto": case "AjouterResto": case "AjoutResto": case "ModifierResto": case "ModificationResto":
            $RestoController = new RestoController($action);
            $RestoController->rooting();
            exit();
            break;

        // -- Les utilisateurs, l'authentification et l'inscription
        case "Inscription": case "Connexion": case "Deconnexion": case "GererUtilisateurs": case "RechercherUtilisateur": case "ModifierUtilisateur": case "ModificationUtilisateur": case "Inscrire":
            $UserController = new UserController($action);
            $UserController->rooting();
            exit();
            break;
        
        // -- Gestion des photos
        case "GererPhotos": case "SupprimerPhoto": case "AjouterPhoto": case "AjoutPhoto":
            $PhotoController = new PhotoController($action);
            $PhotoController->rooting();
            exit();
            break;

        default :
            break;
    }
}