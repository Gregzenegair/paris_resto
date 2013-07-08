
<div id="mainFrame">



    <?php
    if (!empty($_SESSION['afficherUsers'])) {
        $tUsers = $_SESSION['afficherUsers'];
        ?>
        <table id="membres">
            <?PHP
            foreach ($tUsers as $value) {
                ?>
                <tr><td><br></td></tr>
                <tr>
                    <td><a class="buttonSubmit" href="./../Controllers/UserController.php?action=ModifierUtilisateur&id=<?PHP echo $value['id']; ?>">Modifier</a></td><td><?PHP echo $value['pseudo']; ?></td><td><?PHP echo $value['email']; ?></td><td><?PHP echo $value['statut']; ?></td><td><?PHP echo $value['date_inscription']; ?></td><td><?PHP echo $value['actif']; ?></td>
                </tr>
                
                <?PHP
            }
            ?>
        </table>
        <?PHP
    }
    ?>
</div>