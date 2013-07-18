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
    $formulaire = new Form("mainForm", "POST", "./../Controllers/UserController.php?action=Rechercher", $elements);
    echo $formulaire->genererForm();


    if (!empty($_SESSION['afficherUsers'])) {
        $tUsers = $_SESSION['afficherUsers'];
        $count = $_SESSION['count'];
        ?>
        <table id="tableauAffichage">
            <tr>
                <td></td>
                <td>Pseudonyme</td>
                <td>Email</td>
                <td>Statut</td>
                <td>Date inscription</td>
                <td>Actif/Inactif</td>
            </tr>
            <?PHP
            
                        $pagination = $_SESSION['pagination'];
            echo "Nombre total d'utilsateurs enregistrés : " . $count . "<br>";
            $part = floor($count / $pagination) + 2;
            if ($pagination == 1) {
                $part = $part - 1;
            }


            $i = 1;
            while ($i < $part) {
                $tranche = $i * $pagination;
                if ($i == 1) {
                    $echoA = 0;
                } else {
                    $echoA = ($tranche - $pagination);
                }
                ?>
                <a class="aGreenVille" href="../Controllers/RestoController.php?action=GererRestos&limiteBasse=<?PHP echo $echoA; ?>"><?PHP echo $i; ?></a>
                <?PHP
                $i++;
            }
            
            
            foreach ($tUsers as $value) {
                ?>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td><a class="buttonSubmit"
                           href="./../Controllers/UserController.php?action=ModifierUtilisateur&id=<?PHP echo $value['id']; ?>">Modifier</a>
                    </td>
                    <td><?PHP echo $value['pseudo']; ?></td>
                    <td><?PHP echo $value['email']; ?></td>
                    <td><?PHP echo $value['statut']; ?></td>
                    <td><?PHP echo $value['date_inscription']; ?></td>
                    <td><?PHP echo $value['actif']; ?></td>
                </tr>
                <?PHP
            }
            ?>
        </table>
        <?PHP
    }
    ?>
</div>