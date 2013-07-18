<?PHP
// --- Controlle de l'utilisateur avant accès à la page
include_once '../Controllers/NavigationController.php';
NavigationController::Controller($_SESSION['user']);
// --- Fin de controle
?>

<div id="mainFrame">
    <a href="./../Controllers/RestoController.php?action=AjouterResto" id="AjouterResto" class="aGreen">Ajouter restaurant</a>


    <?php
    spl_autoload_register(function ($nomClasse) {
                require_once "../Controllers/Form/$nomClasse.php";
            });


    $inputRecherche = new Input("rechercher", null, "rechercher", "text", "", "placeholder='laisser vide pour tout afficher'", 5, "rechercher");
    $elements = array($inputRecherche);
    $formulaire = new Form("mainForm", "POST", "./../Controllers/RestoController.php?action=Rechercher", $elements);
    echo $formulaire->genererForm();


    if (!empty($_SESSION['afficherRestos'])) {
        $tRestos = $_SESSION['afficherRestos'];
        ?>
        <table id="tableauAffichage">
            <?PHP
            foreach ($tRestos as $value) {
                $categories = $value['categories'];
                $categories = str_replace(",", " | ", $categories);
                ?>
                <tr><td><br></td></tr>
                <tr>
                    <td rowspan="2"><a class="buttonSubmit" href="./../Controllers/RestoController.php?action=ModifierResto&id=<?PHP echo $value['id']; ?>">Modifier</a></td>
                    <td><?PHP echo $value['nom']; ?></td>
                    <td><?PHP echo $value['numero_tel']; ?></td>
                    <td><?PHP echo $value['email']; ?></td>
                    <td><strong><?PHP echo $categories; ?></strong></td>
                </tr>
                <tr>
                    
                    <td colspan="2"><?PHP echo $value['numero_voie'] . " " . $value['type_voie'] . " " . $value['nom_voie']; ?></td>
                    <td><?PHP echo $value['nom_ville']; ?></td>
                    <td><?PHP echo $value['cp']; ?></td>

                </tr>

                <?PHP
            }
            ?>
        </table>
        <?PHP
    }
    ?>
</div>