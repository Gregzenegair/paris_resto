<?php
if (empty($_SESSION['user'])) {
    spl_autoload_register(function ($nomClasse) {
                require_once "../Utils/Form/$nomClasse.php";
            });

    $elements = array();
    //($name, $legend, $id, $type, $value, $options, $position, $class);
    $input2 = new Input("email", null, "emailConnection", "text", "", "placeholder='email'", 1, null);
    $input3 = new Input("mdp", null, "mdpConnection", "password", "", "placeholder='mot de passe'", 1, null);
    $inputsubmit = new Input("valider", null, "valider", "submit", "OK", "", 5, "inputGreen");

    array_push($elements, $input2);
    array_push($elements, $input3);
    array_push($elements, $inputsubmit);


    $formulaire = new Form("mainForm", "POST", "/Connexion", $elements);

    echo $formulaire->genererForm();
} else if ($_SESSION['user'] == "inactif") {
    ?>
    <br><br>
    Votre compte n'a pas encore été activé, merci de bien vouloir vérifier votre adresse email afin de le valider.
    <script type="text/javascript">
        function leave() {
            window.location = "/Deconnexion";
        }
        setTimeout("leave()", 5000);
    </script>
    <br><br>
    <?PHP
} else {
    ?>
    <a href="Deconnexion" class="aGreen">Déconnexion</a>

    <?PHP
}
?>
