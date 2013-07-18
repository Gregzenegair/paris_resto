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
    $formulaire = new Form("mainForm", "POST", "./../Controllers/CategorieController.php?action=Rechercher", $elements);
    echo $formulaire->genererForm();


    if (!empty($_SESSION['afficherCategories'])) {
        $tRestos = $_SESSION['afficherCategories'];
        ?>
        <table id="tableauAffichageCategories">
            <tr>
                <?PHP
                $i = 0;
                foreach ($tRestos as $value) {
                    ?>
                    <td><?PHP echo $value['nom']; ?></td>
                    <td><strong><a class="aRed" href="../Controllers/CategorieController.php?action=SupprimerCategorie&id=<?PHP echo $value['id']; ?>">X</a></strong></td>
                    <?PHP
                    if ($i > 1) {
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