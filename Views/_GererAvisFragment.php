<?PHP
// --- Controlle de l'utilisateur avant accès à la page
include_once '../Controllers/NavigationController.php';
NavigationController::Controller($_SESSION['user']);
// --- Fin de controle
?>

<div id="mainFrame">
    <?php
    spl_autoload_register(function ($nomClasse) {
                require_once "../Utils/Form/$nomClasse.php";
            });


    $inputRecherche = new Input("rechercher", null, "rechercher", "text", "", "placeholder='laisser vide pour tout afficher'", 5, "rechercher");
    $elements = array($inputRecherche);
    $formulaire = new Form("mainForm", "POST", "./../Controllers/AvisController.php?action=Rechercher", $elements);
    echo $formulaire->genererForm();


    if (!empty($_SESSION['afficherAvis'])) {
        $tAvis = $_SESSION['afficherAvis'];
        ?>
        <table id="tableauAffichage">
            <?PHP
            foreach ($tAvis as $value) {
                ?>
                <tr><td><br></td></tr>
                <tr>
                    <?PHP
                    if ($value['actif']==1) {
                        ?>
                    <td><a class="aRed" href="./../Controllers/AvisController.php?action=ModifierAvis&id=<?PHP echo $value['id']; ?>&actif=0&id_restaurant=<?PHP echo $value['id_restaurant']; ?>">Désactiver</a></td>
                    <?PHP
                    }else {
                        ?>
                    <td><a class="aGreen" href="./../Controllers/AvisController.php?action=ModifierAvis&id=<?PHP echo $value['id']; ?>&actif=1&id_restaurant=<?PHP echo $value['id_restaurant']; ?>">Activer</a></td>
                    <?PHP    
                    }
                    ?>
                    <td><?PHP echo $value['titre']; ?></td>
                    <td><?PHP echo $value['description']; ?></td>
                    <td>écrit par : <?PHP echo $value['pseudo']; ?></td>
                </tr>
                <?PHP
            }
            ?>
        </table>
        <?PHP
    }
    ?>
</div>
