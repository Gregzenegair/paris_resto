<div id="mainFrame">

    <?php
    include_once '../Controllers/Form/Form.php';
    include_once '../Controllers/Form/Br.php';
    include_once '../Controllers/Form/Input.php';
    include_once '../Controllers/Form/ElementHTML.php';

    $elements = array();

    $br = new Br(0);

    $inputpseudo = new Input("pseudo", "Pseudonyme :", "pseudo", "text", "", "", 1, null);
    $HTMLPseudoMessage = new ElementHTML("<span class='errorMessage' id='pseudoMessage'></span>");

    $inputEmail = new Input("email", "Email :", "email", "text", "", "", 1, null);
    $HTMLEmailMessage = new ElementHTML("<span class='errorMessage' id='emailMessage'></span>");

    $inputMdp = new Input("mdp", "Mot de passe :", "mdp", "password", "", "", 1, null);
    $HTMLMdpMessage = new ElementHTML("<span class='errorMessage' id='mdpMessage'></span>");

    $inputMdp_check = new Input("mdp_check", "Mot de passe :", "mdp_check", "password", "", "", 1, null);
    $HTMLMdp_checkMessage = new ElementHTML("<span class='errorMessage' id='mdp_checkMessage'></span>");

    $inputsubmit = new Input("valider", null, "valider", "submit", "Validez", "onclick='javascript:return formChecker()'", 5, "inputGreen");

    
    array_push($elements, $inputpseudo);
    array_push($elements, $HTMLPseudoMessage);
    array_push($elements, $inputEmail);
    array_push($elements, $HTMLEmailMessage);
    array_push($elements, $inputMdp);
    array_push($elements, $HTMLMdpMessage);
    array_push($elements, $inputMdp_check);
    array_push($elements, $HTMLMdp_checkMessage);
    array_push($elements, $br);
    array_push($elements, $inputsubmit);


    $formulaire = new Form("mainForm", "POST", "./../Controllers/UserController.php?action=Inscription", $elements);

    echo $formulaire->genererForm();
    ?>
   
    
</div>

<script src="js/inscriptionFormCheck.js"></script>