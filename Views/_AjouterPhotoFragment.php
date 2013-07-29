<?PHP
// --- Controlle de l'utilisateur avant accès à la page
include_once '../Controllers/NavigationController.php';
NavigationController::Controller($_SESSION['user']);
// --- Fin de controle
?>

<link rel="stylesheet" type="text/css" href="/Views/css/btSupprimer.css">
<div id="masqueGris"></div>
<div id="mainFrame">

    <?php
    spl_autoload_register(function ($nomClasse) {
                require_once "../Utils/Form/$nomClasse.php";
            });

    $elements = array();

    $br = new Br(0);

    $photoFormulaire = new ElementHTML('<br><br>
     <span>Photo (JPEG, PNG, GIF | Max: 500Ko) :</span><br>
     <input type="file" name="imageFile" id="imageFile" /><br><br>');
    //$inputIdh = new Input("id", "", "idh", "hidden", $_GET['id'], "", 1, null);
    $inputSubmit = new Input("ajouter", null, "ajouter", "submit", "Ajouter", "", 5, "inputGreen");

    array_push($elements, $br);
    array_push($elements, $photoFormulaire);
    //array_push($elements, $inputIdh);
    array_push($elements, $inputSubmit);

    $formulaire = new Form("mainForm", "POST", "/AjoutPhoto", $elements, "enctype='multipart/form-data'");

    echo $formulaire->genererForm();
    ?>
</div>
