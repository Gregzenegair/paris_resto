<div id="menu" >
    <ul>
        <?php
        if (!empty($_SESSION['user']) && $_SESSION['user'] != "inactif") {
            $tUser = $_SESSION['user'];
            if ($tUser[1] == "10") {
                ?>
                <li><a href="./../Controllers/NavigationController.php?action=Accueil">Accueil</a></li>
                <li>Liste des restaurants</li>
                <li>Partenaires</li>
                <li><a href="./../Controllers/UserController.php?action=GererUtilisateurs">Gérer les utilisateurs</a></li>
                <li><a href="./../Controllers/RestoController.php?action=GererRestos">Gérer les restaurants</a></li>
                <li><a href="./../Controllers/CommentairesController.php?action=GererCommentaires">Gérer les commentaires</a></li>
                <?PHP
            } else if ($tUser[1] == "0") {
                ?>
                <li><a href="./../Controllers/NavigationController.php?action=Accueil">Accueil</a></li>
                <li>Liste des restaurants</li>
                <li>Partenaires</li>

                <?PHP
            }
        } else {
            ?>
            <li><a href="./../Controllers/NavigationController.php?action=Accueil">Accueil</a></li>
            <li>Liste des restaurants</li>
            <li>Partenaires</li>
            <li><a href="./../Controllers/NavigationController.php?action=Inscription">Inscription</a></li>
            <?PHP
        }
        ?>


    </ul>
</div>