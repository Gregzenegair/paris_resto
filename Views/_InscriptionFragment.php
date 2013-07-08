<div id="mainFrame">

    <?php
    include_once '../Controllers/Form/Form.php';
    include_once '../Controllers/Form/Br.php';
    include_once '../Controllers/Form/Input.php';

    $elements = array();

    $br = new Br(0);

    $input1 = new Input("pseudo", "Pseudonyme :", "psuedo", "text", "", "required", 1, null);
    $input2 = new Input("email", "Email :", "email", "text", "", "required", 1, null);
    $input3 = new Input("mdp", "Mot de passe :", "mdp", "password", "", "required", 1, null);
    $inputsubmit = new Input("valider", null, "valider", "submit", "Validez", "", 5, "inputGreen");

    array_push($elements, $input1);
    array_push($elements, $input2);
    array_push($elements, $input3);
    array_push($elements, $br);
    array_push($elements, $inputsubmit);


    $formulaire = new Form("mainForm", "POST", "./../Controllers/UserController.php?action=Inscription", $elements);

    echo $formulaire->genererForm();
    ?>

</div>