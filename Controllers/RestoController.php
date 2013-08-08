<?php

class RestoController {

    private $action;
    private $pagination;
    private $RestosCount;
    private $afficherRestos;
    private $CNX;

    function __construct($action) {
        include_once '../Models/RestoModel.php';
        include_once '../Utils/GDManager.php';

        $this->action = $action;
        $this->CNX = new RestoModel("paris_resto", "root", "");
    }

    private function rmdirAndSubs($dir) {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file))
                $this->rmdirAndSubs($file);
            else
                unlink($file);
        }
        if (is_dir($dir))
            rmdir($dir);
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
        if ($this->action != "Accueil") {
            $this->afficherRestos = $this->CNX->showRestos(null, $limiteBasse, $this->pagination);
            $this->action = "GererRestos";
        } else {
            $this->afficherRestos = $this->CNX->showRestosAccueil(null, $limiteBasse, $this->pagination);
        }
    }

    public function rooting() {
        include_once '../Models/RestoModel.php';

            switch ($this->action) {

                case "GererRestos":
                    $this->GererRestos();
                    $pagination = $this->pagination;
                    $RestosCount = $this->RestosCount;
                    $afficherRestos = $this->afficherRestos;
                    break;

                case "Accueil":
                    $this->GererRestos();
                    $pagination = $this->pagination;
                    $RestosCount = $this->RestosCount;
                    $afficherRestos = $this->afficherRestos;
                    break;

                case "RechercherResto":
                    $afficherRestos = $this->CNX->seekRestos($_POST['rechercher']);
                    $this->action = "GererRestos";
                    break;

                case "AjouterResto":
                    $afficherCategories = $this->CNX->showCategories();
                    $afficherTypesVoie = $this->CNX->showTypesVoie();
                    //$afficherVilles = $this->CNX->showVilles();  // -- Desormais géré en Ajax
                    break;

                case "AjoutResto":

                    $this->CNX->beginTransaction();

                    // -- Insertion ou selection de la ville en fonction de si elle existe ou non
                    $id_villes = $this->CNX->selectOrInsertVille($_POST['nom_ville'], $_POST['cp']);

                    // -- Insertion ou selection des 3 categories en fonction de si elles existent ou non
                    $categorie1 = $this->CNX->selectOrInsertCategorie($_POST['categorie1']);
                    $categorie2 = $this->CNX->selectOrInsertCategorie($_POST['categorie2']);
                    $categorie3 = $this->CNX->selectOrInsertCategorie($_POST['categorie3']);

                    // -- Insertion du restaurant, en retour on réccupère le dernier id inserre
                    $lastInsertId = $this->CNX->insertResto($_POST['nom'], $_POST['numero_tel'], $_POST['email'], $_POST['numero_voie'], $_POST['nom_voie'], $_POST['type_voie'], $id_villes, $_POST['description'], $_POST['horraires'], $_POST['prix']);

                    // -- Insertion des categories dans la table de liaison
                    $this->CNX->insertLigcategories($categorie1, $lastInsertId);
                    $this->CNX->insertLigcategories($categorie2, $lastInsertId);
                    $this->CNX->insertLigcategories($categorie3, $lastInsertId);

                    // -- Insertion de la photo
                    if ($_FILES['imageFile']['error'] == 0 && $_FILES['imageFile']['size'] <= 649526) {

                        $path = $_SERVER["DOCUMENT_ROOT"] . '/Views/img/restos/' . $_SESSION['idResto'] . '/';

                        $i = 0;
                        $pathFile = $path . "photo_$i" . strtolower(strrchr($_FILES['imageFile']['name'], '.'));
                        while (file_exists($pathFile)) {
                            $pathFile = $path . "photo_$i" . strtolower(strrchr($_FILES['imageFile']['name'], '.'));
                            $i++;
                        }
                        $this->CNX->insertPhoto("photo_$i" . strtolower(strrchr($_FILES['imageFile']['name'], '.')), $_SESSION['idResto']);
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        move_uploaded_file($_FILES['imageFile']['tmp_name'], $pathFile);
                        $image = new SimpleImage();
                        $image->load($pathFile);
                        $image->resizeToWidth(128);
                        $image->save($path . "photo_" . $i . "_small" . strtolower(strrchr($_FILES['imageFile']['name'], '.')));
                    }

                    if (isset($resultat)) {
                        $this->CNX->commit();
                    } else {
                        $erreurMsg = "Un problème lors de la copie de l'image est survenu, le restaurant n'a pas été ajouté.<br>";
                        $this->CNX->rollback();
                    }

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
                        $path = $_SERVER["DOCUMENT_ROOT"] . '/Views/img/restos/' . $_POST['id'];
                        $this->rmdirAndSubs($path);
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

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/_MainView.php";
    }

}