<?php

class PhotoController {

    private $action;
    private $CNX;

    function __construct($action) {
        include_once '../Models/PhotoModel.php';
        include_once '../Utils/GDManager.php';

        $this->action = $action;
        $this->CNX = new PhotoModel("paris_resto", "root", "");
    }

    public function rooting() {


        if (isset($this->action)) {


            switch ($this->action) {

                case "GererPhotos":
                    $_SESSION['idResto'] = $_GET['id'];
                    $afficherPhotos = $this->CNX->showPhotos();
                    $this->action = "GererPhotos";
                    break;

                case "SupprimerPhoto":
                    $id = $_GET['id'];
                    $nomPhoto = $this->CNX->showPhotos($id);
                    $path = $_SERVER["DOCUMENT_ROOT"] . '/Views/img/restos/' . $_SESSION['idResto'] . '/';
                    $extensionPhoto = strtolower(strrchr($nomPhoto[0]['nom_fichier'], '.'));
                    $nomFichierPhoto = explode(".", $nomPhoto[0]['nom_fichier']);
                    $pathFile = $path . $nomPhoto[0]['nom_fichier'];
                    $pathFileSmall = $path . $nomFichierPhoto[0] . "_small" . $extensionPhoto;
                    if (file_exists($pathFile)) {
                        unlink($pathFile);
                        unlink($pathFileSmall);
                        $ok = true;
                    }
                    if ($ok) {
                        $this->CNX->deletePhoto($id);
                    }
                    $afficherPhotos = $this->CNX->showPhotos();
                    $this->action = "GererPhotos";
                    break;

                case "AjoutPhoto":

                    if ($_FILES['imageFile']['error'] == 0 && $_FILES['imageFile']['size'] <= 649526) {

                        $path = $_SERVER["DOCUMENT_ROOT"] . '/Views/img/restos/' . $_SESSION['idResto'] . '/';

                        $i = 0;
                        $pathFile = $path . "photo_$i" . strtolower(strrchr($_FILES['imageFile']['name'], '.'));
                        while (file_exists($pathFile)) {
                            $i++;
                            $pathFile = $path . "photo_$i" . strtolower(strrchr($_FILES['imageFile']['name'], '.'));
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
                    $afficherPhotos = $this->CNX->showPhotos();
                    $this->action = "GererPhotos";
                    break;


                default :
                    break;
            }


            $fragment = "_" . $this->action . "Fragment.php";
        }

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/_MainView.php";
    }

}
