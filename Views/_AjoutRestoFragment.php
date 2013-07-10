<link rel="stylesheet" type="text/css" href="css/btSupprimer.css">
<div id="masqueGris"></div>
<div id="mainFrame">

    <?php
    include_once '../Controllers/Form/Form.php';
    include_once '../Controllers/Form/Br.php';
    include_once '../Controllers/Form/Input.php';
    include_once '../Controllers/Form/Select.php';
    include_once '../Controllers/Form/ElementHTML.php';

    $elements = array();

    $br = new Br(0);

    $tListePhotos = array();
    $tListeNotes = array();



    $inputNom = new Input("nom", "Nom du restaurant :", "nom", "text", "", "required", 1, null);
    $inputNumero_tel = new Input("numero_tel", "Numéro de téléphone :", "numero_tel", "text", "", "required", 1, null);
    $inputEmail = new Input("email", "Email :", "email", "text", "", null, 1, null);


    $inputAdresse = new Input("adresse", "Adresse :", "adresse", "text", "", "required", 1, null);
    $inputVille = new Input("villle", "Ville :", "ville", "text", "", "required", 1, null);
    $inputCp = new Input("cp", "Code postal :", "cp", "text", "", "required", 1, null);

    $inputSubmit = new Input("ajouter", null, "ajouter", "submit", "Ajouter", "", 5, "inputGreen");




    array_push($elements, $br);
    array_push($elements, $inputNom);
    array_push($elements, $inputNumero_tel);
    array_push($elements, $inputEmail);
    array_push($elements, $inputAdresse);
    array_push($elements, $inputVille);
    array_push($elements, $inputCp);
    array_push($elements, $inputSubmit);

    $formulaire = new Form("mainForm", "POST", "./../Controllers/UserController.php?action=Modification", $elements);

    echo $formulaire->genererForm();
    ?>
</div>