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

        case "Rechercher":
            $resultRestos = $CNX->seekRestos($_POST['rechercher']);
            $_SESSION['afficherRestos'] = $resultRestos;
            $action = "GererRestos";
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

            $CNX->beginTransaction();

            $id_villes = $CNX->selectOrInsertVille($_POST['nom_ville'], $_POST['cp']);
            $categorie1 = $CNX->selectOrInsertCategorie($_POST['categorie1']);
            $categorie2 = $CNX->selectOrInsertCategorie($_POST['categorie2']);
            $categorie3 = $CNX->selectOrInsertCategorie($_POST['categorie3']);

            $lastInsertId = $CNX->insertResto($_POST['nom'], $_POST['numero_tel'], $_POST['email'], $_POST['numero_voie'], $_POST['nom_voie'], $_POST['type_voie'], $id_villes, $_POST['description'], $_POST['horraires'], $_POST['prix']);

            $CNX->insertLigcategories($categorie1, $lastInsertId);
            $CNX->insertLigcategories($categorie2, $lastInsertId);
            $CNX->insertLigcategories($categorie3, $lastInsertId);

            $CNX->commit();
            header("Location: ./RestoController.php?action=GererRestos");
            return;
            break;

        case "ModifierResto":

            $resultResto = $CNX->showRestos($_GET['id']);
            $resultCategoriesResto = explode(",", $resultResto[0]['categories']);

            $i = 1;
            foreach ($resultCategoriesResto as $value) {
                $resultResto[0]['categorie' . $i] = $value;
                $i++;
            }

            $_SESSION['afficherResto'] = $resultResto;
            $resultCategories = $CNX->showCategories();
            $_SESSION['afficherCategories'] = $resultCategories;
            $resultTypesVoie = $CNX->showTypesVoie();
            $_SESSION['afficherTypesVoie'] = $resultTypesVoie;
            $resultVilles = $CNX->showVilles();
            $_SESSION['afficherVilles'] = $resultVilles;

            break;

        case "Modification" :

            if (!empty($_POST['modifier'])) {
                $CNX->beginTransaction();
                $CNX->deleteLigcategories($_POST['id']);
                $id_villes = $CNX->selectOrInsertVille($_POST['nom_ville'], $_POST['cp']);
                $categorie1 = $CNX->selectOrInsertCategorie($_POST['categorie1']);
                $categorie2 = $CNX->selectOrInsertCategorie($_POST['categorie2']);
                $categorie3 = $CNX->selectOrInsertCategorie($_POST['categorie3']);

                $CNX->updateResto($_POST['id'], $_POST['nom'], $_POST['numero_tel'], $_POST['email'], $_POST['numero_voie'], $_POST['nom_voie'], $_POST['type_voie'], $id_villes, $_POST['description'], $_POST['horraires'], $_POST['prix']);

                $CNX->insertLigcategories($categorie1, $_POST['id']);
                $CNX->insertLigcategories($categorie2, $_POST['id']);
                $CNX->insertLigcategories($categorie3, $_POST['id']);

                $CNX->commit();
            } else if (!empty($_POST['supprimer'])) {
                $CNX->deleteResto($_POST['id']);
            }
            header("Location: ./RestoController.php?action=GererRestos");
            return;
            break;
        default:
            break;
    }




    $redirect = "_" . $action . "Fragment.php";
}
header("Location: ./../Views/_MainView.php?fragment=" . $redirect);
?>
