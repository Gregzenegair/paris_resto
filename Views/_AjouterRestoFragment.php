<link rel="stylesheet" type="text/css" href="css/btSupprimer.css">
<div id="masqueGris"></div>
<div id="mainFrame">

    <?php
    include_once '../Controllers/Form/Form.php';
    include_once '../Controllers/Form/Br.php';
    include_once '../Controllers/Form/Input.php';
    include_once '../Controllers/Form/Select.php';
    include_once '../Controllers/Form/DataList.php';
    include_once '../Controllers/Form/ElementHTML.php';

    $elements = array();

    $br = new Br(0);

    $tListePhotos = array();
    $tListeNotes = array();
    $tListeElemCategories = $_SESSION['afficherCategories'];
    $tListeElemTypesVoie = $_SESSION['afficherTypesVoie'];
    $tListeElemVilles = $_SESSION['afficherVilles'];


    $inputNom = new Input("nom", "Nom du restaurant :", "nom", "text", "", "required", 1, null);
    $inputNumero_tel = new Input("numero_tel", "Numéro de téléphone :", "numero_tel", "text", "", "", 1, null);
    $inputEmail = new Input("email", "Email :", "email", "text", "", null, 1, null);

    $selectTypeVoie = new Select("type_voie", "", $tListeElemTypesVoie, "type_voie", null, 1, "required", "select");
    $inputNumeroVoie = new Input("numero_voie", "Adresse :", "numero_voie", "number", "", "required min='1'", 1, null);
    $inputNomVoie = new Input("nom_voie", "", "nom_voie", "text", "", "required", 1, null);

    $selectCategories1 = new DataList("categorie1", "Categories :", $tListeElemCategories, "categorie1", null, 1, "", "selectCategorie");
    $selectCategories2 = new DataList("categorie2", "", $tListeElemCategories, "categorie2", null, 1, "", "selectCategorie");
    $selectCategories3 = new DataList("categorie3", "", $tListeElemCategories, "categorie3", null, 1, "", "selectCategorie");

    $selectVilles = new DataList("nom_ville", "Ville :", $tListeElemVilles, "nom_ville", null, 1, "", "select");

    $inputCp = new Input("cp", "Code postal :", "cp", "text", "", "", 1, null);

    $inputSubmit = new Input("ajouter", null, "ajouter", "submit", "Ajouter", "", 5, "inputGreen");


    array_push($elements, $br);
    array_push($elements, $inputNom);
    array_push($elements, $selectCategories1);
    array_push($elements, $selectCategories2);
    array_push($elements, $selectCategories3);
    array_push($elements, $inputNumero_tel);
    array_push($elements, $inputEmail);
    array_push($elements, $inputNumeroVoie);
    array_push($elements, $selectTypeVoie);
    array_push($elements, $inputNomVoie);
    array_push($elements, $selectVilles);
    array_push($elements, $inputCp);
    array_push($elements, $br);
    array_push($elements, $inputSubmit);

    $formulaire = new Form("mainForm", "POST", "./../Controllers/RestoController.php?action=Ajout", $elements);

    echo $formulaire->genererForm();
    ?>
</div>

