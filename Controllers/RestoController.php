<?php

class RestoController {

    private $action;
    private $pagination;
    private $RestosCount;
    private $afficherRestos;
    private $CNX;

    function __construct($action) {
        include_once '../Models/RestoModel.php';

        $this->action = $action;
        $this->CNX = new RestoModel("paris_resto", "root", "");
    }

    private function GererRestos() {

        // Limite basse represente la page en cours
        if (isset($_GET['limiteBasse'])) {
            $limiteBasse = $_GET['limiteBasse'];
        } else {
            $limiteBasse = $_GET['limiteBasse'] = 0;
        }
        // -- Determine la pagination de l'affichage des restaurants
        $this->pagination = 50;
        $this->RestosCount = $this->CNX->countRestos();
        $this->afficherRestos = $this->CNX->showRestos(null, $limiteBasse, $this->pagination);
        $this->action = "GererRestos";
    }

    public function rooting() {
        include_once '../Models/RestoModel.php';

        if (isset($this->action)) {

            switch ($this->action) {

                case "GererRestos":
                    $this->GererRestos();
                    $pagination = $this->pagination;
                    $RestosCount = $this->RestosCount;
                    $afficherRestos = $this->afficherRestos;
                    $this->action = "GererRestos";
                    break;

                case "RechercherResto":
                    $afficherRestos = $this->CNX->seekRestos($_POST['rechercher']);
                    $this->action = "GererRestos";
                    break;

                case "AjouterResto":
                    $afficherCategories = $this->CNX->showCategories();
                    $afficherTypesVoie = $this->CNX->showTypesVoie();
                    $afficherVilles = $this->CNX->showVilles();
                    break;

                case "AjoutResto":

                    $this->CNX->beginTransaction();

                    $id_villes = $this->CNX->selectOrInsertVille($_POST['nom_ville'], $_POST['cp']);
                    $categorie1 = $this->CNX->selectOrInsertCategorie($_POST['categorie1']);
                    $categorie2 = $this->CNX->selectOrInsertCategorie($_POST['categorie2']);
                    $categorie3 = $this->CNX->selectOrInsertCategorie($_POST['categorie3']);

                    $lastInsertId = $this->CNX->insertResto($_POST['nom'], $_POST['numero_tel'], $_POST['email'], $_POST['numero_voie'], $_POST['nom_voie'], $_POST['type_voie'], $id_villes, $_POST['description'], $_POST['horraires'], $_POST['prix']);

                    $this->CNX->insertLigcategories($categorie1, $lastInsertId);
                    $this->CNX->insertLigcategories($categorie2, $lastInsertId);
                    $this->CNX->insertLigcategories($categorie3, $lastInsertId);

                    $this->CNX->commit();

                    $this->GererRestos();
                    $pagination = $this->pagination;
                    $RestosCount = $this->RestosCount;
                    $afficherRestos = $this->afficherRestos;
                    $this->action = "GererRestos";
                    break;

                case "ModifierResto":

                    $afficherResto = $this->CNX->showRestos($_GET['id']);
                    $resultCategoriesResto = explode(",", $afficherResto[0]['categories']);

                    $i = 1;
                    foreach ($resultCategoriesResto as $value) {
                        $afficherResto[0]['categorie' . $i] = $value;
                        $i++;
                    }

                    $afficherCategories = $this->CNX->showCategories();
                    $afficherTypesVoie = $this->CNX->showTypesVoie();
                    $afficherVilles = $this->CNX->showVilles();

                    break;

                case "ModificationResto" :

                    if (!empty($_POST['modifier'])) {
                        $this->CNX->beginTransaction();
                        $this->CNX->deleteLigcategories($_POST['id']);
                        $id_villes = $this->CNX->selectOrInsertVille($_POST['nom_ville'], $_POST['cp']);
                        $categorie1 = $this->CNX->selectOrInsertCategorie($_POST['categorie1']);
                        $categorie2 = $this->CNX->selectOrInsertCategorie($_POST['categorie2']);
                        $categorie3 = $this->CNX->selectOrInsertCategorie($_POST['categorie3']);

                        $this->CNX->updateResto($_POST['id'], $_POST['nom'], $_POST['numero_tel'], $_POST['email'], $_POST['numero_voie'], $_POST['nom_voie'], $_POST['type_voie'], $id_villes, $_POST['description'], $_POST['horraires'], $_POST['prix']);

                        $this->CNX->insertLigcategories($categorie1, $_POST['id']);
                        $this->CNX->insertLigcategories($categorie2, $_POST['id']);
                        $this->CNX->insertLigcategories($categorie3, $_POST['id']);

                        $this->CNX->commit();
                    } else if (!empty($_POST['supprimer'])) {
                        $this->CNX->deleteResto($_POST['id']);
                    }

                    $this->GererRestos();
                    $pagination = $this->pagination;
                    $RestosCount = $this->RestosCount;
                    $afficherRestos = $this->afficherRestos;

                    $this->action = "GererRestos";
                    
                    break;
                default:
                    break;
            }


            $fragment = "_" . $this->action . "Fragment.php";
        }

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/_MainView.php";
    }

}