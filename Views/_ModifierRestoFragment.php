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

    if (!empty($_SESSION['afficherResto'])) {
        $tRestos = $_SESSION['afficherResto'];
        $tListePhotos = array();
        $tListeNotes = array();


        foreach ($tRestos as $value) {
            $inputId = new Input("idv", "Id :", "id", "text", $value['id'], "disabled", 1, null);
            $inputIdh = new Input("id", "", "idh", "hidden", $value['id'], "", 1, null);
            $inputNom = new Input("nom", "Nom du restaurant :", "nom", "text", $value['nom'], "required", 1, null);
            $inputNumero_tel = new Input("numero_tel", "Numéro de téléphone :", "numero_tel", "text", $value['nuùero_tel'], "required", 1, null);
            $inputEmail = new Input("email", "Email :", "email", "text", $value['email'], null, 1, null);


            $inputAdresse = new Input("adresse", "Adresse :", "adresse", "text", $value['adresse'], "required", 1, null);
            $inputVille = new Input("villle", "Ville :", "ville", "text", $value['ville'], "required", 1, null);
            $inputCp = new Input("cp", "Code postal :", "cp", "text", $value['cp'], "required", 1, null);
        }

        $inputSubmit = new Input("modifier", null, "modifier", "submit", "Modifier", "", 5, "inputGreen");
        $inputButton = new Input("btSupprimer", null, "btSupprimer", "button", "Supprimer utilisateur", "", 5, "inputRed");
        $HTMLdivS = new ElementHTML("<div id='modale'>");
        $HTMLp = new ElementHTML("<p>Etes-vous certain de vouloir supprimer ce restaurant ?</p>");
        $inputSubmitOui = new Input("supprimer", null, "supprimer", "submit", "Oui", "", 5, "inputRed");
        $inputButtonNon = new Input("btSupprimerNon", null, "btSupprimerNon", "button", "Non", "", 5, "inputGreen");
        $HTMLdivE = new ElementHTML("</div>");



        array_push($elements, $br);
        array_push($elements, $inputSubmit);
        array_push($elements, $inputButton);
        array_push($elements, $HTMLdivS);
        array_push($elements, $HTMLp);
        array_push($elements, $inputSubmitOui);
        array_push($elements, $inputButtonNon);
        array_push($elements, $HTMLdivE);

        $formulaire = new Form("mainForm", "POST", "./../Controllers/UserController.php?action=Modification", $elements);

        echo $formulaire->genererForm();
    }
    ?>
</div>

<script src="js/btSupprimer.js"></script>