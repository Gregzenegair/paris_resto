<link rel="stylesheet" type="text/css" href="css/btSupprimer.css">
<div id="masqueGris"></div>
<div id="mainFrame">

    <?php
    spl_autoload_register(function ($nomClasse) {
                require_once "../Utils/Form/$nomClasse.php";
            });

    $elements = array();

    $br = new Br(0);

    if (!empty($_SESSION['afficherUser']) && !empty($_SESSION['afficherStatuts'])) {
        $tUsers = $_SESSION['afficherUser'];
        $statuts = $_SESSION['afficherStatuts'];
        $tListeActif = array();
        array_push($tListeActif, "Inactif");
        array_push($tListeActif, "Actif");

        foreach ($tUsers as $value) {
            $inputId = new Input("idv", "Id :", "id", "text", $value['id'], "disabled", 1, null);
            $inputIdh = new Input("id", "", "idh", "hidden", $value['id'], "", 1, null);
            $inputPseudo = new Input("pseudo", "Pseudonyme :", "psuedo", "text", $value['pseudo'], "required", 1, null);
            $inputEmail = new Input("email", "Email :", "email", "text", $value['email'], "required", 1, null);
            $selectStatut = new Select("statut", "Statut :", $statuts, "statut", $tUsers[0]['statut'], 1, "", "select");
            $inputDate_inscription = new Input("date_inscription", "Date d'inscription :", "date_inscription", "date", $value['date_inscription'], "required", 1, null);
            $selectActif = new Select("actif", "Actif :", $tListeActif, "actif", $tUsers[0]['actif'], 1, "", "select");
        }

        $inputSubmit = new Input("modifier", null, "modifier", "submit", "Modifier", "", 5, "inputGreen");
        $inputButton = new Input("btSupprimer", null, "btSupprimer", "button", "Supprimer utilisateur", "", 5, "inputRed");
        $HTMLdivS = new ElementHTML("<div id='modale'>");
        $HTMLp = new ElementHTML("<p>Etes-vous certain de vouloir supprimer cet utilisateur ?</p>");
        $inputSubmitOui = new Input("supprimer", null, "supprimer", "submit", "Oui", "", 5, "inputRed");
        $inputButtonNon = new Input("btSupprimerNon", null, "btSupprimerNon", "button", "Non", "", 5, "inputGreen");
        $HTMLdivE = new ElementHTML("</div>");

        array_push($elements, $inputId);
        array_push($elements, $inputIdh);
        array_push($elements, $inputPseudo);
        array_push($elements, $inputEmail);
        array_push($elements, $selectStatut);
        array_push($elements, $inputDate_inscription);
        array_push($elements, $selectActif);
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