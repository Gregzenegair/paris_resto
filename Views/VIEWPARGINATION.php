<?PHP
// --- Controlle de l'utilisateur avant accès à la page
include_once '../Controllers/NavigationController.php';
NavigationController::Controller($_SESSION['user']);
// --- Fin de controle
?>

<div id="mainFrame">

    <?php
    spl_autoload_register(function ($nomClasse) {
                require_once "../Controllers/Form/$nomClasse.php";
            });


    $inputRecherche = new Input("rechercher", null, "rechercher", "text", "", "placeholder='laisser vide pour tout afficher'", 5, "rechercher");
    $elements = array($inputRecherche);
    $formulaire = new Form("mainForm", "POST", "./../Controllers/VilleController.php?action=Rechercher", $elements);
    echo $formulaire->genererForm();


    if (!empty($_SESSION['afficherVilles'])) {
        $tRestos = $_SESSION['afficherVilles'];
        $count = $_SESSION['count'];
        ?>
    <div class="clear"></div>
        <table id="tableauAffichageVilles">
            <tr>
                <?PHP
                $pagination = 400;
                echo "Nombre total de villes : " . $count . "<br>";
                $part = floor($count / $pagination) + 2;


                $i = 1;
                while ($i < $part) {
                    $tranche = $i * $pagination;
                    if ($i == 1) {
                        $echoA = "|" . 0 . " " . $tranche . " ";
                    } else {
                        $echoA = "&limiteBasse=" . (($tranche - $pagination) + 1);
                    }
                    ?>
                <a class="aGreenVille" href="../Controllers/VilleController.php?action=GererVilles<?PHP echo $echoA; ?>"><?PHP echo $i; ?></a>
                <?PHP
                $i++;
            }


            $i = 0;
            foreach ($tRestos as $value) {
                ?>
                <td><?PHP echo $value['nom']; ?></td>
                <td><?PHP echo $value['cp']; ?></td>
                <td><strong><a class="inputRed" href="../Controllers/VilleController.php?action=SupprimerVille&id=<?PHP echo $value['id']; ?>">X</a></strong></td>
                <?PHP
                if ($i > 0) {
                    ?>
                </tr><tr><td><br></td></tr><tr>
                <?PHP
                $i = -1;
            }
            $i++;
        }
        ?>
    </tr>
    </table>
    <?PHP
}
?>
</div>