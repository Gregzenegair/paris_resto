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
    $formulaire = new Form("mainForm", "POST", "/RechercherUtilisateur", $elements);
    echo $formulaire->genererForm();


    if (!empty($afficherUsers)) {

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
            
            echo "Nombre total d'utilsateurs enregistrés : " . $usersCount . "<br>";
            $part = floor($usersCount / $pagination) + 2;
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
                <a class="aGreenVille" href="/GererUtilisateurs__Page__<?PHP echo $echoA; ?>"><?PHP echo $i; ?></a>
                <?PHP
                $i++;
            }
            
            
            foreach ($afficherUsers as $value) {
                ?>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td><a class="buttonSubmit"
                           href="/ModifierUtilisateur__<?PHP echo $value['id']; ?>">Modifier</a>
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
