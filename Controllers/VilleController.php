<?php

class VilleController {

    private $action;
    private $CNX;

    function __construct($action) {
        include_once '../Models/VilleModel.php';

        $this->action = $action;
        $this->CNX = new VilleModel("paris_resto", "root", "");
    }

    public function rooting() {

        switch ($this->action) {

            case "GererVilles":
                if (!isset($_GET['departement'])) {
                    $departement = "95";
                } else {
                    $departement = $_GET['departement'];
                }
                $villesCount = $this->CNX->countVilles();
                $afficherVilles = $this->CNX->showVilles($departement);
                $this->action = "GererVilles";
                break;

            case "RechercherVille":
                $afficherVilles = $this->CNX->seekVilles($_POST['rechercher']);
                $this->action = "GererVilles";
                break;

            case "SupprimerVille":
                $afficherVilles = $this->CNX->deleteVille($_GET['id']);
                if (!isset($_GET['departement'])) {
                    $departement = "95";
                } else {
                    $departement = $_GET['departement'];
                }
                $villesCount = $this->CNX->countVilles();
                $afficherVilles = $this->CNX->showVilles($departement);
                $this->action = "GererVilles";
                break;

            default:
                break;
        }




        $fragment = "_" . $this->action . "Fragment.php";

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/_MainView.php";
    }

}