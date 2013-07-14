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

    if (!empty($_SESSION['afficherResto'])) {

        $tListeElemCategories = $_SESSION['afficherCategories'];
        $tListeElemTypesVoie = $_SESSION['afficherTypesVoie'];
        $tListeElemVilles = $_SESSION['afficherVilles'];

        $tRestos = $_SESSION['afficherResto'];
        $tListePhotos = array();
        $tListeNotes = array();


        foreach ($tRestos as $value) {
            $inputId = new Input("idv", "Id :", "id", "text", $value['id'], "disabled", 1, null);
            $inputIdh = new Input("id", "", "idh", "hidden", $value['id'], "", 1, null);

            $inputNom = new Input("nom", "Nom du restaurant :", "nom", "text", $value['nom'], "", 1, null);

            $selectCategories1 = new DataList("categorie1", "Categories :", $tListeElemCategories, "categorie1", null, 1, "", "selectCategorie");
            $selectCategories2 = new DataList("categorie2", "", $tListeElemCategories, "categorie2", null, 1, "", "selectCategorie");
            $selectCategories3 = new DataList("categorie3", "", $tListeElemCategories, "categorie3", null, 1, "", "selectCategorie");

            $inputNumero_tel = new Input("numero_tel", "Numéro de téléphone :", "numero_tel", "text", $value['numero_tel'], "", 1, null);
            $inputEmail = new Input("email", "Email :", "email", "text", $value['email'], null, 1, null);
            $selectTypeVoie = new Select("type_voie", "", $tListeElemTypesVoie, "type_voie", $value['id_types_voie'], 1, "required", "select");
            $inputNumeroVoie = new Input("numero_voie", "Adresse :", "numero_voie", "number", $value['numero_voie'], "required min='0'", 1, null);
            $inputNomVoie = new Input("nom_voie", "", "nom_voie", "text", $value['nom_voie'], "required", 1, null);

            $selectVilles = new DataList("nom_ville", "Ville :", $tListeElemVilles, "nom_ville", $value['nom_ville'], 1, "", "select");
            $inputCp = new Input("cp", "Code postal :", "cp", "text", $value['cp'], "", 1, null);

        }

        $inputSubmit = new Input("modifier", null, "modifier", "submit", "Modifier", "", 5, "inputGreen");
        $inputButton = new Input("btSupprimer", null, "btSupprimer", "button", "Supprimer restaurant", "", 5, "inputRed");
        $HTMLdivS = new ElementHTML("<div id='modale'>");
        $HTMLp = new ElementHTML("<p>Etes-vous certain de vouloir supprimer ce restaurant ?</p>");
        $inputSubmitOui = new Input("supprimer", null, "supprimer", "submit", "Oui", "", 5, "inputRed");
        $inputButtonNon = new Input("btSupprimerNon", null, "btSupprimerNon", "button", "Non", "", 5, "inputGreen");
        $HTMLdivE = new ElementHTML("</div>");




        array_push($elements, $br);
        array_push($elements, $inputId);
        array_push($elements, $inputIdh);
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
        array_push($elements, $inputButton);
        array_push($elements, $HTMLdivS);
        array_push($elements, $HTMLp);
        array_push($elements, $inputSubmitOui);
        array_push($elements, $inputButtonNon);
        array_push($elements, $HTMLdivE);

        $formulaire = new Form("mainForm", "POST", "./../Controllers/RestoController.php?action=Modification", $elements);

        echo $formulaire->genererForm();
    }
    ?>
</div>

<script src="js/btSupprimer.js"></script>