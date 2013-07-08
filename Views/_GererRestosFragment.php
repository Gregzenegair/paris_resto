
<div id="mainFrame">



    <?php
    if (!empty($_SESSION['afficherRestos'])) {
        $tUsers = $_SESSION['afficherRestos'];
        ?>
        <table id="membres">
            <?PHP
            foreach ($tUsers as $value) {
                ?>
                <tr><td><br></td></tr>
                <tr>
                    <td><a class="buttonSubmit" href="./../Controllers/RestoController.php?action=ModifierResto&id=<?PHP echo $value['id']; ?>">Modifier</a></td><td><?PHP echo $value['nom']; ?></td><td><?PHP echo $value['categorie']; ?></td><td><?PHP echo $value['numero_tel']; ?></td><td><?PHP echo $value['email']; ?></td><td><?PHP echo $value['note_moy']; ?></td>
                </tr>
                <tr>
                    <td><?PHP echo $value['adresse']; ?></td><td><?PHP echo $value['ville']; ?></td><td><?PHP echo $value['cp']; ?></td>
                </tr>
                
                <?PHP
            }
            ?>
        </table>
        <?PHP
    }
    ?>
</div>