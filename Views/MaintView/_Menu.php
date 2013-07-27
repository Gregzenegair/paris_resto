<div id="menu" >
    <ul>
        <?php
        if (!empty($_SESSION['user']) && $_SESSION['user'] != "inactif") {
            $tUser = $_SESSION['user'];
            if ($tUser['statut'] == "10") {
                ?>
                <li><a href="/Accueil">Accueil</a></li>
                <li><a href="/GererUtilisateurs">Gérer les utilisateurs</a></li>
                <li><a href="/GererRestos">Gérer les restaurants</a></li>
                <li><a href="/GererVilles">Gérer les villes</a></li>
                <li><a href="/GererCategories">Gérer les catégories</a></li>
                <?PHP
            } else if ($tUser['statut'] == "0") {
                ?>
                <li><a href="/Accueil">Accueil</a></li>

                <?PHP
            }
        } else {
            ?>
            <li><a href="/Accueil">Accueil</a></li>
            <li>Proposer un restaurant</li>
            <li><a href="/Inscrire">Inscription</a></li>
            <?PHP
        }
        ?>


    </ul>
</div>
