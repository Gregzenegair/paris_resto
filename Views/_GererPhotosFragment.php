<?PHP
// --- Controlle de l'utilisateur avant accès à la page
include_once '../Controllers/NavigationController.php';
NavigationController::Controller($_SESSION['user']);
// --- Fin de controle
?>

<div id="mainFrame">
    <a href="/AjouterPhoto__<?PHP echo $_SESSION['idResto']; ?>" id="AjouterPhoto" class="aGreen">Ajouter une photo</a>
    <?php
    spl_autoload_register(function ($nomClasse) {
                require_once "../Utils/Form/$nomClasse.php";
            });


    if (!empty($afficherPhotos)) {
        ?>
        <div class="clear"></div>
        <table id="tableauAffichagePhotos">


            <?PHP
            foreach ($afficherPhotos as $value) {
                ?>
                <tr>
                    <td><strong><a class="aRed" href="/SupprimerPhoto__<?PHP echo $value['id']; ?>">X</a></strong></td>
                    <td><img style="max-width: 800px;" src="/Views/img/restos/<?PHP echo $_SESSION['idResto']; ?>/<?PHP echo $value['nom_fichier']; ?>"></td>
                </tr>                   
                <?PHP
            }
            ?>

        </table>
        <?PHP
    }
    ?>
</div>
