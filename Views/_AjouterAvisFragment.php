<?PHP
// --- Controlle de l'utilisateur avant accès à la page
include_once '../Controllers/NavigationController.php';
NavigationController::Controller($_SESSION['user']);
// --- Fin de controle
?>

<link rel="stylesheet" type="text/css" href="css/btSupprimer.css">
<div id="masqueGris"></div>
<div id="mainFrame">

    <?php
    spl_autoload_register(function ($nomClasse) {
                require_once "../Controllers/Form/$nomClasse.php";
            });

    $elements = array();

    $br = new Br(0);


    $tListeTypesNotes = $_SESSION['afficherTypesNotes'];
    //$tListeTypesNotes = ["cuisine", "ambiance", "prix", "confort", "service"];

    $inputTitre = new Input("titre", "Titre :", "titre", "text", "", "", 1, null);
    $textareaDescription = new ElementHTML("<legend for='description'>Votre commentaire :</legend><textarea name='description' id='description' placeholder='Description du restaurant, menu, informations relatives'></textarea>");

    $tSelectTypeNoteh = array();
    $i = 0;

    foreach ($tListeTypesNotes as $value) {
        ?>
        <table><tr>
                <td><?PHP echo $value; ?> : </td>
                <td id="<?PHP echo $value . "0"; ?>"><img src="img/star.png"></td>
                <td id="<?PHP echo $value . "1"; ?>"><img src="img/star.png"></td>
                <td id="<?PHP echo $value . "2"; ?>"><img src="img/star.png"></td>
                <td id="<?PHP echo $value . "3"; ?>"><img src="img/star.png"></td>
                <td id="<?PHP echo $value . "4"; ?>"><img src="img/star.png"></td>
            </tr></table>
        <?PHP
        $tSelectTypeNoteh[$i] = new Input("id$value", "", "idh$value", "hidden", "", "", 1, null);
        $i++;
    }

    $inputSubmit = new Input("ajouter", null, "ajouter", "submit", "Ajouter", "", 5, "inputGreen");


    array_push($elements, $br);
    array_push($elements, $inputTitre);
    array_push($elements, $textareaDescription);
    foreach ($tSelectTypeNoteh as $value) {
        array_push($elements, $value);
    }
    array_push($elements, $br);
    array_push($elements, $inputSubmit);

    $formulaire = new Form("mainForm", "POST", "./../Controllers/RestoController.php?action=Ajout", $elements);

    echo $formulaire->genererForm();
    ?>
</div>
<script src="js/ajouterRestoForm.js"></script>