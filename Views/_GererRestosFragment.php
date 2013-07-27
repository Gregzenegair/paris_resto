<?PHP
// --- Controlle de l'utilisateur avant accès à la page
include_once '../Controllers/NavigationController.php';
NavigationController::Controller($_SESSION['user']);
// --- Fin de controle
?>

<div id="mainFrame">
    <a href="/AjouterResto" id="AjouterResto" class="aGreen">Ajouter restaurant</a>


    <?php
    spl_autoload_register(function ($nomClasse) {
                require_once "../Utils/Form/$nomClasse.php";
            });

    if (isset($erreurMsg)) {
        ?>
        <span class="errorMessage"><?PHP echo $erreurMsg; ?></span>
        <?PHP
    }

    $inputRecherche = new Input("rechercher", null, "rechercher", "text", "", "placeholder='laisser vide pour tout afficher'", 5, "rechercher");
    $elements = array($inputRecherche);
    $formulaire = new Form("mainForm", "POST", "/RechercherResto", $elements);
    echo $formulaire->genererForm();


    if (!empty($afficherRestos)) {
        ?>
        <table id="tableauAffichage">
            <?PHP
            echo "Nombre total de restaurants : " . $RestosCount . "<br>";
            $part = floor($RestosCount / $pagination) + 2;
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
                <a class="aGreenVille" href="/GererRestos__Page__<?PHP echo $echoA; ?>"><?PHP echo $i; ?></a>
                <?PHP
                $i++;
            }


            foreach ($afficherRestos as $value) {
                $categories = $value['categories'];
                $categories = str_replace(",", " | ", $categories);
                ?>
                <tr><td><br></td></tr>
                <tr>
                    <td style="text-align: center;"><a class="buttonSubmitSmall" href="/ModifierResto__<?PHP echo $value['id']; ?>">Modifier</a></td>
                    <td><?PHP echo $value['nom']; ?></td>
                    <td><?PHP echo $value['numero_tel']; ?></td>
                    <td><?PHP echo $value['email']; ?></td>
                    <td><strong><?PHP echo $categories; ?></strong></td>
                </tr>
                <tr>
                    <td style="text-align: center;"><a class="buttonSubmitSmall" href="/GererAvis__<?PHP echo $value['id']; ?>">Gérer les avis</a></td>
                    <td colspan="2"><?PHP echo $value['numero_voie'] . " " . $value['type_voie'] . " " . $value['nom_voie']; ?></td>
                    <td><?PHP echo $value['nom_ville']; ?></td>
                    <td><?PHP echo $value['cp']; ?></td>

                </tr>
                <tr>
                    <td style="text-align: center;"><a class="buttonSubmitSmall" href="/GererPhotos__<?PHP echo $value['id']; ?>">Gérer les photos</a></td>

                </tr>

                <?PHP
            }
            ?>
        </table>
        <?PHP
    }
    ?>
</div>
