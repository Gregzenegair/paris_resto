<?php

class CategorieController {

    private $action;
    private $CNX;

    function __construct($action) {
        include_once '../Models/CategorieModel.php';

        $this->action = $action;
        $this->CNX = new CategorieModel("paris_resto", "root", "");
    }

    public function rooting() {


        if (isset($this->action)) {


            switch ($this->action) {

                case "GererCategories":
                    $resultCategories = $this->CNX->showCategories();
                    $this->action = "GererCategories";
                    break;

                case "RechercherCategorie":
                    $resultCategories = $this->CNX->seekCategories($_POST['rechercher']);
                    $action = "GererCategories";
                    break;

                case "SupprimerCategorie":
                    $resultCategories = $this->CNX->deleteCategorie($_GET['id']);
                    $resultCategories = $this->CNX->showCategories();
                    $this->action = "GererCategories";
                    break;

                default :
                    break;
            }


            $fragment = "_" . $this->action . "Fragment.php";
        }

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/_MainView.php";
    }

}
