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

    $tListePhotos = array();
    $tListeNotes = array();

    $inputNom = new Input("nom", "Nom du restaurant :", "nom", "text", "", "required", 1, null);

    $selectCategories1 = new DataList("categorie1", "Categories :", $afficherCategories, "categorie1", null, "", 1, "selectCategorie");
    $selectCategories2 = new DataList("categorie2", "", $afficherCategories, "categorie2", null, "", 1, "selectCategorie");
    $selectCategories3 = new DataList("categorie3", "", $afficherCategories, "categorie3", null, "", 1, "selectCategorie");

    $inputNumero_tel = new Input("numero_tel", "Numéro de téléphone :", "numero_tel", "text", "", "", 1, null);
    $inputEmail = new Input("email", "Email :", "email", "text", "", null, 1, null);
    $DatalistTypeVoie = new DataList("type_voie", "", $afficherTypesVoie, "type_voie", "", "required", 1, "");
    $inputNumeroVoie = new Input("numero_voie", "Adresse :", "numero_voie", "input", "", "required", 1, "");
    $inputNomVoie = new Input("nom_voie", "", "nom_voie", "text", "", "required", 1, null);

    $textareaDescription = new ElementHTML("<legend for='description'>Description du restaurant : </legend><textarea name='description' id='description' placeholder='Description du restaurant, menu, informations relatives'></textarea>");
    $inputHorraires = new Input("horraires", "Horraires :", "horraires", "text", "", "placeholder='Ouvert du lundi au samedi'", 1, null);
    $inputPrix = new Input("prix", "Prix :", "prix", "text", "", "placeholder='15€-25€'", 1, null);

    $selectVilles = new DataList("nom_ville", "Ville :", $afficherVilles, "nom_ville", "", "required", 1, "select");
    $inputCp = new Input("cp", "Code postal :", "cp", "text", "", "required", 1, null);

    $inputSubmit = new Input("ajouter", null, "ajouter", "submit", "Ajouter", "", 5, "inputGreen");


    array_push($elements, $br);
    array_push($elements, $inputNom);
    array_push($elements, $selectCategories1);
    array_push($elements, $selectCategories2);
    array_push($elements, $selectCategories3);
    array_push($elements, $inputNumero_tel);
    array_push($elements, $inputEmail);
    array_push($elements, $inputNumeroVoie);
    array_push($elements, $DatalistTypeVoie);
    array_push($elements, $inputNomVoie);
    array_push($elements, $textareaDescription);
    array_push($elements, $inputHorraires);
    array_push($elements, $inputPrix);
    array_push($elements, $selectVilles);
    array_push($elements, $inputCp);
    array_push($elements, $br);
    array_push($elements, $inputSubmit);

    $formulaire = new Form("mainForm", "POST", "/AjoutResto", $elements);

    echo $formulaire->genererForm();
    ?>
</div>
<script src="/Views/js/ajouterRestoForm.js"></script>
