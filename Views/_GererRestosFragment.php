
<div id="mainFrame">
    <a href="./../Controllers/RestoController.php?action=AjouterResto" class="aGreen">Ajouter restaurant</a>


    <?php
    if (!empty($_SESSION['afficherRestos'])) {
        $tRestos = $_SESSION['afficherRestos'];
        ?>
        <table id="membres">
            <?PHP
            foreach ($tRestos as $value) {
                ?>
                <tr><td><br></td></tr>
                <tr>
                    <td><a class="buttonSubmit" href="./../Controllers/RestoController.php?action=ModifierResto&id=<?PHP echo $value['id']; ?>">Modifier</a></td><td><?PHP echo $value['nom']; ?></td><td><?PHP echo $value['numero_tel']; ?></td><td><?PHP echo $value['email']; ?></td>
                </tr>
                <tr>
                    <td style="width: 200px;"></td>
                    <td><?PHP echo $value['nom_voie']; ?></td>
                    <td><?PHP echo $value['id_villes']; ?></td>
                </tr>

                <?PHP
            }
            ?>
        </table>
        <?PHP
    }
    ?>
</div>