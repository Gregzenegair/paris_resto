<div id="menu" >
    <ul>
        <?php
        if (!empty($_SESSION['user']) && $_SESSION['user'] != "inactif") {
            $tUser = $_SESSION['user'];
            if ($tUser['statut'] == "10") {
                ?>
                <li><a href="./../Controllers/ViewsController.php?action=Accueil">Accueil</a></li>
                <li>Liste des restaurants</li>
                <li>Partenaires</li>
                <li><a href="./../Controllers/UserController.php?action=GererUtilisateurs">Gérer les utilisateurs</a></li>
                <li><a href="./../Controllers/RestoController.php?action=GererRestos">Gérer les restaurants</a></li>
                <li><a href="./../Controllers/PhotoController.php?action=GererPhotos">Gérer les photos</a></li>
                <li><a href="./../Controllers/VilleController.php?action=GererVilles">Gérer les villes</a></li>
                <li><a href="./../Controllers/CategorieController.php?action=GererCategories">Gérer les categories</a></li>
                <li><a href="./../Controllers/CommentaireController.php?action=GererCommentaires">Gérer les commentaires</a></li>
                <?PHP
            } else if ($tUser['statut'] == "0") {
                ?>
                <li><a href="./../Controllers/ViewsController.php?action=Accueil">Accueil</a></li>
                <li>Liste des restaurants</li>
                <li>Partenaires</li>

                <?PHP
            }
        } else {
            ?>
            <li><a href="./../Controllers/ViewsController.php?action=Accueil">Accueil</a></li>
            <li>Liste des restaurants</li>
            <li>Partenaires</li>
            <li><a href="./../Controllers/ViewsController.php?action=Inscription">Inscription</a></li>
            <?PHP
        }
        ?>


    </ul>
</div>